<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ConfigController extends Controller
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
        $variables = DB::table('variables')->get();
        return view('config', compact('variables'));
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
    public function modal(Request $request)
    {
        $variable = $request->post('variable');

        $query = DB::table('variables')->where('id','=',$variable)->first();
        $accion = '';
        switch ($query->nombre) {
            case 'cierre_libro':
                $accion = 'Cierre de Libro';
                break;
            case 'inicio_declaracion':
                $accion = 'Primer día para Declarar';
                break;
            case 'fin_declaracion':
                $accion = 'Ultimo día para Declarar';
                break;
            case 'talonarios_min_imprenta':
                $accion = 'Nro. Mínimo de Talonarios | Imprenta';
                break;
            
            default:
                # code...
                break;
        }
        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-pencil fs-1 text-muted" ></i>                 
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel">'.$accion.'</h1>
                        <div class="">
                            <h5 class="modal-title text-muted fw-bold" id="" style="font-size:14px">Editar acción</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <div class="mx-2">
                        <form  id="form_editar_variable" method="post" onsubmit="event.preventDefault(); editarVariable()">
                            <label for="new_var" class="form-label mt-3">¿Cual es el nuevo valor de la Acción? <span style="color:red">*</span></label>
                            <input class="form-control form-control-sm" type="number" id="new_var" name="new_var" required>
                            <input type="hidden" name="id_variable" value="'.$query->id.'" required> 
                            
                            <p class="text-muted text-end mt-2 mb-5"><span style="color:red">*</span> Campos requeridos.</p>

                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm me-3" id="btn_guardar_guia">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>';

        return response($html);
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request)
    {
        $id = $request->post('id_variable');
        $valor = $request->post('new_var');

        $update = DB::table('variables')->where('id', '=', $id)->update(['valor' => $valor]);
        if ($update) {
            $user = auth()->id();
            
            $consulta = DB::table('variables')->select('nombre')->where('id','=',$id)->first();
            $accion_bitacora = 'El Valor de la Acción:'.$consulta->nombre.', fue modificada a '.$valor.'.';;
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 32, 'accion'=> $accion_bitacora]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

}
