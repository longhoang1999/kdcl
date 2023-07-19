<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class HoithaohoinghiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getgiaithuong = [];
        $gts = DB::table('excel_import_hoithohn')->get();
        foreach($gts as $key => $gt){
            $iddv = DB::table("excel_import_donvi")->select("id", "ten_donvi_TV", "ma_donvi")
                                ->where("id",  $gt->dvct)->first();
            $row = [
                $key + 1,
                $gt->chude ,
                $iddv->ten_donvi_TV,
                $gt->diadiem,
                $gt->tgtc,
                $gt->tgtc,
                $gt->ghichu,

            ];
            array_push($getgiaithuong, $row);
        }
        return collect($getgiaithuong);
    }

    public function headings() :array {
        return [
            "STT",
            "Chủ đề hội thảo, hội nghị",
            "Đơn vị chủ trì",
            "Địa điểm tổ chức",
            "Thời gian tổ chức",
            "Số đại biểu tham gia",
            "Ghi chú",
        ];
    }
}
