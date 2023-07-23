@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.hoanthienbc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<style>
    td button{
        font-size: 15px !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.hoanthienbc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-group">
        <div class="form-standard">
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                 <tr>
                    <th >@lang('project/Selfassessment/title.tenbc')</th>
                    <th >@lang('project/Selfassessment/title.mabaocao')</th>
                    <th >@lang('project/Selfassessment/title.manganh')</th>
                    <th >@lang('project/Selfassessment/title.ttct')</th>
                    <th >@lang('project/Selfassessment/title.donvi')</th>
                    <th >@lang('project/Selfassessment/title.thoidiembc')</th>
                    <th >@lang('project/Selfassessment/title.thoigianth')</th>
                    <th >@lang('project/Selfassessment/title.trang_thai')</th>
                 </tr>
                </thead>
                <tbody>  
                </tbody>                
            </table>
        </div>
    </div>
</section>
<!-- /Kết thúc page trang -->
    
    <!-- Kết thúc trang -->
    </section>

@stop


{{-- page level scripts --}}
@section('footer_scripts')
<script>


    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.tudanhgia.completionreport.data') !!}",
            order: [],  
            columns: [
                { data: 'tenbaocao', name: 'tenbaocao' },
                { data: 'id',  name: 'id' },
                { data: 'ma_nganh', name: 'ma_nganh' },
                { data: 'ngPhutrach', name: 'ngPhutrach' },
                { data: 'dvpt', name: 'dvpt' },
                { data: 'createdAt', name: 'createdAt' },
                { data: 'tgTh', name: 'tgTh' },
                { data: 'status', name: 'status' },
                
            ],           
        });

    });


</script>
@stop











