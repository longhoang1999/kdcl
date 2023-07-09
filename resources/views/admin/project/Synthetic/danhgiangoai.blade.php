@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<style>
    .form-control{
        height: 34px;
        appearance: auto !important;
    }
    .select2-container .select2-selection--single{
        height: 43px !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.bctdg')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <h2>
        Nhận xét báo cáo đánh giá ngoài 
    </h2>


    <div class="line"></div><br/>
    
    <div class="col-md-1" style="text-align: right; float: right;">                
        <a href="{{ route('admin.tonghop.dbcl.tailieudgn') }}" class="btn btn-benchmark" style="width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Tải file">
            <i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;"></i>
        </a>
    </div>
    <div style="background-color: white;">   
         <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
                <tr>
                    <th>Năm</th>
                    <th>Tên báo cáo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="tbodys">                        
            </tbody>                
        </table> 
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
                lengthMenu: [[6, 10, 20, -1], [6, 10, 20, "All"]],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('admin.tonghop.dbcl.datadgn') !!}",
                    type: "POST",
                },
                columns: [
                    { data: 'nam', name: 'nam'},
                    { data: 'ten_bc', name: 'ten_bc'},
                    { data: 'actions', name: 'actions'},
                   
             
                ],   
            });
    });
    
    $(document).ready(function() {
      $('#select2').select2();
      $('#select_user').select2();
    });

</script>
@stop











