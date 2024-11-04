<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
class EstampillasController extends Controller
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
        $total = DB::table('emision_estampillas')->selectRaw("count(*) as total")->where('ingreso_inventario','=',null)->first();
        $contador = 0;
        $consulta =  DB::table('emision_estampillas')->where('ingreso_inventario','=',null)->get();

        foreach ($consulta as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_emision' => $c->id_emision,
                'fecha_emision' => $c->fecha_emision,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query,$a);
            
        }
        return view('emision_estampillas', compact('query'));
    }


    public function modal_emitir()
    {
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();

        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$value.'">'.$value.' UCD</option>';
        }
        $c = DB::table('variables')->select('valor')->where('variable','=','cant_timbres_tira')->first();
        $cant_timbres_tira = $c->valor;

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-collection fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión de Estampillas</h1>
                        <h5 class="text-muted fw-bold">Timbre móvil</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-secondary">*NOTA: Cada tira emitida trae un total de '.$cant_timbres_tira.' Estampillas.</p>
                    <form id="form_emitir_estampillas" method="post" onsubmit="event.preventDefault(); emitirEstampillas()">
                        <div class="d-flex flex-column" id="conten_detalle_emision_estampillas">
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <label for="denominacion" class="form-label">Denominación: <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm denominacion" id="denominacion_1" i="1" name="emitir[1][denominacion]">
                                        '.$option.'
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="cantidad" class="form-label">Cant. Tiras: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm cantidad" id="cantidad_1" i="1" name="emitir[1][cantidad]" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="cantidad" class="form-label">Cant. Estampillas:</label>
                                    <input type="number" class="form-control form-control-sm" id="timbres_1" disabled>
                                </div>
                                <div class="col-md-1 pt-4">
                                    <a  href="javascript:void(0);" class="btn add_button border-0">
                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

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
    public function denominacions(Request $request)
    {
       
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$value.'">'.$value.' UCD</option>';
           
        }
        return response($option);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function emitir_estampillas(Request $request)
    {
        $emitir = $request->post('emitir');
        $user = auth()->id();
        $id_emision = '';

        ///////////////////////////////////////////////////////////////VERIFICACIÓN DE CAMPOS
        foreach ($emitir as $e) {
            if ($e['denominacion'] === 'Seleccione') {
                return response()->json(['success' => false, 'nota' => 'Disculpe, debe seleccionar la denominación ucd que desea emitir para la tira de estampillas.']);
            }else{
                if ($e['cantidad'] == 0) {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, debe colocar la cantidad de tiras que quiere emitir segun la denominación.']);
                }
            }
            
        }

        ///////////////////CONSULTA : CUANTOS TIMBRES SE EMITEN POR TIRA - IDENTIFICADOR FORMA
        $c = DB::table('variables')->select('valor')->where('variable','=','cant_timbres_tira')->first();
        $cant_timbres_tira = $c->valor;

        $query_2 = DB::table('formas')->select('identificador')->where('forma','=','estampillas')->first();
        $identificador_forma = $query_2->identificador;
        

        ////////////////////////////////////////////////////////////////// EMISIÓN
        $insert_emision = DB::table('emision_estampillas')->insert(['key_user' => $user]); 
        if ($insert_emision) {
            $id_emision = DB::table('emision_estampillas')->max('id_emision');

            $url = 'https://estampillas.tributosaragua.com.ve/?id='.$id_emision; 
            QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrEstampillas/qrcode_TM'.$id_emision.'.png'));
           
            $update_qr = DB::table('emision_estampillas')->where('id_emision', '=', $id_emision)->update(['qr' => 'assets/qrEstampillas/qrcode_TM'.$id_emision.'.png']);
        }else{
            return response()->json(['success' => false]);  
        }

        $tables = '';

        ////////////////////////////////////////////////////////////////// INSERCIÓN DE TIRAS
        $consulta = DB::table('estampillas')->selectRaw("count(*) as total")->first();
        if ($consulta->total == 0) {
            //////////////PRIMERA EMISIÓN
            foreach ($emitir as $e) {
                
                $deno = $e['denominacion']; 
                $cantidad_tiras = $e['cantidad'];

                $query_3 = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',$deno)->first();
                $key_deno = $query_3->id;

                ///////////////insert detalle emisión estampillas
                $insert_detalle =DB::table('detalle_emision_estampillas')->insert(['key_emision' => $id_emision, 'key_denominacion' => $key_deno, 'cantidad_tiras' => $cantidad_tiras]); 
                ////////////////////////////////////////////////

                $query_1 = DB::table('ucd_denominacions')->select('identificador')->where('denominacion','=', $deno)->first();
                $identificador_ucd = $query_1->identificador;

                $tr = '';

                for ($i=0; $i < $cantidad_tiras; $i++) { 
                    $desde_correlativo = 0;
                    $hasta_correlativo = 0;
                    $desde = '';
                    $hasta = '';
                    $secuencia = 0;

                    if ($i == 0) {
                        $desde_correlativo = 1;
                        $hasta_correlativo = $cant_timbres_tira;
                        $secuencia = 1;
                    }else{
                        $query = DB::table('estampillas')->select('hasta_correlativo','secuencia')->where('key_denominacion','=', $key_deno)->orderBy('id_tira', 'desc')->first();
                        if ($query) {
                            ////////////existen registros de esa denominicion
                            if ($query->hasta_correlativo == '999999') {
                                $desde_correlativo = 1;
                                $hasta_correlativo = $cant_timbres_tira;
                                if ($query->secuencia != 9) {
                                    $secuencia = $query->secuencia + 1; 
                                }else{
                                    ///////QUE HACER SI ES NUEVE????
                                }
    
                            }else{
                                $desde_correlativo = $query->hasta_correlativo + 1;
                                $hasta_correlativo = ($desde_correlativo + $cant_timbres_tira) - 1;
                                $secuencia = $query->secuencia;
                            }
    
                        }else{
                            ////////////no existen registros de esa denominicion
                            $desde_correlativo = 1;
                            $hasta_correlativo = $cant_timbres_tira;
                            $secuencia = 1;
    
                        }
                    }
                    
                    $length = 6;
                    $formato_desde = substr(str_repeat(0, $length).$desde_correlativo, - $length);
                    $formato_hasta = substr(str_repeat(0, $length).$hasta_correlativo, - $length);

                    $desde = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_desde;
                    $hasta = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_hasta;
                    
                    $insert_tira = DB::table('estampillas')->insert(['key_emision' => $id_emision,
                                                                    'key_denominacion' => $key_deno,
                                                                    'cantidad' => $cant_timbres_tira,
                                                                    'secuencia' => $secuencia,
                                                                    'desde_correlativo' => $desde_correlativo,
                                                                    'hasta_correlativo' => $hasta_correlativo,
                                                                    'desde' => $desde,
                                                                    'hasta' => $hasta,
                                                                    'estado' => 5,
                                                                    'cantidad_asignada' => '0']);   

                    $consulta_inv =  DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $key_deno)->first(); 
                    $cantidad_actual = $consulta_inv->cantidad + $cant_timbres_tira;                                       
                    $update_inventario = DB::table('inventario_estampillas')->where('key_denominacion','=',$key_deno)->update(['cantidad' => $cantidad_actual]);

                    $number = $i+1;
                    $tr .= '<tr>
                                <td>'.$number.'</td>
                                <td>'.$desde.'</td>
                                <td>'.$hasta.'</td>
                            </tr>';
                }///////cierra for 

                $tables .= '<div class="">
                            <p class="fw-bold text-navy fs-5 titulo mb-2">'.$deno.' UCD</p>
                            <table class="table text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>';

            }///////cierra foreach

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-collection fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Estampillas emitidas</span></h1>
                        </div>
                    </div>
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <p class="text-secondary">*NOTA: Cada tira emitida trae un total de 160 Trimbres Fiscales.</p>
                    
                        '.$tables.'
                        
                        <div class="d-flex justify-content-center mb-3">
                            <a href="'.route("emision_estampillas").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                            <a href="'.route("emision_estampillas.pdf", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                        </div>
                    </div>';

            return response()->json(['success' => true, 'html' => $html]); 

        }else{
            /////////////NO ES LA PRIMERA EMISIÓN
            foreach ($emitir as $e) {
                $deno = $e['denominacion']; 
                $cantidad_tiras = $e['cantidad'];

                $query_3 = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',$deno)->first();
                $key_deno = $query_3->id;
                
                ///////////////insert detalle emisión estampillas
                $insert_detalle =DB::table('detalle_emision_estampillas')->insert(['key_emision' => $id_emision, 'key_denominacion' => $key_deno, 'cantidad_tiras' => $cantidad_tiras]); 
                ////////////////////////////////////////////////

                $query_1 = DB::table('ucd_denominacions')->select('identificador')->where('denominacion','=', $deno)->first();
                $identificador_ucd = $query_1->identificador;

                $tr = '';

                for ($i=0; $i < $cantidad_tiras; $i++) { 
                    $desde_correlativo = 0;
                    $hasta_correlativo = 0;
                    $desde = '';
                    $hasta = '';
                    $secuencia = 0;

                    $query = DB::table('estampillas')->select('hasta_correlativo','secuencia')->where('key_denominacion','=', $key_deno)->orderBy('id_tira', 'desc')->first();
                    if ($query) {
                        ////////////existen registros de esa denominicion
                        if ($query->hasta_correlativo == '999999') {
                            $desde_correlativo = 1;
                            $hasta_correlativo = $cant_timbres_tira;
                            if ($query->secuencia != 9) {
                                $secuencia = $query->secuencia + 1; 
                            }else{
                                ///////QUE HACER SI ES NUEVE????
                            }

                        }else{
                            $desde_correlativo = $query->hasta_correlativo + 1;
                            $hasta_correlativo = ($desde_correlativo + $cant_timbres_tira) - 1;
                            $secuencia = $query->secuencia;
                        }

                    }else{
                        
                        ////////////no existen registros de esa denominicion
                        $desde_correlativo = 1;
                        $hasta_correlativo = $cant_timbres_tira;
                        $secuencia = 1;

                    }

                    $length = 6;
                    $formato_desde = substr(str_repeat(0, $length).$desde_correlativo, - $length);
                    $formato_hasta = substr(str_repeat(0, $length).$hasta_correlativo, - $length);

                    $desde = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_desde;
                    $hasta = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_hasta;
                    
                    $insert_tira = DB::table('estampillas')->insert(['key_emision' => $id_emision,
                                                                    'key_denominacion' => $key_deno,
                                                                    'cantidad' => $cant_timbres_tira,
                                                                    'secuencia' => $secuencia,
                                                                    'desde_correlativo' => $desde_correlativo,
                                                                    'hasta_correlativo' => $hasta_correlativo,
                                                                    'desde' => $desde,
                                                                    'hasta' => $hasta,
                                                                    'estado' => 5,
                                                                    'cantidad_asignada' => '0']); 
                                                                    
                    $consulta_inv = DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $key_deno)->first(); 
                    $cantidad_actual = $consulta_inv->cantidad + $cant_timbres_tira;                                       
                    $update_inventario = DB::table('inventario_estampillas')->where('key_denominacion','=',$key_deno)->update(['cantidad' => $cantidad_actual]);

                    $number = $i+1;
                    $tr .= '<tr>
                            <td>'.$number.'</td>
                            <td>'.$desde.'</td>
                            <td>'.$hasta.'</td>
                        </tr>';

                }///////cierra for 

                $tables .= '<div class="">
                                <p class="fw-bold text-navy fs-5 titulo mb-2">'.$deno.' UCD</p>
                                <table class="table text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                    '.$tr.'
                                </table>
                            </div>';

            }///////cierra foreach

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-collection fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Estampillas emitidas</span></h1>
                        </div>
                    </div>
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <p class="text-secondary">*NOTA: Cada tira emitida trae un total de 160 Trimbres Fiscales.</p>
                    
                        '.$tables.'
                        
                        <div class="d-flex justify-content-center mb-3">
                            <a href="'.route("emision_estampillas").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                            <a href="'.route("emision_estampillas.pdf", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                        </div>
                    </div>';

            return response()->json(['success' => true, 'html' => $html]); 
        }

    }



    public function pdf(Request $request)
    {
        $emision = $request->emision;
        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $correlativo = [];

        $query =  DB::table('detalle_emision_estampillas')->where('key_emision', '=', $emision)->get();
        $tables = '';

        $c = 0;

        foreach ($query as $detalle) {
            $c++;
            $salto = true;

            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $detalle->key_denominacion)->first();
            $ucd = $consulta->denominacion;

            $array = array(
                        'salto' => $salto,
                        'ucd' => $ucd,
                        'numero' => '',
                        'desde' => '',
                        'hasta' => '',
                    );
            $a = (object) $array;
            array_push($correlativo,$a);

            $consulta_2 = DB::table('estampillas')->select('desde','hasta')->where('key_emision','=',$emision)->where('key_denominacion','=',$detalle->key_denominacion)->get();
            $i = 0;

            foreach ($consulta_2 as $c2) {
                $i++; 
                $salto = false;
                
                $array = array(
                            'salto' => $salto,
                            'ucd' => $ucd,
                            'numero' => $i,
                            'desde' => $c2->desde,
                            'hasta' => $c2->hasta,
                        );
                $a = (object) $array;
                array_push($correlativo,$a);
            }

            

        }

        $pdf = PDF::loadView('pdfTirasEmitidas', compact('correlativo'));

        return $pdf->download('Tiras_'.$year.''.$mes.''.$dia.'.pdf');

    }



    public function detalles(Request $request){
        $emision = $request->post('emision');
        $ingreso_inventario = '';
        
        ///////////////////////////////////////////////////////////////DETALLE EMISIÓN
        $query = DB::table('emision_estampillas')->select('fecha_emision','ingreso_inventario')->where('id_emision','=', $emision)->first();
        
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
                                    <a href="'.route("emision_estampillas.pdf", ["emision" => $emision]).'">Descargar</a>
                                </td>
                            </tr>
                        </table>
                    </div>';

        ///////////////////////////////////////////////////////////////DETALLE TIRAS
        $query_2 = DB::table('detalle_emision_estampillas')->where('key_emision','=', $emision)->get();
        $tr_t2 = '';

        $c = DB::table('variables')->select('valor')->where('variable','=','cant_timbres_tira')->first();
        $cant_timbres_tira = $c->valor;
        
        $table_three = '';

        foreach ($query_2 as $q2) {
            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $q2->key_denominacion)->first();
            $ucd = $consulta->denominacion;
            $tr_t3 = ''; 

            $cant_timbres = $q2->cantidad_tiras * $cant_timbres_tira;

            $tr_t2 .=   '<tr>
                            <td>'.$ucd.' UCD</td>
                            <td>'.$q2->cantidad_tiras.' unidad(es)</td>
                            <td class="text-muted">'.$cant_timbres.' Timbres Fiscales</td>
                        </tr>';

            $query_3 = DB::table('estampillas')->select('desde','hasta')->where('key_emision','=', $emision)->where('key_denominacion','=', $q2->key_denominacion)->get();
            $i = 0;
            foreach ($query_3 as $q3) {
                $i++;
                $tr_t3 .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$q3->desde.'</td>
                                <td>'.$q3->hasta.'</td>
                            </tr>';  
            }
            ///////////////////////////////////////////////////////////////DETALLE CORRELATIVO
            $table_three .= '<p class="fw-bold text-navy fs-6 text-cente ms-5 ps-3 my-0">'.$ucd.' UCD</p>
                            <div class="d-flex justify-content-center">
                                <table class="table w-75 text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                    '.$tr_t3.'
                                </table>
                            </div>';
        }

        $table_two = '<div class="d-flex justify-content-center">
                        <table class="table w-75">
                            <tr>
                                <th>Denominación</th>
                                <th>Cant. Tiras</th>
                                <th>Cant. Estampillas</th>
                            </tr>
                            '.$tr_t2.'
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
                    <p class="fw-bold text-center text-navy fs-6 titulo">Cantidad de Tiras</p>
                    '.$table_two.'
                    <p class="fw-bold text-center text-navy fs-6 titulo">Correlativo</p>
                    '.$table_three.'
                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>';
        
        return response($html);
        
    }


    public function modal_enviar(Request $request){
        $emision = $request->post('emision'); 

        ///////////////////////////////////////////////////////////////DETALLE TIRAS
        $query = DB::table('detalle_emision_estampillas')->where('key_emision','=', $emision)->get();
        $tables = '';

        foreach ($query as $q1) {
            $query_2 = DB::table('estampillas')->select('desde','hasta')->where('key_emision','=', $emision)->where('key_denominacion','=', $q1->key_denominacion)->get();
            $i = 0;

            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $q1->key_denominacion)->first();
            $ucd = $consulta->denominacion;

            $tr = '';

            foreach ($query_2 as $q2) {
                $i++;
                $tr .= '<tr>
                            <td>'.$i.'</td>
                            <td>'.$q2->desde.'</td>
                            <td>'.$q2->hasta.'</td>
                        </tr>';
            }
            $tables .= '<div class="">
                            <p class="fw-bold text-navy fs-5 titulo mb-2">'.$ucd.' UCD</p>
                            <table class="table text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Enviar a Inventario</h1>
                        <span class="text-muted fw-bold">Estampillas | Timbre movil </span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_enviar_inventario_tiras" method="post" onsubmit="event.preventDefault(); enviarTirasInventario()">
                        '.$tables.'
                        <input type="hidden" name="emision" value="'.$emision.'">

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_enviar_inventario">Aceptar</button>
                        </div>
                    </form>
                </div>';

        return response($html);
    }



    public function enviar_inventario(Request $request)
    {
        $emision = $request->post('emision'); 
        $hoy = date('Y-m-d');
        $update = DB::table('estampillas')->where('key_emision', '=', $emision)->update(['estado' => 1]);

        if ($update) {
            $update_emision = DB::table('emision_estampillas')->where('id_emision', '=', $emision)->update(['ingreso_inventario' => $hoy]);
            if ($update_emision) {

                ///////////BITACORA

                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
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

        $query =  DB::table('detalle_emision_estampillas')->where('key_emision','=', $emision)->get(); 
        if ($query) {
            foreach ($query as $value) {
                $query_2 = DB::table('estampillas')->select('cantidad')->where('key_emision','=', $emision)->where('key_denominacion','=', $value->key_denominacion)->first();
                $cantidad_estampillas = $query_2->cantidad * $value->cantidad_tiras;

                $consulta_inv = DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $value->key_denominacion)->first(); 
                $cantidad_actual = $consulta_inv->cantidad - $cantidad_estampillas;     

                $update_inventario = DB::table('inventario_estampillas')->where('key_denominacion','=',$value->key_denominacion)->update(['cantidad' => $cantidad_actual]);
                if ($update_inventario) {
                    # code...
                }else{
                    return response()->json(['success' => false]);
                }
            }
    
            $delete = DB::table('emision_estampillas')->where('id_emision', '=', $emision)->delete();
            if ($delete) {
                ///////////INCLUIR BITACORA
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            return response()->json(['success' => false]);
        }
        

    }
}
