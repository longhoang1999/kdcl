@extends('admin/layouts/default')
@php
    $baseLang = 'project/QualiAssurance/Kehoachhanhdong/title';
    $baseRoute = 'admin.dambaochatluong.proofclaim';
@endphp

{{-- Page title --}}
@section('title')
    @lang( $baseLang . '.khhd')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style>
    .select2-container .select2-selection--single .select2-selection__clear{
        left: 88%;
    }
    i{
        line-height: initial !important;
    }
</style>
@stop

@section('title_page')
    @lang( $baseLang . '.khhd')
@stop

@section('content')

    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="container-fuild pl-5 ">
            <div class="row mt-3 ">
                <div class="col-md-2 block-flex">
                    <select class="form-control h-2rem" id="nam_search">
                        <option value="">@lang( $baseLang . '.nam')</option>
                        @for($i = intVal(date('Y'));$i >= 1990 ;$i--)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 block-flex">
                    <select class="form-control h-2rem" id="donvi_search">
                        <option value="">@lang( $baseLang . '.donvi')</option>
                        @foreach($donvi as $dv)
                            <option value="{{$dv->id}}">{{$dv->ten_donvi}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 block-flex">
                    <select class="form-control h-2rem" id="lvuc_search">
                        <option value="">@lang( $baseLang . '.lvuc')</option>
                        @foreach($linhvuc as $lv)
                            <option value="{{$lv->id}}">{{$lv->mo_ta}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 block-flex">
                    <select class="form-control h-2rem" id="tthai_search">
                        <option value="">@lang( $baseLang . '.trangthai')</option>
                        <option value="N">@lang( $baseLang . '.cxn')</option>
                        <option value="P">@lang( $baseLang . '.kxn')</option>
                        <option value="Y">@lang( $baseLang . '.dxn')</option>
                    </select>
                </div>
                <div class="col-md-2 block-flex">
                    <a  href="{{route($baseRoute . '.exportlistKhhd')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                        <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                    </a>
                </div>
            </div>
        </div>
        <h3 class="mt-5"></h3>
        <div class="item-group-button right-block mb-2">
            
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>@lang( $baseLang . '.noidung')</th>
                <th>@lang( $baseLang . '.ngay_thuchien')</th>
                <th>@lang( $baseLang . '.ngay_kiemtra')</th>
                <th>@lang( $baseLang . '.donvi_thuchien')</th>
                {{-- <th>@lang( $baseLang . '.nguoi_kiemtra')</th> --}}
                <th>@lang( $baseLang . '.ghichu')</th>
                <th>@lang( $baseLang . '.trangthai')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
        
</section>

<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script>
    $("#nam_search").select2({
        placeholder: "@lang( $baseLang . '.nam')",
        allowClear: true
    });
    $("#donvi_search").select2({
        placeholder: "@lang( $baseLang . '.donvi')",
        allowClear: true
    });
    $("#lvuc_search").select2({
        placeholder: "@lang( $baseLang . '.lvuc')",
        allowClear: true
    });
    $("#tthai_search").select2({
        placeholder: "@lang( $baseLang . '.trangthai')",
        allowClear: true
    });

    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route( $baseRoute . '.getListKhhd') !!}",
                type: 'POST',
                data: {
                    'nam_search' : function() { return $("#nam_search").val() },
                    'donvi_search' : function() { return $("#donvi_search").val() },
                    'lvuc_search'  : function() { return $("#lvuc_search").val() },
                    'tthai_search' : function() { return $("#tthai_search").val() }
                },
            },
            columns: [
                { data: 'noiDung' },
                { data: 'nbd' },
                { data: 'nht' },
                { data: 'donViTh' },
                // { data: 'ngKiemtra' },
                { data: 'ghi_chu' },
                { data: 'trangthai' },
             ],
            order: [[1, 'asc']],
        });
    }); 

    $("#nam_search").change(function() {
        table.ajax.reload();
    })
    $("#donvi_search").change(function() {
        table.ajax.reload();
    })
    $("#lvuc_search").change(function() {
        table.ajax.reload();
    })
    $("#tthai_search").change(function() {
        table.ajax.reload();
    })

</script>

@stop
