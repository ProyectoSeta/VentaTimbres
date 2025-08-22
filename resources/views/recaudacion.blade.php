@extends('adminlte::page')

@section('title', 'Recaudación')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>

@stop

@section('content')
    <div class="contaier py-3 "  >
        <div class="row d-flex align-items-center bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
            <div class="col-sm-2 text-center pb-3">
                <img src="{{asset('assets/logo_seta.png')}}" class="mx-1" alt="" class="mt-3 ms-2" width="140px">
            </div>
            <div class="col-sm-3 pb-3">
                <label for="" class="form-label" style="font-size:13px"><span class="text-danger">*</span> Seleccione el periodo a consultar:</label>
                <form id="form_serach_recaudacion" method="post" onsubmit="event.preventDefault(); searchRecaudacion()">
                    <div class="row">
                        <div class="col-5">
                            <input type="date" class="form-control  form-control-sm" style="font-size:13px" name="desde">  
                        </div>
                        <div class="col-5">
                            <input type="date" class="form-control  form-control-sm" style="font-size:13px" name="hasta">  
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-secondary btn-sm d-flex align-items-center"><i class='bx bx-search fs-6 m-0'></i></button>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="col-sm-3 pb-3">
                <div class="border border-primary-subtle border-3 rounded-4 text-center d-flex flex-column p-3">
                    <div class="titulo text-navy fs-5 fw-semibold">Total Recaudado</div>
                    <div class="fs-3 fw-semibold text-navy">--</div>
                </div>
            </div>
            <div class="col-sm-2 pb-3">
                <div class="border border-3 rounded-4 text-center d-flex flex-column p-3">
                    <div class="titulo text-navy fs-6 fw-semibold">Por Forma 14</div>
                    <div class="fs-4 fw-semibold text-muted">--</div>
                </div>
            </div>
            <div class="col-sm-2 pb-3">
                <div class="border border-3 rounded-4 text-center d-flex flex-column p-3">
                    <div class="titulo text-navy fs-6 fw-semibold">Por Estampillas</div>
                    <div class="fs-4 fw-semibold text-muted">--</div>
                </div>
            </div>
        </div>


        





        <div class="row">
            <div class="col-md-3 ">
                <div class="d-flex flex-column w-75">
                    <div class="text-center mb-3">
                        <div class="fs-5 text-navy fw-bold">Timbres Fiscales</div>
                        <div class="text-secondary">Vendidos</div>
                        <div class="fs-3 text-primary fw-bold bg-primary-subtle text-center rounded-4  px-1">0 <span class="fs-5">Und.</span></div>
                    </div>
                    <div class="text-center mb-3">
                        <div class="fs-5 text-navy fw-bold">Forma 14</div>
                        <div class="text-secondary">Vendidos</div>
                        <div class="fs-3 text-navy fw-bold bg-secondary-subtle text-center rounded-4  px-1">0 <span class="fs-5">Und.</span></div>
                    </div>
                    <div class="text-center mb-3">
                        <div class="fs-5 text-navy fw-bold">Estampillas</div>
                        <div class="text-secondary">Vendidos</div>
                        <div class="fs-3 text-navy fw-bold bg-secondary-subtle text-center rounded-4  px-1">0 <span class="fs-5">Und.</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <!-- timbres fiscales recaudados por entes -->
                <div class="px-5 py-4 borer">
                    <div class="titulo fs-5 fw-semibold text-center mb-3 text-muted">Timbres Fiscales Recaudados | <span class="text-navy">Por Entes</span></div>
                    <div class="table-responsive">
                        <table class="table w-100 table-borderles" style="font-size:13px">
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="40">Registro</th>
                                <td class="text-center">1568 und.</td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%">25%</div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>  <!-- cierra div.table-responsive -->
                </div>
            </div>
        </div>






        <div class="row my-3">
            <div class="col-sm-6 pe-2">
                <div class="text-center bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
                    <div class="titulo fs-5 text-navy fw-bold">Relación de Timbres Fiscales Vendidos <span class="text-muted">| Por Forma 14</span></div>
                    <a href="">Ver Relación</a>
                </div>
            </div>
            <div class="col-sm-6 ps-2">
                <div class="text-center bg_arqueo" style="background-image: url({{asset('assets/fondo2.png')}});">
                    <div class="titulo fs-5 text-navy fw-bold">Relación de Timbres Fiscales Vendidos <span class="text-muted">| Por Estampillas</span></div>
                    <a href="">Ver Relación</a>
                </div>
            </div>
        </div>


                





        

        

    </div>
    
    

    

    
    
<!--****************** MODALES **************************-->
    
  


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
            $('#emisiones_ucd').DataTable(
                {
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
                }
            );
        });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
       


    });

    function searchRecaudacion(){
        var formData = new FormData(document.getElementById("form_serach_recaudacion"));
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url:'{{route("recaudacion.consulta") }}',
            type:'POST',
            contentType:false,
            cache:false,
            processData:false,
            async: true,
            data: formData,
            success: function(response){
                console.log(response);
                // if (response.success) {
                //     $('#content_info_search').html(response.html);
                // }else{
                //     if (response.html != '')  {
                //         alert(response.html);
                //     }else{
                //         alert('Disculpe, ha ocurrido un error. Vuelva a intentarlo.');
                //         window.location.href = "{{ route('consulta')}}";
                //     }
                    
                // }
            },
            error: function(error){
                
            }
        });
    }


  

    

</script>


  
@stop