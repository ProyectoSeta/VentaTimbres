<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SujetoPasivo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class NewPassController extends Controller
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
        $id_user = auth()->id();
        $update = DB::table('users')
                ->selectRaw('DATE(updated_at) AS fecha')
                ->where('id',$id_user)
                ->first();
        return view('new_pass', compact('update'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request)
    {
        $pass = $request->post('password');
        $confirmar = $request->post('confirmar_pass');
        $old_pass = $request->post('pass_actual');

        if (empty($pass) || empty($confirmar) || empty($old_pass)) {
            return response()->json(['success' => false, 'nota' => 'Por favor, Ingrese la contraseña']);
        }else{
            // $usuario = new User(); // SE llama al modelo sujetopasivo
            // $clave_db = $usuario->password;
            $id_user = auth()->id();
            $hash_pass = DB::table('users')->select('password','name')->where('id','=',$id_user)->first(); 
            if (Hash::check($old_pass, $hash_pass->password)) {
                if ($pass == $confirmar) {
                    $validator = Validator::make($request->all() , [
                        'password' => ['required', Password::min(8)
                        ->letters() // Requerir al menos una letra...
                        ->mixedCase() // Requerir al menos una letra mayúscula y una minúscula...
                        ->numbers() // Requerir al menos un número...
                        ->symbols() // Requerir al menos un símbolo...
                        ->uncompromised()],
                    ]);
                    
                    if ($validator->fails()) {
                        $li = '';
                        $errors = $validator->errors();
                        foreach ($errors->all() as $error) {
                            $li .= '<li>'.$error.'</li>';
                        }
                        $errores = '<ul>
                                        '.$li.'
                                    </ul>';
                        return response()->json(['success' => false, 'nota' => 'errores', 'errores' => $errores]);
            
                    }else{
                        $pass_new = bcrypt($request->post('password'));
                        $hoy = date('Y-n-d');
                        $update = DB::table('users')->where('id', '=', $id_user)
                                                    ->update(['password' => $pass_new, 'updated_at' => $hoy]);
                        if ($update) {
                            $accion = 'CONTRASEÑA DEL USUARIO: '.$hash_pass->name.' ACTUALIZADA.';
                            $bitacora = DB::table('bitacoras')->insert(['id_user' => $id_user, 'modulo' => 15, 'accion'=> $accion]);
        
                            return response()->json(['success' => true]);
                        }else{
                            return response()->json(['success' => false, 'nota' => 'Error al actualizar la contraseña.']);
                        }
                    }
                }else{
                    return response()->json(['success' => false, 'nota' => 'Disculpe, las contraseñas no coinciden']);
                }
            }else{
                return response()->json(['success' => false, 'nota' => 'Disculpe, la contraseña actual es incorrecta.']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
