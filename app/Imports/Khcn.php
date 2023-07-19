<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Khcn implements ToModel,WithHeadingRow
{
    public $data = [];
    public function model(array $row)
    {
        $dataExport = array();
        $i = 0;
        foreach ($row as $key => $value) {
            $dataExport[$i++] = $value;
        }

        if($dataExport[0] != null){
            $dataPost = (object) array(
                'stt'   =>  $dataExport[0] != null ? $dataExport[0] : "",
                'tdtda'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'maso'    =>  $dataExport[2] != null ? $dataExport[2] : "",
                'loai' =>  $dataExport[3] != null ? $dataExport[3] : "",
                'capdetai' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'tgbd' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'tgnt' =>  $dataExport[6] != null ? $dataExport[6] : "",

                'namdk' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'namnghiemt' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'linhvuc' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'nganhclq' =>  $dataExport[10] != null ? $dataExport[10] : "",
                'dvctri' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'cndtai' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'tvtgdt' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'nhd' =>  $dataExport[14] != null ? $dataExport[14] : "",
                'dvcnph' =>  $dataExport[15] != null ? $dataExport[15] : "",
                'kinhphi' =>  $dataExport[16] != null ? $dataExport[16] : "",
                'ketqua' =>  $dataExport[17] != null ? $dataExport[17] : "",
                'trangthai' =>  $dataExport[18] != null ? $dataExport[18] : "",
              
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
