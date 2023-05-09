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
    <h1 style="color: red; text-align: center;">Chưa có thông tin về minh chứng này vui lòng cập nhật</h1>
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
    
</script>
@stop
