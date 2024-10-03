<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
class AsignadoTaquillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->id();
        $consulta = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $c = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$consulta->key_sujeto)->first();

        $id_taquilla = $c->id_taquilla;

        // $query_14 = DB::table('asignacion_forma_14_timbres')->selectRaw("count(*) as total")
        //                                                     ->where('fecha_recibido','=',null)
        //                                                     ->where('fecha_recibido','=',null)->first();
        


        // $asignaciones = [];
        
        return view('timbres_asignados');
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
