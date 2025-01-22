@extends('adminlte::page')

@section('title', 'Exenciones')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Exenciones <span class="text-secondary fs-4">| Casos abiertos</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="new_exencion" data-bs-toggle="modal" data-bs-target="#modal_new_exencion">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Nueva</span>
                </button>
            </div>
        </div>



        <!-- ESTADOS DE EXENCIONES -->
        <ul class="nav nav-tabs d-flex justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" id="list-proceso-list" data-bs-toggle="list" href="#list-proceso" role="tab" aria-controls="list-proceso">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bxl-telegram fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Por imprimir en Taquilla</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">En Proceso</h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-emitidos-list" data-bs-toggle="list" href="#list-emitidos" role="tab" aria-controls="list-emitidos">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-loader fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Retirar de taquilla</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Emitidos</h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="list-recibidos-list" data-bs-toggle="list" href="#list-recibidos" role="tab" aria-controls="list-recibidos">
                    <div class="d-flex gap-1 py-1 pe-3">
                        <div class="d-flex align-items-end flex-between-center">
                            <i class='bx bx-package fs-2'></i>
                        </div>
                        <div class="ms-2">
                            <h6 class="mb-1 text-700 text-nowrap text-secondary" style="font-size:13px">Para entregar al Contribuyente</h6>
                            <h6 class="mb-0 lh-1 fw-bold text-secondary-emphasis">Recibidos</h6>
                        </div>
                    </div>
                </a>
            </li>
        </ul>







        <!-- contenido - nav - option -->
        <div class="tab-content py-3" id="nav-tabContent">
            <!-- CONTENIDO: EXENCIONES EN PROCESO  -->
            <div class="tab-pane fade show active" id="list-enviar" role="tabpanel" aria-labelledby="list-enviar-list">
               
            </div>


            <!-- CONTENIDO: TIMBRE(S) DE EXENCIONES EMITIDOS-->
            <div class="tab-pane fade" id="list-enviados" role="tabpanel" aria-labelledby="list-enviados-list">
                
            </div>


            <!-- CONTENIDO: TIMBRE(S) DE EXENCIONES RECIBIDOS -->
            <div class="tab-pane fade" id="list-recibidos" role="tabpanel" aria-labelledby="list-recibidos-list">
                
            </div>
        </div>




         
    

        
        

       

        

       
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ************ NUEVA EXENCION ************** -->
    <div class="modal fade" id="modal_new_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_new_exencion">
            
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#asignados_forma14').DataTable(
                {
                    // "order": [[ 0, "desc" ]],
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
        ///////////////////////////////////////AGREGAR CAMPOS A OTRO(S) TRAMITES
            var maxFieldTramite = 3; //Input fields increment limitation
            var c = 1; //Initial field counter is 1

            $(document).on('click', '.add_button_tramite', function(e){ //Once add button is clicked
                if(c < maxFieldTramite){ //Check maximum number of input fields
                    c++; //Increment field counter
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("exenciones.tramites") }}',
                        success: function(response) {
                            $('.tramites').append('<div class="d-flex justify-content-center ">'+
                                        '<div class="row w-100 mt-2">'+
                                            '<div class="col-sm-3">'+
                                                '<select class="form-select form-select-sm ente" nro="'+c+'" id="ente_'+c+'">'+
                                                    response.entes+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-4">'+
                                                '<select class="form-select form-select-sm tramite" name="tramite['+c+'][tramite]" nro="'+c+'" id="tramite_'+c+'" required>'+
                                                    '<option value="">Seleccione el tramite </option>'+
                                                    response.tramites+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-2" id="div_ucd_'+c+'">'+
                                                '<input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_'+c+'" nro="'+c+'" disabled>'+
                                            '</div>'+
                                            '<div class="col-sm-2">'+
                                                '<select class="form-select form-select-sm forma" nro="'+c+'" name="tramite['+c+'][forma]" id="forma_'+c+'" required>'+
                                                    '<option value="">Seleccione</option>'+
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-1">'+
                                                '<a  href="javascript:void(0);" class="btn remove_button_tramite" nro="'+c+'">'+
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
            });

            $(document).on('click', '.remove_button_tramite', function(e){ 
                var nro =  $(this).attr('nro');
                var ente =  $('#ente_'+nro).val();

                if (ente == 4) {
                    var u = 0;
                    $(".ente").each(function(e){
                        var value = $(this).val();
                        if (value == 4) {
                            u++;
                        }
                    });

                    if (u == 1) {
                        $('#content_tamaño').addClass('d-none');
                    }
                    console.log(u);
                }


                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                c--; //Decrement field counter
                calcular();
            });
        ///////////////////////////////////////////////////////////////////


        //////////////////////////// CONDICIÓN SUJETO
        $(document).on('change','#condicion_sujeto', function(e) {
            e.preventDefault(); 
            var value = $(this).val(); 

            $('#identidad_condicion option').remove();

            if (value == "9" || value == "10") {
                $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                '<option value="V">V</option>'+
                                                '<option value="E">E</option>');
            }else{
                $('#identidad_condicion').append('<option>Seleccione</option>'+
                                                '<option value="J">J</option>'+
                                                '<option value="G">G</option>');
            }

        });

        //////////////////////////// BUSCAR CONTRIBUYENTE
        $(document).on('keyup','#identidad_nro', function(e) {
            e.preventDefault(); 
            var value = $(this).val();
            var condicion = $('#identidad_condicion').val();
            var condicion_sujeto = $('#condicion_sujeto').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.search") }}',
                data: {value:value,condicion:condicion,condicion_sujeto:condicion_sujeto},
                success: function(response) {
                    // console.log(response);               
                    if (response.success) {
                        $('#btns_add_contribuyente').addClass('d-none');
                        $('#nombre').val(response.nombre);
                        $('#nombre').attr('disabled', true);


                        $('.ente').attr('disabled', false);
                        $('.tramite').attr('disabled', false);
                        $('.forma').attr('disabled', false);

                        $('.add_button_tramite').removeClass('disabled');
                        $('.add_button').removeClass('disabled');

                        $('#direccion').attr('disabled', false);
                        $('#tlf_movil').attr('disabled', false);
                        $('#tlf_second').attr('disabled', false);

                        $('#metros').attr('disabled', false);
                        $('#btn_calcular_metrado').removeClass('disabled');

                        $('#solicitud_doc').attr('disabled', false);
                        $('#aprobacion_doc').attr('disabled', false);
                        $('#porcentaje').attr('disabled', false);
                        $('#tipo_pago').attr('disabled', false);


                        $('#btn_submit_exencion').removeClass('disabled');

                    }else{
                        $('#btns_add_contribuyente').removeClass('d-none');
                        $('#nombre').attr('disabled', false);
                        $('#nombre').val('');
                        
                        $('.ente').attr('disabled', true);
                        $('.tramite').attr('disabled', true);
                        $('.forma').attr('disabled', true);

                        $('.add_button_tramite').addClass('disabled');
                        $('.add_button').addClass('disabled');

                        $('#direccion').attr('disabled', true);
                        $('#tlf_movil').attr('disabled', true);
                        $('#tlf_second').attr('disabled', true);

                        $('#metros').attr('disabled', true);
                        $('#btn_calcular_metrado').addClass('disabled');

                        $('#solicitud_doc').attr('disabled', true);
                        $('#aprobacion_doc').attr('disabled', true);
                        $('#porcentaje').attr('disabled', true);
                        $('#tipo_pago').attr('disabled', true);

                        $('#sub_total').html('0');
                        $('#exencion').html('0');
                        $('#total').html('0');

                        $('#html_porcentaje').html('%');

                        $('#btn_submit_exencion').addClass('disabled');
                    }
                },
                error: function() {
                }
            });
            
            
        });

        $(document).on('change','#identidad_condicion', function(e) {
            $('#identidad_nro').val('');

            $('#btns_add_contribuyente').removeClass('d-none');
            $('#nombre').attr('disabled', false);
            $('#nombre').val('');
            
            $('.ente').attr('disabled', true);
            $('.tramite').attr('disabled', true);
            $('.forma').attr('disabled', true);

            $('.add_button_tramite').addClass('disabled');
            $('.add_button').addClass('disabled');

            $('#direccion').attr('disabled', true);
            $('#tlf_movil').attr('disabled', true);
            $('#tlf_second').attr('disabled', true);

            $('#metros').attr('disabled', true);
            $('#btn_calcular_metrado').addClass('disabled');

            $('#solicitud_doc').attr('disabled', true);
            $('#aprobacion_doc').attr('disabled', true);
            $('#porcentaje').attr('disabled', true);
            $('#tipo_pago').attr('disabled', true);

            $('#sub_total').html('0');
            $('#exencion').html('0');
            $('#total').html('0');

            $('#html_porcentaje').html('%');


            $('#btn_submit_exencion').addClass('disabled');
        });

        /////////////////////////// BTN REGISTRO CONTRIBUYENTE
        $(document).on('click','#btn_add_contribuyente', function(e) {
            e.preventDefault();
            var condicion_sujeto = $('#condicion_sujeto').val();
            var condicion = $('#identidad_condicion').val();
            var nro = $('#identidad_nro').val();
            var nombre = $('#nombre').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("venta.add_contribuyente") }}',
                data: {condicion:condicion,nro:nro,nombre:nombre,condicion_sujeto:condicion_sujeto},
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        $('#nombre').attr('disabled', true);
                        $('#btns_add_contribuyente').addClass('d-none');
                        alert('REGISTRO DE CONTRIBUYENTE EXITOSO.');


                        $('.ente').attr('disabled', false);
                        $('.tramite').attr('disabled', false);
                        $('.forma').attr('disabled', false);

                        $('.metodo').attr('disabled', false);
                        $('.comprobante').attr('disabled', false);
                        $('.debitado').attr('disabled', false);

                        $('.add_button_tramite').removeClass('disabled');
                        $('.add_button').removeClass('disabled');

                        $('#btn_submit_venta').attr('disabled', false);


                    }else{
                        if (response.nota) {
                            alert(response.nota);
                        }else{
                            alert('Disculpe, ha ocurrido un error al registar a el contribuyente.');
                        }
                        ////alert
                    }   
                },
                error: function() {
                }
            });
        });

        /////////////////////////// BTN CANCELAR REGISTRO CONTRIBUYENTE
        $(document).on('click','#btn_cancel_add_c', function(e) {
            e.preventDefault();
            $('#btns_add_contribuyente').addClass('d-none');
            $('#nombre').attr('disabled', true);

            $('#nombre').val('');
            $('#identidad_nro').val('');
        });



        /////////////////////////// MODAL NEW EXENCIÓN
        $(document).on('click','#new_exencion', function(e) {
            e.preventDefault();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("exenciones.modal_new") }}',
                success: function(response) {
                    // console.log(response);
                    $('#content_new_exencion').html(response);
                },
                error: function() {
                }
            });
        });


        /////////////////////////// VALOR DEL TRAMITE SEGUN EL METRADO Y EL PORCENTAJE
        // METRADO
        $(document).on('click','#btn_calcular_metrado', function(e) {
            e.preventDefault();
            var condicion_sujeto =  $('#condicion_sujeto').val();
            var metros =  $('#metros').val();
            var capital =  0;

            $(".tramite").each(function(e){
                var tramite = $(this).val();
                var nro = $(this).attr('nro');

                var varios_metrado = 0;

                cal_misc(tramite,condicion_sujeto, metros,capital,nro,varios_metrado);
                
            });
        });



        /////////////////////////
        $(document).on('keyup','#porcentaje', function(e) {
            calcular();
        });

       

          
    });


    ///////////////// ADD CAMPO FORMA 
    function forma(nro,ucd) {
        // console.log(nro+'/'+ucd);
        ///////////////////////////  ADD CAMPO FORMA(S)
        $('#forma_'+nro+' option').remove();

        if (ucd < 6) {
            $('#forma_'+nro).append('<option>Seleccione</option>'+
                        '<option value="3">TFE-14</option>'+
                        '<option value="4">Estampilla</option>');
        }else{
            $('#forma_'+nro).append('<option>Seleccione</option>'+
                        '<option value="3">TFE-14</option>');
        }

    }


    //////////////// CALCULO METRADO Y PORCENTAJE
    function cal_misc(tramite,condicion_sujeto, metros,capital,nro){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '{{route("venta.alicuota") }}',
            data: {tramite:tramite,condicion_sujeto:condicion_sujeto,metros:metros,capital:capital},
            success: function(response) {
                console.log(response);

                if (response.success) {
                    switch(response.alicuota) {
                        case 13:
                            /// METRADO
                            $('#content_tamaño').removeClass('d-none');

                            if (response.size == 'small') {
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Pequeña</p>'+
                                                '<p class="text-secondary">*Hasta 150 mts2.</p>');
                            }else if(response.size == 'medium'){
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Mediana</p>'+
                                                '<p class="text-secondary">*Desde 151, Hasta 399 mts2.</p>');
                            }else if(response.size == 'large'){
                                $('#size').html('<p class="fs-4 fw-bold mb-0">Grande</p>'+
                                                '<p class="text-secondary">*Mayor a 400 mts2.</p>');
                            }else{
                                $('#size').html('');
                            }

                            $('#ucd_tramite_'+nro).val(response.valor);
                            forma(nro,response.valor);
                            calcular();
                            
                            break;
                        default:
                            alert('Disculpe, a ocurrido un error. Vuelva a intentarlo.');
                            break;
                    }
                }else{

                }
                
            },
            error: function() {
            }
        });

    }


    ////////////////// CALCULAR TOTAL
     function calcular(){
        var tramites = [];
        $('.tramite').each(function(){
            var t = $(this).val();
            tramites.push(t);
        });

        var metros = $('#metros').val();
        var porcentaje = $('#porcentaje').val();
        // var condicion_sujeto =  $('#condicion_sujeto').val();

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '{{route("exenciones.total") }}',
            data: {tramites:tramites,metros:metros,porcentaje:porcentaje},
            success: function(response) {
                console.log(response);
                $('#sub_total').html(response.sub_total+' UCD');
                $('#exencion').html(response.exencion+' UCD');
                $('#total').html(response.total+' UCD');

                $('#html_porcentaje').html(porcentaje+'%');

                // $('.debitado').val('');
                // $('.comprobante').val('');

                // $('#debitado').html('0.00');
                // $('#vuelto').html('0.00');
                
            },
            error: function() {
            }
        });

        // console.log(tramites);
    }



    //////////////// NUEVA EXENCION
    function newExencion(){
        var formData = new FormData(document.getElementById("form_new_exencion"));
        // console.log("alo");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("exenciones.nueva") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                // if (response.success) {
                //     $('#modal_venta_realizada').modal('show');
                //     $('#content_venta_realizada').html(response.html);
                // }else{
                //     if (response.nota) {
                //         alert(response.nota);
                //     }else{
                //         alert('Disculpe, ha ocurrido un error');
                //     }
                // }
                    
            },
            error: function(error){
                
            }
        });
    }



    


    
    

    </script>


  
@stop