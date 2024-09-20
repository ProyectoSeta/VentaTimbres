@extends('adminlte::page')

@section('title', 'Aprobacion - Solicitudes')

@section('content_header')
 
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3 pt-0" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h3 class="mb-3 text-navy fw-bold titulo">Aprobación <span class="text-secondary fs-4">| Solicitudes </span></h3>

            <div class="row w-50 d-flex justify-content-end">
                <div class="col-sm-7">
                    <div class="card shadow-none border-light-subtle">
                        <div class="card-body px-3 py-2">
                            <h3 class="d-flex align-items-center justify-content-between mb-0 pb-1">
                                <div class="p-2 border border-warning-subtle grd-warning-light rounded-5 d-flex">
                                    <i class='bx bx-error-circle bx-tada fs-3' style="color:#ff8f00"></i>
                                </div>
                                <div class="d-flex flex-column text-center">
                                    <span class="fs-6 pb-1">Solicitudes Pendientes</span>
                                    <span class="" style="color:#ff8f00">{{$count_aprobar->total}}</span> 
                                </div>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive" style="font-size:12.7px">
            <table id="example" class="table border-light-subtle text-center" style="font-size:12.7px">
                <thead class="border-light-subtle">
                    <th>Cod.</th>
                    <th>Cantera</th>
                    <th>Razón Social</th>
                    <th>R.I.F.</th>
                    <th>Solicitud</th>
                    <th>UCD</th>
                    <th>Emisión</th>
                    <th>Opciones</th>
                </thead>
                <tbody> 
                
                @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{$solicitud->id_solicitud}}</td>
                            <td class="fw-bold">{{$solicitud->nombre}}</td>
                            <td>
                                {{$solicitud->razon_social}}
                            </td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $solicitud->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$solicitud->rif_condicion}}-{{$solicitud->rif_nro}}</a>
                            </td>
                            <td>
                                <a class="text-primary info_talonario" role="button" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</a>
                            </td>
                            <td>
                                <span>{{$solicitud->total_ucd}} UCD</span>
                            </td>
                            @php
                                $separar = (explode(" ",$solicitud->fecha));
                                $fecha = $separar[0];
                            @endphp
                            <td class="text-muted">{{$fecha}}</td>
                            
                            <td class="d-flex">
                                <button class="btn btn-success btn-sm aprobar_solicitud rounded-4 me-2" id_cantera="{{$solicitud->id_cantera}}" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_aprobar_solicitud">Aprobar</button>
                                <button class="btn btn-danger btn-sm denegar_solicitud rounded-4" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_solicitud">Denegar</button>
                            </td>
                        </tr>
                @endforeach
                            
                    
                </tbody> 
                
            </table>
            
        </div>

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
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

    <!-- ********* VER INFO TALONARIO(S) ******** -->
    <div class="modal fade" id="modal_info_talonario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_talonarios">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* APROBAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_aprobar_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_aprobar_solicitud">
                            
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* SOLICITUD APROBADA: VER CORRELATIVO ******** -->
    <div class="modal fade" id="modal_ver_correlativo"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_correlativo">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* DENEGAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_denegar_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_denegar_solicitud">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
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
            $('#example').DataTable(
                {
                    "order": [[ 0, "desc" ]],
                    "language": {
                        "lengthMenu": " Mostrar  _MENU_  Registros por página",
                        "zeroRecords": "No hay Solicitudes por Aprobar",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "No hay Solicitudes por Aprobar",
                        "infoFiltered": "(filtered from _MAX_ total records)",
                        'search':"Buscar",
                        'paginate':{
                            'next':'Siguiente',
                            'previous':'Anterior'
                        }
                    }
                }
            );

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

            ///////MODAL: INFO TALONARIOS
            $(document).on('click','.info_talonario', function(e) { 
                e.preventDefault(e); 
                var id = $(this).attr('id_solicitud');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.talonarios") }}',
                    data: {id:id},
                    success: function(response) {              
                        $('#content_info_talonarios').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: APROBAR SOLICITUD
            $(document).on('click','.aprobar_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var cantera = $(this).attr('id_cantera');
                // alert(solicitud);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.aprobar") }}',
                    data: {solicitud:solicitud,cantera:cantera},
                    success: function(response) {           
                        // alert(response);
                        // console.log(response);
                        $('#content_aprobar_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: APROBAR Y GENERAR CORRELATIVO
            $(document).on('click','.aprobar_correlativo', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var sujeto = $(this).attr('id_sujeto');
                var emitir = $('#emitir_talonarios').val();
                var cantera = $(this).attr('id_cantera');

                $('#modal_aprobar_solicitud').modal('hide');
                $('#modal_ver_correlativo').modal('show');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.correlativo") }}',
                    data: {solicitud:solicitud, sujeto:sujeto, emitir:emitir, cantera:cantera},
                    success: function(response) {           
                        console.log(response);
                        // alert(response);
                        if (response.success) {
                           
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("aprobacion.info") }}',
                                data: {solicitud:solicitud},
                                success: function(response) {           
                                    $('#content_info_correlativo').html(response);
                                },
                                error: function() {
                                }
                            });
  
                        }else {
                            if (response.nota != '') {
                                alert(response.nota);
                            }else{
                                alert('Ha ocurrido un error al aprobar la solicitud');
                            }
                            window.location.href = "{{ route('aprobacion')}}";
                            
                        }
        
                    },
                    error: function() {
                    }
                });
            });

            ////////cerrar modal info correlativo
            $(document).on('click','#cerrar_info_correlativo', function(e) { 
                $('#modal_ver_correlativo').modal('hide');
                window.location.href = "{{ route('aprobacion')}}";
            });
            
            ///////MODAL: DENEGAR SOLICITUD
            $(document).on('click','.denegar_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.denegarInfo") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        $('#content_denegar_solicitud').html(response);
                    },
                    error: function() {
                    }
                });
            });

            $(document).on('keyup','#emitir_talonarios', function(e) {  
                var cant = $(this).val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion.min_talonarios") }}',
                    data: {cant:cant},
                    success: function(response) {     

                        if (response.success) {
                            $(".aprobar_correlativo").attr('disabled', false);
                        }else{
                            $(".aprobar_correlativo").attr('disabled', true);
                        }
                    },
                    error: function() {
                    }
                });

               

               
                // console.log(cant);
            });

        });


        function denegarSolicitud(){
            var formData = new FormData(document.getElementById("form_denegar_solicitud"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("aprobacion.denegar") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        // console.log(response);
                        if (response.success) {
                            alert('LA SOLICITUD HA SIDO DENEGADA CORRECTAMENTE');
                            window.location.href = "{{ route('aprobacion')}}";
                        } else {
                            alert('Ha ocurrido un error al denegar la solicitud.');
                        }  

                    },
                    error: function(error){
                        
                    }
                });
        }


    </script>
  
@stop