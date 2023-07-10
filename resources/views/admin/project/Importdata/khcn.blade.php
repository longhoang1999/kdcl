@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.khcn')
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
    @lang('project/ImportdataExcel/title.khcn')
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
            <a href="{{ route('admin.importdata.khcn.exportUnit') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="export_import_khcn" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
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
                    @lang('project/ImportdataExcel/title.maso')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tdtda')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.loai')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.ketqua')
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
                    @lang('project/ImportdataExcel/title.ttkhcn')
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
                <form action="{{ route('admin.importdata.khcn.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="fortdtda">
                                    <span>@lang('project/ImportdataExcel/title.tdtda')</span>
                                </label>
                                <input type="text" class="form-control " id="fortdtda" placeholder="@lang('project/ImportdataExcel/title.tdtda')" name="tdtda">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="formaso">
                                    <span>@lang('project/ImportdataExcel/title.maso')</span>
                                </label>
                                <input type="text" class="form-control " id="formaso" placeholder="@lang('project/ImportdataExcel/title.maso')" name="maso">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forloai">
                                    <span>@lang('project/ImportdataExcel/title.loai')</span>
                                </label>
                                <input type="text" class="form-control " id="forloai" placeholder="@lang('project/ImportdataExcel/title.loai')" name="loai">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forloai">
                                    <span>@lang('project/ImportdataExcel/title.capdetai')</span>
                                </label>
                                <input type="text" class="form-control " id="forcapdetai" placeholder="@lang('project/ImportdataExcel/title.capdetai')" name="capdetai">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamdk">
                                    <span>@lang('project/ImportdataExcel/title.namdk')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamdk" placeholder="@lang('project/ImportdataExcel/title.namdk')" name="namdk">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamnghiemt">
                                    <span>@lang('project/ImportdataExcel/title.namnghiemt')</span>
                                </label>
                                <input type="number" class="form-control " id="fornamnghiemt" placeholder="@lang('project/ImportdataExcel/title.namnghiemt')" name="namnghiemt">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forlinhvuc">
                                    <span>@lang('project/ImportdataExcel/title.linhvuc')</span>
                                </label>
                                <input type="text" class="form-control " id="forlinhvuc" placeholder="@lang('project/ImportdataExcel/title.linhvuc')" name="linhvuc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornganhclq">
                                    <span>@lang('project/ImportdataExcel/title.nganhclq')</span>
                                </label>
                                <input type="text" class="form-control " id="fornganhclq" placeholder="@lang('project/ImportdataExcel/title.nganhclq')" name="nganhclq">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordvctri">
                                    <span>@lang('project/ImportdataExcel/title.dvctri')</span>
                                </label>
                                <input type="text" class="form-control " id="fordvctri" placeholder="@lang('project/ImportdataExcel/title.dvctri')" name="dvctri">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forcndtai">
                                    <span>@lang('project/ImportdataExcel/title.cndtai')</span>
                                </label>
                                <input type="text" class="form-control " id="forcndtai" placeholder="@lang('project/ImportdataExcel/title.cndtai')" name="cndtai">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortvtgdt">
                                    <span>@lang('project/ImportdataExcel/title.tvtgdt')</span>
                                </label>
                                <input type="text" class="form-control " id="fortvtgdt" placeholder="@lang('project/ImportdataExcel/title.tvtgdt')" name="tvtgdt">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornhd">
                                    <span>@lang('project/ImportdataExcel/title.nhd')</span>
                                </label>
                                <input type="text" class="form-control " id="fornhd" placeholder="@lang('project/ImportdataExcel/title.nhd')" name="nhd">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordvcnph">
                                    <span>@lang('project/ImportdataExcel/title.dvcnph')</span>
                                </label>
                                <input type="text" class="form-control " id="fordvcnph" placeholder="@lang('project/ImportdataExcel/title.dvcnph')" name="dvcnph">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forkinhphi">
                                    <span>@lang('project/ImportdataExcel/title.kinhphi')</span>
                                </label>
                                <select name="kinhphi" id="forkinhphi" class="form-control">
                                    <option value = '1'>@lang('project/ImportdataExcel/title.tuco')</option>
                                    <option value = '2'>@lang('project/ImportdataExcel/title.ngansach')</option>
                                    <option value = '3'>@lang('project/ImportdataExcel/title.taitro')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forketqua">
                                    <span>@lang('project/ImportdataExcel/title.ketqua')</span>
                                </label>
                                <input type="text" class="form-control " id="forketqua" placeholder="@lang('project/ImportdataExcel/title.ketqua')" name="ketqua">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortrangthai">
                                    <span>@lang('project/ImportdataExcel/title.trangthai')</span>
                                </label>
                                <input type="text" class="form-control " id="fortrangthai" placeholder="@lang('project/ImportdataExcel/title.trangthai')" name="trangthai">
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
            ajax: "{!! route('admin.importdata.khcn.dataUnit') !!}",
            columns: [
                { data: 'stt', name: 'stt' ,className: 'stt'},
                { data: 'maso', name: 'maso' },
                { data: 'tendetai', name: 'tendetai' },
                { data: 'loai', name: 'loai' },
                { data: 'ketqua', name: 'ketqua' },
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
            url : "{!! route('admin.importdata.khcn.importUnit') !!}",
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
                                    @lang('project/ImportdataExcel/title.tdtda')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.maso')                                  
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.loai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.capdetai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namdk')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namnghiemt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.linhvuc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nganhclq')
                                    
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dvctri')
                                    
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cndtai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tvtgdt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.nhd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dvcnph')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.kinhphi')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.ketqua')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.trangthai')
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
                                    ${item.tdtda}
                                </td>
                                <td contenteditable class="text-center p-2 row2">
                                    ${item.maso}
                                </td>
                                <td contenteditable class="text-center p-2 row3">
                                    ${item.loai}
                                </td>
                                <td contenteditable class="text-center p-2 row4">
                                    ${item.capdetai}
                                </td>
                                <td contenteditable class="text-center p-2 row5">
                                    ${item.namdk}
                                </td>
                                <td contenteditable class="text-center p-2 row6">
                                    ${item.namnghiemt}
                                </td>
                                <td contenteditable class="text-center p-2 row7">
                                    ${item.linhvuc}
                                </td>
                                <td contenteditable class="text-center p-2 row8">
                                    ${item.nganhclq}
                                </td>
                                <td contenteditable class="text-center p-2 row9">
                                    ${item.dvctri}
                                </td>
                                <td contenteditable class="text-center p-2 row10">
                                    ${item.cndtai}
                                </td>
                                <td contenteditable class="text-center p-2 row11">
                                    ${item.tvtgdt}
                                </td>
                                <td contenteditable class="text-center p-2 row12">
                                    ${item.nhd}
                                </td>
                                <td contenteditable class="text-center p-2 row13">
                                    ${item.dvcnph}
                                </td>
                                <td contenteditable class="text-center p-2 row14">
                                    <select >`
                            if(item.kinhphi == "@lang('project/ImportdataExcel/title.tudo')")
                                add += "<option selected value = '1'>@lang('project/ImportdataExcel/title.tuco')</option>"
                            else
                                add += "<option value = '1'>@lang('project/ImportdataExcel/title.tuco')</option> "  
                            
                            if(item.kinhphi == "@lang('project/ImportdataExcel/title.ngansach')")
                                add += "<option selected value = '2'>@lang('project/ImportdataExcel/title.ngansach')</option>"
                            else
                                add += "<option value = '2'>@lang('project/ImportdataExcel/title.ngansach')</option>"

                            if(item.kinhphi == "@lang('project/ImportdataExcel/title.taitro')")
                                add += "<option selected value = '3'>@lang('project/ImportdataExcel/title.taitro')</option>"
                            else
                                add += "<option value = '3'>@lang('project/ImportdataExcel/title.taitro')</option>"
                                        
                            add += `</select>
                                </td>
                                <td contenteditable class="text-center p-2 row15">
                                    ${item.ketqua}
                                </td>
                                <td contenteditable class="text-center p-2 row16">
                                    ${item.trangthai}
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
                <td contenteditable class="text-center p-2 row14">
                    <select>
                        <option value = '1'>@lang('project/ImportdataExcel/title.tuco')</option>
                        <option value = '2'>@lang('project/ImportdataExcel/title.ngansach')</option>
                        <option value = '3'>@lang('project/ImportdataExcel/title.taitro')</option>
                    </select>
                </td>
                <td contenteditable class="text-center p-2 row15"></td>
                <td contenteditable class="text-center p-2 row16"></td>
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
                    'tdtda' :      $(this).find('.row1').text().trim(),
                    'maso' :  $(this).find('.row2').text().trim(),
                    'loai' :   $(this).find('.row3').text().trim(),
                    'capdetai' :  $(this).find('.row4').text().trim(),
                    'namdk' :  $(this).find('.row5').text().trim(),
                    'namnghiemt' : $(this).find('.row6').text().trim(),
                    'linhvuc' :    $(this).find('.row7').text().trim(),
                    'nganhclq' :   $(this).find('.row8').text().trim(),
                    'dvctri': $(this).find('.row9').text().trim(),
                    'cndtai' :    $(this).find('.row10').text().trim(),
                    'tvtgdt' :   $(this).find('.row11').text().trim(),
                    'nhd' :   $(this).find('.row12').text().trim(),
                    'dvcnph' :  $(this).find('.row13').text().trim(),
                    'kinhphi' :   $(this).find('.row14').find('select').val(),
                    'ketqua' :   $(this).find('.row15').text().trim(),
                    'trangthai' :   $(this).find('.row16').text().trim(),
                    
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.khcn.importDataUnit') }}";
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
        var route = "{{ route('admin.importdata.khcn.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.khcn.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $('#fortdtda').val(data.tendetai);
                $('#formaso').val(data.maso);
                $('#forloai').val(data.loai);
                $('#forcapdetai').val(data.capdetai);
                $('#fornamdk').val(data.namdk);
                $('#fornamnghiemt').val(data.namnt);
                $('#forlinhvuc').val(data.linhvuc);
                $('#fornganhclq').val(data.nganhlq);
                $('#fordvctri').val(data.dvct);
                $('#forcndtai').val(data.cndt);
                $('#fortvtgdt').val(data.thanhvien);
                $('#fornhd').val(data.nguoihd);
                $('#fordvcnph').val(data.dvcnph);
                $('#forkinhphi').val(data.kinhphi);
                $('#forketqua').val(data.ketqua);
                $('#fortrangthai').val(data.trangthai);
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
