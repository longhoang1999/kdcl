<div class="m-l-md">

    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
        <strong>
            Tiêu chí {{ $keHoachTieuChuan->tieuChuan->stt }}
            .{{ $keHoachTieuChi->tieuChi->stt }}
            : {{ $keHoachTieuChi->tieuChi->mo_ta }}
        </strong>
        <div class="m-l-md">
            <strong>1. Mô tả: </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>{!! $keHoachMenhDe->baoCaoMenhDe->mota !!}</p>
            @endforeach
            <br/>
            <strong>2. Điểm mạnh: </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>{!! $keHoachMenhDe->baoCaoMenhDe->diemmanh !!}</p>
            @endforeach
            <br/>
            <strong>3. Điểm tồn tại: </strong>
            @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                @continue(!$keHoachMenhDe->baoCaoMenhDe)
                <p>{!! $keHoachMenhDe->baoCaoMenhDe->tontai !!}</p>
            @endforeach
            <br/>
            <strong>4. Kế hoạch hành động: </strong>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>STT</th>
                    <!--<th>Tiêu đề</th>-->
                    <th>Nội dung</th>
                    <th>Đơn vị thực hiện</th>
                    <th>Đơn vị kiểm tra</th>
                    <th>Thời gian thực hiện</th>
                    <th>Ghi chú</th>
                </tr>
                </thead>
                <tbody>
                @php $stt=0 @endphp
               
                @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                    @continue(!$keHoachMenhDe->baoCaoMenhDe)
                    @foreach($keHoachMenhDe->baoCaoMenhDe->keHoachHanhDongList as $keHoachHanhDong)
                        @php $stt++ @endphp
                        <tr>
                            <td>{{ $stt }}</td>
                        <!--<td>{{ $keHoachHanhDong->tieu_de }}</td>-->
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

                </tbody>
            </table>
            <p><strong>5. Tự đánh giá: {{($keHoachTieuChi->baoCaoTieuChi['danhgia'] >=4)? "Đạt": "Chưa đạt"}}, {{$keHoachTieuChi->baoCaoTieuChi['danhgia']}}/7</strong></p>
        </div>
    @endforeach

</div>