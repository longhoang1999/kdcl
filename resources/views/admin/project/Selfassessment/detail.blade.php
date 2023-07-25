@extends('admin/layouts/default')
@section('title')
    @lang('project/Selfassessment/title.hoantbc')
@parent
@stop

@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiAssurance.css') }}">
<style type="text/css">
    .show_mcg{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .content-body{
        width: 93%;
    margin: auto;
    box-shadow: 0 1px 1px -1px rgb(0 0 0 / 34%), 0 0 6px 0 rgb(0 0 0 / 14%);
    background-color: #ffffff;
    padding: 10px 10px 20px 10px;
    }
    .table td:first-child, .table th:first-child, .table tr:first-child {
        padding-left: 10px;
    }
    .table td:last-child, .table th:last-child, .table tr:last-child {
        padding-right: 6px;
    }
    .pull-right{
        display: flex;
    margin-bottom: 32px;
    }
    div  {
        font-size: 16px ;
    }
    table,tr,td{
        border: solid 1px lightblue;
    }
    td{
        text-align: center;
    }
    
    .table-borderless{
        border: 1px solid;
     }
    .table-borderless tr,td{
        border: 1px solid;
     } 
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.hoantbc')
    
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
        <div class="content-body">
            <div class="text-center">
                <h1>{{$title}}</h1>
                <ul class="d-flex" style="list-style: none;">
                    <li><a href="">@lang('project/Selfassessment/title.trangchu')</a></li>/
                    <li>@lang('project/Selfassessment/title.hoanthanhbc')</li>/
                    <li>{{$title}}</li>
                </ul>
            </div>
            <div class="row show_mcg">
                <div class="col-lg-11 col-lg-offset-1">
                    <div class="ibox" id="htmlContent">
                        @if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
                        <div class="pull-right m-b-lg">
                            <button class="btn btn-primary" onclick="exportHTML();return false;">
                                <i class="fa fa-file-alt"></i> @lang('project/Selfassessment/title.taifile')
                            </button>
    
                            @if (Sentinel::inRole('admin') || Sentinel::inRole('operator') || $keHoachBaoCaoDetail->ns_phutrach == Sentinel::getUser()->id)
                            <button class="btn btn-info" onclick="exportminhchung()">
                                <i class="fa fa-file-alt"></i> @lang('project/Selfassessment/title.xuatminhc')
                            </button>
                            <form action="{{route('admin.tudanhgia.completionreport.encode')}}" method="POST">
                                <input type="text" hidden name="id_khbc" value="{{$id_khbc}}">
                                @csrf
                                <button class="btn btn-warning" id="traSoatMinhChung" type="submit">
                                    <i class="fa fa-atlas"></i> @lang('project/Selfassessment/title.mahoamc')
                                </button>
                            </form>
                            @endif
                            @if($keHoachBaoCaoDetail->trang_thai == 'completed')
                                <a class="btn btn-danger" id="moLaiKeHoach" d-id="{{$keHoachBaoCaoDetail->id}}">
                                    <i class="fa fa-retweet"></i> @lang('project/Selfassessment/title.molai')
                                </a>
                            @else
                                <a class="btn btn-success" id="xacNhanHoanThanh" d-id="{{$keHoachBaoCaoDetail->id}}">
                                    <i class="fa fa-clipboard-check"></i> @lang('project/Selfassessment/title.hoanthanh')
                                </a>
                            @endif
    
                        </div>
                        @endif
                        <div id="div_main_content">
                            <div class="row text-center article-title">
                                <div class="col-sm-12">
                                    <h2 class="text-muted">
                                        {{ $tencsgd }}
                                    </h2>
                                </div>
    
                                <div class="col-sm-4 col-sm-offset-4 text-center m-auto">
                                    <hr>
                                </div>
    
                                <div class="col-sm-12 h3">
                                    {{ $keHoachBaoCaoDetail->ten_bc }} <br/>
                                    <h4>@lang('project/Selfassessment/title.theotcdg')</h4>
                                </div>
    
                                <div class="col-sm-12 m-t-lg">
                                    <p>
                                        @lang('project/Selfassessment/title.tinhtp')
                                    </p>
                                </div>
                            </div>
                    
                            <div class="row  m-t-lg">
                                @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))
                                    @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                        <div class="col-sm-12">
                                            <div class="h4 text-center">@lang('project/Selfassessment/title.p1khaiq')</div>
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <div class="h4 text-center">@lang('project/Selfassessment/title.p1hsvcsgd')</div>
                                        </div>
                                    @endif
                                @endif
    
                                <div class="col-sm-12">
                                    @if(isset($keHoachBaoCaoDetail->keHoachChung->baoCaoChung))
                                        {!! $keHoachBaoCaoDetail->keHoachChung->baoCaoChung->text !!}
                                    @endif
                                </div>
                            </div>
                   
                            <div class="row m-t-lg">
                                @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))
                                    @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                        <div class="col-sm-12 m-t-lg">
                                            <div class="h4 text-center">@lang('project/Selfassessment/title.p2dgtc')</div>
                                        </div>
                                    @else
                                        <div class="col-sm-12 m-t-lg">
                                            <div class="h4 text-center">@lang('project/Selfassessment/title.p2csgd')</div>
                                        </div>
                                    @endif
                                @endif
                                    
                                <div class="col-sm-12">
                                    @foreach($keHoachBaoCaoDetail->keHoachTieuChuanList as $keHoachTieuChuan)
                                        @continue(!$keHoachTieuChuan->baoCaoTieuChuan)
                                        <strong>@lang('project/Selfassessment/title.tieuchuan') {{isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt : ''  }}
                                            : {{isset($keHoachTieuChuan->tieuChuan->mo_ta)?$keHoachTieuChuan->tieuChuan->mo_ta : ''  }}</strong>
                                        @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))

                                            @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'csgd')

                                                @include("admin.project.Selfassessment.hoanthien.tieuchi-csdt")
                                            @else
                                            
                                                <p>{!! $keHoachTieuChuan->baoCaoTieuChuan->modau !!}</p>
                                               @include("admin.project.Selfassessment.hoanthien.tieuchi-ctdt")
                                                <div class="m-b-md m-l-md">
                                                    <b>@lang('project/Selfassessment/title.kltc') {{ $keHoachTieuChuan->tieuChuan->stt }}: </b>
                                                    {!! $keHoachTieuChuan->baoCaoTieuChuan->ketluan !!}
                                                </div>
                                            @endif
                                        @endif
    
                                        
                                    @endforeach
                                </div>

                            </div>
                            @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))
                                @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                    <div class="row m-t-lg">
                                        <div class="col-sm-12 m-t-lg">
                                            <div class="h4 text-center">@lang('project/Selfassessment/title.phan3lama')</div>
                                        </div>
        
                                        <div class="col-sm-12">
                                            @if(isset($keHoachBaoCaoDetail->keHoachChung->baoCaoChung))
                                                {!! $keHoachBaoCaoDetail->keHoachChung->baoCaoChung->ketluan !!}
                                            @endif
                                        </div>
                                    </div>
        
                                    <div class="row m-t-md">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered" id="table">
                                                <tr>
                                                    <td style="width:50%"></td>
                                                    <td class="text-center">
                                                        <p> @lang('project/Selfassessment/title.bacham')</p>
                                                        <p class="font-bold">@lang('project/Selfassessment/title.thutruong')</p>
                                                        <p><i>@lang('project/Selfassessment/title.khtdd')</i></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))
                                @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'csgd')
                                    @include("admin.project.Selfassessment.hoanthien.phuluc7-csdt")
                                @elseif($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                    @include("admin.project.Selfassessment.hoanthien.phuluc7")
                                @endif
                            @endif
    
                            <div class="row m-t-lg">
                                <div class="col-sm-12">
                                    <div class="h4 font-bold mb-sm">
                                        @lang('project/Selfassessment/title.pl8')
                                    </div>
                                </div>
                            </div>
                            @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))
                                @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'csgd')
                                    @include("admin.project.Database.cosogiaoduc")
                                @elseif($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                                    @include("admin.project.Database.chuongtrinhdt")
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @include("admin.project.ExternalReview.include.phuluc10")
            </div>
    <!-- modal -->
            <div class="modal moadal_hoanthanh" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">@lang('project/Selfassessment/title.xnht')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="add_conten">
                        
                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    <a href="{{route('admin.tudanhgia.completionreport.index')}}" class="btn btn-primary submit_ht">@lang('project/Selfassessment/title.xacnhan')</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('project/Selfassessment/title.boqua')</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
<!-- page trang ở đây -->

    
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
</section>
@stop



@section('footer_scripts')

<script type="text/javascript">
    function exportHTML(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>";

       var footer = "</body></html>";
       var data = document.getElementById("div_main_content").innerHTML;
       
       var sourceHTML = header;

        // sourceHTML += "{{'<head><meta charset="utf-8"><title>' . $title . '</title></head><body>' }}";
        sourceHTML += data;
        // sourceHTML += footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'document.docx';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }

    function exportminhchung(){
       var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>";

       var footer = "</body></html>";
       var data = document.getElementById("phuluc10").innerHTML;
       
       var sourceHTML = header;

        // sourceHTML += "{{'<head><meta charset="utf-8"><title>' . $title . '</title></head><body>' }}";
        sourceHTML += data;
        // sourceHTML += footer;
       
       var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
       var fileDownload = document.createElement("a");
       document.body.appendChild(fileDownload);
       fileDownload.href = source;
       fileDownload.download = 'document.docx';
       fileDownload.click();
       document.body.removeChild(fileDownload);
    }
    $('.show_mcg').on('click','.mcGop',function(){

            let id = $(this).attr('id').split('_')[1];
            window.location= "{!! route('admin.tudanhgia.preparereport.viewmcgop',0)!!}"+id;
    }); 

    $('.show_mcg').on('click','.mc',function(){
            let id = $(this).attr('id').split('_')[1];
            window.location= "{!! route('admin.dambaochatluong.manaproof.showProof',0) !!}"+id;
    });
    $('#xacNhanHoanThanh').on('click',function(){
        let id_khbc = $(this).attr('d-id');
        $('.add_conten').html(`<p>"@lang('project/Selfassessment/title.ktldxn')"</p>`);
        $('.moadal_hoanthanh').modal('show');

        $('.submit_ht').on('click',function(){
            $.ajax({
                url: "{{route('admin.tudanhgia.completionreport.exit_hoanthanh')}}",
                type: "POST",
                data:{
                    id_khbc : id_khbc,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {
                },

                success: function(data) {

                },
            })
        })
        
    })

    $('#moLaiKeHoach').on('click',function(){
        let id_khbc = $(this).attr('d-id');
        $('.add_conten').html(`<p>"@lang('project/Selfassessment/title.kkhmt')"</p>`);
        $('.moadal_hoanthanh').modal('show');
        $('.submit_ht').on('click',function(){
            $.ajax({
                url: "{{route('admin.tudanhgia.completionreport.exit_molai')}}",
                type: "POST",
                data:{
                    id_khbc : id_khbc,
                    _token: '{{ csrf_token() }}',
                },    
                error: function(err) {

                },

                success: function(data) {
                 
                },
            })
        })
           
    })

    $(document).ready(function() {
        
        $("a[d-id]").each(function() {
          var dId = $(this).attr("d-id");
          $('.addminhchunggop_' + dId).attr("id", "addminhchunggop_" + dId);
        });
    });



    $('.edit_input').on('change',function() {
        let val = $(this).val();
        let key = $(this).attr('data_key');
         $.ajax({
            url: "{!! route('admin.tudanhgia.database.save_data_csgd') !!}",
            type: "POST",
            data:{
                val : val,
                key : key,
                ikhbc : {{$idkhbc}},
                _token: '{{ csrf_token() }}'
            },    
            error: function(err) {

            },

            success: function(data) {
                if(data ==1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Bạn đã cập nhật thành công.',
                    });
                }else{
                    Swal.fire({
                        icon: 'Warning',
                        title: 'Thất bại!',
                        text: 'Bạn đã cập nhật thất bại.',
                    });
                }
            },
        })
    })

    @if($check != "sua")
        $('.edit_input').prop('disabled', true);
        $('.radiobox').prop('disabled', true);
    @else 
        $("#save_contenty").on('change','.radiobox',function(){
        let key = $(this).attr('data_key');
        let val = $(this).val();
        
        $.ajax({
                url: "{{route('admin.tudanhgia.database.apiNoiDungThem')}}",
                type: "GET",
                data:{
                    id : {{$idkhbc}},
                    key : key,
                    val : val,
                },    
                error: function(err) {
                },

                success: function(data) {
                    console.log(data);
                    if(data ==1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: 'Bạn đã cập nhật thành công.',
                        });
                    }else{
                        Swal.fire({
                            icon: 'Warning',
                            title: 'Thất bại!',
                            text: 'Bạn đã cập nhật thất bại.',
                        });
                    }
                },
            })
        })
    @endif
</script>
@stop

