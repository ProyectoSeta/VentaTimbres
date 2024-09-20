<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class AprobacionProvicionalController extends Controller
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
        $solicitudes = DB::table('solicitud_reservas')
                                            ->join('sujeto_pasivos', 'solicitud_reservas.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('clasificacions', 'solicitud_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                            ->select('solicitud_reservas.*','canteras.nombre','clasificacions.nombre_clf', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                                            ->where('solicitud_reservas.estado', 4)->get();

        return view('aprobacion_provicional',compact('solicitudes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function aprobar(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
       
        $solicitud = DB::table('solicitud_reservas')
        ->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
        ->join('sujeto_pasivos', 'solicitud_reservas.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
        ->select('solicitud_reservas.*','canteras.nombre', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion','sujeto_pasivos.rif_nro')
        ->where('solicitud_reservas.id_solicitud_reserva','=',$idSolicitud)
        ->first();

        if ($solicitud) {
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-help-circle fs-2" style="color:#0072ff"></i>                       
                        <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea Aprobar la siguiente solicitud?</h1>
                        <div class="">
                            <h1 class="modal-title fs-6 text-secondary" id="">Guías Provicionales</h1>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-3"  style="font-size:14px;">
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">Contribuyente:</div>
                        <div class="col-sm-8">'.$solicitud->razon_social.'</div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">R.I.F.:</div>
                        <div class="col-sm-8">'.$solicitud->rif_condicion.'-'.$solicitud->rif_nro.'</div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-sm-4 fw-bold">Cantera:</div>
                        <div class="col-sm-8">'.$solicitud->nombre.'</div>
                    </div>
                    <div class="border my-4"></div>
                    <h6 class="text-center mb-4 text-navy fw-bold">Solicitud de Guías Realizada</h6>
                    <div class="d-flex justify-content-center">
                        <table class="table table-sm w-75 text-center">
                            <thead>
                                <tr>
                                    <th>No. Guías</th>
                                    <th> Total UCD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>'.$solicitud->cantidad_guias.'</td>
                                    <td>'.$solicitud->total_ucd.'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
 
                    <input type="hidden" value="'.$solicitud->id_solicitud_reserva.'" name="id_solicitud">

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-sm me-4 aprobar_correlativo_p" id_solicitud="'.$solicitud->id_solicitud_reserva.'" >Aprobar</button>
                        <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    



                </div>';

                return response($html);
        }
       
       
    }




    public function correlativo(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $query = DB::table('solicitud_reservas')->select('id_sujeto','id_cantera','cantidad_guias')->where('id_solicitud_reserva','=',$idSolicitud)->first(); 
        $cant = $query->cantidad_guias;
        $id_cantera = $query->id_cantera; 
        $id_sujeto = $query->id_sujeto;
        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
        if ($query_count) {
            if ($query_count->total != 0) {
                $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                if ($cant <= $consulta->total) {
                    ///SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                    $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                    if ($c) {
                        $asignado = $c->asignado;
                        $guias_restantes = 50 - $asignado;

                        if ($cant <= $guias_restantes) {
                            /////hay guías suficientes en el talonario para la solicitud
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = ($c->desde + $cant)-1;
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonarios')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = ($desde + $cant) - 1;
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }

                            ///////insert detalle
                            $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                    'id_talonario' => $c->id_talonario,
                                                                    'id_cantera'=>$id_cantera, 
                                                                    'id_sujeto'=>$id_sujeto, 
                                                                    'desde' => $desde, 
                                                                    'hasta' => $hasta,
                                                                    'clase' => 6,
                                                                    'id_solicitud_reserva' => $idSolicitud]);
                            if ($detalle_talonario) {
                                $asignado = $asignado + $cant;
                                $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);

                                $url = route('qr.qrReserva', ['idTalonario' => $c->id_talonario, 'idSujeto' => $id_sujeto, 'idSolicitud' => $idSolicitud]); 
                                
                                QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_T'.$c->id_talonario.'_SR'.$idSolicitud.'.svg'));
                                $update_qr = DB::table('detalle_talonarios')->where('id_talonario','=', $c->id_talonario)->where('id_solicitud_reserva', '=', $idSolicitud)->update(['qr' => 'assets/qr/qrcode_T'.$c->id_talonario.'_SR'.$idSolicitud.'.svg']);
                                if ($update_qr) {

                                    $updates = DB::table('solicitud_reservas')->where('id_solicitud_reserva', '=', $idSolicitud)->update(['estado' => 17]);
                                
                                    $user = auth()->id();
                                    $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                                    $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$idSolicitud.' APROBADA, ID Talonario: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                    $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                    return response()->json(['success' => true]);
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }

                        }else{
                            /////no hay guias suficientes en el talonario para la solicitud
                            $i = 0; //////cuenta las guías asignadas 
                            $talonarios = [];
                            $url_talonarios = '';
                            // $x = 0; //////cuenta las iteraciones del bucle

                            ////////////SE HACE EL PRIMER REGISTRO DE LAS GUIAS PARA DESPUES PASAR AL BUCLE  
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = $c->hasta;

                                $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                        'id_talonario' => $c->id_talonario,
                                                                                        'id_cantera'=>$id_cantera, 
                                                                                        'id_sujeto'=>$id_sujeto, 
                                                                                        'desde' => $desde, 
                                                                                        'hasta' => $hasta,
                                                                                        'clase' => 6,
                                                                                        'id_solicitud_reserva' => $idSolicitud]);
                                if ($detalle_talonario) {
                                    $i = 50;
                                    $asignado = $c->asignado + $i;
                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                }else{
                                    return response()->json(['success' => false]);
                                }
                                
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonarios')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = $c->hasta;

                                    $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                        'id_talonario' => $c->id_talonario,
                                                                                        'id_cantera'=>$id_cantera, 
                                                                                        'id_sujeto'=>$id_sujeto, 
                                                                                        'desde' => $desde, 
                                                                                        'hasta' => $hasta,
                                                                                        'clase' => 6,
                                                                                        'id_solicitud_reserva' => $idSolicitud]);
                                    if ($detalle_talonario) {
                                        $i = ($hasta - $desde) + 1;
                                        $asignado = $c->asignado + $i;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }

                            array_push($talonarios,$c->id_talonario);
                            $url_talonarios = 'T'.$c->id_talonario;


                            do {
                                // $cant -> cantidad de guías solicitadas
                                // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo

                                $guias_faltantes = $cant - $i;
                                $c2 = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                                if ($c2) {
                                    ////// todavia no se han asignado guías del talonario
                                    $desde = $c2->desde;
                                    $hasta = 0;
                                    if ($guias_faltantes <= 50) {
                                        $hasta = ($desde + $guias_faltantes) - 1;
                                    }else{
                                        $hasta = $c2->hasta;
                                    }

                                    $detalle_talonario = DB::table('detalle_talonarios')->insert([
                                                                                    'id_talonario' => $c2->id_talonario,
                                                                                    'id_cantera'=>$id_cantera, 
                                                                                    'id_sujeto'=>$id_sujeto, 
                                                                                    'desde' => $desde, 
                                                                                    'hasta' => $hasta,
                                                                                    'clase' => 6,
                                                                                    'id_solicitud_reserva' => $idSolicitud]);
                                    if ($detalle_talonario) {
                                        $i = $i + (($hasta - $desde) + 1);  
                                        $asignado = $c2->asignado + $i;
                                        array_push($talonarios,$c2->id_talonario);
                                        $url_talonarios .= '-'.$c2->id_talonario;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]); 
                                    }                             
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                                // $x++;
                            } while ($i == $cant);

                            //////GENERAR QR PARA EL(LOS) TALONARIO(S)
                            $url = route('qr.qrReserva', ['idTalonario' => $talonarios ,'idSujeto' => $id_sujeto,'idSolicitud' => $idSolicitud]);
                            QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_'.$url_talonarios.'_SR'.$idSolicitud.'.svg'));
                            
                            foreach ($talonarios as $key => $v) {
                                $update_qr = DB::table('detalle_talonarios')->where('id_talonario', '=', $v)->where('id_solicitud_reserva', '=', $idSolicitud)->update(['qr' => 'assets/qr/qrcode_'.$url_talonarios.'_SR'.$idSolicitud.'.svg']);
                            }

                            $updates = DB::table('solicitud_reservas')->where('id_solicitud_reserva', '=', $idSolicitud)->update(['estado' => 17]);
                                
                            $user = auth()->id();
                            $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                            $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$idSolicitud.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                            return response()->json(['success' => true]);
                            
        

                        }

                    }else{
                        return response()->json(['success' => false]);
                    }
                    
                }else{
                    ///NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Guías de Reserva disponible.']);
                }                
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
            }
        }else{
            return response()->json(['success' => false]);
        }

      
    }



    public function info(Request $request)
    {
        $idSolicitud = $request->post('solicitud'); ///id_solicitud_reserva
        $tables = '';

        //////datos 
        $datos = DB::table('solicitud_reservas')
                    ->join('sujeto_pasivos', 'solicitud_reservas.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
                    ->select('solicitud_reservas.cantidad_guias', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro','canteras.nombre')
                    ->where('solicitud_reservas.id_solicitud_reserva','=',$idSolicitud)->first();
        if ($datos) {
            $razon_social = $datos->razon_social;
            $rif = $datos->rif_condicion.'-'.$datos->rif_nro;
            $cantera = $datos->nombre;
            $nro_guias = $datos->cantidad_guias;
            $i=0;

            $detalles = DB::table('detalle_talonarios')->select('desde','hasta','qr')->where('id_solicitud_reserva','=',$idSolicitud)->get();
            foreach ($detalles as $d) {
                $i = $i + 1;
                $desde = $d->desde;
                $hasta = $d->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                $qr = $d->qr;

                $tables .= ' <span class="ms-3">Talonario Nro. '.$i.'</span>
                            <div class="row d-flex align-items-center">
                                <div class="col-sm-7">
                                    <table class="table mt-2 mb-3">
                                        <tr>
                                            <th>Desde:</th>
                                            <td>'.$formato_desde.'</td>
                                        </tr>
                                        <tr>
                                            <th>Hasta:</th>
                                            <td>'.$formato_hasta.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-5">
                                    <div class="title text-center">
                                        <img width="140px" src="'.asset($qr).'" alt="">
                                    </div>
                                </div>
                            </div>';
            }

            $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                        <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                            <h1 class="modal-title fs-5" id="exampleModalLabel">¡La solicitud a sido Aprobada!</h1>
                            <div class="">
                                <h1 class="modal-title fs-5 text-navy" id="">'.$cantera.'</h1>
                                <h5 class="modal-title text-muted" id="" style="font-size:14px">'.$razon_social.'</h5>
                                <h5 class="modal-title text-muted" id="" style="font-size:14px">'.$rif.'</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" style="font-size:14px">
                        <p class="text-center" style="font-size:14px">El correlativo correspondiente a la solicitud generada es el siguiente:</p>
                            <div class="row px-4 mb-3 text-center">
                                <div class="col-sm-6 text-muted">NO. GUÍAS SOLICITADAS:</div>
                                <div class="col-sm-6 text-success fw-bold">'.$nro_guias.' GUÍAS</div>
                            </div>
                            '.$tables.'
                        <div class="d-flex justify-content-center">
                            <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo_p" data-bs-dismiss="modal">Salir</button>
                        </div>
                    </div>';
            return response($html);



        }
       

        
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
