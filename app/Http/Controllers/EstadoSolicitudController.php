<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EstadoSolicitudController extends Controller
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
        $verificando = DB::table('solicituds')
                    ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                    ->select('solicituds.*','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                    ->where('solicituds.estado','=',4)->get();

        $negadas = DB::table('solicituds')
                    ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                    ->select('solicituds.*','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                    ->where('solicituds.estado','=',6)->get();

        $proceso = DB::table('solicituds')
                    ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                    ->select('solicituds.*','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                    ->where('solicituds.estado','=',17)->get();

        $retirar = DB::table('solicituds')
                    ->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                    ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                    ->select('solicituds.*','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'canteras.nombre')
                    ->where('solicituds.estado','=',18)->get();

        return view('estado_solicitud', compact('verificando','negadas','proceso','retirar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detalles(Request $request)
    {
        $idSolicitud = $request->post('solicitud'); 

        $solicitud = DB::table('solicituds')
                        ->join('detalle_solicituds', 'solicituds.id_solicitud','=', 'detalle_solicituds.id_solicitud')
                        ->select('solicituds.*', 'detalle_solicituds.cantidad')
                        ->where('solicituds.id_solicitud','=',$idSolicitud)
                        ->first();   
                                          
        if ($solicitud) {
            $detalle = '';
            $tr_detalle = '';

            
            $query = DB::table('talonarios')->select('id_talonario', 'desde', 'hasta', 'fecha_enviado_imprenta','fecha_recibido_imprenta','fecha_retiro')
                    ->where('id_solicitud','=',$idSolicitud)->where('asignacion_talonario','=',26)
                    ->get(); 

            foreach ($query as $t) {
                $desde = $t->desde;
                $hasta = $t->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

                $enviado_imprenta = '';
                $recibido_imprenta = '';
                $retiro = '';

                if ($t->fecha_enviado_imprenta == '') {
                    $enviado_imprenta = '<td class="text-secondary fst-italic">Sin enviar</td>';
                }else{
                    $enviado_imprenta = '<td class="text-secondary">'.$t->fecha_enviado_imprenta.'</td>';
                }

                if ($t->fecha_recibido_imprenta == '') {
                    $recibido_imprenta = '<td class="text-secondary fst-italic">Sin recibir</td>';
                }else{
                    $recibido_imprenta = '<td class="text-secondary">'.$t->fecha_recibido_imprenta.'</td>';
                }

                if ($t->fecha_retiro == '') {
                    $retiro = '<td class="text-secondary fst-italic">Sin entregar</td>';
                }else{
                    $retiro = '<td class="text-muted fw-bold">'.$t->fecha_retiro.'</td>';
                }

                $tr_detalle .= '<tr>
                                    <td class="text-muted">'.$t->id_talonario.'</td>
                                    <td class="text-navy fst-italic">'.$formato_desde.' - '.$formato_hasta.'</td>
                                    '.$enviado_imprenta.'
                                    '.$recibido_imprenta.'
                                    '.$retiro.'
                                </tr>';
            }

            $detalle = '<p class="text-navy text-center mt-2 mb-2 fw-bold">TALONARIO(S)</p>
                        <div class="d-flex justify-content-center">
                            <table class="table mx-3 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Correlativo</th>
                                        <th>Enviado</th>
                                        <th>Recibido</th>
                                        <th>Entregado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    '.$tr_detalle.'
                                </tbody>
                            </table>
                        </div>';
            


            $html = '<div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-layer fs-1 text-secondary"  ></i>                    
                                <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel">Detalles de la Solicitud</h1>
                            </div>
                    </div>
                    <div class="modal-body" style="font-size:13px;">
                        <div class="row mx-3">
                            <div class="col-sm-6">
                                <span class="fw-bold">Nro. Solicitud: </span>
                                <span class="text-muted">'.$solicitud->id_solicitud.'</span>
                            </div>
                            <div class="col-sm-6 text-end">
                                <span class="fw-bold">Fecha:  </span>
                                <span class="text-muted">'.$solicitud->fecha.'</span>
                            </div>
                        </div>

                        <p class="text-navy text-center mt-2 mb-2 fw-bold">SOLICITUD</p>

                        <div class="d-flex justify-content-center">
                            <table class="table w-75 text-center">
                                <tr>
                                    <th>Tipo Talonario</th>
                                    <th>Cantidad</th>
                                </tr>
                                <tr class="table-warning">
                                    <td>50 Guías</td>
                                    <td>'.$solicitud->cantidad.'</td>
                                </tr>
                            </table>
                        </div>

                        '.$detalle.'

                        <div class="text-end fs-6 mx-4 mb-3">
                            <span class="fw-bold">TOTAL UCD </span>
                            <span class="text-muted">'.$solicitud->total_ucd.' UCD</span>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                            <button  class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                        
                    </div>';
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
