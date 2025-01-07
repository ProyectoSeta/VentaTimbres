<?php

namespace App\Http\Controllers;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EmisionUcdController extends Controller
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
        $deno = DB::table('ucd_denominacions')->where('estampillas', '=', 'true')->get();
        return view('emision_ucd',compact('deno'));
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
