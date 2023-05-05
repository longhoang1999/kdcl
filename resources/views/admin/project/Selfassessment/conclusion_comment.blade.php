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
<style>
    .modal-header-1{
        padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(0.3rem - 1px);
    border-top-right-radius: calc(0.3rem - 1px);
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.khaiquat')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div id="contextMenu" class="btn btn-primary btn-sm" style="position: absolute;z-index:9999999;display: none">
        <i class="bi bi-chat-right-text"></i> @lang('project/Selfassessment/title.vietnhanxet')
    </div>
	<div class="general">
		<h2>
       		@lang('project/Selfassessment/title.phan3')
    	</h2>
    	<ol class="list_ol">
    		<li>
    			<a href="">@lang('project/Selfassessment/title.trangchu')</a>/
    		</li> 		
    		<li><span>@lang('project/Selfassessment/title.baocao')</span>/</li> 		
    		<li><span>{!! $kehoachbaocaos->ten_bc !!}</span></li>
    		<li><strong>@lang('project/Selfassessment/title.phan3')</strong></li>
    	</ol>
	</div>

    <div class="body_content">

		<div class="clickToComment">
            <div class="row">
                <div class="col-12">         
                    {!! $ketluan !!} 
                </div>
            </div>
            <div class="to_back">
                <div>
                    <a href="{{ route('admin.tudanhgia.commentreport.index')}}" class="fas fa-chevron-left">
                        @lang('project/Selfassessment/title.trove')
                    </a>
                </div>	
            </div>
        </div>
        @include("admin.project.Selfassessment.viewcomment",([ 'kieu' => 'chung.modau','ketluan' => $ketluan, 'id' => $id]))

	</div>
    <div class="modal inmodal fade" id="nhanXetModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header-1">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only"></span>
                    </button>
                    <h4 class="modal-title">@lang('project/Selfassessment/title.vietnhanxet')</h4>
                </div>
                <form class="ajaxForm form-horizontal reloadDone" id="nhanXetForm"
                      action="{{ route('admin.tudanhgia.commentreport.createComment') }}" method="POST">
                    <div class="modal-body">

                        @csrf
                        <input name="type" type="hidden" value="chung">
                        {{-- <input name="kh" type="hidden" value="{{ $KHBaCaoDetail->id }}">
                        <input name="id_chung_bc" type="hidden" value="{{ $keHoachChung->id }}"> --}}

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
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')

 <!-- Bootstrap WYSIHTML5 -->
    <script src="{{asset('vendors/ckeditor/js/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendors/tinymce/js/tinymce.min.js')}}" type="text/javascript"></script>
    <!-- <script src="{{ asset('js/pages/editor.js') }}" type="text/javascript"></script> -->

    <script>
        tinymce.init({
            selector: '#tinymce_full',
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
                        'left': pageX - 230,
                        'top': pageY - 105
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

        // $('.commentDetail').on('click', function () {
        //     var content = document.createElement("span");
        //     content.innerHTML = $(this).attr('d-data');
        //     var id = $(this).attr('d-id');
        //     swal({
        //         title: "Nhận xét",
        //         icon: "info",
        //         content: content,
        //         buttons: {
        //             cancel: "OK",
        //             confirm: {
        //                 text: "Xóa nhận xét",
        //                 closeModal: false
        //             }
        //         },
        //         dangerMode: true,
        //     }).then((value) => {
        //         if (!value) throw null;
        //         
        //         }).done(function () {
        //             swal("Thành công!", "Nhận xét đã được xóa", "success").then((value) => {
        //                 location.reload();
        //             });
        //         }).fail(function (jqXHR, textStatus) {
        //             var parsed = $.parseJSON(jqXHR.responseText);

        //             if (parsed.message) {
        //                 swal("", parsed.message, "warning");
        //                 return false;
        //             }

        //             $.each(parsed.errors, function (index, value) {
        //                 swal("Sự cố khi xử lý", value[0], "warning");
        //                 return false;
        //             });
        //         });
        //     });
        // });

        // $('.quote').on('click', function () {
        //     $(this).parent().parent().parent().parent().find('input[name=parent]').val($(this).attr('data-parent'));
        //     $(this).parent().parent().parent().parent().find('textarea').focus();
        //     $(this).parent().parent().parent().parent().find('.traloi').removeClass("hide").text($(this).attr('data-quote'));
        // })
    </script>
@stop











