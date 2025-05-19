<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class CierreDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // comprobar que la taquilla ha sio cerrada para mostrar el arqueo PENDIENTE
        $hoy = date('Y-m-d');
        
        // FECHA HOY (FORMATO)
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');

        // VENTAS DEL DÍA
        $ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                ->where('ventas.fecha','=',$hoy)
                                ->get();
        
        // DETALLE ARQUEO
        $arqueo = DB::table('cierre_diarios')->where('fecha','=',$hoy)->first();

    

        return view('arqueo',compact('hoy_view','ventas','arqueo'));
        
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
