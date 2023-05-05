@extends('admin/layouts/default')
@php
    $baseLang = 'project/QualiAssurance/KtraMCHoatDong/title';
    $baseRoute = 'admin.dambaochatluong.checkproof';
@endphp

{{-- Page title --}}
@section('title')
    @lang( $baseLang . '.cnhd')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">

<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .block-flex{
        display: flex;
    }
    .block-flex span{
        display: block;
        width: 150px;
        margin-right: 10px; font-weight: bold;
        align-items: center;
    }
    .block-flex input:nth-child(2){
        margin-right: 10px;
    }
    .block-flex input:nth-child(3){
        width: 100px;
    }
    th.dvpc, td.dvpc{
        width: 350px;
    }
</style>
@stop

@section('title_page')
   @lang( $baseLang . '.cnhd')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="container-fuild pl-5 ">
            <div class="row mt-3">
                <h6 class="col-md-12">@lang( $baseLang . '.ktmcyc')</h6>
            </div>
            <div class="row mt-1 ">
                <div class="col-md-8 block-flex">
                    <span>@lang( $baseLang . '.lvuc')</span>
                    <input type="text" class="form-control " placeholder="@lang( $baseLang . '.lvuc')" disabled value="{{ $lv_hdn->mo_ta }}">
                    <input type="number" class="form-control " placeholder="@lang( $baseLang . '.nam')" disabled value="{{ $hoatDongNhom->year }}">
                    <div>
                        <button class="btn" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                            <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-8 block-flex">
                    <span>@lang( $baseLang . '.tenhd')</span>
                    <input type="text" class="form-control " placeholder="@lang( $baseLang . '.tenhd')" disabled value="{{ $hoatDongNhom->noi_dung }}">
                </div>
            </div>
            @if(!Sentinel::inRole('ns_thuchien'))
                @if($hoatDongNhom->cong_bo =='N' )
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <button class="btn" data-toggle="modal" data-target="#congBoSoLieu" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xacnhanmc')">
                                <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                            </button>
                            <button class="btn" data-toggle="modal" data-target="#tuChoiSoLieu" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.khongxacnhan')">
                                <i class="bi bi-dash-circle-fill" style="font-size: 35px;color: red;"></i>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if($hoatDongNhom->cong_bo =='Y' || $hoatDongNhom->cong_bo =='P' )
                    <button class="btn btn-primary" id="moLaiSoLieu" data-toggle="modal" data-target="#openAgain">
                        <i class="fas fa-retweet"></i> @lang( $baseLang . '.mlhd')
                    </button>
                @endif
            @endif
        </div>
        <h3 class="mt-5"></h3>
        <div class="item-group-button right-block mb-2">
            
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th>@lang( $baseLang . '.tieude')</th>
                <th>@lang( $baseLang . '.lvuc')</th>
                <th>@lang( $baseLang . '.so')</th>
                <th>@lang( $baseLang . '.ngaybh')</th>
                <th>@lang( $baseLang . '.noibh')</th>
                <th>@lang( $baseLang . '.diachi')</th>
                <th>@lang( $baseLang . '.nql')</th>
                <th>@lang( $baseLang . '.donvi')</th>
                <th>@lang( $baseLang . '.trangthai')</th>
                <th>@lang( $baseLang . '.tacvu')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
</section>


<!-- modal congBoSoLieu -->
<div class="modal fade" id="congBoSoLieu" tabindex="-1" role="dialog" aria-labelledby="congBoSoLieuLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="congBoSoLieuLabel">
            @lang( $baseLang . '.cbhd')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>@lang( $baseLang . '.hdsdck')</p>
      </div>
      <div class="modal-footer">
        <a href="{{ route( $baseRoute . '.congbo', $id_hdn) }}" class="btn btn-primary">
            @lang( $baseLang . '.congbo')
        </a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            @lang( $baseLang . '.huybo')
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal tuChoiSoLieu -->
<div class="modal fade" id="tuChoiSoLieu" tabindex="-1" role="dialog" aria-labelledby="tuChoiSoLieuLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tuChoiSoLieuLabel">
            @lang( $baseLang . '.khhd')
            <br><small>@lang( $baseLang . '.clkhtc')</small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! route( $baseRoute . '.cancelMc') !!}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id_hdn }}">
        <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-4">
                        <p>@lang( $baseLang . '.kehoach')</p>
                    </div>
                    <div class="col-md-8 block-flex">
                        <input name="ngay_batdau" class="start-date form-control flatpickr flatpickr-input" id="ngay_thuc_hien" type="text" placeholder="@lang( $baseLang . '.nth')" required>
                        <input name="ngay_hoanthanh" class="start-date ml-3 form-control flatpickr flatpickr-input" id="ngay_kiem_tra" type="text" placeholder="@lang( $baseLang . '.nkt')" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p>@lang( $baseLang . '.dvcth')</p>
                    </div>
                    <div class="col-md-8">
                        @foreach($donvi as $dv)
                            @if($dv->minhChungCount == 0)
                                <span class="badge badge-danger">
                                    {{ $dv->ten_donvi }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p>@lang( $baseLang . '.dvtmc')</p>
                    </div>
                    <div class="col-md-8">
                        <select multiple="multiple" class="form-control col-12 select2" name="dvChuaDu[]">
                            @foreach($donvi as $dv)
                                @continue($dv->minhChungCount==0)
                                <option value="{{ $dv->id }}">{{ $dv->ten_donvi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p>@lang( $baseLang . '.ghichu')</p>
                    </div>
                    <div class="col-md-8">
                        <textarea class="form-control"  name="ghi_chu" required></textarea>
                    </div>
                </div>
            </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                @lang( $baseLang . '.dong')
            </button>
            <button type="submit" class="btn btn-danger">
                @lang( $baseLang . '.tcvlkh')
            </button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="openAgain" tabindex="-1" role="dialog" aria-labelledby="openAgainLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="openAgainLabel">
            @lang( $baseLang . '.chuy')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @lang( $baseLang . '.hdqtl')
      </div>
      <div class="modal-footer">
        <a href="{!! route( $baseRoute . '.openAgain', $id_hdn) !!}" class="btn btn-primary">
            @lang( $baseLang . '.mlhd')
        </a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            @lang( $baseLang . '.dong')
        </button>
      </div>
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
    $(".select2").select2({
        allowClear: true,
        width: '300'
    });
    flatpickr('#ngay_thuc_hien', {
        dateFormat: 'd-m-Y',
    });
    flatpickr('#ngay_kiem_tra', {
        dateFormat: 'd-m-Y',
    });

    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route( $baseRoute . '.getListMc', $id_hdn) !!}",
                type: 'GET'
            },
            columns: [
                { data: 'tieu_de' },
                { data: 'linhvuc' },
                { data: 'sohieu' },
                { data: 'ngayBan_hanh' },
                { data: 'noi_banhanh' },
                { data: 'address' },
                { data: 'ng_Quanly' },
                { data: 'donVi' },
                { data: 'trang_thai' },
                { data: 'actions' ,className: 'action' },
             ],
            order: [[1, 'asc']],
        });
    }); 
</script>

@stop
