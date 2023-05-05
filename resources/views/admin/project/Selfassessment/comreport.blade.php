@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.nhanxetbc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<style>
    .form-control{
        height: 34px;
        appearance: auto !important;
    }
    .fa, .far, .fas {
        font-family: "Font Awesome 5 Free" !important;
    }
</style>
@stop

@section('title_page')
     @lang('project/Selfassessment/title.nhanxetbc')
@stop

@section('content')
<section class="content indexpage pr-3 pl-3">
<section class="content-body">
    <h2>
        @lang('project/Selfassessment/title.nhanxetbc')
    </h2>
    <div class="line"></div><br/>
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <div class="container-fuild">
                    <h4 class="h4-left">@lang('project/Selfassessment/title.baocaocnx')</h4><br/>
                    <table class="table table-striped table-bordered" id="table" width="100%">
                        <thead>
                            <th width="50"></th>
                            <th>@lang('project/Selfassessment/title.tenbc')</th>
                            <th>@lang('project/Selfassessment/title.loaitieuchuan')</th>
                            <th>@lang('project/Selfassessment/title.nam')</th>
                        </thead>
                        <tbody class="tbodys">                        
                        </tbody>                
                    </table> 
                </div>
            </div>
            <div class="col-md-7">       
                <div id="div_showbc" style="margin-left: 20px; padding-bottom: 22px;"></div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Tiêu chuẩn : </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
