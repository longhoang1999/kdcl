<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Sangkienkn implements ToModel,WithHeadingRow
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
                'tensk'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'chunhiem'   =>  $dataExport[2] != null ? $dataExport[2] : "",
                'thanhvien'   =>  $dataExport[3] != null ? $dataExport[3] : "",
                'dvct'   =>  $dataExport[4] != null ? $dataExport[4] : "",
                'tgnt'   =>  $dataExport[5] != null ? $dataExport[5] : "",
                
                'diemdg'   =>  $dataExport[6] != null ? $dataExport[6] : "",
                'tgpb'   =>  $dataExport[7] != null ? $dataExport[7] : "",
                'ghichu'   =>  $dataExport[8] != null ? $dataExport[8] : "",

            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
