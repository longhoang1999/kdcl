@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
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
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.bctdg')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <h2>
        @lang('project/Selfassessment/title.htkhbc')
    </h2>
    <div class="line"></div><br/>
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <div class="container-fuild">
                    <h4 class="h4-left">@lang('project/Selfassessment/title.bccv')</h4><br/>
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
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
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
         // console.log(dat)
        $.ajax({
            url: "{!! route('admin.tudanhgia.detailedplanning.data') !!}?id=" + dat.id,
            type: 'GET',
            error: function(err) {

            },            
            
            success: function(data) {
                // console.log(data)
                var texto = '<li class="dd-item">' + data.solieutonghop + '</li>';
                var texto2;
                texto += '<li class="dd-item">' + data.cosodulieu + '</li>';
                if(data.tieuchuan_tieuchi == 0){
                    texto += '<div class="alert alert-warning">' + "@lang('project/Selfassessment/message.alert.kocobctc')" + '</div>';
                }else{
                    let temp = 0;
                  
                        texto += data.phan1 ;
                    
                    texto += data.phan2 ;
                    var name_trangthai = '';
                    var testm = '';
                    data.tieuchuan_tieuchi.forEach((value)=>{

                        if(value.mo_ta != null){
                            var css_trangthai = 'css_action_1';
                            var css_color;
                            if(value.baoCaoTieuChuan != undefined){
                                if(value.baoCaoTieuChuan.trang_thai_bctc == 'nhanxet'){
                                 
                                    name_trangthai = '<i class="fas fa-pen"></i>' + "@lang('project/Selfassessment/title.suabaocao')";
                                    css_color = 'css_color_organe';

                                    testm = `<a href="{{ route('admin.tudanhgia.detailedplanning.show')}}?id=${value.id_kh_baocao}&tieuchuan_id=${value.tieuchuan_id} " class="${css_trangthai } ${css_color}">`+name_trangthai+ '</a>';
                                    
                                }else if(value.baoCaoTieuChuan.trang_thai_bctc == 'dangsua'){
                                  
                                    name_trangthai = '<i class="fas fa-pen"></i>' + "@lang('project/Selfassessment/title.suabaocao')";
                                    css_color = 'css_color_organe';

                                    testm =`<a href="{{ route('admin.tudanhgia.detailedplanning.show')}}?id=${value.id_kh_baocao}&tieuchuan_id=${value.tieuchuan_id} " class="${css_trangthai } ${css_color}">`+name_trangthai+ '</a>';
                                   
                                }
                                else{
                                    name_trangthai = '<i class="fas fa-eye"></i>' + "@lang('project/Selfassessment/title.xembaocao')";
                                    css_color = 'css_color_blue';

                                    testm =`<a href="{{ route('admin.tudanhgia.detailedplanning.show')}}?id=${value.id_kh_baocao}&tieuchuan_id=${value.tieuchuan_id} " class="${css_trangthai } ${css_color}">`+name_trangthai+ '</a>';
                                } 
                            }else{
                            
                                name_trangthai = '<i class="fas fa-pen"></i>' + "@lang('project/Selfassessment/title.vietbc')"
                                css_color = 'css_color_organe';

                                testm =`<a href="{{ route('admin.tudanhgia.detailedplanning.show')}}?id=${value.id_kh_baocao}&tieuchuan_id=${value.tieuchuan_id} " class="${css_trangthai } ${css_color}">`+name_trangthai+ '</a>';
                           
                            }
                                  
                            // console.log(value.id_kh_baocao);
                            texto += '<p class="css_p">'+ '<button class="btn btn-default button_css" id="btn_tieuchuan_'+value.id+'" onclick="showhidetieuchi('+value.id+');return false;"> + </button>' +'<span class="label label-warning span_css"><i class="fas fa-file" style="font-size: 25px;color: #e56f3e;"></i></span>' + 
                            "<span> @lang('project/Selfassessment/title.tc')" +  
                            value.stt_tc + ": &nbsp; </span>" + '<a href="" style="width: 50%;",>' + value.mo_ta + '</a>' + testm +'</br>'+'</p>';

                            texto += '<div id="div_tieuchi_' + value.id +'" style="display:none">';
                            let dem = value.stt_tc;
                            let dem2 = 1;
                            for(var i = 0; i<value.tieuchi.length;i++){
                                texto += '<p class="tieuchi_css">'+'<span><i class="far fa-calendar-check"></i></span>'+ '<b>'+`&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;${dem} `+'.'+`${dem2++}`+'&nbsp;'+value.tieuchi[i].mo_ta+'</b>'+'</p>';    
                            }
                            texto += '</div>';
                        }           

                    })
                 
                    texto += data.phan3;
                 
                }
                $("#div_showbc").empty();
                $('#div_showbc').html(textout);    
                $('#div_showbc').append(texto + '<br/>');
                // $('.css_p').append(texto2);
                // console.log(data);
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
            ajax: "{!! route('admin.tudanhgia.detailedplanning.data') !!}",
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
            //console.log(data)    
            if(data != undefined){
                $('#selectbc_' + data.id).prop('checked', true);
                selectBC(data);
                // console.log(data)
            }   
        });
    });

</script>
@stop











