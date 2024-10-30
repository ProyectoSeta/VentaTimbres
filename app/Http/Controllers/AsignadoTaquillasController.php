<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
class AsignadoTaquillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();

        $c1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$c1->key_sujeto)->first();

        $estampillas = DB::table('asignacion_estampillas')->where('key_taquilla','=',$c2->id_taquilla)->where('fecha_recibido','=',null)->get();
        $rollos = DB::table('asignacion_rollos')->where('key_taquilla','=',$c2->id_taquilla)->where('fecha_recibido','=',null)->get();
        
        
        return view('timbres_asignados',compact('estampillas','rollos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_estampillas(Request $request)
    {
        $asignacion = $request->post('asignacion'); 
        $tables = '';

        $query = DB::table('detalle_asignacion_estampillas')->where('key_asignacion','=', $asignacion)->get(); 
        foreach ($query as $q1) {
            $tr = '';

            $query_2 = DB::table('detalle_estampillas')->where('key_denominacion','=', $q1->key_denominacion)->where('key_asignacion','=', $asignacion)->get(); 
            foreach ($query_2 as $q2) {
                $tr .= '<tr>
                            <td>'.$q2->key_tira.'</td>
                            <td>'.$q2->desde.'</td>
                            <td>'.$q2->hasta.'</td>
                        </tr>';
            }

            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=',$q1->key_denominacion)->first();
            $tables .= '<div class="d-flex justify-content-between my-2">
                            <p class="fw-bold text-navy fs-5 text-cente my-0">'.$consulta->denominacion.' UCD</p>
                            <p class="fw-bold text-muted fs-6 text-cente my-0">Timbres: '.$q1->cantidad.' und.</p>
                        </div>

                        <div class="">
                            <table class="table text-center">
                                <tr>
                                    <th>ID Tira</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-check-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Estampillas | Asignadas</h1>
                        <span class="text-muted fw-bold">Timbre móvil - </span> 
                        <span class="text-navy fw-bold">Asignación ID '.$asignacion.'</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-center fw-bold text-muted fs-5 mb-2">Correlativo</p>
                    <p class="text-muted text-justify"><span class="fw-bold">IMPORTANTE:</span> La Asignación se realizó según la cantidad individual de Estampillas, no por Tiras de Estampillas.</p>
                    
                    '.$tables.'
                    
                    <form id="form_recibido_estampillas" method="post" onsubmit="event.preventDefault(); recibidoEstampillas()">
                        <input type="hidden" name="asignacion" value="'.$asignacion.'"> 
                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm me-2">Aceptar</button>
                        </div>
                    </form>
                </div>';

        return response($html);

    }


    public function recibido_estampillas(Request $request)
    {
        $asignacion = $request->post('asignacion'); 
        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $hoy = $year.''.$mes.''.$dia;

        $user = auth()->id();

        $c1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$c1->key_sujeto)->first();

        $total_estampillas = 0;
        $query = DB::table('detalle_asignacion_estampillas')->select('cantidad')->where('key_asignacion','=',$asignacion)->get();
        foreach ($query as $value) {
            $total_estampillas = $total_estampillas + $value->cantidad;
        }

        $consulta = DB::table('inventario_taquillas')->select('cantidad_estampillas')->where('key_taquilla','=',$c2->id_taquilla)->first();
        $actual_inv = $consulta->cantidad_estampillas;

        $new_cant = $actual_inv + $total_estampillas;

        $update = DB::table('asignacion_estampillas')->where('id_asignacion','=',$asignacion)->update(['fecha_recibido' => $hoy]);
        $update_inv = DB::table('inventario_taquillas')->where('key_taquilla','=',$c2->id_taquilla)->update(['cantidad_estampillas' => $new_cant]);


        if ($update && $update_inv) {
            /////bitacora
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function modal_forma14(Request $request)
    {
        $asignacion = $request->post('asignacion');
        $tr = '';
       

        $query = DB::table('asignacion_rollos')->where('id_asignacion','=',$asignacion)->first();

        $query_2 = DB::table('inventario_rollos')->where('key_asignacion','=',$asignacion)->get();
        foreach ($query_2 as $q2) {
            $tr .= '<tr>
                        <td>'.$q2->id_rollo.'</td>
                        <td>'.$q2->desde.'</td>
                        <td>'.$q2->hasta.'</td>
                    </tr>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-check-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Rollos | Asignados</h1>
                        <span class="text-muted fw-bold">Forma 14 - </span>
                        <span class="text-navy fw-bold">Asignación ID '.$asignacion.'</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    
                    <p class="text-center fw-bold text-muted fs-5  mb-2">Correlativo</p>
                    <p class="text-secondary">*NOTA: Cada rollo emitido trae un total de 160 Trimbres Fiscales.</p>
                    <div class="">
                        <table class="table text-center">
                            <tr>
                                <th>ID Rollo</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            '.$tr.'
                        </table>
                    </div>
                    <form id="form_recibido_forma14" method="post" onsubmit="event.preventDefault(); recibidoForma14()">
                        <input type="hidden" name="asignacion" value="'.$asignacion.'"> 
                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm me-2">Aceptar</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);
    }

    /**
     * Display the specified resource.
     */
    public function recibido_forma14(Request $request)
    {
        $asignacion = $request->post('asignacion'); 

        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $hoy = $year.''.$mes.''.$dia;

        $user = auth()->id();

        $c1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$c1->key_sujeto)->first();

        $total_timbres = 0;
        $query = DB::table('inventario_rollos')->select('desde','hasta')->where('key_asignacion','=',$asignacion)->get();
        foreach ($query as $value) {
            $cantidad = ($value->hasta - $value->desde) + 1;
            $total_timbres = $total_timbres + $cantidad;
        }

        $consulta = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=',$c2->id_taquilla)->first();
        $actual_inv = $consulta->cantidad_tfe;

        $new_cant = $actual_inv + $total_timbres;

        $update = DB::table('asignacion_rollos')->where('id_asignacion','=',$asignacion)->update(['fecha_recibido' => $hoy]);
        $update_inv = DB::table('inventario_taquillas')->where('key_taquilla','=',$c2->id_taquilla)->update(['cantidad_tfe' => $new_cant]);

        if ($update && $update_inv) {
            /////bitacora
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
