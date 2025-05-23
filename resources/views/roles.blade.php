@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Roles <span class="text-secondary fs-4">| Configuraciones</span></h3>
            @can('roles.store')
                <div class="mb-3">
                    <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_rol" data-bs-toggle="modal" data-bs-target="#modal_new_rol"> 
                        <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                        <span>Nuevo Rol</span>
                    </button>
                </div>
            @endcan
            
        </div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="table_roles" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            @if(auth()->user()->can('roles.ver') || auth()->user()->can('roles.update'))
                                <th scope="col">Opciones</th>
                            @endif
                        </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{$rol->id}}</td>
                            <td>{{$rol->name}}</td>

                            @if(auth()->user()->can('roles.ver') || auth()->user()->can('roles.update'))
                                <td>
                                    @can('roles.ver')
                                        <span class="badge bg-secondary ver_permisos" role="button" data-bs-toggle="modal" data-bs-target="#modal_ver_permisos" rol="{{$rol->id}}">
                                            <i class='bx bx-show-alt fs-6'></i>
                                        </span>
                                    @endcan
                                    @can('roles.update')
                                        <span class="badge editar_permisos" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_editar_permisos" rol="{{$rol->id}}">
                                            <i class="bx bx-pencil fs-6"></i>
                                        </span>
                                    @endcan
                                    
                                </td>
                            @endif
                            
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

       
    </div>
   
    


      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* NEW ROL ******** -->
    <div class="modal" id="modal_new_rol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_new_rol">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div> 



    <!-- ********* VER PERMISOS ******** -->
    <div class="modal" id="modal_ver_permisos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_ver_permisos">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div> 

    <!-- ********* EDITAR PERMISOS ******** -->
    <div class="modal" id="modal_editar_permisos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_editar_permisos">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div> 


    <div class="">
        
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

    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <!-- <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script> -->
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_roles').DataTable({
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
            ///////MODAL: ASIGNAR PERMISOS
            $(document).on('click','#new_rol', function(e) { 
                e.preventDefault(e); 

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("roles.modal_new")}}',
                    success: function(response) {       
                        $('#content_new_rol').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: VER PERMISOS
            $(document).on('click','.ver_permisos', function(e) { 
                e.preventDefault(e); 
                var rol = $(this).attr('rol');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("roles.ver")}}',
                    data: {rol:rol},
                    success: function(response) {         
                        console.log(response);  
                        $('#content_ver_permisos').html(response);
                    },
                    error: function() {
                    }
                });
            });


            ///////MODAL: EDITAR PERMISOS
            $(document).on('click','.editar_permisos', function(e) { 
                e.preventDefault(e); 
                var rol = $(this).attr('rol');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("roles.modal_editar")}}',
                    data: {rol:rol},
                    success: function(response) {         
                        $('#content_editar_permisos').html(response);
                    },
                    error: function() {
                    }
                });
            });
        });

        function newRol(){
            var formData = new FormData(document.getElementById("form_new_rol"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("roles.store") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        alert('SE HA REGISTRADO EL ROL CORRECTAMENTE.');
                        window.location.href = "{{ route('roles')}}";
                        
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('Ha ocurrido un error. Vuelva a intentarlo.');
                        }
                    }
                },
                error: function(error){
                    
                }
            });
        }

        function updateRol(){
            var formData = new FormData(document.getElementById("form_update_rol"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("roles.update") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    if (response.success) {
                        alert('SE HA ACTUALIZADO EL ROL CORRECTAMENTE.');
                        window.location.href = "{{ route('roles')}}";
                        
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('Ha ocurrido un error. Vuelva a intentarlo.');
                        }
                    }
                },
                error: function(error){
                    
                }
            });
        }

        
        
      
            
    </script>
@stop