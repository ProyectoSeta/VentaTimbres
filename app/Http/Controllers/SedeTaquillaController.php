<?php

namespace App\Http\Controllers;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;

class SedeTaquillaController extends Controller
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
        $taquillas =  DB::table('taquillas')->join('sedes', 'taquillas.key_sede','=','sedes.id_sede')
                                            ->join('funcionarios', 'taquillas.key_funcionario','=','funcionarios.id_funcionario')
                                            ->select('taquillas.*','sedes.sede','funcionarios.nombre')->get();

        $taquilleros = DB::table('funcionarios')->where('cargo','=','Taquillero')->get();

        return view('sede_taquilla',compact('taquillas','taquilleros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_new_taquilla()
    {
        $option_sedes = '';
        $option_taquilleros = '';

        $c1 = DB::table('sedes')->get();
        foreach ($c1 as $key) {
            $option_sedes .= '<option value="'.$key->id_sede.'">'.$key->sede.'</option>';
        }

        $c2 = DB::table('funcionarios')->where('cargo','=','Taquillero')->get();
        foreach ($c2 as $key) {
            $option_taquilleros .= '<option value="'.$key->id_funcionario.'">'.$key->nombre.', '.$key->ci_condicion.'-'.$key->ci_nro.'</option>';
        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Nueva Taquilla</h1>
                        <span>Agrega una nueva Taquilla</span>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_nueva_taquilla" method="post" onsubmit="event.preventDefault(); nuevaTaquilla()">
                        
                        <div class="row d-flex align-items-center mt-3">
                            <div class="col-3">
                                <label for="sede" class="form-label">Sede:<span class="text-danger"> *</span></label>
                            </div>
                            <div class="col-9">
                                <select class="form-select form-select-sm" aria-label="Small select example" id="sede" name="sede">
                                    <option>Seleccione</option>
                                    '.$option_sedes.'
                                </select>
                            </div>
                        </div>

                        <div class="row d-flex align-items-center mt-3">
                            <div class="col-3">
                                <label for="taquillero" class="form-label">Taquillero:<span class="text-danger"> *</span></label>
                            </div>
                            <div class="col-9">
                                <select class="form-select form-select-sm" aria-label="Small select example" id="taquillero" name="taquillero">
                                    <option>Seleccione</option>
                                    '.$option_taquilleros.'
                                </select>
                            </div>
                        </div>
                        
                        <p class="text-justify mt-4 mb-1"><span class="fw-bold">NOTA:</span> Esta clave será utilizada por el taquillero para aperturar y cerrar la taquilla diariamente.</p>
                        
                        <div class="row d-flex align-items-center mt-3">
                            <div class="col-3">
                                <label class="form-label" for="password">Clave</label><span class="text-danger"> *</span>
                            </div>
                            <div class="col-9">
                                <input type="password" id="password" class="form-control form-control-sm" name="password" required>
                            </div>
                        </div>

                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="text-muted mt-2 mb-3" style="font-size:14px">
                            <span>La Contraseña debe contener:</span> 
                            <ol>
                                <li>Mínimo 8 caracteres.</li>
                                <li>Caracteres alfanuméricos.</li>
                                <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &, entre otros.).</li>
                            </ol>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                        <button type="submit" class="btn btn-success btn-sm me-2">Aceptar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            
                        </div>
                    </form>
                </div>';

        return response($html);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function new_sede(Request $request)
    {
        $ubicacion = $request->post('ubicacion');

        $insert = DB::table('sedes')->insert(['sede' => $ubicacion, 'estado' => 16]); 
        if ($insert) {
            ///////BITACORA
            $user = auth()->id();
            /////BITACORA
            $accion = 'SEDE CREADA: '.$ubicacion.'';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }

    }




    public function new_taquilla(Request $request)
    {
        $taquillero = $request->post('taquillero');
        $sede = $request->post('sede');

        $c1 = DB::table('taquillas')->where('key_funcionario','=',$taquillero)->first();
        if ($c1) {
            /////// hay una taquilla asociada al taquillero seleccionado
            return response()->json(['success' => false, 'error' => 'Disculpe, el taquillero seleccionado ya se encuentra asociado a una taquilla. Por favor, verifique.']);
        }else{
            $validator = Validator::make($request->all(), [
                'password' => ['required', Password::min(8)
                ->letters() // Requerir al menos una letra...
                ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
                ->numbers() // Requerir al menos un número...
                ->symbols() // Requerir al menos un símbolo...
                ],
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }else{
                $insert = DB::table('taquillas')->insert([
                            'key_sede' => $sede,
                            'key_funcionario' => $taquillero,
                            'clave' => bcrypt($request->post('password')), 
                            'estado' => 16]);
                if ($insert) {
                    $id_taquilla = DB::table('taquillas')->max('id_taquilla');
                    $insert_inv_est = DB::table('inv_est_taq_temps')->insert([
                                            'key_taquilla' => $id_taquilla,
                                            'one_ucd' => 0,
                                            'two_ucd' => 0,
                                            'three_ucd' => 0,
                                            'five_ucd' => 0,
                                            'twenty_ut' => 0,
                                            'fifty_ut' => 0,
                                            'fecha' => '2025-01-01'
                                        ]);
                    if ($insert_inv_est) {
                        $insert_inv_tfe = DB::table('inv_tfe_taq_temps')->insert([
                                                'key_taquilla' => $id_taquilla,
                                                'cantidad' => 0,
                                                'fecha' => '2025-03-10'
                                            ]);
                        if ($insert_inv_tfe) {
                            $insert_inv_taq = DB::table('inventario_taquillas')->insert([
                                'key_taquilla' => $id_taquilla,
                                'cantidad_tfe' => 0,
                                'cantidad_estampillas' => 0
                            ]);

                            $insert_hist_taq = DB::table('historial_taquillas')->insert([
                                'key_taquilla' => $id_taquilla,
                                'key_funcionario' => $taquillero,
                                'desde' => '2024-10-20'
                            ]);
                            $insert_efect_taq = DB::table('efectivo_taquillas_temps')->insert([
                                'key_taquilla' => $id_taquilla,
                                'efectivo' => '0'
                            ]);

                            if ($insert_inv_taq && $insert_hist_taq && $insert_efect_taq) {
                                
                                $user = auth()->id();
                                /////BITACORA
                                $accion = 'TAQUILLA CREADA: ID'.$id_taquilla.'';
                                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);

                                return response()->json(['success' => true]);
                            }else{
                                ////delete la taquilla y return false
                                $delete = DB::table('taquillas')->where('id_taquilla', '=', $id_taquilla)->delete();
                                return response()->json(['success' => false]);
                            }
                            
                        }else{
                            ////delete la taquilla y return false
                            $delete = DB::table('taquillas')->where('id_taquilla', '=', $id_taquilla)->delete();
                            return response()->json(['success' => false]);
                        }
                    }else{
                        ////delete la taquilla y return false
                        $delete = DB::table('taquillas')->where('id_taquilla', '=', $id_taquilla)->delete();
                        return response()->json(['success' => false]);
                    }
                }else{
                    return response()->json(['success' => false]);
                } 
            }
        }
    }




    public function new_taquillero(Request $request)
    {
        $key = $request->post('llave');
        $con_key = DB::table('funcionarios')->selectRaw("count(*) as total")->where('key','=',$key)->where('cargo','=','Taquillero')->first();
        if ($con_key->total == 0) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'confirmed', Password::min(8)
                ->letters() // Requerir al menos una letra...
                ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
                ->numbers() // Requerir al menos un número...
                ->symbols() // Requerir al menos un símbolo...
                ->uncompromised()],
                'email' => 'required|unique:users|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }else{
                $ci_nro = $request->post('ci_nro');
                $ci_condicion = $request->post('ci_condicion');

                $c1 = DB::table('funcionarios')->where('ci_condicion','=',$ci_condicion)->where('ci_nro','=',$ci_nro)->first();
                if ($c1) {
                    /////// la cedula se encuentra registrada
                    return response()->json(['success' => false, 'error' => 'La cedula del Taquillero ya se encuentra registrada.']);
                }else{
                    ////// sin coincidencia
                    $nombre = $request->post('nombre');
                    $insert_func = DB::table('funcionarios')->insert([
                                                'ci_condicion' => $ci_condicion,
                                                'ci_nro' => $ci_nro,
                                                'nombre' => $nombre,
                                                'cargo' => 'Taquillero', 
                                                'key' => $key, 
                                                'estado' => 16]);
        
                    if ($insert_func) {
                        $id_funcionario = DB::table('funcionarios')->max('id_funcionario');
                        $usuario = User::create([
                                    'email'=>$request->post('email'),
                                    'password'=>bcrypt($request->post('password')),
                                    'type'=>2,
                                    'key_sujeto'=>$id_funcionario,
                        ]);
        
                        if($usuario->save()){
                            $usuario->assignRole('Taquillero');
                            $user = auth()->id();
                            /////BITACORA
                            $accion = 'TAQUILLERO CREADO: ID'.$id_funcionario.'';
                            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);

                            return response()->json(['success' => true]);
                        }
                    }
                }

            }  ////cierra else (if ($validator->fails()))
        }else{
            return response()->json(['success' => false, 'error' => 'La LLave debe ser única.']);
        }
    }




    ////////////////////////////////////////////////////////////////////////
    // Actualizar clave de taquilla para cierre y arpertura de la misma.
    public function update_clave(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'password' => ['required', Password::min(8)
            ->letters() // Requerir al menos una letra...
            ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
            ->numbers() // Requerir al menos un número...
            ->symbols() // Requerir al menos un símbolo...
            ->uncompromised()],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }else{
            $id_taquilla = $request->post('id');
            $update = DB::table('taquillas')->where('id_taquilla', '=', $id_taquilla)->update(['clave' => bcrypt($request->post('password'))]);
            if ($update) {
                ///////////////////BITACORA
                $user = auth()->id();
                /////BITACORA
                $accion = 'CLAVE DE TAQUILLA ACTUALIZADA: TAQ'.$id_taquilla.'';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }
    


    // Habilitar o deshabilitar taquilla
    public function habilitar_taquilla(Request $request)
    {
        $id_taquilla = $request->post('taquilla'); 
        $checked = $request->post('checked');
        // return response($checked);
        if ($checked == 'true') {
            // habilitar
            $update = DB::table('taquillas')->where('id_taquilla','=', $id_taquilla)->update(['estado' => 16]);
            if ($update) {
                ///////////////////BITACORA
                $user = auth()->id();
                /////BITACORA
                $accion = 'TAQUILLA HABILITADA: TAQ'.$id_taquilla.'';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            // return response('deshabilitar');
            // // deshabilitar
            $update = DB::table('taquillas')->where('id_taquilla', '=', $id_taquilla)->update(['estado' => 17]);
            if ($update) {
                ///////////////////BITACORA
                $user = auth()->id();
                /////BITACORA
                $accion = 'TAQUILLA DESHABILITADA: TAQ'.$id_taquilla.'';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }




    public function habilitar_taquillero(Request $request)
    {
        $id_funcionario = $request->post('funcionario'); 
        $checked = $request->post('checked');
        // return response($checked);
        if ($checked == 'true') {
            // habilitar
            $update = DB::table('funcionarios')->where('id_funcionario','=', $id_funcionario)->update(['estado' => 16]);
            if ($update) {
                ///////////////////BITACORA
                $user = auth()->id();
                /////BITACORA
                $accion = 'TAQUILLERO HABILITADO: TAQUILLERO ID'.$id_funcionario.'';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }else{
            // return response('deshabilitar');
            // // deshabilitar
            $update = DB::table('funcionarios')->where('id_funcionario', '=',$id_funcionario)->update(['estado' => 17]);
            if ($update) {
                ///////////////////BITACORA
                $user = auth()->id();
                /////BITACORA
                $accion = 'TAQUILLERO DESHABILITADO: TAQUILLERO ID'.$id_funcionario.'';
                $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 7, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
