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
            <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-plus-circle fs-2 text-muted me-2"></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Nueva Exención</h1>
                    </div>
                </div> 
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <form id="form_new_exencion" method="post" onsubmit="event.preventDefault(); newExencion()">
                        <!-- *************   DATOS CONTRIBUYENTE   ************* -->
                        <div class="text-navy text-center fw-bold fs-6 mb-3">Datos del Contribuyente</div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label" for="condicion_sujeto">Condición</label><span class="text-danger">*</span>
                                <select class="form-select form-select-sm" id="condicion_sujeto" aria-label="Small select example" name="condicion_sujeto">
                                    <option>Seleccione</option>
                                    <option value="9">Natural</option>
                                    <option value="10">Firma Personal</option>
                                    <option value="11">Ente</option>
                                </select>
                            </div>
                            <!-- ci o rif -->
                            <div class="col-md-5">
                                <label class="form-label" for="identidad_condicion">C.I / R.I.F</label><span class="text-danger">*</span>
                                <div class="row">
                                    <div class="col-5">
                                        <select class="form-select form-select-sm" id="identidad_condicion" aria-label="Small select example" name="identidad_condicion">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-1">-</div> -->
                                    <div class="col-7">
                                        <input type="number" id="identidad_nro" class="form-control form-control-sm" name="identidad_nro" required >
                                        <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 7521004</p>
                                    </div>
                                </div>
                            </div>
                            <!-- nombre o razon -->
                            <div class="col-md-4">
                                <label class="form-label" for="nombre">Nombre / Razon Social</label><span class="text-danger">*</span>
                                <input type="text" id="nombre" class="form-control form-control-sm" name="nombre" disabled required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3 d-none" id="btns_add_contribuyente">
                            <button type="button" class="btn btn-secondary btn-sm me-3" id="btn_cancel_add_c">Cancelar</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_add_contribuyente">Registrar</button>
                        </div>
                        
                        <!-- direccion y telefonos -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="direccion">Dirección</label><span class="text-danger">*</span>
                                <input type="text" id="direccion" class="form-control form-control-sm" name="direccion" required >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="tlf_movil">Teléfono móvil</label><span class="text-danger">*</span>
                                <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" required >
                                <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 04120038547</p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label" for="tlf_second">Teléfono secundario</label>
                                <input type="number" id="tlf_second" class="form-control form-control-sm" name="tlf_second">
                                <p class="text-end text-muted fw-bold mb-0" style="font-size:12px;">Ejemplo: 04120038547</p>
                            </div>
                        </div>



                        <!-- *************   TRAMITE   ************* -->
                        <div class="text-navy text-center fw-bold fs-6 mt-5 mb-2">Tramite(s)</div>
                        <div class="d-flex flex-column tramites">
                            <div class="d-flex justify-content-center">
                                <div class="row  w-100">
                                    <div class="col-sm-3">
                                        <label class="form-label" for="ente">Ente</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm ente" nro="1" id="ente_1" disabled>
                                            
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="tramite">Tramite</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm tramite" name="tramite[1][tramite]" nro="1" id="tramite_1" disabled>
                                            <option value="">Seleccione el tramite </option>
                                                
                                        </select>
                                    </div>
                                    <div class="col-sm-2" id="div_ucd_1">
                                        <label class="form-label" for="ucd_tramite">UCD</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control form-control-sm ucd_tramite" id="ucd_tramite_1" nro="1" disabled required>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label" for="forma">Timbre</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm forma" nro="1" name="tramite[1][forma]"id="forma_1" required>
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 pt-4">
                                        <a  href="javascript:void(0);" class="btn add_button_tramite disabled border-0">
                                            <i class="bx bx-plus fs-4" style="color:#038ae4"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- *************   DATOS DE LA EXENCION   ************* -->
                        <div class="text-navy text-center fw-bold fs-6 mt-5 mb-2">Datos de la Exención</div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="solicitud_doc" class="form-label">Solicitud (Documento)</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" id="solicitud_doc" type="file" name="solicitud_doc" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="aprobacion_doc" class="form-label">Aprobación (Documento)</label><span class="text-danger">*</span>
                                        <input class="form-control form-control-sm" id="aprobacion_doc" type="file" name="aprobacion_doc" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-label" for="porcentaje">Porcentaje (1-90%)</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control form-control-sm " id="porcentaje" name="porcentaje" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="tipo_forma">Tipo de Pago</label><span class="text-danger">*</span>
                                        <select class="form-select form-select-sm" name="tipo_forma" id="tipo_forma" required>
                                            <option value="">Deposito</option>
                                            <option value="">Obra</option>
                                            <option value="">Bien</option>
                                            <option value="">Servicio</option>
                                            <option value="">Suministros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- total -->
                            <div class="col-md-4 px-4 fw-bold titulo">
                                <div class="text-center fs-6 mb-3 text-muted">TOTAL</div>
                                <table class="table table-borderless fs-5">
                                    <tr>
                                        <th>UCD</th>
                                        <td class="text-end text-navy">500</td>
                                    </tr>
                                    <tr>
                                        <th>Bs.</th>
                                        <td class="text-end text-navy">2.045.000,02</td>
                                    </tr>
                                </table>
                            </div>
                        </div>                  

                       

                        <div class="d-flex justify-content-center mt-4 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
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
                    $('.tramites').append('<div class="d-flex justify-content-center ">'+
                                        '<div class="row w-100 mt-2">'+
                                            '<div class="col-sm-3">'+
                                                '<select class="form-select form-select-sm ente" nro="'+c+'" id="ente_'+c+'">'+
                                                
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-sm-4">'+
                                                '<select class="form-select form-select-sm tramite" name="tramite['+c+'][tramite]" nro="'+c+'" id="tramite_'+c+'" required>'+
                                                    '<option value="">Seleccione el tramite </option>'+
                                                        
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

                        $('.metodo').attr('disabled', false);
                        $('.comprobante').attr('disabled', false);
                        $('.debitado').attr('disabled', false);

                        $('.add_button_tramite').removeClass('disabled');
                        $('.add_button').removeClass('disabled');

                        $('#btn_submit_venta').attr('disabled', false);

                    }else{
                        $('#btns_add_contribuyente').removeClass('d-none');
                        $('#nombre').attr('disabled', false);
                        $('#nombre').val('');
                        
                        $('.ente').attr('disabled', true);
                        $('.tramite').attr('disabled', true);
                        $('.forma').attr('disabled', true);

                        $('.metodo').attr('disabled', true);
                        $('.comprobante').attr('disabled', true);
                        $('.debitado').attr('disabled', true);

                        $('.add_button_tramite').addClass('disabled');
                        $('.add_button').addClass('disabled');

                        $('#btn_submit_venta').attr('disabled', true);
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

            $('.metodo').attr('disabled', true);
            $('.comprobante').attr('disabled', true);
            $('.debitado').attr('disabled', true);

            $('.add_button_tramite').addClass('disabled');
            $('.add_button').addClass('disabled');

            $('#btn_submit_venta').attr('disabled', true);
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

       

          
    });


    


    
    

    </script>


  
@stop