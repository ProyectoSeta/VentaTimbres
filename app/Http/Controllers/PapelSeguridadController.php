<?php

namespace App\Http\Controllers;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PapelSeguridadController extends Controller
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
        // FORMA 14 
        $query_tfes = [];
        $total_tfe = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->where('estado', '=', 18)->first();
        $contador_1 = 0;
        $query_1 = DB::table('emision_papel_tfes')->where('estado', '=', 18)->get();

        foreach ($query_1 as $c) {
            $contador_1++;
            $ultimo = false;

            if ($contador_1 == $total_tfe->total) {
                $ultimo = true;
            }

            $array = array(
                'id_lote_papel' => $c->id_lote_papel,
                'fecha_emision' => $c->fecha_emision,
                'cantidad_timbres' => $c->cantidad_timbres,
                'desde' => $c->desde,
                'hasta' => $c->hasta,
                'estado' => $c->estado,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query_tfes,$a);
        }



        // ESTAMPILLAS
        $query_estampillas = [];
        $total_est = DB::table('emision_papel_estampillas')->selectRaw("count(*) as total")->where('estado', '=', 18)->first();
        $contador = 0;
        $query_2 = DB::table('emision_papel_estampillas')->where('estado', '=', 18)->get();

        foreach ($query_2 as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total_est->total) {
                $ultimo = true;
            }

            $array = array(
                'id_lote_papel' => $c->id_lote_papel,
                'fecha_emision' => $c->fecha_emision,
                'cantidad_timbres' => $c->cantidad_timbres,
                'desde' => $c->desde,
                'hasta' => $c->hasta,
                'estado' => $c->estado,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query_estampillas,$a);
            
        }


        
        
        return view('emision_papel', compact('query_tfes','query_estampillas','total_tfe','total_est'));
    }


    // FORMA 14 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function modal_f14()
    {
        $desde = '';
        $hasta = '';
        $options = '';

        $consulta = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_papel_tfes')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            //////consultar cual es el inicio de correlativo
            $con_inicio = DB::table('configuraciones')->select("valor")->where('correlativo','=',3)->first(); //// 3 => inicio correlativo
            if ($con_inicio->valor != null) {
                $desde = $con_inicio->valor;
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, todavia no se ha definido el número de inicio del correlativo para la emision de los timbres fiscales TFE-14. Por favor, vaya hasta el modulo Configuraciones/Ajustes, y defina la variable.']);
            }
        }

        $c1 =  DB::table('configuraciones')->select('valor')->where('correlativo','=',2)->first(); //// 2 => cant. timbres tfe14 por lote 
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1;

        $query_2 =  DB::table('proveedores')->select('id_proveedor','condicion_identidad','nro_identidad','razon_social')->get();
        foreach ($query_2 as $q2) {
            $options .= '<option value="'.$q2->id_proveedor.'">'.$q2->condicion_identidad.''.$q2->nro_identidad.' - '.$q2->razon_social.'</option>';
        }
        
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | TFE-14</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-justify">*NOTA: Sí el total de Timbres Fiscales a emitir es diferente al esperado o se ha cambiado la cantidad de timbres a producirse por emisión, ingrese al <span class="fw-bold">Módulo Configuraciones (Ajustes)</span> para cambiar el número total de Timbres Fiscales por emisión (Lote).  
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total de Timbres a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">'.$cant_timbres_lote.' Timbres TFE-14 | Papel de Seguridad</p>
                    </div>
                    

                    <div class="d-flex justify-content-center mt-4 mb-2">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>'.$desde.'</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>'.$hasta.'</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_papel_f14" method="post" onsubmit="event.preventDefault(); emitirPapelF14()">
                        <div class=" px-2">
                            <label for="proveedor" class="form-label">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" name="proveedor" id="proveedor" aria-label="Small select example">
                                '.$options.'
                            </select>
                        </div>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';


        return response()->json(['success' => true, 'html' => $html]);


    }


    public function emitir_f14(Request $request)
    {
        $id_proveedor = $request->post('proveedor'); 
        $query = DB::table('emision_papel_tfes')->select('id_lote_papel')->where('estado', '=', 18)->first();
        if ($query) {
            ///// hay un lote en proceso
            return response()->json(['success' => false, 'nota' => 'Disculpe el Lote No.'.$query->id_lote_papel.' esta "En Proceso", para emitir otro lote de papel de seguridad debe culminar el proceso pendiente. ']);
        }else{
            ///no hay lote en proceso
            $user = auth()->id();

            $desde = '';
            $hasta = '';

            $consulta = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->first();
            if ($consulta->total != 0) {
                //////ya se han emitido 
                $query =  DB::table('emision_papel_tfes')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
                $desde = $query->hasta + 1;
            }else{
                /////primer lote a emitir
                //////consultar cual es el inicio de correlativo
                $con_inicio = DB::table('configuraciones')->select("valor")->where('correlativo','=',3)->first(); //// 3 => inicio correlativo
                $desde = $con_inicio->valor;
            }

            $c1 =  DB::table('configuraciones')->select('valor')->where('correlativo','=',2)->first(); //// 2 => cant. timbres tfe14 por lote 
            $cant_timbres_lote = $c1->valor;
            $hasta = ($desde + $cant_timbres_lote) - 1;
            
            $insert_emision = DB::table('emision_papel_tfes')->insert([
                                            'key_user' => $user,
                                            'key_proveedor' => $id_proveedor,
                                            'cantidad_timbres' => $cant_timbres_lote,
                                            'desde' => $desde,
                                            'hasta' => $hasta,
                                            'estado' => 18,
                                            'asignados' => 0]);  
            if ($insert_emision) {
                $id_emision = DB::table('emision_papel_tfes')->max('id_lote_papel');
                $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
                $letra_papel = $c2->valor;

                    
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                $tr = '<tr>
                            <td>#</td>
                            <td>'.$letra_papel.'-'.$formato_desde.'</td>
                            <td>'.$letra_papel.'-'.$formato_hasta.'</td>
                        </tr>';
                
                
                

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-collection fs-2 text-muted me-2"></i>
                                <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Emisión Papel de Seguridad</span></h1>
                                <h1 class="fs-6 fw-bold text-muted">TFE-14</h1>
                            </div>
                        </div>
                        <div class="modal-body px-5 py-3" style="font-size:13px">
                            <p class="text-justify fw-semibold">*NOTA: El lote en emisión tiene un total de '.$cant_timbres_lote.' Trimbres Fiscales TFE-14.</p>
                        
                            <div class="">
                                <table class="table text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                    '.$tr.'
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mb-3">
                                <a href="'.route("emision_papel").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                <a href="'.route("papel.pdf_tfes", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                            </div>
                        </div>';
                return response()->json(['success' => true, 'html' => $html]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }


    public function pdf_tfes(Request $request)
    {
        $emision = $request->emision;
        // $dia = date('d');
        // $mes = date('m');
        // $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('emision_papel_tfes')->where('id_lote_papel', '=', $emision)->first();
        $c = 0;

        $desde = $query->desde;
        $hasta = $query->hasta;

        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

        $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
        $letra_papel = $c2->valor;

        $array = array(
                    'id' => 1,
                    'desde' => $letra_papel.''.$formato_desde,
                    'hasta' => $letra_papel.''.$formato_hasta
                );
        $a = (object) $array;
        array_push($correlativo,$a);

        

        $pdf = PDF::loadView('pdfLotePapelTfes', compact('correlativo'));

        return $pdf->download('Lote_TFE14_ID'.$emision.'.pdf');

    }


    public function delete_f14(Request $request){
        $id_lote = $request->post('lote'); 

        $delete = DB::table('emision_papel_tfes')->where('id_lote_papel', '=', $id_lote)->delete();
        if ($delete) {
            ///////////INCLUIR BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

    }


    public function enviar_inv_f14(Request $request){
        $id_lote = $request->post('lote'); 

        $hoy = date('Y-m-d');
        $update = DB::table('emision_papel_tfes')->where('id_lote_papel', '=', $id_lote)->update(['fecha_entrega' => $hoy, 'estado' => 1]);
        if ($update) {
            //////BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    public function detalle_f14(Request $request){
        $id_lote = $request->post('lote'); 

        $query =  DB::table('emision_papel_tfes')->join('proveedores', 'emision_papel_tfes.key_proveedor','=','proveedores.id_proveedor')
                                                        ->join('users', 'emision_papel_tfes.key_user','=','users.id')
                                                        ->select('emision_papel_tfes.*','users.key_sujeto','proveedores.razon_social','proveedores.condicion_identidad','proveedores.nro_identidad')
                                                        ->where('emision_papel_tfes.id_lote_papel','=',$id_lote)
                                                        ->first();
        
        $fecha_entrega = '';
        if ($query->fecha_entrega == null) {
            $fecha_entrega = '<span class="text-secondary">Sin recibir</span>';
        }else{
            $fecha_entrega = $query->fecha_entrega;
        }

        $q2 = DB::table('funcionarios')->select('nombre','cargo')->where('id_funcionario', '=',$query->key_sujeto)->first();

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-detail fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy" id="">Detalles del Lote | <span class="text_muted">Papel de Seguridad</span></h1>
                        <h5 class="fs-6 fw-bold text-muted">TFE-14</h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <div class="d-flex justify-content-center mt-2">
                        <table class="table w-75 ">
                            <tbody>
                            <tr>
                                <th>ID Lote</th>
                                <td class="text-secondary" colspan="2">'.$query->id_lote_papel.'</td>
                            </tr>
                            <tr>
                                <th>Fecha de Emisión</th>
                                <td colspan="2">'.$query->fecha_emision.'</td>
                            </tr>
                            <tr>
                                <th>Fecha de Entrega</th>
                                <td colspan="2">
                                    '.$fecha_entrega.'
                                </td>
                            </tr>
                            <tr>
                                <th>Emitido Por:</th>
                                <td colspan="2">
                                    <div class="d-flex flex-column text-muted">
                                        <span class="">
                                            USER
                                            <span class="badge bg-primary-subtle text-primary-emphasis ms-2">'.$q2->cargo.'</span>
                                        </span>
                                        <span class="text-navy fw-bold">'.$q2->nombre.'</span>  
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Proveedor</th>
                                <td colspan="2">
                                    <div class="d-flex flex-column">
                                        <span class="text-navy fw-bold">'.$query->razon_social.'
                                        </span>
                                        <span class="text-secondary">'.$query->condicion_identidad.'-'.$query->nro_identidad.'</span>  
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th>Cantidad de Timbres Fiscales</th>
                                <td class="text-navy fw-bold" colspan="2">'.$query->cantidad_timbres.' und.</td>
                            </tr>
                            <tr>
                                <th>Reporte Planilla</th>
                                <td colspan="2">
                                    <a target="_blank" class="ver_pago" href="'.route("papel.pdf_tfes", ["emision" => $id_lote]).'">Ver</a>
                                </td>
                            </tr>
                            
                            <tr class="text-center">
                                <th colspan="3" class="text-muted">
                                    Correlativo
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            <tr class="text-center">
                                <td>#</td>
                                <td>'.$query->desde.'</td>
                                <td>'.$query->hasta.'</td>
                            </tr>
                           
                        </tbody></table>
                    </div>

                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>';

        return response($html);

    }


    // ESTAMPILLAS /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function modal_estampillas()
    {
        $options = '';
        $desde = '';
        $hasta = '';

        $consulta = DB::table('emision_papel_estampillas')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido 
            $query =  DB::table('emision_papel_estampillas')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
            $desde = $query->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }

        $c1 =  DB::table('configuraciones')->select('valor')->where('correlativo','=',5)->first(); //// 5 => cant. timbres estampillas por lote 
        $cant_timbres_lote = $c1->valor;
        $hasta = ($desde + $cant_timbres_lote) - 1;

        $query_2 =  DB::table('proveedores')->select('id_proveedor','condicion_identidad','nro_identidad','razon_social')->get();
        foreach ($query_2 as $q2) {
            $options .= '<option value="'.$q2->id_proveedor.'">'.$q2->condicion_identidad.''.$q2->nro_identidad.' - '.$q2->razon_social.'</option>';
        }
        
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión</h1>
                        <span>Papel de Seguridad | Estampillas</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-justify">*NOTA: Si el total de Papel de Seguridad para Estampillas a emitir es diferente al esperado o se ha cambiado la cantidad a producirse por emisión, ingrese al <span class="fw-bold">Módulo Configuraciones (Ajustes)</span> para cambiar el número total de Papel de Seguridad para Estampillas por emisión. 
                    </p>
                    
                    <div class="fw-bold text-center">
                        <p class="text-navy m-0">Total a Emitir</p>
                        <p class="fs-5 titulo fw-semibold text-muted">Papel de Seguridad | '.$cant_timbres_lote.' Estampillas</p>
                    </div>
                    

                    <div class="d-flex justify-content-center  mt-4 mb-2">
                        <table class="table table-borderess w-50">
                            <tr>
                                <th>Desde:</th>
                                <td>'.$desde.'</td>
                            </tr>
                            <tr>
                                <th>Hasta:</th>
                                <td>'.$hasta.'</td>
                            </tr>
                        </table>
                    </div>

                    <form id="form_emitir_papel_estampillas" method="post" onsubmit="event.preventDefault(); emitirPapelEstampillas()">
                        <div class=" px-2">
                            <label for="proveedor" class="form-label">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" name="proveedor" id="proveedor" aria-label="Small select example">
                                '.$options.'
                            </select>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);
    }


    public function emitir_estampillas(Request $request)
    {
        $id_proveedor = $request->post('proveedor'); 
        $query = DB::table('emision_papel_estampillas')->select('id_lote_papel')->where('estado', '=', 18)->first();
        if ($query) {
            ///// hay un lote en proceso
            return response()->json(['success' => false, 'nota' => 'Disculpe el Lote No.'.$query->id_lote_papel.' esta "En Proceso", para emitir otro lote de papel de seguridad debe culminar el proceso pendiente. ']);
        }else{
            ///no hay lote en proceso
            $user = auth()->id();

            $desde = '';
            $hasta = '';

            $consulta = DB::table('emision_papel_estampillas')->selectRaw("count(*) as total")->first();
            if ($consulta->total != 0) {
                //////ya se han emitido 
                $query =  DB::table('emision_papel_estampillas')->select('hasta')->orderBy('id_lote_papel', 'desc')->first();
                $desde = $query->hasta + 1;
            }else{
                /////primer lote a emitir
                $desde = 1;
            }

            $c1 =  DB::table('configuraciones')->select('valor')->where('correlativo','=',5)->first(); //// 5 => cant. timbres tfe14 por lote 
            $cant_timbres_lote = $c1->valor;
            $hasta = ($desde + $cant_timbres_lote) - 1;
            
            $insert_emision = DB::table('emision_papel_estampillas')->insert([
                                            'key_user' => $user,
                                            'key_proveedor' => $id_proveedor,
                                            'cantidad_timbres' => $cant_timbres_lote,
                                            'desde' => $desde,
                                            'hasta' => $hasta,
                                            'estado' => 18,
                                            'emitidos' => 0]);  
            if ($insert_emision) {
                $id_emision = DB::table('emision_papel_estampillas')->max('id_lote_papel');
                $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
                $letra_papel = $c2->valor;

                    
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                $tr = '<tr>
                            <td>#</td>
                            <td>'.$letra_papel.'-'.$formato_desde.'</td>
                            <td>'.$letra_papel.'-'.$formato_hasta.'</td>
                        </tr>';
                
                
                

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-collection fs-2 text-muted me-2"></i>
                                <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Emisión Papel de Seguridad</span></h1>
                                <h1 class="fs-6 fw-bold text-muted">Estampillas</h1>
                            </div>
                        </div>
                        <div class="modal-body px-5 py-3" style="font-size:13px">
                            <p class="text-justify">*NOTA: El lote en emisión tiene un total de '.$cant_timbres_lote.' Estampillas.</p>
                        
                            <div class="">
                                <table class="table text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                    '.$tr.'
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mb-3">
                                <a href="'.route("emision_papel").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                <a href="'.route("papel.pdf_estampillas", ["emision" => $id_emision]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                            </div>
                        </div>';
                return response()->json(['success' => true, 'html' => $html]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }


    public function pdf_estampillas(Request $request)
    {
        $emision = $request->emision;
        // $dia = date('d');
        // $mes = date('m');
        // $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('emision_papel_estampillas')->where('id_lote_papel', '=', $emision)->first();
        $c = 0;

        $desde = $query->desde;
        $hasta = $query->hasta;

        $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
        $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

        $c2 =  DB::table('variables')->select('valor')->where('variable','=','letra_correlativo_papel_tfes')->first();
        $letra_papel = $c2->valor;

        $array = array(
                    'id' => 1,
                    'desde' => $letra_papel.''.$formato_desde,
                    'hasta' => $letra_papel.''.$formato_hasta
                );
        $a = (object) $array;
        array_push($correlativo,$a);

        

        $pdf = PDF::loadView('pdfLotePapelEstampillas', compact('correlativo'));

        return $pdf->download('Lote_Estampillas_ID'.$emision.'.pdf');

    }


    public function delete_estampillas(Request $request){
        $id_lote = $request->post('lote'); 

        $delete = DB::table('emision_papel_estampillas')->where('id_lote_papel', '=', $id_lote)->delete();
        if ($delete) {
            ///////////INCLUIR BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    public function enviar_inv_estampillas(Request $request){
        $id_lote = $request->post('lote'); 

        $hoy = date('Y-m-d');
        $update = DB::table('emision_papel_estampillas')->where('id_lote_papel', '=', $id_lote)->update(['fecha_entrega' => $hoy, 'estado' => 1]);
        if ($update) {
            //////BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    public function detalle_estampillas(Request $request){
        $id_lote = $request->post('lote'); 

        $query =  DB::table('emision_papel_estampillas')->join('proveedores', 'emision_papel_estampillas.key_proveedor','=','proveedores.id_proveedor')
                                                        ->join('users', 'emision_papel_estampillas.key_user','=','users.id')
                                                        ->select('emision_papel_estampillas.*','users.key_sujeto','proveedores.razon_social','proveedores.condicion_identidad','proveedores.nro_identidad')
                                                        ->where('emision_papel_estampillas.id_lote_papel','=',$id_lote)
                                                        ->first();
        
        $fecha_entrega = '';
        if ($query->fecha_entrega == null) {
            $fecha_entrega = '<span class="text-secondary">Sin recibir</span>';
        }else{
            $fecha_entrega = $query->fecha_entrega;
        }

        $q2 = DB::table('funcionarios')->select('nombre','cargo')->where('id_funcionario', '=',$query->key_sujeto)->first();

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-detail fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy" id="">Detalles del Lote | <span class="text_muted">Papel de Seguridad</span></h1>
                        <h5 class="fs-6 fw-bold text-muted">Estampillas</h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <div class="d-flex justify-content-center mt-2">
                        <table class="table w-75 ">
                            <tbody>
                            <tr>
                                <th>ID Lote</th>
                                <td class="text-secondary" colspan="2">'.$query->id_lote_papel.'</td>
                            </tr>
                            <tr>
                                <th>Fecha de Emisión</th>
                                <td colspan="2">'.$query->fecha_emision.'</td>
                            </tr>
                            <tr>
                                <th>Fecha de Entrega</th>
                                <td colspan="2">
                                    '.$fecha_entrega.'
                                </td>
                            </tr>
                            <tr>
                                <th>Emitido Por:</th>
                                <td colspan="2">
                                    <div class="d-flex flex-column text-muted">
                                        <span class="">
                                            USER
                                            <span class="badge bg-primary-subtle text-primary-emphasis ms-2">'.$q2->cargo.'</span>
                                        </span>
                                        <span class="text-navy fw-bold">'.$q2->nombre.'</span>  
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Proveedor</th>
                                <td colspan="2">
                                    <div class="d-flex flex-column">
                                        <span class="text-navy fw-bold">'.$query->razon_social.'
                                        </span>
                                        <span class="text-secondary">'.$query->condicion_identidad.'-'.$query->nro_identidad.'</span>  
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th>Cantidad de Papel para Estampillas</th>
                                <td class="text-navy fw-bold" colspan="2">'.$query->cantidad_timbres.' und.</td>
                            </tr>
                            <tr>
                                <th>Reporte Planilla</th>
                                <td colspan="2">
                                    <a target="_blank" class="ver_pago" href="'.route("papel.pdf_estampillas", ["emision" => $id_lote]).'">Ver</a>
                                </td>
                            </tr>
                            
                            <tr class="text-center">
                                <th colspan="3" class="text-muted">
                                    Correlativo
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                            </tr>
                            <tr class="text-center">
                                <td>#</td>
                                <td>'.$query->desde.'</td>
                                <td>'.$query->hasta.'</td>
                            </tr>
                           
                        </tbody></table>
                    </div>

                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>';

        return response($html);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
