@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.tkpttb')
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
    @lang('project/ImportdataExcel/title.tkpttb')
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
            <a href="{{ route('admin.importdata.tkpttb.exportTkpttb') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_tk_phong_tb" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
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
                    @lang('project/ImportdataExcel/title.tplgd')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.soluong')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.dientichxd')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.doituong')
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
                    @lang('project/ImportdataExcel/title.tkpttb')
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
                    @lang('project/ImportdataExcel/title.cntkpttb')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.importdata.tkpttb.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="fortplgd">
                                    <span>@lang('project/ImportdataExcel/title.tplgd')</span>
                                </label>
                                <input type="text" class="form-control " id="fortplgd" placeholder="@lang('project/ImportdataExcel/title.tplgd')" name="tplgd">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsoluong">
                                    <span>@lang('project/ImportdataExcel/title.soluong')</span>
                                </label>
                                <input type="number" class="form-control " id="forsoluong" placeholder="@lang('project/ImportdataExcel/title.soluong')" name="soluong ">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordientichxd">
                                    <span>@lang('project/ImportdataExcel/title.dientichxd')</span>
                                </label>
                                <input type="number" class="form-control " id="fordientichxd" placeholder="@lang('project/ImportdataExcel/title.dientichxd')" name="dientichxd">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordoituong">
                                    <span>@lang('project/ImportdataExcel/title.doituong')</span>
                                </label>
                                <input type="text" class="form-control " id="fordoituong" placeholder="@lang('project/ImportdataExcel/title.doituong')" name="doituong">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordanhmuc">
                                    <span>@lang('project/ImportdataExcel/title.danhmuc')</span>
                                </label>
                                <input type="text" class="form-control " id="fordanhmuc" placeholder="@lang('project/ImportdataExcel/title.danhmuc')" name="danhmuc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsohuu">
                                    <span>@lang('project/ImportdataExcel/title.sohuu')</span>
                                </label>
                                <input type="text" class="form-control " id="forsohuu" placeholder="@lang('project/ImportdataExcel/title.sohuu')" name="sohuu">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forlienket">
                                    <span>@lang('project/ImportdataExcel/title.lienket')</span>
                                </label>
                                <input type="text" class="form-control " id="forlienket" placeholder="@lang('project/ImportdataExcel/title.lienket')" name="lienket">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forthue">
                                    <span>@lang('project/ImportdataExcel/title.thue')</span>
                                </label>
                                <input type="text" class="form-control " id="forthue" placeholder="@lang('project/ImportdataExcel/title.thue')" name="thue">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsophong">
                                    <span>@lang('project/ImportdataExcel/title.sophong3')</span>
                                </label>
                                <input type="text" class="form-control " id="forsophong" placeholder="@lang('project/ImportdataExcel/title.sophong')" name="sophong">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordientich">
                                    <span>@lang('project/ImportdataExcel/title.dientich3')</span>
                                </label>
                                <input type="text" class="form-control " id="fordientich" placeholder="@lang('project/ImportdataExcel/title.dientich')" name="dientich">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsophong1">
                                    <span>@lang('project/ImportdataExcel/title.sophong4')</span>
                                </label>
                                <input type="text" class="form-control " id="forsophong1" placeholder="@lang('project/ImportdataExcel/title.sophong1')" name="sophong1">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordientich1">
                                    <span>@lang('project/ImportdataExcel/title.dientich4')</span>
                                </label>
                                <input type="text" class="form-control " id="fordientich1" placeholder="@lang('project/ImportdataExcel/title.dientich1')" name="dientich1">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsophong2">
                                    <span>@lang('project/ImportdataExcel/title.sophong5')</span>
                                </label>
                                <input type="text" class="form-control " id="forsophong2" placeholder="@lang('project/ImportdataExcel/title.sophong2')" name="sophong2">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordientich2">
                                    <span>@lang('project/ImportdataExcel/title.dientich5')</span>
                                </label>
                                <input type="text" class="form-control " id="fordientich2" placeholder="@lang('project/ImportdataExcel/title.dientich2')" name="dientich2">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forloaiphong">
                                    <span>@lang('project/ImportdataExcel/title.loaiphong')</span>
                                </label>
                                <input type="text" class="form-control " id="forloaiphong" placeholder="@lang('project/ImportdataExcel/title.loaiphong')" name="loaiphong ">
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
            ajax: "{!! route('admin.importdata.tkpttb.dataUnit') !!}",
            columns: [
                { data: 'stt', name: 'stt' ,className: 'stt'},
                { data: 'tp_gd_lap', name: 'tp_gd_lap' },
                { data: 'so_luong', name: 'so_luong' },
                { data: 'dien_tich_xay', name: 'dien_tich_xay' },
                { data: 'doi_tuong_sd', name: 'doi_tuong_sd' },
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
            url : "{!! route('admin.importdata.tkpttb.importUnit') !!}",
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
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.stt')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.tplgd')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.soluong')                                  
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.dientichxd')                                  
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.doituong')                                  
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.danhmuc')                                  
                                </th>
                                <th class="row_width p-2" colspan="3">
                                    @lang('project/ImportdataExcel/title.hinhthuc')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.phongkc')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.phongbkc')
                                </th>
                                <th class="row_width p-2" colspan="2">
                                    @lang('project/ImportdataExcel/title.phongtam')
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.loaiphong')                                  
                                </th>
                                <th class="row_width p-2" rowspan="2">
                                    @lang('project/ImportdataExcel/title.thaotac')
                                </th>
                            </tr>
                            <tr class="border ">
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sohuu')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.lienket')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.thue')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sophong')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.dientich')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sophong1')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.dientich1')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.sophong2')
                                </th>
                                <th class="row_width p-2" >
                                    @lang('project/ImportdataExcel/title.dientich2')
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
                                ${item.tplgd}
                            </td>
                            <td contenteditable class="text-center p-2 row2" > 
                                ${item.soluong}
                            </td>
                            <td contenteditable class="text-center p-2 row3" >
                                ${item.dientichxd}
                            </td>
                            <td contenteditable class="text-center p-2 row4" >
                                ${item.doituong}
                            </td>
                            <td contenteditable class="text-center p-2 row5" >
                                ${item.danhmuc}
                            </td>
                            <td contenteditable class="text-center p-2 row6" >
                                ${item.sohuu}
                            </td>
                            <td contenteditable class="text-center p-2 row7" >
                                ${item.lienket}
                            </td>
                            <td contenteditable class="text-center p-2 row8" >
                                ${item.thue}
                            </td>
                            <td contenteditable class="text-center p-2 row9" >
                                ${item.sophong}
                            </td>
                            <td contenteditable class="text-center p-2 row10" >
                                ${item.dientich}
                            </td>
                            <td contenteditable class="text-center p-2 row11" >
                                ${item.sophong1}
                            </td>
                            <td contenteditable class="text-center p-2 row12" >
                                ${item.dientich1}
                            </td>
                            <td contenteditable class="text-center p-2 row13" >
                                ${item.sophong2}
                            </td>
                            <td contenteditable class="text-center p-2 row14" >
                                ${item.dientich2}
                            </td>
                            <td contenteditable class="text-center p-2 row15" >
                                ${item.loaiphong}
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
                <td contenteditable class="text-center p-2 trash-btn" >
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
                    'tplgd' :   $(this).find('.row1').text().trim(),
                    'soluong' :  $(this).find('.row2').text().trim(),
                    'dientichxd' : $(this).find('.row3').text().trim(),
                    'doituong' : $(this).find('.row4').text().trim(),
                    'danhmuc' :  $(this).find('.row5').text().trim(),
                    'sohuu' :  $(this).find('.row6').text().trim(),
                    'lienket' : $(this).find('.row7').text().trim(),
                    'thue' : $(this).find('.row8').text().trim(),
                    'sophong' : $(this).find('.row9').text().trim(),
                    'dientich' : $(this).find('.row10').text().trim(),
                    'sophong1' : $(this).find('.row11').text().trim(),
                    'dientich1' : $(this).find('.row12').text().trim(),
                    'sophong2' : $(this).find('.row13').text().trim(),
                    'dientich2' : $(this).find('.row14').text().trim(),
                    'loaiphong' : $(this).find('.row15').text().trim(),
                    
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.tkpttb.importDataUnit') }}";
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
        var route = "{{ route('admin.importdata.tkpttb.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.tkpttb.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $("#fortplgd").val(data.tp_gd_lap);
                $("#forsoluong").val(data.so_luong);
                $("#fordientichxd").val(data.dien_tich_xay);
                $("#fordoituong").val(data.doi_tuong_sd);
                $("#fordanhmuc").val(data.trang_thiet_bi);
                $("#forsohuu").val(data.so_huu);
                $("#forlienket").val(data.lien_ket);
                $("#forthue").val(data.thue);
                $("#forsophong").val(data.so_phong_PKC);
                $("#fordientich").val(data.dien_tich_PKC);
                $("#forsophong1").val(data.so_phong_PBKC);
                $("#fordientich1").val(data.dien_tich_PBKC);
                $("#forsophong2").val(data.so_phong_PT);
                $("#fordientich2").val(data.dien_tich_PT);
                $("#forloaiphong").val(data.loai_phong);
                
                
               
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
