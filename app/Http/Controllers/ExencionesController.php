<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ExencionesController extends Controller
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
        $proceso = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                            ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                            ->where('exenciones.estado','=',18)->get();



        return view('exenciones',compact('proceso'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_new()
    {
        $option_tramites = '';
        $option_entes = '';
        $entes = [];

        $tramites = DB::table('tramites')->where('alicuota','=',13)->get();
        foreach ($tramites as $key) {
            $option_tramites .= '<option value="'.$key->id_tramite.'">'.$key->tramite.'</option>';

            if (array_search($key->key_ente,$entes) == false) {
                
                array_push($entes,$key->key_ente);
            }
        }

        foreach ($entes as $ente) {
            $c2 = DB::table('entes')->where('id_ente','=',$ente)->first();
            $option_entes .= '<option value="'.$c2->id_ente.'">'.$c2->ente.'</option>';
        }


        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Nueva Exención</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_new_exencion" method="post" onsubmit="event.preventDefault(); newExencion()">
                        <!-- *************   DATOS CONTRIBUYENTE   ************* -->
                        <div class="border p-3 rounded-3">
                            <div class="text-navy text-center fw-bold fs-6 mb-3">Datos del Contribuyente</div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                    <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto">
                                        <option>Seleccione</option>
                                        <option value="9">Natural</option>
                                        <option value="10">Firma Personal</option>
                                        <option value="11">Ente</option>
                                    </select>
                                </div>
                                <!-- ci o rif -->
                                <div class="col-md-5">
                                    <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                    <div class="row">
                                        <div class="col-5">
                                            <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion">
                                                <option>Seleccione</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-1">-</div> -->
                                        <div class="col-7">
                                            <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" required >
                                            <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- nombre o razon -->
                                <div class="col-md-4">
                                    <label class="form-label" for="nombre">Nombre / Razon Social</label><span class="text-danger">*</span>
                                    <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-3 mb-3 d-none" id="btns_add_contribuyente">
                                <button type="button" class="btn btn-secondary btn-sm me-3" id="btn_cancel_add_c">Cancelar</button>
                                <button type="button" class="btn btn-success btn-sm" id="btn_add_contribuyente">Registrar</button>
                            </div>
                            
                            <!-- direccion y telefonos -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="direccion">Dirección</label><span class="text-danger">*</span>
                                    <input type="text" id="direccion" class="form-control form-control-sm" name="direccion" required  disabled>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tlf_movil">Teléfono móvil</label><span class="text-danger">*</span>
                                    <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" required  disabled>
                                    <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 04120038547</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tlf_second">Teléfono secundario</label>
                                    <input type="number" id="tlf_second" class="form-control form-control-sm" name="tlf_second" disabled>
                                    <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 04120038547</p>
                                </div>
                            </div>
                        </div>

                        <!-- *************   TRAMITE   ************* -->
                        <div class="border p-3 rounded-3 mt-3">
                            <div class="text-navy text-center fw-bold fs-6 mb-2">Tramite(s)</div>
                            <div class="d-flex flex-column tramites">
                                <div class="d-flex justify-content-center">
                                    <div class="row  w-100">
                                        <div class="col-sm-3">
                                            <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm ente" nro="1" id="ente_1" disabled>
                                                '.$option_entes.'
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm tramite" name="tramite[1][tramite]" nro="1" id="tramite_1" disabled>
                                                <option value="">Seleccione el tramite </option>
                                                '.$option_tramites.'  
                                            </select>
                                        </div>
                                        <div class="col-sm-2" id="div_ucd_1">
                                            <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" nro="1" disabled required>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label" for="forma">Timbre</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm forma" nro="1" name="tramite[1][forma]"id="forma_1" required disabled>
                                                <option value="">Seleccione</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 pt-4">
                                            <a  href="javascript:void(0);" class="btn add_button_tramite disabled border-0">
                                                <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- tamaño de empresa -->
                            <div class="mx-3 mt-4  border p-3 rounded-3" style="background:#f4f7f9;" id="content_tamaño">
                                <p class="text-muted my-0 pb-0">*Ingrese el tamaño de la Empresa.</p>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6 d-flex justify-content-center align-items-end">
                                        <div class="">
                                            <label class="form-label" for="metros">Tamaño de la empresa (Mts2):</label><span class="text-danger">*</span>
                                            <div class="d-flex align-items-center">
                                                <input type="number" id="metros" class="form-control form-control-sm me-2" name="metros" disabled>
                                                <span class="fw-bold">Mts2</span>
                                            </div>
                                        </div>
                                        <!-- btn calcular -->
                                        <div class="ms-3">
                                            <button type="button" class="btn btn-secondary btn-sm disabled" id="btn_calcular_metrado">Calcular</button>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-center pt-4" id="size">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- *************   DATOS DE LA EXENCION   ************* -->
                        <div class="border p-3 rounded-3 mt-3">
                            <div class="text-navy text-center fw-bold fs-6 mb-3">Datos de la Exención</div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="solicitud_doc" class="form-label">Solicitud (Documento)</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" id="solicitud_doc" type="file" name="solicitud_doc" required disabled>
                                        </div>
                                        <div class="col-6">
                                            <label for="aprobacion_doc" class="form-label">Aprobación (Documento)</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" id="aprobacion_doc" type="file" name="aprobacion_doc" required disabled>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <label class="form-label" for="porcentaje">Porcentaje (1-90%)</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control form-control-sm " id="porcentaje" name="porcentaje" required disabled>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="tipo_pago">Tipo de Pago</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm" name="tipo_pago" id="tipo_pago" required disabled>
                                                <option value="18">Deposito</option>
                                                <option value="14">Obra</option>
                                                <option value="15">Bien</option>
                                                <option value="16">Servicio</option>
                                                <option value="17">Suministros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- total -->
                                <div class="col-md-5 px-3 fw-bold titulo">
                                    <!-- <div class="text-center fs-6 mb-2 text-muted"></div> -->
                                    <table class="table table-sm table-borderless fs-">
                                        <tr>
                                            <th>Sub Total</th>
                                            <td class="text-end text-navy fs-6" id="sub_total"></td>
                                        </tr>
                                        <tr>
                                            <th>Exención (<span id="html_porcentaje" class="text-muted">%</span>)</th>
                                            <td class="text-end text-navy fs-6" id="exencion"></td>
                                        </tr>
                                        <tr>
                                            <th class="fs-5">Total a Pagar</th>
                                            <td class="text-end text-navy fs-5 fw-bold" id="total"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm disabled" id="btn_submit_exencion">Emitir</button>
                        </div>
                    </form>
                    
                </div>';
        
        return response($html);

    }


    public function tramites()
    {
        $option_tramites = '';
        $option_entes = '';
        $entes = [];

        $tramites = DB::table('tramites')->where('alicuota','=',13)->get();
        foreach ($tramites as $key) {
            $option_tramites .= '<option value="'.$key->id_tramite.'">'.$key->tramite.'</option>';

            if (array_search($key->key_ente,$entes) == false) {
                
                array_push($entes,$key->key_ente);
            }
        }

        foreach ($entes as $ente) {
            $c2 = DB::table('entes')->where('id_ente','=',$ente)->first();
            $option_entes .= '<option value="'.$c2->id_ente.'">'.$c2->ente.'</option>';
        }
        
        return response()->json(['tramites' => $option_tramites, 'entes' => $option_entes]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function total(Request $request)
    {
        $tramites = $request->post('tramites');
        $metros = $request->post('metros');
        $porcentaje = $request->post('porcentaje');

        $total_ucd = 0; 
        $exencion = 0;
        $total = 0;

        foreach ($tramites as $tramite) {
            if ($tramite != '') { 
                $query = DB::table('tramites')->where('id_tramite','=', $tramite)->first();
                switch ($query->alicuota) {
                    case 13:
                        // METRADO
                        if (!empty($metros)) {
                            // hay metros
                            if ($metros == '' || $metros == 0) {
                                $ucd_tramite = 0;
                            }else{
                                if ($metros <= 150) {
                                    ////pequeña
                                    $ucd_tramite = $query->small;
                                }elseif ($metros > 150 && $metros < 400) {
                                    /////mediana
                                    $ucd_tramite = $query->medium;
                                }elseif ($metros >= 400) {
                                    /////grande
                                    $ucd_tramite = $query->large;
                                }
                            }
                        }else{
                            // no hay metros
                            $ucd_tramite = 0;
                        } 
                        $total_ucd = $total_ucd + $ucd_tramite;
                        break;
                         
                }
            }
        }


        // EXENCION
        if ($porcentaje != '') {
            $exencion = ($total_ucd * $porcentaje)/100;
        }

        // TOTAL
        $total = $total_ucd - $exencion;

        return response()->json(['sub_total' => $total_ucd, 'exencion' => $exencion, 'total' => $total]);
        
    }

    /**
     * Display the specified resource.
     */
    public function nueva(Request $request)
    {
        $tramites = $request->post('tramite');
        $user = auth()->id();

        $total_ucd = 0;
        $year = date("Y");

        ///////////////////////////////////// CONTRIBUYENTE
            $condicion_sujeto = $request->post('condicion_sujeto');
            $identidad_condicion = $request->post('identidad_condicion');
            $identidad_nro = $request->post('identidad_nro');

            $q1 = DB::table('contribuyentes')->select('id_contribuyente')
                                                ->where('condicion_sujeto','=', $condicion_sujeto)
                                                ->where('identidad_condicion','=', $identidad_condicion)
                                                ->where('identidad_nro','=', $identidad_nro)
                                                ->first();
            if ($q1) {
                $id_contribuyente = $q1->id_contribuyente;
            }else{
                return response()->json(['success' => false, 'nota'=> 'Disculpe, el contribuyente no se encuentra registrado.']);
            }

        ///////////////////////////////////// VALIDACIÓN  CAMPOS
            foreach ($tramites as $tramite) {
                $key_tramite = $tramite['tramite'];
                $forma = $tramite['forma'];

                if ($forma == 'Seleccione' || $forma == '') {
                    return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar la Forma.']);
                }

                if ($key_tramite == 'Seleccione' || $key_tramite == '') {
                    return response()->json(['success' => false, 'nota'=> 'Disculpe, debe seleccionar el Tramite.']);
                }
                
            }

        ////////////////////////////////// INSERT
        $direccion = $request->post('direccion');
        $tlf_movil = $request->post('tlf_movil');
        $tlf_second = $request->post('tlf_second');
        $metros = $request->post('metros');
        $solicitud_doc = $request->file('solicitud_doc');
        $aprobacion_doc = $request->file('aprobacion_doc');
        $porcentaje = $request->post('porcentaje');
        $tipo_pago = $request->post('tipo_pago');

        $insert_exencion = DB::table('exenciones')->insert(['key_user' => $user,
                                                            'key_contribuyente' => $id_contribuyente,
                                                            'porcentaje_exencion' => $porcentaje,
                                                            'tipo_pago' => $tipo_pago,
                                                            'direccion' => $direccion,
                                                            'tlf_movil' => $tlf_movil,
                                                            'tlf_second' => $tlf_second,
                                                            'total_ucd' => 0,
                                                            'estado' => 18
                                                        ]); 
        if ($insert_exencion) {
            $id_exencion = DB::table('exenciones')->max('id_exencion');

            ///////////CREAR CARPETA DEL AÑO SI NO EXISTE
            /////////// Solicitudes
            if (!is_dir('../public/assets/Exenciones/Solicitudes/'.$year)){   ////no existe la carpeta del año
                mkdir('../public/assets/Exenciones/Solicitudes/'.$year, 0777);
            }
            /////////// Aprobaciones
            if (!is_dir('../public/assets/Exenciones/Aprobaciones/'.$year)){   ////no existe la carpeta del año
                mkdir('../public/assets/Exenciones/Aprobaciones/'.$year, 0777);
            }
            /////////// Pagos
            if (!is_dir('../public/assets/Exenciones/Pagos/'.$year)){   ////no existe la carpeta del año
                mkdir('../public/assets/Exenciones/Pagos/'.$year, 0777);
            }
            

            // GUARDAR DOC SOLICITUD
            $nombre_doc  = 'SOLICITUD_E'.$id_exencion.'.'.$solicitud_doc->getClientOriginalExtension();
            $ruta          = public_path('assets/Exenciones/Solicitudes/'.$year.'/'.$nombre_doc);
            $ruta_n        = 'assets/Exenciones/Solicitudes/'.$year.'/'.$nombre_doc;

            if(copy($solicitud_doc->getRealPath(),$ruta)){
                // GUARDAR DOC APROBACION
                $nombre_doc_2  = 'SOLICITUD_E'.$id_exencion.'.'.$aprobacion_doc->getClientOriginalExtension();
                $ruta_2          = public_path('assets/Exenciones/Aprobaciones/'.$year.'/'.$nombre_doc_2);
                $ruta_n_2        = 'assets/Exenciones/Aprobaciones/'.$year.'/'.$nombre_doc_2;

                if(copy($aprobacion_doc->getRealPath(),$ruta_2)){
                    $update_docs = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->update(['doc_solicitud' => $ruta_n,'doc_aprobacion' => $ruta_n_2]);
                    if ($update_docs) {
                        //////////////////////////// TRUE RESPONSE
                    }else{
                        //////delete exencion
                        $delete = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->delete();
                        return response()->json(['success' => false]);
                    }
                }else{
                    //////delete exencion
                    $delete = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->delete();
                    return response()->json(['success' => false]);
                }
            }else{
                //////delete exencion
                $delete = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->delete();
                return response()->json(['success' => false]);
            }




            /////////////////////////////////////////// INSERT DETALLE EXENCION
            foreach ($tramites as $tramite) {
                ///// INSERT DETALLE
                $insert_detalle = DB::table('detalle_exenciones')->insert(['key_exencion' => $id_exencion,
                                                                            'key_tramite' => $tramite['tramite'],
                                                                            'forma' => $tramite['forma'],
                                                                            'cantidad' => 1 ,
                                                                            'metros' => $metros,
                                                                        ]);
                if ($insert_detalle) {
                    // SUMA TOTAL UCD
                    if ($tramite['tramite'] != '') { 
                        $query = DB::table('tramites')->where('id_tramite','=', $tramite['tramite'])->first();
                        $ucd_tramite = 0;
                        switch ($query->alicuota) {
                            case 13:
                                // METRADO
                                if (!empty($metros)) {
                                    // hay metros
                                    if ($metros == '' || $metros == 0) {
                                        $ucd_tramite = 0;
                                    }else{
                                        if ($metros <= 150) {
                                            ////pequeña
                                            $ucd_tramite = $query->small;
                                        }elseif ($metros > 150 && $metros < 400) {
                                            /////mediana
                                            $ucd_tramite = $query->medium;
                                        }elseif ($metros >= 400) {
                                            /////grande
                                            $ucd_tramite = $query->large;
                                        }
                                    }
                                }else{
                                    // no hay metros
                                    $ucd_tramite = 0;
                                } 
                                $total_ucd = $total_ucd + $ucd_tramite;
                            break;
                                
                        }
                    }
                }else{
                    // delete exencion
                    $delete = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->delete();
                    return response()->json(['success' => false]);
                }
            } /// cierra foreach

            // UPDATE EXENCION
            $update_exencion = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->update(['total_ucd' => $total_ucd]);
            if ($update_exencion) {
                return response()->json(['success' => true]);
            }else{
                //////delete exencion
                $delete = DB::table('exenciones')->where('id_exencion', '=', $id_exencion)->delete();
                return response()->json(['success' => false]);
            }

        }else{
            return response()->json(['success' => false]); 
        }
        

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function sujeto(Request $request)
    {
        $sujeto = $request->post('sujeto');
        $exencion = $request->post('exencion');

        $c1 = DB::table('contribuyentes')->join('tipos', 'contribuyentes.condicion_sujeto', '=','tipos.id_tipo')
                                        ->select('contribuyentes.*','tipos.nombre_tipo')
                                        ->where('contribuyentes.id_contribuyente','=',$sujeto)->first();

        $c2 = DB::table('exenciones')->select('direccion','tlf_movil','tlf_second')->where('id_exencion','=',$exencion)->first();

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$c1->nombre_razon.'</h1>
                        <h5 class="modal-title text-muted" id="" style="font-size:14px">Contribuyente</h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:15px;">
                    <h6 class="text-muted text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                    <table class="table" style="font-size:14px">
                        <tr>
                            <th>R.I.F.</th>
                            <td>'.$c1->identidad_condicion.'-'.$c1->identidad_nro.'</td>
                        </tr>
                        <tr>
                            <th>Razón Social</th>
                            <td>'.$c1->nombre_razon.' <span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span></td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td>'.$c2->direccion.'</td>
                        </tr>
                        <tr>
                            <th>Teléfono móvil</th>
                            <td>'.$c2->tlf_movil.'</td>
                        </tr>
                        <tr>
                            <th>Teléfono secundario</th>
                            <td>'.$c2->tlf_second.'</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-center my-2 mt-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>';

        return response($html);

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
