<div class="row m-t-lg">
    <div class="col-sm-12">
        <div class="h4 font-bold mb-sm text-center">
            <strong>@lang('project/Selfassessment/title.bthkq')</strong>
        </div>
    </div>
    <div class="col-sm-12 m-t-md">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">@lang('project/Selfassessment/title.tt')</th>
                <th class="text-center" style="width: 50%">@lang('project/Selfassessment/title.lvtctc')</th>
                <th class="text-center">@lang('project/Selfassessment/title.tudanhgia')<br>@lang('project/Selfassessment/title.mucdiem')</th>
                <th class="text-center">@lang('project/Selfassessment/title.gchu')</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $avgLv1 = array();
            $avgLv2 = array();
            $avgLv3 = array();
            $avgLv4 = array();
            ?>
            @foreach($keHoachBaoCaoListDetail->keHoachTieuChuanList as $keHoachTieuChuan)
                @continue(!$keHoachTieuChuan->baoCaoTieuChuan)
                <?php
                $romanNum = 'I';
                if(isset($keHoachTieuChuan->tieuChuan->stt)){
                    if($keHoachTieuChuan->tieuChuan->stt < 9){
                        $romanNum = 'I';
                        if(isset($keHoachTieuChuan->baoCaoTieuChuan->danhgia)){
                            $avgLv1[] = $keHoachTieuChuan->baoCaoTieuChuan->danhgia;
                        }
                    
                    }else if($keHoachTieuChuan->tieuChuan->stt >= 9 && $keHoachTieuChuan->tieuChuan->stt < 13){
                        $romanNum = 'II';
                        $avgLv2[] = $keHoachTieuChuan->baoCaoTieuChuan->danhgia;
                    }else if($keHoachTieuChuan->tieuChuan->stt >= 13 && $keHoachTieuChuan->tieuChuan->stt < 22){
                        $romanNum = 'III';
                        $avgLv3[] = $keHoachTieuChuan->baoCaoTieuChuan->danhgia;
                    }else if($keHoachTieuChuan->tieuChuan->stt >= 22){
                        $romanNum = 'IV';
                        $avgLv4[] = $keHoachTieuChuan->baoCaoTieuChuan->danhgia;
                    }
                }
                
                ?>
          
                    @if(isset($keHoachTieuChuan->tieuChuan->stt))
                        @switch(isset($keHoachTieuChuan->tieuChuan->stt))
                            @case(1)
                                <tr style="font-weight: bold">
                                    <td>{{$romanNum}}</td>
                                    <td>@lang('project/Selfassessment/title.linhvuc1')</td>
                                    <td class="text-center" id="avgLv1"></td>
                                    <td></td>
                                </tr>
                            @break
                            @case(9)
                                <tr style="font-weight: bold">
                                    <td>{{$romanNum}}</td>
                                    <td>@lang('project/Selfassessment/title.linhvuc2')</td>
                                    <td class="text-center" id="avgLv2"></td>
                                    <td></td>
                                </tr>
                            @break
                            @case(13)
                                <tr style="font-weight: bold">
                                    <td>{{$romanNum}}</td>
                                    <td>@lang('project/Selfassessment/title.linhvuc3')</td>
                                    <td class="text-center" id="avgLv3"></td>
                                    <td></td>
                                </tr>
                            @break
                            @case(22)
                                <tr style="font-weight: bold">
                                    <td>{{$romanNum}}</td>
                                    <td>@lang('project/Selfassessment/title.linhvuc4')</td>
                                    <td class="text-center " id="avgLv4"></td>
                                    <td></td>
                                </tr>
                            @break
                            @default
                        @endswitch
                @endif
                

                <tr style="font-weight: bold">
                    <td>{{$romanNum}}.{{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt:''  }}</td>
                    <td>@lang('project/Selfassessment/title.tieuchuan') {{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt:'' }}. {{isset($keHoachTieuChuan->tieuChuan->mo_ta)?$keHoachTieuChuan->tieuChuan->mo_ta:'' }}</td>
                    <td class="text-center">{{ isset($keHoachTieuChuan->baoCaoTieuChuan->danhgia)?$keHoachTieuChuan->baoCaoTieuChuan->danhgia:'' }}</td>
                    <td></td>
                </tr>
                @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                    <tr>
                        <td>{{$romanNum}}.{{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt:'' }}.{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt:'' }}</td>
                        <td>@lang('project/Selfassessment/title.tieuchi') {{ isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt:'' }}.{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt:'' }}. {{ isset($keHoachTieuChi->tieuChi->mo_ta)?$keHoachTieuChi->tieuChi->mo_ta:'' }} </td>
                        <td class="text-center">{{ $keHoachTieuChi->baoCaoTieuChi['danhgia'] ?? 0 }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    document.getElementById("avgLv1").textContent += ({!! number_format(count($avgLv1) ? array_sum($avgLv1) / count($avgLv1) : 0, 2) !!});
    document.getElementById("avgLv2").textContent += ({!! number_format(count($avgLv2) ? array_sum($avgLv2) / count($avgLv2) : 0, 2) !!});
    document.getElementById("avgLv3").textContent += ({!! number_format(count($avgLv3) ? array_sum($avgLv3) / count($avgLv3) : 0, 2) !!});
    document.getElementById("avgLv4").textContent += ({!! number_format(count($avgLv4) ? array_sum($avgLv4) / count($avgLv4) : 0, 2) !!});
</script>
