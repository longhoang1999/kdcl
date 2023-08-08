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
    <div class="col-md-8" style="padding-right: 23px">
        <div class="ibox tieuchuantieuchi">
            <div class="ibox-content ">
                <div class="">
                    @foreach($keHoachBaoCaoDetail2->keHoachTieuChuanList as $keHoachTieuChuan)
                        @if($keHoachTieuChuan->tieuchuan_id == $kh)
                       {{-- @continue(!$keHoachTieuChuan->baoCaoTieuChuan) --}}
                        <strong>@lang('project/Externalreview/title.tieuchuan') {{ $keHoachTieuChuan->tieuChuan->stt }}
                            : {{ $keHoachTieuChuan->tieuChuan->mo_ta }}</strong>


                            @if($keHoachBaoCaoDetail2->loai_tieuchuan_bc == 'csgd')
                                @include("admin.project.ExternalReview.include.tieuchi-csdt")
                            @else
                                @if(isset($keHoachTieuChuan->baoCaoTieuChuan->modau))

                                    @php
                                        $modifiedMota = str_replace('id="addminhchunggop_', 'd-id="', $keHoachTieuChuan->baoCaoTieuChuan->modau);
                                        $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $modifiedMota);
                                        echo '<p>' . $absoluteImagePath . '</p>';
                                    @endphp

                                @endif

                                @include("admin.project.ExternalReview.include.tieuchi-ctdt")

                                <div class="m-b-md m-l-md">
                                    <b>Kết luận tiêu chuẩn {{ $keHoachTieuChuan->tieuChuan->stt }}: </b>
                                    @if(isset($keHoachTieuChuan->baoCaoTieuChuan->ketluan))

                                        @php
                                            $modifiedMota = str_replace('id="addminhchunggop_', 'd-id="', $keHoachTieuChuan->baoCaoTieuChuan->ketluan);
                                            $absoluteImagePath = preg_replace('/src="..\/..\/..\/img_baocao/', 'src="' . asset('img_baocao'), $modifiedMota);
                                            echo '<p>' . $absoluteImagePath . '</p>';
                                        @endphp
                                    @endif
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



                     