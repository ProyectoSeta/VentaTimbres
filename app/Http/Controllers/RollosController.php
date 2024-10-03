<?php

namespace App\Http\Controllers;
use DB;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RollosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $query = [];
        $total = DB::table('emision_rollos')->selectRaw("count(*) as total")->where('ingreso_inventario','=',null)->first();
        $contador = 0;
        $consulta =  DB::table('emision_rollos')->where('ingreso_inventario','=',null)->get();

        foreach ($consulta as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_emision' => $c->id_emision,
                'fecha_emision' => $c->fecha_emision,
                'cantidad' => $c->cantidad,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query,$a);
            
        }

        return view('emision_rollos', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_enviar(Request $request)
    {
        $emision = $request->post('emision'); 
        $tr = '';
        $query =  DB::table('detalle_emision_rollos')->where('key_emision', '=', $emision)->get();
        $i = 0;
        foreach ($query as $detalle) {
            $i++;
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;

            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $tr .= '<tr>
                        <td>'.$i.'</td>
                        <td>A-'.$formato_desde.'</td>
                        <td>A-'.$formato_hasta.'</td>
                    </tr>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Enviar a Inventario</h1>
                        <span class="text-muted fw-bold">Rollos | Forma 14 </span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_enviar_inventario" method="post" onsubmit="event.preventDefault(); enviarRollosInventario()">
                        <table class="table text-center">
                            <tr>
                                <th>#</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            '.$tr.'
                        </table>

                        <input type="hidden" name="emision" value="'.$emision.'">

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_enviar_inventario">Aceptar</button>
                        </div>
                    </form>
                </div>';

        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function emitir(Request $request)
    {
        $user = auth()->id();
        $cantidad = $request->post('cantidad'); 
        $desde = '';
        $hasta = '';
        $tr = '';

        $consulta = DB::table('emision_rollos')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido rollos
            $query =  DB::table('emision_rollos')->select('id_emision')->orderBy('id_emision', 'desc')->first();

            $consulta_2 =  DB::table('detalle_emision_rollos')->select('hasta')->where('key_emision','=',$query->id_emision)->orderBy('correlativo', 'desc')->first();

            $desde = $consulta_2->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }
    
        $insert_emision = DB::table('emision_rollos')->insert(['key_user' => $user,'cantidad' => $cantidad]);   
        if ($insert_emision) {
            $id_emision = DB::table('emision_rollos')->max('id_emision');
            
            
            for($i=1; $i <= $cantidad; $i++) { 
                $hasta = ($desde + 160) - 1; 
                
                
                $insert_detalle = DB::table('detalle_emision_rollos')->insert([
                            'key_emision' => $id_emision,
                            'desde' => $desde,
                            'hasta' => $hasta]);     

                if ($insert_detalle) {
                    $length = 6;
                    $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                    $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                    $tr .= '<tr>
                                <td>'.$i.'</td>
                                <td>A-'.$formato_desde.'</td>
                                <td>A-'.$formato_hasta.'</td>
                            </tr>';
                }else{
                    return response()->json(['success' => false]);
                }
    
                $desde = $hasta + 1;
            }

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-collection fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Rollos emitidos</span></h1>
                        </div>
                    </div>
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <p class="text-secondary">*NOTA: Cada rollo emitido trae un total de 160 Trimbres Fiscales.</p>
                    
                        <div class="">
                            <table class="table text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mb-3">
                            <a href="'.route("emision_rollos").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                            <a href="'.route("rollos.pdf", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                        </div>
                    </div>';
            return response()->json(['success' => true, 'html' => $html]);
        }else{
            return response()->json(['success' => false]);
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function pdf(Request $request)
    {
        $emision = $request->emision;
        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('detalle_emision_rollos')->where('key_emision', '=', $emision)->get();
        $c = 0;
        foreach ($query as $detalle) {
            $c++;
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;

            
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $array = array(
                        'id' => $c,
                        'desde' => $formato_desde,
                        'hasta' => $formato_hasta
                    );
            $a = (object) $array;
            array_push($correlativo,$a);

        }

        $pdf = PDF::loadView('pdfRollosEmitidos', compact('correlativo'));

        return $pdf->download('Rollos_'.$year.''.$mes.''.$dia.'.pdf');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function enviar_inventario(Request $request)
    {
        $emision = $request->post('emision'); 
        $query =  DB::table('detalle_emision_rollos')->where('key_emision', '=', $emision)->get();

        foreach ($query as $detalle) {
            $insert_inv = DB::table('inventario_rollos')->insert([
                        'key_emision' => $emision,
                        'desde' => $detalle->desde,
                        'hasta' => $detalle->hasta,
                        'estado' => 1,]); 
            if ($insert_inv) {
                # code...
            }else{
                return response()->json(['success' => false]);
            }
        }
        $hoy = date('Y-m-d');
        $update = DB::table('emision_rollos')->where('id_emision', '=', $emision)->update(['ingreso_inventario' => $hoy]);

        ///////BITACORA

        return response()->json(['success' => true]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
