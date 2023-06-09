@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.ckdngvch')
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
    .content-body{
        background:white;
    }
    th{
        font-weight:bold !important;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.ckdngvch')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.themmoi')">
                <i class="bi bi-plus-square " style="font-size: 30px;color: #009ef7;"></i>
            </button>
            <!-- <a href="{{ route('admin.importdata.ckdngv.exportCkdtdsv') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a> -->
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_gvch" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
                <i class="bi bi-trash" style="font-size: 35px;color: red;"></i>
            </button>
        </div>
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th rowspan="2">
                    @lang('project/ImportdataExcel/title.stt')
                </th>
                <th rowspan="2">
                    @lang('project/ImportdataExcel/title.noidung')
                </th>
                <th rowspan="2">
                    @lang('project/ImportdataExcel/title.tongso')
                </th>
                <th colspan="2">
                    @lang('project/ImportdataExcel/title.chucdanh')
                </th>
                <th colspan="5">
                    @lang('project/ImportdataExcel/title.tddt')
                </th>
                <th colspan="3">
                    @lang('project/ImportdataExcel/title.hcdn')
                </th>
                <th style="width: 12%;" rowspan="2">
                    @lang('project/ImportdataExcel/title.hanhd')
                </th>
             </tr>
             <tr>
                <th>
                    @lang('project/ImportdataExcel/title.giaosu')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.phogiaosu')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tiensi')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.thacsi')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.daihoc')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.caodang')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.tdk')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hangIII')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hangII')
                </th>
                <th>
                    @lang('project/ImportdataExcel/title.hangI')
                </th>
             </tr>
            </thead>
            <tbody>
                @php
                    $loai = [
                        Lang::get('project/ImportdataExcel/title.gvchcn'),
                        Lang::get('project/ImportdataExcel/title.gvchmc'),
                    ];
                    $khoinganh = [
                        Lang::get('project/ImportdataExcel/title.khoing1'),
                        Lang::get('project/ImportdataExcel/title.khoing2'),
                        Lang::get('project/ImportdataExcel/title.khoing3'),
                        Lang::get('project/ImportdataExcel/title.khoing4'),
                        Lang::get('project/ImportdataExcel/title.khoing5'),
                    ];
                    $character = 'abcdef';
                @endphp
                @foreach($loai as $key => $lo)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <td colspan = "13">
                            <b>{{ $lo }}</b>
                        </td>
                    </tr>
                    @foreach($khoinganh as $key2 => $kn)
                        <tr>
                            <th>{{ substr($character , $key2, 1) }}</th>
                            <td colspan = "13">
                                <b>{{ $kn }}</b>
                            </td>
                        </tr>
                        @foreach($gvch as $value)
                            @if($value->loai == $key + 1 && $value->khoinganh == $key2 + 1)
                                <tr>
                                    <td></td>
                                    <td>{{ $value->noi_dung }}</td>
                                    <td>{{ $value->tong_so }}</td>
                                    <td>{{ $value->giao_su }}</td>
                                    <td>{{ $value->pho_giao_su }}</td>
                                    <td>{{ $value->tien_si }}</td>
                                    <td>{{ $value->thac_si }}</td>
                                    <td>{{ $value->dai_hoc }}</td>
                                    <td>{{ $value->cao_dang }}</td>
                                    <td>{{ $value->trinh_do_khac }}</td>
                                    <td>{{ $value->hang_3 }}</td>
                                    <td>{{ $value->hang_2 }}</td>
                                    <td>{{ $value->hang_1 }}</td>
                                    <td>
                                        <a href="#" class="open-update" data-id="{{ $value->id }}">
                                        <i class="bi bi-gear-fill" style="font-size: 25px;color: #009ef7;"></i>
                                        </a>
                                        <a href="#" class="open-delete" data-id="{{ $value->id }}">
                                            <i class="bi bi-trash" style="font-size: 25px;color: red;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
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
                    @lang('project/ImportdataExcel/title.ckdngvch')
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ route('admin.importdata.ckdngvch.createUnit') }}" method="post">
                @csrf
                <div class="modal-body container-fluid">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="forlgv">
                                @lang('project/ImportdataExcel/title.loaigv')
                            </label>
                            <select name="loaigv" id="forlgv" class="form-control">
                                <option value="1">@lang('project/ImportdataExcel/title.gvchcn')</option>
                                <option value="2">@lang('project/ImportdataExcel/title.gvchmc')</option>
                            </select>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="forkn">
                                @lang('project/ImportdataExcel/title.khoinganh')
                            </label>
                            <select name="khoinganh" id="forkn" class="form-control">
                                <option value="1">@lang('project/ImportdataExcel/title.khoing1')</option>
                                <option value="2">@lang('project/ImportdataExcel/title.khoing2')</option>
                                <option value="3">@lang('project/ImportdataExcel/title.khoing3')</option>
                                <option value="4">@lang('project/ImportdataExcel/title.khoing4')</option>
                                <option value="5">@lang('project/ImportdataExcel/title.khoing5')</option>
                            </select>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="fortenng">
                                @lang('project/ImportdataExcel/title.tennganh')
                            </label>
                            <input type="text" name="tennganh" id="fortenng" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tennganh')" required>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="fortongso">
                                @lang('project/ImportdataExcel/title.tongso')
                            </label>
                            <input type="number" name="tongso" id="fortongso" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tongso')" required>
                        </div> 
                        <!-- Chức danh -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.chucdanh'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="forgiaosu">
                                @lang('project/ImportdataExcel/title.giaosu')
                            </label>
                            <input type="number" name="giaosu" id="forgiaosu" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.giaosu')" required>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="forpgiaosu">
                                @lang('project/ImportdataExcel/title.phogiaosu')
                            </label>
                            <input type="number" name="phogiaosu" id="forpgiaosu" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.phogiaosu')" required>
                        </div> 
                        <!-- Trình độ đào tạo -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.tddt'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fortiensi">
                                @lang('project/ImportdataExcel/title.tiensi')
                            </label>
                            <input type="number" name="tiensi" id="fortiensi" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tiensi')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forthacsi">
                                @lang('project/ImportdataExcel/title.thacsi')
                            </label>
                            <input type="number" name="thacsi" id="forthacsi" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.thacsi')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="fordaihoc">
                                @lang('project/ImportdataExcel/title.daihoc')
                            </label>
                            <input type="number" name="daihoc" id="fordaihoc" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.daihoc')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forcaodang">
                                @lang('project/ImportdataExcel/title.caodang')
                            </label>
                            <input type="number" name="caodang" id="forcaodang" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.caodang')" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fortdk">
                                @lang('project/ImportdataExcel/title.trinhdokhac')
                            </label>
                            <input type="number" name="trinhdokhac" id="fortdk" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.trinhdokhac')" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Hạng chức danh nghề -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.hcdn'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="forhang3">
                                @lang('project/ImportdataExcel/title.hangIII')
                            </label>
                            <input type="number" name="hangIII" id="forhang3" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangIII')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forhang2">
                                @lang('project/ImportdataExcel/title.hangII')
                            </label>
                            <input type="number" name="hangII" id="forhang2" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangII')" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="forhang1">
                                @lang('project/ImportdataExcel/title.hangI')
                            </label>
                            <input type="number" name="hangI" id="forhang1" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangI')" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >
                        @lang('project/Standard/title.themmoi')
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('project/Standard/title.huy')
                    </button>
                </div>
            </form>
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
                    @lang('project/ImportdataExcel/title.ckgvtkn')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.importdata.ckdngvch.updateUnit') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="id_update">
                <div class="modal-body container-fluid">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="forlgv_up">
                                @lang('project/ImportdataExcel/title.loaigv')
                            </label>
                            <select name="loaigv" id="forlgv_up" class="form-control">
                                <option value="1">@lang('project/ImportdataExcel/title.gvchcn')</option>
                                <option value="2">@lang('project/ImportdataExcel/title.gvchmc')</option>
                            </select>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="forkn_up">
                                @lang('project/ImportdataExcel/title.khoinganh')
                            </label>
                            <select name="khoinganh" id="forkn_up" class="form-control">
                                <option value="1">@lang('project/ImportdataExcel/title.khoing1')</option>
                                <option value="2">@lang('project/ImportdataExcel/title.khoing2')</option>
                                <option value="3">@lang('project/ImportdataExcel/title.khoing3')</option>
                                <option value="4">@lang('project/ImportdataExcel/title.khoing4')</option>
                                <option value="5">@lang('project/ImportdataExcel/title.khoing5')</option>
                            </select>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="fortenng_up">
                                @lang('project/ImportdataExcel/title.tennganh')
                            </label>
                            <input type="text" name="tennganh" id="fortenng_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tennganh')" required>
                        </div>  
                        <div class="form-group col-md-6">
                            <label for="fortongso_up">
                                @lang('project/ImportdataExcel/title.tongso')
                            </label>
                            <input type="number" name="tongso" id="fortongso_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tongso')" required>
                        </div> 
                        <!-- Chức danh -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.chucdanh'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="forgiaosu_up">
                                @lang('project/ImportdataExcel/title.giaosu')
                            </label>
                            <input type="number" name="giaosu" id="forgiaosu_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.giaosu')" required>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="forpgiaosu_up">
                                @lang('project/ImportdataExcel/title.phogiaosu')
                            </label>
                            <input type="number" name="phogiaosu" id="forpgiaosu_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.phogiaosu')" required>
                        </div> 
                        <!-- Trình độ đào tạo -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.tddt'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fortiensi_up">
                                @lang('project/ImportdataExcel/title.tiensi')
                            </label>
                            <input type="number" name="tiensi" id="fortiensi_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.tiensi')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forthacsi_up">
                                @lang('project/ImportdataExcel/title.thacsi')
                            </label>
                            <input type="number" name="thacsi" id="forthacsi_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.thacsi')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="fordaihoc_up">
                                @lang('project/ImportdataExcel/title.daihoc')
                            </label>
                            <input type="number" name="daihoc" id="fordaihoc_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.daihoc')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forcaodang_up">
                                @lang('project/ImportdataExcel/title.caodang')
                            </label>
                            <input type="number" name="caodang" id="forcaodang_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.caodang')" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fortdk_up">
                                @lang('project/ImportdataExcel/title.trinhdokhac')
                            </label>
                            <input type="number" name="trinhdokhac" id="fortdk_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.trinhdokhac')" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Hạng chức danh nghề -->
                        <div class="form-group col-md-12">
                            <i>
                                <h2>@lang('project/ImportdataExcel/title.hcdn'):</h2>
                            </i>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="forhang3_up">
                                @lang('project/ImportdataExcel/title.hangIII')
                            </label>
                            <input type="number" name="hangIII" id="forhang3_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangIII')" required>
                        </div> 
                        <div class="form-group col-md-2">
                            <label for="forhang2_up">
                                @lang('project/ImportdataExcel/title.hangII')
                            </label>
                            <input type="number" name="hangII" id="forhang2_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangII')" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="forhang1_up">
                                @lang('project/ImportdataExcel/title.hangI')
                            </label>
                            <input type="number" name="hangI" id="forhang1_up" class="form-control"
                            placeholder="@lang('project/ImportdataExcel/title.hangI')" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >
                        @lang('project/Standard/title.thaydoi')
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('project/Standard/title.huy')
                    </button>
                </div>
            </form>
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
    $(".open-delete").click(function(){
        let idItem = $(this).attr('data-id');
        $("#modalDelete").modal("show")
        let route = "{!! route('admin.importdata.ckdngvch.deleteUnit') !!}" + "?id_delete=" + idItem
        $("#btn-delete-unit").attr("href", route);
    })

    $(".open-update").click(function() {
        let idItem = $(this).attr('data-id');
        

        let loadData = "{{ route('admin.importdata.ckdngvch.getInfoUnit') }}" + "?id=" + idItem;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $("#id_update").val(idItem)
                $("#forlgv_up").val(data.loai);
                $("#forkn_up").val(data.khoinganh);
                $("#fortenng_up").val(data.noi_dung);
                $("#fortongso_up").val(data.tong_so);
                $("#forgiaosu_up").val(data.giao_su);
                $("#forpgiaosu_up").val(data.pho_giao_su);
                $("#fortiensi_up").val(data.tien_si);
                $("#forthacsi_up").val(data.thac_si);
                $("#fordaihoc_up").val(data.dai_hoc);
                $("#forcaodang_up").val(data.cao_dang);
                $("#fortdk_up").val(data.trinh_do_khac);
                $("#forhang3_up").val(data.hang_3);
                $("#forhang2_up").val(data.hang_2);
                $("#forhang1_up").val(data.hang_1);
                $("#modalUpdate").modal("show");
            })

    })

    var listColor = {
        check_empty :   '#ec5757',
        check_website : '#57a7ec',
        check_email  :  '#7306c0',
        check_phone :   '#ce7d27',
        check_number :  '#5765ec',
        check_date : '#047a7e',
    }

    // $(function(){
    //     table = $('#table').DataTable({
    //         responsive: true,
    //         processing: true,
    //         serverSide: true,
    //         ajax: "{!! route('admin.importdata.ckdngv.dataUnit') !!}",
    //         columns: [
    //             { data: 'hoten', name: 'hoten' },
    //             { data: 'namsinh', name: 'namsinh' },
    //             { data: 'chucdanh', name: 'chucdanh' },
    //             { data: 'tddt', name: 'tddt' },
    //             { data: 'cngd', name: 'cngd' },
    //             { data: 'khoinganh', name: 'khoinganh' },
    //             { data: 'actions', name: 'actions' ,className: 'action'},
    //         ],            
    //     });
    // });  

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
            url : "{!! route('admin.importdata.ckdngv.importUnit') !!}",
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
                                    @lang('project/ImportdataExcel/title.hoten')                                  
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.namsinh')                                  
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.gioitinh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.chucdanh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.tddt')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.cngd')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.khoinganh')
                                </th>
                                <th class="row_width p-2">
                                    @lang('project/ImportdataExcel/title.hanhdong')
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
                                    ${item.hoten}
                                </td>
                                <td contenteditable class="text-center p-2 row2"> 
                                    ${item.namsinh}
                                </td>
                                <td contenteditable class="text-center p-2 row3"> 
                                    <select class="form-control"> `;
                                    if(item.gioitinh == "1")
                                        add += "<option selected value = '1'>@lang('project/ImportdataExcel/title.male')</option>";
                                    else
                                        add += "<option value = '1'>@lang('project/ImportdataExcel/title.male')</option>";
                                        if(item.gioitinh == "2")
                                        add += "<option selected value = '2'>@lang('project/ImportdataExcel/title.female')</option>";
                                    else
                                        add += "<option value = '2'>@lang('project/ImportdataExcel/title.female')</option>";

                                    add += `</select>
                                </td>
                                <td contenteditable class="text-center p-2 row4"> 
                                    ${item.chucdanh}
                                </td>
                                <td contenteditable class="text-center p-2 row5"> 
                                    ${item.tddt}
                                </td>
                                <td contenteditable class="text-center p-2 row6"> 
                                    ${item.cngd}
                                </td>
                                <td contenteditable class="text-center p-2 row7"> 
                                    ${item.khoinganh}
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
                <td contenteditable class="text-center p-2 row3">
                    <select class="form-control">
                        <option value = '1'>@lang('project/ImportdataExcel/title.male')</option>
                        <option value = '2'>@lang('project/ImportdataExcel/title.female')</option>
                    </select>
                </td>
                <td contenteditable class="text-center p-2 row4"></td>
                <td contenteditable class="text-center p-2 row5"></td>
                <td contenteditable class="text-center p-2 row6"></td>
                <td contenteditable class="text-center p-2 row7"></td>
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
                    'hoten' :   $(this).find('.row1').text().trim(),
                    'namsinh' :  $(this).find('.row2').text().trim(),
                    'gioitinh' :  $(this).find('.row3').find("select").val(),
                    'chucdanh' :  $(this).find('.row4').text().trim(),
                    'tddt' :  $(this).find('.row5').text().trim(),
                    'cngd' :  $(this).find('.row6').text().trim(),
                    'khoinganh' :  $(this).find('.row7').text().trim(),
                }
                dataSubmit.push(dataObj);
            });

            let loadData = "{{ route('admin.importdata.ckdngv.importDataUnit') }}";
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
        var route = "{{ route('admin.importdata.ckdngv.deleteUnit') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-unit').attr('href' , route);
    })


  

    $("#btn-update-unit").click(function() {
        $("#update-unit").submit();
    })



</script>


@stop
