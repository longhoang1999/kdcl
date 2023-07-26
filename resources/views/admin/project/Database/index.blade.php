@extends('admin/layouts/default')
@section('title')
    Cơ sở dữ liệu
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiAssurance.css') }}">
<style type="text/css">

</style>
@stop

@section('title_page')
    <h2>Cơ sở dữ liệu</h2>
    
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
        
        <table class="table table-striped table-bordered" id="table_danhgiangoai" width="100%">
            <thead>
                <tr>
                    <th >@lang('project/Externalreview/title.tdv')</th>
                    <th >@lang('project/Externalreview/title.tbc')</th>
                    <th >@lang('project/Externalreview/title.nvbc')</th>
                    <th >@lang('project/Externalreview/title.tdbc')</th>
                    <th >@lang('project/Externalreview/title.chitiet')</th>
                </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
<!-- page trang ở đây -->

    
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
</section>
@stop



@section('footer_scripts')

<script type="text/javascript">
   $(function(){
        table = $('#table_danhgiangoai').DataTable({
            lengthMenu: [[7, 10, 20, -1], [7, 10, 20, "All"]],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.tudanhgia.database.data') !!}",
            columns: [
                { data: 'ten_donvi', name: 'ten_donvi' },
                { data: 'ten_baocao', name: 'ten_baocao' },
                { data: 'nam_vietbao', name: 'nam_vietbao' },
                { data: 'thoidiem_bc', name: 'thoidiem_bc' },
                { data: 'actions', name: 'actions' },
            ],            
        });
    });
</script>
@stop

