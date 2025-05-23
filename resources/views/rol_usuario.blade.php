@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Usuarios <span class="text-secondary fs-4">| Roles</span></h3>
        </div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="table_permisos" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Rol(es)</th>
                            @can('rol_usuario.update')
                                <th scope="col">Opción</th>
                            @endcan
                            
                        </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                               @foreach ($user->permisos as $permiso)
                                    <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill">{{$permiso}}</span>
                               @endforeach 
                            </td>
                            @can('rol_usuario.update')
                                <td>
                                    <span class="badge edit_rol_user" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_edit_rol_user" user="{{$user->id}}">
                                        <i class="bx bx-pencil fs-6"></i>
                                    </span>
                                </td>
                            @endcan
                            
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

       
    </div>
   
    


      

    
    
<!--****************** MODALES **************************-->
     

    <!-- ********* NEW PERMISO ******** -->
    <div class="modal" id="modal_edit_rol_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_edit_rol_user">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div> 
    

<!--************************************************-->


@stop





@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bu composer require spatie/laravel-permissionndle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
@stop

@section('js')
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <!-- <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script> -->
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_permisos').DataTable({
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
            ///////////////////////////////////////AGREGAR CAMPOS A OTRO ROL
                var maxFieldTramite = 2; //Input fields increment limitation
                var c = 1; //Initial field counter is 1

                $(document).on('click', '.add_button_rol', function(e){ //Once add button is clicked
                    if(c < maxFieldTramite){ //Check maximum number of input fields
                        c++; //Increment field counter
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("rol_usuario.roles") }}',
                            success: function(response) {
                                $('.roles').append('<div class="d-flex justify-content-center ">'+
                                            '<div class="row w-100 mt-2">'+
                                                '<div class="col-10">'+
                                                    '<select class="form-select form-select-sm" aria-label="Small select example rol" id="rol2" name="rol[]">'+
                                                        response+
                                                    '</select>'+
                                                '</div>'+
                                                '<div class="col-2">'+
                                                    '<a  href="javascript:void(0);" class="btn remove_button_rol"  registro="1">'+
                                                        '<i class="bx bx-x fs-4"></i>'+
                                                    '</a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'); // Add field html
                            },
                            error: function() {
                            }
                        });
                    }
                    

                    console.log(c);
                });

                $(document).on('click', '.remove_button_rol', function(e){ 
                    e.preventDefault();
                    var registro = $(this).attr('registro');
                    console.log(registro);

                    if (registro  == 2) {
                        $('.add_button_rol').removeClass('disabled');
                        c = 2; //Decrement field counter
                    }

                    $(this).parent('div').parent('div').remove(); //Remove field html
                    c--; //Decrement field counter

                    console.log(c);
                });
            ///////////////////////////////////////////////////////////////////

            // MODAL EDIT ROL USER
            $(document).on('click','.edit_rol_user', function(e) { 
                e.preventDefault(e); 
                var user = $(this).attr('user');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: {user:user},
                    url: '{{route("rol_usuario.modal_edit")}}',
                    success: function(response) {       
                        $('#content_edit_rol_user').html(response);
                    },
                    error: function() {
                    }
                });
            });

            // VERIFICAR: NRO. CAMPOS ROL
            

            // VERIFICAR: REPETICIÓN DE ROLES

        });

        function editRolUser(){
            var formData = new FormData(document.getElementById("form_edit_rol_user"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("rol_usuario.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('SE HA ACTUALIZADO EL ROL DE USUARIO CORRECTAMENTE.');
                        window.location.href = "{{ route('rol_usuario')}}";
                        
                    }else{
                        alert('Ha ocurrido un error. Vuelva a intentarlo.');
                    }
                },
                error: function(error){
                    
                }
            });
        }


       

        
      
            
    </script>
@stop