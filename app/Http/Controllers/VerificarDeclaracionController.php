<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class VerificarDeclaracionController extends Controller
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
        $declaraciones = DB::table('declaracions')
                                ->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                ->join('tipos', 'declaracions.tipo', '=', 'tipos.id_tipo')
                                ->select('declaracions.*', 'sujeto_pasivos.id_sujeto', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'tipos.nombre_tipo')
                                ->where('declaracions.estado', 4)
                                ->get();


        return view('verificar_declaracion', compact('declaraciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function info(Request $request)
    {

        $id_declaracion = $request->post('declaracion');
        $declaracion = DB::table('declaracions')
                                ->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                ->join('clasificacions', 'declaracions.estado', '=', 'clasificacions.id_clasificacion')
                                ->join('tipos', 'declaracions.tipo', '=', 'tipos.id_tipo')
                                ->join('ucds', 'declaracions.id_ucd', '=', 'ucds.id')
                                ->select('declaracions.*', 'sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'clasificacions.nombre_clf', 'tipos.nombre_tipo', 'ucds.valor', 'ucds.moneda')
                                ->where('declaracions.id_declaracion', $id_declaracion)
                                ->first();
        if ($declaracion) {
            $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
            $mes_bd = $declaracion->mes_declarado;
            $mes_libro = $meses[$mes_bd];

            $format_monto = number_format($declaracion->monto_total, 2);

            if ($declaracion->referencia == null) {
                $referencia = '<span class="fw-bold text-danger">SIN ACTIVIDAD ECONÓMICA</span>';
            }else{
                $referencia = '<a target="_blank" class="ver_pago" href="'.asset($declaracion->referencia).'">Ver</a>';
            }

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center flex-column">
                        <i class="bx bx-help-circle fs-2 text-muted"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Verificar Declaración</h1>
                    </div>
                    <div class="modal-body" style="font-size:15px;">
                        <h6 class="text-muted text-center" style="font-size:14px;">Datos de la Declaración</h6>
                        <div class="d-flex justify-content-center px-5 mx-5">
                            <table class="table">
                                <tr>
                                    <th>Contribuyente</th>
                                    <td class="d-flex flex-column">
                                        <span class="fw-bold">'.$declaracion->razon_social.'</span>
                                        <span class="text-muted">'.$declaracion->rif_condicion.'-'.$declaracion->rif_nro.'</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Período</th>
                                    <td class="fw-bold text-success">'.$mes_libro.' '.$declaracion->year_declarado.'</td>
                                </tr>
                                <tr>
                                    <th>Tipo de Declaración</th>
                                    <td class="fst-italic text-secondary">'.$declaracion->nombre_tipo.'</td>
                                </tr>
                                <tr>
                                    <th>Fecha de emisión</th>
                                    <td>'.$declaracion->fecha.'</td>
                                </tr>
                                <tr>
                                    <th>Total de Guías Emitidas</th>
                                    <td class="fw-bold">'.$declaracion->nro_guias_declaradas.' und.</td>
                                </tr>
                                <tr>
                                    <th>UCD del día</th>
                                    <td>'.$declaracion->valor.' ('.$declaracion->moneda.')</td>
                                </tr>
                                <tr>
                                    <th>Total UCD</th>
                                    <td>'.$declaracion->total_ucd.' UCD</td>
                                </tr>
                                <tr class="table-warning">
                                    <th>Monto Total</th>
                                    <td class="fw-bold">'.$format_monto.' Bs.</td>
                                </tr>
                                <tr>
                                    <th>Referencia</th>
                                    <td>
                                        '.$referencia.'
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <button type="button" class="btn btn-success verificar_declaracion btn-sm me-3" id_declaracion="'.$declaracion->id_declaracion.'">Aprobar</button>
                            <button type="button" class="btn btn-danger denegar_declaracion btn-sm me-3" id_declaracion="'.$declaracion->id_declaracion.'">Denegar</button>
                            <button type="button" class="btn btn-secondary btn-sm " data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div> ';

            return response($html);
        }else{
            return response()->json(['success' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function verificar(Request $request)
    {
        $id_declaracion = $request->post('declaracion');
        $updates = DB::table('declaracions')->where('id_declaracion', '=', $id_declaracion)->update(['estado' => 5]);
        if ($updates) {
            $user = auth()->id();
            $sp =  DB::table('declaracions')->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->select('sujeto_pasivos.razon_social')
                                            ->where('id_declaracion','=',$id_declaracion)
                                            ->first(); 
            $accion = 'DECLARACIÓN NRO.'.$id_declaracion.' APROBADA, Contribuyente: '.$sp->razon_social;
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 11, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }

    public function denegar(Request $request)
    {
        $id_declaracion = $request->post('id_declaracion');
        $observaciones = $request->post('observacion');

        $updates = DB::table('declaracions')->where('id_declaracion', '=', $id_declaracion)->update(['estado' => 6, 'observaciones' => $observaciones]);
        if ($updates) {
            $user = auth()->id();
            $sp =  DB::table('declaracions')->join('sujeto_pasivos', 'declaracions.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                            ->select('sujeto_pasivos.razon_social')
                                            ->where('id_declaracion','=',$id_declaracion)
                                            ->first(); 
            $accion = 'DECLARACIÓN NRO.'.$id_declaracion.' RECHAZADA, Contribuyente: '.$sp->razon_social;
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 11, 'accion'=> $accion]);

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
