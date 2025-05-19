@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Usuarios <span class="text-secondary fs-4">| Sistema de ventas</span></h3>
            {{-- @can('usuarios.store') --}}
                <div class="mb-3">
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_user" data-bs-toggle="modal" data-bs-target="#modal_new_user"> 
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Nuevo Usuario</span>
                    </button>
                </div> 
            {{-- @endcan --}}
            
        </div>

        
        <div class="table-responsive" style="font-size:12.7px">
            <table id="administrativo" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">C.I</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Creado</th>
                            <th scope="col">Última actualización</th>
                            {{-- @if(auth()->user()->can('usuarios.editar') || auth()->user()->can('usuarios.destroy')) --}}
                                <th scope="col">Opciones</th>
                            {{-- @endif --}}
                        </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td class="text-navy fw-semibold">{{ $admin->nombre }}</td>
                            <td><span class="text-muted">{{ $admin->ci_condicion }}-{{ $admin->ci_nro}}</span></td>
                            <td>{{ $admin->email }}</td>
                            <td><span class="text-muted fst-italic">{{ $admin->cargo }}</span></td>
                            <td class="text-secondary fst-italic">{{ date("d-m-Y h:i A",strtotime($admin->created_at)) }}</td>
                            <td class="text-secondary fst-italic">{{ date("d-m-Y h:i A",strtotime($admin->updated_at)) }}</td>

                            {{-- @if(auth()->user()->can('usuarios.editar') || auth()->user()->can('usuarios.destroy')) --}}
                                <td>
                                    {{-- @can('usuarios.editar') --}}
                                        <span class="badge edit_user" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_edit_user" id_user="{{ $admin->id}}">
                                            <i class="bx bx-pencil fs-6"></i>
                                        </span> 
                                    {{-- @endcan --}}
                                </td>
                            {{-- @endif --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

       
    </div>
   
    


      

    
    
<!--****************** MODALES **************************-->
    
    <!-- ********* EDITAR USER ******** -->
    <div class="modal" id="modal_edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_edit_user">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>  

    <!-- ********* REGISTRO DE NUEVO USER ADMINISTRATIVO ******** -->
    <div class="modal" id="modal_new_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <!-- <div class="modal-header">
                    <h1 class="modal-title fs-5 text-navy d-flex align-items-center" id="exampleModalLabel">
                        <i class="bx bx-plus fw-bold fs-4 pe-2"></i>
                        <span>Nuevo Usuario Administrativo</span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus fs-2 text-navy"></i>                       
                        <h1 class="modal-title fw-bold text-navy fs-5" id="exampleModalLabel">Nuevo Usuario</h1>
                        <h5 class="modal-title" style="font-size:15px">Administrativo</h5>
                    </div>
                </div>
                <div class="modal-body px-4" style="font-size:13px">
                    <p class="text-muted text-justify" style="font-size:13px">IMPORTANTE: Los Usuarios a registrar seran únicamente <span class="fw-bold">Usuarios Administrativos</span>.</p>
                    
                    <form id="form_new_user" method="post" onsubmit="event.preventDefault(); newUser()">
                        <div class="mb-2">
                            <label class="form-label" for="nombre">Nombre y Apellido</label><span class="text-danger">*</span>
                            <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" required>
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label class="form-label" for="ci_condicion">C.I.</label><span class="text-danger">*</span>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-select form-select-sm" id="ci_condicion" name="ci_condicion" required>
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <input type="number" id="ci_nro" class="form-control form-control-sm" name="ci_nro" placeholder="Ejemplo: 8456122" required>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="cargo">Cargo</label><span class="text-danger">*</span>
                            <input type="text" id="cargo" name="cargo" class="form-control form-control-sm" placeholder="Coordinador" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="email">Correo Electrónico</label><span class="text-danger">*</span>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="example@gmail.com" required>
                            <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: ejemplo@gmail.com</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="password">Contraseña</label><span class="text-danger">*</span>
                                    <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password" required>
                                </div> 
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <label class="form-label" for="password_confirmation">Confirmar Contraseña</label><span class="text-danger">*</span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm" autocomplete="new-password" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="rol">Rol del Usuario</label><span class="text-danger">*</span>
                            <select class="form-select form-select-sm" aria-label="Small select example rol" id="rol" name="rol[]">
                                @foreach ($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
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

                        <div class="d-flex justify-content-center mt-4 mb-3">
                        <button type="submit" class="btn btn-success btn-sm me-3" id="btn_aceptar_new_user" disabled>Aceptar</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            
                        </div>
                    </form>
                    

                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div> 
    

<!--************************************************-->


@stop





@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus();
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#contribuyente').DataTable({
                "language": {
                    "lengthMenu": " Mostrar  _MENU_  Registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No se encuentran Registros",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    'search':"Buscar",
                    'paginate':{
                        'next':'Siguiente',
                        'previous':'Anterior'
                    }
                }
            });

            $('#administrativo').DataTable({
                "language": {
                    "lengthMenu": " Mostrar  _MENU_  Registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No se encuentran Registros",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    'search':"Buscar",
                    'paginate':{
                        'next':'Siguiente',
                        'previous':'Anterior'
                    }
                }
            });
        
        });
    </script> 
    <script type="text/javascript">
        $(document).ready(function () {
            

            ///////MODAL: EDITAR USUARIO
            $(document).on('click','.edit_user', function(e) { 
                e.preventDefault(e); 
                var user = $(this).attr('id_user');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("usuarios.modal_edit") }}',
                    data: {user:user},
                    success: function(response) {              
                        $('#html_edit_user').html(response);
                    },
                    error: function() {
                    }
                });
            });

            //////////////////////////////////////////////////////////////
            $(document).on('keyup','#password_confirmation', function(e) { 
                e.preventDefault(e); 
                var confirmar = $(this).val();
                var pass = $('#password').val();

                if (confirmar == pass) {
                    $("#btn_aceptar_new_user").attr('disabled', false);
                    $("#btn_aceptar_edit_user").attr('disabled', false);
                }
                else{
                    $("#btn_aceptar_new_user").attr('disabled', true);
                    $("#btn_aceptar_edit_user").attr('disabled', true);
                }

            });

            $(document).on('keyup','#password', function(e) { 
                e.preventDefault(e);
                var pass = $(this).val();
                if (pass == '') {
                    $("#password_confirmation").attr('disabled', true);
                    $("#btn_aceptar_edit_user").attr('disabled', false);
                }else{
                    $("#password_confirmation").attr('disabled', false);
                    $("#btn_aceptar_edit_user").attr('disabled', true);
                }
            });

            /////////////////////////////////////////////////////////////
            $(document).on('click','#btn_aceptar_new_user', function(e) { 
                $('#obs_error').addClass('d-none');
                $(".ul_obs_error").html('');
            });

            

            
        });

        function newUser(){
            $("#btn_aceptar_new_user").attr('disabled', true);
            var formData = new FormData(document.getElementById("form_new_user"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("usuarios.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('Usuario administrativo creado correctamente.');
                        $('#form_new_user')[0].reset();
                        $('#modal_new_user').modal('hide');
                        window.location.href = "{{ route('usuarios')}}";
                        
                    }else{
                        var errores = response.nota;
                        $(errores.email).each(function(index, element) {
                            $(".ul_obs_error").append('<li>'+element+'</li>'); 
                        });
                        $(errores.password).each(function(index, element) {
                            $(".ul_obs_error").append('<li>'+element+'</li>'); 
                        });
                      
                        $('#obs_error').removeClass('d-none');
                    }
                },
                error: function(error){
                    
                }
            });
        }


        function editUser(){
            $("#btn_aceptar_edit_user").attr('disabled', true);
            var formData = new FormData(document.getElementById("form_edit_user"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("usuarios.editar") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('SE HA ACTUALIZADO LOS DATOS DEL USUARIO CORRECTAMENTE.');
                        $('#form_edit_user')[0].reset();
                        $('#modal_edit_user').modal('hide');
                        window.location.href = "{{ route('usuarios')}}";
                        
                    }else{
                        var errores = response.nota;
                        $(errores.email).each(function(index, element) {
                            $(".ul_obs_error").append('<li>'+element+'</li>'); 
                        });
                        $(errores.password).each(function(index, element) {
                            $(".ul_obs_error").append('<li>'+element+'</li>'); 
                        });
                      
                        $('#obs_error').removeClass('d-none');
                    }
                },
                error: function(error){
                    
                }
            });
        }

      
            
    </script>
@stop