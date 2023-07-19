<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Hoithaohn implements ToModel,WithHeadingRow
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
                'chude'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'dvct'   =>  $dataExport[2] != null ? $dataExport[2] : "",
                'diadiem'   =>  $dataExport[3] != null ? $dataExport[3] : "",
                'tgtc'   =>  $dataExport[4] != null ? $dataExport[4] : "",
                'sodb'   =>  $dataExport[5] != null ? $dataExport[5] : "",
                'ghichu'   =>  $dataExport[6] != null ? $dataExport[6] : "",
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
