@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Comparison/title.lapkh')
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
    @lang('project/Comparison/title.lkhsc')
@stop

@section('content')
<section class="content-body">
    <h2>
        @lang('project/Comparison/title.lkhsc')
    </h2>
    <div class="line"></div>
        <h4>@lang('project/Comparison/title.ctkhsc')</h4>
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
    <div class="function">
        <div class="execl">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                  <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                @lang('project/Comparison/title.xuat_ex')
            </button>
        </div>
    </div>

        <table class="table table-striped table-bordered " id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/Comparison/title.tctc')</th>
                <th >@lang('project/Comparison/title.ngaybd')</th>
                <th >@lang('project/Comparison/title.ngayht')</th>
                <th >@lang('project/Comparison/title.trangthai')</th>
                <th >@lang('project/Comparison/title.nsth')</th>
                <th >@lang('project/Standard/title.ngayt')</th>
                <th >@lang('project/Standard/title.nguoit')</th>
                <th >@lang('project/Standard/title.hanhd')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
    </div>

    <button class="calendar">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
          <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
        </svg>
        <span>@lang('project/Comparison/title.cnkh')</span>
    </button>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body p-0">
            <fieldset class="modal-fieldset">
                <legend>@lang('project/Comparison/title.dsns')</legend>
                <div class="modal-content1">
                    <p>
                        @lang('project/Comparison/title.nsth')
                    </p>
                    <div class="block-perform"></div>
                </div>
                <div class="block-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </div>
                <div class="modal-content2">
                    <p>
                        @lang('project/Comparison/title.dsns')
                    </p>
                    <div class="block-personnel">
                        
                    </div>
                </div>
            </fieldset>
          </div>
        </div>
      </div>
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
            ajax: "{!! route('admin.sochuan.planning.data') !!}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'name', name: 'name' },
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

