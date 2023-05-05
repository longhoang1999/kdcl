@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.lkh')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<link type="text/css" href="{{ asset('vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 32px !important;
    }
    .select2-container .select2-selection--single .select2-selection__clear{
        right: 1rem;
    }
    th.width_30, td.width_30{
        width: 30% !important;
    }
    th.width_50, td.width_50{
        width: 60% !important;
    }
    th.width_20, td.width_20{
        width: 10% !important;
    }
    .btn-delete-lkh{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    hr{
        margin-top: 30px !important;
    }
    .btn-delete-lkh{
        padding: 5px;
        border-radius: 12px;
    }
    ion-icon.hydrated {
      font-size: 20px;
    }
</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.lkh')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">

        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="container-fuild">
        <div class="row">
            <h2 class="col-md-12">
                @lang('project/QualiAssurance/title.khdbcln' )
            </h2>
        </div>
       
        <div class="row">
             @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
            <div class="col-md-4">
                <select id="namlkh" class="form-control">
                    <option value="" hidden>-- @lang('project/QualiAssurance/title.cnlkh')</option>
                    @for($i = intVal(date('Y')) + 1 ;$i >= 2017; $i--)
                        <option >{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <select id="namcopykh" class="form-control">
                    <option value="" hidden>-- @lang('project/QualiAssurance/title.cncopykh')</option>
                    @for($i = intVal(date('Y'));$i >= 2017; $i--)
                        <option >{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-benchmark mr-2" type="button" id="turnOnmodalCopy" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.copykhtnc')">
                    <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                </button>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn" data-toggle="modal" data-target="#modalLapKeHoach" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.lkhm')">
                    <i class="bi bi-file-earmark-plus-fill"  style="font-size: 35px;color: #009ef7;"></i> 
                </button>
            </div>
            
            @endif
            <div class="col-md-1">
                <a class="btn btn-benchmark mr-2" href="{{route('admin.dambaochatluong.planning.exportplaning')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                    <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                </a>
            </div>
        </div>
       
    </div>
   
    <div class="form-standard">
        <div class="content-page">
            <div class="wrapper-tabs">
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">
                        @lang('project/QualiAssurance/title.dlkh')
                    </li>
                    <li class="tab-link" data-tab="tab-2">
                        @lang('project/QualiAssurance/title.clkh')
                    </li>
                </ul>
                <div id="tab-1" class="tab-content current">
                    <div class="container-fuild mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <select class="form-control item-search years">
                                    <option value="">
                                        -- @lang('project/QualiAssurance/title.chonnam')
                                    </option>
                                    @for($i = intVal(date('Y')) + 1 ;$i >= 2017; $i--)
                                        <option 
                                            @if($i == intVal(date('Y')))
                                                selected 
                                            @endif
                                        >{{$i}}</option>
                                    @endfor
                                </select>
                            </div>   
                            <div class="col-md-3">
                                <select class="form-control item-search mcsl">
                                    <option value="">
                                        -- @lang('project/QualiAssurance/title.chonlv')
                                    </option>
                                    @foreach($linh_vuc as $lv)
                                        <option value="{{ $lv->id }}">
                                            {{ $lv->mo_ta }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control item-search donvi">
                                    <option value="">
                                        -- @lang('project/QualiAssurance/title.chondv')
                                    </option>
                                    @foreach($loai_dv as $ldv)
                                        <optgroup label="{{ $ldv->loai_donvi }}">
                                            @foreach($donvi as $value)
                                                @if($value->loai_dv_id == $ldv->id)
                                                    <option value="{{ $value->id }}">
                                                        {{ $value->ten_donvi }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <table class="table table-striped table-bordered" id="table" width="100%">
                        <thead>
                         <tr>
                            <th >@lang('project/QualiAssurance/title.lvuc')</th>
                            <th >@lang('project/QualiAssurance/title.nbd')</th>
                            <th >@lang('project/QualiAssurance/title.nht')</th>
                            <th >@lang('project/QualiAssurance/title.dvpt')</th>
                            <th >@lang('project/QualiAssurance/title.nskt')</th>
                            @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                            <th >@lang('project/QualiAssurance/title.hdong')</th>
                            @endif
                         </tr>
                        </thead>
                        <tbody>  
                        </tbody>                
                    </table>
                </div>
                <div id="tab-2" class="tab-content">
                    <table class="table table-striped table-bordered" id="table2" width="100%">
                        <thead>
                         <tr>
                            <th >@lang('project/QualiAssurance/title.lvuc')</th>
                            <th >@lang('project/QualiAssurance/title.trangthai')</th>
                            @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                            <th >@lang('project/QualiAssurance/title.hdong')</th>
                            @endif
                         </tr>
                        </thead>
                        <tbody>  
                        </tbody>                
                    </table>

                </div>
            </div>
        </div>


        <!-- <div class="item-group-button right-block mb-2 mt-3">
            <button class="btn btn-success btn-benchmark mr-2" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                </svg>    
                <span>@lang('project/QualiAssurance/title.cnkh')</span>
            </button>
        </div> -->
    </div>
</section>


<!-- Modal lập kế hoạch mới -->
<!-- Modal -->
<div class="modal fade" id="modalLapKeHoach" tabindex="-1" role="dialog" aria-labelledby="modalLapKeHoachLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLapKeHoachLabel">
            @lang('project/QualiAssurance/title.lkhm')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.dambaochatluong.planning.createPlan') }}" method="post">
            @csrf
          <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-6">
                        <label>@lang('project/QualiAssurance/title.chonlv')</label>
                        <select class="form-control item-search mcsl" name="linhvuc">
                            <option value="">
                                -- @lang('project/QualiAssurance/title.chonlv')
                            </option>
                            @foreach($linh_vuc as $lv)
                                <option value="{{ $lv->id }}">
                                    {{ $lv->mo_ta }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="cre_start_time">
                            @lang('project/QualiAssurance/title.ngaybd')
                        </label>
                        <input name="startDate" class="form-control flatpickr flatpickr-input" id="cre_start_time" data-mindate="today" type="text" placeholder="@lang('project/QualiAssurance/title.tgth')" >
                    </div>
                    <div class="col-md-6">
                        <label for="cre_end_time">
                            @lang('project/QualiAssurance/title.nht')
                        </label>
                        <input name="endDate" class="form-control flatpickr flatpickr-input" data-mindate="today" id="cre_end_time" type="text" placeholder="@lang('project/QualiAssurance/title.nht')">
                    </div>
                    <div class="col-md-6">
                        <label>
                            @lang('project/QualiAssurance/title.dvpt')
                        </label>
                        <select name="dvpt" class="form-control item-search donvi">
                            <option hidden value="">
                                ---- @lang('project/QualiAssurance/title.chondvpt')
                            </option>
                            @foreach($loai_dv as $ldv)
                                <optgroup label="{{ $ldv->loai_donvi }}">
                                    @foreach($donvi as $value)
                                        @if($value->loai_dv_id == $ldv->id)
                                            <option value="{{ $value->id }}">
                                                {{ $value->ten_donvi }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>
                            @lang('project/QualiAssurance/title.nskt')
                        </label>

                        <select name="nskt" class="form-control item-search ns">
                            <option hidden value="">
                                ---- @lang('project/QualiAssurance/title.nskt')
                            </option>
                            @foreach($nskt as $ns)
                                <option value="{{ $ns->id }}">  
                                    {{ $ns->name . " - " . $ns->ten_donvi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="note">
                            @lang('project/QualiAssurance/title.ghichu')
                        </label>
                        <textarea class="form-control" placeholder="@lang('project/QualiAssurance/title.ghichu')" name="notes"></textarea>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                @lang('project/QualiAssurance/title.lkh')
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
          <h5 class="modal-title" id="modalDeleteLabel">@lang('project/QualiAssurance/title.thongbao')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>@lang('project/QualiAssurance/title.bctsmxk')</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('project/QualiAssurance/title.huy')</button>
          <button type="button" id="btn-delete" class="btn btn-primary" data-id="">@lang('project/QualiAssurance/title.xoa')</button>
        </div>
      </div>
    </div>
  </div>

<!-- Cập nhật kế hoạch -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateLabel">
            @lang('project/QualiAssurance/title.cnkh')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="modal-body">
            <input type="hidden" id="id_ccsl" value="">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="">@lang('project/QualiAssurance/title.lvuc'): </label>
                        <span class="text-primary" id="up_linhvuc"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="">@lang('project/QualiAssurance/title.ngaybd'): </label>
                        <input class="up_ngaybd form-control flatpickr flatpickr-input" id="up_ngaybd" type="text" placeholder="dd-mm-yyyy" >
                    </div>
                    <div class="col-md-6">
                        <label for="">@lang('project/QualiAssurance/title.nht'): </label>
                        <input class="up_nht form-control flatpickr flatpickr-input" id="up_nht" type="text" placeholder="dd-mm-yyyy" >
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.dvpt'): </label>
                        <select id="up_dvpt" class="form-control item-search donvi">
                            <option hidden value="0">
                                ---- @lang('project/QualiAssurance/title.chondvpt')
                            </option>
                            @foreach($loai_dv as $ldv)
                                <optgroup label="{{ $ldv->loai_donvi }}">
                                    @foreach($donvi as $value)
                                        @if($value->loai_dv_id == $ldv->id)
                                            <option value="{{ $value->id }}">
                                                {{ $value->ten_donvi }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.nskt'): </label>
                        <select id="up_nskt" class="form-control item-search ns">
                            @foreach($nskt as $ns)
                                <option value="{{ $ns->id }}">
                                    {{ $ns->name . " - " . $ns->ten_donvi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.ghichu'): </label>
                        <textarea class="form-control" id="up_ghichu"></textarea>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="update_ccsl" class="btn btn-primary">
                @lang('project/QualiAssurance/title.cnkh')
            </button>
          </div>
    </div>
  </div>
</div>

<!-- Lập kế hoạch -->
<div class="modal fade" id="modalLkh" tabindex="-1" role="dialog" aria-labelledby="modalLkhLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLkhLabel">
            @lang('project/QualiAssurance/title.lkh')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.dambaochatluong.planning.createCcsl') }}" method="POST" id="form-lkhNew">
            @csrf
            <input type="hidden" value="" id="id_mcsl" name="id_mcsl">
          <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="">@lang('project/QualiAssurance/title.lvuc'): </label>
                        <span class="text-primary" id="linhvuc"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="lkh-nbd">@lang('project/QualiAssurance/title.ngaybd'): </label>
                        <input name="ngaybd" class="lkh-nbd form-control flatpickr flatpickr-input" id="lkh-nbd" data-mindate="today" type="text" placeholder="dd-mm-yyyy" >
                    </div>
                    <div class="col-md-6">
                        <label for="lkh-nht">@lang('project/QualiAssurance/title.nht'): </label>
                        <input name="nht" class="lkh-nht form-control flatpickr flatpickr-input" id="lkh-nht" data-mindate="today" type="text" placeholder="dd-mm-yyyy" >
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.dvpt'): </label>
                        <select name="dvpt" id="" class="form-control " >
                            <!-- <option hidden value="">
                                ---- @lang('project/QualiAssurance/title.chondvpt')
                            </option> -->
                            @foreach($loai_dv as $ldv)
                                <optgroup label="{{ $ldv->loai_donvi }}">
                                    @foreach($donvi as $value)
                                        @if($value->loai_dv_id == $ldv->id)
                                            <option value="{{ $value->id }}">
                                                {{ $value->ten_donvi }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.nskt'): </label>
                        <select name="nskt" id="" class="form-control " >
                            @foreach($nskt as $ns)
                                <option value="{{ $ns->id }}">
                                    {{ $ns->name . " - " . $ns->ten_donvi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="">@lang('project/QualiAssurance/title.ghichu'): </label>
                        <textarea class="form-control" name="ghichu"></textarea>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-lkhNew">
                @lang('project/QualiAssurance/title.lkh')
            </button>
          </div>
        </form>
    </div>
  </div>
</div>


<!-- Copy lập kế hoạch -->
<div class="modal fade" id="modalCopy" tabindex="-1" role="dialog" aria-labelledby="modalCopyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCopyModalLabel">
            @lang('project/QualiAssurance/title.lkh')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.dambaochatluong.planning.copyPlan') }}" method="post">
        @csrf
            <input type="number" hidden id="nam_lkhCopy" name="nam_lkhCopy">
          <div class="modal-body">
            <div class="container-fuild append-here">
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                @lang('project/QualiAssurance/title.luukh')
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
<script>
    // ckeck date lập kế hoạch
    flatpickr('#lkh-nbd', {
        minDate: 'today',
        dateFormat: 'd-m-Y',
    });

    flatpickr('#lkh-nht', {
        minDate: 'today',
        dateFormat: 'd-m-Y',
    });
    $("#lkh-nht").change(function() {
        let dateNht = new Date($("#lkh-nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#lkh-nbd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#lkh-nbd").change(function() {
        let dateNht = new Date($("#lkh-nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#lkh-nbd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $(".btn-lkhNew").click(function() {
        if($("#lkh-nbd").val() == "" || $("#lkh-nht").val() == "")
            alert("@lang('project/QualiAssurance/title.vldddtt')")
        else 
            $("#form-lkhNew").submit();
    })

    
    
    flatpickr('#up_ngaybd', {
        dateFormat: 'd-m-Y',
    });

    flatpickr('#up_nht', {
        dateFormat: 'd-m-Y',
    });
    $("#up_nht").change(function() {
        let dateNht = new Date($("#up_nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#up_ngaybd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#up_ngaybd").change(function() {
        let dateNht = new Date($("#up_nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#up_ngaybd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })



    flatpickr('#cre_start_time', {
        dateFormat: 'd-m-Y',
        minDate: 'today',
    });

    flatpickr('#cre_end_time', {
        dateFormat: 'd-m-Y',
        minDate: 'today',
    });
    $("#cre_end_time").change(function() {
        let dateNht = new Date($("#cre_end_time").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#cre_start_time").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#cre_start_time").change(function() {
        let dateNht = new Date($("#cre_end_time").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#cre_start_time").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })


    // hết check date lập kế hoạch
    $("#modalCopy").on("click", ".btn-delete-lkh", function() {
        $(this).parent().parent().remove()
    })

    $("#turnOnmodalCopy").click(function() {
        let namlkh = $("#namlkh").val();
        let namcopykh = $("#namcopykh").val();
        if(namlkh != null && namlkh != "" && namcopykh != null && namcopykh != ""){
            let routeApi = "{{ route('admin.dambaochatluong.planning.loadDataCopy') }}" + "?namlkh="  + namlkh + "&namcopykh=" + namcopykh;
            fetch(routeApi, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    $(".append-here").empty();
                    data.forEach((item) => {
                        let dataUI = ` 
                            <div class="row">
                                <div class="col-md-11 mt-3">
                                    <p class="text-primary">
                                        <span class="font-weight-bold">
                                            @lang('project/QualiAssurance/title.lvuc'): 
                                        </span>
                                        <span>
                                            ${item.mo_ta}
                                        </span>
                                        <input name="linhvuc_id[]" type="hidden" value="${item.nhom_mc_sl_id}">
                                    </p>
                                </div>
                                <div class="col-md-1 mt-3">
                                    <button class="btn btn-danger btn-delete-lkh">
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <label for="start_time">
                                        @lang('project/QualiAssurance/title.ngaybd')
                                    </label>
                                    <input name="startDate[]" class="start-date form-control flatpickr flatpickr-input" id="start_time_${item.id}" data-mindate="today" type="text" placeholder="@lang('project/QualiAssurance/title.tgth')" >
                                </div>
                                <div class="col-md-6">
                                    <label for="end_time">
                                        @lang('project/QualiAssurance/title.nht')
                                    </label>
                                    <input name="endDate[]" class="end-date form-control flatpickr flatpickr-input" data-mindate="today" id="end_time_${item.id}" type="text" placeholder="@lang('project/QualiAssurance/title.nht')">
                                </div>
                                <div class="col-md-6">
                                    <label for="dvpt">
                                        @lang('project/QualiAssurance/title.dvpt')
                                    </label>
                                    <select name="dvpt[]" class="form-control donvi dvpt_${item.id}">
                                        <option hidden value="">
                                            ---- @lang('project/QualiAssurance/title.chondvpt')
                                        </option>
                                        @foreach($loai_dv as $ldv)
                                            <optgroup label="{{ $ldv->loai_donvi }}">
                                                @foreach($donvi as $value)
                                                    @if($value->loai_dv_id == $ldv->id)
                                                        <option value="{{ $value->id }}">
                                                            {{ $value->ten_donvi }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="nskt">
                                        @lang('project/QualiAssurance/title.nskt')
                                    </label>

                                    <select name="nskt[]" class="form-control ns nskt_${item.id}">
                                        <option hidden value="">
                                            ---- @lang('project/QualiAssurance/title.nskt')
                                        </option>
                                        @foreach($nskt as $ns)
                                            <option value="{{ $ns->id }}">  
                                                {{ $ns->name . " - " . $ns->ten_donvi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="note">
                                        @lang('project/QualiAssurance/title.ghichu')
                                    </label>
                                    <textarea class="form-control" placeholder="@lang('project/QualiAssurance/title.ghichu')" name="notes[]">${ item.notes != null ? item.notes : "" }</textarea>
                                </div>
                                <hr>
                            </div>
                         `;

                        
                        $(".append-here").append(dataUI)
                        $(".append-here").find(`.dvpt_${item.id}`).val(item.dv_thuchien)
                        $(".append-here").find(`.nskt_${item.id}`).val(item.dv_kiemtra)
                        flatpickr(`#start_time_${item.id}`, {
                            minDate: 'today',
                            dateFormat: 'd-m-Y',
                        });

                        flatpickr(`#end_time_${item.id}`, {
                            minDate: 'today',
                            dateFormat: 'd-m-Y',
                        });
                        
                        // check date render
                        $(`#end_time_${item.id}`).change(function() {
                            let dateNht = new Date($(`#end_time_${item.id}`).val().split("-").reverse().join("-"))
                            let dateNbd = new Date($(`#start_time_${item.id}`).val().split("-").reverse().join("-"))
                            if(dateNht < dateNbd){
                                alert("@lang('project/QualiAssurance/title.vlcdn')")
                                $(this).val("")
                            }
                        })
                        $(`#start_time_${item.id}`).change(function() {
                            let dateNht = new Date($(`#end_time_${item.id}`).val().split("-").reverse().join("-"))
                            let dateNbd = new Date($(`#start_time_${item.id}`).val().split("-").reverse().join("-"))
                            if(dateNht < dateNbd){
                                alert("@lang('project/QualiAssurance/title.vlcdn')")
                                $(this).val("")
                            }
                        })

                    })
                    
                })
                .then(() => {
                    $("#nam_lkhCopy").val($("#namlkh").val())
                    $('#modalCopy').modal("show")
                })
        }else{
            alert("@lang('project/QualiAssurance/title.vlcdn')");
        }
    })

    
    $(document).ready(function(){
        // $(".years").select2({
        //     placeholder: "@lang('project/QualiAssurance/title.nam')",
        //     allowClear: true
        // });
        // $(".mcsl").select2({
        //     placeholder: "@lang('project/QualiAssurance/title.lvuc')",
        //     allowClear: true
        // });
        // $(".donvi").select2({
        //     placeholder: "@lang('project/QualiAssurance/title.donvi')",
        //     allowClear: true
        // });

        var table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route('admin.dambaochatluong.planning.showPlan') !!}",
                type: 'POST',
                data: {
                    'year' : function() { return $(".years").val() },
                    'mcsl' : function() { return $(".mcsl").val() },
                    'donvi': function() { return $(".donvi").val() }
                },
            },
            columns: [
                { data: 'mo_ta', name: 'mo_ta' },
                { data: 'ngayBatdau', name: 'ngayBatdau' },
                { data: 'ngayHoanthanh', name: 'ngayHoanthanh' },
                { data: 'dvThucHien', name: 'dvThucHien' },
                { data: 'nsKiemTra', name: 'nsKiemTra' },
                @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                { data: 'actions', name: 'actions' ,className: 'action'},
                @endif
            ],            
        });

        $(".years").change(function() {
            table.ajax.reload();
        })
        $(".mcsl").change(function() {
            table.ajax.reload();
        })
        $(".donvi").change(function() {
            table.ajax.reload();
        })

        $('#modalDelete').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) 
            let id = button.data('id')
            let modal = $(this)
            modal.find('#btn-delete').attr("data-id", id)
        })
        $("#btn-delete").click(function() {
            let id_delete = $(this).attr("data-id");
            let routeApi = "{{ route('admin.dambaochatluong.planning.deleteCcsl') }}" + "?id_delete="  + id_delete;
                fetch(routeApi, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if(data.result == "done"){
                            // console.log(data.result)
                            // $('#modalDelete').modal("hide");
                            $('#modalDelete').find("button.close").click();
                            table.ajax.reload();
                        }
                    })
        })


        // chuyển tab
        $('ul.tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        })

        $('#table tbody').on('click', '.updateBtn', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            $('#up_linhvuc').text(row.data().mo_ta)
            $('#up_ngaybd').val(row.data().ngay_batdau.split("-").reverse().join("-"))
            $('#up_nht').val(row.data().ngay_hoanthanh.split("-").reverse().join("-"))
            $('#up_dvpt').val(row.data().dv_thuchien)
            $('#up_nskt').val(row.data().dv_kiemtra)
            $('#up_nskt').trigger('change');
            $("#up_ghichu").val(row.data().notes)
            $("#id_ccsl").val(row.data().id_ccsl)
        })

        $("#update_ccsl").click(function() {
            if($("#up_ngaybd").val() == "" && $("#up_nht").val() == "")
                alert("@lang('project/QualiAssurance/title.vldddtt')")
            else{ 
                let dataApi = {
                    'up_ngaybd' : $('#up_ngaybd').val(),
                    'up_nht' : $('#up_nht').val(),
                    'up_dvpt' : $('#up_dvpt').val(),
                    'up_nskt' : $('#up_nskt').val(),
                    'up_ghichu' : $("#up_ghichu").val(),
                    'id_ccsl' : $("#id_ccsl").val()
                }
                let routeApi = "{{ route('admin.dambaochatluong.planning.updateCcsl') }}";
                fetch(routeApi, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    body: JSON.stringify(dataApi)
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if(data.result == "done"){
                            $('#modalUpdate').find("button.close").click();
                            table.ajax.reload();
                        }
                    })
            }
        })
    });  
</script>
<script>
    $(".years").select2({
        placeholder: "@lang('project/QualiAssurance/title.nam')",
        allowClear: true
    });
    $(".mcsl").select2({
        placeholder: "@lang('project/QualiAssurance/title.lvuc')",
        allowClear: true
    });
    // $(".donvi").select2({
    //     placeholder: "@lang('project/QualiAssurance/title.donvi')",
    //     allowClear: true
    // });
    $(".ns").select2({
        placeholder: "@lang('project/QualiAssurance/title.nskt')",
        allowClear: true
    });

</script>


<script>
    $(document).ready(function(){
        var table2 = $('#table2').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route('admin.dambaochatluong.planning.showNotPlan') !!}",
                type: 'POST'
            },
            columns: [
                { data: 'mo_ta', name: 'mo_ta' , className: 'width_30'  },
                { data: 'note', name: 'note' , className: 'width_50' },
                @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                { data: 'actions', name: 'actions', className: 'width_20' ,className: 'action' },
                @endif
            ],            
        });



        $('#table2 tbody').on('click', '.control', function () {
            var tr = $(this).closest('tr');
            var row = table2.row(tr);
            let mota = row.data().mo_ta;
            let id_mcsl = row.data().id;
            $("#id_mcsl").val(id_mcsl)
            $("#linhvuc").text(mota)
        })

    });  
    $.ajaxSetup({
        		headers: {
            			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}
   		 });
</script>


@stop
