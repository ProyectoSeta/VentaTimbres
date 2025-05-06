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


        return view('cierre', compact('hoy_view','aperturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function comprobar()
    {
        $hoy = date('Y-m-d');
        $query = DB::table('apertura_taquillas')->where('fecha','=', $hoy)->get(); //return response($query);
        if (!empty($query)) {
            foreach ($query as $key) {
                if ($key->cierre_taquilla == NULL) {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, la acción no se puede realizar hasta que TODAS las taquillas aperturadas el día de hoy sean cerradas.']); 
                }
            }
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false, 'nota' => 'Hoy no ha sido aperturada ninguna Taquilla.']);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registro_cierre()
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
