<!-- Import dữ liệu thô -->
<div class="menu-item">
    <div class="menu-content pt-8 pb-0">
        <span class="menu-section text-muted text-uppercase  ls-1">
            @lang('menu.10')
        </span>
    </div>
</div>
<!-- Phân quyền Excel -->
<div class="menu-item">
    <a class="menu-link 
    {!! (Request::is('admin/import-excel-2/lap-ke-hoach-excel/index') 
        ? 'active' : '' ) !!}
        " href="{{ $linkMenuTenParent[42] }}" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
        <span class="menu-icon">
            {!! $icon_array[array_rand($icon_array, 1) ] !!}
        </span>
        <span class="menu-title">{{$listmenu_10[10]}}</span>
    </a>
</div>
<!-- Đào tạo -->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion 
{!! (Request::is('admin/import-excel-2/tuyen-sinh/index')
        || Request::is('admin/import-excel-2/du-lieu-sinh-vien/index')
        || Request::is('admin/import-excel-2/chuong-trinh-dao-tao/index')
        || Request::is('admin/import-excel-2/thu-gon-linh-vuc/index')
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
            {!! (Request::is('admin/import-excel-2/tuyen-sinh/index')
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
            {!! (Request::is('admin/import-excel-2/du-lieu-sinh-vien/index')
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
            {!! (Request::is('admin/import-excel-2/chuong-trinh-dao-tao/index')
            ? 'active' : '' ) !!}
                " href="{{ $linkMenuTenParent[11] }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ $listmenu_10_1[3] }}</span>
            </a>
        </div>

        <!-- Thu gọn lĩnh vực -->
        <!-- <div class="menu-item">
            <a class="menu-link 
            {!! (Request::is('admin/import-excel-2/thu-gon-linh-vuc/index')
            ? 'active' : '' ) !!}
                " href="{{ $linkMenuTenParent[19] }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ $listmenu_10_1[4] }}</span>
            </a>
        </div> -->
    </div>
</div>




<!-- Khoa học công nghệ -->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion 
{!! (Request::is('admin/import-excel-2/khcn/index')
        || Request::is('admin/import-excel-2/bien-soan-sach/index')
        || Request::is('admin/import-excel-2/bai-bao-bao-cao/index')
        || Request::is('admin/import-excel-2/sang-che/index')
        || Request::is('admin/import-excel-2/giai-thuong/index')
        || Request::is('admin/import-excel-2/sang-kien-kinh-nghiem/index')
        || Request::is('admin/import-excel-2/hoi-thao-hoi-nghi/index')
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
            {!! (Request::is('admin/import-excel-2/khcn/index')
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
            {!! (Request::is('admin/import-excel-2/bien-soan-sach/index')
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
            {!! (Request::is('admin/import-excel-2/bai-bao-bao-cao/index')
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
            {!! (Request::is('admin/import-excel-2/sang-che/index')
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
            {!! (Request::is('admin/import-excel-2/giai-thuong/index')
            ? 'active' : '' ) !!}
                " href="{{ $linkMenuTenParent[10] }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ $listmenu_10_2[5] }}</span>
            </a>
        </div>

        <!-- Sáng kiến kinh nghiệm -->
        <div class="menu-item">
            <a class="menu-link 
            {!! (Request::is('admin/import-excel-2/sang-kien-kinh-nghiem/index')
            ? 'active' : '' ) !!}
                " href="{{ $linkMenuTenParent[40] }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ $listmenu_10_2[6] }}</span>
            </a>
        </div>
        
        <!-- Hội thảo hội nghị -->
        <div class="menu-item">
            <a class="menu-link 
            {!! (Request::is('admin/import-excel-2/hoi-thao-hoi-nghi/index')
            ? 'active' : '' ) !!}
                " href="{{ $linkMenuTenParent[41] }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">{{ $listmenu_10_2[7] }}</span>
            </a>
        </div>
    </div>
</div>


<!-- Nhân sự -->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion 
{!! (Request::is('admin/import-excel-2/thong-tin-co-ban/index')
        || Request::is('admin/import-excel-2/nhan-su/index')
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
            {!! (Request::is('admin/import-excel-2/thong-tin-co-ban/index')
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
            {!! (Request::is('admin/import-excel-2/nhan-su/index')
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
{!! (Request::is('admin/import-excel-2/doanh-thu-khcn/index')
|| Request::is('admin/import-excel-2/thong-ke-tai-chinh/index') 
|| Request::is('admin/import-excel-2/doanh-thu-khcn2/index')       
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
            {!! (Request::is('admin/import-excel-2/doanh-thu-khcn/index')
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
            {!! (Request::is('admin/import-excel-2/doanh-thu-khcn2/index')
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
            {!! (Request::is('admin/import-excel-2/thong-ke-tai-chinh/index')
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
{!! (Request::is('admin/import-excel-2/tinh-trang-tot-nghiep/index')     
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
            {!! (Request::is('admin/import-excel-2/tinh-trang-tot-nghiep/index')
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
{!! (Request::is('admin/import-excel-2/thong-ke-ky-tuc-xa/index')
|| Request::is('admin/import-excel-2/thong-ke-may-tinh/index')
|| Request::is('admin/import-excel-2/thong-ke-phong-trang-thiet-bi/index')      
|| Request::is('admin/import-excel-2/dien-tich-san-xay-dung/index')  
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
            {!! (Request::is('admin/import-excel-2/thong-ke-ky-tuc-xa/index')
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
            {!! (Request::is('admin/import-excel-2/thong-ke-phong-trang-thiet-bi/index')
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
            {!! (Request::is('admin/import-excel-2/thong-ke-may-tinh/index')
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
            {!! (Request::is('admin/import-excel-2/dien-tich-san-xay-dung/index')
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
{!! (Request::is('admin/import-excel-2/kiem-dinh-chat-luong/index')       
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
            {!! (Request::is('admin/import-excel-2/kiem-dinh-chat-luong/index')
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
{!! (Request::is('admin/import-excel-2/tai-lieu-thu-vien/index')       
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
            {!! (Request::is('admin/import-excel-2/tai-lieu-thu-vien/index')
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
{!! (Request::is('admin/import-excel-2/thong-tin-do-an-khoa-luan/index')
||  Request::is('admin/import-excel-2/cong-khai-hoi-nghi/index')
||  Request::is('admin/import-excel-2/cong-khai-tai-lieu/index') 
||  Request::is('admin/import-excel-2/cong-khai-mon-hoc/index') 
||  Request::is('admin/import-excel-2/cong-khai-quy-mo-dao-tao/index') 
||  Request::is('admin/import-excel-2/cong-khai-cac-phong/index') 
||  Request::is('admin/import-excel-2/cong-khai-sinh-vien-tot-nghiep/index')
||  Request::is('admin/import-excel-2/cong-khai-co-so-giao-duc/index') 
||  Request::is('admin/import-excel-2/cong-khai-sinh-vien-giang-vien/index')
||  Request::is('admin/import-excel-2/dien-tich-dat-sinh-vien/index') 
||  Request::is('admin/import-excel-2/thong-tin-dao-tao/index') 
||  Request::is('admin/import-excel-2/thong-tin-dien-tich-dat/index')
||  Request::is('admin/import-excel-2/cong-khai-tt-ve-hoc-lieu/index')
||  Request::is('admin/import-excel-2/cong-khai-nghien-cuu-khoa-hoc/index')
||  Request::is('admin/import-excel-2/cong-khai-cam-ket-chat-luong/index')
||  Request::is('admin/import-excel-2/tai-chinh-nam-hoc/index')
||  Request::is('admin/import-excel-2/cong-khai-doi-ngu-gv/index')
||  Request::is('admin/import-excel-2/cong-khai-dn-gv-co-huu/index')
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
            {!! (Request::is('admin/import-excel-2/thong-tin-do-an-khoa-luan/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-hoi-nghi/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-tai-lieu/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-mon-hoc/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-quy-mo-dao-tao/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-cac-phong/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-sinh-vien-tot-nghiep/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-co-so-giao-duc/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-sinh-vien-giang-vien/index')
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
            {!! (Request::is('admin/import-excel-2/dien-tich-dat-sinh-vien/index')
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
            {!! (Request::is('admin/import-excel-2/thong-tin-dao-tao/index')
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
            {!! (Request::is('admin/import-excel-2/thong-tin-dien-tich-dat/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-tt-ve-hoc-lieu/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-nghien-cuu-khoa-hoc/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-cam-ket-chat-luong/index')
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
            {!! (Request::is('admin/import-excel-2/tai-chinh-nam-hoc/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-doi-ngu-gv/index')
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
            {!! (Request::is('admin/import-excel-2/cong-khai-dn-gv-co-huu/index')
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