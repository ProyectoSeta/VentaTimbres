<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
class EstampillasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('emision_estampillas');
    }


    public function modal_emitir(Request $request)
    {
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();

        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$value.'">'.$value.' UCD</option>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-collection fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión de Estampillas</h1>
                        <h5 class="text-muted fw-bold">Timbre móvil</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-secondary">*NOTA: Cada tira emitida trae un total de 160 Estampillas.</p>
                    <form id="form_emitir_estampillas" method="post" onsubmit="event.preventDefault(); emitirEstampillas()">
                        <div class="d-flex flex-column" id="conten_detalle_emision_estampillas">
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <label for="denominacion" class="form-label">Denominación: <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm denominacion" id="denominacion_1" i="1" name="emitir[1][denominacion]">
                                        '.$option.'
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="cantidad" class="form-label">Cant. Tiras: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm cantidad" id="cantidad_1" i="1" name="emitir[1][cantidad]" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="cantidad" class="form-label">Cant. Estampillas:</label>
                                    <input type="number" class="form-control form-control-sm" id="timbres_1" disabled>
                                </div>
                                <div class="col-md-1 pt-4">
                                    <a  href="javascript:void(0);" class="btn add_button border-0">
                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);

        
    }


    /**
     * Show the form for creating a new resource.
     */
    public function denominacions(Request $request)
    {
       
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$value.'">'.$value.' UCD</option>';
           
        }
        return response($option);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function emitir(Request $request)
    {
        $emitir = $request->post('emitir');

        /////////VERIFICACIÓN DE CAMPOS
        foreach ($emitir as $e) {
            if ($e['denominacion'] === 'Seleccione') {
                return response()->json(['success' => false, 'nota' => 'Disculpe, debe seleccionar la denominación ucd que desea emitir para la tira de estampillas.']);
            }else{
                if ($e['cantidad'] == 0) {
                    return response()->json(['success' => false, 'nota' => 'Disculpe, debe colocar la cantidad de tiras que quiere emitir segun la denominación.']);
                }
            }
            
        }


        //////////EMISIÓN
        $consulta = DB::table('emision_estampillas')->selectRaw("count(*) as total")->first();
        if ($consulta->total != 0) {
            //////ya se han emitido rollos
            $query =  DB::table('emision_rollos')->select('id_emision')->orderBy('id_emision', 'desc')->first();

            $consulta_2 =  DB::table('detalle_emision_rollos')->select('hasta')->where('key_emision','=',$query->id_emision)->orderBy('correlativo', 'desc')->first();

            $desde = $consulta_2->hasta + 1;
        }else{
            /////primer lote a emitir
            $desde = 1;
        }

        foreach ($emitir as $e) {
            
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
