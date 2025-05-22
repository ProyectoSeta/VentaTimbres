<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HistorialAsignacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asignado_tfe = [];
        $asignado_estampillas = [];

        // FORMA 14
        $query_1 =  DB::table('asignacion_tfes')->get();
        foreach ($query_1 as $q1) {
            $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->select('sedes.sede')
                            ->where('taquillas.id_taquilla','=',$q1->key_taquilla)->first();
            $array = array(
                        'id_asignacion' => $q1->id_asignacion,
                        'fecha' => date("d-m-Y h:i A",strtotime($q1->fecha)),
                        'key_taquilla' => $q1->key_taquilla,
                        'sede' => $consulta->sede,
                    );
            $a = (object) $array;
            array_push($asignado_tfe,$a);
        }


        // ESTAMPILLAS
        $query_2 =  DB::table('asignacion_estampillas')->get();
        foreach ($query_2 as $q2) {
            $consulta =  DB::table('taquillas')
                            ->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                            ->select('sedes.sede')
                            ->where('taquillas.id_taquilla','=',$q2->key_taquilla)->first();
            $array = array(
                        'id_asignacion' => $q2->id_asignacion,
                        'fecha' => date("d-m-Y h:i A",strtotime($q2->fecha)),
                        'key_taquilla' => $q2->key_taquilla,
                        'sede' => $consulta->sede,
                    );
            $i = (object) $array;
            array_push($asignado_estampillas,$i);
        }


        return view('historial_asignaciones', compact('asignado_tfe','asignado_estampillas'));
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
