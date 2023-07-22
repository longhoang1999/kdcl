@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.dsbctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .container-fuild{
        box-shadow: unset;
    }
    .select2{
        width: 100% !important;
        border: 1px solid  #e4e6ef; 
        padding-top: 4px;
    }
    .select2 span{
        display: block;
        height: 100%;
    }
    .select2-selection{
        border: none !important;
    }
    .select2-container .select2-selection--single .select2-selection__clear{
        margin-right: -2.6rem;
    }
    td.action{
        justify-content: center;
        flex-wrap: wrap;
        width: 190px;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.dsbctdg')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                <button class="btn btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button"
                    data-toggle="modal" data-target="#modalCreateBC" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.themmoi')">
                    <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
                </button>
            @endif
            
            <a class="btn btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" href="{{ route('admin.tudanhgia.report.dsbctdg') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/Selfassessment/title.tenbc')</th>
                <th >@lang('project/Selfassessment/title.loaibc')</th>
                <!-- <th >@lang('project/Selfassessment/title.trang_thai')</th> -->
                <th >@lang('project/Selfassessment/title.ngaybd')</th>
                <th >@lang('project/Selfassessment/title.ngaykt')</th>
                <th >@lang('project/Selfassessment/title.cbct')</th>
                <th >@lang('project/Selfassessment/title.hanhdong')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
</section>



<!-- Modal -->
<div class="modal fade" id="modalCreateBC" tabindex="-1" role="dialog" aria-labelledby="modalCreateBCLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateBCLabel">
            @lang('project/Selfassessment/title.tmbctdg')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('admin.tudanhgia.addreport.insert') }}" method="post" id="form-lkhNew">
        @csrf
          <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="btc-select">
                                @lang('project/Selfassessment/title.botc')
                            </label>
                            <br>
                            <select class="btc-select" name="bo_tieuchuan" id="btc-select">
                                <option value=""></option>
                                @foreach($btc as $value)
                                    <option value="{{ $value->id }}">{{ $value->tieu_de }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nganh-select">
                                @lang('project/Selfassessment/title.nganh')
                            </label>
                            <br>
                            <select class="nganh-select form-control" name="ctdt_id" id="nganh-select">
                                <option value="">--@lang('project/Selfassessment/title.chonnganh')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="ten_baocao">
                                @lang('project/Selfassessment/title.tenbc')
                            </label>
                            <br>
                            <input type="text" placeholder="@lang('project/Selfassessment/title.tenbc')" id="ten_baocao" class="form-control" name="ten_bc">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ngay_chot">
                                @lang('project/Selfassessment/title.ncsl')
                            </label>
                            <br>
                            <input name="thoi_diem_bao_cao" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_chot" type="text" placeholder="@lang('project/Selfassessment/title.ncsl')" required> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_cbi_start">
                                @lang('project/Selfassessment/title.khcb')
                            </label>
                            <br>
                            <input name="ngay_batdau_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>  
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                            <br>
                            <input name="ngay_hoanthanh_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>  
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_vietbc_start">
                                @lang('project/Selfassessment/title.khvbc')
                            </label>
                            <br>
                            <input name="ngay_batdau" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>    
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                            <br>
                            <input name="ngay_hoanthanh" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>   
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="centers">
                            @lang('project/Selfassessment/title.ttct')
                        </label>
                        <select name="ns_phutrach" id="centers" class="searchs ttct" multiple="multiple">
                            <option value="" hidden></option>
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="multiple-nscb">
                            @lang('project/Selfassessment/title.nscb')
                        </label>
                        <select class="multiple-nscb js-states form-control" multiple="multiple" name="ns_chuanbi[]" id="multiple-nscb">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="multiple-nsth">
                            @lang('project/Selfassessment/title.nsth')
                        </label>
                        <select class="multiple-nsth js-states form-control" multiple="multiple" name="ns_thuchien[]">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="multiple-nskt">
                            @lang('project/Selfassessment/title.nskt')
                        </label>
                        <select class="multiple-nskt js-states form-control" multiple="multiple" name="ns_kiemtra[]">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="write-follow">
                            @lang('project/Selfassessment/title.vbctheo')
                        </label>
                        <select name="writeFollow" id="write-follow" class="js-states form-control" >
                            <option value="" hidden>
                                @lang('project/Selfassessment/title.vbctheo')
                            </option>
                            <option value="1">
                                @lang('project/Selfassessment/title.chỉbao')
                            </option>  
                            <option value="2">
                                @lang('project/Selfassessment/title.mocchuan')
                            </option>  
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-lkhNew">
                @lang('project/Selfassessment/title.luu')
            </button>
          </div>
        </form>
    </div>
  </div>
</div>


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
                <span class="badge ">
                    @lang('project/Selfassessment/title.hoixoaKH')
                </span>
                <br>
                <span class="badge ">
                    @lang('project/Standard/message.error.khoantac')
                </span>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="btn-delete-manafield">
                    @lang('project/Standard/title.xoa')
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    @lang('project/Standard/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalUpdateBC" tabindex="-1" role="dialog" aria-labelledby="modalUpdateBCLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateBCLabel">
            @lang('project/Selfassessment/title.csbctdg')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('admin.tudanhgia.addreport.update') }}" method="post" id="form-lkhNew-up">
        @csrf
            <input type="hidden" id="id_baocao-up" value="" name="id_baocao">
          <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="btc-select">
                                @lang('project/Selfassessment/title.botc')
                            </label>
                            <br>
                            <select class="btc-select" name="bo_tieuchuan" id="btc-select-up">
                                <option value=""></option>
                                @foreach($btc as $value)
                                    <option value="{{ $value->id }}">{{ $value->tieu_de }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nganh-select">
                                @lang('project/Selfassessment/title.nganh')
                            </label>
                            <br>
                            <select class="nganh-select form-control" name="ctdt_id" id="nganh-select-up">
                                <option value="">--@lang('project/Selfassessment/title.chonnganh')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="ten_baocao">
                                @lang('project/Selfassessment/title.tenbc')
                            </label>
                            <br>
                            <input type="text" placeholder="@lang('project/Selfassessment/title.tenbc')" id="ten_baocao-up" class="form-control" name="ten_bc">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ngay_chot">
                                @lang('project/Selfassessment/title.ncsl')
                            </label>
                            <br>
                            <input name="thoi_diem_bao_cao" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_chot-id" type="text" placeholder="@lang('project/Selfassessment/title.ncsl')" required> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_cbi_start">
                                @lang('project/Selfassessment/title.khcb')
                            </label>
                            <br>
                            <input name="ngay_batdau_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_start-id" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>  
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                            <br>
                            <input name="ngay_hoanthanh_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_end-id" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>  
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_vietbc_start">
                                @lang('project/Selfassessment/title.khvbc')
                            </label>
                            <br>
                            <input name="ngay_batdau" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_start-id" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>    
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                            <br>
                            <input name="ngay_hoanthanh" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_end-id" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>   
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="centers">
                            @lang('project/Selfassessment/title.ttct')
                        </label>
                        <select name="ns_phutrach" id="centers-id" class="searchs ttct">
                            <option value="" hidden></option>
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label for="multiple-nscb">
                            @lang('project/Selfassessment/title.nscb')
                        </label>
                        <select class="multiple-nscb js-states form-control" multiple="multiple" name="ns_chuanbi[]" id="multiple-nscb-id">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="multiple-nsth">
                            @lang('project/Selfassessment/title.nsth')
                        </label>
                        <select class="multiple-nsth js-states form-control" multiple="multiple" name="ns_thuchien[]" id="multiple-nsth-id">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="multiple-nskt">
                            @lang('project/Selfassessment/title.nskt')
                        </label>
                        <select class="multiple-nskt js-states form-control" multiple="multiple" name="ns_kiemtra[]" id="multiple-nskt-id">
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="write-follow">
                            @lang('project/Selfassessment/title.vbctheo')
                        </label>
                        <select name="writeFollow" id="write-follow-id" class="js-states form-control" >
                            <option value="" hidden>
                                @lang('project/Selfassessment/title.vbctheo')
                            </option>
                            <option value="1">
                                @lang('project/Selfassessment/title.chỉbao')
                            </option>  
                            <option value="2">
                                @lang('project/Selfassessment/title.mocchuan')
                            </option>  
                        </select>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-lkhNew-up">
                @lang('project/Selfassessment/title.chinhsua')
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
    // check date
    $("#ngay_cbi_end").change(function() {
        let dateNht = new Date($("#ngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#ngay_cbi_start").change(function() {
        let dateNht = new Date($("#ngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#ngay_vietbc_end").change(function() {
        let dateNht = new Date($("#ngay_vietbc_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_vietbc_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#ngay_vietbc_start").change(function() {
        let dateNht = new Date($("#ngay_vietbc_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_vietbc_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })

    $(".btn-lkhNew").click(function() {
        if($("#ngay_cbi_end").val() == "" || $("#ngay_cbi_start").val() == "" 
            || $("#ngay_vietbc_end").val() == "" ||  $("#ngay_vietbc_start").val() == "")
            alert("@lang('project/QualiAssurance/title.vldddtt')")
        else 
            $("#form-lkhNew").submit();
    })
    // end check date

    $(function(){
        table = $('#table').DataTable({
            lengthMenu: [[7, 10, 20, -1], [7, 10, 20, "All"]],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.tudanhgia.report.data') !!}",
            columns: [
                { data: 'ten_bc', name: 'ten_bc' },
                { data: 'loaibc', name: 'loaibc' },
                //{ data: 'trang_thai', name: 'trang_thai' },
                { data: 'ngBd', name: 'ngBd' },
                { data: 'ngHt', name: 'ngHt' },
                { data: 'ngPhutrach', name: 'ngPhutrach' },
                { data: 'action', name: 'action', className:'action' },
            ],            
        });
    });  


    
    $(".btc-select").select2({
        placeholder: "@lang('project/Selfassessment/title.lcbtc')",
        allowClear: true
    });

    // $(".nganh-select").select2({
    //     placeholder: "@lang('project/Selfassessment/title.nganh')",
    //     allowClear: true
    // });

    $(".ttct").select2({
        placeholder: "@lang('project/Selfassessment/title.ttct')",
        allowClear: true
    });
    $(".multiple-nscb").select2({
        placeholder: "@lang('project/Selfassessment/title.nscb')"
    });
    $(".multiple-nsth").select2({
        placeholder: "@lang('project/Selfassessment/title.nsth')"
    });
    $(".multiple-nskt").select2({
        placeholder: "@lang('project/Selfassessment/title.nskt')"
    });


    flatpickr('#ngay_chot', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_cbi_end', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_cbi_start', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_vietbc_start', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_vietbc_end', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });



    $(".btc-select").change(function() {
        $(".nganh-select").empty();
        let loadData = "{{ route('admin.tudanhgia.addreport.searchLtc') }}" + "?id_btc=" + $(this).val();
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if(data[0].loai_tieuchuan == 'ctdt'){
                    $(".nganh-select").append(`<option value="">--@lang('project/Selfassessment/title.chonnganh')</option>`)
                    data[1].forEach(item => {
                        $(".nganh-select").append(`<option value='${item.id}'>${item.tennganh}</option>`)
                    })

                }
            })
        
    })


    $('#modalDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('id') 

        let route = "{{ route('admin.tudanhgia.report.deletePlan') }}" + "?id_planning=" + recipient;
        var modal = $(this)
        modal.find('#btn-delete-manafield').attr('href' , route)
    })

    
    $('#modalUpdateBC').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('id') 
        console.log(recipient)

        let route = "{{ route('admin.tudanhgia.report.getDataCurrent') }}" + "?id_planning=" + recipient;
        fetch(route, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $("#id_baocao-up").val(data[0].id)
                $("#ten_baocao-up").val(data[0].ten_bc)
                $("#btc-select-up").val(data[0].bo_tieuchuan_id).trigger('change')
                $("#ngay_chot-id").val(data[0].thoi_diem_bao_cao);
                $("#ngay_cbi_start-id").val(data[0].ngay_batdau_chuanbi);
                $("#ngay_cbi_end-id").val(data[0].ngay_hoanthanh_chuanbi);
                $("#ngay_vietbc_start-id").val(data[0].ngay_batdau);
                $("#ngay_vietbc_end-id").val(data[0].ngay_hoanthanh);
                $("#centers-id").val(data[0].ns_phutrach).trigger('change')
                $("#write-follow-id").val(data[0].writeFollow)
                $("#nganh-select-up").val(data[0].ctdt_id)
                let idNscb = [];
                data[1].forEach(item => {
                    idNscb.push(item.id_nhansuchuanbi);
                })
                $("#multiple-nscb-id").val(idNscb).trigger('change')
                

                let idNsth = [];
                data[2].forEach(item => {
                    idNsth.push(item.id_nhansuthuchien)
                })
                $("#multiple-nsth-id").val(idNsth).trigger('change')

                let idNskt = [];
                data[3].forEach(item => {
                    idNskt.push(item.id_nhansukiemtra)
                })
                $("#multiple-nskt-id").val(idNskt).trigger('change')
            })
    })

    $(".btn-lkhNew-up").click(function() {
        if($("#ngay_cbi_end-id").val() == "" || $("#ngay_cbi_start-id").val() == "" 
            || $("#ngay_vietbc_end-id").val() == "" ||  $("#ngay_vietbc_start-id").val() == "")
            alert("@lang('project/QualiAssurance/title.vldddtt')")
        else 
            $("#form-lkhNew-up").submit();
    })


    flatpickr('#ngay_chot-id', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_cbi_end-id', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_cbi_start-id', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_vietbc_start-id', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
    flatpickr('#ngay_vietbc_end-id', {
        dateFormat: 'd-m-Y',
        minDate: "today",
    });
</script>
@stop
