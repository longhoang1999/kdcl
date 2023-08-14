@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.lkhbb')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Standard/standard.css') }}">
<link href="{{ asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .select2-container .select2-selection--single{
        height: unset;
    }
    .container-fuild{
        box-shadow: unset;
    }
    .select2{
        width: 100% !important;
        border: 1px solid  #e4e6ef; 
        padding-top: 4px;
    }
    .select2 span{
        display: block;
        height: 100%;
    }
    .select2-selection{
        border: none !important;
    }
    .select2-container .select2-selection--single .select2-selection__clear{
        margin-right: -2.6rem;
    }
    td.action{
        justify-content: center;
        flex-wrap: wrap;
        width: 190px;
    }
    td.danhmuc{
        color: blue !important;
        text-decoration: underline;
    }
    .font-weight-bold{
        font-weight: bold !important;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.lkhbb')
@stop

@section('content')
<section class="content indexpage pr-3 pl-3">
    <section class="content-body">
        @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
        <div class="item-group-button right-block mb-2">
            <button class="btn btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button"
                data-toggle="modal" data-target="#modalCreateBC" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.phancong')">
                <i class="bi bi-plus-square" style="font-size: 35px;color: red;"></i>
            </button>
        </div>
        @endif
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/ImportdataExcel/title.danhmuc')</th>
                <th >@lang('project/ImportdataExcel/title.tenbang')</th>
                <th >@lang('project/ImportdataExcel/title.donvi')</th>
                <th >@lang('project/ImportdataExcel/title.nskt')</th>
                <th >@lang('project/ImportdataExcel/title.kehoach')</th>
                @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                    <th>@lang('project/ImportdataExcel/title.hanhdong')</th>
                @endif
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </section>
</section>


<!-- Modal -->
<div class="modal fade" id="modalUpdateBC" aria-labelledby="modalUpdateBCLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUpdateBCLabel">
            @lang('project/ImportdataExcel/title.skhpq')
        </h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="{{  route('admin.importdata2.lkhex.updateKH') }}" method="post">
            @csrf
            <input type="text" hidden name="idkh" id="idkh">
            <div class="modal-body">
                <div class="container-fuild">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="upchdanhmuc">
                                    @lang('project/ImportdataExcel/title.chdanhmuc')
                                </label>
                                <br>
                                <select class="btc-select form-control" name="danhmuc" id="upchdanhmuc" required>
                                    <option value="" hidden>--@lang('project/ImportdataExcel/title.chdanhmuc')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="upbang">
                                    @lang('project/ImportdataExcel/title.chonbang')
                                </label>
                                <br>
                                <select class="nganh-select form-control" name="tenbang" id="upbang" required>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="updvth">
                                    @lang('project/Selfassessment/title.dvth')
                                </label>
                                <br>
                                <select class="nganh-select form-control" name="dvth" id="updvth" required>
                                    @foreach($donvi as $value)
                                        <option value="{{ $value->id }}">{{ $value->ten_donvi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="multiple-nskt">
                                @lang('project/Selfassessment/title.nskt')
                            </label>
                            <select class="multiple-nskt js-states form-control" name="ns_kiemtra" required id="upnskt">
                                @foreach($user as $value)
                                    <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                                @endforeach  
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="upngay_cbi_start">
                                    @lang('project/Selfassessment/title.tgth')
                                </label>
                                <br>
                                <input name="ngay_batdau_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="upngay_cbi_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label></label>
                                <br>
                                <input name="ngay_hoanthanh_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="upngay_cbi_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>  
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="upnotes">
                                    @lang('project/ImportdataExcel/title.gcndkh')
                                </label>
                                <br>
                                <textarea class="form-control" name="note" id="upnotes" placeholder="@lang('project/ImportdataExcel/title.gcndkh')" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    @lang('project/ImportdataExcel/title.chinhsua')
                </button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelShow"  aria-labelledby="modelShowLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modelShowLabel">
            @lang('project/ImportdataExcel/title.ttll')
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fuild">
            <div class="row">
                <p>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.danhmuc')</span>: <span class="show_danhmuc"></span> <br>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.tenbang')</span>: <span class="show_tenbang"></span>
                </p>
                <p>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.donvi')</span>: <span class="show_donvi"></span>
                </p>
                <p>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.nskt')</span>: <span class="show_nskt"></span>
                </p>
                <p>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.kehoach')</span>: <span class="show_kehoach"></span>
                </p>
                <p>
                    <span class="font-weight-bold">@lang('project/ImportdataExcel/title.gcndkh')</span>: <span class="show_gcndkh"></span>
                </p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            @lang('project/ImportdataExcel/title.dong')
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDeleteLabel">@lang('project/QualiAssurance/title.thongbao')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>@lang('project/QualiAssurance/title.bctsmxk')</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('project/QualiAssurance/title.huy')</button>
          <button type="button" id="btn-delete" class="btn btn-primary" data-id="">@lang('project/QualiAssurance/title.xoa')</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="modalCreateBC"  role="dialog" aria-labelledby="modalCreateBCLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCreateBCLabel">
            @lang('project/ImportdataExcel/title.lkhbb')
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('admin.importdata2.lkhex.createKH') }}" method="post" id="form-lkhNew">
        @csrf
          <div class="modal-body">
            <div class="container-fuild">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="btc-chdanhmuc">
                                @lang('project/ImportdataExcel/title.chdanhmuc')
                            </label>
                            <br>
                            <select class="btc-select form-control" name="danhmuc" id="btc-chdanhmuc" required>
                                <option value="" hidden>--@lang('project/ImportdataExcel/title.chdanhmuc')</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="select-bang">
                                @lang('project/ImportdataExcel/title.chonbang')
                            </label>
                            <br>
                            <select class="nganh-select form-control" name="tenbang" id="select-bang" required>
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="dvth-select">
                                @lang('project/Selfassessment/title.dvth')
                            </label>
                            <br>
                            <select class="nganh-select form-control" name="dvth" id="dvth-select" required>
                                @foreach($donvi as $value)
                                    <option value="{{ $value->id }}">{{ $value->ten_donvi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="multiple-nskt">
                            @lang('project/Selfassessment/title.nskt')
                        </label>
                        <select class="multiple-nskt js-states form-control" name="ns_kiemtra" id="ns_kiemtra" required>
                            @foreach($user as $value)
                                <option value="{{ $value->id }}">{{$value->name  }} - ({{ $value->ten_donvi }})</option>
                            @endforeach  
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ngay_cbi_start">
                                @lang('project/Selfassessment/title.tgth')
                            </label>
                            <br>
                            <input name="ngay_batdau_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_start" type="text" placeholder="@lang('project/Selfassessment/title.tungay')" required>  
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label></label>
                            <br>
                            <input name="ngay_hoanthanh_chuanbi" class="chot-date form-control flatpickr flatpickr-input searchs" id="ngay_cbi_end" type="text" placeholder="@lang('project/Selfassessment/title.denngay')" required>  
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">
                                @lang('project/ImportdataExcel/title.gcndkh')
                            </label>
                            <br>
                            <textarea class="form-control" name="note" id="notes" placeholder="@lang('project/ImportdataExcel/title.gcndkh')"></textarea>
                        </div>
                    </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-lkhNew">
                @lang('project/Selfassessment/title.luu')
            </button>
          </div>
        </form>
    </div>
  </div>
</div>



<!-- Modal -->


@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>


<script>
    $dataParent = [
        "Đào tạo", "Khoa học công nghệ", "Nhân sự", "Tài chính", "Khảo sát sinh viên", "Cơ sở vật chất", "Kiểm định", "Tài liệu thư viện", "Tài liệu 3 công khai"
    ]
    $dataChild  = [
        'Tuyển sinh',
        'Dữ liệu sinh viên',
        'Chương trình đào tạo',
        'Khoa học công nghệ',
        'Biên soạn sách',
        'Bài báo',
        'Phát minh sáng chế',
        'Giải thưởng',
        'Sáng kiến kinh nghiệm',
        'Hội thảo hội nghị',
        'Thông tin cơ bản',
        'Nhân sự',
        'Doanh thu khoa học công nghệ',
        'Doanh thu khoa học công nghệ 2',
        'Thống kê tài chính',
        'Khảo sát tình trạng tốt nghiệp sinh viên',
        'Diện tính KTX',
        'Thống kê phòng học, thiết bị',
        'Thông kê máy tính',
        'Diện tích sàn xây dựng',
        'Kiểm định',
        'Tài liệu thư viện',
        'Đồ án khóa luận',
        'Hội nghị hội thảo',
        'Giáo trình tài liệu',
        'Môn học',
        'Quy mô đào tạo',
        'Thông tin các phòng',
        'Thông tin sinh viên tốt nghiệp',
        'Thông tin cơ sở giáo dục',
        'Tỉ lệ sinh viên, giảng viên',
        'Diện tích đất',
        'Đào tạo theo đơn',
        'Diện tích đất, tổng diện tích sàn xây dựng',
        'Thông tin về học liệu',
        'Nghiên cứu khoa học',
        'Công khai cam kết chất lượng đào tạo',
        'Công khai tài chính năm học',
        'Công khai đội ngũ giảng viên theo khối ngành',
        'Công khai đội ngũ giảng viên cơ hữu',
    ]

    $("#ns_kiemtra").select2({
        allowClear: false,
        placeholder: "@lang('project/Selfassessment/title.nskt')",
    });
    $("#upnskt").select2({
        allowClear: false,
        placeholder: "@lang('project/Selfassessment/title.nskt')",
    });

    $(function(){
        table = $('#table').DataTable({
            lengthMenu: [[7, 10, 20, -1], [7, 10, 20, "All"]],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.importdata2.lkhex.data') !!}",
            columns: [
                { data: 'danhmuc', name: 'danhmuc' },
                { data: 'table_name', name: 'table_name', className:'danhmuc' },
                { data: 'donvi', name: 'donvi' },
                { data: 'nhansukt', name: 'nhansukt' },
                { data: 'time', name: 'time' },
                @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                { data: 'action', name: 'action', className:'action' },
                @endif
            ],            
        });
    });  

    $dataParent.forEach( (item, index) => {
        let UI = `<option value="${ index + 1}">${item}</option>`;
        $("#btc-chdanhmuc").append(UI)

        let UI2 = `<option value="${ index + 1}">${item}</option>`;
        $("#upchdanhmuc").append(UI2)
    })
    $("#btc-chdanhmuc").on('change', function() {
        $("#select-bang").empty();
        let b = $(this).val();
        if(b == 1){
            let ui = '';
            for(let i = 1; i<= 3; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 2){
            let ui = '';
            for(let i = 4; i<= 10; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 3){
            let ui = '';
            for(let i = 11; i<= 12; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 4){
            let ui = '';
            for(let i = 13; i<= 15; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 5){
            let ui = '';
            for(let i = 16; i<= 16; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 6){
            let ui = '';
            for(let i = 17; i<= 20; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 7){
            let ui = '';
            for(let i = 21; i<= 21; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 8){
            let ui = '';
            for(let i = 22; i<= 22; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }else if(b == 9){
            let ui = '';
            for(let i = 23; i<= 40; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#select-bang").append(ui);
        }
    })


    // check date
    $("#ngay_cbi_end").change(function() {
        let dateNht = new Date($("#ngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#ngay_cbi_start").change(function() {
        let dateNht = new Date($("#ngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#ngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })

    // check date
    $("#upngay_cbi_end").change(function() {
        let dateNht = new Date($("#upngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#upngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })
    $("#upngay_cbi_start").change(function() {
        let dateNht = new Date($("#upngay_cbi_end").val().split("-").reverse().join("-"))
        let dateNbd = new Date($("#upngay_cbi_start").val().split("-").reverse().join("-"))
        if(dateNht < dateNbd){
            alert("@lang('project/QualiAssurance/title.vlcdn')")
            $(this).val("")
        }
    })

    flatpickr('#ngay_cbi_end', {
        dateFormat: 'd-m-Y',
        //minDate: "today",
    });
    flatpickr('#ngay_cbi_start', {
        dateFormat: 'd-m-Y',
        //minDate: "today",
    });


    flatpickr('#upngay_cbi_end', {
        dateFormat: 'd-m-Y',
        //minDate: "today",
    });
    flatpickr('#upngay_cbi_start', {
        dateFormat: 'd-m-Y',
        //minDate: "today",
    });


    
    $('#modelShow').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('id')

        let data = {
            'id'    : recipient
        }
        let routeApi = "{{ route('admin.importdata2.lkhex.getDataOne') }}";
        fetch(routeApi, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {	
                $(".show_danhmuc").text(data.danhmuc)
                $(".show_tenbang").text(data.tablename)
                $(".show_donvi").text(data.ten_donvi)
                $(".show_nskt").text(data.nskt)
                $(".show_kehoach").text(data.kehoach)
                $(".show_gcndkh").text(data.note)
            })
    })

    $('#modalUpdateBC').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('id')

        let data = {
            'idUpdate'    : recipient
        }
        let routeApi = "{{ route('admin.importdata2.lkhex.getDataOne') }}";
        fetch(routeApi, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {	
                if(data.bang_stt == 1 || data.bang_stt == 2 || data.bang_stt == 3 || data.bang_stt == 4){
                    $("#upchdanhmuc").val(1)
                    upbang(1)
                }else if(data.bang_stt == 5 || data.bang_stt == 6 || data.bang_stt == 7 || data.bang_stt == 8 || data.bang_stt == 9 || data.bang_stt == 10){
                    $("#upchdanhmuc").val(2)
                    upbang(2)
                }else if(data.bang_stt == 11 || data.bang_stt == 12){
                    $("#upchdanhmuc").val(3)
                    upbang(3)
                }else if(data.bang_stt == 13 || data.bang_stt == 14 || data.bang_stt == 15){
                    $("#upchdanhmuc").val(4)
                    upbang(4)
                }else if(data.bang_stt == 16){
                    $("#upchdanhmuc").val(5)
                    upbang(5)
                }else if(data.bang_stt == 17 || data.bang_stt == 18 || data.bang_stt == 19 || data.bang_stt == 20){
                    $("#upchdanhmuc").val(6)
                    upbang(6)
                }else if(data.bang_stt == 21){
                    $("#upchdanhmuc").val(7)
                    upbang(7)
                }else if(data.bang_stt == 22){
                    $("#upchdanhmuc").val(8)
                    upbang(8)
                }else{
                    $("#upchdanhmuc").val(9)
                    upbang(9)
                }
                
                $("#upbang").val(data.bang_stt)
                $("#updvth").val(data.donvi_id)
                $("#upnskt").val(data.nskt_id)
                $("#upngay_cbi_start").val(data.ngay_bd.split("-").reverse().join("-"))
                $("#upngay_cbi_end").val(data.ngay_kt.split("-").reverse().join("-"))
                $("#upnotes").val(data.notes)
                $("#idkh").val(data.id)
            })
    })

    function upbang(b){
        if(b == 1){
            let ui = '';
            for(let i = 1; i<= 4; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 2){
            let ui = '';
            for(let i = 5; i<= 10; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 3){
            let ui = '';
            for(let i = 11; i<= 12; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 4){
            let ui = '';
            for(let i = 13; i<= 15; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 5){
            let ui = '';
            for(let i = 16; i<= 16; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 6){
            let ui = '';
            for(let i = 17; i<= 20; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 7){
            let ui = '';
            for(let i = 21; i<= 21; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 8){
            let ui = '';
            for(let i = 22; i<= 22; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }else if(b == 9){
            let ui = '';
            for(let i = 23; i<= 40; i++){
                ui += `<option value="${i}">${$dataChild[i - 1]}</option>`;
            }
            $("#upbang").append(ui);
        }
    }
    $("#upchdanhmuc").on('change', function() {
        $("#upbang").empty();
        let b = $(this).val();
        upbang(b);
    })


    $('#modalDelete').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget) 
        let id = button.data('id')
        let modal = $(this)
        modal.find('#btn-delete').attr("data-id", id)
    })
    $("#btn-delete").click(function() {
        let id_delete = $(this).attr("data-id");
        let routeApi = "{{ route('admin.importdata2.lkhex.deleteKehoach') }}" + "?id_delete="  + id_delete;
            fetch(routeApi, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.result == "done"){
                        $('#modalDelete').find("button.close").click();
                        table.ajax.reload();
                    }
                })
    })
    
</script>

@stop
