@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
    <link href="{{ asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
    <link href="{{ asset('css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
    <!-- <link href="{{ asset('css/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet" type="text/css"/> -->
    <link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
    <link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
    <!-- sweetalert2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.3/sweetalert2.css">
    <style>
        .select2-container{
            width: 100% !important;
        }
        iframe{
            min-height: 12rem !important;
        }
        .ibox-content table,th,tr,td{
            border: solid 1px lightgrey;
        }
        .nav-link{
            padding: 0 !important;
            font-size: 16px;
        }
        .MsoNormalTable{
            width: 100% !important;
        }
        .pr-2, .px-2 {
            padding-right: 0.5rem !important;
        }
        .form-control{
            width: 94%;
        }
        .show_all_mc{
            width: 10rem;
            border-radius: 6px;
            border: none;
            height: 41px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: aquamarine;
        }
        .selectmc_mota{
            width: 98% !important;
        }
        .add_bk{
            background: #f5f8fa !important;
        }
        .bg-info{
            background: white !important;
        }
        .add_bk2{

        }
        #inprogress{
            list-style: none;
            padding: inherit;
        }
        .arrow_content .block_content{
            padding-bottom: 30px;
        }
        i {
            font-size: 1.3rem !important;
        }
        span button i{
            font-size: 30px !important;
        }
        .btn i{
            font-size: 30px !important;
        }
    </style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.bctdg')
@stop

