<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TglvExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_thu_gon_lv')->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->linh_vuc ,
                $ts->bang_bieu,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Lĩnh vực",
            "Bảng biểu",
            
        ];
    }
}
