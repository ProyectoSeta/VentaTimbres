<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class AsignarQrController extends Controller
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
        $asignaciones = [];
        $consulta = DB::table('asignacion_reservas')
                                    ->join('clasificacions', 'asignacion_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                    ->select('asignacion_reservas.*','clasificacions.nombre_clf')
                                    ->where('asignacion_reservas.estado','=',17)
                                    ->get();

        foreach($consulta as $c) {
            $tipo_sujeto = $c->contribuyente;
            $rif_nro = '';
            $rif_condicion = '';
            $id_sujeto = '';

            if ($tipo_sujeto == 27) { ///registrado
                $sujeto = DB::table('sujeto_pasivos')->select('id_sujeto','rif_nro','rif_condicion')->where('id_sujeto','=',$c->id_sujeto)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
                $id_sujeto = $sujeto->id_sujeto;
            }else{  //////no registrado
                $sujeto = DB::table('sujeto_notusers')->select('id_sujeto_notuser','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$c->id_sujeto_notuser)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
                $id_sujeto = $sujeto->id_sujeto_notuser;
            }

            $array = array(
                'id_asignacion' => $c->id_asignacion,
                'contribuyente' => $c->contribuyente,
                'id_sujeto' => $id_sujeto,
                'rif_nro' => $rif_nro,
                'rif_condicion' => $rif_condicion,
                'cantidad_guias' => $c->cantidad_guias,
                'fecha_emision' => $c->fecha_emision,
                'soporte' => $c->soporte,
                'estado' => $c->estado
            );

            $a = (object) $array;
            array_push($asignaciones, $a);
        }

        return view('asignar_qr', compact('asignaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function qr_listo(Request $request)
    {
        $asignacion = $request->post('asignacion');
        $query = DB::table('detalle_talonarios')->select('desde','hasta')->where('id_solicitud_reserva','=',$asignacion)->first();
        if ($query) {
            $desde = $query->desde;
            $hasta = $query->hasta;
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $html = '<div class="modal-body text-center ">
                        <p class="fw-bold text-navy d-flex flex-column px-3">
                            <i class="bx bx-help-circle fs-1 text-secondary"></i>
                            ¿Las siguientes Guía(s) ya contienen su respectivo Código QR?
                        </p>
                        <div class="d-flex flex-column">
                            <span class="">Correlativo:</span>
                            <span class="text-muted">'.$formato_desde.' - '.$formato_hasta.'</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btn_qr_listo" id_asignacion="'.$asignacion.'">Si, listo.</button>
                    </div>';
            return response($html);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function guias_asignadas(Request $request)
    {
        $id_asignacion = $request->asignacion;
        $razon = '';
        $rif = '';
        $guias = [];

        $consulta = DB::table('asignacion_reservas')->select('contribuyente','id_sujeto','id_sujeto_notuser','fecha_emision')->where('id_asignacion','=',$id_asignacion)->first();
        $emision = $consulta->fecha_emision;
        if ($consulta->contribuyente == 27) {
            ////registrado
            $c = DB::table('sujeto_pasivos')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto','=',$consulta->id_sujeto)->first();
            $razon = $c->razon_social;
            $rif = $c->rif_nro.'-'.$c->rif_condicion;
        }else{
            ////no registrado
            $c = DB::table('sujeto_notusers')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$consulta->id_sujeto_notuser)->first();
            $razon = $c->razon_social;
            $rif = $c->rif_nro.'-'.$c->rif_condicion;
        }

        $c2 = DB::table('asignacion_reservas')->select('contribuyente','id_sujeto','id_sujeto_notuser','fecha_emision')->where('id_asignacion','=',$id_asignacion)->first();
        $emision = $consulta->fecha_emision;

        $c3 = DB::table('detalle_talonario_reservas')->select('desde','hasta')->where('id_asignacion_reserva','=',$id_asignacion)->first();
        $desde = $c3->desde;
        $hasta = $c3->hasta;

        for ($i=$desde; $i <= $hasta; $i++) { 
            $c4 = DB::table('detalle_asignacions')->select('nro_guia')->where('id_asignacion','=',$id_asignacion)->where('nro_guia','=',$i)->first();
            $array = array(
                'nro_guia' => $c4->nro_guia
            );

            $a = (object) $array;
            array_push($guias, $a);
        }
        return view('guias_asignadas', compact('razon','rif','emision','guias','id_asignacion'));
    }

    /**
     * Display the specified resource.
     */
    public function guia(Request $request)
    {
        $nroGuia = $request->post('guia');
        $id_asignacion = $request->post('asignacion');
        $html = '';

        $id_sujeto = '';
        $razon = '';
        $rif = '';

        $id_cantera = '';
        $nombre_cantera = '';
        $lugar_cantera = '';
        $municipio_cantera = '';
        $parroquia_cantera = '';
        
        $g = DB::table('detalle_asignacions')->where('nro_guia','=',$nroGuia)->where('id_asignacion','=',$id_asignacion)->first();
        $consulta = DB::table('asignacion_reservas')->select('contribuyente','id_sujeto','id_sujeto_notuser')->where('id_asignacion','=',$id_asignacion)->first();

        if ($g && $consulta) {
            if ($consulta->contribuyente == 27) {
                ////registrado
                ////sujeto
                $id_sujeto = $consulta->id_sujeto;
                $c = DB::table('sujeto_pasivos')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto','=',$id_sujeto)->first();
                $razon = $c->razon_social;
                $rif = $c->rif_nro.'-'.$c->rif_condicion;

                ////cantera
                $id_cantera = $g->id_cantera;
                $c2 = DB::table('canteras')->select('nombre','municipio_cantera','parroquia_cantera','lugar_aprovechamiento')->where('id_cantera','=',$id_cantera)->first();
                $nombre_cantera = $c2->nombre;
                $lugar_cantera = $c2->lugar_aprovechamiento;
                $municipio_cantera = $c2->municipio_cantera;
                $parroquia_cantera = $c2->parroquia_cantera;

            }else{
                ////no registrado
                ////sujeto
                $id_sujeto = $consulta->id_sujeto_notuser;
                $c = DB::table('sujeto_notusers')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$id_sujeto)->first();
                $razon = $c->razon_social;
                $rif = $c->rif_nro.'-'.$c->rif_condicion;

                ///cantera
                $id_cantera = $g->id_cantera_notuser;
                $c2 = DB::table('canteras_notusers')->select('nombre','municipio_cantera','parroquia_cantera','lugar_aprovechamiento')->where('id_cantera_notuser','=',$id_cantera)->first();
                $nombre_cantera = $c2->nombre;
                $lugar_cantera = $c2->lugar_aprovechamiento;
                $municipio_cantera = $c2->municipio_cantera;
                $parroquia_cantera = $c2->parroquia_cantera;
            }


            
            $motivo = '';
            if ($g->anulada == 'Si') {
            $motivo = $g->motivo;
            }else{
                $motivo = '<span class="fst-italic text-secondary">No Aplica</span>';
            }

            
            $length = 6;
            $formato_nro_guia = substr(str_repeat(0, $length).$g->nro_guia, - $length);

            $html = '   <div class="row d-flex justify-content-end">
                            <div class="col-4 text-end fs-5 fw-bold text-muted">
                                <span class="text-danger">Nro° Guía </span><span id="nro_guia_view">'.$formato_nro_guia.'</span>
                            </div>
                        </div>

                        <div class="table-responsive">                    
                            <!-- FECHA Y HORA -->
                            <table class="table" style="width: 40%;">
                                <tr>
                                    <th>Fecha:</th>
                                    <td></td>
                                    <th>Hora de Salida:</th>
                                    <td>'.$g->hora_salida.'</td>
                                </tr>
                            </table>
                            <!-- DATOS DE LA EMPRESA Y CANTERA -->
                            <table class="table">
                                <tr>
                                    <th>Razon Social:</th>
                                    <td>'.$razon.'</td>
                                    <th>R.I.F.:</th>
                                    <td>'.$rif.'</td>
                                </tr>
                                <tr>
                                    <th>Nombre de la Cantera:</th>
                                    <td>'.$nombre_cantera.'</td>
                                    <th>Municipio y Parroquia:</th>
                                    <td>Municipio '.$municipio_cantera.', Parroquia '.$parroquia_cantera.'</td>
                                </tr>
                                <tr>
                                    <th>Lugar de Aprovechamiento:</th>
                                    <td colspan="3">'.$lugar_cantera.'</td>
                                </tr>
                            </table>
                            <!-- DATOS DEL DESTINATARIO -->
                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>
                            <table class="table">
                                <tr>
                                    <th>Razon Social del Destinatario:</th>
                                    <td>'.$g->razon_destinatario.'</td>
                                    <th>R.I.F. del Destinatario:</th>
                                    <td>'.$g->rif_destinatario.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono del Destinatario:</th>
                                    <td>'.$g->tlf_destinatario.'</td>
                                    <th>Municipio y Parroquia:</th>
                                    <td>Municipio '.$g->municipio_destino.', Parroquia '.$g->parroquia_destino.'</td>
                                </tr>
                                <tr>
                                    <th>Dirección de Destino:</th>
                                    <td colspan="3">'.$g->destino.'</td>
                                </tr>
                            </table>
                            <!-- DATOS DE LA CARGA -->
                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>
                            <table class="table">
                                <tr>
                                    <th>Mineral:</th>
                                    <td colspan="2">'.$g->mineral.'</td>
                                    <th>Cantidad Total:</th>
                                    <td colspan="2">'.$g->cantidad.' '.$g->unidad_medida.'</td>
                                </tr>
                                <tr>
                                    <th>Saldo Anterior:</th>
                                    <td>'.$g->saldo_anterior.' '.$g->unidad_medida.'</td>
                                    <th>Cantidad Despachada:</th>
                                    <td>'.$g->cantidad_despachada.' '.$g->unidad_medida.'</td>
                                    <th>Saldo Restante:</th>
                                    <td>'.$g->saldo_restante.' '.$g->unidad_medida.'</td>
                                </tr>
                            </table>
                            <!-- DATOS DEL VEHICULO Y CONDUCTOR -->
                            <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Vehículo y Conductor</p>
                            <table class="table ">
                                <tr>   
                                    <th>Nombre del Conductor:</th>
                                    <td>'.$g->nombre_conductor.'</td>
                                    <th>C.I. del Conductor:</th>
                                    <td>'.$g->ci_conductor.'</td>
                                    <th>Teléfono del Conductor:</th>
                                    <td>'.$g->tlf_conductor.'</td>
                                </tr>
                                <tr>
                                    <th>Modelo del Vehículo:</th>
                                    <td>'.$g->modelo_vehiculo.'</td>
                                    <th>Placa Nro.:</th>
                                    <td>'.$g->placa.'</td>
                                    <th>Capacidad del Vehículo:</th>
                                    <td>'.$g->capacidad_vehiculo.'</td>
                                </tr>
                            </table>
                            <!-- DATOS: anulada?-->
                            <table class="table d-flex justify-content-end">
                                <tr>
                                    <th>¿ANULADA?:</th>
                                    <td>'.$g->anulada.'</td>
                                    <th>Motivo:</th>
                                    <td>'.$motivo.'</td>
                                </tr>
                            </table>
                        </div>
                    

                        <div class="d-flex justify-content-center mt-3 mb-3" >
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Salir</button>
                        </div>';

            return response($html); 
        }else{
            return response('ERROR AL TRAER LOS DATOS DE LA GUÍA.');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function print_qr(Request $request)
    {
        $sectionStyle = array(
            'orientation' => 'portrait',
            'pageSizeH' => 1814,
            'pageSizeW' => 3231,
            'marginTop' => 170,
            'marginLeft' => 130,
            'marginRight' => 130,
            'marginBottom' => 170,
            'breakType' => 'continuous',
            'colsNum' => 2,
            'colsSpace' => 50
        );
        $imageStyle = array(
            'width' => 68,
            'height' => 68,
            'wrappingStyle' => 'behind',
        );

        ////////RESERVA
        $guia = $request->guia;
        $query =  DB::table('detalle_asignacions')->select('qr')->where('nro_guia','=',$guia)->first();
        $ruta = $query->qr;

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection($sectionStyle);

        for ($i=0; $i < 2; $i++) { 
            $section->addImage(public_path($ruta), $imageStyle);
        }

        $filename = 'QRA-U'.$guia.'.docx';
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
    }

    /**
     * Update the specified resource in storage.
     */
    public function print_tira(Request $request)
    {
        $id_asignacion = $request->asignacion;

        $sectionStyle = array(
            'orientation' => 'portrait',
            'pageSizeH' => 1814,
            'pageSizeW' => 3231,
            'marginTop' => 170,
            'marginLeft' => 130,
            'marginRight' => 130,
            'marginBottom' => 170,
            'breakType' => 'continuous',
            'colsNum' => 2,
            'colsSpace' => 50
        );
        $imageStyle = array(
            'width' => 68,
            'height' => 68,
            'wrappingStyle' => 'behind',
        );

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection($sectionStyle);

        $query =  DB::table('detalle_asignacions')->select('qr')->where('id_asignacion','=',$id_asignacion)->get();
        foreach ($query as $q) {
            $ruta = $q->qr; 
            for ($i=0; $i < 2; $i++) { 
                $section->addImage(public_path($ruta), $imageStyle);
            }
        }
        
        $filename = 'QRA-T'.$id_asignacion.'.docx';
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');

    }


    public function modal_qrlisto(Request $request)
    {
        $asignaciones = $request->post('asignaciones'); 
        $tr = '';
        foreach ($asignaciones as $asignacion) {
            if ($asignacion != '') {
                $id_asignacion = $asignacion;
                $query = DB::table('detalle_talonario_reservas')->select('desde','hasta')->where('id_asignacion_reserva','=',$id_asignacion)->first();
                $consulta = DB::table('asignacion_reservas')->select('cantidad_guias')->where('id_asignacion','=',$id_asignacion)->first();

                $cantidad = $consulta->cantidad_guias;
                $desde = $query->desde;
                $hasta = $query->hasta;
                // return response($query->desde);
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                $tr .= '<tr>
                            <td>'.$id_asignacion.'</td>
                            <td class="text-secondary">'.$cantidad.'</td>
                            <td>'.$formato_desde.' - '.$formato_hasta.'</td>
                        </tr>';
            }
           
           
            
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-package fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold">QR Listo</h1>
                        <span class="text-muted fw-bold">Asignaciones</span>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 text-center">
                            <thead>
                                <th>No. Asignación</th>
                                <th>Cant. Guías</th>
                                <th>Correlativo</th>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm" id="btn_aceptar_qrlisto">Aceptar</button>
                    </div>
                </div>';
        return response($html);
    }


    public function qrlisto(Request $request){
        $asignaciones = $request->post('asignaciones'); 
        $ids_asignaciones = '';
        $hoy = date('Y-m-d');

        $idSolicitud = '';

        foreach ($asignaciones as $asignacion) {
            if ($asignacion != '') {
                $update = DB::table('asignacion_reservas')->where('id_asignacion', '=', $asignacion)->update(['estado' => 29, 'fecha_qrlisto' => $hoy]);
                if ($update) {
                    $ids_asignaciones .= $asignacion.'-';
                }else{
                    return response()->json(['success' => false]);
                }
            }else{

            }
        } 


        $user = auth()->id();
        $accion = 'ACTUALIZACION DE ESTADO (QR LISTO), ID ASIGNACIONES: '.$ids_asignaciones;
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

        if ($bitacora) {
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }



    public function modal_guias(Request $request){
        $id_asignacion = $request->post('asignacion'); 

        $query = DB::table('detalle_asignacions')->select('nro_guia','qr')->where('id_asignacion','=',$id_asignacion)->get();
        $consulta = DB::table('asignacion_reservas')->select('contribuyente','id_sujeto','id_sujeto_notuser','fecha_emision')->where('id_asignacion','=',$id_asignacion)->first();
        $emision = $consulta->fecha_emision;
        $id_sujeto = '';
        $tr = '';

        if ($consulta->contribuyente == 27) {
            ////registrado
            $id_sujeto = $consulta->id_sujeto;

            $c = DB::table('sujeto_pasivos')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto','=',$id_sujeto)->first();
            $razon = $c->razon_social;
            $rif = $c->rif_nro.'-'.$c->rif_condicion;
        }else{
            ////no registrado
            $id_sujeto = $consulta->id_sujeto_notuser;

            $c = DB::table('sujeto_notusers')->select('razon_social','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$id_sujeto)->first();
            $razon = $c->razon_social;
            $rif = $c->rif_nro.'-'.$c->rif_condicion;
        }

        foreach ($query as $guia) {
            $ruta = $guia->qr;
            $length = 6;
            $formato_nro_guia = substr(str_repeat(0, $length).$guia->nro_guia, - $length);


            $tr .= '<tr role="button" >
                        <td class="info_guia" nro_guia="'.$guia->nro_guia.'" style="color: #0069eb">'.$formato_nro_guia.'</td>
                        <td class="w-25">
                            <a href="'.route("asignar_qr.print_qr", ["guia" => $guia->nro_guia]).'" class="btn btn-primary btn-sm"  style="font-size:12.7px">Imprimir</a>
                        </td>
                    </tr>';
        }

        $html = '<div class="d-flex justify-content-between px-3 pb-3 text-muted">
                    <div>
                        <h1 class="modal-title fw-bold fs-5 text-navy" id="exampleModalLabel">Asignación No. '.$id_asignacion.'</h1>
                        <span>Emición: '.$emision.'</span>
                    </div>
                    <div class="text-end">
                        <h1 class="modal-title fw-bold fs-5 text-navy">'.$razon.'</h1>
                        <span>R.I.F.: '.$rif.'</span>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-2">
                    <a href="'.route("asignar_qr.print_tira", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm d-flex align-items-center" style="font-size:12.7px"> 
                        <i class="bx bx-printer fs-6 me-2"></i> 
                        <span>Imprimir Tira QR</span>
                    </a>
                </div>

                <table id="tableGuias" class="table table-hover text-center  border-light-subtle" style="font-size:12.7px">
                    <thead>
                        <tr>
                            <th>Nro. de Guía</th>
                            <th>QR</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$tr.'
                    </tbody>                      
                </table>';
        
        return response($html);

    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
