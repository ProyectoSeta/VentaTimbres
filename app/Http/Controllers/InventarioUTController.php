<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class InventarioUTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignado_estampillas = [];
        $cant_20ut = 0;
        $cant_50ut = 0;

        // ASIGNACIONES DE ESTAMPILLAS UT
        $query_2 =  DB::table('asignacion_estampillas')->where('inventario','=',19)->get();
        foreach ($query_2 as $q2) {
            $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->select('sedes.sede')
                            ->where('taquillas.id_taquilla','=',$q2->key_taquilla)->first();
            $array = array(
                        'id_asignacion' => $q2->id_asignacion,
                        'fecha' => $q2->fecha,
                        'key_taquilla' => $q2->key_taquilla,
                        'sede' => $consulta->sede,
                    );
            $i = (object) $array;
            array_push($asignado_estampillas,$i);
        }


        //  INVENTARIO DE ESTAMPILLAS UT
        $con = DB::table('inventario_ut_estampillas')->get();
        foreach ($con as $key) {
            if ($key->key_denominacion == 15) {
                // 20 UT
                $cant_20ut = $cant_20ut + ($key->cantidad_timbres - $key->asignado);
            }else{
                // 50 UT
                $cant_50ut = $cant_50ut + ($key->cantidad_timbres - $key->asignado);
            }
        }

        return view('inventario_ut',compact('asignado_estampillas','cant_20ut','cant_50ut'));
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
