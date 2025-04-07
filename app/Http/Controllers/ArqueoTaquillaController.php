<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ArqueoTaquillaController extends Controller
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
        // comprobar que la taquilla ha sio cerrada para mostrar el arqueo PENDIENTE

        // FECHA HOY (FORMATO)
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
        $hoy_view = $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y');

        // VENTAS DEL DÍA
        $user = auth()->id();
        $query = DB::table('users')->select('key_sujeto')->where('id','=',$user)->first();
        $q2 = DB::table('taquillas')->select('id_taquilla')->where('key_funcionario','=',$query->key_sujeto)->first();

        $id_taquilla = $q2->id_taquilla;
        $hoy = date('Y-m-d');

        $ventas = DB::table('ventas')->join('contribuyentes', 'ventas.key_contribuyente', '=','contribuyentes.id_contribuyente')
                                ->select('ventas.*','contribuyentes.identidad_condicion','contribuyentes.identidad_nro')
                                ->where('ventas.key_taquilla','=',$id_taquilla)
                                ->where('ventas.fecha','=',$hoy)
                                ->get();
        
        // DETALLE ARQUEO
        $arqueo = DB::table('cierre_taquillas')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->first();

        // DETALLE_EFECTIVO
        $c1 = DB::table('apertura_taquillas')->select('fondo_caja')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->first();
        $fondo_caja = $c1->fondo_caja;
        $bs_boveda = 0;

        $c2 = DB::table('boveda_ingresos')->select('monto')->where('fecha','=',$hoy)->where('key_taquilla','=',$id_taquilla)->get();
        if ($c2) {
            foreach ($c2 as $key) {
                $bs_boveda = $bs_boveda + $key->monto;
            }
            
        }

        $efectivo_taq = ($arqueo->efectivo + $fondo_caja) - $bs_boveda;


        return view('arqueo',compact('hoy_view','ventas','arqueo','bs_boveda','efectivo_taq','fondo_caja'));
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
    public function contribuyente(Request $request)
    {
        $sujeto = $request->post('sujeto');

        $c1 = DB::table('contribuyentes')->join('tipos', 'contribuyentes.condicion_sujeto', '=','tipos.id_tipo')
                                        ->select('contribuyentes.*','tipos.nombre_tipo')
                                        ->where('contribuyentes.id_contribuyente','=',$sujeto)->first();

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$c1->nombre_razon.'</h1>
                        <h5 class="modal-title text-muted" id="" style="font-size:14px">Contribuyente</h5>
                    </div>
                </div>
                <div class="modal-body" style="font-size:13px;">
                    <h6 class="text-muted text-center" style="font-size:13px;">Datos del Sujeto pasivo</h6>
                    <table class="table text-center" style="font-size:14px">
                        <tr>
                            <th>R.I.F.</th>
                            <td>'.$c1->identidad_condicion.'-'.$c1->identidad_nro.'</td>
                        </tr>
                        <tr>
                            <th>Razón Social</th>
                            <td>'.$c1->nombre_razon.' <span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">'.$c1->nombre_tipo.'</span></td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-center my-2 mt-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>';

        return response($html);
    }

    /**
     * Display the specified resource.
     */
    public function timbres(Request $request)
    {
        $id_venta = $request->post('venta');
        $timbres = '';

        $q1 = DB::table('detalle_ventas')->join('tramites', 'detalle_ventas.key_tramite', '=','tramites.id_tramite')
                                        ->select('detalle_ventas.*','tramites.tramite','tramites.key_ente')
                                        ->where('detalle_ventas.key_venta','=',$id_venta)->get();
        foreach ($q1 as $key) {
            $c1 = DB::table('entes')->select('ente')->where('id_ente','=',$key->key_ente)->first();
            $length = 6;

            if ($key->forma == 3) {
                // FORMA 14
                $c2 = DB::table('detalle_venta_tfes')->where('key_detalle_venta','=',$key->correlativo)->first();
                $formato_nro = substr(str_repeat(0, $length).$c2->nro_timbre, - $length);

                if ($key->capital == null) {
                    $timbres .= '<div class="border mb-4 rounded-3">
                            <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                <!-- DATOS -->
                                <div class="w-50">
                                    <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th>Ente:</th>
                                            <td>'.$c1->ente.'</td>
                                        </tr>
                                        <tr>
                                            <th>Tramite:</th>
                                            <td>'.$key->tramite.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- UCD -->
                                <div class="">
                                    <div class="text-center titulo fw-bold fs-3">'.$key->ucd.' UCD</div>
                                </div>
                            </div>
                        </div>';
                }else{
                    $timbres .= '<div class="border mb-4 rounded-3">
                            <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                <!-- DATOS -->
                                <div class="w-50">
                                    <div class="text-danger fw-bold fs-4" id="">A-'.$formato_nro.'<span class="text-muted ms-2">TFE-14</span></div> 
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <th>Ente:</th>
                                            <td>'.$c1->ente.'</td>
                                        </tr>
                                        <tr>
                                            <th>Tramite:</th>
                                            <td>'.$key->tramite.'</td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- UCD -->
                                <div class="">
                                    <div class="text-center titulo fw-bold fs-3">'.$key->bs.' Bs.</div>
                                </div>
                            </div>
                        </div>';
                }

            }else{
                // ESTAMPILLAS
                $c3 = DB::table('detalle_venta_estampillas')->where('key_detalle_venta','=',$key->correlativo)->get();
                foreach ($c3 as $value) {
                    $formato_nro = substr(str_repeat(0, $length).$value->nro_timbre, - $length);
                    $timbres .= '<div class="border mb-4 rounded-3">
                                    <div class="d-flex justify-content-between px-3 py-2 align-items-center">
                                        <!-- DATOS -->
                                        <div class="w-50">
                                            <div class="text-danger fw-bold fs-4" id="">'.$formato_nro.'<span class="text-muted ms-2">Estampilla</span></div> 
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <th>Ente:</th>
                                                    <td>'.$c1->ente.'</td>
                                                </tr>
                                                <tr>
                                                    <th>Tramite:</th>
                                                    <td>'.$key->tramite.'</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- UCD -->
                                        <div class="">
                                            <div class="text-center titulo fw-bold fs-3">'.$key->ucd.' UCD</div>
                                        </div>
                                    </div>
                                </div>';
                }
            }
        }

        $html = '<div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold text-navy">Detalle | <span class="text-muted">Timbres</span></h1>
                </div>
                <div class="modal-body px-4 py-3" style="font-size:13px">
                    <div class="">
                        '.$timbres.'
                    </div>
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
