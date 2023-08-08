<div class="m-l-md">
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        <strong>
            @lang('project/Selfassessment/title.tieuchi') {{ $keHoachTieuChuan->tieuChuan->stt }}
            .{{ $keHoachTieuChi->tieuChi->stt }}
            : {{ $keHoachTieuChi->tieuChi->mo_ta }}
        </strong>
        <div class="m-l-md">

            <strong>@lang('project/Selfassessment/title.1mota') </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                @if (isset($keHoachMenhDe->baoCaoMenhDe->mota))
                    @php
                        $modifiedMota = str_replace('id="addminhchunggop_', 'd-id="', $keHoachMenhDe->baoCaoMenhDe->mota);
                        $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $modifiedMota);
                        echo '<p>' . $absoluteImagePath . '</p>';
                    @endphp
                @endif
            @endforeach
            <br/>
            <strong>@lang('project/Selfassessment/title.2diemmanh') </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>
                    @php
                        if (isset($keHoachMenhDe->baoCaoMenhDe->diemmanh)) {
                            $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $keHoachMenhDe->baoCaoMenhDe->diemmanh);
                            echo $absoluteImagePath;
                        }
                    @endphp
                </p>
            @endforeach
            <br/>
            <strong>@lang('project/Selfassessment/title.3diemtontai') </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                @php
                    if (isset($keHoachMenhDe->baoCaoMenhDe->tontai)) {
                        $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $keHoachMenhDe->baoCaoMenhDe->tontai);
                        echo $absoluteImagePath;
                    }
                @endphp
            @endforeach
            <br/>
            <strong>@lang('project/Selfassessment/title.4kehoachhd') </strong>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>@lang('project/Selfassessment/title.stt')</th>
                    <th>@lang('project/Selfassessment/title.nd')</th>
                    <th>@lang('project/Selfassessment/title.dvth')</th>
                    <th>@lang('project/Selfassessment/title.dvkt')</th>
                    <th>@lang('project/Selfassessment/title.tgth')</th>
                    <th>@lang('project/Selfassessment/title.gchu')</th>
                </tr>
                </thead>
                <tbody>
                @php $stt=0 @endphp
                @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                    @continue(!$keHoachMenhDe->baoCaoMenhDe)
                    @foreach($keHoachMenhDe->keHoachHanhDongList as $keHoachHanhDong)
                        @php $stt++ @endphp
                        <tr>
                            <td>{{ $stt }}</td>
                            <td>{{ $keHoachHanhDong->noi_dung }}</td>
                            <td>{{ $keHoachHanhDong->donViThucHien->ten_donvi }}</td>
                            <td>{{ $keHoachHanhDong->donViKiemTra->ten_donvi }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_batdau)->format('d/m/Y') }}
                                @lang('project/Selfassessment/title.toi') {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_hoanthanh)->format('d/m/Y')}}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            <p><strong>@lang('project/Selfassessment/title.5tdg'){{($keHoachTieuChi->baoCaoTieuChi['danhgia'] >=4)? "Đạt": "Chưa đạt"}}, {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}/7</strong></p>
        </div>
    @endforeach

</div>