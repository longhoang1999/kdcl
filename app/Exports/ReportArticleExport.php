<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ReportArticleExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getbbbc = [];
        $bbbcs = DB::table('excel_import_baibao_baocao')->get();
        foreach($bbbcs as $key => $bbbc){
            
            $row = [
                $key + 1,
                $bbbc->tbbbc ,
                $bbbc->maso,
                $bbbc->linhvuc,
                $bbbc->tacgia,
                $bbbc->donvi,
                $bbbc->tcd,
                $bbbc->so_issn_isbn,
                $bbbc->sodang,
                $bbbc->tgcb,
                $bbbc->namdang,
                $bbbc->loai,
                $bbbc->ltc,
                $bbbc->dmtc,
                $bbbc->url,

            ];
            array_push($getbbbc, $row);
        }
        return collect($getbbbc);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên bài báo/báo cáo",
            "Mã số",
            "Lĩnh vực",
            "Tác giả",
            "Đơn vị (Phòng/Khoa/TT)",

            "Tạp chí đăng/ Kỷ yếu",
            "Số ISSN/ISBN",
            "Số đăng",
            "Thời gian công bố (mm/yyyy)",

            "Năm đăng",
            "Loại",
            "Loại tạp chí",
            "Danh mục tạp chí",
            "Đường dẫn/file đính kèm (nếu có)",
            
    
        ];
    }
}
