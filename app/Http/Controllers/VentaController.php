<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use DB;
class VentaController extends Controller
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
        $entes = DB::table('entes')->select('id_ente','ente')->get();
        $tramites = DB::table('tramites')->select('id_tramite','tramite')->where('key_ente','=',1)->get();
        $q1 =  DB::table('ucds')->select('valor','moneda')->orderBy('id', 'desc')->first();
        $ucd = $q1->valor;
        $ucd_hoy = number_format($ucd, 2, ',', '.');
        $moneda = $q1->moneda;
        return view('venta', compact('entes','tramites','ucd_hoy','ucd','moneda'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function search(Request $request)
    {
        $value = $request->post('value');
        $condicion = $request->post('condicion');
        $condicion_sujeto = $request->post('condicion_sujeto');
        // return response($condicion);
        $query = DB::table('contribuyentes')->select('nombre_razon')
                                            ->where('condicion_sujeto','=', $condicion_sujeto)
                                            ->where('identidad_condicion','=', $condicion)
                                            ->where('identidad_nro','=', $value)
                                            ->first();
        if($query){
            return response()->json(['success' => true, 'nombre' => $query->nombre_razon]);
        }else{
            return response()->json(['success' => false]);
        }
    }


    public function add_contribuyente(Request $request)
    {
        $condicion_sujeto = $request->post('condicion_sujeto');
        $condicion = $request->post('condicion');
        $nro = $request->post('nro');
        $nombre = $request->post('nombre');

        if (empty($nro) || empty($nombre)) {
            return response()->json(['success' => false, 'nota' => 'Por favor, complete los campos C.I/R.I.F y Nombre/Razon Social.']);
        }elseif(empty($condicion_sujeto)){
            return response()->json(['success' => false, 'nota' => 'Por favor, seleccione la condición del contribuyente.']);
        }else{
            $campos_nro = strlen($nro);
            if ($campos_nro < 6) {
                return response()->json(['success' => false, 'nota' => 'Por favor, introduzca un C.I/R.I.F válido.']);
            }else{
                $contribuyente = DB::table('contribuyentes')->insert([
                                            'condicion_sujeto' => $condicion_sujeto,
                                            'identidad_condicion' => $condicion,
                                            'identidad_nro' => $nro,
                                            'nombre_razon' => $nombre]);
                if ($contribuyente) {
                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false]);
                }
            }
        }
       
    }



    public function update_inv_taquilla(){
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            /// usuario taquillero
            $id_taquilla = $q2->id_taquilla;

            $hoy = date('Y-m-d');
            $hora = date('H:i:s');

            // ACTUALIZCION DEL INVENTARIO DE TAQUILLA (ESTAMPILLAS Y TFES)
            $upd_1 = DB::table('inv_est_taq_temps')->select('fecha')->where('key_taquilla', '=', $id_taquilla)->first();
            $upd_2 = DB::table('inv_tfe_taq_temps')->select('fecha')->where('key_taquilla', '=', $id_taquilla)->first();
                                                                
            if ($upd_1->fecha == $hoy && $upd_2->fecha == $hoy) {
                // INVENTARO ESTAMPILLAS TAQUILLA
                $q3 = DB::table('ucd_denominacions')->select('id','denominacion')->where('estampillas','=','true')->get();
                foreach ($q3 as $key) {
                    $key_deno = $key->id;
                    $deno = $key->denominacion;

                    $cant_inv = 0;

                    $c1 = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')
                                                                    ->where('key_taquilla','=',$id_taquilla)
                                                                    ->where('key_denominacion','=',$key_deno)
                                                                    ->where('condicion','!=',7)->get(); 
                                                                    // return response($c1);
                    if ($c1) {
                        foreach ($c1 as $value) {
                            $cant_inv = $cant_inv + ($value->cantidad_timbres - $value->vendido);
                        }
                    }else{
                        $cant_inv = 0;
                    }
                    

                    switch ($key_deno) {
                        case 1:
                            # 1 UCD
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['one_ucd' => $cant_inv]);
                            break;
                        case 2:
                            # 2 UCD
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['two_ucd' => $cant_inv]);
                            break;
                        case 3:
                            # 3 UCD
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['three_ucd' => $cant_inv]);
                            break;
                        case 4:
                            # 5 UCD
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['five_ucd' => $cant_inv]);
                            break;
                        case 15:
                            # 20 UT
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['twenty_ut' => $cant_inv]);
                            break;
                        case 16:
                            # 50 UT
                            $upd_inv = DB::table('inv_est_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                                    ->where('fecha','=', $hoy)
                                                                    ->update(['fifty_ut' => $cant_inv]);
                            break;
                        default:
                            # code...
                            break;
                    }
                }

                // INVENTARIO TFES TAQUILLA
                $cant_tfe = 0;
                $c2 = DB::table('inventario_tfes')->select('cantidad_timbres','vendido')
                                                    ->where('key_taquilla','=',$id_taquilla)
                                                    ->where('condicion','!=',7)->get();
                if ($c2) {
                    foreach ($c2 as $value) {
                        $cant_tfe = $cant_tfe + ($value->cantidad_timbres - $value->vendido);
                    }
                }else{
                    $cant_tfe = 0;
                }
                

                $upd_inv_tfe = DB::table('inv_tfe_taq_temps')->where('key_taquilla', '=', $id_taquilla)
                                                        ->where('fecha','=', $hoy)
                                                        ->update(['cantidad' => $cant_tfe]);



                $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $id_taquilla)
                                                        ->where('fecha','=', $hoy)
                                                        ->update(['apertura_taquillero' => $hora]);
                if ($update) {
                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, la taquilla no ha sido aperturada.']);
            }
            
        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false, 'nota' => 'Disculpe, usted no se encuentra asociado a ninguna taquilla.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function ucd_tramite(Request $request)
    {
        $value = $request->post('value');
        $condicion_sujeto = $request->post('condicion_sujeto');

        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
            //////juridico (firma personal - empresa)
            $query = DB::table('tramites')->select('juridico')->where('id_tramite','=', $value)->first();
            if ($query) {
                return response()->json(['success' => true, 'valor' => $query->juridico]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            ////natural
            $query = DB::table('tramites')->select('natural')->where('id_tramite','=', $value)->first();
            if ($query) {
                return response()->json(['success' => true, 'valor' => $query->natural]);
            }else{
                return response()->json(['success' => false]);
            }
        }
        
    }


    public function tramites(Request $request)
    {
        $value = $request->post('value');
        $query = DB::table('tramites')->select('tramite','id_tramite')->where('key_ente','=', $value)->get();
        $option = '<option value="">Seleccione el tramite </option>';
        foreach ($query as $key) {
            $option .= '<option value="'.$key->id_tramite.'">'.$key->tramite.'</option>';
        }

        return response($option);
    }



    public function folios(Request $request){
        $no_folios = $request->post('value');
        $q1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();

        $total = $no_folios * $q1->natural;
        return response($total);
    }



    public function estampillas(Request $request)
    {
        $user = auth()->id();
        $alicuota = '';

        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2){
            $id_taquilla = $q2->id_taquilla;

            $tramite = $request->post('tramite');
            $condicion_sujeto = $request->post('condicion_sujeto');
            $nro = $request->post('nro');
            $folios = $request->post('folios');

            $total_ucd = '';
            $options = '<option value="Seleccione">Seleccione</option>';

            // PRECIO TRAMITE
            $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
            if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                //////juridico (firma personal - empresa)
                $total_ucd = $query->juridico;
            }else{
                ////natural
                $total_ucd = $query->natural;
            }

            ////SI HAY FOLIOS
            if ($tramite == 1) {
                $c1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
                $total_ucd = $total_ucd + ($c1->natural * $folios);
            }


            // CONSULTA INVENTARIO
            ////comprobar si corresponse UT o UCD
            $con = DB::table('inventario_ut_estampillas')->select('cantidad_timbres','asignado','key_denominacion')->get();
            $total_dispo = 0;

            foreach ($con as $value) {
                $total_dispo = $total_dispo + ($value->cantidad_timbres - $value->asignado);
            }

            $q1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=', $id_taquilla)->first();

            if ($total_dispo == 0) {
                $alicuota = 7;
                $html_inventario = '<div class="text-center text-muted titulo fs-6 mb-2">Inventario de Estampillas</div>
                            <div class="d-flex flex-column">
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">1 U.C.D.</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->one_ucd.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">2 U.C.D.</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->two_ucd.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">3 U.C.D.</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->three_ucd.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">5 U.C.D.</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->five_ucd.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                            </div>';
            }else{
                $alicuota = 19;
                //// VALOR UT 
                $con_valor_ut = DB::table('configuraciones')->select('valor')->where('nombre','=','Precio U.T.')->first();
                $precio_20 = number_format((20 * $con_valor_ut->valor), 2, ',', '.');
                $precio_50 = number_format((50 * $con_valor_ut->valor), 2, ',', '.');

                $html_inventario = '<div class="text-center text-muted titulo fs-6 mb-2">Inventario de Estampillas</div>
                            <div class="d-flex flex-column">
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">20 U.T.</div>
                                        <div class="fw-semibold text-secondary" style="font-style:12.4px">'.$precio_20.'Bs. c/u</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->twenty_ut.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                                <div class="mb-2 border py-2 px-3 rounded-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="fs-6 titulo text-muted fw-bold">50 U.T.</div>
                                        <div class="fw-semibold text-secondary" style="font-style:12.4px">'.$precio_50.'Bs. c/u</div>
                                        <div class="fw-bold bg-secondary-subtle text-center rounded-3 px-2 mb-1">'.$q1->fifty_ut.' <span class="">Und.</span></div>
                                    </div>
                                </div>
                            </div>';
            }

            

            // OPTION UCD ESTAMPILLAS  
            $q2 = DB::table('ucd_denominacions')->join('tipos', 'ucd_denominacions.alicuota', '=','tipos.id_tipo')
                                                ->select('ucd_denominacions.id','ucd_denominacions.denominacion','tipos.nombre_tipo')
                                                ->where('ucd_denominacions.estampillas','=', 'true')
                                                ->where('ucd_denominacions.alicuota','=', $alicuota)->get();
            foreach ($q2 as $key) {
                $options .= '<option value="'.$key->id.'">'.$key->denominacion.' '.$key->nombre_tipo.'</option>';
            }

            ///PRECIO UCD HOY
            $con_ucd =  DB::table('ucds')->select('valor','moneda')->orderBy('id', 'desc')->first();
            $ucd_bs = $con_ucd->valor * $total_ucd;
            $format_ucd_bs = number_format($ucd_bs, 2, ',', '.');

            // HTML
            $html = '<div class="modal-header p-2 pt-3">
                        <div class=" d-flex align-items-center">
                            <i class="bx bx-receipt fs-4 mx-2 text-secondary"></i>
                            <h1 class="modal-title fs-5 fw-bold text-muted">Detalle Estampillas</h1>
                        </div>
                    </div>
                    <div class="modal-body px-5" style="font-size:13px">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                '.$html_inventario.'
                            </div>
                            <div class="col-sm-8">
                                <div class="titulo fw-bold fs-4 text-center"><span class="text-muted me-2">Total</span> '.$total_ucd.' U.C.D.</div>
                                <div class="fs-6 text-center text-muted">Bolívares '.$format_ucd_bs.' Bs.</div>
                                <form id="form_detalle_est" method="post" onsubmit="event.preventDefault(); detalleEst()">
                                    <p class="text-muted mt-2"><span class="text-danger">*</span> Ingrese las estampillas que se utilizaran para la venta.</p>
                                    <div id="content_detalle_est">
                                        <div class="d-flex justify-content-center pb-1">
                                            <div class="row">
                                                <div class="col-5">
                                                    <label class="form-label" for="ucd_est">Estampilla</label><span class="text-danger">*</span>
                                                    <select class="form-select form-select-sm ucd_est" aria-label="Small select example"id="ucd_est_1" nro="1" name="detalle[1][ucd]" required>
                                                        '.$options.'
                                                    </select>
                                                </div>
                                                <div class="col-5">
                                                    <label class="form-label" for="cant_est">Cantidad</label><span class="text-danger">*</span>
                                                    <input type="number" class="form-control form-control-sm cant_est" id="cant_est_1" nro="1" name="detalle[1][cantidad]"  required>
                                                </div>
                                                <div class="col-sm-1 pt-4">
                                                    <a  href="javascript:void(0);" class="btn add_button_estampilla border-0">
                                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="taquilla" value="'.$id_taquilla.'">
                                    <input type="hidden" name="tramite" value="'.$tramite.'">
                                    <input type="hidden" name="condicion_sujeto" value="'.$condicion_sujeto.'">
                                    <input type="hidden" name="nro" value="'.$nro.'">
                                    <input type="hidden" name="folios" value="'.$folios.'">
                                    <input type="hidden" name="alicuota" value="'.$alicuota.'">

                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                        <button type="submit" class="btn btn-success btn-sm me-3">Aceptar</button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="btn_cancelar_detalle_est" nro="'.$nro.'" data-bs-dismiss="modal">Cancelar</button>
                                    </div> 
                                </form>
                            </div>
                        </div>                    
                    </div>';

            return response($html);


        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            return response()->json(['success' => false]);
        }
        

    }



    public function est_detalle(Request $request)
    {
        $id_taquilla = $request->post('taquilla');
        $detalle = $request->post('detalle'); 
        $tramite = $request->post('tramite');
        $condicion_sujeto = $request->post('condicion_sujeto');
        $nro = $request->post('nro');
        $folios = $request->post('folios');

        $alicuota = $request->post('alicuota');

        // BUSCAR PRECIO TRAMITE
        $total_ucd = 0;
        $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
            //////juridico (firma personal - empresa)
            $total_ucd = $query->juridico;
        }else{
            ////natural
            $total_ucd = $query->natural;
        }

        ////SI HAY FOLIOS
        if ($tramite == 1) {
            $c1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
            $total_ucd = $total_ucd + ($c1->natural * $folios);
        }


        // COMPROBAR QUE SUMADOS DE EL MONTO TOTAL
        $total_ucd_detalle = 0;
        $total_bs_ut = 0;

        ///total bs ucd
        $con_ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $total_bs_est = $total_ucd * $con_ucd->valor;

        if ($alicuota == 7) {
            ////UCD
            foreach ($detalle as $key) {
                $ucd = $key['ucd'];
                $cant = $key['cantidad'];
                if ($ucd == 4) {
                    $ucd = 5;
                }
                $total_ucd_detalle = $total_ucd_detalle + ($ucd * $cant);
            }
        }else{
            ////UT
            $con_valor_ut = DB::table('configuraciones')->select('valor')->where('nombre','=','Precio U.T.')->first();
            foreach ($detalle as $key) {
                $ucd = $key['ucd'];
                $cant = $key['cantidad'];
                
                if ($ucd == 15) {
                    $precio_ind = 20 * $con_valor_ut->valor;
                }elseif ($ucd == 16) {
                    $precio_ind = 50 * $con_valor_ut->valor;
                }

                $total_bs_ut = $total_bs_ut + ($precio_ind * $cant);
            }
        }

        ////
        // return response($total_bs_ut);
        if ($alicuota == 7){
            if ($total_ucd_detalle != $total_ucd) {
                return response()->json(['success' => false, 'nota' => 'Disculpe, el Total del Tramite es '.$total_ucd.' U.C.D.']);
            }
        }else{
            if ($total_bs_ut < $total_bs_est){
                return response()->json(['success' => false, 'nota' => 'Disculpe, el Total del Tramite es '.$total_ucd.' U.C.D.']);
            }
        }
        ////
        

        
        //  COMPROBAR DISPONIBILIDAD
        $q1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=', $id_taquilla)->first();
        foreach ($detalle as $value) {
            $ucd = $value['ucd'];
            $cant = $value['cantidad'];

            switch ($ucd) {
                case 1:
                    if ($q1->one_ucd < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 1 U.C.D., en su Inventario.']);
                    }
                    break;
                case 2:
                    if ($q1->two_ucd < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 2 U.C.D., en su Inventario.']);
                    }
                    break;
                case 3:
                    if ($q1->three_ucd < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 3 U.C.D., en su Inventario.']);
                    }
                    break;
                case 4:
                    if ($q1->five_ucd < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 5 U.C.D., en su Inventario.']);
                    }
                case 15:
                    if ($q1->twenty_ut < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 20 U.T., en su Inventario.']);
                    }
                case 16:
                    if ($q1->fifty_ut < $cant) {
                        return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de 50 U.T., en su Inventario.']);
                    }
                    break;    
                default:
                    return response()->json(['success' => false]);
                    break;
            }  
        }



        // ACTUALIZO EL INV TEMP DE LA TAQUILLA
        foreach ($detalle as $detal) {
            $ucd = $detal['ucd'];
            $cant = $detal['cantidad'];

            switch ($ucd) {
                case 1:
                    $new_inv = $q1->one_ucd - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['one_ucd' => $new_inv]);
                    break;
                case 2:
                    $new_inv = $q1->two_ucd - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['two_ucd' => $new_inv]);
                    break;
                case 3:
                    $new_inv = $q1->three_ucd - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['three_ucd' => $new_inv]);
                    break;
                case 4:
                    $new_inv = $q1->five_ucd - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['five_ucd' => $new_inv]);
                    break; 
                case 15:
                    $new_inv = $q1->twenty_ut - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['twenty_ut' => $new_inv]);
                    break;   
                case 16:
                    $new_inv = $q1->fifty_ut - $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['fifty_ut' => $new_inv]);
                    break;      
                default:
                    return response()->json(['success' => false]);
                    break;
            }
        }

        $input = base64_encode(serialize($detalle));
        return response()->json(['success' => true, 'detalle' => $input, 'nro' => $nro]);

        
       
    }



    public function agregar(Request $request){
        $tramite = $request->post('tramite');
        // $alicuota = $request->post('alicuota');
        // return response($alicuota);

        if ($tramite['forma'] == 'Seleccione' || $tramite['forma'] == '') {
            return response()->json(['success' => false, 'nota' => 'Debe seleccionar la Forma.']);
        }else{
            $ucd = $request->post('total_ucd');
            $bs = $request->post('total_bs');
            $nro = $request->post('nro');

            $condicion_sujeto = $request->post('condicion_sujeto');
            $identidad_condicion = $request->post('identidad_condicion');
            $identidad_nro = $request->post('identidad_nro');

            $contribuyente = ([
                'condicion_sujeto' => $condicion_sujeto,
                'identidad_condicion' => $identidad_condicion,
                'identidad_nro' => $identidad_nro,
            ]);
            $input_contribuyente = base64_encode(serialize($contribuyente));

            //////////////////////////////////// CALCULAR TOTALES
            $q_ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
            $valor_ucd = $q_ucd->valor;
            $total_ucd = 0; 
            $total_bolivares = 0;

            $ali_tramite = '';
            $anexo = '';
            $nombre_tramite = '';

            if ($tramite != '') { 
                $query = DB::table('tramites')->where('id_tramite','=', $tramite['tramite'])->first();
                $nombre_tramite = $query->tramite;
                switch ($query->alicuota) {
                    case 7:
                        // UCD
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $ucd_tramite = $query->juridico;
                        }else{
                            ////natural
                            $ucd_tramite = $query->natural;
                        }
                        
                        $total_ucd = $total_ucd + $ucd_tramite;
                        $anexo = '<span class="text-muted fst-italic">No aplica</span>';

                        //////SI ES PROTOCOLIZACIÓN Y TIENE FOLIOS ADICIONALES
                        if($tramite['tramite'] == 1){
                            $folios = $request->post('folios');
                            if ($folios != 0 || $folios != '' || $folios != null) {
                                $q1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
                                $total_ucd = $total_ucd + ($folios * $q1->natural);

                                $anexo = '<span class="text-muted fst-italic">+ '.$folios.' Folios ('.$q1->natural.' UCD c/u)</span>';
                            }else{
                                '<span class="text-muted fst-italic">Sin Folios anexos</span>';
                            }
                        }
                        $ali_tramite = '<span class="">'.$total_ucd.' UCD</span>';

                        break;
                    case 8:
                        // PORCENTAJE
                        $capital = $request->post('capital');
                        if (!empty($capital)) {
                            // hay capital
                            $bs_tramite = ($capital * $query->porcentaje) / 100;
                            
                        }else{
                            // no hay capital
                            $bs_tramite = 0;
                        } 

                        $total_bolivares = $total_bolivares + $bs_tramite;
                        $bolivares_tramite_format = number_format($total_bolivares, 2, ',', '.');
                        $capital_format = number_format($capital, 2, ',', '.');

                        $ali_tramite = '<span class="">'.$bolivares_tramite_format.' Bs.</span>';
                        $anexo = '<span class="text-muted fst-italic">Capital: '.$capital_format.' Bs.</span>';

                        break;
                    case 13:
                        // METRADO
                        $metros = $request->post('metros');
                        if (!empty($metros)) {
                            // hay metros
                            if ($metros == '' || $metros == 0) {
                                $ucd_tramite = 0;
                            }else{
                                if ($metros <= 150) {
                                    ////pequeña
                                    $ucd_tramite = $query->small;
                                }elseif ($metros > 150 && $metros < 400) {
                                    /////mediana
                                    $ucd_tramite = $query->medium;
                                }elseif ($metros >= 400) {
                                    /////grande
                                    $ucd_tramite = $query->large;
                                }
                            }
                        }else{
                            // no hay metros
                            $ucd_tramite = 0;
                        } 
                        $total_ucd = $total_ucd + $ucd_tramite;

                        $ali_tramite = '<span class="">'.$total_ucd.' UCD</span>';
                        $anexo = '<span class="text-muted fst-italic">'.$metros.' mt2.</span>';
                        break;
                            
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Debe seleccionar el Tramite.']);
            }
        

            $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
            $total_bolivares_format = number_format($total_bolivares, 2, ',', '.');
            ///////////////////////////////////


            // INPUT CON INFO
            $detalle_tramite = ([
                        'tramite' => $tramite['tramite'],
                        'metros' => $request->post('metros'),
                        'capital' => $request->post('capital'),
                        'nro_folios' => $request->post('folios'),
                        'forma' => $tramite['forma'],
                        'detalle_est' => $tramite['detalle'],
                        'condicion_sujeto' => $condicion_sujeto,
            ]);
            $input = base64_encode(serialize($detalle_tramite));
            
            // //////////////////////////////// TR DE LA TABLA
            $span = '';
            if ($tramite['forma'] == 4) {
                $detalle = unserialize(base64_decode($tramite['detalle']));

                foreach ($detalle as $key) {
                    $key_ucd = $key['ucd'];
                    $key_cant = $key['cantidad'];
                    
                    $cu = DB::table('ucd_denominacions')
                    ->join('tipos', 'ucd_denominacions.alicuota', '=','tipos.id_tipo')
                    ->select('ucd_denominacions.denominacion','tipos.nombre_tipo')
                    ->where('ucd_denominacions.id','=', $key_ucd)->first();

                    for ($i=0; $i < $key_cant; $i++) { 
                        $span .= '<span>Est '.$cu->denominacion.' '.$cu->nombre_tipo.'</span>';
                    }
                }
            }else{
                $span = '<span>TFE-14</span>';
            }
        

            $tr = '<tr class="tr" id="tr_'.$nro.'">
                        <td>1</td>
                        <td>'.$nombre_tramite.'</td>
                        <td>
                            '.$anexo.'
                        </td>
                        <td>
                            '.$ali_tramite.'
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                '.$span.'
                            </div>
                            <input type="hidden" name="tramite['.$nro.']" class="tramite_in" id="tramite_'.$nro.'" value="'.$input.'">
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="btn remove_tramite" nro="'.$nro.'" tramite="'.$tramite['tramite'].'">
                                <i class="bx bx-x fs-4"></i>
                            </a>
                        </td>
                    </tr>';
            ///////////////////////////////////

            // SUMA DE NRO
            $nro++;
            
            // SUMA DE MONTOS (BS - UCD)
            // return response($ucd);
            $ucd = $ucd + $total_ucd;
            $bs = $bs + $total_bolivares;

            $format_bs_total = number_format($bs, 2, ',', '.');

            return response()->json(['success' => true, 'tr' => $tr, 'nro' => $nro, 'ucd' => $ucd, 'bs' => $bs, 'format_bs' => $format_bs_total,'contribuyente' => $input_contribuyente]);
            
        }

        
    }



    public function quitar(Request $request){
        $tramite = unserialize(base64_decode($request->post('tramite')));
        $ucd = $request->post('ucd');
        $bs = $request->post('bs');

        //////////////////////////////////// RESTAR NUMERO DE ESTAMPILLAS (SI LO AMERITA)
        $user = auth()->id();
        $q_u = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$q_u->key_sujeto)->first();
        $id_taquilla = $q2->id_taquilla;
        $detalle_est = unserialize(base64_decode($tramite['detalle_est']));
        

        if ($detalle_est != null) {
            foreach ($detalle_est as $detalle) {
                switch ($detalle['ucd']) {
                    case 1:
                        $con1 = DB::table('inv_est_taq_temps')->select('one_ucd')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->one_ucd;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['one_ucd' => $cant_new]);
                        break;
                    case 2:
                        $con1 = DB::table('inv_est_taq_temps')->select('two_ucd')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->two_ucd;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['two_ucd' => $cant_new]);
                        break;
                    case 3:
                        $con1 = DB::table('inv_est_taq_temps')->select('three_ucd')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->three_ucd;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['three_ucd' => $cant_new]);
                        break;
                    case 4:
                        $con1 = DB::table('inv_est_taq_temps')->select('five_ucd')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->five_ucd;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['five_ucd' => $cant_new]);
                        break;
                    case 15:
                        $con1 = DB::table('inv_est_taq_temps')->select('twenty_ut')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->twenty_ut;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['twenty_ut' => $cant_new]);
                        break;
                    case 16:
                        $con1 = DB::table('inv_est_taq_temps')->select('fifty_ut')->where('key_taquilla','=',$id_taquilla)->first();
                        $cant_inv = $con1->fifty_ut;

                        $cant_new = $cant_inv + $detalle['cantidad'];
                        $upt_1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['fifty_ut' => $cant_new]);
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }

        //////////////////////////////////// CALCULAR TOTALES
        $q_ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $q_ucd->valor;
        $total_ucd = 0; 
        $total_bolivares = 0;

        $query = DB::table('tramites')->where('id_tramite','=', $tramite['tramite'])->first();
        $condicion_sujeto = $tramite['condicion_sujeto'];

        switch ($query->alicuota) {
            case 7:
                // UCD
                if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                    //////juridico (firma personal - empresa)
                    $ucd_tramite = $query->juridico;
                }else{
                    ////natural
                    $ucd_tramite = $query->natural;
                }
                
                $total_ucd = $total_ucd + $ucd_tramite;

                //////SI ES PROTOCOLIZACIÓN Y TIENE FOLIOS ADICIONALES
                if($tramite['tramite'] == 1){
                    $folios = $tramite['nro_folios'];
                    if ($folios != 0 || $folios != '' || $folios != null) {
                        $q1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
                        $total_ucd = $total_ucd + ($folios * $q1->natural);
                    }
                }

                break;
            case 8:
                // PORCENTAJE
                $capital = $tramite['capital'];
                if (!empty($capital)) {
                    // hay capital
                    $bs_tramite = ($capital * $query->porcentaje) / 100;
                    
                }else{
                    // no hay capital
                    $bs_tramite = 0;
                } 
                $total_bolivares = $total_bolivares + $bs_tramite;

                break;
            case 13:
                // METRADO
                $metros = $tramite['metros'];
                if (!empty($metros)) {
                    // hay metros
                    if ($metros == '' || $metros == 0) {
                        $ucd_tramite = 0;
                    }else{
                        if ($metros <= 150) {
                            ////pequeña
                            $ucd_tramite = $query->small;
                        }elseif ($metros > 150 && $metros < 400) {
                            /////mediana
                            $ucd_tramite = $query->medium;
                        }elseif ($metros >= 400) {
                            /////grande
                            $ucd_tramite = $query->large;
                        }
                    }
                }else{
                    // no hay metros
                    $ucd_tramite = 0;
                } 
                $total_ucd = $total_ucd + $ucd_tramite;
                break;        
        }

        $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
        
        // RESTAR PRECIO A LOS TOTALES
        $ucd = $ucd - $total_ucd;
        $bs = $bs - $total_bolivares;
        
        
        $total_bolivares_format = number_format($bs, 2, ',', '.');
        
        return response()->json(['success' => true, 'ucd' => $ucd, 'bs' => $bs, 'format_bs' => $total_bolivares_format]);
    }



    public function alicuota(Request $request){
        $tramite = $request->post('tramite');
        $condicion_sujeto = $request->post('condicion_sujeto');
        $metros = $request->post('metros');
        $capital = $request->post('capital');
        
        $no_ali_metros = 0;
        $no_ali_porcentaje = 0;

        

        $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
        if ($query) {
            switch ($query->alicuota) {
                case 7:
                    // UCD
                    $folios = false;
                    if ($tramite == 1) {
                        $folios = true;
                    }
                    if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                        //////juridico (firma personal - empresa)
                        return response()->json(['success' => true, 'valor' => $query->juridico, 'alicuota' => $query->alicuota, 'folios' => $folios]);
                    }else{
                        ////natural
                        return response()->json(['success' => true, 'valor' => $query->natural, 'alicuota' => $query->alicuota, 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros, 'folios' => $folios]);
                    }
                case 8:
                    // PORCENTAJE
                    if (!empty($capital)){
                        $monto_porcentaje = ($capital * $query->porcentaje) / 100;
                        $monto_format = number_format($monto_porcentaje, 2, ',', '.');
                        return response()->json(['success' => true, 'valor' => $monto_porcentaje, 'valor_format' => $monto_format, 'alicuota' => $query->alicuota, 'porcentaje' => $query->porcentaje]);
                    }else{
                        return response()->json(['success' => true, 'valor' => 0, 'alicuota' => $query->alicuota, 'porcentaje' => $query->porcentaje, 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros]);
                    }
                    
                case 13:
                    // METRADO
                    if (!empty($metros)) {
                        // hay metros
                        if ($metros == '' || $metros == 0) {
                            return response()->json(['success' => true, 'valor' => 0, 'alicuota' => $query->alicuota]);
                        }else{
                            if ($metros <= 150) {
                                ////pequeña
                                return response()->json(['success' => true, 'valor' => $query->small, 'alicuota' => $query->alicuota, 'size' => 'small', 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros]);
                            }elseif ($metros > 150 && $metros < 400) {
                                /////mediana
                                return response()->json(['success' => true, 'valor' => $query->medium, 'alicuota' => $query->alicuota, 'size' => 'medium', 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros]);
                            }elseif ($metros >= 400) {
                                /////grande
                                return response()->json(['success' => true, 'valor' => $query->large, 'alicuota' => $query->alicuota, 'size' => 'large', 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros]);
                            }
                        }
                    }else{
                        // no hay metros
                        return response()->json(['success' => true, 'valor' => 0, 'alicuota' => $query->alicuota, 'no_porcentaje' => $no_ali_porcentaje, 'no_metrado' => $no_ali_metros]);
                    }
                    
            }
        }else{
            return response()->json(['success' => false]);
        }
    }



    public function debitado(Request $request)
    {
        $value = $request->post('value');
        $otro_debito = $request->post('otro_debito');
        $tramites = $request->post('tramites');

        $debito = 0;
        $total_ucd = 0; 
        $vuelto = 0;
        $diferencia = 0;
        $total_bolivares = 0;

        if ($otro_debito != '') {
            $debito = $value + $otro_debito;
        }else{
            $debito = $value;
        }

        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $ucd->valor;
        
        foreach ($tramites as $t) {
            if ($t != '') { 
                $tramite = unserialize(base64_decode($t));
                $condicion_sujeto = $tramite['condicion_sujeto'];

                $query = DB::table('tramites')->where('id_tramite','=', $tramite['tramite'])->first();
                switch ($query->alicuota) {
                    case 7:
                        // UCD
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $ucd_tramite = $query->juridico;
                        }else{
                            ////natural
                            $ucd_tramite = $query->natural;
                        }
                        $total_ucd = $total_ucd + $ucd_tramite;

                        //////SI ES PROTOCOLIZACIÓN Y TIENE FOLIOS ADICIONALES
                        if($tramite['tramite'] == 1){
                            $folios = $tramite['nro_folios'];
                            if ($folios != 0 || $folios != '' || $folios != null) {
                                $q1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
                                $total_ucd = $total_ucd + ($folios * $q1->natural);
                            }
                        }

                        break;
                    case 8:
                        // PORCENTAJE
                        
                        if (!empty($tramite['capital'])) {
                            // hay capital
                            $bs_tramite = ($tramite['capital'] * $query->porcentaje) / 100;
                            
                        }else{
                            // no hay capital
                            $bs_tramite = 0;
                        } 
                        $total_bolivares = $total_bolivares + $bs_tramite;
                        break;
                    case 13:
                        // METRADO
                        $metros = $tramite['metros'];
                        if (!empty($metros)) {
                            // hay metros
                            if ($metros == '' || $metros == 0) {
                                $ucd_tramite = 0;
                            }else{
                                if ($metros <= 150) {
                                    ////pequeña
                                    $ucd_tramite = $query->small;
                                }elseif ($metros > 150 && $metros < 400) {
                                    /////mediana
                                    $ucd_tramite = $query->medium;
                                }elseif ($metros >= 400) {
                                    /////grande
                                    $ucd_tramite = $query->large;
                                }
                            }
                        }else{
                            // no hay metros
                            $ucd_tramite = 0;
                        } 
                        $total_ucd = $total_ucd + $ucd_tramite;
                        break;
                         
                }
            }
        }
        
        $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
        
        ////formato 2 decimales
        if ($debito > $total_bolivares) {
            $vuelto = $debito - $total_bolivares;
        }else{
            $diferencia = $total_bolivares - $debito;
        }


        $deb = number_format($debito, 2, ',', '.');
        $dif = number_format($diferencia, 2, ',', '.');
        $v = number_format($vuelto, 2, ',', '.');

        $submit = '';
        if ($debito >= $total_bolivares) {
            $submit = true;
        }else{
            $submit = false;
        }

        return response()->json(['success' => true, 'debito' => $deb, 'diferencia' => $dif, 'vuelto' => $v, 'submit' => $submit]);
         
    }













    public function total(Request $request)
    {
        $tramites = $request->post('tramites');
        $metros = $request->post('metros');
        $capital = $request->post('capital');
        
        $condicion_sujeto = $request->post('condicion_sujeto');

        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $ucd->valor;
        $total_ucd = 0; 
        $total_bolivares = 0;

        foreach ($tramites as $tramite) {
            if ($tramite != '') { 
                $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
                switch ($query->alicuota) {
                    case 7:
                        // UCD
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $ucd_tramite = $query->juridico;
                        }else{
                            ////natural
                            $ucd_tramite = $query->natural;
                        }
                        $total_ucd = $total_ucd + $ucd_tramite;
                        break;
                    case 8:
                        // PORCENTAJE
                        
                        if (!empty($capital)) {
                            // hay capital
                            $bs_tramite = ($capital * $query->porcentaje) / 100;
                            
                        }else{
                            // no hay capital
                            $bs_tramite = 0;
                        } 
                        $total_bolivares = $total_bolivares + $bs_tramite;
                        break;
                    case 13:
                        // METRADO
                        if (!empty($metros)) {
                            // hay metros
                            if ($metros == '' || $metros == 0) {
                                $ucd_tramite = 0;
                            }else{
                                if ($metros <= 150) {
                                    ////pequeña
                                    $ucd_tramite = $query->small;
                                }elseif ($metros > 150 && $metros < 400) {
                                    /////mediana
                                    $ucd_tramite = $query->medium;
                                }elseif ($metros >= 400) {
                                    /////grande
                                    $ucd_tramite = $query->large;
                                }
                            }
                        }else{
                            // no hay metros
                            $ucd_tramite = 0;
                        } 
                        $total_ucd = $total_ucd + $ucd_tramite;
                        break;
                         
                }
            }
        }

        $folios = $request->post('folios');
        
        $q1 = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();

        $total_ucd = $total_ucd + ($folios * $q1->natural);

        $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
        $total_bolivares_format = number_format($total_bolivares, 2, ',', '.');

        return response()->json(['success' => true, 'ucd' => $total_ucd, 'bolivares' => $total_bolivares_format]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    



    public function disponibilidad(Request $request){
        $array = $request->post('array');

        $user = auth()->id();
        $q1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$q1->key_sujeto)->first();

        $id_taquila = $q2->id_taquilla;

        foreach ($array as $a) {
            $forma = $a['forma'];
            $ucd = $a['ucd'];
            $cantidad = $a['cantidad'];

            if ($forma == 3) {
                /////////////////////// FORMA 14
                $q3 = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=', $id_taquila)->first();
                if ($q3->cantidad_tfe >= $cantidad) {
                    /////si hay
                    return response()->json(['success' => true]); 
                }else{
                    ///// no hay
                    return response()->json(['success' => false, 'nota' => 'No hay timbres disponibles en la Taquilla.']);
                }

            }else{
                ///////////////////// ESTAMPILLAS
                if ($ucd == 10) {
                    $ucd_nota = 5;
                }else{
                    $ucd_nota = $ucd;
                }


                if ($ucd == 10) {
                    $consulta_ucd = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',5)->where('alicuota','=',7)->first();
                    $key_denominacion = $consulta_ucd->id;
                }else{
                    $consulta_ucd = DB::table('ucd_denominacions')->select('id')->where('denominacion','=', $ucd)->where('alicuota','=',7)->first();
                    $key_denominacion = $consulta_ucd->id;
                }

                $q4 = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')->where('key_denominacion','=', $key_denominacion)
                                                                        ->where('key_taquilla','=', $id_taquila)
                                                                        ->where('condicion','=',3) ///en uso
                                                                        ->first();
                if ($q4) {
                    ///// si hay
                    $disponible = $q4->cantidad_timbres - $q4->vendido; 
                    if ($disponible >= $cantidad) {
                        return response()->json(['success' => true]);
                    }else{
                        ///// buscar si hay reserva
                        $q5 = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')->where('key_denominacion','=', $key_denominacion)
                                                                        ->where('key_taquilla','=', $id_taquila)
                                                                        ->where('condicion','=',4) ///reserva
                                                                        ->first();
                        if ($q5) {
                            $disponible_q5 = $q5->cantidad_timbres - $q5->vendido;
                            if ($disponible_q5 >= $cantidad) {
                                return response()->json(['success' => true]);
                            }else{
                                ///// no hay
                                return response()->json(['success' => false, 'nota' => 'No hay estampillas de '.$ucd_nota.' UCD, en el Inventario de la Taquilla.']);
                            }
                        }else{
                            ///// no hay
                            return response()->json(['success' => false, 'nota' => 'No hay sufientes estampillas de '.$ucd_nota.' UCD, en el Inventario de la Taquilla.']);
                        }
                    }
                }else{
                    ///// no hay
                    ///// buscar si hay reserva
                    $q5 = DB::table('detalle_asignacion_estampillas')->select('cantidad_timbres','vendido')->where('key_denominacion','=', $key_denominacion)
                                        ->where('key_taquilla','=', $id_taquila)
                                        ->where('condicion','=',4) ///reserva
                                        ->first();
                    if ($q5) {
                        $disponible_q5 = $q5->cantidad_timbres - $q5->vendido;
                        if ($disponible_q5 >= $cantidad) {
                            return response()->json(['success' => true]);
                        }else{
                            ///// no hay
                            return response()->json(['success' => false, 'nota' => 'No hay estampillas de '.$ucd_nota.' UCD, en el Inventario de la Taquilla.']);
                        }
                    }else{
                        ///// no hay
                        return response()->json(['success' => false, 'nota' => 'No hay sufientes estampillas de '.$ucd_nota.' UCD, en el Inventario de la Taquilla.']);
                    }
                }
            }/////cierra estampillas

        }////cierra foreach


    }




    public function venta(Request $request){
        // return response('4545');
        $tramites = $request->post('tramite');
        $row_timbres = '';
        ///////////////////////////////////// USER Y TAQUILLA
            $user = auth()->id();
            $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
            $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

            if ($q2) {
                $id_taquilla = $q2->id_taquilla;
            }else{
                //////// BITACORA : ACCIÓN DE VENTA SIN SER TAQUILLERO
                return response()->json(['success' => false, 'nota'=> 'Disculpe, su usuario no esta asignado a ninguna taquilla.']);
            }
        
        // VERIFICAR LA APERTURA DE LA TAQUILLA
        $hoy = date('Y').''.date('m').''.date('d');
        $con_apertura = DB::table('apertura_taquillas')->where('key_taquilla','=',$id_taquilla)->where('fecha','=',$hoy)->first();
        if ($con_apertura) {
            ///// ADMIN aperturo taquilla
            if ($con_apertura->apertura_taquillero != null) {
                if ($con_apertura->cierre_taquilla == null) {
                    ///////////////////////////////////// CONTRIBUYENTE
                        $contribuyente = unserialize(base64_decode($request->post('contribuyente')));

                        $condicion_sujeto = $contribuyente['condicion_sujeto'];
                        $identidad_condicion = $contribuyente['identidad_condicion'];
                        $identidad_nro = $contribuyente['identidad_nro'];

                        $q1 = DB::table('contribuyentes')->select('id_contribuyente')
                                                            ->where('condicion_sujeto','=', $condicion_sujeto)
                                                            ->where('identidad_condicion','=', $identidad_condicion)
                                                            ->where('identidad_nro','=', $identidad_nro)
                                                            ->first();
                        if ($q1) {
                            $id_contribuyente = $q1->id_contribuyente;
                        }else{
                            return response()->json(['success' => false, 'nota'=> 'Disculpe, el contribuyente no se encuentra registrado.']);
                        }
                    


                    ///////////////////////////////////// UCD
                        $q3 =  DB::table('ucds')->select('id','valor')->orderBy('id', 'desc')->first();
                        $id_ucd = $q3->id;
                        $valor_ucd = $q3->valor;

                    ///////////////////////////////////// VALIDACIÓN  CAMPOS
                        $nro_tfe14 = 0;
                        foreach ($tramites as $t) {
                            $tramite = unserialize(base64_decode($t));
                            
                            $key_tramite = $tramite['tramite'];
                            $forma = $tramite['forma'];

                            if ($forma == 'Seleccione' || $forma == '') {
                                return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar la Forma.']);
                            }

                            if ($key_tramite == 'Seleccione' || $key_tramite == '') {
                                return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar el Tramite.']);
                            }

                            /////conteo TFE-14
                            if ($forma == 3) {
                                $nro_tfe14++;
                            }
                            
                        }
                    

                    ////////////////////////////////////VERIFICAR CANTIDAD DE TFE (INVENTARIO CONTRA VENTA)
                        $con_inv_tfe =  DB::table('inv_tfe_taq_temps')->select('cantidad')->where('key_taquilla', '=',$id_taquilla)->first();
                        if ($nro_tfe14 > $con_inv_tfe->cantidad) {
                            return response()->json(['success' => false, 'nota'=> 'No hay suficientes timbres TFE-14 en el inventario de la taquilla. Por favor, comuniquese con el coordinador.']);
                        }


                    ///////////////////////////////////// INSERT DETALLE Y SUMA TOTAL 
                        $total_ucd = 0;
                        $total_bolivares = 0;
                    
                        // $array_correlativo_tfe = [];
                        // $array_correlativo_estampillas = [];

                        $cant_tfe = 0;
                        $cant_estampillas = 0;

                        $cant_ucd_tfe = 0;
                        $cant_ucd_estampillas = 0;

                        $exist_tfe = false;
                        $exist_estampillas = false;

                        $i1 = DB::table('ventas')->insert(['key_user' => $user, 
                                                            'key_taquilla' => $id_taquilla, 
                                                            'key_contribuyente' => $id_contribuyente,
                                                            'key_ucd' => $id_ucd]); 
                        if ($i1) {
                            $id_venta = DB::table('ventas')->max('id_venta');

                            foreach ($tramites as $t) {
                                $tramite = unserialize(base64_decode($t));
    
                                $consulta_tramite = DB::table('tramites')->join('entes', 'tramites.key_ente', '=','entes.id_ente')
                                                                        ->select('tramites.tramite','tramites.alicuota','entes.ente')
                                                                        ->where('tramites.id_tramite','=',$tramite['tramite'])->first();
                                    
                                if ($tramite['forma'] == 3) {
                                    /////////////////////////////////////////////////////////////////////////////////////////////////////////// FORMA 14
                                    $key_tramite = $tramite['tramite'];
    
                                    $exist_tfe = true;
                                    $ucd_tramite = '';
                                    $key_deno = '';
    
                                    $alicuota = '';
    
                                    //////// IDENTIFICACION DE FORMA
                                    $c_forma = DB::table('formas')->select('identificador')->where('forma','=','Forma14')->first();
                                    $identificador_forma = $c_forma->identificador;
    
                                    //////// VALOR UCD TRAMITE  
                                    $cons = DB::table('tramites')->select('alicuota')->where('id_tramite','=', $key_tramite)->first();
                                    switch ($cons->alicuota) {
                                        case 7:
                                            // UCD
                                            $alicuota = 7;
                                            if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                                                //////juridico (firma personal - empresa)
                                                $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $key_tramite)->first();
                                                $ucd_tramite = $consulta->juridico;
                                            }else{
                                                ////natural
                                                $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $key_tramite)->first();
                                                $ucd_tramite = $consulta->natural;
                                            }
    
                                            /////////////////////////FOLIOS
                                            $folios = $tramite['nro_folios'];
                                            if ($key_tramite == 1) {
                                                if ($folios != '' || $folios != 0) {
                                                    $qf = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
    
                                                    $ucd_tramite = $ucd_tramite + ($folios * $qf->natural);
                                                }
                                            }
                                            
    
                                            
                                            $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=',$ucd_tramite)->where('alicuota','=',7)->first();
                                            if ($q5) {
                                                $key_deno = $q5->id;
                                                $identificador_ucd = $q5->identificador;
                                            }else{
                                                $q5_otros = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=','0.00')->where('alicuota','=',7)->first();
                                                $key_deno = $q5_otros->id;
                                                $identificador_ucd = $q5_otros->identificador;
                                            }
                                            
                                            
    
                                            $total_ucd = $total_ucd + $ucd_tramite;
                                            if ($key_tramite == 1) {
                                                if ($folios != '' || $folios != 0){
                                                    $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                                'key_tramite' => $key_tramite, 
                                                                                'forma' => $tramite['forma'],
                                                                                'cantidad' => 1,
                                                                                'metros' => null,
                                                                                'capital' => null,
                                                                                'folios' => $folios,
                                                                                'ucd' => $ucd_tramite,
                                                                                'bs' => null]);
                                                }
                                            }else{
                                                $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                                'key_tramite' => $key_tramite, 
                                                                                'forma' => $tramite['forma'],
                                                                                'cantidad' => 1,
                                                                                'metros' => null,
                                                                                'capital' => null,
                                                                                'folios' => null,
                                                                                'ucd' => $ucd_tramite,
                                                                                'bs' => null]);
                                            }
                                                
                                            if ($i2){
                                                $id_detalle_venta = DB::table('detalle_ventas')->max('correlativo');
    
                                                $c5 = DB::table('detalle_venta_tfes')->select('key_inventario_tfe','nro_timbre')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->orderBy('correlativo', 'desc')->first();
                                                if ($c5) {
                                                    $nro_hipotetico = $c5->nro_timbre +1;
    
                                                    $c6 = DB::table('inventario_tfes')->select('hasta','key_lote_papel')->where('correlativo','=',$c5->key_inventario_tfe)->first();
    
                                                    if ($nro_hipotetico > $c6->hasta) {
                                                        $c7 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->where('condicion','=',4)
                                                                                            ->first();
                                                        if ($c7) {
                                                            $nro_timbre = $c7->desde;
                                                            $key_inventario = $c7->correlativo;
                                                            $key_lote = $c7->key_lote_papel;
                                                            $update_2 = DB::table('inventario_tfes')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                                        }else{
                                                            // delete venta
                                                            $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                            return response()->json(['success' => false, 'nota'=> '']);
                                                        }
                                                    }else{
                                                        $nro_timbre = $nro_hipotetico;
                                                        $key_inventario = $c5->key_inventario_tfe;
                                                        $key_lote = $c6->key_lote_papel;
                                                        if ($nro_hipotetico == $c6->hasta) {
                                                            $update_1 = DB::table('inventario_tfes')->where('correlativo','=',$c5->key_inventario_tfe)->update(['condicion' => 7]);
                                                        }
                                                    }
                                                }else{
                                                    /////no hay registro, primer timbre
                                                    $c8 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                                        ->where('condicion','=',4)
                                                                                        ->first();
                                                    if ($c8) {
                                                        $nro_timbre = $c8->desde;
                                                        $key_inventario = $c8->correlativo;
                                                        $key_lote = $c8->key_lote_papel;
                                                        $update_3 = DB::table('inventario_tfes')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                                    }else{
                                                        // delete venta
                                                        $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                        return response()->json(['success' => false, 'nota'=> 'No hay TFE Forma 14 disponibles en taquilla.']);
                                                    }
                                                }
    
                                                // SERIAL
                                                $length = 6;
                                                $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);
    
                                                $serial = $identificador_ucd.''.$identificador_forma.''.$formato_nro;
    
                                                // QR
                                                $url = 'https://tfe14.tributosaragua.com.ve/?id='.$nro_timbre.'?lp='.$key_lote; 
                                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png'));
    
    
                                                // insert detalle_venta_estampilla
                                                $i3 = DB::table('detalle_venta_tfes')->insert(['key_venta' => $id_venta, 
                                                                                                'key_taquilla' => $id_taquilla,  
                                                                                                'key_detalle_venta' => $id_detalle_venta, 
                                                                                                'key_denominacion' => $key_deno,
                                                                                                'bolivares' => null,
                                                                                                'nro_timbre' => $nro_timbre,
                                                                                                'key_inventario_tfe' => $key_inventario,
                                                                                                'serial' => $serial,
                                                                                                'qr' => 'assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png']); 
                                                if ($i3){
                                                    $cant_tfe = $cant_tfe + 1;
                                                    $cant_ucd_tfe = $cant_ucd_tfe + $ucd_tramite;
    
                                                    $row_timbres .= '<div class="border mb-4 rounded-3">
                                                                        <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                                            <!-- DATOS -->
                                                                            <div class="w-50">
                                                                                <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                                                                <table class="table table-borderless table-sm lh-1 text_12">
                                                                                    <tr>
                                                                                        <th>Ente:</th>
                                                                                        <td>'.$consulta_tramite->ente.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Tramite:</th>
                                                                                        <td>'.$consulta_tramite->tramite.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Serial:</th>
                                                                                        <td>'.$serial.'</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <!-- UCD -->
                                                                            <div class="">
                                                                                <div class="text-center titulo fw-bold fs-3">'.$ucd_tramite.' UCD</div>
                                                                            </div>
                                                                            <!-- QR -->
                                                                            <div class="text-center">
                                                                                <img src="'.asset('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                    /////////ACTUALIZAR NRO TIMBRES VENDIDOS (DETALLE_ASIGNACION_TIMBRES)
                                                    $c_vendido = DB::table('inventario_tfes')->select('vendido')->where('correlativo','=',$key_inventario)->first();
                                                    $new_vendido = $c_vendido->vendido + 1;
                                                    $update_vendido = DB::table('inventario_tfes')->where('correlativo','=',$key_inventario)->update(['vendido' => $new_vendido]);
                                                }else{
                                                    // delete venta
                                                    $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                    return response()->json(['success' => false]);
                                                }
                                            }else{
                                                //// eliminar venta
                                                $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                return response()->json(['success' => false]);
                                            }
    
                                            break;
    
                                        case 8:
                                            // PORCENTAJE
                                            $alicuota = 8;
    
                                            $capital = $tramite['capital'];
    
                                            $consulta = DB::table('tramites')->select('porcentaje')->where('id_tramite','=', $key_tramite)->first();
                                            $porcentaje = $consulta->porcentaje;
    
                                            $cons_ident = DB::table('ucd_denominacions')->select('identificador')->where('denominacion','=', $porcentaje)->where('alicuota','=', 8)->first();
                                            $identificador_ali =$cons_ident->identificador;
    
                                            $total_bs_capital = ($capital * $porcentaje) / 100;
                                            $total_bolivares = $total_bolivares + $total_bs_capital; 
    
                                            $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                                        'key_tramite' => $key_tramite, 
                                                                                        'forma' => $tramite['forma'],
                                                                                        'cantidad' => 1,
                                                                                        'metros' => null,
                                                                                        'capital' => $capital,
                                                                                        'folios' => null,
                                                                                        'ucd' => null,
                                                                                        'bs' => $total_bs_capital]); 
                                            if ($i2){
                                                $id_detalle_venta = DB::table('detalle_ventas')->max('correlativo');
    
                                                $c5 = DB::table('detalle_venta_tfes')->select('key_inventario_tfe','nro_timbre')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->orderBy('correlativo', 'desc')->first();
                                                if ($c5) {
                                                    $nro_hipotetico = $c5->nro_timbre +1;
    
                                                    $c6 = DB::table('inventario_tfes')->select('hasta','key_lote_papel')->where('correlativo','=',$c5->key_inventario_tfe)->first();
    
                                                    if ($nro_hipotetico > $c6->hasta) {
                                                        $c7 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->where('condicion','=',4)
                                                                                            ->first();
                                                        if ($c7) {
                                                            $nro_timbre = $c7->desde;
                                                            $key_inventario = $c7->correlativo;
                                                            $key_lote = $c7->key_lote_papel;
                                                            $update_2 = DB::table('inventario_tfes')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                                        }else{
                                                            // delete venta
                                                            $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                            return response()->json(['success' => false, 'nota'=> '']);
                                                        }
                                                    }else{
                                                        $nro_timbre = $nro_hipotetico;
                                                        $key_inventario = $c5->key_inventario_tfe;
                                                        $key_lote = $c6->key_lote_papel;
                                                        if ($nro_hipotetico == $c6->hasta) {
                                                            $update_1 = DB::table('inventario_tfes')->where('correlativo','=',$c5->key_inventario_tfe)->update(['condicion' => 7]);
                                                        }
                                                    }
                                                }else{
                                                    /////no hay registro, primer timbre
                                                    $c8 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                                        ->where('condicion','=',4)
                                                                                        ->first();
                                                    if ($c8) {
                                                        $nro_timbre = $c8->desde;
                                                        $key_inventario = $c8->correlativo;
                                                        $key_lote = $c8->key_lote_papel;
                                                        $update_3 = DB::table('inventario_tfes')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                                    }else{
                                                        // delete venta
                                                        $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                        return response()->json(['success' => false, 'nota'=> 'No hay TFE Forma 14 disponibles en taquilla.']);
                                                    }
                                                }
    
                                                // SERIAL
                                                $length = 6;
                                                $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);
    
                                                $serial = $identificador_ali.''.$identificador_forma.''.$formato_nro;
    
                                                // QR
                                                $url = 'https://tfe14.tributosaragua.com.ve/?id='.$nro_timbre.'?lp='.$key_lote; 
                                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png'));
    
    
                                                // insert detalle_venta_estampilla
                                                $i3 = DB::table('detalle_venta_tfes')->insert(['key_venta' => $id_venta, 
                                                                                                'key_taquilla' => $id_taquilla,  
                                                                                                'key_detalle_venta' => $id_detalle_venta, 
                                                                                                'key_denominacion' => null,
                                                                                                'bolivares' => $total_bs_capital,
                                                                                                'nro_timbre' => $nro_timbre,
                                                                                                'key_inventario_tfe' => $key_inventario,
                                                                                                'serial' => $serial,
                                                                                                'qr' => 'assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png']); 
                                                if ($i3){
                                                    $cant_tfe = $cant_tfe + 1;
                                                    $cant_ucd_tfe = $cant_ucd_tfe;

                                                    $formato_total_bs_capital =  number_format($total_bs_capital, 2, ',', '.');
    
                                                    $row_timbres .= '<div class="border mb-4 rounded-3">
                                                                        <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                                            <!-- DATOS -->
                                                                            <div class="w-50">
                                                                                <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                                                                <table class="table table-borderless table-sm lh-1 text_12">
                                                                                    <tr>
                                                                                        <th>Ente:</th>
                                                                                        <td>'.$consulta_tramite->ente.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Tramite:</th>
                                                                                        <td>'.$consulta_tramite->tramite.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Serial:</th>
                                                                                        <td>'.$serial.'</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <!-- UCD -->
                                                                            <div class="">
                                                                                <div class="text-center titulo fw-bold fs-3">'.$formato_total_bs_capital.' Bs.</div>
                                                                            </div>
                                                                            <!-- QR -->
                                                                            <div class="text-center">
                                                                                <img src="'.asset('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                    /////////ACTUALIZAR NRO TIMBRES VENDIDOS (DETALLE_ASIGNACION_TIMBRES)
                                                    $c_vendido = DB::table('inventario_tfes')->select('vendido')->where('correlativo','=',$key_inventario)->first();
                                                    $new_vendido = $c_vendido->vendido + 1;
                                                    $update_vendido = DB::table('inventario_tfes')->where('correlativo','=',$key_inventario)->update(['vendido' => $new_vendido]);
                                                }else{
                                                    // delete venta
                                                    $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                    return response()->json(['success' => false]);
                                                }
    
                                            }else{
                                                //// eliminar venta
                                                $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                return response()->json(['success' => false]);
                                            }
     
                                            break;
                                        
                                        case 13:
                                            // METRADO
                                            $alicuota = 13;
                                            $metros = $tramite['metros'];
    
                                            if ($metros > 0 && $metros <= 150) {
                                                ////pequeña
                                                $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $key_tramite)->first();
                                                $ucd_tramite = $consulta->small;
                                            }elseif ($metros > 150 && $metros < 400) {
                                                /////mediana
                                                $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $key_tramite)->first();
                                                $ucd_tramite = $consulta->medium;
                                            }elseif ($metros >= 400) {
                                                /////grande
                                                $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $key_tramite)->first();
                                                $ucd_tramite = $consulta->large;
                                            }    
                                            
                                            ///////DENOMINACION E IDENTIFICADOR DE DENOMINACION
                                            $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=',$ucd_tramite)->where('alicuota','=',7)->first();
                                            $key_deno = $q5->id;
                                            $identificador_ucd = $q5->identificador;
                        
                                            $total_ucd = $total_ucd + $ucd_tramite;
    
    
                                            $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                                'key_tramite' => $key_tramite, 
                                                                                'forma' => $tramite['forma'],
                                                                                'cantidad' => 1,
                                                                                'metros' => $metros,
                                                                                'capital' => null,
                                                                                'folios' => null,
                                                                                'ucd' => $ucd_tramite,
                                                                                'bs' => null]); 
                                            if ($i2){
                                                $id_detalle_venta = DB::table('detalle_ventas')->max('correlativo');
    
                                                $c5 = DB::table('detalle_venta_tfes')->select('key_inventario_tfe','nro_timbre')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->orderBy('correlativo', 'desc')->first();
                                                if ($c5) {
                                                    $nro_hipotetico = $c5->nro_timbre +1;
    
                                                    $c6 = DB::table('inventario_tfes')->select('hasta','key_lote_papel')->where('correlativo','=',$c5->key_inventario_tfe)->first();
    
                                                    if ($nro_hipotetico > $c6->hasta) {
                                                        $c7 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->where('condicion','=',4)
                                                                                            ->first();
                                                        if ($c7) {
                                                            $nro_timbre = $c7->desde;
                                                            $key_inventario = $c7->correlativo;
                                                            $key_lote = $c7->key_lote_papel;
                                                            $update_2 = DB::table('inventario_tfes')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                                        }else{
                                                            // delete venta
                                                            $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                            return response()->json(['success' => false, 'nota'=> '']);
                                                        }
                                                    }else{
    
                                                        $nro_timbre = $nro_hipotetico;
                                                        $key_inventario = $c5->key_inventario_tfe;
                                                        $key_lote = $c6->key_lote_papel;
                                                        if ($nro_hipotetico == $c6->hasta) {
                                                            $update_1 = DB::table('inventario_tfes')->where('correlativo','=',$c5->key_inventario_tfe)->update(['condicion' => 7]);
                                                        }
                                                    }
                                                }else{
                                                    /////no hay registro, primer timbre
                                                    $c8 = DB::table('inventario_tfes')->select('desde','correlativo','key_lote_papel')
                                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                                        ->where('condicion','=',4)
                                                                                        ->first();
                                                    if ($c8) {
                                                        $nro_timbre = $c8->desde;
                                                        $key_inventario = $c8->correlativo;
                                                        $key_lote = $c8->key_lote_papel;
                                                        $update_3 = DB::table('inventario_tfes')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                                    }else{
                                                        // delete venta
                                                        $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                        return response()->json(['success' => false, 'nota'=> 'No hay TFE Forma 14 disponibles en taquilla.']);
                                                    }
                                                }
    
                                                // SERIAL
                                                $length = 6;
                                                $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);
    
                                                $serial = $identificador_ucd.''.$identificador_forma.''.$formato_nro;
    
                                                // QR
                                                $url = 'https://tfe14.tributosaragua.com.ve/?id='.$nro_timbre.'?lp='.$key_lote; 
                                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png'));
    
    
                                                // insert detalle_venta_estampilla
                                                $i3 = DB::table('detalle_venta_tfes')->insert(['key_venta' => $id_venta, 
                                                                                                'key_taquilla' => $id_taquilla,  
                                                                                                'key_detalle_venta' => $id_detalle_venta, 
                                                                                                'key_denominacion' => $key_deno,
                                                                                                'bolivares' => null,
                                                                                                'nro_timbre' => $nro_timbre,
                                                                                                'key_inventario_tfe' => $key_inventario,
                                                                                                'serial' => $serial,
                                                                                                'qr' => 'assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png']); 
                                                if ($i3){
                                                    $cant_tfe = $cant_tfe + 1;
                                                    $cant_ucd_tfe = $cant_ucd_tfe + $ucd_tramite;
    
                                                    $row_timbres .= '<div class="border mb-4 rounded-3">
                                                                        <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                                            <!-- DATOS -->
                                                                            <div class="w-50">
                                                                                <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                                                                <table class="table table-borderless table-sm lh-1 text_12">
                                                                                    <tr>
                                                                                        <th>Ente:</th>
                                                                                        <td>'.$consulta_tramite->ente.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Tramite:</th>
                                                                                        <td>'.$consulta_tramite->tramite.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Serial:</th>
                                                                                        <td>'.$serial.'</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <!-- UCD -->
                                                                            <div class="">
                                                                                <div class="text-center titulo fw-bold fs-3">'.$ucd_tramite.' UCD</div>
                                                                            </div>
                                                                            <!-- QR -->
                                                                            <div class="text-center">
                                                                                <img src="'.asset('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                    /////////ACTUALIZAR NRO TIMBRES VENDIDOS (DETALLE_ASIGNACION_TIMBRES)
                                                    $c_vendido = DB::table('inventario_tfes')->select('vendido')->where('correlativo','=',$key_inventario)->first();
                                                    $new_vendido = $c_vendido->vendido + 1;
                                                    $update_vendido = DB::table('inventario_tfes')->where('correlativo','=',$key_inventario)->update(['vendido' => $new_vendido]);
                                                }else{
                                                    // delete venta
                                                    $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                    return response()->json(['success' => false]);
                                                }
                                            }else{
                                                //// eliminar venta
                                                $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                return response()->json(['success' => false]);
                                            }
    
                                            break;
                                                
                                        default:
                                            // delete venta
                                            $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                            return response()->json(['success' => false, 'nota'=> '']);
                                            break;
                                    }
    
                                
    
    
                                }else{
                                    /////////////////////////////////////////////////////////////////////////////////////////////////////////// ESTAMPILLAS
                                    $key_tramite = $tramite['tramite'];
                                    $exist_estampillas = true;
    
                                    $ucd_tramite = '';
                                    $key_deno = '';
    
                                    //////// IDENTIFICACION DE FORMA
                                    $c_forma = DB::table('formas')->select('identificador')->where('forma','=','Estampillas')->first();
                                    $identificador_forma = $c_forma->identificador;
    
                                    //////// VALOR UCD TRAMITE  
                                    if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                                        //////juridico (firma personal - empresa)
                                        $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $key_tramite)->first();
                                        $ucd_tramite = $consulta->juridico;
                                    }else{
                                        ////natural
                                        $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $key_tramite)->first();
                                        $ucd_tramite = $consulta->natural;
                                    }
    
    
                                    /////////////////////////FOLIOS
                                    $folios =  $tramite['nro_folios'];
                                    if ($key_tramite == 1) {
                                        if ($folios != '' || $folios != 0) {
                                            $qf = DB::table('tramites')->select('natural')->where('tramite','=', 'Folio')->first();
    
                                            $ucd_tramite = $ucd_tramite + ($folios * $qf->natural);
                                        }
                                    }
    
                                    $total_ucd = $total_ucd + $ucd_tramite;
                                    if ($key_tramite == 1) {
                                        if ($folios != '' || $folios != 0) {
                                            $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                                'key_tramite' => $key_tramite, 
                                                                                'forma' => $tramite['forma'],
                                                                                'cantidad' => 1,
                                                                                'metros' => null,
                                                                                'capital' => null,
                                                                                'folios' => $folios,
                                                                                'ucd' => $ucd_tramite,
                                                                                'bs' => null]); 
                                        }
                                    }else{
                                        $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                            'key_tramite' => $key_tramite, 
                                                                            'forma' => $tramite['forma'],
                                                                            'cantidad' => 1,
                                                                            'metros' => null,
                                                                            'capital' => null,
                                                                            'folios' => null,
                                                                            'ucd' => $ucd_tramite,
                                                                            'bs' => null]); 
                                    }
                                    
                                    if ($i2) {
                                        $id_detalle_venta = DB::table('detalle_ventas')->max('correlativo');
                                        ///////////////////////// BUSCAR CORRELATIVO
                                        $detalle_est = unserialize(base64_decode($tramite['detalle_est']));
                                        // return response($detalle_est);
                                        foreach ($detalle_est as $est) {
                                            $key_deno = $est['ucd'];
                                            $cant_est = $est['cantidad'];
    
                                            $q5 = DB::table('ucd_denominacions')
                                                    ->join('tipos', 'ucd_denominacions.alicuota', '=','tipos.id_tipo')
                                                    ->select('ucd_denominacions.denominacion','tipos.nombre_tipo','ucd_denominacions.identificador','ucd_denominacions.alicuota')
                                                    ->where('ucd_denominacions.id','=',$key_deno)->first();

                                            $identificador_ucd = $q5->identificador;
    
                                            for ($i=0; $i < $cant_est ; $i++) { 
                                                $nro_timbre = '';
                                                $key_detalle_asignacion = '';

                                                ////// ESTAMPILLAS UCD
                                                $c5 = DB::table('detalle_venta_estampillas')->select('key_detalle_asignacion','nro_timbre')
                                                                                            ->where('key_denominacion','=',$key_deno)
                                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                                            ->orderBy('correlativo', 'desc')->first();
                                                if ($c5) {
                                                    $nro_hipotetico = $c5->nro_timbre +1;

                                                    $c6 = DB::table('detalle_asignacion_estampillas')->select('hasta')->where('correlativo','=',$c5->key_detalle_asignacion)->first();

                                                    if ($nro_hipotetico > $c6->hasta) {
                                                        $c7 = DB::table('detalle_asignacion_estampillas')->select('desde','correlativo')
                                                                    ->where('key_taquilla','=',$id_taquilla)
                                                                    ->where('condicion','=',4)
                                                                    ->where('key_denominacion','=',$key_deno)
                                                                    ->first();
                                                        if ($c7) {
                                                            $nro_timbre = $c7->desde;
                                                            $key_detalle_asignacion = $c7->correlativo;
                                                            $update_2 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                                        }else{
                                                            // delete venta
                                                            $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                            return response()->json(['success' => false, 'nota'=> '']);
                                                        }
                                                    }else{
                                                        $nro_timbre = $nro_hipotetico;
                                                        $key_detalle_asignacion = $c5->key_detalle_asignacion;
                                                        if ($nro_hipotetico == $c6->hasta) {
                                                            $update_1 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c5->key_detalle_asignacion)->update(['condicion' => 7]);
                                                        }
                                                    }
                                                }else{
                                                ///// primer registro de venta de la denominacion 
                                                    $c8 = DB::table('detalle_asignacion_estampillas')->select('desde','correlativo')
                                                                                                    ->where('key_taquilla','=',$id_taquilla)
                                                                                                    ->where('condicion','=',4)
                                                                                                    ->where('key_denominacion','=',$key_deno)
                                                                                                    ->first();
                                                    if ($c8) {
                                                        $nro_timbre = $c8->desde;
                                                        $key_detalle_asignacion = $c8->correlativo;
                                                        $update_3 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                                    }else{
                                                        // delete venta
                                                        $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                        return response()->json(['success' => false, 'nota'=> 'No hay timbres disponibles de ']);
                                                    }
                                                }
                                                
    
                                                // SERIAL
                                                $length = 6;
                                                $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);
    
                                                $serial = $identificador_ucd.''.$identificador_forma.''.$formato_nro;
    
    
                                                // insert detalle_venta_estampilla
                                                $i3 = DB::table('detalle_venta_estampillas')->insert(['key_venta' => $id_venta, 
                                                                                                    'key_taquilla' => $id_taquilla,  
                                                                                                    'key_detalle_venta' => $id_detalle_venta, 
                                                                                                    'key_denominacion' => $key_deno,
                                                                                                    'nro_timbre' => $nro_timbre,
                                                                                                    'key_detalle_asignacion' => $key_detalle_asignacion,
                                                                                                    'serial' => $serial,
                                                                                                    'qr' => 'assets/qrEstampillas/qrcode_EST'.$nro_timbre.'.png']); 
                                                if ($i3) {
                                                    $cant_estampillas = $cant_estampillas + 1;
                                                    $cant_ucd_estampillas = $cant_ucd_estampillas + $q5->denominacion;

                                                    if ($q5->alicuota == 7) {
                                                        $qr = '<img src="'.asset('assets/qrEstampillas/qrcode_EST'.$nro_timbre.'.png').'" class="img-fluid" alt="" width="110px">';
                                                    }elseif ($q5->alicuota == 19) {
                                                        $qr = '';
                                                    }
    
                                                    $row_timbres .= '<div class="border mb-4 rounded-3">
                                                                        <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                                            <!-- DATOS -->
                                                                            <div class="w-50">
                                                                                <div class="text-danger fw-bold fs-4" id="">'.$formato_nro.'<span class="text-muted ms-2">Estampilla</span></div> 
                                                                                <table class="table table-borderless table-sm lh-1 text_12">
                                                                                    <tr>
                                                                                        <th>Ente:</th>
                                                                                        <td>'.$consulta_tramite->ente.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Tramite:</th>
                                                                                        <td>'.$consulta_tramite->tramite.'</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Serial:</th>
                                                                                        <td>'.$serial.'</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <!-- UCD -->
                                                                            <div class="">
                                                                                <div class="text-center titulo fw-bold fs-3">'.$q5->denominacion.' '.$q5->nombre_tipo.'</div>
                                                                            </div>
                                                                            <!-- QR -->
                                                                            <div class="text-center">
                                                                                '.$qr.'
                                                                            </div>
                                                                        </div>
                                                                    </div>';
    
                                                    /////////ACTUALIZAR NRO TIMBRES VENDIDOS (DETALLE_ASIGNACION_TIMBRES)
                                                    $c_vendido = DB::table('detalle_asignacion_estampillas')->select('vendido')->where('correlativo','=',$key_detalle_asignacion)->first();
                                                    $new_vendido = $c_vendido->vendido + 1;
                                                    $update_vendido = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$key_detalle_asignacion)->update(['vendido' => $new_vendido]);
                                                }else{
                                                    // delete venta
                                                    $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                                    return response()->json(['success' => false]);
                                                }
                                            }
    
    
                                        }
                                    }else{
                                        //// eliminar venta
                                        $delete_venta = DB::table('ventas')->where('id_venta', '=', $id_venta)->delete();
                                        return response()->json(['success' => false]);
                                    }
    
                                } ///cierra else ESTAMPILLAS
                                
                            } ///cierra foreach tramites
                        }else{
                            return response()->json(['success' => false]);
                        }

                        

                        ///////////////////////////////////////  UPDATE INVENTARIO TAQUILLAS
                        $inv1 = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=',$id_taquilla)->first();
                        $inv2 = DB::table('inventario_taquillas')->select('cantidad_estampillas')->where('key_taquilla','=',$id_taquilla)->first();

                        $new_inv_tfe = $inv1->cantidad_tfe - $cant_tfe;
                        $new_inv_estampillas = $inv2->cantidad_estampillas - $cant_estampillas;

                        $update_inv_tfe = DB::table('inventario_taquillas')->where('key_taquilla','=',$id_taquilla)->update(['cantidad_tfe' => $new_inv_tfe]);
                        $update_inv_estampilla = DB::table('inventario_taquillas')->where('key_taquilla','=',$id_taquilla)->update(['cantidad_estampillas' => $new_inv_estampillas]);




                    ///////////////////////////////////// UPDATE TOTAL UCD / BOLIVARES (TABLE VENTAS)
                        $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
                        $update_venta = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['total_ucd' => $total_ucd, 'total_bolivares' => $total_bolivares]);

                        $formato_total_bolivares =  number_format($total_bolivares, 2, ',', '.');

                    ///////////////////////////////////// PAGO DE TIMBRE(S)
                        $pagos = $request->post('pago');
                        $tr_detalle_debito = '';

                        foreach ($pagos as $pago) {
                            if ($pago['metodo'] == 5) {
                                /////////////PUNTO
                                $i3 =DB::table('pago_ventas')->insert(['key_venta' => $id_venta, 
                                                                        'metodo' => 5, 
                                                                        'comprobante' => $pago['comprobante'],
                                                                        'monto' => $pago['debitado']]); 
                                $formato_debito_punto =  number_format($pago['debitado'], 2, ',', '.');
                                $tr_detalle_debito .= '<tr>
                                                            <th>Punto</th>
                                                            <td class="table-warning">'.$formato_debito_punto.'</td>
                                                            <td>#'.$pago['comprobante'].'</td>
                                                        </tr>';
                            }else{
                                ///////////EFECTIVO
                                $i3 =DB::table('pago_ventas')->insert(['key_venta' => $id_venta, 
                                                                        'metodo' => 6, 
                                                                        'comprobante' => null,
                                                                        'monto' => $pago['debitado']]); 
                                $formato_debito_efectivo =  number_format($pago['debitado'], 2, ',', '.');
                                $tr_detalle_debito .= '<tr>
                                                            <th>Efectivo</th>
                                                            <td class="table-warning">'.$formato_debito_efectivo.'</td>
                                                            <td><span class="text-secondary fst-italic">No aplica</span></td>
                                                        </tr>';
                                
                                //////// SUMA EFECTIVO EN EL TAQUILLA (TEMPORAL - DIARIO)
                                $consulta_temps = DB::table('efectivo_taquillas_temps')->select('efectivo')->where('key_taquilla','=',$id_taquilla)->first();
                                $monto_efectivo_temp = $consulta_temps->efectivo;
                                $total_new_efectivo_temps = $monto_efectivo_temp + $pago['debitado'];                   

                                $update_efectivo_temp = DB::table('efectivo_taquillas_temps')->where('key_taquilla','=',$id_taquilla)->update(['efectivo' => $total_new_efectivo_temps]);
                            }
                        }

                        $tr_detalle_timbres = '';
                        if ($exist_tfe == true) {
                            $tr_detalle_timbres .= '<tr>
                                                    <td>TFE-14</td>
                                                    <td>'.$cant_tfe.'</td>
                                                    <td>'.$cant_ucd_tfe.'</td>
                                                </tr>';
                        } 
                        if ($exist_estampillas == true) {
                            $tr_detalle_timbres .= '<tr>
                                                    <td>Estampillas</td>
                                                    <td>'.$cant_estampillas.'</td>
                                                    <td>'.$cant_ucd_estampillas.'</td>
                                                </tr>';
                        }


                        $html_pago = '<div class="border rounded-3 py-2 px-3">
                                            <div class="d-flex flex-column text-center">
                                                <div class="fw-bold text-navy">Servicio Tributario del Estado Aragua</div>
                                                <div class="text-muted">G-20008920-2</div>
                                            </div>

                                            <table class="table table-sm my-3 text_12">
                                                <tr>
                                                    <th>Forma</th>
                                                    <th>Cant.</th>
                                                    <th>UCD</th>
                                                </tr>
                                                '.$tr_detalle_timbres.'
                                            </table>

                                            <div class="d-flex justify-content-center">
                                                <table class="table table-sm w-50 text_12">
                                                    <tr>
                                                        <th>Total UCD</th>
                                                        <td>'.$total_ucd.'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>UCD Hoy</th>
                                                        <td>'.$valor_ucd.'</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Bs.</th>
                                                        <td class="table-warning">'.$formato_total_bolivares.'</td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <table class="table table-sm text_12">
                                                '.$tr_detalle_debito.'
                                            </table>

                                        </div>'; 

                    ///////////////////////////////////// HTML
                        $html = '<div class="modal-header">
                                <h1 class="modal-title fs-5 fw-bold text-navy">Venta realizada | <span class="text-muted">Timbres</span></h1>
                            </div>
                            <div class="modal-body px-4 py-3" style="font-size:12.7px">

                                <div class="row">
                                    <!-- DETALLE TIMBRE(S) -->
                                    <div class="col-lg-8">
                                        <p class="text-center text-muted titulo fw-bold mb-2 fs-6">Timbres Fiscales</p>
                                        '.$row_timbres.'
                                    </div>
                                    <!-- DETALLE PAGO -->
                                    <div class="col-lg-4">
                                        '.$html_pago.'
                                    </div>
                                </div>  <!--  cierra div.row   -->

                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <a href="'.route("venta").'" class="btn btn-secondary btn-sm me-3">Cancelar</a>
                                </div>
                            </div>';

                        return response()->json(['success' => true, 'html' => $html]);

                }else{
                    // // BITACORA = INTENTO DE VENTA TAQUILLA CERRADA (TAQUILLERO)
                    return response()->json(['success' => false, 'nota'=> 'Acción invalida. Taquilla Cerrada.']);
                }
            }else{
                // // BITACORA = INTENTO DE VENTA SIN APERTURA DE TAQUILLA (TAQUILLERO)
                return response()->json(['success' => false, 'nota'=> 'Acción invalida. Debe aperturar taquilla.']);
            }
        }else{
            /////no hay registro, ADMIN no ha aperturado taquilla.
            // BITACORA = INTENTO DE VENTA SIN APERTURA DE TAQUILLA
            return response()->json(['success' => false, 'nota'=> 'Acción invalida. La taquilla no ha sido aperturada.']);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    





    






    
    




    public function delete_tramite(Request $request){
        $detalle = unserialize(base64_decode($request->post('detalle')));

        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;

        $q1 = DB::table('inv_est_taq_temps')->where('key_taquilla','=', $id_taquilla)->first();
        foreach ($detalle as $key) {
            $ucd = $key['ucd'];
            $cant = $key['cantidad'];

            switch ($ucd) {
                case 1:
                    $new_inv = $q1->one_ucd + $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['one_ucd' => $new_inv]);
                    break;
                case 2:
                    $new_inv = $q1->two_ucd + $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['two_ucd' => $new_inv]);
                    break;
                case 3:
                    $new_inv = $q1->three_ucd + $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['three_ucd' => $new_inv]);
                    break;
                case 4:
                    $new_inv = $q1->five_ucd + $cant;
                    $update = DB::table('inv_est_taq_temps')->where('key_taquilla','=',$id_taquilla)->update(['five_ucd' => $new_inv]);
                    break;    
                default:
                    return response()->json(['success' => false]);
                    break;
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
