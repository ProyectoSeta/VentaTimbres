@extends('adminlte::page')

@section('title', 'Reporte Anual')

@section('content_header')
    
    <script src="{{ asset('jss/bundle.js') }}" defer></script>
    <link href="{{asset('css/datatable.min.css') }}" rel="stylesheet">
    <script src="{{ asset('jss/jquery-3.5.1.js') }}" ></script>
@stop

@section('content')
    
    <div class="container rounded-4 p-3 px-0" style="background-color:#ffff;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-3 text-navy titulo fw-bold">Trimestres {{$year}} <span class="text-secondary fs-4">| Reportes </span></h3>
        </div>


        <div class="table-response" style="font-size:12.7px">
            <table id="table_reporte_trimestre" class="table align-middle border-light-subtle text-center " style="font-size:12.7px">
                <thead class="bg-primary border-light-subtle">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Período</th>
                            <th scope="col">Imprimir Reporte</th>
                        </tr>
                </thead>
                <tbody>
                    @php
                        $c = 0;
                    @endphp
                    @foreach ($trimestres as $t)
                        @php
                            $c++;
                        @endphp
                        <tr role="buttom">
                            <td>{{$c}}</td>
                            <td>{{$t}}</td>
                            <td>
                                <div class="">
                                    <a href="{{ route('reportes_trimestral', ['tri' =>$t, 'year' =>$year] ) }}" class="badge bg-dark" style="" role="button">
                                        <i class='bx bx-printer fs-6'></i>
                                    </a>
                                </div>
                            </td>
                        </tr> 
                    @endforeach
                    
                </tbody>
            </table>
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
            $('#table_reporte_trimestre').DataTable(
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
        // $(document).on('click','.asignado_taquilla', function(e) {
        //     e.preventDefault();
        //     var exencion =  $(this).attr('exencion');

            
        //     $.ajax({
        //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        //         type: 'POST',
        //         url: '{{route("asignado.modal") }}',
        //         data: {exencion:exencion},
        //         success: function(response) {
        //             // console.log(response);
        //             $('#content_asignado_exencion').html(response);
                    
        //         },
        //         error: function() {
        //         }
        //     });
        // });
          
    });


    
    

    


   


    


    


    


    
    

    </script>


  
@stop