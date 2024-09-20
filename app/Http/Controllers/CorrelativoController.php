<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\TemplateProcessor;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

// use Intervention\Image\Laravel\Facades\Image;
// use Intervention\Image\ImageManagerStatic as Image;

// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
    


class CorrelativoController extends Controller
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
        /////////// DATOS TABLE REGULARES
        $query = DB::table('talonarios')->where('clase','=',5)->get();
        $talonarios = [];
        foreach ($query as $q) {
            
                $detalle = DB::table('detalle_talonario_regulares')
                        ->join('sujeto_pasivos', 'detalle_talonario_regulares.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                        ->join('canteras', 'detalle_talonario_regulares.id_cantera', '=', 'canteras.id_cantera')
                        ->join('clasificacions', 'detalle_talonario_regulares.asignacion_talonario', '=', 'clasificacions.id_clasificacion')
                        ->select('detalle_talonario_regulares.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre', 'clasificacions.nombre_clf')
                        ->where('detalle_talonario_regulares.id_talonario','=',$q->id_talonario)
                        ->first();

                $desde = $q->desde;
                $hasta = $q->hasta;
                $count_reportada = 0; 

                for ($i=$desde; $i <= $hasta; $i++) {                 
                    $consulta_guia = DB::table('control_guias')->where('nro_guia','=', $i)->count();
                    if ($consulta_guia != 0) {
                        $count_reportada = $count_reportada + 1; 
                    }
                }/////cierra for

                // PORCENTAJE REPORTADO
                $reportado = ($count_reportada * 100)/50;


                $datetime1 = date_create($q->fecha_retiro);
                $datetime2 = date_create(date("Y-m-d"));
                $interval = $datetime1->diff($datetime2);
                $i = $interval->format('%a');
                $alert = 0;

                if ($i > 60 && $reportado == 0) {
                    $alert = 1;
                }

                $array = array(
                            'id_talonario' => $q->id_talonario,
                            'id_solicitud' => $q->id_solicitud,
                            'id_cantera' => $detalle->id_cantera,
                            'id_sujeto' => $detalle->id_sujeto,
                            'tipo_talonario' => $q->tipo_talonario,
                            'desde' => $q->desde,
                            'hasta' => $q->hasta,
                            'razon_social' => $detalle->razon_social ,
                            'rif_condicion' => $detalle->rif_condicion,
                            'rif_nro' => $detalle->rif_nro,
                            'nombre' => $detalle->nombre,
                            'fecha_retiro' => $q->fecha_retiro,
                            'grupo' => $detalle->grupo,
                            'qr' => $detalle->qr,
                            'reportado' => $reportado,
                            'alert' => $alert,
                            'asignacion' => $detalle->nombre_clf,
                            'estado' => $q->estado,
                            'intervalo' => $i ///sirve para saber si se ha cumplido un tiempo desde la solicitud del talonario hasta la fecha, para mandar una alerta
                        );
                $a = (object) $array;
                array_push($talonarios,$a);
        }


        /////////// DATOS TABLE RESERVAS
        $reservas = DB::table('talonarios')
                        ->join('reservas', 'talonarios.id_reserva', '=', 'reservas.id_reserva')
                        ->select('talonarios.*','reservas.fecha')
                        ->where('talonarios.clase','=',6)->get();
    
        return view('correlativo', compact('talonarios','reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function talonario(Request $request)
    {
        $idTalonario = $request->post('talonario'); 
        $columnas = [];
        $talonarios = DB::table('talonarios')->where('id_talonario','=', $idTalonario)->get();
        if ($talonarios) {
            $tr = '';
            $buttonTira = '';
            foreach ($talonarios as $talonario) {
                $detalle = DB::table('detalle_talonario_regulares')
                                            ->join('canteras', 'detalle_talonario_regulares.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('sujeto_pasivos', 'detalle_talonario_regulares.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->select('detalle_talonario_regulares.grupo','detalle_talonario_regulares.qr','canteras.nombre', 'sujeto_pasivos.razon_social')
                                            ->where('detalle_talonario_regulares.id_talonario','=', $idTalonario)->first();
                $desde = $talonario->desde;
                $hasta = $talonario->hasta;
                $count_reportada = 0; 

                for ($i=$desde; $i <= $hasta; $i++) { 
                    $length = 6;
                    $formato_nro_guia = substr(str_repeat(0, $length).$i, - $length);
                    

                    $estado = '';
                    $query = DB::table('control_guias')->where('nro_guia','=', $i)->count();
                    if ($query == 0) {
                        $estado = 'Sin reportar';
                    }else{
                        $estado = '<span class="text-success">Reportada</span>';
                        $count_reportada = $count_reportada + 1; 
                    }


                    if ($detalle->grupo == 30) { ////////////////////GRUPO A
                        $ruta = $detalle->qr;
                        $tr .= '<tr role="button" class="info_guia" nro_guia="'.$i.'">
                                    <td style="color: #0069eb">'.$formato_nro_guia.'</td>
                                    <td>'.$estado.'</td>
                                </tr>';
                        $buttonTira = ' <a href="'.route("correlativo.printqr_A", ["talonario" => $idTalonario]).'" class="btn btn-primary btn-sm me-2" style="font-size:12.7px">
                                            Imprimir Uno
                                        </a>

                                        <a href="'.route("correlativo.print_tira", ["grupo" => $detalle->grupo, "talonario" => $idTalonario]).'" class="btn btn-dark btn-sm d-flex align-items-center" style="font-size:12.7px"> 
                                            <i class="bx bx-printer fs-6 me-2"></i> 
                                            <span>Imprimir Tira QR</span>
                                        </a>';
                    }else{ ////////////////////GRUPO B
                        if ($talonario->asignacion_talonario == 26) { /////////////// ASIGNADO
                            $qr = DB::table('qr_guias')->select('qr')->where('nro_guia','=', $i)->first();
                            $ruta = $qr->qr;
                            $tr .= '<tr role="button" >
                                        <td class="info_guia" nro_guia="'.$i.'" style="color: #0069eb">'.$formato_nro_guia.'</td>
                                        <td class="info_guia" nro_guia="'.$i.'">'.$estado.'</td>
                                        <td class="w-25">
                                            <a href="'.route("correlativo.printqr_B", ["guia" => $i]).'" class="btn btn-primary btn-sm"  style="font-size:12.7px">Imprimir</a>
                                        </td>
                                    </tr>';
                            $buttonTira = '<a href="'.route("correlativo.print_tira", ["grupo" => $detalle->grupo, "talonario" => $idTalonario]).'" class="btn btn-dark btn-sm d-flex align-items-center" style="font-size:12.7px"> 
                                                <i class="bx bx-printer fs-6 me-2"></i> 
                                                <span>Imprimir Tira QR</span>
                                            </a>';
                        }else{   /////////////// EN RESERVA
                            $tr .= '<tr role="button" >
                                        <td class="info_guia" nro_guia="'.$i.'" style="color: #0069eb">'.$formato_nro_guia.'</td>
                                        <td class="info_guia" nro_guia="'.$i.'">'.$estado.'</td>
                                        <td class="w-25">
                                            <span class="text-muted fst-italic">Sin Asignar</span>
                                        </td>
                                    </tr>';
                            $buttonTira = '<p class="text-muted"><span style="color:red">*</span>NOTA: LOS QR NO PODRÁN SER GENERADOS HASTA QUE EL TALONARIO HAYA SIDO ASIGNADO.</p>';
                        }
                        
                    }
                   
                }/////cierra for     NOTA: <a href="'.asset($ruta).'" id="descargar_qr" talonario="'.$idTalonario.'" download class="btn btn-secondary btn-sm" style="font-size:12.7px">Descargar</a>

                // PORCENTAJE REPORTADO
                $reportado = ($count_reportada * 100)/50;

                $thTable = '';
                if ($detalle->grupo == 30) {
                    /// un qr por talonario
                    $thTable = '<th>Nro. de Guía</th>
                                <th>Estado</th>';
                }else{
                    /// un qr por guia
                    $thTable = '<th>Nro. de Guía</th>
                                <th>Estado</th>
                                <th>QR</th>';
                }

                $html = '<div class="d-flex justify-content-between px-3 pb-3 text-muted">
                            <div>
                                <h1 class="modal-title fw-bold fs-5 text-navy" id="exampleModalLabel">Talonario No. '.$idTalonario.'</h1>
                                <span>Emitido por la Solicitud #'.$talonario->id_solicitud.'</span>
                            </div>
                            <div class="text-end">
                                <h1 class="modal-title fw-bold fs-5 text-navy">Cantera: '.$detalle->nombre.'</h1>
                                <span>Contribuyente: '.$detalle->razon_social.'</span>
                            </div>
                        </div>

                        <div class="mx-5 px-5 mb-3" style="">
                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: '.$reportado.'%">'.$reportado.'%</div>
                            </div>
                            <p class="text-center pt-2">Se ha <span class="fw-bold">Reportado un '.$reportado.'%</span> del Talonario en el <span class="fw-bold">Libro de Control</span></p>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                            '.$buttonTira.'
                        </div>

                        <table id="tableGuias" class="table table-hover text-center  border-light-subtle" style="font-size:12.7px">
                            <thead>
                                <tr>
                                    '.$thTable.'
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>                      
                        </table>';
             
                return response($html);

            }////cierra foreach
        }//// cierra if talonarios

    }


    public function guia(Request $request)
    {
        $nroGuia = $request->post('guia');
        $html = '';
        $count = DB::table('control_guias')->where('nro_guia','=', $nroGuia)->count();

        if ($count == 0) {
            $html = '<p class="fs-6 text-secondary fst-italic text-center my-5">Sin Reportar.</p>';
            return response($html);
        }else{
            $guia = DB::table('control_guias')->join('canteras', 'control_guias.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('sujeto_pasivos', 'control_guias.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->join('minerals', 'control_guias.id_mineral', '=', 'minerals.id_mineral')
                                            ->select('control_guias.*', 'canteras.nombre', 'canteras.municipio_cantera', 'canteras.parroquia_cantera', 'canteras.lugar_aprovechamiento', 'minerals.mineral', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                                            ->where('control_guias.nro_guia','=', $nroGuia)->get();
        
            if ($guia) {
                
                foreach ($guia as $g) {
                    $motivo = '';
                    if ($g->anulada == 'Si') {
                    $motivo = $g->motivo;
                    }else{
                        $motivo = '<span class="fst-italic text-secondary">No Aplica</span>';
                    }

                    $nro_factura = '';
                    if ($g->nro_factura != '') {
                        $nro_factura = $g->nro_factura;
                    }else{
                        $nro_factura = '<span class="fst-italic text-secondary">No Aplica</span>';
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
                                            <td>'.$g->fecha.'</td>
                                            <th>Hora de Salida:</th>
                                            <td>'.$g->hora_salida.'</td>
                                        </tr>
                                    </table>
                                    <!-- DATOS DE LA EMPRESA Y CANTERA -->
                                    <table class="table">
                                        <tr>
                                            <th>Razon Social:</th>
                                            <td>'.$g->razon_social.'</td>
                                            <th>R.I.F.:</th>
                                            <td>'.$g->rif_condicion.'-'.$g->rif_nro.'</td>
                                        </tr>
                                        <tr>
                                            <th>Nombre de la Cantera:</th>
                                            <td>'.$g->nombre.'</td>
                                            <th>Municipio y Parroquia:</th>
                                            <td>Municipio '.$g->municipio_cantera.', Parroquia '.$g->parroquia_cantera.'</td>
                                        </tr>
                                        <tr>
                                            <th>Lugar de Aprovechamiento:</th>
                                            <td colspan="3">'.$g->lugar_aprovechamiento.'</td>
                                        </tr>
                                    </table>
                                    <!-- DATOS DEL DESTINATARIO -->
                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>
                                    <table class="table">
                                        <tr>
                                            <th>Razon Social del Destinatario:</th>
                                            <td>'.$g->razon_destinatario.'</td>
                                            <th>C.I/R.I.F. del Destinatario:</th>
                                            <td>'.$g->ci_destinatario.'</td>
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
                                            <th>Nro. Factura:</th>
                                            <td colspan="2">'.$nro_factura.'</td>
                                            <th>Fecha de Facturación:</th>
                                            <td colspan="2">'.$g->fecha_facturacion.'</td>
                                        </tr>
                                        <tr>
                                            <th>Mineral:</th>
                                            <td colspan="2">'.$g->mineral.'</td>
                                            <th>Cantidad Facturada:</th>
                                            <td colspan="2">'.$g->cantidad_facturada.' '.$g->unidad_medida.'</td>
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
                }
            }else{
                return response('ERROR AL TRAER LOS DATOS DE LA GUÍA.');
            }
        }

    }

    
    public function qr(Request $request)
    {
        $ruta = $request->post('ruta');
        $talonario = $request->post('talonario');

        $html = '<div class="text-center my-4">
                    <img src="'.asset($ruta).'" alt="">
                </div>
                <div class="d-flex justify-content-center my-2">
                    <a href="'.asset($ruta).'" id="descargar_qr" talonario="'.$talonario.'" download class="btn btn-primary btn-sm">Descargar QR</a>
                </div>';
        return response($html);
      
    }

    /**
     * Display the specified resource.
     */
    public function accion(Request $request)
    {
        $talonario = $request->post('talonario');
        $user = auth()->id();
        $accion = 'QR DESCARGADO DEL TALONARIO NRO.'.$talonario.'.';
        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 13, 'accion'=> $accion]);
    }



    public function printqr_A(Request $request){
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

        ////////GRUPO A
        $talonario = $request->talonario;
        $query =  DB::table('detalle_talonario_regulares')->select('qr')->where('id_talonario','=',$talonario)->first();
        $ruta = $query->qr;

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection($sectionStyle);

        for ($i=0; $i < 2; $i++) { 
            $section->addImage(public_path($ruta), $imageStyle);
        }

        $filename = 'QRU-A'.$talonario.'.docx';
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');

    }


    public function printqr_B(Request $request){
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

        ////////GRUPO B
        $guia = $request->guia; 
        $query =  DB::table('qr_guias')->select('qr')->where('nro_guia','=',$guia)->first();
        $ruta = $query->qr;

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection($sectionStyle);

        for ($i=0; $i < 2; $i++) { 
            $section->addImage(public_path($ruta), $imageStyle);
        }

        $filename = 'QRU-B'.$guia.'.docx';
        
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
     
    }


    public function print_tira(Request $request){
        $grupo = $request->grupo;

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


        if ($grupo == 30) {
            ////////GRUPO A
            $talonario = $request->talonario;
            $query =  DB::table('detalle_talonario_regulares')->select('qr')->where('id_talonario','=',$talonario)->first();
            $ruta = $query->qr;

            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection($sectionStyle);

            for ($i=0; $i < 50; $i++) { 
                $section->addImage(public_path($ruta), $imageStyle);
            }

            $filename = 'QRT-A'.$talonario.'.docx';
            
            header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
            header('Content-Disposition: attachment; filename=' . $filename);
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('php://output');

        }else{
            ////////GRUPO B
            $talonario = $request->talonario;
            $consulta = DB::table('talonarios')->select('desde','hasta')->where('id_talonario','=',$talonario)->first();
            if ($consulta) {
                $desde = $consulta->desde;
                $hasta = $consulta->hasta;


                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection($sectionStyle);

                for ($i=$desde; $i <= $hasta; $i++) { 
                    $query =  DB::table('qr_guias')->select('qr')->where('nro_guia','=',$i)->first();
                    $ruta = $query->qr;

                    for ($x=0; $x < 2; $x++) { 
                        $section->addImage(public_path($ruta), $imageStyle);
                    }
                    
                }

                $filename = 'QRT-B'.$talonario.'.docx';
                header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document"); 
                header('Content-Disposition: attachment; filename=' . $filename);
                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $objWriter->save('php://output');
            
            }else{

            }          

        }
        


    }

    ////////////////////////IMPRESIÓN DE QR

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
