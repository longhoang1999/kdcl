@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.qlhd')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>

<link type="text/css" href="{{ asset('vendors/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">


<style>
    .block-flex{
        display: flex;
        justify-content: space-between;
        width: 65%;
    }
    input.start-date, input.end-date{
        height: 32px;
        width: 50px;
    }
    .block-date{
        display: flex;
    }
    .min-h400{
        min-height: 120px;
        resize: none;
    }
    .custom-block{
        background: white;
        padding: 10px;
        box-shadow: 0 0 6px grey;
        border-radius: 4px;
    }
    .custom-block h4{
        font-weight: bold;
    }
    .header-table{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.cnmcyc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="mt-2 mb-5 custom-block">
            <form action="{{ route('admin.dambaochatluong.updateaci.postUpdateMcyc') }}" method="post">
                @csrf
                <input type="hidden" name="hdn_id" value="{{ $hdn->id }}">
                <div class="modal-body" >
                    <div class="form-group">
                        <h4>@lang('project/QualiAssurance/title.dvth')</h4>
                        <select name="dv_thuchien[]" class="form-control" multiple="multiple" id="so_list">
                            @foreach($loai_dv as $ldv)
                                <optgroup label="{{ $ldv->loai_donvi }}">
                                    @foreach($donvi as $value)
                                        @if($value->loai_dv_id == $ldv->id)
                                            <option value="{{ $value->id }}">
                                                {{ $value->ten_donvi }}
                                            </option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <h4>@lang('project/QualiAssurance/title.tgth')</h4>
                        <div class="block-date">
                            <div class="input-group mr-3">
                                <div class="input-group-append">
                                   <span class="input-group-text"><i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
                                                                     data-hc="#555555" data-loop="true"></i></span>
                                </div>
                                <input name="startDate" class="start-date form-control flatpickr flatpickr-input" data-mindate="today" id="up_ngaybd" type="text" placeholder="@lang('project/QualiAssurance/title.tgth')">
                            </div>

                             <div class="input-group">
                                <div class="input-group-append">
                                   <span class="input-group-text"><i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
                                                                     data-hc="#555555" data-loop="true"></i></span>
                                </div>
                                <input name="endDate" id="up_nht" class="end-date flatpickr flatpickr-input form-control" type="text" placeholder="@lang('project/QualiAssurance/title.tgkt')">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4>@lang('project/QualiAssurance/title.noidung')</h4>
                        <textarea class="form-control min-h400 up_noidung" placeholder="@lang('project/QualiAssurance/title.noidung')" name="noidung"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn">
                        <i class="bi bi-save" style="font-size: 35px;color: #009ef7;"data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.cnmcyc')"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="header-table">
            <h4 class="font-weight-bold">@lang('project/QualiAssurance/title.dsmc')</h4>
            <button class="btn"  data-toggle="modal" data-target="#modalCreate"><i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.themmc')"></i></button>
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/QualiAssurance/title.tieude')</th>
                <th >@lang('project/QualiAssurance/title.linhvuc')</th>
                <th >@lang('project/QualiAssurance/title.so')</th>
                <th >@lang('project/QualiAssurance/title.ngbh')</th>
                <th >@lang('project/QualiAssurance/title.noibh')</th>
                <th >@lang('project/QualiAssurance/title.diachi')</th>
                <th >@lang('project/QualiAssurance/title.ngql')</th>
                <th >@lang('project/QualiAssurance/title.tacvu')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
</section>

<!-- modal thêm minh chứng -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCreateLabel">
                    @lang('project/QualiAssurance/title.dsmc')
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="lv">@lang('project/QualiAssurance/title.dslv')</label>
                    <select name="" id="lv" class="form-control ">
                        <option hidden value="">@lang('project/QualiAssurance/title.dslv')</option>
                        @foreach($linhvuc as $lv)
                            <option value="{{ $lv->id }}"
                                @if($hdn->nhom_mc_sl_id == $lv->id)
                                    selected
                                @endif
                                >
                                @if(!empty($lv->mo_ta))
                                    {{ $lv->mo_ta }} 
                                @endif  
                            </option>
                        @endforeach
                    </select>   
                </div>
                <div class="form-group">
                    <label for="mc">@lang('project/QualiAssurance/title.lcmc')</label>
                    <select name="" id="mc" class="form-control ">
                        <option hidden value="">@lang('project/QualiAssurance/title.lcmc')</option>
                        @foreach($minhchung as $mc)
                            <option value="{{ $mc->id }}"
                                >{{ $mc->tieu_de }}</option>
                        @endforeach
                    </select>   
                </div>
                <hr>
                <div class="container-fuild hide">
                    <div class="row mt-3">
                        <div class="col-md-8">
                            <strong>@lang('project/QualiAssurance/title.tieude'): </strong><br>
                            <span class="show_tieude"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>@lang('project/QualiAssurance/title.sohieu'): </strong><br>
                            <span class="show_sohieu"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>@lang('project/QualiAssurance/title.ngaybh'): </strong><br>
                            <span class="show_ngbh"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>@lang('project/QualiAssurance/title.noibh'): </strong><br>
                            <span class="show_noibh"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>@lang('project/QualiAssurance/title.diachiluu'): </strong><br>
                            <span class="show_diachi"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>@lang('project/QualiAssurance/title.ngql'): </strong><br>
                            <span class="show_ngql"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="chen_mc" class="btn btn-primary">
                    @lang('project/QualiAssurance/title.tvmcyc')
                </button>
                <a href="{{ route('admin.dambaochatluong.manaproof.createMc') . 
                    '?idhdn=' . $hdn->id }}" class="btn btn-success">
                    @lang('project/QualiAssurance/title.themmc')
                </a>
            </div>
        </div>
    </div>
