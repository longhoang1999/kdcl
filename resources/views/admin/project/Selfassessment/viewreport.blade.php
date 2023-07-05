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
    .arrow_content{
        display: block !important ;
    }
    .arrow_content_text_css{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 30px;
    height: 4rem;
    

}
h4{
    font-size: 16px;
    font-weight: 400;
}
.target{
    margin-bottom: 3rem;
}
.modal-header-1{
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
    }
div {
    font-size: 15px;
}
.content-body{
    padding-left: 15px !important;
    padding-right: 15px !important;
    width: 100% !important;
}
table,tr,td{
    border: solid 1px lightblue;
}
td{
    text-align: center;
}
</style>
@stop

@section('title_page')
    
@stop

@section('content')
<section class="content-body">
    <div class="show_minhc">

    
        <div id="contextMenu" class="btn btn-primary btn-sm" style="position: absolute;z-index:9999999;display:none;">
            <i class="fas fa-comment-alt"></i> @lang('project/Selfassessment/title.vietnhanxet')
        </div>
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
            <div class="text-right">
                <div>
                    <button class="btn btn-success btn-lg" id="guiNhanXet" data-toggle="modal" data-target="#guinhanxet" > 
                        <i class="fas fa-share-square"></i> @lang('project/Selfassessment/title.guinhanxet')
                    </button>
                    @if($Forward)
                        <a class="btn btn-info btn-lg" href="{{route('admin.tudanhgia.commentreport.viewReport')}}?id={{$id_khbc}}&tieuchuan_id={{$Forward}}" style="color: #FFFFFF";>
                            <i class="fas fa-chevron-right"></i> @lang('project/Selfassessment/title.nhanxettctt')
                        </a>
                    @endif
                    
                </div>
            </div>
            <h3>
                @lang('project/Selfassessment/title.tc') {{ $tieuChuan->stt}}
            </h3>
            <h2>
                <strong>{{$tieuChuan->mo_ta}}</strong>
                @if($sum_danhgia > 0)
                    <small class="text-danger">
                        <i class="fas fa-star"></i>
                        @lang('project/Selfassessment/title.danhgiamuc') {{ $sum_danhgia }}
                    </small>
                @endif
            </h2>
            
        </div>

        <div class="arrow_content">
            <div class="arrow_content_t clickToComment">
        
            @if($keHoachBaoCaoDetail->loai_tieuchuan != 'csdt')
                        <div class="group_back">
                            <div class="arrow_content_text_css">
                                <h4>@lang('project/Selfassessment/title.modau')</h4>
                                <button id="show_content" onclick="showhidetieuchi()"><i class="fa fa-chevron-up" id="show_arrow"></i></button>
                            </div>
                            <div id="content_text" >
                                <div class="text_contents" >

                                    @if($baoCaoTieuChuan)

                                        @foreach($nhanxetbc as $nhanXet)

                                            @php

                                                if(strlen(strstr($baoCaoTieuChuan->modau,$nhanXet->noidung)) > 0){
                                                    $change = "<a class='commentDetail label label-warning' d-id='$nhanXet->id' d-data='<small><p>{$nhanXet->nhanxet}</p> bởi {$nhanXet->user->name} ({$nhanXet->user->ten_donvi}) vào lúc {$nhanXet->created_at}</small>'>$nhanXet->noidung</a>";
                                                    $baoCaoTieuChuan->modau = str_replace($nhanXet->noidung,$change,$baoCaoTieuChuan->modau);

                                                }
                                            @endphp
                                        @endforeach
                                        {!!$baoCaoTieuChuan->modau!!}
                                    @endif
                                </div>

                            </div>

                            @if($baoCaoTieuChuan)
                                @include("admin.project.Selfassessment.viewcomment",['kieu'=>'tieuchuan_modau','id'=>$baoCaoTieuChuan->id,'id_kehoach_bc'=>$id_khbc])
                            @endif
                        </div>
            @endif
                @foreach($tieuchuans_tieuchi->tieuchi as $kehoachtieuchi)
                    <div class="block_content">
                        <div class="block_content_title">
                            <h4><strong>{{$tieuChuan->stt}}.{{$kehoachtieuchi->stt}}</strong></h4>
                            <h4 onclick="showhidetieuchi2({!!$kehoachtieuchi->id!!})"><a class="collapse-link huongDanTieuChi" d-id="{{ $kehoachtieuchi->id }}">{{ $kehoachtieuchi->mo_ta }}</a></h4>
                        </div>
                        <div class="ibox-tools">
                            <!-- cần sửa lại if này -->

                            @if(isset($danhGiaTieuChiData[$kehoachtieuchi->id]))
                                <a data-toggle="tooltip" title="Đánh giá" class="danhGiaTieuChi"
                                d-danhgia="{{ $danhGiaTieuChiData[$kehoachtieuchi->id] }}">
                                        <span class="text-danger">
                                        <i class="fas fa-star "></i> {{ $danhGiaTieuChiData[$kehoachtieuchi->id] }}
                                        </span>
                                </a>
                            @endif
                        </div>
                        <div class="ibox_cotent css_width" id="show_block_content_{!!$kehoachtieuchi->id!!}" >
                        @if(count($kehoachtieuchi->bc_menhde) > 0)
                            @foreach($kehoachtieuchi->bc_menhde as $menhde)
                                {{--@continue(!$menhde->menhde)--}}
                                <div class="ibox-title border-bottom">
                                    <div class="ibox-tools2">
                                        <h4>{{$menhde->mo_ta}}</h4>
                                    </div>
                                </div>
                                <div class="ibox-content border-bottom">
                                    <h3>@lang('project/Selfassessment/title.mota')</h3>

                                    @php
                                        if($kehoachtieuchi->baocao_tieuchi){
                                            $editable = ($kehoachtieuchi->baocao_tieuchi->trang_thai=='dangsua' || $kehoachtieuchi->baocao_tieuchi->trang_thai=='nhanxet')?"click2edit hover-shadows":"";
                                        }else{
                                            $editable="click2edit hover-shadows";
                                        }
                                    @endphp
                                    <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">
                                        <div class="texts_{!! $menhde->id !!}" >
                                            @if($menhde)

                                                @foreach($nhanxetbc as $nhanXet)
                                                    @php

                                                        if(str_contains($menhde->mota,$nhanXet->noidung)){

                                                            $menhde->mota = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-id='$nhanXet->id' d-data='<small><p>{$nhanXet->nhanxet}</p> bởi {$nhanXet->user->name} ({$nhanXet->user->ten_donvi}) vào lúc {$nhanXet->created_at}</small>'>$nhanXet->noidung</a>",$menhde->mota);
                                                        }
                                                    @endphp
                                                @endforeach
                                                {!! $menhde->mota !!}
                                            @else
                                                <i class="text-muted">@lang('project/Selfassessment/title.bvddtmt')</i>
                                            @endif
                                        </div>

                                    
                                    </div>
                                </div>  
                                    @if($menhde->id)
                                        @include("admin.project.Selfassessment.viewcomment",['kieu'=>'menhde_mota','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                    @endif 
                                <div class="hr-line-dashed"></div>

                                <h3>@lang('project/Selfassessment/title.diemmanh')</h3>

                                <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">
                                    <div class="texts2_{!! $menhde->id !!}">
                                        @foreach($nhanxetbc as $nhanXet)
                                            @php
                                                if(str_contains($menhde->mo_ta,$nhanXet->noidung)){
                                                    $menhde->diemmanh = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-id='$nhanXet->id' d-data='<small><p>{$nhanXet->nhanxet}</p> bởi {$nhanXet->user->name} ({$nhanXet->user->ten_donvi}) vào lúc {$nhanXet->created_at}</small>'>$nhanXet->noidung</a>",$menhde->diemmanh);
                                                }
                                            @endphp
                                        @endforeach
                                        {!! $menhde->diemmanh !!}
                                    </div>               
                                </div>

                                <h3>
                                    @lang('project/Selfassessment/title.khphdm')
                                </h3>

                                <div class="ibox-content">
                                    <table class="table clause-table clause-table-editabe">
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
                                        <tbody class="keHoach_diemmanh" id="keHoach_diemmanh_{{ $menhde->id }}">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                @if($menhde->diemmanh)
                                    @include("admin.project.Selfassessment.viewcomment",['kieu'=>'menhde_diemmanh','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                @endif
                                <div class="hr-line-dashed"></div>

                                <h3>@lang('project/Selfassessment/title.tontai')</h3>

                                <div class="ibox-content minhChungAllow shadows" d-tieuChi="{{ $menhde->tieuchi_id }}">
                                    <div class="texts3_{!! $menhde->id !!}">
                                            @foreach($nhanxetbc as $nhanXet)
                                                @php
                                                    if(str_contains($menhde->mo_ta,$nhanXet->noidung)){
                                                        $menhde->tontai = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-id='$nhanXet->id' d-data='<small><p>{$nhanXet->nhanxet}</p> bởi {$nhanXet->user->name} ({$nhanXet->user->ten_donvi}) vào lúc {$nhanXet->created_at}</small>'>$nhanXet->noidung</a>",$menhde->tontai);
                                                    }
                                                @endphp
                                            @endforeach
                                            {!! $menhde->tontai !!}
                                    </div>
                        
                                </div>

                                <h3>
                                    @lang('project/Selfassessment/title.khkp')
                                </h3>

                                <div class="ibox-content">
                                    <table class="table">
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
                                        <tbody class="keHoach_tontai" id="keHoach_tontai_{{ $menhde->id }}">

                                        </tbody>
                                    </table>
                                </div>

                                @if($menhde->tontai)
                                    @include("admin.project.Selfassessment.viewcomment",['kieu'=>'menhde_tontai','id'=>$menhde->id,'id_kehoach_bc'=>$id_khbc])
                                @endif
                            @endforeach
                        @endif 
                    </div>
                    </div>
                @endforeach
            @if(isset($keHoachBaoCaoDetail->bo_tieuchuan->loai_tieuchuan))
                @if($keHoachBaoCaoDetail->bo_tieuchuan->loai_tieuchuan != 'csdt')
                    @if($keHoachTieuChuan->id_truong_nhom == Sentinel::getUser()->id || $keHoachBaoCaoDetail->ns_phutrach == Sentinel::getUser()->id || Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                        <div class="group_back">
                            <div class="arrow_content_text_css">
                                <h4>@lang('project/Selfassessment/title.ketluan')</h4>
                                <button id="show_content2" onclick="showhidetieuchi3()"><i class="fa fa-chevron-up" id="show_arrow2"></i></button>
                            </div>

                            <div id="content_text2" >
                                <div class="text_contents2" >
                                        @foreach($nhanxetbc as $nhanXet)
                                            @php
                                                if(str_contains($baoCaoTieuChuan->ketluan,$nhanXet->noidung)){
                                                    $baoCaoTieuChuan->ketluan = str_replace($nhanXet->noidung,"<a class='commentDetail label label-warning' d-id='$nhanXet->id' d-data='<small><p>{$nhanXet->nhanxet}</p> bởi {$nhanXet->user->name} ({$nhanXet->user->ten_donvi}) vào lúc {$nhanXet->created_at}</small>'>$nhanXet->noidung</a>",$baoCaoTieuChuan->ketluan);
                                                }
                                            @endphp
                                        @endforeach
                                        {!!$baoCaoTieuChuan->ketluan!!}
                                </div>
                            </div>
                        @if($baoCaoTieuChuan)
                                @include("admin.project.Selfassessment.viewcomment",['kieu'=>'tieuchuan_ketluan','id'=>$baoCaoTieuChuan->id,'id_kehoach_bc'=>$id_khbc])
                            @endif
                        </div>
                    @endif
                @endif
            @endif
            </div>
        </div>
    </div>

    <!-- Modal gửi nhận xét-->
    <form action="{{ route('admin.tudanhgia.commentreport.update_comment') }}" method="POST">
        <input type="text" hidden name="id_khbc" value="{{$id_khbc}}">
        <input type="text" hidden name="tieuchuan_id" value="{{$tieuchuan_id}}">
        @csrf
        <div class="modal fade" id="guinhanxet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" id="exampleModalLongTitle">@lang('project/Selfassessment/title.guinhanxet')</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    @lang('project/Selfassessment/title.ndguinhanxet')
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                  <button type="submit" class="btn btn-info btn-lg">@lang('project/Selfassessment/title.guinhanxet')</button>
                </div>
              </div>
            </div>
          </div>
    </form>


    <!-- Modal viết nhận xét-->
    <div class="modal inmodal fade" id="nhanXetModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title">@lang('project/Selfassessment/title.vietnhanxet')</h3>
                </div>
                <form class="ajaxForm form-horizontal reloadDone" id="nhanXetForm"
                      action="{{ route('admin.tudanhgia.commentreport.update_nx') }}" method="POST">
                    <div class="modal-body">

                        @csrf
                        <input name="type" type="hidden" value="chung">
                        <input name="kh" type="hidden" value="{{ $id_khbc }}">
                        <input name="tieuchuan_id" type="hidden" value="{{ $tieuchuan_id }}">
                        <input name="userId" type="hidden" value="{{ $userId }}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.nhanxetcho')</label>
                            <div class="col-sm-12">
                                <textarea name="noidung" class="form-control noidung" readonly></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('project/Selfassessment/title.noidung')</label>
                            <div class="col-sm-12">
                                <textarea name="nhanxet" class="form-control"></textarea>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div id="ajaxFormOutput" ></div>
                        <button type="submit" class="btn btn-primary ladda-button" data-style="expand-right">
                            @lang('project/Selfassessment/title.nhanxet')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal_nhanxet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="{{ route('admin.tudanhgia.commentreport.delete_nx') }}" method="POST">
            @csrf
            <input type="text" hidden name="id_nx" id="id_nhanxet">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">@lang('project/Selfassessment/title.nhanxet')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body show_nhanxet">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/Selfassessment/title.ok')</button>
                <button type="submit" class="btn btn-primary">@lang('project/Selfassessment/title.xoanhanxet')</button>
              </div>
        </form>
        </div>
      </div>
    </div>
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

            flatpickr('.datelocal', {
                dateFormat: 'd-m-Y',
            });
            flatpickr('.datelocal2', {
                dateFormat: 'd-m-Y',
            });
            flatpickr('.datelocal3', {
                dateFormat: 'd-m-Y',
            });
            flatpickr('.datelocal4', {
                dateFormat: 'd-m-Y',
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
                toolbar2: 'print preview media | forecolor backcolor emoticons',
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
                setup: function (ed) {
                    ed.on('init', function(args) {
                        
                    });
                }
            });
        
            $('#contextMenu').on('click', function () {
            var selectedText = x.Selector.getSelected();
            $('#contextMenu').hide();
            if (selectedText != '') {
                $('#nhanXetModal').modal('show');
                $('#nhanXetForm .noidung').text(selectedText)
            } else {
                $('#nhanXetModal').modal('hide');
            }
        });
        if (!window.x) {
            x = {};
        }

        x.Selector = {};
        x.Selector.getSelected = function () {
            var t = '';
            if (window.getSelection) {
                t = window.getSelection();
            } else if (document.getSelection) {
                t = document.getSelection();
            } else if (document.selection) {
                t = document.selection.createRange().text;
            }
            return t;
        };

        var pageX, pageY;

        $(document).ready(function () {
            $('.clickToComment').on("mouseup", function () {
                var selectedText = x.Selector.getSelected();

                if (selectedText != '') {
                    $('#contextMenu').css({
                        'left': pageX - 120,
                        'top': pageY - 120
                    }).fadeIn(200);
                    //alert(selectedText);
                } else {
                    $('#contextMenu').fadeOut(200);
                }
            });
            $(document).on("mousedown", function (e) {
                pageX = e.pageX;
                pageY = e.pageY;
            });
        });

            
    $('.arrow_content').on('click','.commentDetail',function(){
        let noidung = $(this).attr('d-data');
        let id_nx = $(this).attr('d-id');
        $('#id_nhanxet').val(id_nx);
        $('.show_nhanxet').html(noidung);
        $('#modal_nhanxet').modal('show');

    })
    $(function(){
         $('.show_minhc').on('click','.danMinhChung',function(){
            let id = $(this).attr('d-id');
            window.location= "{!! route('admin.tudanhgia.preparereport.editmcgop',0)!!}"+id;
        })

      
    });
    </script>

@stop









