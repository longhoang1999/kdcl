<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UnitsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getUnit = [];
        $nss = DB::table('excel_import_nhansu')->get();
        foreach($nss as $key => $ns){
           
            $row = [
                $key + 1,
                $ns->thoidiem       ,
                $ns->hodem       ,
                $ns->ten       , 
                $ns->shvc       , 
                $ns->cccd       , 
                $ns->phone       ,
                $ns->email       ,
                $ns->gender       ,
                date("Y-m-d", strtotime($ns->ngaysinh)),
                $ns->quoctich       ,

                $ns->sosobh       ,
                $ns->xaphuongtc       ,
                $ns->quanhuytc       ,
                $ns->tinhtptc       ,
                $ns->cvct       ,
                $ns->dvct       ,
                $ns->chdanh       ,
                $ns->tddt       ,
                $ns->cmdt       ,
                $ns->csdt       ,
                $ns->namtn       ,
                $ns->ccspgv       ,

                $ns->ttqlnn       ,
                $ns->tdllct       ,
                $ns->tinhoc       ,
                $ns->ngoaingu       ,
                $ns->cdnnktd       ,
                $ns->mscdktd       ,
                $ns->ntd       ,
                $ns->cdnnht       ,
                $ns->mscdht       ,
                $ns->ccn       ,
                $ns->ncn       ,
                $ns->dvsdvc       ,
                $ns->cdctht       ,
                $ns->tdbm       ,
                $ns->qdbm       ,
                $ns->htbn       ,
                $ns->nqdbn       ,
                $ns->cdnn       ,
                $ns->cdgv       ,
                 
                $ns->cdkm       ,
                $ns->tdgkm       ,
                $ns->lhdlv       ,
                $ns->shdtd       ,
                $ns->nkhd       ,
                 
                $ns->ncdhd       ,
                $ns->soqdnh       ,
                $ns->ngqdnh       ,
                $ns->htcd       ,
                $ns->tggd       ,

                $ns->nvdpc       ,
                $ns->ltggd       ,
                $ns->ckhbd       ,
                $ns->ttlamv       ,
                $ns->tncongt       ,
                $ns->bacl       ,
                $ns->hesol       ,
                $ns->pcthamn       ,
                $ns->pcudn       ,
                $ns->pccv       ,

            ];
            array_push($getUnit, $row);
        }
        return collect($getUnit);
    }

    public function headings() :array {
        return [
            "STT",
            "Thời điểm",
            "Họ đệm",
            "Tên",
            "Số hiệu viên chức / Mã cán bộ",
            "Số CCCD/Hộ chiếu",
            
            "Điện thoại",
            "Email",
            "Giới tính",
            "Ngày tháng năm sinh",
            "Quốc tịch",
            "Số số BHXH",
            "Xã/Phường thường trú",
            "Quận/Huyện thường trú",
            "Tỉnh/thành phố thường trú",
            "Chức vụ công tác",
            "Đơn vị công tác (Tên Phòng/Khoa/TT)",
            "Chức danh",
            "Trình độ đào tạo",
            "Chuyên môn đào tạo",
            "Cơ sở đào tạo",
            "Năm tốt nghiệp",
            "Chứng chỉ sư phạm giảng viên",
            "Trình độ quản lý nhà nước",
            "Trình độ lý luận chính trị",
            "Trình độ tin học",
            "Trình độ ngoại ngữ",
            "Chức danh nghề nghiệp khi tuyển dụng",
            "Mã số chức danh khi tuyển dụng",
            "Ngày tháng năm tuyển dụng",
            "Chức danh nghề nghiệp hiện tại/ Chức vụ công tác",
            "Mã số chức danh hiện tại",
            "Có chuyển ngạch",
            "Năm chuyển ngạch",
            "Đơn vị sử dụng viên chức",
            "Chức danh (chức vụ) công tác hiện tại",
            "Thời điểm bổ nhiệm",
            "QĐ bổ nhiệm",
            "Hình thức bổ nhiệm",
            "Ngày Quyết định",
            "Chức danh nghề nghiệp",
            "Chức danh giảng viên",
            "Chức danh (chức vụ) kiêm nhiệm",
            "Thời điểm  giao kiêm nhiệm",
            "Loại hợp đồng làm việc",
            "Số hợp đồng tuyển dụng",
            "Ngày ký HĐ",
            "Ngày chấm dứt hợp đồng",
            "Số quyết định ( Nghỉ hưu/ Nghỉ việc/ Chuyển đến)",
            "Ngày quyết định  (Nghỉ hưu/ Nghỉ việc/ Chuyển đến)",
            "Hình thức chuyển đến",
            "Tham gia giảng dạy/hỗ trợ/phục vụ ngành",
            "Nhiệm vụ được phân công",
            "Lớp tham gia giảng dạy",
            "Các khóa học bồi dưỡng",
            "Trạng thái làm việc",
            "Thâm niên công tác",
            "Bậc lương",
            "Hệ số lương",
            "Phụ cấp thâm niên",
            "Phụ cấp ưu đãi nghề",
            "Phụ cấp chức vụ" 
        ];
    }
}
