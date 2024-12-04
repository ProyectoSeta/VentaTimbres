@extends('adminlte::page')

@section('title', 'Aperturar Taquillas')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <!-- <script src="{{asset('vendor/sweetalert.js') }}"></script>  -->
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <main class="container p-3">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="text-navy fs-3 titulo fw-bold">Hoy</div>

            <div class="text-muted fw-bold fs-5">
                24-02-2025
            </div>

            <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="apertura_taquillas" data-bs-toggle="modal" data-bs-target="#modal_apertura_taquillas">
                <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                <span>Aperturar</span>
            </button>
        </div>


        <p class="text-navy fw-bold fs-4 titulo">Taquillas aperturadas | <span class="text-muted">Hoy</span></p>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="table_apertura_hoy" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                <tr>
                        <th>#</th>
                        <th>Taquilla</th>
                        <th>Taquillero</th>
                        <th>Hora Apertura</th>
                        <th>Apertura Taquillero</th>
                        <th>Cierre Taquilla</th>
                    </tr> 
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                
            </table>
        </div>

        <div class="d-flex justify-content-between my-5">
            <p class="text-navy fw-bold fs-4 titulo">Taquillas aperturadas | <span class="text-muted">Buscar por fecha</span></p>

            <div class="d-flex align-items-center" >
                <input type="date" class="form-control me-2" style="font-size:13px" id="fecha_search_apertura">  
                <button type="button" class="btn btn-secondary pb-1" id="btn_search_apertura"><i class='bx bx-search fs-6 m-0'></i></button>
            </div>
            

        </div>
    </main>
    

<!-- *********************************  MODALES ******************************* -->
    <!-- ************ APERTURA DE TAQUILLAS ************** -->
    <div class="modal fade" id="modal_apertura_taquillas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="content_apertura_taquillas">
                    
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
    <!-- <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script> -->
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table_apertura_hoy').DataTable(
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
            $('#table_apertura').DataTable(
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
            /////////////////////////// MODAL APETURAR
            $(document).on('click','#apertura_taquillas', function(e) {
                e.preventDefault();

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("apertura.modal_apertura") }}',
                    success: function(response) {
                        // console.log(response);
                        $('#content_apertura_taquillas').html(response);
                    },
                    error: function() {
                    }
                });
            });

            /////////////////////////// CLICK EN APERTURAR
            $(document).on('click','.check_apertura', function(e) {
                var taquilla = $(this).attr('taquilla');

                if($("#apertura_"+taquilla).is(':checked')) {
                    $('#label_'+taquilla).html('Si');
                } else {
                    $('#label_'+taquilla).html('No');
                }
            });
        });

        function aperturaTaquillas(){
            var formData = new FormData(document.getElementById("form_aperturar_taquillas"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("apertura.apertura_taquillas") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                        alert('LOS ROLLOS SE HAN ENVIADO AL INVENTARIO EXITOSAMENTE');
                            window.location.href = "{{ route('emision_rollos')}}";
                        }else{
                            alert('Disculpe, ha ocurrido un error.');
                        }  

                    },
                    error: function(error){
                        
                    }
                });
        }
    </script>
  
@stop