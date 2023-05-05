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
    .select2-container .select2-selection--single .select2-selection__clear{
        right: 1rem;
    }
</style>
@stop

@section('title_page')
    @lang( $baseLang . '.dshd')
@stop

@section('content')    
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <h4>@lang( $baseLang . '.tkiem')</h4>
        <div class="container-fuild pl-5 ">
            <div class="row mt-3 ">
                <div class="col-md-8">
                    <input type="text" class="form-control " placeholder="@lang( $baseLang . '.tieude')" id="tieude">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <select class="form-control " id="year">
                        <option hidden value="">@lang( $baseLang . '.chonnam')</option>
                        @for($i = intVal(date('Y'));$i >= 2017 ;$i--)
                            <option value="{{ $i }}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control " id="lvuc" >
                        <option hidden value="">@lang( $baseLang . '.lvuc')</option>
                        @foreach ($linhvuc as $item)
                            <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-benchmark" type="button" id="btn-search" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.timkiem')"> 
                        <i class="bi bi-search" style="font-size: 35px;color: #009ef7;"></i>
                    </button>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-benchmark" href="{{route($baseRoute . '.mchdata')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                        <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                
            </div>
        </div>
        <h3 class="mt-3">@lang( $baseLang . '.dshd')</h3>
        <div class="item-group-button right-block mb-2">
            
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang( $baseLang . '.nam')</th>
                <th >@lang( $baseLang . '.lvuc')</th>
                <th >@lang( $baseLang . '.hoatdong')</th>
                <th >@lang( $baseLang . '.mcyc')</th>
                <th >@lang( $baseLang . '.thaotac')</th>
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
    $("#lvuc").select2({
        placeholder: `@lang( $baseLang . '.lvuc')`,
        allowClear: true
    });
    $("#year").select2({
        placeholder: `@lang( $baseLang . '.chonnam')`,
        allowClear: true
    });
    

    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route( $baseRoute . '.getData') !!}",
                type: 'POST',
                data: {
                    'tieude' : function() { return $("#tieude").val() },
                    'lvuc'       : function() { return $("#lvuc").val() },
                    'year'    : function() { return $("#year").val() }
                },
            },
            columns: [
                { data: 'year' },
                { data: 'lvuc' },
                { data: 'noi_dung' },
                { data: 'hd_parent' },
                { data: 'actions' ,className: 'action'},
             ],
            order: [[1, 'asc']],
        });



        $('#btn-search').click(function() {
            table.ajax.reload();
        })
    });  
</script>

@stop
