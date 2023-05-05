@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.bbbc')
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
    @lang('project/ImportdataExcel/title.bbbc')
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
            <a href="{{ route('admin.importdata.baibaobc.exportUnit') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
        </div>
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>
                    @lang('project/ImportdataExcel/title.tbbbc')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.maso')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tapchidang')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.loaitc')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.dmtc')
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
                    @lang('project/ImportdataExcel/title.ttbbbc')
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
                <form action="{{ route('admin.importdata.baibaobc.updateUnit') }}" method="post" id="update-unit">
                    @csrf
                    <input type="hidden" id="id_unit" name="id_unit">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="fortbbbc">
                                    <span>@lang('project/ImportdataExcel/title.tbbbc')</span>
                                </label>
                                <input type="text" class="form-control " id="fortbbbc" placeholder="@lang('project/ImportdataExcel/title.tbbbc')" name="tbbbc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="formaso">
                                    <span>@lang('project/ImportdataExcel/title.maso')</span>
                                </label>
                                <input type="text" class="form-control " id="formaso" placeholder="@lang('project/ImportdataExcel/title.maso')" name="maso">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forlinhvuc">
                                    <span>@lang('project/ImportdataExcel/title.linhvuc')</span>
                                </label>
                                <input type="text" class="form-control " id="forlinhvuc" placeholder="@lang('project/ImportdataExcel/title.linhvuc')" name="linhvuc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortacgia">
                                    <span>@lang('project/ImportdataExcel/title.tacgia')</span>
                                </label>
                                <input type="text" class="form-control " id="fortacgia" placeholder="@lang('project/ImportdataExcel/title.tacgia')" name="tacgia">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordonvipk">
                                    <span>@lang('project/ImportdataExcel/title.donvipk')</span>
                                </label>
                                <input type="text" class="form-control " id="fordonvipk" placeholder="@lang('project/ImportdataExcel/title.donvipk')" name="donvipk">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fortapchidang">
                                    <span>@lang('project/ImportdataExcel/title.tapchidang')</span>
                                </label>
                                <input type="text" class="form-control " id="fortapchidang" placeholder="@lang('project/ImportdataExcel/title.tapchidang')" name="tapchidang">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsoissn">
                                    <span>@lang('project/ImportdataExcel/title.soissn')</span>
                                </label>
                                <input type="text" class="form-control " id="forsoissn" placeholder="@lang('project/ImportdataExcel/title.soissn')" name="soissn">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forsodang">
                                    <span>@lang('project/ImportdataExcel/title.sodang')</span>
                                </label>
                                <input type="text" class="form-control " id="forsodang" placeholder="@lang('project/ImportdataExcel/title.sodang')" name="sodang">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fornamdang">
                                    <span>@lang('project/ImportdataExcel/title.namdang')</span>
                                </label>
                                <input type="text" class="form-control " id="fornamdang" placeholder="@lang('project/ImportdataExcel/title.namdang')" name="namdang">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forloai">
                                    <span>@lang('project/ImportdataExcel/title.loai')</span>
                                </label>
                                <input type="text" class="form-control " id="forloai" placeholder="@lang('project/ImportdataExcel/title.loai')" name="loai">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forloaitc">
                                    <span>@lang('project/ImportdataExcel/title.loaitc')</span>
                                </label>
                                <input type="text" class="form-control " id="forloaitc" placeholder="@lang('project/ImportdataExcel/title.loaitc')" name="loaitc">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fordmtc">
                                    <span>@lang('project/ImportdataExcel/title.dmtc')</span>
                                </label>
                                <select name="dmtc" id="fordmtc" class="form-control">
                                    <option value='1'>@lang('project/ImportdataExcel/title.dmisi')</option>
                                    <option value='2'>@lang('project/ImportdataExcel/title.dmsc')</option>
                                    <option value='3'>@lang('project/ImportdataExcel/title.dmk')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="forurl">
                                    <span>@lang('project/ImportdataExcel/title.url')</span>
                                </label>
                                <input type="text" class="form-control " id="forurl" placeholder="@lang('project/ImportdataExcel/title.url')" name="url">
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
            ajax: "{!! route('admin.importdata.baibaobc.dataUnit') !!}",
            columns: [
                { data: 'tbbbc', name: 'tbbbc' },
                { data: 'maso', name: 'maso' },
                { data: 'tcd', name: 'tcd' },
                { data: 'ltc', name: 'ltc' },
                { data: 'danhmuc', name: 'danhmuc' },
                { data: 'actions', name: 'actions' ,className: 'action'},
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
            url : "{!! route('admin.importdata.baibaobc.importUnit') !!}",
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
                                    @lang('project/ImportdataExcel/title.tbbbc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.maso')                                  
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.linhvuc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tacgia')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.donvipk')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tapchidang')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.soissn')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.sodang')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namdang')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.loai')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.loaitc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.dmtc')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.url')
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
                                    ${item.tbbbc}
                                </td>
                                <td contenteditable class="text-center p-2 row2">
                                    ${item.maso}
                                </td>
                                <td contenteditable class=" text-center p-2 row3">
                                    ${item.linhvuc}
                                </td>
                                <td contenteditable class="text-center p-2 row4">
                                    ${item.tacgia}
                                </td>
                                <td contenteditable class="text-center p-2 row5">
                                    ${item.donvipk}
                                </td>
                                <td contenteditable class="text-center p-2 row6">
                                    ${item.tapchidang}
                                </td>
                                <td contenteditable class="text-center p-2 row7">
                                    ${item.soissn}
                                </td>
                                <td contenteditable class="text-center p-2 row8">
                                    ${item.sodang}
                                </td>
                                <td contenteditable class="text-center p-2 row9">
                                    ${item.namdang}
                                </td>
                                <td contenteditable class="text-center p-2 row10">
                                    ${item.loai}
                                </td>
                                <td contenteditable class="text-center p-2 row11">
                                    ${item.loaitc}
                                </td>
                                <td contenteditable class="text-center p-2 row12">
                                    <select>`
                            if(item.dmtc == "@lang('project/ImportdataExcel/title.dmisi')")
                                add += "<option selected value = '1'>@lang('project/ImportdataExcel/title.dmisi')</option>";
                            else
                                add += "<option value = '1'>@lang('project/ImportdataExcel/title.dmisi')</option>";

                            if(item.dmtc == "@lang('project/ImportdataExcel/title.dmsc')")
                                add += "<option selected value = '2'>@lang('project/ImportdataExcel/title.dmsc')</option>";
                            else
                                add += "<option value = '2'>@lang('project/ImportdataExcel/title.dmsc')</option>";

                            if(item.dmtc == "@lang('project/ImportdataExcel/title.dmk')")
                                add += "<option selected value = '3'>@lang('project/ImportdataExcel/title.dmk')</option>";
                            else
                                add += "<option value = '3'>@lang('project/ImportdataExcel/title.dmk')</option>";

                            add += `</select>
                                </td>
                                <td contenteditable class="text-center p-2 row13">
                                    ${item.url}
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
                <td contenteditable class="text-center p-2 row12">
                    <select>
                        <option value='1'>@lang('project/ImportdataExcel/title.dmisi')</option>
                        <option value='2'>@lang('project/ImportdataExcel/title.dmsc')</option>
                        <option value='3'>@lang('project/ImportdataExcel/title.dmk')</option>
                    </select>
                </td>
                <td contenteditable class="text-center p-2 row13"></td>
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
                    'tbbbc' :   $(this).find('.row1').text().trim(),
                    'maso' :  $(this).find('.row2').text().trim(),
                    'linhvuc' :   $(this).find('.row3').text().trim(),
                    'tacgia' :  $(this).find('.row4').text().trim(),
                    'donvipk' :  $(this).find('.row5').text().trim(),
                    'tapchidang' :  $(this).find('.row6').text().trim(),
                    'soissn' : $(this).find('.row7').text().trim(),
                    'sodang' : $(this).find('.row8').text().trim(),
                    'namdang' : $(this).find('.row9').text().trim(),
                    'loai' : $(this).find('.row10').text().trim(),
                    'loaitc' : $(this).find('.row11').text().trim(),
                    'dmtc' :   $(this).find('.row12').find('select').val(),
                    'url' :   $(this).find('.row13').text().trim(),
                    
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.baibaobc.importDataUnit') }}";
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
        var route = "{{ route('admin.importdata.baibaobc.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


    $('#modalUpdate').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        $("#id_unit").val(id);
        let loadData = "{{ route('admin.importdata.baibaobc.dataUnit') }}" + "?id=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $('#fortbbbc').val(data.tbbbc);
                $('#formaso').val(data.maso);
                $('#forlinhvuc').val(data.linhvuc);
                $('#fortacgia').val(data.tacgia);
                $('#fordonvipk').val(data.donvi);
                $('#fortapchidang').val(data.tcd);
                $('#forsoissn').val(data.so_issn_isbn);
                $('#forsodang').val(data.sodang);
                $('#fornamdang').val(data.namdang);
                $('#forloai').val(data.loai);
                $('#forloaitc').val(data.ltc);
                $('#fordmtc').val(data.dmtc);
                $('#forurl').val(data.url);
            })
    })

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
