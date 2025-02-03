<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AsignadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
        ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
        ->where('exenciones.estado','=',18)
        ->where('exenciones.key_taquilla','!=',null)->get();

        return view('asignado', compact('query'));
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
