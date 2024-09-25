<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entes = DB::table('entes')->select('id_ente','ente')->get();
        $tramites = DB::table('tramites')->select('id_tramite','tramite')->where('key_ente','=',1)->get();
        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();

        return view('venta', compact('entes','tramites','ucd'));
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
    public function search(Request $request)
    {
        $value = $request->post('value');
        $condicion = $request->post('condicion');
        // return response($condicion);
        $query = DB::table('contribuyentes')->select('nombre_razon')
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
        $query = DB::table('tramites')->select('ucd')->where('id_tramite','=', $value)->first();
        
        if ($query) {
            return response()->json(['success' => true, 'valor' => $query->ucd]);
        }else{
            return response()->json(['success' => false]);
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




    public function total(Request $request)
    {
        $tramite = $request->post('value');
        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $ucd->valor;
        $total_ucd = 0; 

        if ($tramite != '') {
            $consulta = DB::table('tramites')->select('ucd')->where('id_tramite','=', $tramite)->first();
            $ucd_tramite = $consulta->ucd;

            $total_ucd = $total_ucd + $ucd_tramite;
        }

        $total_bolivares = $total_ucd * $valor_ucd;

        return response()->json(['success' => true, 'ucd' => $total_ucd, 'bolivares' => $total_bolivares]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function debitado(Request $request)
    {
        $debito = $request->post('debitado');
        return reponse($debito);
        $tramite = $request->post('tramite');
        $vuelto = 0;
        $diferencia = 0;

        $ucd =  DB::table('ucds')->select('valor')->orderBy('id', 'desc')->first();
        $valor_ucd = $ucd->valor;

        $consulta = DB::table('tramites')->select('ucd')->where('id_tramite','=', $tramite)->first();
        $total_ucd = $consulta->ucd;

        $total_bolivares = $total_ucd * $valor_ucd;

        
        ////formato 2 decimales
        if ($debito > $total_bolivares) {
            $vuelto = $debito - $total_bolivares;
        }else{
            $diferencia = $total_bolivares - $debito;
        }
        $deb = number_format($debito, 2, '.', ' ');
        $dif = number_format($diferencia, 2, '.', ' ');
        $v = number_format($vuelto, 2, '.', ' ');

        return response()->json(['success' => true, 'debito' => $deb, 'diferencia' => $dif, 'vuelto' => $v]);
         
    }



    public function add_contribuyente(Request $request)
    {
        $condicion = $request->post('condicion');
        $nro = $request->post('nro');
        $nombre = $request->post('nombre');
        if (empty($nro) || empty($nombre)) {
            return response()->json(['success' => false, 'nota' => 'Por favor, complete los campos C.I/R.I.F y Nombre/Razon Social.']);
        }else{
            $campos_nro = strlen($nro);
            if ($campos_nro < 6) {
                return response()->json(['success' => false, 'nota' => 'Por favor, introduzca un C.I/R.I.F válido.']);
            }else{
                $contribuyente = DB::table('contribuyentes')->insert([
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
