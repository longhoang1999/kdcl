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
    .min-h500{
        min-height: 120px;
        resize: none;
    }
    .bao{
        margin: -4.5rem 0px 0px 67rem;
        position: absolute;
    }
    .btn-group, .btn-group-vertical{
        background: aquamarine;
        border-radius: 8px;
        margin-bottom: 11px;
    }
</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.qlmcyc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        @if( !Sentinel::inRole('ns_kiemtra') )
        <h4>@lang('project/QualiAssurance/title.qlmcyc')</h4>
        <form action="{{ route('admin.dambaochatluong.updateaci.updateMcyc') }}" method="post">
            @csrf
            <input type="hidden" name="id_hdn" value="{{ $hdn->id }}">
            <div class="container-fuild mt-3 pl-5">
                <div class="row mt-3 ">
                    <div class="col-md-2">
                        <select class="form-control " disabled>
                            @for($i = intVal(date('Y')) ;$i >= 2017 ;$i--)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control " id="select_mcsl" name="id_mcsl">
                            <option hidden>@lang('project/QualiAssurance/title.lclv')</option>
                            @foreach ($linhvuc as $item)
                                <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control " placeholder="@lang('project/QualiAssurance/title.thd')" id="name_hd" name="name_hd">
                    </div>
                    <div class="col-md-1">
                        <button class="btn pl-4 pr-4 " data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.luu')"><i class="bi bi-save" style="font-size: 35px;color: #009ef7;"></i></button>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn" data-toggle="modal" data-target="#modalCreate" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.tmcyc')">
                            <i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;"></i>
                        </button>
                    </div>  
                    
                </div>
            </div>
        </form>
        
        @endif
        <div class="block-flex mt-5 mb-5">
            <h3>@lang('project/QualiAssurance/title.dsmcyc')</h3>
            
        </div>
        
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/QualiAssurance/title.mcyc')</th>
                <th >@lang('project/QualiAssurance/title.dvth')</th>
                <th >@lang('project/QualiAssurance/title.tgth')</th>
                <th >@lang('project/QualiAssurance/title.trangthai')</th>
                @if( !Sentinel::inRole('ns_kiemtra') )
                <th >@lang('project/QualiAssurance/title.hanhd')</th>
                @endif
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
</section>


<!-- modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">
                    @lang('project/QualiAssurance/title.thongbao')
                </h5>
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


<!-- Modal -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">
                    @lang('project/QualiAssurance/title.tmmcyc')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.dambaochatluong.updateaci.createMcyc') }}" method="post">
                @csrf
                <input type="hidden" name="parent" value="{{ $hdn->id }}">
                <div class="modal-body" >
                    <div class="form-group">
                        <h5>@lang('project/QualiAssurance/title.dvth')</h5>
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
                        <h5>@lang('project/QualiAssurance/title.tgth')</h5>
                        <div class="block-date">
                            <div class="input-group mr-3">
                                <div class="input-group-append">
                                   <span class="input-group-text"><i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
                                                                     data-hc="#555555" data-loop="true"></i></span>
                                </div>
                                <input name="startDate" class="start-date form-control flatpickr flatpickr-input" data-mindate="today" id="min_max" type="text" placeholder="@lang('project/QualiAssurance/title.tgth')">
                            </div>

                             <div class="input-group">
                                <div class="input-group-append">
                                   <span class="input-group-text"><i class="livicon" data-name="calendar" data-size="16" data-c="#555555"
                                                                     data-hc="#555555" data-loop="true"></i></span>
                                </div>
                                <input name="endDate" class="end-date flatpickr flatpickr-input form-control" type="text" placeholder="@lang('project/QualiAssurance/title.tgkt')">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h5>@lang('project/QualiAssurance/title.noidung')</h5>
                        <textarea class="form-control min-h500" placeholder="@lang('project/QualiAssurance/title.noidung')" name="noidung"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        @lang('project/QualiAssurance/title.tmoi')
                    </button>
                </div>
            </form>
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
    // var byId = function(id) {
    //     return document.getElementById(id);
    // }
    // Sortable.create(byId('multi'), {
    //     animation: 150,
    //     draggable: '.tile',
    //     handle: '.tile__name',
    // });

    // [].forEach.call(byId('multi').getElementsByClassName('tile__list'), function(el) {
    //     Sortable.create(el, {
    //         group: 'photo',
    //         animation: 150,
    //     });
    // });
    
    flatpickr('.flatpickr', {
        minDate: 'today',
        // maxDate: new Date().fp_incr(14),
        dateFormat: 'd-m-Y',
    });

    $("#select_mcsl").val('{{ $hdn->nhom_mc_sl_id }}')
    $("#name_hd").val('{{ $hdn->noi_dung }}')
    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route('admin.dambaochatluong.updateaci.showMcyc', $hdn->id) !!}",
                type: 'GET'
            },
            columns: [
                { data: 'noi_dung'},
                { data: 'tenDv' },
                { data: 'thoi_gian', },
                { data: 'trang_thai' },
                @if( !Sentinel::inRole('ns_kiemtra') )
                { data: 'actions' ,className: 'action' },
                @endif
            ],
            order: [[1, 'asc']],
        });

        $('#so_list').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 500,                
            dropUp: true,
            nSelectedText: '@lang('project/QualiAssurance/title.dvdc')',
            nonSelectedText: '@lang('project/QualiAssurance/title.ccdv')',
        });

    });

    $('#modalDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        console.log(id)
        var route = "{{ route('admin.dambaochatluong.updateaci.deleteMcyc') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-human').attr('href' , route);
    })
</script>


@stop
