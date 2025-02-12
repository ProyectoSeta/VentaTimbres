@extends('adminlte::page')

@section('title', 'Imprimir Timbre')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Imprimir Timbre <span class="text-secondary fs-4">| Exenciones </span></h3>
        </div>


        <div class="table-response" style="font-size:12.7px">
            <table id="asignado_exencion" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Asignado</th>
                            <th scope="col">Contribuyente</th>
                            <th scope="col">Total UCD</th>
                            <!-- <th scope="col">Exención (%)</th> -->
                            <th scope="col">Imprimir</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($query as $key)
                        <tr>
                            <td>{{$key->id_exencion}}</td>
                            <td><span class="text-muted fst-italic">{{$key->fecha}}</span></td>
                            <td>
                                <a class="info_sujeto_exencion d-flex flex-column" role="button" exencion="{{$key->id_exencion}}" sujeto="{{$key->key_contribuyente}}" data-bs-toggle="modal" data-bs-target="#modal_info_sujeto_exencion">
                                    <span>{{$key->nombre_razon}}</span>
                                    <span>{{$key->identidad_condicion}}-{{$key->identidad_nro}}</span>
                                </a>
                            </td>
                            <td>
                                <span class="text-navy fw-bold">{{$key->total_ucd}} UCD</span>                                    
                            </td>
                            <!-- <td>
                                <span class="badge bg-primary-subtle border border-primary-subtle text-primary-emphasis rounded-pill" style="font-size:12.7px">{{$key->porcentaje_exencion}}%</span>
                            </td> -->
                            <td>
                                <button class="btn btn-sm btn-secondary asignado_taquilla d-inline-flex align-items-center" exencion="{{$key->id_exencion}}" type="button" data-bs-toggle="modal" data-bs-target="#modal_asignado_exencion">
                                    <i class='bx bx-printer fs-6' ></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>








         
    

        
        

       

        

       
    </div>
    
    

      
<!-- <p class="text-muted ms-2"><span class="text-danger">*</span><span class="fw-bold">IMPORTANTE: </span>En caso de <span class="fw-bold">Anulación</span> del Timbre, debe <span class="fw-bold">solicitarle al Director de Recaudación</span> la Anulación del mismo.</p> -->
    
    
<!--****************** MODALES **************************-->
    <!-- ************ ASIGNAR TAQUILLERO ************* -->
    <div class="modal fade" id="modal_asignado_exencion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_asignado_exencion">
                
            </div>  <!-- cierra modal-content -->
        </div>  <!-- cierra modal-dialog -->
    </div>

    <!-- DETALLE VENTA EXENCION -->
    <div class="modal fade" id="modal_venta_realizada" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="content_venta_realizada">
                
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
    </script>
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
    <script src="{{ asset('jss/datatable.min.js') }}" defer ></script>
    <script src="{{ asset('jss/datatable.bootstrap.js') }}" ></script>
    <script src="{{ asset('jss/toastr.js') }}" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" ></script>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $('#asignado_exencion').DataTable(
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
        /////////////   MODAL EXENCION TAQUILLA
        $(document).on('click','.asignado_taquilla', function(e) {
            e.preventDefault();
            var exencion =  $(this).attr('exencion');

            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '{{route("asignado.modal") }}',
                data: {exencion:exencion},
                success: function(response) {
                    // console.log(response);
                    $('#content_asignado_exencion').html(response);
                    
                },
                error: function() {
                }
            });
        });
          
    });


    
    //////////////// VENTA DE TIMBRES
    function impresionExencion(){
        var formData = new FormData(document.getElementById("form_impresion_exencion"));
        // console.log("alo");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("asignado.venta") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.success) {
                    $('#modal_asignado_exencion').modal('hide');

                    $('#modal_venta_realizada').modal('show');
                    $('#content_venta_realizada').html(response.html);
                }else{
                    if (response.nota) {
                        alert(response.nota);
                    }else{
                        alert('Disculpe, ha ocurrido un error');
                    }
                }
                    
            },
            error: function(error){
                
            }
        });
    }

    


   


    


    


    


    
    

    </script>


  
@stop