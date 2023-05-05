@extends('admin/layouts/default')

@section('title')
    @lang('project/Externalreview/title.solieuth')
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/ExternalReview/externalreview.css') }}">

@stop

@section('title_page')
    @lang('project/Externalreview/title.solieuth')
@stop
@section('content')
<section class="content-body">
    <style>
        .title_tieuChuan{
            margin-bottom: 0px;
        }
        .nav-second-level{
            
        }
        .nav-second-level li a{
            display: flex;
            justify-content: space-between;
        }
        .firtLevel li a{
            justify-content: left;
        }
        .firtLevel {
            padding-left:15px;
        }
        .nav-level_child li a{
            display: flex;
            justify-content: flex-start !important;
        }
        .navbar-fixed-top {
            background: #fff;
            transition-duration: 0.4s;
            border-bottom: 1px solid #e7eaec !important;
            z-index: 1030 !important;
        }
        body.fixed-sidebar .navbar-static-side, body.canvas-menu .navbar-static-side {
            z-index: 2 !important;
        }
        .navbar .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #1ab394;
            border-radius: 4px;
            background: #1ab394;
            color: white;
        }
        .navbar .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            line-height: 28px;
            outline-color: #1ab394;
            border: none;
            box-shadow: none;
        }
        .navbar .select2-selection.select2-selection--single:focus{
            outline: #1ab394;
            border: none;
        }
        .navbar .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }
        .navbar .select2-selection__arrow b {
            border-color: #1ab394 transparent transparent transparent !important;
        }
        .md-skin .wrapper-content, #page-wrapper {
            padding: 0;
        }
        body{
            overflow: hidden;
        }
        iframe{
            border: none;
        }
        .md-skin .page-heading{
            margin:0px;
        }
        .content-body{
            width: 100%;
        }
    </style>
    <div>
        <iframe src="{{$url}}" style="width:100%; height:80vh"></iframe>
    </div>

</section>
@stop



@section('footer_scripts')

<script>
    

</script>
@stop