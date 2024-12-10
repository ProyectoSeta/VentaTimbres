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



    public function metros(Request $request){
        $tramite = $request->post('tramite');
        $metros = $request->post('value');

        if ($metros == '' || $metros == 0) {
            return response('0');
        }else{
            if ($metros <= 150) {
                ////pequeña
                $query = DB::table('tramites')->select('small')->where('id_tramite','=', $tramite)->first();
                return response($query->small);
            }elseif ($metros > 150 && $metros < 400) {
                /////mediana
                $query = DB::table('tramites')->select('medium')->where('id_tramite','=', $tramite)->first();
                return response($query->medium);
            }elseif ($metros >= 400) {
                /////grande
                $query = DB::table('tramites')->select('large')->where('id_tramite','=', $tramite)->first();
                return response($query->large);
            }
        }
        
    }



    public function total(Request $request)
    {
        $tramites = $request->post('tramites');
        $metros = $request->post('metros');
        $condicion_sujeto = $request->post('condicion_sujeto');

        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $ucd->valor;
        $total_ucd = 0; 

        
        

        foreach ($tramites as $tramite) {
            if ($tramite != '') {
                if ($tramite == 9) {
                    
                    if ($metros > 0 && $metros <= 150) {
                        ////pequeña
                        $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->small;
                    }elseif ($metros > 150 && $metros < 400) {
                        /////mediana
                        $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->medium;
                    }elseif ($metros >= 400) {
                        /////grande
                        $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->large;
                    }elseif ($metros == 0 || $metros == '') {
                        $ucd_tramite = 0;
                    }                    

                    $total_ucd = $total_ucd + $ucd_tramite;

                }else{
                    if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                        //////juridico (firma personal - empresa)
                        $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->juridico;
                    }else{
                        ////natural
                        $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->natural;
                    }
                    $total_ucd = $total_ucd + $ucd_tramite;
                }
            }
        }

        $total_bolivares = $total_ucd * $valor_ucd;
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
                if ($tramite == 9) { /////permiso bomberos (9)
                    
                    if ($metros > 0 && $metros <= 150) {
                        ////pequeña
                        $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->small;
                    }elseif ($metros > 150 && $metros < 400) {
                        /////mediana
                        $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->medium;
                    }elseif ($metros >= 400) {
                        /////grande
                        $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->large;
                    }elseif ($metros == 0 || $metros == '') {
                        $ucd_tramite = 0;
                    }                    

                    $total_ucd = $total_ucd + $ucd_tramite;

                }else{
                    if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                        //////juridico (firma personal - empresa)
                        $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->juridico;
                    }else{
                        ////natural
                        $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $tramite)->first();
                        $ucd_tramite = $consulta->natural;
                    }
                    $total_ucd = $total_ucd + $ucd_tramite;
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

                $q4 = DB::table('detalle_estampillas')->select('cantidad','vendido')->where('key_denominacion','=', $key_denominacion)
                                                                        ->where('key_taquilla','=', $id_taquila)
                                                                        ->where('condicion','!=',7) ///en uso
                                                                        ->where('condicion','!=',8) ///en uso
                                                                        ->first();
                if ($q4) {
                    ///// si hay
                    $disponible = $q4->cantidad - $q4->vendido; 
                    if ($disponible >= $cantidad) {
                        return response()->json(['success' => true]);
                    }else{
                        ///// buscar si hay reserva
                        $q5 = DB::table('detalle_estampillas')->select('cantidad','vendido')->where('key_denominacion','=', $key_denominacion)
                                                                        ->where('key_taquilla','=', $id_taquila)
                                                                        ->where('condicion','=',4) ///reserva
                                                                        ->first();
                        if ($q5) {
                            $disponible_q5 = $q5->cantidad - $q5->vendido;
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
                                                        ->select('tramites.tramite','entes.ente')
                                                        ->where('tramites.id_tramite','=',$tramite['tramite'])->first();

                if ($tramite['forma'] == 3) {
                    ////////////////////////// FORMA 14
                    $exist_tfe = true;

                    $nro_timbre = '';
                    $id_rollo = '';

                    //////////// BUSCAR CORRELATIVO
                    $c1 = DB::table('detalle_venta_tfes')->select('nro_timbre','key_rollo')->orderBy('correlativo', 'desc')->first();
                    if ($c1) {
                        /////////hay registro de ventas
                        $nro_hipotetico= $c1->nro_timbre + 1; 

                        $c2 = DB::table('inventario_rollos')->select('hasta','vendido')->where('id_rollo','=',$c1->key_rollo)->first();
                        if ($c2->hasta >= $nro_hipotetico) {
                            ///////// el nro sigue dentro del rango del rollo
                            $nro_timbre = $nro_hipotetico;
                            $id_rollo = $c1->key_rollo;

                            if ($c2->hasta == $nro_timbre) {
                                $update_rollo = DB::table('inventario_rollos')->where('id_rollo','=',$c1->key_rollo)->update(['condicion' => 7]);
                            }

                            $new_vendido = $c2->vendido + 1;
                            $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c1->key_rollo)->update(['vendido' => $new_vendido]);
                        }else{
                            //////// Buscar el siguiente rollo asignado
                            $c3 = DB::table('inventario_rollos')->select('desde','id_rollo')->where('key_taquilla','=',$id_taquilla)->where('condicion','=', 4)->first();
                            if ($c3) {
                                $nro_timbre = $c3->desde;
                                $id_rollo = $c3->id_rollo;

                                
                                $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c3->id_rollo)->update(['vendido' => 1, 'condicion' => 3]);
                            }else{
                                return response()->json(['success' => false, 'nota'=> 'Disculpe, no tiene rollos disponibles asignados a su taquilla.']);
                            }
                        }
                    }else{
                        /////////primera venta a realizarse
                        $c4 = DB::table('inventario_rollos')->select('desde','id_rollo')->where('key_taquilla','=',$id_taquilla)->where('condicion','=', 4)->first();
                        if ($c4) {
                            $nro_timbre = $c4->desde;
                            $id_rollo = $c4->id_rollo;

                            $update_vendido = DB::table('inventario_rollos')->where('id_rollo','=',$c4->id_rollo)->update(['vendido' => 1, 'condicion' => 3]);
                        }else{
                            return response()->json(['success' => false, 'nota'=> 'Disculpe, no tiene rollos disponibles asignados a su taquilla.']);
                        }
                    }

                    //////////////// INSERT DETALLE 
                    $key_tramite = $tramite['tramite'];
                
                    if ($key_tramite == 9) {
                        $metros = $request->post('metros');

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
    
                        $total_ucd = $total_ucd + $ucd_tramite;

                    }else{
                        if ($condicion_sujeto == 10 || $condicion_sujeto == 11) {
                            //////juridico (firma personal - empresa)
                            $consulta = DB::table('tramites')->select('juridico')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->juridico;
                        }else{
                            ////natural
                            $consulta = DB::table('tramites')->select('natural')->where('id_tramite','=', $key_tramite)->first();
                            $ucd_tramite = $consulta->natural;
                        }
                        $total_ucd = $total_ucd + $ucd_tramite;
                    }

                    //// buscar key denominacions
                    $q4 = DB::table('ucd_denominacions')->select('id')->where('denominacion','=',$ucd_tramite)->first();
                    $key_denominacion = $q4->id;

                    ////insert y QR
                    $url = 'https://forma14.tributosaragua.com.ve/?id='.$nro_timbre; 
                    QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png'));
                    
                    $i2 =DB::table('detalle_venta_tfes')->insert([
                                                                'key_denominacion' => $key_denominacion, 
                                                                'nro_timbre' => $nro_timbre,
                                                                'key_tramite' => $key_tramite,
                                                                'qr' => 'assets/qrForma14/qrcode_TFE'.$nro_timbre.'.png',
                                                                'key_rollo' => $id_rollo]);
                    if ($i2) {
                        $id_correlativo_detalle = DB::table('detalle_venta_tfes')->max('correlativo');
                        array_push($array_correlativo_tfe,$id_correlativo_detalle);

                        $cant_tfe = $cant_tfe + 1;
                        $cant_ucd_tfe = $cant_ucd_tfe + $ucd_tramite;

                        $length = 6;
                        $formato_nro_timbre = substr(str_repeat(0, $length).$nro_timbre, - $length);

                        $row_timbres .= '<div class="border mb-4 rounded-3">
                                <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                    <!-- DATOS -->
                                    <div class="">
                                        <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro_timbre.'<span class="text-muted ms-2">TFE-14</span></div> 
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
                    }else{
                        return response()->json(['success' => false]);
                    } 
                    
                }else{
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////// ESTAMPILLAS
                    $key_tramite = $tramite['tramite'];
                    $exist_estampillas = true;


                    $nro_timbre = '';
                    $secuencia = '';
                    $key_tira = '';
                    $id_correlativo = '';


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
                        $key_denominacion = $q5->id; 
                        $identificador_ucd = $q5->identificador;
                    }else{
                        $q5 = DB::table('ucd_denominacions')->select('id','identificador')->where('denominacion','=',$ucd_tramite)->first();
                        $key_denominacion = $q5->id;
                        $identificador_ucd = $q5->identificador;
                    }

                    
                    $total_ucd = $total_ucd + $ucd_tramite;
                    

                    ///////////////////////// BUSCAR CORRELATIVO
                    if ($ucd_tramite == 10) { //// 10 UCD
                        $ucd_alert = 5;
                        for ($i=0; $i < 2; $i++) { 
                            $c5 = DB::table('detalle_venta_estampillas')->select('key_detalle_estampilla','secuencia','nro_correlativo','key_tira')
                                                                        ->where('key_denominacion','=',$key_denominacion)
                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                        ->orderBy('correlativo', 'desc')->first();
                            if ($c5) {
                                /////// se han registrado ventas de esta denominacion
                                $nro_hipotetico = $c5->nro_correlativo + 1;

                                $q6 = DB::table('detalle_estampillas')->select('desde_correlativo','hasta_correlativo')->where('correlativo','=', $c5->key_detalle_estampilla)->first();

                                if ($nro_hipotetico >= $q6->desde_correlativo && $q6->hasta_correlativo >= $nro_hipotetico) {
                                    //////// esta dentro del rango de la fracción de tira asignada
                                    $nro_timbre = $nro_hipotetico;
                                    $secuencia = $c5->secuencia;
                                    $key_tira = $c5->key_tira;
                                    $id_correlativo = $c5->key_detalle_estampilla;

                                    if ($q6->hasta_correlativo == $nro_timbre) {
                                        ///// ultimo timbre de la asignacion
                                        $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 7]);
                                    }
                                }else{
                                    /////// buscar otra fracción de tira asignada
                                    $c6 = DB::table('detalle_estampillas')->select('correlativo','secuencia','desde_correlativo','key_tira')
                                                                        ->where('key_denominacion','=',$key_denominacion)
                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                        ->where('condicion','=', 4)
                                                                        ->first();
                                    if ($c6) {
                                        $nro_timbre = $c6->desde_correlativo;
                                        $secuencia = $c6->secuencia;
                                        $key_tira = $c6->key_tira;
                                        $id_correlativo = $c6->correlativo;

                                        //////////// primer timbre de la asignacion (En uso)
                                        $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 3]);
                                    }else{
                                        return response()->json(['success' => false, 'nota'=> 'Disculpe, no hay en su Inventario, estampillas de '.$ucd_alert.' UCD disponibles.']);
                                    }
                                }

                            }else{
                                ////// es la primera venta
                                $c7 = DB::table('detalle_estampillas')->select('correlativo','secuencia','desde_correlativo','key_tira')
                                                                    ->where('key_denominacion','=',$key_denominacion)
                                                                    ->where('key_taquilla','=',$id_taquilla)
                                                                    ->where('condicion','=', 4)
                                                                    ->first();
                                if ($c7) {
                                    $nro_timbre = $c7->desde_correlativo;
                                    $secuencia = $c7->secuencia;
                                    $key_tira = $c7->key_tira;
                                    $id_correlativo = $c7->correlativo;

                                    //////////// primer timbre de la asignacion (En uso)
                                    $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 3]);
                                }else{
                                    return response()->json(['success' => false, 'nota'=> 'Disculpe, no hay en su Inventario, estampillas de '.$ucd_alert.' UCD disponibles.']);
                                }
                            }


                            //////////////// FORMATO NO.
                            $q7 = DB::table('formas')->select('identificador')->where('forma','=','Estampillas')->first();
                            $identificador_forma = $q7->identificador;

                            $length = 6;
                            $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);

                            $nro = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_nro;

                            ////////////////INSERT DETALLE VENTA ESTAMPILLAS
                            $i3 =DB::table('detalle_venta_estampillas')->insert([
                                                                    'key_detalle_estampilla' => $id_correlativo,
                                                                    'key_tramite' => $key_tramite,
                                                                    'key_denominacion' => $key_denominacion, 
                                                                    'secuencia' => $secuencia,
                                                                    'nro_correlativo' => $nro_timbre,
                                                                    'nro' => $nro,
                                                                    'key_tira' => $key_tira,
                                                                    'key_taquilla' => $id_taquilla]); 
                            if ($i3) {
                                $id_correlativo_detalle = DB::table('detalle_venta_estampillas')->max('correlativo');
                                array_push($array_correlativo_estampillas,$id_correlativo_detalle);

                                $cant_estampillas = $cant_estampillas + 1;
                                $cant_ucd_estampillas = $cant_ucd_estampillas + 5;

                                $consulta_emision_tira = DB::table('estampillas')->select('key_emision')->where('id_tira','=',$key_tira)->first(); 
                                $consulta_qr_tira = DB::table('emision_estampillas')->select('qr')->where('id_emision','=',$consulta_emision_tira->key_emision)->first();

                                $row_timbres .= '<div class="border mb-4 rounded-3">
                                                    <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                        <!-- DATOS -->
                                                        <div class="">
                                                            <div class="text-danger fw-bold fs-4" id="">'.$nro.'<span class="text-muted ms-2">Estampilla</span></div> 
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
                                                            <div class="text-center titulo fw-bold fs-3">5 UCD</div>
                                                        </div>
                                                        <!-- QR -->
                                                        <div class="text-center">
                                                            <img src="'.asset($consulta_qr_tira->qr).'" class="img-fluid" alt="" width="110px">
                                                        </div>
                                                    </div>
                                                </div>';
                                
                                /////////ACTUALIZAR VENDIDO
                                $q8 = DB::table('detalle_estampillas')->select('vendido')->where('correlativo','=',$id_correlativo)->first();
                                $new_vendido = $q8->vendido + 1;
                                $update_vendido = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['vendido' => $new_vendido]);
                            }else{
                                return response()->json(['success' => false]); 
                            }
                        }////// cierra for

                    }else{ ////////// OTRAS DENOMINACIONES 
                        $c5 = DB::table('detalle_venta_estampillas')->select('correlativo','key_detalle_estampilla','secuencia','nro_correlativo','key_tira')
                                                                        ->where('key_denominacion','=',$key_denominacion)
                                                                        ->where('key_taquilla','=',$id_taquilla)
                                                                        ->orderBy('correlativo', 'desc')->first();
                        if ($c5) {
                            /////// se han registrado ventas de esta denominacion
                            $nro_hipotetico = $c5->nro_correlativo + 1; 

                            $q6 = DB::table('detalle_estampillas')->select('desde_correlativo','hasta_correlativo')
                                                                ->where('correlativo','=',$c5->key_detalle_estampilla)
                                                                ->first();
                            if ($nro_hipotetico >= $q6->desde_correlativo && $q6->hasta_correlativo >= $nro_hipotetico) {
                                //////// esta dentro del rango de la fracción de tira asignada
                                $nro_timbre = $nro_hipotetico;
                                $secuencia = $c5->secuencia;
                                $key_tira = $c5->key_tira;
                                $id_correlativo = $c5->correlativo;

                                if ($q6->hasta_correlativo == $nro_timbre) {
                                    //////ultimo timbre de la asgnación
                                    $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 7]);
                                }
                            }else{
                                /////// buscar otra fracción de tira asignada
                                $c6 = DB::table('detalle_estampillas')->select('correlativo','secuencia','desde_correlativo','key_tira')
                                                                    ->where('key_denominacion','=',$key_denominacion)
                                                                    ->where('key_taquilla','=',$id_taquilla)
                                                                    ->where('condicion','=', 4)
                                                                    ->first();
                                if ($c6) {
                                    $nro_timbre = $c6->desde_correlativo;
                                    $secuencia = $c6->secuencia;
                                    $key_tira = $c6->key_tira;
                                    $id_correlativo = $c6->correlativo;

                                    ///////primer timbre de la asignación (En uso)
                                    $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 3]);
                                }else{
                                    return response()->json(['success' => false, 'nota'=> 'Disculpe, no hay en su Inventario, estampillas de '.$ucd_tramite.' UCD disponibles.']);
                                }
                            }

                        }else{
                            ////// es la primera venta
                            $c7 = DB::table('detalle_estampillas')->select('correlativo','secuencia','desde_correlativo','key_tira')
                                                                ->where('key_denominacion','=',$key_denominacion)
                                                                ->where('key_taquilla','=',$id_taquilla)
                                                                ->where('condicion','=', 4)
                                                                ->first();
                            if ($c7) {
                                $nro_timbre = $c7->desde_correlativo;
                                $secuencia = $c7->secuencia;
                                $key_tira = $c7->key_tira;
                                $id_correlativo = $c7->correlativo;

                                ///////primer timbre de la asignación (En uso)
                                $update_condicion = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['condicion' => 3]);
                            }else{
                                return response()->json(['success' => false, 'nota'=> 'Disculpe, no hay en su Inventario, estampillas de '.$ucd_tramite.' UCD disponibles.']);
                            }
                        }


                        //////////////// FORMATO NO.
                        $q7 = DB::table('formas')->select('identificador')->where('forma','=','Estampillas')->first();
                        $identificador_forma = $q7->identificador;

                        $length = 6;
                        $formato_nro = substr(str_repeat(0, $length).$nro_timbre, - $length);

                        $nro = $identificador_ucd.''.$identificador_forma.''.$secuencia.''.$formato_nro;

                        ////////////////INSERT DETALLE VENTA ESTAMPILLAS
                        $i3 =DB::table('detalle_venta_estampillas')->insert([
                                                                'key_detalle_estampilla' => $id_correlativo,
                                                                'key_tramite' => $key_tramite,
                                                                'key_denominacion' => $key_denominacion, 
                                                                'secuencia' => $secuencia,
                                                                'nro_correlativo' => $nro_timbre,
                                                                'nro' => $nro,
                                                                'key_tira' => $key_tira,
                                                                'key_taquilla' => $id_taquilla]); 
                        if ($i3) {
                            $id_correlativo_detalle = DB::table('detalle_venta_estampillas')->max('correlativo');
                            array_push($array_correlativo_estampillas,$id_correlativo_detalle);

                            $cant_estampillas = $cant_estampillas + 1;
                            $cant_ucd_estampillas = $cant_ucd_estampillas + $ucd_tramite;

                            $consulta_emision_tira = DB::table('estampillas')->select('key_emision')->where('id_tira','=',$key_tira)->first();
                            $consulta_qr_tira = DB::table('emision_estampillas')->select('qr')->where('id_emision','=',$consulta_emision_tira->key_emision)->first();

                            $row_timbres .= '<div class="border mb-4 rounded-3">
                                                <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                                    <!-- DATOS -->
                                                    <div class="">
                                                        <div class="text-danger fw-bold fs-4" id="">'.$nro.'<span class="text-muted ms-2">Estampilla</span></div> 
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
                                                        <img src="'.asset($consulta_qr_tira->qr).'" class="img-fluid" alt="" width="110px">
                                                    </div>
                                                </div>
                                            </div>';

                            /////////ACTUALIZAR VENDIDO
                            $q8 = DB::table('detalle_estampillas')->select('vendido')->where('correlativo','=',$id_correlativo)->first();
                            $new_vendido = $q8->vendido + 1;
                            $update_vendido = DB::table('detalle_estampillas')->where('correlativo','=',$id_correlativo)->update(['vendido' => $new_vendido]);
                        }
                    }

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
