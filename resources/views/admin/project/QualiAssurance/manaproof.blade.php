@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.qlmc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style type="text/css">
.searchtext {
    padding: 13px 10px !important; 
}    

</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.qlmc')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    @if(!Sentinel::inRole('khac'))
    <div class="form-standard">
        <h4>@lang('project/QualiAssurance/title.tkiem')</h4>
            <div class="container-fuild pl-5 ">
                <div class="row mt-3 ">                                        
                    <div class="col-md-3">
                        <select class="form-control " id="add_tc">
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-benchmark" onclick="add();return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.themtieuchi')">
                            <i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;"></i>
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-benchmark" onclick="search();return false;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.timkiem')">
                            <i class="bi bi-search" style="font-size: 35px;color: #009ef7;"></i>
                        </button>
                    </div>                    
                </div>

                <div class="row mt-3 div_search" id="div_tk_1">                    
                    <div class="col-md-2">
                        <select class="form-control " id="nam_search">
                            <option value=""></option>
                            @for($i = intVal(date('Y'));$i >= 1990 ;$i--)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control " id="linhvuc_search" >
                            <option value=""></option>
                            @foreach ($linhvuc as $item)
                                <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control " id="hoatdong_search">
                            <option value=""></option>
                        </select>
                    </div>  
                    <div class="col-md-2">
                        <button class="btn" onclick="close_tc(1);return false;" >
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
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
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
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
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
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
                        <button class="btn " onclick="close_tc(4);return false;" >
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
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
                        <button class="btn " onclick="close_tc(5);return false;" >
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
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
                            &nbsp;<i class="bi bi-trash" style="font-size: 35px;color: red;" aria-hidden="true"></i>&nbsp;
                        </button>
                    </div>
                </div>

            </div>
            <br/>
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <h3>@lang('project/QualiAssurance/title.dsmc')</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-5">
                    <input type="text" name="tieude_search" id="tieude_search" class="form-control" style="height: 100%;" placeholder="@lang('project/QualiAssurance/title.locmctt')">
                </div>
                @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                <div class="col-md-1" style="text-align: right;">                
                    <a href="{{ route('admin.dambaochatluong.manaproof.newProof') }}" class="btn btn-benchmark" style="width: 100%;" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.tmoi')">
                        <i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;"></i>
                    </a>
                </div>
                @endif
                <div class="col-md-1">                
                    <a class="btn btn-benchmark" style="width: 100%;" href="{{route('admin.dambaochatluong.manaproof.exportProof')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                        <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/QualiAssurance/title.tdmc')</th>
                <th >@lang('project/QualiAssurance/title.sohieu')</th>
                <th >@lang('project/QualiAssurance/title.ngaybh')</th>
                <th >@lang('project/QualiAssurance/title.noibh')</th>
                <th >@lang('project/QualiAssurance/title.dvql')</th>
                <th >@lang('project/QualiAssurance/title.loaimc')</th>
                <th >@lang('project/QualiAssurance/title.tinhtrang')</th>
                <th >@lang('project/QualiAssurance/title.hanhd')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
    @endif

</section>
<!-- Modal -->
<div class="modal fade" id="delete_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('project/QualiAssurance/title.xoamc')</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>@lang('project/QualiAssurance/message.confirm.delete')</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/QualiAssurance/title.huy')</button>
          <button type="button" onclick="deletemc();return false;" class="btn btn-primary">@lang('project/QualiAssurance/title.xoa')</button>
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
<script>
    var id_del = '';
    var cur_search = [];
    var list_search = ["@lang('project/QualiAssurance/title.nam')/@lang('project/QualiAssurance/title.lvuc')/@lang('project/QualiAssurance/title.hoatdong')",
"@lang('project/QualiAssurance/title.tdmc')",   
"@lang('project/QualiAssurance/title.tyeu')", 
"@lang('project/QualiAssurance/title.sohieu')", 
"@lang('project/QualiAssurance/title.diachi')",
"@lang('project/QualiAssurance/title.tukhoa')",];

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
            console.log(id_del)
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
                console.log(data)                
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
                { data: 'sohieu', name: 'sohieu' },
                { data: 'ngayBan_hanh', name: 'ngayBanhanh' },
                { data: 'noi_banhanh', name: 'noi_banhanh' },
                { data: 'ten_donvi', name: 'ten_donvi' },
                { data: 'cong_khai_text', name: 'cong_khai_text'},
                { data: 'tinhTrang', name: 'tinhTrang' },
                { data: 'actions', orderable: false, searchable: false ,className: 'action'},
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

        $("#linhvuc_search").select2({
            placeholder: "@lang('project/QualiAssurance/title.lclv')",
            allowClear: false
        })
        
        $("#hoatdong_search").select2({
            placeholder: "@lang('project/QualiAssurance/title.lchd')",
            allowClear: false
        })
        
        $("#nam_search").select2({
            placeholder: "@lang('project/QualiAssurance/title.nam')",
            allowClear: false
        })

        $('.div_search').hide();
        fill_list_search();

    });  
</script>

@stop

