<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CkttdtExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getAdmissions = [];
        $tss = DB::table('excel_import_tt_dao_tao')->get();
        
        foreach($tss as $key => $ts){
            $row = [
                $key + 1,
                $ts->ten_don_vi ,
                $ts->so_luong,
                $ts->tddt,
                $ts->cndt,
                $ts->ket_qua,

            ];
            array_push($getAdmissions, $row);
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên đơn vị đặt hàng đào tạo",
            "Số lượng",
            "Trình độ đào tạo",
            "Chuyên ngành đào tạo",
            "Kết quả đào tạo",
        ];
    }
}
