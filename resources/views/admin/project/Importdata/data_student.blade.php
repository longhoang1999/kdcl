@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.dlsinhvien')
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
        width:3000px;
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
    @lang('project/ImportdataExcel/title.dlsinhvien')
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
            <a href="{{ route('admin.importdata.dlsinhvien.exportUnit') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
        </div>
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>
                    @lang('project/ImportdataExcel/title.stt1')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.msv')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hoten')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tennganh')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.nbdck')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.trinhdo')
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
                    @lang('project/ImportdataExcel/title.ndlsv')
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
                        @lang('project/ImportdataExcel/title.themtt')
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
                    @lang('project/ImportdataExcel/title.cnttdv')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.importdata.dlsinhvien.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="formsv">
                                    <span>@lang('project/ImportdataExcel/title.msv')</span>
                                </label>
                                <input type="text" class="form-control " id="formsv" placeholder="@lang('project/ImportdataExcel/title.msv')" name="msv">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forho">
                                    <span>@lang('project/ImportdataExcel/title.ho')</span>
                                </label>
                                <input type="text" class="form-control " id="forho" placeholder="@lang('project/ImportdataExcel/title.ho')" name="ho">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forten">
                                    <span>@lang('project/ImportdataExcel/title.ten')</span>
                                </label>
                                <input type="text" class="form-control " id="forten" placeholder="@lang('project/ImportdataExcel/title.ten')" name="ten">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forntns">
                                    <span>@lang('project/ImportdataExcel/title.ntns')</span>
                                </label>
                                <input type="text" class="form-control " id="forntns" placeholder="@lang('project/ImportdataExcel/title.ntns')" name="ntns">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forgioitinh">
                                    <span>@lang('project/ImportdataExcel/title.gioitinh')</span>
                                </label>
                                <input type="text" class="form-control " id="forgioitinh" placeholder="@lang('project/ImportdataExcel/title.gioitinh')" name="gioitinh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="foremail">
                                    <span>@lang('project/ImportdataExcel/title.email')</span>
                                </label>
                                <input type="text" class="form-control " id="foremail" placeholder="@lang('project/ImportdataExcel/title.email')" name="email">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forphone">
                                    <span>@lang('project/ImportdataExcel/title.phone')</span>
                                </label>
                                <input type="text" class="form-control " id="forphone" placeholder="@lang('project/ImportdataExcel/title.phone')" name="phone">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forcccd">
                                    <span>@lang('project/ImportdataExcel/title.cccd')</span>
                                </label>
                                <input type="text" class="form-control " id="forcccd" placeholder="@lang('project/ImportdataExcel/title.cccd')" name="cccd">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forlop">
                                    <span>@lang('project/ImportdataExcel/title.lop')</span>
                                </label>
                                <input type="text" class="form-control " id="forlop" placeholder="@lang('project/ImportdataExcel/title.lop')" name="lop">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forxa">
                                    <span>@lang('project/ImportdataExcel/title.xa')</span>
                                </label>
                                <input type="text" class="form-control " id="forxa" placeholder="@lang('project/ImportdataExcel/title.xa')" name="xa">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forhuyen">
                                    <span>@lang('project/ImportdataExcel/title.huyen')</span>
                                </label>
                                <input type="text" class="form-control " id="forhuyen" placeholder="@lang('project/ImportdataExcel/title.huyen')" name="huyen">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortinh">
                                    <span>@lang('project/ImportdataExcel/title.tinh')</span>
                                </label>
                                <input type="text" class="form-control " id="fortinh" placeholder="@lang('project/ImportdataExcel/title.tinh')" name="tinh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordantoc">
                                    <span>@lang('project/ImportdataExcel/title.dantoc')</span>
                                </label>
                                <input type="text" class="form-control " id="fordantoc" placeholder="@lang('project/ImportdataExcel/title.dantoc')" name="dantoc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forquoctich">
                                    <span>@lang('project/ImportdataExcel/title.quoctich')</span>
                                </label>
                                <input type="text" class="form-control " id="forquoctich" placeholder="@lang('project/ImportdataExcel/title.quoctich')" name="quoctich">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortennganh">
                                    <span>@lang('project/ImportdataExcel/title.tennganh')</span>
                                </label>
                                <input type="text" class="form-control " id="fortennganh" placeholder="@lang('project/ImportdataExcel/title.tennganh')" name="tennganh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="formanganh">
                                    <span>@lang('project/ImportdataExcel/title.manganh')</span>
                                </label>
                                <input type="text" class="form-control " id="formanganh" placeholder="@lang('project/ImportdataExcel/title.manganh')" name="manganh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="formanganhTS">
                                    <span>@lang('project/ImportdataExcel/title.manganhts')</span>
                                </label>
                                <input type="text" class="form-control " id="formanganhTS" placeholder="@lang('project/ImportdataExcel/title.manganhts')" name="manganhts">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkqxhtnam1">
                                    <span>@lang('project/ImportdataExcel/title.kqxhtnam1')</span>
                                </label>
                                <input type="text" class="form-control " id="forkqxhtnam1" placeholder="@lang('project/ImportdataExcel/title.kqxhtnam1')" name="kqxhtnam1">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkqxhtnam2">
                                    <span>@lang('project/ImportdataExcel/title.kqxhtnam2')</span>
                                </label>
                                <input type="text" class="form-control " id="forkqxhtnam2" placeholder="@lang('project/ImportdataExcel/title.kqxhtnam2')" name="kqxhtnam2">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkqxhtnam3">
                                    <span>@lang('project/ImportdataExcel/title.kqxhtnam3')</span>
                                </label>
                                <input type="text" class="form-control " id="forkqxhtnam3" placeholder="@lang('project/ImportdataExcel/title.kqxhtnam3')" name="kqxhtnam3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkqxhtnam4">
                                    <span>@lang('project/ImportdataExcel/title.kqxhtnam4')</span>
                                </label>
                                <input type="text" class="form-control " id="forkqxhtnam4" placeholder="@lang('project/ImportdataExcel/title.kqxhtnam4')" name="kqxhtnam4">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkqxhtnam5">
                                    <span>@lang('project/ImportdataExcel/title.kqxhtnam5')</span>
                                </label>
                                <input type="text" class="form-control " id="forkqxhtnam5" placeholder="@lang('project/ImportdataExcel/title.kqxhtnam5')" name="kqxhtnam5">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornbdck">
                                    <span>@lang('project/ImportdataExcel/title.nbdck')</span>
                                </label>
                                <input type="number" class="form-control " id="fornbdck" placeholder="@lang('project/ImportdataExcel/title.nbdck')" name="nbdck">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornktkh">
                                    <span>@lang('project/ImportdataExcel/title.nktkh')</span>
                                </label>
                                <input type="number" class="form-control " id="fornktkh" placeholder="@lang('project/ImportdataExcel/title.nktkh')" name="nktkh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortrangthai">
                                    <span>@lang('project/ImportdataExcel/title.trangthai')</span>
                                </label>
                                <input type="text" class="form-control " id="fortrangthai" placeholder="@lang('project/ImportdataExcel/title.trangthai')" name="trangthai">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamnh">
                                    <span>@lang('project/ImportdataExcel/title.namnh')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamnh" placeholder="@lang('project/ImportdataExcel/title.namnh')" name="namnh">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamtn">
                                    <span>@lang('project/ImportdataExcel/title.namtn')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamtn" placeholder="@lang('project/ImportdataExcel/title.namtn')" name="namtn">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamqd">
                                    <span>@lang('project/ImportdataExcel/title.namqd')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamqd" placeholder="@lang('project/ImportdataExcel/title.namqd')" name="namqd">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamnb">
                                    <span>@lang('project/ImportdataExcel/title.namnb')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamnb" placeholder="@lang('project/ImportdataExcel/title.namnb')" name="namnb">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forbaocaobo">
                                    <span>@lang('project/ImportdataExcel/title.baocaobo')</span>
                                </label>
                                <input type="text" class="form-control " id="forbaocaobo" placeholder="@lang('project/ImportdataExcel/title.baocaobo')" name="baocaobo">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortrinhdo">
                                    <span>@lang('project/ImportdataExcel/title.trinhdo')</span>
                                </label>
                                <input type="text" class="form-control " id="fortrinhdo" placeholder="@lang('project/ImportdataExcel/title.trinhdo')" name="trinhdo">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamdulien">
                                    <span>@lang('project/ImportdataExcel/title.namdulien')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamdulien" placeholder="@lang('project/ImportdataExcel/title.namdulien')" name="namdulien">
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
            ajax: "{!! route('admin.importdata.dlsinhvien.dataUnit') !!}",
            columns: [
                { data: 'masv', name: 'masv' },
                { data: 'hoten', name: 'hoten' },
                { data: 'tennganh', name: 'tennganh' },
                { data: 'nbdck', name: 'nbdck' },
                { data: 'trinhdo', name: 'trinhdo' },
                { data: 'actions', name: 'actions',className: 'action' },
            ],            
        });
    });  

    $('#import_unit').on('click', function () {
        var f =  $("#forMaDVIP").val(1);
        var formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');

        var listloaidv = {
            @foreach($loai_dv as $ldv)
                {{ $ldv->id }} : '{{ $ldv->loai_donvi }}', 
            @endforeach
        };

        $.ajax({
            url : "{!! route('admin.importdata.dlsinhvien.importUnit') !!}",
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
                                    @lang('project/ImportdataExcel/title.msv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ho')                                  
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ten')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ntns')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.gioitinh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.email')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.phone')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cccd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.lop')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.xa')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.huyen')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tinh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dantoc')
                                    
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.quoctich')
                                    
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tennganh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.manganh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.manganhts')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kqxhtnam1')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kqxhtnam2')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kqxhtnam3')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kqxhtnam4')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kqxhtnam5')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nbdck')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nktkh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.trangthai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namnh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namtn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namqd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namnb')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.baocaobo')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.trinhdo')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namdulien')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.thaotac')
                                </th>
                            </tr>
                        </thead>
                        <tbody id="idtbody"></tbody>
                `
                $("#idtableip").append(thead);
                data.forEach((item, index) => { 
                    var add = `
                        <tr class="row_number">
                                <td contenteditable class="text-center p-2 row0">${item.stt}</td>
                                <td contenteditable class="text-center p-2 row1">
                                    ${item.msv}
                                </td>
                                <td contenteditable class="text-center check-select p-2 row2">
                                    ${item.ho}
                                </td>
                                <td contenteditable class="text-center p-2 row3">
                                    ${item.ten}
                                </td>
                                <td contenteditable class="text-center p-2 row4">
                                    ${item.ntns}
                                </td>
                                <td contenteditable class="text-center p-2 row5">
                                    ${item.gioitinh}
                                </td>
                                <td contenteditable class="text-center p-2 row6">
                                    ${item.email}
                                </td>
                                <td contenteditable class="text-center p-2 row7">
                                    ${item.phone}
                                </td>
                                <td contenteditable class="text-center p-2 row8">
                                    ${item.cccd}
                                </td>
                                <td contenteditable class="text-center p-2 row9">
                                    ${item.lop}
                                </td>
                                <td contenteditable class="text-center p-2 row10">
                                    ${item.xa}
                                </td>
                                <td contenteditable class="text-center p-2 row11">
                                    ${item.huyen}
                                </td>
                                <td contenteditable class="text-center p-2 row12">
                                    ${item.tinh}
                                </td>
                                <td contenteditable class="text-center p-2 row13">
                                    ${item.dantoc}
                                </td>
                                <td contenteditable class="text-center p-2 row14">
                                    ${item.quoctich}
                                </td>
                                <td contenteditable class="text-center p-2 row15">
                                    ${item.tennganh}
                                </td>
                                <td contenteditable class="text-center p-2 row16">
                                    ${item.manganh}
                                </td>
                                <td contenteditable class="text-center p-2 row17">
                                    ${item.manganhts}
                                </td>
                                <td contenteditable class="text-center p-2 row18">
                                    ${item.kqxhtnam1}
                                </td>
                                <td contenteditable class="text-center p-2 row19">
                                    ${item.kqxhtnam2}
                                </td>
                                <td contenteditable class="text-center p-2 row20">
                                    ${item.kqxhtnam3}
                                </td>
                                <td contenteditable class="text-center p-2 row21">
                                    ${item.kqxhtnam4}
                                </td>
                                <td contenteditable class="text-center p-2 row22">
                                    ${item.kqxhtnam5}
                                </td>
                                <td contenteditable class="text-center p-2 row23">
                                    ${item.nbdck}
                                </td>
                                <td contenteditable class="text-center p-2 row24">
                                    ${item.nktkh}
                                </td>
                                <td contenteditable class="text-center p-2 row25">
                                    ${item.trangthai}
                                </td>
                                <td contenteditable class="text-center p-2 row26">
                                    ${item.namnh}
                                </td>
                                <td contenteditable class="text-center p-2 row27">
                                    ${item.namtn}
                                </td>
                                <td contenteditable class="text-center p-2 row28">
                                    ${item.namqd}
                                </td>
                                <td contenteditable class="text-center p-2 row29">
                                    ${item.namnb}
                                </td>
                                <td contenteditable class="text-center p-2 row30">
                                    ${item.baocaobo}
                                </td>
                                <td contenteditable class="text-center p-2 row31">
                                    ${item.trinhdo}
                                </td>
                                <td contenteditable class="text-center p-2 row32">
                                    ${item.namdulien}
                                </td>
                                <td contenteditable class="text-center p-2 trash-btn">
                                    <ion-icon name="trash-outline" ></ion-icon>
                                </td>
                            </tr>
                    `;
                    $("#idtbody").append(add);

                    // Validate các trường excel
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
                    item1.setAttribute("style", "background: " + listColor['']);
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
                    item1.setAttribute("style", "background: " + listColor['']);
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
                    item1.setAttribute("style", "background: " + listColor['']);
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
                    item1.setAttribute("style", "background: " + listColor['']);
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
                    item1.setAttribute("style", "background: " + listColor['']);
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
                    item1.setAttribute("style", "background: " + listColor['']);
                    checkDate = false;
                }
            }
        }
        return checkDate;  
    }
    
    
    
    // event when keyup attribute
    $("#idtableip").on("keyup", '.check-empty', function() {
        if($(this).text().trim()  == "" || $(this).text().trim() == null){
            $(this).attr("style", "background: " + listColor[''])
        }else{
            $(this).removeAttr("style");
        }
    })

    $("#idtableip").on("keyup", '.check-website', function() {
        let pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor[''])
        }else{
            $(this).removeAttr("style");
        }  
    })
    

    $("#idtableip").on("keyup", '.check-email', function() {
        let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor[''])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-phone', function() {
        let pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor[''])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-number', function() {
        if(isNaN($(this).text().trim())){
            $(this).attr("style", "background: " + listColor[''])
        }else{
            $(this).removeAttr("style");
        }  
    })

    $("#idtableip").on("keyup", '.check-date', function() {
        let pattern = /^\d{2}[./-]\d{2}[./-]\d{4}$/;
        if(!pattern.test($(this).text().trim())){
            $(this).attr("style", "background: " + listColor[''])
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
                    'stt' :   $(this).find('.row0').text().trim(),
                    'msv' :      $(this).find('.row1').text().trim(),
                    'ho' :  $(this).find('.row2').text().trim(),
                    'ten' :   $(this).find('.row3').text().trim(),
                    'ntns' :   $(this).find('.row4').text().trim(),
                    'gioitinh' :   $(this).find('.row5').text().trim(),
                    'email' :   $(this).find('.row6').text().trim(),
                    'phone' :   $(this).find('.row7').text().trim(),
                    'cccd' :   $(this).find('.row8').text().trim(),
                    'lop' :  $(this).find('.row9').text().trim(),
                    'xa' :  $(this).find('.row10').text().trim(),
                    'huyen' : $(this).find('.row11').text().trim(),
                    'tinh' :    $(this).find('.row12').text().trim(),
                    'dantoc' :   $(this).find('.row13').text().trim(),
                    'quoctich': $(this).find('.row14').text().trim(),
                    'tennganh' :    $(this).find('.row15').text().trim(),
                    'manganh' :   $(this).find('.row16').text().trim(),
                    'manganhts' :   $(this).find('.row17').text().trim(),
                    'kqxhtnam1' :  $(this).find('.row18').text().trim(),
                    'kqxhtnam2' :   $(this).find('.row19').text().trim(),
                    'kqxhtnam3' :    $(this).find('.row20').text().trim(),
                    'kqxhtnam4' :    $(this).find('.row21').text().trim(),
                    'kqxhtnam5' :    $(this).find('.row22').text().trim(),
                    'nbdck' :  $(this).find('.row23').text().trim(),
                    'nktkh' :   $(this).find('.row24').text().trim(),
                    'trangthai' : $(this).find('.row25').text().trim(),
                    'namnh' : $(this).find('.row26').text().trim(),
                    'namtn' : $(this).find('.row27').text().trim(),
                    'namqd' : $(this).find('.row28').text().trim(),
                    'namnb' : $(this).find('.row29').text().trim(),
                    'baocaobo' : $(this).find('.row30').text().trim(),
                    'trinhdo' : $(this).find('.row31').text().trim(),
                    'namdulien' : $(this).find('.row32').text().trim(),
                }
                dataSubmit.push(dataObj);
            });
            

            let loadData = "{{ route('admin.importdata.dlsinhvien.importDataUnit') }}";
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
                        $("#modal_unit").modal("hide");
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
        var route = "{{ route('admin.importdata.dlsinhvien.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.dlsinhvien.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $('#formsv').val(data.masv);
                $('#forho').val(data.ho);
                $('#forten').val(data.ten);
                $('#forntns').val(data.ntns);
                $('#forgioitinh').val(data.gioitinh);
                $('#foremail').val(data.email);
                $('#forphone').val(data.phone);
                $('#forcccd').val(data.cccd);
                $('#forlop').val(data.lop);
                $('#forxa').val(data.xa);
                $('#forhuyen').val(data.huyen);
                $('#fortinh').val(data.tinh);
                $('#fordantoc').val(data.dantoc);
                $('#forquoctich').val(data.quoctich);
                $('#fortennganh').val(data.tennganh);
                $('#formanganh').val(data.manganh);
                $('#formanganhTS').val(data.manganhTS);
                $('#forkqxhtnam1').val(data.kqxhtnam1);
                $('#forkqxhtnam2').val(data.kqxhtnam2);
                $('#forkqxhtnam3').val(data.kqxhtnam3);
                $('#forkqxhtnam4').val(data.kqxhtnam4);
                $('#forkqxhtnam5').val(data.kqxhtnam5);
                $('#fornbdck').val(data.nbdck);
                $('#fornktkh').val(data.nktkh);
                $('#fortrangthai').val(data.trangthai);
                $('#fornamnh').val(data.namnh);
                $('#fornamtn').val(data.namtn);
                $('#fornamqd').val(data.namqd);
                $('#fornamnb').val(data.namnb);
                $('#forbaocaobo').val(data.baocaobo);
                $('#fortrinhdo').val(data.trinhdo);
                $('#fornamdulien').val(data.namdulien);
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
