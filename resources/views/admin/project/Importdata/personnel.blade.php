@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.ttns')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Standard/standard.css') }}">
<link href="{{ asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .cke_chrome{
        margin: 0 !important;
        width: 100% !important;
    }
    .cke_dialog_tabs{
        display: flex !important;
    }
    #modal_unit .modal-xl{
        width: 1420px !important;
        max-width: unset !important;
    }
    #css_table{
        overflow-x: auto;
        width:100%;
        overflow-y: auto;
        max-height: 450px;
    }
    #idtableip{
        width:4000px;
    }
    .row_width{
        width:7rem;
    }
    .listlhcsg{
        width: 100%;
        border: none;
        outline: none;
    }
    .trash-btn{
        font-size: 20px;
        cursor: pointer;
    }
    .icon-oblig{
        color: red;
        font-size: 25px;
    }
    .css-note{
        text-align: right;
        display: flex;
        justify-content: space-between;
    }
    .blank{
        width: 10px;
    }
    .note-group{
        display: flex;
        flex-wrap: wrap;
    }
    .note-item{
        width: 350px;
        display: flex;
        margin: 5px 0;
    }
    .block-note{
        width: 40px;
        height: 20px;
        border: 1px solid gray;
        margin-right: 4px;
    }
    .color-empty{
        background: #ec5757;
    }
    .color-number{
        background: #5765ec;
    }
    .color-phone{
        background: #ce7d27;
    }
    .color-website{
        background: #57a7ec;
    }
    .color-email{
        background: #7306c0;
    }
    .color-date{
       background: #047a7e;
    }
    
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.ttns')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.nhap_excel')">
                <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
            </button>
            <a href="{{ route('admin.importdata.nhansu.exportUnit') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_nhansu" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
                <i class="bi bi-trash" style="font-size: 35px;color: red;"></i>
            </button>
        </div>
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>
                    @lang('project/ImportdataExcel/title.stt1')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.thoidiem')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hoten')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.trinhdo')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.loaihp')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.trangthai')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hanhd')
                </th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
    </div>
</section>
<!-- /Kết thúc page trang -->

