@extends('adminlte::page')

@section('title', 'Asignar Guías')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script> -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    
    
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <section id="html_asignar_guias">
            <div class="text-center mb-2">
                <h3 class="mb-1 text-navy titulo fw-bold">Asignación de Guías</h3>
                <span class="text-secondary fw-bold">Talonarios de Reserva</span>
            </div>

            <div style="font-size:12.7px">
                <p class="text-secondary text-justify my-4" style="font-size:12.7px">
                    <span class="fw-bold">*Recordatorio:</span> Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Officiis non totam repellendus sunt delectus, doloremque vero officia deleniti, distinctio rerum, atque inventore neque. 
                    Omnis, debitis voluptatem excepturi vitae obcaecati facilis.
                </p>

                <div class="d-flex justify-content-center">
                    <div class="w-50">
                        <label class="form-label mb-3" for="rif">
                            <span style="color:red">*</span> Ingrese el R.I.F del contribuyente al que va dirigida la asignación: 
                        </label>

                        <div class="row mb-4">
                            <div class="col-3">
                                <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion">
                                    <option value="G" id="rif_gubernamental">G</option>
                                    <option value="J" id="rif_juridico">J</option>
                                </select>
                            </div>
                            <div class="col-1">-</div>
                            <div class="col-6">
                                <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" autofocus value="{{ old('rif_nro') }}"/>
                                <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-secondary btn-sm pb-0" id="search_sujeto_asignar" >
                                    <i class='bx bx-search-alt-2 fs-5'></i>
                                </button>
                            </div>
                        </div>

                        <div id="content-search-sujeto">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="html_table_asignaciones">
            <div class="text-start mb-3 mt-5 d-flex justify-content-between">
                <h3 class="mb-0 pb-0 text-navy titulo fw-bold">Guías Asignadas <span class="text-secondary fs-4">| Reservas</span></h3>
                <h5 class="text-secondary d-flex align-items-center">
                    <span>Procesando</span> 
                    <i class='bx bx-dots-horizontal-rounded bx-flashing fs-4 ms-2' ></i>
                </h5>
            </div>

            <div class="table-responsive" style="font-size:12.7px">
                <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                    <thead>
                        <th>#</th>
                        <th>R.I.F.</th>
                        <th>Detalles</th>
                        <th>Cant. Guías</th> 
                        <th>Emisión</th>
                        <th>Soporte</th>
                        <th>Estado</th>
                        <th>¿Entregado?</th> <!-- entregado?  -->
                    </thead>
                    <tbody id="list_canteras" class="border-light-subtle"> 
                        @foreach ($asignaciones as $a)
                            <tr>
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
                                @switch($a->estado)
                                        @case('17')  
                                            <span class="badge text-bg-primary p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-history fs-6 me-2'></i>En proceso</span>
                                        @break
                                        @case('29')  
                                            <span class="badge text-bg-warning p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;background-color: #ef7f00;"><i class='bx bx-error-circle fs-6 me-2'></i>QR Listo</span>
                                        @break
                                        @case('19')  
                                            <span class="badge text-bg-success p-2 py-1 d-flex justify-content-center align-items-center" style="font-size: 12px;"><i class='bx bx-check-circle fs-6 me-2'></i>Entregado</span>
                                        @break
                                    @default
                                        
                                @endswitch
                                </td>
                                <td>
                                    @if ($a->estado == 17)
                                            <button class="btn btn-sm btn-success d-inline-flex align-items-center" disabled type="button">
                                                <i class="bx bx-check"></i>
                                            </button>
                                    @else
                                        <button class="btn btn-sm btn-success d-inline-flex align-items-center " id_asignacion="{{$a->id_asignacion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_asignacion_entregada">
                                            <i class="bx bx-check"></i>
                                        </button>
                                    @endif

                                    @if ($a->delete_a == '1')
                                        <button class="btn btn-sm btn-danger d-inline-flex align-items-center delete_asignacion" role="button" id_asignacion="{{$a->id_asignacion}}">
                                            <i class="bx bx-trash-alt"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-danger d-inline-flex align-items-center" disabled>
                                            <i class="bx bx-trash-alt"></i>
                                        </button>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody> 
                    
                </table>
                
            </div>
        </section>        
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

    <!-- ********* ASIGNACIÓN: SUJETO REGISTRADO (USER O NOTUSER)******** -->
    <div class="modal fade" id="modal_asignar_sujeto_registrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_asignar_sujeto_registrado">
                <div class="py-4 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* ASIGNACIÓN: SUJETO NO REGISTRADO ******** -->
    <div class="modal fade" id="modal_asignar_sujeto_no_registrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_ver_solicitud">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-navy fw-bold d-flex align-items-center" id="exampleModalLabel" ><i class='bx bx-customize me-2 text-muted fs-2'></i>Asignación de Guías</h1>
                </div>

                <div class="modal-body " style="font-size:12.7px">
                    <form id="form_asignar_guias_notregister" method="post" onsubmit="event.preventDefault(); asignarGuiasNotregister();">
                        <div class="row px-4">
                            <div class="col-sm-6">  <!-- ********************************************************************* -->
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Datos del Contribuyente</span>
                                </div>

                                <label class="form-label" for="rif">R.I.F.</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="rif_condicion" aria-label="Default select example" name="rif_condicion" required>
                                            <option value="G" id="rif_gubernamental">G</option>
                                            <option value="J" id="rif_juridico">J</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="rif" class="form-control form-control-sm" name="rif_nro" placeholder="Ejemplo: 30563223" required/>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 30563223</p>
                                    </div>
                                </div>
                                
                                <!-- razon social input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="razon_social">Razon Social</label><span class="text-danger"> *</span>
                                    <input type="text" id="razon_social" class="form-control form-control-sm" name="razon_social" required>
                                </div>

                                <!-- direccion input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="direccion">Dirección</label><span class="text-danger"> *</span>
                                    <input type="text" id="direccion" class="form-control form-control-sm" name="direccion" required/>
                                </div>

                                <!-- tlf movil input -->
                                <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_movil">Teléfono Movil</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_movil" class="form-control form-control-sm" name="tlf_movil" placeholder="Ejemplo: 04125231102" required >
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>

                                <!-- ci:repr input -->
                                <label class="form-label" for="ci_repr">Cédula del Representante</label><span class="text-danger"> *</span>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-select form-select-sm" id="ci_condicion_repr" aria-label="Default select example" name="ci_condicion_repr" required>
                                            <option value="V">V</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="col-1">-</div>
                                    <div class="col-8">
                                        <input type="number" id="ci_nro_repr" class="form-control form-control-sm" name="ci_nro_repr" placeholder="Ejemplo: 8456122" required>
                                        <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 8456122</p>
                                    </div>
                                </div>

                                 <!-- nombre:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="name_repr">Nombre del Representante</label><span class="text-danger"> *</span>
                                    <input type="text" id="name_repr" class="form-control form-control-sm" name="name_repr" required>
                                </div>

                                 <!-- tlf:repr input -->
                                 <div class="form-outline mb-2">
                                    <label class="form-label" for="tlf_repr">Teléfono del Representante</label><span class="text-danger"> *</span>
                                    <input type="number" id="tlf_repr" class="form-control form-control-sm" name="tlf_repr" placeholder="Ejemplo: 04125231102" required>
                                    <p class="text-end text-muted mb-0" style="font-size:12px;">Ejemplo: 04125231102</p>
                                </div>
                            </div><!-- cierra col-sm-6 -->
                            <div class="col-sm-6">
                                <div class="text-center text-navy fw-bold mb-3">
                                    <span class="">Correspondiente a la Asignación</span>
                                </div>

                                <div class=" mb-2">
                                    <label class="form-label" for="cantidad">No. de Guías</label><span class="text-danger">*</span>
                                    <input class="form-control form-control-sm" type="number" name="cantidad" id="cantidad" required >
                                </div>
                                <div class="mb-2">
                                            <label class="form-label" for="motivo">Motivo</label><span class="text-danger">*</span>
                                            <input class="form-control form-control-sm" type="text" id="motivo" name="motivo" required>
                                        </div>
                                <div class="mb-4">
                                    <label class="form-label" for="oficio">Oficio</label><span class="text-danger">*</span>
                                    <p class="mb-2 text-secondary text-justify"><span class="fw-bold">Nota: </span>Es importante subir el oficio de la solicitud, realizada por el contribuyente para la asignación de guías provicionales, como soporte de dicha transacción.</p>
                                    <input class="form-control form-control-sm" id="oficio" type="file" name="oficio" required >
                                </div>
                            </div> <!-- cierra col-sm-6 -->
                        </div> <!-- cierra row -->

                        <input type="hidden" name="tipo_sujeto" value="sin_registrar" required>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_generar_asignacion" disabled="">Asignar</button>
                        </div>
                    </form>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* ASIGNACIÓN EXITOSA: VER CORRELATIVO ******** -->
    <div class="modal fade" id="modal_asignacion_correlativo"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignacion_correlativo">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
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


    <!--********* GUÍA ASIGNACIÓN  ******** -->
    <div class="modal fade" id="modal_guia_asignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_guias_asignacion">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>    
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>



    <!-- ********* ASIGNACIONES: QR LISTO ******** -->
    <div class="modal" id="modal_asignacion_entregada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_asignacion_entregada">
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
        // const myModal = document.getElementById('myModal');
        // const myInput = document.getElementById('myInput');

        // myModal.addEventListener('shown.bs.modal', () => {
        //     myInput.focus();
        // });
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
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
        var modal_status = false;


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

        //////////////////BUSCAR RIF INGRESADO
        $(document).on('click','#search_sujeto_asignar', function(e) {  
            var rif_nro = $('#rif').val();
            var rif_condicion = $('#rif_condicion').val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.search") }}',
                data: {rif_nro:rif_nro,rif_condicion:rif_condicion},
                success: function(response) {           
                    $('#content-search-sujeto').html(response);
                },
                error: function() {
                }
            });
            // console.log(cant);
        });

        //////////////////ABRIR MODAL SUJETO REGISTRADO (USER O NOT USER)
        $(document).on('click','.asignar', function(e) {  
            var tipo = $(this).attr('tipo');
            var sujeto = $(this).attr('id_sujeto');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.modal") }}',
                data: {tipo:tipo,sujeto:sujeto},
                success: function(response) {
                    // console.log(response);           
                    $('#content_asignar_sujeto_registrado').html(response);
                },
                error: function() {
                }
            });
            
        });


        //////////////////// DESHABILITAR EL BOTON "ASIGNAR" SI EL NUMERO DE GUIAS ES 0
        $(document).on('keyup','#cantidad', function(e) {  
            var cant = $(this).val();
            if (cant == 0) {
                $("#btn_generar_asignacion").attr('disabled', true);
            }else{
                $("#btn_generar_asignacion").attr('disabled', false);
            }
            // console.log(cant);
        });


        ////////cerrar modal info correlativo
        $(document).on('click','#cerrar_info_correlativo_reserva', function(e) { 
            $('#modal_asignacion_correlativo').modal('hide');
            window.location.href = "{{ route('asignar')}}";
        });

    
        /////////////PARROQUIAS
        $(document).on('change','.municipio_dest', function(e) {
            var municipio = $(this).val();
            var guia = $(this).attr('guia');

            switch (municipio) {
                case 'Bolívar':
                    $('#parroquia_'+guia).html('<option value="Bolívar (San Mateo)">Bolívar (San Mateo)</option>');
                    break;
                case 'Camatagua':
                    $('#parroquia_'+guia).html('<option value="Camatagua">Camatagua</option>'+
                                        '<option value="Carmen de Cura">Carmen de Cura</option>');
                    break;
                case 'Francisco Linares Alcántara':
                    $('#parroquia_'+guia).html('<option value="Santa Rita">Santa Rita</option>'+
                                        '<option value="Francisco de Miranda">Francisco de Miranda</option>'+
                                        '<option value="Moseñor Feliciano González">Moseñor Feliciano González</option>');
                    break;
                case 'Girardot':
                    $('#parroquia_'+guia).html('<option value="Pedro José Ovalles">Pedro José Ovalles</option>'+
                                        '<option value="Joaquín Crespo">Joaquín Crespo</option>'+
                                        '<option value="José Casanova Godoy">José Casanova Godoy</option>'+
                                        '<option value="Madre María de San José">Madre María de San José</option>'+
                                        '<option value="Andrés Eloy Blanco">Andrés Eloy Blanco</option>'+
                                        '<option value="Los Tacarigua">Los Tacarigua</option>'+
                                        '<option value="Las Delicias">Las Delicias</option>'+
                                        '<option value="Choroní">Choroní</option>');

                break;
                case 'José Ángel Lamas':
                    $('#parroquia_'+guia).html('<option value="Santa Cruz">Santa Cruz</option>');
                    break;
                case 'José Félix Ribas':
                    $('#parroquia_'+guia).html('<option value="José Félix Ribas">José Félix Ribas</option>'+
                                        '<option value="Castor Nieves Ríos">Castor Nieves Ríos</option>'+
                                        '<option value="Las Guacamayas">Las Guacamayas</option>'+
                                        '<option value="Pao de Zárate">Pao de Zárate</option>'+
                                        '<option value="Zuata">Zuata</option>');
                break;
                case 'José Rafael Revenga':
                    $('#parroquia_'+guia).html('<option value="José Rafael Revenga">José Rafael Revenga</option>');
                    break;
                case 'Libertador':
                    $('#parroquia_'+guia).html('<option value="Palo Negro">Palo Negro</option>'+
                                        '<option value="San Martín de Porres">San Martín de Porres</option>');
                    break;
                case 'Mario Briceño Iragorry':
                    $('#parroquia_'+guia).html('<option value="El Limón">El Limón</option>'+
                                        '<option value="Caña de Azúcar">Caña de Azúcar</option>');
                break;
                case 'Ocumare de la Costa de Oro':
                    $('#parroquia_'+guia).html('<option value="Ocumare de la Costa">Ocumare de la Costa</option>');
                    break;
                case 'San Casimiro':
                    $('#parroquia_'+guia).html('<option value="San Casimiro">San Casimiro</option>'+
                                        '<option value="Güiripa">Güiripa</option>'+
                                        '<option value="Ollas de Caramacate">Ollas de Caramacate</option>'+
                                        '<option value="Valle Morín">Valle Morín</option>');
                    break;
                case 'San Sebastián':
                    $('#parroquia_'+guia).html('<option value="San Sebastián">San Sebastián</option>');
                    break;
                case 'Santiago Mariño':
                    $('#parroquia_'+guia).html('<option value="Turmero">Turmero</option>'+
                                        '<option value="Arévalo Aponte">Arévalo Aponte</option>'+
                                        '<option value="Chuao">Chuao</option>'+
                                        '<option value="Samán de Güere">Samán de Güere</option>'+
                                        '<option value="Alfredo Pacheco Miranda">Alfredo Pacheco Miranda</option>');
                    break;
                case 'Santos Michelena':
                    $('#parroquia_'+guia).html('<option value="Santos Michelena">Santos Michelena</option>'+
                                        '<option value="Tiara">Tiara</option>');
                    break;
                case 'Sucre':
                    $('#parroquia_'+guia).html('<option value="Cagua">Cagua</option>'+
                                        '<option value="Bella Vista">Bella Vista</option>');
                break;
                case 'Tovar':
                    $('#parroquia_'+guia).html('<option value="Tovar">Tovar</option>');
                    break;
                case 'Urdaneta':
                    $('#parroquia_'+guia).html('<option value="Urdaneta">Urdaneta</option>'+
                                        '<option value="Las Peñitas">Las Peñitas</option>'+
                                        '<option value="San Francisco de Cara">San Francisco de Cara</option>'+
                                        '<option value="Taguay">Taguay</option>');
                    break;
                case 'Zamora':
                    $('#parroquia_'+guia).html('<option value="Zamora">Zamora</option>'+
                                        '<option value="Magdaleno">Magdaleno</option>'+
                                        '<option value="San Francisco de Asís">San Francisco de Asís</option>'+
                                        '<option value="Valles de Tucutunemo">Valles de Tucutunemo</option>'+
                                        '<option value="Augusto Mijares">Augusto Mijares</option>');
                    break;
                default:
                    break;
            }

        });  

        //////////////CONTENT: REGISTRO DE CANTERA
        $(document).on('change','.select_cantera', function(e) {
            var select = $(this).val();
            var guia = $(this).attr('guia');

            if (select == 'otro') {
                var sujeto = $('.otro').attr('sujeto');
                // $('#id_sujeto_cantera').val(sujeto);

                $('#content_add_cantera_'+guia).removeClass('d-none');

                $(".razon_dest").attr('disabled', true);
                $(".ci_dest").attr('disabled', true);
                $(".tlf_dest").attr('disabled', true);
                $(".municipio_dest").attr('disabled', true);
                $(".parroquia_dest").attr('disabled', true);
                $(".destino").attr('disabled', true);
                $(".mineral").attr('disabled', true);
                $(".unidad_medida").attr('disabled', true);
                $(".cantidad").attr('disabled', true);
                $(".saldo_anterior").attr('disabled', true);
                $(".cantidad_despachada").attr('disabled', true);
                $(".saldo_restante").attr('disabled', true);
                $(".modelo").attr('disabled', true);
                $(".nombre_conductor").attr('disabled', true);
                $(".tlf_conductor").attr('disabled', true);
                $(".placa").attr('disabled', true);
                $(".ci_conductor").attr('disabled', true);
                $(".capacidad_vehiculo").attr('disabled', true);
                $(".hora_salida").attr('disabled', true);
                $(".anulada").attr('disabled', true);
                $(".motivo_anulada").attr('disabled', true);

            }else{
                $('#content_add_cantera_'+guia).addClass('d-none');

                $(".razon_dest").attr('disabled', false);
                $(".ci_dest").attr('disabled', false);
                $(".tlf_dest").attr('disabled', false);
                $(".municipio_dest").attr('disabled', false);
                $(".parroquia_dest").attr('disabled', false);
                $(".destino").attr('disabled', false);
                $(".mineral").attr('disabled', false);
                $(".unidad_medida").attr('disabled', false);
                $(".cantidad").attr('disabled', false);
                $(".saldo_anterior").attr('disabled', false);
                $(".cantidad_despachada").attr('disabled', false);
                $(".saldo_restante").attr('disabled', false);
                $(".modelo").attr('disabled', false);
                $(".nombre_conductor").attr('disabled', false);
                $(".tlf_conductor").attr('disabled', false);
                $(".placa").attr('disabled', false);
                $(".ci_conductor").attr('disabled', false);
                $(".capacidad_vehiculo").attr('disabled', false);
                $(".hora_salida").attr('disabled', false);
                $(".anulada").attr('disabled', false);
                $(".motivo_anulada").attr('disabled', false);
            }
        });

        ////////////////////CANCELAR REGISTRO NUEVA CANTERA (NOTUSER)
        $(document).on('click','.btn_cancel_add_cantera', function(e) { 
            var guia = $(this).attr('guia');
            $('#content_add_cantera_'+guia).addClass('d-none');
            // var first = $(".select_cantera").first().val();
            // console.log(first);
            // $(".select_cantera").first().attr("selected");

        });

        ////////////////////REGISTRAR NUEVA CANTERA (NOTUSER)
        $(document).on('click','#add_cantera', function(e) { 
            e.preventDefault(e); 
            var guia = $(this).attr('guia');
            var sujeto = $('#id_sujeto_cantera').val();
            var nombre = $('#nombre_nc_'+guia).val();
            var direccion = $('#direccion_nc_'+guia).val();
            var municipio = $('#municipio_nc_'+guia).val();
            var parroquia = $('#parroquia_nc_'+guia).val();

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar.add_cantera") }}',
                data: {sujeto:sujeto,nombre:nombre,direccion:direccion,municipio:municipio,parroquia:parroquia},
                success: function(response) {              
                    console.log(response);
                    if (response.success) {
                        $("#select_cantera_"+guia).removeClass('select_cantera');
                        $(".select_cantera").prepend("<option value='"+response.cantera+"'>"+response.nombre+"</option>");
                        $("#select_cantera_"+guia).prepend("<option value='"+response.cantera+"' selected>"+response.nombre+"</option>");
                        $("#select_cantera_"+guia).addClass('select_cantera');

                        alert('¡Registro Exitoso!');

                        $('#content_add_cantera_'+guia).addClass('d-none');

                        $(".razon_dest").attr('disabled', false);
                        $(".ci_dest").attr('disabled', false);
                        $(".tlf_dest").attr('disabled', false);
                        $(".municipio_dest").attr('disabled', false);
                        $(".parroquia_dest").attr('disabled', false);
                        $(".destino").attr('disabled', false);
                        $(".mineral").attr('disabled', false);
                        $(".unidad_medida").attr('disabled', false);
                        $(".cantidad").attr('disabled', false);
                        $(".saldo_anterior").attr('disabled', false);
                        $(".cantidad_despachada").attr('disabled', false);
                        $(".saldo_restante").attr('disabled', false);
                        $(".modelo").attr('disabled', false);
                        $(".nombre_conductor").attr('disabled', false);
                        $(".tlf_conductor").attr('disabled', false);
                        $(".placa").attr('disabled', false);
                        $(".ci_conductor").attr('disabled', false);
                        $(".capacidad_vehiculo").attr('disabled', false);
                        $(".hora_salida").attr('disabled', false);
                        $(".anulada").attr('disabled', false);
                        $(".motivo_anulada").attr('disabled', false);

                    }else{
                        if (response.i == 'empty') {
                            alert("Debe llenar todos los campos requeridos.");
                        }else{
                            alert("ERROR AL GENERAR EL REGISTRO");
                        }
                    }
                },
                error: function() {
                }
            });
        });

        ////////////// CERRAR EL MODAL DE ASIGNACIÓN 
        $(document).on('click','#cerrar_asignacion', function(e){
            var asignacion = $(this).attr('asignacion');
            
            if (confirm('¿Desea cerrar la pestaña? Una vez que la cierre no se guardará la información de la Asignación.')) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("asignar.cerrar") }}',
                    data: {asignacion:asignacion},
                    success: function(response) { 
                        console.log(response);    
                        if (response.success) {
                            $('#modal_guia_asignacion').modal('hide');
                            window.location.href = "{{ route('asignar')}}";
                        }        
                        
                    },
                    error: function() {
                    }
                });
            }
            
        });


        // ///////////////////////DESABILITAR BUTTON GUARDAR ASIGNACIÓN
        // $(document).on('click','#guardar_asignacion', function(e){
        //     $(this).attr('disabled', true);
        // });


        ////////////////////////////ELIMINAR LA ASIGNACIÓN SI SE RECARGA LA PÁGINA
        window.onbeforeunload = function() {
            // return "You have some unsaved changes";
            var delete_var = $('#cerrar_asignacion').attr('delete');
            if ($('#modal_guia_asignacion').is(':visible') && delete_var == 'true') {
                var asignacion = $('#cerrar_asignacion').attr('asignacion');
        
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("asignar.cerrar") }}',
                    data: {asignacion:asignacion},
                    success: function(response) {       
                        
                    },
                    error: function() {
                    }
                });
                
            } else {
                // console.log('El modal está cerrado');
            }
            
        };
        

        ////////////// ELIMINAR ASIGNACIÓN 
        $(document).on('click','.delete_asignacion', function(e){
            var asignacion = $(this).attr('id_asignacion');
            
            if (confirm('¿Desea eliminar la Asignación?')) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("asignar.delete") }}',
                    data: {asignacion:asignacion},
                    success: function(response) { 
                        console.log(response);    
                        if (response.success) {
                            alert("Asignación eliminada correctamente.");
                            window.location.href = "{{ route('asignar')}}";
                        }else{
                            alert("Ha ocurrido un error al eliminar la Asignación.");
                           
                        }
                    },
                    error: function() {
                    }
                });
            }
            
        });


        ///////MODAL: INFO SUJETO PASIVO
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


        //////SELECION DE ANULADA: SI 
        $(document).on('change','.anulado_si', function(e) { 
            var guia = $(this).attr('guia');
            e.preventDefault(e); 
            $("#motivo_anulada_"+guia).attr('disabled', false);
            
        });

        ////SELECION DE ANULADA: NO
        $(document).on('change','.anulado_no', function(e) { 
            var guia = $(this).attr('guia');
            e.preventDefault(e); 
            $("#motivo_anulada_"+guia).attr('disabled', true);
            $("#motivo_anulada_"+guia).val("");
            
        });

    });

    


    ////////////////////ASIGNACIÓN CONTRIBUYENTE REGISTRADO 
    function asignarGuiasRegister(){
        var formData = new FormData(document.getElementById("form_asignar_guias_register"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("asignar.asignar_user") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // console.log(response);
                    if (response.success) {
                        var asignacion = response.asignacion;
                        var sujeto = response.sujeto;
                        var tipo = response.tipo_sujeto;

                        $('#modal_asignar_sujeto_registrado').modal('hide');
                        $('#modal_guia_asignacion').modal('show');
                        modal_status = true;
                        //////////////////Registro de guías asignadas
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("asignar.guias") }}',
                            data: {asignacion:asignacion,sujeto:sujeto,tipo:tipo},
                            success: function(response){
                                console.log(response);
                                if (response.success) {
                                    $('#content_guias_asignacion').html(response.html);
                                }else{
                                    
                                }
                            },
                            error: function(error){
                                
                            }
                        });
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('DISCULPE, HA OCURRIDO UN ERROR AL GENERAR LA ASIGNACIÓN.');
                        }
                    }
                    

                },
                error: function(error){
                    
                }
            });
    }

    ////////////////////ASIGNACIÓN CONTRIBUYENTE NO REGISTRADO
    function asignarGuiasNotregister(){
        var formData = new FormData(document.getElementById("form_asignar_guias_notregister"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("asignar.asignar_notuser") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        var asignacion = response.asignacion;
                        var sujeto = response.sujeto;
                        var tipo = response.tipo_sujeto;

                        $('#modal_asignar_sujeto_no_registrado').modal('hide');
                        $('#modal_guia_asignacion').modal('show');
                        modal_status = true;
                        //////////////////Registro de guías asignadas
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            url: '{{route("asignar.guias") }}',
                            data: {asignacion:asignacion,sujeto:sujeto,tipo:tipo},
                            success: function(response){
                                console.log(response);
                                if (response.success) {
                                    $('#content_guias_asignacion').html(response.html);
                                }else{
                                    
                                }
                            },
                            error: function(error){
                                
                            }
                        });
                    }else{
                        if (response.nota != '') {
                            alert(response.nota);
                        }else{
                            alert('DISCULPE, HA OCURRIDO UN ERROR AL GENERAR LA ASIGNACIÓN.');
                        }
                    }

                },
                error: function(error){
                    
                }
            });
    }
    
    function registrarGuias(){
        var formData = new FormData(document.getElementById("form_registrar_guias"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("asignar.registro_guias") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    var asignacion = $('#cerrar_asignacion').attr('delete','false');
                    alert('LA ASIGNACIÓN SE HA REGISTRADO CORRECTAMENTE');
                    window.location.href = "{{ route('asignar')}}";
                }else{
                    
                
                }
            },
            error: function(error){
                
            }
        });
    }


    </script>


  
@stop