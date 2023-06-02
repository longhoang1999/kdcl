<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CkcldtExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_cccldt')->get();
        
        foreach($tss as $ts){
            $row = [
                $ts->nganh,
                $ts->ten_mon ,
                $ts->mdmh,
                $ts->so_tin_chi,
                $ts->lich_day,
                $ts->ppdgsv,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "Năm",
            "Nội dung",
            "Trình độ Đại học chính quy",
            
        ];
    }
}
