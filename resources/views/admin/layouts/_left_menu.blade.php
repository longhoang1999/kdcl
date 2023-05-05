    <?php
    $listmenu_2 = Lang::get('menu.2_list');
    $listmenu_3 = Lang::get('menu.3_list');
    $listmenu_4 = Lang::get('menu.4_list');
    $listmenu_5 = Lang::get('menu.5_list');
    $listmenu_6 = Lang::get('menu.6_list');
    $listmenu_7 = Lang::get('menu.7_list');
    $listmenu_8 = Lang::get('menu.8_list');
    $listmenu_9 = Lang::get('menu.9_list');
    $listmenu_10 = Lang::get('menu.10_list');
    $listmenu_2_1 = Lang::get('menu.2_1_list');
    $listmenu_2_2 = Lang::get('menu.2_2_list');
    $listmenu_2_3 = Lang::get('menu.2_3_list');

    $listmenu_10_1 = Lang::get('menu.10_1_list');
    $listmenu_10_2 = Lang::get('menu.10_2_list');
    $listmenu_10_3 = Lang::get('menu.10_3_list');
    $listmenu_10_4 = Lang::get('menu.10_4_list');
    $listmenu_10_5 = Lang::get('menu.10_5_list');
    $listmenu_10_6 = Lang::get('menu.10_6_list');
    $listmenu_10_7 = Lang::get('menu.10_7_list');
    $listmenu_10_8 = Lang::get('menu.10_8_list');
    $listmenu_10_9 = Lang::get('menu.10_9_list');
    // link
    $linkMenuTwoParent = Lang::get('menu.2_list_parent');
    $linkMenuTwoChild = Lang::get('menu.2_list_child');

    $linkMenuThreeParent = Lang::get('menu.3_list_parent');
    $linkMenuFourParent = Lang::get('menu.4_list_parent');
    $linkMenuSevenParent = Lang::get('menu.7_list_parent');
    $linkMenuEightParent = Lang::get('menu.8_list_parent');

    $listmenu_7_1 = Lang::get('menu.7_1_list');
    $linkMenuSevenChild = Lang::get('menu.7_list_child');
    $linkMenuTenParent = Lang::get('menu.10_list_child');


    $icon_array = [
        '<i class="bi bi-grid fs-3"></i>',
        '<i class="bi bi-window fs-3"></i>',
        '<i class="bi bi-app-indicator fs-3"></i>',
        '<i class="bi bi-app-indicator fs-3"></i>',
        '<i class="bi bi-person fs-2"></i>',
        '<i class="bi bi-sticky fs-3"></i>',
        '<i class="bi bi-shield-check fs-3"></i>',
        '<i class="bi bi-layers fs-3"></i>',
        '<i class="bi bi-printer fs-3"></i>',
        '<i class="bi bi-cart fs-3"></i>',
        '<i class="bi bi-hr fs-3"></i>',
        '<i class="bi bi-people fs-3"></i>',
        '<i class="bi bi-calendar3-event fs-3"></i>',
        '<i class="bi-chat-left fs-3"></i>',
        '<i class="bi bi-layout-sidebar fs-3"></i>',
        '<i class="bi bi-layers fs-3"></i>',
        '<i class="bi bi-layers fs-3"></i>',
    ];
    
?>

