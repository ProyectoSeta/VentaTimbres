<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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


    public function modal_emitir(Request $request)
    {
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();

        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$value.'">'.$value.' UCD</option>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-collection fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión de Estampillas</h1>
                        <h5 class="text-muted fw-bold">Timbre móvil</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-secondary">*NOTA: Cada tira emitida trae un total de 160 Estampillas.</p>
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
        $consulta = DB::table('estampillas')->selectRaw("count(*) as total")->first();
        $insert_emision = DB::table('emision_estampillas')->insert(['key_user' => $user]); 
        if ($insert_emision) {
            $id_emision = DB::table('emision_estampillas')->max('id_emision');
        }else{
            return response()->json(['success' => false]);  
        }

        $tables = '';

        ////////////////////////////////////////////////////////////////// INSERCIÓN DE TIRAS
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
                                                                    'estado' => 5]);   
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
                                                                    'estado' => 5]);   
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
        
        $query =  DB::table('detalle_emision_estampillas')->where('key_emision', '=', $emision)->get();
        $tables = '';

        foreach ($query as $detalle) {
            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $detalle->key_denominacion)->first();
            $ucd = $consulta->denominacion;

            $tr = '';

            $consulta_2 = DB::table('estampillas')->select('desde','hasta')->where('key_emision','=',$emision)->where('key_denominacion','=',$detalle->key_denominacion)->get();
            $i = 0;
            foreach ($consulta_2 as $c) {
                $i++;
                $tr .= '<tr>
                            <td>'.$i.'</td>
                            <td>'.$c->desde.'</td>
                            <td>'.$c->hasta.'</td>
                        </tr>';
            }

            $tables .= '<div class="">
                            <p id="ucd_title">'.$ucd.' UCD</p>
                            <table class="">
                                <tr>
                                    <th>#</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>';

        }

        $pdf = PDF::loadHTML(view('pdfTirasEmitidas', compact('tables')));

        return $pdf->download('Tiras_'.$year.''.$mes.''.$dia.'.pdf');

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
