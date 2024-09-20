<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Users;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UsuariosController extends Controller
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
        $sujetos = DB::table('sujeto_pasivos')
            ->join('users', 'sujeto_pasivos.id_user', '=', 'users.id')
            ->select('sujeto_pasivos.id_sujeto', 'sujeto_pasivos.rif_condicion', 'sujeto_pasivos.rif_nro', 'users.id', 'users.name','users.email', 'users.created_at')
            ->where('users.type',3)
            ->get();
        $admins = DB::table('users')
            ->select('id', 'name','email', 'created_at')
            ->where('type',4)
            ->get();
        return view('usuarios', compact('sujetos', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_edit(Request $request)
    {
        $user = $request->post('user');
        $consulta = DB::table('users')->select('id','email')->where('id', '=', $user)->first();
        if ($consulta) {
            $html = '<div class="modal-header">
                        <h1 class="modal-title fs-5 text-navy d-flex align-items-center" id="exampleModalLabel">
                            <!-- <i class="bx bx-pencil fw-bold fs-4 pe-2"></i> -->
                            <span>Editar Datos</span>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: 13px">
                        <form id="form_edit_user" method="post" onsubmit="event.preventDefault(); editUser()">
                            <div class="mb-2">
                                <label class="form-label" for="email">Correo Electrónico</label><span class="text-danger">*</span>
                                <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="example@gmail.com" value="'.$consulta->email.'" required>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: ejemplo@gmail.com</p>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Contraseña</label><span class="text-danger">*</span>
                                        <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password">
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label class="form-label" for="password_confirmation">Confirmar Contraseña</label><span class="text-danger">*</span>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm" autocomplete="new-password" disabled required>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>
                            <div class="text-muted">
                                <span>La Contraseña debe contener:</span>
                                <ol>
                                    <li>Mínimo 8 caracteres.</li>
                                    <li>Caracteres alfanuméricos.</li>
                                    <li>Caracteres especiales (Ejemplo: ., @, $, *, %, !, &, entre otros.).</li>
                                </ol>
                            </div>

                            <div class="d-none alert alert-danger" id="obs_error">
                                <ul class="ul_obs_error">
                                    
                                </ul>
                            </div>
                            <input type="hidden" name="id_user" value="'.$consulta->id.'">
                            <div class="d-flex justify-content-center mt-4 mb-3">
                                <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-sm" id="btn_aceptar_edit_user">Actualizar</button>
                            </div>
                        </form>
                    </div>';

            return response($html);
        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            return response()->json(['success' => false, 'nota' => $validator->errors()]);
        }else{
            $usuario = User::create([
                'name'=>$request->post('nombre'),
                'email'=>$request->post('email'),
                'password'=>bcrypt($request->post('password')),
                'type'=>4
            ]);

            if ($usuario) {
                $user = auth()->id();
                $accion = 'NUEVO USUARIO ADMINISTRATIVO CREADO: '.$request->post('nombre').'.';
                $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 15, 'accion'=> $accion]);
                return response()->json(['success' => true]);
            }

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
    public function editar(Request $request)
    {
        $pass = $request->post('password');
        if (empty($pass)) {

            $idUser = $request->post('id_user');
            $email = $request->post('email');
            //  return response($idUser);
            $update = DB::table('users')->where('id', '=', $idUser)
                                        ->update(['email' => $email]);
            if ($update) {
                return response()->json(['success' => true]);
            }else{
                return response()->json(['success' => false, 'nota' => 'Error al actualizar los datos del usuario']);
            }

        }else{
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'confirmed', Password::min(8)
                ->letters() // Requerir al menos una letra...
                ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
                ->numbers() // Requerir al menos un número...
                ->symbols() // Requerir al menos un símbolo...
                ->uncompromised()],
            ]);
            
            if ($validator->fails()) {
                return response()->json(['success' => false, 'nota' => $validator->errors()]);
    
            }else{
                $idUser = $request->post('id_user');
                $email = $request->post('email');
                $pass = bcrypt($request->post('password'));
    
                $update = DB::table('users')->where('id', '=', $idUser)
                                            ->update(['email' => $email, 
                                                    'password' => $pass]);
                if ($update) {
                    $user = auth()->id();
                    $sp =  DB::table('users')->select('name')->where('id','=',$idUser)->first(); 
                    $accion = 'DATOS DEL USUARIO: '.$sp->name.' ACTUALIZADOS.';
                    $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 15, 'accion'=> $accion]);

                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false, 'nota' => 'Error al actualizar los datos del usuario']);
                }
            }
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
        $user = $request->post('user');
        $delete = DB::table('users')->where('id', '=', $user)->delete();
        if($delete){
            $user = auth()->id();
            $sp =  DB::table('users')->select('name')->where('id','=',$user)->first(); 
            $accion = 'USUARIO ELIMINADO: '.$sp->name.'.';
            $bitacora = DB::table('bitacoras')->insert(['id_user' => $user, 'modulo' => 15, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false]);
        }
    }
}
