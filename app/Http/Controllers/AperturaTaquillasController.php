<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AperturaTaquillasController extends Controller
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
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");   

        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');
        $hoy = date('Y-m-d');
        $aperturas = [];
        $query = DB::table('apertura_taquillas')->whereDate('fecha', $hoy)->get();

        foreach ($query as $q1) {
            $q2 = DB::table('taquillas')->where('id_taquilla','=', $q1->key_taquilla)->first();

            $q3 = DB::table('sedes')->select('sede')->where('id_sede','=', $q2->key_sede)->first();
            $q4 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $q2->key_funcionario)->first();

            $hora_apertura = date("h:i A",strtotime($q1->apertura_admin));
            $apertura_taquillero = '';
            if ($q1->apertura_taquillero != null) {
                $apertura_taquillero = date("h:i A",strtotime($q1->apertura_taquillero));
            }else{
                $apertura_taquillero = $q1->apertura_taquillero;
            }
            

            $array = array(
                        'correlativo' => $q1->correlativo,
                        'id_taquilla' => $q1->key_taquilla,
                        'ubicacion' => $q3->sede,
                        'taquillero' => $q4->nombre,
                        'hora_apertura' => $hora_apertura,
                        'apertura_taquillero' => $apertura_taquillero,
                        'cierre_taquilla' => null
                    );
            $a = (object) $array;
            array_push($aperturas,$a);
        }


        return view('apertura',compact('aperturas','hoy_view'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_apertura()
    {
        $tr = '';
        $hoy = date('Y-m-d');

        $query = DB::table('taquillas')->join('sedes', 'taquillas.key_sede', '=','sedes.id_sede')
                                        ->join('funcionarios', 'taquillas.key_funcionario', '=','funcionarios.id_funcionario')
                                        ->select('sedes.sede','funcionarios.nombre','taquillas.id_taquilla')
                                        ->where('taquillas.estado','!=',17)
                                        ->get();
        foreach ($query as $taquilla) {
            $input = '';
            $consulta = DB::table('apertura_taquillas')->select('apertura_admin')
                                                        ->where('key_taquilla','=', $taquilla->id_taquilla)
                                                        ->where('fecha','=', $hoy)->first();
            if ($consulta) {
                ////// hay registro, se aperturo taquilla
                $input = '<div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input form-select-lg check_apertura" type="checkbox" role="switch" id="apertura" checked disabled>
                                <label class="form-check-label" for="apertura">Si</label>
                            </div>';
            }else{
                ///// no hay registro, no se ha aperturado taquilla
                $input = '<div class="form-check form-switch d-flex align-items-center">
                                <input class="form-check-input form-select-lg check_apertura" taquilla="'.$taquilla->id_taquilla.'" type="checkbox" role="switch" id="apertura_'.$taquilla->id_taquilla.'" name="apertura[]" value="'.$taquilla->id_taquilla.'">
                                <label class="form-check-label" id="label_'.$taquilla->id_taquilla.'" for="apertura_'.$taquilla->id_taquilla.'">No</label>
                            </div>';
            }

            $tr .= '<tr>
                        <td>'.$taquilla->id_taquilla.'</td>
                        <td>'.$taquilla->sede.'</td>
                        <td>'.$taquilla->nombre.'</td>
                        <td>
                            '.$input.'
                        </td>
                    </tr>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-lock-open-alt fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Aperturar Taquillas</h1>
                        <h5 class="text-muted fs-6">'.$hoy.'</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_aperturar_taquillas" method="post" onsubmit="event.preventDefault(); aperturaTaquillas()">
                        <table class="table" id="table_apertura">
                            <thead>
                                <tr>
                                    <th>Id Taquilla</th>
                                    <th>Ubicación</th>
                                    <th>Taquillero</th>
                                    <th>Apertura</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$tr.'
                            </tbody>
                        </table>


                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aperturar</button>
                        </div>
                    </form>
                </div>';
        
        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function apertura_taquillas(Request $request)
    {
        $apertura = $request->post('apertura');

        foreach ($apertura as $id_taquilla) {
            $q2 = DB::table('taquillas')->select('key_funcionario','estado')->where('id_taquilla','=',$id_taquilla)->first();
            if ($q2){
                ///// verificar si estan deshabilitados
                $con_taq = DB::table('funcionarios')->select('estado')->where('id_funcionario','=',$q2->key_funcionario)->first();
                if ($q2->estado == 17) {
                    return response()->json(['success' => false, 'nota'=> 'La Taquilla ID'.$id_taquilla.' se encuentra Deshabilitada..']);
                }
                if ($con_taq->estado == 17) {
                    return response()->json(['success' => false, 'nota'=> 'El Funcionario asignado a la Taquilla ID'.$id_taquilla.' se encuentra Deshabilitado.']);
                }

                //// insert
                $insert = DB::table('apertura_taquillas')->insert(['key_taquilla' => $id_taquilla,'fondo_caja' => 0]);
            }else{
                 return response()->json(['success' => false]); 
            }
            
        }
        
        return response()->json(['success' => true]); 
    }

    /**
     * Display the specified resource.
     */
    public function search_fecha(Request $request)
    {
        $fecha = $request->post('fecha');
        $tr = '';
        $query = DB::table('apertura_taquillas')->where('fecha','=', $fecha)->get();

        foreach ($query as $q1) {
            $q2 = DB::table('taquillas')->where('id_taquilla','=', $q1->key_taquilla)->first();

            $q3 = DB::table('sedes')->select('sede')->where('id_sede','=', $q2->key_sede)->first();
            $q4 = DB::table('funcionarios')->select('nombre')->where('id_funcionario','=', $q2->key_funcionario)->first();

            $hora_apertura = date("h:i A",strtotime($q1->apertura_admin));
            $apertura_taquillero = '';
            if ($q1->apertura_taquillero != null) {
                $apertura_taquillero = date("h:i A",strtotime($q1->apertura_taquillero));
            }else{
                $apertura_taquillero = '<span class="badge bg-danger-subtle border border-danger-subtle text-danger-emphasis rounded-pill" style="font-size:12.7px">Taquillero no aperturo</span>';
            }


            $tr .= '<tr>
                        <td>
                            <span class="text-secondary fst-italic">'.$fecha.'</span>
                        </td>   
                        <td>'.$q1->key_taquilla.'</td>
                        <td>'.$q3->sede.'</td>
                        <td>'.$q4->nombre.'</td>
                        <td><span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">'.$hora_apertura.'</span></td>
                        <td>'.$apertura_taquillero.'</td>
                        <td></td>
                    </tr>';
        }

        $html = ' <div class="table-responsive" style="font-size:12.7px">
                <table id="table_apertura_fecha" class="table text-center border-light-subtle" style="font-size:12.7px">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>ID Taquilla</th>
                            <th>Ubicación</th>
                            <th>Taquillero</th>
                            <th>Hora Apertura</th>
                            <th>Apertura Taquillero</th>
                            <th>Cierre Taquilla</th>
                        </tr> 
                    </thead>
                    <tbody>
                        '.$tr.'
                    </tbody>
                </table>
            </div>';

        return response($html);
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
