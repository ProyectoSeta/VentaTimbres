@extends('adminlte::page')

@section('title', 'Sujetos Pasivos')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Sujetos Pasivos <span class="text-secondary fs-4">| Registrados</span></h3>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:13px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Rif</th>
                            <!-- <th scope="col">Tipo</th> -->
                            <th scope="col">Razón social</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Telefonos</th>
                            <th scope="col">Representante</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Opciones</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach( $sujeto as $sujeto)               
                        <tr>
                            <td>{{$sujeto->id_sujeto}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $sujeto->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$sujeto->rif_condicion}}-{{$sujeto->rif_nro}}</a>
                            </td>
                            <td class="text-navy fw-bold">{{$sujeto->razon_social}}</td>
                            <td>{{$sujeto->direccion}}</td>
                            <td>{{$sujeto->tlf_movil." - ".$sujeto->tlf_fijo }}</td>
                            <td>
                                <a class="info_representante" role="button" id_sujeto='{{ $sujeto->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_representante">{{$sujeto->name_repr}}</a>
                            </td>
                            <td>
                            @switch($sujeto->estado)
                                        @case('Verificando')
                                            <span class="badge text-bg-secondary p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-error-circle fs-6 me-2'></i>Verificando</span>
                                        @break
                                        @case('Verificado')
                                            <span class="badge text-bg-success p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Verificado</span>
                                        @break
                                        @case('Rechazado')
                                            <span class="badge text-bg-danger p-2 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-x-circle fs-6 me-2'></i>Rechazado</span>
                                        @break
                                    @endswitch
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm rounded-4 px-3 edit_estado_sj" id_sujeto="{{$sujeto->id_sujeto}}" data-bs-toggle="modal" data-bs-target="#modal_edit_estado_sj">Editar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
   
    


      

    
    
  <!--****************** MODALES **************************-->
    <!-- ********* INFO REPRESENTANTE ******** -->
    <div class="modal" id="modal_info_representante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" id="content_modal_repr">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* INFO SUJETO ******** -->
   <div class="modal" id="modal_info_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="html_info_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* EDITAR ESTADO: SUJETO PASIVO ******** -->
    <div class="modal" id="modal_edit_estado_sj" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_estado_sj">
                
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
            $('#example').DataTable({
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
             ///////MODAL: INFO SUJETO PASIVO
             $(document).on('click','.info_sujeto', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.sujeto") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {              
                        $('#html_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });


            ///////MODAL: INFO REPRESENTANTE
            $(document).on('click','.info_representante', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("sujeto.representante") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {            
                        $('#content_modal_repr').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO REPRESENTANTE
            $(document).on('click','.edit_estado_sj', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("sujeto.edit_estado") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {            
                        $('#content_estado_sj').html(response);
                    },
                    error: function() {
                    }
                });
            });

        });

        function editEstadoSP(){
            var formData = new FormData(document.getElementById("form_edit_estado_sp"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("sujeto.update_estado") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('ESTADO ACTUALIZADO CORRECTAMENTE');
                        $('#form_edit_estado_sp')[0].reset();
                        $('#modal_edit_estado_sj').modal('hide');
                        window.location.href = "{{ route('sujeto')}}";
                        
                    }else{
                        alert('Ha ocurrido un error al actualizar el estado del Sujeto Pasivo.');
                    }
                },
                error: function(error){
                    
                }
            });
        }
            
    </script>
@stop