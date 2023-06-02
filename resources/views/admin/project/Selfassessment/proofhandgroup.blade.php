@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.xlmc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style type="text/css">
    .searchtext {
        padding: 13px 10px !important; 
    }    
    .block-flex{
        display: flex;
        justify-content: space-between;
    }
    .block-flex section{
        padding: 0 10px;
        width: 48%;
    }
    .block-group{
        align-items: center;
        margin: 10px 0 ;
    }
    .block-group label{
        margin-right:10px;
        flex: 1;
    }
    .block-group select{
        flex: 1;
    }
    .list-item{
        border: 2px solid green;
        padding: 10px 5px;
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
    }
    .list-item .text-content{
        width: 90%;
    }
    .list-item button{
       width: 4%;
    }
    .select2-container .select2-selection--single .select2-selection__clear{
        margin-right: -2rem;
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
<div class="block-flex">
    <section class="content-body">
        <div class="block-item">
            <h2>@lang('project/Selfassessment/title.xlmc')</h2>
            <div class="form-block">
                @if(isset($kehoach_baocao_search) && $kehoach_baocao_search != null)
                    <div class="block-group">
                        <label for="select-report">@lang('project/Selfassessment/title.baocao')</label>
                        <select name="report_id" id="select-report" class="form-control">
                            <option value="" hidden></option>
                            @foreach($kehoach_baocao as $khbc)
                                <option  
                                    @if($kehoach_baocao_search->id == $khbc->id)  
                                        selected
                                    @endif
                                 value="{{ $khbc->id }}">{{ $khbc->ten_bc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="block-group">
                        <label for="standard">@lang('project/Selfassessment/title.tctchi')</label>
                        <select name="standard_id" id="standard" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                            @foreach($kehoach_tieuchuan as $khtc)
                                <option 
                                    @if(isset(Request()->standard_id) && Request()->standard_id == $khtc->tieuchuan_id)  
                                        selected
                                    @endif
                                value="{{ $khtc->tieuchuan_id }}">@lang('project/Selfassessment/title.tc') {{ $khtc->stt }}: {{ $khtc->mo_ta }}</option>
                            @endforeach
                        </select>
                        <select name="criteria_id" id="criteria" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                                @foreach($tieuchi as $tchi)
                                    <option  
                                        @if(isset(Request()->criteria_id) && Request()->criteria_id == $tchi->id)
                                            selected
                                        @endif
                                     value="{{ $tchi->id }}">
                                     @lang('project/Selfassessment/title.tc') {{ $tchi->sttTC }}.{{ $tchi->stt }}: {{ $tchi->mo_ta }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="block-group">
                        <label for="select_mctt">@lang('project/Selfassessment/title.mctt')</label>
                        <select id="select_mctt" name="select_mctt[]" multiple="multiple" class="ml-2 mr-2">
                            <option value="" hidden></option>
                            @foreach($mctt as $mc)
                                <option 
                                    @if($minhchung_tt == $mc->id)
                                        selected
                                    @endif
                                 value="{{ $mc->id }}">
                                    {{ $mc->tieu_de }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="block-group">
                        <label for="select-report">@lang('project/Selfassessment/title.baocao')</label>
                        <select name="report_id" id="select-report" class="select-report form-control">
                            <option value="" hidden></option>
                            @foreach($kehoach_baocao as $khbc)
                                <option  value="{{ $khbc->id }}">{{ $khbc->ten_bc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="block-group">
                        <label for="standard">@lang('project/Selfassessment/title.tctchi')</label>
                        <select name="standard_id" id="standard" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                        </select>
                        <select name="criteria_id" id="criteria" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                        </select>
                    </div>
                    <div class="block-group">
                        <label for="select_mctt">@lang('project/Selfassessment/title.mccc')</label>
                        <select id="select_mctt" name="select_mctt[]" multiple="multiple" class="ml-2 mr-2 form-control">
                            <option value="" hidden></option>
                        </select>
                    </div>
                @endif


                <div class="block-group">
                    <label>@lang('project/Selfassessment/title.kmc')</label>
                    <span class="badge badge-primary kieu-minh-chung">@lang('project/Selfassessment/title.thsmcc')</span>
                </div>
                <div class="block-group">
                    <label for="name_minhchung">@lang('project/Selfassessment/title.tmc')</label>
                    <input type="text" placeholder="@lang('project/Selfassessment/title.tmc')" class="form-control" id="name_minhchung">
                </div>
                <div class="block-group">
                    <label for="trichyeu_mc">@lang('project/Selfassessment/title.trichyeu')</label>
                    <textarea class="form-control" placeholder="@lang('project/Selfassessment/title.tymc')" id="trichyeu_mc"></textarea>
                </div>
                <div class="block-group">
                    <label>@lang('project/Selfassessment/title.congkhai')</label>
                    <input type="checkbox" id="congkhai_checkbox" checked name="cong_khai">
                    <label for="congkhai_checkbox">@lang('project/Selfassessment/title.ckmc')</label>
                </div>
                <div class="">
                    <label>@lang('project/Selfassessment/title.dsmc')</label>
                    <div class="block-list-selected">
                        
                    </div>
                </div>
                <div class="block-group">
                    <button type="button" class="btn" id="btn-submit" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.hoanthanh')">
                        <i class="bi bi-save" style="font-size: 35px;color: #50cd89;"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="content-body">
        <h2>
            @lang('project/Selfassessment/title.tvmc')
        </h2>
        <div class="line"></div>
        <div class="form-standard">
            <h4>@lang('project/QualiAssurance/title.tkiem')</h4>
                <div class="container-fuild">
                    <div class="row mt-3 ">                                        
                        <div class="col-md-3">
                            <select class="form-control" id="add_tc">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-benchmark" onclick="add();return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.tmoi')">
                                <i class="bi bi-plus-square" style="font-size: 30px;color: red;"></i>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-benchmark" onclick="search();return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.timkiem')">
                                <i class="bi bi-search" style="font-size: 30px;color: #009ef7;"></i>
                            </button>
                        </div>                    
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_1">                    
                        <div class="col-md-2">
                            <select class="form-control h-2rem" id="nam_search">
                                <option value="">@lang('project/QualiAssurance/title.nam')</option>
                                @for($i = intVal(date('Y'));$i >= 1990 ;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control h-2rem" id="linhvuc_search" >
                                <option value="" hidden>@lang('project/QualiAssurance/title.lclv')</option>
                                @foreach ($linhvuc as $item)
                                    <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control h-2rem" id="hoatdong_search">
                                <option value="" hidden>@lang('project/QualiAssurance/title.lchd')</option>                            
                            </select>
                        </div>  
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(1);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>                                                      
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_2">                    
                        <label class="col-md-2 control-label">
                            @lang('project/QualiAssurance/title.tdmc')
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="search_2" style="height: 100%;" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(2);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_3">                    
                        <label class="col-md-2 control-label">
                            @lang('project/QualiAssurance/title.tyeu')
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="search_3" style="height: 100%;" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(3);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_4">                    
                        <label class="col-md-2 control-label">
                            @lang('project/QualiAssurance/title.sohieu')
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="search_4" style="height: 100%;" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(4);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_5">                    
                        <label class="col-md-2 control-label">
                            @lang('project/QualiAssurance/title.diachi')
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="search_5" style="height: 100%;" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(5);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3 div_search" id="div_tk_6">                    
                        <label class="col-md-2 control-label">
                            @lang('project/QualiAssurance/title.tukhoa')
                        </label>
                        <div class="col-md-4">
                            <input type="text" id="search_6" style="height: 100%;" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn" onclick="close_tc(6);return false;" >
                                &nbsp;<i class="bi bi-trash" aria-hidden="true" style="font-size: 25px;color: red;"></i>&nbsp;
                            </button>
                        </div>
                    </div>

                </div>
                <br/>
            <div class="form-group" hidden>
                <div class="row">
                    <div class="col-md-8">
                        <h3>@lang('project/QualiAssurance/title.dsmc')</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="tieude_search" id="tieude_search" class="form-control" style="height: 100%;" placeholder="@lang('project/QualiAssurance/title.locmctt')">
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                 <tr>
                    <th >@lang('project/QualiAssurance/title.tdmc')</th>
                    <th >@lang('project/QualiAssurance/title.hanhd')</th>
                 </tr>
                </thead>
                <tbody>  
                </tbody>                
            </table> 
        </div>
    </section>
</div>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>

@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script>
    var id_del = '';
    var cur_search = [];
    var list_search = [
        "@lang('project/QualiAssurance/title.nam')/@lang('project/QualiAssurance/title.lvuc')/@lang('project/QualiAssurance/title.hoatdong')",
        "@lang('project/QualiAssurance/title.tdmc')",   
        "@lang('project/QualiAssurance/title.tyeu')", 
        "@lang('project/QualiAssurance/title.sohieu')", 
        "@lang('project/QualiAssurance/title.diachi')",
        "@lang('project/QualiAssurance/title.tukhoa')"
    ];

    function add(){
        var choose = $('#add_tc').val();
        var idx = (choose - 1);
        if(!cur_search.includes(idx)){
            cur_search.push(idx);            
            fill_list_search();
            $('#div_tk_' + choose).show();
        }
    }

    function close_tc(id){
        $('#div_tk_' + id).hide();
        var idx = id - 1;

        if(cur_search.includes(idx)){
            for (var i = 0; i < cur_search.length; i++) {
                cur_search[i] == idx;
                cur_search.splice(i,1);
                break;
            }            
            fill_list_search();            
        }   
    }

    function fill_list_search(){
        var el = $('#add_tc');
        el.empty();
        for (var i = 0; i < list_search.length; i++) {
            if(!cur_search.includes(i)){
                el.append($("<option></option>").attr("value", (i + 1)).text(list_search[i]));
            }
        }
    }

    function deleteconfirm(id) {
        id_del = id;
        $('#delete_confirm_modal').modal('toggle');
    }

    function deletemc(){
        if(id_del > 0){
            $.ajax({
                url: "{!! route('admin.dambaochatluong.manaproof.deleteMC') !!}",
                type: 'POST',
                data:{
                    id: id_del,
                    _token: "{{csrf_token()}}"
                },
                error: function(err) {

                },            
                success: function(data) {                
                    if(data == 1){
                        alert("@lang('project/QualiAssurance/message.success.delete')");
                        table.ajax.reload();
                    }else{
                        alert("@lang('project/QualiAssurance/message.error.delete')");
                    }
                    $('#delete_confirm_modal').modal('hide');
                }
            });
        }
    }

    function getdatasearch(){
        var nam = $('#nam_search').val();
        var linhvuc = $('#linhvuc_search').val();
        var hoatdong = $('#hoatdong_search').val();
        var tieude = $('#tieude_search').val().trim();

        var tdmc = $('#search_2').val().trim();
        var tyeu = $('#search_3').val().trim();
        var sohieu = $('#search_4').val().trim();
        var diachi = $('#search_5').val().trim();
        var tukhoa = $('#search_6').val().trim();

        for (var i = 0; i < 6; i++) {
            if(!cur_search.includes(i)){
                switch(i){
                    case 0: nam = ''; linhvuc = ''; hoatdong = ''; break;
                    case 1: tdmc = ''; break;
                    case 2: tyeu = ''; break;
                    case 3: sohieu = ''; break;
                    case 4: diachi = ''; break;
                    case 5: tukhoa = ''; break;
                }
            }
        }

        return {
            nam: nam,
            linhvuc: linhvuc,
            hoatdong: hoatdong,
            tdmc:tdmc,
            tyeu:tyeu,
            sohieu:sohieu,
            diachi:diachi,
            tukhoa:tukhoa,
            _token : "{{ csrf_token()}}",
        };       
    }

    function search(){
        var tieude = $('#tieude_search').val();
        table.ajax.url("{!! route('admin.dambaochatluong.manaproof.viewProof') !!}?tieude=" + tieude).load();        
    }

    function loadhoatdong(linhvuc){
        $.ajax({
            url: "{!! route('admin.dambaochatluong.manaproof.getHD') !!}?linhvuc=" + linhvuc + '&year=' + $('#nam_search').val(),
            type: 'GET',
            error: function(err) {

            },            
            success: function(data) {                
                var el = $('#hoatdong_search');
                el.empty();
                el.append($("<option></option>").attr("value", '').text("@lang('project/QualiAssurance/title.lchd')"));
                if(data != ''){
                    for (var i = 0; i < data.length; i++) {
                        el.append($("<option></option>").attr("value", data[i][0]).text(data[i][1]));                                                
                    }
                }
            }
        });
    }
    
    $(function(){
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,            
            ajax: {
                url: "{!! route('admin.dambaochatluong.manaproof.viewProof') !!}",
                type: 'POST',
                cache: false,
                data: function (d) {
                    return $.extend(d,getdatasearch());
                },
            },
            order: [],  
            columns: [
                { data: 'tieu_de', name: 'tieu_de' },
                { data: 'checkBoxSelect', name: 'checkBoxSelect'  },
            ],           
        });

        $('#tieude_search').keyup(function(){            
            search();
        });

        $('#linhvuc_search').on('change',function(){
            loadhoatdong($('#linhvuc_search').val());
        });

        $('#year').on('change',function(){
            loadhoatdong($('#linhvuc_search').val());
        });

        $("#hoatdong_search").select2();
        $("#linhvuc_search").select2();
        $("#nam_search").select2();


        $('.div_search').hide();
        fill_list_search();

    });  
</script>



<script type="text/javascript">
    $('#select-report').on('change', function (e) {
        if($(this).val() != null && $(this).val() != ""){
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
        }
    });
    $('#standard').on('change', function (e) {
        if($(this).val() != null && $(this).val() != ""){
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
                            let title = `TC ${item.sttTC}.${item.stt}: ${item.mo_ta}`;
                            var option = new Option(title, item.id, true, true);
                            $("#criteria").append(option);
                        })
                    }
                    var option = new Option("", "", true, true);
                    $("#criteria").append(option).trigger('change');
                })
        }
    });

    $('#criteria').on('change', function (e) {
        if($(this).val() != null && $(this).val() != ""){
            var route = "{{ route('admin.tudanhgia.preparereport.searchMctt') }}" + "?id_criteria=" + $(this).val();
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data != undefined && data != null){
                        $("#select_mctt").empty();
                        data.forEach((item, index) => {
                            var option = new Option(item.tieu_de, item.id , true, true);
                            $("#select_mctt").append(option);
                            $('#select_mctt').val(null).trigger('change');
                        })
                    }
                })
        }
    });
        
    // select minh chứng từ thư viện
    var selectedMinhChung = [];
    $("#table").on("click", ".btn-select-item", function(){
        let check = false;
        selectedMinhChung.forEach(item => {
            if($(this).data('id') == item.id){
                check = true;
            }
        })
        if(!check){
            let infoMC = {
                'id' : $(this).data('id'),
                'content' : $(this).data('content'),
                'trichyeu'  : $(this).data('trichyeu')
            }
            selectedMinhChung.push(infoMC);
            updateUI();
            kieuMC();
        }
    })

    function updateUI() {
        $(".block-list-selected").empty();
        selectedMinhChung.forEach((item, index) => {
            let UI = ` 
                <div class="list-item">
                    <span class="text-success text-content">${item.content}</span>
                    <button type="button" class="btn btn-danger btn-remove p-0" data-id="${item.id}">
                        <ion-icon name="close-circle-outline"></ion-icon>
                    </button>
                </div>
             `;
            $(".block-list-selected").append(UI)
        })
    }

    function kieuMC(){
        if(selectedMinhChung.length == 1){
            $(".kieu-minh-chung").text("@lang('project/Selfassessment/title.mcdl')")
            $("#name_minhchung").val(selectedMinhChung[0].content);
            $("#trichyeu_mc").val(selectedMinhChung[0].trichyeu);
        }else if(selectedMinhChung.length > 1){
            $(".kieu-minh-chung").text("@lang('project/Selfassessment/title.mcgop')")
            $("#name_minhchung").val("");
            $("#trichyeu_mc").val("");
        }else{
            $(".kieu-minh-chung").text("@lang('project/Selfassessment/title.thsmcc')")
            $("#name_minhchung").val("");
            $("#trichyeu_mc").val("");
        }
    }

    $(".block-list-selected").on("click", ".btn-remove", function() {
        let index = undefined;
        for(let i = 0; i < selectedMinhChung.length ; i++){
            if(selectedMinhChung[i].id == $(this).attr("data-id")){
                index = i;
                break;
            }
        }
        if(index != undefined){
            selectedMinhChung.splice(index, 1)
        }
        updateUI()
        kieuMC()
    })  



    // submit form
    $("#btn-submit").on("click", function() {
        let baocao_id = $("#select-report").val();
        let tieuchuan = $("#standard").val();
        let tieuchi = $("#criteria").val();
        let mctthieu = $("#select_mctt").val();
        let tenminhchung = $("#name_minhchung").val();
        let trichyeu = $("#trichyeu_mc").val();
        let congkhai;
        if ($('#congkhai_checkbox').is(':checked')) {
            congkhai = "Y"
        }else{
            congkhai = "N"
        }
        let hoatdongId = $("#hoatdong_search").val();
        let listMinhChung = selectedMinhChung;

        if(tenminhchung != "" && trichyeu != "" && listMinhChung.length > 0){
            let data = {
                baocao_id, tieuchuan, tieuchi, mctthieu, tenminhchung,
                trichyeu, congkhai, listMinhChung, hoatdongId
            }

            var route = "{{ route('admin.tudanhgia.preparereport.gopMinhChung') }}";
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
                        @if(isset($kehoach_baocao_search) && $kehoach_baocao_search != null)
                            location.replace("{{ route('admin.tudanhgia.preparereport.proofCompare') }}" 
                                + "?report_id=" + "{{ Request()->report_id }}" 
                                + "&standard_id=" + "{{ Request()->standard_id }}" 
                                + "&criteria_id=" + "{{ Request()->criteria_id }}")

                        @else 
                            if(data.status == true){
                                alert(data.message)
                                location.replace("{{ route('admin.tudanhgia.preparereport.proofHandling') }}")
                            }
                        @endif
                    })
        }else{
            alert("@lang('project/Selfassessment/title.thieutt')")
        }
         
    })





    

    $(function(){
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
        $("#select_mctt").select2({
            placeholder: "@lang('project/Selfassessment/title.lcmctt')",
            allowClear: true
        })
    });
</script>
@stop

