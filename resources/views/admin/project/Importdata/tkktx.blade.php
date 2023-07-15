@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.tkktx')
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
    .w-stt{
        width: 10px !important;
    }
    .table-show{
        background-color: white;
        padding: 15px;
        box-shadow: 0 0 12px #cecece;
        border-radius: 5px;
    }
    .table-show td:first-child{
        text-align: center;
    }
    .table-show thead{
        background: #2d85cb;
        color: white;
    }
    .container-fuild{
        display: flex;
        flex-wrap: wrap;
    }
    .container-fuild .block-code{
        width: 50%;
    }
    .container-fuild .block-code .row{
        margin: 10px 0;
    }
    input[type="text"]{
        outline: none;
        padding: 10px;
        margin: 5px 0;
    }
    .block-child{
        display: none;
    }
    .table-striped td{
        text-align: left !important;
    }
    .space-block{
        justify-content: space-between;
    }
    .space-block-item{
        
        display: flex;
    }
    .select-nam{
        padding: 0 10px;
        border-radius: 3px;
        outline: none;
        color: #474747;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.tkktx')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button space-block mb-2">
            <select class="select-nam space-block-item">
                <option value="" >
                    @lang('project/ImportdataExcel/title.chonnam')
                </option>
                @foreach($nams as $nam)
                    <option value="{{ $nam->nam }}"  
                        @if(isset(request()->nam) && request()->nam == $nam->nam)
                            selected
                        @endif
                     >{{ $nam->nam }}</option>
                @endforeach
            </select>
            <div class="space-block-item">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.nhap_dl')">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <a href="{{ route('admin.importdata.tkktx.exportTkktx') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                    <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                </a>
                <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__ns" data-nametable="excel_import_tk_ktx" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
                    <i class="bi bi-trash" style="font-size: 35px;color: red;"></i>
                </button>
            </div>
        </div>
        <div class="table-show">
            <table class="table table-striped table-bordered" id="table" width="100%"   >
              <thead>
                <tr>
                  <th scope="col">
                      @lang('project/ImportdataExcel/title.noidung')
                  </th>
                  <th scope="col">
                      @lang('project/ImportdataExcel/title.noidungnho')
                  </th>
                  <th scope="col">
                      @lang('project/ImportdataExcel/title.nam')
                  </th>
                  <th scope="col">
                      @lang('project/ImportdataExcel/title.giatrim')
                  </th>
                  <th scope="col">
                        @lang('project/ImportdataExcel/title.hanhdong')
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($tttnsv as $value)
                 @php
                    $childs  = DB::table("excel_import_tk_ktx")
                            ->where("parent", $value->id)
                            ->orderBy('id', 'asc'); 
                    if(isset(request()->nam)) {
                        $childs = $childs->where("nam", request()->nam);
                    }
                    $child = $childs->get();
                    $groupChild = $childs->groupBy('nam')->select('nam')->get();
                    $arr = [];
                    foreach($groupChild as $gr){
                        array_push($arr , $gr->nam);
                    }
                 @endphp
                 <tr>
                    <td colspan="4" style="padding-left: 11px">
                        {{ $value->tieu_chi }}
                    </td>
                    <td>
                        <button class="btn btn-delete"  data-nam="{{ implode(' ',$arr) }}" data-parent = "{{ $value->id }}">
                            <i class="bi bi-trash" style="font-size: 25px;color: red;"></i>
                        </button>
                    </td> 
                 </tr>
                 @foreach($child as $value2)
                 <tr>
                     <td></td>
                     <td class="tc_content">
                         {{ $value2->tieu_chi }}
                     </td>
                     <td class="nam_content">
                         {{ $value2->nam }}
                     </td>
                     <td class="giatri_content">
                         {{ $value2->gia_tri }}
                     </td>
                     <td>
                         <button class="btn btn-update" data-id="{{ $value2->id }}" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.chinhsua')">
                            <i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>
                         </button>
                     </td>
                 </tr>
                 @endforeach
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</section>
<!-- /Kết thúc page trang -->

<!-- Import modal excel -->
<div class="modal fade" id="modal_unit" tabindex="-1" role="dialog" aria-labelledby="modalUnitLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUnitLabel">
                    @lang('project/ImportdataExcel/title.tkktx')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <input type="file" class="mb-2" name="files" id="file"  accept=".xlsx, .xls, .csv"> -->
                <div class="d-flex justify-content-between">
                    <!-- <button class="btn btn-success btn-benchmark mb-2" id="import_unit">@lang('project/Standard/title.nhap')</button> -->
                    <!-- <button class="btn btn-success btn-benchmark m-2" id="add_unit">
                        @lang('project/ImportdataExcel/title.themtt')
                    </button> -->
                </div>

                <form id="css_table" method="post" action="{{ route('admin.importdata.tkktx.importUnit') }}">
                    @csrf
                    <div class="container-fuild">
                        <!-- 1 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-7">
                                    <label>
                                        @lang('project/ImportdataExcel/title.tdtktx')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent" >
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-2">
                                        <button data-check="1" class="btn btn-benchmark mr-2 btn-add-item" type="button" sdata-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                                <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_ block_render_one">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.tdtktx')" class="form-control" name="key1[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value1[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- 2 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.tdtpo')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-check="2" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_ block_render">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.tdtpo')" class="form-control" name="key2[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value2[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.ssvcnc')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-check="3" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                            
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.tong3')" class="form-control" name="key3[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value3[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.ct13')" class="form-control" name="key3[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value3[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.ct23')" class="form-control" name="key3[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value3[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 4 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.slsvoktx')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>
                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-check="4" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.tong4')" class="form-control" name="key4[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value4[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.ct14')" class="form-control" name="key4[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value4[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.ct24')" class="form-control" name="key4[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value4[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.tscoktx')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>
                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-1">
                                        <button data-check="5" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.tscoktx')" class="form-control" name="key5[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value5[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.ttcsvs')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-2">
                                        <button data-check="6" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.bankc')" class="form-control" name="key6[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value6[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.dangsc')" class="form-control" name="key6[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value6[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.kienco')" class="form-control" name="key6[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value6[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.ndvsd')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-2">
                                        <button data-check="7" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.ndvsd')" class="form-control" name="key7[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value7[]">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- 10 -->
                        <div class="block-code">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>
                                        @lang('project/ImportdataExcel/title.htsh')
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <input type="checkbox" class="checkbox-parent">
                                    <input type="hidden" class="checkbox-hidden" name="checkbox[]" value="off">
                                </div>
                            </div>

                            <div class="block-child">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text" placeholder="@lang('project/ImportdataExcel/title.nam')" name="nam[]">
                                    </div>
                                    <div class="col-md-2">
                                        <button data-check="8" class="btn btn-benchmark mr-2 btn-add-item" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm item">
                                            <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block_render_">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.muon')" class="form-control" name="key8[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value8[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.sohuu8')" class="form-control" name="key8[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value8[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" placeholder="Tiêu đề" value="@lang('project/ImportdataExcel/title.chothue8')" class="form-control" name="key8[]">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" name="value8[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

                
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.importdata.tkktx.deleteUnit') }}" method="post">
                @csrf
                <input type="hidden" id="id_parent" name="id_parent">
                <div class="modal-body">
                    <p class="font-weight-bold">
                        @lang('project/ImportdataExcel/title.cnxoa')
                    </p>
                    <div class="container mb-4 container-delete">
                        <div class="row">
                            

                        </div>
                    </div>

                    <span class="badge badge-primary">
                        @lang('project/Standard/message.error.khoantac')
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        @lang('project/Standard/title.xoa')
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        @lang('project/Standard/title.huy')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- modal update -->
<!-- Modal -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog modal-ml">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateLabel">
            @lang('project/ImportdataExcel/title.cntkktx')
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.importdata.tkktx.updateUnit') }}" method="post">
            @csrf
            <input type="hidden" class="save-id" name="id">
          <div class="modal-body">
            <p class="tieu_chi_con"></p>
            <p class="tieu_chi_nam"></p>
            <input type="text" class="tieu_chi_giatri" name="tieu_chi_giatri">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                @lang('project/Standard/title.thaydoi')
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                @lang('project/Standard/title.huy')
            </button>
          </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalDeleteAll__ns" tabindex="-1" aria-labelledby="modalDeleteAll__nsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeleteAll__nsLabel">Cảnh báo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            Xóa trắng dữ liệu bảng <br>
            <span class="text-danger">Hành động của bạn không thể hoàn tác</span>
      </div>
      <div class="modal-footer">
            <a href="" id="deleteAllTable__ns" class="btn btn-danger">
                Xóa trắng dữ liệu bảng                   
             </a>
      </div>
    </div>
  </div>
</div>

    <!-- Kết thúc trang -->
    </sectio
    forlienketn>
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
    $(".checkbox-parent").click(function() {
        if($(this).is(':checked')){ 
            $(this).parent().parent().parent()
                .find(".block-child").css("display", "block");
            $(this).parent().find(".checkbox-hidden").val("on");
        }
        else{ 
            $(this).parent().parent().parent()
                .find(".block-child").css("display", "none");
            $(this).parent().find(".checkbox-hidden").val("off");
        }
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
    //         ajax: "{!! route('admin.importdata.dtkhcn2.dataUnit') !!}",
    //         columns: [
    //             { data: 'nam', name: 'nam' },
    //             { data: 'doanh_thu', name: 'doanh_thu' },
    //             { data: 'ty_le_doanh_thu', name: 'ty_le_doanh_thu' },
    //             { data: 'ty_so_doanh_thu', name: 'ty_so_doanh_thu' },
    //             { data: 'actions', name: 'actions' },
    //         ],            
    //     });
    // });  

    var dataFix = [
        { stt: '1', content: "@lang('project/ImportdataExcel/title.dtdct')", parent: ''},
        { stt: '2', content: "@lang('project/ImportdataExcel/title.tdtsxd')", parent: ''},
        { stt: '1', content: "@lang('project/ImportdataExcel/title.htgd')", parent: '2'},
        { stt: '2', content: "@lang('project/ImportdataExcel/title.tvtt')", parent: '2'},
        { stt: '3', content: "@lang('project/ImportdataExcel/title.ttnc')", parent: '2'},
        { stt: '3', content: "@lang('project/ImportdataExcel/title.tdts')", parent: ''},
        { stt: '1', content: "@lang('project/ImportdataExcel/title.ccdtkt')", parent: '3'},
        { stt: '2', content: "@lang('project/ImportdataExcel/title.ctdtnkql')", parent: '3'},
    ];


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



    $("#import_unit_data").click(function() {
        $("form#css_table").submit();
    })


    $(".btn-delete").click(function() {
        $("#id_parent").val($(this).attr("data-parent"));
        $("#modalDelete").modal("show");
        let arrNam = $(this).attr("data-nam").split(" ");
        $(".container-delete .row").empty();
        arrNam.forEach((item, index) => {
            let UI = ` 
                <div class="col-md-6">
                    <input type="checkbox" id="nam1_${index}" name="nam_delete[]" value="${item}">
                    <label for="nam1_${index}">${item}</label>
                </div>
             `;
            $(".container-delete .row").append(UI);
        })
    })
    

    $(".btn-update").click(function() {
        $(".tieu_chi_con").text(
            "@lang('project/ImportdataExcel/title.noidungnho'): " + $(this).parent().parent().find(".tc_content").text()
        );
        $(".tieu_chi_nam").text(
            "@lang('project/ImportdataExcel/title.nam'): " + $(this).parent().parent().find(".nam_content").text()
        );
        $(".tieu_chi_giatri").val($(this).parent().parent().find(".giatri_content").text().trim());
        $('.save-id').val(
            $(this).attr('data-id')
        );
        $("#modalUpdate").modal("show");

    })

    $(".select-nam").change(function() {
        if($(this).val() == ""){
            let route = "{{ route('admin.importdata.tkktx.index') }}";
            location.replace(route);
        }else{
            let route = "{{ route('admin.importdata.tkktx.index') }}" + "?nam=" + $(this).val()
            location.replace(route);
        }
        
    })



    $("#modal_unit").on('click', ".btn-add-item", function(){
        let check = $(this).attr('data-check');
        let UI = `
            <div class="row">
                <div class="col-md-7">
                    <input type="text" placeholder="Tiêu đề" name="key${check}[]" class="form-control">
                </div>
                <div class="col-md-1">
                    <input type="text" name="value${check}[]">
                </div>
            </div>
        `;
        $(this).parent().parent().parent().find(".block_render_").append(UI);
    })



    

    

    $('#modalDeleteAll__ns').on('show.bs.modal', function (event) {
        // var button = $(event.relatedTarget) 
        // var recipient = button.data('nametable')
        var route = "{{ route('admin.importdata.tkktx.deleteAll') }}";
        $("#deleteAllTable__ns").attr('href', route);
    })
</script>


@stop
