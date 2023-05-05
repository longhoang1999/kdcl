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
@stop

@section('title_page')
    @lang('project/Selfassessment/title.khaiquat')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
	<div class="general">
		<h2>
       		@lang('project/Selfassessment/title.phan1')
    	</h2>
    	<ol class="list_ol">
    		<li>
    			<a href="">@lang('project/Selfassessment/title.trangchu')</a>/
    		</li>
    
    		<li><span>@lang('project/Selfassessment/title.baocao')</span>/</li>
    		
    		<li><span>{!! $kehoachbaocaos->ten_bc !!}</span>/</li>
    		
    		<li><strong>@lang('project/Selfassessment/title.phan1')</strong></li>
    	</ol>
	</div>

	<div class="body_content">

		@if($kehoachbaocaos->loai_tieuchuan == 'ctdt')
			<div class="col-sm-12">
                <h3>@lang('project/Selfassessment/title.gypkq')</h3>
                <b>@lang('project/Selfassessment/title.datvande')</b><br/>
                @lang('project/Selfassessment/title.noidungtomtat')
                <br/><b>@lang('project/Selfassessment/title.tongquanc')</b> @lang('project/Selfassessment/title.khoang')<br/>
                @lang('project/Selfassessment/title.motatt')
            </div>
		@else
			<div class="col-sm-12">
                <h3> @lang('project/Selfassessment/title.phan1hs') </h3>
                <b>@lang('project/Selfassessment/title.khaiquatgd')</b><br/>
                @lang('project/Selfassessment/title.khaiquatls')
                <br/><b>@lang('project/Selfassessment/title.boicanh')</b><br/>
                @lang('project/Selfassessment/title.motaqd')
                <br/><b>@lang('project/Selfassessment/title.cosodl')</b><br/>
            </div>
		@endif
		<div class="update_text"> 
            <form action="{!! route('admin.tudanhgia.detailedplanning.updategeneral') !!}" method="POST">
                <input type="hidden" class="kh_bc_id" name="kh" value="{{ $kehoachbaocaos->id }}">
                <input type="hidden" name="id_kehoacchung" class="kh_chung_id" value="{{ $id_kehoacchung }}">
                @csrf  
        		<div class="row">
                    <div class="col-12">
                        <div class="card my-3">
                    
                                <div class="bootstrap-admin-card-content">
                                    <textarea name="text" id="tinymce_full" class="dd">
                                        {!! $text !!}
                                    </textarea>
                                
                            </div>
                        </div>
                    </div>
                </div>
        		<div class="to_back">
        			<p>
                        <a href="{{route('admin.tudanhgia.detailedplanning.index')}}">
            				<i class="fas fa-chevron-left"></i>
            				@lang('project/Selfassessment/title.trove')
                        </a>
        			</p>
        			<button style="background-color: #1ab394;border-color: #1ab394;color: #FFFFFF;" type="button" id="submit_kq" onclick="update()">
        				<i class="fas fa-edit"></i>
        				@lang('project/Selfassessment/title.capnhat')
        			</button> 
        		</div>
            </form>
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

        function update(){
           let kh_bc = $('.kh_bc_id').val();
           let kh_chung = $('.kh_chung_id').val();
           let text = tinymce.activeEditor.getContent();
           $.ajax({
                    url: "{!! route('admin.tudanhgia.detailedplanning.updategeneral') !!}",
                    type: "POST",
                    data:{
                        kh : kh_bc,
                        id_kehoacchung : kh_chung,
                        text : text,
                        _token: '{{ csrf_token() }}'
                    },    
                    error: function(err) {

                    },

                    success: function(data) {
                        alert("Bạn đã cập nhật thành");
                       // console.log(data)
                    },
                })
        }
    </script>
@stop











