<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
class AsignarController extends Controller
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
        $asignado_tfe = [];
        $asignado_estampillas = [];

        $query_1 =  DB::table('asignacion_tfes')->where('fecha_recibido','=', null)->get();
        foreach ($query_1 as $q1) {
            $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->select('sedes.sede')
                            ->where('taquillas.id_taquilla','=',$q1->key_taquilla)->first();
            $array = array(
                        'id_asignacion' => $q1->id_asignacion,
                        'fecha' => $q1->fecha,
                        'cantidad' => $q1->cantidad,
                        'key_taquilla' => $q1->key_taquilla,
                        'sede' => $consulta->sede,
                    );
            $a = (object) $array;
            array_push($asignado_tfe,$a);
        }



        $query_2 =  DB::table('asignacion_estampillas')->where('fecha_recibido','=', null)->get();
        foreach ($query_2 as $q2) {
            $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->select('sedes.sede')
                            ->where('taquillas.id_taquilla','=',$q2->key_taquilla)->first();
            $array = array(
                        'id_asignacion' => $q2->id_asignacion,
                        'fecha' => $q2->fecha,
                        'key_taquilla' => $q2->key_taquilla,
                        'sede' => $consulta->sede,
                    );
            $i = (object) $array;
            array_push($asignado_estampillas,$i);
        }

        $sedes =  DB::table('sedes')->get();
        return view('asignar', compact('sedes','asignado_tfe','asignado_estampillas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function taquillas(Request $request)
    {
        $sede = $request->post('value'); 
        $options = '';
        $taquillas =  DB::table('taquillas')
                        ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                        ->select('taquillas.*','funcionarios.nombre')
                        ->where('taquillas.key_sede','=', $sede)->get();
        if ($taquillas) {
            $options .= '<option>Seleccionar</option>';
            foreach ($taquillas as $taquilla) {
                $options .= '<option value="'.$taquilla->id_taquilla.'">'.$taquilla->id_taquilla.' - '.$taquilla->nombre.'</option>';
            }

            return response($options);
        }
    }



    public function funcionario(Request $request)
    {
        $taquilla = $request->post('value'); 
        $query =  DB::table('taquillas')
                        ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                        ->select('funcionarios.nombre')
                        ->where('taquillas.id_taquilla','=', $taquilla)->first();
        if ($query) {
            $funcionario = ''.$query->nombre.'';
            return response($funcionario);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function asignar_forma_14(Request $request)
    {
        $cantidad = $request->post('cantidad'); ///return response($cantidad.'/'.$sede.'/'.$taquilla);
        $sede = $request->post('sede');
        $taquilla = $request->post('taquilla');
        $user = auth()->id();
        $desde = '';
        $hasta = '';
        $tr = '';
        $html = '';

        if (!empty($cantidad) || !empty($taquilla)) {
            if ($cantidad != 0) { 
                $c1 = DB::table('emision_tfes')->select('id_emision','cantidad_timbres','desde','hasta')->where('estado','=',1)->first(); 
                if ($c1) {
                    //////////////////////////////// BUSCAR DESDE - HASTA
                    $c2 = DB::table('inventario_tfes')->select('hasta','cantidad')->where('key_emision','=',$c1->id_emision)->orderBy('id_lote', 'desc')->first();
                    if ($c2) {
                        //////HAY REGISTROS, HAN SIDO ASIGNADOS TIMBRE DE ESA EMISION, ULTIMO (HASTA) ASIGNADO
                        $timbres_dispo = $c1->cantidad_timbres - $c2->cantidad;
                        if ($timbres_dispo <= $cantidad) {
                            /////// HAY SUFICIENTES TIMBRES DISPONIBLES EN ESA EMISION PARA CUBRIR LA ASIGNACION
                            $desde = $c2->hasta + 1;
                            $hasta = ($desde + $cantidad) - 1;
                        }else{
                            /////// NO HAY SUFICIENTES TIMBRES DISPONIBLES EN ESE EMISION PARA CUBRIR LA ASIGNACION
                            return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficientes Timbres TFE-14 en el lote actual, asigne la cantidad disponible, y luego realice otra asignación para la cantidad restante, con el siguiente lote disponible en Inventario.']);   
                        }
                    }else{
                        /////NO HAY REGISTROS EN INVENTARIO, PRIMERA ASIGNACION DE ESA EMISION(LOTE)
                        $desde = $c1->desde;
                        $hasta = ($desde + $cantidad) - 1;
                    }
                    /////////////////////////////////////////////////////////

                    ///////////////////////////////////////////////// INSERTS
                    $insert = DB::table('asignacion_tfes')->insert([
                                            'key_user' => $user,
                                            'cantidad' => $cantidad,
                                            'key_taquilla' => $taquilla]); 
                    if ($insert) {
                        $id_asignacion = DB::table('asignacion_tfes')->max('id_asignacion');

                        $insert_inv = DB::table('inventario_tfes')->insert([
                                                        'key_emision' => $c1->id_emision,
                                                        'desde' => $desde,
                                                        'hasta' => $hasta,
                                                        'cantidad' => $cantidad,
                                                        'vendido' => 0,
                                                        'key_asignacion' => $id_asignacion,
                                                        'key_taquilla' => $taquilla,
                                                        'condicion' => 8]); 
                        if ($insert_inv) {
                            if ($hasta == $c1->hasta) {
                                ///////ULTIMA ASIGNACION DEL LOTE EN USO
                                $update = DB::table('emision_tfes')->where('id_emision', '=', $c1->id_emision)->update(['estado' => 2]);
                            }


                            $consulta =  DB::table('sedes')->select('sede')->where('id_sede','=',$sede)->first();
                            $consulta_2 = DB::table('taquillas')
                                                ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                                                ->select('funcionarios.nombre')
                                                ->where('taquillas.id_taquilla','=', $taquilla)->first();


                            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                                <div class="text-center">
                                                    <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                                                    <h1 class="modal-title fs-5 fw-bold text-navy">Timbres Fiscales Asignados</h1>
                                                    <span class="text-muted fw-bold">Forma 14</span>
                                                </div>
                                            </div>
                                            <div class="modal-body px-5 py-3" style="font-size:13px">
                                                <div class="d-flex flex-column text-muted mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <p class="mb-1">Sede: <span class="text-navy fw-bold">'.$consulta->sede.'</span></p>
                                                        <p class="mb-1">ID TAQUILLA: <span class="text-navy fw-bold">'.$taquilla.'</span></p>
                                                    </div>
                                                    <p class="mb-1">Taquillero designado: <span class="text-navy fw-bold">'.$consulta_2->nombre.'</span></p>
                                                </div>
                                                
                                                <div class="">
                                                    <table class="table text-center">
                                                        <tr>
                                                            <th>ID Emisión Lote</th>
                                                            <th>Desde</th>
                                                            <th>Hasta</th>
                                                        </tr>
                                                        <tr>
                                                            <td>'.$c1->id_emision.'</td>
                                                            <td>'.$desde.'</td>
                                                            <td>'.$hasta.'</td>
                                                        </tr>
                                                    </table>
                                                </div>


                                                <div class="d-flex justify-content-center mb-3">
                                                    <a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                                    <a href="'.route("asignar.pdf_forma14", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir Constancia</a>
                                                </div>
                                            </div>';

                            return response()->json(['success' => true, 'html' => $html]);
                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }

                }else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Timbres TFE-14 disponibles en el Inventario en este momento.']); 
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, especifique la cantidad de rollos a Asignar.']); 
            }
        }else{
            return response()->json(['success' => false, 'nota' => 'Disculpe, debe llenar los campos solicitados.']);
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function pdf_forma14(Request $request)
    {
        $asignacion = $request->asignacion;
       
        $length = 6;
        $correlativo = [];
        $query = DB::table('inventario_tfes')->where('key_asignacion', '=', $asignacion)->first();

        $desde = $query->desde;
        $hasta = $query->hasta;

        $cant_timbres = $query->cantidad;

        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

        $array = array(
                    'id' => $query->key_emision,
                    'desde' => $formato_desde,
                    'hasta' => $formato_hasta,
                    'cant_timbres' => $cant_timbres
                );
        $a = (object) $array;
        array_push($correlativo,$a);

        $c2 = DB::table('taquillas')
                            ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                            ->select('funcionarios.nombre','funcionarios.ci_condicion','funcionarios.ci_nro','taquillas.key_sede')
                            ->where('taquillas.id_taquilla','=', $query->key_taquilla)->first();
        
        $c3 = DB::table('sedes')->select('sede')->where('id_sede','=', $c2->key_sede)->first(); 
        
        $cant_timbres = $query->cantidad;
        $taquillero = $c2->nombre;
        $sede = $c3->sede;
        $ci_taquillero = $c2->ci_condicion.''.$c2->ci_nro;
        $id_taquilla = $query->key_taquilla;


        $pdf = PDF::loadView('pdfAsignacionTFE14', compact('correlativo','cant_timbres','taquillero','sede','ci_taquillero','id_taquilla','asignacion'));

        return $pdf->download('Asignación_TFE14_ID'.$asignacion.'.pdf');
    }



    public function detalle_rollos(Request $request){
        $asignacion = $request->post('asignacion');
        $vista = $request->post('vista'); 

        $button = '';
        $datos = '';

        $query = DB::table('asignacion_tfes')->where('id_asignacion','=',$asignacion)->first();
        $q2 = DB::table('inventario_tfes')->where('key_asignacion','=',$asignacion)->first();

        
        $tr = '<tr>
                    <td>'.$q2->key_emision.'</td>
                    <td>'.$q2->desde.'</td>
                    <td>'.$q2->hasta.'</td>
                </tr>';
       
        $fecha_recibido = '';

        if ($query->fecha_recibido == NULL) {
            $fecha_recibido = '<span class="text-secondary">Sin Recibir</span>';
        }else{
            $fecha_recibido = $query->fecha_recibido;
        }

        $q3 = DB::table('taquillas')
                            ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                            ->select('funcionarios.nombre','taquillas.key_sede')
                            ->where('taquillas.id_taquilla','=', $query->key_taquilla)->first();
        
        $q4 = DB::table('sedes')->select('sede')->where('id_sede','=', $q3->key_sede)->first(); 
        $c2 = DB::table('users')->select('key_sujeto')->where('id','=', $query->key_user)->first(); 
        $c3 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $c2->key_sujeto)->first(); 

        if ($vista == 'taquillero') {
            $button = '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>';
            $datos = '';
        }else{
            $button = '<a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>';
            $datos = '<div class="d-flex justify-content-center">
                        <table class="table">
                            <tr>
                                <th>ID Asignación:</th>
                                <td class="text-navy fw-bold">'.$asignacion.'</td>
                                <th>Sede:</th>
                                <td class="text-navy fw-bold">'.$q4->sede.'</td>
                            </tr>
                            <tr>
                                <th>ID Taquilla:</th>
                                <td>'.$query->key_taquilla.'</td>
                                <th>Taquillero Designado:</th>
                                <td class="text-navy fw-bold">'.$q3->nombre.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Fecha asignación:</th>
                                <td colspan="2">'.$query->fecha.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Fecha recepción:</th>
                                <td colspan="2">'.$fecha_recibido.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Asignado por:</th>
                                <td colspan="2">'.$c3->nombre.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Cantidad de Rollos:</th>
                                <td colspan="2" class="text-navy fw-bold">'.$query->cantidad.' Unidades</td>
                            </tr>
                        </table>
                    </div>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-collection  fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Timbres Fiscales Asignados</h1>
                        <span class="text-muted fw-bold">Lote | Forma 14</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    '.$datos.'
                    <p class="text-center fw-bold text-muted fs-5  mb-2">Correlativo</p>
                    
                    <div class="">
                        <table class="table text-center">
                            <tr>
                                <th>ID Emisión Lote</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            '.$tr.'
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        '.$button.'
                    </div>
                </div>';

        return response($html);
    }

    ///////////////////////////////////ASIGNACIÓN DE ESTAMPILLAS ////////////////////////////////////////////////////////////


    public function denominacions(Request $request)
    {
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$denomi->id.'">'.$value.' UCD</option>';
           
        }
        return response($option);
    }



    /**
     * Update the specified resource in storage.
     */
    public function content_estampillas()
    {
        $sedes =  DB::table('sedes')->get();
        $option_sedes = '<option value="Seleccione">Seleccione</option>';

        foreach ($sedes as $sede) {
            $option_sedes .= '<option value="'.$sede->id_sede.'">'.$sede->sede.'</option>';
        }


        $option_ucd = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option_ucd .= '<option value="'.$denomi->id.'">'.$value.' UCD</option>';
           
        }

        $html = '<form id="form_asignar_estampillas" method="post" onsubmit="event.preventDefault(); asignarEstampillas()">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="select_sede_estampilla" class="form-label">Sede: <span style="color:red">*</span></label>
                            <select class="form-select form-select-sm sede" forma="estampillas" id="select_sede_estampilla" name="sede" required>
                                '.$option_sedes.'
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="select_taquilla_estampilla" class="form-label">Taquilla: <span style="color:red">*</span></label>
                            <select class="form-select form-select-sm taquilla" forma="estampillas" id="select_taquilla_estampilla" name="taquilla" required>
                                <option value="Seleccione">Seleccionar</option>
                            </select>
                        </div>
                    </div>

                    <p class="text-muted my-2 text-end">Taquillero designado: <span class="text-navy fw-bold" id="funcionario_estampillas"> </span></p>
                    <p class="text-center fw-bold text-muted fs-6 titulo">Asignación</p>

                    <p class="text-muted text-justify"><span class="fw-bold">IMPORTANTE:</span> La Asignación se hará según la cantidad individual de Estampillas que se quiera asignar, no por Tiras de Estampillas.</p>
                    <div class="">
                        <div class="d-flex flex-column" id="conten_detalle_asignar_estampillas">
                            <div class="row">
                                <div class="col-5">
                                    <label for="denominacion_1" class="form-label">Denominación: <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm denominacion" id="denominacion_1" i="1" name="emitir[1][denominacion]">
                                        '.$option_ucd.'
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="cantidad_1" class="form-label">Cant. Estampillas:</label>
                                    <input type="number" class="form-control form-control-sm" i="1" id="cantidad_1" name="emitir[1][cantidad]">
                                </div>
                                <div class="col-2 pt-4">
                                    <a  href="javascript:void(0);" class="btn add_button border-0">
                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm">Asignar</button>
                    </div>
                </form>';

        return response($html);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function asignar_estampillas(Request $request)
    {
        $emitir = $request->post('emitir');
        $sede = $request->post('sede');
        $taquilla = $request->post('taquilla');
        
        $user = auth()->id();

        $tr = '';
       

        ///////////////////////////////////////////////////////////////VERIFICACIÓN DE CAMPOS
            if ($taquilla == 'Seleccione') {
                return response()->json(['success' => false, 'nota' => 'Debe seleccionar la Taquilla.']);
            }

            foreach ($emitir as $e) {
                if ($e['denominacion'] === 'Seleccione') {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, debe seleccionar la denominación UCD que desea asignar a Taquilla.']);
                }else{
                    if ($e['cantidad'] == 0) {
                        return response()->json(['success' => false, 'nota' => 'Disculpe, debe colocar la cantidad de Estampillas que desea asignar a Taquilla.']);
                    }
                }
            }

        /////////////////////////////////////////////////////////////VERIFICAR DISPONIBILIDAD
            foreach ($emitir as $e) {
                $deno = $e['denominacion'];
                $cantidad = $e['cantidad'];

                $cant_dispo = 0;

                $c1 = DB::table('inventario_estampillas')->select('cantidad_timbres','asignado')->where('key_denominacion','=', $deno)->where('estado','=', 1)->get();
                foreach ($c1 as $key) {
                    $cant_dispo = $cant_dispo + ($key->cantidad_timbres - $key->asignado);
                    if ($cant_dispo >= $cantidad) {
                        break;
                    }
                }

                if ($cant_dispo < $cantidad) {
                    $c2 = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $deno)->first();
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficientes estampillas de '.$c2->denominacion.' UCD para realizar la Asignación.']);
                }
                
            }

        ////////////////////////////////////////////////////////////ASIGNACIÓN
            /////////INSERT ASIGNACION
            $insert_asignacion = DB::table('asignacion_estampillas')->insert(['key_user' => $user,
                                                                            'key_taquilla' => $taquilla,
                                                                            'condicion' => 8,
                                                                            'fecha_recibido' => null]); 
            if ($insert_asignacion) {
                $id_asignacion = DB::table('asignacion_estampillas')->max('id_asignacion');

                foreach ($emitir as $e) {
                    $key_deno = $e['denominacion'];
                    $cantidad = $e['cantidad'];

                    $con = DB::table('ucd_denominacions')->select('denominacion')->where('id', '=', $key_deno)->first();
    
                    $timbres_asignados = 0;
                    $timbres_restantes = $cantidad;
    
                    $q1 = DB::table('inventario_estampillas')->select('id_inventario_estampilla','cantidad_timbres','desde','hasta','asignado')
                                                            ->where('estado', '=', 1)
                                                            ->where('key_denominacion', '=', $key_deno)->get();
                    foreach ($q1 as $key) {
                        if ($timbres_asignados == $cantidad) {
                            break;
                        }else{
                            // DESDE
                            $q2 = DB::table('detalle_asignacion_estampillas')->select('hasta')
                                                                    ->where('key_inventario_estampilla', '=', $key->id_inventario_estampilla)
                                                                    ->orderBy('correlativo', 'desc')->first();
                            if ($q2) {
                                $desde = $q2->hasta + 1;
                            }else{
                                //// no hay registros
                                $desde = $key->desde;
                            }
    
                            ///HASTA
                            $hasta_prev = ($desde + $timbres_restantes) - 1;
                            if ($hasta_prev > $key->hasta) {
                                /////sobrepaso el limite
                                $hasta = $key->hasta;
                                $timbres_asignados = $timbres_asignados + (($hasta - $desde) + 1);
                            }else{
                                $hasta = $hasta_prev;
                                $timbres_asignados = $cantidad;
                            }
    
                            $timbres_restantes = $timbres_restantes - $timbres_asignados;
                            $cant_asignados = ($hasta - $desde) + 1;
    
                            $insert_detalle = DB::table('detalle_asignacion_estampillas')->insert(['key_asignacion' => $id_asignacion,
                                                                                                    'key_taquilla' => $taquilla,
                                                                                                    'key_inventario_estampilla' => $key->id_inventario_estampilla,
                                                                                                    'key_denominacion' => $key_deno,
                                                                                                    'cantidad_timbres' => $cant_asignados,
                                                                                                    'desde' => $desde,
                                                                                                    'hasta' => $hasta,
                                                                                                    'condicion' => 4,
                                                                                                    'vendido' => 0
                                                                                                    ]);
                            if ($insert_detalle) {
                                $tr .= '<tr>
                                            <td>
                                                <sapn class="fw-bold text-navy fs-6">'.$con->denominacion.' UCD</sapn>
                                            </td>
                                            <td>'.$desde.'</td>
                                            <td>'.$hasta.'</td>
                                            <td>'.$cant_asignados.' und.</td>
                                        </tr>';

                                $new_asignado = $key->asignado + $cant_asignados;

                                if ($key->cantidad_timbres == $new_asignado) {
                                    $update_asignado = DB::table('inventario_estampillas')->where('id_inventario_estampilla','=',$key->id_inventario_estampilla)->update(['asignado' => $new_asignado, 'estado' => 2]);
                                }else{
                                    $update_asignado = DB::table('inventario_estampillas')->where('id_inventario_estampilla','=',$key->id_inventario_estampilla)->update(['asignado' => $new_asignado]);
                                }
                            }else{
                                /////eliminar registro de asignacion estampillas
                                $delete = DB::table('asignacion_estampillas')->where('id_asignacion', '=', $id_asignacion)->delete();
                                return response()->json(['success' => false]);
                            }
                        }
                    }
                }

                $consulta_sede = DB::table('sedes')->select('sede')->where('id_sede','=', $sede)->first(); 
                $consulta_taquillero = DB::table('taquillas')->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                                                            ->select('funcionarios.nombre')
                                                            ->where('taquillas.id_taquilla','=', $taquilla)->first();

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                                <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | Estampillas Asignadas</h1>
                            </div>
                        </div>
                        <div class="modal-body px-5 py-3" style="font-size:13px">
                            <div class="d-flex flex-column text-muted mb-3">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-1">Sede: <span class="text-navy fw-bold">'.$consulta_sede->sede.'</span></p>
                                    <p class="mb-1">ID Taquilla: <span class="text-navy fw-bold">'.$taquilla.'</span></p>
                                </div>
                                <p class="mb-1">Taquillero designado: <span class="text-navy fw-bold">'.$consulta_taquillero->nombre.'</span></p>
                            </div>

                            <div class="text-muted fw-bold fs-5">Correlativo</div>

                            <table class="table">
                                <tr>
                                    <th>UCD</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                    <th>Cantidad</th>
                                </tr>
                                '.$tr.'
                            </table>
                            
                            <div class="d-flex justify-content-center mb-3">
                                <a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                <a href="'.route("asignar.pdf_estampillas", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir Constancia</a>
                            </div>
                        </div>';
                return response()->json(['success' => true, 'html' => $html]);

            }else{
                return response()->json(['success' => false]);
            }

            


        
        
    }



    public function pdf_estampillas(Request $request){
        $asignacion = $request->asignacion;
        $correlativo = [];

        $query =  DB::table('detalle_asignacion_estampillas')->where('key_asignacion', '=', $asignacion)->get();
        $tables = '';


        foreach ($query as $detalle) {
            $consulta = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $detalle->key_denominacion)->first();
            $ucd = $consulta->denominacion;

            $array = array(
                        'ucd' => $ucd,
                        'cantidad' => $detalle->cantidad_timbres,
                        'desde' => $detalle->desde,
                        'hasta' => $detalle->hasta,
                    );
            $a = (object) $array;
            array_push($correlativo,$a);
            

        }////


        $c1 = DB::table('asignacion_estampillas')->select('key_taquilla')->where('id_asignacion', '=', $asignacion)->first();

        $c2 = DB::table('taquillas')
                            ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                            ->select('funcionarios.nombre','funcionarios.ci_condicion','funcionarios.ci_nro','taquillas.key_sede')
                            ->where('taquillas.id_taquilla','=', $c1->key_taquilla)->first();
        
        $c3 = DB::table('sedes')->select('sede')->where('id_sede','=', $c2->key_sede)->first(); 
        
        $taquillero = $c2->nombre;
        $sede = $c3->sede;
        $ci_taquillero = $c2->ci_condicion.''.$c2->ci_nro;
        $id_taquilla = $c1->key_taquilla;


        $pdf = PDF::loadView('pdfAsignacionEstampillas', compact('correlativo','taquillero','sede','ci_taquillero','id_taquilla','asignacion'));

        return $pdf->download('Asignación_Estampillas_'.$asignacion.'.pdf');

    }



    public function info_taquilla(Request $request){
        $taquilla = $request->post('taquilla'); 
        $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                            ->select('sedes.sede','funcionarios.nombre')
                            ->where('taquillas.id_taquilla','=',$taquilla)->first();
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="" >Información de Taquilla</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <div class="d-flex justify-content-centerpx-3">
                        <table class="table text-cente">
                            <tr>
                                <th class="text-center">ID</th>
                                <td class="text-muted">'.$taquilla.'</td>
                            </tr>
                            <tr>
                                <th class="text-center">Sede</th>
                                <td>'.$consulta->sede.'</td>
                            </tr>
                            <tr>
                                <th class="text-center">Taquillero Designado</th>
                                <td class="text-navy fw-bold">'.$consulta->nombre.'</td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>';

        return response($html);
    }


    public function detalle_estampillas(Request $request){
        $asignacion = $request->post('asignacion'); 
        $vista = $request->post('vista'); 
        $tables = '';
        $button = '';
        $datos = '';
        
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

        $q3 = DB::table('asignacion_estampillas')->where('id_asignacion','=', $asignacion)->first(); 
        
        $fecha_recibido = '';

        if ($q3->fecha_recibido == NULL) {
            $fecha_recibido = '<span class="text-secondary">Sin Recibir</span>';
        }else{
            $fecha_recibido = $q3->fecha_recibido;
        }

        $q4 = DB::table('taquillas')
                            ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                            ->select('funcionarios.nombre','taquillas.key_sede')
                            ->where('taquillas.id_taquilla','=', $q3->key_taquilla)->first();
        
        $q5 = DB::table('sedes')->select('sede')->where('id_sede','=', $q4->key_sede)->first(); 
        $c2 = DB::table('users')->select('key_sujeto')->where('id','=', $q3->key_user)->first(); 
        $c3 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $c2->key_sujeto)->first(); 

        if ($vista == 'taquillero') {
            $button = '<button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>';
            $datos = '';
        }else{
            $button = '<a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>';
            $datos = '<div class="d-flex justify-content-center">
                        <table class="table">
                            <tr>
                                <th>ID Asignación:</th>
                                <td class="text-navy fw-bold">'.$asignacion.'</td>
                                <th>Sede:</th>
                                <td class="text-navy fw-bold">'.$q5->sede.'</td>
                            </tr>
                            <tr>
                                <th>ID Taquilla:</th>
                                <td>'.$q3->key_taquilla.'</td>
                                <th>Taquillero Designado:</th>
                                <td class="text-navy fw-bold">'.$q4->nombre.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Fecha asignación:</th>
                                <td colspan="2">'.$q3->fecha.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Fecha recepción:</th>
                                <td colspan="2">'.$fecha_recibido.'</td>
                            </tr>
                            <tr>
                                <th colspan="2">Asignado por:</th>
                                <td colspan="2">'.$c3->nombre.'</td>
                            </tr>
                        </table>
                    </div>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-collection  fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Estampillas Asignadas</h1>
                        <span class="text-muted fw-bold">Timbre móvil</span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    '.$datos.'
                    <p class="text-center fw-bold text-muted fs-5 mb-2">Correlativo</p>
                    <p class="text-muted text-justify"><span class="fw-bold">IMPORTANTE:</span> La Asignación se realizó según la cantidad individual de Estampillas, no por Tiras de Estampillas.</p>
                    '.$tables.'
                    <div class="d-flex justify-content-center mb-3">
                       '.$button.'
                    </div>
                </div>';

        return response($html);
    }


    


}
