<style>
    .arrow_active #tudanhgia_bctdg {
        margin-left: 34px !important;
    }

    .arrow_active #tudanhgia_bctdg {
        margin-left: 34px !important;
    }
</style>
<div>
	<div class="">
        <div class="row">
            @foreach($keHoachBaoCaoList as $keHoachBaoCao)
                @php
                    $href = route("admin.danhgiangoai.baocaotudanhgia.index",['id'=>$keHoachBaoCao->id_khbc,'page'=>'baocao']);
                @endphp
                @if($keHoachBaoCao->hien_thi != 0)
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="listing listing-radius listing-primary" onclick="window.location='{{ $href }}';">
                    <div class="listing-content">
                        <a href="{{ $href }}">
                            @if(isset($keHoachBaoCao->ten_donvi->ten_donvi))
                                <h3 class="lead">{{$keHoachBaoCao->ten_donvi->ten_donvi}}</h3>
                            @endif
                            <p class="text-truncate">{{$keHoachBaoCao->ten_bc }}</p>
                            <p class="text-left">@lang('project/ExternalReview/title.nvbc'): {{ (($keHoachBaoCao->ngay_batdau)?\Carbon\Carbon::parse($keHoachBaoCao->ngay_batdau)->format('Y'):"") }}</p>
                            <p class="text-left">@lang('project/ExternalReview/title.tdbc'): {{ (($keHoachBaoCao->thoi_diem_bao_cao)?\Carbon\Carbon::parse($keHoachBaoCao->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>
                        </a>
                    </div>
                </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <style>
        
        .text-truncate{
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            cursor: pointer;
            height: 57px;
            /* text-indent: 25px; */
        }
        .text-truncate:hover{
            -webkit-line-clamp: initial;
        }
        .text-center {
            text-align: center !important;
        }
        .shape {
            border-style: solid;
            border-width: 0 70px 40px 0;
            float: right;
            height: 0px;
            width: 0px;
            -ms-transform: rotate(360deg);
            /* IE 9 */
            -o-transform: rotate(360deg);
            /* Opera 10.5 */
            -webkit-transform: rotate(360deg);
            /* Safari and Chrome */
            transform: rotate(360deg);
        }

        .listing {
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin: 15px 0;
            overflow: hidden;
        }

        .listing:hover {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: rotate scale(1.1);
            -webkit-transition: all 0.4s ease-in-out;
            -moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
        }

        .shape {
            border-color: rgba(255, 255, 255, 0) #d9534f rgba(255, 255, 255, 0) rgba(255, 255, 255, 0);
        }

        .listing-radius {
            border-radius: 7px;
            /* height: 38vh; */
        }

        .listing-danger {
            border-color: #d9534f;
        }

        .listing-danger .shape {
            border-color: transparent #d9533f transparent transparent;
        }

        .listing-success {
            border-color: #5cb85c;
        }

        .listing-success .shape {
            border-color: transparent #5cb75c transparent transparent;
        }

        .listing-default {
            border-color: #999999;
        }

        .listing-default .shape {
            border-color: transparent #999999 transparent transparent;
        }

        .listing-primary {
            border-color: #428bca;
        }

        .listing-primary .shape {
            border-color: transparent #318bca transparent transparent;
        }

        .listing-info {
            border-color: #5bc0de;
        }

        .listing-info .shape {
            border-color: transparent #5bc0de transparent transparent;
        }

        .listing-warning {
            border-color: #f0ad4e;
        }

        .listing-warning .shape {
            border-color: transparent #f0ad4e transparent transparent;
        }

        .shape-text {
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            position: relative;
            right: -40px;
            top: 2px;
            white-space: nowrap;
            -ms-transform: rotate(30deg);
            /* IE 9 */
            -o-transform: rotate(360deg);
            /* Opera 10.5 */
            -webkit-transform: rotate(30deg);
            /* Safari and Chrome */
            transform: rotate(30deg);
        }

        .listing-content {
            padding: 0 20px 10px;
        }
    </style>

	<script type="text/javascript">
		var x = document.getElementsByClassName("listing");
        var i;
        var c;

        //specify the colors you want to use
        var colors = ["#009933", "#006699", "#33cccc", "#99cc00", "#f60"];
        var d = colors.length;

        for (i = 0; i < x.length; i++){
            while (i < d) {
                c = i;
                var random_color = colors[c];
                x[i].style.borderColor  = random_color;
                i++;
            }
            while (i > d) {
                var random_color = colors[Math.floor(Math.random() * colors.length)];
                x[i].style.borderColor  = random_color;
                i++;
            }
        }
	</script>
</div>