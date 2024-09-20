@extends('adminlte::page')

@section('title', 'Aprobación - Guías Provicionales')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>

    <!-- <img src="{{asset('assets/bf-2.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy titulo">Aprobación - Guías Provicionales</h3>
            <!-- <div class="me-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 fw-bold btn-sm d-flex align-items-center" id="new_solicitud_p" data-bs-toggle="modal" data-bs-target="#modal_solicitud_p">
                    <i class='bx bx-plus fw-bold fs-6 pe-2' ></i>
                    <span>Nueva Solicitud</span>
                </button>
            </div> -->
        </div>
        
        
        <div class="table-responsive" style="font-size:14px">        
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">Cod.</th>
                        <th scope="col">Contribuyente</th>
                        <th scope="col">R.I.F.</th>
                        <th scope="col">Cantera</th>
                        <th scope="col">Cant. Guías</th>
                        <th scope="col">Total UCD</th>
                        <th scope="col">Emisión</th> <!-- fecha -->
                        <th scope="col">Opción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{$solicitud->id_solicitud_reserva}}</td>
                            <td>{{$solicitud->razon_social}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $solicitud->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$solicitud->rif_condicion}}-{{$solicitud->rif_nro}}</a>
                            </td>
                            <td>
                                {{$solicitud->nombre}}
                            </td>
                            <td>
                                <span class="badge text-bg-primary rounded-pill" style="font-size:12.7px">{{$solicitud->cantidad_guias}} Guías</span>
                            </td>
                            <td>{{$solicitud->total_ucd}}</td>
                            <td>{{$solicitud->fecha}}</td>
                            <td class="d-flex">
                                <button class="btn btn-success btn-sm aprobar_solicitud_p rounded-4 me-2" id_solicitud="{{$solicitud->id_solicitud_reserva}}" data-bs-toggle="modal" data-bs-target="#modal_aprobar_solicitud_p">Aprobar</button>
                                <button class="btn btn-danger btn-sm denegar_solicitud rounded-4" id_solicitud="{{$solicitud->id_solicitud_reserva}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_solicitud">Denegar</button>
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
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* APROBAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_aprobar_solicitud_p" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_aprobar_solicitud_p">
                 <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div> 
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

     <!-- ********* SOLICITUD APROBADA: VER CORRELATIVO ******** -->
     <div class="modal fade" id="modal_ver_correlativo_p"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_correlativo_p">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
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
        const myModal = document.getElementById('myModal');
        const myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
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
        $(document).ready(function (){
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


            ///////MODAL: APROBAR SOLICITUD
            $(document).on('click','.aprobar_solicitud_p', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(solicitud);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion_provicional.aprobar") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        // alert(response);
                        // console.log(response);
                        $('#content_aprobar_solicitud_p').html(response);
                    },
                    error: function() {
                    }
                });
            });




             ///////MODAL: APROBAR Y GENERAR CORRELATIVO
             $(document).on('click','.aprobar_correlativo_p', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // var sujeto = $(this).attr('id_sujeto');
                // var fecha = $(this).attr('fecha');
                // var cantera = $(this).attr('id_cantera');

                $('#modal_aprobar_solicitud_p').modal('hide');
                $('#modal_ver_correlativo_p').modal('show');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("aprobacion_provicional.correlativo") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {           
                        console.log(response);
                        // alert(response);
                        if (response.success) {
                           
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("aprobacion_provicional.info") }}',
                                data: {solicitud:solicitud},
                                success: function(response) {           
                                    $('#content_info_correlativo_p').html(response);
                                },
                                error: function() {
                                }
                            });
  
                        }else{
                            alert(response.nota);
                        }
        
                    },
                    error: function() {
                    }
                });
            });

            ////////cerrar modal info correlativo
            $(document).on('click','#cerrar_info_correlativo_p', function(e) { 
                $('#modal_ver_correlativo_p').modal('hide');
                window.location.href = "{{ route('aprobacion_provicional')}}";
            });


           


        });  

        

       

    </script>
@stop