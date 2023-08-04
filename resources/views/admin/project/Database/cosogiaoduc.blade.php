
        @if($check == "sua")
            <style>
                .import_ex table{
                    border: 1px solid;
                     border-collapse: collapse;
                }
                .import_ex table th{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                    background: lightblue;
                }
                .import_ex table td{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                }
                .edit_input{
                        padding: 7px;
                        color: red;
                        font-weight: bold;
                        margin: 5px;
                }
                .edit_input::-webkit-inner-spin-button,
                .edit_input::-webkit-outer-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
                }

                .edit_input {
                  -moz-appearance: textfield; /* Firefox */
                }

            </style>

        @else
             <style>
                .import_ex table{
                    border: 1px solid;
                     border-collapse: collapse;
                }
                .import_ex table th{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                    background: lightblue;
                }
                .import_ex table td{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                }
                .edit_input{
                        padding: 7px;
                        color: red;
                        font-weight: bold;
                        margin: 5px;
                        border: none;
                        outline: none;
                        background: none;
                }
                .btn-benchmarkbtn-benchmark{
                    display: none;
                }
                .edit_input::-webkit-inner-spin-button,
                .edit_input::-webkit-outer-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
                }

                .edit_input {
                  -moz-appearance: textfield; /* Firefox */
                }
                .btn-benchmark{
                    display: none;
                }
                #btn_submit{
                    display: none;
                }
                .table-borderless{
                    border: 1px solid;
                }
                .table-borderless tr,td{
                    border: 1px solid;
                }
            </style>


        @endif
        <style>
            li.none_css{
                display: none !important;
            }
        </style>
      <div class="m-t-md">
            <div class="h5 text-center">
                @lang('project/Externalreview/title.csdlkdcl')
            </div>

            <p class="text-center">@lang('project/Externalreview/title.tdbc') {{ (($keHoachBaoCaoDetail2->thoi_diem_bao_cao)?\Carbon\Carbon::parse($keHoachBaoCaoDetail2->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>
            <p> <strong>@lang('project/Externalreview/title.phan1')</strong></p>
            <p><i><strong>@lang('project/Externalreview/title.1')</strong></i></p>
            <p>- TRƯỜNG ĐẠI HỌC HỌC CÔNG NGHIỆP DỆT MAY HÀ NỘI</p>
            <p>- HA NOI INDUSTRIAL TEXTTILE GARMENT UNIVERSITY</p>
            <p><i><strong>@lang('project/Externalreview/title.2')</strong></i></p>
            <p>- ĐHCNDMHN</p>
            <p>- HTU</p>
            <p><i><strong>@lang('project/Externalreview/title.3')</strong></i></p>
            <p><i><strong>4. Cơ quan/Bộ chủ quản: Tập đoàn Dệt May Việt Nam</strong></i></p>
            <p><i><strong>5. Địa chỉ : Lệ Chi - Gia Lâm - Hà Nội</strong></i></p>
            <p><i><strong>6. Thông tin liên hệ: Điện thoại: (0234) 38276514 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.fax')</strong></i></p>
            <p><i><strong> phongtchc@hict.edu.vn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   ww.hict.edu.vn</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.7') </strong></i><i>01/06/2015 (QĐ 3993/VPCP- ĐMDN) </i></p>
            <p><i><strong>8. Thời gian bắt đầu đào tạo khóa I: 2016</strong></i></p>
            <p><i><strong>9. Thời gian cấp bằng tốt nghiệp cho khoá I:  2020</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.10') </strong></i></p>
            <div class="m-l-lg">
            <p>
                <label class="checkbox-inline">
                    <input type="checkbox" class="m-t-xs" disabled checked> @lang('project/Externalreview/title.conglap')
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.bancong')
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.danlap')
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.tuthuc')
                </label>
            </p>
            <p>@lang('project/Externalreview/title.lhk')</p>
        </div>
        <p><i><strong>@lang('project/Externalreview/title.11')</strong></i></p>

        <div class="row m-t-lg">

            <!-- form cần sửa -->
            <div id="save_contenty">
                <table class="table-borderless table table-condensed">
                    <tr>
                        <td></td>
                        <td>@lang('project/Externalreview/title.co')</td>
                        <td>@lang('project/Externalreview/title.khong')</td>
                    </tr>
                    <tr>
                        <td>@lang('project/Externalreview/title.chinhquy')</td>
                        <td><input {{ ($noiDungThem->chinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[chinhquy]" value="co" data_key="chinhquy"></td>
                        <td><input {{ ($noiDungThem->chinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[chinhquy]" value="khong" data_key="chinhquy"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.khongchinhquy')</td>
                        <td><input {{ ($noiDungThem->khongchinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[khongchinhquy]" value="co" data_key="khongchinhquy"></td>
                        <td><input {{ ($noiDungThem->khongchinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[khongchinhquy]" value="khong" data_key="khongchinhquy"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.tuxa')</td>
                        <td><input {{ ($noiDungThem->tuxa=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[tuxa]" value="co" data_key="tuxa"></td>
                        <td><input {{ ($noiDungThem->tuxa=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[tuxa]" value="khong" data_key="tuxa"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.lknn')</td>
                        <td><input {{ ($noiDungThem->nuocngoai=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[nuocngoai]" value="co" data_key="nuocngoai"></td>
                        <td><input {{ ($noiDungThem->nuocngoai=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[nuocngoai]" value="khong" data_key="nuocngoai"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.lktn')</td>
                        <td><input {{ ($noiDungThem->trongnuoc=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[trongnuoc]" value="co" data_key="trongnuoc"></td>
                        <td><input {{ ($noiDungThem->trongnuoc=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[trongnuoc]" value="khong" data_key="trongnuoc"></td>
                    </tr>
                </table>
            </div>
        </div>
        <form action="{{route('admin.tudanhgia.database.save_file_csgd')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" hidden value="{{$idkhbc}}" name="id">
            <p><i><strong>@lang('project/Externalreview/title.12')</strong></i></p>
            <p><em>@lang('project/Externalreview/title.cpb')</em>
            </p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g12">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                     {!! isset($data['g12']) ? $data['g12'] : '' !!}
                </div>
            </div>
            <p><i><strong>@lang('project/Externalreview/title.13')</strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g13">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g13']) ? $data['g13'] : '' !!}
                </div>
            </div>
            <p><i><strong>
                14. Danh sách đơn vị trực thuộc (bao gồm các trung tâm nghiên cứu, chi nhánh/cơ sở của các đơn vị)
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g14">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g14']) ? $data['g14'] : '' !!}

                </div>
            </div>
            <p><strong>
                II. Cán bộ, giảng viên, nhân viên
            </strong></p>
            <p>
                CSGD cần có cơ sở dữ liệu về cán bộ, giảng viên, nhân viên của mình, bao gồm cả cơ hữu và hợp đồng ngắn hạn. Từ cơ sở dữ liệu lấy ra các thông tin dưới đây (Thống kê mỗi loại gồm 5 bảng tương ứng với 5 năm của giai đoạn đánh giá):
            </p>

            <p><i><strong>
                15. Thống kê số lượng giảng viên và nghiên cứu viên
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g15">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g15']) ? $data['g15'] : '' !!}

                </div>
            </div>

            <p><i><strong>
                16.Thống kê số lượng cán bộ quản lý, nhân viên
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g16">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g16']) ? $data['g16'] : '' !!}

                </div>
            </div>
            <p><i><strong>
                17. Thống kê số lượng cán bộ, giảng viên và nhân viên (gọi chung là cán bộ) của CSGD theo giới tính:
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g17">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g17']) ? $data['g17'] : '' !!}

                </div>
            </div>

            <p><i><strong>
                18. Thống kê, phân loại giảng viên theo trình độ:
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g18_1">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g18_1']) ? $data['g18_1'] : '' !!}

                </div>
            </div>

            <p>(Khi tính số lượng các TSKH, TS thì không bao gồm những giảng viên vừa có học vị vừa có chức danh khoa học vì đã tính ở 2 dòng trên)</p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g18_2">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g18_2']) ? $data['g18_2'] : '' !!}

                </div>
            </div>
            <p><i><strong>
                19. Thống kê, phân loại giảng viên cơ hữu theo độ tuổi (số người):
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g19_1">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g19_1']) ? $data['g19_1'] : '' !!}

                </div>
            </div>
            <b>Tổng hợp</b>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g19_2">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g19_2']) ? $data['g19_2'] : '' !!}

                </div>
            </div>

            <p><i><strong>
                20. Thống kê, phân loại giảng viên cơ hữu theo mức độ thường xuyên sử dụng ngoại ngữ và tin học cho công tác giảng dạy và nghiên cứu:
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g20">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g20']) ? $data['g20'] : '' !!}

                </div>
            </div>

            <p><strong>III. Người học</strong></p>
            <p>Người học bao gồm sinh viên, học sinh, học viên cao học và nghiên cứu sinh:</p>
            <p><i><strong>
                21. Tổng số sinh viên đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ chính quy:
            </strong></i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g21">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g21']) ? $data['g21'] : '' !!}

                </div>
            </div>
            <div>
                <span>Số lượng người học hệ chính quy đang học tập tại CSGD: </span>
                <input type="number" class="edit_input" value="{{$dulieu->g21_slnhcq}}" data_key="g21_slnhcq" min="0">
            </div>
            <p><i>
                <strong>
                    22. Tổng số sinh viên đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ không chính quy:
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g22">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g22']) ? $data['g22'] : '' !!}

                </div>
            </div>

            <p><i>
                <strong>
                   23. Ký túc xá cho sinh viên:
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g23">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g23']) ? $data['g23'] : '' !!}

                </div>
            </div>

            <p><i>
                <strong>
                    24. Sinh viên tham gia nghiên cứu khoa học
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g24">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g24']) ? $data['g24'] : '' !!}

                </div>
            </div>

            <p><i>
                <strong>
                    25. Thống kê số lượng sinh viên tốt nghiệp trong 5 năm gần đây.
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g25">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g25']) ? $data['g25'] : '' !!}

                </div>
            </div>
            <p><i>
                <strong>
                    26. Tình trạng tốt nghiệp của sinh viên đại học hệ chính quy:
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g26">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g26']) ? $data['g26'] : '' !!}

                </div>
            </div>
            <p><i>
                <strong>
                    27. Tình trạng tốt nghiệp của sinh viên cao đẳng hệ chính quy:
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g27">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g27']) ? $data['g27'] : '' !!}

                </div>
            </div>
            <p><strong>
                IV. Nghiên cứu khoa học và chuyển giao công nghệ
            </strong></p>

            <p><i>
                <strong>
                    28. Số lượng đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ của đơn vị thực hiện CSGD được nghiệm thu trong 5 năm gần đây:
                </strong>
            </i></p>

            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g28">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g28']) ? $data['g28'] : '' !!}

                </div>
            </div>
            <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước.</p>
            <div>
                <span>Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->g28_tysdtnckh}}" data_key="g28_tysdtnckh" min="0">
            </div>

            <p><i><strong>
                29. Doanh thu từ nghiên cứu khoa học và chuyển giao công nghệ của CSGD trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g29">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g29']) ? $data['g29'] : '' !!}

                </div>
            </div>
            <p><i><strong>
                30. Số lượng cán bộ cơ hữu của CSGD tham gia thực hiện đề tài khoa học trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g30">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g30']) ? $data['g30'] : '' !!}

                </div>
            </div>
            <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
            <p><i><strong>
                31. Số lượng sách của CSGD được xuất bản trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g31">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g31']) ? $data['g31'] : '' !!}

                </div>
            </div>
            <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
            <div>
                <span>Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->g31_tyssddxb}}" data_key="g31_tyssddxb" min="0">
            </div>
            <p><i><strong>
                32. Số lượng cán bộ cơ hữu của CSGD tham gia viết sách trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g32">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g32']) ? $data['g32'] : '' !!}

                </div>
            </div>

            <p><i><strong>
                33. Số lượng bài của các cán bộ cơ hữu của CSGD được đăng tạp chí trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g33">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g33']) ? $data['g33'] : '' !!}

                </div>
            </div>

            <div>
                <span>Tỷ số bài đăng tạp chí trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->g33_tysbdtc}}" data_key="g33_tysbdtc" min="0">
            </div>

            <p><i><strong>
                34. Số lượng cán bộ cơ hữu của CSGD tham gia viết bài đăng tạp chí trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g34">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g34']) ? $data['g34'] : '' !!}

                </div>
            </div>
            <p><i><strong>
                35. Số lượng báo cáo khoa học do cán bộ cơ hữu của CSGD báo cáo tại các hội nghị, hội thảo, được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g35">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g35']) ? $data['g35'] : '' !!}

                </div>
            </div>
            <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của cơ sở giáo dục vì đã được tính 1 lần)</p>
            <div>
                <span>Tỷ số bài báo cáo trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->g35_tysbbc}}" data_key="g35_tysbbc" min="0">
            </div>

            <p><i><strong>
                36. Số lượng cán bộ cơ hữu của CSGD có báo cáo khoa học tại các hội nghị, hội thảo được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g36">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g36']) ? $data['g36'] : '' !!}

                </div>
            </div>

            <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của trường)</p>
            <p><i><strong>
                37. Số bằng phát minh, sáng chế được cấp trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g37">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g37']) ? $data['g37'] : '' !!}

                </div>
            </div>
            <p><i><strong>38. Nghiên cứu khoa học của sinh viên</strong></i></p>
            <p><i><strong>
                38.1. Số lượng sinh viên của nhà trường tham gia thực hiện đề tài khoa học trong 5 năm gần đây:
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g38_1">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g38_1']) ? $data['g38_1'] : '' !!}

                </div>
            </div>
            <p>*Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp nhà nước</p>
            <p><i><strong>
                38.2. Thành tích nghiên cứu khoa học của sinh viên:
            </strong></i></p>
            <p>(Thống kê các giải thưởng nghiên cứu khoa học, sáng tạo, các bài báo, công trình được công bố)</p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g38_2">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g38_2']) ? $data['g38_2'] : '' !!}

                </div>
            </div>
            <p><strong>V. Cơ sở vật chất, thư viện, tài chính</strong></p>
            <p><i><strong>
                39. Diện tích đất, diện tích sàn xây dựng
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g39">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g39']) ? $data['g39'] : '' !!}

                </div>
            </div>
            <p><i><strong>
                40. Tổng số đầu sách trong thư viện của nhà trường (bao gồm giáo trình, học liệu, tài liệu, sách tham khảo… sách, tạp chí, kể cả e-book, cơ sở dữ liệu điện tử)
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g40">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g40']) ? $data['g40'] : '' !!}

                </div>
            </div>

            <p><i><strong>
                41. Tổng số thiết bị chính của trường
            </strong></i></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="g41">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['g41']) ? $data['g41'] : '' !!}

                </div>
            </div>
            <p><i>
                <strong>
                    42. Tổng kinh phí từ các nguồn thu của trường trong 5 năm gần đây (triệu đồng):
                </strong>
            </i></p>
            @php $fiveYearAgo = $keHoachBaoCaoDetail2->nam - 5; $key1 = 1; $key2 = 1;$key3 = 1;$key4 = 1;$key5 = 1;$key6 = 1;$key7 = 1;@endphp
            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g42_'.$key1} }}" data_key="g42_{{$key1}}" min="0">
                </div>
                @php $key1++; @endphp
            @endfor

            <p><i>
                <strong>
                    43. Tổng thu học phí (chỉ tính hệ chính quy) trong 5 năm gần đây (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g43_'.$key2} }}" data_key="g43_{{$key2}}" min="0">
                </div>
                @php $key2++; @endphp
            @endfor
            <p><i>
                <strong>
                    44. Tổng chi cho hoạt động nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g44_'.$key3} }}" data_key="g44_{{$key3}}" min="0">
                </div>
                @php $key3++; @endphp
            @endfor
            <p><i>
                <strong>
                   45. Tổng thu từ hoạt động nghiên cứu khoa học, chuyển giao công nghệ và phục vụ cộng đồng (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g45_'.$key4} }}" data_key="g45_{{$key4}}" min="0">
                </div>
                @php $key4++; @endphp
            @endfor
            <p><i>
                <strong>
                    46. Tổng chi cho hoạt động đào tạo (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g46_'.$key5} }}" data_key="g46_{{$key5}}" min="0">
                </div>
                @php $key5++; @endphp
            @endfor
            <p><i>
                <strong>
                    47. Tổng chi cho phát triển đội ngũ (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g47_'.$key6} }}" data_key="g47_{{$key6}}" min="0">
                </div>
                @php $key6++; @endphp
            @endfor
            <p><i>
                <strong>
                    48. Tổng chi cho hoạt động kết nối doanh nghiệp, tư vấn và hỗ trợ việc làm (triệu đồng):
                </strong>
            </i></p>

            @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
                <div>
                    <span>- Năm {{$i}}: </span>
                    <input type="number" class="edit_input" value="{{$dulieu->{'g48_'.$key7} }}" data_key="g48_{{$key7}}" min="0">
                </div>
                @php $key7++; @endphp
            @endfor

            <p><strong>
                VI. Kết quả kiểm định chất lượng giáo dục
            </strong></p>
            <div class="parent_ex">
                <input hidden type="file" class="inputFile" name="gvi">
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
                <div class="import_ex">
                    {!! isset($data['gvi']) ? $data['gvi'] : '' !!}

                </div>
            </div>
            <p><strong>
                VII. Tóm tắt một số chỉ số quan trọng
            </strong></p>
            <p>Từ kết quả khảo sát ở trên, tổng hợp thành một số chỉ số quan trọng dưới đây (số liệu năm cuối kỳ đánh giá):</p>
            <p><i><strong>
                1. Giảng viên:
            </strong></i></p>

            <div>
                <span>Tổng số giảng viên cơ hữu (người): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_1_tsgvch}}" data_key="vii_1_tsgvch" min="0">
            </div>
            <div>
                <span>Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_1_tlgvch}}" data_key="vii_1_tlgvch" min="0">
            </div>
            <div>
                <span>Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu của đơn vị thực hiện CSGD (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_1_tlgvchts}}" data_key="vii_1_tlgvchts" min="0">
            </div>
            <div>
                <span>Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu của đơn vị thực hiện CSGD (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_1_tlgvchths}}" data_key="vii_1_tlgvchths" min="0">
            </div>

            <p><i><strong>
                2. Sinh viên:
            </strong></i></p>

            <div>
                <span>Tổng số sinh viên chính quy (người): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_2_tssvcq}}" data_key="vii_2_tssvcq" min="0">
            </div>
            <div>
                <span>Tỷ số sinh viên trên giảng viên (sau khi quy đổi): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_2_tssvtgv}}" data_key="vii_2_tssvtgv" min="0">
            </div>
            <div>
                <span>Tỷ lệ sinh viên tốt nghiệp so với số tuyển vào (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_2_tlsvtn}}" data_key="vii_2_tlsvtn" min="0">
            </div>

            <p><i><strong>
                3. Đánh giá của sinh viên tốt nghiệp về chất lượng đào tạo của nhà trường:
            </strong></i></p>
            <div>
                <span>Tỷ lệ sinh viên trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_3_tlsvtl}}" data_key="vii_3_tlsvtl" min="0">
            </div>
            <div>
                <span>Tỷ lệ sinh viên trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_3_tlsvknct}}" data_key="vii_3_tlsvknct" min="0">
            </div>
            <p><i><strong>
                4. Sinh viên có việc làm trong năm đầu tiên sau khi tốt nghiệp
            </strong></i></p>
            <div>
                <span>Tỷ lệ sinh viên có việc làm đúng ngành đào tạo, trong đó bao gồm cả sinh viên chưa có việc làm học tập nâng cao (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_4_tlsvdn}}" data_key="vii_4_tlsvdn" min="0">
            </div>
            <div>
                <span>Tỷ lệ sinh viên có việc làm trái ngành đào tạo (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_4_tlsvtn}}" data_key="vii_4_tlsvtn" min="0">
            </div>
            <div>
                <span>Tỷ lệ tự tạo được việc làm trong số sinh viên có việc làm (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_4_tlttdvl}}" data_key="vii_4_tlttdvl" min="0">
            </div>
            <div>
                <span>Thu nhập bình quân/tháng của sinh viên có việc làm (triệu VNĐ): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_4_tnbq}}" data_key="vii_4_tnbq" min="0">
            </div>
            <p><i><strong>
                5. Đánh giá của nhà tuyển dụng về sinh viên tốt nghiệp có việc làm đúng ngành đào tạo:
            </strong></i></p>
            <div>
                <span>Tỷ lệ sinh viên đáp ứng yêu cầu của công việc, có thể sử dụng được ngay (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_5_tlsvduyc}}" data_key="vii_5_tlsvduyc" min="0">
            </div>
            <div>
                <span>Tỷ lệ sinh viên cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm (%): </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_5_tlsvcb}}" data_key="vii_5_tlsvcb" min="0">
            </div>
            <p><i><strong>
                6. Nghiên cứu khoa học và chuyển giao công nghệ:
            </strong></i></p>
            <div>
                <span>Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_6_tlsdtnckh}}" data_key="vii_6_tlsdtnckh" min="0">
            </div>
            <div>
                <span>Tỷ số doanh thu từ NCKH và chuyển giao công nghệ trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_6_dtnckh}}" data_key="vii_6_dtnckh" min="0">
            </div>
            <div>
                <span>Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_6_tssxb}}" data_key="vii_6_tssxb" min="0">
            </div>
            <div>
                <span>Tỷ số bài đăng tạp chí trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_6_tsbdtc}}" data_key="vii_6_tsbdtc" min="0">
            </div>
            <div>
                <span>Tỷ số bài báo cáo trên cán bộ cơ hữu: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_6_tsbbc}}" data_key="vii_6_tsbbc" min="0">
            </div>

            <p><i><strong>
                7. Cơ sở vật chất (số liệu năm cuối kỳ đánh giá):
            </strong></i></p>
            <div>
                <span>Tỷ số diện tích sàn xây dựng trên sinh viên chính quy: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_7_tsdts}}" data_key="vii_7_tsdts" min="0">
            </div>
            <div>
                <span>Tỷ số chỗ ở ký túc xá trên sinh viên chính quy: </span>
                <input type="number" class="edit_input" value="{{$dulieu->vii_7_tscokt}}" data_key="vii_7_tscokt" min="0">
            </div>
            <p><i><strong>
                8. Kết quả kiểm định chất lượng giáo dục
            </strong></i></p>
            <div>
                <span>Cấp cơ sở giáo dục: Đạt. </span>

            </div>
            <div>
                <span>Cấp chương trình đào tạo: 12 CTĐT đạt </span>

            </div>

            <div class="text-center mt-3">
                <button id="btn_submit" class="btn btn-success w-25" type="submit">Cập nhật bảng biểu</button>
            </div>
        </form>


<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/baocaoctdt.js') }}"></script>
<script type="text/javascript">



</script>


