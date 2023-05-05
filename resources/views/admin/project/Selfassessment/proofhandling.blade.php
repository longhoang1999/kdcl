@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
    <style>
        .block-minhchung{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px 0px;
            padding: 0 20px;
        }
        .content-body{
            padding: 5px;
            border-radius: 5px;
            margin: 20px;
        }
        table tr{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        .block-flex{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-delete-mc, .btn-delete-mcg{
            display: flex;
            justify-content: center;
            align-items: center;
            outline: none;
            border: none;
            width: 25px;
            height: 25px;
            color: white;
            border-radius: 50%;
            margin-left: 10px;
            font-weight: bold;
        }
        .btn-delete-mc{
            background: orange;
        }
        .btn-delete-mcg{
            background: #e90000;
        }
        .block-minhchung span{
            flex: 1;
        }
        .select2-container .select2-selection--single{
        height: 39px !important;
    }
    .col-md-1{
        padding-bottom: 1rem;
    }
    </style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.xlmc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="block-flex">
        <h4>
            @lang('project/Selfassessment/title.tkmc')
        </h4>
        <a href="{{ route('admin.tudanhgia.preparereport.proofHandGroup') }}" class="btn btn-warning">
            @lang('project/Selfassessment/title.xlmc')
        </a>
    </div>
    <div class="form pl-5 pr-5 container-fuild">
        <div class="row block-form">
            <label for="select-report" class="col-md-5">
                @lang('project/Selfassessment/title.bclkhct'): 
            </label>
            <select name="" id="select-report" class="form-control col-md-7">
                <option value="" hidden></option>
                @foreach($kehoach_baocao as $khbc)
                    <option value="{{ $khbc->id }}">{{ $khbc->ten_bc }}</option>
                @endforeach
            </select>
        </div>
        <div class="row block-form mt-3">
            <label for="standard" class="col-md-2">
                @lang('project/Selfassessment/title.tctchi'): 
            </label>
            <select name="" id="standard" class="form-control col-md-3">
                <option value="" hidden></option>
            </select>
            <div class="col-md-1"></div>
            <select name="" id="criteria" class="form-control col-md-3">
                <option value="" hidden></option>
            </select>
        </div>
        <button class="btn mt-1" id="btn-search" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.timkiem')">
            <i class="bi bi-search" style="font-size: 35px;color: #009ef7;"></i>
        </button>
    </div>
</section>



<section class="content-body pl-2 pr-2">
    <h3>@lang('project/Selfassessment/title.dsmcdxl')</h3>
    <div class="block-mana">
        <table class="table table-striped table-bordered" id="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">
                  @lang('project/Selfassessment/title.tmcdxl')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.kmc')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.tchi')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.mctt')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.mctp')
              </th>
              <th scope="col">
                  @lang('project/Selfassessment/title.quanly')
              </th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
    </div>
</section>


<!-- Xóa minh chứng thành phần -->
<div class="modal fade" id="modalDeleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            @lang('project/Selfassessment/title.canhbao')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="font-weight-bold text-denger">
            @lang('project/Selfassessment/title.hdktht')
        </p>
      </div>
      <div class="modal-footer">
        <button id="link-delete-item" class="btn btn-danger" data-minhchunggop="" 
                data-minhchung="">
            @lang('project/Selfassessment/title.xoa')
        </button>
      </div>
    </div>
  </div>
</div>


<!-- Xóa minh chứng gộp -->
<div class="modal fade" id="modalDeleteGroup" tabindex="-1" role="dialog" aria-labelledby="modalDeleteGroupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDeleteGroupLabel">
            @lang('project/Selfassessment/title.canhbao')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="font-weight-bold text-denger">
            @lang('project/Selfassessment/title.hdktht')
        </p>
      </div>
      <div class="modal-footer">
        <button id="link-delete-group" class="btn btn-danger" data-minhchunggop="" 
                data-minhchung="">
            @lang('project/Selfassessment/title.xoa')
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
    <script type="text/javascript">
        $(function(){
            table = $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax:  {
                    url: "{!! route('admin.tudanhgia.preparereport.showmcgop') !!}",
                    type: 'POST',
                    data: {
                        'report_id' : function() { return $("#select-report").val() },
                        'standard_id' : function() { return $("#standard").val() },
                        'criteria_id': function() { return $("#criteria").val() }
                    },
                },
                columns: [
                    { data: 'tieuDe', name: 'tieuDe' },
                    { data: 'kieuMC', name: 'kieuMC' },
                    { data: 'sttTieuchi', name: 'sttTieuchi'},
                    { data: 'countMctt', name: 'countMctt' },
                    { data: 'minhchung', name: 'minhchung' },
                    { 
                        data: 'actions', 
                        name: 'actions', 
                        className: 'action', 
                    },
                ],            
            });
        });

        $('#modalDeleteItem').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget) 
            let minhChung = button.data('minhchung') 
            let minhChungGop = button.data('minhchunggop') 
            let modal = $(this)
            modal.find('#link-delete-item').attr("data-minhchunggop", minhChungGop)
            modal.find('#link-delete-item').attr("data-minhchung", minhChung)
        })

        $('#modalDeleteGroup').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget)  
            let minhChungGop = button.data('minhchunggop') 
            let modal = $(this)
            modal.find('#link-delete-group').attr("data-minhchunggop", minhChungGop)
        })
        

        $("#link-delete-item").on('click', function() {
            let minhChung = $(this).attr("data-minhchung")
            let minhChungGop = $(this).attr("data-minhchunggop")
            let route = "{{ route('admin.tudanhgia.preparereport.deleteMctp') }}";
            let data = {
                minhchungid: minhChung,
                minhchunggopid: minhChungGop
            }
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.status){
                        $('#modalDeleteItem').modal("hide");
                        table.ajax.reload();
                    }
                })
        })

        $("#link-delete-group").on('click', function() {
            let minhChungGop = $(this).attr("data-minhchunggop")
            let route = "{{ route('admin.tudanhgia.preparereport.deleteMcGroup') }}";
            let data = {
                minhchunggopid: minhChungGop
            }
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.status){
                        $('#modalDeleteGroup').find("button.close").trigger("click");
                        table.ajax.reload();
                    }
                })
        })

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
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_report=" + $(this).val();
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
        });
        $('#standard').on('change', function (e) {
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_standard=" + $(this).val();
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
        });
        

        $("#btn-search").click(function(){
            table.ajax.reload();
        })
    </script>
@stop







