@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.dcmc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
    <style>
        .form-block{
            padding-bottom: 1rem;   
        }
        .select2-container .select2-selection--single .select2-selection__clear{
            right: 1rem;
        }
        table{
            padding: 21px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 12px #ababab;
        }
        .table td:first-child, .table th:first-child, .table tr:first-child {
            padding: 0.75rem;
        }
        .block-item{
            padding: 21px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 12px #ababab;
        }
    </style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.dcmc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="block-item">
        <h2>@lang('project/Selfassessment/title.xlmc')</h2>
        <form action="{{ route('admin.tudanhgia.preparereport.proofCompare') }}" method="get" id="form-search">
            <div class="container-fuild">
                <div class="row form-block">
                    <div class="col-md-6 block-group">
                        <label for="select-report">@lang('project/Selfassessment/title.baocao')</label>
                        <select name="report_id" id="select-report" class="form-control">
                            <option value="" hidden></option>
                            @foreach($kehoach_baocao as $khbc)
                                <option value="{{ $khbc->id }}">{{ $khbc->ten_bc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-block">
                    <div class="col-md-5 block-group">
                        <label for="standard">@lang('project/Selfassessment/title.tctchi')</label>
                        <select name="standard_id" id="standard" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                        </select>
                    </div>
                </div>
                <div class="row form-block mt-2">
                    <div class="col-md-5 block-group">
                        <select name="criteria_id" id="criteria" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                        </select>  
                    </div>
                    <button type="button" class="col-md-1 btn" id="btn-search" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.timkiem')">
                        <i class="bi bi-search" style="font-size: 35px;color: #009ef7;"></i>
                    </button>
                </div>
                
            </div>
        </form>
    </div>
</section>

<section class="content-body mt-3">
    <h2>@lang('project/Selfassessment/title.qlmc')</h2><br>
    <div class="">
        @if($renderView)
        <table class="table table-striped table-bordered" id="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">
                  @lang('project/Selfassessment/title.tieuchi')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.mctt')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.dsmctp')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.kmc')
              </th>
              
                  <th scope="col">
                      @lang('project/Selfassessment/title.quanly')
                  </th>
              
            </tr>
          </thead>
            <tbody>
                @foreach($listTieuChi as $tieuChi)
                    @php
                        $tieuChuan = DB::table("tieuchuan")
                            ->where("id", $tieuChi->tieuchuan_id)
                            ->select("id", "stt");
                    @endphp
                    @if($tieuChuan->count() == 0)
                        @continue
                    @endif
                    <tr>
                        <td colspan="4">
                            {{ $tieuChuan->first()->stt.".".$tieuChi->stt }}
                            @php
                                $mctt_count = DB::table("role_mctt_tchi")
                                            ->where("tieuchi_id", $tieuChi->id);
                            @endphp
                            @if($mctt_count->count()==0)
                                <i class="font-bold text-danger">
                                    @lang('project/Selfassessment/title.ccmctt')
                                </i>
                            @else
                                : {{ $tieuChi->mo_ta }}
                            @endif
                        </td>
                        
                            <td class="text-center">
                                @php
                                    $minhchung_gop = DB::table("minhchung_gop")
                                        ->where("id_tieuchi", $tieuChi->id);
                                @endphp
                                @if($minhchung_gop->count()>0)
                                    
                                        <button type="button" class="btn xacNhanTieuChi"
                                                data-toggle="modal" data-target="#xacnhanTC"
                                                data-id="{{ $tieuChi->id }}"
                                                data-toggle="tooltip" title="Xác nhận">
                                            <i class="bi bi-check-square-fill" style="font-size: 25px;color: #00bc8c;"></i>
                                        </button>

                                @endif
                            </td>
                        
                    </tr>

                    @php
                        $mctt_id = DB::table("tieuchi_minhchungtt")
                                ->where("tieuchi_id", $tieuChi->id)
                                ->get();
                        $array_minhchungtt_id = [];
                        foreach($mctt_id as $value){
                            array_push($array_minhchungtt_id, $value->minhchungtt_id);
                        }
                        $mctt = DB::table("minhchung_tt")
                            ->whereIn("id", $array_minhchungtt_id)->get();

                    @endphp

                    @foreach($mctt as $minhChungTTKey=>$minhChungTT)
                        <tr>
                            <td></td>
                            <td colspan="3">
                                @php
                                    $mcg_mctt = DB::table("minhchunggop_minhchungtt")
                                        ->where("minhchungtt_id", $minhChungTT->id)
                                        ->get();

                                    $array_minhchunggop_id = [];
                                    foreach($mcg_mctt as $value){
                                        array_push($array_minhchunggop_id, $value->minhchunggop_id);
                                    }

                                    $minhChungGopTT = DB::table("minhchung_gop")
                                        ->whereIn("id", $array_minhchunggop_id)
                                        ->where("id_tieuchi", $tieuChi->id)
                                        ->where("id_kehoach_baocao", $keHoachBaoCaoDetail->id)
                                        ->get();

                                    $tong = 0;
                                    foreach($minhChungGopTT as $value){
                                        $mcg_mc = DB::table("minhchunggop_minhchung")
                                                ->where("minhchunggop_id", $value->id)
                                                ->count();
                                        $tong = $tong + $mcg_mc;
                                    }
                                @endphp
                                @if($tong == 0)
                                    <span class="text-danger">{{ $minhChungTT->tieu_de }} (Cần bổ sung minh chứng)</span>
                                @else
                                    {{ $minhChungTT->tieu_de }}
                                    ({{ $tong }} 
                                    minh chứng)
                                @endif
                            </td>
                           
                                <td class="text-center">
                                    <a href="{{ 
                                        route('admin.tudanhgia.preparereport.createMcGop', 
                                        [
                                            'report_id'=>Request()->report_id,
                                            'standard_id'=>Request()->standard_id,
                                            'criteria_id'=>Request()->criteria_id,
                                            'minhchung_tt'=>$minhChungTT->id
                                        ])
                                     }}"
                                       data-toggle="tooltip" title="Thêm minh chứng"
                                       class="btn btn-xs">
                                        <i class="bi bi-plus-square-fill" style="font-size: 25px;color: rgb(6, 159, 210);"></i>
                                    </a>
                                </td>
                            
                        </tr>
                        @php
                            $isHadMinhChung = false;
                            $minhChungID = [];
                            $count = 0;
                        @endphp
                        @foreach($minhChungGopTT as $minhChungGop)
                            @php
                                $mcg_minhchung = DB::table("minhchunggop_minhchung")
                                            ->where("minhchunggop_id", $minhChungGop->id)
                                            ->get();
                                $array_minhchung_id = [];
                                foreach($mcg_minhchung as $value){
                                    array_push($array_minhchung_id, $value->minhchung_id);
                                }
                                $minhchungs = DB::table("minhchung AS mc")
                                    ->whereIn("mc.id", $array_minhchung_id)
                                    ->leftjoin('nhom_mc_sl AS mcsl', 'mcsl.id', '=', 'mc.nhom_mc_sl_id')
                                    ->select('mc.id', 'mc.tieu_de', 'mcsl.mo_ta', 'mc.sohieu', 'mc.ngay_ban_hanh', 'mc.nhom_mc_sl_id', 'mc.noi_banhanh', 'mc.address');
                            @endphp
                            @foreach($minhchungs->get() as $minhChung)
                                @if(in_array($minhChung->id,$minhChungID))
                                    @continue
                                @endif
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <a href="javascript:;" class="view-minhchung"
                                           data-id="{{ $minhChung->id }}" data-minhchungJSON="{{ json_encode($minhChung) }}"
                                           data-toggle="modal" data-target="#detailMinhChung">
                                            [Minh chứng] {{ $minhChung->tieu_de }}
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        @if($minhchungs->count() == 1)
                                            <button class="btn btn-xs" data-toggle="tooltip"
                                                    title="Minh chứng độc lập">
                                                <i class="fas fa-clipboard" style="font-size: 25px;color: red;"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs" data-toggle="tooltip"
                                                    title="Minh chứng gộp">
                                                <i class="fas fa-paste" style="font-size: 25px;color: #180cf5;"></i>
                                            </button>
                                        @endif

                                        @if($minhChungGop->xacnhan=='Y')
                                            <button class="btn btn-xs " data-toggle="tooltip"
                                                    title="Đã xác nhận">
                                                <i class="bi bi-check-circle-fill" style="font-size: 25px;color: #50cd89;"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-default" data-toggle="tooltip"
                                                    title="Chưa xác nhận">
                                                <i class="far fa-circle"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <button class="btn btn-xs MCGopDel" data-toggle="tooltip"
                                                title="Xóa MC khỏi nhóm"  data-id="{{$minhChungGop->id}}"
                                                data-mc="{{$minhChung->id}}">
                                            <i class="bi bi-x-circle-fill" style="font-size: 25px;color: red;"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
              </tbody>
        </table>
        {{ $listTieuChi->links() }}
        @endif
    </div>
