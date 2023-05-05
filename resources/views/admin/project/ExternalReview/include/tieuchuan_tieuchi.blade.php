<style>
  .md-skin .wrapper-content {
            padding-right: 0px !important; 
        }
        body.fixed-nav #wrapper .navbar-static-side, body.fixed-nav #wrapper #page-wrapper {
            margin-top: 60px;
            padding-right: 0px !important;
        }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="ibox tieuchuantieuchi">
            <div class="ibox-content ">
                <div class="">
                    @foreach($keHoachBaoCaoListDetail as $keHoachTieuChuan)
                        @if($keHoachTieuChuan->id_tieuchuan == $kh)
                        {{--@continue(!$keHoachTieuChuan->baoCaoTieuChuan)--}}
                        <strong>@lang('project/Externalreview/title.tieuchuan') {{ $keHoachTieuChuan->keHoachTieuChuans->stt }}
                            : {{ $keHoachTieuChuan->keHoachTieuChuans->mo_ta }}</strong>


                            @if($keHoachBaoCaoDetail2->loai_tieuchuan == 'csgd')
                                {{--@include("kdcl::danhgiangoai.tonghop.include.tieuchi-csdt")--}}
                            @else
                                <p>{!! str_replace('&nbsp;',' ',$keHoachTieuChuan->keHoachTieuChuans->modau) !!}</p>
                                @include("kdcl::danhgiangoai.tonghop.include.tieuchi-ctdt")

                                <div class="m-b-md m-l-md">
                                    <b>@lang('project/Externalreview/title.kltchuan') {{ $keHoachTieuChuan->keHoachTieuChuans->stt }}: </b>
                                    {!! str_replace('&nbsp;',' ',$keHoachTieuChuan->keHoachTieuChuans->ketluan) !!}
                                </div>
                            @endif

                        @endif
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
    @include("admin.project.ExternalReview.include.table_minh_chung")
</div>



                     