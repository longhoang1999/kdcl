<div class="m-l-md">
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        <strong>
            Tiêu chí {{ $keHoachTieuChuan->tieuChuan->stt }}
            .{{ $keHoachTieuChi->tieuChi->stt }}
            : {{ $keHoachTieuChi->tieuChi->mo_ta }}
        </strong>
        <div class="m-l-md">
{{--            <strong>1. Mô tả: </strong></p>--}}
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>{!! $keHoachMenhDe->baoCaoMenhDe->mota !!}</p>
            @endforeach
            <br/>

            <p><strong>Tự đánh giá tiêu chí đạt mức:  {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}/7</strong></p>
        </div>
    @endforeach

    <strong>Đánh giá chung về tiêu chuẩn {{ $keHoachTieuChuan->tieuChuan->stt }}:</strong>
    <br/>
    <strong>1. Tóm tắt các điểm mạnh:</strong>
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>{!! $keHoachMenhDe->baoCaoMenhDe->diemmanh !!}</p>
            @endforeach
    @endforeach
    <br/>
    <strong>2. Tóm tắt các điểm tồn tại:</strong>
    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
            @continue(!$keHoachMenhDe->baoCaoMenhDe)
            <p>{!! $keHoachMenhDe->baoCaoMenhDe->tontai !!}</p>
        @endforeach
    @endforeach
    <br/>
    <strong>3. Kế hoạch cải tiến:</strong>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>STT</th>
                <th>Mục tiêu</th>
                <th>Nội dung</th>
                <th>Đơn vị thực hiện</th>
                <th>Đơn vị kiểm tra</th>
                <th>Thời gian thực hiện</th>
                <th>Ghi chú</th>
            </tr>
            </thead>
            <tbody>
            @php $stt=0; $stt_dm=0; $stt_tt=0 ;@endphp
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                    @continue(!$keHoachMenhDe->baoCaoMenhDe)
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
                                tới {{ \Carbon\Carbon::parse($keHoachHanhDong->ngay_hoanthanh)->format('d/m/Y')}}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
        <br/>
        <strong>4. Mức đánh giá:</strong>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Tiêu chuẩn/Tiêu chí</th>
                <th>Tự đánh giá</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                <tr>
                    <td>Tiêu chí {{ $keHoachTieuChuan->tieuChuan->stt }}.{{ $keHoachTieuChi->tieuChi->stt }}</td>
                    <td>{{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
</div>
