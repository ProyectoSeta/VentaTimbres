<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AjustesController extends Controller
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
        $con_14 = DB::table('configuraciones')->join('clasificacions', 'configuraciones.unidad', '=', 'clasificacions.id_clasificacion')
                                                ->select('configuraciones.*','clasificacions.nombre_clf')
                                                ->where('configuraciones.module', '=',23)->get();
        $con_venta = DB::table('configuraciones')->join('clasificacions', 'configuraciones.unidad', '=', 'clasificacions.id_clasificacion')
                                                ->select('configuraciones.*','clasificacions.nombre_clf')
                                                ->where('configuraciones.module', '=',24)->get();
        $con_est = DB::table('configuraciones')->join('clasificacions', 'configuraciones.unidad', '=', 'clasificacions.id_clasificacion')
                                                ->select('configuraciones.*','clasificacions.nombre_clf')
                                                ->where('configuraciones.module', '=',27)->get();
        $ucd = DB::table('ucds')->orderBy('id', 'desc')->first();

        return view('ajustes',compact('con_14','con_venta','con_est','ucd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_editar(Request $request)
    {
        $correlativo = $request->post('correlativo'); 
        $variable = $request->post('variable'); 
        $nombre = '';
        $inputs = '';
        

        if ($variable == 'ucd') {
            $nombre = 'Precio U.C.D';

            $inputs = '<div class="row my-0">
                        <div class="col-md-8">
                            <label for="valor" class="form-label mt-3">Nuevo valor para <span class="text-navy">"'.$nombre.'"</span> <span style="color:red">*</span></label>
                            <input class="form-control form-control-sm" step="0.01" type="number" id="valor" name="valor" required>
                        </div>
                        <div class="col-md-4">
                            <label for="moneda" class="form-label mt-3">Moneda <span style="color:red">*</span></label>
                            <select class="form-select form-select-sm" aria-label="Small select example" id="moneda" name="moneda">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                                <option value="CNY">CNY</option>
                                <option value="TRY">TRY</option>
                                <option value="RUB">RUB</option>
                            </select>
                        </div>
                    </div>';
        }else{
            if ($correlativo == 3) { ////INICIO DE CORRELATIVO TFE-14
                $c1 = DB::table('configuraciones')->select('valor')->where('correlativo', '=', $correlativo)->first();
                if ($c1->valor != NULL){
                    return response()->json(['success' => false, 'nota' => 'Disculpe, este valor solo es modificable una (1) sola vez.']);
                }
            }

            $query = DB::table('configuraciones')->select('nombre')->where('correlativo', '=', $correlativo)->first();
            $nombre = $query->nombre;

            $inputs = '<label for="valor" class="form-label mt-3">¿Cual es el nuevo valor para <span class="text-navy">"'.$nombre.'"</span>? <span style="color:red">*</span></label>
                        <input class="form-control form-control-sm" step="0.01" type="number" id="valor" name="valor" required>';
        }
        
        
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                    <i class="bx bx-pencil fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Editar Valor</h1>
                        <div class="text-muted fw-semibold">'.$nombre.'</div>
                    </div>
                </div>
                <div class="modal-body px-5" style="font-size:13px">
                    <form  id="form_editar_valor_ajustes" method="post" onsubmit="event.preventDefault(); editarValor()">
                        '.$inputs.'

                        <input type="hidden" name="correlativo" value="'.$correlativo.'" required> 
                        <input type="hidden" name="variable" value="'.$variable.'" required> 
                        
                        <p class="text-muted text-end mt-2 "><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="submit" class="btn btn-success btn-sm me-3" id="btn_guardar_guia">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>';

        return response()->json(['success' => true, 'html' => $html]);
        
        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
    public function update(Request $request)
    {
        $correlativo = $request->post('correlativo'); 
        $variable = $request->post('variable'); 
        $valor = $request->post('valor'); 
        $hoy = date('Y-m-d h:i:s');

        if ($variable == 'ucd') {
            $moneda = $request->post('moneda'); 
            $insert = DB::table('ucds')->insert(['valor' => $valor, 'moneda' => $moneda]); 
            if ($insert) {
                ////BITACORA
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            if ($correlativo == 3) { ////INICIO DE CORRELATIVO TFE-14
                //verificar si el valor no ha sido ingresado antes
                $c1 = DB::table('configuraciones')->select('valor')->where('correlativo', '=', $correlativo)->first();
                if ($c1->valor == NULL) {
                    $update = DB::table('configuraciones')->where('correlativo','=',$correlativo)->update(['valor' => $valor, 'updated_at' => $hoy]);
                    if ($update) {
                        ////BITACORA
                        return response()->json(['success' => true]);
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    /// BITACORA
                    return response()->json(['success' => false, 'nota' => 'Disculpe, este valor solo es modificable una (1) sola vez.']);
                }
            }else{
                $update = DB::table('configuraciones')->where('correlativo','=',$correlativo)->update(['valor' => $valor, 'updated_at' => $hoy]);
                if ($update) {
                    ////BITACORA
                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
