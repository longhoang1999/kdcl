@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.ttcb')
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
    @lang('project/ImportdataExcel/title.ttcb')
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
            <a href="{{ route('admin.importdata.thongtincoban.exportBasiclnfor') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_donvi" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
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
                    @lang('project/ImportdataExcel/title.madvi')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tendviTV')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.loaidv')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.ntl')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.lvhd')
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
                    @lang('project/ImportdataExcel/title.nttcb')
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
                <form action="{{ route('admin.importdata.thongtincoban.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="forMaDV">
                                    <span>@lang('project/ImportdataExcel/title.madv')</span>
                                </label>
                                <input type="number" class="form-control " id="forMaDV" placeholder="@lang('project/ImportdataExcel/title.madv')" name="madv">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forLoaiDv">
                                    <span>@lang('project/ImportdataExcel/title.loaidv')</span>
                                </label>
                                <select name="loaidv" id="forLoaiDv" class="form-control border-1 w-100">
                                    @foreach($loai_dv as $ldv)
                                        <option value="{{ $ldv->id }}">{{ $ldv->loai_donvi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="forTenDVTV">
                                    <span>@lang('project/ImportdataExcel/title.tendviTV')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control " id="forTenDVTV" placeholder="@lang('project/ImportdataExcel/title.tendviTV')" required name="tendviTV">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forTenDVTA">
                                    <span>@lang('project/ImportdataExcel/title.tendviTA')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control " id="forTenDVTA" placeholder="@lang('project/ImportdataExcel/title.tendviTA')" required name="tendviTA">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="forVTTV">
                                    <span>@lang('project/ImportdataExcel/title.tendvtTV')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control " id="forVTTV" placeholder="@lang('project/ImportdataExcel/title.tendvtTV')" required name="viettatTV">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forVTTA">
                                    <span>@lang('project/ImportdataExcel/title.tendvtTA')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control " id="forVTTA" placeholder="@lang('project/ImportdataExcel/title.tendvtTA')" required name="viettatTA">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forTenTD">
                                    <span>@lang('project/ImportdataExcel/title.tentd')</span>
                                </label>
                                <input type="text" class="form-control " id="forTenTD" placeholder="@lang('project/ImportdataExcel/title.tentd')" required name="tentruocday">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forChuquan">
                                    <span>@lang('project/ImportdataExcel/title.cqBcq')</span>
                                </label>
                                <input type="text" class="form-control " id="forChuquan" placeholder="@lang('project/ImportdataExcel/title.cqBcq')" required name="chuquan">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forNtl">
                                    <span>@lang('project/ImportdataExcel/title.ntl')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" id="forNtl" type="date" placeholder="@lang('project/ImportdataExcel/title.ntl')" name="ngay_thanhlap" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forsoqd">
                                    <span>@lang('project/ImportdataExcel/title.soqd')</span>
                                </label>
                                <input class="form-control" id="forsoqd" type="text" placeholder="@lang('project/ImportdataExcel/title.soqd')" required name="soqd"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forLvhd">
                                    <span>@lang('project/ImportdataExcel/title.lvhd')</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" id="forLvhd" type="text" placeholder="@lang('project/ImportdataExcel/title.lvhd')" required name="lvhoatdong"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forSdtlh">
                                    <span>@lang('project/ImportdataExcel/title.sdtlh')</span>
                                </label>
                                <input class="form-control" id="forSdtlh" type="text" placeholder="@lang('project/ImportdataExcel/title.sdtlh')" required name="phone"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forFax">
                                    <span>@lang('project/ImportdataExcel/title.sofax')</span>
                                </label>
                                <input class="form-control" id="forFax" type="text" placeholder="@lang('project/ImportdataExcel/title.sofax')" required name="fax"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forEmail">
                                    <span>@lang('project/ImportdataExcel/title.email')</span>
                                </label>
                                <input class="form-control" id="forEmail" type="text" placeholder="@lang('project/ImportdataExcel/title.email')" required 
                                name="email"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forWebsite">
                                    <span>@lang('project/ImportdataExcel/title.website')</span>
                                </label>
                                <input class="form-control" id="forWebsite" type="text" placeholder="@lang('project/ImportdataExcel/title.website')" required name="website"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forNote">
                                    <span>@lang('project/ImportdataExcel/title.ghichu')</span>
                                </label>
                                <input class="form-control" id="forNote" type="text" placeholder="@lang('project/ImportdataExcel/title.ghichu')" required name="note"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="forLhcsgd">
                                    <span>@lang('project/ImportdataExcel/title.lhcsgd')</span>
                                </label>
                                <input class="form-control" id="forLhcsgd" type="text" placeholder="@lang('project/ImportdataExcel/title.lhcsgd')" required name="lhcsgd"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forTgbdk1">
                                    <span>@lang('project/ImportdataExcel/title.tgbdk1')</span>
                                </label>
                                <input class="form-control" id="forTgbdk1" type="text" placeholder="@lang('project/ImportdataExcel/title.tgbdk1')" required name="tgbdk1"> 
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forTgcbk1">
                                    <span>@lang('project/ImportdataExcel/title.tgcbk1')</span>
                                </label>
                                <input class="form-control" id="forTgcbk1" type="text" placeholder="@lang('project/ImportdataExcel/title.tgcbk1')" required name="tgcbk1"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="forDiachi">
                                    <span>@lang('project/ImportdataExcel/title.diachi')</span>
                                </label>
                                <textarea class="form-control" placeholder="@lang('project/ImportdataExcel/title.tgcbk1')" id="forDiachi" name="diachi"></textarea>
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
            ajax: "{!! route('admin.importdata.thongtincoban.dataUnit') !!}",
            columns: [
                { data: 'stt', name: 'stt' ,className: 'stt'},
                { data: 'ma_donvi', name: 'ma_donvi' },
                { data: 'ten_donvi_TV', name: 'ten_donvi_TV' },
                { data: 'loai_donvi', name: 'loai_donvi' },
                { data: 'ngay_TL', name: 'ngay_TL' },
                { data: 'lv_hoat_dong', name: 'lv_hoat_dong' },
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
            url : "{!! route('admin.importdata.thongtincoban.importUnit') !!}",
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
                                    @lang('project/ImportdataExcel/title.madv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.loaidv')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tendvTV')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tendvTA')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tenVTTV')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tenVTTA')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tentd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cqBcq')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ntl')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.soqd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.lvhd')
                                    <span class="icon-oblig">*</span>
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.diachi')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.sdtlh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.sofax')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.email')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.website')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ghichu')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.lhcsgd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tgbdk1')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tgcbk1')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/Standard/title.thaotac')
                                </th>
                            </tr>
                        </thead>
                        <tbody id="idtbody"></tbody>
                `
                $("#idtableip").append(thead);
                data.forEach((item, index) => { 
                    var add = `
                        <tr class="row_number">
                                <td contenteditable class="check-number text-center p-2 row0">${item.stt}</td>
                                <td contenteditable class="check-number text-center p-2 row1">
                                    ${item.madv}
                                </td>
                                <td class="text-center check-select p-2 row2">
                                    <select class="listloaidv border-0 w-100">`;
                    var checkselect = false;
                    for (const [index1, item1] of Object.entries(listloaidv)) {
                        if(index1 != 8){
                            if(item.loaidv == item1){
                                add += `<option selected value="${index1}">${item1}</option>`; 
                                checkselect = true;
                            }else{
                                add += `<option value="${index1}">${item1}</option>`; 
                            }
                        }
                    }    
                    if(checkselect){
                        add += `<option value="8">${listloaidv['8']}</option>`; 
                    }else{
                        add += `<option selected value="8">${listloaidv['8']}</option>`; 
                    }            
                    add += `</select>
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row3">
                                    ${item.tendvTV}
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row4">
                                    ${item.tendvTA}
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row5">
                                    ${item.tenvtTV}
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row6">
                                    ${item.tenvtTA}
                                </td>
                                <td contenteditable class="text-center p-2 row7">
                                    ${item.tenTD}
                                </td>
                                <td contenteditable class="text-center p-2 row8">
                                    ${item.cqbcq}
                                </td>
                                <td contenteditable class="check-empty check-date text-center p-2 row9">
                                    ${item.ntl}
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row10">
                                    ${item.soqd}
                                </td>
                                <td contenteditable class="check-empty text-center p-2 row11">
                                    ${item.lvhd}
                                </td>
                                <td contenteditable class="text-center p-2 row12">
                                    ${item.diachi}
                                </td>
                                <td contenteditable class="check-phone text-center p-2 row13">
                                    ${item.sdtlh}
                                </td>
                                <td contenteditable class="text-center p-2 row14">
                                    ${item.fax}
                                </td>
                                <td contenteditable class="check-email text-center p-2 row15">
                                    ${item.email}
                                </td>
                                <td contenteditable class="check-website text-center p-2 row16">
                                    ${item.website}
                                </td>
                                <td contenteditable class="text-center p-2 row17">
                                    ${item.notes}
                                </td>
                                <td contenteditable class="text-center p-2 row18">
                                    ${item.lhcsgd}
                                </td>
                                <td contenteditable class="check-number text-center p-2 row19">
                                    ${item.tgdtk1}
                                </td>
                                <td contenteditable class="check-number text-center p-2 row20">
                                    ${item.tgcbk1}
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
                <td contenteditable class="check-number text-center p-2 row0"></td>
                <td contenteditable class="check-number text-center p-2 row1"></td>
                <td class="check-select text-center p-2 row2">
                    <select class="listloaidv border-0 w-100">
                        @foreach($loai_dv as $ldv)
                            <option value="{{ $ldv->id }}">{{ $ldv->loai_donvi }}</option>
                        @endforeach
                    </select>
                </td>
                <td contenteditable class="check-empty text-center p-2 row3"></td>
                <td contenteditable class="check-empty text-center p-2 row4"></td>
                <td contenteditable class="check-empty text-center p-2 row5"></td>
                <td contenteditable class="check-empty text-center p-2 row6"></td>
                <td contenteditable class="text-center p-2 row7"></td>
                <td contenteditable class="text-center p-2 row8"></td>
                <td contenteditable class="check-empty check-date text-center p-2 row9"></td>
                <td contenteditable class="check-empty text-center p-2 row10"></td>
                <td contenteditable class="text-center p-2 row11"></td>
                <td contenteditable class="check-phone text-center p-2 row12"></td>
                <td contenteditable class="text-center p-2 row13"></td>
                <td contenteditable class="check-email text-center p-2 row14"></td>
                <td contenteditable class="check-website text-center p-2 row15"></td>
                <td contenteditable class="text-center p-2 row16"></td>
                <td contenteditable class="text-center p-2 row17"></td>
                <td contenteditable class="check-number text-center p-2 row18"></td>
                <td contenteditable class="check-number text-center p-2 row19"></td>
                <td contenteditable class="check-number text-center p-2 row20"></td>
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
                    'stt' :   $(this).find('.row0').text().trim(),
                    'madv' :      $(this).find('.row1').text().trim(),
                    'loaidv' :  $(this).find('.row2').find('select').val(),
                    'tendvTV' :   $(this).find('.row3').text().trim(),
                    'tendvTA' :  $(this).find('.row4').text().trim(),
                    'tenvtTV' :  $(this).find('.row5').text().trim(),
                    'tenvtTA' : $(this).find('.row6').text().trim(),
                    'tenTD' :    $(this).find('.row7').text().trim(),
                    'cqbcq' :   $(this).find('.row8').text().trim(),
                    'ntl': $(this).find('.row9').text().trim(),
                    'soqd' :    $(this).find('.row10').text().trim(),
                    'lvhd' :    $(this).find('.row11').text().trim(),
                    'diachi' :   $(this).find('.row12').text().trim(),
                    'sdtlh' :  $(this).find('.row13').text().trim(),
                    'fax' :   $(this).find('.row14').text().trim(),
                    'email' :    $(this).find('.row15').text().trim(),
                    'website' :    $(this).find('.row16').text().trim(),
                    'notes' :    $(this).find('.row17').text().trim(),
                    'lhcsgd' :  $(this).find('.row18').text().trim(),
                    'tgdtk1' :   $(this).find('.row19').text().trim(),
                    'tgcbk1' : $(this).find('.row20').text().trim(),
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.thongtincoban.importDataUnit') }}";
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
        var route = "{{ route('admin.importdata.thongtincoban.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.thongtincoban.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                //$("#forMaDV").val(data.ma_donvi);
                $('#forMaDV').val(data.ma_donvi);
                $('#forLoaiDv').val(data.loai_dv_id);
                $('#forTenDVTV').val(data.ten_donvi_TV);
                $('#forTenDVTA').val(data.ten_donvi_TA);
                $('#forVTTV').val(data.viet_tat_TV);
                $('#forVTTA').val(data.viet_tat_TA);
                $('#forTenTD').val(data.ten_truoc_day);
                $('#forChuquan').val(data.chu_quan);
                $('#forNtl').val(data.ngay_thanh_lap);
                $('#forsoqd').val(data.soqd);
                $('#forLvhd').val(data.lv_hoat_dong);
                $('#forSdtlh').val(data.phone);
                $('#forFax').val(data.fax);
                $('#forEmail').val(data.email);
                $('#forWebsite').val(data.website);
                $('#forNote').val(data.ghichu);
                $('#forLhcsgd').val(data.loai_hinh);
                $('#forTgbdk1').val(data.tgdtk1);
                $('#forTgcbk1').val(data.tgcbk1);
                $('#forDiachi').val(data.diachi);
                
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
