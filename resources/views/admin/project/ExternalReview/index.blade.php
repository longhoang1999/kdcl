@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
     @lang('project/Externalreview/title.danhgn')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/ExternalReview/externalreview.css') }}">

@stop

@section('title_page')
    @lang('project/Externalreview/title.danhgn')
@stop
@section('content')
<section class="content-body">
    <style>
        .metismenu{
            list-style: none;
        }
        .table td:first-child, .table th:first-child, .table tr:first-child {
        padding-left: 10px;
        }

        tr a.mt-4:hover{
            cursor: pointer;
        }
        p,strong,br,hr,b,small,i,u,em,mark,del,ins,sub,sup{
        word-wrap: break-word;
        }
        img{
            max-width: 100%;
            height: auto;
        }
    </style>
    <div class="body-flex">
      <div class="content-body-css">
            <h2>
                @lang('project/Selfassessment/title.dsbctdg')
            </h2>
            <ol class="d-flex">
                <li class="pr-2 pl-2"><a href="">@lang('project/Externalreview/title.trangchu')</a></li>

                    @if($KHBaCaoDetail)

                        <li class="pr-2 pl-2">/
                            {{$KHBaCaoDetail->ten_bc}}
                        </li>

                        <li class="pr-2 "> / {{$title}}</li>
                    @endif


            </ol>
             {{--  @include("admin.project.ExternalReview.include.tieuchuan_tieuchi") --}}
            @if($page == 'tieuchuan')
                @if(!$khtc)<!-- Nếu không có  id tiêu chí -->

                    @include ('admin.project.ExternalReview.include.tieuchuan_tieuchi')
                @else
                    @include ('admin.project.ExternalReview.include.tieuchi')
                @endif
            @elseif($page == 'ketluan')
                @include ('admin.project.ExternalReview.include.ketluan')
            @elseif($page == 'phuluc')
               @if($tag != 'pl4')  <!-- phụ lục 4 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                @if($tag == 'pl1')      <!-- phụ lục 1 -->
                                    @if($keHoachBaoCaoDetail2->loai_tieuchuan_bc == 'csgd')
                                        @include("admin.project.Database.data_school_csgd")
                                    @elseif($keHoachBaoCaoDetail2->loai_tieuchuan_bc == 'ctdt')
                                        @include("admin.project.Database.display_data")
                                    @else
                                        <h6>@lang('project/Externalreview/title.kcpl')</h6>
                                    @endif
                               {{-- @elseif($tag == 'pl2')  <!-- phụ lục 2 -->
                                    @include("kdcl::hoanthanh.phuluc9")
                                @elseif($tag == 'pl3')  <!-- phụ lục 3 -->
                                    @include ('kdcl::danhgiangoai.tonghop.include.phuluc3')
                                --}}
                                 @endif

                            </div>
                        </div>
                    </div>
                </div>

                @else <!-- phụ lục 4 -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="boxphuluc10">
                                <div class="pageHomeView">
                                    @include("admin.project.ExternalReview.include.phuluc10")
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class=" {{((!$id)?'pageHomeView':'ibox-content') }} ">
                                <div  class="form-horizontal ajaxForm">

                                  @if(!$id)
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

                                        <style>
                                            .css_scoll{
                                                display: none;
                                            }
                                            .content-body-css{
                                                width: 95%;
                                                background-color: white;
                                            }
                                        </style>

                                 @endif
                                    <div class="form-group">
                                        <div class="col-sm-12"> </div>
                                        <div class="col-sm-12 css-img">
                                            @php
                                                if($page == 'chung' || $page=='baocao'){
                                                    echo ( ($keHoachChung)?$keHoachChung->text:"");
                                                }
                                            @endphp
                                        </div>
                                    </div>

                                    <!-- <div class="hr-line-dashed"></div> -->

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="css_scoll">@include("admin.project.ExternalReview.include.sidebar") </div>
    </div>




</section>
@stop





{{-- page level scripts --}}
@section('footer_scripts')

