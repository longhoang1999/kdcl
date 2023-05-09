<style>
	.css_scoll{
		display: none;
	}
</style>
<div class="m-t-md">
    <div class="h5 text-center">
        @lang('project/Externalreview/title.csdlkdclcsdt')
    </div>

    <p class="text-center">@lang('project/Externalreview/title.tdbc2') {{ (($keHoachBaoCaoDetail2->thoi_diem_bao_cao)?\Carbon\Carbon::parse($keHoachBaoCaoDetail2->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>

    <p> <strong>@lang('project/Externalreview/title.phan1') </strong></p>
    <p><i><strong>@lang('project/Externalreview/title.1')</strong></i></p>
    <p>- @lang('project/Externalreview/title.tiengviet')</p>
    <p>- @lang('project/Externalreview/title.tienganh')</p>
    <p><i><strong>@lang('project/Externalreview/title.2')</strong></i></p>
    <p>- @lang('project/Externalreview/title.viettat')</p>
    <p>- @lang('project/Externalreview/title.tienganh')</p>
    <p><i><strong>@lang('project/Externalreview/title.3')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.4')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.5')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.6') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;@lang('project/Externalreview/title.fax')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.email') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.web')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.7') </strong></i><i>@lang('project/Externalreview/title.quyetdinh') </i></p>
    <p><i><strong>@lang('project/Externalreview/title.8')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.9')</strong></i></p>
    <p><i><strong>@lang('project/Externalreview/title.10')</strong></i></p>
    <div class="m-l-lg">
        <p>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled checked> @lang('project/Externalreview/title.conglap')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.bancong')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.danlap')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.tuthuc')
            </label>
        </p>
        <p>@lang('project/Externalreview/title.lhk')</p>
    </div>
    @php $fiveYearAgo = $keHoachBaoCaoDetail2->nam -5 @endphp

    <p> <strong>@lang('project/Externalreview/title.ii')</strong></p>
    <p><i><strong>@lang('project/Externalreview/title.12ten')</strong></i> </p>
    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_donvi)? $keHoachBaoCaoDetail2->phutrach->ten_donvi : ''}}</p>
    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_tienganh)? $keHoachBaoCaoDetail2->phutrach->ten_tienganh : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.13ten')</strong></i></p>
    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_ngan)? $keHoachBaoCaoDetail2->phutrach->ten_ngan : ''}}</p>
    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_tienganh)? $keHoachBaoCaoDetail2->phutrach->ten_tienganh :''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.14ten') </strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ten_donvi_cu)? $keHoachBaoCaoDetail2->phutrach->ten_donvi_cu : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.15ten') </strong></i>{{ isset($keHoachBaoCaoDetail2->ctdt->tennganh)? $keHoachBaoCaoDetail2->ctdt->tennganh : ''}}</p>
    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->ctdt->tennganh)? $keHoachBaoCaoDetail2->ctdt->tennganh :''}}</p>
    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->ctdt->tennganh_en)? $keHoachBaoCaoDetail2->ctdt->tennganh_en : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.16')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ma_ctdt)? $keHoachBaoCaoDetail2->phutrach->ma_ctdt : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.17') </strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ten_ctdt_cu)? $keHoachBaoCaoDetail2->phutrach->ten_ctdt_cu : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.18')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->dia_chi)? $keHoachBaoCaoDetail2->phutrach->dia_chi : ''}}</p>
    <p><i><strong>@lang('project/Externalreview/title.19')</strong></i> {{ (isset($keHoachBaoCaoDetail2->phutrach->dien_thoai)?$keHoachBaoCaoDetail2->phutrach->dien_thoai:'.................. ')  }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;@lang('project/Externalreview/title.fax')</p>
    <p><i><strong>@lang('project/Externalreview/title.20')</strong></i> {{ (($keHoachBaoCaoDetail2->phutrach->email)?$keHoachBaoCaoDetail2->phutrach->email:'.................. ') }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.webs') {{ (($keHoachBaoCaoDetail2->phutrach->website)?$keHoachBaoCaoDetail2->phutrach->website:'..................')  }}</p>
    <p>
        <i><strong>@lang('project/Externalreview/title.21')</strong></i>
        {{ isset($keHoachBaoCaoDetail2->phutrach->nam_thanhlap)?$keHoachBaoCaoDetail2->phutrach->nam_thanhlap:'' }} <br>
      <div> {!! isset($keHoachBaoCaoDetail2->phutrach->mota_nam_thanhlap)?$keHoachBaoCaoDetail2->phutrach->mota_nam_thanhlap : '' !!} </div>
    </p>
    <p><i><strong>@lang('project/Externalreview/title.22')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->nam_batdau)?$keHoachBaoCaoDetail2->phutrach->nam_batdau : '' }}</p>
    <p><i><strong>@lang('project/Externalreview/title.23')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->nam_capbang)?$keHoachBaoCaoDetail2->phutrach->nam_capbang : '' }}</p>
    <p> <strong>@lang('project/Externalreview/title.iii')</strong></p>
    <p><i><strong>@lang('project/Externalreview/title.24') <br></strong></i>
        @php
            if(isset($keHoachBaoCaoDetail2->phutrach->gioi_thieu)){

                if($keHoachBaoCaoDetail2->phutrach->gioi_thieu != null){
                   echo($keHoachBaoCaoDetail2->phutrach->gioi_thieu);
                }
                
            }
        @endphp

    </p>
    <p><i><strong>@lang('project/Externalreview/title.25') <br>
        @php
            if(isset($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc)){
                if($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc != null){
                    echo($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc);
                }
                
            }
        @endphp
        </strong></i>
        
    </p>
    <p>
        <i><strong>@lang('project/Externalreview/title.26')</strong></i>
    </p>

    <p>
        <em>@lang('project/Externalreview/title.rieng')</em>
    </p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>@lang('project/Externalreview/title.tt')</th>
            <th>@lang('project/Externalreview/title.cbp')</th>
            <th>@lang('project/Externalreview/title.hvt')</th>
            <th>@lang('project/Externalreview/title.ns')</th>
            <th>@lang('project/Externalreview/title.hocvi')</th>
            <th>@lang('project/Externalreview/title.dienthoai')</th>
            <th>@lang('project/Externalreview/title.mail')</th>
        </tr>
        </thead>
        <tbody>
        @php $stt = 1 @endphp

        @foreach($ThongKeTruongDonViList as $ThongKeTruongDonVi)
            <tr>
                <td>{{ $stt}}</td>
                <td>{{ $ThongKeTruongDonVi->cdctht }}</td>
                <td>{{ $ThongKeTruongDonVi->hodem }}{{$ThongKeTruongDonVi->ten}}</td>
                <td>{{ $ThongKeTruongDonVi->ngaysinh }}</td>
                <td>
                    @if($ThongKeTruongDonVi->hocham)
                        {{ $ThongKeTruongDonVi->hocham }},
                    @endif
                    {{ $ThongKeTruongDonVi->tdcm }}
                </td>
                <td>{{ $ThongKeTruongDonVi->phone }}</td>
                <td>{{ $ThongKeTruongDonVi->email }}</td>
            </tr>
            @php $stt += 1 @endphp
        @endforeach

        @foreach($TruongPhoDonViPhuTrach as $ThongKeTruongDonVi)
            <tr>
                <td>{{ $stt}}</td>
                <td>{{ $ThongKeTruongDonVi->cdctht }}</td>
                <td>{{ $ThongKeTruongDonVi->hodem }}{{$ThongKeTruongDonVi->ten}}</td>
                <td>{{ $ThongKeTruongDonVi->ngaysinh }}</td>
                <td>
                    @if($ThongKeTruongDonVi->hocham)
                        {{ $ThongKeTruongDonVi->hocham }},
                    @endif
                    {{ $ThongKeTruongDonVi->tdcm }}
                </td>
                <td>{{ $ThongKeTruongDonVi->phone }}</td>
                <td>{{ $ThongKeTruongDonVi->email }}</td>
            </tr>
            @php $stt += 1 @endphp
        @endforeach

         </tbody>
    </table>

    <p><i><strong>@lang('project/Externalreview/title.27')</strong></i></p>

    @foreach($Trinhdo as $DVDT_SLNganh)
        <p>
        @lang('project/Externalreview/title.slcndt') {{ $DVDT_SLNganh->tdcm }}: <b>{{ $DVDT_SLNganh->total }}</b>
        </p>
    @endforeach

    <p>@lang('project/Externalreview/title.slcndtk')</p>
    <p>
        <em>
        @lang('project/Externalreview/title.donvi')
        </em>
    </p>
    <p><i><strong>@lang('project/Externalreview/title.28')</strong></i></p>

    <div class="row m-t-lg">
        @php
            $phuLuc28 = $noiDungThem->where('ten','phuluc28')->first();
            if($phuLuc28){
                $noidung28 = json_decode($phuLuc28->noidung);
            }else{
                $noidung28 = json_decode('{"chinhquy":"co","khongchinhquy":"co","tuxa":"co","nuocngoai":"co","trongnuoc":"co"}');
            }
        @endphp
        <form method="POST" class="col-md-6 noiDungThem phuluc28" action="{{-- route("hoanthanh.api.noidungthem") --}}">
            @csrf
            <input type="hidden" value="phuluc28" name="ten">
            <input type="hidden" value="{{ $keHoachBaoCaoDetail2->id }}" name="id_kehoach_bc">
            <table class="table-borderless table table-condensed">
                <tr>
                    <td></td>
                    <td>@lang('project/Externalreview/title.co')</td>
                    <td>@lang('project/Externalreview/title.khong')</td>
                </tr>
                <tr>
                    <td>@lang('project/Externalreview/title.chinhquy')</td>
                    <td><input {{ ($noidung28->chinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[chinhquy]" value="co"></td>
                    <td><input {{ ($noidung28->chinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[chinhquy]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/Externalreview/title.khongchinhquy')</td>
                    <td><input {{ ($noidung28->khongchinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[khongchinhquy]" value="co"></td>
                    <td><input {{ ($noidung28->khongchinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[khongchinhquy]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/Externalreview/title.tuxa')</td>
                    <td><input {{ ($noidung28->tuxa=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[tuxa]" value="co"></td>
                    <td><input {{ ($noidung28->tuxa=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[tuxa]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/Externalreview/title.lknn')</td>
                    <td><input {{ ($noidung28->nuocngoai=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[nuocngoai]" value="co"></td>
                    <td><input {{ ($noidung28->nuocngoai=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[nuocngoai]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/Externalreview/title.lktn')</td>
                    <td><input {{ ($noidung28->trongnuoc=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[trongnuoc]" value="co"></td>
                    <td><input {{ ($noidung28->trongnuoc=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[trongnuoc]" value="khong"></td>
                </tr>
            </table>
        </form>
    </div>
    <!-- <--cần sửa -->
    <p><i><strong>@lang('project/Externalreview/title.29')<b>{{ $tongSoNganhDaoTao }}</b></strong></i></p>

    <p> <strong>@lang('project/Externalreview/title.iv')</strong></p>
    <p><i><strong>@lang('project/Externalreview/title.30')</strong></i></p>
    <table class="table table-striped table-bordered ">
        <thead>
        <tr>
            <th>@lang('project/Externalreview/title.tt')</th>
            <th>@lang('project/Externalreview/title.pl')</th>
            <th>@lang('project/Externalreview/title.nam')</th>
            <th>@lang('project/Externalreview/title.nu')</th>
            <th>@lang('project/Externalreview/title.tongso')</th>
        </tr>
        </thead>
        <tbody>
        
            <tr>
                <td>1</td>
                <td>
                   <strong>@lang('project/Externalreview/title.cbch')</strong>
                </td>
                <td>{{$Gvcohuunam}}</td>
                <td>{{$Gvcohuunu}}</td>
                <td>{{$Gvcohuunam + $Gvcohuunu}}</td>
            </tr>
             <tr>
                <td>1</td>
                <td>
                   <strong>@lang('project/Externalreview/title.cbk')</strong>
                </td>
                <td>{{$Gvkhacmen - $Gvcohuunam}}</td>
                <td>{{$Gvkhacwn - $Gvcohuunu}}</td>
                <td>{{$Gvkhacmen - $Gvcohuunam + $Gvkhacwn - $Gvcohuunu}}</td>
            </tr>
            

        </tbody>
    </table>
    <p><em>@lang('project/Externalreview/title.donvithuchien')</em></p>
    <p><i><strong>@lang('project/Externalreview/title.31')</strong></i></p>
    <p>
        <small>@lang('project/Externalreview/title.cbchla')
        </small>
    </p>
    <p>
        <small>@lang('project/Externalreview/title.gvtgla')
        </small>
    </p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2">@lang('project/Externalreview/title.tt')</th>
            <th rowspan="2">@lang('project/Externalreview/title.tdhvcd')</th>
            <th rowspan="2">@lang('project/Externalreview/title.soluonggv')</th>
            <th colspan="3">@lang('project/Externalreview/title.gvcohuu')</th>
            <th rowspan="2">@lang('project/Externalreview/title.gvthinhgiang')</th>
            <th rowspan="2">@lang('project/Externalreview/title.gvqt')</th>
        </tr>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.gvbienche')</th>
            <th>@lang('project/Externalreview/title.gvhopdong')</th>
            <th>@lang('project/Externalreview/title.gvkiemnhiem')</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>@lang('project/Externalreview/title.01')</td>
            <td>@lang('project/Externalreview/title.02')</td>
            <td>@lang('project/Externalreview/title.03')</td>
            <td>@lang('project/Externalreview/title.04')</td>
            <td>@lang('project/Externalreview/title.05')</td>
            <td>@lang('project/Externalreview/title.06')</td>
            <td>@lang('project/Externalreview/title.07')</td>
            <td>@lang('project/Externalreview/title.08')</td>

        </tr>
        <?php $i = 1; $sumgv1 = 0; $sumgv2 = 0; $sumgv3 = 0; ?>
        @foreach($list_tdcm as $key=>$plgv)
            <?php $sumgv1 += $plgv[0]; $sumgv2 += $plgv[4]; $sumgv3 += $plgv[5];?>
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{$key}}</td>
                <td>{{$plgv[0]}}</td>
                <td>{{$plgv[1]}}</td>
                <td>{{$plgv[2]}}</td>
                <td>{{$plgv[3]}}</td>
                <td>{{$plgv[4]}}</td>
                <td>{{$plgv[5]}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p><em>@lang('project/Externalreview/title.khitinhsl')</em></p>
    
    <p>@lang('project/Externalreview/title.sum')<b> {{$sum = $sumgv1 - $sumgv2 - $sumgv3}} </b>
    @lang('project/Externalreview/title.nguoi')</p>
    <p>@lang('project/Externalreview/title.tile')
        @if ($sum>0)
            <b>{{number_format(($sum)/$sumgv1*100, 2)}}</b>
        @endif
        @lang('project/Externalreview/title.phantram')</p>
    
    <br/>
    <p><i><strong>@lang('project/Externalreview/title.32')</strong></i></p>
    <p>
        <small>@lang('project/Externalreview/title.solieub32')
        </small>
    </p>

    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2">@lang('project/Externalreview/title.tt')</th>
            <th rowspan="2">@lang('project/Externalreview/title.tdhvcd')</th>
            <th rowspan="2">@lang('project/Externalreview/title.hsquydoi')</th>
            <th rowspan="2">@lang('project/Externalreview/title.soluonggv')</th>
            <th colspan="3">@lang('project/Externalreview/title.gvcohuu')</th>
            <th rowspan="2">@lang('project/Externalreview/title.gvthinhgiang')</th>
            <th rowspan="2">@lang('project/Externalreview/title.gvqt')</th>
            <th rowspan="2">@lang('project/Externalreview/title.gvquydoi')</th>
        </tr>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.gvbienche')</th>
            <th>@lang('project/Externalreview/title.gvhopdong')</th>
            <th>@lang('project/Externalreview/title.gvkiemnhiem')</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>@lang('project/Externalreview/title.01')</td>
            <td>@lang('project/Externalreview/title.02')</td>
            <td>@lang('project/Externalreview/title.03')</td>
            <td>@lang('project/Externalreview/title.04')</td>
            <td>@lang('project/Externalreview/title.05')</td>
            <td>@lang('project/Externalreview/title.06')</td>
            <td>@lang('project/Externalreview/title.07')</td>
            <td>@lang('project/Externalreview/title.08')</td>
            <td>@lang('project/Externalreview/title.09')</td>
            <td>@lang('project/Externalreview/title.010')</td>

        </tr>
        <tr>
            <td> </td>
            <td>@lang('project/Externalreview/title.hsquydoi')</td>
            <td></td>
            <td></td>
            <td>@lang('project/Externalreview/title.001')</td>
            <td>@lang('project/Externalreview/title.001')</td>
            <td>@lang('project/Externalreview/title.0cham3')</td>
            <td>@lang('project/Externalreview/title.0cham2')</td>
            <td>@lang('project/Externalreview/title.0cham2')</td>
            <td></td>
        </tr>
    <?php $index = 1;$gvqd = 0 ; $sumgvch = 0;?>
        @foreach($list_tdcm as $key=>$tlplgv)
            <?php  
                $gvqd = $tlplgv[7]*($tlplgv[1]+$tlplgv[2]+0.3*$tlplgv[3]+0.2*$tlplgv[4]+0.2*$tlplgv[5]); 
                $sumgvch += $tlplgv[15]
             ?>
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{$key}}</td>
                <td>{{$tlplgv[7]}}</td>
                <td>{{$tlplgv[0]}}</td>
                <td>{{$tlplgv[1]}}</td>
                <td>{{$tlplgv[2]}}</td>
                <td>{{$tlplgv[3]}}</td>
                <td>{{$tlplgv[4]}}</td>
                <td>{{$tlplgv[5]}}</td>
                <td>{{$gvqd}}</td>
            </tr>
        @endforeach
        
        </tbody>
    </table>
    <p>
        <small>@lang('project/Externalreview/title.cachtinh')</small>
    </p>
    <br/>
    <p><i><strong>@lang('project/Externalreview/title.33')</strong></i></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2">@lang('project/Externalreview/title.tt')</th>
            <th rowspan="2">@lang('project/Externalreview/title.tdhv')</th>
            <th rowspan="2">@lang('project/Externalreview/title.sl')</th>
            <th rowspan="2">@lang('project/Externalreview/title.tl')</th>
            <th colspan="2">@lang('project/Externalreview/title.plgt')</th>
            <th colspan="5">@lang('project/Externalreview/title.plt')</th>
        </tr>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.nam')</th>
            <th>@lang('project/Externalreview/title.nu')</th>
            <th>@lang('project/Externalreview/title.030')</th>
            <th>@lang('project/Externalreview/title.031')</th>
            <th>@lang('project/Externalreview/title.041')</th>
            <th>@lang('project/Externalreview/title.051')</th>
            <th>@lang('project/Externalreview/title.060')</th>
        </tr>
        </thead>
        <tbody>
        <?php $temp = 1; $sumgvts = 0; $sumgvths = 0;?>
        @foreach($list_tdcm as $key=>$cbtd)
            <?php 
                if ($key == 'Tiến sĩ') {
                    $sumgvts += $cbtd[15];
                }else if ($key == 'Thạc sĩ'){
                    $sumgvths += $cbtd[15];
                }

            ?>
            <tr>
                <td>{{ $temp++ }}</td>
                <td>{{$key}}</td>
                <td>{{$cbtd[15]}}</td>
                <td>{{($sumgvch != 0)?number_format($cbtd[15]/$sumgvch*100,2) : 0}}</td>
                <td>{{$cbtd[8]}}</td>
                <td>{{$cbtd[9]}}</td>
                <td>{{$cbtd[10]}}</td>
                <td>{{$cbtd[11]}}</td>
                <td>{{$cbtd[12]}}</td>
                <td>{{$cbtd[13]}}</td>
                <td>{{$cbtd[14]}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
  
        <p>@lang('project/Externalreview/title.33cham1')<b>{{number_format($tuoitb->tuoitb)}}</b> @lang('project/Externalreview/title.tuoi')</p>
        <p>@lang('project/Externalreview/title.33cham2') <b>{{($sumgvch != 0)?number_format(($sumgvts/$sumgvch)*100,2): 0}}%</b></p>
        <p>@lang('project/Externalreview/title.33cham3')
            <b>{{($sumgvch != 0)?number_format(($sumgvths/$sumgvch)*100,2):0}}%</b></p>
        <br/>

    <p><i><strong>@lang('project/Externalreview/title.34')</strong></i></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2">@lang('project/Externalreview/title.tt')</th>
            <th rowspan="2">@lang('project/Externalreview/title.tansuat')</th>
            <th colspan="2">@lang('project/Externalreview/title.tyle')</th>
        </tr>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.nn')</th>
            <th>@lang('project/Externalreview/title.th')</th>
        </tr>
        </thead>
        <tbody>
        <?php $dem = 1; $dem2 = 7; $dem3 =1?>
        @foreach($arrayngoaingu as $tksdnnth)
            <tr>
                <td>{{$dem++}}</td>
                <td>{{$tksdnnth[$dem3++]}}</td>
                <td>{{number_format($tksdnnth[0],2)}}%</td>
                <td>{{number_format($tksdnnth[$dem2++],2)}}%</td>
            </tr>
            
        @endforeach
        </tbody>
    </table>
    <p> <strong>@lang('project/Externalreview/title.v')</strong></p>
    <p><i><strong>@lang('project/Externalreview/title.35')</strong></i></p>
    <p>@lang('project/Externalreview/title.tongsonguoidk')</p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.stt')</th>
            <th>@lang('project/Externalreview/title.namhoc')</th>
            <th>@lang('project/Externalreview/title.sothisinh')</th>
            <th>@lang('project/Externalreview/title.sotrungtuyen')</th>
            <th>@lang('project/Externalreview/title.tylecanhtranh')</th>
            <th>@lang('project/Externalreview/title.sonhaphoc')</th>
            <th>@lang('project/Externalreview/title.diemtuyen')</th>
            <th>@lang('project/Externalreview/title.diemtrungbinh')</th>
            <th>@lang('project/Externalreview/title.soluongsvqt')</th>
        </tr>
        </thead>
        <tbody>
      
        @foreach($thongKeTuyenSinh as $i=>$tkts)
            <tr>
                <td>{{$i +1}}</td>
                <td>{{$tkts[0]}}-{{$tkts[0]+1}}</td>
                <td>{{$tkts[1]}}</td>
                <td>{{$tkts[2]}}</td>
                <td>{{$tkts[3]}}</td>
                <td>{{$tkts[4]}}</td>
                <td>{{$tkts[5]}}</td>
                <td>{{$tkts[6]}}</td>
                <td>{{$tkts[7]}}</td>
               
            </tr>

        @endforeach
      
        </tbody>
    </table>
    <p><i><strong>@lang('project/Externalreview/title.36')</strong></i></p>
    <p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.cactieuchi')</th>
            @foreach($thongKeTuyenSinh as $i=>$tkts)
                <th>{{$tkts[0]}}-{{$tkts[0]+1}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>@lang('project/Externalreview/title.sv')</td>
            @foreach($thongKeTuyenSinh as $i=>$tkts)
                <td>{{ $tkts[8] }}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <p><i><strong>@lang('project/Externalreview/title.37')</strong></i></p>
    <p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2"></th>
            <th colspan="5">@lang('project/Externalreview/title.namhoc')</th>
        </tr>
        <tr style="text-align:center">
            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <th>{{ $i }}-{{ $i+1 }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>@lang('project/Externalreview/title.soluong')</td>
            @foreach($thongKeTuyenSinh as $i=>$tkts)
                @if(isset($tkts[9]))
                    <td>{{ $tkts[9] }}</td>
                @endif
            @endforeach
        </tr>

        <tr>
            <td>@lang('project/Externalreview/title.tylenguoihoc')</td>
            
            @foreach($thongKeTuyenSinh as $i=>$tkts)
                @if(isset($tkts[9]))
                    <td>{{ number_format(($tkts[9]/$tkts[4])*100,2)}} %</td>
                @endif
            @endforeach
           
        </tr>
        </tbody>
    </table>
    <p><i><strong>@lang('project/Externalreview/title.38')</strong></i></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th>@lang('project/Externalreview/title.cactieuchi')</th>
            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <th>{{ $i }}-{{ $i+1 }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        {{--
        <tr>
            <td>@lang('project/Externalreview/title.tongs')</td>
            @foreach($thongKeCTDT_KTX as $tkctdt_ktx)
                <td>{{ number_format($tkctdt_ktx->TongDienTich,0) }}</td>
            @endforeach
        </tr>
        <tr>
            <td>@lang('project/Externalreview/title.nhucau')</td>
            @foreach($thongKeCTDT_KTX as $tkctdt_ktx)
                <td>{{ number_format($tkctdt_ktx->NhuCau,0) }}</td>
            @endforeach
        </tr>

        <tr>
            <td>@lang('project/Externalreview/title.ktx')</td>
            @foreach($thongKeCTDT_KTX as $tkctdt_ktx)
                <td>{{ number_format($tkctdt_ktx->SoLuongKTX,0) }}</td>
            @endforeach
        </tr>

        <tr>
            <td>@lang('project/Externalreview/title.tylehocktx')</td>
            @foreach($thongKeCTDT_KTX as $tkctdt_ktx)
                <td>{{ number_format($tkctdt_ktx->TongDienTich/$tkctdt_ktx->SoSVNhapHoc,0) }}</td>
            @endforeach
        </tr>
        --}}
        </tbody>
    </table>

    <p><i><strong>@lang('project/Externalreview/title.39')</strong></i></p>
    <p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2"></th>
            <th colspan="5">@lang('project/Externalreview/title.namhoc')</th>
        </tr>
        <tr style="text-align:center">
            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <th>{{ $i }}-{{ $i+1 }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        {{--
        <tr>
            <td>@lang('project/Externalreview/title.soluong')</td>
            @foreach($bang39_SVNCKH as $b39svnckh)
                <td>{{ $b39svnckh->SoLuong }}</td>
            @endforeach
        </tr>

        <tr>
            <td>@lang('project/Externalreview/title.tylesv')</td>
            @foreach($bang39_SVNCKH as $b39svnckh)
                <td>{{ ($b39svnckh->TongSoSV >0)? number_format(100*$b39svnckh->SoLuong/$b39svnckh->TongSoSV, 2): "-" }}
                    %
                </td>
            @endforeach
        </tr>
        --}}
        </tbody>
    </table>

    <p><i><strong>@lang('project/Externalreview/title.40')</strong></i></p>
    <p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="text-align:center">
            <th rowspan="2">@lang('project/Externalreview/title.cactieuchi')</th>
            <th colspan="5">@lang('project/Externalreview/title.namtn')</th>
        </tr>
        <tr style="text-align:center">
            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <th>{{ $i }}-{{ $i+1 }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        {{--
        @foreach($soLuongTotNghieps as $tieuChi => $soLuongTotNghiep)
            <tr>
                <td>@lang('project/Externalreview/title.svtn'){{ $tieuChi }}</td>
                @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                    <td></td>
                @endfor
            </tr>

            <tr>
                <td style="padding-left:50px">@lang('project/Externalreview/title.hecq')</td>
                @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                    <td>{{ $soLuongTotNghiep[1][$i] }}</td>
                @endfor
            </tr>

            <tr>
                <td style="padding-left:50px">@lang('project/Externalreview/title.hekcq')</td>
                @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                    <td>{{ $soLuongTotNghiep[0][$i] }}</td>
                @endfor
            </tr>
        @endforeach
        --}}
        </tbody>
    </table>

