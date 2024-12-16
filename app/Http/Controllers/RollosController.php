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
        $total = DB::table('emision_tfes')->selectRaw("count(*) as total")->where('ingreso_inventario','=',null)->first();
        $contador = 0;
        $consulta =  DB::table('emision_tfes')->where('ingreso_inventario','=',null)->get();

        foreach ($consulta as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_emision' => $c->id_emision,
                'fecha_emision' => $c->fecha_emision,
                'cantidad' => $c->cantidad_timbres,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query,$a);
            
        }

        return view('emision_rollos', compact('query'));
    }


    public function modal_emitir()
    {
        $desde = '';
        $hasta = '';

        $consulta = DB::table('emision_tfes')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_tfes')->select('hasta')->orderBy('id_emision', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }

        $c1 =  DB::table('variables')->select('valor')->where('variable','=','cant_por_emision_tfes')->first();
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1; 

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-collection fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión de Timbres Fiscales</h1>
                        <h5 class="text-muted fw-bold">TFE - 14</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-secondary">*NOTA: Si el total de timbres fiscales a emitir 
                        es diferente al esperado o se ha cambiado el numero de timbres a producirse por emisión, 
                        dirigirse al modulo configuraciones para cambiar el numero total de timbres fiscales.
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">'.$cant_timbres_lote.' Timbres Fiscales TFE14</p>
                    </div>
                    

                    <div class="d-flex justify-content-center my-4">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>'.$desde.'</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>'.$hasta.'</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_rollos" method="post" onsubmit="event.preventDefault(); emitirRollos()">
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function modal_enviar(Request $request)
    {
        $emision = $request->post('emision'); 
        $tr = '';
        $query =  DB::table('emision_tfes')->where('id_emision', '=', $emision)->first();        

        $desde = $query->desde;
        $hasta = $query->hasta;

        $length = 6;
        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

        $tr = '<tr>
                    <td>#</td>
                    <td>A-'.$formato_desde.'</td>
                    <td>A-'.$formato_hasta.'</td>
                </tr>';


        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Enviar a Inventario</h1>
                        <span class="text-muted fw-bold">Lote TFE14 | Emitidos </span>
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
        $desde = '';
        $hasta = '';
        $tr = '';

        $consulta = DB::table('emision_tfes')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_tfes')->select('hasta')->orderBy('id_emision', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }
    
        $c1 =  DB::table('variables')->select('valor')->where('variable','=','cant_por_emision_tfes')->first();
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1; 

        $insert_emision = DB::table('emision_tfes')->insert([
                                    'key_user' => $user,
                                    'cantidad_timbres' => $cant_timbres_lote,
                                    'desde' => $desde,
                                    'hasta' => $hasta]);  
  
        if ($insert_emision) {
            $id_emision = DB::table('emision_tfes')->max('id_emision');
            $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
            $letra_papel = $c2->valor;

                
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $tr .= '<tr>
                        <td>#</td>
                        <td>'.$letra_papel.'-'.$formato_desde.'</td>
                        <td>'.$letra_papel.'-'.$formato_hasta.'</td>
                    </tr>';
               
               
            

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-collection fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Emisión Timbres Fiscales</span></h1>
                        </div>
                    </div>
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <p class="text-secondary">*NOTA: El lote en emisión tiene un total de '.$cant_timbres_lote.' Trimbres Fiscales TFE-14.</p>
                    
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
        // $dia = date('d');
        // $mes = date('m');
        // $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('emision_tfes')->where('id_emision', '=', $emision)->first();
        $c = 0;

        $desde = $query->desde;
        $hasta = $query->hasta;

        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

        $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
        $letra_papel = $c2->valor;

        $array = array(
                    'id' => 1,
                    'desde' => $letra_papel.''.$formato_desde,
                    'hasta' => $letra_papel.''.$formato_hasta
                );
        $a = (object) $array;
        array_push($correlativo,$a);

        

        $pdf = PDF::loadView('pdfRollosEmitidos', compact('correlativo'));

        return $pdf->download('Lote_TFE14_ID'.$emision.'.pdf');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function enviar_inventario(Request $request)
    {
        $emision = $request->post('emision'); 

        // $insert_inv = DB::table('inventario_tfes')->insert([
        //             'key_emision' => $emision,
        //             'desde' => $query->desde,
        //             'hasta' => $query->hasta,
        //             'cantidad' => $query->cantidad_timbres,
        //             'vendido' => 0,
        //             'condicion' => 8]); 
       
        // $id_lote = DB::table('inventario_tfes')->max('id_lote');
        $hoy = date('Y-m-d');
        $update = DB::table('emision_tfes')->where('id_emision', '=', $emision)->update(['ingreso_inventario' => $hoy, 'estado' => 1]);
        if ($update) {
            //////BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

    }



    public function detalles(Request $request){
        $emision = $request->post('emision');
        $ingreso_inventario = '';
        
        ///////////////////////////////////////////////////////////////DETALLE EMISIÓN
        $query = DB::table('emision_tfes')->where('id_emision','=', $emision)->first();
        
        if ($query->ingreso_inventario == NULL) {
            $ingreso_inventario = '<span class="text-secondary">Sin ingreso</span>';
        }else{
            $ingreso_inventario = $query->ingreso_inventario;
        }

        $table_one = '<div class="d-flex justify-content-center mt-2">
                        <table class="table w-75 ">
                            <tr>
                                <th>ID</th>
                                <td class="text-secondary" colspan="2">'.$emision.'</td>
                            </tr>
                            <tr>
                                <th>Emitido</th>
                                <td colspan="2">'.$query->fecha_emision.'</td>
                            </tr>
                            <tr>
                                <th>Ingreso a Inventario</th>
                                <td colspan="2">
                                    '.$ingreso_inventario.'
                                </td>
                            </tr>
                            <tr>
                                <th>PDF Correlativo</th>
                                <td colspan="2">
                                    <a href="'.route("rollos.pdf", ["emision" => $emision]).'">Descargar</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Cantidad de Timbres TFE-14</th>
                                <td colspan="2">
                                    '.$query->cantidad_timbres.' Unidad(es)
                                </td>
                            </tr>
                        </table>
                    </div>';

        $table_two = '<div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <tr>
                                <th>#</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>'.$query->desde.'</td>
                                <td>'.$query->hasta.'</td>
                            </tr>
                        </table>
                    </div>';

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-detail fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy titulo" id="" >Detalles de la Emisión</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    '.$table_one.'
                    <p class="fw-bold text-center text-navy fs-6 titulo">Correlativo</p>
                    '.$table_two.'
                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>';
        
        return response($html);
        
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
    public function delete(Request $request)
    {
        $emision = $request->post('emision'); 

        $delete = DB::table('emision_tfes')->where('id_emision', '=', $emision)->delete();
        if ($delete) {
            ///////////INCLUIR BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
