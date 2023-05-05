@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.tmbc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .bock-body{
    margin: 20px;
    padding-bottom: 22px;
    background: antiquewhite;;
    box-shadow: rgb(171 171 171) 0px 0px 12px;
}
p{
    font-size: 18px;
    margin-bottom: 12px
}
.bottom{
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.tmbctdg')
@stop

@section('content')
<section class="content-body bock-body">
    <h2>
        @lang('project/Selfassessment/title.ttbctđg')
    </h2>
    <div class="line"></div>
    <div>
        <form action="{{ route('admin.tudanhgia.addreport.insert') }}" method="post">
            @csrf
            <div class="select2s" style="margin: 3rem 8px 0px 8px;">
                <div class="select2-left">
                    <p>@lang('project/Selfassessment/title.botc')</p>
                    <select id="select2-css-left" class="btc-select" name="bo_tieuchuan" style="width: 51rem;">
                        <option value=""></option>
                      @foreach($btc as $value)
                         <option value="{{ $value->id }}">{{ $value->tieu_de }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="select2-right">
                    <select id="select2-css-right" class="nganh-select" name="ctdt_id" style="width: 22rem;margin: -1px -5px 0px -27px;">
    
                    </select>
                </div>
            </div>
    
            <div class="report" style="margin-top: 2rem;">
                 <div class="name-report">
                    <p>@lang('project/Selfassessment/title.tenbc')</p>
                    <input type="text" name="ten_bc" placeholder="@lang('project/Selfassessment/title.tenbc')" style="width: 51rem;">
                 </div>
                 <div class="data-date">
                        <p style="margin-left: -23px;">@lang('project/Selfassessment/title.ncsl')</p>
                        <input name="thoi_diem_bao_cao" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_chot" type="text" placeholder="@lang('project/Selfassessment/title.ncsl')" required style="height: 2rem;width: 22rem;margin: -1px -5px 0px -27px;">           
                 </div>
            </div>
            <div class="list-select2" style="margin: 2rem 96px 0px 26px;">
                <div class="select2-1 ">
                    <p>@lang('project/Selfassessment/title.khcb')</p>
                    <input name="ngay_batdau_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required style="width: 16rem;height: 2rem;">  
                </div>
                <div class="select2-2 ">
                    <input name="ngay_hoanthanh_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required style="width: 16rem;height: 2rem;">  
                </div>
                <div class="select2-3 ">
                    <p>@lang('project/Selfassessment/title.khvbc')</p>
                    <input name="ngay_batdau" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required style="width: 16rem;height: 2rem;">  
                </div>
                <div class="select2-4 size">
                    <input name="ngay_hoanthanh" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_vietbc_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required style="width: 16rem;height: 2rem;"> 
                </div>
            </div>
            <div class="assistant">
                <div class="center">
                    <p>@lang('project/Selfassessment/title.ttct')</p>
                    <select name="ns_phutrach" id="centers" class="searchs ttct">
                        @foreach($user as $value)
                            <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="select-bootom" style="margin-top: 2rem;">
                <div class="bottom">
                    <p>@lang('project/Selfassessment/title.nscb')</p>
                    <select class="multiple-nscb js-states form-control" multiple="multiple" name="ns_chuanbi[]">
                        @foreach($user as $value)
                            <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                        @endforeach  
                    </select>
                </div>
                <div class="bottom">
                    <p>@lang('project/Selfassessment/title.nsth')</p>
                    <select class="multiple-nsth js-states form-control" multiple="multiple" name="ns_thuchien[]">
                        @foreach($user as $value)
                            <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                        @endforeach  
                    </select>
                </div>
                <div class="bottom">
                    <p>@lang('project/Selfassessment/title.nskt')</p>
                    <select class="multiple-nskt js-states form-control" multiple="multiple" name="ns_kiemtra[]">
                        @foreach($user as $value)
                            <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                        @endforeach  
                    </select>
                </div>
            </div>
            <div class="" style="margin: 5rem 0px 14px 0px;display: flex;justify-content: center;">
                <button class="btn btn-success btn-benchmark mr-2" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-down mr-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z"/>
                        <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                    </svg>
                    <span>
                        @lang('project/Selfassessment/title.luu')
                    </span>
                </button>
            </div>
        </form>
    </div>
    
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
    $(".btc-select").select2({
        placeholder: "@lang('project/Selfassessment/title.lcbtc')",
    });
    $(".nganh-select").select2({
        placeholder: "@lang('project/Selfassessment/title.nganh')",
    });
    $(".ttct").select2({
        placeholder: "@lang('project/Selfassessment/title.ttct')",
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
        dateFormat: 'd/m/Y',
    });
    flatpickr('#ngay_cbi_end', {
        dateFormat: 'd/m/Y',
    });
    flatpickr('#ngay_cbi_start', {
        dateFormat: 'd/m/Y',
    });
    flatpickr('#ngay_vietbc_start', {
        dateFormat: 'd/m/Y',
    });
    flatpickr('#ngay_vietbc_end', {
        dateFormat: 'd/m/Y',
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
                if(data.loai_tieuchuan == 'ctdt'){
                    @foreach($ctdtList as $ctdt)
                        $(".nganh-select").append("<option value='{{ $ctdt->id }}'>{{ $ctdt->tennganh }}</option>")
                    @endforeach
                }
            })
        
    })
</script>
@stop
