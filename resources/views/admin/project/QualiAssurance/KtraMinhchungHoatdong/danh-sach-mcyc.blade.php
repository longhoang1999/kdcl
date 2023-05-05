@extends('admin/layouts/default')
@php
    $baseLang = 'project/QualiAssurance/KtraMCHoatDong/title';
    $baseRoute = 'admin.dambaochatluong.checkproof';
@endphp

{{-- Page title --}}
@section('title')
    @lang( $baseLang . '.qlhd')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style>
    .block-flex{
        display: flex;
    }
    .block-flex span{
        display: block;
        width: 150px;
        margin-right: 10px; font-weight: bold;
        align-items: center;
    }
    .block-flex input:nth-child(2){
        margin-right: 10px;
    }
    .block-flex input:nth-child(3){
        width: 100px;
    }
    th.dvpc, td.dvpc{
        width: 350px;
    }
</style>
@stop

@section('title_page')
    @lang( $baseLang . '.dsmcyc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="container-fuild pl-5 ">
            <div class="row mt-3 ">
                <div class="col-md-8 block-flex">
                    <span>@lang( $baseLang . '.lvuc')</span>
                    <input type="text" class="form-control " placeholder="@lang( $baseLang . '.lvuc')" disabled value="{{ $lv_hdn->mo_ta }}">
                    <input type="number" class="form-control " placeholder="@lang( $baseLang . '.nam')" disabled value="{{ $hoatDongNhom->year }}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-7 block-flex">
                    <span>@lang( $baseLang . '.tenhd')</span>
                    <input type="text" class="form-control " placeholder="@lang( $baseLang . '.tenhd')" disabled value="{{ $hoatDongNhom->noi_dung }}">
                </div>
                <div class="col-md-1">
                    <button class="btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                        <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                    </button>
                </div>
            </div>
        </div>
        <h3 class="mt-5"></h3>
        <div class="item-group-button right-block mb-2">
            
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>@lang( $baseLang . '.mcyc_full')</th>
                <th>@lang( $baseLang . '.donviPc')</th>
                <th>@lang( $baseLang . '.tgth')</th>
                <th>@lang( $baseLang . '.tgcl')</th>
                <th>@lang( $baseLang . '.trangthai')</th>
                <th>@lang( $baseLang . '.quanly')</th>
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
    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route( $baseRoute . '.getListMcyc', $id_hdn) !!}",
                type: 'GET'
            },
            columns: [
                { data: 'noi_dung' },
                { data: 'dvpc' , className: 'dvpc' },
                { data: 'times' },
                { data: 'timesConlai' },
                { data: 'trang_thai' },
                { data: 'actions' ,className: 'action'},
             ],
            order: [[1, 'asc']],
        });
    }); 
</script>
@stop
