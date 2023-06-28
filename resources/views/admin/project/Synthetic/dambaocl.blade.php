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
            <div class="btn btn-danger"><a href="#" style="color: white;">Đảm bảo chất lượng</a></div>

            <div class="btn btn-light"><a href="{!! route('admin.tonghop.dbcl.minhchungyc') !!}" style="color: black;">Minh chứng yêu cầu</a></div>
        </div>
        <h1>Tổng hợp đảm bảo chất lượng</h1>
        <div class="synthetic">
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                    <th>Lĩnh vực</th>
                    <th>ĐV Phụ trách</th>
                    <th>Tổng số Hoạt động</th>
                    <th>Tổng số MCYC</th>
                    <th>MCYC đã phân công</th>
                    <th>MCTT đã cập nhật</th>
                    <th>MCTT đã xác nhận</th>
                    <th>MCYC chưa cập nhật</th>
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
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true, 
            searching:true,
            ajax: "{!! route('admin.tonghop.dbcl.datadbcl') !!}",
            order: [],  
            columns: [
                { data: 'mo_ta', name: 'mo_ta' },
                { data: 'donvipt', name: 'donvipt' },
                { data: 'allhd', name: 'allhd' },
                { data: 'allmcyc', name: 'allmcyc' },
                { data: 'allmcdpc', name: 'allmcdpc' },
                { data: 'allmcdcn', name: 'allmcdcn' },
                { data: 'allmcdxn', name: 'allmcdxn' },
                { data: 'allmcccn', name: 'allmcccn' },
               
            ],           
        });

    });
</script>
@stop
