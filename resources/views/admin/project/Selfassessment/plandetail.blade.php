@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.lkhct')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<style>
.control-label{
    margin: 11px 18px 0px 1px;
}
.block-flex{
    display: flex;
}
/* div.d-flex{
    align-items: inherit !important;
} */
.block-flex input{
    width: 40%;
}
.button_lkh{
    background-color: orange; !important;
}
.bock-body{
    margin: 20px;
    padding-bottom: 22px;
    background: white;
    box-shadow: rgb(171 171 171) 0px 0px 12px;
}
.tieuchuan{
    display: flex;
    align-items: center;
}

.tieuchi{
    padding: 9px 0px 8px 0px;
    border-radius: 40px !important;
    position: relative;
    display: flex;

}
.part-two-tieuchi span{
    height: 100%;
    padding: 4px 4px 0px 9px;
    position: relative;
}
.menhde{
    height: 62px;
    margin-top: 9px;
    border-radius: 38px !important;
    padding: 1px 50px 0px 0px;
    font-style: italic;
}
.select2-selection{
    display: flex;
    padding: 19px;
}

#gioihan_start{
    cursor: no-drop;
}

#gioihan_end{
    cursor: no-drop;
}

.button_tc{
    position: absolute;
    right: 66px;
}
.pd-css{
    margin: 0 13px;
}
.bt_tieuchi{
    position: absolute;
    right: 86px;
}
.part-two-menhde_css{
    background: antiquewhite;
    margin: 10px 0;
    height: auto;
    padding: 2px 0;
    color: black;
    border-radius: 82px;
    width: 89%;
    margin-left: 7rem;
}
.menhde_css{
    padding-right: 98px;
}

.select2-container{
    width: 100% !important;
}
.d-flex1{
    display: flex;
    /* align-items: center !important; */
}
.ml-5{
    margin-left: 15px;
}
.select2-container .select2-selection--single{
    display: flex !important;
}

tbody tr td:last-child {
    display: revert !important;
}
</style>
@stop

@php
    use Illuminate\Support\Facades\DB;
@endphp

