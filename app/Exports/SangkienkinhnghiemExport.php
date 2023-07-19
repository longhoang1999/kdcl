<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class SangkienkinhnghiemExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getgiaithuong = [];
        $gts = DB::table('excel_import_sangkienkn')->get();
        foreach($gts as $key => $gt){
            $iddv = DB::table("excel_import_donvi")->select("id", "ten_donvi_TV", "ma_donvi")
                                ->where("id",  $gt->dvct)->first();
            $row = [
                $key + 1,
                $gt->tensk ,
                $gt->chunhiem,
                $gt->thanhvien,
                $iddv->ten_donvi_TV,
                $gt->tgnt,
                $gt->diemdg,
                $gt->tgpb,
                $gt->ghichu,

            ];
            array_push($getgiaithuong, $row);
        }
        return collect($getgiaithuong);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên sáng kiến kinh nghiệm",
            "Chủ nhiệm",
            "Thành viên",
            "Đơn vị chủ trì",
            "Thời gian nghiệm thu",
            "Điểm đánh giá",
            "Thời gian phổ biến",
            "Ghi chú"
        ];
    }
}
