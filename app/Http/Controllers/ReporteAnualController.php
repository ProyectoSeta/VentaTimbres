<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ReporteAnualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $con1 = DB::table('cierre_diarios')->select('fecha')->first();
        $con2 = DB::table('cierre_diarios')->select('fecha')->orderBy('id', 'desc')->first();

        $inicio = date("Y",strtotime($con1->fecha));
        $fin = date("Y",strtotime($con2->fecha));

        $years = [];

        if ($inicio == $fin) {
            $years = [$inicio];
        }else{
            //////// hay mas años
            $c = 1;
            $new_year = '';

            for ($i=$inicio; $i <= $fin; $i++) { 
                if ($c == 1) {
                    $new_year = $inicio;
                    array_push($years,$inicio);
                }else{
                    $new_year = $new_year + 1;
                    array_push($years,$new_year);
                }
                $c++;
            }
        }

        return view('reporte_anual', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pdf_reporte(Request $request)
    {
        $year = $request->year;
        if ($year == '2024') {
            $pdf = \PDF::loadView('pdf/reporte_2024');
            return $pdf->download('REPORTE_2024.pdf');
        }else{
            $pdf = \PDF::loadView('pdf/reporte_2025');
            return $pdf->download('REPORTE_2025.pdf');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
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
