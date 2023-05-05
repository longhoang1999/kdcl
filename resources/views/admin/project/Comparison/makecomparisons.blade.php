@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Comparison/title.ycct')
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
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}">


<link rel="stylesheet" href="{{ asset('css/project/Comparaison/planning.css') }}">

@stop

@section('title_page')
    @lang('project/Comparison/title.thsc')
@stop

@section('content')
<section class="content-body">
    <h2>
        @lang('project/Comparison/title.thsc')
    </h2>
    <div class="line"></div>
    <div class="select">
        <select name="" id="" class="seclet-left">
            <option value="">2021</option>
            <option value="">2022</option>
        </select>
        <select name="" id="" class="seclet-mid">
            <option value="">@lang('project/Comparison/title.botc')</option>
        </select>
        <select name="" id="" class="seclet-right">
            <option value="">@lang('project/Comparison/title.ctdt')</option>
        </select>
    </div>

        <table class="table table-striped table-bordered " id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/Comparison/title.tctc')</th>
                <th >@lang('project/Comparison/title.trongso')</th>
                <th >@lang('project/Comparison/title.mocchuan')</th>
                <th >@lang('project/Comparison/title.tudanhgia')</th>
                <th >@lang('project/Comparison/title.dsmc')</th>
                <th >@lang('project/Comparison/title.ghichu')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
    </div>

    <div class="option">
        <button class="cancel">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg>
            <span>@lang('project/Comparison/title.huy')</span>
        </button>
        <button class="save">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
              <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
              <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
            <span>@lang('project/Comparison/title.luu')</span>
        </button>
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
            ajax: "{!! route('admin.thuongtruc.setstandard.data') !!}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'human', name: 'human' },
                { data: 'actions', name: 'actions' },
            ],            
        });
    });  
</script>
@stop

