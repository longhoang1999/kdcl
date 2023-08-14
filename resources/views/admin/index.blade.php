@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Home
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <style>
        #kt_post{
            background: transparent !important;
        }
        .left, .right{
           margin-bottom: 40px;
            padding: 0 10px;
        }
        .common-info, .info-user, .block-table{
            width: 100%;
            background: white;
            border-radius: 10px;
            padding: 20px 30px;
            box-shadow: 0 0 12px #b1b1b1;
        }
        .info-item{
            width: 48%;
            margin-bottom: 35px;
            box-shadow: 0 0 12px #b1b1b1;
            border-radius: 5px;
        }
        .common-info-content{
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .bg-blue{
            background: #03a9f4;
        }
        .bg-green{
            background: #8bc34a;
        }
        .bg-orange{
            background: #ffc107;
        }
        .bg-red{
            background: #f44336;
        }
        .block-flex{
            padding: 10px 15px;
        }
        .block-flex a{
            color: rgb(96, 125, 139);
        }
        .bg{
            display: flex;
            padding: 30px 20px;
        }
        .bg i{
            font-size: 80px !important;
            color: white;
            width: 60%;
        }
        .block-text{
            text-align: right;
        }
        .block-text h1{
            font-size: 50px;
            color: white;
        }
        .block-text p{
            font-size: 20px !important;
            color: white;
        }
        .content-user img{
            border-radius: 50%;
        }
        .info-user h1{
            margin-bottom: 60px;
        }
        .link-name{
            font-size: 20px !important;
            color: #373737;
        }
        .link-email{
            font-size: 15px !important;
        }
        .table-img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .chucvu{
            color: #bda5f8!important;
            font-weight: 400;
            font-size: 14px;
            display: block;
        }
        .avatar{
            display: flex;
            align-items: center;
        }
        .block-chucvu{
            margin-left: 20px;
        }
    </style>
@stop

@section('title_page')
    @lang('default.trangchu')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <div class="container-fuild">
            <div class="row">
                <div class="left col-md-8">
                    <div class="common-info">
                        <h1 class="mb-5">Thông tin chung</h1>
                        <div class="common-info-content">
                            <div class="info-item">
                                <div class="bg bg-blue">
                                    <i class="bi bi-window fs-3"></i>
                                    <div class="block-text">
                                        <h1 class="">26</h1>
                                        <p>Comment</p>
                                    </div>
                                </div>
                                <div class="block-flex">
                                    <a href="">Xem chi tiết</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="bg bg-green">
                                    <i class="bi bi-layers fs-3"></i>
                                    <div class="block-text">
                                        <h1>26</h1>
                                        <p>Comment</p>
                                    </div>
                                </div>
                                <div class="block-flex">
                                    <a href="">Xem chi tiết</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="bg bg-orange">
                                    <i class="bi bi-grid fs-3"></i>
                                    <div class="block-text">
                                        <h1>26</h1>
                                        <p>Comment</p>
                                    </div>
                                </div>
                                <div class="block-flex">
                                    <a href="">Xem chi tiết</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="bg bg-red">
                                    <i class="fas fa-edit"></i>
                                    <div class="block-text">
                                        <h1>26</h1>
                                        <p>Comment</p>
                                    </div>
                                </div>
                                <div class="block-flex">
                                    <a href="">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right col-md-4">
                    <div class="info-user">
                        <h1>Thông tin tài khoản</h1>
                        <div class="content-user text-center">
                            <div class="symbol symbol-160px">
                                @if(Sentinel::getUser()->pic)
                                    <img alt="Logo" src="{{ asset(Sentinel::getUser()->pic) }}" />
                                @elseif(Sentinel::getUser()->gender === "male")
                                    <img alt="Logo" src="{{ asset('images/authors/avatar3.png') }}" />
                                @elseif(Sentinel::getUser()->gender === "female")
                                    <img alt="Logo" src="{{ asset('images/authors/avatar5.png') }}" />
                                @else
                                    <img alt="Logo" src="{{ asset('images/authors/no_avatar.jpg') }}" />
                                @endif
                            </div>
                            <div class="mt-5  text-center">
                                <div class="fw-bolder">
                                    <a href="" class="link-name">
                                        {{ Sentinel::getUser()->name }}
                                    </a>
                                </div>
                            </div>
                            <div class=" mb-5 text-center">
                                <a href="#" class="link-email fw-bold text-muted text-hover-primary fs-7">
                                    {{ Sentinel::getUser()->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fuild">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-table">
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                                <th>Avatar</th>
                                <th>Tên nhân sự</th>
                                <th>Email</th>
                                <th>Đơn vị</th>
                                <th>Hành động</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
            table = $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                lengthMenu: [[5, 10, 20, -1],[5, 10, 20, "All"]],
                ajax: "{!! route('admin.thuongtruc.manacategory.dashboard') !!}",
                columns: [
                    { data: 'avatar', name: 'avatar' , className:'avatar' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'tenDV', name: 'tenDV' },
                    { data: 'actions', name: 'actions' ,className: 'action'},
                ],            
            });
        });
    </script>

<!--//jquery-ui-->

@stop
