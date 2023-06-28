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
        <div class="d-flex justify-content-center">
            <div class="btn btn-light"><a href="{!! route('admin.tonghop.dbcl.index') !!}" style="color: black;">Đảm bảo chất lượng</a></div>

            <div class="btn btn-danger"><a href="#" style="color: white;">Minh chứng yêu cầu</a></div>

        </div>
        <h1>Danh sách minh chứng yêu cầu</h1>
        <div class="synthetic">
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                    <th>STT</th>
                    <th>Minh chứng yêu cầu</th>
                    <th>Đơn vị thực hiện</th>
                    <th>Thời gian thực hiện</th>
                    <th>Thời gian còn lại</th>
                    <th>Trạng thái</th>
                </thead>
                <tbody class="tbodys">                        
                </tbody>                
            </table>
        </div>
<!-- page trang ở đây -->
<section class="content-body bock-body">
    
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
    $(function () {
        var url = "{!! route('admin.tonghop.dbcl.datamcyc') !!}" + "?id_nhom_mc_sl=" + {{$id_nhom_mc_sl}};
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true, 
            searching:true,
            ajax: url,

            order: [],  
            columns: [
                { data: 'key', name: 'key' },
                { data: 'noi_dung', name: 'noi_dung' },
                { data: 'tendonvi', name: 'tendonvi' },
                { data: 'ngay', name: 'ngay' },
                { data: 'thoigiancl', name: 'thoigiancl' },
                { data: 'trangthai', name: 'trangthai' },
               
            ],           
        });

    });
</script>
@stop
