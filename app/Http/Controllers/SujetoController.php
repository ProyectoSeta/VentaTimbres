<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class SujetoController extends Controller
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
        $sujeto = SujetoPasivo::all();
        return view('sujeto',compact('sujeto'));
    }

    public function representante(Request $request)
    {
        $idSujeto = $request->post('sujeto');
       
        $representante = DB::table('sujeto_pasivos')->select('ci_condicion_repr','ci_nro_repr','rif_condicion_repr','rif_nro_repr','name_repr','tlf_repr')->where('id_sujeto','=',$idSujeto)->get();
         if ($representante) {
            $html='';
            foreach ($representante as $repr) {
                $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-briefcase-alt fs-1" style="color:#c14900"></i>
                                <h1 class="modal-title fs-5 text-navy" id="">Datos del Representante</h1>
                                <h5 class="modal-title" id="" style="font-size:14px">Sujeto Pasivo</h5>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <div>
                                <table class="table table-borderless text-center">
                                    <tr>
                                        <th>Nombre y Apellido</th>
                                        <td>'.$repr->name_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>R.I.F.</th>
                                        <td>'.$repr->rif_condicion_repr.'-'.$repr->rif_nro_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>C.I.</th>
                                        <td>'.$repr->ci_condicion_repr.'-'.$repr->ci_nro_repr.'</td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono</th>
                                        <td>'.$repr->tlf_repr.'</td>
                                    </tr>
                                </table>
                            </div>';
            }
            return response($html);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit_estado(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $sujeto = DB::table('sujeto_pasivos')->select('razon_social', 'rif_condicion', 'rif_nro', 'estado')->where('id_sujeto','=',$idSujeto)->first();
        if ($sujeto) {

            $option = '';
            switch ($sujeto->estado) {
                case 'Verificando':
                    $option = '<option value="Verificando">Verificando</option>
                                <option value="Verificado">Verificado</option>
                                <option value="Rechazado">Rechazado</option>';
                    break;
                case 'Verificado':
                    $option = '<option value="Verificado">Verificado</option>
                                <option value="Verificando">Verificando</option>
                                <option value="Rechazado">Rechazado</option>';
                    break;
                case 'Rechazado':
                    $option = '<option value="Rechazado">Rechazado</option>
                                <option value="Verificando">Verificando</option>
                                <option value="Verificado">Verificado</option>';
                    break;
                default:
                    # code...
                    break;
            }

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-refresh bx-spin  fs-1" style="color:#0d8a01"></i>       
                            <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel">Editar Estado</h1>
                        </div>
                    </div>
                    <div class="modal-body p-2">
                        <form id="form_edit_estado_sp" method="post" onsubmit="event.preventDefault(); editEstadoSP()">
                            <div class="mx-4 my-2" style="font-size:14px">
                                <div class="row" >
                                    <div class="col-sm-4 fw-bold">R.I.F.:</div>
                                    <div class="col-sm-8 text-muted">'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 fw-bold">Razon Social:</div>
                                    <div class="col-sm-8 text-muted">'.$sujeto->razon_social.'</div>
                                </div>

                                <div class="row px-5 my-3 mb-4">
                                    <div class="col-sm-5">
                                        <label for="estado" class="fw-bold fs-6 text-navy">Editar Estado</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <select class="form-select form-select-sm" id="estado" aria-label="Small select" name="estado" required="">
                                            '.$option.'
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="sujeto" value="'.$idSujeto.'">

                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                                </div>
                            </div>
                        </form>
                        
                        
                    </div>';
            return response($html);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update_estado(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $estado = $request->post('estado');

        $update = DB::table('sujeto_pasivos')->where('id_sujeto', '=', $idSujeto)->update(['estado' => $estado]);
        if ($update) {
            $user = auth()->id();
            $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$idSujeto)->first(); 
            $accion = 'ESTADO DEL USUARIO '.$sp->razon_social.' ACTUALIZADO A: '.$estado;
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 12, 'accion'=> $accion]);

            return response()->json(['success' => true]);
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
