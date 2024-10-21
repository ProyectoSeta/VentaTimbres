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
    public function index()
    {
        // $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qr/?id=2/'.'agrrrrrrrrrrrrrrrrrgw0r7688888777777777777777776555555555ggggggggggssssssssssssssssssssAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
                                                            
        // QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/Pruebs.png'));

        $sedes =  DB::table('sedes')->get();
        return view('asignar', compact('sedes'));
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
        $tr = '';
        $html = '';

        if (!empty($cantidad) || !empty($taquilla)) {
            if ($cantidad != 0) {
                $comprobacion = DB::table('inventario_rollos')->selectRaw("count(*) as total")->where('estado','=',1)->first();
                if ($comprobacion->total < $cantidad) {
                    ///////////NO HAY SUFICIENTES ROLLOS PARA REALIZAR LA ASIGNACIÓN
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficientes rollos en el inventario para realizar la asignación.']);
                }else{
                    $insert = DB::table('asignacion_rollos')->insert(['key_user' => $user,'cantidad' => $cantidad,'key_taquilla' => $taquilla]);
                    if ($insert) {
                        $id_asignacion = DB::table('asignacion_rollos')->max('id_asignacion');
                        for ($i=0; $i < $cantidad; $i++) { 
                            $query =  DB::table('inventario_rollos')->select('id_rollo','desde','hasta')->where('estado','=',1)->first(); 
                            if ($query) {
                                ///update key_asignación
                                $update = DB::table('inventario_rollos')->where('id_rollo', '=', $query->id_rollo)
                                                                        ->update(['estado' => 2,
                                                                                    'key_asignacion' => $id_asignacion,
                                                                                    'key_taquilla' => $taquilla,
                                                                                    'condicion' => 4
                                                                                ]);
                                if ($update) {
                                    $tr .= '<tr>
                                                <td>'.$query->id_rollo.'</td>
                                                <td>'.$query->desde.'</td>
                                                <td>'.$query->hasta.'</td>
                                            </tr>'; 
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }

                        $consulta =  DB::table('sedes')->select('sede')->where('id_sede','=',$sede)->first();
                        $consulta_2 = DB::table('taquillas')
                                    ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                                    ->select('funcionarios.nombre')
                                    ->where('taquillas.id_taquilla','=', $taquilla)->first();

                        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                    <div class="text-center">
                                        <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                                        <h1 class="modal-title fs-5 fw-bold text-navy">Rollos Asignados</h1>
                                        <span class="text-muted fw-bold">Forma 14 </span>
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


                                    <div class="d-flex justify-content-center mb-3">
                                        <a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                        <a href="'.route("asignar.pdf_forma14", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                                    </div>
                                </div>';
                        return response()->json(['success' => true, 'html' => $html]);
                        
                    }else{
                        return response()->json(['success' => false]);
                    }
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
        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('inventario_rollos')->where('key_asignacion', '=', $asignacion)->get();

        foreach ($query as $detalle) {
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;

            
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $array = array(
                        'id' => $detalle->id_rollo,
                        'desde' => $formato_desde,
                        'hasta' => $formato_hasta
                    );
            $a = (object) $array;
            array_push($correlativo,$a);

        }

        $pdf = PDF::loadView('pdfAsignacionTFE14', compact('correlativo'));

        return $pdf->download('Asignación_TFE14_'.$year.''.$mes.''.$dia.'.pdf');
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
                                <option>Seleccionar</option>
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
        $taquilla = $request->post('taquilla');

        $user = auth()->id();

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

        /////////////////////////////////////////////////////////////VERIFICAR DISPONIBILIDAD
        foreach ($emitir as $e) {
            $denominacion = $e['denominacion'];
            $cantidad_timbres = $e['cantidad'];

            $consulta = DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $denominacion)->first();
            if ($consulta->cantidad < $cantidad_timbres) {
                $ucd = DB::table('ucd_denominacions')->select('denominacion')->where('id','=', $denominacion)->first();
                return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficiente estampillas de '.$ucd->denominacion.' UCD en el Inventario para realizar la asignación.']);
            }
        }


        //////////////////////////////////////////////////////////ASIGNACIÓN
        $insert_asignacion = DB::table('asignacion_estampillas')->insert(['key_user' => $user, 'key_taquilla' => $taquilla]); 
        if ($insert_asignacion) {
            $id_asignacion = DB::table('asignacion_estampillas')->max('id_asignacion');
            foreach ($emitir as $e) {
                $insert_detalle = DB::table('detalle_asignacion_estampillas')->insert(['key_asignacion' => $id_asignacion, 'key_denominacion' => $e['denominacion'], 'cantidad' => $e['cantidad']]);

                $asignado = 0;
                do {
                    $query = DB::table('estampillas')->select('id_tira','cantidad','cantidad_asignada')->where('key_denominacion','=', $e['denominacion'])->where('cantidad_asignada','<>','cantidad')->first();
                    $timbres_disponibles = $query->cantidad - $query->cantidad_asignada;
    
                    if ($timbres_disponibles >= $e['cantidad']) {
                        ///hay suficientes timbres en la tira para cubrir la asignación
                        $insert_de = DB::table('detalle_estampillas')->insert(['key_tira' => $query->id_tira, 'key_asignacion' => $id_asignacion, 'key_taquilla' => $taquilla, 'cantidad' => $e['cantidad']]);
                        if ($insert_de) {
                            $new_cantidad_asignada = $query->cantidad_asignada + $e['cantidad'];

                            $update = DB::table('estampillas')->where('id_tira','=',$query->id_tira)->update(['cantidad_asignada' => $new_cantidad_asignada]);
                            if ($update) {
                                $consulta_inv = DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $e['denominacion'])->first(); 
                                $cantidad_actual = $consulta_inv->cantidad + $e['cantidad'];                                       
                                $update_inventario = DB::table('inventario_estampillas')->where('key_denominacion','=', $e['denominacion'])->update(['cantidad' => $cantidad_actual]);
                                if ($update_inventario) {
                                    $asignado = $e['cantidad'];
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        ///no hay suficientes timbres en la tira para cubrir la asignación




                        $insert_de = DB::table('detalle_estampillas')->insert(['key_tira' => $query->id_tira, 'key_asignacion' => $id_asignacion, 'key_taquilla' => $taquilla, 'cantidad' => $timbres_disponibles]);
                        if ($insert_de) {
                            $new_cantidad_asignada = $query->cantidad_asignada + $timbres_disponibles;

                            $update = DB::table('estampillas')->where('id_tira','=',$query->id_tira)->update(['cantidad_asignada' => $new_cantidad_asignada]);
                            if ($update) {
                                $consulta_inv = DB::table('inventario_estampillas')->select('cantidad')->where('key_denominacion','=', $e['denominacion'])->first(); 
                                $cantidad_actual = $consulta_inv->cantidad + $timbres_disponibles;                                       
                                $update_inventario = DB::table('inventario_estampillas')->where('key_denominacion','=', $e['denominacion'])->update(['cantidad' => $cantidad_actual]);
                                if ($update_inventario) {
                                    $asignado = $timbres_disponibles;
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }else{
                            return response()->json(['success' => false]);
                        }


    
                    }
                    
    
                }while ($asignado == $e['cantidad']);
    
                
            }
        }else{
            return response()->json(['success' => false]);
        }
        




        // return response($emitir);
    }
}
