@extends('adminlte::page')

@section('title', 'Emisión Rollos')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

    <!-- <img src="{{asset('assets/bf-1.svg')}}" class="w-100" alt="..."> -->
@stop

@section('content')
    
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-3 text-navy titulo fw-bold">Emitiendo <span class="text-secondary fs-4">| Rollos TFE 14</span></h3>
            <div class="mb-3">
                <button type="button" class="btn bg-navy rounded-pill px-3 btn-sm fw-bold d-flex align-items-center" id="" data-bs-toggle="modal" data-bs-target="#modal_emitir_rollos">
                    <i class='bx bx-plus fw-bold fs-6 pe-2'></i>
                    <span>Emitir</span>
                </button>
            </div>
        </div>

        

        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:12.7px">
                <thead>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                    <th>Opciones</th> 
                </thead>
                <tbody id="" class="border-light-subtle"> 
                    @foreach ($query as $emision)
                        <tr>
                            <td>{{$emision->id_emision}}</td>
                            <td class="text-secondary">{{$emision->fecha_emision}}</td>
                            <td class="text-navy fw-bold">{{$emision->cantidad}} Rollos</td>
                            <td>
                                <a href="#">Ver</a>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12px">En Proceso</span>
                            </td>
                            <td class="d-flex align-items-center justify-content-center">
                                
                                @if ($emision->ultimo == true)
                                    <span class="badge py-1 delete_solicitud" style="background-color: #ed0000;" role="button" >
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @else
                                    <span class="badge py-1" style="background-color: #ed00008c;">
                                        <i class="bx bx-trash-alt fs-6"></i>
                                    </span> 
                                @endif

                                <button class="btn btn-sm btn-primary enviar_inventario d-inline-flex align-items-center ms-2" emision="{{$emision->id_emision}}" title="Enviar a Inventario" type="button" data-bs-toggle="modal" data-bs-target="#modal_enviar_inventario">
                                    <i class='bx bxs-chevron-right'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                  
                </tbody> 
                
            </table>
            
        </div>
    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <div class="modal fade" id="modal_emitir_rollos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_timbre_impreso">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class='bx bx-collection fs-2 text-muted me-2'></i>
                        <h1 class="modal-title fs-5 fw-bold text-navy">Emisión de Rollos</h1>
                        <h5 class="text-muted fw-bold">TFE - 14</h5>
                    </div>
                </div>
                <div class="modal-body px-5 py-3" style="font-size:13px">
                    <p class="text-secondary">*NOTA: Cada rollo emitido trae un total de 160 Trimbres Fiscales.</p>
                    <form id="form_emitir_rollos" method="post" onsubmit="event.preventDefault(); emitirRollos()">
                        <div class="px-4">
                            <label for="cantidad" class="form-label">Cantidad de rollos <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="cantidad" placeholder="" name="cantidad" required>
                        </div>

                        <p class="text-muted text-end fw-bold mt-3" style="font-size:13px"><span style="color:red">*</span> Campos requeridos.</p>

                        <div class="d-flex justify-content-center mt-3 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-sm">Emitir</button>
                        </div>
                    </form>
                    
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>


    <!-- ************  CORRELATIVO ROLLOS  ************** -->
    <div class="modal fade" id="modal_correlativo_rollos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_correlativo_rollos">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>
    

    <!-- *****************  ENVIAR A INVENTARIO  *************** -->
    <div class="modal fade" id="modal_enviar_inventario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_enviar_inventario">
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
          /////////////////////////// MODAL ENVIAR A INVENTARIO
          $(document).on('click','.enviar_inventario', function(e) {
                e.preventDefault();
                var emision = $(this).attr('emision');
                $('#btn_enviar_inventario').attr('disabled', true);

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("rollos.modal_enviar") }}',
                    data: {emision:emision},
                    success: function(response) {
                        console.log(response);
                        $('#content_enviar_inventario').html(response);

                    },
                    error: function() {
                    }
                });
            });

    });

    function emitirRollos(){
        var formData = new FormData(document.getElementById("form_emitir_rollos"));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("rollos.emitir") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        $('#modal_emitir_rollos').modal('hide');
                        $('#modal_correlativo_rollos').modal('show');
                        $('#content_correlativo_rollos').html(response.html);
                       
                    }else{
                        alert('Disculpe, ha ocurrido un error en la Emisión de Rollos.');
                    }  

                },
                error: function(error){
                    
                }
            });
    }


    function enviarRollosInventario(){
        var formData = new FormData(document.getElementById("form_enviar_inventario"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("rollos.enviar_inventario") }}',
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