<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CkgttlExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_giaotrinh')->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->nganh,
                $ts->tgt_tltk,
                $ts->nxb,
                $ts->ke_hoach,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Ngành/CTĐT",
            "Tên giáo trình, tài liệu tham khảo (kể cả giáo trình điện tử)",
            "Năm xuất bản",
            "Kế hoạch soạn thảo giáo trình, tài liệu tham khảo (kể cả giáo trình điện tử)",
            
        ];
    }
}
