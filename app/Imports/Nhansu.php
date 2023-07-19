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
                'cccd' =>  $dataExport[5] != null ? $dataExport[5] : "",
                'phone' =>  $dataExport[6] != null ? $dataExport[6] : "",
                'email' =>  $dataExport[7] != null ? $dataExport[7] : "",
                'gender' =>  $dataExport[8] != null ? $dataExport[8] : "",
                'ngaysinh' =>  $dataExport[9] != null ? $dataExport[9] : "",
                'quoctich' =>  $dataExport[10] != null ? $dataExport[10] : "",

                'sosobh' =>  $dataExport[11] != null ? $dataExport[11] : "",
                'xaphuongtc'  =>  $dataExport[12] != null ? $dataExport[12] : "",
                'quanhuytc' =>  $dataExport[13] != null ? $dataExport[13] : "",
                'tinhtptc' =>  $dataExport[14] != null ? $dataExport[14] : "",

                'cvct' =>  $dataExport[15] != null ? $dataExport[15] : "",
                'dvct' =>  $dataExport[16] != null ? $dataExport[16] : "",
                'chdanh' =>  $dataExport[17] != null ? $dataExport[17] : "",
                'tddt' =>  $dataExport[18] != null ? $dataExport[18] : "",
                'cmdt' =>  $dataExport[19] != null ? $dataExport[19] : "",
                'csdt' =>  $dataExport[20] != null ? $dataExport[20] : "",
                'namtn' =>  $dataExport[21] != null ? $dataExport[21] : "",
                'ccspgv' =>  $dataExport[22] != null ? $dataExport[22] : "",
                'ttqlnn' =>  $dataExport[23] != null ? $dataExport[23] : "",
                'tdllct' =>  $dataExport[24] != null ? $dataExport[24] : "",
                'tinhoc' =>  $dataExport[25] != null ? $dataExport[25] : "",
                'ngoaingu' =>  $dataExport[26] != null ? $dataExport[26] : "",
                'cdnnktd' =>  $dataExport[27] != null ? $dataExport[27] : "",
                'mscdktd' =>  $dataExport[28] != null ? $dataExport[28] : "",
                'ntd' =>  $dataExport[29] != null ? $dataExport[29] : "",
                'cdnnht' =>  $dataExport[30] != null ? $dataExport[30] : "",
                'mscdht' =>  $dataExport[31] != null ? $dataExport[31] : "",
                'ccn' =>  $dataExport[32] != null ? $dataExport[32] : "",
                'ncn' =>  $dataExport[33] != null ? $dataExport[33] : "",
                'dvsdvc' =>  $dataExport[34] != null ? $dataExport[34] : "",
                'cdctht' =>  $dataExport[35] != null ? $dataExport[35] : "",
                'tdbm' =>  $dataExport[36] != null ? $dataExport[36] : "",
                'qdbm' =>  $dataExport[37] != null ? $dataExport[37] : "",
                'htbn' =>  $dataExport[38] != null ? $dataExport[38] : "",
                'nqdbn' =>  $dataExport[39] != null ? $dataExport[39] : "",
                'cdnn' =>  $dataExport[40] != null ? $dataExport[40] : "",
                'cdgv' =>  $dataExport[41] != null ? $dataExport[41] : "",
                'cdkm' =>  $dataExport[42] != null ? $dataExport[42] : "",
                'tdgkm' =>  $dataExport[43] != null ? $dataExport[43] : "",
                'lhdlv' =>  $dataExport[44] != null ? $dataExport[44] : "",
                'shdtd' =>  $dataExport[45] != null ? $dataExport[45] : "",
                'nkhd' =>  $dataExport[46] != null ? $dataExport[46] : "",
                'ncdhd' =>  $dataExport[47] != null ? $dataExport[47] : "",
                'soqdnh' =>  $dataExport[48] != null ? $dataExport[48] : "",
                'ngqdnh' =>  $dataExport[49] != null ? $dataExport[49] : "",
                'htcd' =>  $dataExport[50] != null ? $dataExport[50] : "",
                'tggd' =>  $dataExport[51] != null ? $dataExport[51] : "",
                'nvdpc' =>  $dataExport[52] != null ? $dataExport[52] : "",
                'ltggd' =>  $dataExport[53] != null ? $dataExport[53] : "",
                'ckhbd' =>  $dataExport[54] != null ? $dataExport[54] : "",
                'ttlamv' =>  $dataExport[55] != null ? $dataExport[55] : "",
                'tncongt' =>  $dataExport[56] != null ? $dataExport[56] : "",
                'bacl' =>  $dataExport[57] != null ? $dataExport[57] : "",
                'hesol' =>  $dataExport[58] != null ? $dataExport[58] : "",
                'pcthamn' =>  $dataExport[59] != null ? $dataExport[59] : "",
                'pcudn' =>  $dataExport[60] != null ? $dataExport[60] : "",
                'pccv' =>  $dataExport[61] != null ? $dataExport[61] : "",

            );
            array_push($this->data, $dataPost);
        }
    }
    public function read() {
        return $this->data;
    }
}
