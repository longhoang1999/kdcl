<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use App\Exports\DefaultExport;

class CSDTExport extends DefaultExport implements FromCollection, WithHeadings 
{
    public function collection()
    {
        $getCTDT = [];
        $csdts = $this->dataExceptDelete(
                DB::table('csdt')->orderBy('created_at', 'desc')->get()
        );
        
        foreach($csdts as $csdt){
            $row = [

                $csdt->ten_csdt,
                $csdt->dia_chi,
                $csdt->sdt_lienhe,
                $csdt->ns_phutrach,
                $csdt->trang_thai,
                date("d/m/Y", strtotime($csdt->created_at)),
            ];
            array_push($getCTDT, $row);
        }
        return collect($getCTDT);
    }

    public function headings() :array {
        return [
            "Tên CSĐT",
            "Địa Chỉ",
            "SĐT liên hệ",
            "Người Phụ Trách",
            "Trạng Thái",
            "Ngày tạo",
        ];
    }
}
