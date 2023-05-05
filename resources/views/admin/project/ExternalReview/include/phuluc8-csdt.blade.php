<style>
    .text-center{
        text-align: center !important;
    }
    .d-flex{
        display: flex;
    }
    .justify-between{
        justify-content: space-between;
    }
    .mb-1{
        margin-bottom: 0.3em;
    }
    .css_scoll{
        display: none;
    }
</style>
<div class="m-t-md">
    <div class="h5 text-center">
        @lang('project/ExternalReview/title.csdlkdcl')
    </div>

    <p class="text-center">@lang('project/ExternalReview/title.tdbc') {{ (($keHoachBaoCaoDetail2->thoi_diem_bao_cao)?\Carbon\Carbon::parse($keHoachBaoCaoDetail2->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>

    <p> <strong>@lang('project/ExternalReview/title.phan1')</strong></p>
    <p><i><strong>@lang('project/ExternalReview/title.1')</strong></i></p>
    <p>- @lang('project/ExternalReview/title.tiengviet')</p>
    <p>- @lang('project/ExternalReview/title.tienganh')</p>
    <p><i><strong>@lang('project/ExternalReview/title.2')</strong></i></p>
    <p>- @lang('project/ExternalReview/title.viettat')</p>
    <p>- @lang('project/ExternalReview/title.tienganh')</p>
    <p><i><strong>@lang('project/ExternalReview/title.3')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.4')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.5')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.6') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/ExternalReview/title.fax')</strong></i></p>
    <p><i><strong> @lang('project/ExternalReview/title.email') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/ExternalReview/title.web')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.7') </strong></i><i>@lang('project/ExternalReview/title.quyetdinh') </i></p>
    <p><i><strong>@lang('project/ExternalReview/title.8')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.9')</strong></i></p>
    <p><i><strong>@lang('project/ExternalReview/title.10')</strong></i></p>
    <div class="m-l-lg">
        <p>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled checked> @lang('project/ExternalReview/title.conglap')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/ExternalReview/title.bancong')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/ExternalReview/title.danlap')
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="m-t-xs" disabled> @lang('project/ExternalReview/title.tuthuc')
            </label>
        </p>
        <p>@lang('project/ExternalReview/title.lhk')</p>
    </div>
    <p><i><strong>@lang('project/ExternalReview/title.11')</strong></i></p>

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
                    <td>@lang('project/ExternalReview/title.co')</td>
                    <td>@lang('project/ExternalReview/title.khong')</td>
                </tr>
                <tr>
                    <td>@lang('project/ExternalReview/title.chinhquy')</td>
                    <td><input {{ ($noidung28->chinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[chinhquy]" value="co"></td>
                    <td><input {{ ($noidung28->chinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[chinhquy]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/ExternalReview/title.kcq')</td>
                    <td><input {{ ($noidung28->khongchinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[khongchinhquy]" value="co"></td>
                    <td><input {{ ($noidung28->khongchinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[khongchinhquy]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/ExternalReview/title.tuxa')</td>
                    <td><input {{ ($noidung28->tuxa=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[tuxa]" value="co"></td>
                    <td><input {{ ($noidung28->tuxa=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[tuxa]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/ExternalReview/title.lknn')</td>
                    <td><input {{ ($noidung28->nuocngoai=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[nuocngoai]" value="co"></td>
                    <td><input {{ ($noidung28->nuocngoai=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[nuocngoai]" value="khong"></td>
                </tr>

                <tr>
                    <td>@lang('project/ExternalReview/title.lktn')</td>
                    <td><input {{ ($noidung28->trongnuoc=='co')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[trongnuoc]" value="co"></td>
                    <td><input {{ ($noidung28->trongnuoc=='khong')?'checked':"" }} class="radiobox" type="radio"
                               name="noidungthem[trongnuoc]" value="khong"></td>
                </tr>
            </table>
        </form>
    </div>

    <p><i><strong>@lang('project/ExternalReview/title.12')</strong></i></p>
    <p><em>@lang('project/ExternalReview/title.cpb')</em>
    </p>
    <table class="table table-responsive table-bordered table-striped" id="table">
        <thead>
        <tr>
            <th>@lang('project/ExternalReview/title.tt')</th>
            <th>@lang('project/ExternalReview/title.cbp')</th>
            <th>@lang('project/ExternalReview/title.hvt')</th>
            <th>@lang('project/ExternalReview/title.ns')</th>
            <th>@lang('project/ExternalReview/title.hocvi')</th>
            <th>@lang('project/ExternalReview/title.dienthoai')</th>
            <th>@lang('project/ExternalReview/title.mail')</th>
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
        </tbody>
    </table>

    <p><i><strong>@lang('project/ExternalReview/title.13')</strong></i></p>
    <table class="table table-responsive table-bordered table-striped" id="table">
        <tr>
            <thead>
            <tr style="text-align:center">
                <th rowspan="2" class="text-center">@lang('project/ExternalReview/title.stt')</th>
                <th rowspan="2" class="text-center">@lang('project/ExternalReview/title.khoavien')</th>
                <th colspan="2" class="text-center">@lang('project/ExternalReview/title.daihoc')</th>
                <th colspan="2" class="text-center">@lang('project/ExternalReview/title.sdh')</th>
                <th colspan="2" class="text-center">@lang('project/ExternalReview/title.khac')</th>
            </tr>
            <tr style="text-align:center">
                <th>@lang('project/ExternalReview/title.sctdt')</th>
                <th>@lang('project/ExternalReview/title.ssv')</th>
                <th>@lang('project/ExternalReview/title.sctdt')</th>
                <th>@lang('project/ExternalReview/title.ssv')</th>
                <th>@lang('project/ExternalReview/title.sctdt')</th>
                <th>@lang('project/ExternalReview/title.ssv')</th>
            </tr>
            </thead>
            <tbody>
            @php $stt = 1 @endphp
            @foreach($Bang13_CSGD as $i=>$item)
                <tr>
                    <td>{{$stt++}}</td>
                    <td>{{$item->ten_donvi_TV}}</td>
                    {{--<td>{{number_format($item->SoCTDT_1 ?? '', 0, ",", ".")}}</td>
                    <td>{{number_format($item->SoSV_1 ?? '', 0, ",", ".")}}</td>
                    <td>{{number_format($item->SoCTDT_2 ?? '', 0, ",", ".")}}</td>
                    <td>{{number_format($item->SoSV_2 ?? '', 0, ",", ".")}}</td>
                    <td>{{number_format($item->SoCTDT_2 ?? '', 0, ",", ".")}}</td>
                    <td>{{number_format($item->SoSV_3 ?? '', 0, ",", ".")}}</td>--}}
                </tr>
            @endforeach
            </tbody>
        </tr>
    </table>