<script>

    function showhidetieuchi(id){
        if($('#btn_tieuchuan_' + id).text() == '-'){
            $('#div_tieuchi_' + id).hide();
            $('#btn_tieuchuan_' + id).text('+');
        }else{
            $('#div_tieuchi_' + id).show();
            $('#btn_tieuchuan_' + id).text('-');
        }
    }

    function selectBC(dat){    
        var textout = '<br/><h4 id="div_showbcs" style="text-align: center;width: 100%;">' + dat.ten_bc + '</h4><br/>';
        var id_khbc = dat.id;
        var name_bc = dat.ten_bc;
        $.ajax({
            url: "{!! route('admin.tudanhgia.commentreport.data') !!}?id=" + dat.id,
            type: 'GET',
            error: function(err) {

            },            
            success: function(data) {

                var texto = '';
                var texto2;
                texto += '';
                var css_color;
                var name_trangthai;
                var css_trangthai = 'css_action_1';
                if(data.tieuchuan_tieuchi == 0){
                    texto += '<div class="alert alert-warning">' + "@lang('project/Selfassessment/message.alert.kocobctc')" + '</div>';
                }else{
                    let temp = 0;
                    texto += data.phan1 ;
                    texto += data.phan2 ;
                    var check = false;
                    var  ccb = '' + "@lang('project/Selfassessment/title.chuacongbo')";
                    var css_color_tt = 'css_color_organe';
                    data.tieuchuan_tieuchi.forEach((value)=>{
                        console.log(value)
                        if(value.baoCaoTieuChuan != undefined){
                            check = true;    
                            if(value.baoCaoTieuChuan.trang_thai_bctc){
                                if(value.baoCaoTieuChuan.trang_thai_bctc == 'congbo'){
                                    name_trangthai = '<i class="fas fa-eye"></i>' + "@lang('project/Selfassessment/title.xemvnx')";
                                    css_color = 'css_color_blue';
                                }else if(value.baoCaoTieuChuan.trang_thai_bctc == 'xacnhan'){
                                    name_trangthai = '' + "Đã xác nhận";
                                    css_color = 'css_color_organe';
                                }else{
                                    name_trangthai = '' + "@lang('project/Selfassessment/title.chuacongbo')";
                                    css_color = 'css_color_organe';
                                } 
                            }
                                
                            if(value.stt_tc){
                                texto += '<p class="css_p">'+ '<button class="btn btn-success button_css" id="btn_tieuchuan_'+value.id+'" onclick="showhidetieuchi('+value.id+');return false;"> + </button>' +'<span class="label label-warning span_css"><i class="fas fa-file" style="font-size: 25px;color: #e56f3e;"></i></span>' + 
                                "<span> @lang('project/Selfassessment/title.tc')";
                            
                                if(value.baoCaoTieuChuan.trang_thai_bctc == 'congbo'){  
                                    texto += value.stt_tc + ": &nbsp; </span>" + '<a href="" style="width: 46%;">' + value.mo_ta + '</a>' + `<a href="{{route('admin.tudanhgia.commentreport.viewReport')}}?id=${value.id_kh_baocao}&tieuchuan_id=${value.tieuchuan_id}" class="${css_trangthai } ${css_color}">` +name_trangthai+ '</a>'+'</br>'+'</p>';
                                }else{
                                    texto += value.stt_tc + ": &nbsp; </span>" + '<a href="" style="width: 46%;">' + value.mo_ta + '</a>' + `<a href="#" class="${css_trangthai } ${css_color}">` +name_trangthai+ '</a>'+'</br>'+'</p>';
                                }
                                texto += '<div id="div_tieuchi_' + value.id +'" style="display:none">';
                                let dem = value.stt_tc;
                                let dem2 = 1;
                                for(var i = 0; i<value.tieuchi.length;i++){
                                    texto += '<p class="tieuchi_css">'+'<span><i class="far fa-calendar-check"></i></span>'+ '<b>'+`&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;${dem} `+'.'+`${dem2++}`+value.tieuchi[i].mo_ta+'</b>'+'</p>';    
                                }
                                 
                            }
                            
                        }else{
                           check = true;
                           texto += '<p class="css_p">'+ '<button class="btn btn-success button_css" id="btn_tieuchuan_'+value.id+'" onclick="showhidetieuchi('+value.id+');return false;"> + </button>' +'<span class="label label-warning span_css"><i class="fas fa-file" style="font-size: 25px;color: #e56f3e;"></i></span>' + 
                                "<span> @lang('project/Selfassessment/title.tc')";
                            texto += value.stt_tc + ": &nbsp; </span>" + '<a href="">' + value.mo_ta + '</a>' + `<a href="#" class="${css_trangthai } ${css_color_tt}">` +ccb+ '</a>'+'</br>'+'</p>';
                            texto += '<div id="div_tieuchi_' + value.id +'" style="display:none">';
                                let dem = value.stt_tc;
                                let dem2 = 1;
                                for(var i = 0; i<value.tieuchi.length;i++){
                                    texto += '<p class="tieuchi_css">'+'<span><i class="far fa-calendar-check"></i></span>'+ '<b>'+`&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;${dem} `+'.'+`${dem2++}`+value.tieuchi[i].mo_ta+'</b>'+'</p>';    
                                }

                        }    
                        texto += '</div>'; 
                    });
                    if(!check){
                        texto += '<div class="alert alert-warning">' + "@lang('project/Selfassessment/message.alert.kocobctc')" + '</div>';
                    }
                    texto += data.phan3;
                }
                $("#div_showbc").empty();
                $('#div_showbc').html(textout);    
                $('#div_showbc').append(texto + '<br/>');
                $('#div_showbc').css({'background' : 'white','box-shadow' : '0 0 12px #ababab'});                
            }
        });
    }


    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching:false,
            ajax: "{!! route('admin.tudanhgia.commentreport.data') !!}",
            order: [],  
            columns: [
                { data: 'actions', orderable: false, searchable: false },
                { data: 'ten_bc', name: 'ten_bc' },
                { data: 'loai_tieuchuan', name: 'loai_tieuchuan' },
                { data: 'nam', name: 'nam' },
            ],           
        });

        $('#table tbody').on('click', 'tr', function () {            
            var data = table.row( this ).data();    
            if(data != undefined){
                $('#selectbc_' + data.id).prop('checked', true);
                selectBC(data);
            }   
        });
    });

</script>
@stop











