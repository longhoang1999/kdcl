<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TtdaklExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_doan_khoaluan')->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->nganh ,
                $ts->trinh_do_dao_tao ,
                $ts->ten_de_tai,
                $ts->htnth,
                $ts->htnhd,
                $ts->ndtt,  

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Ngành/CTĐT",
            "Trình độ đào tạo",
            "Tên đề tài",
            "Họ và tên người thực hiện",
            "Họ và tên người hướng dẫn",
            "Nội dung tóm tắt",
            
        ];
    }
}
