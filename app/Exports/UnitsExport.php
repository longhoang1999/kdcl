<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class UnitsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $getUnit = [];
        $nss = DB::table('excel_import_nhansu')->get();
        foreach($nss as $ns){
           
            $row = [
                $ns->thoidiem ,
                $ns->hodem,
                $ns->ten,
                $ns->shvc,
                $ns->phone,
                $ns->email,
                $ns->gender,
                date("d/m/Y", strtotime($ns->ngaysinh)),
                $ns->quoctich,
                $ns->tdcm,
                $ns->tdnv,
                $ns->namtn,
                $ns->noitn,
                $ns->gvsp,
                $ns->qlnn,
                $ns->llct,
                $ns->tinhoc,
                $ns->ngoaingu,
                $ns->hocham,
                $ns->namphong,
                $ns->cdnn,
                $ns->masocd,
                $ns->namtd,
                $ns->cdnnht,
                $ns->masocdht,
                $ns->chuyenngach,
                $ns->namcn,
                $ns->dvsdvc,
                $ns->cdctht,
                $ns->tdbn,
                $ns->qdbn,
                $ns->cdkm,
                $ns->tdgkm,
                $ns->loaihd,
                $ns->ngaycdhd,
                $ns->tggdht,
                $ns->nvdpc,
                $ns->ltggd,
                $ns->khbd,
                $ns->trangthai,

            ];
            array_push($getUnit, $row);
        }
        return collect($getUnit);
    }

    public function headings() :array {
        return [
            "Thời điểm",
            "Họ đệm",
            "Tên",
            "Số hiệu viên chức",
            "Điện thoại",
            "Email",
            "Giới tính",
            "Ngày sinh",
            "Quốc tịch",
            "Trình độ chuyên môn cao nhất",
            "Trình độ nghiệp vụ theo chuyên ngành",
            "Năm tốt nghiệp",
            "Nơi tốt nghiệp",
            "GVSP",
            "QLNN",
            "LLCT",
            "Tin học",
            "Ngoại ngữ",
            "Học hàm được phong ",
            "Năm được phong",
            "Chức danh nghề nghiệp khi tuyển dụng",
            "Mã số chức danh khi tuyển dụng",
            "Năm tuyển dụng",
            "Chức danh nghề nghiệp hiện tại",
            "Mã số chức danh hiện tại",
            "Có chuyển ngạch",
            "Năm chuyển ngạch",
            "Đơn vị sử dụng viên chức",
            "Chức danh (chức vụ) công tác hiện tại",
            "Thời điểm bổ nhiệm",
            "QĐ bổ nhiệm",
            "Chức danh (chức vụ) kiêm nhiệm",
            "Thời điểm  giao kiêm nhiệm",
            "Loại hợp đồng làm việc",
            "Ngày chấm dứt hợp đồng",
            "Tham gia giảng dạy/hỗ trợ/phục vụ ngành",
            "Nhiệm vụ được phân công",
            "Lớp tham gia giảng dạy",
            "Các khóa học bồi dưỡng",
            "Trạng thái",
            
        ];
    }
}
