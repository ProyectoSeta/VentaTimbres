<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class VerificarCanteraController extends Controller
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
        $canteras = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                ->where('status', 'Verificando')->get();
        return view('verificar_cantera', compact('canteras'));
    }


    public function info(Request $request)
    {
        $idCantera = $request->post('cantera');
        
        $query = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                ->where('canteras.id_cantera','=',$idCantera)->get();
        if ($query) {
            $html = '';
            $min = '';

            foreach ($query as $c) {
                //////////////minerales
               
                $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get(); 
                foreach ($minerales as $id_min) {
                    $id = $id_min->id_mineral;
                    $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                    if($query_min){
                        foreach ($query_min as $mineral) {
                            $name_mineral = $mineral->mineral;
                            $min .= '<span>'.$name_mineral.'</span>';
                        }
                    } 
                }

                ///////////datos cantera
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-help-circle fs-2 text-muted"></i>                       
                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">¿Verificar Cantera?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5 text-navy fw-bold" id="">'.$c->nombre.'</h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <form id="form_verificar_cantera" method="post" onsubmit="event.preventDefault(); verificarCantera()">
                                <table class="table">
                                    <tr>
                                        <th>Conribuyente</th>
                                        <td class="d-flex flex-column">
                                            <span>'.$c->razon_social.'</span>
                                            <span>'.$c->rif_condicion.'-'.$c->rif_nro.'</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nombre de la Cantera</th>
                                        <td>'.$c->nombre.'</td>
                                    </tr>
                                    <tr>
                                        <th>Lugar de Aprovechamiento</th>
                                        <td>'.$c->lugar_aprovechamiento.'</td>
                                    </tr>
                                    <tr>
                                        <th>Producción</th>
                                        <td class="d-flex flex-column">
                                            '.$min.'
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Límite de Guías solicitadas por período</th>
                                        <td>
                                            <input type="number" class="form-control" id="limite_guia_cantera" name="limite_guia_cantera" required>
                                            <input type="hidden" name="id_cantera" value="'.$idCantera.'">
                                        </td>
                                    </tr>
                                </table>
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span> El <span class="fw-bold">Límite de guías a solicitar, </span>
                                    se define como el límite impuesto de guías que el contribuyente pude solicitar en un 
                                    <span class="fw-bold">período de tres (3) meses</span>, lo cual se aplica
                                    <span class="fw-bold">exclusivamete a esta cantera</span>. El número de guias se estima según su producción.
                                    
                                </p>
                                <div class="d-flex justify-content-center my-3">
                                    <button type="submit" class="btn btn-success btn-sm me-4" id="cantera_verificada">Verificar y guardar</button>
                                    <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>';
                return response($html);
            }
        }
    }

    public function verificar(Request $request)
    {
        $idCantera = $request->post('id_cantera');
        $limite = $request->post('limite_guia_cantera');
        $sujeto = DB::table('canteras')->select('id_sujeto')->where('id_cantera','=',$idCantera)->first();
        if ($sujeto) { 
            $idSujeto = $sujeto->id_sujeto; 
            $hoy = date('Y-m-d');
            $fin = date("Y-m-d", strtotime($hoy . "+ 3 months"));
            
            $insert = DB::table('limite_guias')->insert(['id_sujeto' => $idSujeto, 'id_cantera' => $idCantera, 'total_guias_periodo'=>$limite, 'inicio_periodo' => $hoy, 'fin_periodo' => $fin, 'total_guias_solicitadas_periodo' => '0']);
            $updates = DB::table('canteras')->where('id_cantera', '=', $idCantera)->update(['status' => 'Verificada']);
            if ($insert && $updates) {
                $user = auth()->id();
                $sp = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                        ->select('canteras.nombre','sujeto_pasivos.razon_social')
                                        ->where('canteras.id_cantera','=',$idCantera)->first(); 
                $accion = 'VERIFICACIÓN APROBADA, Cantera: '.$sp->nombre.', Contribuyente: '.$sp->razon_social.'.';
                $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 10, 'accion'=> $accion]);

                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }


        }

       
    }



    public function info_denegar(Request $request)
    {
        $idCantera = $request->post('cantera');
        $query = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto','=', 'sujeto_pasivos.id_sujeto')
                ->select('canteras.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro')
                ->where('canteras.id_cantera','=',$idCantera)->get();
        if ($query) {
            $html = '';
            $min = '';

            foreach ($query as $c) {
                //////////////minerales
                $minerales = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
                foreach ($minerales as $id_min) {
                    $id = $id_min->id_mineral;
                    $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                    if($query_min){
                        foreach ($query_min as $mineral) {
                            $name_mineral = $mineral->mineral;
                            $min .= '<span>'.$name_mineral.'</span>';
                        }
                    } 
                }

                ///////////datos cantera
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>                    
                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">¿Rechazar la Verificación de la Cantera?</h1>
                                <div class="">
                                    <h1 class="modal-title fs-5 text-navy fw-bold" id="">'.$c->nombre.'</h1>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                        <form id="denegar_cantera" method="post" onsubmit="event.preventDefault(); denegarCantera()">
                            <table class="table">
                                <tr>
                                    <th>Conribuyente</th>
                                    <td class="d-flex flex-column">
                                        <span>'.$c->razon_social.'</span>
                                        <span>'.$c->rif_condicion.'-'.$c->rif_nro.'</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nombre de la Cantera</th>
                                    <td>'.$c->nombre.'</td>
                                </tr>
                                <tr>
                                    <th>Lugar de Aprovechamiento</th>
                                    <td>'.$c->lugar_aprovechamiento.'</td>
                                </tr>
                                <tr>
                                    <th>Producción</th>
                                    <td class="d-flex flex-column">
                                        '.$min.'
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span></th>
                                    <td>
                                        <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                                        <input type="hidden" name="id_cantera" value="'.$idCantera.'">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-muted text-end" style="font-size:13px">
                                <span class="text-danger">*</span> Campos Obligatorios
                            </div>
                        
                            <div class="mt-3 mb-2">
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span>Las <span class="fw-bold">Observaciones </span>
                                    cumplen la función de notificar al <span class="fw-bold">Contribuyente</span>
                                    del porque la Cantera no ha sido verificada. Para que así, puedan rectificar y cumplir con el deber formal.
                                </p>
                            </div>

                            <div class="d-flex justify-content-center m-3">
                                <button type="submit" class="btn btn-danger btn-sm me-4">Denegar</button>
                                <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>

                            
                        </div>';
                return response($html);
            }
        }
    }


    public function denegar(Request $request)
    {
        $idCantera = $request->post('id_cantera');
        $observacion = $request->post('observacion');

        $updates = DB::table('canteras')->where('id_cantera', '=', $idCantera)->update(['status' => 'Denegada', 'observaciones' => $observacion]);
        if ($updates) {
            $user = auth()->id();
            $sp = DB::table('canteras')->join('sujeto_pasivos', 'canteras.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                    ->select('canteras.nombre','sujeto_pasivos.razon_social')
                                    ->where('canteras.id_cantera','=',$idCantera)->first(); 
            $accion = 'VERIFICACIÓN RECHAZADA, Cantera: '.$sp->nombre.', Contribuyente: '.$sp->razon_social.'.';
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 10, 'accion'=> $accion]);

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
