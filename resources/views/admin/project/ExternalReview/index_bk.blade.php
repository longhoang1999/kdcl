@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.dsbctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/ExternalReview/externalreview.css') }}">

@stop

@section('title_page')
    @lang('project/Selfassessment/title.dsbctdg')
@stop

@section('content')
<section class="content-body">
    <div class="body-flex">
        <div class="content-body-css">
            <h2>
                @lang('project/Selfassessment/title.dsbctdg')
            </h2>
            <ol class="d-flex">
                <li class="pr-2 pl-2"><a href="">@lang('project/ExternalReview/title.trangchu')</a></li>
                
                    @if($KHBaCaoDetail)
                        /
                        <li class="pr-2 pl-2">
                            {{$KHBaCaoDetail->ten_bc}}
                        </li>
                        
                        <li class="pr-2 "> / {{$title}}</li>
                    @endif
                
                
            </ol>
             {{--  @include("admin.project.ExternalReview.include.tieuchuan_tieuchi") --}}
            @if($page == 'tieuchuan')
                @if(!$khtc)<!-- Nếu không có  id tiêu chí -->
                    {{--@include ('kdcl::danhgiangoai.tonghop.include.tieuchuan_tieuchi')--}}
                @else
                    @include ('admin.project.ExternalReview.include.tieuchi')
                @endif
            @elseif($page == 'ketluan')
               {{-- @include ('kdcl::danhgiangoai.tonghop.include.ketluan')--}}
            @elseif($page == 'phuluc')
                {{--@if($tag != 'pl4')  <!-- phụ lục 4 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                @if($tag == 'pl1')      <!-- phụ lục 1 -->
                                    @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'csdt')
                                        @include("kdcl::hoanthanh.phuluc8-csdt")
                                    @elseif($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                        @include("kdcl::hoanthanh.phuluc8")
                                    @else
                                        <h6>Không có phụ lục cho loại tiêu chuẩn của bộ tiêu chuẩn này!</h6>
                                    @endif
                                @elseif($tag == 'pl2')  <!-- phụ lục 2 -->
                                    @include("kdcl::hoanthanh.phuluc9")
                                @elseif($tag == 'pl3')  <!-- phụ lục 3 -->
                                    @include ('kdcl::danhgiangoai.tonghop.include.phuluc3')
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
                @endif--}}

            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class=" {{((!$id)?'pageHomeView':'ibox-content') }} ">
                                <div  class="form-horizontal ajaxForm">
                                
                                  @if(!$id)
                                        <!-- <div class="alert alert-warning">
                                            Vui lòng chọn Báo cáo, để xem danh sách mệnh đề tương ứng
                                        </div> -->
                                        @include("admin.project.ExternalReview.include.list_department")

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
        console.log($add_row)
         if($(`#tieuchuan_child_${a}`).is(':visible')){
            $(`#tieuchuan_child_${a}`).hide();
            $add_row.removeClass('active');

        }else{
            $(`#tieuchuan_child_${a}`).show();
            $add_row.addClass('active');
        }
    }
    

</script>
@stop












