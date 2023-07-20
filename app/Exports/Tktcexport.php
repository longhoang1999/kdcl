<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class Tktcexport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_tk_tai_chinh')->where('parent_id', null)->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->noi_dung ,
                "",
                "",
            ];
            array_push($getAdmissions, $row);

            $tssChild = DB::table('excel_import_tk_tai_chinh')->where('parent_id', $ts->id)->get();
            foreach($tssChild as $key2 => $child){
                $row2 = [
                    ($key + 1) . "." . ($key2 + 1),
                    "" ,
                    $child->doanhthu,
                    $child->nam,
                ];
                array_push($getAdmissions, $row2);
            }
            
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Nội dung",
            "Doanh thu",
            "Năm",
            
        ];
    }
}
