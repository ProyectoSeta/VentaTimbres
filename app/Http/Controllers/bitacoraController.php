<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class bitacoraController extends Controller
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
        $bitacoras = DB::table('bitacoras')->join('users', 'bitacoras.id_user', '=', 'users.id')
                    ->join('clasificacions', 'bitacoras.modulo', '=', 'clasificacions.id_clasificacion')
                    ->select('bitacoras.*', 'users.name','clasificacions.nombre_clf')->get();

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
