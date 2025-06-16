<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HistorialCierresController extends Controller
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
        return view('historial_cierres');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $fecha = $request->post('fecha');

        //////APERTURAS DEL DÍA TAQUILLAS
        // $aperturas = [];

        $tr = '';
        $total = DB::table('apertura_taquillas')->selectRaw("count(*) as total")->whereDate('fecha', $fecha)->first();
        $query = DB::table('apertura_taquillas')->whereDate('fecha', $fecha)->get();

        if ($total->total != 0) {
            foreach ($query as $q1) {
                $q2 = DB::table('taquillas')->where('id_taquilla','=', $q1->key_taquilla)->first();
    
                $q3 = DB::table('sedes')->select('sede')->where('id_sede','=', $q2->key_sede)->first();
                $q4 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $q2->key_funcionario)->first();
    
                $hora_apertura = date("h:i A",strtotime($q1->apertura_admin));
                $estado = 1;
                $apertura_taquillero = '';
                if ($q1->apertura_taquillero != null) {
                    $apertura_taquillero = '<span class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill" style="font-size:12.7px">'.date("h:i A",strtotime($q1->apertura_taquillero)).'</span>';
                }else{
                    $apertura_taquillero = '<span class="fst-italic fw-bold text-muted">Taquillero sin Aperturar.</span>';
                }
    
                $cierre = '';

                $post_id = $q1->key_taquilla;
                $post_fecha = $fecha;

                if ($q1->cierre_taquilla != null) {
                    $cierre = '<span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:12.7px">'.date("h:i A",strtotime($q1->cierre_taquilla)).'</span>';
                    $arqueo = '<a href="'.route('cierre.arqueo', ['id' => $q1->key_taquilla, 'fecha' => $fecha]).'">Ver</a>';
                    $estado = 0;
                }else{
                    $cierre = '<button class="btn btn-secondary btn-sm rounded-3 cierre_taquilla" taquilla="'.$post_id.'" fecha="'.$post_fecha.'" style="font-size:12.7px">Realizar Cierre</button>';
                    $arqueo = '<span class="fst-italic fw-bold text-muted">Sin cierrar.</span>';
                }
                
                $tr .= '<tr>
                            <td>'.$q1->key_taquilla.'</td>
                            <td>'.$q3->sede.'</td>
                            <td>'.$q4->nombre.'</td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">'.$hora_apertura.'</span>
                            </td>
                            <td>
                                '.$apertura_taquillero.'
                            </td>
                            <td>
                                '.$cierre.'
                            </td>
                            <td>
                                '.$arqueo.'
                            </td>
                        </tr>';
            }
    
            $table_aperturas = '<p class="text-navy fw-bold fs-4 titulo">Cierre de Taquillas</p>
                                <div class="table-response" style="font-size:12.7px">
                                    <table class="table table-sm" style="font-size:12.7px" id="table_historial_cierre">
                                        <thead>
                                            <tr>
                                                <th>ID Taquilla</th>
                                                <th>Ubicación</th>
                                                <th>Taquillero</th>
                                                <th>Hora Apertura</th>
                                                <th>Apertura Taquillero</th>
                                                <th>Cierre Taquilla</th>
                                                <th>Arqueo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.$tr.'
                                        </tbody>
                                    </table>
                                </div>';
    
            //////// 
            $con = DB::table('cierre_diarios')->whereDate('fecha', $fecha)->first();
            if ($con) {
                $btn = '<a href="'.route('cierre_diario', ['fecha' => $fecha]).'" class="btn bg-navy rounded-pill px-3 text-center btn-sm fw-bold">
                            Ver Cierre del día
                        </a>';
            }else{
                $btn = '<button class="btn btn-secondary btn-sm rounded-3" id="cierre_general" fecha="'.$post_fecha.'" style="font-size:12.7px">Realizar Cierre General</button>';
            }

            $html = '<div class="d-flex justify-content-center">
                        '.$btn.'
                    </div>
                    '.$table_aperturas.'';
        }else{
            $html = '<div class="text-center fw-semibol fs-5 text-danger">SIN ACTIVIDAD</div>';
        }

        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function cierre_taquilla(Request $request)
    {
        $fecha = $request->post('fecha');
        $taquilla = $request->post('id');

        ////CIERRE
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

        $q1 = DB::table('ventas')->select('id_venta','total_bolivares','key_ucd')
                                ->where('key_taquilla','=',$taquilla)
                                ->whereDate('fecha', $fecha)->get();
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

        $hora = date('H:i:s');
        $fecha_bd = $fecha.' 16:00:00';
        $insert = DB::table('cierre_taquillas')->insert(['fecha' => $fecha_bd,
                                                        'key_taquilla' => $taquilla,
                                                        'recaudado' => $recaudado,
                                                        'punto' => $punto,
                                                        'efectivo' => $efectivo,
                                                        'transferencia' => $transferencia,
                                                        'recaudado_tfe' => $recaudado_tfe,
                                                        'recaudado_est' => $recaudado_est,
                                                        'cantidad_tfe' => $cantidad_tfe,
                                                        'cantidad_est' => $cantidad_est
                                                    ]); 
        if ($insert) {
            $update = DB::table('apertura_taquillas')->where('key_taquilla', '=', $taquilla)
                                                        ->whereDate('fecha', $fecha)
                                                        ->update(['cierre_taquilla' => '16:00:00']);
            $update_temp = DB::table('efectivo_taquillas_temps')->where('key_taquilla','=',$taquilla)->update(['efectivo' => '0']);
            if ($update) {
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            return response()->json(['success' => false]);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function cierre_general(Request $request)
    {
        $fecha = $request->post('fecha');

        $taquillas = [];
        $query = DB::table('apertura_taquillas')->select('key_taquilla','cierre_taquilla')->whereDate('fecha', $fecha)->get(); 
        if (!empty($query)) {
            foreach ($query as $key) {
                if ($key->cierre_taquilla == NULL) {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la acción no se puede realizar hasta que TODAS las taquillas aperturadas el día de hoy sean cerradas.']); 
                }

                array_push($taquillas,$key->key_taquilla);
            }
            
            /////////////////// CALCULAR CIERRES 
            $recaudado = 0;
            $punto = 0;
            $efectivo = 0;
            $transferencia = 0;
            $recaudado_tfe = 0;
            $recaudado_est = 0;
            $cantidad_tfe = 0;
            $cantidad_est = 0;

            $anulado_bs_tfe = 0;

            foreach ($taquillas as $taquilla) {
                $id_taquilla = $taquilla;

                $q1 = DB::table('ventas')->select('id_venta','total_bolivares','key_ucd')
                                        ->where('key_taquilla','=',$id_taquilla)
                                        ->whereDate('fecha', $fecha)->get();
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

                            if ($pago->anulado != null) {
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
                            // else{
                            //     // ESTAMPILLAS
                            //     $con_20 = DB::table('detalle_venta_estampillas')->selectRaw("count(*) as total")->where('key_denominacion','=',15)->where('key_detalle_venta','=',$value->correlativo)->first();
                            //     $con_50 = DB::table('detalle_venta_estampillas')->selectRaw("count(*) as total")->where('key_denominacion','=',16)->where('key_detalle_venta','=',$value->correlativo)->first();
                                
                            //     $total_20 = $con_20->total * (20 * $valor_ut);
                            //     $total_50 = $con_50->total * (50 * $valor_ut);
                                
                            //     $cantidad_est = $cantidad_est + ($con_20->total + $con_50->total);

                            //     // $ucd_bs = $value->ucd * $valor_ucd;
                            //     $recaudado_est = $recaudado_est + ($total_20 + $total_50);

                            // }
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
            } //cierra foreach taquillas


            ////le resto a lo recaudado por tfe lo anulado en bs
            $recaudado_tfe = $recaudado_tfe - $anulado_bs_tfe;
            $recaudado = $recaudado_tfe + $recaudado_est;

            $insert = DB::table('cierre_diarios')->insert(['fecha' => $fecha,
                                                            'recaudado' => $recaudado,
                                                            'punto' => $punto,
                                                            'efectivo' => $efectivo,
                                                            'transferencia' => $transferencia,
                                                            'recaudado_tfe' => $recaudado_tfe,
                                                            'recaudado_est' => $recaudado_est,
                                                            'cantidad_tfe' => $cantidad_tfe,
                                                            'cantidad_est' => $cantidad_est
                                                        ]); 
            if ($insert) {
                ////BITACORA
                $user = auth()->id();
                $accion = 'CIERRE GENERAL ('.$fecha.') REALIZADO, USER ID:'.$user.' ';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 2, 'accion'=> $accion]);
            return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }




        }else{
            return response()->json(['success' => false, 'nota' => 'Hoy no ha sido aperturada ninguna Taquilla.']);
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
