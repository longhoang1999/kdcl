<div class="m-l-md">
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        <strong>
            @lang('project/Selfassessment/title.tieuchi') {{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt : '' }}
            .{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt : '' }}
            : {{ isset($keHoachTieuChi->tieuChi->mo_ta)?$keHoachTieuChi->tieuChi->mo_ta : '' }}
        </strong>
        <div class="m-l-md">
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


        </div>
    <p><strong>@lang('project/Selfassessment/title.tdgtcdt')  {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}@lang('project/Selfassessment/title./7')</strong></p>
    @endforeach

    <strong>@lang('project/Selfassessment/title.dgcvtc') {{ isset($keHoachTieuChuan->tieuChuan->stt) ? $keHoachTieuChuan->tieuChuan->stt : '' }}:</strong>
    <br/>
    <strong>@lang('project/Selfassessment/title.1tomtat')</strong>
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
    <strong>@lang('project/Selfassessment/title.2tomtat')</strong>
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
            @continue(!$keHoachMenhDe->baoCaoMenhDe)
            @php
                if (isset($keHoachMenhDe->baoCaoMenhDe->tontai)) {
                    $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $keHoachMenhDe->baoCaoMenhDe->tontai);
                    echo $absoluteImagePath;
                }
            @endphp
        @endforeach
    @endforeach
    <br/>
    <strong>@lang('project/Selfassessment/title.3tomtat')</strong>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>@lang('project/Selfassessment/title.stt')</th>
                <th>@lang('project/Selfassessment/title.muctieu')</th>
                <th>@lang('project/Selfassessment/title.noidung')</th>
                <th>@lang('project/Selfassessment/title.dvth')</th>
                <th>@lang('project/Selfassessment/title.dvkt')</th>
                <th>@lang('project/Selfassessment/title.tgth')</th>
                <th>@lang('project/Selfassessment/title.gchu')</th>
            </tr>
            </thead>
            <tbody>
           @php $stt=0; $stt_dm=0; $stt_tt=0 ;@endphp
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                    @continue(!$keHoachMenhDe->baoCaoMenhDe)
                    @foreach($keHoachMenhDe->keHoachHanhDongList as $keHoachHanhDong)
                        @php
                            $stt++;
                            ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? $stt_dm++ : $stt_tt++;
                        @endphp


                        <tr>
                            <td>{{ $stt }}</td>
                            <td>{{ ($keHoachHanhDong->kieu_kehoach == 'diemmanh')? "Phát huy điểm mạnh $stt_dm" :  "Khắc phục tồn tại $stt_tt"}}</td>
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
            @endforeach
            </tbody>
        </table>
        <br/>
        <strong>@lang('project/Selfassessment/title.4mdg')</strong>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>@lang('project/Selfassessment/title.tctc')</th>
                <th>@lang('project/Selfassessment/title.tdg')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                <tr>
                    <td>@lang('project/Selfassessment/title.tieuchi') {{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt:'' }}.{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt:'' }}</td>
                    <td>{{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
</div>