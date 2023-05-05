<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Nhansu implements ToModel,WithHeadingRow
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
                'stt'  =>  $dataExport[0] != null ? $dataExport[0] : "",
                'thoidiem' =>  $dataExport[1] != null ? $dataExport[1] : "",
                'hodem' =>  $dataExport[2] != null ? $dataExport[2] : "",
                'ten' =>  $dataExport[3] != null ? $dataExport[3] : "",
                'sohieu' =>  $dataExport[4] != null ? $dataExport[4] : "",
                'phone' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'email' =>  $dataExport[6] != null ? $dataExport[6] : "",
                'gender' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'ngaysinh' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'quoctich' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'trinhdo' =>  $dataExport[10] != null ? $dataExport[10] : "",
                'tdnv' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'namtn' =>  $dataExport[12] != null ? $dataExport[12] : "",
                'noitn' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'gvsp' =>  $dataExport[14] != null ? $dataExport[14] : "",
                'qlnn' =>  $dataExport[15] != null ? $dataExport[15] : "",
                'llct' =>  $dataExport[16] != null ? $dataExport[16] : "",
                'tinhoc' =>  $dataExport[17] != null ? $dataExport[17] : "",
                'ngoaingu' =>  $dataExport[18] != null ? $dataExport[18] : "",
                'hamphong' =>  $dataExport[19] != null ? $dataExport[19] : "",
                'namphong' =>  $dataExport[20] != null ? $dataExport[20] : "",
                'cdnntd' =>  $dataExport[21] != null ? $dataExport[21] : "",
                'mscdnn' =>  $dataExport[22] != null ? $dataExport[22] : "",
                'namtd' =>  $dataExport[23] != null ? $dataExport[23] : "",
                'cdnnht' =>  $dataExport[24] != null ? $dataExport[24] : "",
                'mscdht' =>  $dataExport[25] != null ? $dataExport[25] : "",
                'cocn' =>  $dataExport[26] != null ? $dataExport[26] : "",
                'namcn' =>  $dataExport[27] != null ? $dataExport[27] : "",
                'dvsdvc' =>  $dataExport[28] != null ? $dataExport[28] : "",
                'cdctht' =>  $dataExport[29] != null ? $dataExport[29] : "",
                'tdbn' =>  $dataExport[30] != null ? $dataExport[30] : "",
                'qdbn' =>  $dataExport[31] != null ? $dataExport[31] : "",
                'cdkm' =>  $dataExport[32] != null ? $dataExport[32] : "",
                'tdiemkn' =>  $dataExport[33] != null ? $dataExport[33] : "",
                'loaihd' =>  $dataExport[34] != null ? $dataExport[34] : "",
                'ngcd' =>  $dataExport[35] != null ? $dataExport[35] : "",
                'tggd' =>  $dataExport[36] != null ? $dataExport[36] : "",
                'nvdpc' =>  $dataExport[37] != null ? $dataExport[37] : "",
                'loptggd' =>  $dataExport[38] != null ? $dataExport[38] : "",
                'ckhbd' =>  $dataExport[39] != null ? $dataExport[39] : "",
                'trangthai' =>  $dataExport[40] != null ? $dataExport[40] : "",

            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
