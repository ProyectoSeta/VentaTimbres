@extends('adminlte::page')

@section('title', 'Aperturar Taquillas')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="mx-5 bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
        <div class="container rounded-4 p-3 px-0">
            <div class="d-flex justify-content-between mb-2">
                <p class="text-navy fw-bold fs-3 titulo">Historial de Cierres | <span class="text-muted">Buscar</span></p>

                <div class="d-flex align-items-center" >
                    <input type="date" class="form-control me-2" style="font-size:13px" id="fecha_search_cierre">  
                    <button type="button" class="btn btn-secondary pb-1" id="btn_search_cierre"><i class='bx bx-search fs-6 m-0'></i></button>
                </div>
            </div>

            <div id="content_table_search">
                
            </div>

        </div> 

        
    </div>
    

<!-- *********************************  MODALES ******************************* -->

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
            $('#table_historial_cierre').DataTable(
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
            

            /////////////////////////// CONTENT: TABLE SEARCH POR FECHA
            $(document).on('click','#btn_search_cierre', function(e) {
                e.preventDefault();
                var fecha = $('#fecha_search_cierre').val();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("historial_cierre.search") }}',
                    data: {fecha:fecha},
                    success: function(response) {
                        console.log(response);
                        $('#content_table_search').html(response);
                        $('#table_historial_cierre').DataTable();
                    },
                    error: function() {
                    }
                });
            });

        });

    </script>
  
@stop