<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportArticle implements ToModel,WithHeadingRow
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
                'tbbbc'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'maso'    =>  $dataExport[2] != null ? $dataExport[2] : "",
                'linhvuc' =>  $dataExport[3] != null ? $dataExport[3] : "",
                'tacgia' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'donvipk' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'tapchidang' =>  $dataExport[6] != null ? $dataExport[6] : "",
                'soissn' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'sodang' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'tgcb' =>  $dataExport[9] != null ? $dataExport[9] : "",

                'namdang' =>  $dataExport[10] != null ? $dataExport[10] : "",
                'loai' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'loaitc' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'dmtc' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'url' =>  $dataExport[14] != null ? $dataExport[14] : "",
              
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
