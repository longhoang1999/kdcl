@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Comparison/title.thopsc')
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
    @lang('project/Comparison/title.thopsc')
@stop

@section('content')
<section class="content-body">
    <h2>
        @lang('project/Comparison/title.thopsc')
    </h2>
    <div class="line"></div>
    <div class="select" id="select-id">
    	<div class="sel-1">
    		<p>@lang('project/Comparison/title.cbtc')</p>
	    	<select name="" id="" class="seclet-1">
	            <option value="">@lang('project/Comparison/title.botc')</option>
	        </select>
	    </div>
	    <div class="sel-2">
	    	<p>@lang('project/Comparison/title.ctdt')</p>
	    	<select name="" id="" class="seclet-2">
	            <option value="">@lang('project/Comparison/title.ctdt')</option>
	        </select>
	    </div>
	    <div class="sel-3">
	    	<p>@lang('project/Comparison/title.tunam')</p>
	        <select name="" id="" class="seclet-3">
	            <option value="">2021</option>
	            <option value="">2022</option>
	        </select>
	    </div>
	    <div class="sel-4">
	    	<p>@lang('project/Comparison/title.dennam')</p>
	        <select name="" id="" class="seclet-4">
	            <option value="">2021</option>
	            <option value="">2022</option>
	        </select>
	    </div>  
    </div>

    <div class="block-standard ">
    	<div class="standard-left block-css">
    		<p>@lang('project/Comparison/title.smcdlkh')</p>
    		<p>120</p>
    	</div>
    	<div class="standard-mid block-css">
    		<p>@lang('project/Comparison/title.smcdth')</p>
    		<p>120</p>
    	</div>
    	<div class="standard-right block-css">
    		<p>@lang('project/Comparison/title.smcd')</p>
    		<p>120</p>
    	</div>
    </div>

    <div class="charts">
    	<p>@lang('project/Comparison/title.bdxhttc')</p>
    	<select name="" id="">
    		<option>@lang('project/Comparison/title.tieuchi1')</option>
    	</select>
    </div>
    <div class="benchmark">
        <a href="">@lang('project/Comparison/title.mocchuan1')</a>
        <a href="">@lang('project/Comparison/title.mocchuan2')</a>
        <a href="">@lang('project/Comparison/title.mocchuan3')</a>
    </div>
    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

        
    <div class="function function-2">
        <div class="execl">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                  <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                  <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                @lang('project/Comparison/title.xuat_ex')
            </button>
        </div>
        <h2>@lang('project/Comparison/title.thkq')</h2>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    var xValues = [2015,2016,2017,2018,2019,2020];

	new Chart("myChart", {
	  type: "line",
	  data: {
	    labels: xValues,
	    datasets: [{
	      lineTension: 0,
	      data: [160,40,45,60,33,11,74],
	      borderColor: "red",
	      fill: false
	    }, {
	      lineTension: 0, 
	      data: [0,200,40,90,68,33,47],
	      borderColor: "green",
	      fill: false
	    }]
	  },
	  options: {
	    legend: {display: false},
	    scales: {
	      yAxes: [{ticks: {min: 0, max:500}}],
	    }
	  }
	});

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

