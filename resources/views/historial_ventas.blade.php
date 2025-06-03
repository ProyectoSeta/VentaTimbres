@extends('adminlte::page')

@section('title', 'Historial Ventas')
@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    


    <main>
        <div class="my-4 pt-5">
           <h1 class="display-6 text-muted text-center fw-bold">Historial | <span class="text-navy">Ventas</span></h1> 
        </div>
        <div class="d-flex flex-column align-items-center justify-content-center" style="font-size:13px">
           <!-- FORM SEARCH TFE14 -->
            <form id="form_search_venta" method="post" onsubmit="event.preventDefault(); searchVenta()">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="taquilla" class="form-label"><span class="text-danger">*</span> Taquilla: </label>
                        <select class="form-select form-select-sm" aria-label="Small select example" name="taquilla" id="taquilla">
                            <option selected>Seleccione</option>
                            @foreach ($taquillas as $taq)
                                <option value="{{$taq->id_taquilla}}">TAQ{{$taq->id_taquilla}} - {{$taq->nombre}} | {{$taq->sede}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="fecha" class="form-label"><span class="text-danger">*</span> Fecha:</label>
                        <input type="date" id="fecha" class="form-control form-control-sm" name="fecha" required>
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-primary mb-3  ms-3 mt-4"> <i class=" bx bx-search-alt"></i> </button>
                    </div>
                </div>
                
            </form>
            
        
        </div>
        
        

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 bg-white container-fluid bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="p-lg-5 mx-auto" id="content_info_search">
                
                
                

                
            </div>
        </div>


    </main>
    
<!-- *********************************  MODALES ******************************* -->
     <!-- INFO CONTRIBUYENTE -->
    <div class="modal fade" id="modal_info_sujeto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_info_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE TIMBRES -->
    <div class="modal fade" id="modal_timbres" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-l">
            <div class="modal-content" id="content_timbres">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE VENTA -->
    <div class="modal fade" id="modal_detalle_venta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_venta">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE FORMAS -->
    <div class="modal fade" id="modal_detalle_formas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="content_detalle_formas">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>



<!-- ************************************************************************** -->


    


@stop

@section('footer')


    

  
        
@stop



@section('css')
    <link rel="stylesheet" href="{{asset('assets/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stop

@section('js')
    
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_venta_taquilla').DataTable(
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
            /////////////////////// MODAL INFO SUJETO
            $(document).on('click','.info_sujeto', function(e) {
                e.preventDefault();
                var sujeto = $(this).attr('sujeto');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.contribuyente") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {
                        console.log(response);
                        $('#content_info_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// TIMBRES
            $(document).on('click','.timbres', function(e) {
                e.preventDefault();
                var venta = $(this).attr('venta');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.timbres") }}',
                    data: {venta:venta},
                    success: function(response) {
                        console.log(response);
                        $('#content_timbres').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// DETALLE VENTA
            $(document).on('click','.detalle_venta', function(e) {
                e.preventDefault();
                var venta = $(this).attr('venta');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.detalle_venta") }}',
                    data: {venta:venta},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#content_detalle_venta').html(response.html);
                        }else{
                            alert('Disculpe, vuelva a cargar la pagina.');
                        }
                        
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////// MODAL DETALLE FORMA class="detalle_forma"
            $(document).on('click','.detalle_forma', function(e) {
                e.preventDefault();
                var forma = $(this).attr('forma');
                var taquilla = $(this).attr('taquilla');

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("arqueo.detalle_forma") }}',
                    data: {forma:forma,taquilla:taquilla},
                    success: function(response) {
                        console.log(response);
                        $('#content_detalle_formas').html(response);
                        $('#table_detalle_forma').DataTable(
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
                    },
                    error: function() {
                    }
                });
            });



        });

        function searchVenta(){
            var formData = new FormData(document.getElementById("form_search_venta"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("historial_ventas.search") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    $('#content_info_search').html(response);
                    $('#table_venta_taquilla').DataTable();
                },
                error: function(error){
                    
                }
            });
        }



        


    </script>
  
@stop