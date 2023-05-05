@extends('admin/layouts/default')

@section('title')
    @lang('project/Externalreview/title.thuvmc')
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/ExternalReview/externalreview.css') }}">

@stop

@section('title_page')
    @lang('project/Externalreview/title.thuvmc')
@stop
@section('content')
<section class="content-body">
    
    <table class="table table-striped table-bordered" id="table">
        <thead>
            <tr>
                <th>@lang('project/Externalreview/title.tieude')</th>
                <th>@lang('project/Externalreview/title.sohieu')</th>
                <th>@lang('project/Externalreview/title.ngaybanhanh')</th>
                <th>@lang('project/Externalreview/title.noibanhanh')</th>
                <th>@lang('project/Externalreview/title.donvql')</th>
                <th>@lang('project/Externalreview/title.loaimc')</th>
                <th>@lang('project/Externalreview/title.xacnhan')</th>
                <th>@lang('project/Externalreview/title.quanly')</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

</section>
@stop



@section('footer_scripts')

<script>
        
        //  $(function () {
        //     table = $('#table').DataTable({
        //         responsive: true,
        //         processing: true,
        //         serverSide: true, 
        //         searching:false,
        //         ajax: "{{ route('admin.danhgiangoai.baocaotudanhgia.thuvien') }}?id="+{{$id}},
        //         order: [], 
        //         columns: [

        //             { data: 'id'},
        //             { data: 'id' },
        //         ],           
        //     });

        // });

         $( function () {
            table = $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url:" {{ route('admin.danhgiangoai.baocaotudanhgia.thuvien') }}?id="+{{$id}},
                    type: 'GET',
                },

                columns: [ 
                    {data:'ten_ngan'},
                    {data:'sohieu'},
                    {data:'ngay_ban_hanh'},
                    {data:'noi_banhanh'},
                    {data:'tendonvi'},
                    {data:'trang_t'},
                    {data:'status'},
                    {data:'quanly'},
                    // {data:'status'},
                   

                ]


            });

        });
         // $('.a').on('click',function(){
         //    $.ajax({
         //            url: "{!! route('admin.danhgiangoai.baocaotudanhgia.thuvien') !!}",
        
         //            error: function(err) {

         //            },
         //            success: function(data) {   
         //                console.log(data);
         //            }

         //        });
         // })
         

</script>
@stop