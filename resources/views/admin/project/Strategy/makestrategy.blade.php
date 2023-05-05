@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Strategy/title.thds')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link href="{{ asset('vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
<link href="{{ asset('css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" media="all" href="{{ asset('vendors/bower-jvectormap/css/jquery-jvectormap-1.2.2.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/animate/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/only_dashboard.css') }}" />
<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}">


    <link rel="stylesheet" href="{{ asset('css/project/Strategy/planning.css') }}">

@stop

@section('title_page')
    @lang('project/Strategy/title.thds')
@stop

@section('content')
<section class="content-body">
    <h2>
        @lang('project/Strategy/title.thds')
    </h2>
    <div class="line"></div>
    <h4>@lang('project/Strategy/title.ctkqds')</h4>
    <div class="row ">
        <div class="col-md-2">
            <select class="form-control select2">
                @for($i = 1990;$i <= intVal(date('Y'));$i++)
                <option>{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="item-group-button right-block">
            <button class="btn btn-success btn-benchmark mr-2 ml-4 pl-3 pr-3" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel mr-2" viewBox="0 0 16 16">
                    <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>  
                <span>@lang('project/Strategy/title.xuat_ex')</span>
            </button>
        </div>
    </div>

        <table class="table table-striped table-bordered " id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/Strategy/title.tcdtds')</th>
                <th >@lang('project/Strategy/title.dtuong') 1</th>
                <th >@lang('project/Strategy/title.dtuong') 2</th>
                <th >@lang('project/Strategy/title.dtuong') 3</th>
                <th >@lang('project/Strategy/title.dtuong') 4</th>
                <th >@lang('project/Strategy/title.dtuong') 5</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
    </div>

</section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('vendors/moment/js/moment.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- Back to Top-->
<script type="text/javascript" src="{{ asset('vendors/countUp.js/js/countUp.js') }}"></script>


<script type="text/javascript" src="{{ asset('vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>

<script>
    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.doisanh.planning.update') !!}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
                { data: 'human', name: 'human' },
                { data: 'name', name: 'name' },
            ],            
        });
    });  
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(".select2").select2();
    
</script>
@stop

