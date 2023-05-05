@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Infexchange/title.bangtin')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('css/project/Infexchange/infexchange.css') }}">
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
            <textarea class="form-control pt-2 pb-2 w-20rem" placeholder="@lang('project/Infexchange/title.traloi')"></textarea>
            <br>
            <button class="btn btn-info">@lang('project/Infexchange/title.gui')</button>
    	</div>
    	<div class="feedback">
    		<div class="avatar">
                <img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="">      
            </div>
            <div class="feedback-block">
                <div class="feedback-top">
                    <p>
                        <a href="#" class="mr-2">Phuc.bui</a>
                        <span>2021-07-06 10:52:58</span>
                    </p>
                    <p class="pl-3">Quyết định bảo vệ khóa luận</p>
                    <button class="button-like">
                        <ion-icon name="thumbs-up-outline"></ion-icon>
                        <span>@lang('project/Infexchange/title.thich')</span>
                    </button>
                    <button class="button-comment">
                        <ion-icon name="chatbox-ellipses-outline"></ion-icon>
                        <span>@lang('project/Infexchange/title.binhluan')</span>
                    </button>
                </div>
                <div class="feedback-bottom">
                    <div class="image">
                        <div class="avatar">
                            <img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="">      
                        </div>
                        <p>
                            <a href="#" class="mr-2">tien.duc</a>
                            <br>
                            <span>abc</span>
                            <br>
                            <span>
                                <ion-icon name="thumbs-up-outline"></ion-icon>
                                <span>0</span>
                                <span>@lang('project/Infexchange/title.luotthich')</span>
                                 - 
                                <span>2022-02-05 0:38:35</span>
                            </span>
                        </p>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">
                                    @lang('project/Infexchange/title.xoabl')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="comment2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="48" fill="currentColor" class="bi bi-file-earmark-person-fill" viewBox="0 0 16 16">
                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755z"/>
                        </svg>
                        <br>
                        <textarea placeholder="Trả lời.."></textarea>
                        <br>
                        <button>@lang('project/Infexchange/title.gui')</button>
                    </div>
                </div>
            </div>
    	</div>

        <div class="comment-buttom">
            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="currentColor" class="bi bi-file-earmark-person-fill" viewBox="0 0 16 16">
                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755z"/>
            </svg>
            <div class="block-comment">
                <a href="">thuoc.nghiem</a>
                <span>2020-11-1</span>
                <span>14:32:12</span>
                <p>@lang('project/Infexchange/title.nmcstgvvlgd')</p>
            <button class="button-like2">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                </svg>
                <span>@lang('project/Infexchange/title.thich')</span>
            </button>
            <button class="button-comment2">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" class="bi bi-wechat" viewBox="0 0 16 16">
                    <path d="M11.176 14.429c-2.665 0-4.826-1.8-4.826-4.018 0-2.22 2.159-4.02 4.824-4.02S16 8.191 16 10.411c0 1.21-.65 2.301-1.666 3.036a.324.324 0 0 0-.12.366l.218.81a.616.616 0 0 1 .029.117.166.166 0 0 1-.162.162.177.177 0 0 1-.092-.03l-1.057-.61a.519.519 0 0 0-.256-.074.509.509 0 0 0-.142.021 5.668 5.668 0 0 1-1.576.22ZM9.064 9.542a.647.647 0 1 0 .557-1 .645.645 0 0 0-.646.647.615.615 0 0 0 .09.353Zm3.232.001a.646.646 0 1 0 .546-1 .645.645 0 0 0-.644.644.627.627 0 0 0 .098.356Z"/>
                    <path d="M0 6.826c0 1.455.781 2.765 2.001 3.656a.385.385 0 0 1 .143.439l-.161.6-.1.373a.499.499 0 0 0-.032.14.192.192 0 0 0 .193.193c.039 0 .077-.01.111-.029l1.268-.733a.622.622 0 0 1 .308-.088c.058 0 .116.009.171.025a6.83 6.83 0 0 0 1.625.26 4.45 4.45 0 0 1-.177-1.251c0-2.936 2.785-5.02 5.824-5.02.05 0 .1 0 .15.002C10.587 3.429 8.392 2 5.796 2 2.596 2 0 4.16 0 6.826Zm4.632-1.555a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0Zm3.875 0a.77.77 0 1 1-1.54 0 .77.77 0 0 1 1.54 0Z"/>
                </svg>
                <span>@lang('project/Infexchange/title.binhluan')</span>
            </button>
            </div>
        </div>
        <div class="continue">
            <button>@lang('project/Infexchange/title.xemthem')</button>
        </div>
    </div>
</section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')


@stop
