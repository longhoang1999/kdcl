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
    p,strong,br,hr,b,small,i,u,em,mark,del,ins,sub,sup{
        word-wrap: break-word;
    }
    img{
        max-width: 100%;
        height: auto;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.hoantbc')

@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
    
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

                            <strong>@lang('project/Selfassessment/title.tieuchuan') {{isset($keHoachTieuChuan->tieuChuan->stt)?$keHoachTieuChuan->tieuChuan->stt : ''  }}
                                : {{isset($keHoachTieuChuan->tieuChuan->mo_ta)?$keHoachTieuChuan->tieuChuan->mo_ta : ''  }}</strong>

                            @if(isset($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan))

                                @if($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'csgd')

                                    @include("admin.project.Selfassessment.hoanthien.tieuchi-csdt")
                                @else
                                    <p>{!! isset($keHoachTieuChuan->baoCaoTieuChuan->modau) ? $keHoachTieuChuan->baoCaoTieuChuan->modau : "" !!}</p>
                                   @include("admin.project.Selfassessment.hoanthien.tieuchi-ctdt")
                                    <div class="m-b-md m-l-md">
                                        <b>@lang('project/Selfassessment/title.kltc') {{ $keHoachTieuChuan->tieuChuan->stt }}: </b>
                                        {!! isset($keHoachTieuChuan->baoCaoTieuChuan->ketluan) ? $keHoachTieuChuan->baoCaoTieuChuan->ketluan : "" !!}
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
                        @include("admin.project.Database.cosogiaoducexp")
                    @elseif($keHoachBaoCaoDetail->boTieuChuan->loai_tieuchuan == 'ctdt')
                        @include("admin.project.Database.chuongtrinhdtexp")
                    @endif
                @endif
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

    exportHTML();
    
</script>
@stop

