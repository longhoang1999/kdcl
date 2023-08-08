<div class="m-l-md">
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        <strong>
            @lang('project/Externalreview/title.tieuchi') {{ $keHoachTieuChuan->tieuChuan->stt }}
            .{{ $keHoachTieuChi->tieuChi->stt }}
            : {{ $keHoachTieuChi->tieuChi->mo_ta }}
        </strong>
        <div class="m-l-md">
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                <p>
                    @php
                        if (isset($keHoachMenhDe->baoCaoMenhDe->mota)) {
                            $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $keHoachMenhDe->baoCaoMenhDe->mota);
                            echo $absoluteImagePath;
                        }
                    @endphp
                </p>
            @endforeach
            <br/>

            <p><strong> @lang('project/Externalreview/title.tudanhdm') {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}/7</strong></p>
        </div>
    @endforeach

    <strong>@lang('project/Externalreview/title.dgcvtc') {{ $keHoachTieuChuan->tieuChuan->stt }}:</strong>
    <br/>
    <strong>@lang('project/Externalreview/title.tomtatdm')</strong>
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
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
    @endforeach
    <br/>
    <strong>@lang('project/Externalreview/title.tomtatdtt')</strong>
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
            @continue(!$keHoachMenhDe->baoCaoMenhDe)
            <p>
                @php
                    if (isset($keHoachMenhDe->baoCaoMenhDe->tontai)) {
                        $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $keHoachMenhDe->baoCaoMenhDe->tontai);
                        echo $absoluteImagePath;
                    }
                @endphp
            </p>
        @endforeach
    @endforeach
    <br/>
    <strong>@lang('project/Externalreview/title.khctien')</strong>
        <table class="table table-bordered">
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
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                        @foreach($keHoachMenhDe->baoCaoMenhDe->keHoachHanhDongList as $keHoachHanhDong)
                            @php
                                $stt++;
                                ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? $stt_dm++ : $stt_tt++;
                            @endphp
                            <tr>
                                <td>{{ $stt}}</td>
                                <td>{{ ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? "Phát huy điểm mạnh $stt_dm" :  "Khắc phục tồn tại $stt_tt"}}</td>
                                <td>{{ $keHoachHanhDong->noi_dung }}</td>
                                <td>{{ $keHoachHanhDong->donViThucHien->ten_donvi }}</td>
                                <td>{{ $keHoachHanhDong->donViKiemTra->ten_donvi }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_batdau)->format('d/m/Y') }}
                                    -> {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_hoanthanh)->format('d/m/Y')}}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                @endforeach
                
            @endforeach
            </tbody>
        </table>
        <br/>
        <strong>@lang('project/Externalreview/title.mucdg')</strong>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>@lang('project/Externalreview/title.tieuchuantc')</th>
                <th>@lang('project/Externalreview/title.tudanhgia')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                <tr>
                    <td>@lang('project/Externalreview/title.tieuchi') {{ $keHoachTieuChuan->tieuChuan->stt }}.{{ $keHoachTieuChi->tieuChi->stt }}</td>
                    <td>{{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
</div>
