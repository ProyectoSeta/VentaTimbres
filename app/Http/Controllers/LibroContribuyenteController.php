<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class LibroContribuyenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_sujeto = $request->sujeto;
        $libros = DB::table('libros')->where('id_sujeto','=',$id_sujeto)->get();

        $razon = '';
        $rif = '';

        $consulta = DB::table('sujeto_pasivos')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto','=',$id_sujeto)->first();
        if ($consulta) {
            $razon = $consulta->razon_social;
            $rif = $consulta->rif_condicion.' - '.$consulta->rif_nro;
        }
        return view('libro_contribuyente', compact('libros','razon','rif'));
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