</section>
<!-- /Kết thúc page trang -->

    
    <!-- Kết thúc trang -->
    </section>


<!-- modal detail minh chứng -->

<!-- data-minhchungJSON -->
<div class="modal fade" id="detailMinhChung" tabindex="-1" role="dialog" aria-labelledby="detailMinhChungLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailMinhChungLabel">
            @lang('project/Selfassessment/title.ttmc')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fuild">
            <div class="row">
                <div class="col-md-12">
                    <label for="fortieude">
                        @lang('project/Selfassessment/title.tieude')
                    </label>
                    <input type="text" class="form-control" disabled id="fortieude">
                </div>
                <div class="col-md-12">
                    <label for="forlinhvuc">
                        @lang('project/Selfassessment/title.linhvuc')
                    </label>
                    <input type="text" class="form-control" disabled id="forlinhvuc">
                </div>
                <div class="col-md-12">
                    <label for="forso">
                        @lang('project/Selfassessment/title.so')
                    </label>
                    <input type="text" class="form-control" disabled id="forso">
                </div>
                <div class="col-md-12">
                    <label for="forngaybh">
                        @lang('project/Selfassessment/title.ngaybh')
                    </label>
                    <input type="text" class="form-control" disabled id="forngaybh">
                </div>
                <div class="col-md-12">
                    <label for="fornoibh">
                        @lang('project/Selfassessment/title.noibh')
                    </label>
                    <input type="text" class="form-control" disabled id="fornoibh">
                </div>
                <div class="col-md-12">
                    <label for="fordiachi">
                        @lang('project/Selfassessment/title.diachi')
                    </label>
                    <input type="text" class="form-control" disabled id="fordiachi">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            @lang('project/Selfassessment/title.dong')
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal xác nhận minh chứng -->
<div class="modal fade" id="xacnhanTC" tabindex="-1" role="dialog" aria-labelledby="xacnhanTCLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="xacnhanTCLabel">
            @lang('project/Selfassessment/title.thongbao')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p class="font-weight-bold text-warning">
                @lang('project/Selfassessment/title.xntc')
            </p>
            <span>
                @lang('project/Selfassessment/title.bdxntc')
            </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-xacnhan">
            @lang('project/Selfassessment/title.xacnhan')
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal xóa minh chứng -->
<div class="modal fade" id="xoaMinhChung" tabindex="-1" role="dialog" aria-labelledby="xoaMinhChungLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="xoaMinhChungLabel">
            @lang('project/Selfassessment/title.canhbao')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <p class="font-weight-bold text-warning">
                @lang('project/Selfassessment/title.xmctp')
            </p>
            <span>
                @lang('project/Selfassessment/title.xmxmctp')
            </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-delete">
            @lang('project/Selfassessment/title.xacnhan')
        </button>
      </div>
    </div>
  </div>
