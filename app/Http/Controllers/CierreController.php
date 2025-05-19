<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CierreController extends Controller
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
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');

        $hoy = date('Y-m-d');
        $aperturas = [];
        $query = DB::table('apertura_taquillas')->where('fecha','=', $hoy)->get();

        foreach ($query as $q1) {
            $q2 = DB::table('taquillas')->where('id_taquilla','=', $q1->key_taquilla)->first();

            $q3 = DB::table('sedes')->select('sede')->where('id_sede','=', $q2->key_sede)->first();
            $q4 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $q2->key_funcionario)->first();

            $hora_apertura = date("h:i A",strtotime($q1->apertura_admin));
            $estado = 1;
            $apertura_taquillero = '';
            if ($q1->apertura_taquillero != null) {
                $apertura_taquillero = date("h:i A",strtotime($q1->apertura_taquillero));
            }else{
                $apertura_taquillero = $q1->apertura_taquillero;
            }

            $cierre = '';
            if ($q1->cierre_taquilla != null) {
                $cierre = date("h:i A",strtotime($q1->cierre_taquilla));
                $estado = 0;
            }else{
                $cierre = $q1->cierre_taquilla;
            }
            

            $array = array(
                        'correlativo' => $q1->correlativo,
                        'id_taquilla' => $q1->key_taquilla,
                        'ubicacion' => $q3->sede,
                        'taquillero' => $q4->nombre,
                        'hora_apertura' => $hora_apertura,
                        'apertura_taquillero' => $apertura_taquillero,
                        'cierre_taquilla' => $cierre,
                        'estado' => $estado
                    );
            $a = (object) $array;
            array_push($aperturas,$a);
        }


        $con_cierre = DB::table('cierre_diarios')->where('fecha','=', $hoy)->first();
        if ($con_cierre) {
           $condicion = 'false';
        }else{
            $condicion = 'true';
        }


        return view('cierre', compact('hoy_view','aperturas','condicion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function comprobar()
    {
        $hoy = date('Y-m-d');
        $taquillas = [];
        $query = DB::table('apertura_taquillas')->select('key_taquilla','cierre_taquilla')->where('fecha','=', $hoy)->get(); //return response($query);
        if (!empty($query)) {
            foreach ($query as $key) {
                if ($key->cierre_taquilla == NULL) {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la acción no se puede realizar hasta que TODAS las taquillas aperturadas el día de hoy sean cerradas.']); 
                }

                array_push($taquillas,$key->key_taquilla);
            }
            return response()->json(['success' => true, 'taquillas' => $taquillas]);
        }else{
            return response()->json(['success' => false, 'nota' => 'Hoy no ha sido aperturada ninguna Taquilla.']);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registro_cierre(Request $request)
    {
        $taquillas = $request->post('taquillas');
        $hoy = date('Y-m-d');

        $recaudado = 0;
        $punto = 0;
        $efectivo = 0;
        $recaudado_tfe = 0;
        $recaudado_est = 0;
        $cantidad_tfe = 0;
        $cantidad_est = 0;

        foreach ($taquillas as $taquilla) {
            $id_taquilla = $taquilla;

            $q1 = DB::table('ventas')->select('id_venta','total_bolivares','key_ucd')
                                    ->where('key_taquilla','=',$id_taquilla)
                                    ->where('fecha','=',$hoy)->get();
            if ($q1) {
                foreach ($q1 as $key) {
                    $recaudado = $recaudado + $key->total_bolivares;

                    // CONSULTA UCD
                    $c1 = DB::table('ucds')->select('valor')->where('id','=',$key->key_ucd)->first();
                    $valor_ucd = $c1->valor;

                    // PUNTO Y EFECTIVO
                    $q2 = DB::table('pago_ventas')->where('key_venta','=',$key->id_venta)->get();
                    foreach ($q2 as $pago) {
                        if ($pago->metodo == 5) {
                            //PUNTO
                            $punto = $punto + $pago->monto;
                        }else{
                            //EFECTIVO
                            $efectivo = $efectivo + $pago->monto;
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
                        }else{
                            // ESTAMPILLAS
                            $q4 = DB::table('detalle_venta_estampillas')->selectRaw("count(*) as total")->where('key_detalle_venta','=',$value->correlativo)->first();
                            $cantidad_est = $cantidad_est + $q4->total;

                            $ucd_bs = $value->ucd * $valor_ucd;
                            $recaudado_est = $recaudado_est + $ucd_bs;
                        }
                    }
                } //cierra foreach
            }else{
                // sin ventas
            }
        } //cierra foreach taquillas



        $insert = DB::table('cierre_diarios')->insert(['fecha' => $hoy,
                                                        'recaudado' => $recaudado,
                                                        'punto' => $punto,
                                                        'efectivo' => $efectivo,
                                                        'recaudado_tfe' => $recaudado_tfe,
                                                        'recaudado_est' => $recaudado_est,
                                                        'cantidad_tfe' => $cantidad_tfe,
                                                        'cantidad_est' => $cantidad_est
                                                    ]); 
        if ($insert) {
           return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function arqueo(Request $request)
    {
        $id_taquilla = $request->id;
        $hoy = date('Y-m-d');

        $c1 = DB::table('apertura_taquillas')->select('cierre_taquilla','fondo_caja')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->first();
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


        return view('arqueo',compact('hoy_view','ventas','arqueo','bs_boveda','efectivo_taq','fondo_caja','id_taquilla'));
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
