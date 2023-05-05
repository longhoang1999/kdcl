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
    @lang('project/Selfassessment/title.ketluan')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
	<div class="general">
		<h2>
       		@lang('project/Selfassessment/title.phan3')
    	</h2>
    	<ol class="list_ol">
    		<li>
    			<a href="">@lang('project/Selfassessment/title.trangchu')</a>/
    		</li>
    		
    		<li><span>@lang('project/Selfassessment/title.baocao')</span>/</li>
    		
    		<li><span>{!! $KHBaCaoDetail->ten_bc !!}</span></li>
    		
    		<li><strong>@lang('project/Selfassessment/title.phan3')</strong>/</li>
    	</ol>
	</div>

	<div class="body_content">     
			<div class="col-sm-12">
                <h3>@lang('project/Selfassessment/title.gypkl')</h3>
                <span>@lang('project/Selfassessment/title.noidungtomtatndm')</span>
                <br/><span>@lang('project/Selfassessment/title.tomtatndtt')</span> <br/>
                <span> @lang('project/Selfassessment/title.khct')</span><br>
                <span> @lang('project/Selfassessment/title.thdg')</span>
            </div>
		
		<div class="update_text"> 
            <form action="{!! route('admin.tudanhgia.detailedplanning.updateconclusion') !!}" method="POST">
                <input type="hidden" name="kh" class="id_kh" value="{{ $KHBaCaoDetail->id }}">
                <input type="hidden" name="id_kehoacchung" class="id_khc" value="{{ $id_kehoacchung }}">
                @csrf  
        		<div class="row">
                    <div class="col-12">
                        <div class="card my-3">
                               
                                <div class="bootstrap-admin-card-content">
                                    <textarea name="text" id="tinymce_full" class="text_kl">
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
        			<button style="background-color: #1ab394;border-color: #1ab394;color: #FFFFFF;" type="button" onclick="update_kl()">
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


        function update_kl(){
               let kh = $('.id_kh').val();
               let id_kehoacchung = $('.id_khc').val();
               // let text = $('#tinymce_full').val();
               // let a = tinymce.get('#tinymce_full').getContent();
               // let modau = tinymce.activeEditor.getContent();
               tinymce.triggerSave();
               let text = $('.text_kl').val();
  
               $.ajax({
                        url: "{!! route('admin.tudanhgia.detailedplanning.updateconclusion') !!}",
                        type: "POST",
                        data:{
                            kh : kh,
                            id_kehoacchung : id_kehoacchung,
                            text : text,
                            _token: '{{ csrf_token() }}'
                        },    
                        error: function(err) {

                        },

                        success: function(data) {
                            alert("Bạn đã cập nhật thành");
                        },
                    })
            }
    </script>
@stop