</div>


<!-- modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalDeleteLabel">
                    @lang('project/QualiAssurance/title.thongbao')
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="badge ">
                    @lang('project/QualiAssurance/message.error.hoixoaTc')
                </span>
                <br>
                <span class="badge ">
                    @lang('project/QualiAssurance/message.error.khoantac')
                </span>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="btn-delete-human">
                    @lang('project/QualiAssurance/title.xoa')
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    @lang('project/QualiAssurance/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>

<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" ></script>

<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>
<script>
    flatpickr('#up_ngaybd', {
        dateFormat: 'd-m-Y',
    });

    flatpickr('#up_nht', {
        dateFormat: 'd-m-Y',
    });
    $("#up_nht").change(function() {
        let dateNht = new Date($("#up_nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#up_ngaybd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#up_ngaybd").change(function() {
        let dateNht = new Date($("#up_nht").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#up_ngaybd").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })

    $(".up_noidung").val("{{ $hdn->noi_dung }}");
    $(".start-date").val('{{ date("d-m-Y", strtotime($hdn->ngay_batdau)) }}');
    $(".end-date").val('{{ date("d-m-Y", strtotime($hdn->ngay_hoanthanh)) }}');
    @foreach($hdn_dv as $value)
        $("#so_list option[value='" + {{ $value->donvi_id }} + "']").prop("selected", true);
    @endforeach
    

    $('#so_list').multiselect({
        enableFiltering: true,
        includeSelectAllOption: true,
        maxHeight: 500,                
        dropUp: true,
        nSelectedText: "@lang('project/QualiAssurance/title.dvdc')",
        nonSelectedText: "@lang('project/QualiAssurance/title.ccdv')",
    });
    
    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route('admin.dambaochatluong.updateaci.showHdnMc', $hdn->id) !!}",
                type: 'GET'
            },
            columns: [
                { data: 'tieu_de'},
                { data: 'linhvuc' },
                { data: 'sohieu', },
                { data: 'ngayBanhanh' },
                { data: 'noi_banhanh' },
                { data: 'address' },
                { data: 'quan_ly' },
                { data: 'actions' ,className: 'action'},

            ],
            order: [[1, 'asc']],
        });
    });

    $(".hide").hide();
    $("#mc").change(function() {
        var id = $(this).val();
        let loadData = "{{ route('admin.dambaochatluong.updateaci.showDataMc') }}" + "?id_mc=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                $(".show_tieude").text(data.tieu_de);
                $(".show_sohieu").text(data.sohieu != null ? data.sohieu : "");
                $(".show_ngbh").text(data.ngay_ban_hanh);
                $(".show_noibh").text(data.noi_banhanh);
                $(".show_diachi").text(data.address);
                $(".show_ngql").text(data.name);
                $("#chen_mc").attr("data-id", data.id);
                $(".hide").show();
            })
    })

    $("#lv").change(function() {
        $("#mc").empty();
        $("#mc").append(`<option hidden value="">@lang('project/QualiAssurance/title.lcmc')</option>`);

        var id = $(this).val();
        let loadData = "{{ route('admin.dambaochatluong.updateaci.showDataMc') }}" + "?id_mcsl=" + id;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                data.forEach(item => {
                    let opt = `<option value="${item.id}">${item.tieu_de}</option>`;
                    $("#mc").append(opt);               
                })
            })
    })

    $("#chen_mc").click(function() {
        let id_hdn = "{{ $hdn->id }}";
        let id_mc = $(this).attr("data-id");
        let loadData = "{{ route('admin.dambaochatluong.updateaci.chenMc') }}" + "?id_hdn=" + id_hdn + "&id_mc=" + id_mc;
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
            .then((response) => response.json())
            .then((data) => {
                alert(data.mes);
                if(data.status == "done"){
                    $("#modalCreate").modal("hide");
                    table.ajax.reload();
                }
            })
    })
</script>


@stop
