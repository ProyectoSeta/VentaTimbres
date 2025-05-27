<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = DB::table('proveedores')->get();
        return view('proveedores', compact('proveedores'));
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
        $insert = DB::table('proveedores')->insert([
                                        'condicion_identidad' => $request->post('rif_condicion'),
                                        'nro_identidad' => $request->post('rif_nro'),
                                        'razon_social' => $request->post('razon'),
                                        'direccion' => $request->post('direccion'), 
                                        'nombre_representante' => $request->post('nombre'), 
                                        'email' => $request->post('email'), 
                                        'tlf_movil' => $request->post('tlf_movil'), 
                                        'tlf_fijo' => $request->post('tlf_fijo')]);
        if ($insert) {
            $id_proveedor = DB::table('proveedores')->max('id_proveedor');
           
            $user = auth()->id();
            /////BITACORA
            $accion = 'NUEVO PROVEEDOR CREADO ID'.$id_proveedor.'';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 3, 'accion'=> $accion]);
            return response()->json(['success' => true]);
            
        }else{
            return response()->json(['success' => false]);
        }
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
