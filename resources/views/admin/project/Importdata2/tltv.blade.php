@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.tltv')
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
    @lang('project/ImportdataExcel/title.tltv')
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
            <a href="{{ route('admin.importdata.tltv.exportTltv') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_tailieu_thuvien" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
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
                    @lang('project/ImportdataExcel/title.mhp')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tenhp')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.ychp')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.sachin1')
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
                    @lang('project/ImportdataExcel/title.tltv')
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
                    @lang('project/ImportdataExcel/title.cntltv')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.importdata.tltv.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="formhp">
                                    <span>@lang('project/ImportdataExcel/title.mhp')</span>
                                </label>
                                <input type="number" class="form-control " id="formhp" placeholder="@lang('project/ImportdataExcel/title.mhp')" name="mhp">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortenhp">
                                    <span>@lang('project/ImportdataExcel/title.tenhp')</span>
                                </label>
                                <input type="text" class="form-control " id="fortenhp" placeholder="@lang('project/ImportdataExcel/title.tenhp')" name="tenhp">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkhoinganh">
                                    <span>@lang('project/ImportdataExcel/title.khoinganh')</span>
                                </label>
                                <input type="text" class="form-control " id="forkhoinganh" placeholder="@lang('project/ImportdataExcel/title.khoinganh')" name="khoinganh">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forychp">
                                    <span>@lang('project/ImportdataExcel/title.ychp2')</span>
                                </label>
                                <input type="number" class="form-control " id="forychp" placeholder="@lang('project/ImportdataExcel/title.ychp')" name="ychp">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachin2">
                                    <span>@lang('project/ImportdataExcel/title.sachin2')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachin2" placeholder="@lang('project/ImportdataExcel/title.sachin2')" name="sachin2">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachdt2">
                                    <span>@lang('project/ImportdataExcel/title.sachdt2')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachdt2" placeholder="@lang('project/ImportdataExcel/title.sachdt2')" name="sachdt2">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forychp3">
                                    <span>@lang('project/ImportdataExcel/title.ychp3')</span>
                                </label>
                                <input type="number" class="form-control " id="forychp3" placeholder="@lang('project/ImportdataExcel/title.ychp3')" name="ychp3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachin3">
                                    <span>@lang('project/ImportdataExcel/title.sachin3')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachin3" placeholder="@lang('project/ImportdataExcel/title.sachin3')" name="sachin3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachdt3">
                                    <span>@lang('project/ImportdataExcel/title.sachdt3')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachdt3" placeholder="@lang('project/ImportdataExcel/title.sachdt3')" name="sachdt3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortrennn">
                                    <span>@lang('project/ImportdataExcel/title.trennn2')</span>
                                </label>
                                <input type="number" class="form-control " id="fortrennn" placeholder="@lang('project/ImportdataExcel/title.trennn')" name="trennn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortnndn">
                                    <span>@lang('project/ImportdataExcel/title.tnndn2')</span>
                                </label>
                                <input type="number" class="form-control " id="fortnndn" placeholder="@lang('project/ImportdataExcel/title.tnndn')" name="tnndn">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="forychp1">
                                    <span>@lang('project/ImportdataExcel/title.ychp6')</span>
                                </label>
                                <input type="number" class="form-control " id="forychp1" placeholder="@lang('project/ImportdataExcel/title.ychp6')" name="ychp1">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachin6">
                                    <span>@lang('project/ImportdataExcel/title.sachin6')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachin6" placeholder="@lang('project/ImportdataExcel/title.sachin6')" name="sachin6">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachdt6">
                                    <span>@lang('project/ImportdataExcel/title.sachdt6')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachdt6" placeholder="@lang('project/ImportdataExcel/title.sachdt6')" name="sachdt6">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forychp7">
                                    <span>@lang('project/ImportdataExcel/title.ychp7')</span>
                                </label>
                                <input type="number" class="form-control " id="forychp7" placeholder="@lang('project/ImportdataExcel/title.ychp7')" name="ychp7">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachin7">
                                    <span>@lang('project/ImportdataExcel/title.sachin7')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachin7" placeholder="@lang('project/ImportdataExcel/title.sachin7')" name="sachin7">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsachdt7">
                                    <span>@lang('project/ImportdataExcel/title.sachdt7')</span>
                                </label>
                                <input type="number" class="form-control " id="forsachdt7" placeholder="@lang('project/ImportdataExcel/title.sachdt7')" name="sachdt7">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forsldtcbi1">
                                    <span>@lang('project/ImportdataExcel/title.sldtcbi1')</span>
                                </label>
                                <input type="number" class="form-control " id="forsldtcbi1" placeholder="@lang('project/ImportdataExcel/title.sldtcbi1')" name="sldtcbi1">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="forsldtcdt1">
                                    <span>@lang('project/ImportdataExcel/title.sldtcdt1')</span>
                                </label>
                                <input type="number" class="form-control " id="forsldtcdt1" placeholder="@lang('project/ImportdataExcel/title.sldtcdt1')" name="sldtcdt1">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortrennn1">
                                    <span>@lang('project/ImportdataExcel/title.trennn3')</span>
                                </label>
                                <input type="number" class="form-control " id="fortrennn1" placeholder="@lang('project/ImportdataExcel/title.trennn1')" name="trennn1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fortnndn1">
                                    <span>@lang('project/ImportdataExcel/title.tnndn3')</span>
                                </label>
                                <input type="number" class="form-control " id="fortnndn1" placeholder="@lang('project/ImportdataExcel/title.tnndn1')" name="tnndn1">
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
            ajax: "{!! route('admin.importdata.tltv.dataUnit') !!}",
            columns: [
                { data: 'stt', name: 'stt' ,className: 'stt'},
                { data: 'ma_hoc_phan', name: 'ma_hoc_phan' },
                { data: 'ten_hoc_phan', name: 'ten_hoc_phan' },
                { data: 'syctdc_sck', name: 'syctdc_sck' },
                { data: 'sach_in_sck', name: 'sach_in_sck' },
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
            url : "{!! route('admin.importdata.tltv.importUnit') !!}",
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
                                <th class="row_width p-2" rowspan="4">
                                    @lang('project/ImportdataExcel/title.stt')
                                </th>
                                <th class="row_width p-2" rowspan="4">
                                    @lang('project/ImportdataExcel/title.mhp')
                                </th>
                                <th class="row_width p-2" rowspan="4">
                                    @lang('project/ImportdataExcel/title.tenhp')                                  
                                </th>
                                <th class="row_width p-2" rowspan="4">
                                    @lang('project/ImportdataExcel/title.khoinganh')                                  
                                </th>
                                <th class="row_width p-2" colspan="6">
                                    @lang('project/ImportdataExcel/title.gtc')                                  
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.namxb')                                  
                                </th>
                                <th class="row_width p-2" colspan="8">
                                    @lang('project/ImportdataExcel/title.tltk')                                  
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.namxb')                                  
                                </th>
                                <th class="row_width p-2" rowspan="4">
                                    @lang('project/ImportdataExcel/title.thaotac')
                                </th>
                            </tr>
                            <tr class="border ">
                                <th class="row_width p-2" colspan="3">
                                    @lang('project/ImportdataExcel/title.sck')
                                </th>
                                <th class="row_width p-2" colspan="3">
                                    @lang('project/ImportdataExcel/title.sgt')
                                </th>
                                <th class="row_width p-2" rowspan="3">
                                    @lang('project/ImportdataExcel/title.trennn')
                                </th>
                                <th class="row_width p-2" rowspan="3">
                                    @lang('project/ImportdataExcel/title.tnndn')
                                </th>
                                <th class="row_width p-2" colspan="3">
                                    @lang('project/ImportdataExcel/title.stk')
                                </th>
                                <th class="row_width p-2" colspan="3">
                                    @lang('project/ImportdataExcel/title.shd')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.tcdtxb')
                                </th>
                                <th class="row_width p-2" rowspan="3">
                                    @lang('project/ImportdataExcel/title.trennn1')
                                </th>
                                <th class="row_width p-2" rowspan="3">
                                    @lang('project/ImportdataExcel/title.tnndn1')
                                </th>
                            </tr>
                            <tr class="border ">
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.ychp')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.sctt')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.ychp1')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.sctt1')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.ychp4')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.sctt4')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.ychp5')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.sctt5')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.sctt6')
                                </th>
                            </tr>
                            <tr class="border ">
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sachin')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sachdt')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sachin1')
                                </th>
                                <th class="row_width p-2" ">
                                    @lang('project/ImportdataExcel/title.sachdt1')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sachin4')
                                </th>
                                <th class="row_width p-2" ">
                                    @lang('project/ImportdataExcel/title.sachdt4')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sachin5')
                                </th>
                                <th class="row_width p-2" ">
                                    @lang('project/ImportdataExcel/title.sachdt5')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sldtcbi')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sldtcdt')
                                </th>
                            </tr>
                        </thead>
                        <tbody id="idtbody"></tbody>
                `
                $("#idtableip").append(thead);
                data.forEach((item, index) => { 
                    var add = `
                        <tr class="row_number">
                            <td contenteditable class="text-center p-2 row0" >${item.stt}</td>
                            <td contenteditable class="text-center p-2 row1" >
                                ${item.mhp}
                            </td>
                            <td contenteditable class="text-center p-2 row2" > 
                                ${item.tenhp}
                            </td>
                            <td contenteditable class="text-center p-2 row3" >
                                ${item.khoinganh}
                            </td>
                            <td contenteditable class="text-center p-2 row4" >
                                ${item.ychp}
                            </td>
                            <td contenteditable class="text-center p-2 row5" >
                                ${item.sachin}
                            </td>
                            <td contenteditable class="text-center p-2 row6" >
                                ${item.sachdt}
                            </td>
                            <td contenteditable class="text-center p-2 row7" >
                                ${item.ychp1}
                            </td>
                            <td contenteditable class="text-center p-2 row8" >
                                ${item.sachin1}
                            </td>
                            <td contenteditable class="text-center p-2 row9" >
                                ${item.sachdt1}
                            </td>
                            <td contenteditable class="text-center p-2 row10" >
                                ${item.trennn}
                            </td>
                            <td contenteditable class="text-center p-2 row11" >
                                ${item.tnndn}
                            </td>
                            <td contenteditable class="text-center p-2 row12" >
                                ${item.ychp4}
                            </td>
                            <td contenteditable class="text-center p-2 row13" >
                                ${item.sachin4}
                            </td>
                            <td contenteditable class="text-center p-2 row14" >
                                ${item.sachdt4}
                            </td>
                            <td contenteditable class="text-center p-2 row15" >
                                ${item.ychp5}
                            </td>
                            <td contenteditable class="text-center p-2 row16" >
                                ${item.sachin5}
                            </td>
                            <td contenteditable class="text-center p-2 row17" >
                                ${item.sachdt5}
                            </td>
                            <td contenteditable class="text-center p-2 row18" >
                                ${item.sldtcbi}
                            </td>
                            <td contenteditable class="text-center p-2 row19" >
                                ${item.sldtcdt}
                            </td>
                            <td contenteditable class="text-center p-2 row20" >
                                ${item.trennn1}
                            </td>
                            <td contenteditable class="text-center p-2 row21" >
                                ${item.tnndn1}
                            </td>
                            <td contenteditable class="text-center p-2 trash-btn" >
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
                <td contenteditable class="text-center p-2 row0" ></td>
                <td contenteditable class="text-center p-2 row1" ></td>
                <td contenteditable class="text-center p-2 row2" ></td>
                <td contenteditable class="text-center p-2 row3" ></td>
                <td contenteditable class="text-center p-2 row4" ></td>
                <td contenteditable class="text-center p-2 row5" ></td>
                <td contenteditable class="text-center p-2 row6" ></td>
                <td contenteditable class="text-center p-2 row7" ></td>
                <td contenteditable class="text-center p-2 row8" ></td>
                <td contenteditable class="text-center p-2 row9" ></td>
                <td contenteditable class="text-center p-2 row10" ></td>
                <td contenteditable class="text-center p-2 row11" ></td>
                <td contenteditable class="text-center p-2 row12" ></td>
                <td contenteditable class="text-center p-2 row13" ></td>
                <td contenteditable class="text-center p-2 row14" ></td>
                <td contenteditable class="text-center p-2 row15" ></td>
                <td contenteditable class="text-center p-2 row16" ></td>
                <td contenteditable class="text-center p-2 row17" ></td>
                <td contenteditable class="text-center p-2 row18" ></td>
                <td contenteditable class="text-center p-2 row19" ></td>
                <td contenteditable class="text-center p-2 row20" ></td>
                <td contenteditable class="text-center p-2 row21" ></td>
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
                    'mhp' :   $(this).find('.row1').text().trim(),
                    'tenhp' :  $(this).find('.row2').text().trim(),
                    'khoinganh' :  $(this).find('.row3').text().trim(),
                    'ychp' :  $(this).find('.row4').text().trim(),
                    'sachin' : $(this).find('.row5').text().trim(),
                    'sachdt' : $(this).find('.row6').text().trim(),
                    'ychp1' : $(this).find('.row7').text().trim(),
                    'sachin1' :  $(this).find('.row8').text().trim(),
                    'sachdt1' : $(this).find('.row9').text().trim(),
                    'trennn' : $(this).find('.row10').text().trim(),
                    'tnndn' : $(this).find('.row11').text().trim(),
                    'ychp4' : $(this).find('.row12').text().trim(),
                    'sachin4' : $(this).find('.row13').text().trim(),
                    'sachdt4' : $(this).find('.row14').text().trim(),
                    'ychp5' : $(this).find('.row15').text().trim(),
                    'sachin5' : $(this).find('.row16').text().trim(),
                    'sachdt5' : $(this).find('.row17').text().trim(),
                    'sldtcbi' : $(this).find('.row18').text().trim(),
                    'sldtcdt' : $(this).find('.row19').text().trim(),
                    'trennn1' : $(this).find('.row20').text().trim(),
                    'tnndn1' : $(this).find('.row21').text().trim(),

                    
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.tltv.importDataUnit') }}";
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
                        $("#modal_unit .modal-header button").click();
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
        var route = "{{ route('admin.importdata.tltv.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.tltv.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $("#formhp").val(data.ma_hoc_phan);
                $("#fortenhp").val(data.ten_hoc_phan);
                $("#forkhoinganh").val(data.khoi_nganh);
                $("#forychp").val(data.syctdc_sck);
                $("#forsachin2").val(data.sach_in_sck);
                $("#forsachdt2").val(data.sach_dt_sck);
                $("#forychp3").val(data.syctdc_sgt);
                $("#forsachin3").val(data.sach_in_sgt);
                $("#forsachdt3").val(data.sach_dt_sgt);
                $("#fortrennn").val(data.ttnn);
                $("#fortnndn").val(data.tnndn);
                $("#forychp1").val(data.syctdchp_stk);
                $("#forsachin6").val(data.sach_in_stk);
                $("#forsachdt6").val(data.sach_dt_stk);
                $("#forychp7").val(data.syctdc_shd);
                $("#forsachin7").val(data.sach_in_shd);
                $("#forsachdt7").val(data.sach_dt_shd);
                $("#forsldtcbi1").val(data.sldtcbi);
                $("#forsldtcdt1").val(data.sldtcdt);
                $("#fortrennn1").val(data.ttnn_tltk);
                $("#fortnndn1").val(data.tnndn_tltk);
                
               
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
