<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SujetoPasivo;
use App\Models\Solicitud;
use DB;

class SolicitudController extends Controller
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
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        // var_dump($sp);
        $id_sp = $sp->id_sujeto;

        $solicitudes = DB::table('solicituds')->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('clasificacions', 'solicituds.estado', '=', 'clasificacions.id_clasificacion')
                                            ->select('solicituds.*','canteras.nombre','clasificacions.nombre_clf')
                                            ->where('solicituds.id_sujeto', $id_sp)->get();

        // var_dump($solicitudes);
        return view('solicitud',compact('solicitudes'));

    }

  

    /**
     * Show the form for creating a new resource.
     */
    public function new_solicitud()
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $opction_canteras = '';
        $canteras = DB::table('canteras')->select('id_cantera','nombre')->where('id_sujeto','=',$id_sp)
                                                                        ->where('status','=','Verificada')->get();
        if ($canteras) {
            foreach ($canteras as $cantera) {
                $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
            }
            $fecha_actual = date('Y-m-d');
            $html = '<div class="text-center mb-2">
                        <span class="fs-6 fw-bold text-navy">Datos de la Solicitud</span>
                    </div>
                    <form id="form_generar_solicitud" method="post" onsubmit="event.preventDefault(); generarSolicitud();">
                        
                        <div class="row mb-2">
                            <div class="col-5">
                                <label class="form-label" for="rif">Cantera a la que va dirigido el Talonario</label><span class="text-danger">*</span>
                            </div>
                            <div class="col-7">
                                <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                    '.$opction_canteras.'
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="tipo">Contenido del Talonario</label>
                                <input type="text" class="form-control form-control-sm mb-3 text-center" name="tipo" id="tipo" value="50 guías" readonly>
                            </div>
                            <div class="col-6">
                                <label for="cant_talonario">Cantidad <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm mb-3" type="number" name="cantidad" id="cantidad" required>
                            </div>
                        </div> 
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary btn-sm" id="calcular">Calular</button>
                        </div>

                        <div class="d-flex justify-content-end align-items-center me-2 fs-6 mb-2">
                            <span class="fw-bold me-4">Total: </span>
                            <span id="total_ucd" class="fs-5">0 UCD</span>
                        </div>

                        <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Notas: </span><br>
                            <span class="fw-bold">1. </span>Cada Guía tiene un valor de <span class="fw-bold">cinco (5) UCD</span> (Unidad de Cuenta Dinámica).<br>
                            <span class="fw-bold">2. </span>Solo podrá eligir las canteras que hayan sido verificadas previamente.
                        </p>

                        <div class="d-flex justify-content-center mt-3 mb-3" >
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar" disabled>Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_solicitud" disabled>Realizar solicitud</button>
                        </div>
                    </form>';

            return response($html);

        }else{
            return response('Error al traer las canteras verificadas.');
        }



    }

   
    public function store(Request $request)
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $idCantera = $request->post('cantera');
        $cant = $request->post('cantidad');
        $tipo = 50;

        $limites = DB::table('limite_guias')->where('id_cantera','=',$idCantera)->get();
        // return response($limites);
        if ($limites) {
            foreach ($limites as $limite) {
                $fecha_actual = date('Y-m-d');
                if ($fecha_actual > $limite->fin_periodo) {
                    ////ALCANZO LA FECHA LIMITE, TOCA NUEVO PERIODO
                    $inicio = $fecha_actual;
                    $fin = date("Y-m-d", strtotime($inicio . "+ 3 months"));

                    $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => 0, 'inicio_periodo' => $inicio, 'fin_periodo' => $fin]);
                    if ($update_limite) {
                        $limites_actualizado = DB::table('limite_guias')->where('id_cantera','=',$idCantera)->get();
                        if ($limites_actualizado) {
                            foreach ($limites_actualizado as $l) {
                                $solicitado = $cant * $tipo;
                                $total_guias_prev = $l->total_guias_solicitadas_periodo + $solicitado;
                                if ($total_guias_prev <= $l->total_guias_periodo) {
                                    $ucd_pagar = $solicitado * 5;

                                    $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 
                                                                                        'id_cantera'=>$idCantera, 
                                                                                        'total_ucd'=>$ucd_pagar, 
                                                                                        'estado' => 4]);
                                    if ($query_solicitud){
                                        $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                                        $query_detalle = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 
                                                                                                'cantidad' => $cant, 
                                                                                                'id_solicitud' => $id_solicitud]); 
                                        if ($query_detalle) {

                                            $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => $total_guias_prev]);
                                            if ($update_limite) {
                                                return response()->json(['success' => true]);
                                            }
                                        }
                                
                                    }else{
                                        return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                                    }
                                    
                                }else{
                                    return response()->json(['success' => false, 'nota' => 'EXCEDE EL NÚMERO DE GUÍAS A SOLICITAR EN EL ACTUAL PERÍODO']);
                                }
                            }
                        }else{
                            return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                        }
                        
                    }else{
                        return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                    }
                    
                }else{
                    ////NO HA ALCANZADO EL FIN DEL PERIODO
                    $solicitado = $cant * $tipo;
                    $total_guias_prev = $limite->total_guias_solicitadas_periodo + $solicitado;
                    if ($total_guias_prev <= $limite->total_guias_periodo) {
                        $ucd_pagar = $solicitado * 5;

                        $query_solicitud = DB::table('solicituds')->insert(['id_sujeto' => $id_sp, 
                                                                            'id_cantera'=>$idCantera, 
                                                                            'total_ucd'=>$ucd_pagar, 
                                                                            'estado' => 4]);
                        if ($query_solicitud){
                            $id_solicitud = DB::table('solicituds')->max('id_solicitud');
                            $query_detalle = DB::table('detalle_solicituds')->insert(['tipo_talonario' => '50', 
                                                                                    'cantidad' => $cant, 
                                                                                    'id_solicitud' => $id_solicitud]); 
                            if ($query_detalle) {

                                $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => $total_guias_prev]);
                                if ($update_limite) {
                                    return response()->json(['success' => true]);
                                }
                            }
                    
                        }else{
                            return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
                        }
                        
                    }else{
                        return response()->json(['success' => false, 'nota' => 'EXCEDE EL NÚMERO DE GUÍAS A SOLICITAR EN EL ACTUAL PERÍODO']);
                    }

                }


            }
        }

    
    }

    public function talonarios(Request $request){
        $idSolicitud = $request->post('id');

        // $user = auth()->id();
        // $sp = DB::table('sujeto_pasivos')->where('id_user','=',$user)->first();
        // $id_sp = $sp->id_sujeto;
        // $razon = $sp->razon_social;

        $tr = '';

        $cantera = DB::table('solicituds')->join('sujeto_pasivos', 'solicituds.id_sujeto', '=', 'sujeto_pasivos.id_sujeto')
                                        ->join('canteras', 'solicituds.id_cantera', '=', 'canteras.id_cantera')
                                        ->select('solicituds.*','sujeto_pasivos.razon_social', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro','canteras.nombre')
                                        ->where('solicituds.id_solicitud','=',$idSolicitud)->first();
        if ($cantera) {
            $nombre_cantera = $cantera->nombre;  
            $id_sp = $cantera->id_sujeto;
            $razon = $cantera->razon_social;
        }

        // $ucd = DB::table('ucds')->select('valor')->where('id','=',$cantera->id_ucd)->first();

        // $formato_monto_total = number_format($cantera->monto_total, 2, ',', '.');
        // $formato_monto_transferido = number_format($cantera->monto_transferido, 2, ',', '.');

        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get();
        if($detalles){
            foreach ($detalles as $solicitud) {
                $tr .= '<tr>
                            <td class="text-secondary">'.$cantera->fecha.'</td>
                            <td>'.$solicitud->tipo_talonario.' Guías</td>
                            <td>'.$solicitud->cantidad.' und.</td>
                        </tr>';
            }
        }
        $html = '
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-detail fs-1 text-secondary"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">'.$nombre_cantera.'</h1>
                        <div style="font-size:14px" class="">
                            <span class="text-muted fw-bold">'.$razon.'</span><br>
                            <span class="text-secondary">'.$cantera->rif_condicion.'-'.$cantera->rif_nro.'</span>
                        </div>
                    </div>
                </div>
                    
                <div class="modal-body px-4" style="font-size:14px;">
                    <h6 class="text-center mb-3 text-navy fw-bold">DETALLES DE LA SOLICITUD REALIZADA</h6>
                    <table class="table text-center">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">Emisión de Solicitud</th>
                                <th scope="col">Contenido del Talonario</th>
                                <th scope="col">Cant. de Talonarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tr.'
                        </tbody>
                    </table>

                    <p class="text-muted" style="font-size:13px"><span class="fw-bold">Nota:
                    </span> El <span class="fw-bold">Tipo de talonario </span>
                    es definido por el número de guías que contenga este. 
                </p>
                </div>';

        return response($html);
       
    }


    /**
     * Display the specified resource.
     */
    public function calcular(Request $request)
    {
        $cantidad = $request->post('cant');
        $ucd = (50 * $cantidad) * 5;

        // $actual =  DB::table('ucds')->select('id', 'valor')->orderBy('id', 'desc')->first();
        // $precio_ucd = $actual->valor;
        // $id_ucd = $actual->id;

        // $total = $ucd * $precio_ucd;
        // $total = number_format($total, 2, ',', '.');

        return response()->json(['ucd' => $ucd]);
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
    public function destroy(Request $request)
    {
        $idSolicitud = $request->post('solicitud');
        $idCantera = $request->post('cantera');
        // return response($idCantera);

        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;


        ////////////ELIMINAR NUMERO DE GUIAS, EN GUIAS SOLICITADAS (LIMTE_GUIAS)/////
        $detalles = DB::table('detalle_solicituds')->where('id_solicitud','=',$idSolicitud)->get(); 
        $guias = 0;
        
        if($detalles){
            foreach ($detalles as $solicitud) {
               $guias = $guias + ($solicitud->tipo_talonario * $solicitud->cantidad);
            }
        }
        $limites = DB::table('limite_guias')->select('total_guias_solicitadas_periodo')->where('id_cantera','=',$idCantera)->get();
        foreach ($limites as $limite) {
            $new_total_guias = $limite->total_guias_solicitadas_periodo - $guias;
        }
        $update_limite = DB::table('limite_guias')->where('id_cantera', '=', $idCantera)->update(['total_guias_solicitadas_periodo' => $new_total_guias]);

        ///////////////ELIMINAR SOLICITUD//////////////////////////
        $delete = DB::table('solicituds')->where('id_solicitud', '=', $idSolicitud)->delete();
        
        if($delete && $update_limite){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
