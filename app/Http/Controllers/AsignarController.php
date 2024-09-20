<?php

namespace App\Http\Controllers;
use App\Models\SujetoPasivo;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;


class AsignarController extends Controller
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
        $asignaciones = [];
        $consulta = DB::table('asignacion_reservas')
                                    ->join('clasificacions', 'asignacion_reservas.estado', '=', 'clasificacions.id_clasificacion')
                                    ->select('asignacion_reservas.*','clasificacions.nombre_clf')
                                    ->where('asignacion_reservas.estado','=',17)
                                    ->orWhere('asignacion_reservas.estado','=',29)
                                    ->get();
        $total = count($consulta);
        $current = 0;

        foreach($consulta as $c) {
            $current++;

            $tipo_sujeto = $c->contribuyente;
            $rif_nro = '';
            $rif_condicion = '';
            $id_sujeto = '';

            if ($tipo_sujeto == 27) { ///registrado
                $sujeto = DB::table('sujeto_pasivos')->select('id_sujeto','rif_nro','rif_condicion')->where('id_sujeto','=',$c->id_sujeto)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
                $id_sujeto = $sujeto->id_sujeto;
            }else{  //////no registrado
                $sujeto = DB::table('sujeto_notusers')->select('id_sujeto_notuser','rif_nro','rif_condicion')->where('id_sujeto_notuser','=',$c->id_sujeto_notuser)->first();
                $rif_nro = $sujeto->rif_nro;
                $rif_condicion = $sujeto->rif_condicion;
                $id_sujeto = $sujeto->id_sujeto_notuser;
            }

            if ($current == $total) {
                $delete_a = '1';
            }else {
                $delete_a = '0';
            }

            $array = array(
                'id_asignacion' => $c->id_asignacion,
                'contribuyente' => $c->contribuyente,
                'id_sujeto' => $id_sujeto,
                'rif_nro' => $rif_nro,
                'rif_condicion' => $rif_condicion,
                'cantidad_guias' => $c->cantidad_guias,
                'fecha_emision' => $c->fecha_emision,
                'soporte' => $c->soporte,
                'estado' => $c->estado,
                'delete_a' => $delete_a
            );

            $a = (object) $array;
            array_push($asignaciones, $a);
        }


        return view('asignar', compact('asignaciones'));
    }



    public function sujeto(Request $request)
    {
        $idSujeto = $request->post('sujeto');
        $tipo = $request->post('tipo');
        if ($tipo == 27) { 
            /////REGISTRADO
            $sujeto = DB::table('sujeto_pasivos')->where('id_sujeto','=',$idSujeto)->first();
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-user-circle fs-1 text-secondary" ></i>
                            <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$sujeto->razon_social.'</h1>
                            <h5 class="modal-title text-muted fw-bold" id="" style="font-size:14px">Contribuyente</h5>
                        </div>
                    </div>
                    <div class="modal-body" style="font-size:15px;">
                        <h6 class="text-navy fw-bold text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                        <table class="table" style="font-size:14px">
                            <tr>
                                <th>R.I.F.</th>
                                <td>'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</td>
                            </tr>
                            <tr>
                                <th>Razon Social</th>
                                <td>'.$sujeto->razon_social.'</td>
                            </tr>
                            <tr>
                                <th>¿Empresa Artesanal?</th>
                                <td>'.$sujeto->artesanal.'</td>
                            </tr>
                            <tr>
                                <th>Dirección</th>
                                <td>'.$sujeto->direccion.'</td>
                            </tr>
                            <tr>
                                <th>Teléfono móvil</th>
                                <td>'.$sujeto->tlf_movil.'</td>
                            </tr>
                            <tr>
                                <th>Teléfono fijo</th>
                                <td>'.$sujeto->tlf_fijo.'</td>
                            </tr>
                        </table>

                        <h6 class="text-navy fw-bold text-center" style="font-size:14px;">Datos del Representante</h6>
                        <table class="table"  style="font-size:14px">
                            <tr>
                                <th>C.I. del representante</th>
                                <td>'.$sujeto->ci_condicion_repr.'-'.$sujeto->ci_nro_repr.'</td>
                            </tr>
                            <tr>
                                <th>R.I.F. del representante</th>
                                <td>'.$sujeto->rif_condicion_repr.'-'.$sujeto->rif_nro_repr.'</td>
                            </tr>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <td>'.$sujeto->name_repr.'</td>
                            </tr>
                            <tr>
                                <th>Teléfono movil</th>
                                <td>'.$sujeto->tlf_repr.'</td>
                            </tr>
                        </table>
                    </div>';

            return response($html);

        }else{
            ///// NO REGISTRADO
            $sujeto = DB::table('sujeto_notusers')->where('id_sujeto_notuser','=',$idSujeto)->first();
            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-user-circle fs-1 text-muted" ></i>
                            <h1 class="modal-title fs-5 text-navy fw-bold" id="" >'.$sujeto->razon_social.'</h1>
                            <h5 class="modal-title text-muted fw-bold" id="" style="font-size:14px">Contribuyente</h5>
                            <span class="badge bg-secondary-subtle border border-secondary-subtle text-secondary-emphasis rounded-pill" style="font-size:12.7px">Registrado mediante Asignaciones</span>
                        </div>
                    </div>
                    <div class="modal-body" style="font-size:15px;">
                        <h6 class="text-navy fw-bold text-center" style="font-size:14px;">Datos del Sujeto pasivo</h6>
                        <table class="table" style="font-size:14px">
                            <tr>
                                <th>R.I.F.</th>
                                <td>'.$sujeto->rif_condicion.'-'.$sujeto->rif_nro.'</td>
                            </tr>
                            <tr>
                                <th>Razon Social</th>
                                <td>'.$sujeto->razon_social.'</td>
                            </tr>
                            <tr>
                                <th>Dirección</th>
                                <td>'.$sujeto->direccion.'</td>
                            </tr>
                            <tr>
                                <th>Teléfono móvil</th>
                                <td>'.$sujeto->tlf_movil.'</td>
                            </tr>
                        </table>

                        <h6 class="text-navy fw-bold text-center" style="font-size:14px;">Datos del Representante</h6>
                        <table class="table"  style="font-size:14px">
                            <tr>
                                <th>C.I. del representante</th>
                                <td>'.$sujeto->ci_condicion_repr.'-'.$sujeto->ci_nro_repr.'</td>
                            </tr>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <td>'.$sujeto->name_repr.'</td>
                            </tr>
                            <tr>
                                <th>Teléfono movil</th>
                                <td>'.$sujeto->tlf_repr.'</td>
                            </tr>
                        </table>
                    </div>';

            return response($html);
        }
    }

    

    public function search(Request $request)
    {
        $rif_nro = $request->post('rif_nro'); 
        $rif_condicion = $request->post('rif_condicion');
        $html = '';

        $query =  DB::table('sujeto_pasivos')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
        if ($query->total == 0) {
            $query2 =  DB::table('sujeto_notusers')->selectRaw("count(*) as total")
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            if ($query2->total == 0) {
                $html = '<div class="text-center">
                            <p class="fw-bold text-muted mb-2">Contribuyente No Registrado</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_no_registrado">Registrar</a>
                        </div>';
            }else{
                $consulta =  DB::table('sujeto_notusers')->select('id_sujeto_notuser','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
                $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado en Asignaciones</p>
                            <a href="#" class="asignar" tipo="notuser" id_sujeto="'.$consulta->id_sujeto_notuser.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
            }
        }else{
            $consulta =  DB::table('sujeto_pasivos')->select('id_sujeto','razon_social','rif_nro','rif_condicion')
                                            ->where('rif_condicion','=',$rif_condicion)
                                            ->where('rif_nro','=',$rif_nro)->first();
            $html = '<div class="text-center">
                            <p class="fw-bold text-success mb-2">Contribuyente Registrado en la Plataforma</p>
                            <a href="#" class="asignar" tipo="user" id_sujeto="'.$consulta->id_sujeto.'" data-bs-toggle="modal" data-bs-target="#modal_asignar_sujeto_registrado">'.$consulta->razon_social.' <br> '.$consulta->rif_condicion.'-'.$consulta->rif_nro.'</a>
                        </div>';
        }

        return response($html);
    }



    public function modal(Request $request)   ////MODAL ASIGNACIÓN DE GUIAS - CONTRIBUYENTE RESGISTRADO
    {
        $tipo = $request->post('tipo'); 
        $sujeto = $request->post('sujeto');

        if ($tipo == 'user') {
            $sp = DB::table('sujeto_pasivos')->where('id_sujeto','=',$sujeto)->first();
            if ($sp) {
                      
                $html = '<div class="modal-header">
                         <h1 class="modal-title fs-5 text-navy fw-bold d-flex align-items-center" id="exampleModalLabel" ><i class="bx bx-customize me-2 text-muted fs-2"></i>Asignación de Guías</h1>
                    </div>
                    <div class="modal-body " style="font-size:13px">
                        <form id="form_asignar_guias_register" method="post" onsubmit="event.preventDefault(); asignarGuiasRegister();">
                            <div class="row px-4">
                                <div class="col-sm-6">
                                    <div class="text-center text-navy fw-bold mb-3">
                                        <span class="">Datos del Contribuyente</span><br>
                                        <span class="text-secondary">Registrado en la Plataforma</span>
                                    </div>

                                    <div class="mb-0">
                                        <span class="fw-bold">R.I.F.</span>
                                        <p class="text-navy fw-bold mb-2">'.$sp->rif_condicion.'-'.$sp->rif_nro.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Razon Social</span>
                                        <p class="text-navy fw-bold mb-2">'.$sp->razon_social.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Dirección</span>
                                        <p class="text-muted mb-2">'.$sp->direccion.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Teléfono Móvil</span>
                                        <p class="text-muted mb-2">'.$sp->tlf_movil.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Teléfono Fijo</span>
                                        <p class="text-muted mb-2">'.$sp->tlf_fijo.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Representante legal</span>
                                        <p class="text-muted mb-2">'.$sp->name_repr.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">C.I. del Representante</span>
                                        <p class="text-muted mb-2">'.$sp->ci_condicion_repr.'-'.$sp->ci_nro_repr.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">R.I.F. del Representante</span>
                                        <p class="text-muted mb-2">'.$sp->rif_condicion_repr.'-'.$sp->rif_nro_repr.'</p>
                                    </div>
                                    <div class="mb-0">
                                        <span class="fw-bold">Teléfono del Representante</span>
                                        <p class="text-muted mb-2">'.$sp->tlf_repr.'</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-center text-navy fw-bold mb-3">
                                        <span class="">Correspondiente a la Asignación</span>
                                    </div>

                                    <div class=" mb-2">
                                        <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" type="number" id="cantidad" name="cantidad" required>
                                    </div>
                                    <div class=" mb-2">
                                        <label class="form-label" for="motivo">Motivo</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" type="text" id="motivo" name="motivo" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                        <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                        <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                    </div>
                                    <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>


                                    <input type="hidden" name="id_sujeto" value="'.$sp->id_sujeto.'" required>
                                    <input type="hidden" name="tipo_sujeto" value="'.$tipo.'" required>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion">Asignar</button>
                            </div>
                        </form>
                    </div>';

                    
                return response($html);
                    
                
            }else{
                return response()->json(['success' => false]);
            }

        }else{
            $sp = DB::table('sujeto_notusers')->where('id_sujeto_notuser','=',$sujeto)->first();
            if ($sp) {
                    
                $html = '<div class="modal-header">
                             <h1 class="modal-title fs-5 text-navy fw-bold d-flex align-items-center" id="exampleModalLabel" ><i class="bx bx-customize me-2 text-muted fs-2"></i>Asignación de Guías</h1>
                        </div>
                        <div class="modal-body " style="font-size:13px">
                            <form id="form_asignar_guias_register" method="post" onsubmit="event.preventDefault(); asignarGuiasRegister();">
                                <div class="row px-4">
                                    <div class="col-sm-6">
                                        <div class="text-center text-navy fw-bold mb-3">
                                            <span class="">Datos del Contribuyente</span><br>
                                            <span class="text-secondary">Registrado en Asignaciones</span>
                                        </div>

                                        <div class="mb-0">
                                            <span class="fw-bold">R.I.F.</span>
                                            <p class="text-navy fw-bold mb-2">'.$sp->rif_condicion.'-'.$sp->rif_nro.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">Razon Social</span>
                                            <p class="text-navy fw-bold mb-2">'.$sp->razon_social.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">Dirección</span>
                                            <p class="text-muted mb-2">'.$sp->direccion.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">Teléfono Móvil</span>
                                            <p class="text-muted mb-2">'.$sp->tlf_movil.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">Representante legal</span>
                                            <p class="text-muted mb-2">'.$sp->name_repr.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">C.I. del Representante</span>
                                            <p class="text-muted mb-2">'.$sp->ci_condicion_repr.'-'.$sp->ci_nro_repr.'</p>
                                        </div>
                                        <div class="mb-0">
                                            <span class="fw-bold">Teléfono del Representante</span>
                                            <p class="text-muted mb-2">'.$sp->tlf_repr.'</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-center text-navy fw-bold mb-3">
                                            <span class="">Correspondiente a la Asignación</span>
                                        </div>

                                        <div class=" mb-2">
                                            <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" type="number" id="cantidad" name="cantidad" required>
                                        </div>
                                        <div class=" mb-2">
                                            <label class="form-label" for="motivo">Motivo</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" type="text" id="motivo" name="motivo" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                            <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                            <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required>
                                        </div>

                                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                                        <input type="hidden" name="id_sujeto" value="'.$sp->id_sujeto_notuser.'" required>
                                        <input type="hidden" name="tipo_sujeto" value="'.$tipo.'" required>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar">Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion" disabled="">Asignar</button>
                                </div>
                            </form>
                        </div>';

                return response($html);
                    
                
            }else{
                return response()->json(['success' => false]);
            }
        }


    }



    public function asignar_notuser(Request $request)
    {   
        $rif_condicion = $request->post('rif_condicion');
        $rif_nro = $request->post('rif_nro');
        $razon_social = $request->post('razon_social');
        $direccion = $request->post('direccion');
        $tlf_movil = $request->post('tlf_movil');
        $ci_condicion_repr = $request->post('ci_condicion_repr');
        $ci_nro_repr = $request->post('ci_nro_repr');
        $name_repr = $request->post('name_repr');
        $tlf_repr = $request->post('tlf_repr');
        $cantidad = $request->post('cantidad');
        $motivo = $request->post('motivo');
        $oficio = $request->file('oficio');

        $user = auth()->id();
        $year = date("Y");

        $tipo_sujeto = 'notuser';

        ///////////CREAR CARPETA PARA LOS OFICIOS SI NO EXISTE
        if (!is_dir('../public/assets/oficiosReservas/'.$year)){   ////no existe la carpeta del año
            mkdir('../public/assets/oficiosReservas/'.$year, 0777);
        }
        $consulta_rif = DB::table('sujeto_notusers')->selectRaw("count(*) as total")->where('rif_condicion','=',$rif_condicion)->where('rif_nro','=',$rif_nro)->first(); 
        if ($consulta_rif->total == 0) {
            $consulta_razon = DB::table('sujeto_notusers')->selectRaw("count(*) as total")->where('razon_social','=',$razon_social)->first();
            if ($consulta_razon->total == 0){
                /////////////////////////////////////// (1) REGISTRAR SUJETO NOT USER
                $insert_sujeto = DB::table('sujeto_notusers')->insert(['rif_condicion' => $rif_condicion,
                                                                'rif_nro' => $rif_nro, 
                                                                'razon_social' => $razon_social,
                                                                'direccion' => $direccion,
                                                                'tlf_movil' => $tlf_movil,
                                                                'ci_condicion_repr' => $ci_condicion_repr,
                                                                'ci_nro_repr' => $ci_nro_repr,
                                                                'name_repr' => $name_repr,
                                                                'tlf_repr' => $tlf_repr
                                                            ]);
                if ($insert_sujeto) {

                    $id_sujeto = DB::table('sujeto_notusers')->max('id_sujeto_notuser');
                    $desde = '';
                    $hasta = '';


                    /////////////////////////////////// (2) REGISTRAR LA ASIGNACIÓN
                    $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 28,
                                                                        'id_sujeto_notuser' => $id_sujeto, 
                                                                        'cantidad_guias'=>$cantidad,
                                                                        'motivo'=>$motivo,
                                                                        'estado' => 17,
                                                                        'id_user' => $user]);
                    if ($insert_asignacion) {
                        $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
                        $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
                        $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
                        $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

                        if(copy($oficio->getRealPath(),$ruta)){
                            $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                            if ($update_oficio) {
                                //////////////////////////// TRUE RESPONSE
                            }else{
                                return response()->json(['success' => false]);
                            }
                        }else{
                            return response()->json(['success' => false]);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }



                    /////////////////////////////////// (3) ASIGNACION DE GUÍAS
                    $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
                    if ($query_count) {
                        if ($query_count->total != 0) {
                            $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                            if ($cantidad <= $consulta->total){
                                ////// SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                                $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first();
                                if ($c){
                                    $asignado = $c->asignado;
                                    $guias_restantes = 50 - $asignado;

                                    if ($cantidad <= $guias_restantes) {
                                        /////hay guías suficientes en el talonario para la solicitud
                                        if ($c->asignado == 0) {
                                            ////// todavia no se han asignado guías del talonario
                                            $desde = $c->desde;
                                            $hasta = ($c->desde + $cantidad)-1;
                                        }else{
                                            ////// ya se han asignado guías del talonario
                                            $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                            
                                            if ($detalle) {
                                                
                                                $desde = $detalle->hasta + 1;
                                                $hasta = ($desde + $cantidad) - 1;
                                            }else{
                                                return response()->json(['success' => false]);
                                            }
                                        }
                                        
                                        
                                        $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                        'id_talonario' => $c->id_talonario,
                                                                        'id_asignacion_reserva' => $id_asignacion,
                                                                        'desde' => $desde, 
                                                                        'hasta' => $hasta]);
                                        
                                        
                                        if ($detalle_talonario) {
                                            $asignado = $asignado + $cantidad;
                                            $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
            
                                            // $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                                            
                                            // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));
                                            // $update_qr = DB::table('detalle_talonario_reserva')->where('id_talonario','=', $c->id_talonario)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                                            if ($update_asignado) {
                                            
                                                $user = auth()->id();
                                                $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                                $accion = 'ASIGNACIÓN DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.', ID TALONARIO: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                                $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                                
                                                
                                                $total_guias_reserva = $consulta->total - $cantidad;
                                                $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                                                if ($update_total_reserva) {
                                                    return response()->json(['success' => true, 'asignacion' => $id_asignacion, 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
                                                }else{
                                                    return response()->json(['success' => false]);
                                                }
                                            }
                                        }else{
                                            return response()->json(['success' => false]);
                                        }
            
                                    }else{
                                        /////no hay guias suficientes en el talonario para la solicitud
                                        $i = 0; //////cuenta las guías asignadas 
                                        $talonarios = [];
                                        $url_talonarios = '';
                                        // $x = 0; //////cuenta las iteraciones del bucle
            
                                        ////////////SE HACE EL PRIMER REGISTRO DE LAS GUIAS PARA DESPUES PASAR AL BUCLE  
                                        if ($c->asignado == 0) {
                                            ////// todavia no se han asignado guías del talonario
                                            $desde = $c->desde;
                                            $hasta = $c->hasta;
                                            
                                            
                                            $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                            'id_talonario' => $c->id_talonario,
                                                                            'id_asignacion_reserva' => $id_asignacion,
                                                                            'desde' => $desde, 
                                                                            'hasta' => $hasta]);
                                            

                                            if ($detalle_talonario) {
                                                $i = 50;
                                                $asignado = $c->asignado + $i;
                                                $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                            }else{
                                                return response()->json(['success' => false]);
                                            }
                                            
                                        }else{
                                            ////// ya se han asignado guías del talonario
                                            $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                            if ($detalle) {
                                                $desde = $detalle->hasta + 1;
                                                $hasta = $c->hasta;
                                                
                                                $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                            'id_talonario' => $c->id_talonario,
                                                                            'id_asignacion_reserva' => $id_asignacion,
                                                                            'desde' => $desde, 
                                                                            'hasta' => $hasta]);
                                                
                                                if ($detalle_talonario) {
                                                    $i = ($hasta - $desde) + 1;
                                                    $asignado = $c->asignado + $i;
                                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                                }else{
                                                    return response()->json(['success' => false]);
                                                }
                                            }else{
                                                return response()->json(['success' => false]);
                                            }
                                        }
            
                                        array_push($talonarios,$c->id_talonario);
                                        // $url_talonarios = 'T'.$c->id_talonario;
            
            
                                        do {
                                            // $cant -> cantidad de guías solicitadas
                                            // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo
            
                                            $guias_faltantes = $cantidad - $i;
                                            $c2 = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                                            if ($c2) {
                                                ////// todavia no se han asignado guías del talonario
                                                $desde = $c2->desde;
                                                $hasta = 0;
                                                if ($guias_faltantes <= 50) {
                                                    $hasta = ($desde + $guias_faltantes) - 1;
                                                }else{
                                                    $hasta = $c2->hasta;
                                                }
            
                                                $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                    'id_talonario' => $c->id_talonario,
                                                                    'id_asignacion_reserva' => $id_asignacion,
                                                                    'desde' => $desde, 
                                                                    'hasta' => $hasta]);
                                                
                                                if ($detalle_talonario) {
                                                    $i = $i + (($hasta - $desde) + 1);  
                                                    $asignado = $c2->asignado + $i;
                                                    array_push($talonarios,$c2->id_talonario);
                                                    // $url_talonarios .= '-'.$c2->id_talonario;
                                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                                }else{
                                                    return response()->json(['success' => false]); 
                                                }                             
                                            }else{
                                                return response()->json(['success' => false]); 
                                            }
                                            // $x++;
                                        } while ($i == $cantidad);
            
                                        //////GENERAR QR PARA EL(LOS) TALONARIO(S)
                                        // $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrReserva/?id='.$id_asignacion; 
                                        // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_A'.$id_asignacion.'.svg'));
            
                                        // $url = route('qr.qrReserva', ['idTalonario' => $talonarios ,'idSujeto' => $id_sujeto,'idSolicitud' => $idSolicitud]);
                                        // QrCode::size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_'.$url_talonarios.'_SR'.$idSolicitud.'.svg'));
                                        
                                        // foreach ($talonarios as $key => $v) {
                                        //     $update_qr = DB::table('detalle_talonario_reserva')->where('id_talonario', '=', $v)->where('id_solicitud_reserva', '=', $id_asignacion)->update(['qr' => 'assets/qr/qrcode_A'.$id_asignacion.'.svg']);
                                        // }
            
                                            
                                        $user = auth()->id();
                                        $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                        $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
            
                                        $total_guias_reserva = $consulta->total - $cantidad;
                                        $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                                        if ($update_total_reserva) {
                                            return response()->json(['success' => true, 'asignacion' => $id_asignacion , 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
                                        }else{
                                            return response()->json(['success' => false]);
                                        }
                    
            
                                    }
                                }else{
                                    return response()->json(['success' => false]);
                                }

                            }else{
                                ////// NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                                return response()->json(['success' => false, 'nota' => 'Disculpe, no hay Guías de Reserva disponible.']);
                            }
                        }else{
                            ////// NO HAY TALONARIOS DE RESERVA
                            return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
                        }
                    }else{
                        return response()->json(['success' => false]);
                    }
                    

                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, hay un Contribuyente registrado con la Razón Social ingresada, por favor verifique.']);
            }
        }else{
            return response()->json(['success' => false, 'nota' => 'Disculpe, hay un Contribuyente registrado con el R.I.F. ingresado, por favor verifique.']);
        }
    
    }



    public function asignar_user(Request $request){
        $id_sujeto = $request->post('id_sujeto');
        $tipo_sujeto = $request->post('tipo_sujeto');

        $cantidad = $request->post('cantidad');
        $motivo = $request->post('motivo');
        $oficio = $request->file('oficio');

        $user = auth()->id();
        $year = date("Y");

        ///////////CREAR CARPETA PARA LOS OFICIOS SI NO EXISTE
        if (!is_dir('../public/assets/oficiosReservas/'.$year)){   ////no existe la carpeta del año
            mkdir('../public/assets/oficiosReservas/'.$year, 0777);
        }

        if ($tipo_sujeto == 'user') {
            /////////////////////////////////// (1) REGISTRAR LA ASIGNACIÓN
            $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 27,
                                                                'id_sujeto' => $id_sujeto, 
                                                                'cantidad_guias'=>$cantidad,
                                                                'motivo'=>$motivo,
                                                                'estado' => 17,
                                                                'id_user' => $user]);
            
        }else{
            /////////////////////////////////// (1) REGISTRAR LA ASIGNACIÓN
            $insert_asignacion = DB::table('asignacion_reservas')->insert(['contribuyente' => 28,
                                                                'id_sujeto_notuser' => $id_sujeto, 
                                                                'cantidad_guias'=>$cantidad,
                                                                'motivo'=>$motivo,
                                                                'estado' => 17,
                                                                'id_user' => $user]);
        }

        if ($insert_asignacion) {
            $id_asignacion = DB::table('asignacion_reservas')->max('id_asignacion');
            $nombreimagen  = 'OFICIO_A'.$id_asignacion.'.'.$oficio->getClientOriginalExtension();
            $ruta          = public_path('assets/oficiosReservas/'.$year.'/'.$nombreimagen);
            $ruta_n        = 'assets/oficiosReservas/'.$year.'/'.$nombreimagen;

            if(copy($oficio->getRealPath(),$ruta)){
                $update_oficio = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->update(['soporte' => $ruta_n]);
                if ($update_oficio) {
                    //////////////////////////// TRUE RESPONSE
                }else{
                    return response()->json(['success' => false]);
                }
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            return response()->json(['success' => false]);
        }



        /////////////////////////////////// (3) ASIGNACION DE GUÍAS
        $query_count =  DB::table('talonarios')->selectRaw("count(*) as total")->where('clase','=',6)->first(); 
        if ($query_count) {
            if ($query_count->total != 0) {
                $consulta =  DB::table('total_guias_reservas')->select('total')->first(); 
                if ($cantidad <= $consulta->total){
                    ////// SI HAY GUÍAS SUFICIENTES PARA LA SOLICITUD
                    $c = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first();
                    if ($c){
                        $asignado = $c->asignado;
                        $guias_restantes = 50 - $asignado;

                        if ($cantidad <= $guias_restantes) {
                            /////hay guías suficientes en el talonario para la solicitud
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = ($c->desde + $cantidad)-1;
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                
                                if ($detalle) {
                                    
                                    $desde = $detalle->hasta + 1;
                                    $hasta = ($desde + $cantidad) - 1;
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }
                            
                            
                            $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                            'id_talonario' => $c->id_talonario,
                                                            'id_asignacion_reserva' => $id_asignacion,
                                                            'desde' => $desde, 
                                                            'hasta' => $hasta]);
                            
                            
                            if ($detalle_talonario) {
                                $asignado = $asignado + $cantidad;
                                $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);

                                if ($update_asignado) {
                                
                                    $user = auth()->id();
                                    if ($tipo_sujeto == 'user') {
                                        $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                                    }else{
                                        $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                                    }
                                    
                                    $accion = 'ASIGNACIÓN DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.', ID TALONARIO: '.$c->id_talonario.', Contribuyente: '.$sp->razon_social;
                                    $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                                    
                                    
                                    $total_guias_reserva = $consulta->total - $cantidad;
                                    $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                                    if ($update_total_reserva) {
                                        return response()->json(['success' => true, 'asignacion' => $id_asignacion, 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                }
                            }else{
                                return response()->json(['success' => false]);
                            }

                        }else{
                            /////no hay guias suficientes en el talonario para la solicitud
                            $i = 0; //////cuenta las guías asignadas 
                            $talonarios = [];
                            $url_talonarios = '';
                            // $x = 0; //////cuenta las iteraciones del bucle

                            ////////////SE HACE EL PRIMER REGISTRO DE LAS GUIAS PARA DESPUES PASAR AL BUCLE  
                            if ($c->asignado == 0) {
                                ////// todavia no se han asignado guías del talonario
                                $desde = $c->desde;
                                $hasta = $c->hasta;
                                
                                
                                $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                'id_talonario' => $c->id_talonario,
                                                                'id_asignacion_reserva' => $id_asignacion,
                                                                'desde' => $desde, 
                                                                'hasta' => $hasta]);
                                

                                if ($detalle_talonario) {
                                    $i = 50;
                                    $asignado = $c->asignado + $i;
                                    $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                }else{
                                    return response()->json(['success' => false]);
                                }
                                
                            }else{
                                ////// ya se han asignado guías del talonario
                                $detalle = DB::table('detalle_talonario_reservas')->select('hasta')->where('id_talonario','=',$c->id_talonario)->orderBy('correlativo', 'desc')->first();
                                if ($detalle) {
                                    $desde = $detalle->hasta + 1;
                                    $hasta = $c->hasta;
                                    
                                    $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                                'id_talonario' => $c->id_talonario,
                                                                'id_asignacion_reserva' => $id_asignacion,
                                                                'desde' => $desde, 
                                                                'hasta' => $hasta]);
                                    
                                    if ($detalle_talonario) {
                                        $i = ($hasta - $desde) + 1;
                                        $asignado = $c->asignado + $i;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]);
                                    }
                                }else{
                                    return response()->json(['success' => false]);
                                }
                            }

                            array_push($talonarios,$c->id_talonario);
                            // $url_talonarios = 'T'.$c->id_talonario;


                            do {
                                // $cant -> cantidad de guías solicitadas
                                // $guias_faltantes -> cantidad de guías solicitadas que faltan por asignarle correlattivo

                                $guias_faltantes = $cantidad - $i;
                                $c2 = DB::table('talonarios')->where('clase','=',6)->where('asignado','!=',50)->first(); 
                                if ($c2) {
                                    ////// todavia no se han asignado guías del talonario
                                    $desde = $c2->desde;
                                    $hasta = 0;
                                    if ($guias_faltantes <= 50) {
                                        $hasta = ($desde + $guias_faltantes) - 1;
                                    }else{
                                        $hasta = $c2->hasta;
                                    }

                                    $detalle_talonario = DB::table('detalle_talonario_reservas')->insert([
                                                        'id_talonario' => $c->id_talonario,
                                                        'id_asignacion_reserva' => $id_asignacion,
                                                        'desde' => $desde, 
                                                        'hasta' => $hasta]);
                                    
                                    if ($detalle_talonario) {
                                        $i = $i + (($hasta - $desde) + 1);  
                                        $asignado = $c2->asignado + $i;
                                        array_push($talonarios,$c2->id_talonario);
                                        // $url_talonarios .= '-'.$c2->id_talonario;
                                        $update_asignado = DB::table('talonarios')->where('id_talonario', '=', $c2->id_talonario)->update(['asignado' => $asignado]);
                                    }else{
                                        return response()->json(['success' => false]); 
                                    }                             
                                }else{
                                    return response()->json(['success' => false]); 
                                }
                                // $x++;
                            } while ($i == $cantidad);


                                
                            $user = auth()->id();
                            if ($tipo_sujeto == 'user') {
                                $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                            }else{
                                $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                            }
                            $accion = 'SOLICITUD DE GUÍAS PROVICIONALES NRO.'.$id_asignacion.' APROBADA, ID Talonario(s): '.$talonarios.', Contribuyente: '.$sp->razon_social;
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);

                            $total_guias_reserva = $consulta->total - $cantidad;
                            $update_total_reserva = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $total_guias_reserva]);
                            if ($update_total_reserva) {
                                return response()->json(['success' => true, 'asignacion' => $id_asignacion, 'sujeto' => $id_sujeto, 'tipo_sujeto' => $tipo_sujeto]);
                            }else{
                                return response()->json(['success' => false]);
                            }
        

                        }
                    }else{
                        return response()->json(['success' => false]);
                    }

                }else{
                    ////// NO HAY GUIAS SUFICIENTES PARA LA SOLICITUD
                    return response()->json(['success' => false, 'nota' => 'Disculpe, no hay suficientes Guías de Reserva disponibles.']);
                }
            }else{
                ////// NO HAY TALONARIOS DE RESERVA
                return response()->json(['success' => false, 'nota' => 'Disculpe, no ha emitido todavia talonarios de reserva para la asignación de guías provicionales.']);
            }
        }else{
            return response()->json(['success' => false]);
        }


    }



    public function guias(Request $request) {
        $id_asignacion = $request->post('asignacion');
        $id_sujeto = $request->post('sujeto');
        $tipo_sujeto = $request->post('tipo');

        // return response($id_asignacion.'-'.$id_sujeto.'-'.$tipo_sujeto);

        $li = '';
        $tab_pane = '';




        $correlativo = DB::table('detalle_talonario_reservas')->where('id_asignacion_reserva','=',$id_asignacion)->get();
        if ($correlativo) {
            $contador = 0;
            foreach ($correlativo as $c) {
                $desde = $c->desde;
                $hasta = $c->hasta;
                $buttons = '';
                for ($i=$desde; $i <= $hasta ; $i++) { 
                    $contador++;

                    //////////////////////////////////////////////////////////////////////////// CANTERAS
                    $opction_canteras = '';
                    if ($tipo_sujeto == 'user') {
                        $consulta_canteras =  DB::table('canteras')->select('id_cantera','nombre')
                                                                    ->where('id_sujeto','=',$id_sujeto)
                                                                    ->where('status','=','Verificada')->get();
                        foreach ($consulta_canteras as $cantera) {
                            $opction_canteras .= '<option  value="'.$cantera->id_cantera.'">'.$cantera->nombre.'</option>';
                        };
                        $html_canteras = '<div class="pt-4 px-3 d-flex ">
                                            <!-- cantera -->
                                            <div class="row g-3 align-items-center mb-2 w-50">
                                                <div class="col-3">
                                                    <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-select form-select-sm select_cantera" id="select_cantera_'.$i.'" name="cantera_'.$i.'" required>
                                                        '.$opction_canteras.'
                                                    </select>
                                                </div>
                                            </div>
                                        </div>';

                    }else{
                        $count_canteras =  DB::table('canteras_notusers')->selectRaw("count(*) as total")->where('id_sujeto_notuser','=',$id_sujeto)->first();
                        if ($count_canteras->total != 0) {
                            $consulta_canteras =  DB::table('canteras_notusers')->select('id_cantera_notuser','nombre')
                                                                    ->where('id_sujeto_notuser','=',$id_sujeto)->get();
                            foreach ($consulta_canteras as $cantera) {
                                $opction_canteras .= '<option  value="'.$cantera->id_cantera_notuser.'">'.$cantera->nombre.'</option>';
                            }
                            
                            $html_canteras = '<div class="pt-4 px-3 d-flex ">
                                                <!-- cantera -->
                                                <div class="row g-3 align-items-center mb-2 w-50">
                                                    <div class="col-3">
                                                        <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                    </div>
                                                    <div class="col-9">
                                                        <select class="form-select form-select-sm select_cantera" id="select_cantera_'.$i.'" guia="'.$i.'" name="cantera_'.$i.'" required>
                                                            '.$opction_canteras.'
                                                            <option class="otro" sujeto='.$id_sujeto.'" value="otro">Otro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center mx-5 px-5 py-3 my-4 flex-column bg-light rounded d-none" id="content_add_cantera_'.$i.'">
                                                <p class="fw-bold text-navy text-center mb-2 fs-6">Regitro de Cantera o Desazolve</p>
                                                <p class=""><span style="color:red">*</span>NOTA: Es necesario llenar el registro de la nueva Cantera o Desazolve para continuar con el proceso.</p>
                                                
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row g-3 mb-2">
                                                                <div class="col-4">
                                                                    <label for="nombre_nc_'.$i.'" class="col-form-label">Nombre: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="nombre_nc_'.$i.'" class="form-control form-control-sm" name="nombre" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row g-3 mb-2">
                                                                <div class="col-4">
                                                                    <label for="direccion_nc_'.$i.'" class="col-form-label">Lugar de aprovechamiento: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" id="direccion_nc_'.$i.'" class="form-control form-control-sm" name="direccion" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="municipio_nc_'.$i.'" class="col-form-label">Municipio: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <select class="form-select form-select-sm municipio" aria-label="Default select example" id="municipio_nc_'.$i.'" name="municipio">
                                                                        <option value="Bolívar">Bolívar</option>
                                                                        <option value="Camatagua">Camatagua</option>
                                                                        <option value="Francisco Linares Alcántara">Francisco Linares Alcántara</option>
                                                                        <option value="Girardot">Girardot</option>
                                                                        <option value="José Ángel Lamas">José Ángel Lamas</option>
                                                                        <option value="José Félix Ribas">José Félix Ribas</option>
                                                                        <option value="José Rafael Revenga">José Rafael Revenga</option>
                                                                        <option value="Libertador">Libertador</option>
                                                                        <option value="Mario Briceño Iragorry">Mario Briceño Iragorry</option>
                                                                        <option value="Ocumare de la Costa de Oro">Ocumare de la Costa de Oro</option>
                                                                        <option value="San Casimiro">San Casimiro</option>
                                                                        <option value="San Sebastián">San Sebastián</option>
                                                                        <option value="Santiago Mariño">Santiago Mariño</option>
                                                                        <option value="Santos Michelena">Santos Michelena</option>
                                                                        <option value="Sucre">Sucre</option>
                                                                        <option value="Tovar">Tovar</option>
                                                                        <option value="Urdaneta">Urdaneta</option>
                                                                        <option value="Zamora">Zamora </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="row g-3 align-items-center mb-2">
                                                                <div class="col-4">
                                                                    <label for="parroquia_nc_'.$i.'" class="col-form-label">Parroquia: <span style="color:red">*</span></label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <select class="form-select form-select-sm parroquia" aria-label="Default select example" id="parroquia_nc_'.$i.'" name="parroquia">
                                                                        <option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" id="id_sujeto_cantera" name="id_sujeto_cantera" value="'.$id_sujeto.'" required>
                                                    <p class="text-muted text-end me-4"><span style="color:red">*</span> Campos requeridos.</p> 

                                                    <div class="d-flex justify-content-center mt-3 mb-3">
                                                        <button type="button" class="btn btn-secondary btn-sm me-3 btn_cancel_add_cantera" guia="'.$i.'">Cancelar</button>
                                                        <a id="add_cantera" class="btn btn-success btn-sm" guia="'.$i.'">Guardar</a>
                                                    </div>
                                                
                                            </div>';
                        }else{
                            $html_canteras = '<div class="pt-4 px-3 d-flex ">
                                                    <!-- cantera -->
                                                    <div class="row g-3 align-items-center mb-2 w-50">
                                                        <div class="col-3">
                                                            <label for="" class="col-form-label">Cantera: <span style="color:red">*</span></label>
                                                        </div>
                                                        <div class="col-9">
                                                            <select class="form-select form-select-sm select_cantera" id="select_cantera_'.$i.'" name="cantera_'.$i.'" required>
                                                                '.$opction_canteras.'
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                    <div class="d-flex justify-content-center mx-5 px-5 py-3 my-4 flex-column bg-light rounded" id="content_add_cantera_'.$i.'">
                                        <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Cantero o Desazolve</p>
                                        <div class="row">
                                            <div class="col-lg-6 px-4">
                                                <div class="row g-3 mb-2">
                                                    <div class="col-4">
                                                        <label for="nombre_nc_'.$i.'" class="col-form-label">Nombre: <span style="color:red">*</span></label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" id="nombre_nc_'.$i.'" class="form-control form-control-sm" name="nombre_nc" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 px-4">
                                                <div class="row g-3 mb-2">
                                                    <div class="col-4">
                                                        <label for="direccion_nc_'.$i.'" class="col-form-label">Lugar de aprovechamiento: <span style="color:red">*</span></label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" id="direccion_nc_'.$i.'" class="form-control form-control-sm" name="direccion_nc" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 px-4">
                                                <div class="row g-3 align-items-center mb-2">
                                                    <div class="col-4">
                                                        <label for="municipio_nc_'.$i.'" class="col-form-label">Municipio: <span style="color:red">*</span></label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select class="form-select form-select-sm municipio" aria-label="Default select example" id="municipio_nc_'.$i.'" name="municipio_nc">
                                                            <option value="Bolívar">Bolívar</option>
                                                            <option value="Camatagua">Camatagua</option>
                                                            <option value="Francisco Linares Alcántara">Francisco Linares Alcántara</option>
                                                            <option value="Girardot">Girardot</option>
                                                            <option value="José Ángel Lamas">José Ángel Lamas</option>
                                                            <option value="José Félix Ribas">José Félix Ribas</option>
                                                            <option value="José Rafael Revenga">José Rafael Revenga</option>
                                                            <option value="Libertador">Libertador</option>
                                                            <option value="Mario Briceño Iragorry">Mario Briceño Iragorry</option>
                                                            <option value="Ocumare de la Costa de Oro">Ocumare de la Costa de Oro</option>
                                                            <option value="San Casimiro">San Casimiro</option>
                                                            <option value="San Sebastián">San Sebastián</option>
                                                            <option value="Santiago Mariño">Santiago Mariño</option>
                                                            <option value="Santos Michelena">Santos Michelena</option>
                                                            <option value="Sucre">Sucre</option>
                                                            <option value="Tovar">Tovar</option>
                                                            <option value="Urdaneta">Urdaneta</option>
                                                            <option value="Zamora">Zamora </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 px-4">
                                                <div class="row g-3 align-items-center mb-2">
                                                    <div class="col-4">
                                                        <label for="parroquia_nc_'.$i.'" class="col-form-label">Parroquia: <span style="color:red">*</span></label>
                                                    </div>
                                                    <div class="col-8">
                                                        <select class="form-select form-select-sm parroquia" aria-label="Default select example" id="parroquia_nc_'.$i.'" name="parroquia_nc">
                                                            <option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        

                                            <input type="hidden" id="id_sujeto_cantera" name="id_sujeto_cantera" value="'.$id_sujeto.'" required>
                                            <p class="text-muted text-end me-4"><span style="color:red">*</span> Campos requeridos.</p> 

                                            <div class="d-flex justify-content-center mt-3 mb-3">
                                                <button type="button" disabled class="btn btn-secondary btn-sm me-3 btn_cancel_add_cantera" guia="'.$i.'">Cancelar</button>
                                                <a id="add_cantera" class="btn btn-success btn-sm" guia="'.$i.'">Guardar</a>
                                            </div>
                                        </div>
                                    </div>';
                        }
                        
                    }
                    
                    ///////////////////////////////////////////////////
                    $li_items = '';
                    $tab_pane_items = ''; 
                    

                    if ($contador == 1) {
                        $li .= '<li class="nav-item" role="presentation">
                                <button class="nav-link nav-link-button active d-flex align-items-center" id="'.$i.'-tab" data-bs-toggle="pill" data-bs-target="#g'.$i.'-tab-pane" type="button" role="tab" aria-controls="'.$i.'-tab-pane" aria-selected="true" guia="'.$i.'">
                                    <i class="bx bx-tag bx-flip-horizontal me-2 fs-6" ></i>
                                    Guía '.$contador.'
                                </button>
                            </li>';
                        $tab_pane_items = 'show active';
                    }else{
                        $li .= '<li class="nav-item" role="presentation">
                                <button class="nav-link done nav-link-button d-flex align-items-center" id="'.$i.'-tab" data-bs-toggle="pill" data-bs-target="#g'.$i.'-tab-pane" type="button" role="tab" aria-controls="'.$i.'-tab-pane" aria-selected="false" guia="'.$i.'">
                                    <i class="bx bx-tag bx-flip-horizontal me-2 fs-6" ></i>
                                    Guía '.$contador.'
                                </button>
                            </li>';
                        $tab_pane_items = '';
                    }

                    if ($i == $hasta) {
                        $buttons = '<div class="d-flex justify-content-center mt-3 mb-3">
                                        <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" disabled>Cancelar</button>
                                        <button type="submit" class="btn btn-success btn-sm" id="guardar_asignacion" >Guardar Asignación</button>
                                    </div>';
                    }else{
                        $buttons = '';
                    }


                    $tab_pane .= '<div class="tab-pane fade '.$tab_pane_items.'" id="g'.$i.'-tab-pane" role="tabpanel" aria-labelledby="'.$i.'-tab" tabindex="0">
                                    <div class="row d-flex justify-content-between  px-3">
                                        <div class="col-sm-5">
                                        </div>

                                        <div class="col-sm-4 text-end fs-5 fw-bold text-muted">
                                            <span class="text-danger">Nro° Guía </span><span id="nro_guia_view">'.$i.'</span>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="nro_guia_'.$i.'" name="nro_guia_'.$i.'" value="'.$i.'" required> 

                                    '.$html_canteras.'

                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Destinatario</p>

                                    <div class="row">
                                        <div class="col-sm-4 px-4">
                                            <!-- razon social -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="razon" class="col-form-label">Razon social: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="razon" class="form-control form-control-sm razon_dest" name="razon_dest_'.$i.'" placeholder="Ejemplo: Razon Social, C.A." required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 px-4">
                                            <!-- rif del destinatario -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-3">
                                                    <label for="ci" class="col-form-label">R.I.F: </label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="rif_dest_'.$i.'" class="form-control form-control-sm ci_dest" name="rif_dest_'.$i.'" placeholder="Ejemplo: J00000000"  required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 px-4">
                                            <!-- telefono destinatario -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="tlf_dest" class="col-form-label">Telefono: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="tlf_dest" class="form-control form-control-sm tlf_dest" name="tlf_dest_'.$i.'" placeholder="Ejemplo: 0414-0000000" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 px-4">
                                            <!-- destino -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="municipio" class="col-form-label">Municipio: </label>
                                                </div>
                                                <div class="col-8">
                                                    <select class="form-select form-select-sm municipio_dest" aria-label="Default select example" id="municipio_'.$i.'" guia="'.$i.'" name="municipio_destino_'.$i.'" required>
                                                        <option value="Bolívar">Bolívar</option>
                                                        <option value="Camatagua">Camatagua</option>
                                                        <option value="Francisco Linares Alcántara">Francisco Linares Alcántara</option>
                                                        <option value="Girardot">Girardot</option>
                                                        <option value="José Ángel Lamas">José Ángel Lamas</option>
                                                        <option value="José Félix Ribas">José Félix Ribas</option>
                                                        <option value="José Rafael Revenga">José Rafael Revenga</option>
                                                        <option value="Libertador">Libertador</option>
                                                        <option value="Mario Briceño Iragorry">Mario Briceño Iragorry</option>
                                                        <option value="Ocumare de la Costa de Oro">Ocumare de la Costa de Oro</option>
                                                        <option value="San Casimiro">San Casimiro</option>
                                                        <option value="San Sebastián">San Sebastián</option>
                                                        <option value="Santiago Mariño">Santiago Mariño</option>
                                                        <option value="Santos Michelena">Santos Michelena</option>
                                                        <option value="Sucre">Sucre</option>
                                                        <option value="Tovar">Tovar</option>
                                                        <option value="Urdaneta">Urdaneta</option>
                                                        <option value="Zamora">Zamora </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 px-4">
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="parroquia" class="col-form-label">Parroquia:</label>
                                                </div>
                                                <div class="col-8">
                                                    <select class="form-select form-select-sm parroquia_dest" aria-label="Default select example" id="parroquia_'.$i.'" name="parroquia_destino_'.$i.'" required>
                                                        <option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 px-4">
                                            <div class="row align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="destino" class="col-form-label">Lugar de destino: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="destino" class="form-control form-control-sm destino" name="destino_'.$i.'" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de la Carga</p>

                                    <div class="row px-3 d-flex align-items-center">
                                        <div class="col-sm-6">
                                            <!-- mineral no metalico -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="mineral" class="col-form-label">Mineral: <span style="color:red">*</span></label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="mineral_'.$i.'" class="form-control form-control-sm mineral" name="mineral_'.$i.'" required novalidate>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- cantidad -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="cantidad" class="col-form-label">Cantidad: <span style="color:red">*</span></label>
                                                </div>
                                                <div class="col-4">
                                                    <select class="form-select form-select-sm unidad_medida" aria-label="Small select example" name="unidad_medida_'.$i.'" id="unidad_medida_'.$i.'" required>
                                                        <option value="Toneladas">Toneladas</option>
                                                        <option value="Metros cúbicos">Metros Cúbicos</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" step="0.01" id="cantidad_'.$i.'" class="form-control form-control-sm cantidad" name="cantidad_facturada_'.$i.'" placeholder="Cantidad" required novalidate>
                                                </div> 
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="row px-3 d-flex align-items-center">
                                        <!-- saldo anterior -->
                                        <div class="col-sm-4">
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="saldo_anterior" class="col-form-label">Saldo anterior: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" step="0.01" id="saldo_anterior" class="form-control form-control-sm saldo_anterior" name="saldo_anterior_'.$i.'" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Cantidad Despachada -->
                                        <div class="col-sm-4">
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="cantidad_despachada" class="col-form-label">Cantidad Despachada: <span style="color:red">*</span></label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" step="0.01" id="cantidad_despachada" class="form-control form-control-sm cantidad_despachada" name="cantidad_despachada_'.$i.'" placeholder="" required novalidate>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Saldo Restante -->
                                        <div class="col-sm-4">
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="saldo_restante" class="col-form-label">Saldo Restante: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" step="0.01" id="saldo_restante" class="form-control form-control-sm saldo_restante" name="saldo_restante_'.$i.'" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos del Transporte</p>

                                    <div class="row d-flex align-items-center">
                                        <div class="col-sm-6 px-4">
                                            <!-- modelo del vehiculo -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="modelo" class="col-form-label">Modelo Vehículo: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="modelo" class="form-control form-control-sm modelo" name="modelo_'.$i.'" placeholder="Ejemplo: Camion Plataforma Ford F-350">
                                                </div>
                                            </div>

                                            <!-- Nombre del conductor  -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="nombre_conductor" class="col-form-label">Nombre Conductor: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="nombre_conductor" class="form-control form-control-sm nombre_conductor" name="nombre_conductor_'.$i.'" placeholder="Ejemplo: Juan Castillo">
                                                </div>
                                            </div>

                                            <!-- telefono del conductor  -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="tlf_conductor" class="col-form-label">Teléfono Conductor: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="tlf_conductor" class="form-control form-control-sm tlf_conductor" name="tlf_conductor_'.$i.'" placeholder="Ejemplo: 04140000000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 px-4">
                                            <!-- placa -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="placa" class="col-form-label">Placa: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="placa" class="form-control form-control-sm placa" name="placa_'.$i.'" placeholder="Ejemplo: AB123CD">
                                                </div>
                                            </div>

                                            <!-- ci conductor -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="ci_conductor" class="col-form-label">C.I.: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="ci_conductor" class="form-control form-control-sm ci_conductor" name="ci_conductor_'.$i.'" placeholder="Ejemplo: V0000000">
                                                </div>
                                            </div>

                                            <!-- capacidad del vehiculo -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="capacidad_vehiculo" class="col-form-label">Capacidad del Vehículo: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="capacidad_vehiculo" class="form-control form-control-sm capacidad_vehiculo" name="capacidad_vehiculo_'.$i.'" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-center fw-bold py-2" style="font-size: 16px;color: #959595;">Datos de Circulación</p>
                                    
                                    <div class="row">
                                        <div class="col-sm-3 px-4">
                                            <!-- hora de Salida -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-4">
                                                    <label for="hora_salida" class="col-form-label">Hora de Salida: </label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" id="hora_salida" class="form-control form-control-sm hora_salida" name="hora_salida_'.$i.'" placeholder="Ejemplo: 5:30 AM">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 px-4">
                                            <!-- anulada -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-5">
                                                    <label for="" class="col-form-label">¿Anulada?: <span style="color:red">*</span></label>
                                                </div>
                                                <div class="col-7">
                                                    <div class="form-check form-check-inline ">
                                                        <input class="form-check-input anulada anulado_si" type="radio" name="anulada_'.$i.'" guia="'.$i.'" id="anulado_si" value="Si" required novalidate>
                                                        <label class="form-check-label" for="anulado_si">
                                                            Si
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input anulada anulado_no" type="radio" name="anulada_'.$i.'" guia="'.$i.'" id="anulado_no" value="No" required novalidate>
                                                        <label class="form-check-label" for="anulado_no">
                                                            No
                                                        </label>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-sm-6 px-4">
                                            <!-- motivo de anulacion -->
                                            <div class="row g-3 align-items-center mb-2">
                                                <div class="col-sm-4">
                                                    <label for="motivo_anulada" class="col-form-label">Motivo de la Anulación: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" id="motivo_anulada_'.$i.'" class="form-control form-control-sm motivo_anulada" name="motivo_'.$i.'" placeholder="Elemplo: Por tachaduras" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted text-end me-4"><span style="color:red">*</span> Campos requeridos.</p>
                                    '.$buttons.'
                                </div>
                                
                            ';
                    

                    
                }

                $html = '<div class="modal-header fs-5 text-navy fw-bold d-flex justify-content-between align-items-center px-4">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-collection me-2 text-muted fs-3"></i>
                                <span>Detalles de la Asignación</span>
                            </div>
                            <button type="button" class="btn-close fs-6" id="cerrar_asignacion" asignacion="'.$id_asignacion.'" delete="true"></button>
                        </div>
                        <div class="modal-body px-4" style="font-size:12.7px;">
                            <form id="form_registrar_guias" class="was-validated" method="post" onsubmit="event.preventDefault(); registrarGuias()">

                                <input type="hidden" name="asignacion" value="'.$id_asignacion.'">
                                <input type="hidden" name="sujeto" value="'.$id_sujeto.'">
                                <input type="hidden" name="tipo_sujeto" value="'.$tipo_sujeto.'">

                                <p class="text-center" style="font-size:14px;">
                                    <span class="fw-bold">
                                        <i class="bx bx-error-circle me-2"></i> 
                                        IMPORTANTE:
                                    </span> Para culminar la Asignacion de las Guías de Reserva deberá llenar los datos mínimos requeridos de las guías a asignar.
                                </p>
                                <!-- TABS GUIAS ASIGNADAS -->
                                <ul class="nav nav-pills d-flex justify-content-center" id="myTab" role="tablist" style="font-size:14px;">
                                    '.$li.'
                                </ul>
                                <!-- CONTENT TABS: GUIAS ASIGNADAS -->
                                <div>
                                    <div class="tab-content border rounded px-2 py-3 my-3 mt-4" id="myTabContent">
                                        '.$tab_pane.'  
                                    </div>

                                    
                                </div>
                            </form>
                        </div>';

                return response()->json(['success' => true, 'html' => $html]);
            }
        }else{
            return response()->json(['success' => false]);
        }
    }



    public function add_cantera(Request $request){
        $id_sujeto = $request->post('sujeto');
        $nombre = $request->post('nombre');
        $direccion = $request->post('direccion');
        $municipio = $request->post('municipio');
        $parroquia = $request->post('parroquia');
        
        if (empty($nombre) || empty($direccion) || empty($municipio) || empty($parroquia)) {
            return response()->json(['success' => false,'i' => 'empty']);
        }else{
            $insert = DB::table('canteras_notusers')->insert(['id_sujeto_notuser' => $id_sujeto,
                                                            'nombre' => $nombre, 
                                                            'municipio_cantera' => $municipio,
                                                            'parroquia_cantera' => $parroquia,
                                                            'lugar_aprovechamiento' => $direccion
                                                        ]);

            
            if ($insert) {
                $id_cantera = DB::table('canteras_notusers')->max('id_cantera_notuser');
                return response()->json(['success' => true, 'cantera' => $id_cantera, 'nombre' => $nombre]);
            }else{
                return response()->json(['success' => false, 'i' => 'error']);
            }
        }

    }



    public function registro_guias(Request $request){
        $id_asignacion = $request->post('asignacion');
        $id_sujeto = $request->post('sujeto');
        $tipo_sujeto = $request->post('tipo_sujeto');
        // return response($id_asignacion.'/'.$id_sujeto.'/'.$tipo_sujeto);
        $user = auth()->id();


        if (empty($id_asignacion) ||  empty($id_sujeto) ||  empty($tipo_sujeto)) {
            return response()->json(['success' => false]);
        }else{
            $correlativo = DB::table('detalle_talonario_reservas')->where('id_asignacion_reserva','=',$id_asignacion)->get();
            if ($correlativo) {
                foreach ($correlativo as $c) {
                    $desde = $c->desde; 
                    $hasta = $c->hasta;
                    if ($tipo_sujeto == 'user') {
                         /////////////////////////////////////////////CONTRIBUYENTE REGISTRADO EN LA PLATAFORMA (USER)
                        for ($i=$desde; $i <= $hasta ; $i++) {
                            $detalle = DB::table('detalle_asignacions')->insert([
                                                            'id_asignacion' => $id_asignacion,
                                                            'id_cantera'=> $request->post('cantera_'.$i), 
                                                            'id_cantera_notuser'=> null, 
                                                            'nro_guia' => $i, 
                                                            'razon_destinatario' => $request->post('razon_dest_'.$i),
                                                            'rif_destinatario' => $request->post('rif_dest_'.$i),
                                                            'tlf_destinatario' => $request->post('tlf_dest_'.$i),
                                                            'municipio_destino' => $request->post('municipio_destino_'.$i),
                                                            'parroquia_destino' => $request->post('parroquia_destino_'.$i),
                                                            'destino' => $request->post('destino_'.$i),
                                                            'mineral' => $request->post('mineral_'.$i),
                                                            'unidad_medida' => $request->post('unidad_medida_'.$i),
                                                            'cantidad' => $request->post('cantidad_facturada_'.$i),
                                                            'saldo_anterior' => $request->post('saldo_anterior_'.$i),
                                                            'cantidad_despachada' => $request->post('cantidad_despachada_'.$i),
                                                            'saldo_restante' => $request->post('saldo_restante_'.$i),
                                                            'modelo_vehiculo' => $request->post('modelo_vehiculo_'.$i),
                                                            'placa' => $request->post('placa_'.$i),
                                                            'nombre_conductor' => $request->post('nombre_conductor_'.$i),
                                                            'ci_conductor' => $request->post('ci_conductor_'.$i),
                                                            'tlf_conductor' => $request->post('tlf_conductor_'.$i),
                                                            'capacidad_vehiculo' => $request->post('capacidad_vehiculo_'.$i),
                                                            'hora_salida' => $request->post('hora_salida_'.$i),
                                                            'anulada' => $request->post('anulada_'.$i),
                                                            'motivo' => $request->post('motivo_'.$i)
                            ]);

                            if ($detalle) {
                                
                                $id_detalle= DB::table('detalle_asignacions')->max('id_detalle_asignacion');
                                $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrGR/?id='.$i.'';
                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_R'.$i.'.png'));
                                $update_qr = DB::table('detalle_asignacions')->where('id_detalle_asignacion', '=', $id_detalle)->update(['qr' => 'assets/qr/qrcode_R'.$i.'.png']);
                            }else{
                                return response()->json(['success' => false]);
                            }
                            
                        }////cierra for

                          
                        $sp =  DB::table('sujeto_pasivos')->select('razon_social')->where('id_sujeto','=',$id_sujeto)->first(); 
                        $accion = 'GUÍAS DE RESERVA ASIGNADAS - NRO. DE ASIGNACIÓN: '.$id_asignacion.', DESDE: '.$desde.', HASTA: '.$hasta.', CONTRIBUYENTE: '.$sp->razon_social;
                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                    
                        return response()->json(['success' => true]);

                    }else{
                        /////////////////////////////////////////////CONTRIBUYENTE NO REGISTRADO EN LA PLATAFORMA (NOTUSER)
                        for ($i=$desde; $i <= $hasta ; $i++) {
                            $detalle = DB::table('detalle_asignacions')->insert([
                                                            'id_asignacion' => $id_asignacion,
                                                            'id_cantera'=> null, 
                                                            'id_cantera_notuser'=> $request->post('cantera_'.$i), 
                                                            'nro_guia' => $i, 
                                                            'razon_destinatario' => $request->post('razon_dest_'.$i),
                                                            'rif_destinatario' => $request->post('rif_dest_'.$i),
                                                            'tlf_destinatario' => $request->post('tlf_dest_'.$i),
                                                            'municipio_destino' => $request->post('municipio_destino_'.$i),
                                                            'parroquia_destino' => $request->post('parroquia_destino_'.$i),
                                                            'destino' => $request->post('destino_'.$i),
                                                            'mineral' => $request->post('mineral_'.$i),
                                                            'unidad_medida' => $request->post('unidad_medida_'.$i),
                                                            'cantidad' => $request->post('cantidad_facturada_'.$i),
                                                            'saldo_anterior' => $request->post('saldo_anterior_'.$i),
                                                            'cantidad_despachada' => $request->post('cantidad_despachada_'.$i),
                                                            'saldo_restante' => $request->post('saldo_restante_'.$i),
                                                            'modelo_vehiculo' => $request->post('modelo_vehiculo_'.$i),
                                                            'placa' => $request->post('placa_'.$i),
                                                            'nombre_conductor' => $request->post('nombre_conductor_'.$i),
                                                            'ci_conductor' => $request->post('ci_conductor_'.$i),
                                                            'tlf_conductor' => $request->post('tlf_conductor_'.$i),
                                                            'capacidad_vehiculo' => $request->post('capacidad_vehiculo_'.$i),
                                                            'hora_salida' => $request->post('hora_salida_'.$i),
                                                            'anulada' => $request->post('anulada_'.$i),
                                                            'motivo' => $request->post('motivo_'.$i)
                            ]);
                            if ($detalle) {
                                $id_detalle= DB::table('detalle_asignacions')->max('id_detalle_asignacion');
                                $url = 'https://mineralesnometalicos.tributosaragua.com.ve/qrGR/?id='.$i.'';
                                QrCode::format('png')->size(180)->eye('circle')->generate($url, public_path('assets/qr/qrcode_R'.$i.'.png'));
                                $update_qr = DB::table('detalle_asignacions')->where('id_detalle_asignacion', '=', $id_detalle)->update(['qr' => 'assets/qr/qrcode_R'.$i.'.png']);
  
                            }else{
                                return response()->json(['success' => false]);
                            } 
                        } ////cierra for
                        
                        $sp =  DB::table('sujeto_notusers')->select('razon_social')->where('id_sujeto_notuser','=',$id_sujeto)->first(); 
                        $accion = 'GUÍAS DE RESERVA ASIGNADAS - NRO. DE ASIGNACIÓN: '.$id_asignacion.', DESDE: '.$desde.', HASTA: '.$hasta.', CONTRIBUYENTE (NO REGISTRADO EN LA PLATAFORMA): '.$sp->razon_social;
                        $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 24, 'accion'=> $accion]);
                    
                        return response()->json(['success' => true]);
                        
                    }
                    
                } ////cierra foreach
            }else{
                return response()->json(['success' => false]);
            }
        }

        

    }



    public function cerrar(Request $request){
        $id_asignacion = $request->post('asignacion');
        // return response($id_asignacion);
        $query =  DB::table('asignacion_reservas')->select('contribuyente','cantidad_guias','soporte')->where('id_asignacion', '=', $id_asignacion)->first(); 
        $contribuyente = $query->contribuyente;
        $cantidad = $query->cantidad_guias; 
        $soporte = public_path($query->soporte);  
        $id_sujeto = '';
        $tipo_sujeto = '';

        if ($contribuyente == 27) {
            //////registrado
            $tipo_sujeto = 'user';
        }else{
            //////no registrado
            $query_2 =  DB::table('asignacion_reservas')->select('id_sujeto_notuser')->where('id_asignacion', '=', $id_asignacion)->first(); 
            $id_sujeto = $query_2->id_sujeto_notuser;
            $tipo_sujeto = 'notuser';
        }
        
        $delete_asignacion = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->delete();

        $consulta = DB::table('total_guias_reservas')->select('total')->where('correlativo', '=', 1)->first();
        $total = $consulta->total;
        $new_total = $total + $cantidad;
        $retribucion = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $new_total]);

        if ($delete_asignacion && $retribucion) {
            /////////////////// ELIMINAR OFICIO
            unlink($soporte);

            if ($tipo_sujeto == 'notuser') {
                $consulta =  DB::table('asignacion_reservas')->selectRaw("count(*) as total")->where('id_sujeto_notuser','=',$id_sujeto)->first(); 

                if ($consulta->total == 0) {
                    /////////no hay mas registros de asignaciones con este sujeto notuser, por lo tanto se borra el registro
                    $delete_notuser = DB::table('sujeto_notusers')->where('id_sujeto_notuser', '=', $id_sujeto)->delete();
                }
            }

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
        

    }
   


    public function delete(Request $request){
        $id_asignacion = $request->post('asignacion');
        
        $query =  DB::table('asignacion_reservas')->select('contribuyente','cantidad_guias','soporte')->where('id_asignacion','=', $id_asignacion)->first(); 
        $contribuyente = $query->contribuyente;
        $cantidad = $query->cantidad_guias; 
        $soporte = public_path($query->soporte); 
        $id_sujeto = '';
        $tipo_sujeto = '';

        if ($contribuyente == 27) {
            //////registrado
            $tipo_sujeto = 'user';
        }else{
            //////no registrado
            $query_2 =  DB::table('asignacion_reservas')->select('id_sujeto_notuser')->where('id_asignacion', '=', $id_asignacion)->first(); 
            $id_sujeto = $query_2->id_sujeto_notuser;
            $tipo_sujeto = 'notuser';
        }
        
        ////////////////////ELIMINAR QR'S(IMAGENES)
        $c =  DB::table('detalle_talonario_reservas')->select('desde','hasta')->where('id_asignacion_reserva', '=', $id_asignacion)->first(); 
        // return response($query_3);c
        for($i=$c->desde; $i <= $c->hasta; $i++) { 
            $ruta = public_path('assets/qr/qrcode_R'.$i.'.png');
            unlink($ruta);
        }  

        /////////////////// ELIMINAR ASIGNACION
        $delete_asignacion = DB::table('asignacion_reservas')->where('id_asignacion', '=', $id_asignacion)->delete();

        $consulta1 = DB::table('total_guias_reservas')->select('total')->where('correlativo', '=', 1)->first();
        $total = $consulta1->total;
        $new_total = $total + $cantidad;
        $retribucion = DB::table('total_guias_reservas')->where('correlativo', '=', 1)->update(['total' => $new_total]);

        /////////////////// ELIMINAR SUJETO (NOTUSER) SI NO TIENE MAS REGISTROS
        if ($delete_asignacion && $retribucion) {
            /////////////////// ELIMINAR OFICIO
            unlink($soporte);

            if ($tipo_sujeto == 'notuser') {
                $consulta =  DB::table('asignacion_reservas')->selectRaw("count(*) as total")->where('id_sujeto_notuser','=',$id_sujeto)->first(); 

                if ($consulta->total == 0) {
                    /////////no hay mas registros de asignaciones con este sujeto notuser, por lo tanto se borra el registro
                    $delete_notuser = DB::table('sujeto_notusers')->where('id_sujeto_notuser', '=', $id_sujeto)->delete();
                }
            }


            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
        

    }




    public function correlativo(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
       

        $detalle = DB::table('detalle_talonarios')->select('desde','hasta')->where('id_solicitud_reserva','=',$id_asignacion)->first();
       
        if ($detalle) {
            $desde = $detalle->desde;
            $hasta = $detalle->hasta;
            $length = 6;
            $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
            $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

     $asignacion = DB::table('asignacion_reservas')->select('cantidad_guias')->where('id_asignacion','=',$id_asignacion)->first();
            $cantidad = $asignacion->cantidad_guias;
        
       

            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                            <i class="bx bx-check-circle bx-tada fs-1" style="color:#076b0c" ></i>                   
                                <h1 class="modal-title text-navy fs-5" id="exampleModalLabel">CORRELATIVO</h1>
                                <span class="fs-6 text-muted">Guía(s) Asignadas</span>
                            </div>
                        </div>
                        <div class="modal-body" style="font-size:14px">
                            <p class="text-center" style="font-size:14px">El correlativo correspondiente a la asignación de Guías es el siguiente:</p>
                                <div class="row d-flex align-items-center px-5">
                                    <div class="col-sm-12">
                                        <table class="table mt-2 mb-3">
                                            <tr>
                                                <th>No. de Guías:</th>
                                                <td>'.$cantidad.' Guías</td>
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
                                </div>
                            <div class="d-flex justify-content-center">
                                <button  class="btn btn-secondary btn-sm " id="cerrar_info_correlativo_reserva" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>';
            return response($html);
        }

    }

    

    public function detalle(Request $request)
    {
        $id_asignacion = $request->post('asignacion');
        $tipo = $request->post('tipo');

        $razon_social = '';
        $rif = '';
        $nombre_cantera = '';
        $direccion_cantera = '';
        $registro = '';

        $tr_correlativo = '';
        $tr_canteras = '';
        
        $query = DB::table('asignacion_reservas')->where('id_asignacion','=',$id_asignacion)->first();
        if ($query) {
            $emision = $query->fecha_emision;
            $guias = $query->cantidad_guias;
            $soporte = $query->soporte;
            $entrega = $query->fecha_entrega;
            $tr_entrega = '';

            if ($entrega == null) {
                $tr_entrega = '';
            }else{
               $tr_entrega = '<tr>
                                <th>Fecha de entrega</th>
                                <td></td>
                            </tr>';
            }

            //////////////////////////////////////////////////////////////////////////////////////////////////////
            $correlativo = DB::table('detalle_talonario_reservas')->select('id_talonario','desde','hasta')->where('id_asignacion_reserva','=',$id_asignacion)->get();
            foreach ($correlativo as $c) {
                $desde = $c->desde;
                $hasta = $c->hasta;
                $length = 6;
                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);

               $tr_correlativo .= '<tr class="text-center">
                                    <td>'.$c->id_talonario.'</td>
                                    <td>'.$formato_desde.'</td>
                                    <td>'.$formato_hasta.'</td>
                                </tr>';
            }
            
           
            ////////////////////////////////////////////////////////////////////////////////////////
            if ($tipo == 27) {
                ///REGISTRADO
                $sujeto = DB::table('sujeto_pasivos')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto','=',$query->id_sujeto)->first();
                $razon_social = $sujeto->razon_social;
                $rif = $sujeto->rif_condicion.'-'.$sujeto->rif_nro;
                $registro = '<span class="badge bg-primary-subtle text-primary-emphasis ms-2">Registrado</span>';

                $detalle_canteras = DB::table('detalle_asignacions')->select('nro_guia','id_cantera')->where('id_asignacion','=',$id_asignacion)->get();
                foreach ($detalle_canteras as $dc) {
                    $cantera = DB::table('canteras')->select('nombre')->where('id_cantera','=',$dc->id_cantera)->first();
                    $nombre_cantera = $cantera->nombre;

                    $tr_canteras .= '<tr class="text-center">
                                        <td>'.$dc->nro_guia.'</td>
                                        <td colspan="2">'.$nombre_cantera.'</td>
                                    </tr>';
                }
                
                
            }else{
                /// NO REGISTRADO
                $sujeto = DB::table('sujeto_notusers')->select('razon_social','rif_condicion','rif_nro')->where('id_sujeto_notuser','=',$query->id_sujeto_notuser)->first();
                $razon_social = $sujeto->razon_social;
                $rif = $sujeto->rif_condicion.'-'.$sujeto->rif_nro;
                $registro = '<span class="badge bg-secondary-subtle text-secondary-emphasis ms-2">Registado mediante Asignaciones</span>';

                $detalle_canteras = DB::table('detalle_asignacions')->select('nro_guia','id_cantera_notuser')->where('id_asignacion','=',$id_asignacion)->get();
                foreach ($detalle_canteras as $dc){
                    $cantera = DB::table('canteras_notusers')->select('nombre')->where('id_cantera_notuser','=',$dc->id_cantera_notuser)->first();
                    $nombre_cantera = $cantera->nombre;

                    $tr_canteras .= '<tr class="text-center">
                                        <td>'.$dc->nro_guia.'</td>
                                        <td colspan="2">'.$nombre_cantera.'</td>
                                    </tr>';
                }
                
            }



            $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                        <div class="text-center">
                            <i class="bx bx-detail fs-1 text-secondary"></i>
                            <h1 class="modal-title fs-5 fw-bold text-navy" id="" >Detalles de la Asignación</h1>
                        </div>
                    </div>
                    <div class="modal-body" style="font-size:13px;">
                        <div class="d-flex justify-content-center mt-2">
                            <table class="table w-75 ">
                                <tr>
                                    <th>ID</th>
                                    <td class="text-secondary" colspan="2">'.$query->id_asignacion.'</td>
                                </tr>
                                <tr>
                                    <th>Emisión</th>
                                    <td colspan="2">'.$emision.'</td>
                                </tr>
                                <tr>
                                    <th>Contribuyente</th>
                                    <td colspan="2">
                                        <div class="d-flex flex-column">
                                            <span class="text-navy fw-bold">'.$razon_social.'
                                                '.$registro.'
                                            </span>
                                            <span class="text-secondary">'.$rif.'</span>  
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <th>Guías solicitadas</th>
                                    <td class="text-navy fw-bold" colspan="2">'.$guias.' Guías</td>
                                </tr>
                                <tr>
                                    <th>Oficio</th>
                                    <td colspan="2">
                                        <a target="_blank" class="ver_pago" href="'.asset($soporte).'">Ver</a>
                                    </td>
                                </tr>
                                '.$tr_entrega.'
                                <tr class="text-center">
                                    <th colspan="3" class="text-muted">
                                        Correlativo
                                    </th>
                                </tr>
                                <tr class="text-center">
                                    <th>No. Talonario</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                '.$tr_correlativo.'
                                <tr class="text-center">
                                    <th colspan="3" class="text-muted">
                                        Cantera o Desazolve
                                    </th>
                                </tr>
                                <tr class="text-center">
                                    <th>Nro. Guía</th>
                                    <th colspan="2">Nombre</th>
                                </tr>
                                '.$tr_canteras.'
                            </table>
                        </div>

                        <div class="d-flex justify-content-center my-2">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Salir</button>
                        </div>
                    </div>';

            return response($html);
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
