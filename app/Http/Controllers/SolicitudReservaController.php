<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class SolicitudReservaController extends Controller
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
        $id_sp = $sp->id_sujeto;

        $solicitudes = DB::table('solicitud_reservas')->join('canteras', 'solicitud_reservas.id_cantera', '=', 'canteras.id_cantera')
                                            ->join('clasificacions', 'solicitud_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                            ->select('solicitud_reservas.*','canteras.nombre','clasificacions.nombre_clf')
                                            ->where('solicitud_reservas.id_sujeto', $id_sp)->get();

        return view('solicitud_reserva',compact('solicitudes'));
    }



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
                        <span class="fs-6 fw-bold text-navy">DATOS DE LA SOLICITUD</span>
                    </div>
                    <form id="form_generar_solicitud_p" method="post" onsubmit="event.preventDefault(); generarSolicitudProvicionales();">
                        
                        <div class="row mb-1">
                            <div class="col-5">
                                <label class="form-label" for="rif">Cantera a la que van dirigidas las Guías <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-7">
                                <select class="form-select form-select-sm" id="cantera" aria-label="Default select example" name="cantera" required>
                                    '.$opction_canteras.'
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center">
                            <div class="col-5">
                                <label for="cant_talonario">Cantidad de Guías <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-5">
                                <input class="form-control form-control-sm mb-3" type="number" name="cantidad" id="cantidad" min="1" required>
                            </div>
                            <div class="col-2">
                                <div class="text-secondary">Guías</div>
                            </div>
                        </div> 
                        
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary btn-sm" id="calcular_r">Calular</button>
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
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_solicitud_p" disabled>Realizar solicitud</button>
                        </div>
                    </form>';

            return response($html);

        }else{
            return response('Error al traer las canteras verificadas.');
        }



    }



    public function calcular(Request $request)
    {
        $cantidad = $request->post('cant');
        $ucd = $cantidad * 5;

        $actual =  DB::table('ucds')->select('id', 'valor')->orderBy('id', 'desc')->first();
        $precio_ucd = $actual->valor;
        $id_ucd = $actual->id;

        $total = $ucd * $precio_ucd;
        $total = number_format($total, 2, ',', '.');

        return response()->json(['ucd' => $ucd, 'precio_ucd' => $precio_ucd, 'total' => $total, 'id_ucd' => $id_ucd]);
    }



    public function store(Request $request)
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto','estado')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        if ($sp->estado == 'Verificado') {
            $year = date("Y");
            $mes = date("F");

            $idCantera = $request->post('cantera');
            $cant = $request->post('cantidad');
            $solicitado = $cant;

            $total_ucd = $solicitado * 5;

            $insert = DB::table('solicitud_reservas')->insert(['id_sujeto' => $id_sp, 
                                                        'id_cantera'=>$idCantera,
                                                        'cantidad_guias'=>$cant,
                                                        'total_ucd'=>$total_ucd, 
                                                        'estado' => 4]);
            if ($insert) {
                return response()->json(['success' => true]);
                
            }else{
                return response()->json(['success' => false, 'nota' => 'ERROR AL SOLICITAR EL TALONARIO']);
            }
          


        }elseif ($sp->estado == 'Rechazado') {
            return response()->json(['success' => false, 'nota' => 'DISCULPE, NO SE PUEDE REALIZAR LA SOLICITUD YA QUE LOS PERMISOS DE SU USUARIO SE ENCUENTRAN RESTRINGIDOS.']);
        }elseif ($sp->estado == 'Verificando') {
            return response()->json(['success' => false, 'nota' => 'DISCULPE, NO SE PUEDE REALIZAR LA SOLICITUD YA QUE SU USUARIO SE ENCUENTRA EN PROCESO DE VERIFICACIÓN.']);
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
    // public function store(Request $request)
    // {
    //     //
    // }

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
    public function destroy(Request $request)
    {
        $idSolicitud = $request->post('solicitud');

        ///////////////ELIMINAR SOLICITUD//////////////////////////
        $delete = DB::table('solicitud_reservas')->where('id_solicitud_reserva', '=', $idSolicitud)->delete();
        
        if($delete){
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
