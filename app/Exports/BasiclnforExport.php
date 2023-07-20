<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BasiclnforExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getBasiclnfor = [];
        $dvs = DB::table('excel_import_donvi')->get();
        foreach($dvs as $key => $dv){
            //loại đơn vị
            $ldv = DB::table('loai_donvi')->where("id", $dv->loai_dv_id)->select('loai_donvi')
                    ->first();
            $row = [
                $key + 1,
                $dv->ma_donvi ,
                $ldv->loai_donvi,
                $dv->ten_donvi_TV,
                $dv->ten_donvi_TA,
                $dv->viet_tat_TV,
                $dv->viet_tat_TA,
                $dv->ten_truoc_day,

                $dv->loaiht,
                $dv->sqdcdlh,
                $dv->ntncdlh,
                $dv->chu_quan,
                date("d/m/Y", strtotime($dv->ngay_thanh_lap)),
                $dv->soqd,
                $dv->soqdcapp,
                $dv->ngcapphd,
                $dv->plcs,
                $dv->lhcsdt,
                $dv->soqdgtc,

                $dv->phone,
                $dv->fax,
                $dv->email,
                $dv->website,
                $dv->ghichu,
                $dv->loai_hinh,
                $dv->tgdtk1,
                $dv->tgcbk1,
            ];
            array_push($getBasiclnfor, $row);
        }
        return collect($getBasiclnfor);
    }

    public function headings() :array {
        return [
            "STT",
            "Mã đơn vị",
            "Loại đơn vị",
            "Tên đơn vị (*)(Tiếng Việt)",
            "Tên đơn vị (*)(Tiếng Anh)",
            "Tên viết tắt (*)(Tiếng Việt)",
            "Tên viết tắt (*)(Tiếng Anh)",
            "Tên trước đây",

            "Loại hình trường",
            "Số quyết định chuyển đổi loại hình",
            "Ngày tháng năm ký quyết định chuyển đổi loại hình",

            "Cơ quan/Bộ chủ quản",
            "Ngày quyết định thành lập",
            
            "Số quyết định thành lập",
            "Số quyết định cấp phép hoạt động",
            "Ngày được cấp phép hoạt động",
            "Phân loại cơ sở",
            "Loại hình cơ sở đào tạo",
            "Số quyết định thành lập, giao tự chủ",
            "Số điện thoại liên hệ",
            "Số fax",
            "Email",
            "Website",
            "Ghi chú",
            "Loại hình cơ sở giáo dục",
            "Thời gian bắt đầu đào tạo khóa I",
            "Thời gian cấp bằng tốt nghiệp cho khoá I",
        ];
    }
}
