<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TttnsvExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_tinh_trang_tn')->get();
        
        foreach($tss as $ts){
            
            $row = [
                $ts->tieu_chi,
                $ts->nam,
            
            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "Tiêu chí",
            "Năm",           
        ];
    }
}
