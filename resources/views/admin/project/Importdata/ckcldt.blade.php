@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.cknckh')
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
    .row_add{
        width: 8% !important;
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
    .wrraper-table{
        padding: 2rem;
        background: white;
        border-radius: 5px;
        box-shadow: 0 0 12px grey;
    }
    .table td:first-child{
        padding-left: 0.75rem !important ;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.ckcldt')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            <!-- <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.nhap_excel')">
                <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
            </button> -->
            <a href="{{ route('admin.importdata.cknckh.exportCknckh') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
        </div>
        
        <div class="wrraper-table">
            <select name="" id="year" class="form-control">
                <option value="" hidden>-- @lang('project/ImportdataExcel/title.cnck')</option>
                @for($i = intVal(date('Y')) + 1 ;$i >= 2017; $i--)
                    <option  value="{{ $i }}" 
                        @if($i == intVal(date('Y')))
                            selected
                        @endif
                    >{{$i}}</option>
                @endfor
            </select>
            <br>
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                 <tr>
                    <th>
                        @lang('project/ImportdataExcel/title.stt')
                    </th>
                    <th>
                        @lang('project/ImportdataExcel/title.noidung')
                    </th>
                    <th>
                        @lang('project/ImportdataExcel/title.tddhcq')
                    </th>
                 </tr>
                </thead>
                <tbody>  
                    <tr>
                        <td>I</td>
                        <td>@lang('project/ImportdataExcel/title.dkkyts')</td>
                        <td contenteditable id="dkkyts">
                            {!! $current == "" ?  "" : $current->dkdkts !!}
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="3">II</td>
                        <td rowspan="3">@lang('project/ImportdataExcel/title.mtkt')</td>
                        <td>
                            @lang('project/ImportdataExcel/title.kienthuc'): 
                            <div contenteditable id="kienthuc">
                                {!! $current == "" ?  "" : $current->kienthuc !!}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('project/ImportdataExcel/title.kynang'): 
                            <div contenteditable id="kynang">
                                {!! $current == "" ?  "" : $current->kynang !!}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @lang('project/ImportdataExcel/title.nltctn'):
                            <div contenteditable id="nltctn">
                                {!! $current == "" ?  "" : $current->nltctn !!}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>III</td>
                        <td>@lang('project/ImportdataExcel/title.ccshd')</td>
                        <td contenteditable id="ccshd">
                            {!! $current == "" ?  "" : $current->ccshd !!}
                        </td>
                    </tr>
                    <tr>
                        <td>IV</td>
                        <td>@lang('project/ImportdataExcel/title.ctdtnt')</td>
                        <td contenteditable id="ctdtnt">
                            {!! $current == "" ?  "" : $current->ctdt !!}
                        </td>
                    </tr>
                    <tr>
                        <td>V</td>
                        <td>@lang('project/ImportdataExcel/title.knhtrt')</td>
                        <td contenteditable id="knhtrt">
                            {!! $current == "" ?  "" : $current->knht !!}
                        </td>
                    </tr>
                    <tr>
                        <td>VI</td>
                        <td>@lang('project/ImportdataExcel/title.vtlv')</td>
                        <td contenteditable id="vtlv">
                            {!! $current == "" ?  "" : $current->vtstn !!}
                        </td>
                    </tr>
                </tbody>                
            </table>

            <button id="btn-update" class="btn btn-primary">
                @lang('project/ImportdataExcel/title.capnhat')
            </button>
        </div>
    </div>
</section>
<!-- /Kết thúc page trang -->
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
    
    $("#btn-update").click(function() {
        let data = {
            "dkkyts": dkkyts.textContent,
            "kienthuc": kienthuc.textContent,
            "kynang": kynang.textContent,
            "nltctn": nltctn.textContent,
            "ccshd": ccshd.textContent,
            "ctdtnt": ctdtnt.textContent,
            "knhtrt": knhtrt.textContent,
            "vtlv": vtlv.textContent,
            "year": year.value
        }

        let routeApi = "{{ route('admin.importdata.ckcldt.updateCkcldt') }}";
        fetch(routeApi, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST", 
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if(data.mes == "done"){
                    location.reload();
                }
            })
    })
    

    $("#year").change(function(){
        let routeApi = "{{ route('admin.importdata.ckcldt.getCkcldt') }}?nam=" 
                + $("#year").val();
        fetch(routeApi, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if(data.result == ""){
                    alert("Năm công khai không có dữ liệu");
                }else{
                    dkkyts.textContent = data.result.dkdkts;
                    kienthuc.textContent = data.result.kienthuc;
                    kynang.textContent = data.result.kynang;
                    nltctn.textContent = data.result.nltctn;
                    ccshd.textContent = data.result.ccshd;
                    ctdtnt.textContent = data.result.ctdt;
                    knhtrt.textContent = data.result.knht;
                    vtlv.textContent = data.result.vtstn;
                    console.log(data)
                }
            })
    })

</script>


@stop