<!-- Import modal excel -->
<div class="modal fade" id="modal_unit" tabindex="-1" role="dialog" aria-labelledby="modalUnitLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUnitLabel">
                    @lang('project/ImportdataExcel/title.nttns')
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" class="mb-2" name="files" id="file"  accept=".xlsx, .xls, .csv">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success btn-benchmark mb-2" id="import_unit">@lang('project/Standard/title.nhap')</button>
                    <button class="btn btn-success btn-benchmark m-2" id="add_unit">
                        @lang('project/ImportdataExcel/title.themns')
                    </button>
                </div>
                <div id="css_table">
                    <table id="idtableip" class="table table-striped" border="1"></table>
                </div>

                <div class="css-note">
                    <!-- <div class="blank"></div> -->
                    <div class="note-group">
                        <div class="note-item">
                            <div class="block-note color-empty"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.ttkdt')
                            </span>
                        </div>
                        <div class="note-item">
                            <div class="block-note color-number"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.tnpls')
                            </span>
                        </div>
                        <div class="note-item">
                            <div class="block-note color-phone"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.tnplsdt')
                            </span>
                        </div>
                        <div class="note-item">
                            <div class="block-note color-email"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.tnple')
                            </span>
                        </div>
                        <div class="note-item">
                            <div class="block-note color-website"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.tnplw')
                            </span>
                        </div>
                        <div class="note-item">
                            <div class="block-note color-date"></div>
                            <span>
                                @lang('project/ImportdataExcel/title.tnplntn')
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="import_unit_data">
                    @lang('project/Standard/title.save')
                </button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('project/Standard/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">
                    @lang('project/Standard/title.thongbao')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="badge badge-danger">
                    @lang('project/Standard/message.error.hoixoaTc')
                </span>
                <br>
                <span class="badge badge-primary">
                    @lang('project/Standard/message.error.khoantac')
                </span>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="btn-delete-unit">
                    @lang('project/Standard/title.xoa')
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    @lang('project/Standard/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>


<!-- modal update -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateLabel">
                    @lang('project/ImportdataExcel/title.cnttns')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.importdata.nhansu.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="forMaDV">
                                    <span>@lang('project/ImportdataExcel/title.thoidiem')</span>
                                </label>
                                <input type="number" class="form-control " id="forMaDV" placeholder="@lang('project/ImportdataExcel/title.thoidiem')" name="thoidiem">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forHodem">
                                    <span>@lang('project/ImportdataExcel/title.hodem')</span>
                                </label>
                                <input type="text" class="form-control " id="forHodem" placeholder="@lang('project/ImportdataExcel/title.hodem')" name="hodem">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forTen">
                                    <span>@lang('project/ImportdataExcel/title.ten')</span>
                                </label>
                                <input type="text" class="form-control " id="forTen" placeholder="@lang('project/ImportdataExcel/title.ten')" name="ten">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forTenDVTV">
                                    <span>@lang('project/ImportdataExcel/title.shvc')</span>
                                </label>
                                <input type="text" class="form-control " id="forTenDVTV" placeholder="@lang('project/ImportdataExcel/title.shvc')" required name="shvc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcccd">
                                    <span>@lang('project/ImportdataExcel/title.cccd')</span>
                                </label>
                                <input type="text" class="form-control " id="forcccd" placeholder="@lang('project/ImportdataExcel/title.cccd')" required name="cccd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fordvct">
                                    <span>@lang('project/ImportdataExcel/title.dvct')</span>
                                </label>
                                <input type="text" class="form-control " id="fordvct" placeholder="@lang('project/ImportdataExcel/title.dvct')" required name="dvct">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forTenDVTA">
                                    <span>@lang('project/ImportdataExcel/title.dienthoai')</span>
                                </label>
                                <input type="text" class="form-control " id="forTenDVTA" placeholder="@lang('project/ImportdataExcel/title.dienthoai')" required name="dienthoai">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forEmail">
                                    <span>@lang('project/ImportdataExcel/title.email')</span>
                                </label>
                                <input type="email" class="form-control " id="forEmail" placeholder="@lang('project/ImportdataExcel/title.email')" required name="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forVTTV">
                                    <span>@lang('project/ImportdataExcel/title.gioitinh')</span>
                                </label>
                                <input type="text" class="form-control " id="forVTTV" placeholder="@lang('project/ImportdataExcel/title.gioitinh')" required name="gioitinh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forVTTA">
                                    <span>@lang('project/ImportdataExcel/title.ngaysinh')</span>
                                </label>
                                <input type="text" class="form-control " id="forVTTA" placeholder="@lang('project/ImportdataExcel/title.ngaysinh')" required name="ngaysinh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forQuoctich">
                                    <span>@lang('project/ImportdataExcel/title.quoctich')</span>
                                </label>
                                <input type="text" class="form-control " id="forQuoctich" placeholder="@lang('project/ImportdataExcel/title.quoctich')" required name="quoctich">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forTenTD">
                                    <span>@lang('project/ImportdataExcel/title.tdcmcn')</span>
                                </label>
                                <input type="text" class="form-control " id="forTenTD" placeholder="@lang('project/ImportdataExcel/title.tdcmcn')" required name="tdcmcn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forChuquan">
                                    <span>@lang('project/ImportdataExcel/title.tdnvtcn')</span>
                                </label>
                                <input type="text" class="form-control " id="forChuquan" placeholder="@lang('project/ImportdataExcel/title.tdnvtcn')" required name="tdnvtcn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forNtl">
                                    <span>@lang('project/ImportdataExcel/title.ntn')</span>
                                </label>
                                <input class="form-control" id="forNtl" type="text" placeholder="@lang('project/ImportdataExcel/title.ntn')" name="ntn" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forLvhd">
                                    <span>@lang('project/ImportdataExcel/title.noitn')</span>
                                </label>
                                <input class="form-control" id="forLvhd" type="text" placeholder="@lang('project/ImportdataExcel/title.noitn')" required name="noitn"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forSdtlh">
                                    <span>@lang('project/ImportdataExcel/title.GVSP')</span>
                                </label>
                                <input class="form-control" id="forSdtlh" type="text" placeholder="@lang('project/ImportdataExcel/title.GVSP')" required name="GVSP"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forFax">
                                    <span>@lang('project/ImportdataExcel/title.QLNN')</span>
                                </label>
                                <input class="form-control" id="forFax" type="text" placeholder="@lang('project/ImportdataExcel/title.QLNN')" required name="QLNN"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forLLCT">
                                    <span>@lang('project/ImportdataExcel/title.LLCT')</span>
                                </label>
                                <input class="form-control" id="forLLCT" type="text" placeholder="@lang('project/ImportdataExcel/title.LLCT')" required 
                                name="LLCT"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forWebsite">
                                    <span>@lang('project/ImportdataExcel/title.tinhoc')</span>
                                </label>
                                <input class="form-control" id="forWebsite" type="text" placeholder="@lang('project/ImportdataExcel/title.tinhoc')" required name="tinhoc"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forNote">
                                    <span>@lang('project/ImportdataExcel/title.ngoaingu')</span>
                                </label>
                                <input class="form-control" id="forNote" type="text" placeholder="@lang('project/ImportdataExcel/title.ngoaingu')" required name="ngoaingu"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="forTgbdk1">
                                    <span>@lang('project/ImportdataExcel/title.hhdp')</span>
                                </label>
                                <input class="form-control" id="forTgbdk1" type="text" placeholder="@lang('project/ImportdataExcel/title.hhdp')" required name="hhdp"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forTgcbk1">
                                    <span>@lang('project/ImportdataExcel/title.ndp')</span>
                                </label>
                                <input class="form-control" id="forTgcbk1" type="text" placeholder="@lang('project/ImportdataExcel/title.ndp')" required name="ndp"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forcdnnktd">
                                    <span>@lang('project/ImportdataExcel/title.cdnnktd')</span>
                                </label>
                                <input class="form-control" id="forcdnnktd" type="text" placeholder="@lang('project/ImportdataExcel/title.cdnnktd')" required name="cdnnktd"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="formscdktd">
                                    <span>@lang('project/ImportdataExcel/title.mscdktd')</span>
                                </label>
                                <input class="form-control" id="formscdktd" type="text" placeholder="@lang('project/ImportdataExcel/title.mscdktd')" required name="mscdktd"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forntd">
                                    <span>@lang('project/ImportdataExcel/title.ntd')</span>
                                </label>
                                <input class="form-control" id="forntd" type="text" placeholder="@lang('project/ImportdataExcel/title.ntd')" required name="ntd"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forcdnnht">
                                    <span>@lang('project/ImportdataExcel/title.cdnnht')</span>
                                </label>
                                <input class="form-control" id="forcdnnht" type="text" placeholder="@lang('project/ImportdataExcel/title.cdnnht')" required name="cdnnht"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="formscdht">
                                    <span>@lang('project/ImportdataExcel/title.mscdht')</span>
                                </label>
                                <input class="form-control" id="formscdht" type="text" placeholder="@lang('project/ImportdataExcel/title.mscdht')" required name="mscdht"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forccn">
                                    <span>@lang('project/ImportdataExcel/title.ccn')</span>
                                </label>
                                <input class="form-control" id="forccn" type="text" placeholder="@lang('project/ImportdataExcel/title.ccn')" required name="ccn"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forncn">
                                    <span>@lang('project/ImportdataExcel/title.ncn')</span>
                                </label>
                                <input class="form-control" id="forncn" type="text" placeholder="@lang('project/ImportdataExcel/title.ncn')" required name="ncn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fordvsdvc">
                                    <span>@lang('project/ImportdataExcel/title.dvsdvc')</span>
                                </label>
                                <select name="dvsdvc" id="fordvsdvc" class="form-control">
                                    @foreach($donvi as $dv)
                                        <option value="{{ $dv->id }}">{{ $dv->ten_donvi_TV }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdctht">
                                    <span>@lang('project/ImportdataExcel/title.cdctht')</span>
                                </label>
                                <input class="form-control" id="forcdctht" type="text" placeholder="@lang('project/ImportdataExcel/title.cdctht')" required name="cdctht">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fortdbm">
                                    <span>@lang('project/ImportdataExcel/title.tdbm')</span>
                                </label>
                                <input class="form-control" id="fortdbm" type="text" placeholder="@lang('project/ImportdataExcel/title.tdbm')" required name="tdbm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forqdbm">
                                    <span>@lang('project/ImportdataExcel/title.qdbm')</span>
                                </label>
                                <input class="form-control" id="forqdbm" type="text" placeholder="@lang('project/ImportdataExcel/title.qdbm')" required name="qdbm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdkm">
                                    <span>@lang('project/ImportdataExcel/title.cdkm')</span>
                                </label>
                                <input class="form-control" id="forcdkm" type="text" placeholder="@lang('project/ImportdataExcel/title.cdkm')" required name="cdkm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fortdgkm">
                                    <span>@lang('project/ImportdataExcel/title.tdgkm')</span>
                                </label>
                                <input class="form-control" id="fortdgkm" type="text" placeholder="@lang('project/ImportdataExcel/title.tdgkm')" required name="tdgkm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forlhdlv">
                                    <span>@lang('project/ImportdataExcel/title.lhdlv')</span>
                                </label>
                                <input class="form-control" id="forlhdlv" type="text" placeholder="@lang('project/ImportdataExcel/title.lhdlv')" required name="lhdlv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forshdtd">
                                    <span>@lang('project/ImportdataExcel/title.shdtd')</span>
                                </label>
                                <input class="form-control" id="forshdtd" type="text" placeholder="@lang('project/ImportdataExcel/title.shdtd')" required name="shdtd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forncdhd">
                                    <span>@lang('project/ImportdataExcel/title.ncdhd')</span>
                                </label>
                                <input class="form-control" id="forncdhd" type="text" placeholder="@lang('project/ImportdataExcel/title.ncdhd')" required name="ncdhd">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fortggd">
                                    <span>@lang('project/ImportdataExcel/title.tggd')</span>
                                </label>
                                <input class="form-control" id="fortggd" type="text" placeholder="@lang('project/ImportdataExcel/title.tggd')" required name="tggd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fornvdpc">
                                    <span>@lang('project/ImportdataExcel/title.nvdpc')</span>
                                </label>
                                <input class="form-control" id="fornvdpc" type="text" placeholder="@lang('project/ImportdataExcel/title.nvdpc')" required name="nvdpc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forltggd">
                                    <span>@lang('project/ImportdataExcel/title.ltggd')</span>
                                </label>
                                <input class="form-control" id="forltggd" type="text" placeholder="@lang('project/ImportdataExcel/title.ltggd')" required name="ltggd">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="forckhbd">
                                    <span>@lang('project/ImportdataExcel/title.ckhbd')</span>
                                </label>
                                <input class="form-control" id="forckhbd" type="text" placeholder="@lang('project/ImportdataExcel/title.ckhbd')" required name="ckhbd">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forxa">
                                    <span>@lang('project/ImportdataExcel/title.xa')</span>
                                </label>
                                <input class="form-control" id="forxa" type="text" placeholder="@lang('project/ImportdataExcel/title.xa')" required name="xa">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forhuyen">
                                    <span>@lang('project/ImportdataExcel/title.huyen')</span>
                                </label>
                                <input class="form-control" id="forhuyen" type="text" placeholder="@lang('project/ImportdataExcel/title.huyen')" required name="huyen">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fortinh">
                                    <span>@lang('project/ImportdataExcel/title.tinh')</span>
                                </label>
                                <input class="form-control" id="fortinh" type="text" placeholder="@lang('project/ImportdataExcel/title.tinh')" required name="tinh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortrangthai">
                                    <span>@lang('project/ImportdataExcel/title.trangthai')</span>
                                </label>
                                <input class="form-control" id="fortrangthai" type="text" placeholder="@lang('project/ImportdataExcel/title.trangthai')" required name="trangthai">
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-update-unit">
                    @lang('project/Standard/title.thaydoi')
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('project/Standard/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>



    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>


<script>
    

    var listColor = {
        check_empty :   '#ec5757',
        check_website : '#57a7ec',
        check_email  :  '#7306c0',
        check_phone :   '#ce7d27',
        check_number :  '#5765ec',
        check_date : '#047a7e',
    }

    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.importdata.nhansu.dataUnit') !!}",
            columns: [
                { data: 'stt', name: 'stt' ,className: 'stt'},
                { data: 'thoidiem', name: 'thoidiem' },
                { data: 'fullname', name: 'fullname' },
                { data: 'tdcm', name: 'tdcm' },
                { data: 'loaihd', name: 'loaihd' },
                { data: 'trangthai', name: 'trangthai' },
                { data: 'actions', name: 'actions' ,className: 'action'},
            ],            
        });
        table.on( 'draw.dt', function () {
            var PageInfo = $('#table').DataTable().page.info();
            table.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        });
    });  


    var listdv = {
        @foreach($donvi as $dv)
            {{ $dv->ma_donvi }} : '{{ $dv->ten_donvi_TV }}', 
        @endforeach
    };

    $('#import_unit').on('click', function () {
        var f =  $("#forMaDVIP").val(1);
        var formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');

        $.ajax({
            url : "{!! route('admin.importdata.nhansu.importUnit') !!}",
            type : 'POST',
            data : formData,
            processData: false,  
            contentType: false,  
            enctype: 'multipart/form-data',
            success : function(data) {
                $("#idtableip").empty();
                $("#add_unit").show();
                var thead = `
                        <thead class="btn-success ">
                            <tr class="border ">
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.stt')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.thoidiem')
                                </th>
                                <th colspan="10" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ttcn')
                                </th>
                                <th colspan="4" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdcm')
                                </th>
                                <th colspan="5" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdnv')
                                </th>
                                <th colspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.hocham')
                                </th>
                                <th colspan="8" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdnn')
                                </th>
                                <th colspan="5" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cvkm')
                                </th>
                                <th colspan="3" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tthd')
                                </th>
                                <th colspan="3" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.htn')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ckhbd')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.xa')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.huyen')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tinh')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.trangthai')
                                </th>
                                <th rowspan="2" class="row_width p-2">
                                    @lang('project/Standard/title.thaotac')
                                </th>
                            </tr>
                            <tr class="border ">
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.hodem')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ten')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.shvc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cccd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dvct')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dienthoai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.email')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.gioitinh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ngaysinh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.quoctich')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdcmcn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdnvtcn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ntn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.noitn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.GVSP')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.QLNN')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.LLCT')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tinhoc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ngoaingu')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.hhdp')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ndp')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdnnktd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.mscdktd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ntd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdnnht')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.mscdht')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ccn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ncn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dvsdvc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdctht')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdbm')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.qdbm')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdkm')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdgkm')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.lhdlv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.shdtd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ncdhd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tggd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nvdpc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ltggd')
                                </th>
                            </tr>
                        </thead>
                        <tbody id="idtbody"></tbody>
                `;

                $("#idtableip").append(thead);
                //console.log(data)

                data.forEach((item, index) => { 
                    var add = `
                        <tr class="row_number">
                                <td contenteditable class="check-number text-center p-2 row0">${item.stt}</td>
                                <td contenteditable class=" text-center p-2 row1">${item.thoidiem}</td>
                                <td contenteditable class=" text-center p-2 row2">${item.hodem}</td>
                                <td contenteditable class=" text-center p-2 row3">${item.ten}</td>
                                <td contenteditable class=" text-center p-2 row4">${item.sohieu}</td>
                                <td contenteditable class=" text-center p-2 row5">${item.cccd}</td>
                                <td contenteditable class=" text-center p-2 row6">${item.dvct}</td>
                                <td contenteditable class=" text-center p-2 row7">${item.phone}</td>
                                <td contenteditable class=" text-center p-2 row8">${item.email}</td>
                                <td contenteditable class=" text-center p-2 row9">${item.gender}</td>
                                <td contenteditable class=" text-center p-2 row10">${item.ngaysinh}</td>
                                <td contenteditable class=" text-center p-2 row11">${item.quoctich}</td>
                                <td contenteditable class=" text-center p-2 row12">${item.trinhdo}</td>
                                <td contenteditable class=" text-center p-2 row13">${item.tdnv}</td>
                                <td contenteditable class=" text-center p-2 row14">${item.namtn}</td>
                                <td contenteditable class=" text-center p-2 row15">${item.noitn}</td>
                                <td contenteditable class=" text-center p-2 row16">${item.gvsp}</td>
                                <td contenteditable class=" text-center p-2 row17">${item.qlnn}</td>
                                <td contenteditable class=" text-center p-2 row18">${item.llct}</td>
                                <td contenteditable class=" text-center p-2 row19">${item.tinhoc}</td>
                                <td contenteditable class=" text-center p-2 row20">${item.ngoaingu}</td>
                                <td contenteditable class=" text-center p-2 row21">${item.hamphong}</td>
                                <td contenteditable class=" text-center p-2 row22">${item.namphong}</td>
                                <td contenteditable class=" text-center p-2 row23">${item.cdnntd}</td>
                                <td contenteditable class=" text-center p-2 row24">${item.mscdnn}</td>
                                <td contenteditable class=" text-center p-2 row25">${item.namtd}</td>
                                <td contenteditable class=" text-center p-2 row26">${item.cdnnht}</td>
                                <td contenteditable class=" text-center p-2 row27">${item.mscdht}</td>
                                <td contenteditable class=" text-center p-2 row28">${item.cocn}</td>
                                <td contenteditable class=" text-center p-2 row29">${item.namcn}</td>
                                <td contenteditable class=" text-center p-2 row30">
                                    <select class="listloaidv border-0 w-100">`;
                            for (const [index1, item1] of Object.entries(listdv)) { 
                                if(item.dvsdvc == index1){
                                    add += `<option selected value="${index1}">${item1}</option>`; 
                                }else{
                                    add += `<option value="${index1}">${item1}</option>`; 
                                }
                            }    
                            add += `</select>
                                </td>
                                <td contenteditable class=" text-center p-2 row31">${item.cdctht}</td>
                                <td contenteditable class=" text-center p-2 row32">${item.tdbn}</td>
                                <td contenteditable class=" text-center p-2 row33">${item.qdbn}</td>
                                <td contenteditable class=" text-center p-2 row34">${item.cdkm}</td>
                                <td contenteditable class=" text-center p-2 row35">${item.tdiemkn}</td>
                                <td contenteditable class=" text-center p-2 row36">${item.loaihd}</td>
                                <td contenteditable class=" text-center p-2 row37">${item.shdtd}</td>
                                <td contenteditable class=" text-center p-2 row38">${item.ngcd}</td>
                                <td contenteditable class=" text-center p-2 row39">${item.tggd}</td>
                                <td contenteditable class=" text-center p-2 row40">${item.nvdpc}</td>
                                <td contenteditable class=" text-center p-2 row41">${item.loptggd}</td>
                                <td contenteditable class=" text-center p-2 row42">${item.ckhbd}</td>
                                <td contenteditable class=" text-center p-2 row43">${item.xa}</td>
                                <td contenteditable class=" text-center p-2 row44">${item.huyen}</td>
                                <td contenteditable class=" text-center p-2 row45">${item.tinh}</td>
                                <td contenteditable class=" text-center p-2 row46">${item.trangthai}</td>
                                <td contenteditable class="text-center p-2 trash-btn">
                                    <ion-icon name="trash-outline" ></ion-icon>
                                </td>
                            </tr>
                    `;
                    $("#idtbody").append(add);

                //     // Validate các trường excel
                    checkEmpty();
                    checkWebsite();
                    checkEmail();
                    checkPhone();
                    checkNumber();
                    checkDate();
                });
                
            }
        });
    })


    $('#add_unit').on('click',()=>{
        var adds = `
            <tr class="row_number">
                <td contenteditable class="text-center p-2 row0"></td>
                <td contenteditable class="text-center p-2 row1"></td>
                <td contenteditable class="text-center p-2 row2"></td>
                <td contenteditable class="text-center p-2 row3"></td>
                <td contenteditable class="text-center p-2 row4"></td>
                <td contenteditable class="text-center p-2 row5"></td>
                <td contenteditable class="text-center p-2 row6"></td>
                <td contenteditable class="text-center p-2 row7"></td>
                <td contenteditable class="text-center p-2 row8"></td>
                <td contenteditable class="text-center p-2 row9"></td>
                <td contenteditable class="text-center p-2 row10"></td>
                <td contenteditable class="text-center p-2 row11"></td>
                <td contenteditable class="text-center p-2 row12"></td>
                <td contenteditable class="text-center p-2 row13"></td>
                <td contenteditable class="text-center p-2 row14"></td>
                <td contenteditable class="text-center p-2 row15"></td>
                <td contenteditable class="text-center p-2 row16"></td>
                <td contenteditable class="text-center p-2 row17"></td>
                <td contenteditable class="text-center p-2 row18"></td>
                <td contenteditable class="text-center p-2 row19"></td>
                <td contenteditable class="text-center p-2 row20"></td>
                <td contenteditable class="text-center p-2 row21"></td>
                <td contenteditable class="text-center p-2 row22"></td>
                <td contenteditable class="text-center p-2 row23"></td>
                <td contenteditable class="text-center p-2 row24"></td>
                <td contenteditable class="text-center p-2 row25"></td>
                <td contenteditable class="text-center p-2 row26"></td>
                <td contenteditable class="text-center p-2 row27"></td>
                <td contenteditable class="text-center p-2 row28"></td>
                <td contenteditable class="text-center p-2 row29"></td>
                <td contenteditable class="text-center p-2 row30">
                    <select class="listloaidv border-0 w-100">`;
            for (const [index1, item1] of Object.entries(listdv)) { 
                adds += `<option value="${index1}">${item1}</option>`; 
            }    
            adds += `</select>
                </td>
                <td contenteditable class="text-center p-2 row31"></td>
                <td contenteditable class="text-center p-2 row32"></td>
                <td contenteditable class="text-center p-2 row33"></td>
                <td contenteditable class="text-center p-2 row34"></td>
                <td contenteditable class="text-center p-2 row35"></td>
                <td contenteditable class="text-center p-2 row36"></td>
                <td contenteditable class="text-center p-2 row37"></td>
                <td contenteditable class="text-center p-2 row38"></td>
                <td contenteditable class="text-center p-2 row39"></td>
                <td contenteditable class="text-center p-2 row40"></td>
                <td contenteditable class="text-center p-2 row41"></td>
                <td contenteditable class="text-center p-2 row42"></td>
                <td contenteditable class="text-center p-2 row43"></td>
                <td contenteditable class="text-center p-2 row44"></td>
                <td contenteditable class="text-center p-2 row45"></td>
                <td contenteditable class="text-center p-2 row46"></td>
                <td contenteditable class="text-center p-2 trash-btn">
                    <ion-icon name="trash-outline"></ion-icon>
                </td>

            </tr>
            `;
        $("#idtbody").prepend(adds);
    })


    $("#idtableip").on("click", ".trash-btn", function() {
        $(this).parent().remove();
    })

    // validate when load excel data
    function checkEmpty() {
        let checkEmpty = true;
        let classEmpty = $("#idtableip").find(".check-empty")
        for (const [index1, item1] of Object.entries(classEmpty)) {
            if(item1.textContent != undefined){
                if(item1.textContent.trim()  == "" || item1.textContent.trim() == null){
                    item1.setAttribute("style", "background: " + listColor['check_empty']);
                    checkEmpty = false;
                }
            }
        }
        return checkEmpty;   
    }

    function checkWebsite() {
        let checkWebsite = true;
        let classWebsite = $("#idtableip").find(".check-website");
        let pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

        for (const [index1, item1] of Object.entries(classWebsite)) {
            if(item1.textContent != undefined){
                if(!pattern.test(item1.textContent.trim())){
                    item1.setAttribute("style", "background: " + listColor['check_website']);
                    checkWebsite = false;
                }
            }
        }
        return checkWebsite;      
    }

    function checkEmail() {
        let checkEmail = true;
        let classEmail = $("#idtableip").find(".check-email");
        let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        for (const [index1, item1] of Object.entries(classEmail)) {
            if(item1.textContent != undefined){
                if(!pattern.test(item1.textContent.trim())){
                    item1.setAttribute("style", "background: " + listColor['check_email']);
                    checkEmail = false;
                }
            }
        }
        return  checkEmail;  
    }

    function checkPhone() {
        let checkPhone = true;
        let classPhone = $("#idtableip").find(".check-phone");
        let pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

        for (const [index1, item1] of Object.entries(classPhone)) {
            if(item1.textContent != undefined){
                if(!pattern.test(item1.textContent.trim())
                ){
                    item1.setAttribute("style", "background: " + listColor['check_phone']);
                    checkPhone = false;
                }
            }
        }  
        return checkPhone; 
    }

    function checkNumber() {
        let checkNumber = true;
        let classNumber = $("#idtableip").find(".check-number");
        for (const [index1, item1] of Object.entries(classNumber)) {
            if(item1.textContent != undefined){
                if(isNaN(item1.textContent.trim())){
                    item1.setAttribute("style", "background: " + listColor['check_number']);
                    checkNumber = false;
                }
            }
        }
        return checkNumber;

    }

    function checkDate() {
        let checkDate = true;
        let classDate = $("#idtableip").find(".check-date");
        let pattern = /^\d{2}[./-]\d{2}[./-]\d{4}$/;

        for (const [index1, item1] of Object.entries(classDate)) {
            if(item1.textContent != undefined){
                if(!pattern.test(item1.textContent.trim())
                ){
                    item1.setAttribute("style", "background: " + listColor['check_date']);
                    checkDate = false;
                }
            }
        }
        return checkDate;  
    }
    
    
    
    // event when keyup attribute
    $("#idtableip").on("keyup", '.check-empty', function() {
        if($(this).text().trim()  == "" || $(this).text().trim() == null){
            $(this).attr("style", "background: " + listColor['check_empty'])
        }else{
            $(this).removeAttr("style");
        }
    })

    $("#idtableip").on("keyup", '.check-website', function() {
        let pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor['check_website'])
        }else{
            $(this).removeAttr("style");
        }  
    })
    

    $("#idtableip").on("keyup", '.check-email', function() {
        let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor['check_email'])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-phone', function() {
        let pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor['check_phone'])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-number', function() {
        if(isNaN($(this).text().trim())){
            $(this).attr("style", "background: " + listColor['check_number'])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-date', function() {
        let pattern = /^\d{2}[./-]\d{2}[./-]\d{4}$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor['check_date'])
        }else{
            $(this).removeAttr("style");
        }  
    })


    var dataSubmit = [];
    $("#import_unit_data").click(function() {
        if(checkEmpty() && checkWebsite() && checkEmail() && checkPhone()
            &&  checkNumber() && checkDate())   {            
            dataSubmit.length = 0;
            $(".row_number").each(function( index ) {
                let dataObj = {
                    'thoidiem' :   $(this).find('.row1').text().trim(),
                    'hodem' :      $(this).find('.row2').text().trim(),
                    'ten' :  $(this).find('.row3').text().trim(),
                    'shvc' :   $(this).find('.row4').text().trim(),
                    'cccd' :   $(this).find('.row5').text().trim(),
                    'dvct' :   $(this).find('.row6').text().trim(),
                    'phone' :  $(this).find('.row7').text().trim(),
                    'email' :  $(this).find('.row8').text().trim(),
                    'gender' : $(this).find('.row9').text().trim(),
                    'ngaysinh' :    $(this).find('.row10').text().trim(),
                    'quoctich' :   $(this).find('.row11').text().trim(),
                    'tdcm': $(this).find('.row12').text().trim(),
                    'tdnv' :    $(this).find('.row13').text().trim(),
                    'namtn' :   $(this).find('.row14').text().trim(),
                    'noitn' :  $(this).find('.row15').text().trim(),
                    'gvsp' :   $(this).find('.row16').text().trim(),
                    'qlnn' :    $(this).find('.row17').text().trim(),
                    'llct' :    $(this).find('.row18').text().trim(),
                    'tinhoc' :    $(this).find('.row19').text().trim(),
                    'ngoaingu' :  $(this).find('.row20').text().trim(),
                    'hocham' :   $(this).find('.row21').text().trim(),
                    'namphong' : $(this).find('.row22').text().trim(),
                    'cdnn' : $(this).find('.row23').text().trim(),
                    'masocd' :      $(this).find('.row24').text().trim(),
                    'namtd' :  $(this).find('.row25').text().trim(),
                    'cdnnht' :   $(this).find('.row26').text().trim(),
                    'masocdht' :  $(this).find('.row27').text().trim(),
                    'chuyenngach' :  $(this).find('.row28').text().trim(),
                    'namcn' : $(this).find('.row29').text().trim(),
                    'dvsdvc' :    $(this).find('.row30').find('select').val(),
                    'cdctht' :   $(this).find('.row31').text().trim(),
                    'tdbn': $(this).find('.row32').text().trim(),
                    'qdbn' :    $(this).find('.row33').text().trim(),
                    'cdkm' :   $(this).find('.row34').text().trim(),
                    'tdgkm' :  $(this).find('.row35').text().trim(),
                    'loaihd' :   $(this).find('.row36').text().trim(),
                    'shdtd' :   $(this).find('.row37').text().trim(),
                    'ngaycdhd' :    $(this).find('.row38').text().trim(),
                    'tggdht' :    $(this).find('.row39').text().trim(),
                    'nvdpc' :    $(this).find('.row40').text().trim(),
                    'ltggd' :  $(this).find('.row41').text().trim(),
                    'khbd' :   $(this).find('.row42').text().trim(),
                    'xa' :   $(this).find('.row43').text().trim(),
                    'huyen' :   $(this).find('.row44').text().trim(),
                    'tinh' :   $(this).find('.row45').text().trim(),
                    'trangthai' : $(this).find('.row46').text().trim(),
                }
                dataSubmit.push(dataObj);
            });
            let loadData = "{{ route('admin.importdata.nhansu.importDataUnit') }}";
            fetch(loadData, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                body: JSON.stringify(dataSubmit)
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.mes == "done"){
                        $("#file").val("");
                        $("#add_unit").hide();
                        $("#idtableip").empty();
                        $("#modal_unit").find("button.close").click();
                        table.ajax.reload();
                    }
                })
        }else{
            alert("@lang('project/ImportdataExcel/title.vlktldl')")
        }
    })

    $('#modalDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        var route = "{{ route('admin.importdata.nhansu.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.nhansu.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $('#forMaDV').val(data.thoidiem);
                $('#forHodem').val(data.hodem);
                $('#forTen').val(data.ten);
                $('#forTenDVTV').val(data.shvc);
                $('#forcccd').val(data.cccd);
                $('#fordvct').val(data.dvct);
                $('#forTenDVTA').val(data.phone);
                $('#forEmail').val(data.email);
                $('#forVTTV').val(data.gender);
                $('#forVTTA').val(data.ngaysinh);
                $('#forQuoctich').val(data.quoctich);
                $('#forTenTD').val(data.tdcm);
                $('#forChuquan').val(data.tdnv);
                $('#forNtl').val(data.namtn);
                $('#forLvhd').val(data.noitn);
                $('#forSdtlh').val(data.gvsp);
                $('#forFax').val(data.qlnn);
                $('#forLLCT').val(data.llct);
                $('#forWebsite').val(data.tinhoc);
                $('#forNote').val(data.ngoaingu);
                $('#forTgbdk1').val(data.hocham);
                $('#forTgcbk1').val(data.namphong);
                $('#forcdnnktd').val(data.cdnn);
                $('#formscdktd').val(data.masocd);
                $('#forntd').val(data.namtd);
                $('#forcdnnht').val(data.cdnnht);
                $('#formscdht').val(data.masocdht);
                $('#forccn').val(data.chuyenngach);
                $('#forncn').val(data.namcn);
                $('#fordvsdvc').val(data.dvsdvc);
                $('#forcdctht').val(data.cdctht);
                $('#fortdbm').val(data.tdbn);
                $('#forqdbm').val(data.qdbn);
                $('#forcdkm').val(data.cdkm);
                $('#fortdgkm').val(data.tdgkm);
                $('#forlhdlv').val(data.loaihd);
                $('#forshdtd').val(data.shdtd);
                $('#forncdhd').val(data.ngaycdhd);
                $('#fortggd').val(data.tggdht);
                $('#fornvdpc').val(data.nvdpc);
                $('#forltggd').val(data.ltggd);
                $('#forckhbd').val(data.khbd);
                $('#forxa').val(data.xa);
                $('#forhuyen').val(data.huyen);
                $('#fortinh').val(data.tinh);
                $('#fortrangthai').val(data.trangthai);
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
