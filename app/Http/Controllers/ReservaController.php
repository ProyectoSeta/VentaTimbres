<?php

namespace App\Http\Controllers;
use App\Models\User;


use DB;
use Illuminate\Http\Request;

class ReservaController extends Controller
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
        
        $talonarios = DB::table('talonarios')
            ->join('reservas', 'talonarios.id_reserva', '=', 'reservas.id_reserva')
            ->select('talonarios.id_talonario','talonarios.tipo_talonario', 'reservas.fecha', 'talonarios.desde', 'talonarios.hasta', 'talonarios.asignado')
            ->where('talonarios.clase','=',6)
            ->get();
        


        return view('reserva', compact('talonarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function emitir(Request $request)
    {
        $cantidad = $request->post('cantidad');
        $tipo_talonario = $request->post('tipo_talonario');
        $user = auth()->id();

        $insert_reserva = DB::table('reservas')->insert(['id_user' => $user]);
        if ($insert_reserva) {
            $id_reserva= DB::table('reservas')->max('id_reserva');
            $insert_detalle_reserva = DB::table('detalle_reservas')->insert(['tipo_talonario' => $tipo_talonario, 'cantidad' => $cantidad, 'id_reserva' => $id_reserva,]);
            
            if ($insert_detalle_reserva) {
                $nro_talonarios = 0;
                $cod_talonarios = '';

                $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->get();   
                if ($query_count) { 
                    foreach ($query_count as $c) {
                        $count = $c->total; 
                    }
                    if($count == 0){ //////////No hay ningun registro en la tabla Talonarios
                        $detalles = DB::table('detalle_reservas')->where('id_reserva','=',$id_reserva)->get(); 
                        $c = 0; 
                        foreach ($detalles as $detalle) { ////////talonarios que el contribuyente solicito
                            $tipo = $detalle->tipo_talonario;
                            $cant = $detalle->cantidad;
                            $nro_talonarios = $nro_talonarios + $cant;
                            // return response($cant); 
                            for ($i=0; $i < $cant; $i++) {                        
                                $c = $c + 1; 
                                
                                if ($c == 1) {
                                $desde = 1;
                                $hasta = $tipo; 

                                }else{
                                    $id_max= DB::table('talonarios')->max('id_talonario');
                                    $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                                    foreach ($query_hasta as $hasta) {
                                        $prev_hasta = $hasta->hasta;
                                    }
                                    $desde = $prev_hasta +1;
                                    $hasta = ($desde + $tipo)-1;
                                }
                            
                                $insert = DB::table('talonarios')->insert(['id_solicitud' => null,
                                                                            'id_reserva' => $id_reserva, 
                                                                            'tipo_talonario' => $tipo, 
                                                                            'desde' => $desde, 
                                                                            'hasta' => $hasta,
                                                                            'clase' => 6,
                                                                            'asignado' => 0,
                                                                            'estado' => 20]);
                                if ($insert) {
                                    $id_talonario= DB::table('talonarios')->max('id_talonario');
                                    if($i == ($cant - 1)){
                                        $cod_talonarios .= $id_talonario;
                                    }else{
                                        $cod_talonarios .= $id_talonario.'-';
                                    }
                                }
                                
                            } ////cierra for    
                        }/////cierra foreach

                        $accion = 'EMISIÓN DE '.$cantidad.' TALONARIOS DE RESERVA (COD: '.$cod_talonarios.')';
                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

                        $consulta = DB::table('total_guias_reservas')->select('total')->where('correlativo','=',1)->first();
                        $total_guias_reserva = $consulta->total + ($cantidad * $tipo_talonario);
                        $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                        if ($update_total_reserva) {
                            return response()->json(['success' => true, 'id_reserva' => $id_reserva]);
                        }else{
                            return response()->json(['success' => false]);
                        }
                        
                        
                    }else{   //////////Hay registros en la tabla Talonarios
                        $detalles = DB::table('detalle_reservas')->where('id_reserva','=',$id_reserva)->get();
                        foreach ($detalles as $detalle){
                            $tipo = $detalle->tipo_talonario;
                            $cant = $detalle->cantidad;
                            $nro_talonarios = $nro_talonarios + $cant;

                            for ($i=1; $i <= $cant; $i++) {  
                                $id_max= DB::table('talonarios')->max('id_talonario');
                                $query_hasta = DB::table('talonarios')->select('hasta')->where('id_talonario', '=' ,$id_max)->get();
                                foreach ($query_hasta as $hasta) {
                                    $prev_hasta = $hasta->hasta;
                                }
                                $desde = $prev_hasta +1;
                                $hasta = ($desde + $tipo)-1;

                                $contador_guia = $desde;            
                                $insert = DB::table('talonarios')->insert(['id_solicitud' => null,
                                                                            'id_reserva' => $id_reserva, 
                                                                            'tipo_talonario' => $tipo, 
                                                                            'desde' => $desde, 
                                                                            'hasta' => $hasta,
                                                                            'clase' => 6,
                                                                            'asignado' => 0,
                                                                            'estado' => 20]);
                                if ($insert) {
                                    $id_talonario= DB::table('talonarios')->max('id_talonario');
                                    if($i == ($cant - 1)){
                                        $cod_talonarios .= $id_talonario;
                                    }else{
                                        $cod_talonarios .= $id_talonario.'-';
                                    }
                                }
                            } ////cierra for                
                        } ////cierra foreach

                        $accion = 'EMISIÓN DE '.$cantidad.' TALONARIOS DE RESERVA (COD: '.$cod_talonarios.')';
                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

                        $consulta = DB::table('total_guias_reservas')->select('total')->where('correlativo','=',1)->first();
                        $total_guias_reserva = $consulta->total + ($cantidad * $tipo_talonario);
                        $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                        if ($update_total_reserva) {
                            return response()->json(['success' => true, 'id_reserva' => $id_reserva]);
                        }else{
                            return response()->json(['success' => false]);
                        }

                    }
                
                }else{
                    return response()->json(['success' => false]);
                }

            }else{
                return response()->json(['success' => false]);
            }
        }else{
            return response()->json(['success' => false]);
        }

       


    }

    public function info_correlativo(Request $request)
    {
        $id_reserva = $request->post('reserva');
        $tables = '';
        $talonarios = DB::table('talonarios')->select('id_talonario','tipo_talonario','desde','hasta')->where('id_reserva','=',$id_reserva)->get();

        if ($talonarios) {
            $i=0;
            foreach ($talonarios as $talonario) {
                $i = $i + 1;
                $desde = $talonario->desde;
                $hasta = $talonario->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);


            

                $tables .= ' <span class="ms-3 text-muted">Talonario Nro. '.$i.'</span>
                        <div class="row d-flex align-items-center px-5">
                            <div class="col-sm-12">
                                <table class="table mt-2 mb-3">
                                    <tr>
                                        <th>Contenido:</th>
                                        <td>'.$talonario->tipo_talonario.' Guías</td>
                                    </tr>
                                    <tr>
                                        <th>Desde:</th>
                                        <td>'.$formato_desde.'</td>
                                    </tr>
                                    <tr>
                                        <th>Hasta:</th>
                                        <td>'.$formato_hasta.'</td>
                                    </tr>
                                </table>
                            </div>
                        </div>';
        
                    
            }

            $html = ' <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title text-navy fw-bold fs-5" id="exampleModalLabel">CORRELATIVO</h1>
                                <span class="fs-6 text-muted">Talonarios Emitidos</span>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px">
                            <p class="text-center" style="font-size:14px">El correlativo correspondiente a la reserva es el siguiente:</p>
                                '.$tables.'
                            <div class="d-flex justify-content-center">
                                <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo_reserva" data-bs-dismiss="modal">Salir</button>
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
