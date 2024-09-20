@extends('adminlte::page')

@section('title', 'Nuevos usuarios')

@section('content_header')
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{asset('vendor/sweetalert.js') }}"></script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    <div class="container rounded-4 p-3" style="background-color:#ffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-3 text-navy fw-bold titulo">Nuevos usuarios <span class="text-secondary fs-4">| Verificación </span></h3>
        </div>
        <div class="table-responsive" style="font-size:14px">
            <table id="example" class="table text-center border-light-subtle" style="font-size:13px">
                <thead class="border-light-subtle">
                    <th>Cod.</th>
                    <th>Razón Social</th>
                    <th>R.I.F.</th>
                    <th>¿Artesanal?</th>
                    <th>Representante</th>
                    <th>Opciones</th>
                </thead>
                <tbody> 
                @foreach( $sujetos as $sujeto)               
                    <tr>
                        <td>{{$sujeto->id_sujeto}}</td>
                        <td>{{$sujeto->razon_social}}</td>
                        <td>
                            <a class="info_sujeto" role="button" id_sujeto='{{ $sujeto->id_sujeto }}' data-bs-toggle="modal" data-bs-target="#modal_info_sujeto">{{$sujeto->rif_condicion}}-{{$sujeto->rif_nro}}</a>
                        </td>
                        <td>
                        @php
                            if($sujeto->rif_condicion == 'G'){
                        @endphp    
                            <span class="fst-italic text-secondary">No Aplica</span>
                        @php
                            }else{
                        @endphp
                            <span>{{$sujeto->artesanal}}</span>
                        @php
                            }
                        @endphp
                        </td>
                        <td>{{$sujeto->name_repr}}</td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm aprobar_sujeto rounded-4 px-3" id_sujeto="{{$sujeto->id_sujeto}}" data-bs-toggle="modal" data-bs-target="#modal_aprobar_sujeto">Aprobar</button>
                            <button class="btn btn-danger btn-sm denegar_sujeto rounded-4 px-3" id_sujeto="{{$sujeto->id_sujeto}}" data-bs-toggle="modal" data-bs-target="#modal_denegar_sujeto">Denegar</button>
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

    <!-- ********* APROBAR SOLICITUD ******** -->
    <div class="modal fade" id="modal_aprobar_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_aprobar_sujeto">
                <div class="my-5 py-5 d-flex flex-column text-center">
                    <i class='bx bx-loader-alt bx-spin fs-1 mb-3' style='color:#0077e2'  ></i>
                    <span class="text-muted">Cargando, por favor espere un momento...</span>
                </div>
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

     <!-- ********* DENEGAR SOLICITUD ******** -->
     <div class="modal fade" id="modal_denegar_sujeto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="content_denegar_sujeto">
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

            ///////MODAL: INFO APROBAR SUJETO
            $(document).on('click','.aprobar_sujeto', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("verificar_user.info") }}',
                    data: {sujeto:sujeto},
                    success: function(response) { 
                        // alert(response);             
                        $('#content_aprobar_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

            ///////MODAL: INFO DENEGAR SUJETO
            $(document).on('click','.denegar_sujeto', function(e) { 
                e.preventDefault(e); 
                var sujeto = $(this).attr('id_sujeto');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    url: '{{route("verificar_user.info_denegar") }}',
                    data: {sujeto:sujeto},
                    success: function(response) {          
                        $('#content_denegar_sujeto').html(response);
                    },
                    error: function() {
                    }
                });
            });

           

        });

        function aprobarUser(){
            var formData = new FormData(document.getElementById("form_aprobar_user"));
            console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("verificar_user.aprobar") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('El USUARIO HA SIDO APROBADO CORRECTAMENTE');
                        window.location.href = "{{ route('verificar_user')}}";
                    } else {
                        alert('Ha ocurrido un error al aprobar la verificación del usuario.');
                    }  

                },
                error: function(error){
                    
                }
            });
        }

        function denegarUser(){
            var formData = new FormData(document.getElementById("form_denegar_sujeto"));
            // console.log("alo");
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url:'{{route("verificar_user.denegar") }}',
                type:'POST',
                contentType:false,
                cache:false,
                processData:false,
                async: true,
                data: formData,
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        alert('LA VERIFICACIÓN DEL USUARIO HA SIDO DENEGADA CORRECTAMENTE');
                        window.location.href = "{{ route('verificar_user')}}";
                    } else {
                        alert('Ha ocurrido un error al denegar la verificación del usuario.');
                    }  

                },
                error: function(error){
                    
                }
            });
        }
    </script>
  
@stop