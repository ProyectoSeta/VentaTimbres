<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class AsignadosController extends Controller
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
        $query = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
        ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
        ->where('exenciones.estado','=',18)
        ->where('exenciones.key_taquilla','!=',null)->get();

        return view('asignado', compact('query'));
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
    public function modal(Request $request)
    {
        $id_exencion = $request->post('exencion');
        $tramites = '';

        $c1 = DB::table('exenciones')->join('contribuyentes', 'exenciones.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                    ->select('exenciones.*','contribuyentes.nombre_razon','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                    ->where('exenciones.id_exencion','=',$id_exencion)->first();

        $q2 = DB::table('contribuyentes')->join('tipos','contribuyentes.condicion_sujeto', '=','tipos.id_tipo')
                                    ->select('contribuyentes.*','tipos.nombre_tipo')
                                    ->where('contribuyentes.id_contribuyente','=', $c1->key_contribuyente)->first();

        $html_contribuyente = '<!-- *************** DATOS CONTRIBUYENTE ******************-->
                                <div class="mb-2" style="font-size:13px">
                                    <div class="d-flex justify-content-center">
                                        <div class="row w-100">
                                            <h5 class="titulo fw-bold text-navy mb-3">Contribuyente | <span class="text-secondary fs-6">Datos</span></h5>
                                            <!-- Tipo Contribuyente -->
                                            <div class="col-sm-3">
                                                <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                                <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto" disabled>
                                                    <option>'.$q2->nombre_tipo.'</option>
                                                </select>
                                            </div>
                                            <!-- ci o rif -->
                                            <div class="col-sm-5">
                                                <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion" disabled>
                                                            <option>'.$q2->identidad_condicion.'</option>
                                                        </select>
                                                    </div>
                                                    <!-- <div class="col-1">-</div> -->
                                                    <div class="col-7">
                                                        <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" value="'.$q2->identidad_nro.'" disabled>
                                                        <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- nombre o razon -->
                                            <div class="col-sm-4">
                                                <label class="form-label" for="nombre">Nombre / Razon Social</label><span class="text-danger">*</span>
                                                <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled value="'.$q2->nombre_razon.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>';


        $c2 = DB::table('detalle_exenciones')->where('key_exencion','=',$id_exencion)->get();
        // return response($c2);
        foreach ($c2 as $key) {
            $q1 = DB::table('tramites')->join('entes','tramites.key_ente', '=','entes.id_ente')
                                        ->select('tramites.tramite','entes.ente')
                                        ->where('tramites.id_tramite','=', $key->key_tramite)->first();

            $metros = $key->metros;
            $ucd_tramite = '';

            if ($metros > 0 && $metros <= 150) {
                ////pequeña
                $consulta = DB::table('tramites')->select('small')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->small;
            }elseif ($metros > 150 && $metros < 400) {
                /////mediana
                $consulta = DB::table('tramites')->select('medium')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->medium;
            }elseif ($metros >= 400) {
                /////grande
                $consulta = DB::table('tramites')->select('large')->where('id_tramite','=', $key->key_tramite)->first();
                $ucd_tramite = $consulta->large;
            }    


            $tramites .= '<div class="d-flex justify-content-center">
                                    <div class="row w-100">
                                        <h5 class="titulo fw-bold text-navy my-3">Tramite | <span class="text-secondary fs-6">Datos</span></h5>
                                        <div class="col-sm-3">
                                            <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm ente" disabled>
                                               <option>'.$q1->ente.'</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm tramite" name="tramite[1][tramite]" disabled>
                                                <option>'.$q1->tramite.'</option>
                                            </select>
                                        </div>                                        
                                        <div class="col-sm-2">
                                            <label class="form-label" for="">Metros (mt2)</label><span class="text-danger">*</span>
                                            <input type="number" class="form-control form-control-sm " disabled value="'.$metros.'">
                                        </div>
                                        <div class="col-sm-1" id="div_ucd_1">
                                            <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" nro="1" disabled value="'.$ucd_tramite.'">
                                        </div> 
                                        <div class="col-sm-2">
                                            <label class="form-label" for="forma">Timbre</label><span class="text-danger">*</span>
                                            <select class="form-select form-select-sm forma" nro="1" name="tramite[1][forma]"id="forma_1" value="TFE-14">
                                                <option value="">Seleccione</option>
                                            </select>
                                            <p class="text-end my-0 text-muted" id="cant_timbre_1">1 und.</p>
                                        </div>
                                    </div>
                                </div>';
        }

        $html_tramites = '<!-- **************** DATOS TRAMITE **************** -->
                        <div class="mb-4" style="font-size:13px">
                            <div class="d-flex flex-column tramites">
                                '.$tramites.'
                            </div>
                        </div>';

        $html = '<div class="modal-header p-2 pt-3 ps-3">
                    <h1 class="modal-title fs-5 fw-bold text-navy">Venta | <span class="text-muted">Exención</span></h1>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_impresion_exencion" method="post" onsubmit="event.preventDefault(); impresionExencion()">
                        '.$html_contribuyente.'
                        '.$html_tramites.'

                        <input type="hidden" name="exencion" value="'.$id_exencion.'">


                        <!-- totales -->
                        <div class="row d-flex align-items-center ">
                            <div class="col-lg-6 d-flex justify-content-end flex-column">
                                <div class="bg-light rounded-3 px-3 py-2 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="d-flex flex-column titulo mb-0">
                                            <span class="fs-3 fw-bold text-navy">UCD</span>
                                            <span class="fw-bold text-muted" style="font-size:13px">Unidad de Cuenta Dinámica</span>
                                        </p>
                                        <span class="fs-2 text-navy fw-bold" id="ucd">'.$c1->total_ucd.' UCD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <img src='.asset("assets/banner_asignado_ex.svg").'" alt="" class="rounded-4" width="95%">
                                </div>
                            </div>
                        </div>


                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <a class="btn btn-secondary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#modal_asignado_exencion" >Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_submit_venta">Realizar Venta</button>
                        </div>
                    </form>
                </div>';
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
