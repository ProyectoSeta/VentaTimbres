<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ArqueoTemporalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // FECHA HOY (FORMATO)
        $hoy = date('Y-m-d');
        $fecha = $hoy;
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');


        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla','clave')->where('key_funcionario','=',$query->key_sujeto)->first();
        if ($q2) {
            /// usuario taquillero
            $id_taquilla = $q2->id_taquilla;

            //  ARQUEO
            $recaudado = 0;
            $punto = 0;
            $transferencia = 0;
            $efectivo = 0;
            $recaudado_tfe = 0;
            $recaudado_est = 0;
            $cantidad_tfe = 0;
            $cantidad_est = 0; 
            $anulado_bs_tfe = 0;
            $efectivo_taq = 0;

            $bs_boveda = 0;
            $fondo_caja = 0;

            $q1 = DB::table('ventas')->select('id_venta','total_bolivares','key_ucd')
                                    ->where('key_taquilla','=',$id_taquilla)
                                    ->whereDate('fecha', $hoy)->get();
            if ($q1) {
                foreach ($q1 as $key) {
                    // CONSULTA UCD
                    $c1 = DB::table('ucds')->select('valor')->where('id','=',$key->key_ucd)->first();
                    $con_ut = DB::table('configuraciones')->select('valor')->where('nombre','=','Precio U.T.')->first();
                    $valor_ucd = $c1->valor;
                    $valor_ut = $con_ut->valor;

                    // PUNTO Y EFECTIVO
                    $q2 = DB::table('pago_ventas')->where('key_venta','=',$key->id_venta)->get();
                    foreach ($q2 as $pago) {
                        if ($pago->metodo == 5) {
                            //PUNTO
                            $punto = $punto + $pago->monto;
                        }elseif ($pago->metodo == 20) {
                            //TRANSFERENCIA
                            $transferencia = $transferencia + $pago->monto;
                        }else{
                            //EFECTIVO
                            $efectivo = $efectivo + $pago->monto;
                        }

                        if ($pago->anulado != NULL) {
                            $anulado_bs_tfe = $anulado_bs_tfe + $pago->anulado;
                        }
                    }
                    

                    // (RECAUDACION Y CANTIDAD) TFE Y EST
                    $q3 = DB::table('detalle_ventas')->where('key_venta','=',$key->id_venta)->get();
                    foreach ($q3 as $value) {
                        if ($value->forma == 3) {
                            // FORMA 14
                            $cantidad_tfe++;

                            if ($value->capital != NULL) {
                                // bs
                                $recaudado_tfe = $recaudado_tfe + $value->bs;
                            }else{
                                // ucd
                                $ucd_bs = $value->ucd * $valor_ucd;
                                $recaudado_tfe = $recaudado_tfe + $ucd_bs;
                            }
                        }
                    }

                    /////
                        $con_est = DB::table('detalle_venta_estampillas')->select("key_denominacion")->where('key_venta','=',$key->id_venta)->get();
                        foreach ($con_est as $k) {
                            if ($k->key_denominacion == 15) {
                                # 20UT
                                $recaudado_est = $recaudado_est + (20 * $valor_ut);
                                $cantidad_est = $cantidad_est + 1;
                            }elseif ($k->key_denominacion == 16) {
                                # 50UT
                                $recaudado_est = $recaudado_est + (50 * $valor_ut);
                                $cantidad_est = $cantidad_est + 1;
                            }

                            
                        }
                    /////
                    
                } //cierra foreach
            }else{
                // sin ventas
            }


            ////le resto a lo recaudado por tfe lo anulado en bs
            $recaudado_tfe = $recaudado_tfe - $anulado_bs_tfe;
            $recaudado = $recaudado_tfe + $recaudado_est;


            // DETALLE_EFECTIVO
            //FONDO DE CAJA
            $c1 = DB::table('apertura_taquillas')->select('fondo_caja')->whereDate('fecha', $hoy)->where('key_taquilla','=',$id_taquilla)->first();
            if ($c1->fondo_caja != NULL || $c1->fondo_caja != 0) {
                $fondo_caja = $c1->fondo_caja;
            }else{
                $fondo_caja = 0;
            }

            ///BOLIVARES EN BOVEDA
            $c2 = DB::table('boveda_ingresos')->select('monto')->whereDate('fecha', $hoy)->where('key_taquilla','=',$id_taquilla)->get();
            if ($c2) {
                foreach ($c2 as $key) {
                    $bs_boveda = $bs_boveda + $key->monto;
                }
                
            }

            ///EFECTIVO EN TAQUILLA
            if ($efectivo != 0 || $efectivo != NULL) {
                $efectivo_taq = ($efectivo + $fondo_caja) - $bs_boveda;
            }else{
                $efectivo_taq = 0;
            }


            // VENTAS DEL DÍA
            $ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                    ->where('ventas.key_taquilla','=',$id_taquilla)
                                    ->whereDate('ventas.fecha', $hoy)
                                    ->get();

                        
            return view('arqueo_temporal', compact('hoy_view','fecha','id_taquilla','efectivo_taq','bs_boveda','fondo_caja','ventas','recaudado','punto','transferencia','efectivo','recaudado_tfe','recaudado_est','cantidad_tfe','cantidad_est','anulado_bs_tfe'));
            
        }else{
            ////no esta asignado a ninguna taquilla
            /////BITACORA 
            $accion = 'IMPORTANTE: INTENTO DE CIERRE DE TAQUILLA SIN EL CARGO DE TAQUILLERO.';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 10, 'accion'=> $accion]);
            return response()->json(['success' => false, 'nota' => 'Disculpe, usted no se encuentra asociado a ninguna taquilla.']);
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
