<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class DtkhcnExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getDtkhcn = [];
        $dtkhcns = DB::table('export_import_dtkhcn')->get();
        foreach($dtkhcns as $key => $dtkhcn){
            
            $row = [
                $key + 1,
                $dtkhcn->tenhd ,
                $dtkhcn->mahd,
                $dtkhcn->sanphamcua,
                $dtkhcn->dvtn,
                $dtkhcn->namcg,
                $dtkhcn->stcg,
                $dtkhcn->trangthai,

            ];
            array_push($getDtkhcn, $row);
        }
        return collect($getDtkhcn);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên hợp đồng",
            "Mã hợp đồng",
            "Sản phẩm của (Option)",
            "Đơn vị tiếp nhận",
            "Năm chuyển giao",
            "Số tiền chuyển giao",
            "Trạng thái",
    
        ];
    }
}
