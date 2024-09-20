@extends('adminlte::page')

@section('title', 'Control: Canteras')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Control <span class="text-secondary fs-4">| Canteras y Desazolves</span></h3>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:13px">
                <thead class="border-light-subtle">
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="2" class="text-secondary">Período</th>
                        <th colspan="3">Guías</th>
                        <th colspan="1"></th>
                    </tr>
                    <tr>
                        <th>Cantera / Desazolve</th>
                        <!-- <th>Contribuyente</th> -->
                        <th>R.I.F.</th>
                        <th class="text-secondary">Inicio</th>
                        <th class="text-secondary">Fin</th>
                        <th>Límite</th>
                        <th>Solicitadas</th>
                        <th>Opciones</th>
                    </tr>                    
                </thead>
                <tbody id="list_canteras"> 
                    @foreach ($limites as $limite)
                        <tr>
                            <td class="fw-bold">{{ $limite->nombre }}</td>
                            <!-- <td>{{ $limite->razon_social }}</td> -->
                            <td>
                                <a class="info_sujeto" role="button" id_sujeto='{{ $limite->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$limite->rif_condicion}}-{{$limite->rif_nro}}</a>
                            </td>
                            <td class="text-secondary">{{ $limite->inicio_periodo }}</td>
                            <td class="text-secondary">{{ $limite->fin_periodo }}</td>

                            <td class="fw-bold">{{ $limite->total_guias_periodo }} Guías</td>
                            
                            @php
                                if($limite->total_guias_solicitadas_periodo == $limite->total_guias_periodo){
                            @endphp
                                <td class="text-danger fw-bold">{{ $limite->total_guias_solicitadas_periodo }} Guías</td>
                            @php
                                }else{
                            @endphp
                                <td class="text-success fw-bold">{{ $limite->total_guias_solicitadas_periodo }} Guías</td>
                            @php     
                                }
                            @endphp
                            
                            <td>
                                <span class="badge update_limite" style="background-color: #169131;" role="button" data-bs-toggle="modal" data-bs-target="#modal_update_limite" id_cantera="{{ $limite->id_cantera }}">
                                    <i class="bx bx-pencil fs-6"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
                
            </table>
            
        </div>

    </div>
    
    

      

    
    
<!--****************** MODALES **************************-->
    <!-- ********* ******** -->
    <div class="modal" id="modal_update_limite" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-2 pt-3 d-flex justify-content-center">
                    <div class="text-center">
                        <i class="bx bx-refresh bx-spin  fs-1" style="color:#0d8a01"></i>
                        <h1 class="modal-title fs-5 text-navy fw-bold" id="exampleModalLabel">Actualizar Límite</h1>
                    </div>
                </div>
                <div class="modal-body" style="font-size:14px;" id="content_update_limite">
                    <div class="my-5 py-5 d-flex flex-column text-center">
                        <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                        <span class="text-muted">Cargando, por favor espere un momento...</span>
                    </div>
                </div>  
            </div>  
        </div>  
    </div>


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


            ///////MODAL: ACTUALIZAR LÍMITE
            $(document).on('click','.update_limite', function(e) { 
                e.preventDefault(e); 
                var cantera = $(this).attr('id_cantera');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("control_canteras.update_limite") }}',
                    data: {cantera:cantera},
                    success: function(response) {              
                        $('#content_update_limite').html(response);
                    },
                    error: function() {
                    }
                });
            });
            

           

        });

        function updateLimite(){
            var formData = new FormData(document.getElementById("form_update_limite"));
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url:'{{route("control_canteras.update") }}',
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
                            alert('ACTUALIZACIÓN DEL LÍMITE REALIZADA CORRECTAMENTE');
                            window.location.href = "{{ route('control_canteras')}}";
                        } else {
                            alert('Ha ocurrido un error al actualizar el límite.');
                        }    

                    },
                    error: function(error){
                        
                    }
                });
        }
        

        
    </script>
  
@stop