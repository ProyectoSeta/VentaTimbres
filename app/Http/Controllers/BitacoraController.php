<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class BitacoraController extends Controller
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
        $con = DB::table('bitacoras')->join('users', 'bitacoras.key_user', '=', 'users.id')
                    ->join('modulos', 'bitacoras.key_modulo', '=', 'modulos.id_modulo')
                    ->select('bitacoras.*','modulos.modulo','users.key_sujeto')->get();

        $bitacoras = [];

        foreach ($con as $key) {
            $fecha =  date("d-m-Y h:i A",strtotime($key->fecha));
            $con = DB::table('funcionarios')->select('nombre')->where('id_funcionario',$key->key_sujeto)->first();

            $array = array(
                        'correlativo' => $key->correlativo,
                        'nombre' => $con->nombre,
                        'modulo' => $key->modulo,
                        'fecha' => $fecha,
                        'accion' => $key->accion,
                    );
            $a = (object) $array;
            array_push($bitacoras,$a);
        }


        return view('bitacora', compact('bitacoras'));
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
