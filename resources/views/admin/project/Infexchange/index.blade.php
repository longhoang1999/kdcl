@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Infexchange/title.bangtin')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('css/project/Infexchange/infexchange.css') }}">
    <style>
        .content-body{
            margin-top: 3rem;
        }
        .comment2{
            padding: 10px;
        }
        .changeBg{
            background-color: #206ae5;
            color: white;
        }
    </style>
@stop

@section('title_page')
    @lang('project/Infexchange/title.bangtin')
@stop

@section('content')
<section class="content-body">
    <div class="sum">
    	<h4>@lang('project/Infexchange/title.bmcsdg')</h4>
    	<div class="comment">
    		<div class="avatar">
                @if($pic != null && $pic != "")
                    <img src="{{  asset($pic) }}" alt="">
                @else 
                    <img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="">
                @endif    
            </div>
            <br>
            <textarea class="form-control pt-2 pb-2 w-20rem" id="content" placeholder="@lang('project/Infexchange/title.dangtin')"></textarea>
            <br>
            <button class="btn btn-info btn-send">@lang('project/Infexchange/title.gui')</button>
    	</div>

        <!-- <div class="continue">
            <button>@lang('project/Infexchange/title.xemthem')</button>
        </div> -->
        <div class="block-render">
        </div>
    </div>


    
</section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        $(".btn-send").click(function() {
            let data = {
				'content': $("#content").val(),
			}
			
			let routeApi = "{{ route('admin.traodoithongtin.messageboard.createbantin') }}";
			fetch(routeApi, {
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: "POST",
				body: JSON.stringify(data),
			})
				.then((response) => response.json())
				.then((data) => {
					if(data.mes == "done"){
						alert('Cập nhật thành công');
						$("#content").val("");
                        renderUI();
					}				
				})
        })
        var assetPath = "{{ asset('') }}";

        renderUI();
        function renderUI(){
            let routeApi = "{{ route('admin.traodoithongtin.messageboard.renderUI') }}";
			fetch(routeApi, {
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			})
				.then((response) => response.json())
				.then((data) => {
                    $(".block-render").empty();
                    let UI = ``;
					data[0].forEach((item, index) => {
                        if(item.perent == "0"){
                            UI = `
                                <div class="feedback">
                                    <div class="avatar">
                                `;
                            if(item.pic == ""){
                                UI += `<img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="">`;
                            }else{
                                UI += `<img src="${assetPath + item.pic}" alt="">`;
                            }
                            UI += `  
                                    </div>
                                    <div class="feedback-block">
                                        <div class="feedback-top">
                                            <p>
                                                <a href="#" class="mr-2">${item.name}</a>
                                                <span>${ item.created_at }</span>
                                            </p>
                                            <p class="pl-3">${item.noidung}</p>
                            `
                            let count = 0; let check = false;
                            data[1].forEach((it, ind) => {
                                if(it.bantin_id == item.id){
                                    count ++;
                                }
                                if(it.user_id == "{{ Sentinel::getUser()->id }}" && it.bantin_id == item.id){
                                    check = true;
                                }
                            })

                            UI += `     <button data-id="${item.id}" class="button-like ${check ? "changeBg" : ""}">
                                                <ion-icon name="thumbs-up-outline"></ion-icon>
                                                <span>${count}</span>
                                                <span>@lang('project/Infexchange/title.thich')</span>
                                            </button>
                                        </div>
                            `
                           
                            data[0].forEach(item2 => {
                                if(item2.perent == item.id){
                                    UI += `
                                        <hr>
                                        <div class="feedback-bottom">
                                            <div class="image">
                                                <div class="avatar">
                                    `
                                    if(item2.pic == ""){
                                        UI += `<img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="">`;
                                    }else{
                                        UI += `<img src="${assetPath + item2.pic}" alt="">`;
                                    }
                                    UI += `
                                                </div>
                                                <p>
                                                    <a href="#" class="mr-2">${item2.name}</a>
                                                    <br>
                                                    <span>${item2.noidung}</span>
                                                    <br>
                                                    <span>
                                                        <span>${item2.created_at}</span>
                                                    </span>
                                                </p>
                                    `
                                    if(item2.user_id == "{{ Sentinel::getUser()->id }}"){
                                        UI += `
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="{{ route('admin.traodoithongtin.messageboard.xoaComment') }}?id=${item2.id}">
                                                                @lang('project/Infexchange/title.xoabl')
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `
                                    }else{
                                        UI += `
                                                </div>
                                            </div> 
                                        `
                                    }
                                }
                            })

                            UI += `
                                <form method="post" action="{{ route('admin.traodoithongtin.messageboard.postParent') }}" class="comment2">
                                    @csrf
                                    <input type="hidden" value="${item.id}" name="id_post">
                                    <div>
                                        @if($pic != null && $pic != "")
                                            <img src="{{  asset($pic) }}" alt="" width="30">
                                        @else 
                                            <img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="" width="30">
                                        @endif
                                    </div> 
                                    <textarea class="form-control" placeholder="Trả lời.." name="content"></textarea>
                                    <div>
                                        <button class="btn btn-primary" type="submit">@lang('project/Infexchange/title.gui')</button>
                                    </div>
                                </form>
                            `
                            UI += `</div>
                                </div>`;
                            $(".block-render").append(UI);
                        }
                    })	
				})
            
        }

        $(".block-render").on('click', '.button-like', function() {
            let idPost = $(this).attr("data-id");
			
			let routeApi = "{{ route('admin.traodoithongtin.messageboard.likePosst') }}" + "?idPost=" + idPost;
			fetch(routeApi, {
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			})
				.then((response) => response.json())
				.then((data) => {
                    if(data.mes == "done"){
                        renderUI();	
                    }
				})
        })
        
        
    </script>

@stop
