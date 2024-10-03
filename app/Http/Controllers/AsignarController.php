<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $sedes =  DB::table('sedes')->get();
        return view('asignar', compact('sedes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function taquillas(Request $request)
    {
        $sede = $request->post('value'); 
        $options = '';
        $taquillas =  DB::table('taquillas')
                        ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                        ->select('taquillas.*','funcionarios.nombre')
                        ->where('taquillas.key_sede','=', $sede)->get();
        if ($taquillas) {
            $options .= '<option>Seleccionar</option>';
            foreach ($taquillas as $taquilla) {
                $options .= '<option value="'.$taquilla->id_taquilla.'">'.$taquilla->id_taquilla.' - '.$taquilla->nombre.'</option>';
            }

            return response($options);
        }
    }



    public function funcionario(Request $request)
    {
        $taquilla = $request->post('value'); 
        $query =  DB::table('taquillas')
                        ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                        ->select('funcionarios.nombre')
                        ->where('taquillas.id_taquilla','=', $taquilla)->first();
        if ($query) {
            $funcionario = ''.$query->nombre.'';
            return response($funcionario);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function asignar_forma_14(Request $request)
    {
        $cantidad = $request->post('cantidad'); ///return response($cantidad.'/'.$sede.'/'.$taquilla);
        $sede = $request->post('sede');
        $taquilla = $request->post('taquilla');
        $user = auth()->id();
        $tr = '';
        $html = '';

        if (!empty($cantidad) || !empty($taquilla)) {
            if ($cantidad != 0) {
                $comprobacion = DB::table('inventario_rollos')->selectRaw("count(*) as total")->where('estado','=',1)->first();
                if ($comprobacion->total < $cantidad) {
                    ///////////NO HAY SUFICIENTES ROLLOS PARA REALIZAR LA ASIGNACIÓN
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficientes rollos en el inventario para realizar la asignación.']);
                }else{
                    $insert = DB::table('asignacion_forma_14_timbres')->insert(['key_user' => $user,'cantidad' => $cantidad,'key_taquilla' => $taquilla]);
                    if ($insert) {
                        $id_asignacion = DB::table('asignacion_forma_14_timbres')->max('id_asignacion');
                        for ($i=0; $i < $cantidad; $i++) { 
                            $query =  DB::table('inventario_rollos')->select('id_rollo','desde','hasta')->where('estado','=',1)->first(); 
                            if ($query) {
                                ///update key_asignación
                                $update = DB::table('inventario_rollos')->where('id_rollo', '=', $query->id_rollo)
                                                                        ->update(['estado' => 2,
                                                                                    'key_asignacion' => $id_asignacion,
                                                                                    'key_taquilla' => $taquilla,
                                                                                    'condicion' => 4
                                                                                ]);
                                if ($update) {
                                    $tr .= '<tr>
                                                <td>'.$query->id_rollo.'</td>
                                                <td>'.$query->desde.'</td>
                                                <td>'.$query->hasta.'</td>
                                            </tr>'; 
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }

                        $consulta =  DB::table('sedes')->select('sede')->where('id_sede','=',$sede)->first();
                        $consulta_2 = DB::table('taquillas')
                                    ->join('funcionarios', 'taquillas.key_funcionario', '=', 'funcionarios.id_funcionario')
                                    ->select('funcionarios.nombre')
                                    ->where('taquillas.id_taquilla','=', $taquilla)->first();

                        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                    <div class="text-center">
                                        <i class="bx bxs-layer-plus fs-2 text-muted me-2"></i>
                                        <h1 class="modal-title fs-5 fw-bold text-navy">Rollos Asignados</h1>
                                        <span class="text-muted fw-bold">Forma 14 </span>
                                    </div>
                                </div>
                                <div class="modal-body px-5 py-3" style="font-size:13px">
                                    <div class="d-flex flex-column text-muted mb-3">
                                        <div class="d-flex justify-content-between">
                                            <p class="mb-1">Sede: <span class="text-navy fw-bold">'.$consulta->sede.'</span></p>
                                            <p class="mb-1">ID Taquila: <span class="text-navy fw-bold">'.$taquilla.'</span></p>
                                        </div>
                                        <p class="mb-1">Funcionario designado: <span class="text-navy fw-bold">'.$consulta_2->nombre.'</span></p>
                                    </div>
                                    <p class="text-secondary">*NOTA: Cada rollo emitido trae un total de 160 Trimbres Fiscales.</p>
                                    <div class="">
                                        <table class="table text-center">
                                            <tr>
                                                <th>ID Rollo</th>
                                                <th>Desde</th>
                                                <th>Hasta</th>
                                            </tr>
                                            '.$tr.'
                                        </table>
                                    </div>


                                    <div class="d-flex justify-content-center mb-3">
                                        <a href="'.route("asignar").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                        <a href="'.route("asignar.pdf_forma14", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">Imprimir</a>
                                    </div>
                                </div>';
                        return response()->json(['success' => true, 'html' => $html]);
                        
                    }else{
                        return response()->json(['success' => false]);
                    }
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, especifique la cantidad de rollos a Asignar.']); 
            }
        }else{
            return response()->json(['success' => false, 'nota' => 'Disculpe, debe llenar los campos solicitados.']);
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
    public function pdf_forma14(Request $request)
    {
        $asignacion = $request->asignacion;
        $dia = date('d');
        $mes = date('m');
        $year = date('Y');
        $tr = '';
        $length = 6;
        $correlativo = [];
        $query =  DB::table('inventario_rollos')->where('key_asignacion', '=', $asignacion)->get();

        foreach ($query as $detalle) {
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;

            
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

            $array = array(
                        'id' => $detalle->id_rollo,
                        'desde' => $formato_desde,
                        'hasta' => $formato_hasta
                    );
            $a = (object) $array;
            array_push($correlativo,$a);

        }

        $pdf = PDF::loadView('pdfAsignacionTFE14', compact('correlativo'));

        return $pdf->download('Asignación_TFE14_'.$year.''.$mes.''.$dia.'.pdf');
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
