<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class Tkktxexport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_tk_ktx')->where("parent", null)->get();
        
        foreach($tss as $key => $ts){
            
            $row = [
                $key + 1,
                $ts->tieu_chi,
                "",
                ""
            ];
            array_push($getAdmissions, $row);

            $tss2 = DB::table('excel_import_tk_ktx')->where("parent", $ts->id)->get();
            foreach($tss2 as $key2 => $value){
                $row = [
                    ($key + 1) . "." . ($key2 + 1),
                    $value->tieu_chi,
                    $value->nam,
                    $value->gia_tri
                ];
                array_push($getAdmissions, $row);
            }
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Tiêu chí",
            "Năm",  
            "Giá trị"         
        ];
    }
}
