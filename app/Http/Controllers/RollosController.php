<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class RollosController extends Controller
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
        return view('emision_rollos');
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
    public function emitir(Request $request)
    {
        $user = auth()->id();
        $cantidad = $request->post('cantidad'); 
        $desde = '';
        $hasta = '';
        $tr = '';

        $consulta = DB::table('emision_rollos')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido rollos
            $query =  DB::table('emision_rollos')->select('id_emision')->orderBy('id', 'desc')->first();
            $consulta_2 =  DB::table('detalle_emision_rollos')->select('hasta')->where('key_emision','=',$query->id_emision)->first();

            $desde = $consulta_2->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }
        
        $insert_emision = DB::table('emision_rollos')->insert(['key_user' => $user,'cantidad' => $cantidad]);   
        if ($insert_emision) {
            $id_emision = DB::table('emision_rollos')->max('id_emision');

            for ($i=1; $i >= $cantidad; $i++) { 
                $hasta = ($desde + 160) - 1;
                $insert_detalle = DB::table('detalle_emision_rollos')->insert([
                            'key_emision' => $id_emision,
                            'desde' => $desde,
                            'hasta' => $hasta]);     

                if ($insert_detalle) {
                    $length = 6;
                    $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                    $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                    $tr .= '<tr>
                                <td>'.$i.'</td>
                                <td>A-'.$formato_desde.'</td>
                                <td>A-'.$formato_hasta.'</td>
                            </tr>';
                }else{
                    return response()->json(['success' => false]);
                }
    
                $desde = $hasta + 1;
            }

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-collection fs-2 text-muted me-2"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | <span class="text-muted">Rollos emitidos</span></h1>
                        </div>
                    </div>
                    <div class="modal-body px-5 py-3" style="font-size:13px">
                        <p class="text-secondary">*NOTA: Cada rollo emitido trae un total de 160 Trimbres Fiscales.</p>
                    
                        <div class="">
                            <table class="table text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr.'
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <a href="" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                        </div>
                    </div>';
            return response()->json(['success' => true, 'html' => $html]);
        }else{
            return response()->json(['success' => false]);
        }
        
        
       

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
