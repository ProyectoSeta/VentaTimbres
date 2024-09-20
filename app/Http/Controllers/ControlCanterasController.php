<?php

namespace App\Http\Controllers;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ControlCanterasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 
     * Display a listing of the resource.
     */
    public function index()
    {
        $limites = DB::table('limite_guias')
                ->join('sujeto_pasivos', 'limite_guias.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->join('canteras', 'limite_guias.id_cantera','=', 'canteras.id_cantera')
                ->select('limite_guias.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                ->get();

        return view('control_canteras', compact('limites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_limite(Request $request)
    {
        $cantera = $request->post('cantera');

        $limite = DB::table('limite_guias')->select('total_guias_periodo')->where('id_cantera','=',$cantera)->first();
        if ($limite) {
            $html = '<form id="form_update_limite" method="post" onsubmit="event.preventDefault(); updateLimite()">
                        <p class="text-secondary text-justify">*La actualización del límite de guías que puede solicitar el Contribuyente en un período de tres (3) meses.</p>
                        <div class="row text-center mx-3 mb-4">
                            <div class="col-sm-6 fw-bold">Límite Actual</div>
                            <div class="col-sm-6 text-muted">'.$limite->total_guias_periodo.' Guías</div>
                        </div>
                        <div class="row text-center mx-2 mb-4">
                            <div class="col-sm-6 fw-bold">Nuevo Límite<span style="color:red">*</span></div>
                            <div class="col-sm-6">
                                <input type="number" class="form-control form-control-sm" name="limite" id="new_limite" required>
                            </div>
                        </div>
                        <p class="text-muted text-end mx-2 mb-3"><span style="color:red">*</span> Campos requeridos.</p>
                        <input type="hidden" name="id_cantera" value="'.$cantera.'">
                        <div class="d-flex justify-content-center my-3">
                            <button type="submit" class="btn btn-success btn-sm me-4">Actualizar</button>
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>';
            return response($html);
        }

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
    public function update(Request $request)
    {
        $cantera = $request->post('id_cantera');
        $limite = $request->post('limite');

        $updates = DB::table('limite_guias')->where('id_cantera', '=', $cantera)->update(['total_guias_periodo' => $limite]);
        if ($updates) {
            $user = auth()->id();
            $c =  DB::table('canteras')->select('nombre')->where('id_cantera','=',$cantera)->first(); 
            $accion = 'LÍMITE DE SOLICITUD DE GUÍAS ACTUALIZADO A '.$limite.' GUÍAS, CANTERA: '.$c->nombre.'.';
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 14, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
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
