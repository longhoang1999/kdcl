
<input type="hidden" value="{{($id)?$id:''}}" id="idShowSibar">
    <style>
        #kt_aside{
            background: #ffff;
        }

        #side-menu a{
            color: #888c9f !important;
        }
        .actives {
            background: red;
        }
    </style>
@if($id)
    @php
        $currentIdkh = request()->query('idkh'); // Lấy giá trị của tham số idkh từ URL
        $key2 = request()->query('key');
        $phul = request()->query('tag');
        $pa = request()->query('page');
    @endphp

    @if(isset($keHoachBaoCaokehoachchung->id))
        @if($keHoachBaoCaokehoachchung->id)

            <li >
                <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index') }}">
                    <i class="fas fa-home"></i>  <span class="nav-label ml-2">@lang('project/Externalreview/title.trangchu')</span>
                </a>
            </li>

            <li class="none_css {{ ($pa == 'baocao')?'actives':'' }}">
                <a href="{{
                        route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'idkh'=>$keHoachBaoCaokehoachchung->id,'page'=>'chung']) }}">
                <i class="fas fa-tasks"></i>  <span class="nav-label ml-2">@lang('project/Externalreview/title.p1kq')</span>
                </a>
            </li>
            <li class="arrow_active none_css">
                <a href="#" class="d-flex align-items-center css_arrow" onclick="show_tudanhgia()"> {{-- route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'idkh'=>$keHoachBaoCaokehoachchung->id,'page'=>'chung']) --}}
                    <i class="fas fa-file-signature"></i>  <span class="nav-label ml-2">@lang('project/Externalreview/title.p2tdg') </span>
                <span class="fa arrow arrow-right"></span>
                </a>
                @if($keHoachTieuChuan->count() >0)
                <ul class="nav-second-level" id="tudanhgia_bctdg" style="display: none;">
                @php $i=0 @endphp
                @foreach($keHoachTieuChuan as $keHoachTieuChuans)
                        @php $i++ @endphp
                        @if(!$keHoachTieuChuans->truongnhom)
                            @continue
                        @endif
                        <li class="arrow_tc_{{$i}}">
                            <a data-toggle="tooltip" data-placement="right"
                               data-original-title="{{-- explode(':',$keHoachTieuChuan->tieuChuan->moTaWithStt)[1] --}}"
                               title="" href="<?php
                                                    if(!empty($keHoachTieuChuans->tieuchuan->id)){
                                                       echo( route('admin.danhgiangoai.baocaotudanhgia.index',['idkh'=>$keHoachTieuChuans->tieuchuan->id,'id'=>$id,'page'=>'tieuchuan']));
                                                    }
                                                ?>" class="d-flex align-items-center
                                                {{ ($currentIdkh == $keHoachTieuChuans->tieuchuan->id) ? 'actives' : '' }}
                                    " onclick="show_tieuchuan_chidl({{$i}})">
                                <p class="title_tieuChuan m-0">
                                    <i class="fas fa-file-signature"></i> @lang('project/Externalreview/title.tieuchuan') {{$i}}
                                </p>
                                <span class="label onLink" href="{{-- route('admin.danhgiangoai.baocaotudanhgia.index',['idkh'=>$keHoachTieuChuans->tieuchuan->id, 'id'=>$id,'page'=>'tieuchuan']) --}}" style="color: black !important; margin: 0 13px; background: wheat;">...</span>
                                <span class="fa arrow"></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </li>

        @endif
    @endif

    @if(isset($keHoachBaoCaokehoachchung->id))

        @if($keHoachBaoCaokehoachchung->id)
            <li class=" arrow_ketluan none_css" onclick="show_ketluan()">
                <a href="#" class="d-flex align-items-center css_arrow" >
                    <i class="fas fa-chart-line"></i>  <span class="nav-label ml-2">@lang('project/Externalreview/title.p3kl')</span>
                    <span class="fa arrow arrow-right"></span>
                </a>
                <ul class="nav-second-level nav-level_child" id="show_ketluan" style="display: none;">
                    <li class="{{ ($key2 == 'ketluanchung')?'actives':'' }} " >
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'ketluanchung','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Kết luận chung">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.klc')</span>
                        </a>
                    </li>
                    <li class="{{ ($key2 == 'diem_manh')?'actives':'' }}">
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'diem_manh','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Tóm tắt những điểm mạnh của CTĐT">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.thdm')</span>
                        </a>
                    </li>
                    <li class="{{ ($key2 == 'tontai')?'actives':'' }}">
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'tontai','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Tóm tắt những điểm còn tồn tại của CTĐT">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.thtt')</span>
                        </a>
                    </li>
                    <li class="{{ ($key2 == 'kehoach')?'actives':'' }}">
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'kehoach','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Kế hoạch khắc phục, nâng cấp chất lượng của CTĐT">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.khhd')</span>
                        </a>
                    </li>
                    @if($keHoachBaoCaokehoachchung->loai_tieuchuan != 'csgd')
                    <li class="{{ ($key2 == 'TĐG1')?'actives':'' }}">
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'TĐG1','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="(Phụ lục 7a) Bảng tổng hợp kết quả tự đánh giá CTĐT đánh giá theo Thông tư 04/2016">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.kqtdg1') </span>
                        </a>
                    </li>
                    <li class="{{ ($key2 == 'TĐG2')?'actives':'' }}">
                        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'TĐG2','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="(Phụ lục 7b) Bảng tổng hợp kết quả tự đánh giá chương trình đào tạo đánh giá chất lượng theo Quyết định 72/2007, Thôngtư 23/2011, Thông tư 49/2012, Thông tư 33/2014">
                            <i class="fas fa-edit"></i>
                            <span class="nav-label" >@lang('project/Externalreview/title.kqtdg2') </span>
                        </a>
                    </li>
                    @else
                        <li class="{{ ($key2 == 'CSGD')?'actives':'' }}">
                            <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'key'=>'CSGD','page'=>'ketluan']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="BẢNG TỔNG HỢP KẾT QUẢ TỰ ĐÁNH GIÁ CSGD">
                                <i class="fas fa-edit"></i>
                                <span class="nav-label" >@lang('project/Externalreview/title.kqtdgcsdt')</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

        @endif
    @endif

    <li class="{{ ($page=='phuluc')?'active':'' }} arrow_phuluc none_css" onclick="show_phuluc()">
            <a href="#" class="d-flex align-items-center css_arrow">
            <i class="fas fa-tasks"></i>  <span class="nav-label ml-2">@lang('project/Externalreview/title.p4pl')</span>
            <span class="fa arrow arrow-right"></span>
            </a>
            <ul class="nav-second-level nav-level_child" id="show_phuluc" style="display: none;">
                <li class="{{ ($tag == 'pl1')?'active':'' }}" >
                    <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'tag'=>'pl1','page'=>'phuluc']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Cơ sở dữ liệu kiểm định chất lượng CTĐT">
                        <i class="fas fa-edit"></i>
                        <span class="nav-label" >@lang('project/Externalreview/title.csdl')</span>
                    </a>
                </li>
                {{--<li  class="{{ ($tag == 'pl2')?'active':'' }}">
                    <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'tag'=>'pl2','page'=>'phuluc']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Quy định thể thức và cấu trúc văn bản của báo cáo tự đánh giá">
                        <i class="fas fa-edit"></i>
                        <span class="nav-label" >Phụ lục 2</span>
                    </a>
                </li>
                <li class="{{ ($tag == 'pl3')?'active':'' }}">
                    <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'tag'=>'pl3','page'=>'phuluc']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Hướng dẫn mã hóa thông tin, minh chứng">
                        <i class="fas fa-edit"></i>
                        <span class="nav-label" >Phụ lục 3</span>
                    </a>
                </li>--}}
                <li class="{{ ($phul == 'pl4')?'actives':'' }}">
                    <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$id,'tag'=>'pl4','page'=>'phuluc']) }}"  data-toggle="tooltip" data-placement="right" data-original-title="Danh mục minh chứng">
                        <i class="fas fa-clipboard-list"></i>
                        <span class="nav-label" >@lang('project/Externalreview/title.dmmchung')</span>
                    </a>
                </li>
            </ul>
    </li>

    <li class="{{ ($page=='thuvienminhchung')?'active':'' }} none_css">
        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.thuvienminhchung',['id'=>$id]) }}">
            <i class="fas fa-table"></i>
            <span class="nav-label">@lang('project/Externalreview/title.thuvmc')</span>
        </a>
    </li>

    <li class="{{ ($page=='baocaokhac')?'active':'' }} none_css">
        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.baoCaoKhac',['id'=>$id]) }}">
            <i class="fas fa-file-signature"></i>
            <span class="nav-label">@lang('project/Externalreview/title.solieuth')</span>
        </a>
    </li>

   {{-- <li class="{{ ($page=='dugiotructuyen')?'active':'' }}">
        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.dugiotructuyen',['id'=>$id]) }}">
            <i class="fas fa-clock"></i>
            <span class="nav-label">@lang('project/Externalreview/title.dugiott')</span>
        </a>
    </li>

    <li class="{{ ($page=='phongvantructuyen')?'active':'' }}">
        <a href="{{ route('admin.danhgiangoai.baocaotudanhgia.phongvantructuyen',['id'=>$id]) }}">
            <i class="fas fa-chalkboard-teacher"></i>
            <span class="nav-label">@lang('project/Externalreview/title.pvtt')</span>
        </a>
    </li>
    --}}

@endif



