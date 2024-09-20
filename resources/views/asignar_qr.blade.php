@extends('adminlte::page')

@section('title', 'Asignación - QR')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    
    
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        
        <div class="text-start mb-3 d-flex justify-content-between">
            <h3 class="mb-0 pb-0 text-navy fw-bold titulo">QR <span class="text-secondary fs-4">| Asignaciones </span></h3>
            <!-- <h5 class="text-secondary d-flex align-items-center">
                <span>Procesando</span> 
                <i class='bx bx-dots-horizontal-rounded bx-flashing fs-4 ms-2' ></i>
            </h5> -->
        </div>

        <div class="table-responsive" style="font-size:12.7px">
            <div class="d-flex justify-content-center mb-1 mt-2 d-none" id="btn_asignaciones_listas">
                <button class="btn  btn-outline-primary btn-sm d-flex align-items-center" type="button" id="btn_asignaciones_qrlisto" data-bs-toggle="modal" data-bs-target="#modal_qr_listo">
                    <span> Qr Listo</span>
                    <i class='bx bxs-chevron-right ms-1'></i>
                </button>
            </div>

            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th scope="col">
                        <div class="form-check">
                            <input class="form-check-input fs-6" type="checkbox" value="" id="check_all_qrlisto">
                        </div>
                    </th>
                    <th>ID</th>
                    <th>R.I.F.</th>
                    <th>Detalles</th>
                    <th>Cant. Guías</th> 
                    <th>Emisión</th>
                    <th>Soporte</th>
                    <th>QR</th>
                    <th>¿QR Listo?</th> <!-- listo?  -->
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                    @foreach ($asignaciones as $a)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input fs-6 check_listo check_{{$a->id_asignacion}}" type="checkbox" value="{{$a->id_asignacion}}">
                                </div>
                            </td>
                            <td class="text-secondary fw-bold">{{$a->id_asignacion}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $a->id_sujeto }}' tipo="{{ $a->contribuyente }}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$a->rif_condicion}}-{{$a->rif_nro}}</a>
                            </td>
                            <td>
                                <a class="detalle_asignacion" role="button" id_asignacion='{{ $a->id_asignacion }}' tipo="{{ $a->contribuyente }}" data-bs-toggle="modal" data-bs-target="#modal_detalle_asignacion">Ver</a>
                            </td>
                            <td  class="table-primary fw-bold">{{$a->cantidad_guias}} Guías</td>
                            <td class="text-secondary">{{$a->fecha_emision}}</td>
                            <td>
                                <a target="_blank" class="ver_pago" href="{{asset($a->soporte)}}">Ver</a>
                            </td>
                            <td>
                                <a href="#" class="info_guias" role="button" asignacion='{{ $a->id_asignacion }}' data-bs-toggle="modal" data-bs-target="#modal_ver_guias">Ver</a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary qr_listo d-inline-flex align-items-center" id_asignacion="{{$a->id_asignacion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_qr_listo">
                                <i class='bx bxs-chevron-right'></i>
                                </button>
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

    <!-- ********* DETALLES ASIGNACIÓN ******** -->
    <div class="modal fade" id="modal_detalle_asignacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_detalle_asignacion">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- ********* VER QR ******** -->
    <div class="modal" id="modal_ver_qr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-qr fs-1 text-muted'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy" id="exampleModalLabel">Código QR</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px" id="content_ver_qr">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* ASIGNACIONES: QR LISTO ******** -->
    <div class="modal" id="modal_qr_listo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_qr_listo">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

     <!-- ********* VER GUIAS ******** -->
     <div class="modal" id="modal_ver_guias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content" >
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bxs-layer fs-1 text-muted" ></i>                    
                        <h1 class="modal-title text-navy fw-bold fs-5" id="exampleModalLabel">Datos de la Asignación</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px" id="content_ver_guias">
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
            var tipo = $(this).attr('tipo');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.sujeto") }}',
                data: {sujeto:sujeto,tipo:tipo},
                success: function(response) {              
                    $('#html_info_sujeto').html(response);
                },
                error: function() {
                }
            });
        });

        ///////MODAL: DETALLE ASIGNACION
        $(document).on('click','.detalle_asignacion', function(e) { 
            e.preventDefault(e); 
            var asignacion = $(this).attr('id_asignacion');
            var tipo = $(this).attr('tipo');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.detalle") }}',
                data: {asignacion:asignacion,tipo:tipo},
                success: function(response) {              
                    $('#content_detalle_asignacion').html(response);
                },
                error: function() {
                }
            });
        });


        ///////MODAL: QR
        $(document).on('click','.qr', function(e) { 
            e.preventDefault(e); 
            var ruta = $(this).attr('ruta');
            var talonario = 'resreva';
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("correlativo.qr") }}',
                data: {ruta:ruta,talonario:talonario},
                success: function(response) {   
                    $('#content_ver_qr').html(response);
                    
                },
                error: function() {
                }
            });
        });

        
        
        ////////////////////////////////////////////////////QR LISTO////////////////////////////////////////////////////////////
        $i = 0;
        $o = 0;
        ////////SELECCIONAR TODOS LOS CHECKBOX
        $('#check_all_qrlisto').change(function() {
            var checkboxes = $('input:checkbox').length;
            if ($(this).is(':checked')) {
                $('#btn_asignaciones_listas').removeClass('d-none');
                $(".check_listo").attr('disabled', true);
                $o = checkboxes - 1;
            }else{
                $('#btn_asignaciones_listas').addClass('d-none');
                $(".check_listo").attr('disabled', false);
                $o = 0;
            }
            $('.check_listo').prop('checked', $(this).is(':checked'));
        });

        /////////SELECCIONAR CHECKBOX
        $('.check_listo').change(function() {
            if ($(this).is(':checked')) {
                $o++;
            }else{
                $o--;
            }
            // /////////////////////////
            if ($o <= 1) {
                $('#btn_asignaciones_listas').addClass('d-none');
                $(".qr_listo").attr('disabled', false);
            }else{
                $('#btn_asignaciones_listas').removeClass('d-none');
                $(".qr_listo").attr('disabled', true);
            }
        });

        ///////SELECCIONAR ASIGNACIONES: QR LISTO
        $(document).on('click','.qr_listo', function(e) { 
            e.preventDefault(e); 
            var asignaciones = [];
            var id_asignacion = $(this).attr('id_asignacion');

            asignaciones.push(id_asignacion);
            $i++;
        
            $(".check_"+id_asignacion).prop("checked", true);
            $('input[type="checkbox"]').not(".check_"+id_asignacion).prop('checked', false);

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar_qr.modal_qrlisto") }}',
                data: {asignaciones:asignaciones},
                success: function(response) {        

                    $('#content_qr_listo').html(response);

                    //////////////////////////////////////////////////////////////
                    $(document).on('click','#btn_aceptar_qrlisto', function(e) {
                        // console.log(talonarios);
                        $("#btn_aceptar_qrlisto").attr('disabled', true);                            
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("asignar_qr.qrlisto") }}',
                            data: {asignaciones:asignaciones},
                            success: function(response) {  
                                if (response.success) {
                                    alert("ACTUALIZACIÓN DE ESTADO EXITOSO");
                                    window.location.href = "{{ route('asignar_qr')}}";
                                }else{
                                    alert("ERROR AL ACTUALIZAR EL ESTADO");
                                }     
                                
                            },
                            error: function() {
                            }
                        });
                    }); 
                    //////////////////////////////////////////////////////////////
                },
                error: function() {
                }
            });
            
        });

        ///////////////// MODAL: QR LISTO
        $(document).on('click','#btn_asignaciones_qrlisto', function(e) { 
            e.preventDefault(e); 
            var asignaciones = [];

            $("input[type=checkbox]:checked").each(function() {
                asignaciones.push($(this).val());
            });

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar_qr.modal_qrlisto") }}',
                data: {asignaciones:asignaciones},
                success: function(response) {        

                    $('#content_qr_listo').html(response);

                    //////////////////////////////////////////////////////////////
                    $(document).on('click','#btn_aceptar_qrlisto', function(e) {
                        // console.log(talonarios);
                        $("#btn_aceptar_qrlisto").attr('disabled', true);                            
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("asignar_qr.qrlisto") }}',
                            data: {asignaciones:asignaciones},
                            success: function(response) {  
                                console.log(response);
                                if (response.success) {
                                    alert("ACTUALIZACIÓN DE ESTADO EXITOSO");
                                    window.location.href = "{{ route('asignar_qr')}}";
                                }else{
                                    alert("ERROR AL ACTUALIZAR EL ESTADO");
                                }     
                                
                            },
                            error: function() {
                            }
                        });
                    }); 
                    //////////////////////////////////////////////////////////////
                },
                error: function() {
                }
            });
        });

        ///////MODAL: INFO TALONARIO
        $(document).on('click','.info_guias', function(e) { 
            e.preventDefault(e); 
            var asignacion = $(this).attr('asignacion');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar_qr.modal_guias") }}',
                data: {asignacion:asignacion},
                success: function(response) {              
                //    console.log(response);
                        $('#content_ver_guias').html(response);
                        $('#tableGuias').DataTable();

                    
                },
                error: function() {
                }
            });
        });

    });

    

    



    </script>


  
@stop