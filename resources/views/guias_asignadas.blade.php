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
        
        <div class=" mb-1 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 pb-0 text-navy fw-bold titulo">Asignación <span class="text-secondary fs-4">| No.{{$id_asignacion}}</span></h3>

            
            <div class="d-flex flex-column">
                <p class="fs-5 text-navy fw-bold titulo my-0">{{$razon}}</p>
                <p class="text-muted text-end mb-0 pb-0 fs-6">{{$rif}}</p>
                <p class="text-secondary fw-bold text-end pt-0 my-0" style="font-size:13px">Emisión: {{$emision}}</p>
            </div>
        </div>

        <div class="d-flex justify-content-center mb-1">
            <a href="{{route('asignar_qr.print_tira', ['asignacion' => $id_asignacion]) }}" class="btn btn-dark btn-sm d-flex align-items-center" style="font-size:12.7px"> 
                <i class="bx bx-printer fs-6 me-2"></i> 
                <span>Imprimir Tira QR</span>
            </a>
        </div>

        <div class="table-responsive" style="font-size:12.7px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>Nro. Guía</th>
                    <th>Opción</th>
                </thead>
                <tbody id="list_canteras" class="border-light-subtle"> 
                    @foreach ($guias as $g)
                        <tr role="button">
                            <td class="text-primary">
                                <a href="#" class="info_guia_reserva" asignacion="{{$id_asignacion}}" guia="{{$g->nro_guia}}" data-bs-toggle="modal" data-bs-target="#modal_content_guia_reserva">{{$g->nro_guia}}</a>
                            </td>
                            <td>
                                <a href="{{route('asignar_qr.print_qr', ['guia' => $g->nro_guia])}}" class="btn btn-primary btn-sm"  style="font-size:12.7px">Imprimir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>

        

        

        
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* VER EL REGISTRO DE LA GUÍA ******** -->
    <div class="modal" id="modal_content_guia_reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                
                <div class="row mx-3 mt-3 mb-1 d-flex align-items-center">
                    <div class="col-3 d-flex justify-content-center">
                        <img src="{{asset('assets/aragua.png')}}" alt="" width="100px">
                    </div>
                    <div class="col-6 d-flex flex-column text-center pt-4">
                        <span class="fs-6 fw-bold">GUÍA DE CIRCULACIÓN DE MINERALES NO METÁLICOS</span>
                        <span>GOBIERNO BOLIVARIANO DEL ESTADO ARAGUA SERVICIO TRIBUTARIO DE ARAGUA (SETA)</span>
                    </div>
                    <div class="col-3 d-flex justify-content-center">
                        <img src="{{asset('assets/logo_seta.png')}}" alt="" class="mt-3 ms-2" width="110px">
                    </div>
                </div>
                <div class="modal-body mx-4" style="font-size:14px" id="content_info_guia_reserva">
                    
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
       ////////////////////MODAL: INFO GUIA
       $(document).on('click','.info_guia_reserva', function(e) { 
            e.preventDefault(e); 
            var guia = $(this).attr('guia');
            var asignacion = $(this).attr('asignacion');
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignar_qr.guia") }}',
                data: {guia:guia,asignacion:asignacion},
                success: function(response) { 
                    console.log(response);       
                    $('#content_info_guia_reserva').html(response);
                },
                error: function() {
                }
            });
        });
        

         

    });

    

    



    </script>


  
@stop