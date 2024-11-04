<?php

namespace App\Http\Controllers;

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


    public function venta_f14(Request $request)
    {
        $user = auth()->id();
        $query =  DB::table('taquillas')->select('id_taquilla')->where('id_user','=', $user)->first();
        if ($query) {
            $id_taquilla = $query->id_taquilla;

            $condicion = $request->post('identidad_condicion');
            $nro = $request->post('identidad_nro');
            $tramites = $request->post('tramites');
            
            $metodo = $request->post('metodo_one');
            $comprobante = $request->post('comprobante_one');
            $debitado = $request->post('debitado_one');

            if ($condicion == '' || $nro == '' || $debitado == 0) {
                return response()->json(['success' => false, 'nota' => 'Por favor, Ingrese todos los datos requeridos.']);
            }else{
                if ($metodo == 'punto' && strlen($comprobante) < 4) {
                    return response()->json(['success' => false, 'nota' => 'El No. de Comprobante debe tener mínimo 4 caracteres.']);
                }else{
                    ///////////////////////////////// VERIFICACION DE LOS TRAMITES
                    $contador = 0;
                    foreach ($tramites as $tramite) {
                        $contador = $contador++;
                        if ($contador == 1 && $tramite == '') {
                            return response()->json(['success' => false, 'nota' => 'Disculpe, debe seleccionar el tramite para la venta del timbre.']);
                            break;
                        }
                    }
                    /////////////////////////////////////////////////////////////

                    $consulta = DB::table('contribuyentes')->select('id_contribuyente')->where('identidad_condicion','=', $condicion)->where('identidad_nro','=', $nro)->first();
                    if($consulta){
                        $id_contribuyente = $consulta->id_contribuyente;

                        $ucd =  DB::table('ucds')->select('id','valor')->orderBy('id', 'desc')->first();
                        $valor_ucd = $ucd->valor;
                        $id_ucd = $ucd->id;

                        $insert_venta = DB::table('ventas')->insert(['type' =>  3,
                                                                    'key_user' => $user,
                                                                    'key_taquilla' => $id_taquilla,
                                                                    'key_contribuyente' => $id_contribuyente,
                                                                    'key_ucd' => $id_ucd]);
                        if ($insert_venta) {
                            $id_venta = DB::table('ventas')->max('id_venta');
                            
                            foreach ($tramites as $tramite) {
                                ////*************************** */
                            }

                        }else{
                            return response()->json(['success' => false]);
                        }

                    }else{
                        return response()->json(['success' => false, 'nota' => 'Disculpe, el Contribuyente no se encuentra registrado.']);
                    }//////
                }//////
            }////////
        }else{

            return response()->json(['success' => false, 'nota' => 'Disculpe, su usuario debe estar asociado a una Taquilla para que la venta se puede realizar.']);
        }

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
