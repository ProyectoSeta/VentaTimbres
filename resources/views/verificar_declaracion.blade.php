@extends('adminlte::page')

@section('title', 'Verificación: Declaraciones')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Declaraciones <span class="text-secondary fs-4">| Verificación </span></h3>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:13px">
                <thead class="border-light-subtle">
                    <th>#</th>
                    <th>Contribuyente</th>
                    <th>R.I.F.</th>
                    <th>Libro</th>
                    <th>Tipo de Declaración</th>
                    <th>Referencia</th>
                    <th>Opciones</th>
                </thead>
                <tbody> 
                    @foreach ($declaraciones as $declaracion)
                        <tr>
                            <td>{{$declaracion->id_declaracion}}</td>
                            <td>{{$declaracion->razon_social}}</td>
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $declaracion->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$declaracion->rif_condicion}}-{{$declaracion->rif_nro}}</a>
                            </td>
                                @php
                                    $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                    $mes_bd = $declaracion->mes_declarado;
                                    $mes_libro = $meses[$mes_bd];
                                @endphp
                            <td>
                                <a href="{{ route('detalle_libro.index', ['mes' =>$declaracion->mes_declarado, 'year' =>$declaracion->year_declarado, 'sujeto' =>$declaracion->id_sujeto]) }}">{{$mes_libro}} {{$declaracion->year_declarado}}</a>
                            </td>
                            <td>{{$declaracion->nombre_tipo}}</td>
                            <td>
                                @php
                                    if($declaracion->referencia == null){
                                @endphp
                                    <span class="fw-bold text-danger">SIN ACTIVIDAD ECONÓMICA</span>    
                                @php
                                    }else{
                                @endphp
                                    <a target="_blank" class="ver_pago" href="{{ asset($declaracion->referencia) }}">Ver</a>
                                @php
                                    }
                                @endphp
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm btn_verificar_declaracion px-3 rounded-4 fw-bold" id_declaracion="{{$declaracion->id_declaracion}}" data-bs-toggle="modal" data-bs-target="#modal_verificar_declaracion">Verificar</button>
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

    <!-- ********* VERIFICACIÓN DE DECLARACIONES******** -->
    <div class="modal" id="modal_verificar_declaracion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_verificar_declaracion">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- *********BOX: OBSERVACION DE DENEGACIÓN DE DECLARACIÓN******** -->
    <div class="modal" id="modal_box_obv" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-error-circle bx-tada fs-2" style="color:#e40307"></i>                  
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Denegar Declaración</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:15px;" id="content_verificar_declaracion">
                    <form id="form_denegar_declaracion" method="post" onsubmit="event.preventDefault();">
                        <div class="ms-2 me-2">
                            <label for="observacion" class="form-label">Observación</label><span class="text-danger">*</span>
                            <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                            <input type="hidden" name="id_declaracion" id="declaracion" value="" required>
                        </div>
                        <div class="text-muted text-end" style="font-size:13px">
                            <span class="text-danger">*</span> Campos Obligatorios
                        </div>
                    
                        <div class="mt-3 mb-2">
                            <p class="text-muted me-3 ms-3" style="font-size:13px"><span class="fw-bold">Nota:
                                </span>Las <span class="fw-bold">Observaciones </span>
                                cumplen la función de notificar al <span class="fw-bold">Contribuyente</span>
                                del porque la declaración ha sido negada. Para que así, puedan rectificar y cumplir con el deber formal.
                            </p>
                        </div>

                        <div class="d-flex justify-content-center m-3">
                            <button type="submit" class="btn btn-danger btn_form_denegar_declaracion btn-sm me-4" disabled>Denegar</button>
                            <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>  <!-- cierra modal-body -->
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

           ///////MODAL: VERIFICAR DECLARACION
           $(document).on('click','.btn_verificar_declaracion', function(e) { 
                e.preventDefault(e); 
                var declaracion = $(this).attr('id_declaracion');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("verificar_declaracion.info") }}',
                    data: {declaracion:declaracion},
                    success: function(response) {    
                        // console.log(response);          
                        $('#content_verificar_declaracion').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ////////////////////VERIFICAR DECLARACIÓN
            $(document).on('click','.verificar_declaracion', function(e) { 
                e.preventDefault(e); 
                var declaracion = $(this).attr('id_declaracion');

                if (confirm("¿Esta seguro que desea Aprobar la Declaración?")) {
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'POST',
                        url: '{{route("verificar_declaracion.verificar") }}',
                        data: {declaracion:declaracion},
                        success: function(response) {    
                            // console.log(response);          
                            if (response.success) {
                                alert('LA DECLARACIÓN FUE VERIFICADA CORRECTAMENTE');
                                window.location.href = "{{ route('verificar_declaracion')}}";
                            } else {
                                alert('Ha ocurrido un error al verificar la Declaración.');
                            }
                        },
                        error: function() {
                        }
                    });
                }else{

                }
                
            });

            ////////////////////
            $(document).on('keyup','#observacion', function(e) {  
                var cant = $(this).val();
                if (cant != '') {
                    $(".btn_form_denegar_declaracion").attr('disabled', false);
                }else{
                    $(".btn_form_denegar_declaracion").attr('disabled', true);
                }
            });

            ////////////////////DENEGAR DECLARACIÓN: OBSERVACIONES
            $(document).on('click','.denegar_declaracion', function(e) { 
                e.preventDefault(e); 
                var declaracion = $(this).attr('id_declaracion');

                $('#declaracion').val(declaracion);
                $('#modal_verificar_declaracion').modal('hide');
                $('#modal_box_obv').modal('show');

            });

            ////////////////////
            $(document).on('click','.btn_form_denegar_declaracion', function(e) { 
                e.preventDefault(e); 
                // var declaracion = $(this).attr('id_declaracion');
                var formData = new FormData(document.getElementById("form_denegar_declaracion"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("verificar_declaracion.denegar") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        // alert(response);
                        // console.log(response);
                        if (response.success) {
                        alert('SE HA DENEGADO LA DECLARACIÓN CORRECTAMENTE');
                        window.location.href = "{{ route('verificar_declaracion')}}";
                        } else {
                        alert('Ha ocurrido un error al denegar la Declaración.');
                        }    

                    },
                    error: function(error){
                        
                    }
                });
                

            });
           
           

        });

    //    function denegarDeclaracion(){
        
    //    }

        
    </script>
  
@stop