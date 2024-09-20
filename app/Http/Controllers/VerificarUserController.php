<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SujetoPasivo;
use DB;
use Illuminate\Http\Request;

class VerificarUserController extends Controller
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
        $sujetos = DB::table('sujeto_pasivos')->where('estado','=','Verificando')->get();
        return view('verificar_user',compact('sujetos'));
    }

    public function info(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $query = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->get();
        if ($query) {
            foreach ($query as $sujeto) {
                if ($sujeto->rif_condicion == 'G') {
                    $artesanal = '<span class="fst-italic text-secondary">No Aplica</span>';
                }else{
                    $artesanal = $sujeto->artesanal;
                }
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2 text-muted" ></i>                       
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea aprobar la Verificación del Contribuyente?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5 text-navy fw-bold" id="">'.$sujeto->razon_social.'</h1>
                                    <h5 class="modal-title text-muted" id="" style="font-size:14px">'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                            <table class="table" style="font-size:14px">
                                <tr>
                                    <th>R.I.F.</th>
                                    <td>'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</td>
                                </tr>
                                <tr>
                                    <th>Razon Social</th>
                                    <td>'.$sujeto->razon_social.'</td>
                                </tr>
                                <tr>
                                    <th>¿Artesanal?</th>
                                    <td>'.$artesanal.'</td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>'.$sujeto->direccion.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono móvil</th>
                                    <td>'.$sujeto->tlf_movil.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono fijo</th>
                                    <td>'.$sujeto->tlf_fijo.'</td>
                                </tr>
                            </table>

                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Representante</h6>
                            <table class="table"  style="font-size:14px">
                                <tr>
                                    <th>C.I. del representante</th>
                                    <td>'.$sujeto->ci_condicion_repr.'-'.$sujeto->ci_nro_repr.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F. del representante</th>
                                    <td>'.$sujeto->rif_condicion_repr.'-'.$sujeto->rif_nro_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Nombre y Apellido</th>
                                    <td>'.$sujeto->name_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono movil</th>
                                    <td>'.$sujeto->tlf_repr.'</td>
                                </tr>
                            </table>   

                            <form id="form_aprobar_user" method="post" onsubmit="event.preventDefault(); aprobarUser()">
                                
                                <input type="hidden" class="form-control" name="id_sujeto" value="'.$idSujeto.'">
                                <div class="d-flex justify-content-center my-2">
                                    <button type="submit" class="btn btn-success btn-sm me-4">Aprobar</button>
                                    <a class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</a>
                                </div>
                            </form>
 
                        </div>';
                        
                return response($html);
                
            }
        }
    }

    public function aprobar(Request $request)
    {
        $idSujeto = $request->post('id_sujeto');

        $update = DB::table('sujeto_pasivos')->where('id_sujeto', '=', $idSujeto)->update(['estado' => 'Verificado']);
        if ($update) {

            $user = auth()->id();
            
            $sp = DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$idSujeto)->first(); 
            $accion = 'VERIFICACIÓN DE USUARIO APROBADA, Contribuyente: '.$sp->razon_social.'.';
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 9, 'accion'=> $accion]);

            if ($bitacora) {
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }



    public function info_denegar(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $query = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->get();
        if ($query) {
            foreach ($query as $sujeto) {
                if ($sujeto->rif_condicion == 'G') {
                    $artesanal = '<span class="fst-italic text-secondary">No Aplica</span>';
                }else{
                    $artesanal = $sujeto->artesanal;
                }
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>                      
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea rechazar la Verificación del Contribuyente?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5 text-navy fw-bold">'.$sujeto->razon_social.'</h1>
                                    <h5 class="modal-title text-muted" style="font-size:14px">'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                            <table class="table" style="font-size:14px">
                                <tr>
                                    <th>R.I.F.</th>
                                    <td>'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</td>
                                </tr>
                                <tr>
                                    <th>Razon Social</th>
                                    <td>'.$sujeto->razon_social.'</td>
                                </tr>
                                <tr>
                                    <th>¿Artesanal?</th>
                                    <td>'.$artesanal.'</td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>'.$sujeto->direccion.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono móvil</th>
                                    <td>'.$sujeto->tlf_movil.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono fijo</th>
                                    <td>'.$sujeto->tlf_fijo.'</td>
                                </tr>
                            </table>

                            <h6 class="text-muted text-center" style="font-size:14px;">Datos del Representante</h6>
                            <table class="table"  style="font-size:14px">
                                <tr>
                                    <th>C.I. del representante</th>
                                    <td>'.$sujeto->ci_condicion_repr.'-'.$sujeto->ci_nro_repr.'</td>
                                </tr>
                                <tr>
                                    <th>R.I.F. del representante</th>
                                    <td>'.$sujeto->rif_condicion_repr.'-'.$sujeto->rif_nro_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Nombre y Apellido</th>
                                    <td>'.$sujeto->name_repr.'</td>
                                </tr>
                                <tr>
                                    <th>Teléfono movil</th>
                                    <td>'.$sujeto->tlf_repr.'</td>
                                </tr>
                            </table>   

                            <form id="form_denegar_sujeto" method="post" onsubmit="event.preventDefault(); denegarUser()">
                                
                                <div class="ms-2 me-2">
                                    <label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                                    <input type="hidden" name="id_sujeto" value="'.$idSujeto.'">
                                </div>
                                <div class="text-muted text-end" style="font-size:13px">
                                    <span class="text-danger">*</span> Campos Obligatorios
                                </div>
                            
                                <div class="mt-3 mb-2">
                                    <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                        </span>Las <span class="fw-bold">Observaciones </span>
                                        cumplen la función de notificar al <span class="fw-bold">Contribuyente</span>
                                        del porque su usuario no ha sido verificado. Para que así, puedan rectificar y cumplir con el deber formal.
                                    </p>
                                </div>

                                <div class="d-flex justify-content-center m-3">
                                    <button type="submit" class="btn btn-danger btn-sm me-4">Denegar</button>
                                    <a class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</a>
                                </div>
                            </form>
 
                        </div>';
                        
                return response($html);
                
            }
        }
    }



    public function denegar(Request $request)
    {
        $idSujeto = $request->post('id_sujeto');
        $observacion = $request->post('observacion');

        $updates = DB::table('sujeto_pasivos')->where('id_sujeto', '=', $idSujeto)->update(['estado' => 'Rechazado', 'observaciones' => $observacion]);
        if ($updates) {

            $user = auth()->id();
            $sp = DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$idSujeto)->first(); 
            $accion = 'VERIFICACIÓN DE USUARIO RECHAZADA, Contribuyente: '.$sp->razon_social.'.';
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 9, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
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
