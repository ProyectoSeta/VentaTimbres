<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class InventarioTaquillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $query_1 = DB::table('sedes')->get();
        $t1 = DB::table('sedes')->selectRaw("count(*) as total")->first();

        $taquillas = [];
        $s = 0;

        foreach ($query_1 as $q1) {
            $s++;

            if ($s == $t1->total) {
                ////ultima sede
                $array = array(
                    'salto' => true,
                    'fin' => false,
                    'sede' => $q1->sede,
                    'id_taquilla' => '',
                    'cantidad_tfe' => '',
                    'cantidad_estampillas' => '',
                    'taquillero' => ''
                );
                $a = (object) $array;
                array_push($taquillas,$a);
    
                $query = DB::table('taquillas')->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                                ->select('funcionarios.nombre','taquillas.id_taquilla')
                                                ->where('taquillas.key_sede','=', $q1->id_sede)->get();
                $t2 = DB::table('taquillas')->selectRaw("count(*) as total")->where('key_sede','=', $q1->id_sede)->first();

                $t = 0;
                foreach ($query as $key) {
                    $t++;

                    if ($t == $t2->total) {
                        ///ultima taquilla, de la ultima sede
                        $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                        $array = array(
                                   'salto' => false,
                                   'fin' => false,
                                   'sede' => '',
                                   'id_taquilla' => $key->id_taquilla,
                                   'cantidad_tfe' => $c1->cantidad_tfe,
                                   'cantidad_estampillas' => $c1->cantidad_estampillas,
                                   'taquillero' => $key->nombre
                               );
                        $a = (object) $array;
                        array_push($taquillas,$a);

                        //////
                        $array = array(
                                    'salto' => false,
                                    'fin' => true,
                                    'sede' => '',
                                    'id_taquilla' => '',
                                    'cantidad_tfe' => '',
                                    'cantidad_estampillas' => '',
                                    'taquillero' => ''
                                );
                        $a = (object) $array;
                        array_push($taquillas,$a);

                    }else{
                        $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                        $array = array(
                                    'salto' => false,
                                    'fin' => false,
                                    'sede' => '',
                                    'id_taquilla' => $key->id_taquilla,
                                    'cantidad_tfe' => $c1->cantidad_tfe,
                                    'cantidad_estampillas' => $c1->cantidad_estampillas,
                                    'taquillero' => $key->nombre
                                );
                        $a = (object) $array;
                        array_push($taquillas,$a);
                    }
                    
                }

            }else{
                $array = array(
                        'salto' => true,
                        'fin' => false,
                        'sede' => $q1->sede,
                        'id_taquilla' => '',
                        'cantidad_tfe' => '',
                        'cantidad_estampillas' => '',
                        'taquillero' => ''
                );
                $a = (object) $array;
                array_push($taquillas,$a);
    
                $query = DB::table('taquillas')->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                                ->select('funcionarios.nombre','taquillas.id_taquilla')
                                                ->where('taquillas.key_sede','=', $q1->id_sede)->get();
    
                foreach ($query as $key) {
                    $c1 = DB::table('inventario_taquillas')->where('key_taquilla','=', $key->id_taquilla)->first();
                    $array = array(
                                'salto' => false,
                                'fin' => false,
                                'sede' => '',
                                'id_taquilla' => $key->id_taquilla,
                                'cantidad_tfe' => $c1->cantidad_tfe,
                                'cantidad_estampillas' => $c1->cantidad_estampillas,
                                'taquillero' => $key->nombre
                            );
                    $a = (object) $array;
                    array_push($taquillas,$a);
                }

            }



            

        }

        return view('inventario_taquillas',compact('taquillas'));
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