</div>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript">
        function checkSubmit() {
            if($("#select-report").val() != "" && $("#standard").val() != "" && $("#criteria").val() != "")
                return true;
            else return false;
        }
        $("#btn-search").click(function() {
            if(checkSubmit())
                $("#form-search").submit();
            else
                alert("@lang('project/Selfassessment/title.vlddtt')")
        })

        $('#detailMinhChung').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var dataJSON = button.data('minhchungjson') 
            var modal = $(this)
            modal.find('#fortieude').val(dataJSON.tieu_de)
            modal.find('#forlinhvuc').val(dataJSON.mo_ta)
            modal.find('#forso').val(dataJSON.sohieu)
            modal.find('#forngaybh').val(dataJSON.ngay_ban_hanh.split("-").reverse().join("-"))
            modal.find('#fornoibh').val(dataJSON.noi_banhanh)
            modal.find('#fordiachi').val(dataJSON.address)
        })



        $(".MCGopDel").click(function() {
            let mcGopId = $(this).attr("data-id");
            let mcId = $(this).attr("data-mc");
            $("#xoaMinhChung").find(".btn-delete").attr("data-id", mcGopId);
            $("#xoaMinhChung").find(".btn-delete").attr("data-mc", mcId);
            $("#xoaMinhChung").modal("show");
        })
        $(".btn-delete").click(function() {
            let mcGopId = $(this).attr("data-id");
            let mcId = $(this).attr("data-mc");
            let idKhbc = $("#select-report").val();

            var route = "{{ route('admin.tudanhgia.preparereport.xoaMinhChung') }}";
            let data = {
                mcGopId, mcId, idKhbc
            }

            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
                body: JSON.stringify(data)
            })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.mes);
                    window.location.reload();
                })

        })

        $('#xacnhanTC').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var modal = $(this)
            modal.find('.btn-xacnhan').attr('data-id' , id)
        })
        $('.btn-xacnhan').click(function() {
            let idTchi = $(this).attr("data-id");
            let idKhbc = $("#select-report").val();
            var route = "{{ route('admin.tudanhgia.preparereport.xacnhanTchi') }}";
            let data = {
                idTchi, idKhbc
            }
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
                body: JSON.stringify(data)
            })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.mes);
                    window.location.reload();
                })
        })


        function autoChosse(){
            var queryString = location.search
            var params = new URLSearchParams(queryString)
            var reportId = params.get("report_id")
            var standardId = params.get("standard_id")
            var criteriaId = params.get("criteria_id")

            
            if(reportId != NaN){
                $("#select-report").val(reportId).trigger('change');                
                renderReport(() => {
                    $("#standard").val(standardId).trigger('change');
                    renderStandard(() => {
                        $("#criteria").val(criteriaId).trigger('change');
                    });
                });
            }
        }
        autoChosse()




        $("#select-report").select2({
            placeholder: "@lang('project/Selfassessment/title.lcbc')",
            allowClear: true
        })
        $("#standard").select2({
            placeholder: "@lang('project/Selfassessment/title.lctc')",
            allowClear: true
        })
        $("#criteria").select2({
            placeholder: "@lang('project/Selfassessment/title.lctchi')",
            allowClear: true
        })



        $('#select-report').on('change', function (e) {
            renderReport(() => {});
        });
        function renderReport(callback) {
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_report=" + $('#select-report').val();
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.kehoach_tieuchuan != undefined){
                        $('#standard').empty().trigger("change");
                        data.kehoach_tieuchuan.forEach((item, index) => {
                            let title = `TC ${item.stt}: ${item.mo_ta}`;
                            var option = new Option(title, item.tieuchuan_id, true, true);
                            $("#standard").append(option);
                        })
                    }
                    var option = new Option("", "", true, true);
                    $("#standard").append(option).trigger('change');
                })
                .then(() => {
                    callback();
                })
        }









        $('#standard').on('change', function (e) {
            renderStandard(() => {});
        });
        
        function renderStandard(callback){
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_standard=" + $('#standard').val();
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.tieuchi != undefined){
                        $('#criteria').empty().trigger("change");
                        data.tieuchi.forEach((item, index) => {
                            let title = `TChi ${item.stt}: ${item.mo_ta}`;
                            var option = new Option(title, item.id, true, true);
                            $("#criteria").append(option);
                        })
                    }
                    var option = new Option("", "", true, true);
                    $("#criteria").append(option).trigger('change');
                })
                .then(() => {
                    setTimeout(() => {
                        callback();
                    }, 2000)
                })
        }

    </script>
@stop







