@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.dlsinhvien')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Standard/standard.css') }}">
<link href="{{ asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<style>
    table, th, td{
        border: 1px solid #414141 !important;
    }
    th{
        font-weight: bold !important;
        padding: 10px 5px !important;
        background-color: #00bfff !important;
    }
    tr:nth-child(odd){
        background-color: #f1f1f1 !important;
    }
    td{
        text-align: center !important;
        padding: 10px 5px !important;
    }
    #excel_data, #excel_data2{
        padding: 5px;
    }
    .table{
        width: 2000px !important;
    }
    #excel_data, #excel_data2{
        overflow-x:auto;
    }
    #excel_data::-webkit-scrollbar, #excel_data2::-webkit-scrollbar {
                height: 1em
            }
    #excel_data::-webkit-scrollbar-thumb, #excel_data2::-webkit-scrollbar-thumb {
        background: #c9c8c7;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.dlsinhvien')
@stop

@section('content')
<section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="card">
    		<div class="card-body">
    			<div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h1>@lang('project/ImportdataExcel/title.cnht')</h1>
                            <a id="export-data" href="" class="btn btn-success">@lang('project/ImportdataExcel/title.export')</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <select class="form-control" id="selectYear">
                        <option value="" >--@lang('project/ImportdataExcel/title.cnhtdl')</option>
                        @foreach($getFile as $value)
                            <option value="{{ $value->id }}">{{ $value->year }}</option>
                        @endforeach
                    </select>
                </div>
    		</div>
    	</div>
        <div id="excel_data2" class="mt-5"></div>
        
        <div class="card mt-4">
    		<div class="card-body">
    			<div class="row">
                    <div class="col-md-12">
                        <h1>@lang('project/ImportdataExcel/title.tdlm')</h1>
                    </div>
                </div>
                <hr>
                <form class="row" action="{{ route('admin.importdata2.dlsinhvien.addfilenew') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <input name="file" type="file" id="excel_file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required/>
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" placeholder="@lang('project/ImportdataExcel/title.ndl')" name="year" required>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-benchmark mr-2" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Thêm mới">
                            <i class="bi bi-plus-square " style="font-size: 30px;color: #009ef7;"></i>
                        </button>
                    </div>
                </form>

    		</div>
    	</div>
        <div id="excel_data" class="mt-5"></div>


    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script>
    const excel_file = document.getElementById('excel_file');
    excel_file.addEventListener('change', (event) => {
        if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
        {
            document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

            // excel_file.value = '';

            return false;
        }
        var reader = new FileReader();
        reader.readAsArrayBuffer(event.target.files[0]);
        reader.onload = function(event){
            var data = new Uint8Array(reader.result);
            var work_book = XLSX.read(data, {type:'array'});
            var sheet_name = work_book.SheetNames;
            var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});
            if(sheet_data.length > 0)
            {
                var table_output = '<table class="table ">';
                for(var row = 0; row < sheet_data.length; row++)
                {
                    table_output += '<tr>';
                    for(var cell = 0; cell < sheet_data[row].length; cell++)
                    {
                        if(row == 0)
                        {
                            table_output += '<th>'+sheet_data[row][cell]+'</th>';
                        }
                        else
                        {
                            table_output += '<td>'+sheet_data[row][cell]+'</td>';
                        }
                    }
                    table_output += '</tr>';
                }
                table_output += '</table>';
                document.getElementById('excel_data').innerHTML = table_output;
            }
            // excel_file.value = '';
        }
    });



    $("#selectYear").on("change", function() {
        if($(this).val() == ""){
            document.getElementById('excel_data2').innerHTML = "";
            $("#export-data").attr('href', "")
        }else{
            let data = {
                'id': $(this).val()
            }
            let routeApi = "{{ route('admin.importdata2.dlsinhvien.showFileData') }}";
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
                    document.getElementById('excel_data2').innerHTML = data.data;
                    $("#export-data").attr('href', data.href)
                })
        }
    })

    $("#export-data").click(function(e){
        e.preventDefault();
        if($(this).attr('href') == ""){
            alert("@lang('project/ImportdataExcel/title.vlcnxhdl')")
        }else{
            location.href = $(this).attr('href');
        }
    })
</script>


@stop
