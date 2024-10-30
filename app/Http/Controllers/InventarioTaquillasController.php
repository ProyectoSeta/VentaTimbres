<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class InventarioTaquillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DB::table('taquillas')->select('id_taquilla')->get();
        $taquillas = [];
        
        foreach ($query as $key) { 
            $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
print_r($c1->cantidad_estampillas);
            // $array = array(
            //             'id_taquilla' => $key->id_taquilla,
            //             'cantidad_tfe' => $c1->cantidad_tfe,
            //             'cantidad_estampillas' => $c2->cantidad_estampillas,
            //         );
            // $a = (object) $array;
            // array_push($taquillas,$a);
        }

        // return view('inventario_taquillas',compact('taquillas'));
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
