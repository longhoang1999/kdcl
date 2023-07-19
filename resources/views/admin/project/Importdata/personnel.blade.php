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
        width:6000px;
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
                    @lang('project/ImportdataExcel/title.dienthoai')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.email')
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
                                <input type="text" class="form-control " id="forTenDVTV" placeholder="@lang('project/ImportdataExcel/title.shvc')" name="shvc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcccd">
                                    <span>@lang('project/ImportdataExcel/title.cccd')</span>
                                </label>
                                <input type="text" class="form-control " id="forcccd" placeholder="@lang('project/ImportdataExcel/title.cccd')" name="cccd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forTenDVTA">
                                    <span>@lang('project/ImportdataExcel/title.dienthoai')</span>
                                </label>
                                <input type="text" class="form-control " id="forTenDVTA" placeholder="@lang('project/ImportdataExcel/title.dienthoai')" name="dienthoai">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forEmail">
                                    <span>@lang('project/ImportdataExcel/title.email')</span>
                                </label>
                                <input type="email" class="form-control " id="forEmail" placeholder="@lang('project/ImportdataExcel/title.email')" name="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forVTTV">
                                    <span>@lang('project/ImportdataExcel/title.gioitinh')</span>
                                </label>
                                <input type="text" class="form-control " id="forVTTV" placeholder="@lang('project/ImportdataExcel/title.gioitinh')" name="gioitinh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forVTTA">
                                    <span>@lang('project/ImportdataExcel/title.ngaysinh')</span>
                                </label>
                                <input type="date" class="form-control " id="forVTTA" placeholder="@lang('project/ImportdataExcel/title.ngaysinh')" name="ngaysinh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forQuoctich">
                                    <span>@lang('project/ImportdataExcel/title.quoctich')</span>
                                </label>
                                <input type="text" class="form-control " id="forQuoctich" placeholder="@lang('project/ImportdataExcel/title.quoctich')" name="quoctich">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forsosobh">
                                    <span>@lang('project/ImportdataExcel/title.sosobh')</span>
                                </label>
                                <input type="text" class="form-control " id="forsosobh" placeholder="@lang('project/ImportdataExcel/title.sosobh')" name="sosobh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forxaphuongtc">
                                    <span>@lang('project/ImportdataExcel/title.xaphuongtc')</span>
                                </label>
                                <input type="text" class="form-control " id="forxaphuongtc" placeholder="@lang('project/ImportdataExcel/title.xaphuongtc')" name="xaphuongtc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forquanhuytc">
                                    <span>@lang('project/ImportdataExcel/title.quanhuytc')</span>
                                </label>
                                <input type="text" class="form-control " id="forquanhuytc" placeholder="@lang('project/ImportdataExcel/title.quanhuytc')" name="quanhuytc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortinhtptc">
                                    <span>@lang('project/ImportdataExcel/title.tinhtptc')</span>
                                </label>
                                <input type="text" class="form-control " id="fortinhtptc" placeholder="@lang('project/ImportdataExcel/title.tinhtptc')" name="tinhtptc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcvct">
                                    <span>@lang('project/ImportdataExcel/title.cvct')</span>
                                </label>
                                <input type="text" class="form-control " id="forcvct" placeholder="@lang('project/ImportdataExcel/title.cvct')" name="cvct">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fordvct">
                                    <span>@lang('project/ImportdataExcel/title.dvct')</span>
                                </label>
                                <input type="text" class="form-control " id="fordvct" placeholder="@lang('project/ImportdataExcel/title.dvct')" name="dvct">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forchdanh">
                                    <span>@lang('project/ImportdataExcel/title.chdanh')</span>
                                </label>
                                <input type="text" class="form-control " id="forchdanh" placeholder="@lang('project/ImportdataExcel/title.chdanh')" name="chdanh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortddt">
                                    <span>@lang('project/ImportdataExcel/title.tddt')</span>
                                </label>
                                <input type="text" class="form-control " id="fortddt" placeholder="@lang('project/ImportdataExcel/title.tddt')" name="tddt">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcmdt">
                                    <span>@lang('project/ImportdataExcel/title.cmdt')</span>
                                </label>
                                <input type="text" class="form-control " id="forcmdt" placeholder="@lang('project/ImportdataExcel/title.cmdt')" name="cmdt">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcsdt">
                                    <span>@lang('project/ImportdataExcel/title.csdt')</span>
                                </label>
                                <input type="text" class="form-control " id="forcsdt" placeholder="@lang('project/ImportdataExcel/title.csdt')" name="csdt">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fornamtn">
                                    <span>@lang('project/ImportdataExcel/title.namtn')</span>
                                </label>
                                <input type="text" class="form-control " id="fornamtn" placeholder="@lang('project/ImportdataExcel/title.namtn')" name="namtn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forccspgv">
                                    <span>@lang('project/ImportdataExcel/title.ccspgv')</span>
                                </label>
                                <input type="text" class="form-control " id="forccspgv" placeholder="@lang('project/ImportdataExcel/title.ccspgv')" name="ccspgv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forttqlnn">
                                    <span>@lang('project/ImportdataExcel/title.ttqlnn')</span>
                                </label>
                                <input type="text" class="form-control " id="forttqlnn" placeholder="@lang('project/ImportdataExcel/title.ttqlnn')" name="ttqlnn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortdllct">
                                    <span>@lang('project/ImportdataExcel/title.tdllct')</span>
                                </label>
                                <input type="text" class="form-control " id="fortdllct" placeholder="@lang('project/ImportdataExcel/title.tdllct')" name="tdllct">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="fortinhoc">
                                    <span>@lang('project/ImportdataExcel/title.tinhoc')</span>
                                </label>
                                <input type="text" class="form-control " id="fortinhoc" placeholder="@lang('project/ImportdataExcel/title.tinhoc')" name="tinhoc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forngoaingu">
                                    <span>@lang('project/ImportdataExcel/title.ngoaingu')</span>
                                </label>
                                <input type="text" class="form-control " id="forngoaingu" placeholder="@lang('project/ImportdataExcel/title.ngoaingu')" name="ngoaingu">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdnnktd">
                                    <span>@lang('project/ImportdataExcel/title.cdnnktd')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdnnktd" placeholder="@lang('project/ImportdataExcel/title.cdnnktd')" name="cdnnktd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="formscdktd">
                                    <span>@lang('project/ImportdataExcel/title.mscdktd')</span>
                                </label>
                                <input type="text" class="form-control " id="formscdktd" placeholder="@lang('project/ImportdataExcel/title.mscdktd')" name="mscdktd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forntd">
                                    <span>@lang('project/ImportdataExcel/title.ntd')</span>
                                </label>
                                <input type="text" class="form-control " id="forntd" placeholder="@lang('project/ImportdataExcel/title.ntd')" name="ntd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdnnht">
                                    <span>@lang('project/ImportdataExcel/title.cdnnht')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdnnht" placeholder="@lang('project/ImportdataExcel/title.cdnnht')" name="cdnnht">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="formscdht">
                                    <span>@lang('project/ImportdataExcel/title.mscdht')</span>
                                </label>
                                <input type="text" class="form-control " id="formscdht" placeholder="@lang('project/ImportdataExcel/title.mscdht')" name="mscdht">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forccn">
                                    <span>@lang('project/ImportdataExcel/title.ccn')</span>
                                </label>
                                <input type="text" class="form-control " id="forccn" placeholder="@lang('project/ImportdataExcel/title.ccn')" name="ccn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forncn">
                                    <span>@lang('project/ImportdataExcel/title.ncn')</span>
                                </label>
                                <input type="text" class="form-control " id="forncn" placeholder="@lang('project/ImportdataExcel/title.ncn')" name="ncn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fordvsdvc">
                                    <span>@lang('project/ImportdataExcel/title.dvsdvc')</span>
                                </label>
                                <select name="dvsdvc" id="fordvsdvc" class="form-control">
                                    @foreach($donvi as $dv)
                                        <option value="{{ $dv->ma_donvi }}">{{ $dv->ten_donvi_TV }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="forcdctht">
                                    <span>@lang('project/ImportdataExcel/title.cdctht')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdctht" placeholder="@lang('project/ImportdataExcel/title.cdctht')" name="cdctht">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortdbm">
                                    <span>@lang('project/ImportdataExcel/title.tdbm')</span>
                                </label>
                                <input type="text" class="form-control " id="fortdbm" placeholder="@lang('project/ImportdataExcel/title.tdbm')" name="tdbm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forqdbm">
                                    <span>@lang('project/ImportdataExcel/title.qdbm')</span>
                                </label>
                                <input type="text" class="form-control " id="forqdbm" placeholder="@lang('project/ImportdataExcel/title.qdbm')" name="qdbm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forhtbn">
                                    <span>@lang('project/ImportdataExcel/title.htbn')</span>
                                </label>
                                <input type="text" class="form-control " id="forhtbn" placeholder="@lang('project/ImportdataExcel/title.htbn')" name="htbn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fornqdbn">
                                    <span>@lang('project/ImportdataExcel/title.nqdbn')</span>
                                </label>
                                <input type="text" class="form-control " id="fornqdbn" placeholder="@lang('project/ImportdataExcel/title.nqdbn')" name="nqdbn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdnn">
                                    <span>@lang('project/ImportdataExcel/title.cdnn')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdnn" placeholder="@lang('project/ImportdataExcel/title.cdnn')" name="cdnn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdgv">
                                    <span>@lang('project/ImportdataExcel/title.cdgv')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdgv" placeholder="@lang('project/ImportdataExcel/title.cdgv')" name="cdgv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forcdkm">
                                    <span>@lang('project/ImportdataExcel/title.cdkm')</span>
                                </label>
                                <input type="text" class="form-control " id="forcdkm" placeholder="@lang('project/ImportdataExcel/title.cdkm')" name="cdkm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortdgkm">
                                    <span>@lang('project/ImportdataExcel/title.tdgkm')</span>
                                </label>
                                <input type="text" class="form-control " id="fortdgkm" placeholder="@lang('project/ImportdataExcel/title.tdgkm')" name="tdgkm">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forlhdlv">
                                    <span>@lang('project/ImportdataExcel/title.lhdlv')</span>
                                </label>
                                <input type="text" class="form-control " id="forlhdlv" placeholder="@lang('project/ImportdataExcel/title.lhdlv')" name="lhdlv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forshdtd">
                                    <span>@lang('project/ImportdataExcel/title.shdtd')</span>
                                </label>
                                <input type="text" class="form-control " id="forshdtd" placeholder="@lang('project/ImportdataExcel/title.shdtd')" name="shdtd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fornkhd">
                                    <span>@lang('project/ImportdataExcel/title.nkhd')</span>
                                </label>
                                <input type="text" class="form-control " id="fornkhd" placeholder="@lang('project/ImportdataExcel/title.nkhd')" name="nkhd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forncdhd">
                                    <span>@lang('project/ImportdataExcel/title.ncdhd')</span>
                                </label>
                                <input type="text" class="form-control " id="forncdhd" placeholder="@lang('project/ImportdataExcel/title.ncdhd')" name="ncdhd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forsoqdnh">
                                    <span>@lang('project/ImportdataExcel/title.soqdnh')</span>
                                </label>
                                <input type="text" class="form-control " id="forsoqdnh" placeholder="@lang('project/ImportdataExcel/title.soqdnh')" name="soqdnh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forngqdnh">
                                    <span>@lang('project/ImportdataExcel/title.ngqdnh')</span>
                                </label>
                                <input type="text" class="form-control " id="forngqdnh" placeholder="@lang('project/ImportdataExcel/title.ngqdnh')" name="ngqdnh">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forhtcd">
                                    <span>@lang('project/ImportdataExcel/title.htcd')</span>
                                </label>
                                <input type="text" class="form-control " id="forhtcd" placeholder="@lang('project/ImportdataExcel/title.htcd')" name="htcd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortggd">
                                    <span>@lang('project/ImportdataExcel/title.tggd')</span>
                                </label>
                                <input type="text" class="form-control " id="fortggd" placeholder="@lang('project/ImportdataExcel/title.tggd')" name="tggd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fornvdpc">
                                    <span>@lang('project/ImportdataExcel/title.nvdpc')</span>
                                </label>
                                <input type="text" class="form-control " id="fornvdpc" placeholder="@lang('project/ImportdataExcel/title.nvdpc')" name="nvdpc">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forltggd">
                                    <span>@lang('project/ImportdataExcel/title.ltggd')</span>
                                </label>
                                <input type="text" class="form-control " id="forltggd" placeholder="@lang('project/ImportdataExcel/title.ltggd')" name="ltggd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forckhbd">
                                    <span>@lang('project/ImportdataExcel/title.ckhbd')</span>
                                </label>
                                <input type="text" class="form-control " id="forckhbd" placeholder="@lang('project/ImportdataExcel/title.ckhbd')" name="ckhbd">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forttlamv">
                                    <span>@lang('project/ImportdataExcel/title.ttlamv')</span>
                                </label>
                                <input type="text" class="form-control " id="forttlamv" placeholder="@lang('project/ImportdataExcel/title.ttlamv')" name="ttlamv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortncongt">
                                    <span>@lang('project/ImportdataExcel/title.tncongt')</span>
                                </label>
                                <input type="text" class="form-control " id="fortncongt" placeholder="@lang('project/ImportdataExcel/title.tncongt')" name="tncongt">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forbacl">
                                    <span>@lang('project/ImportdataExcel/title.bacl')</span>
                                </label>
                                <input type="text" class="form-control " id="forbacl" placeholder="@lang('project/ImportdataExcel/title.bacl')" name="bacl">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forhesol">
                                    <span>@lang('project/ImportdataExcel/title.hesol')</span>
                                </label>
                                <input type="text" class="form-control " id="forhesol" placeholder="@lang('project/ImportdataExcel/title.hesol')" name="hesol">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forpcthamn">
                                    <span>@lang('project/ImportdataExcel/title.pcthamn')</span>
                                </label>
                                <input type="text" class="form-control " id="forpcthamn" placeholder="@lang('project/ImportdataExcel/title.pcthamn')" name="pcthamn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forpcudn">
                                    <span>@lang('project/ImportdataExcel/title.pcudn')</span>
                                </label>
                                <input type="text" class="form-control " id="forpcudn" placeholder="@lang('project/ImportdataExcel/title.pcudn')" name="pcudn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forpccv">
                                    <span>@lang('project/ImportdataExcel/title.pccv')</span>
                                </label>
                                <input type="text" class="form-control " id="forpccv" placeholder="@lang('project/ImportdataExcel/title.pccv')" name="pccv">
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
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'ttlamv', name: 'ttlamv' },
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
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.stt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.thoidiem')
                                </th>
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
                                    @lang('project/ImportdataExcel/title.sosobh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.xaphuongtc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.quanhuytc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tinhtptc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cvct')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dvct')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.chdanh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tddt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cmdt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.csdt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namtn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ccspgv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ttqlnn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tdllct')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tinhoc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ngoaingu')
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
                                    @lang('project/ImportdataExcel/title.htbn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nqdbn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdnn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cdgv')
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
                                    @lang('project/ImportdataExcel/title.nkhd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ncdhd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.soqdnh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ngqdnh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.htcd')
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
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ckhbd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ttlamv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tncongt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.bacl')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.hesol')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.pcthamn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.pcudn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.pccv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.thaotac')
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
                                <td contenteditable class=" text-center p-2 row6">${item.phone}</td>
                                <td contenteditable class=" text-center p-2 row7">${item.email}</td>
                                <td contenteditable class=" text-center p-2 row8">${item.gender}</td>
                                <td contenteditable class=" text-center p-2 row9">${item.ngaysinh}</td>
                                <td contenteditable class=" text-center p-2 row10">${item.quoctich}</td>

                                <td contenteditable class=" text-center p-2 row11">${item.sosobh}</td>
                                <td contenteditable class=" text-center p-2 row12">${item.xaphuongtc}</td>
                                <td contenteditable class=" text-center p-2 row13">${item.quanhuytc}</td>
                                <td contenteditable class=" text-center p-2 row14">${item.tinhtptc}</td>
                                <td contenteditable class=" text-center p-2 row15">${item.cvct}</td>
                                <td contenteditable class=" text-center p-2 row16">${item.dvct}</td>
                                <td contenteditable class=" text-center p-2 row17">${item.chdanh}</td>
                                <td contenteditable class=" text-center p-2 row18">${item.tddt}</td>
                                <td contenteditable class=" text-center p-2 row19">${item.cmdt}</td>
                                <td contenteditable class=" text-center p-2 row20">${item.csdt}</td>
                                <td contenteditable class=" text-center p-2 row21">${item.namtn}</td>
                                <td contenteditable class=" text-center p-2 row22">${item.ccspgv}</td>
                                <td contenteditable class=" text-center p-2 row23">${item.ttqlnn}</td>
                                <td contenteditable class=" text-center p-2 row24">${item.tdllct}</td>

                                <td contenteditable class=" text-center p-2 row25">${item.tinhoc}</td>
                                <td contenteditable class=" text-center p-2 row26">${item.ngoaingu}</td>
                                <td contenteditable class=" text-center p-2 row27">${item.cdnnktd}</td>
                                <td contenteditable class=" text-center p-2 row28">${item.mscdktd}</td>
                                <td contenteditable class=" text-center p-2 row29">${item.ntd}</td>
                                <td contenteditable class=" text-center p-2 row30">${item.cdnnht}</td>
                                <td contenteditable class=" text-center p-2 row31">${item.mscdht}</td>
                                <td contenteditable class=" text-center p-2 row32">${item.ccn}</td>
                                <td contenteditable class=" text-center p-2 row33">${item.ncn}</td>
                                <td contenteditable class=" text-center p-2 row34">
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
                                <td contenteditable class=" text-center p-2 row35">${item.cdctht}</td>
                                <td contenteditable class=" text-center p-2 row36">${item.tdbm}</td>
                                <td contenteditable class=" text-center p-2 row37">${item.qdbm}</td>
                                <td contenteditable class=" text-center p-2 row38">${item.htbn}</td>
                                <td contenteditable class=" text-center p-2 row39">${item.nqdbn}</td>
                                <td contenteditable class=" text-center p-2 row40">${item.cdnn}</td>
                                <td contenteditable class=" text-center p-2 row41">${item.cdgv}</td>
                                <td contenteditable class=" text-center p-2 row42">${item.cdkm}</td>
                                <td contenteditable class=" text-center p-2 row43">${item.tdgkm}</td>
                                <td contenteditable class=" text-center p-2 row44">${item.lhdlv}</td>
                                <td contenteditable class=" text-center p-2 row45">${item.shdtd}</td>
                                <td contenteditable class=" text-center p-2 row46">${item.nkhd}</td>
                                <td contenteditable class=" text-center p-2 row47">${item.ncdhd}</td>
                                <td contenteditable class=" text-center p-2 row48">${item.soqdnh}</td>
                                <td contenteditable class=" text-center p-2 row49">${item.ngqdnh}</td>
                                <td contenteditable class=" text-center p-2 row50">${item.htcd}</td>
                                <td contenteditable class=" text-center p-2 row51">${item.tggd}</td>
                                <td contenteditable class=" text-center p-2 row52">${item.nvdpc}</td>
                                <td contenteditable class=" text-center p-2 row53">${item.ltggd}</td>
                                <td contenteditable class=" text-center p-2 row54">${item.ckhbd}</td>
                                <td contenteditable class=" text-center p-2 row55">${item.ttlamv}</td>
                                <td contenteditable class=" text-center p-2 row56">${item.tncongt}</td>
                                <td contenteditable class=" text-center p-2 row57">${item.bacl}</td>
                                <td contenteditable class=" text-center p-2 row58">${item.hesol}</td>
                                <td contenteditable class=" text-center p-2 row59">${item.pcthamn}</td>
                                <td contenteditable class=" text-center p-2 row60">${item.pcudn}</td>
                                <td contenteditable class=" text-center p-2 row61">${item.pccv}</td>

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
                <td contenteditable class="text-center p-2 row30"></td>
                <td contenteditable class="text-center p-2 row31"></td>
                <td contenteditable class="text-center p-2 row32"></td>
                <td contenteditable class="text-center p-2 row33"></td>
                <td contenteditable class="text-center p-2 row34">
                    <select class="listloaidv border-0 w-100">`;
                    for (const [index1, item1] of Object.entries(listdv)) { 
                        adds += `<option value="${index1}">${item1}</option>`; 
                    }    
                    adds += `</select>
                </td>
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

                <td contenteditable class="text-center p-2 row47"></td>
                <td contenteditable class="text-center p-2 row48"></td>
                <td contenteditable class="text-center p-2 row49"></td>
                <td contenteditable class="text-center p-2 row50"></td>
                <td contenteditable class="text-center p-2 row51"></td>

                <td contenteditable class="text-center p-2 row52"></td>
                <td contenteditable class="text-center p-2 row53"></td>
                <td contenteditable class="text-center p-2 row54"></td>
                <td contenteditable class="text-center p-2 row55"></td>
                <td contenteditable class="text-center p-2 row56"></td>
                <td contenteditable class="text-center p-2 row57"></td>
                <td contenteditable class="text-center p-2 row58"></td>
                <td contenteditable class="text-center p-2 row59"></td>
                <td contenteditable class="text-center p-2 row60"></td>
                <td contenteditable class="text-center p-2 row61"></td>

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
                    'phone' :  $(this).find('.row6').text().trim(),
                    'email' :  $(this).find('.row7').text().trim(),
                    'gender' : $(this).find('.row8').text().trim(),
                    'ngaysinh' :    $(this).find('.row9').text().trim(),
                    'quoctich' :   $(this).find('.row10').text().trim(),

                    'sosobh' :   $(this).find('.row11').text().trim(),
                    'xaphuongtc' :   $(this).find('.row12').text().trim(),
                    'quanhuytc' :   $(this).find('.row13').text().trim(),
                    'tinhtptc' :   $(this).find('.row14').text().trim(),
                    'cvct' :   $(this).find('.row15').text().trim(),
                    'dvct' :   $(this).find('.row16').text().trim(),
                    'chdanh' :   $(this).find('.row17').text().trim(),
                    'tddt' :   $(this).find('.row18').text().trim(),
                    'cmdt' :   $(this).find('.row19').text().trim(),
                    'csdt' :   $(this).find('.row20').text().trim(),
                    'namtn' :   $(this).find('.row21').text().trim(),
                    'ccspgv' :   $(this).find('.row22').text().trim(),
                    'ttqlnn' :   $(this).find('.row23').text().trim(),
                    'tdllct' :   $(this).find('.row24').text().trim(),
                    'tinhoc' :   $(this).find('.row25').text().trim(),
                    'ngoaingu' :   $(this).find('.row26').text().trim(),
                    'cdnnktd' :   $(this).find('.row27').text().trim(),
                    'mscdktd' :   $(this).find('.row28').text().trim(),
                    'ntd' :   $(this).find('.row29').text().trim(),
                    'cdnnht' :   $(this).find('.row30').text().trim(),
                    'mscdht' :   $(this).find('.row31').text().trim(),
                    'ccn' :   $(this).find('.row32').text().trim(),
                    'ncn' :   $(this).find('.row33').text().trim(),
                    'dvsdvc' :   $(this).find('.row34').find('select').val(),

                    'cdctht' :   $(this).find('.row35').text().trim(),
                    'tdbm' :   $(this).find('.row36').text().trim(),
                    'qdbm' :   $(this).find('.row37').text().trim(),
                    'htbn' :   $(this).find('.row38').text().trim(),
                    'nqdbn' :   $(this).find('.row39').text().trim(),
                    'cdnn' :   $(this).find('.row40').text().trim(),
                    'cdgv' :   $(this).find('.row41').text().trim(),
                    'cdkm' :   $(this).find('.row42').text().trim(),
                    'tdgkm' :   $(this).find('.row43').text().trim(),
                    'lhdlv' :   $(this).find('.row44').text().trim(),
                    'shdtd' :   $(this).find('.row45').text().trim(),
                    'nkhd' :   $(this).find('.row46').text().trim(),
                    'ncdhd' :   $(this).find('.row47').text().trim(),
                    'soqdnh' :   $(this).find('.row48').text().trim(),
                    'ngqdnh' :   $(this).find('.row49').text().trim(),
                    'htcd' :   $(this).find('.row50').text().trim(),
                    'tggd' :   $(this).find('.row51').text().trim(),
                    'nvdpc' :   $(this).find('.row52').text().trim(),
                    'ltggd' :   $(this).find('.row53').text().trim(),
                    'ckhbd' :   $(this).find('.row54').text().trim(),
                    'ttlamv' :   $(this).find('.row55').text().trim(),
                    'tncongt' :   $(this).find('.row56').text().trim(),
                    'bacl' :   $(this).find('.row57').text().trim(),
                    'hesol' :   $(this).find('.row58').text().trim(),
                    'pcthamn' :   $(this).find('.row59').text().trim(),
                    'pcudn' :   $(this).find('.row60').text().trim(),
                    'pccv' :   $(this).find('.row61').text().trim(),
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
                $('#forTenDVTA').val(data.phone);
                $('#forEmail').val(data.email);
                $('#forVTTV').val(data.gender);
                $('#forVTTA').val(data.ngaysinh);
                $('#forQuoctich').val(data.quoctich);
                
                $('#forsosobh').val(data.sosobh);
                $('#forxaphuongtc').val(data.xaphuongtc);
                $('#forquanhuytc').val(data.quanhuytc);
                $('#fortinhtptc').val(data.tinhtptc);
                $('#forcvct').val(data.cvct);
                $('#fordvct').val(data.dvct);
                $('#forchdanh').val(data.chdanh);
                $('#fortddt').val(data.tddt);
                $('#forcmdt').val(data.cmdt);
                $('#forcsdt').val(data.csdt);
                $('#fornamtn').val(data.namtn);
                $('#forccspgv').val(data.ccspgv);
                $('#forttqlnn').val(data.ttqlnn);
                $('#fortdllct').val(data.tdllct);
                $('#fortinhoc').val(data.tinhoc);
                $('#forngoaingu').val(data.ngoaingu);
                $('#forcdnnktd').val(data.cdnnktd);
                $('#formscdktd').val(data.mscdktd);
                $('#forntd').val(data.ntd);

                $('#forcdnnht').val(data.cdnnht);
                $('#formscdht').val(data.mscdht);
                $('#forccn').val(data.ccn);
                $('#forncn').val(data.ncn);
                $('#fordvsdvc').val(data.dvsdvc);
                
                $('#forcdctht').val(data.cdctht);
                $('#fortdbm').val(data.tdbm);
                $('#forqdbm').val(data.qdbm);
                $('#forhtbn').val(data.htbn);
                $('#fornqdbn').val(data.nqdbn);
                $('#forcdnn').val(data.cdnn);
                
                $('#forcdgv').val(data.cdgv);
                $('#forcdkm').val(data.cdkm);
                $('#fortdgkm').val(data.tdgkm);
                $('#forlhdlv').val(data.lhdlv);
                $('#forshdtd').val(data.shdtd);
                $('#fornkhd').val(data.nkhd);
                $('#forncdhd').val(data.ncdhd);
                $('#forsoqdnh').val(data.soqdnh);
                $('#forngqdnh').val(data.ngqdnh);
                $('#forhtcd').val(data.htcd);
                $('#fortggd').val(data.tggd);
                $('#fornvdpc').val(data.nvdpc);
                $('#forltggd').val(data.ltggd);
                $('#forckhbd').val(data.ckhbd);
                $('#forttlamv').val(data.ttlamv);
                $('#fortncongt').val(data.tncongt);
                $('#forbacl').val(data.bacl);
                $('#forhesol').val(data.hesol);
                $('#forpcthamn').val(data.pcthamn);
                $('#forpcudn').val(data.pcudn);
                $('#forpccv').val(data.pccv);
                
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
