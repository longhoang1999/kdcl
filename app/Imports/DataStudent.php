<?php

namespace App\Imports;

use App\Models\UnitImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataStudent implements ToModel,WithHeadingRow
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
                'msv'   =>  $dataExport[1] != null ? $dataExport[1] : "",
                'ho'    =>  $dataExport[2] != null ? $dataExport[2] : "",
                'ten' =>  $dataExport[3] != null ? $dataExport[3] : "",
                'ntns' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'gioitinh' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'email' =>  $dataExport[6] != null ? $dataExport[6] : "",
                'phone' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'cccd' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'lop' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'sonha' =>  $dataExport[10] != null ? $dataExport[10] : "",

                'xa' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'huyen' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'tinh' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'dantoc' =>  $dataExport[14] != null ? $dataExport[14] : "",
                'quoctich' =>  $dataExport[15] != null ? $dataExport[15] : "",
                'tennganh' =>  $dataExport[16] != null ? $dataExport[16] : "",
                'manganh' =>  $dataExport[17] != null ? $dataExport[17] : "",
                'manganhts' =>  $dataExport[18] != null ? $dataExport[18] : "",
                'kqxhtnam1' =>  $dataExport[19] != null ? $dataExport[19] : "",
                'kqxhtnam2' =>  $dataExport[20] != null ? $dataExport[20] : "",
                'kqxhtnam3' =>  $dataExport[21] != null ? $dataExport[21] : "",
                'kqxhtnam4' =>  $dataExport[22] != null ? $dataExport[22] : "",
                'kqxhtnam5' =>  $dataExport[23] != null ? $dataExport[23] : "",
                'nbdck' =>  $dataExport[24] != null ? $dataExport[24] : "",
                'nktkh' =>  $dataExport[25] != null ? $dataExport[25] : "",
                'trangthai' =>  $dataExport[26] != null ? $dataExport[26] : "",
                'ngaychuyen' =>  $dataExport[27] != null ? $dataExport[27] : "",
                'soqd' =>  $dataExport[28] != null ? $dataExport[28] : "",


                'namnh' =>  $dataExport[29] != null ? $dataExport[29] : "",
                'namtn' =>  $dataExport[30] != null ? $dataExport[30] : "",
                'namqd' =>  $dataExport[31] != null ? $dataExport[31] : "",
                'namnb' =>  $dataExport[32] != null ? $dataExport[32] : "",
                'baocaobo' =>  $dataExport[33] != null ? $dataExport[33] : "",
                'trinhdo' =>  $dataExport[34] != null ? $dataExport[34] : "",
                'namdulien' =>  $dataExport[35] != null ? $dataExport[35] : "",

                
            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
