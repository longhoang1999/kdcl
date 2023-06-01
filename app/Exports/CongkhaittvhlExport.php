<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CongkhaittvhlExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getKhcn = [];
        $khcns = DB::table('excel_import_hoclieu_tv_tthl')->get();
        foreach($khcns as $key => $khcn){
            
            $row = [
                $key + 1,
                $khcn->ten ,
                $khcn->so_luong,

            ];
            array_push($getKhcn, $row);
        }
        return collect($getKhcn);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên",
            "Số Lượng",
        ];
    }
}
