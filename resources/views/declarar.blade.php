@extends('adminlte::page')

@section('title', 'Declaración')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-5.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        
        <div class="row">
            <!-- /////////////  DECLARACIÓN DE LIBROS -->
            <div class="col-sm-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-3 text-navy fw-bold titulo">Declaración <span class="text-success fs-4">| Libros</span></h3>
                    <div class="mb-3">
                    </div>
                </div>
                <div class="table-responsive mb-3" style="font-size:14px">
                    <table id="example" class="table text-center border-light-subtle" style="font-size:14px">
                        <thead>
                            <th></th>
                            <th>Libro</th>
                            <th>Opción</th>
                        </thead>
                        <tbody id="list_canteras" class="border-light-subtle"> 
                            @foreach ($declaracion_libros as $libro)
                                <tr>
                                    <th>#</th>
                                    <th>
                                        @php
                                            $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                            $mes_bd = $libro->mes;
                                            $mes_libro = $meses[$mes_bd];
                                        @endphp
                                        <a href="{{ route('detalle_libro.index', ['mes' =>$libro->mes, 'year' =>$libro->year, 'sujeto' =>$id_sp]) }}">{{$mes_libro}} {{$libro->year}}</a>
                                    </th>
                                    <th>
                                        <button class="btn btn-primary btn-sm px-3 fw-bold rounded-4 btn_declarar" data-bs-toggle="modal" data-bs-target="#modal_declarar_libro" id_libro="{{$libro->id_libro}}" mes="{{$libro->mes}}" year="{{$libro->year}}">Declarar</button>
                                    </th>
                                </tr>
                            @endforeach
                            
                        </tbody> 
                        
                    </table>
                </div>
            </div>
            <!-- /////////////   CARD INFO: DECLARACIÓN DE LIBROS -->
            <div class="col-sm-4">
                <div class="card mb-3">
                    <img src="{{asset('assets/3.png')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////////////// -->

        <div class="row">
            <!-- ///////////// DECLARACION DE GUIAS EXTEMPORANEAS -->
            <div class="col-sm-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-3 text-navy fw-bold titulo">Declaración <span class="text-secondary fs-4">| Guías Extemporaneas</span></h3>
                    <div class="mb-3">
                    </div>
                </div>
                <div class="table-responsive mb-3" style="font-size:14px">
                    <table id="example2" class="table text-center border-light-subtle" style="font-size:13px">
                        <thead>
                            <th></th>
                            <th>Libro</th>
                            <th>Opción</th>
                        </thead>
                        <tbody id="list_canteras" class="border-light-subtle"> 
                            @foreach ($declaracion_guias as $libro)
                                <tr>
                                    <th>#</th>
                                    <th>
                                        @php
                                            $meses = ['','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO','JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
                                            $mes_bd = $libro->mes;
                                            $mes_libro = $meses[$mes_bd];
                                        @endphp
                                        <a href="{{ route('detalle_libro.index', ['mes' =>$libro->mes, 'year' =>$libro->year, 'sujeto' =>$id_sp]) }}">{{$mes_libro}} {{$libro->year}}</a>
                                    </th>
                                    <th>
                                        <button class="btn btn-primary btn-sm px-3 fw-bold rounded-4 btn_declarar_extemp" data-bs-toggle="modal" data-bs-target="#modal_declarar_libro" id_libro="{{$libro->id_libro}}" mes="{{$libro->mes}}" year="{{$libro->year}}">Declarar</button>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody> 
                        
                    </table>
                </div>
            </div>
            <!-- ////////////  CARD INFO: DECLARACIÓN DE GUIAS EXTEMPORANEAS -->
            <div class="col-sm-4">
                <div class="card mb-3">
                    <img src="{{asset('assets/4.png')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <!-- <h5 class="card-title">Card title</h5> -->
                        <p class="card-text text-justify" style="font-size:14px">Las Guías Extemporáneas ingresadas en un Libro previamente Declarado, 
                            deberán ser declaradas en la <span class="fw-bold titulo">"Declaración de guías extemporáneas"</span>. Por lo tanto, en el 
                            periodo señalado solo aparecerán las Guías Extemporáneas, pendientes por Declarar, 
                            ingresadas en la Apertura del Libro. </p>
                        <p class="card-text fst-italic text-secondary"><small class="text-body-secondary titulo">Declaración de Guías Extemporáneas</small></p>
                    </div>
                </div>
            </div>
        </div>

        

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- *********  ******** -->
    <div class="modal" id="modal_declarar_libro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <!-- <i class='bx bx-error-circle bx-tada fs-2' style='color:#e40307' ></i> -->
                        <h1 class="modal-title fs-5" id="title-modal-declarar" style="color: #0072ff"></h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:15px;" id="content_modal_declarar">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
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

            $('#example2').DataTable(
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
       ///////MODAL: INFO DECLARAR
       $(document).on('click','.btn_declarar', function(e) { 
            e.preventDefault(e); 
            var mes = $(this).attr('mes');
            var year = $(this).attr('year');
            var libro = $(this).attr('id_libro');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("declarar.info_declarar") }}',
                data: {mes:mes,year:year,libro:libro},
                success: function(response) {    
                    console.log(response); 
                    $('#title-modal-declarar').html('Declarar Libro de Control');
                    $('#content_modal_declarar').html(response.html);

                    if (response.actividad == 'no') {
                        $("#actividad").removeClass('d-none');
                        $("#referencia").attr('disabled', true);
                        $(".btn_form_declarar").attr('disabled', false);
                    }else{
                        $("#actividad").addClass('d-none');
                    }
                    
                },
                error: function() {
                }
            });
        });

        ///////MODAL: INFO DECLARAR EXTEMPORANEAS
        $(document).on('click','.btn_declarar_extemp', function(e) { 
            e.preventDefault(e); 
            var mes = $(this).attr('mes');
            var year = $(this).attr('year');
            var libro = $(this).attr('id_libro');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("declarar.info_declarar_extemporaneas") }}',
                data: {mes:mes,year:year,libro:libro},
                success: function(response) {    
                    console.log(response);  
                    $('#title-modal-declarar').html('Declarar Guías Extemporaneas');
                    $('#content_modal_declarar').html(response.html);

                    if (response.actividad == 'no') {
                        $("#actividad").removeClass('d-none');
                        $("#referencia").attr('disabled', true);
                        $(".btn_form_declarar").attr('disabled', false);
                    }else{
                        $("#actividad").addClass('d-none');
                    }
                    
                },
                error: function() {
                }
            });
        });

        ////////HABILITAR EL BUTTON PARA GENERAR LA SOLICITUD
        $(document).on('change','#referencia', function(e) {
            e.preventDefault(); 
            $('.btn_form_declarar').attr('disabled', false);
        });

    });

    function declararLibros(){
        var formData = new FormData(document.getElementById("form_declarar_libros"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("declarar.declarar_libros") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // alert(response);
                    console.log(response);
                    if (response.success) {
                        alert('DECLARACIÓN DE LIBRO REALIZADA CORRECTAMENTE');
                        window.location.href = "{{ route('declarar')}}";
                    } else {
                        alert('Ha ocurrido un error al declarar el Libro.');
                    }    

                },
                error: function(error){
                    
                }
            });
    }


    function declararGuias(){
        var formData = new FormData(document.getElementById("form_declarar_guias"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("declarar.declarar_guias") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    // alert(response);
                    console.log(response);
                    if (response.success) {
                        alert('DECLARACIÓN DE GUÍA EXTEMPORANEA REALIZADA CORRECTAMENTE');
                        window.location.href = "{{ route('declarar')}}";
                    } else {
                        alert('Ha ocurrido un error al declarar el Libro.');
                    }    

                },
                error: function(error){
                    
                }
            });
    }
</script>


  
@stop