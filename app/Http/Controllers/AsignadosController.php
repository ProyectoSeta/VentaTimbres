<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;
use Illuminate\Http\Request;

class AsignadosController extends Controller
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
        $user = auth()->id();

        $c1 = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$c1->key_sujeto)->first();

        $query = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
        ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
        ->where('exenciones.estado','=',18)
        ->where('exenciones.key_taquilla','=',$c2->id_taquilla)->get();

        return view('asignado', compact('query'));
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
    public function modal(Request $request)
    {
        $id_exencion = $request->post('exencion');
        $tramites = '';

        $c1 = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                    ->where('exenciones.id_exencion','=',$id_exencion)->first();

        $q2 = DB::table('contribuyentes')->join('tipos','contribuyentes.condicion_sujeto', '=','tipos.id_tipo')
                                    ->select('contribuyentes.*','tipos.nombre_tipo')
                                    ->where('contribuyentes.id_contribuyente','=', $c1->key_contribuyente)->first();

        $html_contribuyente = '<!-- *************** DATOS CONTRIBUYENTE ******************-->
                                <div class="mb-2" style="font-size:13px">
                                    <div class="d-flex justify-content-center">
                                        <div class="row w-100">
                                            <h5 class="titulo fw-bold text-navy mb-3">Contribuyente | <span class="text-secondary fs-6">Datos</span></h5>
                                            <!-- Tipo Contribuyente -->
                                            <div class="col-sm-3">
                                                <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto" disabled>
                                                    <option>'.$q2->nombre_tipo.'</option>
                                                </select>
                                            </div>
                                            <!-- ci o rif -->
                                            <div class="col-sm-5">
                                                <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion" disabled>
                                                            <option>'.$q2->identidad_condicion.'</option>
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-1">-</div> -->
                                                    <div class="col-7">
                                                        <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" value="'.$q2->identidad_nro.'" disabled>
                                                        <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- nombre o razon -->
                                            <div class="col-sm-4">
                                                <label class="form-label" for="nombre">Nombre / Razon Social</label><span class="text-danger">*</span>
                                                <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled value="'.$q2->nombre_razon.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>';


        $c2 = DB::table('detalle_exenciones')->where('key_exencion','=',$id_exencion)->get();
        // return response($c2);
        foreach ($c2 as $key) {
            $q1 = DB::table('tramites')->join('entes','tramites.key_ente', '=','entes.id_ente')
                                        ->select('tramites.tramite','entes.ente')
                                        ->where('tramites.id_tramite','=', $key->key_tramite)->first();

            $metros = $key->metros;
            $ucd_tramite = '';

            if ($metros > 0 && $metros <= 150) {
                ////pequeña
                $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->small;
            }elseif ($metros > 150 && $metros < 400) {
                /////mediana
                $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->medium;
            }elseif ($metros >= 400) {
                /////grande
                $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->large;
            }    


            $tramites .= '<div class="d-flex justify-content-center">
                                    <div class="row w-100">
                                        <h5 class="titulo fw-bold text-navy my-3">Tramite | <span class="text-secondary fs-6">Datos</span></h5>
                                        <div class="col-sm-3">
                                            <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm ente" disabled>
                                               <option>'.$q1->ente.'</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm tramite" title="'.$q1->tramite.'" disabled>
                                                <option>'.$q1->tramite.'</option>
                                            </select>
                                        </div>                                        
                                        <div class="col-sm-2">
                                            <label class="form-label" for="">Metros (mt2)</label><span class="text-danger">*</span>
                                            <input type="number" class="form-control form-control-sm " disabled value="'.$metros.'">
                                        </div>
                                        <div class="col-sm-1" id="div_ucd_1">
                                            <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control form-control-sm"  disabled value="'.$ucd_tramite.'">
                                        </div> 
                                        <div class="col-sm-2">
                                            <label class="form-label" for="forma">Timbre</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm forma"  disabled>
                                                <option>TFE-14</option>
                                            </select>
                                            <p class="text-end my-0 text-muted" id="cant_timbre_1">1 und.</p>
                                        </div>
                                    </div>
                                </div>';
        }

        $html_tramites = '<!-- **************** DATOS TRAMITE **************** -->
                        <div class="mb-4" style="font-size:13px">
                            <div class="d-flex flex-column tramites">
                                '.$tramites.'
                            </div>
                        </div>';

        $html = '<div class="modal-header p-2 pt-3 ps-3">
                    <h1 class="modal-title fs-5 fw-bold text-navy">Venta | <span class="text-muted">Exención</span></h1>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_impresion_exencion" method="post" onsubmit="event.preventDefault(); impresionExencion()">
                        '.$html_contribuyente.'
                        '.$html_tramites.'

                        <input type="hidden" name="exencion" value="'.$id_exencion.'">


                        <!-- totales -->
                        <div class="row d-flex align-items-center ">
                            <div class="col-lg-6 d-flex justify-content-end flex-column">
                                <div class="bg-light rounded-3 px-3 py-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">UCD</span>
                                            <span class="fw-bold text-muted" style="font-size:13px">Unidad de Cuenta Dinámica</span>
                                        </p>
                                        <span class="fs-2 text-navy fw-bold" id="ucd">'.$c1->total_ucd.' UCD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <img src="'.asset('assets/banner_asignado_ex.svg').'" alt="" class="rounded-4" width="95%">
                                </div>
                            </div>
                        </div>


                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <a class="btn btn-secondary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#modal_asignado_exencion" >Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_submit_venta">Imprimir</button>
                        </div>
                    </form>
                </div>';
        
        return response($html);
    }

    /**
     * Display the specified resource.
     */
    public function venta(Request $request)
    {
        $id_exencion = $request->post('exencion');
        $row_timbres = '';

        ///////////////////////////////////// USER Y TAQUILLA
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $con_taq = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        ///////////////////////////////////// UCD
        $q3 =  DB::table('ucds')->select('id','valor')->orderBy('id', 'desc')->first();
        $id_ucd = $q3->id;
        $valor_ucd = $q3->valor;

        if ($con_taq) {
            $id_taquilla = $con_taq->id_taquilla;
        }else{
            //////// BITACORA : ACCIÓN DE VENTA SIN SER TAQUILLERO
            return response()->json(['success' => false, 'nota'=> 'Disculpe, su usuario no esta asignado a ninguna taquilla.']);
        }

        //////// IDENTIFICACION DE FORMA
        $c_forma = DB::table('formas')->select('identificador')->where('forma','=','Forma14')->first();
        $identificador_forma = $c_forma->identificador;


        // VERIFICAR LA APERTURA DE LA TAQUILLA
        $hoy = date('Y').''.date('m').''.date('d');
        $con_apertura = DB::table('apertura_taquillas')->where('key_taquilla','=',$id_taquilla)->where('fecha','=',$hoy)->first();
        if ($con_apertura) {
            ///// ADMIN aperturo taquilla
            if ($con_apertura->apertura_taquillero != null){
                if ($con_apertura->cierre_taquilla == null) {
                    $q1 = DB::table('exenciones')->where('id_exencion','=',$id_exencion)->first();
                    if ($q1) {
                        $id_contribuyente = $q1->key_contribuyente;
                        $total_ucd = 0;
                        $cant_tfe = 0;
                        $cant_ucd_tfe = 0;
                        $exist_tfe = false;
                    

                        $i1 = DB::table('ventas')->insert(['key_user' => $user, 
                                                            'key_taquilla' => $id_taquilla, 
                                                            'key_contribuyente' => $id_contribuyente,
                                                            'key_ucd' => $id_ucd,
                                                            'key_exencion' => $id_exencion]); 
                        if ($i1){
                            $id_venta = DB::table('ventas')->max('id_venta');

                            $q2 = DB::table('detalle_exenciones')->where('key_exencion','=',$id_exencion)->get();
                            foreach ($q2 as $key) {
                                $consulta_tramite = DB::table('tramites')->join('entes', 'tramites.key_ente', '=','entes.id_ente')
                                                                    ->select('tramites.tramite','tramites.alicuota','entes.ente')
                                                                    ->where('tramites.id_tramite','=',$key->key_tramite)->first();

                                $metros = $key->metros;

                                if ($metros > 0 && $metros <= 150) {
                                    ////pequeña
                                    $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $key->key_tramite)->first();
                                    $ucd_tramite = $consulta->small;
                                }elseif ($metros > 150 && $metros < 400) {
                                    /////mediana
                                    $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $key->key_tramite)->first();
                                    $ucd_tramite = $consulta->medium;
                                }elseif ($metros >= 400) {
                                    /////grande
                                    $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $key->key_tramite)->first();
                                    $ucd_tramite = $consulta->large;
                                }    
                                
                                ///////DENOMINACION E IDENTIFICADOR DE DENOMINACION
                                $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=',$ucd_tramite)->where('alicuota','=',7)->first();
                                $key_deno = $q5->id;
                                $identificador_ucd = $q5->identificador;
            
                                $total_ucd = $total_ucd + $ucd_tramite;

                                $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                            'key_tramite' => $key->key_tramite, 
                                                                            'forma' => $key->forma,
                                                                            'cantidad' => 1,
                                                                            'metros' => $metros,
                                                                            'capital' => null]); 
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
                                                                <div class="">
                                                                    <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                                                    <table class="table table-borderless table-sm">
                                                                        <tr>
                                                                            <th>Ente:</th>
                                                                            <td>'.$consulta_tramite->ente.'</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Tramite:</th>
                                                                            <td>'.$consulta_tramite->tramite.'</td>
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
                                        return response()->json(['success' => false]);
                                    }
                                }else{
                                    //// eliminar venta
                                    return response()->json(['success' => false]);
                                }
                            } ///cierra foreach

                            

                            //////////////////////////////////////  UPDATE INVENTARIO TAQUILLAS
                            $inv1 = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=',$id_taquilla)->first();
                            $new_inv_tfe = $inv1->cantidad_tfe - $cant_tfe;
                            $update_inv_tfe = DB::table('inventario_taquillas')->where('key_taquilla','=',$id_taquilla)->update(['cantidad_tfe' => $new_inv_tfe]);

                            ///////////////////////////////////// UPDATE TOTAL UCD / BOLIVARES (TABLE VENTAS)
                            $total_bolivares = $total_ucd * $valor_ucd;
                            $update_venta = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['total_ucd' => $total_ucd, 'total_bolivares' => $total_bolivares]);

                            $formato_total_bolivares =  number_format($total_bolivares, 2, ',', '.');

                            ///////////////////////////////////// PAGO DE TIMBRE(S)
                            $tr_detalle_debito = '<tr>
                                                        <th>Punto</th>
                                                        <td colspan="2" class="table-warning">Exención - No Aplica</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Efectivo</th>
                                                        <td colspan="2" class="table-warning">Exención - No Aplica</td>
                                                    </tr>';

                            $tr_detalle_timbres = '<tr>
                                                    <td>TFE-14</td>
                                                    <td>'.$cant_tfe.'</td>
                                                    <td>'.$cant_ucd_tfe.'</td>
                                                </tr>';
                            


                            $html_pago = '<div class="border rounded-3 py-2 px-3">
                                                <div class="d-flex flex-column text-center">
                                                    <div class="fw-bold text-navy">Servicio Tributario del Estado Aragua</div>
                                                    <div class="text-muted">G-20008920-2</div>
                                                </div>

                                                <table class="table table-sm my-3">
                                                    <tr>
                                                        <th>Forma</th>
                                                        <th>Cant.</th>
                                                        <th>UCD</th>
                                                    </tr>
                                                    '.$tr_detalle_timbres.'
                                                </table>

                                                <div class="d-flex justify-content-center">
                                                    <table class="table table-sm w-50">
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

                                                <table class="table table-sm">
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
                                        <a href="'.route("asignado").'" class="btn btn-secondary btn-sm me-3">Cancelar</a>
                                    </div>
                                </div>';
                            
                            // UPDATE CONDICION EXENCION 
                            $fecha_impresion = date('Y-m-d h:m:s');
                            $update_con = DB::table('exenciones')->where('id_exencion','=',$id_exencion)->update(['fecha_impresion' => $fecha_impresion,'estado' => 20]);

                            return response()->json(['success' => true, 'html' => $html]);




                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }

                }else{
                    // // BITACORA = INTENTO DE VENTA TAQUILLA CERRADA (TAQUILLERO)
                    return response()->json(['success' => false, 'nota'=> 'Acción invalida. Taquilla Cerrada.']);
                }
            }else{
                // // BITACORA = INTENTO DE VENTA SIN APERTURA DE TAQUILLA (TAQUILLERO)
                return response()->json(['success' => false, 'nota'=> 'Acción invalida. Debe aperturar taquilla.']);
            }
        }else{
            ////no hay registro, ADMIN no ha aperturado taquilla.
            // BITACORA = INTENTO DE VENTA SIN APERTURA DE TAQUILLA
            return response()->json(['success' => false, 'nota'=> 'Acción invalida. La taquilla no ha sido aperturada.']);
        }
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
