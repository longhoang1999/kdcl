<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class CktcnhExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $parentI = [
            '1' =>  'Học phí chính quy chương trình đại trà',
            '2' => 'Học phí chính quy chương trình khác',
            '3' => 'Học phí hình thức vừa học vừa làm',
            '4' => 'Tổng thu năm'
        ];
        $parentII = [
            '1' =>  'Tiến sĩ',
            '2' => 'Thạc sỹ',
            '3' => 'Đại học',
            '4' => 'Cao đẳng sư phạm',
            '5' => 'Trung cấp sư phạm',
            '6' => 'Từ ngân sách',
            '7' => 'Từ học phí',
            '8' => 'Từ nghiên cứu khoa học và chuyển giao công nghệ',
            '9' => 'Từ nguồn hợp pháp khác',
            '10' => 'Từ nguồn sản xuất dịch vụ',
        ];
        $donvitinh = [
            '1' => 'Triệu đồng / năm',
            '2' => 'Tỷ đồng'
        ];

        $getAdmissions = [];
        
        foreach($parentI as $key => $pI){
            $row = [
                $key,
                $pI, "", "", ""
            ];
            array_push($getAdmissions, $row);

            $tss = DB::table('excel_import_tcnh')->where("parent_I", $key)
                    ->orderBy('nam', 'desc')->get();
            foreach($tss as $key2 => $value){
                $row = [
                    ($key) . "." . ($key2 + 1),
                    $value->ten_khoinganh != null ? $parentII[$value->parent_II] . "- Khối ngành: " . $value->ten_khoinganh : $parentII[$value->parent_II],
                    $value->donvitinh == '1' ? "Triệu đồng / năm" : "Tỷ đồng",
                    $value->hocphi_1nam,
                    $value->hocphi_cakhoa,
                    $value->nam
                ];
                array_push($getAdmissions, $row);
            }


            
        }
        return collect($getAdmissions);
    }

    public function headings() :array {
        return [
            "Nội dung",
            "Đơn vị tính",
            "Học phí/1SV/năm năm học: ",
            "Dự kiến Học phí/1SV của cả khóa học",
            "Năm"
            
        ];
    }
}