<div class="aside-menu flex-column-fluid" style="background-color: #ffff">
                        <!--begin::Aside Menu-->
                        <div class="hover-scroll-overlay-y my-2 py-5 py-lg-8" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

                                <!-- Dashboard -->
                                <div class="menu-item">
                                    <div class="menu-content pb-2">
                                        <span class="menu-section text-muted text-uppercase ls-1">Dashboard</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link 
                                        {!! (Request::is('admin') ? 'active' : '' ) !!}
                                    "href="{{ route('admin.dashboard') }}">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">Home</span>
                                    </a>
                                </div>
                                <!-- / Dashboard -->
                                @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                                <!-- Thường trực -->
                                <div class="menu-item ">
                                    <div class="menu-content pt-8 pb-2">
                                        <span class="menu-section text-muted text-uppercase ls-1">
                                            @lang('menu.2')
                                        </span>
                                    </div>
                                </div>
                                <!-- show trong menu-item,  active trong menu-link-->
                                <!-- QL bộ tiêu chuẩn -->
                                <div data-kt-menu-trigger="click" class="menu-item  menu-accordion 
                                    {!! (Request::is('admin/thuong-truc/setstandard') 
                                    || Request::is('admin/thuong-truc/setstandard/*')
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link ">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{ $listmenu_2[1] }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/setstandard/index') 
                                            || Request::is('admin/thuong-truc/setstandard/index/*') 
                                            || Request::is('admin/thuong-truc/setstandard/config-standard/*') 
                                            || Request::is('admin/thuong-truc/setstandard/create-single-standard/*')
                                            || Request::is('admin/thuong-truc/setstandard/config-criteria/*')
                                            || Request::is('admin/thuong-truc/setstandard/criteria')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[1] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_1[1] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/setstandard/show-suggestions') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[2] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_1[2] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/setstandard/show-minimum') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[3] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_1[3] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /QL bộ tiêu chuẩn -->
                                <!-- Quản lý danh mục -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                    {!! (Request::is('admin/thuong-truc/manacategory/manafield') 
                                        || Request::is('admin/thuong-truc/manacategory/create-manafield')
                                        || Request::is('admin/thuong-truc/manacategory/manaunit')
                                        || Request::is('admin/thuong-truc/manacategory/manactdt')
                                        || Request::is('admin/thuong-truc/manacategory/manacsdt')
                                        || Request::is('admin/thuong-truc/manacategory/manahuman')
                                        || Request::is('admin/thuong-truc/manacategory/linkreport')
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{ $listmenu_2[2] }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/manafield') 
                                                || Request::is('admin/thuong-truc/manacategory/create-manafield')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[4] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[1] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/manaunit') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[5] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[2] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/manactdt') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[6] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[3] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/manacsdt') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[7] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[4] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/manahuman') 
                                            ? 'active' : '' ) !!}

                                             " href="{{ $linkMenuTwoChild[8] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[5] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/linkreport') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[9] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_2[6] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Quản lý danh mục -->
                                <!-- Đối sánh -->
                                {{-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{ $listmenu_2[3] }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/stracriteria') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[10] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_3[1] }}</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/thuong-truc/manacategory/strasubject') 
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTwoChild[11] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_2_3[2] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- /Đối sánh -->
                                <!-- /Thường trực -->
                                 @endif
                                

                                
                                <!-- @foreach($listmenu_2 as $key => $menu)
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$menu}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        @if($key  == '1')
                                            @foreach($listmenu_2_1 as $key_child => $menu_child)
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ $linkMenuTwoChild[$key_child] }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $menu_child }}</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @elseif($key  == '2')
                                            @foreach($listmenu_2_2 as $key_child => $menu_child)
                                                @php
                                                    $key_child = $key_child + count($listmenu_2_1);
                                                @endphp
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ $linkMenuTwoChild[$key_child] }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $menu_child }}</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @elseif($key  == '3')
                                            @foreach($listmenu_2_3 as $key_child => $menu_child)
                                                @php
                                                    $key_child = $key_child + count($listmenu_2_1) + count($listmenu_2_2);
                                                @endphp
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ $linkMenuTwoChild[$key_child] }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $menu_child }}</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                @endforeach -->
								
                              	@if(5 == 6)
                                <!-- Trao đổi thông tin -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-2">
                                        <span class="menu-section text-muted text-uppercase ls-1">
                                            @lang('menu.3')
                                        </span>
                                    </div>
                                </div>
                                <!-- Bản tin -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                        {!! (Request::is('admin/trao-doi-thong-tin/messageboard/index') 
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuThreeParent[1] }}">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_3[1]}}</span>
                                    </a>
                                </div>
                                <!-- Chat -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/trao-doi-thong-tin/chat/index') 
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuThreeParent[2] }}">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_3[2]}}</span>
                                    </a>
                                </div>
                                <!-- /Trao đổi thông tin -->
                                @endif


                                <!-- Đảm bảo chất lượng -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase ls-1">
                                            @lang('menu.4')
                                        </span>
                                    </div>
                                </div>
                                <!-- Lập kế hoạch -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/dam-bao-chat-luong/planning/index') 
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuFourParent[1] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_4[1]}}</span>
                                    </a>
                                </div>
                                <!-- Cập nhật hoạt động -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                     {!! (Request::is('admin/dam-bao-chat-luong/updateaci/index') 
                                        || Request::is('admin/dam-bao-chat-luong/updateaci/mana-action') 
                                        || Request::is('admin/dam-bao-chat-luong/updateaci/mana-action/*')
                                        || Request::is('admin/dam-bao-chat-luong/updateaci/get-update-mcyc')
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuFourParent[2] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_4[2]}}</span>
                                    </a>
                                </div>
                                <!-- Cập nhật minh chứng -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/dam-bao-chat-luong/manaproof/index') 
                                        || Request::is('admin/dam-bao-chat-luong/manaproof/edit-proof') 
                                        || Request::is('admin/dam-bao-chat-luong/manaproof/edit-proof/*')
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuFourParent[3] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_4[3]}}</span>
                                    </a>
                                </div>
                                <!-- KTMC theo hoạt động -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/dam-bao-chat-luong/kiem-tra-mc-hoat-dong/index')
                                        || Request::is('admin/dam-bao-chat-luong/kiem-tra-mc-hoat-dong/chi-tiet') 
                                        || Request::is('admin/dam-bao-chat-luong/kiem-tra-mc-hoat-dong/chi-tiet/*')
                                        || Request::is('admin/dam-bao-chat-luong/kiem-tra-mc-hoat-dong/chinh-sua/*')
                                        || Request::is('admin/dam-bao-chat-luong/kiem-tra-mc-hoat-dong/chinh-sua')
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuFourParent[4] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_4[4]}}</span>
                                    </a>
                                </div>
                                <!-- KH hoạt động -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                        {!! (Request::is('admin/dam-bao-chat-luong/ke-hoach-hanh-dong/index')
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuFourParent[5] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_4[5]}}</span>
                                    </a>
                                </div>
                            <!-- /Đảm bảo chất lượng -->
                                


                            {{-- <!-- So chuẩn -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase ls-1">
                                            @lang('menu.5')
                                        </span>
                                    </div>
                                </div>
                                <!-- Lập kế hoạch -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_5[1]}}</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_5[2]}}</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_5[3]}}</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_5[4]}}</span>
                                    </a>
                                </div>
                            <!-- /So chuẩn --> --}}


                            {{-- <!-- Đối sánh -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase  ls-1">
                                            @lang('menu.6')
                                        </span>
                                    </div>
                                </div>
                                <!-- Lập kế hoạch -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_6[1]}}</span>
                                    </a>
                                </div>
                                <!-- THực hiện đối sánh -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_6[2]}}</span>
                                    </a>
                                </div>
                                <!-- Tổng hợp kết quả -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_6[3]}}</span>
                                    </a>
                                </div>
                                <!-- Yêu cầu cải tiến -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_6[4]}}</span>
                                    </a>
                                </div>
                            <!-- /Đối sánh --> --}}

                                
                            <!-- Tự đánh giá -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase ls-1">
                                            @lang('menu.7')
                                        </span>
                                    </div>
                                </div>
                                <!-- Lập kế hoạch -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/tu-danh-gia/report/index')
                                        || Request::is('admin/tu-danh-gia/report/lap-ke-hoach/*')
                                        || Request::is('admin/tu-danh-gia/report/lap-ke-hoach')
                                        ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuSevenParent[1] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_7[1]}}</span>
                                    </a>
                                </div>

                                <!-- Chuẩn bị đánh giá -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/tu-danh-gia/preparereport/doi-chieu-mc')
                                        || Request::is('admin/tu-danh-gia/preparereport/proof-handling')
                                        || Request::is('admin/tu-danh-gia/preparereport/edit-mc-gop/*')
                                        || Request::is('admin/tu-danh-gia/preparereport/xu-ly-mc')
                                    ? 'show' : '' ) !!}

                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_7[2]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Xử lý minh chứng -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/tu-danh-gia/preparereport/xu-ly-mc')
                                                || Request::is('admin/tu-danh-gia/preparereport/proof-handling')
                                                || Request::is('admin/tu-danh-gia/preparereport/edit-mc-gop/*')
                                                ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuSevenChild[1] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_7_1[1] }}</span>
                                            </a>
                                        </div>
                                        <!-- Đối chiếu minh chứng -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/tu-danh-gia/preparereport/doi-chieu-mc')
                                                ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuSevenChild[2] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_7_1[2] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Báo cáo tự đánh giá -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/tu-danh-gia/detailedplanning/index')
                                    || Request::is('admin/tu-danh-gia/detailedplanning/show')
                                    ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuSevenParent[3] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_7[3]}}</span>
                                    </a>
                                </div>
                                <!-- Nhận xét báo cáo -->
                                @if( !Sentinel::inRole('ns_thuchien'))
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/tu-danh-gia/commentreport/index')
                                    || Request::is('admin/tu-danh-gia/commentreport/viewreport')
                                    ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuSevenParent[4] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_7[4]}}</span>
                                    </a>
                                </div>
                                @endif
                                <!-- Hoàn thiện báo cáo -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/tu-danh-gia/completionreport/index')
                                    ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuSevenParent[5] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_7[5]}}</span>
                                    </a>
                                </div>
                            <!-- /Tự đánh giá -->
                                


                            <!-- Đánh giá ngoài -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase  ls-1">
                                            @lang('menu.8')
                                        </span>
                                    </div>
                                </div>
                                <!-- Lập kế hoạch đánh giá ngoài -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/danh-gia-ngoai/lap-ke-hoach-dgn')
                                    ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuEightParent[1] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_8[1]}}</span>
                                    </a>
                                </div>
                                <!-- Báo cáo đánh giá ngoài -->
                                <div class="menu-item">
                                    <a class="menu-link 
                                    {!! (Request::is('admin/danh-gia-ngoai/bao-cao-tdg/bao-cao')
                                        || Request::is('admin/danh-gia-ngoai/bao-cao-tdg/bao-cao/*')
                                    ? 'active' : '' ) !!}
                                     " href="{{ $linkMenuEightParent[2] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_8[2]}}</span>
                                    </a>
                                </div>
                            <!-- /Đánh giá ngoài -->

                                
                            {{-- <!-- Tổng hợp -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase  ls-1">
                                            @lang('menu.9')
                                        </span>
                                    </div>
                                </div>
                                <!-- Đảm bảo chất lượng -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_9[1]}}</span>
                                    </a>
                                </div>
                                <!-- Báo cáo tiến độ -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_9[2]}}</span>
                                    </a>
                                </div>
                                <!-- DS báo cáo TĐG -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_9[3]}}</span>
                                    </a>
                                </div>
                                <!-- Báo cáo nhận xét -->
                                <div class="menu-item">
                                    <a class="menu-link" href="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_9[4]}}</span>
                                    </a>
                                </div>
                            <!-- /Tổng hợp --> --}}


                            <!-- Import dữ liệu thô -->
                                <div class="menu-item">
                                    <div class="menu-content pt-8 pb-0">
                                        <span class="menu-section text-muted text-uppercase  ls-1">
                                            @lang('menu.10')
                                        </span>
                                    </div>
                                </div>
                                <!-- Đào tạo -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/tuyen-sinh/index')
                                        || Request::is('admin/import-du-lieu-excel/du-lieu-sinh-vien/index')
                                        || Request::is('admin/import-du-lieu-excel/chuong-trinh-dao-tao/index')
                                        || Request::is('admin/import-du-lieu-excel/thu-gon-linh-vuc/index')
                                    ? 'show' : '' ) !!}

                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[1]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Tuyển sinh -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/tuyen-sinh/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[3] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_1[1]}}</span>
                                            </a>
                                        </div>

                                        <!-- Dữ liệu sinh viên -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/du-lieu-sinh-vien/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[4] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_1[2]}}</span>
                                            </a>
                                        </div>

                                        <!-- Chương trìn đào tạo -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/chuong-trinh-dao-tao/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[11] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_10_1[3] }}</span>
                                            </a>
                                        </div>

                                        <!-- Thu gọn lĩnh vực -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thu-gon-linh-vuc/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[19] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_10_1[4] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>




                                <!-- Khoa học công nghệ -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/khcn/index')
                                        || Request::is('admin/import-du-lieu-excel/bien-soan-sach/index')
                                        || Request::is('admin/import-du-lieu-excel/bai-bao-bao-cao/index')
                                        || Request::is('admin/import-du-lieu-excel/sang-che/index')
                                        || Request::is('admin/import-du-lieu-excel/giai-thuong/index')
                                    ? 'show' : '' ) !!}

                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[2]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Khoa học công nghệ -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/khcn/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[5] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_2[1]}}</span>
                                            </a>
                                        </div>

                                        <!-- Biên soạn sách -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                           {!! (Request::is('admin/import-du-lieu-excel/bien-soan-sach/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[7] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_2[2]}}</span>
                                            </a>
                                        </div>


                                        <!-- Bài báo -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/bai-bao-bao-cao/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[8] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_10_2[3] }}</span>
                                            </a>
                                        </div>

                                        <!-- Phát minh sáng chế -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/sang-che/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[9] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_10_2[4] }}</span>
                                            </a>
                                        </div>
            

                                        <!-- Giải thưởng -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/giai-thuong/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[10] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $listmenu_10_2[5] }}</span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                

                                <!-- Nhân sự -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/thong-tin-co-ban/index')
                                        || Request::is('admin/import-du-lieu-excel/nhan-su/index')
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[3]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Thông tin cơ bản -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-tin-co-ban/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[1] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_3[1]}}</span>
                                            </a>
                                        </div>

                                        <!-- Nhân sự -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                           {!! (Request::is('admin/import-du-lieu-excel/nhan-su/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[2] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_3[2]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chỉnh lại link  -->
                                <!-- Tài chính -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/doanh-thu-khcn/index')
                                || Request::is('admin/import-du-lieu-excel/thong-ke-tai-chinh/index') 
                                || Request::is('admin/import-du-lieu-excel/doanh-thu-khcn2/index')       
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[4]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Doanh thu KHCN -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/doanh-thu-khcn/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[6] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_4[1]}}</span>
                                            </a>
                                        </div>
                                        
                                        <!-- Doanh thu KHCN2 -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/doanh-thu-khcn2/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[15] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_4[3]}}</span>
                                            </a>
                                        </div>
                                        <!-- Thống kê tài chính -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-ke-tai-chinh/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[12] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_4[2]}}</span>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>



                                <!-- Chỉnh lại link  -->
                                <!-- Khảo sát sinh viên -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/tinh-trang-tot-nghiep/index')     
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[5]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Khảo sát tình trạng tốt nghiệp sinh viên -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/tinh-trang-tot-nghiep/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[21] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_5[1]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chỉnh lại link  -->
                                <!-- Cơ sở vật chất -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/thong-ke-ky-tuc-xa/index')
                                || Request::is('admin/import-du-lieu-excel/thong-ke-may-tinh/index')
                                || Request::is('admin/import-du-lieu-excel/thong-ke-phong-trang-thiet-bi/index')      
                                || Request::is('admin/import-du-lieu-excel/dien-tich-san-xay-dung/index')  
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[6]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Diện tích Ký túc xá -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-ke-ky-tuc-xa/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[13] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_6[1]}}</span>
                                            </a>
                                        </div>
                                        <!-- Thống kê phòng học,trang thiết bị -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-ke-phong-trang-thiet-bi/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[18] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_6[2]}}</span>
                                            </a>
                                        </div>
                                        <!-- Thống kê máy tính -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-ke-may-tinh/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[14] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_6[3]}}</span>
                                            </a>
                                        </div>
                                        <!-- Diện tích sàn xây dựng -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/dien-tich-san-xay-dung/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[20] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_6[4]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chỉnh lại link  -->
                                <!-- Kiểm định -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/kiem-dinh-chat-luong/index')       
                                    ? 'show' : '' ) !!}
                                 ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[7]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Kiểm định -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/kiem-dinh-chat-luong/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[16] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_7[1]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <!-- Chỉnh lại link  -->
                                <!-- Tài liệu thư viện -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/tai-lieu-thu-vien/index')       
                                    ? 'show' : '' ) !!}
                                ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[8]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!-- Tài liệu thư viện -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/tai-lieu-thu-vien/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[17] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{$listmenu_10_8[1]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chỉnh lại link  -->
                                <!-- Tài liệu ba công khai -->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion 
                                {!! (Request::is('admin/import-du-lieu-excel/thong-tin-do-an-khoa-luan/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-hoi-nghi/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-tai-lieu/index') 
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-mon-hoc/index') 
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-quy-mo-dao-tao/index') 
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-cac-phong/index') 
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-sinh-vien-tot-nghiep/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-co-so-giao-duc/index') 
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-sinh-vien-giang-vien/index')
                                ||  Request::is('admin/import-du-lieu-excel/dien-tich-dat-sinh-vien/index') 
                                ||  Request::is('admin/import-du-lieu-excel/thong-tin-dao-tao/index') 
                                ||  Request::is('admin/import-du-lieu-excel/thong-tin-dien-tich-dat/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-tt-ve-hoc-lieu/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-nghien-cuu-khoa-hoc/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-cam-ket-chat-luong/index')
                                ||  Request::is('admin/import-du-lieu-excel/tai-chinh-nam-hoc/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-doi-ngu-gv/index')
                                ||  Request::is('admin/import-du-lieu-excel/cong-khai-dn-gv-co-huu/index')
                                    ? 'show' : '' ) !!}
                                ">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            {!! $icon_array[array_rand($icon_array, 1) ] !!}
                                        </span>
                                        <span class="menu-title">{{$listmenu_10[9]}}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                                        <!--  Thông tin đồ án, khóa luận, luận văn, luận án tốt nghiệp -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-tin-do-an-khoa-luan/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[22] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ttdakl')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[1]}}</span>
                                            </a>
                                        </div>
                                        <!--  Công khai hội nghị, hội thảo khoa học do csgd tổ chức -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-hoi-nghi/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[23] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.hnhtkh')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[2]}}</span>
                                            </a>
                                        </div>
                                        <!--  Công khai giáo trình, tài liệu tham khảo do cơ sở giáo dục tổ chức biên soạn -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-tai-lieu/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[24] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.gttltk')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[3]}}</span>
                                            </a>
                                        </div>
                                        <!--  Công khai môn học của từng khóa học, chuyên ngành -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-mon-hoc/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[25] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckmh')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[4]}}</span>
                                            </a>
                                        </div>
                                        <!--   Công khai thông tin về quy mô đào tạo hiện tại   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-quy-mo-dao-tao/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[26] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckqmdt')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[5]}}</span>
                                            </a>
                                        </div>
                                        <!--   Công khai thông tin về các phòng thí nghiệm, phòng thực hành, xưởng thực tập, nhà tập đa năng, hội trường, phòng học, thư viện, trung tâm học liệu   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-cac-phong/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[27] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckcp')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[6]}}</span>
                                            </a>
                                        </div>
                                        <!--   Công khai thông tin về sinh viên tốt nghiệp và tỷ lệ sinh viên có việc làm    -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-sinh-vien-tot-nghiep/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[28] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.cksvtn')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[7]}}</span>
                                            </a>
                                        </div>
                                        <!--   Công khai thông tin kiểm định cơ sở giáo dục và chương trình giáo dục   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-co-so-giao-duc/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[29] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckcsgd')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[8]}}</span>
                                            </a>
                                        </div>
                                        <!--   Công khai tỷ lệ sinh viên/giảng viên quy đổi   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-sinh-vien-giang-vien/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[30] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.cksvgv')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[9]}}</span>
                                            </a>
                                        </div>
                                        <!--   Diện tích đất/sinh viên; diện tích sàn/sinh viên   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/dien-tich-dat-sinh-vien/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[31] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckdtdsv')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[10]}}</span>
                                            </a>
                                        </div>
                                        <!-- Công khai thông tin đào tạo theo đơn đặt hàng của nhà nước, địa phương và doanh nghiệp -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-tin-dao-tao/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[32] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckttdt')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[11]}}</span>
                                            </a>
                                        </div>
                                        <!--  Công khai thông tin về diện tích đất, tổng diện tích sàn xây dựng -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/thong-tin-dien-tich-dat/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[33] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckttdtd')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[12]}}</span>
                                            </a>
                                        </div>
                                        <!--   Import Công khai thông tin về học liệu (sách, tạp chí, e-book, cơ sở dữ liệu điện tử) của thư viện và trung tâm học liệu    -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-tt-ve-hoc-lieu/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[34] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckttvhl')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[13]}}</span>
                                            </a>
                                        </div>
                                        <!--   Import Công khai thông tin về các hoạt động nghiên cứu khoa học, chuyển giao công nghệ, sản xuất thử và tư vấn    -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-nghien-cuu-khoa-hoc/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[35] }}" >
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[14]}}</span>
                                            </a>
                                        </div>
                                        <!--   Import Công khai Công khai cam kết chất lượng đào tạo của Trường Đại học Công nghiệp Dệt May Hà Nội năm học   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-cam-ket-chat-luong/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[36] }}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.ckcldt')">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[15]}}</span>
                                            </a>
                                        </div>
                                        <!--   Import công khai tài chính năm học   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/tai-chinh-nam-hoc/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[37] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[16]}}</span>
                                            </a>
                                        </div>
                                        <!--   Import công khai danh sách đội ngũ giảng viên theo khối ngành   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-doi-ngu-gv/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[38] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[17]}}</span>
                                            </a>
                                        </div>

                                        <!--   Import công khai đội ngũ giảng viên cơ hữu   -->
                                        <div class="menu-item">
                                            <a class="menu-link 
                                            {!! (Request::is('admin/import-du-lieu-excel/cong-khai-dn-gv-co-huu/index')
                                            ? 'active' : '' ) !!}
                                             " href="{{ $linkMenuTenParent[39] }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title" >{{$listmenu_10_9[18]}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            <!-- /Import dữ liệu thô -->

                                <div class="menu-item">
                                    <div class="menu-content">
                                        <div class="separator mx-1 my-4"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>