<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class EstadoController extends Controller
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
        $t_enviar = [];
        $t_enviados = [];
        $t_recibidos = [];


        ////////////////////////////////////////////////////////////////////////TALONARIOS POR ENVIAR
        $consulta_enviar = DB::table('talonarios')->where('estado','=',20)->get();
        foreach ($consulta_enviar as $c) {
            if ($c->clase == 6) { 
                /////////////////reserva
                $array = array(
                        'id_talonario' => $c->id_talonario,
                        'id_solicitud' => 'No aplica',
                        'id_cantera' => 'No aplica',
                        'id_sujeto' => 'No aplica',
                        'nombre_cantera' => 'No aplica',
                        'razon_social' => 'No aplica',
                        'rif_condicion' => 'No aplica',
                        'rif_nro' => 'No aplica',
                        'tipo' => $c->tipo_talonario,
                        'desde' => $c->desde,
                        'hasta' => $c->hasta,
                        'clase' => $c->clase
                    );

                $a = (object) $array;
                array_push($t_enviar, $a);
            }else{
                //////////////////regular
                $detalle = DB::table('detalle_talonario_regulares')
                            ->join('sujeto_pasivos', 'detalle_talonario_regulares.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                            ->join('canteras', 'detalle_talonario_regulares.id_cantera', '=', 'canteras.id_cantera')
                            ->select('detalle_talonario_regulares.id_sujeto', 'detalle_talonario_regulares.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                            ->where('detalle_talonario_regulares.id_talonario','=',$c->id_talonario)->first();
                if ($detalle) {
                    $array = array(
                            'id_talonario' => $c->id_talonario,
                            'id_solicitud' => $c->id_solicitud,
                            'id_cantera' => $detalle->id_cantera,
                            'id_sujeto' => $detalle->id_sujeto,
                            'nombre_cantera' => $detalle->nombre,
                            'razon_social' => $detalle->razon_social,
                            'rif_condicion' => $detalle->rif_condicion,
                            'rif_nro' => $detalle->rif_nro,
                            'tipo' => $c->tipo_talonario,
                            'desde' => $c->desde,
                            'hasta' => $c->hasta,
                            'clase' => $c->clase
                        );

                    $a = (object) $array;
                    array_push($t_enviar, $a);
                }
            }
            
        }


        ////////////////////////////////////////////////////////////////////////////TALONARIOS ENVIADOS
        $consulta_enviados = DB::table('talonarios')->where('estado','=',21)->get();
        foreach ($consulta_enviados as $c) {
            if ($c->clase == 6){
                /////////////////reserva
                $array = array(
                        'id_talonario' => $c->id_talonario,
                        'id_solicitud' => 'No aplica',
                        'id_cantera' => 'No aplica',
                        'id_sujeto' => 'No aplica',
                        'nombre_cantera' => 'No aplica',
                        'razon_social' => 'No aplica',
                        'rif_condicion' => 'No aplica',
                        'rif_nro' => 'No aplica',
                        'tipo' => $c->tipo_talonario,
                        'desde' => $c->desde,
                        'hasta' => $c->hasta,
                        'clase' => $c->clase,
                        'fecha_enviado_imprenta' => $c->fecha_enviado_imprenta,
                    );

                $a = (object) $array;
                array_push($t_enviados, $a);
            }else{
                $detalle = DB::table('detalle_talonario_regulares')
                            ->join('sujeto_pasivos', 'detalle_talonario_regulares.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                            ->join('canteras', 'detalle_talonario_regulares.id_cantera', '=', 'canteras.id_cantera')
                            ->select('detalle_talonario_regulares.id_sujeto', 'detalle_talonario_regulares.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                            ->where('detalle_talonario_regulares.id_talonario','=',$c->id_talonario)->first();
                if ($detalle) {
                    $array = array(
                        'id_talonario' => $c->id_talonario,
                        'id_solicitud' => $c->id_solicitud,
                        'id_cantera' => $detalle->id_cantera,
                        'id_sujeto' => $detalle->id_sujeto,
                        'nombre_cantera' => $detalle->nombre,
                        'razon_social' => $detalle->razon_social,
                        'rif_condicion' => $detalle->rif_condicion,
                        'rif_nro' => $detalle->rif_nro,
                        'tipo' => $c->tipo_talonario,
                        'desde' => $c->desde,
                        'hasta' => $c->hasta,
                        'clase' => $c->clase,
                        'fecha_enviado_imprenta' => $c->fecha_enviado_imprenta,
                        );

                    $a = (object) $array;
                    array_push($t_enviados, $a);
                }
            }
        }


        ///////////////////////////////////////////////////////////////////////TALONARIOS RECIBIDOS
        $consulta_recibidos = DB::table('talonarios')->where('estado','=',22)->where('asignacion_talonario','=',26)->get();
        foreach ($consulta_recibidos as $c) {
            if ($c->clase == 6){
                /////////////////reserva
                $array = array(
                        'id_talonario' => $c->id_talonario,
                        'id_solicitud' => 'No aplica',
                        'id_cantera' => 'No aplica',
                        'id_sujeto' => 'No aplica',
                        'nombre_cantera' => 'No aplica',
                        'razon_social' => 'No aplica',
                        'rif_condicion' => 'No aplica',
                        'rif_nro' => 'No aplica',
                        'tipo' => $c->tipo_talonario,
                        'desde' => $c->desde,
                        'hasta' => $c->hasta,
                        'clase' => $c->clase,
                        'fecha_enviado_imprenta' => $c->fecha_enviado_imprenta,
                        'fecha_recibido_imprenta' => $c->fecha_recibido_imprenta,
                    );

                $a = (object) $array;
                array_push($t_recibidos, $a);
            }else{
                $detalle = DB::table('detalle_talonario_regulares')
                            ->join('sujeto_pasivos', 'detalle_talonario_regulares.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                            ->join('canteras', 'detalle_talonario_regulares.id_cantera', '=', 'canteras.id_cantera')
                            ->select('detalle_talonario_regulares.id_sujeto', 'detalle_talonario_regulares.id_cantera','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                            ->where('detalle_talonario_regulares.id_talonario','=',$c->id_talonario)->first();
                if ($detalle) {
                    $array = array(
                        'id_talonario' => $c->id_talonario,
                        'id_solicitud' => $c->id_solicitud,
                        'id_cantera' => $detalle->id_cantera,
                        'id_sujeto' => $detalle->id_sujeto,
                        'nombre_cantera' => $detalle->nombre,
                        'razon_social' => $detalle->razon_social,
                        'rif_condicion' => $detalle->rif_condicion,
                        'rif_nro' => $detalle->rif_nro,
                        'tipo' => $c->tipo_talonario,
                        'desde' => $c->desde,
                        'hasta' => $c->hasta,
                        'clase' => $c->clase,
                        'fecha_enviado_imprenta' => $c->fecha_enviado_imprenta,
                        'fecha_recibido_imprenta' => $c->fecha_recibido_imprenta,
                        );

                    $a = (object) $array;
                    array_push($t_recibidos, $a);
                }
            }
            
        }

            
        $count_proceso = DB::table('solicituds')->selectRaw("count(*) as total")->where('estado','=',17)->first();
        $count_retirar = DB::table('solicituds')->selectRaw("count(*) as total")->where('estado','=',18)->first();

        $count = DB::table('solicituds')->selectRaw("count(*) as total")
                                        ->where('estado','!=','Verificando')
                                        ->where('estado','!=','Negada')
                                        ->where('estado','!=','Retirado')->first();

        if ($count->total == 0) {
            $porcentaje_proceso = 0;
            $porcentaje_retirar = 0;
        }else{
            $porcentaje_proceso = ($count_proceso->total/$count->total)*100;
            $porcentaje_retirar = ($count_retirar->total/$count->total)*100;
        }

       

        return view('estado', compact('t_enviar','t_enviados','t_recibidos','count_proceso','count_retirar','count','porcentaje_proceso','porcentaje_retirar'));
    }



    

    public function solicitud(Request $request)
    {
        $idSolicitud = $request->post('solicitud'); 
        $seccion = $request->post('seccion'); 

        $solicitud = DB::table('solicituds')
                        ->join('detalle_solicituds', 'solicituds.id_solicitud','=', 'detalle_solicituds.id_solicitud')
                        ->select('solicituds.*', 'detalle_solicituds.cantidad')
                        ->where('solicituds.id_solicitud','=',$idSolicitud)
                        ->first();   
                                          
        if ($solicitud) {
            $consulta = DB::table('emision_talonarios')->where('id_solicitud','=',$idSolicitud)->first();
            if ($consulta) {
                $emision = '<td>50 Guías</td>
                            <td>'.$consulta->cantidad.'</td>';
            }else{
                $emision = '<td colspan="2" class="fst-italic">No se emitieron talonarios con la imprenta para esta Solicitud, ya que la asignación se realizó a través de la reserva de Talonarios del Contribuyente.</td>';
            }

            $detalle = '';
            $tr_detalle = '';

            if ($seccion == 'talonarios') {
                $html = '';
            }else{
                $query = DB::table('talonarios')->select('id_talonario', 'desde', 'hasta', 'fecha_enviado_imprenta','fecha_recibido_imprenta','fecha_retiro')
                        ->where('id_solicitud','=',$idSolicitud)
                        ->get(); 

                foreach ($query as $t) {
                    $desde = $t->desde;
                    $hasta = $t->hasta;
                    $length = 6;
                    $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                    $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                    $enviado_imprenta = '';
                    $recibido_imprenta = '';
                    $retiro = '';

                    if ($t->fecha_enviado_imprenta == '') {
                        $enviado_imprenta = '<td class="text-secondary fst-italic">Sin enviar</td>';
                    }else{
                        $enviado_imprenta = '<td class="text-secondary">'.$t->fecha_enviado_imprenta.'</td>';
                    }

                    if ($t->fecha_recibido_imprenta == '') {
                        $recibido_imprenta = '<td class="text-secondary fst-italic">Sin recibir</td>';
                    }else{
                        $recibido_imprenta = '<td class="text-secondary">'.$t->fecha_recibido_imprenta.'</td>';
                    }

                    if ($t->fecha_retiro == '') {
                        $retiro = '<td class="text-secondary fst-italic">Sin entregar</td>';
                    }else{
                        $retiro = '<td class="text-muted fw-bold">'.$t->fecha_retiro.'</td>';
                    }

                    $tr_detalle .= '<tr>
                                        <td class="text-muted">'.$t->id_talonario.'</td>
                                        <td class="text-navy fst-italic">'.$formato_desde.' - '.$formato_hasta.'</td>
                                        '.$enviado_imprenta.'
                                        '.$recibido_imprenta.'
                                        '.$retiro.'
                                    </tr>';
                }

                $detalle = '<p class="text-navy text-center mt-2 mb-2 fw-bold">TALONARIO(S)</p>
                            <div class="d-flex justify-content-center">
                                <table class="table mx-3 text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Correlativo</th>
                                            <th>Enviado</th>
                                            <th>Recibido</th>
                                            <th>Entregado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        '.$tr_detalle.'
                                    </tbody>
                                </table>
                            </div>';
            }


            $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-layer fs-1 text-secondary"  ></i>                    
                                <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel">Detalles de la Solicitud</h1>
                            </div>
                    </div>
                    <div class="modal-body" style="font-size:13px;">
                        <div class="row mx-3">
                            <div class="col-sm-6">
                                <span class="fw-bold">Nro. Solicitud: </span>
                                <span class="text-muted">'.$solicitud->id_solicitud.'</span>
                            </div>
                            <div class="col-sm-6 text-end">
                                <span class="fw-bold">Fecha:  </span>
                                <span class="text-muted">'.$solicitud->fecha.'</span>
                            </div>
                        </div>

                        <p class="text-navy text-center mt-2 mb-2 fw-bold">SOLICITUD</p>

                        <div class="d-flex justify-content-center">
                            <table class="table w-75 text-center">
                                <tr>
                                    <th>Tipo Talonario</th>
                                    <th>Cantidad</th>
                                </tr>
                                <tr class="table-warning">
                                    <td>50 Guías</td>
                                    <td>'.$solicitud->cantidad.'</td>
                                </tr>
                            </table>
                        </div>

                        <p class="text-navy text-center mt-2 mb-0 fw-bold">Talonarios Emitidos</p>
                        <p class="text-muted text-center mb-2">A través de la Solicitud</p>

                        <div class="d-flex justify-content-center">
                            <table class="table w-75 text-center">
                                <tr>
                                    <th>Tipo Talonario</th>
                                    <th>Cantidad</th>
                                </tr>
                                <tr class="table-warning">
                                    '.$emision.'
                                </tr>
                            </table>
                        </div>

                        '.$detalle.'

                        <div class="text-end fs-6 mx-4 mb-3">
                            <span class="fw-bold">TOTAL UCD </span>
                            <span class="text-muted">'.$solicitud->total_ucd.' UCD</span>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                            <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                        
                    </div>';
            return response($html);
       }
    }


    public function info_denegada(Request $request){
        $idSolicitud = $request->post('solicitud');
        $query = DB::table('solicituds')->select('observaciones')->where('id_solicitud','=',$idSolicitud)->get();

        if ($query) {
            $html='';
            foreach ($query as $c) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>
                                <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted text-center">OBSERVACIONES DE LA DENEGACIÓN</p>
                            <p class="mx-3 mt-1">'.$c->observaciones.'</p>

                            <div class="mt-3 mb-2">
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span>Las <span class="fw-bold">Observaciones </span>
                                    realizadas cumplen con el objetivo de notificarle
                                    del porque la Cantera no fue verificada. Para que así, pueda rectificar y cumplir con el deber formal.
                                </p>
                            </div>
                        </div>';

            }

            return response($html);
        }


    }


    // public function update(Request $request)
    // {
    //     $idSolicitud = $request->post('id_solicitud');
    //     $estado = $request->post('estado_actual');
    //     $update_solicitud = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => $estado]);
    //     $fecha = date('Y-m-d');

    //     if ($update_solicitud) {
    //         switch ($estado) {
    //             case 'En proceso':
    //                 $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_recibido' => NULL, 'fecha_retiro' => NULL]);
    //                 break;
    //             case 'Retirar':
    //                 $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_recibido' => $fecha]);
    //                 break;
    //             case 'Retirado':
    //                 $update_talonario = DB::table('talonarios')->where('id_solicitud', '=', $idSolicitud)->update(['fecha_retiro' => $fecha]);
    //                 break;
                
    //             default:
    //                 # code...
    //                 break;
    //         }
    //         if ($update_talonario) {
    //             $user = auth()->id();
    //             $accion = 'ESTADO DE LA SOLICITUD NRO.'.$idSolicitud.' ACTUALIZADO A: '.$estado;
    //             $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 8, 'accion'=> $accion]);

    //             return response()->json(['success' => true]);
    //         }else{
    //             return response()->json(['success' => false]);
    //         }
           
    //     }else{
    //         return response()->json(['success' => false]);
    //     }
    // }







    /////////////////////////////////// ENVIADOS A IMPRENTA //////////////////////////////////////
    public function modal_enviados(Request $request){
        $talonarios = $request->post('talonarios'); 
        $tr = '';
        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $query = DB::table('talonarios')->select('desde','hasta')->where('id_talonario','=',$talonario)->first();
                $desde = $query->desde;
                $hasta = $query->hasta;
                // return response($query->desde);
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                $tr .= '<tr>
                            <td>'.$talonario.'</td>
                            <td>'.$formato_desde.' - '.$formato_hasta.'</td>
                        </tr>';
            }
           
           
            
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <!-- <i class="bx bx-user-circle fs-1 text-secondary" ></i> -->
                        <i class="bx bxl-telegram fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold">Talonarios Enviados a Imprenta</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <thead>
                                <th>Talonario</th>
                                <th>Correlativo</th>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" id="btn_aceptar_enviados">Aceptar</button>
                    </div>
                </div>';
        return response($html);

    }

    public function enviados(Request $request){
        $talonarios = $request->post('talonarios');
        $ids_talonarios = '';
        $hoy = date('Y-m-d');
        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $update = DB::table('talonarios')->where('id_talonario', '=', $talonario)->update(['estado' => 21, 'fecha_enviado_imprenta' => $hoy]);
                if ($update) {
                    $ids_talonarios .= $talonario.'-';
                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                
            }
           
        } 
        $user = auth()->id();
        $accion = 'ACTUALIZACION DE ESTADO (ENVIADOS), ID TALONARIOS: '.$ids_talonarios;
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 8, 'accion'=> $accion]);

        if ($bitacora) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    /////////////////////////////////// RECIBIDOS DE LA IMPRENTA //////////////////////////////////////
    public function modal_recibidos(Request $request){
        $talonarios = $request->post('talonarios'); 
        $tr = '';
        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $query = DB::table('talonarios')->select('desde','hasta')->where('id_talonario','=',$talonario)->first();
                $desde = $query->desde;
                $hasta = $query->hasta;
                // return response($query->desde);
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                $tr .= '<tr>
                            <td>'.$talonario.'</td>
                            <td>'.$formato_desde.' - '.$formato_hasta.'</td>
                        </tr>';
            }
           
           
            
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-collection fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold">Talonarios Recibidos de la Imprenta</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <thead>
                                <th>Talonario</th>
                                <th>Correlativo</th>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" id="btn_aceptar_recibidos">Aceptar</button>
                    </div>
                </div>';
        return response($html);

    }

    public function recibidos(Request $request){
        $talonarios = $request->post('talonarios');
        $ids_talonarios = '';
        $hoy = date('Y-m-d');
        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $update = DB::table('talonarios')->where('id_talonario', '=', $talonario)->update(['estado' => 22, 'fecha_recibido_imprenta' => $hoy]);
                if ($update) {
                    $ids_talonarios .= $talonario.'-';

                    $solicitud = DB::table('talonarios')->select('id_solicitud')->where('id_talonario','=',$talonario)->first();
                    $id_solicitud = $solicitud->id_solicitud;

                    $consulta_solicitud = DB::table('detalle_solicituds')->select('cantidad')->where('id_solicitud','=',$id_solicitud)->first();
                    $cantidad_solicitada = $consulta_solicitud->cantidad;

                    $consulta_talonarios = DB::table('talonarios')->selectRaw("count(*) as total")->where('estado','=',22)->where('id_solicitud','=',$id_solicitud)->first();
                    $talonarios_recibidos = $consulta_talonarios->total;

                    if ($talonarios_recibidos >= $cantidad_solicitada) {
                        $update_solicitud = DB::table('solicituds')->where('id_solicitud', '=', $id_solicitud)->update(['estado' => 18]);
                    }
                }else{
                    return response()->json(['success' => false]);
                }
            }else{

            }
           
        } 


        $user = auth()->id();
        $accion = 'ACTUALIZACION DE ESTADO (RECIBIDOS), ID TALONARIOS: '.$ids_talonarios;
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 8, 'accion'=> $accion]);

        if ($bitacora) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    /////////////////////////////////// ENTREGADOS AL CONTRIBUYENTE //////////////////////////////////////
    public function modal_entregados(Request $request){
        $talonarios = $request->post('talonarios'); 
        $tr = '';
        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $query = DB::table('talonarios')->select('desde','hasta')->where('id_talonario','=',$talonario)->first();
                $desde = $query->desde;
                $hasta = $query->hasta;
                // return response($query->desde);
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                $tr .= '<tr>
                            <td>'.$talonario.'</td>
                            <td>'.$formato_desde.' - '.$formato_hasta.'</td>
                        </tr>';
            }
           
           
            
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-package fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold">Talonario(s) Entregados</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <thead>
                                <th>Talonario</th>
                                <th>Correlativo</th>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" id="btn_aceptar_entregados">Aceptar</button>
                    </div>
                </div>';
        return response($html);

    }

    public function entregados(Request $request){
        $talonarios = $request->post('talonarios');
        $ids_talonarios = '';
        $hoy = date('Y-m-d');

        $idSolicitud = '';

        foreach ($talonarios as $talonario) {
            if ($talonario != '') {
                $consulta = DB::table('talonarios')->select('id_solicitud')->where('id_talonario', '=', $talonario)->first();
                $idSolicitud = $consulta->id_solicitud;
                // echo($talonario);
                $update = DB::table('talonarios')->where('id_talonario', '=', $talonario)->update(['estado' => 23, 'fecha_retiro' => $hoy]);
                if ($update) {
                    $ids_talonarios .= $talonario.'-';

                }else{
                    return response()->json(['success' => false]);
                }
            }else{

            }
        } 


        $consulta_solicitud = DB::table('detalle_solicituds')->select('cantidad')->where('id_solicitud','=',$idSolicitud)->first();
        $cantidad_solicitada = $consulta_solicitud->cantidad;

        $consulta_talonarios = DB::table('talonarios')->selectRaw("count(*) as total")->where('estado','=',23)->where('id_solicitud','=',$idSolicitud)->first();
        $talonarios_entregados = $consulta_talonarios->total;

        if ($talonarios_entregados >= $cantidad_solicitada) {
            $update_solicitud = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->update(['estado' => 19]);
        }

        $user = auth()->id();
        $accion = 'ACTUALIZACION DE ESTADO (ENTREGADO), ID TALONARIOS: '.$ids_talonarios;
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 8, 'accion'=> $accion]);

        if ($bitacora) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
