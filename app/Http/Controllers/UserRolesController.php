<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserRolesController extends Controller
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
        $users = [];
        $q1 = DB::table('users')->select('id','key_sujeto')->where('type', '=', 2)->where('id', '!=', 1)->get();

        foreach ($q1 as $key) {
            $permisos = [];
            $c1 = DB::table('model_has_roles')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('roles.name')
                            ->where('model_has_roles.model_id', '=', $key->id)
                            ->get();

            foreach ($c1 as $value) {
                array_push($permisos, $value->name);
            }
            
            $con = DB::table('funcionarios')->select('nombre')->where('id_funcionario', '=', $key->key_sujeto)->first();
            $array = array(
                'id' => $key->id,
                'name' => $con->nombre,
                'permisos' => $permisos,
            );

            $a = (object) $array;
            array_push($users, $a);
        }


        

        return view('rol_usuario', compact('users'));
    }


    public function modal_edit(Request $request){
        $user = $request->post('user');
        $c = 0;
        $div = '';

        $q1 = DB::table('model_has_roles')
                            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->select('model_has_roles.role_id','roles.name')
                            ->where('model_has_roles.model_id', '=', $user)
                            ->get();
        
        $total = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                            ->selectRaw("count(*) as total")
                            ->where('model_has_roles.model_id', '=', $user)
                            ->first();

        foreach ($q1 as $key) {
            $c++;
            $options = '<option value="'.$key->name.'">'.$key->name.'</option>';

            $c2 = DB::table('roles')->select('id','name')->where('name', '!=', 'Admin Master')->where('name', '!=', 'Sujeto pasivo')->where('id', '!=', $key->role_id)->get();
            foreach ($c2 as $value) {
                $options .= '<option value="'.$value->name.'">'.$value->name.'</option>';
            }

            if ($total->total > 1) {
                if ($c == 1) {
                    $button = '<a  href="javascript:void(0);" class="btn add_button_rol mt-4 disabled">
                                    <i class="bx bx-plus fs-4 text-primary "></i>
                                </a>';
                    $label = '<label for="rol'.$c.'" class="form-label">Rol: <span class="text-danger">*</span></label>';
                }else{
                    $button = '<a  href="javascript:void(0);" class="btn remove_button_rol" registro="2">
                                    <i class="bx bx-x fs-4"></i>
                                </a>';
                    $label = '';
                }
            }else{
                $button = '<a  href="javascript:void(0);" class="btn add_button_rol">
                                <i class="bx bx-plus fs-4 text-primary pt-4"></i>
                            </a>';
                $label = '<label for="rol'.$c.'" class="form-label">Rol: <span class="text-danger">*</span></label>';
            }

            

            $div .= '<div class="d-flex justify-content-center">
                        <div class="row w-100">
                            <div class="col-10">
                                '.$label.'
                                <select class="form-select form-select-sm" aria-label="Small select example rol" id="rol'.$c.'" name="rol[]">
                                    '.$options.'
                                </select>
                            </div>
                            <div class="col-2">
                                '.$button.'
                            </div>
                        </div>
                    </div>';

        }

        $html = '<div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-pencil fs-2 text-navy"></i>                       
                        <h1 class="modal-title fw-bold text-navy fs-5" id="exampleModalLabel">Editar Roles de Usuario</h1>
                        <h5 class="modal-title" style="font-size:15px">Control de Permisos</h5>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <form id="form_edit_rol_user" method="post" onsubmit="event.preventDefault(); editRolUser()">
                        <div class="roles">
                            '.$div.'
                        </div>
                       
                        <input type="hidden" name="user" value="'.$user.'">
                        <p class="text-muted text-end"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-4 mb-3">
                        <button type="submit" class="btn btn-success btn-sm me-3" id="">Aceptar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            
                        </div>
                    </form>
                </div>';

        return response($html);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function roles()
    {
        $q1 = DB::table('roles')->select('id','name')->where('name', '!=', 'Admin Master')->where('name', '!=', 'Sujeto pasivo')->get();
        $options = '';

        foreach ($q1 as $key) {
            $options .= '<option value="'.$key->name.'">'.$key->name.'</option>';
        }

        return response($options);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
    public function update(Request $request)
    {
        $user = $request->post('user');
        $roles = $request->post('rol');

        $user = User::findOrFail($user);

        $user->syncRoles($roles);
        
        // BITACORA
        $id_user = auth()->id();
        $accion = 'SE ACTUALIZÓ EL ROL DEL USUARIO ID'.$user.'.';
        $bitacora = DB::table('bitacoras')->insert(['key_user' => $id_user, 'key_modulo' => 8, 'accion'=> $accion]);

        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
