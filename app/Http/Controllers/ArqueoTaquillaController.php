<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ArqueoTaquillaController extends Controller
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
        // comprobar que la taquilla ha sio cerrada para mostrar el arqueo PENDIENTE
        $hoy = date('Y-m-d');
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;

        $c1 = DB::table('apertura_taquillas')->select('cierre_taquilla','fondo_caja')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->first();
        if ($c1) {
            if ($c1->cierre_taquilla != NULL) {
                // FECHA HOY (FORMATO)
                $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
                $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');

                // VENTAS DEL DÍA
                $ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                        ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                        ->where('ventas.key_taquilla','=',$id_taquilla)
                                        ->where('ventas.fecha','=',$hoy)
                                        ->get();
                
                // DETALLE ARQUEO
                $arqueo = DB::table('cierre_taquillas')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->first();

                // DETALLE_EFECTIVO
                $fondo_caja = $c1->fondo_caja;
                $bs_boveda = 0;

                $c2 = DB::table('boveda_ingresos')->select('monto')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->get();
                if ($c2) {
                    foreach ($c2 as $key) {
                        $bs_boveda = $bs_boveda + $key->monto;
                    }
                    
                }

                $efectivo_taq = ($arqueo->efectivo + $fondo_caja) - $bs_boveda;


                return view('arqueo',compact('hoy_view','ventas','arqueo','bs_boveda','efectivo_taq','fondo_caja'));
            }else{
                //no ha cerrado taquilla
                return redirect()->action([HomeController::class, 'index']);
            }
        }else{
            /////taquilla sin aperturar
            return redirect()->action([HomeController::class, 'index']);
        }

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
    public function contribuyente(Request $request)
    {
        $sujeto = $request->post('sujeto');

        $c1 = DB::table('contribuyentes')->join('tipos', 'contribuyentes.condicion_sujeto', '=','tipos.id_tipo')
                                        ->select('contribuyentes.*','tipos.nombre_tipo')
                                        ->where('contribuyentes.id_contribuyente','=',$sujeto)->first();

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$c1->nombre_razon.'</h1>
                        <h5 class="modal-title text-muted" id="" style="font-size:14px">Contribuyente</h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <h6 class="text-muted text-center" style="font-size:13px;">Datos del Sujeto pasivo</h6>
                    <table class="table text-center" style="font-size:14px">
                        <tr>
                            <th>R.I.F.</th>
                            <td>'.$c1->identidad_condicion.'-'.$c1->identidad_nro.'</td>
                        </tr>
                        <tr>
                            <th>Razón Social</th>
                            <td>'.$c1->nombre_razon.' <span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span></td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-center my-2 mt-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>';

        return response($html);
    }

    /**
     * Display the specified resource.
     */
    public function timbres(Request $request)
    {
        $id_venta = $request->post('venta');
        $timbres = '';

        $q1 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                        ->select('detalle_ventas.*','tramites.tramite','tramites.key_ente')
                                        ->where('detalle_ventas.key_venta','=',$id_venta)->get();
        foreach ($q1 as $key) {
            $c1 = DB::table('entes')->select('ente')->where('id_ente','=',$key->key_ente)->first();
            $length = 6;

            if ($key->forma == 3) {
                // FORMA 14
                $c2 = DB::table('detalle_venta_tfes')->where('key_detalle_venta','=',$key->correlativo)->first();
                $formato_nro = substr(str_repeat(0, $length).$c2->nro_timbre, - $length);

                if ($key->capital == null) {
                    $timbres .= '<div class="border mb-4 rounded-3">
                            <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                <!-- DATOS -->
                                <div class="w-50">
                                    <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th>Ente:</th>
                                            <td>'.$c1->ente.'</td>
                                        </tr>
                                        <tr>
                                            <th>Tramite:</th>
                                            <td>'.$key->tramite.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- UCD -->
                                <div class="">
                                    <div class="text-center titulo fw-bold fs-3">'.$key->ucd.' UCD</div>
                                </div>
                            </div>
                        </div>';
                }else{
                    $formato_bs =  number_format($key->bs, 2, ',', '.');
                    $timbres .= '<div class="border mb-4 rounded-3">
                            <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                <!-- DATOS -->
                                <div class="w-50">
                                    <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th>Ente:</th>
                                            <td>'.$c1->ente.'</td>
                                        </tr>
                                        <tr>
                                            <th>Tramite:</th>
                                            <td>'.$key->tramite.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- UCD -->
                                <div class="">
                                    <div class="text-center titulo fw-bold fs-3">'.$formato_bs.' Bs.</div>
                                </div>
                            </div>
                        </div>';
                }

            }else{
                // ESTAMPILLAS
                $c3 = DB::table('detalle_venta_estampillas')->where('key_detalle_venta','=',$key->correlativo)->get();
                foreach ($c3 as $value) {
                    $formato_nro = substr(str_repeat(0, $length).$value->nro_timbre, - $length);
                    $timbres .= '<div class="border mb-4 rounded-3">
                                    <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                        <!-- DATOS -->
                                        <div class="w-50">
                                            <div class="text-danger fw-bold fs-4" id="">'.$formato_nro.'<span class="text-muted ms-2">Estampilla</span></div> 
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <th>Ente:</th>
                                                    <td>'.$c1->ente.'</td>
                                                </tr>
                                                <tr>
                                                    <th>Tramite:</th>
                                                    <td>'.$key->tramite.'</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- UCD -->
                                        <div class="">
                                            <div class="text-center titulo fw-bold fs-3">'.$key->ucd.' UCD</div>
                                        </div>
                                    </div>
                                </div>';
                }
            }
        }

        $html = '<div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold d-flex align-items-center">
                        <i class="bx bx-detail fs-4 me-2 text-muted"></i>
                        <span class="text-navy">Detalle | <span class="text-muted">Timbres</span></span>
                    </h1>
                </div>
                <div class="modal-body px-4 py-3" style="font-size:13px">
                    <div class="">
                        '.$timbres.'
                    </div>
                </div>';

        return response($html);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detalle_venta(Request $request)
    {
        $id_venta = $request->post('venta');
        $table_detalles = '';
        $tr_pago = '';
        $tr_tramites = '';

        $venta = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro','contribuyentes.nombre_razon','contribuyentes.condicion_sujeto')
                                    ->where('ventas.id_venta','=',$id_venta)->first();
        if ($venta) {
            $c1 = DB::table('tipos')->select('nombre_tipo')->where('id_tipo','=',$venta->condicion_sujeto)->first();
            $table_detalles = '<table class="table table-sm w-50">
                                <tr>
                                    <th>ID</th>
                                    <td>'.$id_venta.'</td>
                                </tr>
                                <tr>
                                    <th>Contribuyente</th>
                                    <td>
                                        '.$venta->nombre_razon.'<span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span><br>
                                        <span>'.$venta->identidad_condicion.'-'.$venta->identidad_nro.'</span>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Hora</th>
                                    <td>'.date("h:i A",strtotime($venta->hora)).'</td>
                                </tr>
                                <tr>
                                    <th>Total UCD</th>
                                    <td>'.$venta->total_ucd.' UCD</td>
                                </tr>
                                <tr>
                                    <th>Total Bs.</th>
                                    <td>'.number_format($venta->total_bolivares, 2, ',', '.').' Bs.</td>
                                </tr>
                            </table>';
            
            // DETALLE PAGO
            $q1 = DB::table('pago_ventas')->join('tipos', 'pago_ventas.metodo','=','tipos.id_tipo')
                                    ->select('pago_ventas.*','tipos.nombre_tipo')
                                    ->where('pago_ventas.key_venta','=',$id_venta)->get();
            foreach ($q1 as $key) {
                if ($key->metodo == 5) {
                    $href = $key->comprobante; ///punto
                }else{
                    $href = '<span class="fst-italic text-secondary">No aplica</span>'; ///efectivo
                }
                $tr_pago .= '<tr>
                                <td>'.$key->nombre_tipo.'</td>
                                <td>'.$href.'</td>
                                <td>'.number_format($key->monto, 2, ',', '.').'</td>
                            </tr>';
            }

            // DETALLE TRAMITES
            $i = 0;
            $q2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite','=','tramites.id_tramite')
                                    ->select('detalle_ventas.*','tramites.tramite','tramites.alicuota')
                                    ->where('detalle_ventas.key_venta','=',$id_venta)->get();
            foreach ($q2 as $value) {
                $i++;
                if ($value->forma == 3) {
                    /// FORMA 14
                    $c2 = DB::table('detalle_venta_tfes')->select('serial')->where('key_detalle_venta','=',$value->correlativo)->get();
                    foreach ($c2 as $de) {
                        switch ($value->alicuota) {
                            case 7:
                                // UCD
                                if ($value->folios != NULL) {
                                    $anexo = '<span class="text-muted fst-italic">+ '.$value->folios.' Folios</span>';
                                }else{
                                    $anexo = '<span class="text-muted fst-italic">S/A</span>';
                                }                            
                                $tr_tramites .= '<tr>
                                                    <td>'.$i.'</td>
                                                    <td>'.$value->tramite.'</td>
                                                    <td>'.$anexo.'</td>
                                                    <td>'.$value->ucd.' UCD</td>
                                                    <td>TFE-14 ('.$de->serial.')</td>
                                                </tr>';
                                break;
                            case 8:
                                // PORCENTAJE
                                $tr_tramites .= '<tr>
                                                    <td>'.$i.'</td>
                                                    <td>'.$value->tramite.'</td>
                                                    <td><span class="text-muted fst-italic">Capital: '.number_format($value->capital, 2, ',', '.').' Bs.</span></td>
                                                    <td>'.number_format($value->bs, 2, ',', '.').' Bs.</td>
                                                    <td>TFE-14 ('.$de->serial.')</td>
                                                </tr>';
                                break;
                            case 13:
                                // METRADO
                                $tr_tramites .= '<tr>
                                                    <td>'.$i.'</td>
                                                    <td>'.$value->tramite.'</td>
                                                    <td><span class="text-muted fst-italic">'.$value->metros.' mt2.</span></td>
                                                    <td>'.$value->ucd.' UCD</td>
                                                    <td>TFE-14 ('.$de->serial.')</td>
                                                </tr>';
                                break;
                            default:
                                return response()->json(['success' => false]);
                                break;
                        }
                    }
                    
                }else{
                    /// ESTAMPILLAS
                    $est_c = '';
                    $c3 = DB::table('detalle_venta_estampillas')->join('ucd_denominacions', 'detalle_venta_estampillas.key_denominacion','=','ucd_denominacions.id')
                                                                ->select('detalle_venta_estampillas.serial','ucd_denominacions.denominacion')
                                                                ->where('detalle_venta_estampillas.key_detalle_venta','=',$value->correlativo)->get();
                    foreach ($c3 as $est) {
                        $est_c .= '<span>Est '.$est->denominacion.' UCD ('.$est->serial.')</span>';
                    }
                    $div_est = '<div class="d-flex flex-column">'.$est_c.'</div>';

                    if ($value->folios != NULL) {
                        $anexo = '<span class="text-muted fst-italic">+ '.$value->folios.' Folios</span>';
                    }else{
                        $anexo = '<span class="text-muted fst-italic">S/A</span>';
                    } 

                    $tr_tramites .= '<tr>
                                        <td>'.$i.'</td>
                                        <td>'.$value->tramite.'</td>
                                        <td>'.$anexo.'</td>
                                        <td>'.$value->ucd.' UCD</td>
                                        <td>'.$div_est.'</td>
                                    </tr>';
                }
            }

            $html = '<div class="modal-header p-2 pt-3">
                        <h1 class="fs-5 fw-bold d-flex align-items-center">
                            <i class="bx bx-detail fs-4 me-2 text-muted"></i>
                            <span class="text-navy">Detalle Venta</span>
                        </h1>
                    </div>
                    <div class="modal-body px-4" style="font-size:12.7px">
                        <div class="d-flex flex-column align-items-center mb-4">
                            '.$table_detalles.'
                            <h5 class="fw-bold titulo text-muted text-center">Pago</h5>
                            <table class="table table-sm w-50" style="font-size:12.7px">
                                <thead>
                                    <tr>
                                        <th>Metodo</th>
                                        <th>Ref.</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    '.$tr_pago.'
                                </tbody>
                            </table>
                        </div>

                        <h5 class="fw-bold titulo text-navy text-center">Tramites y Timbres</h5>
                        <table class="table table-sm text-center mb-3" style="font-size:12.7px">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="45%">Tramite</th>
                                    <th>Anexo</th>
                                    <th>UCD|Bs.</th>
                                    <th>Forma</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr_tramites.'
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <a class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modal_detalle_venta" >Cancelar</a>
                        </div>
                    </div>';
            return response()->json(['success' => true, 'html' => $html]); 
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function detalle_forma(Request $request)
    {
        $hoy = date('Y-m-d');
        $forma = $request->post('forma');

        $modal_header = "";
        $tr = "";
        $thead = '';
        $length = 6;

        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;

        $query = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('ventas.id_venta','contribuyentes.identidad_condicion','contribuyentes.identidad_nro','contribuyentes.nombre_razon','contribuyentes.condicion_sujeto')
                                    ->where('ventas.fecha','=',$hoy)->get();
        foreach ($query as $venta) {
            $c1 = DB::table('tipos')->select('nombre_tipo')->where('id_tipo','=',$venta->condicion_sujeto)->first();
            if ($forma == 3) {
                ////FORMA 14
                $q1 = DB::table('detalle_venta_tfes')->select('nro_timbre','serial','condicion','sustituto')->where('key_venta','=',$venta->id_venta)->get();
                foreach ($q1 as $key) {
                    switch ($key->condicion) {
                        case 7:
                            $nota = '<span class="text-muted fst-italic">S/N</span>';
                            break;
                        case 29:
                            $formato_sustituto = substr(str_repeat(0, $length).$key->sustituto, - $length);
                            $nota = '<div class="d-flex flex-column">
                                        <span class="badge text-bg-danger" style="font-size:13px" >Anulado</span>
                                        <span class="text-muted">Sustituto: <span class="text-danger">A-'.$formato_sustituto.'</span> </span>
                                    </div>';
                            break;
                        case 30:
                            $nota = '<span class="badge text-bg-secondary" style="font-size:13px" >Re-Impreso</span>';
                            break;
                    }

                    $formato_nro = substr(str_repeat(0, $length).$key->nro_timbre, - $length);
                    $tr .=   '<tr>
                                <td><span class="text-danger fw-bold fs-6">A-'.$formato_nro.'</span></td>
                                <td><span class="text-navy fw-semibold fw-6">'.$key->serial.'</span></td>
                                <td class="text-muted">'.$venta->id_venta.'</td>
                                <td>
                                    '.$venta->nombre_razon.'<span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span><br>
                                    <span class="text-muted">'.$venta->identidad_condicion.'-'.$venta->identidad_nro.'</span>
                                </td>
                                <td class="w-25">'.$nota.'</td>
                            </tr>';
                }
            }else{
                ////ESTAMPILLAS
                $q1 = DB::table('detalle_venta_estampillas')->select('key_denominacion','nro_timbre','serial')->where('key_venta','=',$venta->id_venta)->get();
                foreach ($q1 as $key) {
                    $c2 = DB::table('ucd_denominacions')->select('denominacion')->where('id','=',$key->key_denominacion)->first();
                    $formato_nro = substr(str_repeat(0, $length).$key->nro_timbre, - $length);
                    $tr .=   '<tr>
                                <td><span class="text-danger fw-bold fs-6">'.$formato_nro.'</span></td>
                                <td><span class="text-navy fw-semibold fw-6">'.$key->serial.'</span></td>
                                <td class="text-muted">'.$venta->id_venta.'</td>
                                <td class="">'.$c2->denominacion.' UCD</td>
                                <td>
                                    '.$venta->nombre_razon.'<span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span><br>
                                    <span class="text-muted">'.$venta->identidad_condicion.'-'.$venta->identidad_nro.'</span>
                                </td>
                            </tr>';
                }
            }
            
        }

        ////MODAL HEADER
        if ($forma == 3) {
            $modal_header = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                <div class="text-center">
                                    <i class="bx bx-receipt fs-2 text-muted me-2"></i>
                                    <h1 class="modal-title fs-5 fw-bold text-navy">Detalle | TFE-14 vendidos</h1>
                                </div>
                            </div>';
            $thead = '<thead>
                        <tr>
                            <th>No. Timbre</th>
                            <th>Serial</th>
                            <th>Id. Venta</th>
                            <th>Contribuyente</th>
                            <th>Nota</th>
                        </tr>
                    </thead>';
        }else{
            $modal_header = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                <div class="text-center">
                                    <i class="bx bx-receipt fs-2 text-muted me-2"></i>
                                    <h1 class="modal-title fs-5 fw-bold text-navy">Detalle | Estampillas vendidas</h1>
                                </div>
                            </div>';
            $thead = '<thead>
                        <tr>
                            <th>No. Timbre</th>
                            <th>Serial</th>
                            <th>Id. Venta</th>
                            <th>Denominación</th>
                            <th>Contribuyente</th>
                        </tr>
                    </thead>';
        }

        $html = ''.$modal_header.'
                <div class="modal-body px-4" style="font-size:13px">
                    <div class="table-responsive" style="font-size:12.7px">
                        <table class="table table-sm text-center" id="table_detalle_forma">
                            '.$thead.'
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                </div>';

        return response($html);
        


    }

    /**
     * Remove the specified resource from storage.
     */
    public function cierre_punto()
    {
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;
        $hoy = date('Y-m-d');
        $tr = '';

        $q1 = DB::table('ventas')->select('id_venta','hora')->where('key_taquilla','=',$id_taquilla)->where('fecha','=',$hoy)->get();
        foreach ($q1 as $value) {
            $con = DB::table('pago_ventas')->where('key_venta','=',$value->id_venta)->where('metodo','=',5)->get();
            foreach ($con as $key) {
                $formato = number_format($key->monto, 2, ',', '.');
                $tr .= '<tr>
                            <td>'.date("h:i A",strtotime($value->hora)).'</td>
                            <td>'.$key->comprobante.'</td>
                            <td>'.$formato.'</td>
                        </tr>';
            }
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-error-circle fs-2 text-danger me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Cierre de Punto</h1>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <div class="table-responsive py-2"style="font-size:12.7px">
                        <table class="table table-sm text-center" id="table_cierre_punto">
                            <thead>
                                <tr>
                                    <th>Hora (Aprox.)</th>
                                    <th>Referencia</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>
                    </div>
                </div>';

        return response($html);
    }
}
