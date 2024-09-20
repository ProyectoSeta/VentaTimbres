<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class DeclaracionesContribuyenteController extends Controller
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
        $razon = '';
        $rif = '';

        $consulta = DB::table('sujeto_pasivos')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto','=',$id_sujeto)->first();
        if ($consulta) {
            $razon = $consulta->razon_social;
            $rif = $consulta->rif_condicion.' - '.$consulta->rif_nro;
        }

        $declaraciones = DB::table('declaracions')
                                    ->join('clasificacions', 'declaracions.estado', '=', 'clasificacions.id_clasificacion')
                                    ->join('tipos', 'declaracions.tipo', '=', 'tipos.id_tipo')
                                    ->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                    ->select('declaracions.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'clasificacions.nombre_clf','tipos.nombre_tipo')
                                    ->where('declaracions.id_sujeto', $id_sujeto)
                                    ->orderBy('declaracions.id_declaracion', 'asc')
                                    ->get();
        return view('declaraciones_contribuyente', compact('declaraciones','razon','rif'));
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
