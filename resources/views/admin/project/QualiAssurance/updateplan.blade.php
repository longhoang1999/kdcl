@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.lkh')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">

@stop

@section('title_page')
    @lang('project/QualiAssurance/title.lkh')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->

<!-- page trang ở đây -->
<section class="content-body">
    <div class="row">
        <h2>
            @lang('project/QualiAssurance/title.khdbcln' ):   
        </h2>
        <div class="col-md-1 ">
            <select class="form-control select2">
                @for($i = 1990;$i <= intVal(date('Y'));$i++)
                <option>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div> 
    <div class="form-standard">
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/QualiAssurance/title.lvuc')</th>
                <th >@lang('project/QualiAssurance/title.nbd')</th>
                <th >@lang('project/QualiAssurance/title.nht')</th>
                <th >@lang('project/QualiAssurance/title.dvpt')</th>
                <th >@lang('project/QualiAssurance/title.nskt')</th>
                {{-- <th >@lang('project/QualiAssurance/title.hdong')</th> --}}
                
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>


        <div class="item-group-button right-block mb-2">
            <button class="btn btn-success btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16">
                    <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                  </svg>  
                <span>@lang('project/QualiAssurance/title.huy')</span>
            </button>
            <button class="btn btn-success btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                        <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                    </svg>   
                <span>@lang('project/QualiAssurance/title.luu')</span>
            </button>
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
    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.dambaochatluong.planning.showPlan') !!}",
            columns: [
                { data: 'linh_vuc' },
                { data: 'ngayBatdau' },
                { data: 'ngayHoanthanh' },
                { data: 'noi_dung' },
                { data: 'dv_kiemtra' },
                // { data: 'actions' },
            ],              
        });
    }); 


    $(".select2").select2(); 
</script>

@stop
    