@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Infexchange/title.chat')
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


<link rel="stylesheet" href="{{ asset('css/project/Infexchange/infexchange.css') }}">


@stop

@section('title_page')
    @lang('project/Infexchange/title.chat')
@stop

@section('content')
<section class="content-body">
    <div class="chat">
    	<div class="user">
    		<a href="">
    			<img src="https://scontent.fhan5-2.fna.fbcdn.net/v/t39.30808-6/293799048_554109623060686_5360915059457800792_n.jpg?stp=cp1_dst-jpg_s960x960&_nc_cat=1&ccb=1-7&_nc_sid=8bfeb9&_nc_ohc=3D0SPTgr-LcAX_YdWEi&_nc_ht=scontent.fhan5-2.fna&oh=00_AT-iCCkvHQxXdrfYa5UDmBSW5JskYTIIW1pQcvQbuf2nWw&oe=62DFB97F" alt="lỗi">
    			<span>Hoàng Anh</span>
    		</a>
    		<hr>
    		<div class="group">
    			<span>@lang('project/Infexchange/title.nhom')</span>
    			<div class="icon">
	    			<span>+</span>
	    			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
	  					<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</div>
    		</div>
    		<ul class="list-group">
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.nhom1')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.nhom2')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.nhomtest')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.ntdv')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.ttdbcl')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.ttdbcl')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
				<li>
					<a href="">
						<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
						  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
						  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
						  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
						</svg>
						<strong>
							<p>@lang('project/Infexchange/title.ttdbcluong')</p>
							<span>@lang('project/Infexchange/title.tienduc')</span>
						</strong>
					</a>
				</li>
			</ul>
    	</div>

    	<div class="search"> 
    		<button class="buttons">
    			<svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
  					<path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  					<path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
				</svg>
    		</button>
    		<p>@lang('project/Infexchange/title.cmlhdbdmtc')</p>	
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


@stop
