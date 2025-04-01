<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteTrimestralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->year;
        $trimestres = [];
        if ($year == '2024') {
            $trimestres = ['Enero - Marzo','Abril - Junio','Julio - Septiembre','Octubre - Diciembre'];
        }else{
            $trimestres = ['Enero - Marzo'];
        }

        return view('trimestre', compact('trimestres','year'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function reportes_trimestral(Request $request)
    {
        $trimestre = $request->tri;
        $year = $request->year;

        if ($year == '2024') {
            switch ($trimestre) {
                case 'Enero - Marzo':
                    $pdf = \PDF::loadView('pdf/tri1_2024');
                    return $pdf->download('TRI1_2024.pdf');
                    break;
                case 'Abril - Junio':
                    $pdf = \PDF::loadView('pdf/tri2_2024');
                    return $pdf->download('TRI2_2024.pdf');
                    break;
                case 'Julio - Septiembre':
                    $pdf = \PDF::loadView('pdf/tri3_2024');
                    return $pdf->download('TRI3_2024.pdf');
                    break;
                case 'Octubre - Diciembre':
                    $pdf = \PDF::loadView('pdf/tri4_2024');
                    return $pdf->download('TRI4_2024.pdf');
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            $pdf = \PDF::loadView('pdf/tri1_2025');
            return $pdf->download('TRI1_2025.pdf');
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
