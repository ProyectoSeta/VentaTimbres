<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use DB;

class RolesController extends Controller
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
        $roles = Role::all();
        return view('roles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function modal_new()
    {
        $modulo = '';
        $c = 0;
        $cols = '';

        $q1 = DB::table('permissions')->where('priority','=',1)->get();
        
        foreach ($q1 as $key) {
            $c++;
            $module_title = false;
            $nombre_modulo = '';


            // arracar con el primer modulo
            if ($c == 1) {
                $modulo = $key->module;
                $module_title = true;
            }

            // cambiar de modulo 
            if ($modulo != $key->module) {
                $modulo = $key->module;
                $module_title = true;
            }


            if ($module_title == true) {
                $c1 = DB::table('modulos')->select('modulo')->where('id_modulo','=',$modulo)->first();
                $nombre_modulo = '<div class="text-navy fw-semibold titulo fs-5"><span class="text-muted">Modulo </span>'.$c1->modulo.'</div>';
                if ($c != 1) {
                    $cols .= '</div>';
                }
                $cols .= ''.$nombre_modulo.'
                            <div class="row row-cols-sm-3 border m-2 p-2 rounded-3">         
                                <div class="col py-0 my-0">
                                    <table class="table table-sm table-borderless my-0 py-0">
                                        <tr>
                                            <td class="text-center" width="30%">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input fs-6" type="checkbox" role="switch" id="'.$key->id.'" name="permisos[]" value="'.$key->name.'">
                                                </div>
                                            </td>
                                            <td>        
                                                <label class="form-check-label" for="'.$key->id.'">'.$key->description.'</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>';
            }else{
                $cols .= '<div class="col py-0 my-0">
                            <table class="table table-sm table-borderless my-0 py-0">
                                <tr>
                                    <td class="text-center" width="30%">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="'.$key->id.'" name="permisos[]" value="'.$key->name.'">
                                        </div>
                                    </td>
                                    <td>        
                                        <label class="form-check-label" for="'.$key->id.'">'.$key->description.'</label>
                                    </td>
                                </tr>
                            </table>
                        </div>';
            }

            
        }

        $cols .= '</div>';

        $html = '<div class="modal-header p-2 pt-3">
                    <h1 class="modal-title fw-bold text-navy fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bx bx-plus fs-2 text-navy mx-2"></i>
                        <span>Nuevo Rol <span class="text-muted">| Control de Usuarios</span></span>
                    </h1>
                </div>
                <div class="modal-body px-5" style="font-size:13px">
                    <form id="form_new_rol" method="post" onsubmit="event.preventDefault(); newRol()">
                        <label for="name_rol" class="form-label">Nombre del Rol: <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm" type="text" name="name_rol" id="name_rol" required>

                        <label for="" class="form-label mt-3">Permisos: <span class="text-danger">*</span></label>

                        
                         '.$cols.'
                        

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rol = $request->post('name_rol');
        $permisos = $request->post('permisos');

        if (!empty($permisos)) {
            $c1 = DB::table('roles')->select('name')->where('name', '=', $rol)->first();

            if ($c1) {
                //// hay un rol con ese nombre
                return response()->json(['success' => false,'nota' => 'Disculpe, hay un Rol registrado con ese nombre.']);
            }else{
                $role = Role::create(['name' => $rol]);

                // ASIGNAR LOS PERMISOS AL ROL
                $role->syncPermissions($permisos);
                if ($role) {
                    $user = auth()->id();
                    $accion = 'CREACIÓN DEL ROL '.$rol.'.';
                    $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 8, 'accion'=> $accion]);

                    return response()->json(['success' => true]);
                }else{
                    return response()->json(['success' => false]);
                }
            }
        }else{
            return response()->json(['success' => false, 'nota' => 'Por favor, elija los Permisos del Rol.']);
        }
    }

    public function ver(Request $request)
    {
        $id_rol = $request->post('rol');

        $modulo = '';
        $c = 0;
        $cols = '';

        $q1 = DB::table('role_has_permissions')->where('role_id','=',$id_rol)->get();
        
        foreach ($q1 as $key) { 
            $c++;
            $module_title = false;
            $nombre_modulo = '';

            $c2 = DB::table('permissions')->where('id','=',$key->permission_id)->first(); ////
            
            // arracar con el primer modulo
            if ($c == 1) {
                $modulo = $c2->module;
                $module_title = true;
            }

            // cambiar de modulo 
            if ($modulo != $c2->module) {
                $modulo = $c2->module;
                $module_title = true;
            }


            if ($module_title == true) {
                $c1 = DB::table('modulos')->select('modulo')->where('id_modulo','=',$modulo)->first();
                $nombre_modulo = '<div class="text-navy fw-semibold titulo fs-5"><span class="text-muted">Módulo </span>'.$c1->modulo.'</div>';
                if ($c != 1) {
                    $cols .= '</div>';
                }
                

                $cols .= ''.$nombre_modulo.'
                            <div class="row row-cols-sm-3 border m-2 p-2 rounded-3">
                                <div class="col py-0 my-0">
                                    <table class="table table-sm table-borderless my-0 py-0">
                                        <tr>
                                            <td class="text-center" width="30%">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input fs-6" type="checkbox" role="switch" checked disabled>
                                                </div>
                                            </td>
                                            <td>        
                                                <label class="form-check-label">'.$c2->description.'</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>';

            }else{
                $cols .= '<div class="col py-0 my-0">
                            <table class="table table-sm table-borderless my-0 py-0">
                                <tr>
                                    <td class="text-center" width="30%">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch" checked disabled>
                                        </div>
                                    </td>
                                    <td>        
                                        <label class="form-check-label">'.$c2->description.'</label>
                                    </td>
                                </tr>
                            </table>
                        </div>';
            }

            
        }

        $c3 = DB::table('roles')->select('name')->where('id','=',$id_rol)->first();

        $cols .= '</div>';

        $html = '<div class="modal-header p-2 pt-3">
                    <h1 class="modal-title fw-bold text-navy fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bx bxs-category fs-2 text-navy mx-2"></i>
                        <span>Permisos del Rol <span class="text-muted">| Control de Usuarios</span></span>
                    </h1>
                </div>
                <div class="modal-body px-5" style="font-size:13px">
                        <label for="name_rol" class="form-label">Nombre del Rol: </label>
                        <input class="form-control form-control-sm" type="text" value="'.$c3->name.'" disabled>

                        <label for="" class="form-label mt-3">Permisos:</label>

                        
                            '.$cols.'
                        

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                </div>';

        return response($html);
    }
    
    public function modal_editar(Request $request)
    {
        $id_rol = $request->post('rol');

        $modulo = '';
        $c = 0;
        $cols = '';

        
        $q1 = DB::table('permissions')->where('priority','=',1)->get();

        foreach ($q1 as $key) {
            $c++;
            $module_title = false;
            $nombre_modulo = '';
            $check = '';

            $c2 = DB::table('role_has_permissions')->where('permission_id','=',$key->id)->where('role_id','=',$id_rol)->first();
            if ($c2) {
                $check = 'checked';
            }
            
            // arracar con el primer modulo
            if ($c == 1) {
                $modulo = $key->module;
                $module_title = true;
            }

            // cambiar de modulo 
            if ($modulo != $key->module) {
                $modulo = $key->module;
                $module_title = true;
            }

            if ($module_title == true) {
                $c1 = DB::table('modulos')->select('modulo')->where('id_modulo','=',$modulo)->first();
                $nombre_modulo = '<div class="text-navy fw-semibold titulo fs-5"><span class="text-muted">Módulo </span>'.$c1->modulo.'</div>';
                if ($c != 1) {
                    $cols .= '</div>';
                }

                $cols .= ''.$nombre_modulo.'
                    <div class="row row-cols-sm-3 border m-2 p-2 rounded-3">
                        <div class="col py-0 my-0">
                            <table class="table table-sm table-borderless my-0 py-0">
                                <tr>
                                    <td class="text-center" width="30%">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="'.$key->id.'" name="permisos[]" value="'.$key->name.'" '.$check.'>
                                        </div>
                                    </td>
                                    <td>        
                                        <label class="form-check-label" for="'.$key->id.'">'.$key->description.'</label>
                                    </td>
                                </tr>
                            </table>
                        </div>';
            }else{
                $cols .= '<div class="col py-0 my-0">
                            <table class="table table-sm table-borderless my-0 py-0">
                                <tr>
                                    <td class="text-center" width="30%">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="'.$key->id.'" name="permisos[]" value="'.$key->name.'" '.$check.'>
                                        </div>
                                    </td>
                                    <td>        
                                        <label class="form-check-label" for="'.$key->id.'">'.$key->description.'</label>
                                    </td>
                                </tr>
                            </table>
                        </div>';
            }

            
        }

        $c3 = DB::table('roles')->select('name')->where('id','=',$id_rol)->first();
        $cols .= '</div>';

        $html = '<div class="modal-header p-2 pt-3">
                    <h1 class="modal-title fw-bold text-navy fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bx bx-edit fs-2 text-navy mx-2"></i>
                        <span>Actualizar Permisos <span class="text-muted">| Control de Usuarios</span></span>
                    </h1>
                </div>
                <div class="modal-body px-5" style="font-size:13px">
                    <form id="form_update_rol" method="post" onsubmit="event.preventDefault(); updateRol()">
                        <label for="name_rol" class="form-label">Nombre del Rol: <span class="text-danger">*</span></label>
                        <input class="form-control form-control-sm" type="text"  value="'.$c3->name.'" disabled >
                        <input type="hidden" name="rol" value="'.$id_rol.'">

                        <label for="" class="form-label mt-3">Permisos: <span class="text-danger">*</span></label>

                    
                            '.$cols.'
            

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
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $rol = $request->post('rol');
        $permisos = $request->post('permisos');

        if (!empty($permisos)) {
            $role = Role::findOrFail($rol);
            $role->syncPermissions($permisos);

            // BITACORA
            $user = auth()->id();
            $accion = 'ACTUALIZACIÓN DE LOS PERMISOS, ROL ID '.$rol.'.';
            $bitacora = DB::table('bitacoras')->insert(['key_user' => $user, 'key_modulo' => 8, 'accion'=> $accion]);

            return response()->json(['success' => true]);
        }else{
            return response()->json(['success' => false, 'nota' => 'Por favor, elija los Permisos del Rol.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
