@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.qlmc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dropfile.css')}}">
<link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/app.css') }}" />
<link href="{{ asset('css/pages/tagsinput.css') }}" rel="stylesheet" />

<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('title_page')
    Quản lý báo cáo đánh giá ngoài
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">

    <style>
        .select2-selection{
            display: flex !important;
            align-items: center;
            justify-content: center;
            border: 1px solid #e4e6ef;
            background-color: #fff;
        }

        .select2-search__field{
            outline: none;
            background: none;
        }
        .label-info{
        background: #7272ff !important;
        border-radius: 4px !important;
        padding: 0 6px !important;
    }
    </style>
    <div class="form-standard">
        <form id="mc_form" action="{!! route('admin.tonghop.dbcl.update_nx') !!}" method="post" enctype="multipart/form-data" onsubmit="return checksubmit();">
            @csrf
           <input type="hidden" name="idkhbc" id="idkhbc">
            
            <div class="form-group row pl-4">
                <div class="col-md-3">
                    @lang('project/QualiAssurance/title.file')
                </div>
                <div class="col-md-6">
                    <div id="dropzon_id" class="dropzon text-primary">            
                        <input type="file" class="form-control-file text-primary font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title="@lang('project/QualiAssurance/title.chichonteporpdf')" name="file" accept="image/jpeg,image/gif,image/png,application/pdf">>
                        <center><p id="img_name">@lang('project/QualiAssurance/title.chichonteporpdf')</p></center>
                    </div>
                </div>
                <div class="col-md-2" id="showthumnail">
                    
                </div>
            </div>
            
                <div class="form-group row pl-4 mt-5">
                    <div class="col-md-10 row">
                        <div class="col-md-4">
                            @lang('project/QualiAssurance/title.nam')
                        </div>
                        <div class="col-md-7">
                            <select class="form-control" id="year_search" onchange="change(value)">
                                <option value=""></option>
                                @for($i = intVal(date('Y'));$i >= 1990 ;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10 row mt-4">
                        <div class="col-md-4">
                            Báo cáo
                        </div>
                        <div class="col-md-7">
                            <select class="form-control" id="ten_bc">
                                <option value=""></option>
                                
                            </select>
                        </div>
                    </div>
                </div>

            
            <div class="item-group-button mb-2">
                <button class="btn btn-benchmark mt-5 ml-4 pl-3 pr-3" type="button">
                    <i class="bi bi-x-circle" style="font-size: 35px;color: red;"></i>
                </button>
                <button type="submit" onclick="doSubmit();" class="btn btn-benchmark mt-5 ml-4 pl-3 pr-3" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.luu')">
                    <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
        </form>
        
    </div>


</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"  type="text/javascript"></script>
<script src="{{ asset('vendors/typeahead.js/js/bloodhound.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('vendors/typeahead.js/js/typeahead.bundle.min.js') }}"  type="text/javascript"></script>

<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>


<script>
    var fileuploadok = true;
    var uploadfilesize = 0;
    var maxuploadfilesize = 40; //MB
   
    function doSubmit(){
        $('#mc_form').submit();                        
    }

    function checksubmit(){
        tukhoa = $('#tukhoa').val();
        if(tukhoa == ''){
            alert("@lang('project/QualiAssurance/message.error.empty_tukhoa')");
            return false;
        }   

        if(uploadfilesize > maxuploadfilesize * 1024 * 1024){
            alert("@lang('project/QualiAssurance/message.error.maxuploadfilesize')");
            return false;
        }

        if($('#linhvuc_search').val() == ''){            
            alert("@lang('project/QualiAssurance/message.error.empty_linhvuc')");
            return false;
        }

        return fileuploadok;
    }

    $('#tukhoa').tagsinput({   
        itemText: function(item) {
            return item;
        },
        typeaheadjs: {
            name: 'tukhoatimkiem',            
            displayKey: 'name',
            valueKey: 'name',
            source: function(query, process, cb) {                
                return $.get("{!! route('admin.dambaochatluong.manaproof.getTukhoa') !!}", {tukhoa: query, linhvuc: $('#linhvuc_search').val() }, function (data) {
                        var response = [];
                        $.map(JSON.parse(data), function (item) {
                            response.push({name : item});
                        });
                        return cb(response);
                });     
            }
        },
    });

    
    function readUrl(input) {  
        if (input.files[0]) {           
            var fs = input.files[0].size;
            uploadfilesize = fs;

            var isred = uploadfilesize > maxuploadfilesize * 1024 * 1024 ? true : false;
            if(fs >= 1024 * 1024){
                fs = (parseFloat(fs) / (1024 * 1024)).toFixed(2) + ' mb'; 
            }else if(fs >= 1024){
                fs = (parseFloat(fs) / (1024)).toFixed(2) + ' kb';
            }else{
                fs = parseFloat(fs).toFixed(2) + ' b';
            }
            text = input.files[0].name + '(' + fs + ')';

            $('#showthumnail').empty();
            if(isred){
                fileuploadok = false;
                text = '<span style="color:red;">' + text + '</span>';
                alert("@lang('project/QualiAssurance/message.error.maxuploadfilesize')");
            }else{
                $.ajax({
                    url: "{!! route('admin.tonghop.dbcl.uploadfile') !!}",
                    type: 'POST',                
                    data: {
                        filename: input.files[0].name,
                        size: uploadfilesize,
                        _token: "{{csrf_token()}}",
                    },
                    error: function(err) {

                    },            
                    success: function(data) {   

                         fileuploadok = true;
                            input.setAttribute("data-title", text);
                            $('#img_name').html(text); 
                        // if(data == 1){
                        //     fileuploadok = true;
                        //     input.setAttribute("data-title", text);
                        //     $('#img_name').html(text);                            
                        // }else{
                        //     var textout = '<span style="color:red;">' + "@lang('project/QualiAssurance/message.error.fileexisted')</span>";
                        //     fileuploadok = false;
                        //     var textthumb = '<a href="' + data + '"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/></svg></a>'
                        //     $('#img_name').html(textout);
                        //     $('#showthumnail').html(textthumb);
                        // }
                    }
                });
            }             
        }
    }
 
  

    function change(a) {
        let namebc = $('#ten_bc');
        $.ajax({
            url: "{{ route('admin.tonghop.dbcl.baocaodgn_nx') }}",
            type: 'POST',
            data: {
                nam: a,
                _token: "{{ csrf_token() }}",
            },
            error: function(err) {

            },
            success: function(data) {
                namebc.empty(); // Xóa tất cả các phần tử <option> hiện có trong thẻ <select>
                namebc.append(`<option value="">
                                    </option>`);
                data.forEach(function(e) {
                    namebc.append(`<option value="${e.id}">
                                        ${e.ten_bc}
                                    </option>`);
                });
            }
        });
    }

    $('#ten_bc').on('change', function() {
        $('#idkhbc').val($(this).val());
    });

    $(function(){
      	$("#year_search").select2({
               placeholder: "@lang('project/QualiAssurance/title.nam')",        
        });
        $("#ten_bc").select2({    
            placeholder: "Chọn báo cáo",
        });
        $("#hoatdong_search").select2({    

        });
        $("#quanly_search").select2();
      	$("#mcyc_search").select2();
      
    });

    
</script>

@stop
