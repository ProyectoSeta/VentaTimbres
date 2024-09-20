@extends('adminlte::page')

@section('title', 'Reserva')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>

    <!-- <img src="{{asset('assets/bf-2.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy titulo fw-bold">Talonarios <span class="text-secondary fs-4">| de Reserva</span></h3>
            <div class="me-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 fw-bold btn-sm d-flex align-items-center" id="new_reserva" data-bs-toggle="modal" data-bs-target="#modal_emision_reserva">
                    <i class='bx bx-plus fw-bold fs-6 pe-2' ></i>
                    <span>Emitir</span>
                </button>
            </div>
        </div>
        
        
        <div class="table-responsive" style="font-size:12.7px">        
            <table id="example" class="table display border-light-subtle text-center" style="width:100%; font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                    <tr>
                        <th scope="col">Cod. Talonario</th>
                        <th scope="col">Fecha Emisión</th>
                        <th scope="col">Correlativo</th>
                        <th scope="col">Asignado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($talonarios as $talonario)
                        <tr>
                            @php
                                $desde = $talonario->desde;
                                $hasta = $talonario->hasta;
                                $length = 6;
                                $formato_desde = substr(str_repeat(0, $length).$desde, - $length);
                                $formato_hasta = substr(str_repeat(0, $length).$hasta, - $length);
                                
                                $asignado = ($talonario->asignado * 100)/$talonario->tipo_talonario;
                            @endphp
                            <td>{{$talonario->id_talonario}}</td>
                            <td>
                                <span class="text-muted">{{$talonario->fecha}}</span>
                            </td>
                            <td>
                                <a href="{{ route('detalle_reserva.index', ['talonario' =>$talonario->id_talonario]) }}">{{$formato_desde}} - {{$formato_hasta}}</a>
                            </td>
                            <td>
                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="{{$asignado}}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: {{$asignado}}%">{{$asignado}}%</div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
    

    
    
<!--****************** MODALES **************************-->
    <!-- ********* EMITIR ******** -->
    <div class="modal fade" id="modal_emision_reserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-plus-circle text-muted fs-3 me-2'></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel">Emición</h1>
                        <span class="">Talonarios de Reserva</span>
                    </div>
                    
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body mx-2" style="font-size:14px;" id="content_info_new">
                    <form id="form_emitir_reserva" method="post" onsubmit="event.preventDefault(); emitirReserva()">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="tipo_talonario" class="form-label">Tipo Talonario</label>
                                <input class="form-control form-control-sm" id="tipo_talonario" type="number" placeholder="50" name="tipo_talonario" value="50" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="cantidad" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                <input class="form-control form-control-sm" id="cantidad" type="number" name="cantidad">
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-3" data-bs-dismiss="modal" id="btn_cancelar">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_emitir_reserva">Emitir</button>
                        </div>
                    </form>
                   
                </div>  <!-- cierra modal-body -->
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ********* EMISIÓN: CORRELATIVO ******** -->
    <div class="modal fade" id="modal_emision_correlativo"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_emision_correlativo">
                <div class="modal-body">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
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
           
           ////////cerrar modal info correlativo
           $(document).on('click','#cerrar_info_correlativo_reserva', function(e) { 
                $('#modal_emision_correlativo').modal('hide');
                window.location.href = "{{ route('reserva')}}";
            });


        });  

        function emitirReserva(){
            $("#btn_emitir_reserva").attr('disabled', true);
            var formData = new FormData(document.getElementById("form_emitir_reserva"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("reserva.emitir") }}',
                    type:'POST',
                    contentType:false,
                    cache:false,
                    processData:false,
                    async: true,
                    data: formData,
                    success: function(response){
                        console.log(response);
                        if (response.success) {
                            var reserva = response.id_reserva;
                            $('#modal_emision_reserva').modal('hide');
                            $('#modal_emision_correlativo').modal('show');

                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                url: '{{route("reserva.info_correlativo") }}',
                                data: {reserva:reserva},
                                success: function(response) {           
                                    $('#content_emision_correlativo').html(response);
                                },
                                error: function() {
                                }
                            });
    
                        }else {
                            alert('Ha ocurrido un error al aprobar la solicitud');
                        }   

                    },
                    error: function(error){
                        
                    }
                });
        }

       

    </script>
@stop