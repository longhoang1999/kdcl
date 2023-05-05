<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CkttdtdExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_dtd_dtxxd')->get();
        
        foreach($tss as $ts){
            $row = [
                $ts->ten_du_an ,
                $ts->nct_tvtg,
                $ts->dttn_qt,
                $ts->tgth,
                $ts->kinh_phi,
                $ts->tom_tat,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "Tên dự án, nhiệm vụ khoa học công nghệ",
            "Người chủ trì và các thành viên",
            "Đối tác trong nước và quốc tế",
            "Thời gian thực hiện",
            "Kinh phí thực hiện (triệu đồng)",
            "Tóm tắt sản phẩm, ứng dụng thực tiễn",
        ];
    }
}
