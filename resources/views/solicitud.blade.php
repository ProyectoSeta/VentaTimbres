@extends('adminlte::page')

@section('title', 'Solicitud de Guías')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>

    <!-- <img src="{{asset('assets/bf-2.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy titulo fw-bold">Solicitud de Guías</h3>
            <div class="me-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 fw-bold btn-sm d-flex align-items-center" id="new_solicitud" data-bs-toggle="modal" data-bs-target="#modal_new_solicitud">
                    <i class='bx bx-plus fw-bold fs-6 pe-2' ></i>
                    <span>Nueva solicitud</span>
                </button>
            </div>
        </div>
        
        
        <div class="table-responsive" style="font-size:14px">        
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">Cod.</th>
                        <th scope="col">Cantera</th>
                        <th scope="col">Fecha de emisión</th>
                        <th scope="col">Solicitud</th>
                        <!-- <th scope="col">Pago</th> -->
                        <th scope="col">Total UCD</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $solicitudes as $solicitud)               
                        <tr>
                            <td>{{$solicitud->id_solicitud}}</td>
                            <td class="fw-bold">{{$solicitud->nombre}}</td>
                            <td class="text-secondary">{{$solicitud->fecha}}</td>
                            <td>
                                <a class="text-primary info_talonario" role="button" id_solicitud="{{$solicitud->id_solicitud}}" data-bs-toggle="modal" data-bs-target="#modal_info_talonario">Ver</a>
                            </td>
                            <td>
                                <span>{{$solicitud->total_ucd}} UCD</span>
                            <td>
                                @switch($solicitud->estado)
                                    @case('4') <!-- verificando -->
                                        <span class="badge text-bg-secondary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-error-circle fs-6 me-2'></i>Verificando solicitud</span>
                                    @break
                                    @case('6')  <!-- negada -->
                                        <span role="button" class="badge text-bg-danger p-2 py-1 d-flex justify-content-center align-items-center solicitud_denegada" style="font-size: 12px;" data-bs-toggle="modal" data-bs-target="#modal_info_denegada" id_solicitud='{{ $solicitud->id_solicitud }}'><i class='bx bx-x-circle fs-6 me-2'></i>Negada</span>
                                    @break
                                    @case('17')  <!-- en proceso -->
                                        <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                    @break
                                    @case('18')  <!-- por retirar -->
                                    <span class="badge text-bg-warning p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;background-color: #ef7f00;"><i class='bx bx-error-circle fs-6 me-2'></i>Retirar Talonario(s)</span>
                                    @break
                                    @case('19') <!-- entregado -->
                                    <span class="badge text-bg-success p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Retirado</span>
                                    @break
                                    
                    
                                @endswitch                    
                            </td>
                            <td>
                                @if ($solicitud->estado == '4')
                                    <span class="badge delete_solicitud" style="background-color: #ed0000;" role="button" id_cantera="{{$solicitud->id_cantera}}" id_solicitud="{{$solicitud->id_solicitud}}">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @else
                                    <span class="badge" style="background-color: #ed00008c;">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
    

    
    
  <!--****************** MODALES **************************-->
    <!-- ********* NUEVA SOLICITUD ******** -->
    <div class="modal fade" id="modal_new_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-navy" id="exampleModalLabel">
                    <!-- <i class='bx bxs-file-plus'></i> -->
                        Solicitud de Guías - Talonario
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mx-2" style="font-size:14px;" id="content_info_new">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>  <!-- cierra modal-body -->
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

    <!-- *********INFO SOLICITUD DENEGADA ******** -->
    <div class="modal" id="modal_info_denegada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_denegada">
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
           
            ///////MODAL: REALIZAR SOLICITUD
            $(document).on('click','#new_solicitud', function(e) { 
                e.preventDefault(e); 
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.new_solicitud") }}',
                    success: function(response) {              
                        $('#content_info_new').html(response);
                    },
                    error: function() {
                    }
                });
            });

            // ///////MODAL: INFO TALONARIOS
            // $(document).on('click','#calcular', function(e) { 
            //     e.preventDefault(e); 
            //     var cant = $('#cantidad').val();
            //     $.ajax({
            //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //         type: 'POST',
            //         url: '{{route("solicitud.talonarios") }}',
            //         data: {cant:cant},
            //         success: function(response) {    
            //             // console.log(response);          
            //             $('#content_info_talonarios').html(response);
            //         },
            //         error: function() {
            //         }
            //     });
            // });

            //////////////////CALCULAR LOS UCD A PAGAR
            $(document).on('click','#calcular', function(e) { 
                e.preventDefault(e); 
                var cant = $('#cantidad').val();
                // console.log(cant);

                if (cant != 0) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("solicitud.calcular") }}',
                        data: {cant:cant},
                        success: function(response) {
                            
                            $('#total_ucd').html(response.ucd+' UCD');
                            // $('#precio_ucd').html(response.precio_ucd+' Bs.');
                            // $('.total_pagar').html(response.total+' Bs.');

                            // $('#id_ucd').val(response.id_ucd);
                            // $('#ucd').val(response.ucd);
                            // $('#monto_total').val(response.total);

                            // $('#banco_emisor').attr('disabled', false); 
                            // $('#banco_receptor').attr('disabled', false); 
                            // $('#nro_referencia').attr('disabled', false);  
                            // $('#fecha_emision').attr('disabled', false); 
                            // $('#monto_trans').attr('disabled', false); 

                            // $('#ref_pago').attr('disabled', false); 
                        },
                        error: function() {
                        }
                    });
                }
                
                

            });

            ////////////////////
            $(document).on('keyup','#cantidad', function(e) {  
                var cant = $(this).val();
                if (cant == 0) {
                    // $('#ref_pago').attr('disabled', true);
                    $("#btn_cancelar").attr('disabled', true);
                    $("#btn_generar_solicitud").attr('disabled', true);

                    // $('#banco_emisor').attr('disabled', true); 
                    // $('#banco_receptor').attr('disabled', true); 
                    // $('#nro_referencia').attr('disabled', true); 
                    // $('#fecha_emision').attr('disabled', true); 
                    // $('#monto_trans').attr('disabled', true); 

                    $('#total_ucd').html('0 UCD');
                    // $('#precio_ucd').html('0 Bs.');
                    // $('.total_pagar').html('0 Bs.');
                }
                console.log(cant);
            });

            // ////////HABILITAR EL BUTTON PARA GENERAR LA SOLICITUD
            // $(document).on('change','#', function(e) {
            //     e.preventDefault(); 
            //     var value = $(this).val();
            //     console.log(value);
            //     if (value != '') {
            //         $('#btn_generar_solicitud').attr('disabled', false);
            //     }else{
            //         $('#btn_generar_solicitud').attr('disabled', true);
            //     }
            // });



            ////////////////////CALCULAR LOS UCD A PAGAR
            $(document).on('click','#calcular', function(e) { 
                e.preventDefault(e); 
                var cant = $('#cantidad').val();
                // console.log(cant);

                if (cant == '' || cant == 0) {
                    $('#total_ucd').html('0 UCD');
                }else{
                    var total_guias = cant * 50;
                    var total_ucd = total_guias * 5;
                    $('#total_ucd').html(total_ucd +' UCD');

                    $("#btn_cancelar").attr('disabled', false);
                    $("#btn_generar_solicitud").attr('disabled', false);
                }
            });

            ////////////////////
            $(document).on('keyup','#cantidad', function(e) {  
                var cant = $(this).val();
                if (cant == 0) {
                    $("#btn_cancelar").attr('disabled', true);
                    $("#btn_generar_solicitud").attr('disabled', true);
                }
                // console.log(cant);
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
                        // console.log(response);          
                        $('#content_info_talonarios').html(response);
                    },
                    error: function() {
                    }
                });
            });


            //////ELIMINAR SOLICITUD
            $(document).on('click','.delete_solicitud', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                var cantera = $(this).attr('id_cantera');
                
                if (confirm("¿ESTA SEGURO QUE DESEA ELIMINAR LA SOLICITUD CON EL CÓDIGO:   " + solicitud + "?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("solicitud.destroy") }}',
                        data: {solicitud:solicitud,cantera:cantera},
                        success: function(response) {
                        //    console.log(response);
                            if (response.success){
                                alert("SOLICITUD ELIMINADA EXITOSAMENTE");
                                window.location.href = "{{ route('solicitud')}}";
                            } else{
                                alert("SE HA PRODUCIDO UN ERROR AL ELIMINAR LA SOLICITUD");
                            }              
                        },
                        error: function() {
                        }
                    });
                }else{

                }
                
            });

             ///////MODAL: INFO SOLICITUD DENEGADA
             $(document).on('click','.solicitud_denegada', function(e) { 
                e.preventDefault(e); 
                var solicitud = $(this).attr('id_solicitud');
                // alert(cantera);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("estado.info_denegada") }}',
                    data: {solicitud:solicitud},
                    success: function(response) {
                        // console.log(response);               
                        $('#content_info_denegada').html(response);
                    },
                    error: function() {
                    }
                });
            });





        });  

        function generarSolicitud(){
                var formData = new FormData(document.getElementById("form_generar_solicitud"));
                $('#btn_generar_solicitud').attr('disabled', true);
                // alert(formData);
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("solicitud.store") }}',
                    data: formData,
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    success: function(response) {
                        // console.log(response);
                       if (response.success) {
                            alert('La solicitud a sido generada exitosamente!');
                            $('#form_generar_solicitud')[0].reset();
                            $('#modal_new_solicitud').modal('hide');
                            window.location.href = "{{ route('solicitud')}}";   
                        }else{
                            alert(response.nota);
                       }
                    },
                    error: function() {
                    }
                });
        }

    </script>
@stop