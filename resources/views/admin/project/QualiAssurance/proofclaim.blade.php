@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.qlmcyc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">

@stop

@section('title_page')
    @lang('project/QualiAssurance/title.qlmcyc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <h2>
        @lang('project/QualiAssurance/title.tmmcyc')
    </h2>
    <div class="line"></div>
        <h4>@lang('project/QualiAssurance/title.ttlvhd')</h4>
        
        <div class="container-fuild mt-3 pl-4">
            <div class="row">
                <div class="col-md-2">
                    <span>@lang('project/QualiAssurance/title.nam')</span>
                </div>
                <div class="col-md-3">
                    <span>@lang('project/QualiAssurance/title.lvuc')</span>
                </div>
                <div class="col-md-5">
                    <span>@lang('project/QualiAssurance/title.hdong')</span>
                </div>
            </div>
            <div class="row mt-3 ">
                <div class="col-md-2">
                    <select class="form-control h-2rem select2">
                        @for($i = 1990;$i <= intVal(date('Y'));$i++)
                        <option>{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control h-2rem select2" >
                        <option hidden>@lang('project/QualiAssurance/title.lclv')</option>
                        @foreach ($linhvuc as $item)
                            <option value="{{ $item->id }}">{{ $item->tieu_de }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select class="form-control h-2rem select2">
                        <option hidden>@lang('project/QualiAssurance/title.thoatd')</option>
                        @foreach ($hoatdong as $item)
                            <option value="{{ $item->id }}">{{ $item->noi_dung }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <h3>@lang('project/QualiAssurance/title.tmmcyc')</h3>
        <form action="" method="post" class="container-fuild">
            @csrf
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.slmcyc')
                </div>
                <div class="col-md-1">
                    <input type="number" class="form-control" placeholder="3">
                </div>
            </div>
            <div class="container-fuild mt-3 pl-4">
                <div class="row">
                    <div class="col-md-5">
                        <span>@lang('project/QualiAssurance/title.mcyc')1</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.dvth')</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.tgian')</span>
                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col-md-5">
                        <input type="text" class="form-control h-2rem" placeholder="@lang('project/QualiAssurance/title.ndmcyc')">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control h-2rem">
                            <option>TT ĐBCL, Đào tạo, Cơ khí</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control h-2rem" placeholder="12/10/2021-12/02/2022">
                    </div>
                </div>
            </div>
            <div class="container-fuild mt-3 pl-4">
                <div class="row">
                    <div class="col-md-5">
                        <span>@lang('project/QualiAssurance/title.mcyc')2</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.dvth')</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.tgian')</span>
                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col-md-5">
                        <input type="text" class="form-control h-2rem" placeholder="@lang('project/QualiAssurance/title.ndmcyc')">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control h-2rem">
                            <option>Tất cả</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control h-2rem" placeholder="12/10/2021-12/02/2022">
                    </div>
                </div>
            </div>
            <div class="container-fuild mt-3 pl-4">
                <div class="row">
                    <div class="col-md-5">
                        <span>@lang('project/QualiAssurance/title.mcyc')3</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.dvth')</span>
                    </div>
                    <div class="col-md-3">
                        <span>@lang('project/QualiAssurance/title.tgian')</span>
                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col-md-5">
                        <input type="text" class="form-control h-2rem" placeholder="@lang('project/QualiAssurance/title.ndmcyc')">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control h-2rem">
                            <option>TTT ĐBCL</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control h-2rem" placeholder="12/10/2021-12/02/2022">
                    </div>
                </div>
            </div>
    
            <div class="item-group-button mb-2">
                <button class="btn btn-success btn-benchmark mt-5 ml-4 pl-3 pr-3" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon" viewBox="0 0 16 16">
                        <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                      </svg>  
                    <span>@lang('project/QualiAssurance/title.huy')</span>
                </button>
                <button class="btn btn-success btn-benchmark mt-5 ml-4 pl-3 pr-3" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                        <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                    </svg>   
                <span>@lang('project/QualiAssurance/title.luu')</span>
                </button>
            </div>
        </form>
        
</section>
<!-- /Kết thúc page trang -->
    
    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script>
    $(".select2").select2();
    
</script>


@stop
