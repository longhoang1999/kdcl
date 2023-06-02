<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CkdtdsvExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_dientich_sv')->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->ten ,
                $ts->ty_le,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên",
            "Tỷ lệ",
            
        ];
    }
}
