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

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = auth()->id();

        $c1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$c1->key_sujeto)->first();

        $estampillas = DB::table('asignacion_estampillas')->where('key_taquilla','=',$c2->id_taquilla)->where('fecha_recibido','=',null)->get();
        $rollos = DB::table('asignacion_tfes')->where('key_taquilla','=',$c2->id_taquilla)->where('fecha_recibido','=',null)->get();
        
        
        return view('timbres_asignados',compact('estampillas','rollos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_estampillas(Request $request)
    {
        $asignacion = $request->post('asignacion'); 
        $tr = '';

        $query = DB::table('detalle_asignacion_estampillas')->where('key_asignacion','=', $asignacion)->get(); 
        foreach ($query as $q1) {
            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=',$q1->key_denominacion)->first();

            $tr .= '<tr>
                        <td><span class="fw-bold text-navy fs-6">'.$consulta->denominacion.' UCD</span></td>
                        <td>'.$q1->desde.'</td>
                        <td>'.$q1->hasta.'</td>
                        <td class="text-muted">'.$q1->cantidad_timbres.' und.</td>
                    </tr>';           
        }

        $table = '<div class="">
                        <table class="table text-center">
                            <tr>
                                <th>U.C.D.</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Cant. Timbres</th>
                            </tr>
                            '.$tr.'
                        </table>
                    </div>';

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-check-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Estampillas | Asignadas</h1>
                        <span class="text-muted fw-bold">Timbre Móvil - </span> 
                        <span class="text-navy fw-bold">Asignación ID '.$asignacion.'</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="mb-2 text-justify"><span class="fw-bold">NOTA</span>: Se debe tomar en cuenta las siguientes recomendaciones <span class="text-danger fw-bold">(Obligatorias)</span>, antes de dar clic en "Aceptar".
                        <ul class="text-justify">
                            <li>La asignación se realizará según la cantidad individual de Estampillas.</li>
                            <li>Se debe verificar que la cantidad y el correlativo de los Timbres coincidan con lo entregado.</li>
                            <li>Se debe firmar la "Constancia de entrega".</li>
                        </ul>
                    </p>

                    <p class="text-center fw-bold text-muted fs-5 mb-2">Correlativo</p>
                    
                    '.$table.'
                    
                    <p class="my-4 text-justify"><span class="fw-bold">IMPORTANTE</span>: Al <span class="fw-bold">ACEPTAR</span> los Timbres Fiscales como recibidos, acepta que ha recibido personalmente la cantidad de timbres especificada, según el correlativo detallado. Y haber firmado la <span class="fw-bold">"Constancia de Entrega"</span>.</p>

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
        $query = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres')->where('key_asignacion','=',$asignacion)->get();
        foreach ($query as $value) {
            $total_estampillas = $total_estampillas + $value->cantidad_timbres;
        }

        $consulta = DB::table('inventario_taquillas')->select('cantidad_estampillas')->where('key_taquilla','=',$c2->id_taquilla)->first();
        $actual_inv = $consulta->cantidad_estampillas;

        $new_cant = $actual_inv + $total_estampillas;

        $update = DB::table('asignacion_estampillas')->where('id_asignacion','=',$asignacion)->update(['condicion' => 19,'fecha_recibido' => $hoy]);
        $update_inv = DB::table('inventario_taquillas')->where('key_taquilla','=',$c2->id_taquilla)->update(['cantidad_estampillas' => $new_cant]);
        $update_condicion = DB::table('detalle_asignacion_estampillas')->where('key_asignacion','=',$asignacion)->update(['condicion' => 4]);

        if ($update && $update_inv && $update_condicion) {
            /////bitacora
            $accion = 'ESTAMPILLAS RECIBIDAS EN LA TAQ'.$c2->id_taquilla.', ID ASIGNACIÓN: '.$asignacion.'.';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 5, 'accion'=> $accion]);
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
       

        $query = DB::table('asignacion_tfes')->where('id_asignacion','=',$asignacion)->first();

        $q2 = DB::table('inventario_tfes')->where('key_asignacion','=',$asignacion)->get();
        foreach ($q2 as $key) {
            $tr = '<tr>
                        <td>#</td>
                        <td>'.$key->desde.'</td>
                        <td>'.$key->hasta.'</td>
                        <td class="text-muted">'.$key->cantidad_timbres.' und.</td>
                    </tr>';
        }
        
        
        

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-check-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Lote de Timbres Fiscales | Asignados</h1>
                        <span class="text-muted fw-bold">Forma 14 - </span>
                        <span class="text-navy fw-bold">Asignación ID '.$asignacion.'</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="mb-2 text-justify"><span class="fw-bold">NOTA</span>: Se debe tomar en cuenta las siguientes recomendaciones<span class="text-danger fw-bold"> (Obligatorias)</span>, antes de dar clic en "Aceptar".
                        <ul>
                            <li>Se debe verificar que la cantidad y el correlativo de los Timbres coincida con lo entregado.</li>
                            <li>Se debe firmar la "Constancia de entrega".</li>
                        </ul>
                    </p>
                    
                    <p class="text-center fw-bold text-muted fs-5  mb-2">Correlativo</p>
                    
                    <div class="">
                        <table class="table text-center">
                            <tr>
                                <th>#</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Cant. Timbres</th>
                            </tr>
                            '.$tr.'
                        </table>
                    </div>

                    <p class="my-4 text-justify"><span class="fw-bold">IMPORTANTE</span>: Al <span class="fw-bold">ACEPTAR</span> los Timbres Fiscales como recibidos, acepta que ha recibido personalmente la cantidad de timbres especificada, según el correlativo detallado. Y haber firmado la <span class="fw-bold">"Constancia de Entrega"</span>.</p>

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
        $query = DB::table('inventario_tfes')->select('cantidad_timbres')->where('key_asignacion','=',$asignacion)->get();
        foreach ($query as $key) {
            $total_timbres = $total_timbres + $key->cantidad_timbres;
        }
        

        $consulta = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=',$c2->id_taquilla)->first();
        $actual_inv = $consulta->cantidad_tfe;

        $new_cant = $actual_inv + $total_timbres;

        $update = DB::table('asignacion_tfes')->where('id_asignacion','=',$asignacion)->update(['condicion' => 19,'fecha_recibido' => $hoy]);
        $update_inv = DB::table('inventario_taquillas')->where('key_taquilla','=',$c2->id_taquilla)->update(['cantidad_tfe' => $new_cant]);
        $update_condicion = DB::table('inventario_tfes')->where('key_asignacion','=',$asignacion)->update(['condicion' => 4]);

        if ($update && $update_inv && $update_condicion) {
            /////bitacora
            $accion = 'TIMBRES FISCALES ELECTRONICOS FORMA 14 RECIBIDOS EN LA TAQ'.$c2->id_taquilla.', ID ASIGNACIÓN: '.$asignacion.'.';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 5, 'accion'=> $accion]);
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