<script>

    function show_tudanhgia(){
        $add_row = $('.arrow_active');
         if($(`#tudanhgia_bctdg`).is(':visible')){
            $(`#tudanhgia_bctdg`).hide();
            $add_row.removeClass('active');

        }else{
            $(`#tudanhgia_bctdg`).show();
            $add_row.addClass('active');
        }
    }

    function show_ketluan(){
        $add_row = $('.arrow_ketluan');
         if($(`#show_ketluan`).is(':visible')){
            $(`#show_ketluan`).hide();
            $add_row.removeClass('active');

        }else{
            $(`#show_ketluan`).show();
            $add_row.addClass('active');
        }
    }

    function show_phuluc(){
        $add_row = $('.arrow_phuluc');
         if($(`#show_phuluc`).is(':visible')){
            $(`#show_phuluc`).hide();
            $add_row.removeClass('active');

        }else{
            $(`#show_phuluc`).show();
            $add_row.addClass('active');
        }
    }

    function show_tieuchuan_chidl(a){
        $add_row = $(`.arrow_tc_${a}`);
         if($(`#tieuchuan_child_${a}`).is(':visible')){
            $(`#tieuchuan_child_${a}`).hide();
            $add_row.removeClass('active');

        }else{
            $(`#tieuchuan_child_${a}`).show();
            $add_row.addClass('active');
        }
    }

    $(".wrapper").addClass('hide_menu');
    $(".skin-josh").addClass("left-hidden");
    $(".skin-josh").removeClass("mini");

    $(function(){
        table = $('#table_danhgiangoai').DataTable({
            lengthMenu: [[7, 10, 20, -1], [7, 10, 20, "All"]],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.danhgiangoai.baocaotudanhgia.data') !!}",
            columns: [
                { data: 'ten_donvi', name: 'ten_donvi' },
                { data: 'ten_baocao', name: 'ten_baocao' },
                { data: 'nam_vietbao', name: 'nam_vietbao' },
                { data: 'thoidiem_bc', name: 'thoidiem_bc' },
                { data: 'actions', name: 'actions' },
            ],
        });
    });

    $(function(){
         $('.show_mcg').on('click','.mcGop',function(){
            let idmc_gop =  $(this).attr('id');
            let id = idmc_gop.substring(idmc_gop.indexOf('_')+1);
            window.location= "{!! route('admin.tudanhgia.preparereport.viewmcgop',0)!!}"+id;
         })

         $('.show_mcg').on('click','.mc',function(){
            let idmc_gop =  $(this).attr('id');
            let id = idmc_gop.substring(idmc_gop.indexOf('_')+1);
            window.location= "{!! route('admin.dambaochatluong.manaproof.showProof',0)!!}"+id;
         })

         $('.MC_Tc_Tchi').on('click','tr a.mt-4',function(){
            let id_mc = $(this).attr('d-id');

            window.location.href = "{!! route('admin.tudanhgia.preparereport.viewmcgop',0)!!}"+id_mc;
            // window.location.href = "{!! route('admin.dambaochatluong.manaproof.showProof',0)!!}"+id_mc;
         })

         $('body').on('click','.mcGop',function(){

            let id = $(this).attr('id').split('_')[1];
            window.location= "{!! route('admin.tudanhgia.preparereport.viewmcgop',0)!!}"+id;
        });

        $('body').on('click','.mc',function(){
            let id = $(this).attr('id').split('_')[1];
            window.location= "{!! route('admin.dambaochatluong.manaproof.showProof',0) !!}"+id;
        });
    })

    // $(document).ready(function () {
    //         // Lấy URL hiện tại
    //         var currentURL = window.location.href;

    //         // Xử lý phần side-menu để bôi đỏ item li nếu URL trùng khớp
    //         $("#side-menu li").each(function () {
    //             var anchor = $(this).find("a").attr("href");
    //             if (currentURL.includes(anchor)) {
    //                 $(this).css('background','red');
    //             }
    //         });
    //     });
</script>
@stop
