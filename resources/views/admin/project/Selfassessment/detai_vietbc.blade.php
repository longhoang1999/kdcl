@extends('admin/layouts/default')
@section('title')
    @lang('project/Selfassessment/title.tqkhbc')
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/custom-datatable.css') }}">
<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<style type="text/css">
    .row4 {
        width: 46% !important;
    }
    .row3 {
    width: 21% !important;
    }
    /* .row5 {
    width: 10% !important;
    } */
    .row1{
        width: 18% !important;
    }
    .row2{
        width: 15% !important;
    }
    i.bi{
        font-size: 20px;
        color: lightgreen;
    }

    .td_1{
        width: 42.66%;
        vertical-align: middle;
    }
    .td_2{
        width: 19.35%;
        vertical-align: middle;
    }
    .td_3{
        width: 13.7%;
        vertical-align: middle;
    }
    .td_4{
        width: 14.1%;
        vertical-align: middle;
    }
    .td_5{
        text-align: center;
        vertical-align: middle;
    }
    .vertical{
        vertical-align: middle;
    }
    .rounded{
        border-radius: 5px !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.tqkhbc')
    
@stop

@section('content')

    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
        <h1 class="text-center">{{$tenbaocao}}</h1>
        <div class="container text-center m-5 rounded"> 
            <a href="{{ route('admin.tudanhgia.report.detail_bc',['id' => $id_kehoach]) }}" class="btn btn-light rounded">@lang('project/Selfassessment/title.khcb')</a>
            <a href="{{ route('admin.tudanhgia.report.detail_baocao',['id' => $id_kehoach])}}" class="btn btn-danger rounded">@lang('project/Selfassessment/title.khvbc')</a>
        </div>
        @if($phutrach)
            <div class="form-group text-center rounded">
                <div class="btn btn-warning btn-xs rounded">
                    <b>@lang('project/Selfassessment/title.ttct') :</b>
                    {{ $phutrach->name }}
                    ({{ $phutrach->ten_donvi }})
                </div>
            </div>
        @endif
        

        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/Selfassessment/title.tenbc')</th>
                <th >@lang('project/Selfassessment/title.thoigianth')</th>
                <th >@lang('project/Selfassessment/title.conlai')</th> 
                <th >@lang('project/Selfassessment/title.truongnhom')</th>
                <th >@lang('project/Selfassessment/title.nsth')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table>
    
    
   
<!-- page trang ở đây -->

    <!-- Modal -->
<!-- modal nhân sự thực hiện -->
<div class="modal inmodal fade" id="modal_nhansu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse">
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">@lang('project/Selfassessment/title.danhsachnhansu')</h4>
                <div class="add_tc">
                    
                </div>
            </div>
            <div class="modal-body">
                <div class="list-group truong_nhom_bc text-center mb-5" style="background-color: #f2f2f2a3;">
                         
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="list-group exchangeList_tn text-center" style="background-color: #f2f2f2a3;">
                            
                        </div>
                    </div>

                    <div class="col-lg-2 text-center justify-content-center">
                        <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                    </div>
                    <div class="col-lg-5">

                        <div class="list-group exchangeList_th text-center" style="background-color: #f2f2f2a3;">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
            </div>
        </div>
    </div>
</div>
<!-- /Kết thúc page trang -->
    
    <!-- Kết thúc trang -->
</section>
@stop



@section('footer_scripts')

<script type="text/javascript">
        $(function(){
            table = $('#table').DataTable({
                lengthMenu: [[6, 10, 20, -1], [6, 10, 20, "All"]],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{!! route('admin.tudanhgia.report.data_deatial_khbc') !!}?id="+{{$id_kehoach}},
                columns: [
                    { data: 'tieuchuan', name: 'tieuchuan', className: ' dt-control td_1'},
                    { data: 'time', name: 'time', className: 'td_2 text-center' },
                    { data: 'conlai', name: 'conlai', className: 'td_3 text-center' },
                    { data: 'truongnhom', name: 'truongnhom', className: 'td_4 text-center' },
                    { data: 'actions', name: 'actions', className: 'td_5 text-center'},
             
                ],   
            });
        });

        $('.table-striped').on('click','.show_nhansu',function(){
            let id_khtc = $(this).attr('d-id');
            $('.exchangeList_th').empty();
            $('.exchangeList_tn').empty();
            $('.truong_nhom_bc').empty();

            $('.exchangeList_th').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nsth')</p>")
            $('.exchangeList_tn').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nskt')</p>")
            $('.truong_nhom_bc').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.truongnhom')</p>")
                $.ajax({
                        url: "{{route('admin.tudanhgia.report.show_nskt')}}",
                        type: "POST",
                        data:{
                            id_khtc : id_khtc,
                            _token: '{{ csrf_token() }}',
                        },    
                        error: function(err) {

                        },

                        success: function(data) {

                            for (const [key, value] of Object.entries(data)) {
                                if(value[1]){
                                    $('.exchangeList_th').append(`<p>${value[1]}</p>`);
                                }
                                
                                if(value[2]){
                                    $('.exchangeList_tn').append(`<p>${value[2]}</p>`);
                                }
                                if(value[3]){
                                    $('.truong_nhom_bc').append(`<p>${value[3]}</p>`);
                                }
                                
                            }

                        },
                });
            $('#modal_nhansu').modal('show');
        })



         $('#table tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                let id_tc = row.data().id;
                $.ajax({
                        url: "{{route('admin.tudanhgia.report.show_tctieuchi_bc')}}",
                        type: "GET",
                        data:{
                            id_tc : id_tc,
                            id_kehoach : {{$id_kehoach}},
                            // _token : {{csrf_token()}},
                        },    
                        error: function(err) {
                            alert("@lang('project/Selfassessment/title.bcndtt')");
                        },

                        success: function(data) {
                            let times;
                            let x = '';
                            let s ='';
                            for (const [key, value] of Object.entries(data)) {
                                if(value[8]){

                                }
                                times = value[3]+'<i class="fas fa-arrow-right"></i>'+value[4];
                                if (value[3] == '' || value[4]== null){
                                    times = 'Không có dữ liệu';
                                }
                                   x += `<tr class="table table-hover table-more">
                                            <td class = "menhde_ct row4 vertical" id_md = ${value[9]} id_khtc = ${value[10]}>
                                                <span class="id_tc_${value[9]}"><i class="bi bi-plus-circle-fill"></i></span>
                                                ${value[8]+'.'+value[1]} : ${value[2]}
                                            </td>     
                                            <td class = "row3 text-center vertical">${times}</td>
                                            <td class = "row2 text-center vertical">${value[6]}</td>
                                            <td class = "row2 text-center vertical">${value[5]}</td>
                                            <td class = "row1 text-center vertical">${value[7]}</td>
                                        </tr>`
                            }

                             // s =   `
                             //        <table class="table table-hover table-more">
                             //            ${x}
                             //        </table>
                             //        `
                            row.child(x).show();
                            tr.addClass('shown');
                        },
                        
                })
                
              
                
            }
        });





 $('.table-striped').on('click','.show_nhansu_tc',function(){
    let id_khtc = $(this).attr('d-id');
    $('.exchangeList_th').empty();
    $('.exchangeList_tn').empty();
    $('.truong_nhom_bc').empty();
    $('.exchangeList_th').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nsth')</p>")
    $('.exchangeList_tn').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nskt')</p>")
    $('.truong_nhom_bc').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.truongnhom')</p>")
        $.ajax({
                url: "{{route('admin.tudanhgia.report.show_nskt_tc')}}",
                type: "POST",
                data:{
                    id_khtc : id_khtc,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {

                },

                success: function(data) {
                    for (const [key, value] of Object.entries(data)) {
                        if(value[1]){
                            $('.exchangeList_th').append(`<p>${value[1]}</p>`);
                        }
                        if(value[2]){
                            $('.exchangeList_tn').append(`<p>${value[2]}</p>`);
                        }
                        if(value[3]){
                            $('.truong_nhom_bc').append(`<p>${value[3]}</p>`);
                        }
    
                    }
                   
                },
        });
    $('#modal_nhansu').modal('show');
});


$('#table tbody').on('click', 'td.menhde_ct', function () {
    let tr = $(this).closest('tr');
    let icons = $(this).find('span').html();
    var row = table.row(tr);
    // console.log(row)
    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    } else {
        let id_md = $(this).attr('id_md');
        let id_khtc = $(this).attr('id_khtc');

        // Open this row
        // let id_tc = row.data().id;

        $.ajax({
                url: "{{route('admin.tudanhgia.report.show_tctieuchi_md')}}",
                type: "GET",
                data:{
                    id_tc : id_md,
                    id_kehoach : {{$id_kehoach}},
                    id_khtc : id_khtc,
                    // _token : {{csrf_token()}},
                },    
                error: function(err) {
                    alert("@lang('project/Selfassessment/title.bcndtt')");
                },

                success: function(data) {
                    // console.log(data)
                    let change_tc = $(`.id_tc_${id_md}`).html();
                    let times;
                    let x2 = '';
                    let s2 ='';
                    for (const [key, value] of Object.entries(data)) {

                        times = value[3]+'<i class="fas fa-arrow-right"></i>'+value[4];
                        if (value[3] == '' || value[4]== null){
                            times = 'Không có dữ liệu';
                        }
                           x2 += `
                                <tr class="table table-hover table-more hide_md_${id_md}">
                                    <td class = "row4 vertical"><i>(${value[1]}) : ${value[2]}</i></td>     
                                    <td class = "row3 text-center vertical"><i>${times}</i></td>
                                    <td class = "row2 text-center vertical"><i>${value[6]}</i></td>
                                    <td class = "row2 text-center vertical"><i>${value[5]}</i></td>
                                    <td class = "row1 text-center vertical"><i>${value[7]}</i></td>
                                </tr>
                                `
                    }

                     // s2 =   `
                     //        <tr class="table table-hover table-more hide_md_${id_md}">
                     //            ${x2}
                     //        </tr>
                     //        `
                    row.child(x2).show();
                    // icons = '<i class="bi bi-dash-circle-fill"></i>';
                    // console.log($(this).find('span').html());

                    if(change_tc == '<i class="bi bi-plus-circle-fill"></i>'){
                        tr.after(x2);
                        $(`.id_tc_${id_md}`).html('<i class="bi bi-dash-circle-fill"></i>');
                        $(`.id_tc_${id_md} i`).css('color','coral');
                    }else{
                        $(`.hide_md_${id_md}`).remove();
                        $(`.id_tc_${id_md}`).html('<i class="bi bi-plus-circle-fill"></i>');
                    }
                        
                   
                    
                    tr.addClass('shown');


                },
                
        });  
        
    }
});

$('.table-striped').on('click','.show_nhansu_md',function(){
    let id_khmd = $(this).attr('d-id');
    $('.exchangeList_th').empty();
    $('.exchangeList_tn').empty();
    $('.truong_nhom_bc').empty();
    $('.exchangeList_th').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nsth')</p>");
    $('.exchangeList_tn').append("<p class='btn btn-primary p-4'>@lang('project/Selfassessment/title.nskt')</p>");
        $.ajax({
                url: "{{route('admin.tudanhgia.report.show_nskt_md')}}",
                type: "POST",
                data:{
                    id_khmd : id_khmd,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {

                },

                success: function(data) {
                    for (const [key, value] of Object.entries(data)) {
                        if(value[1]){
                            $('.exchangeList_th').append(`<p>${value[1]}</p>`);
                        }
                        if(value[2]){
                            $('.exchangeList_tn').append(`<p>${value[2]}</p>`);
                        }
                    }
                   
                },
        });
    $('#modal_nhansu').modal('show');
});
</script>


@stop

