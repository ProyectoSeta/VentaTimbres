<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AperturaTaquillasController extends Controller
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
        return view('apertura');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_apertura()
    {
        $tr = '';
        $query = DB::table('taquillas')->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                                        ->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                        ->select('sedes.sede','funcionarios.nombre','taquillas.id_taquilla')
                                        ->get();
        foreach ($query as $taquilla) {
            $tr .= '<tr>
                        <td>'.$taquilla->id_taquilla.'</td>
                        <td>'.$taquilla->sede.'</td>
                        <td>'.$taquilla->nombre.'</td>
                        <td>
                            <div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input form-select-lg check_apertura" taquilla="'.$taquilla->id_taquilla.'" type="checkbox" role="switch" id="apertura_'.$taquilla->id_taquilla.'" name="apertura[]" value="'.$taquilla->id_taquilla.'">
                                <label class="form-check-label" id="label_'.$taquilla->id_taquilla.'" for="apertura_'.$taquilla->id_taquilla.'">No</label>
                            </div>
                        </td>
                    </tr>';
        }

        $hoy = date('d-m-Y');

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-lock-open-alt fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Aperturar Taquillas</h1>
                        <h5 class="text-muted fs-6">25-12-2024</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_aperturar_taquillas" method="post" onsubmit="event.preventDefault(); aperturaTaquillas()">
                        <table class="table" id="table_apertura">
                            <thead>
                                <tr>
                                    <th>Id Taquilla</th>
                                    <th>Ubicación</th>
                                    <th>Taquillero</th>
                                    <th>Apertura</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>


                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aperturar</button>
                        </div>
                    </form>
                </div>';
        
        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function apertura_taquillas(Request $request)
    {
        $apertura = $request->post('apertura');

        foreach ($apertura as $id_taquilla) {
            $insert = DB::table('apertura_taquillas')->insert(['key_taquilla' => $id_taquilla]);
        }
        
        return response()->json(['success' => true]); 
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
