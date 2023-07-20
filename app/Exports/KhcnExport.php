<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class KhcnExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getKhcn = [];
        $khcns = DB::table('export_import_khcn')->get();
        foreach($khcns as $key => $khcn){
            
            $row = [
                $key + 1,
                $khcn->maso       ,
                $khcn->tendetai      ,
                $khcn->loai      ,
                $khcn->capdetai      ,
                $khcn->tgbd      ,
                $khcn->tgnt      ,
                $khcn->namdk      ,
                $khcn->namnt      ,
                $khcn->linhvuc      ,
                $khcn->nganhlq      ,
                $khcn->dvct      ,
                $khcn->cndt      ,
                $khcn->thanhvien      ,
                $khcn->nguoihd     ,
                $khcn->dvcnph     ,
                $khcn->kinhphi     ,
                $khcn->ketqua     ,
                $khcn->trangthai     ,

            ];
            array_push($getKhcn, $row);
        }
        return collect($getKhcn);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên đề tài/đề án",
            "Mã số",
            "Loại",
            "Cấp đề tài",
            "Thời gian bắt đầu (mm/yyyy)",
            "Thời gian nghiệm thu (mm/yyyy)",
            "Năm đăng ký",
            "Năm nghiệm thu",
            "Lĩnh vực",

            "Ngành có liên quan (1 đề tài có thể liên quan nhiều ngành)",
            "Đơn vị chủ trì (option)",
            "Chủ nhiệm đề tài",
            "Thành viên tham gia đề tài",
            "Người hướng dẫn",
            "Đơn vị/cá nhân phối hợp",
            "Kinh phí",
            "Kết quả",
            "Trạng thái",
    
        ];
    }
}
