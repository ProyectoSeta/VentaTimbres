<?php

namespace App\Http\Controllers;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InventarioPapelController extends Controller
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
        $query_tfes = [];
        $total = DB::table('emision_papel_tfes')->selectRaw("count(*) as total")->where('estado', '=', 18)->first();
        $contador = 0;
        $query_1 = DB::table('emision_papel_tfes')->get();

        foreach ($query_1 as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_lote_papel' => $c->id_lote_papel,
                'fecha_emision' => $c->fecha_emision,
                'cantidad_timbres' => $c->cantidad_timbres,
                'desde' => $c->desde,
                'hasta' => $c->hasta,
                'estado' => $c->estado,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query_tfes,$a);
            
        }


        
        $query_estampillas = [];
        $total = DB::table('emision_papel_estampillas')->selectRaw("count(*) as total")->where('estado', '=', 18)->first();
        $contador = 0;
        $query_2 = DB::table('emision_papel_estampillas')->get();

        foreach ($query_2 as $c) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_lote_papel' => $c->id_lote_papel,
                'fecha_emision' => $c->fecha_emision,
                'cantidad_timbres' => $c->cantidad_timbres,
                'desde' => $c->desde,
                'hasta' => $c->hasta,
                'estado' => $c->estado,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query_estampillas,$a);
            
        }


        // TOTALES
        $total_f14 = 0;
        $total_estampillas = 0;

        $t1 = DB::table('emision_papel_tfes')->select('cantidad_timbres','asignados')->where('estado', '=', 1)->get();
        foreach ($t1 as $k1) {
            $total_prev = $k1->cantidad_timbres - $k1->asignados;
            $total_f14 = $total_f14 + $total_prev;
        }

        $t2 = DB::table('emision_papel_estampillas')->select('cantidad_timbres','emitidos')->where('estado', '=', 1)->get();
        foreach ($t2 as $k2) {
            $total_prev = $k2->cantidad_timbres - $k2->emitidos;
            $total_estampillas = $total_estampillas + $total_prev;
        }



        
        
        return view('inventario_papel', compact('query_tfes','query_estampillas','total_f14','total_estampillas'));

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
