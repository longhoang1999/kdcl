<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CompilationBookExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getBssach = [];
        $bsss = DB::table('excel_import_biensoansach')->get();
        foreach($bsss as $key =>  $bss){
            $iddv = DB::table("excel_import_donvi")->select("id", "ma_donvi", "ten_donvi_TV")
                        ->where("ma_donvi",  $bss->dvchutri)->first();
            $row = [
                $key + 1,
                $bss->donvi ,
                $bss->masach       ,
                $bss->tensach      ,
                $bss->loaisach      ,
                $bss->chubien      ,
                $bss->thanhvien      ,

                $iddv->ten_donvi_TV      ,
                $bss->tgdk      ,
                $bss->tgnt      ,
                $bss->tgxb      ,

                $bss->namdk      ,
                $bss->namnt      ,
                $bss->namxb      ,
                $bss->nhaxb      ,
                $bss->hpsd      ,
                $bss->nhsd      ,
                $bss->trangthai      

            ];
            array_push($getBssach, $row);
        }
        return collect($getBssach);
    }

    public function headings() :array {
        return [
            "STT",
            "Đơn vị",
            "Mã sách",
            "Tên sách",
            "Loại sách",
            "Chủ biên",
            "Thành viên",
            "Đơn vị chủ trì biên soạn",
            "Thời gian đăng ký (mm/yyyy)",
            "Thời gian nghiệm thu (mm/yyyy)",
            "Thời gian xuất bản (mm/yyyy)",

            "Năm đăng ký",
            "Năm nghiệm thu",
            "Năm xuất bản",
            "Nhà xuất bản",
            "Học phần sử dụng",

            "Ngành học sử dụng",
            "Trạng thái",
    
        ];
    }
}
