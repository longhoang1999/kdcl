<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Award implements ToModel,WithHeadingRow
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
                'tengt'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'capkhent'    =>  $dataExport[2] != null ? $dataExport[2] : "",
                'soqd' =>  $dataExport[3] != null ? $dataExport[3] : "",

                'linhvuc' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'tgkt' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'doituong' =>  $dataExport[6] != null ? $dataExport[6] : "",
                'chucvu' =>  $dataExport[7] != null ? $dataExport[7] : "",

                'donvict' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'lopod' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'masv' =>  $dataExport[10] != null ? $dataExport[10] : "",
                'ngdc' =>  $dataExport[11] != null ? $dataExport[11] : "",

                'dvctkt' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'donvicap' =>  $dataExport[13] != null ? $dataExport[13] : "",
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
