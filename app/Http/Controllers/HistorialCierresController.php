<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class HistorialCierresController extends Controller
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
        return view('historial_cierres');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $fecha = $request->post('fecha');

        //////APERTURAS DEL DÍA TAQUILLAS
        // $aperturas = [];

        $tr = '';
        $total = DB::table('apertura_taquillas')->selectRaw("count(*) as total")->whereDate('fecha', $fecha)->first();
        $query = DB::table('apertura_taquillas')->whereDate('fecha', $fecha)->get();

        if ($total->total != 0) {
            foreach ($query as $q1) {
                $q2 = DB::table('taquillas')->where('id_taquilla','=', $q1->key_taquilla)->first();
    
                $q3 = DB::table('sedes')->select('sede')->where('id_sede','=', $q2->key_sede)->first();
                $q4 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $q2->key_funcionario)->first();
    
                $hora_apertura = date("h:i A",strtotime($q1->apertura_admin));
                $estado = 1;
                $apertura_taquillero = '';
                if ($q1->apertura_taquillero != null) {
                    $apertura_taquillero = '<span class="badge bg-info-subtle border border-info-subtle text-info-emphasis rounded-pill" style="font-size:12.7px">'.date("h:i A",strtotime($q1->apertura_taquillero)).'</span>';
                }else{
                    $apertura_taquillero = '<span class="fst-italic fw-bold text-muted">Taquillero sin Aperturar.</span>';
                }
    
                $cierre = '';
                if ($q1->cierre_taquilla != null) {
                    $cierre = '<span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:12.7px">'.date("h:i A",strtotime($q1->cierre_taquilla)).'</span>';
                    $arqueo = '<a href="'.route('cierre.arqueo', ['id' => $q1->key_taquilla, 'fecha' => $fecha]).'">Ver</a>';
                    $estado = 0;
                }else{
                    $cierre = '<span class="fst-italic fw-bold text-muted">Sin cierrar.</span>';
                    $arqueo = '<span class="fst-italic fw-bold text-muted">Sin cierrar.</span>';
                }
                
                $tr .= '<tr>
                            <td>'.$q1->key_taquilla.'</td>
                            <td>'.$q3->sede.'</td>
                            <td>'.$q4->nombre.'</td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">'.$hora_apertura.'</span>
                            </td>
                            <td>
                                '.$apertura_taquillero.'
                            </td>
                            <td>
                                '.$cierre.'
                            </td>
                            <td>
                                '.$arqueo.'
                            </td>
                        </tr>';
            }
    
            $table_aperturas = '<p class="text-navy fw-bold fs-4 titulo">Cierre de Taquillas</p>
                                <div class="table-response" style="font-size:12.7px">
                                    <table class="table table-sm" style="font-size:12.7px" id="table_historial_cierre">
                                        <thead>
                                            <tr>
                                                <th>ID Taquilla</th>
                                                <th>Ubicación</th>
                                                <th>Taquillero</th>
                                                <th>Hora Apertura</th>
                                                <th>Apertura Taquillero</th>
                                                <th>Cierre Taquilla</th>
                                                <th>Arqueo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.$tr.'
                                        </tbody>
                                    </table>
                                </div>';
    
            //////// 
            $con = DB::table('cierre_diarios')->whereDate('fecha', $fecha)->first();
            if ($con) {
                $btn = '<a href="'.route('cierre_diario', ['fecha' => $fecha]).'" class="btn bg-navy rounded-pill px-3 text-center btn-sm fw-bold">
                            Ver Cierre del día
                        </a>';
            }else{
                $btn = '<div class="fw-bold text-center fs-4 titulo">Sin Cierre General.</div>';
            }

            $html = '<div class="d-flex justify-content-center">
                        '.$btn.'
                    </div>
                    '.$table_aperturas.'';
        }else{
            $html = '<div class="text-center fw-semibol fs-5 text-danger">SIN ACTIVIDAD</div>';
        }

        return response($html);
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
