<div class="row m-t-lg">
    <div class="col-sm-12">
        <div class="h4 font-bold mb-sm">
            @lang('project/Selfassessment/title.pl7a')
        </div>
    </div>

    <div class="col-sm-12 m-t-md">
        <p>@lang('project/Selfassessment/title.tencsgd')</p>
        <p>@lang('project/Selfassessment/title.ma')</p>
        <p>@lang('project/Selfassessment/title.tenctdt')
        <p>@lang('project/Selfassessment/title.mactdt')
    </div>

    <div class="col-sm-12 m-t-md">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" rowspan="3">@lang('project/Selfassessment/title.tctc')</th>
                <th class="text-center" colspan="7">@lang('project/Selfassessment/title.tdg')</th>
                <th class="text-center" colspan="3">@lang('project/Selfassessment/title.thtc')</th>
            </tr>
            <tr>
                <th class="text-center" colspan="3">@lang('project/Selfassessment/title.chuadat')</th>
                <th class="text-center" colspan="4">@lang('project/Selfassessment/title.dat')</th>
                <th class="text-center" rowspan="2">@lang('project/Selfassessment/title.muctb')</th>
                <th class="text-center" rowspan="2">@lang('project/Selfassessment/title.sotcdat')</th>
                <th class="text-center" rowspan="2">@lang('project/Selfassessment/title.tyledat')</th>
            </tr>
            <tr>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.001')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.002')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.003')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.004')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.005')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.006')</span></th>
                <th class="text-center"><span class="badge badge-secondary">@lang('project/Selfassessment/title.007')</span></th>
            </tr>
            </thead>

            <tbody class="text-center">

            @foreach($keHoachBaoCaoDetail->keHoachTieuChuanList as $keHoachTieuChuan)
                @continue(!$keHoachTieuChuan->baoCaoTieuChuan)
                @php
                    $dat = 0;
                     foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                         if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4){
                             $dat++;
                         }
                     }

                @endphp

                <tr class="text-center">
                    <th>@lang('project/Selfassessment/title.tieuchuan') {{ $keHoachTieuChuan->tieuChuan->stt }}</th>
                    {{--@for($i=1;$i<=7;$i++)
                        @if($i==$keHoachTieuChuan->baoCaoTieuChuan->danhgia)
                            <th></th>
                        @else
                            <th></th>
                        @endif
                    @endfor
                    --}}
                    <th class="text-center"
                        rowspan="{{ $keHoachTieuChuan->keHoachTieuChiList->count()+1 }}">
                        {{ isset($keHoachTieuChuan->baoCaoTieuChuan->danhgia)?$keHoachTieuChuan->baoCaoTieuChuan->danhgia:'' }}
                    </th>
                    <th class="text-center"
                        rowspan="{{ $keHoachTieuChuan->keHoachTieuChiList->count()+1 }}">
                        {{ $dat }}
                    </th>
                    <th class="text-center"
                        rowspan="{{ $keHoachTieuChuan->keHoachTieuChiList->count()+1 }}">
                        {{ round(($dat/$keHoachTieuChuan->keHoachTieuChiList->count())*100,2) }}
                    </th>
                </tr>
                @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                    <tr>
                        <td>
                            @lang('project/Selfassessment/title.tieuchi') {{ $keHoachTieuChuan->tieuChuan->stt }}
                            .{{ $keHoachTieuChi->tieuChi->stt }}
                        </td>

                        @for($i=1;$i<=7;$i++)
                            @if($i==$keHoachTieuChi->baoCaoTieuChi['danhgia'])
                                <td>{{ $keHoachTieuChi->baoCaoTieuChi['danhgia'] }}</td>
                            @else
                                <td></td>
                            @endif
                        @endfor
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-sm-12 mt-md font-italic">
        <p class="font-bold">@lang('project/Selfassessment/title.ghichu')</p>

        @lang('project/Selfassessment/title.ghibangsn')<br>
        @lang('project/Selfassessment/title.mucdanhgiachung')
    </div>
    
    <div class="col-sm-12 m-t-md">
        <table class="table table-bordered">
            <tr>
                <td style="width:50%"></td>
                <td class="text-center">
                    <p> @lang('project/Selfassessment/title.ngaythangnam')</p>
                    <p class="font-bold">@lang('project/Selfassessment/title.thutruong')</p>
                    <p><i>@lang('project/Selfassessment/title.kyten')</i></p>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="row m-t-lg">
    <div class="col-sm-12">
        <div class="h4 font-bold mb-sm">
            @lang('project/Selfassessment/title.phuluc7b')
        </div>
    </div>

    <div class="col-sm-12 m-t-md">
        <p><p>@lang('project/Selfassessment/title.tencsgd')</p>
        <p>@lang('project/Selfassessment/title.ma')</p>
        <p>@lang('project/Selfassessment/title.tenctdt')</p>
        <p>@lang('project/Selfassessment/title.mactdt')</p>
    </div>

    <div class="col-sm-12 m-t-md">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center" rowspan="2">@lang('project/Selfassessment/title.tctc')</th>
                <th class="text-center" colspan="3">@lang('project/Selfassessment/title.kqdg')</th>
                <th class="text-center" colspan="2">@lang('project/Selfassessment/title.thtc')</th>
            </tr>
            <tr>
                <th>@lang('project/Selfassessment/title.dat')</th>
                <th>@lang('project/Selfassessment/title.chuadat')</th>
                <th>@lang('project/Selfassessment/title.khongdanhgia')</th>
                <th>@lang('project/Selfassessment/title.sotcdat')</th>
                <th>@lang('project/Selfassessment/title.tyledat')</th>
            </tr>

            </thead>

            <tbody class="text-center">
            @php
                $totalDat = 0;
                $totalTieuChi = 0;
            @endphp

            @foreach($keHoachBaoCaoDetail->keHoachTieuChuanList as $keHoachTieuChuan)
                @continue(!$keHoachTieuChuan->baoCaoTieuChuan)
                @php
                    $dat = 0;
                     foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                         if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4){
                             $dat++;
                             $totalDat++;
                         }
                         $totalTieuChi++;
                     }
                @endphp

                <tr class="text-center">
                    <th>@lang('project/Selfassessment/title.tieuchuan') {{ $keHoachTieuChuan->tieuChuan->stt }}</th>
                    <th></th>
                    <th></th>
                    <th></th>

                    <th class="text-center"
                        rowspan="{{ $keHoachTieuChuan->keHoachTieuChiList->count()+1 }}">
                        {{ $dat }}
                    </th>
                    <th class="text-center"
                        rowspan="{{ $keHoachTieuChuan->keHoachTieuChiList->count()+1 }}">
                        {{ round(($dat/$keHoachTieuChuan->keHoachTieuChiList->count())*100,2) }}
                    </th>
                </tr>
                @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                    <tr>
                        <td>
                            @lang('project/Selfassessment/title.tieuchi') {{ $keHoachTieuChuan->tieuChuan->stt }}
                            .{{ $keHoachTieuChi->tieuChi->stt }}
                        </td>

                        @if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4)
                            <td>@lang('project/Selfassessment/title.d')</td>
                        @else
                            <td></td>
                        @endif


                        @if($keHoachTieuChi->baoCaoTieuChi['danhgia']<4)
                            <td>@lang('project/Selfassessment/title.c')</td>
                        @else
                            <td></td>
                        @endif

                        @if($keHoachTieuChi->baoCaoTieuChi['danhgia']==="")
                            <td>@lang('project/Selfassessment/title.k')</td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
            <tr>
                <th class="text-center" colspan="4">@lang('project/Selfassessment/title.dgc')</th>
                <th class="text-center">{{ $totalDat }}</th>
                <th class="text-center">{{ $totalTieuChi != 0 ? round(($totalDat/$totalTieuChi)*100,2) : '-'}}</th>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="col-sm-12 mt-md font-italic">
        <p class="font-bold">@lang('project/Selfassessment/title.ghichu')</p>

        @lang('project/Selfassessment/title.gmdg')<br>
        @lang('project/Selfassessment/title.tiletieuchi')
    </div>

    <div class="col-sm-12 m-t-md">
        <table class="table table-bordered">
            <tr>
                <td style="width:50%"></td>
                <td class="text-center">
                    <p> @lang('project/Selfassessment/title.ngaythangnam')</p>
                    <p class="font-bold">@lang('project/Selfassessment/title.thutruong')</p>
                    <p><i>@lang('project/Selfassessment/title.kyten')</i></p>
                </td>
            </tr>
        </table>
    </div>
</div>