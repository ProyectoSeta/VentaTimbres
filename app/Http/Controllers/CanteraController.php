<?php

namespace App\Http\Controllers;
// use App\Models\Users;
use App\Models\User;
use App\Models\Cantera;
use App\Models\Mineral;
use App\Models\SujetoPasivo;
use App\Models\Produccion;
use Illuminate\Http\Request;
use DB;

class CanteraController extends Controller
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
       
        // $sp = SujetoPasivo::select('id_sujeto')->find($user);
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;
        $canteras = DB::table('canteras')->where('id_sujeto','=', $id_sp)->get();

       return view('cantera', compact('canteras'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_new()
    {
        $html = '';
        $cols = '';

        $minerales = DB::table('minerals')->get();
        if ($minerales) {
            foreach ($minerales as $m) {
                $cols .=   '<div class="col form-check">
                                <input class="form-check-input" type="checkbox" name="mineral[]" value="'.$m->mineral.'" id="'.$m->id_mineral.'">
                                <label class="form-check-label" for="'.$m->id_mineral.'">
                                    '.$m->mineral.'
                                </label>
                            </div>';
            }

            $html = '<div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel">
                            <i class="bx bx-plus fw-bold fs-3 pe-2 text-muted "></i>
                            <span class="text-navy fw-bold">Registro de Cantera o Desazolve</span>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size:14px;">
                        <form id="form_new_cantera" method="post" onsubmit="event.preventDefault(); newCantera()" class="p-3">
                            <!-- nombre cantera -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-2">
                                    <label for="" class="col-form-label">Nombre<span style="color:red">*</span></label>
                                </div>
                                <div class="col-10">
                                    <input type="text" id="" class="form-control form-control-sm" name="nombre" >
                                </div>
                            </div>
                            <!-- municipio y parroqui cantera -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-sm-2">
                                    <label for="municipio" class="col-form-label">Municipio<span style="color:red">*</span></label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-select form-select-sm" aria-label="Default select example" id="municipio" name="municipio">
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

                                <div class="col-sm-2">
                                    <label for="parroquia" class="col-form-label">Parroquia<span style="color:red">*</span></label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-select form-select-sm" aria-label="Default select example" id="parroquia" name="parroquia">
                                        <option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>
                                    </select>
                                </div>
                            </div>
                            <!-- direccion cantera -->
                            <div class="row g-3 align-items-center mb-2">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Lugar de Aprovechamiento<span style="color:red">*</span></label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="" class="form-control form-control-sm" name="direccion" >
                                </div>
                            </div>
                            <!-- produccion cantera -->
                            <div class="row col-12">
                                    <label for="" class="col-form-label ps-1 pb-3">Producción<span style="color:red">*</span></label>
                                </div>
                            <div class="row g-3 align-items-center mb-2">
                                
                                <div class="col-12">
                                    <div class="row row-cols-sm-3 px-3">
                                        '.$cols.'
                                    </div> <!-- cierra .row  -->

                                    <div class="row pt-3">
                                        <div class="col-sm-9">
                                            <div class="form-check ps-0">
                                                <label class="form-check-label fw-bold" >
                                                    Otro(s)
                                                </label>
                                            </div>
                                            <div class="mb-2 otros_minerales">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input class="form-control form-control-sm" type="text" name="mineral[]">
                                                    </div>
                                                    <div class="col-2">
                                                        <a  href="javascript:void(0);" class="btn add_button">
                                                            <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                        </a>
                                                    </div>
                                                </div>         
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- cierra .col-9 produccion -->
                        </div>  <!-- cierra .row produccion -->
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                            <div class="d-flex justify-content-center mt-3 mb-3" >
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                            </div>
                        </form>
                    </div>';

            return response($html);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto', 'estado')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $nombre = $request->post('nombre');
        $municipio = $request->post('municipio');
        $parroquia = $request->post('parroquia');
        $direccion = $request->post('direccion');

        switch ($sp->estado) {
            case 'Verificado':
                $cantera = DB::table('canteras')->insert([
                                        'id_sujeto' =>  $id_sp,
                                        'nombre' => $nombre,
                                        'municipio_cantera' => $municipio,
                                        'parroquia_cantera' => $parroquia,
                                        'lugar_aprovechamiento' => $direccion,
                                        'status' => 'Verificando']);
                if($cantera){
                    $id_cantera = DB::table('canteras')->max('id_cantera');
                
                    $minerales = $request->post('mineral');
                    foreach($minerales as $mineral){
                        if($mineral != null){
                            $id_min = '';
                            $query_min = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();

                            if(count($query_min) > 0 ){
                                foreach ($query_min as $min) {
                    
                                    $id_min = $min->id_mineral;

                                }
                            }else{
                                ///el mineral NO existe en la tabla minerals
                                $new_min = DB::table('minerals')->insert(['mineral' => $mineral]);
                                if ($new_min) {
                                    $query_new = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();
                                    foreach ($query_new as $new) {
                    
                                        $id_min = $new->id_mineral;
            
                                    }
                                }

                            }
                            // var_dump($id_min);
                            $produccions = DB::table('produccions')->insert(['id_cantera' => $id_cantera,'id_mineral' => $id_min]);
                            
                        } /////cierra if ($mineral != null)
                    }//////cierra foreach
                    return response()->json(['success' => true]);
                } ///cierra if($cantera)
                else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, ha ocurrido un error al registrar la Cantera.']);
                } 

                break;
            case 'Verificando':
                return response()->json(['success' => false, 'nota' => 'Disculpe, para poder registar la(s) Cantera(s) necesita estar verificado previamente.']);
                break;
            case 'Rechazado':
                $motivo = DB::table('sujeto_pasivos')->select('observaciones')->where('id_sujeto','=',$id_sp)->first();
                if ($motivo) {
                    $obv = $motivo->observaciones;
                    return response()->json(['success' => false, 'nota' => 'Rachazado', 'obv' => $obv]);
                }
                
                break;
            
            default:
                # code...
                break;
        }

        
         
         
    }

    /**
     * Display the specified resource.
     */

    public function minerales(Request $request)
    {
        $idCantera = $request->post('cantera');
        $query = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
         
        if($query){
            $produccion = '';
            foreach ($query as $id_min) {
                $id = $id_min->id_mineral;
                $query_min = DB::table('minerals')->select('mineral')->where('id_mineral','=',$id)->get();
                if($query_min){
                    foreach ($query_min as $mineral) {
                        $name_mineral = $mineral->mineral;
                        $produccion .= '<span>'.$name_mineral.'</span>';
                    }
                } 
            }
            $name = DB::table('canteras')->select('nombre')->where('id_cantera','=',$idCantera)->first();
            if ($name) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                                <div class="text-center">
                                    <i class="bx bxs-hard-hat fs-2" style="color:#ff8f00"></i>
                                    <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel"> Producción de la Cantera</h1>
                                    <h1 class="modal-title fs-6 px-2 fw-bold" id="exampleModalLabel">'.$name->nombre.'</h1>
                                </div>
                                
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            </div>
                            <div class="modal-body" style="font-size:15px;">
                                <div class="d-flex flex-column text-center py-2" >
                                    '.$produccion.'
                                </div>
                            </div>';
            }

            return response($html);

        }
    }

    
    public function info_denegada(Request $request){
        $idCantera = $request->post('cantera');
        $query = DB::table('canteras')->select('observaciones')->where('id_cantera','=',$idCantera)->get();

        if ($query) {
            $html='';
            foreach ($query as $c) {
                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307" ></i>
                                <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p class=" text-center text-muted">OBSERVACIÓN DE LA DENEGACIÓN</p>
                            <p class="mx-3 mt-1">'.$c->observaciones.'</p>

                            <div class="mt-3 mb-2">
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                    </span>Las <span class="fw-bold">Observaciones </span>
                                    realizadas cumplen con el objetivo de notificarle
                                    del porque la Cantera no fue verificada. Para que así, pueda rectificar y cumplir con el deber formal.
                                </p>
                            </div>
                        </div>';

            }
            return response($html);
        }
    }


    public function info_limite(Request $request){
        $idCantera = $request->post('cantera');
        $query = DB::table('limite_guias')->select('total_guias_periodo')->where('id_cantera','=',$idCantera)->first();

        if ($query) {
            $html='';

                $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                            <div class="text-center">
                                <i class="bx bx-show-alt fs-1 text-muted mb-0 pb-0"></i>
                                <h1 class="modal-title fs-5 text-navy fw-bold mt-0 pt-0" id="exampleModalLabel"> Información</h1>
                            </div>
                        </div>
                        <div class="modal-body">
                            <p class=" text-center mb-0 pb-0 fw-bold fs-6">LÍMITE DE GUÍAS A SOLICITAR CADA TRES (3) MESES</p>
                            <p class="mx-3 text-center text-navy fw-bold">'.$query->total_guias_periodo.' Guías</p>

                            <p class=" text-center fw-bold fs-6 mb-0 pb-0">PERÍODO ACTUAL</p>
                            <div class="row text-center">
                                <div class="col-sm-6">
                                    <span>Inicio: </span>
                                    <span class="fw-bold text-navy">2024-02-24</span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="">Fin del período: </span>
                                    <span class="text-success fw-bold">2024-05-24</span>
                                </div>
                            </div>

                            <div class="mt-3 mb-2">
                                
                                <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Observaciones:
                                    </span> Cada cantera cuenta con un límite de guías a solicitar unico, el cual se renovará cada tres (3) meses. 
                                    Una vez, superado el Límite establecido no podrá realizar una nueva solicitud hasta haber transcurrido 
                                    el período de tiempo de tres (3) meses.
                                    
                                </p>
                            </div>
                        </div>';

            return response($html);
        }

    }




    public function modal_edit(Request $request){

        $idCantera = $request->post('cantera');
        $produccion = [];
        $cols = '';
        $html = '';

        $query = DB::table('produccions')->select('id_mineral')->where('id_cantera','=',$idCantera)->get();
        if ($query) {
            ////////////////////////PRODUCCIÓN
            foreach ($query as $id_min) {
                $id = $id_min->id_mineral; 
                array_push($produccion, $id);    
            }

            ///////////////////////COLS: MINERALES
            $minerales = DB::table('minerals')->get();
            if ($minerales) {
                foreach ($minerales as $m) {

                    if(in_array($m->id_mineral,$produccion)){ 
                        $check = 'checked="checked" disabled';
                    }else{
                        $check = '';
                    }
                    $cols .=   '<div class="col form-check">
                                    <input class="form-check-input" type="checkbox" name="mineral[]" value="'.$m->mineral.'" id="'.$m->id_mineral.'" '.$check.'>
                                    <label class="form-check-label" for="'.$m->id_mineral.'">
                                        '.$m->mineral.'
                                    </label>
                                </div>';
                }
            }

            /////////////////////DATOS CANTERA
            $cantera = DB::table('canteras')->where('id_cantera','=',$idCantera)->first();
            if ($cantera) {
                $html = '<div class="modal-header">
                            <h1 class="modal-title fs-5 text-navy d-flex align-items-center" id="exampleModalLabel">
                                
                                <i class="bx bx-pencil fw-bold text-muted fs-3 pe-2"></i>
                                <span class="text-navy fw-bold">Editar Cantera</span>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size:14px;">
                            <form id="form_edit_cantera" method="post" onsubmit="event.preventDefault(); editCantera()" class="p-3">
                                <!-- nombre cantera -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-2">
                                        <label for="" class="col-form-label">Nombre<span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" id="" class="form-control form-control-sm" name="nombre" value="'.$cantera->nombre.'">
                                    </div>
                                </div>
                                <!-- municipio y parroqui cantera -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-sm-2">
                                        <label for="municipio" class="col-form-label">Municipio<span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-select form-select-sm" aria-label="Default select example" id="municipio" name="municipio">
                                            <option value="'.$cantera->municipio_cantera.'">'.$cantera->municipio_cantera.'</option>    
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

                                    <div class="col-sm-2">
                                        <label for="parroquia" class="col-form-label">Parroquia<span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select class="form-select form-select-sm" aria-label="Default select example" id="parroquia" name="parroquia">
                                            <option value="'.$cantera->parroquia_cantera.'">'.$cantera->parroquia_cantera.'</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- direccion cantera -->
                                <div class="row g-3 align-items-center mb-2">
                                    <div class="col-sm-3">
                                        <label for="" class="col-form-label">Lugar de Aprovechamiento<span style="color:red">*</span></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="" class="form-control form-control-sm" name="direccion" value="'.$cantera->lugar_aprovechamiento.'">
                                    </div>
                                </div>
                                <!-- produccion cantera -->
                                <div class="row col-12">
                                        <label for="" class="col-form-label ps-1 pb-3">Producción<span style="color:red">*</span></label>
                                    </div>
                                <div class="row g-3 align-items-center mb-2">
                                    
                                    <div class="col-12">
                                        <div class="row row-cols-sm-3 px-3">
                                            '.$cols.'
                                        </div> <!-- cierra .row  -->

                                        <div class="row pt-3">
                                            <div class="col-sm-9">
                                                <div class="form-check ps-0">
                                                    <label class="form-check-label fw-bold" >
                                                        Otro(s)
                                                    </label>
                                                </div>
                                                <div class="mb-2 otros_minerales">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <input class="form-control form-control-sm" type="text" name="mineral[]">
                                                        </div>
                                                        <div class="col-2">
                                                            <a  href="javascript:void(0);" class="btn add_button">
                                                                <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                                            </a>
                                                        </div>
                                                    </div>         
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- cierra .col-9 produccion -->
                                </div>  <!-- cierra .row produccion -->
                                <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                                <input type="hidden" name="id_cantera" value="'.$cantera->id_cantera.'">

                                <div class="d-flex justify-content-center mt-3 mb-3" >
                                    <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                </div>
                            </form>
                        </div>';
                return response($html);
            }

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar(Request $request)
    {
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto', 'estado')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $idCantera = $request->post('id_cantera');
        $nombre = $request->post('nombre');
        $municipio = $request->post('municipio');
        $parroquia = $request->post('parroquia');
        $direccion = $request->post('direccion');


        switch ($sp->estado) {
            case 'Verificado':
                $cantera = DB::table('canteras')->where('id_cantera', '=', $idCantera)
                                        ->update(['nombre' => $nombre, 
                                                'municipio_cantera' => $municipio, 
                                                'parroquia_cantera' => $parroquia, 
                                                'lugar_aprovechamiento' => $direccion]);
                $minerales = $request->post('mineral');

                foreach($minerales as $mineral){
                    if($mineral != null){
                        $id_min = '';
                        $query_min = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();

                        if(count($query_min) > 0 ){
                            foreach ($query_min as $min) {
                
                                $id_min = $min->id_mineral;

                            }
                        }else{
                            ///el mineral NO existe en la tabla minerals
                            $new_min = DB::table('minerals')->insert(['mineral' => $mineral]);
                            if ($new_min) {
                                $query_new = DB::table('minerals')->select('id_mineral')->where('mineral','=',$mineral)->get();
                                foreach ($query_new as $new) {
                
                                    $id_min = $new->id_mineral;

                                }
                            }

                        }

                        $produccions = DB::table('produccions')->insert(['id_cantera' => $idCantera,'id_mineral' => $id_min]);
                        
                    } /////cierra if ($mineral != null)
                }//////cierra foreach
                return response()->json(['success' => true]);
                break;
            case 'Verificando':
                return response()->json(['success' => false, 'nota' => 'Disculpe, los datos de la cantera no pueden ser actualizados ya que su usuario esta en proceso de Verificación.']);
                break;
            case 'Rechazado':
                $motivo = DB::table('sujeto_pasivos')->select('observaciones')->where('id_sujeto','=',$id_sp)->first();
                if ($motivo) {
                    $obv = $motivo->observaciones;
                    return response()->json(['success' => false, 'nota' => 'Rachazado', 'obv' => $obv]);
                }
                break;
            
            default:
                # code...
                break;
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
    public function destroy(Request $request)
    {   
        $user = auth()->id();
        $sp = DB::table('sujeto_pasivos')->select('id_sujeto')->where('id_user','=',$user)->first();
        $id_sp = $sp->id_sujeto;

        $idCantera = $request->post('cantera');
        $conteo = DB::table('control_guias')->selectRaw("count(*) as total")->where('id_sujeto','=',$id_sp)->where('id_cantera','=',$idCantera)->get();
        if ($conteo) {
            foreach ($conteo as $c){
                if ($c->total == 0){
                    //////el usuario no ha registrado ninguna guia aun.
                    $delete = DB::table('canteras')->where('id_cantera', '=', $idCantera)->delete();

                    if($delete){
                        return response()->json(['success' => true]);
                    }else{
                        return response()->json(['success' => false]);
                    }
                }else{
                    ////////el usuario ya ha registrado guias
                    return response()->json(['success' => 'sin permiso']);
                }
            }
        }else{
            return response()->json(['success' => false]);
        }

        
    }
}
