<style>
    .md-skin .wrapper-content {
        padding-right: 0px !important; 
    }
    body.fixed-nav #wrapper .navbar-static-side, body.fixed-nav #wrapper #page-wrapper {
        margin-top: 60px;
        padding-right: 0px !important;
    }

    table{
        border: 1px solid lightgrey !important;
    }
    table tr{
        border: 1px solid lightgrey !important;
    }
    table tr th,td{
        border: 1px solid lightgrey !important;
    }
</style>
<div class="row show_mcg">
    <div class="col-md-8">
        <div class="ibox tieuchuantieuchi">
            <div class="ibox-content ">
                <div class="">
                    @foreach($keHoachTieuChuan as $keHoachTieuChuans)
                        @if($keHoachTieuChuans->tieuchuan_id == $kh)
                       {{-- @continue(!$keHoachTieuChuan->baoCaoTieuChuan) --}}
                        
                        <div class="">
                            @foreach($keHoachTieuChuans->tieuchi as $keHoachTieuChi)
                                @if($keHoachTieuChi->id_tieuchi == $khtc)
                                <strong>
                                    @lang('project/Externalreview/title.tieuchi') {{ $keHoachTieuChuans->tieuchuan->stt }}
                                    .{{ $keHoachTieuChi->stt }}
                                    : {{ $keHoachTieuChi->mo_ta }}
                                </strong>
                                <div class="m-l-md">

                                    <strong>@lang('project/Externalreview/title.1mota') </strong></p>
                                    @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                        @continue(!$keHoachMenhDe->baoCaoMenhDe)
                                        <p>{!! str_replace('&nbsp;',' ',$keHoachMenhDe->baoCaoMenhDe->mota) !!}</p>
                                    @endforeach
                                    <br/>
                                    <strong>@lang('project/Externalreview/title.2diemmanh') </strong></p>
                                    @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                        @continue(!$keHoachMenhDe->baoCaoMenhDe)
                                        <p>{!! strip_tags(str_replace('&nbsp;',' ',$keHoachMenhDe->baoCaoMenhDe->diemmanh)) !!}</p>
                                    @endforeach
                                    <br/>
                                    <strong>@lang('project/Externalreview/title.3diemtontai') </strong></p>
                                    @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                        @continue(!$keHoachMenhDe->baoCaoMenhDe)
                                        <p>{!! strip_tags(str_replace('&nbsp;',' ',$keHoachMenhDe->baoCaoMenhDe->tontai)) !!}</p>
                                    @endforeach
                                    <br/>
                                    <strong>@lang('project/Externalreview/title.4kehoachhd') </strong></p>
                                    <table border="1" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('project/Externalreview/title.stt')</th>
                                            <th>@lang('project/Externalreview/title.muctieu')</th>
                                            <th>@lang('project/Externalreview/title.nd')</th>
                                            <th>@lang('project/Externalreview/title.dvth')</th>
                                            <th>@lang('project/Externalreview/title.dvkt')</th>
                                            <th>@lang('project/Externalreview/title.tgth')</th>
                                            <th>@lang('project/Externalreview/title.gchu')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $stt=0; $stt_dm=0; $stt_tt=0 ;@endphp
                                            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                                                @foreach($keHoachMenhDe->baoCaoMenhDe->keHoachHanhDongList as $keHoachHanhDong)
                                                    @php
                                                        $stt++;
                                                        ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? $stt_dm++ : $stt_tt++;
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $stt }}</td>
                                                        <td>{{ ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? "Phát huy điểm mạnh $stt_dm" :  "Khắc phục tồn tại $stt_tt"}}</td>
                                                        <td>{{ $keHoachHanhDong->noi_dung }}</td>
                                                        <td>{{ isset($keHoachHanhDong->donViThucHien) ? $keHoachHanhDong->donViThucHien->ten_donvi : '' }}</td>
                                                        <td>{{ isset($keHoachHanhDong->donViKiemTra) ? $keHoachHanhDong->donViKiemTra->ten_donvi : '' }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_batdau)->format('d/m/Y') }}
                                                            @lang('project/Externalreview/title.toi') {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_hoanthanh)->format('d/m/Y')}}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        
                                        </tbody>
                                    </table>
                                  <p><strong>@lang('project/Externalreview/title.5tdg') {{($keHoachTieuChi->baoCaoTieuChi['danhgia'] >=4)? "Đạt": "Chưa đạt"}}, {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}/7</strong></p>
                                </div>
                                @endif
                            @endforeach

                        </div>

                        @endif
                    @endforeach
                </div>
                   
            </div>
        </div>
    </div>

    
    @include("admin.project.ExternalReview.include.table_minh_chung")

</div>

