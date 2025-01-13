<?php

namespace App\Http\Controllers;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class EmisionUcdController extends Controller
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
        // DENOMINACIONES PARA ESTAMPILLAS
        $deno = [];
        $q1 = DB::table('ucd_denominacions')->where('estampillas', '=', 'true')->get();
        foreach ($q1 as $key) {
            $key_deno = $key->id;

            $total_timbres = 0;
            $c1 = DB::table('inventario_estampillas')->select('cantidad_timbres','asignado')->where('key_denominacion', '=', $key_deno)->where('estado', '=', 1)->get();
            foreach ($c1 as $key2) {
                $tp = $key2->cantidad_timbres - $key2->asignado;
                $total_timbres = $total_timbres + $tp;
            }

            $array = array(
                'denominacion' => $key->denominacion,
                'total_timbres' => $total_timbres
            );

            $a = (object) $array;
            array_push($deno,$a);
        }

        // TOTAL PAPEL DE SEGURIDAD DISPONIBLE
        $total_estampillas = 0;
        $t2 = DB::table('emision_papel_estampillas')->select('cantidad_timbres','emitidos')->where('estado', '=', 1)->get();
        foreach ($t2 as $k2) {
            $total_prev = $k2->cantidad_timbres - $k2->emitidos;
            $total_estampillas = $total_estampillas + $total_prev;
        }


        // ASIGNACIONES DE UCD A ESTAMPILLAS
        $query_asignaciones = [];
        $query = DB::table('asignacion_ucd_estampillas')->join('funcionarios', 'asignacion_ucd_estampillas.key_user', '=','funcionarios.id_funcionario')
                                                        ->select('asignacion_ucd_estampillas.*','funcionarios.nombre','funcionarios.cargo')
                                                        ->get();

        $total = DB::table('asignacion_ucd_estampillas')->selectRaw("count(*) as total")->first();
        $contador = 0;

        foreach ($query as $key) {
            $contador++;
            $ultimo = false;

            if ($contador == $total->total) {
                $ultimo = true;
            }

            $array = array(
                'id_asignacion_ucd' => $key->id_asignacion_ucd,
                'fecha' => $key->fecha,
                'hora' => date("h:i A",strtotime($key->hora)),
                'nombre' => $key->nombre,
                'cargo' => $key->cargo,
                'key_user' => $key->key_user,
                'ultimo' => $ultimo
            );

            $a = (object) $array;
            array_push($query_asignaciones,$a);
        }



        return view('emision_ucd',compact('deno','total_estampillas','query_asignaciones'));
    }

    public function denominacions()
    {
       
        $option = '<option value="Seleccione">Seleccione</option>';
        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$denomi->id.'">'.$value.' UCD</option>';
           
        }
        return response($option);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_emitir()
    {
        $option = '';
        $total_estampillas = 0;

        $query = DB::table('ucd_denominacions')->where('estampillas','=','true')->get();
        foreach ($query as $denomi) {
            $value = $denomi->denominacion;
            $option .= '<option value="'.$denomi->id.'">'.$value.' UCD</option>';
           
        }

        $t2 = DB::table('emision_papel_estampillas')->select('cantidad_timbres','emitidos')->where('estado', '=', 1)->get();
        foreach ($t2 as $k2) {
            $total_prev = $k2->cantidad_timbres - $k2->emitidos;
            $total_estampillas = $total_estampillas + $total_prev;
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Asignación de UCD</h1>
                        <span>Estampillas | Denominaciones UCD </span>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_emitir_estampillas_ucd" method="post" onsubmit="event.preventDefault(); emitirEstampillasUcd()">
                        <div class="d-flex justify-content-center">
                            <div class="row bg-body-secondary p-2 rounded-3">
                                <div class="col-lg-8 d-flex flex-column">
                                    <div class="fs-6 text-navy fw-bold" >Disponible en Inventario</div>
                                    <div class="text-secondary">Para emitir denominaciones UCD</div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    <div class="fw-bold fs-6" style="color: #004cbd">'.$total_estampillas.' und.</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center fs-6 text-muted fw-bold titulo my-3">Emisión</div>

                        <p class="text-muted">NOTA: Solo se puede realizar por emisión, dos (2) denominaciones UCD para Estampillas.</p>
                        
                        <div id="row_emision_ucd">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label for="ucd" class="form-label">Denominación: <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm denominacion" name="emitir[1][denominacion]" id="denominacion_1" i="1" aria-label="Default select example" required>
                                        '.$option.'
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="cantidad" class="form-label">Cantidad: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm cantidad" id="cantidad_1" i="1" name="emitir[1][cantidad]" required>
                                </div>
                                <div class="col-md-1 pt-4">
                                    <a  href="javascript:void(0);" class="btn add_button border-0">
                                        <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        


                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                        </div>
                    </form>
                    
                </div>';

        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function emitir_denominacion(Request $request)
    {
        $emitir = $request->post('emitir');
        $user = auth()->id();

        $tr = '';

        $total_timbres_emitir = 0;
        $timbres_disponibles = 0;

        foreach ($emitir as $em) {
            $total_timbres_emitir = $total_timbres_emitir + $em['cantidad'];
        }

        $t2 = DB::table('emision_papel_estampillas')->select('cantidad_timbres','emitidos')->where('estado', '=', 1)->get();
        foreach ($t2 as $k2) {
            $total_prev = $k2->cantidad_timbres - $k2->emitidos;
            $timbres_disponibles = $timbres_disponibles + $total_prev;
        }

        if ($total_timbres_emitir <= $timbres_disponibles) {
            ////// si hay papel

            /////////INSERT ASIGNACION UCD ESTAMPILLAS
            $insert_asignacion = DB::table('asignacion_ucd_estampillas')->insert(['key_user' => $user]);  

            if ($insert_asignacion) {
                $id_asignacion = DB::table('asignacion_ucd_estampillas')->max('id_asignacion_ucd');

                foreach ($emitir as $em) {
                    $key_deno = $em['denominacion'];
                    $cantidad = $em['cantidad'];
    
                    $q1 = DB::table('emision_papel_estampillas')->select('id_lote_papel','desde','hasta','emitidos','cantidad_timbres')->where('cantidad_timbres', '!=', 'emitidos')->where('estado', '=', 1)->get();
    
                    $timbres_emitidos = 0;
                    $timbres_restantes = $cantidad;
                    
                    foreach ($q1 as $key) {
                        
                        if ($timbres_emitidos == $cantidad) {
                            # cancelar foreach
                            break;
                        }else{
                            $q2 = DB::table('inventario_estampillas')->select('hasta')->where('key_lote_papel', '=', $key->id_lote_papel)->orderBy('id_inventario_estampilla', 'desc')->first();
                            if ($q2) {
                                ///// hay emisiones de este lote en el inventario
                                $desde = $q2->hasta + 1;
                            }else{
                                ///// primera emision del lote
                                $desde = $key->desde;
                            }
    
                            $hasta_prev = ($desde + $timbres_restantes) - 1;
                            if ($hasta_prev > $key->hasta) {
                                $hasta = $key->hasta;
                                $timbres_emitidos = $timbres_emitidos + (($hasta - $desde) + 1);
                            }else{
                                $hasta = $hasta_prev;
                                $timbres_emitidos = $cantidad;
                            }

                            $timbres_restantes = $timbres_restantes - $timbres_emitidos;

                            $cant_registro = ($hasta - $desde) + 1;
    
                            $insert_inventario = DB::table('inventario_estampillas')->insert(['key_asignacion_ucd' => $id_asignacion,
                                                                                            'key_lote_papel' => $key->id_lote_papel,
                                                                                            'key_denominacion' => $key_deno,
                                                                                            'cantidad_timbres' => $cant_registro,
                                                                                            'desde' => $desde,
                                                                                            'hasta' => $hasta,
                                                                                            'estado' => 1,
                                                                                            'asignado' => 0
                                                                                            ]);
                            if ($insert_inventario) {
                                # code...
                                /////UPDATE DEL TOTAL TIBRES EMITIDOS EN EMISION_PAPEL_ESTAMPILLAS (TABLE)
                                $new_emitidos = $key->emitidos + $cant_registro;

                                if ($key->cantidad_timbres == $new_emitidos) {
                                    $update_emitidos = DB::table('emision_papel_estampillas')->where('id_lote_papel','=',$key->id_lote_papel)->update(['emitidos' => $new_emitidos, 'estado' => 4]);
                                }else{
                                    $update_emitidos = DB::table('emision_papel_estampillas')->where('id_lote_papel','=',$key->id_lote_papel)->update(['emitidos' => $new_emitidos]);
                                }
                            
                            }else{
                                /////eliminar registro de asignacion ucd estampillas
                                $delete = DB::table('asignacion_ucd_estampillas')->where('id_asignacion_ucd', '=', $id_asignacion)->delete();
                                return response()->json(['success' => false]);
                            }


                            ///// GENERAR QRS
                            for ($i=$desde; $i <= $hasta; $i++) { 
                                $url = 'https://estampillas.tributosaragua.com.ve/?id='.$i.'?lp='.$key->id_lote_papel; 
                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qrEstampillas/qrcode_EST'.$i.'.png'));
                            }
                        }
                    }

                    $c3 = DB::table('ucd_denominacions')->select('denominacion')->where('id', '=', $key_deno)->first();

                    $tr .= '<tr>
                                <td><span class="fw-bold text-navy fs-6">'.$c3->denominacion.' UCD</span></td>
                                <td>'.$desde.'</td>
                                <td>'.$hasta.'</td>
                                <td>'.$cantidad.'</td>
                            </tr>';
                }

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bxs-collection fs-2 text-muted me-2"></i>
                                <h1 class="modal-title fs-5 fw-bold text-navy">Correlativo | Estampillas</h1>
                                <span>Denominaciones UCD </span>
                            </div>
                        </div>
                        <div class="modal-body px-5 py-3" style="font-size:13px">
                            <p class="text-muted ">NOTA: Tener en cuenta que la secuencia "Desde" y "Hasta" corresponden 
                                al correlativo de papel impreso en el Papel de Seguridad para las Estampillas.</p>
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>Denominación</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                        <th>Cant.</th>    
                                    </tr>    
                                </thead> 
                                <tbody>
                                    '.$tr.'
                                </tbody>   
                            </table>    
                                
                            <p class="text-muted">IMPORTANTE: .</p>

                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <a href="'.route("emision_ucd").'" class="btn btn-secondary btn-sm me-2">Cancelar</a>
                                <a href="'.route("emision_ucd.pdf_emision", ["asignacion" => $id_asignacion]).'" class="btn btn-dark btn-sm"  style="font-size:12.7px">PDF</a>
                            </div>
                        </div>';

                return response()->json(['success' => true, 'html' => $html]);
            
            }else{
                return response()->json(['success' => false]);
            }

        }else{
            return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficiente papel de seguridad de estampillas para realizar la Emisión.']);
        }

    }





    public function pdf_emision(Request $request)
    {
        $asignacion = $request->asignacion;

        $query =  DB::table('inventario_estampillas')->join('ucd_denominacions', 'inventario_estampillas.key_denominacion', '=','ucd_denominacions.id')
                                                    ->select('inventario_estampillas.*','ucd_denominacions.denominacion','ucd_denominacions.identificador')
                                                    ->where('inventario_estampillas.key_asignacion_ucd', '=', $asignacion)->get();


        $pdf = PDF::setPaper([0,0,283.5,141.7])->loadView('pdfAsignacionUcdEstampillas', compact('query'));

        return $pdf->download('ESTAMPILLAS_UCD_A'.$asignacion.'.pdf');

    }

    /**
     * Display the specified resource.
     */
    public function detalle(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
        $tr = '';

        $query = DB::table('asignacion_ucd_estampillas')->join('funcionarios', 'asignacion_ucd_estampillas.key_user', '=','funcionarios.id_funcionario')
                                                        ->select('asignacion_ucd_estampillas.*','funcionarios.nombre','funcionarios.cargo')
                                                        ->where('asignacion_ucd_estampillas.id_asignacion_ucd','=',$id_asignacion)
                                                        ->first();
        
        $query_2 = DB::table('inventario_estampillas')->join('ucd_denominacions', 'inventario_estampillas.key_denominacion', '=','ucd_denominacions.id')
                                                    ->select('inventario_estampillas.*','ucd_denominacions.denominacion')
                                                    ->where('inventario_estampillas.key_asignacion_ucd', '=', $id_asignacion)->get();
        foreach ($query_2 as $key) {
            $tr .= '<tr>
                        <td>
                            <span class="text-navy fs-6 fw-bold">'.$key->denominacion.' UCD</span>
                        </td>
                        <td class="text-muted fw-bold">#'.$key->key_lote_papel.'</td>
                        <td>'.$key->desde.'</td>
                        <td>'.$key->hasta.'</td>
                        <td class="text-muted">'.$key->cantidad_timbres.' und.</td>
                    </tr>';
        }
        
        $hora = date("h:i A",strtotime($query->hora));

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-detail fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Detalle | <span class="text-muted"> Asignación UCD</span></h1>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <div class="d-flex justify-content-center">
                        <table class="table w-75 ">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td class="text-secondary" colspan="2">'.$query->id_asignacion_ucd.'</td>
                                </tr>
                                <tr>
                                    <th>Fecha - Hora</th>
                                    <td colspan="2">'.$query->fecha.' - '.$hora.'</td>
                                </tr>
                                <tr>
                                    <th>Emitido Por:</th>
                                    <td colspan="2">
                                        <div class="d-flex flex-column text-muted">
                                            <span class="">
                                                USER
                                                <span class="badge bg-primary-subtle text-primary-emphasis ms-2">'.$query->cargo.'</span>
                                            </span>
                                            <span class="text-navy fw-bold">'.$query->nombre.'</span>  
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                        

                    <div class="text-navy fw-bold fs-5 mb-3 text-center">Correlativo</div>

                    <table class="table text-center">
                        <tr>
                            <th>UCD</th>
                            <th>ID Lote Papel</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Cantidad Est.</th>
                        </tr>
                        '.$tr.'
                    </table>

                    <div class="d-flex justify-content-center my-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                    </div>
                </div>';

        return response($html);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
        $borrar = [];

        $q1 = DB::table('inventario_estampillas')->select('key_lote_papel','cantidad_timbres')->where('key_asignacion_ucd', '=', $id_asignacion)->get();
        foreach ($q1 as $key) {

            $array = array(
                'key_lote_papel' => $key->key_lote_papel,
                'cantidad' => $key->cantidad_timbres,
            );

            $a = (object) $array;
            array_push($borrar,$a);
        }

        $delete = DB::table('asignacion_ucd_estampillas')->where('id_asignacion_ucd', '=', $id_asignacion)->delete();

        if ($delete) {
            foreach ($borrar as $key) {
                $c2 = DB::table('emision_papel_estampillas')->select('emitidos')->where('id_lote_papel', '=', $key->key_lote_papel)->first();
                $new_emitidos = $c2->emitidos - $key->cantidad;
                $update = DB::table('emision_papel_estampillas')->where('id_lote_papel', '=', $key->key_lote_papel)->update(['emitidos' => $new_emitidos]);
            }

            ///////////INCLUIR BITACORA
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

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
