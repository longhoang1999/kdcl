@extends('admin/layouts/default')
@section('title')
    @lang('project/Selfassessment/title.hoantbc')
@parent
@stop

@section('header_styles')

<style type="text/css">

</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.hoantbc')
    
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
      <div class="m-t-md">
      		<div class="h5 text-center">
                @lang('project/Externalreview/title.csdlkdcl')
            </div>

		    <p class="text-center">@lang('project/Externalreview/title.tdbc') {{ (($keHoachBaoCaoDetail2->thoi_diem_bao_cao)?\Carbon\Carbon::parse($keHoachBaoCaoDetail2->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>
            <p> <strong>@lang('project/Externalreview/title.phan1')</strong></p>
            <p><i><strong>@lang('project/Externalreview/title.1')</strong></i></p>
            <p>- @lang('project/Externalreview/title.tiengviet')</p>
            <p>- @lang('project/Externalreview/title.tienganh')</p>
            <p><i><strong>@lang('project/Externalreview/title.2')</strong></i></p>
            <p>- @lang('project/Externalreview/title.viettat')</p>
            <p>- @lang('project/Externalreview/title.tienganh')</p>
            <p><i><strong>@lang('project/Externalreview/title.3')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.4')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.5')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.6') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.fax')</strong></i></p>
            <p><i><strong> @lang('project/Externalreview/title.email') &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.web')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.7') </strong></i><i>@lang('project/Externalreview/title.quyetdinh') </i></p>
            <p><i><strong>@lang('project/Externalreview/title.8')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.9')</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.10')</strong></i></p>
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
            @php
                $phuLuc28 = $noiDungThem->where('ten','phuluc28')->first();
                if($phuLuc28){
                    $noidung28 = json_decode($phuLuc28->noidung);
                }else{
                    $noidung28 = json_decode('{"chinhquy":"co","khongchinhquy":"co","tuxa":"co","nuocngoai":"co","trongnuoc":"co"}');
                }
            @endphp
            <form method="POST" class="col-md-6 noiDungThem phuluc28" action="{{-- route("hoanthanh.api.noidungthem") --}}">
                @csrf
                <input type="hidden" value="phuluc28" name="ten">
                <input type="hidden" value="{{ $keHoachBaoCaoDetail2->id }}" name="id_kehoach_bc">
                <table class="table-borderless table table-condensed">
                    <tr>
                        <td></td>
                        <td>@lang('project/Externalreview/title.co')</td>
                        <td>@lang('project/Externalreview/title.khong')</td>
                    </tr>
                    <tr>
                        <td>@lang('project/Externalreview/title.chinhquy')</td>
                        <td><input {{ ($noidung28->chinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[chinhquy]" value="co"></td>
                        <td><input {{ ($noidung28->chinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[chinhquy]" value="khong"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.kcq')</td>
                        <td><input {{ ($noidung28->khongchinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[khongchinhquy]" value="co"></td>
                        <td><input {{ ($noidung28->khongchinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[khongchinhquy]" value="khong"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.tuxa')</td>
                        <td><input {{ ($noidung28->tuxa=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[tuxa]" value="co"></td>
                        <td><input {{ ($noidung28->tuxa=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[tuxa]" value="khong"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.lknn')</td>
                        <td><input {{ ($noidung28->nuocngoai=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[nuocngoai]" value="co"></td>
                        <td><input {{ ($noidung28->nuocngoai=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[nuocngoai]" value="khong"></td>
                    </tr>

                    <tr>
                        <td>@lang('project/Externalreview/title.lktn')</td>
                        <td><input {{ ($noidung28->trongnuoc=='co')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[trongnuoc]" value="co"></td>
                        <td><input {{ ($noidung28->trongnuoc=='khong')?'checked':"" }} class="radiobox" type="radio"
                                   name="noidungthem[trongnuoc]" value="khong"></td>
                    </tr>
                </table>
            </form>
        </div>
		<p><i><strong>@lang('project/Externalreview/title.12')</strong></i></p>
        <p><em>@lang('project/Externalreview/title.cpb')</em>
        </p> 
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>@lang('project/Externalreview/title.13')</strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>
            14. Danh sách đơn vị trực thuộc (bao gồm các trung tâm nghiên cứu, chi nhánh/cơ sở của các đơn vị)
        </strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
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
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i><strong>
            16.Thống kê số lượng cán bộ quản lý, nhân viên
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>
            17. Thống kê số lượng cán bộ, giảng viên và nhân viên (gọi chung là cán bộ) của CSGD theo giới tính:
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i><strong>
            18. Thống kê, phân loại giảng viên theo trình độ:
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        
        <p>(Khi tính số lượng các TSKH, TS thì không bao gồm những giảng viên vừa có học vị vừa có chức danh khoa học vì đã tính ở 2 dòng trên)</p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>
            19. Thống kê, phân loại giảng viên cơ hữu theo độ tuổi (số người):
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <b>Tổng hợp</b>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        
        <p><i><strong>
            20. Thống kê, phân loại giảng viên cơ hữu theo mức độ thường xuyên sử dụng ngoại ngữ và tin học cho công tác giảng dạy và nghiên cứu:
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><strong>III. Người học</strong></p>
        <p>Người học bao gồm sinh viên, học sinh, học viên cao học và nghiên cứu sinh:</p>
        <p><i><strong>
            21. Tổng số sinh viên đăng ký dự thi vào CSGD, trúng tuyển và nhập học trong 5 năm gần đây hệ chính quy:
        </strong></i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
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
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i>
            <strong>
               23. Ký túc xá cho sinh viên:
            </strong>
        </i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i>
            <strong>
                24. Sinh viên tham gia nghiên cứu khoa học
            </strong>
        </i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i>
            <strong>
                25. Thống kê số lượng sinh viên tốt nghiệp trong 5 năm gần đây.
            </strong>
        </i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i>
            <strong>
                26. Tình trạng tốt nghiệp của sinh viên đại học hệ chính quy:
            </strong>
        </i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i>
            <strong>
                27. Tình trạng tốt nghiệp của sinh viên cao đẳng hệ chính quy:
            </strong>
        </i></p>

        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
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
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước.</p>
        <div>
            <span>Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ trên cán bộ cơ hữu: </span>
            <input type="number" class="edit_input" value="{{$dulieu->g28_tysdtnckh}}" data_key="g28_tysdtnckh" min="0">
        </div>

        <p><strong>
            29. Doanh thu từ nghiên cứu khoa học và chuyển giao công nghệ của CSGD trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><strong>
            30. Số lượng cán bộ cơ hữu của CSGD tham gia thực hiện đề tài khoa học trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
        <p><strong>
            31. Số lượng sách của CSGD được xuất bản trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
        <div>
            <span>Tỷ số sách đã được xuất bản trên cán bộ cơ hữu: </span>
            <input type="number" class="edit_input" value="{{$dulieu->g31_tyssddxb}}" data_key="g31_tyssddxb" min="0">
        </div>
        <p><strong>
            32. Số lượng cán bộ cơ hữu của CSGD tham gia viết sách trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><strong>
            33. Số lượng bài của các cán bộ cơ hữu của CSGD được đăng tạp chí trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <div>
            <span>Tỷ số bài đăng tạp chí trên cán bộ cơ hữu: </span>
            <input type="number" class="edit_input" value="{{$dulieu->g33_tysbdtc}}" data_key="g33_tysbdtc" min="0">
        </div>

        <p><strong>
            34. Số lượng cán bộ cơ hữu của CSGD tham gia viết bài đăng tạp chí trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><strong>
            35. Số lượng báo cáo khoa học do cán bộ cơ hữu của CSGD báo cáo tại các hội nghị, hội thảo, được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của cơ sở giáo dục vì đã được tính 1 lần)</p>
        <div>
            <span>Tỷ số bài báo cáo trên cán bộ cơ hữu: </span>
            <input type="number" class="edit_input" value="{{$dulieu->g35_tysbbc}}" data_key="g35_tysbbc" min="0">
        </div>

        <p><strong>
            36. Số lượng cán bộ cơ hữu của CSGD có báo cáo khoa học tại các hội nghị, hội thảo được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của trường)</p>
        <p><strong>
            37. Số bằng phát minh, sáng chế được cấp trong 5 năm gần đây:
        </strong></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>38. Nghiên cứu khoa học của sinh viên</strong></i></p>
        <p><i><strong>
            38.1. Số lượng sinh viên của nhà trường tham gia thực hiện đề tài khoa học trong 5 năm gần đây:
        </strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p>*Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp nhà nước</p>
        <p><i><strong>
            38.2. Thành tích nghiên cứu khoa học của sinh viên:
        </strong></i></p>
        <p>(Thống kê các giải thưởng nghiên cứu khoa học, sáng tạo, các bài báo, công trình được công bố)</p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><strong>V. Cơ sở vật chất, thư viện, tài chính</strong></p>
        <p><i><strong>
            39. Diện tích đất, diện tích sàn xây dựng
        </strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i><strong>
            40. Tổng số đầu sách trong thư viện của nhà trường (bao gồm giáo trình, học liệu, tài liệu, sách tham khảo… sách, tạp chí, kể cả e-book, cơ sở dữ liệu điện tử)
        </strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>

        <p><i><strong>
            41. Tổng số thiết bị chính của trường
        </strong></i></p>
        <div class="parent_ex">
            <div>
                <button href="" class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modal_unit" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel" fdprocessedid="riirhd">
                    <i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
                </button>
            </div>
           
            <div class="import_ex">
                
            </div> 
        </div>
        <p><i>
            <strong>
                42. Tổng kinh phí từ các nguồn thu của trường trong 5 năm gần đây (triệu đồng):
            </strong>
        </i></p>
        @php $fiveYearAgo = $keHoachBaoCaoDetail2->nam - 5; $key = 1; @endphp
        @for($i=$fiveYearAgo+1;$i<$fiveYearAgo+6;$i++)
            <div>
                <span>- Năm {{$i}}: </span>
                <input type="number" class="edit_input" value="{{$dulieu->{'g42_'.$key} }}" data_key="g42_{{$key}}" min="0">
            </div>
            @php $key++; @endphp
        @endfor
        
      
    </div>
<!-- page trang ở đây -->

    
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
</section>

@stop



@section('footer_scripts')

<script type="text/javascript">
   
</script>
@stop