@section('title_page')
    @lang('project/Selfassessment/title.lkhct')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body bock-body">
    <div class="form-standard">
        <h3 style="
        text-align: center;
        width: 100%;">
            @lang('project/Selfassessment/title.tenbc') :
            {{ $khbc->ten_bc }}
        </h3>
        <div class="part-one" style="display: inline-block;">
            <span class="label label-primary">
                <i class="fas fa-edit"></i>
            </span>
            <span >@lang('project/Selfassessment/title.p1')</span>
            <button style="float: right;margin-right: 20px;" class="btn btn-warning button_css button_lkh" id="btn_part_one" onclick="showhidepartone();return false;"><i class="fa fa-plus"></i></button>
            <div id="div_lkh_part_one" style="display:none">
                <br/>
                <table style="width: 100%;">
                    <tr>
                        <td width="10%">
                            <label class="control-label">@lang('project/Selfassessment/title.ghtg'):</label>
                        </td>
                        <td width="10%">
                            <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc" id="gioihan_start" type="text" value="{{ $keHoachBaoCao->ngay_batdau }}" disabled/>
                        </td>
                        <td width="10%">
                            <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_bc" id="gioihan_end" type="text" value="{{ $keHoachBaoCao->ngay_hoanthanh }}" disabled/>
                        </td>
                        <td width="10%" align="right">
                            <label class="control-label">@lang('project/Selfassessment/title.nbd'):&nbsp;</label>
                        </td>
                        <td width="10%">
                            <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input ngaybd_chung" id="ngay_bat_dau" type="text" value="{{ isset($keHoachChung->ngay_batdau)?$keHoachChung->ngay_batdau:''}}">
                        </td>
                        <td width="10%" align="right">
                            <label class="control-label">@lang('project/Selfassessment/title.ngayht'):</label>
                        </td>
                        <td width="10%">
                            <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_chung" id="ngay_ket_thuc" type="text" value="{{ isset($keHoachChung->ngay_hoanthanh)?$keHoachChung->ngay_hoanthanh:''}}">
                        </td>
                        <td width="10%" align="center">
                            <button type="button" class="btn" onclick="update_khaiquat()" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.capnhat')">
                                <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <br/>
            </div>
        </div>
        <hr>
        <div class="check_time">
            <button class="part-two border-0">
                <span class="label label-primary">
                    <i class="fas fa-edit"></i>
                </span>
                <span>@lang('project/Selfassessment/title.p2')</span>
            </button>
            <div >
                @foreach($listTc as $kh_tieuchuan)

                    <div class="part-two-content">
                        <div class="tieuchuan ml-3">

                            <button class="btn btn-success button_css" id="btn_tieuchuan{{$kh_tieuchuan->id}}" onclick="showhidetieuchi({{$kh_tieuchuan->id}});return false;"><i class="fa fa-plus"></i></button>

                            <span class="label label-warning span_css">
                                <i class="fas fa-file"></i>
                            </span>
                            <span>
                                @lang('project/Selfassessment/title.tc'){{$kh_tieuchuan->stt }}:
                                <a>{{ $kh_tieuchuan->mo_ta }} </a>
                            </span>&nbsp;
                            <span class="daVietBaoCao_{{$kh_tieuchuan->id}} pl-2" d-id=""
                                  d-url="">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                            <button style="float: right;margin-right: 10px;" class="btn btn-warning button_css button_lkh button_tc" id="btn_part_two_{{$kh_tieuchuan->id}}" onclick="showhidepartwo({{$kh_tieuchuan->id}});return false;"><i class="fa fa-plus"></i></button>
                        </div>
                        <div id="div_lkh_part_two{{$kh_tieuchuan->id}}" style="width: 97%; display: none;">
                            <br/>
                            <table style="width: 100%; line-height: 36px;">
                                <tr>
                                    <td width="10%">
                                        <label class="control-label">@lang('project/Selfassessment/title.ghcb'):</label>
                                    </td>
                                    <td width="10%">
                                        <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc" id="tieuchuan_date_gh_bd_{{$kh_tieuchuan->id}}" type="text" value="{{ $keHoachBaoCao->ngay_batdau_chuanbi }}" readonly />
                                    </td>
                                    <td width="10%">
                                        <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_bc" id="tieuchuan_date_gh_kt_{{$kh_tieuchuan->id}}" type="text" value="{{ $keHoachBaoCao->ngay_hoanthanh_chuanbi }}" readonly />
                                    </td>
                                    <td width="10%" align="right">
                                        <label class="control-label">@lang('project/Selfassessment/title.khcb'):&nbsp;</label>
                                    </td>
                                    <td width="10%">
                                        <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input kh_time" id="ngay_chuanbi_{{$kh_tieuchuan->id}}" type="text" >
                                    </td>
                                    <td width="10%">
                                        <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input kh_time" id="ngay_hoanthanh_{{$kh_tieuchuan->id}}" type="text" >
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">
                                        <label class="control-label">@lang('project/Selfassessment/title.ghbc'):</label>
                                    </td>
                                    <td width="10%">
                                        <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc" id="tieuchuan_ghbc_bd_{{$kh_tieuchuan->id}}" type="text" value="{{ $keHoachBaoCao->ngay_batdau }}" disabled/>
                                    </td>
                                    <td width="10%">
                                        <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_bc" id="tieuchuan_ghbc_kt_{{$kh_tieuchuan->id}}" type="text" value="{{ $keHoachBaoCao->ngay_hoanthanh }}" disabled/>
                                    </td>
                                    <td width="10%" align="right">
                                        <label class="control-label">@lang('project/Selfassessment/title.khvbc'):&nbsp;</label>
                                    </td>
                                    <td width="10%">
                                        <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input kh_time" id="ngay_batdau_vbc_{{$kh_tieuchuan->id}}" type="text" >
                                    </td>
                                    <td width="10%">
                                        <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input kh_time" id="ngay_hoanthanh_vbc_{{$kh_tieuchuan->id}}" type="text">
                                    </td>
                                </tr>

                            </table>
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="form-group d-flex">
                                    <strong class="control-label">@lang('project/Selfassessment/title.nscb')</strong>
                                    <div class="">
                                        <div class="form-control-static">
                                            <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                            data-target="#nhanSuChuanBiModal_{{$kh_tieuchuan->id}}"  data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                            </button>
                                            <span id="nhanSuChuanBiForm_{{$kh_tieuchuan->id}}"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex">
                                    <strong class="control-label">@lang('project/Selfassessment/title.nsth')</strong>
                                    <div class="">
                                        <div class="form-control-static">
                                            <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                    data-target="#nhanSuThucHienModal_{{$kh_tieuchuan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                            </button>
                                            <span id="nhanSuThucHienForm_{{$kh_tieuchuan->id}}"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex">
                                    <strong class="control-label">@lang('project/Selfassessment/title.nskt')</strong>
                                    <div class="">
                                        <div class="form-control-static">
                                            <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                    data-target="#nhanSuKiemTraModal_{{$kh_tieuchuan->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                            </button>
                                            <span id="nhanSuKiemTraForm_{{$kh_tieuchuan->id}}"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                        <!-- Phân quyền -->
                         {{--   @if(Sentinel::inRole('admin') || Sentinel::inRole('operator') || $kh_tieuchuan->ns_phutrach ==  Sentinel::getUser()->id)
                         --}}
                            <div class="form-group d-flex align-items-center">
                                <label class="control-label">@lang('project/Selfassessment/title.truongnhom')</label>
                                <div class="col-sm-8">
                                    <select name="truongnhom" class="form-control select2_tn" id="truong_nhom_tieuchuan_{{$kh_tieuchuan->id}}">

                                    </select>
                                </div>
                            </div>
                            <!-- <div class="update_all_tieuchuan d-flex align-items-center">
                                <strong>@lang('project/Selfassessment/title.capnhatctc')</strong>
                                <input type="checkbox" id = "checkbox_all_{{$kh_tieuchuan->id}}" onclick="checkbox_tieuchuan({{$kh_tieuchuan->id}})" style="width: 1.3rem;height: 1.3rem;">
                            </div> -->

                            <br>
                            <div class="d-flex justify-content-center">

                                <button type="button" class="btn" onclick="update_tieuchuan({{$kh_tieuchuan->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.capnhat')">
                                    <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                                </button>
                                <button type="button" class="btn btn-warning ml-4" onclick="update_all_tieuchuan({{$kh_tieuchuan->id}})" id="tieuchuan_all_{{$kh_tieuchuan->id}}" style="display: none;">
                                    @lang('project/Selfassessment/title.capnhatctc')
                                </button>
                            </div>
                            <br/>
                        </div>
                    </div>
                    <div id="div_tieuchi{{$kh_tieuchuan->id}}" style="display:none">
                        @foreach($kh_tieuchuan->tieuchi as $tchi)

                            <input type="text" hidden id="tieuchi_id_{{$kh_tieuchuan->id}}" value="{{$tchi->id}}">
                            <div class="part-two-tieuchi part-two-tieuchi_{{$tchi->id}} part-two-tieuchi2_{{$kh_tieuchuan->id}}">
                                <div class="d-flex align-items-center">
                                    <div class="tieuchi ml-4">
                                        @if($khbc->writeFollow == 1 || $khbc->writeFollow == 2)
                                            <button class="btn btn-success button_css" id="div_tieuchi-1{{$tchi->id}}" onclick="showhidemenhde({{$tchi->id}});updatebosung({{$id_kehoach_bc}},{{$kh_tieuchuan->id}},{{$tchi->id}});"><i class="fa fa-plus"></i></button>
                                        @endif

                                        <span style="color:red;">
                                            <i class="far fa-calendar-check" style="color:red;"></i>
                                        </span>

                                        <span style="padding-right: 106px;">
                                            @lang('project/Selfassessment/title.tieuchi') {{$kh_tieuchuan->stt }}.{{ $tchi->stt }}:
                                            <a href="#">{{ $tchi->mo_ta }}</a>

                                            <span class="daVietBaoCao_tieuchi_{{$tchi->id}}" d-id="" d-url="">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </span>


                                    </div>
                                    <button style="" class="btn btn-warning button_css button_lkh bt_tieuchi btn_part_tieuchi2{{$kh_tieuchuan->id}}" id="btn_part_tieuchi{{$tchi->id}}" onclick="showhidepartieuchi({{$tchi->id}},{{$kh_tieuchuan->id}})"><i class="fa fa-plus"></i></button>
                                </div>

                                <div id="div_lkh_part_tieuchi{{$tchi->id}}" class="div_lkh_part_tieuchi2{{$kh_tieuchuan->id}}" style="width: 97%; display: none;">
                                    <br/>
                                    <table style="width: 100%; line-height: 36px;">
                                        <tr>
                                            <td width="10%">
                                                <label class="control-label">@lang('project/Selfassessment/title.ghcb'):</label>
                                            </td>
                                            <td width="10%">
                                                <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc tchi_batdau_chuanbi_{{$kh_tieuchuan->id}}" type="text" disabled/>
                                            </td>
                                            <td width="10%">
                                                <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_bc tchi_hoanthanh_chuanbi_{{$kh_tieuchuan->id}}" type="text" disabled/>
                                            </td>
                                            <td width="10%" align="right">
                                                <label class="control-label">@lang('project/Selfassessment/title.khcb'):&nbsp;</label>
                                            </td>
                                            <td width="10%">
                                                <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input kh_time" id="ngay_chuanbi_tchi{{$tchi->id}}" type="text">
                                            </td>
                                            <td width="10%">
                                                <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input kh_time" id="ngay_hoanthanh_tchi{{$tchi->id}}" type="text" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">
                                                <label class="control-label">@lang('project/Selfassessment/title.ghbc'):</label>
                                            </td>
                                            <td width="10%">
                                                <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc tchi_batdau_bc_{{$kh_tieuchuan->id}}" id="" type="text" disabled/>
                                            </td>
                                            <td width="10%">
                                                <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_bc tchi_hoanthanh_bc_{{$kh_tieuchuan->id}}" id="" type="text" disabled/>
                                            </td>
                                            <td width="10%" align="right">
                                                <label class="control-label">@lang('project/Selfassessment/title.khvbc'):&nbsp;</label>
                                            </td>
                                            <td width="10%">
                                                <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input kh_time" id="ngay_batdau_vbc_tchi{{$tchi->id}}" type="text" >
                                            </td>
                                            <td width="10%">
                                                <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input kh_time" id="ngay_hoanthanh_vbc_tchi{{$tchi->id}}" type="text">
                                            </td>
                                        </tr>

                                    </table>
                                    <br>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-group d-flex">
                                            <strong class="control-label">@lang('project/Selfassessment/title.nscb')</strong>
                                            <div class="">
                                                <div class="form-control-static d-flex align-items-center">
                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                            data-target="#nhanSuChuanBiModal_tchi_{{$tchi->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                    </button>
                                                    <p id="nhanSuChuanBiForm_tchi_{{$tchi->id}}" style="margin: 0;"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex">
                                            <strong class="control-label">@lang('project/Selfassessment/title.nsth')</strong>
                                            <div class="">
                                                <div class="form-control-static d-flex align-items-center">
                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                            data-target="#nhanSuThucHienModal_tchi_{{$tchi->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                    </button>
                                                    <p id="nhanSuThucHienForm_tchi_{{$tchi->id}}" style="margin: 0;"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group d-flex">
                                            <strong class="control-label">@lang('project/Selfassessment/title.nskt')</strong>
                                            <div class="">
                                                <div class="form-control-static d-flex align-items-center">
                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                            data-target="#nhanSuKiemTraModal_tchi_{{$tchi->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                    </button>
                                                    <p id="nhanSuKiemTraForm_tchi_{{$tchi->id}}" style="margin: 0;"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group d-flex">
                                        <label class="control-label">@lang('project/Selfassessment/title.truongnhom')</label>
                                        <div class="col-sm-8">
                                            <select name="truongnhom" id="truong_nhom_tieuchi_{{$tchi->id}}" class="form-control select2 ">

                                            </select>
                                        </div>
                                    </div>
                                   <!--  <div class="d-flex align-items-center">
                                        <strong>@lang('project/Selfassessment/title.capnhatcmdvtc')</strong>
                                        <input type="checkbox" id = "checkbox_tieuchi_{{$tchi->id}}" onclick="checkbox_tieuchi({{$tchi->id}},{{$kh_tieuchuan->id}}) " style="width: 1.3rem;height: 1.3rem;">
                                    </div> -->
                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn" onclick="update_tieuchi({{$tchi->id}},{{$kh_tieuchuan->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.capnhat')">
                                            <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                                        </button>
                                        <button type="button" id="tieuchi_all_{{$tchi->id}}" class="btn btn-warning ml-4" onclick="update_tieuchi_all({{$tchi->id}},{{$kh_tieuchuan->id}})" style="display: none;">
                                            @lang('project/Selfassessment/title.capnhatcmdctcn')
                                        </button>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                            <div id="div_menhde{{$tchi->id}}" style="display:none">
                                @if($khbc->writeFollow == 1)
                                    @foreach($tchi->menhde as $md)
                                            <div class="part-two-menhde_{{$md->id}} part-two-menhde_css part-two-menhde2_{{$kh_tieuchuan->id}} part-two-menhde3_{{$tchi->id}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="menhde ml-5 menhde_css">
                                                        <a href="#">
                                                            @lang('project/Selfassessment/title.chibao') {{ $md->stt }}: {{ $md->mo_ta }}
                                                        </a>

                                                          <span class="daVietBaoCao_menhde_{{$md->id}}" d-id="" d-url="">
                                                                <i class="fas fa-spinner fa-spin"></i>
                                                          </span>
                                                    </div>


                                                    <button style="" class="btn btn-warning button_css button_lkh bt_tieuchi btn_part_menhde2_{{$kh_tieuchuan->id}} btn_part_menhde3_{{$tchi->id}}" id="btn_part_menhde_{{$md->id}}" onclick="showhideparmenhde({{$md->id}},{{$tchi->id}},{{$kh_tieuchuan->id}})"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div id="div_lkh_part_menhde{{$md->id}}" style="width: 97%; display: none; padding-left: 58px ;" class="div_lkh_part_menhde2{{$kh_tieuchuan->id}} div_lkh_part_menhde3{{$tchi->id}}">
                                                    <br/>
                                                    <table style="width: 100%; line-height: 36px;">
                                                        <tr>
                                                            <td width="10%">
                                                                <label class="control-label">@lang('project/Selfassessment/title.ghtg'):</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_md_gh_{{$tchi->id}}" id="gioihan_start_menhde" type="text" disabled/>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_md_gh_{{$tchi->id}}" id="gioihan_end_menhde" type="text" disabled/>
                                                            </td>
                                                            <td width="10%" align="right">
                                                                <label class="control-label">@lang('project/Selfassessment/title.nbd'):&nbsp;</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input ngaybd_menhde_{{$md->id}}" id="ngay_bat_dau" type="text">
                                                            </td>
                                                            <td width="10%" align="right">
                                                                <label class="control-label">@lang('project/Selfassessment/title.ngayht'):</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_menhde_{{$md->id}}" id="ngay_ket_thuc" type="text">
                                                            </td>
                                                        </tr>

                                                    </table>
                                                    <br>
                                                    <div class="d-flex justify-content-around">

                                                        <div class="form-group d-flex">
                                                            <strong class="control-label">@lang('project/Selfassessment/title.nsth')</strong>
                                                            <div class="">
                                                                <div class="form-control-static d-flex align-items-center">
                                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                                            data-target="#nhanSuThucHienModal_menhde_{{$md->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                                    </button>
                                                                    <p id="nhanSuThucHienForm_menhde_{{$md->id}}" style="margin: 0;"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <input type="checkbox" id = "checkbox_menhde_{{$md->id}}" onclick="checkbox_menhde({{$md->id}})"> -->
                                                        <div class="form-group d-flex">
                                                            <strong class="control-label">@lang('project/Selfassessment/title.nskt')</strong>
                                                            <div class="">
                                                                <div class="form-control-static d-flex align-items-center">
                                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                                            data-target="#nhanSuKiemTraModal_menhde_{{$md->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                                    </button>
                                                                    <p id="nhanSuKiemTraForm_menhde_{{$md->id}}" style="margin: 0;"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn" onclick="update_menhde({{$md->id}},{{$tchi->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.capnhat')">
                                                            <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                                                        </button>
                                                    </div>
                                                    <br/>
                                                </div>
                                            </div>

                                            <!-- modal nhân sự thực hiện mệnh đề      -->
                                            <div class="modal inmodal fade" id="nhanSuThucHienModal_menhde_{{$md->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex flex-row-reverse">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                                <span class="sr-only">Close</span>
                                                            </button>
                                                            <h4 class="modal-title">@lang('project/Selfassessment/title.nsth')</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">

                                                                <div class="col-lg-5">
                                                                    <div class="list-group exchangeList_mende_th_{{$md->id}}" data-target="#nhanSuThucHienAll_menhde_{{$md->id}}"
                                                                         id="nhanSuThucHienList_menhde_{{$md->id}}" d-form="#nhanSuThucHienForm_menhde_{{$md->id}}" d-name="ns_thuchien">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 text-center justify-content-center">
                                                                    <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="list-group exchangeList_mende_th_{{$md->id}}" data-target="#nhanSuThucHienList_menhde_{{$md->id}}"
                                                                         id="nhanSuThucHienAll_menhde_{{$md->id}}">


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <!-- modal mệnh đề kiểm tra -->

                                        <div class="modal inmodal fade" id="nhanSuKiemTraModal_menhde_{{$md->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex flex-row-reverse">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">&times;</span>
                                                            <span class="sr-only">Close</span>
                                                        </button>
                                                        <h4 class="modal-title">@lang('project/Selfassessment/title.nskt')</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-lg-5">
                                                                <div class="list-group exchangeList_mende_kt_{{$md->id}}" data-target="#nhanSuKiemTraAll_menhde_{{$md->id}}"
                                                                     id="nhanSuKiemTraList_menhde_{{$md->id}}" d-form="#nhanSuKiemTraForm_menhde_{{$md->id}}" d-name="ns_kiemtra">

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 text-center justify-content-center">
                                                                <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="list-group exchangeList_mende_kt_{{$md->id}}" data-target="#nhanSuKiemTraList_menhde_{{$md->id}}"
                                                                     id="nhanSuKiemTraAll_menhde_{{$md->id}}">



                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif($khbc->writeFollow == 2)
                                    @php $index = 1 @endphp
                                    @foreach($tchi->menhde as $md)
                                            <div class="part-two-menhde_{{$md->id}} part-two-menhde_css part-two-menhde2_{{$kh_tieuchuan->id}} part-two-menhde3_{{$tchi->id}}">
                                                <div class="d-flex align-items-center">
                                                    <div class="menhde ml-5 menhde_css">
                                                        <a href="#">
                                                            @lang('project/Selfassessment/title.mocchuan') {{ $index++}}: {{ $md->mo_ta }}
                                                        </a>

                                                          <span class="daVietBaoCao_menhde_{{$md->id}}" d-id="" d-url="">
                                                                <i class="fas fa-spinner fa-spin"></i>
                                                          </span>
                                                    </div>


                                                    <button style="" class="btn btn-warning button_css button_lkh bt_tieuchi btn_part_menhde2_{{$kh_tieuchuan->id}} btn_part_menhde3_{{$tchi->id}}" id="btn_part_menhde_{{$md->id}}" onclick="showhideparmenhde({{$md->id}},{{$tchi->id}},{{$kh_tieuchuan->id}})"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div id="div_lkh_part_menhde{{$md->id}}" style="width: 97%; display: none; padding-left: 58px ;" class="div_lkh_part_menhde2{{$kh_tieuchuan->id}} div_lkh_part_menhde3{{$tchi->id}}">
                                                    <br/>
                                                    <table style="width: 100%; line-height: 36px;">
                                                        <tr>
                                                            <td width="10%">
                                                                <label class="control-label">@lang('project/Selfassessment/title.ghtg'):</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_md_gh_{{$tchi->id}}" id="gioihan_start_menhde" type="text" disabled/>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_md_gh_{{$tchi->id}}" id="gioihan_end_menhde" type="text" disabled/>
                                                            </td>
                                                            <td width="10%" align="right">
                                                                <label class="control-label">@lang('project/Selfassessment/title.nbd'):&nbsp;</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input ngaybd_menhde_{{$md->id}}" id="ngay_bat_dau" type="text">
                                                            </td>
                                                            <td width="10%" align="right">
                                                                <label class="control-label">@lang('project/Selfassessment/title.ngayht'):</label>
                                                            </td>
                                                            <td width="10%">
                                                                <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input ngayht_menhde_{{$md->id}}" id="ngay_ket_thuc" type="text">
                                                            </td>
                                                        </tr>

                                                    </table>
                                                    <br>
                                                    <div class="d-flex justify-content-around">

                                                        <div class="form-group d-flex">
                                                            <strong class="control-label">@lang('project/Selfassessment/title.nsth')</strong>
                                                            <div class="">
                                                                <div class="form-control-static d-flex align-items-center">
                                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                                            data-target="#nhanSuThucHienModal_menhde_{{$md->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                                    </button>
                                                                    <p id="nhanSuThucHienForm_menhde_{{$md->id}}" style="margin: 0;"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <input type="checkbox" id = "checkbox_menhde_{{$md->id}}" onclick="checkbox_menhde({{$md->id}})"> -->
                                                        <div class="form-group d-flex">
                                                            <strong class="control-label">@lang('project/Selfassessment/title.nskt')</strong>
                                                            <div class="">
                                                                <div class="form-control-static d-flex align-items-center">
                                                                    <button class="btn btn-xs pd-css" data-toggle="modal" type="button"
                                                                            data-target="#nhanSuKiemTraModal_menhde_{{$md->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xemdanhsach')">
                                                                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                                    </button>
                                                                    <p id="nhanSuKiemTraForm_menhde_{{$md->id}}" style="margin: 0;"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" class="btn" onclick="update_menhde({{$md->id}},{{$tchi->id}})" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.capnhat')">
                                                            <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                                                        </button>
                                                    </div>
                                                    <br/>
                                                </div>
                                            </div>

                                            <!-- modal nhân sự thực hiện mệnh đề      -->
                                            <div class="modal inmodal fade" id="nhanSuThucHienModal_menhde_{{$md->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex flex-row-reverse">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                                <span class="sr-only">Close</span>
                                                            </button>
                                                            <h4 class="modal-title">@lang('project/Selfassessment/title.nsth')</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">

                                                                <div class="col-lg-5">
                                                                    <div class="list-group exchangeList_mende_th_{{$md->id}}" data-target="#nhanSuThucHienAll_menhde_{{$md->id}}"
                                                                         id="nhanSuThucHienList_menhde_{{$md->id}}" d-form="#nhanSuThucHienForm_menhde_{{$md->id}}" d-name="ns_thuchien">

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2 text-center justify-content-center">
                                                                    <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="list-group exchangeList_mende_th_{{$md->id}}" data-target="#nhanSuThucHienList_menhde_{{$md->id}}"
                                                                         id="nhanSuThucHienAll_menhde_{{$md->id}}">


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <!-- modal mệnh đề kiểm tra -->

                                        <div class="modal inmodal fade" id="nhanSuKiemTraModal_menhde_{{$md->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex flex-row-reverse">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">&times;</span>
                                                            <span class="sr-only">Close</span>
                                                        </button>
                                                        <h4 class="modal-title">@lang('project/Selfassessment/title.nskt')</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-lg-5">
                                                                <div class="list-group exchangeList_mende_kt_{{$md->id}}" data-target="#nhanSuKiemTraAll_menhde_{{$md->id}}"
                                                                     id="nhanSuKiemTraList_menhde_{{$md->id}}" d-form="#nhanSuKiemTraForm_menhde_{{$md->id}}" d-name="ns_kiemtra">

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-2 text-center justify-content-center">
                                                                <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="list-group exchangeList_mende_kt_{{$md->id}}" data-target="#nhanSuKiemTraList_menhde_{{$md->id}}"
                                                                     id="nhanSuKiemTraAll_menhde_{{$md->id}}">



                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- modal nhân sự chuẩn bị tiêu chí -->
                            <div class="modal inmodal fade" id="nhanSuChuanBiModal_tchi_{{$tchi->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex flex-row-reverse">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">@lang('project/Selfassessment/title.nscb')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_cb{{$tchi->id}}" data-target="#nhanSuChuanBiAll_tchi_{{$tchi->id}}"
                                                         id="nhanSuChuanBiList_tchi_{{$tchi->id}}" d-form="#nhanSuChuanBiForm_tchi_{{$tchi->id}}" d-name="ns_chuanbi">

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 text-center justify-content-center">
                                                    <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_cb{{$tchi->id}}" data-target="#nhanSuChuanBiList_tchi_{{$tchi->id}}"
                                                         id="nhanSuChuanBiAll_tchi_{{$tchi->id}}">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal nhân sự thực hiện -->

                            <div class="modal inmodal fade" id="nhanSuThucHienModal_tchi_{{$tchi->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex flex-row-reverse">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">@lang('project/Selfassessment/title.nsth')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_th{{$tchi->id}}" data-target="#nhanSuThucHienAll_tchi_{{$tchi->id}}"
                                                         id="nhanSuThucHienList_tchi_{{$tchi->id}}" d-form="#nhanSuThucHienForm_tchi_{{$tchi->id}}" d-name="ns_thuchien">

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 text-center justify-content-center">
                                                    <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_th{{$tchi->id}}" data-target="#nhanSuThucHienList_tchi_{{$tchi->id}}"
                                                         id="nhanSuThucHienAll_tchi_{{$tchi->id}}">


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal nhân sự kiểm tra -->

                            <div class="modal inmodal fade" id="nhanSuKiemTraModal_tchi_{{$tchi->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex flex-row-reverse">
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">@lang('project/Selfassessment/title.nskt')</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_kt{{$tchi->id}}" data-target="#nhanSuKiemTraAll_tchi_{{$tchi->id}}"
                                                         id="nhanSuKiemTraList_tchi_{{$tchi->id}}" d-form="#nhanSuKiemTraForm_tchi_{{$tchi->id}}" d-name="ns_kiemtra">

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 text-center justify-content-center">
                                                    <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="list-group exchangeList_tchi_kt{{$tchi->id}}" data-target="#nhanSuKiemTraList_tchi_{{$tchi->id}}"
                                                         id="nhanSuKiemTraAll_tchi_{{$tchi->id}}">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                <!-- modal nhân sự chuẩn bị -->
                <div class="modal inmodal fade" id="nhanSuChuanBiModal_{{$kh_tieuchuan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex flex-row-reverse">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">@lang('project/Selfassessment/title.nscb')</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_cb_tieuchuan exchangeList_cb_{{$kh_tieuchuan->id}}" data-target="#nhanSuChuanBiAll_{{$kh_tieuchuan->id}}"
                                             id="nhanSuChuanBiList_{{$kh_tieuchuan->id}}" d-form="#nhanSuChuanBiForm_{{$kh_tieuchuan->id}}" d-name="ns_chuanbi">

                                        </div>
                                    </div>

                                    <div class="col-lg-2 text-center justify-content-center">
                                        <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_cb_tieuchuan exchangeList_cb_{{$kh_tieuchuan->id}}" data-target="#nhanSuChuanBiList_{{$kh_tieuchuan->id}}"
                                             id="nhanSuChuanBiAll_{{$kh_tieuchuan->id}}">


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal nhân sự thực hiện -->
                <div class="modal inmodal fade" id="nhanSuThucHienModal_{{$kh_tieuchuan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex flex-row-reverse">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">@lang('project/Selfassessment/title.nsth')</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_th_{{$kh_tieuchuan->id}}" data-target="#nhanSuThucHienAll_{{$kh_tieuchuan->id}}"
                                             id="nhanSuThucHienList_{{$kh_tieuchuan->id}}" d-form="#nhanSuThucHienForm_{{$kh_tieuchuan->id}}" d-name="ns_thuchien">

                                        </div>
                                    </div>

                                    <div class="col-lg-2 text-center justify-content-center">
                                        <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                    </div>
                                    <div class="col-lg-5">

                                        <div class="list-group exchangeList_th_{{$kh_tieuchuan->id}}" data-target="#nhanSuThucHienList_{{$kh_tieuchuan->id}}"
                                             id="nhanSuThucHienAll_{{$kh_tieuchuan->id}}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal nhân sự kiểm tra -->
                <div class="modal inmodal fade" id="nhanSuKiemTraModal_{{$kh_tieuchuan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex flex-row-reverse">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">@lang('project/Selfassessment/title.nskt')</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_kt_{{$kh_tieuchuan->id}}" data-target="#nhanSuKiemTraAll_{{$kh_tieuchuan->id}}"
                                             id="nhanSuKiemTraList_{{$kh_tieuchuan->id}}" d-form="#nhanSuKiemTraForm_{{$kh_tieuchuan->id}}" d-name="ns_kiemtra">

                                        </div>
                                    </div>

                                    <div class="col-lg-2 text-center justify-content-center">
                                        <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_kt_{{$kh_tieuchuan->id}}" data-target="#nhanSuKiemTraList_{{$kh_tieuchuan->id}}"
                                             id="nhanSuKiemTraAll_{{$kh_tieuchuan->id}}">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div >
            <div class="part-three" data-toggle="modal" data-target="">
                <span class="label label-primary">
                    <i class="fas fa-edit"></i>
                </span>
                <span>@lang('project/Selfassessment/title.p3')</span>
        </div>
    </div>
</section>

<!-- Khái quát và kết luận -->
<div class="modal fade" id="modalKqKl" tabindex="-1" role="dialog" aria-labelledby="modalKqKlLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex flex-row-reverse">
        <h5 class="modal-title" id="modalKqKlLabel">
            @lang('project/Selfassessment/title.lkhp1p3')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
        @csrf
          <div class="modal-body">
                <p>
                    @lang('project/Selfassessment/title.kehoach'):
                    {{ $khbc->ten_bc }}
                </p>
                <p class="block-flex">
                    @lang('project/Selfassessment/title.ghtg'):
                    <span class="block-flex">
                        <input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input" id="gioihan_start" type="text" value="{{ $keHoachBaoCao->ngay_batdau }}">
                        <input name="gioihan_end" class="start-date ml-3 form-control flatpickr flatpickr-input" id="gioihan_end" type="text" value="{{ $keHoachBaoCao->ngay_hoanthanh }}">
                    </span>
                </p>
                <p class="block-flex">
                    @lang('project/Selfassessment/title.nbd'):
                    <input name="ngay_bat_dau" class="start-date form-control flatpickr flatpickr-input" id="ngay_bat_dau" type="text">
                    <input name="ngay_ket_thuc" class="start-date ml-3 form-control flatpickr flatpickr-input" id="ngay_ket_thuc" type="text">
                </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">
                @lang('project/Selfassessment/title.capnhat')
            </button>
          </div>
        </form>
    </div>
  </div>
</div>
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
    var list_nhansuchuanbi_tieuchuan = {};
    var list_nhansuthuchien_tieuchuan = {};
    var list_nhansukiemtra_tieuchuan = {};
    var list_nhansuchuanbi_tieuchi = {};
    var list_nhansuthuchien_tieuchi = {};
    var list_nhansukiemtra_tieuchi = {};
    var list_nhansuthuchien_menhde = {};
    var list_nhansukiemtra_menhde = {};
    var khbc_id = {{$khbc->id}};
    var listkhtchuan = {};
    var listkhtchi = {};

    function showhidetieuchi(id){
        if($('#btn_tieuchuan' + id).html() == '<i class="fa fa-minus"></i>'){
            $('#div_tieuchi' + id).hide();
            $('#btn_tieuchuan' + id).html('<i class="fa fa-plus"></i>');
        }else{
            $('#div_tieuchi' + id).show();
            $('#btn_tieuchuan' + id).html('<i class="fa fa-minus"></i>');
        }

    }
    function showhidemenhde(id){
        if($('#div_tieuchi-1' + id).html() == '<i class="fa fa-minus"></i>'){
            $('#div_menhde' + id).hide();
            $('#div_tieuchi-1' + id).html('<i class="fa fa-plus"></i>');
        }else{
            $('#div_menhde' + id).show();
            $('#div_tieuchi-1' + id).html('<i class="fa fa-minus"></i>');
        }
    }
    function showhidepartone(){
        if($('#btn_part_one').html() == '<i class="fa fa-minus"></i>'){
            $('#div_lkh_part_one').hide();
            $('#btn_part_one').html('<i class="fa fa-plus"></i>');
        }else{

            $('#div_lkh_part_one').show();
            $('#btn_part_one').html('<i class="fa fa-minus"></i>');
        }
    }

    function load_menhde(data, tieuchi_id){
        listkhtchuan[tieuchi_id] = data.id;
        $('.ngaybd_md_gh_' + tieuchi_id).val(data.ngay_batdau);
        $('.ngayht_md_gh_' + tieuchi_id).val(data.ngay_hoanthanh);
    }


    function load_tieuchuan(data, tieuchuan_id){
        listkhtchuan[tieuchuan_id] = data.id;
        $('#ngay_chuanbi_' + tieuchuan_id).val(data.ngay_batdau_chuanbi);
        $('#ngay_hoanthanh_' + tieuchuan_id).val(data.ngay_hoanthanh_chuanbi);
        $('#ngay_batdau_vbc_' + tieuchuan_id).val(data.ngay_batdau);
        $('#ngay_hoanthanh_vbc_' + tieuchuan_id).val(data.ngay_hoanthanh);
        $('.tchi_batdau_chuanbi_' + tieuchuan_id).val(data.ngay_batdau_chuanbi);
        $('.tchi_hoanthanh_chuanbi_' + tieuchuan_id).val(data.ngay_hoanthanh_chuanbi);
        $('.tchi_batdau_bc_' + tieuchuan_id).val(data.ngay_batdau);
        $('.tchi_hoanthanh_bc_' + tieuchuan_id).val(data.ngay_hoanthanh);

        let truong_nhom = $('#truong_nhom_tieuchuan_'+tieuchuan_id);

        let nhanSuChuanBiAll = $('#nhanSuChuanBiAll_'+tieuchuan_id);
        let nhanSuChuanBiList = $('#nhanSuChuanBiList_'+tieuchuan_id);
        let nhanSuThucHienAll = $('#nhanSuThucHienAll_'+tieuchuan_id);
        let nhanSuThucHienList = $('#nhanSuThucHienList_'+tieuchuan_id);
        let nhanSuKiemTraAll = $('#nhanSuKiemTraAll_'+tieuchuan_id);
        let nhanSuKiemTraList = $('#nhanSuKiemTraList_'+tieuchuan_id);
        nhanSuChuanBiAll.empty();
        nhanSuChuanBiList.empty();
        nhanSuThucHienAll.empty();
        nhanSuThucHienList.empty();
        nhanSuKiemTraAll.empty();
        nhanSuKiemTraList.empty();
        truong_nhom.empty();
        nhanSuChuanBiAll.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.danhsachnhansu')
                                    </li>
                                `
                                );
        nhanSuChuanBiList.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.nscb')
                                    </li>
                                `
                                );
        nhanSuThucHienAll.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.danhsachnhansu')
                                    </li>
                                `
                                );
        nhanSuThucHienList.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.nsth')
                                    </li>
                                `
                                );
        nhanSuKiemTraAll.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.danhsachnhansu')
                                    </li>
                                `
                                );
        nhanSuKiemTraList.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.nsth')
                                    </li>
                                `
                                );

        var truongNhomList = [];
        var id_nhansu_th = [];
        var id_nhansu_kt = [];
        var id_nhansu_cb = [];
        if(data.kh_tieuchuan_id != undefined){
            data.kh_tieuchuan_id.forEach(function(e){
                e.id_nhansuthuchien.forEach(function(e_child){
                    id_nhansu_th.push(e_child.id);
                });
                e.id_nhansukiemtra.forEach(function(e_child){
                    id_nhansu_kt.push(e_child.id);
                });
                e.id_nhansuchuanbi.forEach(function(e_child){
                    id_nhansu_cb.push(e_child.id);
                });

            });
        }

        data.kh_bacao.forEach(function(e){

            e.nhanSuThucHienList.forEach(function(e_child,index){
                if(!truongNhomList.includes(e_child.id)){
                    truongNhomList.push(e_child.id);
                    truong_nhom.append(`
                                        <option value=""></option>
                                        <option value="${e_child.id}" ${(data.truongnhom==e_child.id)?"selected":""}>
                                            ${e_child.name} (${e_child.ten_donvi})
                                        </option>
                                      `);
                }
                if(id_nhansu_th.includes(e_child.id)){
                    nhanSuThucHienAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                     `
                    );
                }else{
                    nhanSuThucHienAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                     `
                    );
                }
            });

            e.nhanSuKiemTraList.forEach(function(e_child,index){
                if(!truongNhomList.includes(e_child.id)){
                    truongNhomList.push(e_child.id);

                    truong_nhom.append(`<option value="${e_child.id}" ${(data.truongnhom==e_child.id)?"selected":""}>
                                            ${e_child.name} (${e_child.ten_donvi})
                                        </option>
                                      `);
                }
                if(id_nhansu_kt.includes(e_child.id)){
                    nhanSuKiemTraAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                    `
                    )
                }else{
                    nhanSuKiemTraAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                    `
                    )
                }

            });

            e.nhanSuChuanBiList.forEach(function(e_child,index){
                if(id_nhansu_cb.includes(e_child.id)){
                    nhanSuChuanBiAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                    `
                    )
                }else{
                    nhanSuChuanBiAll.append(`
                        <a href="javascript:;" d-id="${e_child.id}"
                           class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                            ${e_child.name}
                            <div class="small">${e_child.ten_donvi }</div>
                        </a>
                    `
                    )
                }
            });
        });

        // Nhân sự chuẩn bị
        $('.exchangeList_cb_' + tieuchuan_id + ' a').unbind('click');
        $('.exchangeList_cb_' + tieuchuan_id + ' a').click(function () {
            var target = $(this).parent().attr('data-target');
            var targetForm = $(target).attr('d-form');
            var targetName = $(target).attr('d-name');
            var source = '#' + $(this).parent().attr('id');
            var sourceForm = $(this).parent().attr('d-form');
            var sourceName = $(this).parent().attr('d-name');
            $(target).append($(this));

            if (targetForm != null || targetName != null) {
                $(targetForm).html("");
                var i = 0;
                list_nhansuchuanbi_tieuchuan[tieuchuan_id] = [];
                $(target + ' a').each(function (key) {
                    i++;
                    list_nhansuchuanbi_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(targetForm).append(i + ' nhân sự');
            }

            if (sourceForm != null || sourceName != null) {
                $(sourceForm).html("");
                var i = 0;
                list_nhansuchuanbi_tieuchuan[tieuchuan_id] = [];
                $(source + ' a').each(function (key) {
                    i++;
                    list_nhansuchuanbi_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(sourceForm).append(i + ' nhân sự');
            }
        });

        $('.exchangeList_cb_' + tieuchuan_id + ' a.exchanged').each(function () {
            $(this).trigger('click');
        });

        //Nhân sự thực hiện
        $('.exchangeList_th_' + tieuchuan_id + ' a').unbind('click');
        $('.exchangeList_th_' + tieuchuan_id + ' a').click(function () {
            var target = $(this).parent().attr('data-target');
            var targetForm = $(target).attr('d-form');
            var targetName = $(target).attr('d-name');
            var source = '#' + $(this).parent().attr('id');
            var sourceForm = $(this).parent().attr('d-form');
            var sourceName = $(this).parent().attr('d-name');
            $(target).append($(this));

            if (targetForm != null || targetName != null) {
                $(targetForm).html("");
                var i = 0;
                list_nhansuthuchien_tieuchuan[tieuchuan_id] = [];
                $(target + ' a').each(function (key) {
                    i++;
                    list_nhansuthuchien_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(targetForm).append(i + ' nhân sự');
            }

            if (sourceForm != null || sourceName != null) {
                $(sourceForm).html("");
                var i = 0;
                list_nhansuthuchien_tieuchuan[tieuchuan_id] = [];
                $(source + ' a').each(function (key) {
                    i++;
                    list_nhansuthuchien_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(sourceForm).append(i + ' nhân sự');
            }
        });

        $('.exchangeList_th_' + tieuchuan_id + ' a.exchanged').each(function () {
            $(this).trigger('click');
        });

        //Nhân sự kiểm tra
        $('.exchangeList_kt_' + tieuchuan_id + ' a').unbind('click');
        $('.exchangeList_kt_' + tieuchuan_id + ' a').click(function () {
            var target = $(this).parent().attr('data-target');
            var targetForm = $(target).attr('d-form');
            var targetName = $(target).attr('d-name');
            var source = '#' + $(this).parent().attr('id');
            var sourceForm = $(this).parent().attr('d-form');
            var sourceName = $(this).parent().attr('d-name');
            $(target).append($(this));

            if (targetForm != null || targetName != null) {
                $(targetForm).html("");
                var i = 0;
                list_nhansukiemtra_tieuchuan[tieuchuan_id] = [];
                $(target + ' a').each(function (key) {
                    i++;
                    list_nhansukiemtra_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(targetForm).append(i + ' nhân sự');
            }

            if (sourceForm != null || sourceName != null) {
                $(sourceForm).html("");
                var i = 0;
                list_nhansukiemtra_tieuchuan[tieuchuan_id] = [];
                $(source + ' a').each(function (key) {
                    i++;
                    list_nhansukiemtra_tieuchuan[tieuchuan_id].push($(this).attr('d-id'));
                });
                $(sourceForm).append(i + ' nhân sự');
            }
        });

        $('.exchangeList_kt_' + tieuchuan_id + ' a.exchanged').each(function () {
            $(this).trigger('click');
        });

    }

    function showhidepartwo(tieuchuan_id){

        if($('#div_lkh_part_two'+tieuchuan_id).is(':visible')){
            $('#div_lkh_part_two'+tieuchuan_id).hide();
            $('#btn_part_two_'+tieuchuan_id).html('<i class="fa fa-plus"></i>');
        }else{
            // load du lieu khi mo
            // console.log(tieuchuan_id)
            $.ajax({
                url: "{{route('admin.tudanhgia.report.datadetail')}}",
                type: "POST",
                _token: '{{ csrf_token() }}',
                data:{
                    khbc_id : {{$id_kehoach_bc}},
                    tieuchuan_id : tieuchuan_id,
                },
                error: function(err) {

                },

                success: function(data) {
                    if(data == 0){
                        alert(`@lang('project/Selfassessment/title.danhsachnhansu')`);
                    }else{
                        if(data != undefined){

                            load_tieuchuan(data, tieuchuan_id);
                        }
                    }

                    $('#div_lkh_part_two'+tieuchuan_id).show();
                    $('#btn_part_two_'+tieuchuan_id).html('<i class="fa fa-minus"></i>');
                },
            });
            let tieuchuan_date_gh_bd = $('#tieuchuan_date_gh_bd_' + tieuchuan_id).val();
            let tieuchuan_date_gh_kt = $('#tieuchuan_date_gh_kt_' + tieuchuan_id).val();
            let tieuchuan_ghbc_bd = $('#tieuchuan_ghbc_bd_' + tieuchuan_id).val();
            let tieuchuan_ghbc_kt = $('#tieuchuan_ghbc_kt_' + tieuchuan_id).val();



            $("#ngay_chuanbi_" + tieuchuan_id).flatpickr({
                dateFormat: 'd-m-Y',
                minDate: tieuchuan_date_gh_bd,
                maxDate: tieuchuan_date_gh_kt,
            });

            $("#ngay_hoanthanh_" + tieuchuan_id).flatpickr({
                dateFormat: 'd-m-Y',
                minDate: tieuchuan_date_gh_bd,
                maxDate: tieuchuan_date_gh_kt,
            });

            $("#ngay_batdau_vbc_" + tieuchuan_id).flatpickr({
                dateFormat: 'd-m-Y',
                minDate: tieuchuan_ghbc_bd,
                maxDate: tieuchuan_ghbc_kt,
            });

            $("#ngay_hoanthanh_vbc_" + tieuchuan_id).flatpickr({
                dateFormat: 'd-m-Y',
                minDate: tieuchuan_ghbc_bd,
                maxDate: tieuchuan_ghbc_kt,
            });

        }

    }


    function showhidepartieuchi(tieuchi_id,tieuchuan_id){
        let truong_nhom_tieuchi = $('#truong_nhom_tieuchi_'+tieuchi_id);
        let nhanSuChuanBiAll_tchi = $('#nhanSuChuanBiAll_tchi_'+tieuchi_id);
        let nhanSuThucHienAll_tchi = $('#nhanSuThucHienAll_tchi_'+tieuchi_id);
        let nhanSuKiemTraAll_tchi = $('#nhanSuKiemTraAll_tchi_'+tieuchi_id);
        let nhanSuChuanBiList_tchi = $('#nhanSuChuanBiList_tchi_'+tieuchi_id);
        let nhanSuThucHienList_tchi = $('#nhanSuThucHienList_tchi_'+tieuchi_id);
        let nhanSuKiemTraList_tchi = $('#nhanSuKiemTraList_tchi_'+tieuchi_id);
        var truongnhom_tieuchi = [];


        if($('#div_lkh_part_tieuchi'+tieuchi_id).is(':visible')){
            $('#div_lkh_part_tieuchi'+tieuchi_id).hide();
            $('#btn_part_tieuchi'+tieuchi_id).html('<i class="fa fa-plus"></i>');
            $('.part-two-tieuchi_'+tieuchi_id).css('border-radius','82px');
        }else{
            $.ajax({
                url: "{{route('admin.tudanhgia.report.datadetail')}}",
                type: "POST",
                _token: '{{ csrf_token() }}',
                data:{
                    khbc_id : khbc_id,
                    tieuchuan_id : tieuchuan_id,
                    tieuchi_id: tieuchi_id,
                },
                error: function(err) {

                },

                success: function(data) {
                    nhanSuChuanBiAll_tchi.empty();
                    nhanSuThucHienAll_tchi.empty();
                    nhanSuKiemTraAll_tchi.empty();
                    nhanSuChuanBiList_tchi.empty();
                    nhanSuThucHienList_tchi.empty();
                    nhanSuKiemTraList_tchi.empty();

                    nhanSuChuanBiAll_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.danhsachnhansu')
                                                </li>
                                            `
                                            );

                    nhanSuThucHienAll_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.danhsachnhansu')
                                                </li>
                                            `
                                            );
                    nhanSuKiemTraAll_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.danhsachnhansu')
                                                </li>
                                            `
                                            );
                    nhanSuChuanBiList_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.nscb')
                                                </li>
                                            `
                                            );
                    nhanSuThucHienList_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.nsth')
                                                </li>
                                            `
                                            );

                    nhanSuKiemTraList_tchi.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.nsth')
                                                </li>
                                            `
                                            );
                    if(data == 0){
                        alert(`@lang('project/Selfassessment/title.kcdlkhtchi')`);
                    }else{
                        // console.log(data);
                        load_tieuchuan(data.kh_tieuchuan, tieuchuan_id);
                        listkhtchi[tieuchi_id] = data.id;

                        let tchi_batdau_chuanbi = $('.tchi_batdau_chuanbi_' + tieuchuan_id).val();
                        let tchi_hoanthanh_chuanbi = $('.tchi_hoanthanh_chuanbi_' + tieuchuan_id).val();
                        let tchi_batdau_bc = $('.tchi_batdau_bc_' + tieuchuan_id).val();
                        let tchi_hoanthanh_bc = $('.tchi_hoanthanh_bc_' + tieuchuan_id).val();
                       $("#ngay_chuanbi_tchi" + tieuchi_id).flatpickr({
                            dateFormat: 'd-m-Y',
                            minDate: tchi_batdau_chuanbi,
                            maxDate: tchi_hoanthanh_chuanbi,
                        });

                        $("#ngay_hoanthanh_tchi" + tieuchi_id).flatpickr({
                            dateFormat: 'd-m-Y',
                            minDate: tchi_batdau_chuanbi,
                            maxDate: tchi_hoanthanh_chuanbi,
                        });

                        $("#ngay_batdau_vbc_tchi" + tieuchi_id).flatpickr({
                            dateFormat: 'd-m-Y',
                            minDate: tchi_batdau_bc,
                            maxDate: tchi_hoanthanh_bc,
                        });

                        $("#ngay_hoanthanh_vbc_tchi" + tieuchi_id).flatpickr({
                            dateFormat: 'd-m-Y',
                            minDate: tchi_batdau_bc,
                            maxDate: tchi_hoanthanh_bc,
                        });
                        $('#ngay_chuanbi_tchi' + tieuchi_id).val(data.ngay_batdau_chuanbi);
                        $('#ngay_hoanthanh_tchi' + tieuchi_id).val(data.ngay_hoanthanh_chuanbi);
                        $('#ngay_batdau_vbc_tchi' + tieuchi_id).val(data.ngay_batdau);
                        $('#ngay_hoanthanh_vbc_tchi' + tieuchi_id).val(data.ngay_hoanthanh);



                        truong_nhom_tieuchi.empty();
                        let id_nsth_tieuchi = [];
                        let id_nsth_kiemtra = [];
                        let id_nsth_chuanbi = [];
                        data.kh_tieuchi_id.forEach(function(e){
                            e.id_nhansuthuchien.forEach(function(e_child){
                                id_nsth_tieuchi.push(e_child.id);
                            })
                            e.id_nhansukiemtra.forEach(function(e_child){
                                id_nsth_kiemtra.push(e_child.id);
                            })
                            e.id_nhansuchuanbi.forEach(function(e_child){
                                id_nsth_chuanbi.push(e_child.id);
                            })
                        })
                        data.kh_tieuchi.forEach(function(e){
                                e.nhanSuThucHienList.forEach(function(e_child){
                                    if(!truongnhom_tieuchi.includes(e_child.id)){
                                        truongnhom_tieuchi.push(e_child.id);
                                        truong_nhom_tieuchi.append(`
                                                                    <option value=""></option>
                                                                    <option value="${e_child.id}" ${(data.truongnhom==e_child.id)?"selected":""}>
                                                                        ${e_child.name} (${e_child.ten_donvi})
                                                                    </option>
                                                                `);
                                    }
                                    if(id_nsth_tieuchi.includes(e_child.id)){
                                        nhanSuThucHienAll_tchi.append(`
                                                                <a href="javascript:;" d-id="${e_child.id}"
                                                                   class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                                                                    ${e_child.name}
                                                                    <div class="small">${e_child.ten_donvi }</div>
                                                                </a>
                                                             `)
                                    }else{
                                        nhanSuThucHienAll_tchi.append(`
                                                                <a href="javascript:;" d-id="${e_child.id}"
                                                                   class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                                                                    ${e_child.name}
                                                                    <div class="small">${e_child.ten_donvi }</div>
                                                                </a>
                                                             `)
                                    }

                                });
                                e.nhanSuKiemTraList.forEach(function(e_child){
                                    if(!truongnhom_tieuchi.includes(e_child.id)){
                                        truongnhom_tieuchi.push(e_child.id);
                                        truong_nhom_tieuchi.append(`
                                                                    <option value=""></option>
                                                                    <option value="${e_child.id}" ${(data.truongnhom==e_child.id)?"selected":""}>
                                                                        ${e_child.name} (${e_child.ten_donvi})
                                                                    </option>
                                                                `);

                                    }

                                    if(id_nsth_kiemtra.includes(e_child.id)){
                                        nhanSuKiemTraAll_tchi.append(`
                                                                    <a href="javascript:;" d-id="${e_child.id}"
                                                                       class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                                                                        ${e_child.name}
                                                                        <div class="small">${e_child.ten_donvi }</div>
                                                                    </a>
                                                                `)
                                    }else{
                                        nhanSuKiemTraAll_tchi.append(`
                                                                    <a href="javascript:;" d-id="${e_child.id}"
                                                                       class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                                                                        ${e_child.name}
                                                                        <div class="small">${e_child.ten_donvi }</div>
                                                                    </a>
                                                                `)
                                    }

                                });
                                e.nhanSuChuanBiList.forEach(function(e_child){

                                    if(id_nsth_chuanbi.includes(e_child.id)){
                                        nhanSuChuanBiAll_tchi.append(`
                                                                    <a href="javascript:;" d-id="${e_child.id}"
                                                                       class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                                                                        ${e_child.name}
                                                                        <div class="small">${e_child.ten_donvi }</div>
                                                                    </a>
                                                                `)
                                    }else{
                                        nhanSuChuanBiAll_tchi.append(`
                                                                    <a href="javascript:;" d-id="${e_child.id}"
                                                                       class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                                                                        ${e_child.name}
                                                                        <div class="small">${e_child.ten_donvi }</div>
                                                                    </a>
                                                                `)
                                    }

                                });
                        });
                    }
                    $('#div_lkh_part_two'+tieuchi_id).show();
                    $('#btn_part_two_'+tieuchi_id).html('<i class="fa fa-minus"></i>');
                    // Nhân sự chuẩn bị
                    $('.exchangeList_tchi_cb' + tieuchi_id + ' a').unbind('click');
                    $('.exchangeList_tchi_cb'+ tieuchi_id + ' a').on('click', function () {
                        var target = $(this).parent().attr('data-target');
                        var targetForm = $(target).attr('d-form');
                        var targetName = $(target).attr('d-name');
                        var source = '#' + $(this).parent().attr('id');
                        var sourceForm = $(this).parent().attr('d-form');
                        var sourceName = $(this).parent().attr('d-name');
                        $(target).append($(this));
                        if (targetForm != null || targetName != null) {
                            $(targetForm).html("");

                            var i = 0;
                            list_nhansuchuanbi_tieuchi[tieuchi_id] = [];
                            list_nhansuchuanbi_tieuchi[tieuchi_id].splice(0,list_nhansuchuanbi_tieuchi[tieuchi_id].length);
                            $(target + ' a').each(function (key) {
                                i++;
                             list_nhansuchuanbi_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(targetForm).append(i + ' nhân sự');
                        }

                        if (sourceForm != null || sourceName != null) {
                            $(sourceForm).html("");
                            var i = 0;
                            list_nhansuchuanbi_tieuchi[tieuchi_id] = [];
                            list_nhansuchuanbi_tieuchi[tieuchi_id].splice(0,list_nhansuchuanbi_tieuchi[tieuchi_id].length);
                            $(source + ' a').each(function (key) {
                                i++;

                                list_nhansuchuanbi_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(sourceForm).append(i + ' nhân sự');
                        }

                    });


                    $('.exchangeList_tchi_cb'+tieuchi_id+' a.exchanged').each(function () {
                        $(this).trigger('click');
                    });

                    // Nhân sự thực hiện

                    $('.exchangeList_tchi_th' + tieuchi_id + ' a').unbind('click');
                    $('.exchangeList_tchi_th'+ tieuchi_id + ' a').on('click', function () {
                        var target = $(this).parent().attr('data-target');
                        var targetForm = $(target).attr('d-form');
                        var targetName = $(target).attr('d-name');
                        var source = '#' + $(this).parent().attr('id');
                        var sourceForm = $(this).parent().attr('d-form');
                        var sourceName = $(this).parent().attr('d-name');
                        $(target).append($(this));
                        if (targetForm != null || targetName != null) {
                            $(targetForm).html("");

                            var i = 0;
                            list_nhansuthuchien_tieuchi[tieuchi_id] = [];
                            $(target + ' a').each(function (key) {
                                i++;
                                $(targetForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + targetName + '[]">');
                             list_nhansuthuchien_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(targetForm).append(i + ' nhân sự');
                        }

                        if (sourceForm != null || sourceName != null) {
                            $(sourceForm).html("");
                            var i = 0;
                            list_nhansuthuchien_tieuchi[tieuchi_id] = [];
                            $(source + ' a').each(function (key) {
                                i++;
                                $(sourceForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + sourceName + '[]">');

                            list_nhansuthuchien_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(sourceForm).append(i + ' nhân sự');
                        }

                    });


                    $('.exchangeList_tchi_th' + tieuchi_id + ' a.exchanged').each(function () {
                        $(this).trigger('click');
                    });


                     // Nhân sự kiểm tra

                    $('.exchangeList_tchi_kt' + tieuchi_id + ' a').unbind('click');
                    $('.exchangeList_tchi_kt'+ tieuchi_id + ' a').on('click', function () {
                        var target = $(this).parent().attr('data-target');
                        var targetForm = $(target).attr('d-form');
                        var targetName = $(target).attr('d-name');
                        var source = '#' + $(this).parent().attr('id');
                        var sourceForm = $(this).parent().attr('d-form');
                        var sourceName = $(this).parent().attr('d-name');
                        $(target).append($(this));
                        if (targetForm != null || targetName != null) {
                            $(targetForm).html("");

                            var i = 0;
                            list_nhansukiemtra_tieuchi[tieuchi_id] = [];
                            $(target + ' a').each(function (key) {
                                i++;
                                $(targetForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + targetName + '[]">');
                             list_nhansukiemtra_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(targetForm).append(i + ' nhân sự');
                        }

                        if (sourceForm != null || sourceName != null) {
                            $(sourceForm).html("");
                            var i = 0;
                            list_nhansukiemtra_tieuchi[tieuchi_id] = [];
                            $(source + ' a').each(function (key) {
                                i++;
                                $(sourceForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + sourceName + '[]">');

                            list_nhansukiemtra_tieuchi[tieuchi_id].push($(this).attr('d-id'));
                            });
                            $(sourceForm).append(i + ' nhân sự');
                        }

                    });


                    $('.exchangeList_tchi_kt' + tieuchi_id + ' a.exchanged').each(function () {
                        $(this).trigger('click');
                    });
                    // Nhân sự kiểm tra

                },
            });

            $('#div_lkh_part_tieuchi'+tieuchi_id).show();
            $('#btn_part_tieuchi'+tieuchi_id).html('<i class="fa fa-minus"></i>');
            $('.part-two-tieuchi_'+tieuchi_id).css('border-radius','25px');
        }


    }

    function showhideparmenhde(menhde_id,tieuchi_id,tieuchuan_id){
        let nhanSuThucHienAll_menhde = $('#nhanSuThucHienAll_menhde_'+menhde_id);
        let nhanSuThucHienList_menhde = $('#nhanSuThucHienList_menhde_'+menhde_id);
        let nhanSuKiemTraAll_menhde = $('#nhanSuKiemTraAll_menhde_'+menhde_id);
        let nhanSuKiemTraList_menhde = $('#nhanSuKiemTraList_menhde_'+menhde_id);
        if($('#div_lkh_part_menhde'+menhde_id).is(':visible')){
            $('#div_lkh_part_menhde'+menhde_id).hide();
            $('#btn_part_menhde_'+menhde_id).html('<i class="fa fa-plus"></i>');
            $('.part-two-menhde_'+menhde_id).css('border-radius','82px');
        }else{

            $.ajax({
                url: "{{route('admin.tudanhgia.report.datadetail')}}",
                type: "POST",
                data:{
                    menhde_id : menhde_id,
                    tieuchi_id : tieuchi_id,
                    tieuchuan_id : tieuchuan_id,
                    khbc_id : khbc_id,
                    _token: '{{ csrf_token() }}',

                },
                error: function(err) {

                },

                success: function(data) {
                    nhanSuThucHienAll_menhde.empty();
                    nhanSuThucHienList_menhde.empty();
                    nhanSuKiemTraAll_menhde.empty();
                    nhanSuKiemTraList_menhde.empty();

                    nhanSuThucHienAll_menhde.append(`
                                    <li class="list-group-item active font-bold">
                                        @lang('project/Selfassessment/title.danhsachnhansu')
                                    </li>
                                `
                                );

                    nhanSuKiemTraAll_menhde.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.danhsachnhansu')
                                                </li>
                                            `
                                            );

                    nhanSuThucHienList_menhde.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.nsth')
                                                </li>
                                            `
                                            );

                    nhanSuKiemTraList_menhde.append(`
                                                <li class="list-group-item active font-bold">
                                                    @lang('project/Selfassessment/title.nsth')
                                                </li>
                                            `
                                            );

                    if(data == 0){
                        alert(`@lang('project/Selfassessment/title.kcdlkhmenhde')`);
                    }else{
                        var id_nsth_menhde = [];
                        var id_nsth_kiemtra = [];

                        // console.log(data);
                        data.kh_menhde_id.forEach(function(e){
                            e.id_nhansuthuchien.forEach(function(e_child){
                                id_nsth_menhde.push(e_child.id);
                            });

                            e.id_nhansukiemtra.forEach(function(e_child){
                                id_nsth_kiemtra.push(e_child.id);
                            });
                        })
                        $('.ngaybd_menhde_'+menhde_id).val(data.ngay_batdau);
                        $('.ngayht_menhde_'+menhde_id).val(data.ngay_hoanthanh);

                        load_menhde(data.ke_hoach_tieuchi,tieuchi_id);
                        // console.log(data)
                        for (var i = 0; i < data.ke_hoach_bcns.length; i++) {
                            var e = data.ke_hoach_bcns[i];
                            for (var j = 0; j < e.nhanSuThucHienList.length; j++) {
                                var f = e.nhanSuThucHienList[j];

                                if(id_nsth_menhde.includes(f.id)){
                                    nhanSuThucHienAll_menhde.append(`<a href="javascript:;" d-id="${f.id}"
                                                                   class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                                                                    ${f.name}
                                                                    <div class="small">${f.ten_donvi }</div>
                                                                </a>`
                                                                );
                                }else{
                                    nhanSuThucHienAll_menhde.append(`<a href="javascript:;" d-id="${f.id}"
                                                                   class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                                                                    ${f.name}
                                                                    <div class="small">${f.ten_donvi }</div>
                                                                </a>`
                                                                );
                                }

                            }
                            for (var k = 0; k < e.nhanSuKiemTraList.length; k++) {
                                var h = e.nhanSuKiemTraList[k];

                                if(id_nsth_kiemtra.includes(h.id)){
                                    nhanSuKiemTraAll_menhde.append(`<a href="javascript:;" d-id="${h.id}"
                                                                   class="list-group-item exchanged nhanSuChuanBiItem click_tieuchuan">
                                                                    ${h.name}
                                                                    <div class="small">${h.ten_donvi }</div>
                                                                </a>`
                                                                );
                                }else{
                                    nhanSuKiemTraAll_menhde.append(`<a href="javascript:;" d-id="${h.id}"
                                                                   class="list-group-item nhanSuChuanBiItem click_tieuchuan">
                                                                    ${h.name}
                                                                    <div class="small">${h.ten_donvi }</div>
                                                                </a>`
                                                                );
                                }

                            }
                        }

                    }
                    // Mệnh đề thực hiện
                    $('.exchangeList_mende_th_' + menhde_id + ' a').unbind('click');
                    $('.exchangeList_mende_th_'+ menhde_id + ' a').on('click', function () {
                        var target = $(this).parent().attr('data-target');
                        var targetForm = $(target).attr('d-form');
                        var targetName = $(target).attr('d-name');
                        var source = '#' + $(this).parent().attr('id');
                        var sourceForm = $(this).parent().attr('d-form');
                        var sourceName = $(this).parent().attr('d-name');
                        $(target).append($(this));
                        if (targetForm != null || targetName != null) {
                            $(targetForm).html("");

                            var i = 0;
                            list_nhansuthuchien_menhde[menhde_id] = [];
                            // list_nhansuthuchien_tieuchi[tieuchi_id].splice(0,list_nhansuthuchien_tieuchi[tieuchi_id].length);
                            $(target + ' a').each(function (key) {
                                i++;
                                $(targetForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + targetName + '[]">');
                             list_nhansuthuchien_menhde[menhde_id].push($(this).attr('d-id'));
                            });
                            $(targetForm).append(i + ' nhân sự');
                        }

                        if (sourceForm != null || sourceName != null) {
                            $(sourceForm).html("");
                            var i = 0;
                            list_nhansuthuchien_menhde[menhde_id] = [];
                            // list_nhansuthuchien_menhde[tieuchi_id].splice(0,list_nhansuthuchien_menhde[tieuchi_id].length);
                            $(source + ' a').each(function (key) {
                                i++;
                                $(sourceForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + sourceName + '[]">');

                            list_nhansuthuchien_menhde[menhde_id].push($(this).attr('d-id'));
                            });
                            $(sourceForm).append(i + ' nhân sự');
                        }

                    });


                    $('.exchangeList_mende_th_' + menhde_id + ' a.exchanged').each(function () {
                        $(this).trigger('click');
                    });
                        // Mệnh đề kiểm tra
                    $('.exchangeList_mende_kt_' + menhde_id + ' a').unbind('click');
                    $('.exchangeList_mende_kt_'+ menhde_id + ' a').on('click', function () {
                        var target = $(this).parent().attr('data-target');
                        var targetForm = $(target).attr('d-form');
                        var targetName = $(target).attr('d-name');
                        var source = '#' + $(this).parent().attr('id');
                        var sourceForm = $(this).parent().attr('d-form');
                        var sourceName = $(this).parent().attr('d-name');
                        $(target).append($(this));
                        if (targetForm != null || targetName != null) {
                            $(targetForm).html("");

                            var i = 0;
                            list_nhansukiemtra_menhde[menhde_id] = [];
                            $(target + ' a').each(function (key) {
                                i++;
                                $(targetForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + targetName + '[]">');
                             list_nhansukiemtra_menhde[menhde_id].push($(this).attr('d-id'));
                            });
                            $(targetForm).append(i + ' nhân sự');
                        }

                        if (sourceForm != null || sourceName != null) {
                            $(sourceForm).html("");
                            var i = 0;
                            list_nhansukiemtra_menhde[menhde_id] = [];
                            $(source + ' a').each(function (key) {
                                i++;
                                $(sourceForm).append('<input type="hidden" value="' + $(this).attr('d-id') + '" ' +
                                    'name="' + sourceName + '[]">');

                            list_nhansukiemtra_menhde[menhde_id].push($(this).attr('d-id'));
                            });
                            $(sourceForm).append(i + ' nhân sự');
                        }

                    });


                    $('.exchangeList_mende_kt_' + menhde_id + ' a.exchanged').each(function () {
                        $(this).trigger('click');
                    });
                }

            });

            setTimeout(function(){
                let ngaybd_md_gh = $('.ngaybd_md_gh_' + tieuchi_id).val();
                let ngayht_md_gh = $('.ngayht_md_gh_' + tieuchi_id).val();

                $(".ngaybd_menhde_" + menhde_id).flatpickr({
                    dateFormat: 'd-m-Y',
                    minDate: ngaybd_md_gh,
                    maxDate: ngayht_md_gh,
                });
                $(".ngayht_menhde_" + menhde_id).flatpickr({
                    dateFormat: 'd-m-Y',
                    minDate: ngaybd_md_gh,
                    maxDate: ngayht_md_gh,
                });
            },2000);

            $('#div_lkh_part_menhde'+menhde_id).show();
            $('#btn_part_menhde_'+menhde_id).html('<i class="fa fa-minus"></i>');
            $('.part-two-menhde_'+menhde_id).css('border-radius','25px');


        }

    }

    function update_khaiquat(){
        let id_khbc = {{ $keHoachBaoCao->id }};
        let ngay_batdau_chung = $('.ngaybd_chung').val();
        let ngay_hoanthanh_chung = $('.ngayht_chung').val();

        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_kq')}}",
                type: "GET",
                data:{
                    id_khbc : id_khbc,
                    ngay_batdau_chung : ngay_batdau_chung,
                    ngay_hoanthanh_chung : ngay_hoanthanh_chung,
                },
                error: function(err) {

                },

                success: function(data) {
                    if(data == 1){
                        $('#div_lkh_part_one').hide();
                        $('#btn_part_one').html('<i class="fa fa-plus"></i>');
                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);
                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }


                },
        });
    }

    function update_tieuchuan(tc_id){
        let id_tieuchuan = tc_id;
        let id_khbc = {{ $keHoachBaoCao->id }};
        let ngay_chuanbi = $('#ngay_chuanbi_'+tc_id).val();
        let ngay_hoanthanh = $('#ngay_hoanthanh_'+tc_id).val();
        let ngay_batdau_vbc = $('#ngay_batdau_vbc_'+tc_id).val();
        let ngay_hoanthanh_vbc = $('#ngay_hoanthanh_vbc_'+tc_id).val();
        let truong_nhom = $('#truong_nhom_tieuchuan_'+tc_id).val();
        let arr_cb = list_nhansuchuanbi_tieuchuan[tc_id] != undefined ? list_nhansuchuanbi_tieuchuan[tc_id].join(',') : [];
        let arr_th = list_nhansuthuchien_tieuchuan[tc_id] != undefined ? list_nhansuthuchien_tieuchuan[tc_id].join(',') : [];
        let arr_kt = list_nhansukiemtra_tieuchuan[tc_id] != undefined ? list_nhansukiemtra_tieuchuan[tc_id].join(',') : [];
        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_tieuchuan')}}",
                type: "GET",
                data:{
                    ngay_chuanbi : ngay_chuanbi,
                    ngay_hoanthanh : ngay_hoanthanh,
                    ngay_batdau_vbc : ngay_batdau_vbc,
                    ngay_hoanthanh_vbc : ngay_hoanthanh_vbc,
                    id_tieuchuan : id_tieuchuan,
                    id_khbc : id_khbc,
                    truong_nhom : truong_nhom,
                    nhansuchuanbi : arr_cb,
                    nhansuthuchien : arr_th,
                    nhansukiemtra : arr_kt,
                },
                error: function(err) {

                },

                success: function(data) {
                    if(data == 1){
                        $('#div_lkh_part_two'+tc_id).hide();
                        $('#btn_part_two_'+tc_id).html('<i class="fa fa-plus"></i>');

                        $('.div_lkh_part_tieuchi2'+tc_id).hide();
                        $('.btn_part_tieuchi2'+tc_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-tieuchi2_'+tc_id).css('border-radius','82px');

                        $('.div_lkh_part_menhde2'+tc_id).hide();
                        $('.btn_part_menhde2_'+tc_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-menhde2_'+tc_id).css('border-radius','82px');
                        check_start();
                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);

                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }


                },
        })
    }
    function checkbox_tieuchuan(a){
       let check =  $("#checkbox_all_"+a);
            if(check.is(':checked')){
                $("#tieuchuan_all_"+a).css('display','block');
            }else{
                $("#tieuchuan_all_"+a).css('display','none');
            }

    }
    function checkbox_tieuchi(a,b){
       let check =  $("#checkbox_tieuchi_"+a);
            if(check.is(':checked')){
                $("#tieuchi_all_"+a).css('display','block');
            }else{
                $("#tieuchi_all_"+a).css('display','none');
            }

    }

    function update_all_tieuchuan(tieuchuan_id){
        let id_tieuchuan = tieuchuan_id;
        let id_tieuchi = $('#tieuchi_id_'+tieuchuan_id).val();
        let id_khbc = {{ $keHoachBaoCao->id }};
        let ngay_chuanbi = $('#ngay_chuanbi_'+tieuchuan_id).val();
        let ngay_hoanthanh = $('#ngay_hoanthanh_'+tieuchuan_id).val();
        let ngay_batdau_vbc = $('#ngay_batdau_vbc_'+tieuchuan_id).val();
        let ngay_hoanthanh_vbc = $('#ngay_hoanthanh_vbc_'+tieuchuan_id).val();
        let truong_nhom = $('#truong_nhom_tieuchuan_'+tieuchuan_id).val();
        let option = 1;
        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_tieuchuan')}}",
                type: "GET",
                data:{
                    ngay_chuanbi : ngay_chuanbi,
                    ngay_hoanthanh : ngay_hoanthanh,
                    ngay_batdau_vbc : ngay_batdau_vbc,
                    ngay_hoanthanh_vbc : ngay_hoanthanh_vbc,
                    id_tieuchuan : id_tieuchuan,
                    id_khbc : id_khbc,
                    truong_nhom : truong_nhom,
                    option : option,
                    id_tieuchi : id_tieuchi,
                },
                error: function(err) {

                },

                success: function(data) {
                    if(data == 1){
                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);
                        $('#div_lkh_part_two'+tieuchuan_id).hide();
                        $('#btn_part_two_'+tieuchuan_id).html('<i class="fa fa-plus"></i>');

                        $('.div_lkh_part_tieuchi2'+tieuchuan_id).hide();
                        $('.btn_part_tieuchi2'+tieuchuan_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-tieuchi2_'+tieuchuan_id).css('border-radius','82px');

                        $('.div_lkh_part_menhde2'+tieuchuan_id).hide();
                        $('.btn_part_menhde2_'+tieuchuan_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-menhde2_'+tieuchuan_id).css('border-radius','82px');
                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }

                },
        })
    }

    $(".select2_tn").select2({
        placeholder: "@lang('project/Selfassessment/title.nscb')"
    });


    var list_tieuchuan = [
        @foreach($listTc as $kh_tieuchuan)
            {{ $kh_tieuchuan->id }},
        @endforeach
    ];

    $('.exchangeListSearch').on('keyup', function () {
        var search = $(this).val().toLowerCase();
        // console.log(search);
        var targetElement = $($(this).attr('data-target'));
        targetElement.removeClass('hidden');
        $.each(targetElement, function (index, value) {
            var text = $.trim($(this).text().toLowerCase());
            var check = text.indexOf(search);

            //alert(text);
            if (check == -1) {
                $(this).addClass('hidden');
            } else {

            }
        });
    });

    function check_start(){
        $.ajax({
                url: "{{route('admin.tudanhgia.report.star_tieuchuan')}}?id={{$id_kehoach_bc}}&botieuchuan={{$khbc->bo_tieuchuan_id}}",
                type: "GET",
                error: function(err) {

                },

                success: function(data) {
                    var tieuchuan = data[0];
                    var tieuchi = data[1];
                    var menhde = data[2];

                    for(var i = 0;i < tieuchuan.length;i++){

                        if(tieuchuan[i][1] == 1){

                            $('.daVietBaoCao_' + tieuchuan[i][0]).html('<i class="fas fa-star text-danger" data-toggle="tooltip"\n' +
                                'title="Đã được lên kết hoạch"></i>');
                        }else{
                            $('.daVietBaoCao_' + tieuchuan[i][0]).html('<i class="fas fa-star text-muted" data-toggle="tooltip"' +
                                'title="Chưa được lên kết hoạch"></i>');
                        }
                    }

                    for(var i = 0;i < tieuchi.length;i++){
                        if(tieuchi[i][1] == 1){
                            $('.daVietBaoCao_tieuchi_' + tieuchi[i][0]).html('<i class="fas fa-star text-danger" data-toggle="tooltip"\n' +
                                'title="Đã được lên kết hoạch"></i>');
                        }else{
                            $('.daVietBaoCao_tieuchi_' + tieuchi[i][0]).html('<i class="fas fa-star text-muted" data-toggle="tooltip"' +
                                'title="Chưa được lên kết hoạch"></i>');
                        }
                    }

                    for(var i = 0;i < menhde.length;i++){

                        if(menhde[i][1] == 1){
                            $('.daVietBaoCao_menhde_' + menhde[i][0]).html('<i class="fas fa-star text-danger" data-toggle="tooltip"\n' +
                                'title="Đã được lên kết hoạch"></i>');
                            // console.log( menhde[i][0])

                        }else{
                            $('.daVietBaoCao_menhde_' + menhde[i][0]).html('<i class="fas fa-star text-muted" data-toggle="tooltip"' +
                                'title="Chưa được lên kết hoạch"></i>');
                            // console.log('g')
                        }
                    }
                },
        });
    }
    $(function () {
        check_start();
       let ngay_bd = $('#gioihan_start').val();
       let ngay_kt = $('#gioihan_end').val();
        $("#ngay_bat_dau").flatpickr({
            dateFormat: 'd-m-Y',
            minDate: ngay_bd,
            maxDate: ngay_kt,
        });
        $("#ngay_ket_thuc").flatpickr({
            dateFormat: 'd-m-Y',
            minDate: ngay_bd,
            maxDate: ngay_kt,
        });
    });

    function update_tieuchi(tieuchi_id,tieuchuan_id){
        let id_tieuchi = tieuchi_id;
        let id_kh_tieuchuan = listkhtchuan[tieuchuan_id];
        let ngay_chuanbi_tchi = $('#ngay_chuanbi_tchi'+tieuchi_id).val();
        let ngay_hoanthanh_tchi = $('#ngay_hoanthanh_tchi'+tieuchi_id).val();
        let ngay_batdau_vbc_tchi = $('#ngay_batdau_vbc_tchi'+tieuchi_id).val();
        let ngay_hoanthanh_vbc_tchi = $('#ngay_hoanthanh_vbc_tchi'+tieuchi_id).val();
        let truong_nhom = $('#truong_nhom_tieuchi_'+tieuchi_id).val();
        let arr_cb_tieuchi = list_nhansuchuanbi_tieuchi[tieuchi_id] != undefined ? list_nhansuchuanbi_tieuchi[tieuchi_id].join(',') : [];
        let arr_th_tieuchi = list_nhansuthuchien_tieuchi[tieuchi_id] != undefined ? list_nhansuthuchien_tieuchi[tieuchi_id].join(',') : [];
        let arr_kt_tieuchi = list_nhansukiemtra_tieuchi[tieuchi_id] != undefined ? list_nhansukiemtra_tieuchi[tieuchi_id].join(',') : [];
        let id_khbc = {{ $keHoachBaoCao->id }};
        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_tieuchi')}}",
                type: "GET",
                data:{
                    ngay_chuanbi_tchi : ngay_chuanbi_tchi,
                    ngay_hoanthanh_tchi : ngay_hoanthanh_tchi,
                    ngay_batdau_vbc_tchi : ngay_batdau_vbc_tchi,
                    ngay_hoanthanh_vbc_tchi : ngay_hoanthanh_vbc_tchi,
                    id_tieuchi : id_tieuchi,
                    id_kh_tieuchuan : id_kh_tieuchuan,
                    truong_nhom : truong_nhom,
                    nhansuchuanbi : arr_cb_tieuchi,
                    nhansuthuchien : arr_th_tieuchi,
                    nhansukiemtra : arr_kt_tieuchi,
                    id_khbc : id_khbc,
                },
                error: function(err) {

                },

                success: function(data) {
                    if(data ==1){
                        $('#div_lkh_part_tieuchi'+tieuchi_id).hide();
                        $('#btn_part_tieuchi'+tieuchi_id).html('<i class="fa fa-plus"></i>');

                        $('.div_lkh_part_menhde3'+tieuchi_id).hide();
                        $('.btn_part_menhde3_'+tieuchi_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-menhde3_'+tieuchi_id).css('border-radius','82px');
                        check_start();
                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);
                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }

                },
        });
    }

    function update_tieuchi_all(tieuchi_id,tieuchuan_id){
        let id_tieuchi = tieuchi_id;
        let id_kh_tieuchuan = listkhtchuan[tieuchuan_id];
        let ngay_chuanbi_tchi = $('#ngay_chuanbi_tchi'+tieuchi_id).val();
        let ngay_hoanthanh_tchi = $('#ngay_hoanthanh_tchi'+tieuchi_id).val();
        let ngay_batdau_vbc_tchi = $('#ngay_batdau_vbc_tchi'+tieuchi_id).val();
        let ngay_hoanthanh_vbc_tchi = $('#ngay_hoanthanh_vbc_tchi'+tieuchi_id).val();
        let truong_nhom = $('#truong_nhom_tieuchi_'+tieuchi_id).val();
        let option = 1;
        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_tieuchi')}}",
                type: "GET",
                data:{
                    ngay_chuanbi_tchi : ngay_chuanbi_tchi,
                    ngay_hoanthanh_tchi : ngay_hoanthanh_tchi,
                    ngay_batdau_vbc_tchi : ngay_batdau_vbc_tchi,
                    ngay_hoanthanh_vbc_tchi : ngay_hoanthanh_vbc_tchi,
                    id_tieuchi : id_tieuchi,
                    id_kh_tieuchuan : id_kh_tieuchuan,
                    truong_nhom : truong_nhom,
                    option : option,
                },
                error: function(err) {

                },

                success: function(data) {

                    if(data == 1){

                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);
                        $('#div_lkh_part_tieuchi'+tieuchi_id).hide();
                        $('#btn_part_tieuchi'+tieuchi_id).html('<i class="fa fa-plus"></i>');

                        $('.div_lkh_part_menhde3'+tieuchi_id).hide();
                        $('.btn_part_menhde3_'+tieuchi_id).html('<i class="fa fa-plus"></i>');
                        $('.part-two-menhde3_'+tieuchi_id).css('border-radius','82px');
                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }

                },
        });
    }

    function update_menhde(menhde_id,tieuchi_id){
        let id_kh_tieuchi = listkhtchuan[tieuchi_id];
        let ngay_batdau = $('.ngaybd_menhde_'+menhde_id).val();
        let ngay_hoanthanh = $('.ngayht_menhde_'+menhde_id).val();
        let id_khbc = {{ $keHoachBaoCao->id }};
        let arr_th_menhde = list_nhansuthuchien_menhde[menhde_id] != undefined ? list_nhansuthuchien_menhde[menhde_id].join(',') : [];
        let arr_kt_menhde = list_nhansukiemtra_menhde[menhde_id] != undefined ? list_nhansukiemtra_menhde[menhde_id].join(',') : [];


        $.ajax({
                url: "{{route('admin.tudanhgia.report.upadate_menhde')}}",
                type: "GET",
                data:{
                    ngay_batdau : ngay_batdau,
                    ngay_hoanthanh : ngay_hoanthanh,
                    menhde_id : menhde_id,
                    id_kh_tieuchi : id_kh_tieuchi,
                    nhansuthuchien : arr_th_menhde,
                    nhansukiemtra : arr_kt_menhde,
                    id_khbc : id_khbc,
                },
                error: function(err) {
                },

                success: function(data) {
                    if(data == 1){
                        check_start();
                        alert(`@lang('project/Selfassessment/title.capnhatthanhcong')`);
                        $('#div_lkh_part_menhde'+menhde_id).hide();
                        $('#btn_part_menhde_'+menhde_id).html('<i class="fa fa-plus"></i>');
                    }else{
                        alert(`@lang('project/Selfassessment/title.capnhatkhl')`);
                    }

                },
        })
    }

    function updatebosung(id_khbc,id_tieuchuan,id_tieuchi){
        $.ajax({
                url: "{{route('admin.tudanhgia.report.updatebosung')}}",
                type: "POST",
                data:{
                    id_khbc : id_khbc,
                    id_tieuchuan : id_tieuchuan,
                    id_tieuchi : id_tieuchi,

                },
                error: function(err) {
                },

                success: function(data) {
                    check_start();
                    console.log(data)

                },
        })
    }
</script>
@stop
