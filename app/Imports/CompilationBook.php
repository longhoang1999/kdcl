<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompilationBook implements ToModel,WithHeadingRow
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
                'donvi'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'masach'   =>  $dataExport[2] != null ? $dataExport[2] : "",
                'tensach'    =>  $dataExport[3] != null ? $dataExport[3] : "",
                'loaisach' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'chubien' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'thanhvien' =>  $dataExport[6] != null ? $dataExport[6] : "",

                'dvchutri' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'tgdk' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'tgnt' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'tgxb' =>  $dataExport[10] != null ? $dataExport[10] : "",

                'namdk' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'namnt' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'namxuatban' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'nhaxuatban' =>  $dataExport[14] != null ? $dataExport[14] : "",
                'hpsd' =>  $dataExport[15] != null ? $dataExport[15] : "",
                'nhsd' =>  $dataExport[16] != null ? $dataExport[16] : "",
                'trangthai' =>  $dataExport[17] != null ? $dataExport[17] : "",
              
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
