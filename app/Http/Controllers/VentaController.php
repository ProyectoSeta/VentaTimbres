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
        $q1 =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $ucd = $q1->valor;
        return view('venta', compact('entes','tramites','ucd'));
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



    // public function metros(Request $request){
    //     $tramite = $request->post('tramite');
    //     $metros = $request->post('value');

    //     if ($metros == '' || $metros == 0) {
    //         return response('0');
    //     }else{
    //         if ($metros <= 150) {
    //             ////pequeña
    //             $query = DB::table('tramites')->select('small')->where('id_tramite','=', $tramite)->first();
    //             return response($query->small);
    //         }elseif ($metros > 150 && $metros < 400) {
    //             /////mediana
    //             $query = DB::table('tramites')->select('medium')->where('id_tramite','=', $tramite)->first();
    //             return response($query->medium);
    //         }elseif ($metros >= 400) {
    //             /////grande
    //             $query = DB::table('tramites')->select('large')->where('id_tramite','=', $tramite)->first();
    //             return response($query->large);
    //         }
    //     }
        
    // }



    public function alicuota(Request $request){
        $tramite = $request->post('tramite');
        $condicion_sujeto = $request->post('condicion_sujeto');
        $metros = $request->post('metros');
        $capital = $request->post('capital');

        $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
        if ($query) {
            switch ($query->alicuota) {
                case 7:
                    // UCD
                    if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                        //////juridico (firma personal - empresa)
                        return response()->json(['success' => true, 'valor' => $query->juridico, 'alicuota' => $query->alicuota]);
                    }else{
                        ////natural
                        return response()->json(['success' => true, 'valor' => $query->natural, 'alicuota' => $query->alicuota]);
                    }
                case 8:
                    // PORCENTAJE
                    if (!empty($capital)){
                        $monto_porcentaje = ($capital * $query->porcentaje) / 100;
                        $monto_format = number_format($monto_porcentaje, 2, ',', '.');
                        return response()->json(['success' => true, 'valor' => $monto_porcentaje, 'valor_format' => $monto_format, 'alicuota' => $query->alicuota, 'porcentaje' => $query->porcentaje]);
                    }else{
                        return response()->json(['success' => true, 'valor' => 0, 'alicuota' => $query->alicuota, 'porcentaje' => $query->porcentaje]);
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
                                return response()->json(['success' => true, 'valor' => $query->small, 'alicuota' => $query->alicuota, 'size' => 'small']);
                            }elseif ($metros > 150 && $metros < 400) {
                                /////mediana
                                return response()->json(['success' => true, 'valor' => $query->medium, 'alicuota' => $query->alicuota, 'size' => 'medium']);
                            }elseif ($metros >= 400) {
                                /////grande
                                return response()->json(['success' => true, 'valor' => $query->large, 'alicuota' => $query->alicuota, 'size' => 'large']);
                            }
                        }
                    }else{
                        // no hay metros
                        return response()->json(['success' => true, 'valor' => 0, 'alicuota' => $query->alicuota]);
                    }
                    
            }
        }else{
            return response()->json(['success' => false]);
        }
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

        $total_bolivares = $total_bolivares + ($total_ucd * $valor_ucd);
        $total_bolivares_format = number_format($total_bolivares, 2, ',', '.');

        return response()->json(['success' => true, 'ucd' => $total_ucd, 'bolivares' => $total_bolivares_format]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function debitado(Request $request)
    {
        $value = $request->post('value');
        $otro_debito = $request->post('otro_debito');
        $metros = $request->post('metros');
        $condicion_sujeto = $request->post('condicion_sujeto');

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
        
        $tramites = $request->post('tramites');

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
        
        $total_bolivares = $total_ucd * $valor_ucd;

        
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
                    $consulta_ucd = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',5)->first();
                    $key_denominacion = $consulta_ucd->id;
                }else{
                    $consulta_ucd = DB::table('ucd_denominacions')->select('id')->where('denominacion','=', $ucd)->first();
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
                    return response()->json(['success' => false, 'nota' => 'No hay suficientes estampillas de '.$ucd_nota.' UCD, en el Inventario de la Taquilla.']);
                }
            }/////cierra estampillas

        }////cierra foreach


    }




    public function venta(Request $request){
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

        
        ///////////////////////////////////// CONTRIBUYENTE
            $condicion_sujeto = $request->post('condicion_sujeto');
            $identidad_condicion = $request->post('identidad_condicion');
            $identidad_nro = $request->post('identidad_nro');

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
            foreach ($tramites as $tramite) {
                $key_tramite = $tramite['tramite'];
                $forma = $tramite['forma'];

                if ($forma == 'Seleccione' || $forma == '') {
                    return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar la Forma.']);
                }

                if ($key_tramite == 'Seleccione' || $key_tramite == '') {
                    return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar el Tramite.']);
                }
                
            }

      


        ///////////////////////////////////// INSERT DETALLE Y SUMA TOTAL 
            $total_ucd = 0;
        
            $array_correlativo_tfe = [];
            $array_correlativo_estampillas = [];

            $cant_tfe = 0;
            $cant_estampillas = 0;

            $cant_ucd_tfe = 0;
            $cant_ucd_estampillas = 0;

            $exist_tfe = false;
            $exist_estampillas = false;

            foreach ($tramites as $tramite) {
                $consulta_tramite = DB::table('tramites')->join('entes', 'tramites.key_ente', '=','entes.id_ente')
                                                        ->select('tramites.tramite','tramites.alicuota','entes.ente')
                                                        ->where('tramites.id_tramite','=',$tramite['tramite'])->first();

                $i1 = DB::table('ventas')->insert(['key_user' => $user, 
                                                'key_taquilla' => $id_taquilla, 
                                                'key_contribuyente' => $id_contribuyente,
                                                'key_ucd' => $id_ucd]); 
                if ($i1) {
                    $id_venta = DB::table('ventas')->max('id_venta');
                    if ($tramite['forma'] == 3) {
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////// FORMA 14





                    
















                    }else{
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////// ESTAMPILLAS
                        $key_tramite = $tramite['tramite'];
                        $ucd_tramite = '';
                        $key_deno = '';

                        //////// Valor del ucd tramite
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->juridico;
                        }else{
                            ////natural
                            $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->natural;
                        }

                        ///////Buscar el id denominacion e identificador de forma
                        if ($ucd_tramite == 10) {
                            $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=','5')->first();
                            $key_deno = $q5->id; 
                            // $identificador_ucd = $q5->identificador;
                        }else{
                            $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=',$ucd_tramite)->first();
                            $key_deno = $q5->id;
                            // $identificador_ucd = $q5->identificador;
                        }

                        $total_ucd = $total_ucd + $ucd_tramite;

                        $i2 = DB::table('detalle_ventas')->insert(['key_venta' => $id_venta, 
                                                                    'key_tramite' => $key_tramite, 
                                                                    'forma' => $tramite['forma'],
                                                                    'cantidad' => 1,
                                                                    'metros' => null,
                                                                    'capital' => null]); 
                        if ($i2) {
                            $id_detalle_venta = DB::table('detalle_ventas')->max('correlativo');
                            ///////////////////////// BUSCAR CORRELATIVO
                            if ($ucd_tramite == 10) { //// 10 UCD = DOS ESTAMPILLAS DE 5 UCD
                                for ($i=0; $i < 2; $i++) {
                                    $c5 = DB::table('detalle_venta_estampillas')->select('key_asignacion_estampilla','nro_timbre')
                                                                                ->where('key_denominacion','=',$key_deno)
                                                                                ->where('key_taquilla','=',$id_taquilla)
                                                                                ->orderBy('correlativo', 'desc')->first();
                                    if ($c5) {
                                        $nro_hipotetico = $c5->nro_timbre +1;

                                        $c6 = DB::table('detalle_asignacion_estampillas')->select('hasta')->where('correlativo','=',$c5->key_asignacion_estampilla)->first();

                                        if ($nro_hipotetico > $c6->hasta) {
                                            $c7 = DB::table('detalle_asignacion_estampillas')->select('desde','correlativo')
                                                        ->where('key_taquilla','=',$id_taquilla)
                                                        ->where('condicion','=',4)
                                                        ->where('key_denominacion','=',$key_deno)
                                                        ->first();
                                            if ($c7) {
                                                $nro_timbre = $desde;
                                                $update_2 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                            }else{
                                                return response()->json(['success' => false, 'nota'=> '']);
                                            }
                                        }else{
                                            $nro_timbre = $nro_hipotetico;
                                            if ($nro_hipotetico == $c6->hasta) {
                                                $update_1 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c5->key_asignacion_estampilla)->update(['condicion' => 7]);
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
                                            $nro_timbre = $desde;
                                            $update_3 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                        }else{
                                            return response()->json(['success' => false, 'nota'=> 'No hay timbres disponibles de ']);
                                        }
                                    }


                                    // insert detalle_venta_estampilla
                                    $i3 = DB::table('detalle_venta_estampillas')->insert(['key_venta' => $id_venta, 
                                                                    'key_detalle_venta' => $key_tramite, 
                                                                    'key_denominacion' => $tramite['forma'],
                                                                    'nro_timbre' => 1,
                                                                    'key_detalle_asignacion' => null,
                                                                    'serial' => null,
                                                                    'qr' => null]); 
                                }
                            }else{ //// OTRAS DENOMINACIONES 1 (UND) ESTAMPILLA
                                $c5 = DB::table('detalle_venta_estampillas')->select('key_asignacion_estampilla','nro_timbre')
                                                                            ->where('key_denominacion','=',$key_deno)
                                                                            ->where('key_taquilla','=',$id_taquilla)
                                                                            ->orderBy('correlativo', 'desc')->first();
                                if ($c5) {
                                    $nro_hipotetico = $c5->nro_timbre +1;

                                    $c6 = DB::table('detalle_asignacion_estampillas')->select('hasta')->where('correlativo','=',$c5->key_asignacion_estampilla)->first();

                                    if ($nro_hipotetico > $c6->hasta) {
                                        $c7 = DB::table('detalle_asignacion_estampillas')->select('desde','correlativo')
                                                    ->where('key_taquilla','=',$id_taquilla)
                                                    ->where('condicion','=',4)
                                                    ->where('key_denominacion','=',$key_deno)
                                                    ->first();
                                        if ($c7) {
                                            $nro_timbre = $desde;
                                            $update_2 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c7->correlativo)->update(['condicion' => 3]);
                                        }else{
                                            return response()->json(['success' => false, 'nota'=> '']);
                                        }
                                    }else{
                                        $nro_timbre = $nro_hipotetico;
                                        if ($nro_hipotetico == $c6->hasta) {
                                            $update_1 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c5->key_asignacion_estampilla)->update(['condicion' => 7]);
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
                                        $nro_timbre = $desde;
                                        $update_3 = DB::table('detalle_asignacion_estampillas')->where('correlativo','=',$c8->correlativo)->update(['condicion' => 3]);
                                    }else{
                                        return response()->json(['success' => false, 'nota'=> 'No hay timbres disponibles de ']);
                                    }
                                }
                            }
                        }else{
                            //// eliminar venta

                        }

                        

                    } ///cierra else estampilla-tfe
                }else{
                    return response()->json(['success' => false]);
                }

                

            }


            /////////////////////////////////////// INSERT VENTA | UPDATE DETALLES VENTA | UPDATE INVENTARIO TAQUILLAS
            $i1 =DB::table('ventas')->insert(['key_user' => $user, 
                                            'key_taquilla' => $id_taquilla, 
                                            'key_contribuyente' => $id_contribuyente,
                                            'key_ucd' => $id_ucd]); 

            if ($i1) {
                $id_venta = DB::table('ventas')->max('id_venta');
            }else{
                return response()->json(['success' => false]);
            }

            foreach ($array_correlativo_tfe as $c) {
                $update_key_venta = DB::table('detalle_venta_tfes')->where('correlativo','=',$c)->update(['key_venta' => $id_venta]);
            }

            foreach ($array_correlativo_estampillas as $c) {
                $update_key_venta = DB::table('detalle_venta_estampillas')->where('correlativo','=',$c)->update(['key_venta' => $id_venta]);
            }

            $inv1 = DB::table('inventario_taquillas')->select('cantidad_tfe')->where('key_taquilla','=',$id_taquilla)->first();
            $inv2 = DB::table('inventario_taquillas')->select('cantidad_estampillas')->where('key_taquilla','=',$id_taquilla)->first();

            $new_inv_tfe = $inv1->cantidad_tfe - $cant_tfe;
            $new_inv_estampillas = $inv2->cantidad_estampillas - $cant_estampillas;

            $update_inv_tfe = DB::table('inventario_taquillas')->where('key_taquilla','=',$id_taquilla)->update(['cantidad_tfe' => $new_inv_tfe]);
            $update_inv_estampilla = DB::table('inventario_taquillas')->where('key_taquilla','=',$id_taquilla)->update(['cantidad_estampillas' => $new_inv_estampillas]);




        ///////////////////////////////////// UPDATE TOTAL UCD / BOLIVARES (TABLE VENTAS)
            $total_bolivares = $total_ucd * $valor_ucd;
            $update_rollo = DB::table('ventas')->where('id_venta','=',$id_venta)->update(['total_ucd' => $total_ucd, 'total_bolivares' => $total_bolivares]);

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
                        <a href="'.route("venta").'" class="btn btn-secondary btn-sm me-3">Cancelar</a>
                    </div>
                </div>';

                return response()->json(['success' => true, 'html' => $html]);



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