@section('content')
<section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->   
    <div class="show_css">
        <h2>
            @foreach($KHBaoCao as $value)
                {{ $value->ten_bc }}
            @endforeach
        </h2>

        <ol class="show_css_list_ol">
            <li>
                <a href="">@lang('project/Selfassessment/title.trangchu')</a>
            </li>
            /
            <li><span>@lang('project/Selfassessment/title.baocao')</span></li>
            /
            <li><strong>
                @foreach($KHBaoCao as $value)
                    {{ $value->ten_bc }}
                @endforeach
            </strong></li>
        </ol>
    </div>

    <div class="target">
        <h3>
            TC {{ isset($tieuChuan->stt)?$tieuChuan->stt:''}}
        </h3>
        <h2>
            <strong>{{isset($tieuChuan->mo_ta)?$tieuChuan->mo_ta:''}}</strong>
        </h2>
            @if($sum_danhgia > 0)
                <small class="text-danger">
                    <i class="fas fa-star"></i>
                     @lang('project/Selfassessment/title.danhgiamuc') {{ $sum_danhgia }}
                </small>
            @endif
            @if(isset($tieuChuan->trang_thai))
                @if($tieuChuan->trang_thai=='congbo')
                    <div class="label label-success">@lang('project/Selfassessment/title.dacongbo')</div>
                @endif
            @endif
    </div>


    <div class="arrow_content">
        <div class="arrow_content_text">
           @if($keHoachBaoCaoDetail->loai_tieuchuan != 'csgd')
                @if($keHoachTieuChuan->id_truong_nhom == Sentinel::getUser()->id || $keHoachBaoCaoDetail->ns_phutrach == Sentinel::getUser()->id || Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                    <div class="group_back">
                        <div class="arrow_content_text_css">
                            <h5>@lang('project/Selfassessment/title.modau')</h5>
                            @if(!Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                            <button id="show_content" onclick="showhidetieuchi()"><i class="fa fa-chevron-up" id="show_arrow"></i></button>
                            @endif
                        </div>
                        <div id="content_text" >
                            <div class="text_contents p-5" id="show_textcontent">
                                @if($baoCaoTieuChuan)
                                    @foreach($nhanxetbc as $nhanXet)
                                        @php
                                            if(str_contains($baoCaoTieuChuan->modau,$nhanXet->noidung)){
                                                $baoCaoTieuChuan->modau = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-data='".e($nhanXet->nhanxet)."'>$nhanXet->noidung</a>",$baoCaoTieuChuan->modau);
                                            }
                                        @endphp
                                    @endforeach
                                    <span class="update_modau_bc">{!!$baoCaoTieuChuan->modau!!}</span>
                                @else
                                    <div class="add_text_md"> 
                                        <i class="text-muted">@lang('project/Selfassessment/title.bvddtmd')</i>
                                    </div>
                                @endif
                            </div>
                            <div id="show-text" style="display: none;">

                                <form action="{{route('admin.tudanhgia.detailedplanning.updatetieuchuan')}}" method="POST">
                                    <input name="id_tc" class="id_tc" type="hidden" value="{{ $tieuchuan_id }}">
                                    <input name="id_khbc" class="id_khbc" type="hidden" value="{{ $id_khbc }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card my-3">
                                            
                                                <div class="bootstrap-admin-card-content">
                                                    <textarea class="tinymce_full tieuchuan_save" name="modau">
                                                        @if($baoCaoTieuChuan)
                                                            {!! $baoCaoTieuChuan->modau!!}
                                                        @endif
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right setupdate">

                                        <button type="button" class="click2cancel btn btn-default" id="modau_tc" onclick="hide_tc()">
                                            <i class="fas fa-chevron-left"></i> @lang('project/Selfassessment/title.quaylai')
                                        </button>

                                        <button type="button" onclick="update_modau()" class="btn btn-info ladda-button" data-style="expand-right">
                                                <i class="fas fa-save"></i> @lang('project/Selfassessment/title.luu')
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        @if($baoCaoTieuChuan)
                            @include("admin.project.Selfassessment.comment",['kieu'=>'tieuchuan_modau','id'=>$baoCaoTieuChuan->id,'id_kehoach_bc'=>$id_khbc])
                        @endif
                    </div>
                @endif
           @endif
            @foreach($tieuchuans_tieuchi->tieuchi as $kehoachtieuchi)
                <div class="block_content" style="position: relative;">
                    <div class="block_content_title">
                        <h5><strong>{{$tieuChuan->stt}}.{{$kehoachtieuchi->stt}}</strong></h5>
                        <h5 onclick="showhidetieuchi2({!!$kehoachtieuchi->id!!})"><a class="collapse-link huongDanTieuChi" d-id="{{ $kehoachtieuchi->id }}">{{ $kehoachtieuchi->mo_ta }}</a></h5>
                    </div>
                    <div class="ibox-tools">

                        <a title="Mốc chuẩn" class="mocChuanTieuChi"
                           d-id="{{ $kehoachtieuchi->id }}" >
                            <i class="fas fa-book"></i>
                        </a>

                        <a data-toggle="tooltip" title="Minh chứng tối thiểu" class="minhChungTTTieuChi"
                           d-id="{{ $kehoachtieuchi->id }}">
                            <i class="fas fa-minus-circle"></i>
                        </a>
                        <!-- cần sửa lại if này -->

                        @if(isset($kehoachtieuchi->menhde_baocao_start))
                            <a data-toggle="tooltip" title="Đánh giá" class="danhGiaTieuChi"
                               d-danhgia="{{ $kehoachtieuchi->menhde_baocao_start->danhgia }}">
                                    <span class="text-danger">
                                    <i class="fas fa-star "></i>
                                     <span class="danhgiaomuc_{{$kehoachtieuchi->id}}">
                                         {{ $kehoachtieuchi->menhde_baocao_start->danhgia }}
                                     </span>
                                    </span>
                            </a>
                        @endif

                        <span class="m-l-md uploadcb">

                            @if($kehoachtieuchi->baocao_tieuchi)
                                @if($kehoachtieuchi->baocao_tieuchi->trang_thai=="dangsua")
                                    <button class="btn ladda-button btn-xs congBoTieuChi congBoTieuChi_{{isset($kehoachtieuchi->id) ? $kehoachtieuchi->id : '' }} data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.cbtc')"
                                                data-style="expand-right"
                                                d-id="{{isset($kehoachtieuchi->baocao_tieuchi->id) ? $kehoachtieuchi->baocao_tieuchi->id : ''}}"
                                                d-tieuchi_id="{{isset($kehoachtieuchi->id) ? $kehoachtieuchi->id : ''}}" 
                                                d-menhde = "{{isset($kehoachtieuchi->menhde_khmd->id) ? $kehoachtieuchi->menhde_khmd->id : ''}}" 
                                                d-kehmd = "{{isset($kehoachtieuchi->menhde_khmd->id_khmd) ? $kehoachtieuchi->menhde_khmd->id_khmd : ''}}" 
                                                >
                                                <i class="bi bi-bookmark-check-fill" style="font-size: 35px;color: #009ef7;"></i>
                                    </button>
                                @elseif($kehoachtieuchi->baocao_tieuchi->trang_thai=="congbo")
                                    <div class="label label-success" style="position: absolute;left: 14px;
                                    bottom: 2px;">@lang('project/Selfassessment/title.dacongbo')</div>
                                     @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                                    <button class="btn ladda-button btn-xs moLaiTieuChi congBoTieuChi_{{$kehoachtieuchi->id}} data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.molaitieuchi')"
                                            data-style="expand-right"
                                            d-id="{{$kehoachtieuchi->baocao_tieuchi->id}}"
                                            d-tieuchi_id="{{$kehoachtieuchi->id}}">
                                            <i class="fas fa-redo" style="font-size: 25px;color: #50cd89;"></i>
                                    </button>
                                    @endif 
                                @endif
                            @else
                                <button class="btn ladda-button btn-xs congBoTieuChi congBoTieuChi_{{$kehoachtieuchi->id}} data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.cbtc')"
                                        data-style="expand-right"
                                        d-id="0"
                                        d-tieuchi_id="{{$kehoachtieuchi->id}}" 
                                        d-menhde = "{{$kehoachtieuchi->menhde_khmd->id}}" 
                                        d-kehmd = "{{$kehoachtieuchi->menhde_khmd->id_khmd}}"
                                        >
                                        <i class="bi bi-bookmark-check-fill" style="font-size: 35px;color: #009ef7;"></i>
                                </button>
                            @endif
                        </span>
                    </div>

                    <div class="ibox_cotent css_width" id="show_block_content_{!!$kehoachtieuchi->id!!}" style="display: none;">
                    @if(isset($kehoachtieuchi->bc_menhde))     
                        @if(count($kehoachtieuchi->bc_menhde) > 0)
                            @foreach($kehoachtieuchi->bc_menhde as $menhde)
                                <!-- @php 
                                    echo($menhde->id);
                                @endphp -->
                                {{--@continue(!$menhde->menhde)--}}
                                <div class="ibox-title border-bottom">
                                    <div class="ibox-tools2">
                                        <h5>{{$menhde->mo_ta}}</h5>
                                        @if($menhde)
                                            @if($menhde->trang_thai=='dangsua' || $menhde->trang_thai=='nhanxet')
                                                <button class="btn ladda-button btn-xs congBoMenhDe congBoMenhDe_css data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.hoanthanh')"
                                                        data-style="expand-right"
                                                        d-id="{{$menhde->id}}"
                                                        d-menh_id="{{$menhde->menhde_id}}">
                                                        <i class="bi bi-check-square-fill" style="font-size: 25px;color: #009ef7;"></i> 
                                                </button>
                                            @elseif($menhde->trang_thai=='congbo')
                                                <div class="label label-success">@lang('project/Selfassessment/title.dahoanthanh')</div>
                                                @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                                                <button class="btn ladda-button btn-xs moLaiMenhDe congBoMenhDe_css data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.molai')"
                                                        data-style="expand-right"
                                                        d-id="{{$menhde->id}}">
                                                        <i class="fas fa-redo" style="font-size: 25px;color: #50cd89;"></i>
                                                </button>
                                                @endif
                                            @endif
                                        @else
                                            <button class="btn btn-xs congBoMenhDeFake congBoMenhDe_css data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.hoanthanh')">
                                                <i class="bi bi-check-square-fill" style="font-size: 25px;color: #009ef7;"></i> 
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <div class="ibox-content border-bottom">
                                    <h3>@lang('project/Selfassessment/title.mota')</h3>

                                    @php

                                        if($kehoachtieuchi->baocao_tieuchi){
                                            if(!empty($kehoachtieuchi->baocao_tieuchi->trang_thai)){
                                                $editable = ($kehoachtieuchi->baocao_tieuchi->trang_thai=='dangsua' || $kehoachtieuchi->baocao_tieuchi->trang_thai=='nhanxet')?"click2edit hover-shadows":"";
                                            }
                                            
                                            
                                        }else{
                                            $editable="click2edit hover-shadows";
                                        }
                                        $trangthai='';
                                        if(!empty($kehoachtieuchi->baocao_tieuchi->trang_thai)){
                                            $trangthai=!empty($kehoachtieuchi->baocao_tieuchi->trang_thai)?$kehoachtieuchi->baocao_tieuchi->trang_thai:'';
                                        }
                                    @endphp
                                    <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">                                    
                                        <div class="texts_{!! $menhde->id !!} showtieuchi_{{$kehoachtieuchi->id}} p-4" onclick="showbaocaomenhde({!! $menhde->id !!},{!! $trangthai=="dangsua" ? 1 : 0 !!})">
                                            @if($menhde)

                                                @foreach($nhanxetbc as $nhanXet)
                                                    @php
                                                        if(str_contains($menhde->mo_ta,$nhanXet->noidung)){
                                                            $menhde->mota = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-data='".e($nhanXet->nhanxet)."'>$nhanXet->noidung</a>",$menhde->mota);
                                                        }
                                                    @endphp
                                                @endforeach
                                                <span class="update_mota_bc_{{$menhde->id}} update_mota_bc_pr_{{$kehoachtieuchi->id}}">{!! $menhde->mota !!}</span>
                                            @else
                                                <i class="text-muted">@lang('project/Selfassessment/title.bvddtmt')</i>
                                            @endif
                                        </div>

                                        <div id="shows_{!! $menhde->id !!}" style="display: none;" class="exit_{{$kehoachtieuchi->id}}">
                                            <form action="{{route('admin.tudanhgia.detailedplanning.updatemenhde')}}" method="POST">
                                                <input name="id_menhde" type="hidden" class="id_md_mt_{{$menhde->id}}" value="{{ $menhde->menhde_id }}">
                                                <input name="id_khbc" type="hidden" class="id_khbc_mt_{{$menhde->id}}" value="{{ $id_khbc }}">
                                                <!-- <input name="id_bc_md" type="hidden" class="id_baocao_mt_{{$menhde->id}}" value="{{$menhde->id}}"> -->
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card my-3">
                                                
                                                            <div class="bootstrap-admin-card-content">
                                                                <textarea class="tinymce_full_md menhde_mt_{{$menhde->id}} menhde_mt_tc_{{$menhde->tieuchi_id}}" style="width: 100%;" id="menhde_mota_dm_{{ $tieuChuan->id}}_{{ $menhde->tieuchi_id}}_{{$menhde->id}}" tieu_chi_id = "$menhde->tieuchi_id" name="mota_md">                     
                                                                    @if($menhde)
                                                                        <div class="menhde_minhchung_id_{{$menhde->id}}  menhde_minhchung_text_{{$kehoachtieuchi->id}}}}border-bottom"> 
                                                                            {!! $menhde->mota !!}
                                                                        </div>
                                                                    @endif
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right setupdate">

                                                    <button type="button" class="click2cancel btn btn-default" onclick="hied_md({!! $menhde->id!!})">
                                                        <i class="fas fa-chevron-left"></i> @lang('project/Selfassessment/title.quaylai')
                                                    </button>

                                                    <button type="button" onclick="update_md_mt({!! $menhde->id!!})" class="btn btn-info ladda-button" data-style="expand-right">
                                                        <i class="fas fa-save"></i> @lang('project/Selfassessment/title.luu')
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                    @if($menhde->id)
                                        @include("admin.project.Selfassessment.comment",['kieu'=>'menhde_mota','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                    @endif 
                                <div class="hr-line-dashed"></div>

                                <h3>@lang('project/Selfassessment/title.diemmanh')</h3>

                                <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">
                                    <div class="texts2_{!! $menhde->id !!} p-2" onclick="showbaocaomenhde2({!! $menhde->id !!},{!! $trangthai=="dangsua" ? 1 : 0 !!})">
                                        @if($menhde)
                                            @foreach($nhanxetbc as $nhanXet)
                                                @php
                                                    if(str_contains($menhde->mo_ta,$nhanXet->noidung)){
                                                        $menhde->diemmanh = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-data='".e($nhanXet->nhanxet)."'>$nhanXet->noidung</a>",$menhde->diemmanh);
                                                    }
                                                @endphp
                                            @endforeach
                                            <span class="update_diemmanh_bc_{{$menhde->id}}">{!! $menhde->diemmanh !!}</span>
                                        @else
                                            <i class="text-muted">@lang('project/Selfassessment/title.bvddtdm')</i>
                                        @endif
                                    </div>
                                    <div id="shows2_{!! $menhde->id !!}" style="display: none;">
                                        <form action="{{route('admin.tudanhgia.detailedplanning.updatemenhdedm')}}" method="POST">
                                            <input name="id_menhde" type="hidden" class="id_mde_dm_{{$menhde->id}}" value="{{ $menhde->menhde_id }}">
                                            <input name="id_khbc" type="hidden" class="id_khbc_dm_{{$menhde->id}}" value="{{ $id_khbc }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card my-3">
                                                        
                                                        <div class="bootstrap-admin-card-content">
                                                            <textarea class="tinymce_diemmanh menhde_mota_diemm_{{$menhde->id}}" style="width: 100%;" name="mota_dm">
                                                                @if($menhde)
                                                                    {!! $menhde->diemmanh !!}
                                                                @endif
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right setupdate">

                                                <button type="button" class="click2cancel btn btn-default" onclick="hied_md2({!!$menhde->id !!})" >
                                                    <i class="fas fa-chevron-left"></i> @lang('project/Selfassessment/title.quaylai')
                                                </button>

                                                <button type="button" onclick="update_md_dm({!!$menhde->id !!})" class="btn btn-info ladda-button" data-style="expand-right">
                                                    <i class="fas fa-save"></i> @lang('project/Selfassessment/title.luu')
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <h3>
                                    @lang('project/Selfassessment/title.khphdm')
                                    @if($editable!='')
                                        <a href="javascript:;" class="addKeHoach" data-type="diemmanh"
                                           data-id="{{ $menhde->menhde_id }}">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    @endif
                                </h3>

                                <div class="ibox-content">
                                    <table class="table clause-table clause-table-editabe table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('project/Selfassessment/title.noidung')</th>
                                            <th>@lang('project/Selfassessment/title.donvithuchien')</th>
                                            <th>@lang('project/Selfassessment/title.donvikiemtra')</th>
                                            <th>@lang('project/Selfassessment/title.tungay')</th>
                                            <th>@lang('project/Selfassessment/title.denngay')</th>

                                            <!-- if này có vấn đề cần hỏi lại  -->

                                            @if($tieuChuan->trang_thai!='congbo')
                                                <th colspan="2">@lang('project/Selfassessment/title.tacvu')</th>
                                            @endif
                                            
                                        </tr>
                                        </thead>
                                        <tbody class="keHoach_diemmanh" id="keHoach_diemmanh_{{ $menhde->menhde_id }}">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                @if($menhde->diemmanh)
                                    @include("admin.project.Selfassessment.comment",['kieu'=>'menhde_diemmanh','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                @endif
                                <div class="hr-line-dashed"></div>

                                <h3>@lang('project/Selfassessment/title.tontai')</h3>

                                <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">
                                    <div class="texts3_{!! $menhde->id !!} p-2" onclick="showbaocaomenhde3({!! $menhde->id !!},{!! $trangthai=="dangsua" ? 1 : 0 !!})">
                                        @if($menhde)

                                            @foreach($nhanxetbc as $nhanXet)
                                                @php
                                                    if(str_contains($menhde->mo_ta,$nhanXet->noidung)){
                                                        $menhde->tontai = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-data='".e($nhanXet->nhanxet)."'>$nhanXet->noidung</a>",$menhde->tontai);
                                                    }
                                                @endphp
                                            @endforeach
                                            <span class="update_tontai_bc_{{$menhde->id}}">{!! $menhde->tontai !!}</span>
                                        @else
                                            <i class="text-muted">@lang('project/Selfassessment/title.bvddttt')</i>
                                        @endif
                                    </div>
                                    <div id="shows3_{!! $menhde->id !!}" style="display: none;">
                                        <form action="{{route('admin.tudanhgia.detailedplanning.updatemenhdett')}}" method="POST">
                                            <input name="id_menhde" class="id_md_tt_{{$menhde->id}}" type="hidden" value="{{ $menhde->menhde_id }}">
                                            <input name="id_khbc" class="id_khbc_tt_{{$menhde->id}}" type="hidden" value="{{ $id_khbc }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card my-3">
                                                        
                                                        <div class="bootstrap-admin-card-content">
                                                            <textarea class="tinymce_full menhde_tt_{{$menhde->id}}" style="width: 100%;" name="mota_tt">
                                                                @if($menhde)
                                                                    {!! $menhde->tontai !!}
                                                                @endif
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right setupdate">

                                                <button type="button" class="click2cancel btn btn-default" onclick="hied_md3({!!$menhde->id !!})" >
                                                    <i class="fas fa-chevron-left"></i> @lang('project/Selfassessment/title.quaylai')
                                                </button>

                                                <button type="button" onclick="update_md_tt({!!$menhde->id !!})" class="btn btn-info ladda-button" data-style="expand-right">
                                                    <i class="fas fa-save"></i> @lang('project/Selfassessment/title.luu')
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <h3>
                                    @lang('project/Selfassessment/title.khkp')
                                    @if($editable!='')
                                        <a href="javascript:;" class="addKeHoach" data-type="tontai"
                                           data-id="{{ $menhde->menhde_id }}">
                                            <i class="fa fa-plus-circle"></i>
                                        </a>
                                    @endif
                                </h3>

                                <div class="ibox-content">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('project/Selfassessment/title.noidung')</th>
                                            <th>@lang('project/Selfassessment/title.donvithuchien')</th>
                                            <th>@lang('project/Selfassessment/title.donvikiemtra')</th>
                                            <th>@lang('project/Selfassessment/title.tungay')</th>
                                            <th>@lang('project/Selfassessment/title.denngay')</th>
                                            <th colspan="2">@lang('project/Selfassessment/title.tacvu')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="keHoach_tontai" id="keHoach_tontai_{{ $menhde->menhde_id }}">

                                        </tbody>
                                    </table>
                                </div>

                                @if($menhde->tontai)
                                    @include("admin.project.Selfassessment.comment",['kieu'=>'menhde_tontai','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                @endif

                                <div class="ibox-content text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-xs font-bold btn-info">
                                            <i class="fas fa-star"></i> @lang('project/Selfassessment/title.danhgia')
                                        </button>

                                        @for($i=1;$i<=7;$i++)
                                            @php
                                                $danhGiaClass="btn-default";
                                                if($menhde){
                                                    $danhGiaClass = ($i==$menhde->danhgia)?"btn-primary":"btn-default";
                                                }
                                                if($kehoachtieuchi->baocao_tieuchi){
                                                    $editClass = ($kehoachtieuchi->baocao_tieuchi->trang_thai=='dangsua')?"danhGia":"";
                                                }else{
                                                    $editClass = "danhGia";
                                                }
                                                
                                            @endphp

                                            <button type="button" data-id="{{ $menhde->id }}" value="{{ $i }}"
                                                    class=" {{$editClass}} btn btn-xs {{ $danhGiaClass }}">
                                                @lang('project/Selfassessment/title.muc') {{ $i }}
                                            </button>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach
                        @endif 
                    @endif
                </div>
                </div>
            @endforeach

           @if($keHoachBaoCaoDetail->loai_tieuchuan != 'csgd')
                @if($keHoachTieuChuan->id_truong_nhom == Sentinel::getUser()->id || $keHoachBaoCaoDetail->ns_phutrach == Sentinel::getUser()->id || Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                    <div class="group_back">
                        <div class="arrow_content_text_css">
                            <h5>@lang('project/Selfassessment/title.ketluan')</h5>
                            @if(!Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
                            <button id="show_content2" onclick="showhidetieuchi3()"><i class="fa fa-chevron-up" id="show_arrow2"></i></button>
                            @endif
                        </div>

                        <div id="content_text2" >
                            <div class="text_contents2 p-5" id="show_textcontent2">
                                @if($baoCaoTieuChuan)
                                    @foreach($nhanxetbc as $nhanXet)
                                        @php
                                            if(str_contains($baoCaoTieuChuan->ketluan,$nhanXet->noidung)){
                                                $baoCaoTieuChuan->ketluan = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-data='".e($nhanXet->nhanxet)."'>$nhanXet->noidung</a>",$baoCaoTieuChuan->ketluan);
                                            }
                                        @endphp
                                    @endforeach
                                    <span class="update_ketluan_bc">{!!$baoCaoTieuChuan->ketluan!!}</span>
                                @else
                                    <div class="add_text_kl">
                                        <i class="text-muted">@lang('project/Selfassessment/title.bvddtkl')</i>
                                    </div>
                                @endif
                            </div>
                            <div id="show-text2" style="display: none;">
                                <form action="{{route('admin.tudanhgia.detailedplanning.updatetieuchuan2')}}" method="POST">
                                    <input name="id_tc" type="hidden" class="id_tc_kl" value="{{ $tieuchuan_id }}">
                                    <input name="id_khbc" type="hidden" class="id_khbc_kl" value="{{ $id_khbc }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card my-3">
                                                
                                                <div class="bootstrap-admin-card-content">
                                                    <textarea class="tinymce_full tieu_chuan2_kl" name="ketluan" >
                                                        @if($baoCaoTieuChuan)
                                                            {!!$baoCaoTieuChuan->ketluan!!}
                                                        @endif
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right setupdate">

                                        <button type="button" class="click2cancel btn btn-default" onclick="hide_tc2()">
                                            <i class="fas fa-chevron-left"></i> @lang('project/Selfassessment/title.quaylai')
                                        </button>

                                        <button type="button" onclick="update_ketluan()" class="btn btn-info ladda-button" data-style="expand-right">
                                            <i class="fas fa-save"></i> @lang('project/Selfassessment/title.luu')
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                       @if($baoCaoTieuChuan)
                            @include("admin.project.Selfassessment.comment",['kieu'=>'tieuchuan_ketluan','id'=>$baoCaoTieuChuan->id,'id_kehoach_bc'=>$id_khbc])
                        @endif
                    </div>
                @endif
            @endif
        </div>

        <div class="guide col-lg-4">
            <div class="mc-box" id="stickerx">
                <div class="tabs-container">
                    <ul class="nav nav-tabs css_bk" style="float: unset!important;">
                        <li class="nav-link" id="tab-hd">
                            <a data-toggle="tab" href="#tab-1" class="p-2 add_bk bg-info">@lang('project/Selfassessment/title.huongdan')</a>
                        </li>
                        <li class="nav-link" id="tab-nx">
                            <a data-toggle="tab" href="#tab-2" class="p-2 add_bk2">@lang('project/Selfassessment/title.nhanxet')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body bg-info p-2">
                                <ul class="list-group">
                                    <div class="" id="huongDanDetail">
                                        <span class="">@lang('project/Selfassessment/title.hcmtdxhd')</span>
                                    </div>
                                </ul>

                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body p-2 bg-info">
                                @if(count($nhanxetbc)>0)
                                    <ul class="sortable-list connectList agile-list" id="inprogress">
                                        @foreach($nhanxetbc as $nhanXet)
                                            <li class="info-element">
                                                <div class="alert alert-warning">{{ $nhanXet->noidung }}</div>
                                                <div class="agile-detail">
                                                    {{ $nhanXet->nhanxet }}
                                                </div>
                                                <div class="agile-detail">
                                                    <small>
                                                        <b>{{ \Carbon\Carbon::parse($nhanXet->created_at)->diffForHumans() }}</b>,
                                                        @lang('project/Selfassessment/title.dangboi') <b>{{ $nhanXet->name }}</b>
                                                    </small>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    @lang('project/Selfassessment/title.ccnxnc')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="benchmark" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('project/Selfassessment/title.mocchuan')</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body add_item">
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MOdal kế hoạch -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="keHoachModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                
                <h3 class="modal-title" id="kh_kehoach_title">@lang('project/Selfassessment/title.themkehoach')</h3>
            </div>
            <form class="ajaxForm2 doneCloseModal form-horizontal" id="keHoachForm" modal-id="keHoachModal"
                      action="{{route('admin.tudanhgia.detailedplanning.creat_khhd')}}">
                    <div class="modal-body">

                        <input name="id_khbc" class="id_khbc_time" type="hidden" value="{{ $id_khbc }}">
                        <input name="id_menhde" id="menhde_id" class="id_menhde_time" type="hidden" value="">
                        <input name="kieu_kehoach" id="kh_kehoach_type" class="menhde_kkh" type="hidden" value="">

                        <div class="form-group d-flex justify-content-start">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.tieude')</label>
                            <div class="col-sm-10">
                                <input type="text" value="" name="tieu_de" class="form-control p-3 menhde_tieude" required>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.noidung')</label>
                            <div class="col-sm-10">
                                <textarea name="noi_dung" class="form-control menhde_noidung"></textarea>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.dexuatmoi')</label>
                            <div class="col-sm-10">
                                <textarea name="de_xuat_moi" class="form-control menhde_dxm"></textarea>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.thoigian')</label>
                            <div class="col-sm-5">
                                <div class="input-group date">
                                    <span class="input-group-addon pr-2"><i class="fas fa-calendar"></i></span>
                                    <input type="text" class="form-control datelocal menhde_nbd" name="ngay_batdau" autocomplete="off"
                                           placeholder="Ngày bắt đầu">
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="input-group date2">
                                    <span class="input-group-addon pr-2"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control datelocal2 menhde_nht" name="ngay_hoanthanh" autocomplete="off"
                                           placeholder="Ngày hoàn thành">
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-start">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.nhansu')</label>
                            <div class="col-sm-5">
                                <select name="ns_thuchien" class="form-control menhde_nsth">
                                    <option value="">- @lang('project/Selfassessment/title.nsth') -</option>
                                    @foreach($donViData as $donVi)
                                        <option value="{{ $donVi->id }}">{{ $donVi->ten_donvi }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-sm-5">
                                <select name="ns_kiemtra" class="form-control menhde_nskt">
                                    <option value="">- @lang('project/Selfassessment/title.nskt') -</option>
                                    @foreach($donViData as $donVi)
                                        <option value="{{ $donVi->id }}">{{ $donVi->ten_donvi }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div id="ajaxFormOutput" class="hidden text-left alert"></div>
                        <button type="button" class="btn btn-light p-1" data-bs-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                        <button type="button" onclick="create_md()" class="btn btn-success ladda-button p-1" data-style="expand-right">
                           </i> @lang('project/Selfassessment/title.them')
                        </button>
                    </div>
                </form>        
        </div>
      </div>
    </div>

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Launch demo modal
    </button> -->

    <!-- Modal -->
<div class="modal fade" id="exampleModalss" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content btn">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabels">@lang('project/Selfassessment/title.danhgia')</h5>
          </div>
          <div class="modal-body danhgiatc text-center">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary show_dg" data-bs-dismiss="modal"><i class="fa-solid fa-i"></i>@lang('project/Selfassessment/title.ok')</button>
            <a href="" class="btn btn-primary show_tc" style="display: none;"><i class="fa-solid fa-i"></i>@lang('project/Selfassessment/title.ok')</a>
          </div>
        </div>
      </div>
  </div>

      <!-- modal_tc_mc -->
      <!-- Modal -->
<div class="modal fade" id="select_mc_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content btn btn-warning">
            <div class="modal-header">
                <h3 class="modal-title">@lang('project/Selfassessment/title.cmc')</h3>
            </div>
            <div class="modal-body danhgiatc text-center">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-12 control-label">
                            @lang('project/Selfassessment/title.mcctc')
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <select id="selectmc" class="form-control"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary show_dg" data-bs-dismiss="modal"><i class="fa-solid fa-i"></i>@lang('project/Selfassessment/title.cancel')</button>
                <a href="" class="btn btn-primary show_tc" style="display: none;"><i class="fa-solid fa-i"></i>@lang('project/Selfassessment/title.ok')</a>
            </div>
        </div>
    </div>
</div>    


    <!-- Modal minh chứng gộp -->

<div class="modal fade show_minhchunggop" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="form-group" style="line-height: 38px;">
            <div class="row p-3">
                <h2 class="col-sm-12 control-label text-center">
                    @lang('project/Selfassessment/title.chenminhchung')
                </h2>
            </div>

            <div class="minhchung_stt">
                
            </div>

            <div class="bg-light p-3" style="border: 1px solid lightgrey;">   
                <div class="row">  
                    <div class="col-md-9  align-items-center">
                        @if(isset($tieuChuan->id))
                            <select id="" class="selectmc_mota form-control option_mc{{$tieuChuan->id}} h-auto w-100"></select>
                        @endif
                        <!-- <select type="text" class="checks"></select> -->
                    </div>
                    <div class="col-md-2">
                        <button class="show_all_mc">@lang('project/Selfassessment/title.httc')</button>
                    </div>
                </div>
                <div class="change_all_minhchung">
                    <div class="minhchung_tieude">
                    
                    </div>
                    <div class="minhchung_trichyeu">
            
                    </div>
                    <div class="Minhchung_nbh">

                    </div>
                </div>
                @if(isset($tieuChuan->id))
                    <button class="border-0 btn btn-primary" onclick="setminhchung({{$tieuChuan->id}})">Chèn vào báo cáo</button>
                @endif
            </div>
            

            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
    </div>
  </div>
</div>

<!-- Modal Minh chứng -->
<div class="modal fade modal_minhchung" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content pt-4" style="line-height: 84px;">
        <h3 class="text-center">Chi tiết minh chứng</h3>
        <div class="p-4 bg-light border mt-4">
            <div class="tieude_modal_mc">
                <strong class="modal_mc_tieude" style="padding-right: 17px;"></strong>
                <span class="content_mc_tieude"></span>
            </div>
            <div class="trichyeu_modal_mc">
                <strong class="modal_mc_trichyeu" style="padding-right: 17px;"></strong>
                <span class="content_mc_trichyeu"></span>
            </div>
            <div class="chitiet_modal_mc">
                
            </div>
        </div>
    </div>
  </div>
</div>

<!-- modal kế hoạch hướng dẫn -->

<div class="modal fade modal_kehoachhd" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong>@lang('project/Selfassessment/title.kehoach')</strong></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <b>@lang('project/Selfassessment/title.xoakehoach')</b>
        <br>
        <b>@lang('project/Selfassessment/title.xokehoachnay')</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/Selfassessment/title.huy')</button>
        <button type="button" class="btn btn-primary delete_modal_hd" data-bs-dismiss="modal">@lang('project/Selfassessment/title.xoakehoach')</button>
      </div>
    </div>
  </div>
</div>

<!-- modal chi tiết kế hoạch hướng dẫn -->

<div class="modal fade modal_chitiet_kehoachhd" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="modal-title w-100" id="exampleModalLabel"><strong>@lang('project/Selfassessment/title.chitietkeh')</strong></h3>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body import_khhd p-5">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/Selfassessment/title.huy')</button>
        <button type="button" class="btn btn-primary delete_modal_hd" data-bs-dismiss="modal">@lang('project/Selfassessment/title.xoakehoach')</button>
      </div>
    </div>
  </div>
</div>
<!-- Kết thúc trang -->
    </section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')

    <script src="{{asset('vendors/ckeditor/js/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendors/tinymce/js/tinymce.min.js')}}" type="text/javascript"></script>
    <!-- <script src="{{ asset('js/pages/editor.js') }}" type="text/javascript"></script> -->
   
    <script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>
    <!-- sweetalert2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.3/sweetalert2.min.js"></script>

    <script>
        var cur_editor = null;
        var add_mc = '';
        function showhidetieuchi(){
            if($('#content_text').is(':visible')){
                $('#content_text').hide();
                let arr = $('#show_arrow');
                arr.removeClass('fa-chevron-up');
                arr.addClass('fa-chevron-down');
            }else{
                $('#content_text').show();
                let arr = $('#show_arrow');
                arr.removeClass('fa-chevron-down');
                arr.addClass('fa-chevron-up');

            }
        }

        function showhidetieuchi3(){
            if($('#content_text2').is(':visible')){
                $('#content_text2').hide();
                let arr = $('#show_arrow2');
                arr.removeClass('fa-chevron-up');
                arr.addClass('fa-chevron-down');
            }else{
                $('#content_text2').show();
                let arr = $('#show_arrow2');
                arr.removeClass('fa-chevron-down');
                arr.addClass('fa-chevron-up');

            }

        }
        function showhidetieuchi2(a){
            if($(`#show_block_content_${a}`).is(':visible')){
                $(`#show_block_content_${a}`).hide();
            }else{
                $(`#show_block_content_${a}`).show();
            }
            


        }


        $('#show_textcontent').on('click', ()=>{
            $('#show-text').show();
            $('.text_contents').hide();
        })

         $('#show_textcontent2').on('click', ()=>{
            $('#show-text2').show();
            $('.text_contents2').hide();
        })
        function showbaocaomenhde(a,b){

            if(b == 1){
                $(`#shows_${a}`).show();
                $(`.texts_${a}`).hide();

                
            }
        }

        function hied_md(a){
            $(`#shows_${a}`).hide();
            $(`.texts_${a}`).show();
        }
        
        function showbaocaomenhde2(a,b){
            if(b == 1){
                $(`#shows2_${a}`).show();
                $(`.texts2_${a}`).hide();
            }                
                
        }

        function hied_md2(a){
            $(`#shows2_${a}`).hide();
            $(`.texts2_${a}`).show();
        }
        function showbaocaomenhde3(a,b){
            if(b == 1){
                $(`#shows3_${a}`).show();
                $(`.texts3_${a}`).hide();
            }                
            
        }
        function hied_md3(a){
            $(`#shows3_${a}`).hide();
            $(`.texts3_${a}`).show();
        }
        var check = false;
        function openselectmc(ed){
            var cur_editor_id = ed.id;
            cur_editor = ed;
            var st = cur_editor_id.split('_');
            var n = st.length;
            
            if(n > 4){                
                var tieuchuan_id = st[n - 3];
                var tieuchi_id = st[n - 2];
                var menhde_id = st[n - 1];
                var push_minhchung = $(`.option_mc${tieuchuan_id}`);
                $.ajax({
                    url: "{!! route('admin.tudanhgia.detailedplanning.showmcgop')!!}?id_tieuchi=" + tieuchi_id,
                    type: 'GET',
                    error: function(err) {

                    },            
                    success: function(data) {
                        push_minhchung.empty();
                        data.forEach(function(e){
                            e.minhChungList.forEach(function(e_child){
                                
                                push_minhchung.append(`<option value="${e_child.id}" trichyeu="${e_child.trich_yeu}">${e_child.tieu_de}</option>`);
                            });
                           
                        });

                         $('.show_minhchunggop').on('click','.show_all_mc',function(){
                            $(this).css('display','none');
                             // push_minhchung.empty();
                             let arr_mct = {!! json_encode($arr_mc) !!};
                             // id_mcg = parseInt(id_mcg);
                            data.forEach(function(e){
                                e.minhchung.forEach(function(e_child){
                                    if(!arr_mct.includes(parseInt(e_child.id))){
                                        push_minhchung.append(`<option value="${e_child.id}" trichyeu="${e_child.trich_yeu}">${e_child.tieu_de}</option>`);
                                    }
                                    
                                    
                                });
                               
                            });

                            if(!check){
                                $('.minhchung_tieude').empty();
                                $('.minhchung_tieude').append( `
                                                                <p style="font-weight: bold;margin: 0;margin-top:6px">Tiêu đề</p>
                                                                <span>
                                                                     ${$(`select.option_mc${tieuchuan_id} option`).filter(":selected").text()}
                                                                </span>
                                                            `);
                                $('.minhchung_trichyeu').empty();
                                $('.minhchung_trichyeu').append(`   
                                                                <p style="font-weight: bold;margin: 0;margin-top:6px">Trích Yếu</p>
                                                                <span>
                                                                    

                                                                ${$(".selectmc_mota  option:selected").attr('trichyeu')})
                                                                </span>
                                                              `);
                                }
                                
                                check = true;
                           
                         })

                       $('.minhchung_tieude').empty();
                       $('.minhchung_trichyeu').empty();
                       $('.minhchung_tieude').append( `
                                                        <p style="font-weight: bold;margin: 0;margin-top:6px">Tiêu đề</p>
                                                        <span>
                                                        ${$(`select.option_mc${tieuchuan_id} option`).filter(":selected").text()}
                                                        </span>
                                                    `);
                       
                       $('.minhchung_trichyeu').append(`   
                                                        <p style="font-weight: bold;margin: 0;margin-top:6px">Trích Yếu</p>
                                                        <span id="mc-trichyeu">
                                                            ${$(`select.option_mc${tieuchuan_id} option`).filter(":selected").attr("trichyeu")} 
                                                          
                                                        </span>
                                                      `);
                        $test = $(`.option_mc${tieuchuan_id}`).on('change', function(){

                            $('.minhchung_tieude').empty();
                            $('.minhchung_tieude').append( `
                                                            <p style="font-weight: bold;margin: 0;margin-top:6px">Tiêu đề</p>
                                                            <span>
                                                                 ${$(`select.option_mc${tieuchuan_id} option`).filter(":selected").text()}
                                                            </span>
                                                        `);
                            $('.minhchung_trichyeu').empty();
                            $('.minhchung_trichyeu').append(`   
                                                            <p style="font-weight: bold;margin: 0;margin-top:6px">Trích Yếu</p>
                                                            <span>
                                                                

                                                            ${$(".selectmc_mota  option:selected").attr('trichyeu')})
                                                            </span>
                                                          `);
                        });
                    },
                });            
                $('.show_minhchunggop').modal('toggle');
            }
        }

        cur_editor2 = $('.show_minhchunggop .option_mc').val();
      
        function clickMC(id,mcg){
            var num;
           
            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.modalminhchung') !!}",
                type: 'POST',
                
                data :{
                    id_minhchunggop : id,
                    mcg : mcg,
                },   
                error: function(err) {

                },

                success: function(data) {
                   $('.modal_mc_tieude').html('Tiêu đề');
                   $('.modal_mc_trichyeu').html('Trích Yếu');
                   $('.modal_mc_chitiet').html('Xem chi tiết');
                   data.forEach(function(e){
                        $('.content_mc_tieude').html(e.tieu_de);
                        $('.content_mc_trichyeu').html(e.trich_yeu);
                        var link  = "{!! route('admin.tudanhgia.preparereport.editmcgop',0)!!}";  
                        link = link.replace('edit-mc-gop/0','edit-mc-gop/'+ e.id);
                        $('.chitiet_modal_mc').html(
                                                    `<strong style ="padding-right: 17px;">Xem chi tiết</strong>
                                                    <a href="${link}" title="" style="background: aquamarine; padding: 5px; border-radius: 45px;">
                                                        <i class="fas fa-eye"></i>
                                                        <span type="">
                                                            DS minh chứng các thành phần
                                                        </span>
                                                     </a>
                                                    `
                                               );
                   });
                },
            });


            $('.modal_minhchung').modal('show');

        }
      
            
  
        function setminhchung(tieuchuan_id){

            let arr_mc = {!! json_encode($arr_mc) !!};
            
            let inseart =  `${$('select.option_mc' + tieuchuan_id + ' option').filter(":selected").text()}`;
            let id_mcg =  `${$('select.option_mc' + tieuchuan_id + ' option').filter(":selected").val()}`;
         
            if(cur_editor != null){
                if(check){
                    id_mcg = parseInt(id_mcg);
                    if(arr_mc.includes(id_mcg)){
                        let text = '&nbsp;<a data-mce-href="mcGop" id="addminhchunggop_' + id_mcg + '" href="#" class="danMinhChung mcGop" d-type="mcGop" d-id="' + id_mcg + '">' + '[' + inseart + ']'+ ' </a>';
                         cur_editor.execCommand('mceInsertContent', false, text);  
                    }else{
                        let text = '&nbsp;<a data-mce-href="mc" id="addminhchunggop_' + id_mcg + '" href="#" class="danMinhChung mcGop" d-id="' + id_mcg + '">' + '[' + inseart + ']'+ ' </a>';
                         cur_editor.execCommand('mceInsertContent', false, text);  
                    }
                }else{
                    let text = '&nbsp;<a data-mce-href="mcGop" id="addminhchunggop_' + id_mcg + '" href="#" class="danMinhChung mcGop" d-type="mcGop" d-id="' + id_mcg + '">' + '[' + inseart + ']'+ ' </a>';
                     cur_editor.execCommand('mceInsertContent', false, text);  
                }
                     
                             
            } 

            check = false;           
            $('.show_minhchunggop').modal('hide');                 
        }

        $('.click2cancel').on('click', ()=>{
            $('#show-text').hide();
            $('.text_contents').show();
        });
            
        $('.mocChuanTieuChi').on('click', function(){
            $('#exampleModalLabel').empty();
            $('#exampleModalLabel').prepend("@lang('project/Selfassessment/title.mocchuan')");
            let add = $('.add_item');
            let item ='';
            let id_tieuchi = $(this).attr('d-id');

            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.showmochuan') !!}?id="+id_tieuchi,
                type: 'GET',
                error: function(err) {

                },            
                success: function(data) {
                      if(data == 1){
                        item = "@lang('project/Selfassessment/title.ccmcctcn')";
                    }else{
                        data.forEach(function(e){
                           item += e.mo_ta;
                        });
                    }
                     add.empty();
                     add.append(item);
                     $('#benchmark').modal('show');
                },
            });
        });
        
        $('.block_content').on('click','.minhChungTTTieuChi', function(){
            $('#exampleModalLabel').empty();
            $('#exampleModalLabel').prepend("@lang('project/Selfassessment/title.mctt')");
            let add = $('.add_item');
            let item = '';
            let id_tieuchi = $(this).attr('d-id')

            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.showmctt') !!}",
                type: 'POST',
                data: {
                    id : id_tieuchi,
                     _token : '{{ csrf_token() }}',
                },
               
                error: function(err) {

                },

                success: function(data) {
                   
                    
                    if(data == 1){
                        item = "@lang('project/Selfassessment/title.mtctcncdxl')";
                    }else{
                        data.forEach(function(e){
                            if(e.tieuchis != undefined){
                                item += '<li>' + e.tieuchis.tieu_de + '</li>'+ '</br>';
                            }
                        })
                    }
                    
                     add.empty();
                     add.append(item);
                     $('#benchmark').modal('show');
                },
            })
        });

        
        $('.block_content_title').on('click','.huongDanTieuChi', function(){
            let id_tieuchi = $(this).attr('d-id');
            let huongdan = '';
            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.showhuongdan') !!}?id="+id_tieuchi,
                type: 'GET',
                error: function(err) {

                },

                success: function(data) {
                    $('#huongDanDetail').empty();
                    data.forEach(function(e){
                        // huongdan += e.mo_ta;
                        $('#huongDanDetail').append(e.mo_ta);
                        $('#huongDanDetail').append("<p><hr></p>");
                        
                    })
                   
                },
            })
        });

        flatpickr('.datelocal', {
            dateFormat: 'd/m/Y',
        });
        flatpickr('.datelocal2', {
            dateFormat: 'd/m/Y',
        });
        flatpickr('.datelocal3', {
            dateFormat: 'd/m/Y',
        });
        flatpickr('.datelocal4', {
            dateFormat: 'd/m/Y',
        });
        // $('.input-group.date').click(function(){
        //     $('.datelocal').flatpickr('show'); //support hide,show and destroy command
        // });
        
        $('.addKeHoach').on('click', function () {
            $('#menhde_id').val($(this).attr('data-id'));
            $('#kh_kehoach_type').val($(this).attr('data-type'));

            if ($(this).attr('data-type') == 'diemmanh') {
                $('#kh_kehoach_title').html("Kế hoạch phát huy điểm mạnh");
            } else {
                $('#kh_kehoach_title').html("Kế hoạch khắc phục tồn tại");
            }

            $('#keHoachModal').modal('show');
        });

        tinymce.init({
            selector: '.tinymce_full',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor',
            ],
            toolbar1:
                'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | minhchung',
            image_advtab: true,
            templates: [
                {
                    title: 'Test template 1',
                    content: 'Test 1',
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2',
                },
            ],
            default_link_target:"_blank",
            allow_unsafe_link_target: true,
            setup: function (ed) {
                ed.on('init', function(args) {
                    
                });
            }
        });

        tinymce.init({
            selector: '.tinymce_full_md',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor',
            ],
            toolbar1:
                'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | minhchung',
            image_advtab: true,
            templates: [
                {
                    title: 'Test template 1',
                    content: 'Test 1',
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2',
                },
            ],
            default_link_target:"_blank",
            allow_unsafe_link_target: true,
            setup: function (ed) {
                ed.on('init', function(args) {
                    
                });

                ed.on("click", function(e) {

                    var id = e.target.id;
                    var clas = e.target.class;
                    let mcg = e.target.classList.value;
                    if(mcg.includes('mcGop')){
                        mcg = 'mcGop';
                    }else{
                        mcg = 'mc';
                    }

                    if(id != undefined && id != '' && id.includes('addminhchunggop_')){
                        var idmcg = id.split('_')[1];
                     
                        clickMC(idmcg,mcg);    
                    }
                });
                
                ed.addButton('minhchung', {
                    icon: 'anchor',
                    text: "@lang('project/Selfassessment/title.minhchung')",
                    tooltip: "@lang('project/Selfassessment/title.chenminhchung')",
                    onclick: function () {
                        openselectmc(ed);
                        $('.selectmc_mota').select2({
                            dropdownParent: $(".show_minhchunggop"),
                        }); 
                    }
                });
            }
        });

        tinymce.init({
            selector: '.tinymce_diemmanh',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor',
            ],
            toolbar1:
                'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | minhchung',
            image_advtab: true,
            templates: [
                {
                    title: 'Test template 1',
                    content: 'Test 1',
                },
                {
                    title: 'Test template 2',
                    content: 'Test 2',
                },
            ],
            default_link_target:"_blank",
            allow_unsafe_link_target: true,
            setup: function (ed) {
                ed.on('init', function(args) {
                    
                });
                
            }
        });

        $('#tab-nx').on('click', ()=>{
            $('#tab-nx').css('background','white');
            $('.panel-body').css('background','white');

            $('#tab-hd').css('background','#ebebeb');

        })
        $('#tab-hd').on('click', ()=>{
            $('#tab-hd').css('background','white');
            $('.panel-body').css('background','white');
            $('#tab-nx').css('background','#ebebeb');
            
        })


        $('.uploadcb').on('click','.congBoTieuChi', function () {
            let id = $(this).attr('d-id');
            var tieuchi_id = $(this).attr('d-tieuchi_id');
            let menhde_id = $(this).attr('d-menhde');
            let kehmd = $(this).attr('d-kehmd');
            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.showcongbotieuchi') !!}",
                type: 'GET',

                data :{
                    tieuchi_id : tieuchi_id,
                    baocao_id : id,
                    id_khbc : {{$id_khbc}},
                    menhde_id : menhde_id,
                    kehmd : kehmd,
                },
                error: function(err) {

                },

                success: function(data) {
                    $('.show_dg').css("display", "none");
                    $('.show_tc').css("display", "block");
                    $('#exampleModalss').modal('show');
                    $('#exampleModalLabels').empty();
                    $('#exampleModalLabels').append('Tiêu chí');
                    $('.danhgiatc').empty();
                    $('.danhgiatc').append('<p>' + data + '</p>')
                   
                },
            })

        });

        $('.uploadcb').on('click','.moLaiTieuChi', function () {
            let id = $(this).attr('d-id');
            var tieuchi_id = $(this).attr('d-tieuchi_id');
            $.ajax({
                url: "{!! route('admin.tudanhgia.detailedplanning.moLaiTieuChi') !!}",
                type: 'GET',

                data :{
                    tieuchi_id : tieuchi_id,
                    baocao_id : id,
                    id_khbc : {{$id_khbc}},
                    id_tieuchuan : {{$tieuchuan_id}},
                },
                error: function(err) {

                },

                success: function(data) {
                    $('.show_dg').css("display", "none");
                    $('.show_tc').css("display", "block");
                    $('#exampleModalss').modal('show');
                    $('#exampleModalLabels').empty();
                    $('#exampleModalLabels').append(`@lang('project/Selfassessment/title.tieuchi')`);
                    $('.danhgiatc').empty();
                    $('.danhgiatc').append('<p>' + data + '</p>')
                   
                },
            })

        });
        function hide_tc(){
            $('#show-text').hide();
            $('.text_contents').show();
        }
        

        function hide_tc(){
            $('#show-text').hide();
            $('.text_contents').show();
        }

        function hide_tc2(){
            $('#show-text2').hide();
            $('.text_contents2').show();
        }


         function update_modau(){
           let kh_bc = $('.id_khbc').val();
           let tieu_chuan = $('.id_tc').val();
           tinymce.triggerSave();
           let modau = $('.tieuchuan_save').val();

           $.ajax({
                url: "{{route('admin.tudanhgia.detailedplanning.updatetieuchuan')}}",
                type: "POST",
                data:{
                    id_khbc : kh_bc,
                    id_tc : tieu_chuan,
                    modau : modau,
                    id_kh_tc : {{$keHoachTieuChuan->id}},
                    _token: '{{ csrf_token() }}'
                },    
                error: function(err) {

                },

                success: function(data) {
                    console.log(data)
                    if(data){
                        $('.add_text_md').html(data);
                    }
                    alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                    $('.update_modau_bc').html(data);
                    $('#show-text').hide();
                    $('.text_contents').show();
                },
            });
        }

        function update_ketluan(){
           let kh_bc = $('.id_khbc_kl').val();
           let tieu_chuan = $('.id_tc_kl').val();
           tinymce.triggerSave();
           let ketluan = $('.tieu_chuan2_kl').val();

           $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updatetieuchuan2')}}",
                    type: "POST",
                    data:{
                        id_khbc : kh_bc,
                        id_tc : tieu_chuan,
                        ketluan : ketluan,
                        _token: '{{ csrf_token() }}'
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        if(data){
                            $('.add_text_kl').html(data);
                        }
                        alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                        $('.update_ketluan_bc').html(data);
                        $('#show-text2').hide();
                        $('.text_contents2').show();
                    },
                })
        }


        function update_md_mt(menhde_id){
           let id_khbc = $('.id_khbc_mt_' + menhde_id).val();
           let id_menhde = $('.id_md_mt_' + menhde_id).val();
           tinymce.triggerSave();
           let mota_md = $('.menhde_mt_' + menhde_id).val();

           $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updatemenhde')}}",
                    type: "POST",
                    data:{
                        id_khbc : id_khbc,
                        id_menhde : id_menhde,
                        mota_md : mota_md,
                        _token: '{{ csrf_token() }}'
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                         $('.update_mota_bc_'+ menhde_id).html(data);
                         $(`#shows_${menhde_id}`).hide();
                         $(`.texts_${menhde_id}`).show();
                    },
            });
        }

        function update_md_dm(menhde_id){
           let id_khbc = $('.id_khbc_dm_'+ menhde_id).val();
           let id_menhde = $('.id_mde_dm_'+ menhde_id).val();
           tinymce.triggerSave();
           let mota_dm = $('.menhde_mota_diemm_'+ menhde_id).val();

           $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updatemenhdedm')}}",
                    type: "POST",
                    data:{
                        id_khbc : id_khbc,
                        id_menhde : id_menhde,
                        mota_dm : mota_dm,
                        _token: '{{ csrf_token() }}'
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                        $('.update_diemmanh_bc_'+ menhde_id).html(data);
                        $(`#shows2_${menhde_id}`).hide();
                        $(`.texts2_${menhde_id}`).show();
                    },
            });
        }

        function update_md_tt(menhde_id){
           let id_khbc = $('.id_khbc_tt_'+ menhde_id).val();
           let id_menhde = $('.id_md_tt_'+ menhde_id).val();
           tinymce.triggerSave();
           let mota_tt = $('.menhde_tt_'+ menhde_id).val();
           $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updatemenhdett')}}",
                    type: "POST",
                    data:{
                        id_khbc : id_khbc,
                        id_menhde : id_menhde,
                        mota_tt : mota_tt,
                        _token: '{{ csrf_token() }}'
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                        $('.update_tontai_bc_'+ menhde_id).html(data);
                        $(`#shows3_${menhde_id}`).hide();
                        $(`.texts3_${menhde_id}`).show();
                    },
            });
        }


        function create_md(){
            let id_khbc = $('.id_khbc_time').val();
            let id_menhde = $('.id_menhde_time').val();
            let tieu_de = $('.menhde_tieude').val();
            let noi_dung = $('.menhde_noidung').val();
            let de_xuat_moi = $('.menhde_dxm').val();
            let ns_thuchien = $('.menhde_nsth').val();
            let ns_kiemtra = $('.menhde_nskt').val();
            let ngay_batdau = $('.menhde_nbd').val();
            let ngay_hoanthanh = $('.menhde_nht').val();
            let kieu_kehoach = $('.menhde_kkh').val();

            
            let tieu_des = $('.menhde_tieude');
            let noi_dungs = $('.menhde_noidung');
            let de_xuat_mois = $('.menhde_dxm');
            let ns_thuchiens = $('.menhde_nsth');
            let ns_kiemtras = $('.menhde_nskt');
            let ngay_batdaus = $('.menhde_nbd');
            let ngay_hoanthanhs = $('.menhde_nht');

            $.ajax({
                url: "{{route('admin.tudanhgia.detailedplanning.creat_khhd')}}",
                type: "POST",
                data:{
                    id_khbc : id_khbc,
                    id_menhde : id_menhde,
                    tieu_de : tieu_de,
                    noi_dung : noi_dung,
                    de_xuat_moi : de_xuat_moi,
                    ns_thuchien : ns_thuchien,
                    ns_kiemtra : ns_kiemtra,
                    ngay_batdau : ngay_batdau,
                    ngay_hoanthanh : ngay_hoanthanh,
                    kieu_kehoach : kieu_kehoach,
                    _token: '{{ csrf_token() }}'
                },    
                error: function(err) {
                    alert(`@lang('project/Selfassessment/title.bcddtt')`);
                },

                success: function(data) {
                    if(data == 1){
                        tieu_des.val('');
                        noi_dungs.val('');
                        de_xuat_mois.val('');
                        ns_thuchiens.val('');
                        ns_kiemtras.val('');
                        ngay_batdaus.val('');
                        ngay_hoanthanhs.val('');

                        $('#keHoachModal').modal('hide'); 
                        alert("@lang('project/Selfassessment/title.capnhatthanhcong')");
                        tontai_diemmanh();
                    }else{
                        alert(`@lang('project/Selfassessment/title.nbdktnhnht')`);
                    }
                },                    
            });
        }

        $('.danhGiaTieuChi').on('click', function () {
            $('.show_dg').css("display", "block");
            $('.show_tc').css("display", "none");
            $('#exampleModalss').modal('show');
            $('#exampleModalLabels').empty();
            $('#exampleModalLabels').append('Đánh giá');
            $('.danhgiatc').empty();
            $('.danhgiatc').append(`<p>@lang('project/Selfassessment/title.dgtc')</p> <span>@lang('project/Selfassessment/title.dtbm') </span> ${$(this).attr('d-danhgia')}`);
        });

        $('.congBoMenhDe').on('click', function(){

            let bacaomd_id = $(this).attr('d-id');
            let menh_id = $(this).attr('d-menh_id');
            $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updtecbmd')}}",
                    type: "POST",
                    data:{
                        bacaomd_id : bacaomd_id,
                        menh_id : menh_id,
                        id_khbc : {{$id_khbc}},
                       _token: '{{ csrf_token() }}',
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        $('.show_dg').css("display", "none");
                        $('.show_tc').css("display", "block");
                        $('#exampleModalss').modal('show');
                        $('#exampleModalLabels').empty();
                        $('#exampleModalLabels').append('Mệnh đề');
                        $('.danhgiatc').empty();
                        $('.danhgiatc').append('<p>' + data + '</p>')
                    },
            });
        });

        $('.moLaiMenhDe').on('click', function(){

            let bacaomd_id = $(this).attr('d-id');
            $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.updtemlmd')}}",
                    type: "POST",
                    data:{
                        bacaomd_id : bacaomd_id,
                       _token: '{{ csrf_token() }}',
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        $('.show_dg').css("display", "none");
                        $('.show_tc').css("display", "block");
                        $('#exampleModalss').modal('show');
                        $('#exampleModalLabels').empty();
                        $('#exampleModalLabels').append(`@lang('project/Selfassessment/title.menhde')`);
                        $('.danhgiatc').empty();
                        $('.danhgiatc').append('<p>' + data + '</p>')
                    },
            });
        });

        $('.congBoMenhDeFake').on('click', function () {
        swal("@lang('project/Selfassessment/title.mdcdvbc')", "@lang('project/Selfassessment/title.vlvbckht')", "@lang('project/Selfassessment/title.warning')");
            $('.show_dg').css("display", "block");
            $('.show_tc').css("display", "none");
            $('#exampleModalss').modal('show');
            $('#exampleModalLabels').empty();
            $('#exampleModalLabels').append(`@lang('project/Selfassessment/title.menhde')`);
            $('.danhgiatc').empty();
            $('.danhgiatc').append(`<p>@lang('project/Selfassessment/title.mdcdvbc')</p> <span>@lang('project/Selfassessment/title.vlvbckht'), @lang('project/Selfassessment/title.warning')!! </span>`);
        });
        

        $('.danhGia').on('click', function(){
            let muc = $(this).val();
            let bacaomd_id = $(this).attr('data-id');

            $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.update_muc')}}",
                    type: "POST",
                    data:{
                        bacaomd_id : bacaomd_id,
                        muc : muc,
                        id_khbc : {{$id_khbc}},
                       _token: '{{ csrf_token() }}',
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        $('.show_dg').css("display", "none");
                        $('.show_tc').css("display", "block");
                        $('#exampleModalss').modal('show');
                        $('#exampleModalLabels').empty();
                        $('#exampleModalLabels').append('Mức');
                        $('.danhgiatc').empty();
                        $('.danhgiatc').append('<p>' + data + '</p>')
                    },
            });
        });

        $('.add_bk').on('click',function(e){
            $(this).addClass('bg-info');
            $('.add_bk2').removeClass('bg-info');
            $('#tab-nx').css('background','');
        })

        $('.add_bk2').on('click',function(e){
            $(this).addClass('bg-info');
            $('.add_bk').removeClass('bg-info');
            $('#tab-hd').css('background','');
        })

        function tontai_diemmanh(){
            $('.keHoach_tontai').html('');
            $('.keHoach_diemmanh').html('');
            $.ajax({
                url: "{{route('admin.tudanhgia.detailedplanning.tontai_diemmanh')}}",
                type: "POST",
                data:{
                    id_khbc : {{$id_khbc}},
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {
                    alert(`@lang('project/Selfassessment/title.bcddtt')`);
                },

                success: function(data) {          
                    $('.keHoach_tontai').empty();          
                    $('.keHoach_diemmanh').empty();          
                    data.forEach(function(keHoach){
                        $('#keHoach_' + keHoach.kieu_kehoach + '_' + keHoach.menhde_id).append(
                            "<tr>" +
                                "<td class='text-center'>" + keHoach.noi_dung + "</td>" +
                                "<td class='text-center'>" + keHoach.nhanSuThucHien.ten_donvi + "</td>" +
                                "<td class='text-center'>" + keHoach.nhanSuKiemTra.ten_donvi + "</td>" +
                                "<td class='text-center'>" + keHoach.ngay_batdau + "</td>" +
                                "<td class=text-center'>" + keHoach.ngay_hoanthanh + "</td>" +
                                @if(isset($tieuChuan->trang_thai))
                                    @if($tieuChuan->trang_thai!='congbo')
                                        "<td><button class='btn btn-xs detailKeHoach_"+keHoach.id+" show_chitiet_khhd' d-id='" + keHoach.id + "' + data-bs-toggle='tooltip' data-bs-placement='top' title='@lang('project/Selfassessment/title.xemctkh')'>" +
                                        "<i class='fas fa-info-circle' style='font-size: 25px;color: #009ef7;'></i></button></td>" +
                                        "<td><button class='btn btn-xs deleteKeHoach_"+keHoach.id+"' onclick='delete_diemmanh("+keHoach.id+")' d-id_menhde='" + keHoach.menhde_id + "' d-id='" + keHoach.id + "'data-bs-toggle='tooltip' data-bs-placement='top' title='@lang('project/Selfassessment/title.xoakehoach')'>" +
                                        "<i class='fas fa-minus-circle' style='font-size: 25px;color: red;'></i></button></td>" +
                                    @endif
                                @endif
                            "</tr>"
                        );
                    })
                    
                },                    
            });
        }

        function delete_diemmanh(kehoach_hd){
            let check_modal_hd = $('.modal_kehoachhd').modal('show');
            let id_menhde = $('.deleteKeHoach_'+kehoach_hd).attr('d-id_menhde');
            let id_kh_hd = $('.deleteKeHoach_'+kehoach_hd).attr('d-id');
            $('.delete_modal_hd').on('click',function(e){
                $.ajax({
                    url: "{{route('admin.tudanhgia.detailedplanning.delete_diemmanh')}}",
                    type: "POST",
                    data:{
                        id_khbc : {{$id_khbc}},
                        id_menhde : id_menhde,
                        id_kh_hd : id_kh_hd,
                        _token: '{{ csrf_token() }}',
                    },    
                    error: function(err) {
                       
                    },

                    success: function(data) {
                        tontai_diemmanh();
                    },                    
                });
            })
           
        }


        $('.keHoach_diemmanh').on('click', '.show_chitiet_khhd', function(e){
            let id_kh_hd = $(this).attr('d-id');
            $.ajax({
                url: "{{route('admin.tudanhgia.detailedplanning.show_tontai_diemmanh')}}",
                type: "POST",
                data:{
                    id_khbc : {{$id_khbc}},
                    id_kh_hd : id_kh_hd,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {
                    alert(`@lang('project/Selfassessment/title.bcddtt')`);
                },

                success: function(data) {
                    data.forEach(function(keHoach){
                        $('.import_khhd').html(` 
                                <div class="mt-2 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.tieude')</strong>
                                    <span class="pl-5">${keHoach.tieu_de}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.noidung')</strong>
                                    <span class="pl-5">${keHoach.noi_dung}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong class="text-center" style="width:81px">@lang('project/Selfassessment/title.dexuatmoi')</strong>
                                    <span class="pl-5">${keHoach.de_xuat_moi}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.thoigian')</strong>
                                    <span class="pl-5">${keHoach.ngay_batdau}</span>
                                    <span class="pl-5">${keHoach.ngay_hoanthanh}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.nhansu')</strong>
                                    <span class="pl-5">${keHoach.nhanSuThucHien.ten_donvi}</span>
                                    <span class="pl-5">${keHoach.nhanSuKiemTra.ten_donvi}</span>
                                </div>           

                        `)
                    });

                    $('.modal_chitiet_kehoachhd').modal('show');
                    
                },                    
            });
        })

        $('.keHoach_tontai').on('click', '.show_chitiet_khhd', function(e){
            let id_kh_hd = $(this).attr('d-id');
            $.ajax({
                url: "{{route('admin.tudanhgia.detailedplanning.show_tontai_diemmanh')}}",
                type: "POST",
                data:{
                    id_khbc : {{$id_khbc}},
                    id_kh_hd : id_kh_hd,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {
                    alert(`@lang('project/Selfassessment/title.bcddtt')`);
                },

                success: function(data) {
                    data.forEach(function(keHoach){
                        $('.import_khhd').html(` 
                                <div class="mt-2 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.tieude')</strong>
                                    <span class="pl-5">${keHoach.tieu_de}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.noidung')</strong>
                                    <span class="pl-5">${keHoach.noi_dung}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong class="text-center" style="width:81px">@lang('project/Selfassessment/title.dexuatmoi')</strong>
                                    <span class="pl-5">${keHoach.de_xuat_moi}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.thoigian')</strong>
                                    <span class="pl-5">${keHoach.ngay_batdau}</span>
                                    <span class="pl-5">${keHoach.ngay_hoanthanh}</span>
                                </div>
                                <div class="mt-5 d-flex">
                                    <strong style="width:81px">@lang('project/Selfassessment/title.nhansu')</strong>
                                    <span class="pl-5">${keHoach.nhanSuThucHien.ten_donvi}</span>
                                    <span class="pl-5">${keHoach.nhanSuKiemTra.ten_donvi}</span>
                                </div>           

                        `)
                    });

                    $('.modal_chitiet_kehoachhd').modal('show');
                    
                },                    
            });
        })
        $(function(){
             tontai_diemmanh();
            $('.selectmc_mota').select2({
                dropdownParent: $(".show_minhchunggop"),

            });
            $('.option_mc').select2();
            $('.danMinhChung').click(function(e){
                // console.log(this);
                
                e.preventDefault();
            });
        });
        $('.checks').select2();
        $('.minhChungAllow').on('click','.danMinhChung',function(){
        let idmc_gop =  $(this).attr('id');
        let mcg = $(this).attr('data-mce-href');
        let id = idmc_gop.substring(idmc_gop.indexOf('_')+1);
        clickMC(id,mcg);
     })


    </script>
@stop









