<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteAnualController extends Controller
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
        $meses = [
                1 => "Enero",
                2 => "Febrero",
                3 => "Marzo",
                4 => "Abril",
                5 => "Mayo",
                6 => "Junio",
                7 => "Julio",
                8 => "Agosto",
                9 => "Septiembre",
                10 => "Octubre",
                11 => "Noviembre",
                12 => "Diciembre"
            ];

        $recaudacion_total = 0;
        $recaudacion_total_tfe = 0;
        $recaudacion_total_est = 0;

        $content_meses = [];


        foreach ($meses as $numero => $nombre) {
            $recaudado_mes = 0;
            $recaudado_tfe = 0;
            $recaudado_est = 0;
            $recaudado_punto = 0;
            $recaudado_efectivo = 0;

            $actividad = true;

            $c2 = DB::table('cierre_diarios')->whereMonth('fecha', $numero)->whereYear('fecha', $year)->get();
            if ($c2) {
                foreach ($c2 as $key) {
                    $recaudado_mes = $recaudado_mes + $key->recaudado;
                    $recaudado_tfe = $recaudado_tfe + $key->recaudado_tfe;
                    $recaudado_est = $recaudado_est + $key->recaudado_est;
                    $recaudado_punto = $recaudado_punto + $key->punto;
                    $recaudado_efectivo = $recaudado_efectivo + $key->efectivo;
                }
            }else{
                /// sin actividad
                $actividad = false;
            }


            $array = array(
                        'mes' => $nombre,
                        'recaudado_tfe' => $recaudado_tfe,
                        'recaudado_est' => $recaudado_est,
                        'recaudado_punto' => $recaudado_punto,
                        'recaudado_efectivo' => $recaudado_efectivo,
                        'recaudado_mes' => $recaudado_mes,
                        'actividad' => $actividad
                    );
                
            $a = (object) $array;
            array_push($content_meses,$a);


            $recaudacion_total = $recaudacion_total + $recaudado_mes;
            $recaudacion_total_tfe = $recaudacion_total_tfe + $recaudado_tfe;
            $recaudacion_total_est = $recaudacion_total_est + $recaudado_est;
        }

        

        $pdf = PDF::loadView('pdf/reporte_anual', compact('content_meses','recaudacion_total','recaudacion_total_tfe','recaudacion_total_est','year'));

        return $pdf->download('Reporte Anual '.$year.'.pdf');
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
