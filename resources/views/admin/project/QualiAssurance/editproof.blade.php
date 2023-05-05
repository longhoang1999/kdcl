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
<style type="text/css">

.imgthumnail {
  border: 1px solid #ddd; /* Gray border */
  border-radius: 4px;  /* Rounded border */
  padding: 5px; /* Some padding */
  width: 150px; /* Set a small width */
}

/* Add a hover effect (blue shadow) */
.imgthumnail:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
.form-group{
    margin-bottom: 1rem;
}
.select2-container .select2-selection--single .select2-selection__rendered{
    padding-right: 1px !important;
}
.form-control{
    appearance: auto !important; 
}

.label-info{
        background: #7272ff !important;
        border-radius: 4px !important;
        padding: 0 6px !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.qlmc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<section class="content-body">
    <div class="form-standard">
        <form id="mc_form" action="{!! route('admin.dambaochatluong.manaproof.updateMC') !!}" method="post" enctype="multipart/form-data" onsubmit="return checksubmit();">
            @csrf
            <input type="hidden" name="mc_id" id="mc_id" value="{{$minhchung->id}}">
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.file')
                </div>
                <div class="col-md-6">
                    <div id="dropzon_id" class="dropzon text-primary">            
                        <input type="file" class="form-control-file text-primary font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title="@lang('project/QualiAssurance/title.chichonteporpdf')" name="file" accept="image/jpeg,image/gif,image/png,application/pdf">>
                        <center><p id="img_name">@lang('project/QualiAssurance/title.chichonteporpdf')</p></center>
                    </div>
                </div>
                <div class="col-md-4" id="showthumnail">
                    @if($minhchung->extfile == 'pdf' || $minhchung->extfile == 'PDF')
                        <a target="_blank" href="{!! route('admin.dambaochatluong.manaproof.showProof',$minhchung->id) !!}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
                            </svg>  
                        </a>
                    @else
                        @if($minhchung->duong_dan != '')
                        <a target="_blank" href="{!! route('admin.dambaochatluong.manaproof.showProof',$minhchung->id) !!}">
                            <img src="{{$minhchung->imgfile}}" alt="{{$minhchung->ten_file}}" height="100">
                        </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.hoatd')
                </div>
                <div class="col-md-1">
                    <select class="form-control h-2rem " id="year_search">
                        @for($i = intVal(date('Y'));$i >= 1990 ;$i--)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control h-2rem " name="nhom_mc_sl_id" id="linhvuc_search" >
                        @foreach ($linhvuc as $item)                        
                        <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control h-2rem" id="hoatdong_search" name="hoatdongnhom_id" data-placeholder="@lang('project/QualiAssurance/title.lchd')">
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control h-2rem select2" id="mcyc_search" name="mcyc_id[]" multiple data-placeholder="@lang('project/QualiAssurance/title.mcycau')">
                    </select>
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.tdmc')
                </div>
                <div class="col-md-9">
                    <input type="text" name="tieu_de" value="{{$minhchung->tieu_de}}" required class="form-control">
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.tyeu') 
                </div>
                <div class="col-md-9">
                    <input type="text" name="trich_yeu" value="{{$minhchung->trich_yeu}}" required class="form-control" >
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.nbh')
                </div>
                <div class="col-md-9">
                    <input type="text" name="noi_banhanh" value="{{$minhchung->noi_banhanh}}" required class="form-control" >
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.s_nbh') 
                </div>
                <div class="col-md-4">
                    <input type="text" name="sohieu" value="{{$minhchung->sohieu}}" class="form-control" >
                </div>
                <div class="col-md-2">
                    <!-- <input type="text" class="form-control" name="ngay_ban_hanh" id="ngay_ban_hanh" value="{{$minhchung->ngay_ban_hanh_text}}" required placeholder="Ngày ban hành"> -->
                    <input name="ngay_ban_hanh" class="start-date form-control flatpickr flatpickr-input" id="ngay_ban_hanh" value="{{$minhchung->ngay_ban_hanh_text}}" type="text" placeholder="@lang('project/QualiAssurance/title.nbh')">
                </div>                    
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.dcluu')
                </div>
                <div class="col-md-9">
                    <input type="text" name="address" value="{{$minhchung->address}}" class="form-control">
                </div>
            </div>
            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.ddan')
                </div>
                <div class="col-md-9">
                    <input type="text" name="duong_dan" value="{{$minhchung->url}}" class="form-control">
                </div>
            </div>

            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.tkmc')
                </div>
                <div class="col-md-9">
                    <input type="text" required class="form-control" name="tukhoa" id="tukhoa" data-role="tagsinput">
                </div>
            </div>

            <div class="form-group row pl-4">
                <div class="col-md-2">
                    @lang('project/QualiAssurance/title.nqly')
                </div>
                <div class="col-md-3">
                    <select class="form-control h-2rem" id="quanly_search" name="nguoi_quan_ly">
                        <option value="{{$minhchung->nguoi_quan_ly}}">{{$minhchung->nguoi_quan_ly_text}}</option>
                    </select>
                </div>
                <div class="col-md-1">
                    @if($minhchung->cong_khai == 'Y')
                    <input type="checkbox" class="form-control" name="cong_khai" value="Y" style="margin-left: 10px;height: 3rem;" checked>
                    @else
                    <input type="checkbox" class="form-control" name="cong_khai" value="Y" style="margin-left: 10px;height: 3rem;">
                    @endif
                </div>
                <div class="col-md-2">
                    <div style="margin-top: 5px;">@lang('project/QualiAssurance/title.congkhaimc')</div>
                </div>                
            </div>

            
            <div class="item-group-button mb-2">
                <a class="btn btn-benchmark mt-5 ml-4 pl-3 pr-3" href="{{route('admin.dambaochatluong.manaproof.index')}}">
                    <i class="bi bi-x-circle" style="font-size: 35px;color: red;"></i>
                </a>
                <button type="submit" onclick="doSubmit();" class="btn btn-benchmark mt-5 ml-4 pl-3 pr-3" type="button"> 
                    <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
        </form>
        @if( !Sentinel::inRole('ns_kiemtra') && !Sentinel::inRole('ns_thuchien'))
        @if($minhchung->tinh_trang == 'dangcho')
            <a href="{{ route('admin.dambaochatluong.manaproof.xacnhanMC') }}?idmc={{ $minhchung->id }}&tinh_trang=xacnhan" class="btn btn-success">
                @lang('project/QualiAssurance/title.xacnhan')    
            </a>
            <a href="{{ route('admin.dambaochatluong.manaproof.xacnhanMC') }}?idmc={{ $minhchung->id }}&tinh_trang=khongxacnhan" class="btn btn-danger">
                @lang('project/QualiAssurance/title.khongxacnhan')    
            </a>
        @endif

        @if($minhchung->tinh_trang == 'xacnhan')
            <a href="{{ route('admin.dambaochatluong.manaproof.xacnhanMC') }}?idmc={{ $minhchung->id }}&tinh_trang=khongxacnhan" class="btn btn-danger">
                @lang('project/QualiAssurance/title.khongxacnhan')    
            </a>
        @endif

        @if($minhchung->tinh_trang == 'khongxacnhan')
            <a href="{{ route('admin.dambaochatluong.manaproof.xacnhanMC') }}?idmc={{ $minhchung->id }}&tinh_trang=molai" class="btn btn-warning">
                @lang('project/QualiAssurance/title.molaiMC')    
            </a>
        @endif
        @endif

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
    var firsthd = 0;
   
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

    function gettextdropzone(name, size){
        var fs = size;
        uploadfilesize = fs;
        var isred = uploadfilesize > maxuploadfilesize * 1024 * 1024 ? true : false;
        if(fs >= 1024 * 1024){
            fs = (parseFloat(fs) / (1024 * 1024)).toFixed(2) + ' mb'; 
        }else if(fs >= 1024){
            fs = (parseFloat(fs) / (1024)).toFixed(2) + ' kb';
        }else{
            fs = parseFloat(fs).toFixed(2) + ' b';
        }
        text = name + '(' + fs + ')';                   
        return text;
    }

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
                    url: "{!! route('admin.dambaochatluong.manaproof.checkuploadfile') !!}",
                    type: 'POST',                
                    data: {
                        filename: input.files[0].name,
                        size: uploadfilesize,
                        _token: "{{csrf_token()}}",
                    },
                    error: function(err) {

                    },            
                    success: function(data) {   
                        if(data == 1){
                            fileuploadok = true;
                            input.setAttribute("data-title", text);
                            $('#img_name').html(text);                            
                        }else{
                            var textout = '<span style="color:red;">' + "@lang('project/QualiAssurance/message.error.fileexisted')</span>";
                            fileuploadok = false;
                            var textthumb = '<a href="' + data + '"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/></svg></a>'
                            $('#img_name').html(textout);
                            $('#showthumnail').html(textthumb);
                        }
                    }
                });
            }             
        }
    }
        
    function loadhoatdong(opt){
        var datasearch = {
            linhvuc: $('#linhvuc_search').val(),
            year: $('#year_search').val(),
            hoatdong: '',
        };

        if(opt == 1){
            datasearch.hoatdong = $('#hoatdong_search').val();
        }

        if(datasearch.linhvuc != '' || (datasearch.hoatdong != '' && opt == 1)){            
            $.ajax({
                url: "{!! route('admin.dambaochatluong.manaproof.getHD') !!}",
                type: 'GET',
                data: datasearch,
                error: function(err) {

                },            
                success: function(data) {   
                    var el2 = $('#mcyc_search');
                    el2.empty();
                    el2.append($("<option></option>").attr("value", '').text("@lang('project/QualiAssurance/title.mcycau')"));

                    if(opt == 0){             
                        var el = $('#hoatdong_search');
                        el.empty();
                        el.append($("<option></option>").attr("value", '').text("@lang('project/QualiAssurance/title.lchd')"));

                        if(data != ''){
                            for (var i = 0; i < data.length; i++) {
                                el.append($("<option></option>").attr("value", data[i][0]).text(data[i][1]));                                                
                            }
                        }
                        if(firsthd < 2){                            
                            firsthd++;
                            el.val({{$minhchung->hoatdongnhom_id}});
                            el.trigger('change');
                        }

                    }else{                        
                        if(data != ''){
                            for (var i = 0; i < data.length; i++) {
                                el2.append($("<option></option>").attr("value", data[i][0]).text(data[i][1]));       
                            }

                            if(firsthd == 1){
                                var listsel = [
                                @foreach($minhchung->hoatdongnhom as $key => $value)
                                @if($value->id != $minhchung->hoatdongnhom_id)
                                {{$value->id}},
                                @endif
                                @endforeach
                                ];
                                el2.val(listsel);                                
                                el2.trigger('change');
                                firsthd = 2;
                            }
                        }
                    }
                }
            });
        }
    }
    
    $(function(){

        $('#linhvuc_search').on('change',function(){
            loadhoatdong(0);
        });

        $('#hoatdong_search').on('change',function(){
            loadhoatdong(1);
        });   

        $('#year_search').on('change',function(){
            loadhoatdong(0);
        });       

        // $('#ngay_ban_hanh').datetimepicker({
        //     viewMode: 'days',            
        //     format: 'DD/MM/YYYY',
        //     icons: {
        //         time: 'fa fa-clock-o',
        //         date: 'fa fa-calendar',
        //         up: 'fa fa-chevron-up',
        //         down: 'fa fa-chevron-down',
        //         previous: 'fa fa-chevron-left',
        //         next: 'fa fa-chevron-right',
        //     },
        // });

        flatpickr('#ngay_ban_hanh', {
            dateFormat: 'd-m-Y',
        });

        $(".select2").select2();

        $("#quanly_search").select2({
            ajax: {
                url: "{!! route('admin.dambaochatluong.manaproof.getQL') !!}",
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.result,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                }
            }            
        });
        $("#year_search").select2({
                       
        });
        $("#linhvuc_search").select2({     
            placeholder: "@lang('project/QualiAssurance/title.lvuc')",
        });
        $("#hoatdong_search").select2({    

        });
        @foreach($minhchung->tukhoa as $key => $value)
        $('#tukhoa').tagsinput('add', '{{$value->tk_name}}');
        @endforeach

        $("#quanly_search").val({{$minhchung->nguoi_quan_ly}});
        $("#quanly_search").trigger('change');
        $('#year_search').val({{$minhchung->ngay_ban_hanh != '' ? date('Y',strtotime($minhchung->ngay_ban_hanh)) : date('Y')}});
        $('#year_search').trigger('change');
        $('#linhvuc_search').val({{$minhchung->nhom_mc_sl_id}});
        $('#linhvuc_search').trigger('change');

        // $("#hoatdong_search").val({{ $minhchung->hoatdongnhom_id }});
        // $("#hoatdong_search").trigger('change');

        var te = gettextdropzone("{{$minhchung->ten_file}}",{{$minhchung->count_size}});
        $('#img_name').html(te);

    });  

</script>


@stop
