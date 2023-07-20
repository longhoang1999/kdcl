<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class AwardExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getgiaithuong = [];
        $gts = DB::table('excel_import_giaithuong')->get();
        foreach($gts as $key => $gt){
            $row = [
                $key + 1,
                $gt->tengt       ,
                $gt->capkhent        ,
                $gt->soqd            ,
                $gt->linhvuc         ,
                $gt->tgkt            ,
                $gt->doituong        ,
                $gt->chucvu          ,
                $gt->donvict         ,
                $gt->lopod           ,
                $gt->masv            ,
                $gt->ngdc             ,
                $gt->dvctkt          ,
                $gt->donvicap        

            ];
            array_push($getgiaithuong, $row);
        }
        return collect($getgiaithuong);
    }

    public function headings() :array {
        return [
            "STT",
            "Tên giải thưởng/ Hình thức KT",
            "Cấp khen thưởng",
            "Số Quyết định",

            "Lĩnh vực",
            "Thời gian khen thưởng (mm/yyyy)",
            "Đối tượng KT",
            "Chức vụ",
            "Đơn vị công tác",
            "Lớp ổn định",
            "Mã sinh viên",

            "Người được cấp",
            "Đơn vị chủ tri của đối tượng được khen thưởng",
            "Đơn vị cấp",
    
        ];
    }
}
