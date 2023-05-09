<div class="row m-t-lg">
    <div class="col-sm-12">
        <div class="ibox">
            <div class="ibox-content">
                   
                    @if($key=="TĐG1")
                    <div class="row m-t-lg">
                        <div class="col-sm-12">
                            <div class="h4 font-bold mb-sm">
                            @lang('project/Externalreview/title.phuluc')
                            </div>
                        </div>

                        <div class="col-sm-12 m-t-md">
                            <p>@lang('project/Externalreview/title.tencsgd')</p>
                            <p>@lang('project/Externalreview/title.ma')</p>
                            <p>@lang('project/Externalreview/title.tenctdt'){{ $keHoachBaoCaoDetail2->phutrachr->ten_ctdt }}</p>
                            <p>@lang('project/Externalreview/title.mactdt'){{ $keHoachBaoCaoDetail2->phutrachr->ma_ctdt }}</p>
                        </div>

                        <div class="col-sm-12 m-t-md">
                            <table class="table table-striped table-bordered " id="table">
                                <thead>
                                <tr>
                                    <th class="text-center" rowspan="3">@lang('project/Externalreview/title.tctc')</th>
                                    <th class="text-center" colspan="7">@lang('project/Externalreview/title.tdg')</th>
                                    <th class="text-center" colspan="3">@lang('project/Externalreview/title.thtc')</th>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="3">@lang('project/Externalreview/title.chuadat')</th>
                                    <th class="text-center" colspan="4">@lang('project/Externalreview/title.dat')</th>
                                    <th class="text-center" rowspan="2">@lang('project/Externalreview/title.muctb')</th>
                                    <th class="text-center" rowspan="2">@lang('project/Externalreview/title.sotcdat')</th>
                                    <th class="text-center" rowspan="2">@lang('project/Externalreview/title.tyledat')</th>
                                </tr>
                                <tr>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.001')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.002')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.003')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.004')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.005')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.006')</span></th>
                                    <th class="text-center"><span class="badge badge-secondary">@lang('project/Externalreview/title.007')</span></th>

                                </tr>
                                </thead>

                                <tbody class="text-center">

                                @foreach($keHoachBaoCaoListDetail as $keHoachTieuChuan)
                                    @continue(!$keHoachTieuChuan->id)
                                    @php
                                        $dat = 0;
                                        if(isset($keHoachTieuChuan->keHoachTieuChiList)){
                                            foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                                                 if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4){
                                                     $dat++;
                                                 }
                                             }
                                        }
                                         
                                    @endphp

                                    <tr class="text-center">
                                        <th>@lang('project/Externalreview/title.tieuchuan'){{ isset($keHoachTieuChuan->keHoachTieuChuans->stt)?$keHoachTieuChuan->keHoachTieuChuans->stt:''  }}</th>
                                        @if(isset($keHoachTieuChuan->danhgia))
                                            @for($i=1;$i<=7;$i++)
                                                @if($i==$keHoachTieuChuan->danhgia)
                                                    <th></th>
                                                @else
                                                    <th></th>
                                                @endif
                                            @endfor
                                        @endif
                                        
                                        
                                        <th class="text-center"
                                            rowspan="{{isset($keHoachTieuChuan->keHoachTieuChiList)?$keHoachTieuChuan->keHoachTieuChiList->count()+1 : '' }}">
                                            {{ isset($keHoachTieuChuan->danhgia)?$keHoachTieuChuan->danhgia:'' }}
                                        </th>
                                        <th class="text-center"
                                            rowspan="{{ isset($keHoachTieuChuan->keHoachTieuChiList)?$keHoachTieuChuan->keHoachTieuChiList->count()+1 : '' }}">
                                            {{ $dat }}
                                        </th>
                                        <th class="text-center"
                                            rowspan="{{ isset($keHoachTieuChuan->keHoachTieuChiList)?$keHoachTieuChuan->keHoachTieuChiList->count()+1 : '' }}">
                                            {{ isset($keHoachTieuChuan->keHoachTieuChiList)?round(($dat/$keHoachTieuChuan->keHoachTieuChiList->count())*100,2):'' }}
                                        </th>
                                    </tr>
                                    @if(isset($keHoachTieuChuan->keHoachTieuChiList))
                                        @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                                            <tr>
                                                <td>
                                                @lang('project/Externalreview/title.tieuchi') {{ $keHoachTieuChuan->keHoachTieuChuans->stt }}
                                                    .{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt:'' }}
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

                                    @endif
                                    
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-12 mt-md font-italic">
                            <p class="font-bold">@lang('project/Externalreview/title.ghichu')</p>

                            @lang('project/Externalreview/title.ghibangsn')<br>
                            @lang('project/Externalreview/title.mucdanhgiachung')
                        </div>

                    </div>
                    @elseif($key=="TĐG2")
                    <div class="row m-t-lg">
                        <div class="col-sm-12">
                            <div class="h4 font-bold mb-sm">
                            @lang('project/Externalreview/title.phuluc7b')
                            </div>
                        </div>

                        <div class="col-sm-12 m-t-md">
                            <p>@lang('project/Externalreview/title.tencsgd')</p>
                            <p>@lang('project/Externalreview/title.ma')</p>
                            <p>@lang('project/Externalreview/title.tenctdt'){{ $keHoachBaoCaoDetail2->phutrachr->ten_ctdt }}</p>
                            <p>@lang('project/Externalreview/title.mactdt'){{ $keHoachBaoCaoDetail2->phutrachr->ma_ctdt }}</p>
                        </div>

                        <div class="col-sm-12 m-t-md">
                            <table class="table table-striped table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th class="text-center" rowspan="2">@lang('project/Externalreview/title.tctc')</th>
                                    <th class="text-center" colspan="3">@lang('project/Externalreview/title.kqdg')</th>
                                    <th class="text-center" colspan="2">@lang('project/Externalreview/title.thtc')</th>
                                </tr>
                                <tr>
                                    <th>@lang('project/Externalreview/title.dat')</th>
                                    <th>@lang('project/Externalreview/title.chuadat')</th>
                                    <th>@lang('project/Externalreview/title.khongdanhgia')</th>
                                    <th>@lang('project/Externalreview/title.sotcdat')</th>
                                    <th>@lang('project/Externalreview/title.tyledat')</th>
                                </tr>

                                </thead>

                                <tbody class="text-center">
                                @php
                                    $totalDat = 0;
                                    $totalTieuChi = 0;
                                @endphp

                                @foreach($keHoachBaoCaoListDetail as $keHoachTieuChuan)
                                    @continue(!$keHoachTieuChuan->id)
                                    @php
                                        $dat = 0;
                                        if(isset($keHoachTieuChuan->keHoachTieuChiList)){
                                            foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                                                 if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4){
                                                     $dat++;
                                                     $totalDat++;
                                                 }
                                                 $totalTieuChi++;
                                             }
                                        }
                                         
                                    @endphp

                                    <tr class="text-center">
                                        <th>@lang('project/Externalreview/title.tieuchuan') {{ isset($keHoachTieuChuan->keHoachTieuChuans->stt)?$keHoachTieuChuan->keHoachTieuChuans->stt:'' }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                        <th class="text-center"
                                            rowspan="{{ isset($keHoachTieuChuan->keHoachTieuChiList)?$keHoachTieuChuan->keHoachTieuChiList->count()+1:'' }}">
                                            {{ $dat }}
                                        </th>
                                        <th class="text-center"
                                            rowspan="{{ isset($keHoachTieuChuan->keHoachTieuChiList)?$keHoachTieuChuan->keHoachTieuChiList->count()+1:'' }}">
                                            {{ isset($keHoachTieuChuan->keHoachTieuChiList)?round(($dat/$keHoachTieuChuan->keHoachTieuChiList->count())*100,2):'' }}
                                        </th>
                                    </tr>
                                    @if(isset($keHoachTieuChuan->keHoachTieuChiList))
                                        @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                                            <tr>
                                                <td>
                                                @lang('project/Externalreview/title.tieuchi'){{ $keHoachTieuChuan->keHoachTieuChuans->stt }}
                                                    .{{ isset($keHoachTieuChi->tieuChi->stt)?$keHoachTieuChi->tieuChi->stt:'' }}
                                                </td>

                                                @if($keHoachTieuChi->baoCaoTieuChi['danhgia']>=4)
                                                    <td>@lang('project/Externalreview/title.d')</td>
                                                @else
                                                    <td></td>
                                                @endif


                                                @if($keHoachTieuChi->baoCaoTieuChi['danhgia']<4)
                                                    <td>@lang('project/Externalreview/title.c')</td>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($keHoachTieuChi->baoCaoTieuChi['danhgia']==="")
                                                    <td>@lang('project/Externalreview/title.k')</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                    
                                @endforeach
                                <tr>
                                    <th class="text-center" colspan="4">@lang('project/Externalreview/title.dgc')</th>
                                    <th class="text-center">{{ $totalDat }}</th>
                                    <th class="text-center">{{ round(($totalDat/$totalTieuChi)*100,2) }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-12 mt-md font-italic">
                            <p class="font-bold">@lang('project/Externalreview/title.ghichu')</p>

                            @lang('project/Externalreview/title.gmdg')<br>
                            @lang('project/Externalreview/title.tiletieuchi')
                        </div>


                    @elseif($key=="CSGD")
                            @include("admin.project.ExternalReview.include.phuluc7-csdt")
                    @else
                    <div class="row m-t-lg ">
                        <div class="col-sm-12">
                            @if($key=='ketluanchung')
                                @if($keHoachBaoCaoDetail2->keHoachChung->baoCaoChung)
                                    {!! $keHoachBaoCaoDetail2->keHoachChung->baoCaoChung->ketluan !!}
                                @endif
                            @endif
                            
                            <?php $i = 0; ?>
                            @php $stt=0 @endphp
                            @if($key =='kehoach')
                                <style>
                                .ibox .ibox-content{
                                    padding: 15px 40px 15px 40px !important;
                                }
                                </style>
                                <table class="table table-bordered tableKehoach table-striped " id="table">
                                    <thead>
                                    <tr>
                                        <th width="5%">@lang('project/Externalreview/title.stt')</th>
                                        <!-- <th>Mục tiêu</th> -->
                                        <th width="50%">@lang('project/Externalreview/title.nd')</th>
                                        <th width="12%">@lang('project/Externalreview/title.dvth')</th>
                                        <th width="12%">@lang('project/Externalreview/title.dvkt')</th>
                                        <th width="13%">@lang('project/Externalreview/title.tgth')</th>
                                        <!-- <th>Ghi chú</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($keHoachBaoCaoListDetail as $keHoachTieuChuan)
                                        <?php $i++; ?> 
                                        @continue(!$keHoachTieuChuan->id)
                                        <div class="m-l-md">
                                            @if($key=='kehoach')
                                                <!-- 3. Kế hoạch cải tiến -->
                                                @if(isset($keHoachTieuChuan->keHoachTieuChiList))
                                                    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                                                        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                                            @continue(!$keHoachMenhDe->baocao_menhde)
                                                            @foreach($keHoachMenhDe->baocao_menhde->keHoachHanhDongList as $keHoachHanhDong)
                                                                @php $stt++ @endphp
                                                                <tr>
                                                                    <td>{{ $stt }}</td>
                                                                    <td class="text-td-left">{{ $keHoachHanhDong->noi_dung }}</td>
                                                                    <td>{{ $keHoachHanhDong->donViThucHien->ten_donvi }}</td>
                                                                    <td>{{ $keHoachHanhDong->donViKiemTra->ten_donvi }}</td>
                                                                    <td>
                                                                        {{ $keHoachHanhDong->ngay_batdau }}
                                                                        <br>  @lang('project/Externalreview/title.toi') <br> {{ $keHoachHanhDong->ngay_hoanthanh}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                                      
                                            @endif
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                @foreach($keHoachBaoCaoListDetail as $keHoachTieuChuan)
                                    <?php $i++; ?> 
                                    @continue(!$keHoachTieuChuan->id)
                                    <div class="m-l-md">
                                        @if($key=='diem_manh')
                                            <!--1. Tóm tắt các điểm mạnh:  -->
                                            <p><?= $i; ?>. 

                                                @if(isset($keHoachTieuChuan->keHoachTieuChiList))
                                                    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                                                        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                                            @continue(!$keHoachMenhDe->baocao_menhde)
                                                            {!! strip_tags(str_replace('&nbsp;',' ',$keHoachMenhDe->baocao_menhde->diemmanh)) !!}
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                                
                                            </p>
                                        @elseif($key=='tontai')
                                            <!-- 2. Tóm tắt các tồn tại:  -->
                                            <p><?= $i; ?>.
                                                @if(isset($keHoachTieuChuan->keHoachTieuChiList))
                                                    @foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi)
                                                        @foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe)
                                                            @continue(!$keHoachMenhDe->baocao_menhde)
                                                            {!! strip_tags(str_replace('&nbsp;',' ',$keHoachMenhDe->baocao_menhde->tontai)) !!}
                                                        @endforeach
                                                    @endforeach
                                                @endif 
                                                
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</div>
                   