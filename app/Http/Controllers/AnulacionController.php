<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AnulacionController extends Controller
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
        return view('anular');
    }




    public function search_tfe(Request $request)
    {
        $timbre = $request->post('timbre');

        $length = 6;

        $con1 = DB::table('detalle_venta_tfes')->select('key_detalle_venta','key_venta','nro_timbre','key_denominacion','bolivares','key_inventario_tfe','serial','qr','condicion','sustituto')->where('nro_timbre','=',$timbre)->first();
        if ($con1) {
            if ($con1->condicion == 7 || $con1->condicion == 30) {
                ///vendido o reimpreso
                $con2 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                        ->select('tramites.tramite')->where('detalle_ventas.correlativo','=',$con1->key_detalle_venta)->first();
                $con3 =  DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                        ->select('ventas.fecha','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro','contribuyentes.condicion_sujeto')
                                        ->where('ventas.id_venta','=',$con1->key_venta)->first();
                if ($con2 && $con3) {
                    $formato_nro = substr(str_repeat(0, $length).$con1->nro_timbre, - $length);

                    if ($con1->bolivares != null) {
                        $monto = number_format($con1->bolivares, 2, ',', '.').' Bs.';
                    }else{
                        $query = DB::table('ucd_denominacions')->join('tipos', 'ucd_denominacions.alicuota', '=','tipos.id_tipo')->select('ucd_denominacions.denominacion','tipos.nombre_tipo')
                                                                ->where('ucd_denominacions.id','=',$con1->key_denominacion)->first();
                        $monto = $query->denominacion.' '.$query->nombre_tipo.'';
                    }

                


                    ///ID LOTE PAPEL
                    $con4 = DB::table('inventario_tfes')->select('key_lote_papel')->where('correlativo','=',$con1->key_inventario_tfe)->first();

                    ///CONDICION SUJETO
                    $con5 = DB::table('tipos')->select('nombre_tipo')->where('id_tipo','=',$con3->condicion_sujeto)->first();

                    $html = '<form id="form_anular_tfe" method="post" onsubmit="event.preventDefault(); anularTFE()">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="d-flex flex-column my-2">
                                            <span>No Timbre (Correlativo de Papel)</span>
                                            <span class="text-danger fs-5 fw-bold titulo">A-'.$formato_nro.' </span>
                                        </div>
                                        <div class="d-flex flex-column my-2">
                                            <span>Serial</span>
                                            <span class="fw-semibold fs-5">'.$con1->serial.'</span>
                                        </div>
                                        <div class="d-flex flex-column my-2">
                                            <span>Monto (UCD|Bs)</span>
                                            <span class="fs-4 text-navy fw-bold">'.$monto.'</span>
                                        </div>
                                        <div class="d-flex flex-column my-2">
                                            <span>Fecha de Emisión (Venta)</span>
                                            <span class="fs-5 text-muted fw-bold">'.date("d-m-Y h:i A",strtotime($con3->fecha)).'</span>
                                        </div>
                                        <div class=" my-2">
                                            <img src="'.asset(''.$con1->qr.'').'" class="img-fluid" alt="" width="110px">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="d-flex flex-column my-2">
                                            <span>Contribuyente</span>
                                            <div class="d-flex flex-column">
                                                <span class="text-navy fs-5 fw-bold titulo">'.$con3->nombre_razon.'<span class="badge ms-2 fs-6 text-bg-secondary">'.$con5->nombre_tipo.'</span></span>
                                                <span class="text-muted fs-5 fw-bold titulo">'.$con3->identidad_condicion.'-'.$con3->identidad_nro.'</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column my-2">
                                            <span>Tramite</span>
                                            <span class="fs-5 text-muted">'.$con2->tramite.' </span>
                                        </div>

                                    </div>
                                    <div class="col-lg-2">
                                        <div class="fw-bold titulo fs-5">Origen</div>
                                        <div class="d-flex flex-column my-2">
                                            <span>ID Venta</span>
                                            <a href="#" class="fs-5 detalle_venta" venta="'.$con1->key_venta.'" data-bs-toggle="modal" data-bs-target="#modal_detalle_venta">#'.$con1->key_venta.' </a>
                                        </div>
                                        <div class="d-flex flex-column my-2">
                                            <span>ID Lote de Papel</span>
                                            <span class="fs-5">#'.$con4->key_lote_papel.' </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <img src="'.asset('assets/timbre.svg').'" class="shadow-sm mx-auto img-fluid" alt="" style="width: 100%; height: 300px;">
                                    </div>
                                </div>
                                <input type="hidden" name="timbre" value="'.$timbre.'">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-danger mb-3 ms-3">Anular Timbre</button>
                                </div>
                            </form>';


                    return response()->json(['success' => true, 'html' => $html]);
                }else{
                    return response()->json(['success' => false]);
                }
            }elseif ($con1->condicion == 29) {
                ////anulado
                $html = '<div class="text-center display-6 text-danger">
                            ESTE TIMBRE YA HA SIDO ANULADO EN EL PROCESO DE FALLA DE IMPRESIÓN.</br>
                            <span class="text-navy fs-6">
                                Para mas Información sobre el Timbre, dirigase a la sección de Consulta.
                            </span>
                        </div>';
                return response()->json(['success' => false, 'html' => $html]);

            }
        }else{
            $html = '<div class="text-center display-6 text-danger">
                        TIMBRE SIN VENTA
                    </div>';
            return response()->json(['success' => false, 'html' => $html]);
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
    public function anular(Request $request)
    {
        $timbre = $request->post('timbre');
        

        $con1 = DB::table('detalle_venta_tfes')->select('correlativo','key_venta','key_detalle_venta','condicion')->where('nro_timbre','=',$timbre)->first();
        if ($con1){
            if ($con1->condicion == 7 || $con1->condicion == 30) {
                

                $con3 = DB::table('ventas')->select('key_ucd')->where('id_venta','=',$con1->key_venta)->first();
                $con4 = DB::table('detalle_venta_tfes')->select('key_denominacion','bolivares')->where('correlativo','=',$con1->correlativo)->first();

                if ($con3 && $con4) {
                    if ($con4->bolivares == null) {
                        $con_ucd = DB::table('ucds')->select('valor')->where('id','=',$con3->key_ucd)->first();
                        ///ucd
                        $con_deno = DB::table('ucd_denominacions')->select('denominacion')->where('id','=',$con4->key_denominacion)->first();
                        $anulado_bs = $con_deno->denominacion * $con_ucd->valor;
                    }else{
                        ///bs
                        $anulado_bs = $con4->bolivares;
                    }

                    $con_pago = DB::table('pago_ventas')->select('monto','anulado')->where('key_venta','=',$con1->key_venta)->first();
                    // return response($con_pago->anulado);
                    if ($con_pago->anulado == NULL) {
                        $monto_new = $con_pago->monto - $anulado_bs;
                    }else{
                        $monto_new = $con_pago->monto - $anulado_bs;
                        ////se han anulado timbres de esta venta 
                        $anulado_bs = $anulado_bs + $con_pago->anulado;
                    }

                    
                    $update_pago = DB::table('pago_ventas')->where('key_venta','=',$con1->key_venta)->update(['monto' => $monto_new, 'anulado' => $anulado_bs]); 
                    $update = DB::table('detalle_venta_tfes')->where('nro_timbre','=',$timbre)->update(['condicion' => 29]); 
                    if ($update && $update_pago) {
                        /////BITACORA
                        $user = auth()->id();
                        $accion = 'ANULACIÓN DE TIMBRE '.$timbre.'.';
                        $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 1, 'accion'=> $accion]);

                        return response()->json(['success' => true]);
                    }else{
                        return response()->json(['success' => false]);
            
                    }

                }else{
                    ///return false
                }

            }elseif ($con1->condicion == 29) {
                return response()->json(['success' => false, 'nota' => 'ESTE TIMBRE YA HA SIDO ANULADO EN EL PROCESO DE FALLA DE IMPRESIÓN..']);
            }
        }else{
            return response()->json(['success' => false, 'nota' => 'Timbre sin venta.']);
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
    public function destroy(string $id)
    {
        //
    }
}
