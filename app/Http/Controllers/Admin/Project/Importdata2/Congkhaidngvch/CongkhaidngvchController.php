<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Congkhaidngvch;
use App\Http\Controllers\Admin\DefinedController;
use App\Http\Requests\UserRequest;
use App\Mail\Register;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use File;
use Hash;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Redirect;
use Sentinel;
use URL;
use Lang;
use View;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Validator;
use App\Mail\Restore;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Country;

//Import Excel
use App\Imports\Ckdngv;

// export excel
use App\Exports\CkdsgvknExport;

class CongkhaidngvchController extends DefinedController{
    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '40')->select("id", "year")->get();
		
        return view('admin.project.Importdata2.ckdngvch')->with([
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'getFile'           => $getFile
        ]);
	}

    public function showFileData(Request $req){
        $getFile = DB::table('excel_import_data2')->where('id',$req->id )
                    ->first();
        $address = public_path($getFile->url);
        $a = Excel::toArray([],$address);
        $table = "";
        $UI = "";
        foreach($a[0] as $key => $value) {
            $td = "";
            if($key == 0){
                foreach($value as $val){
                    if(trim($val) != ""){
                        $td .=   '<th>'.  trim($val)   .'</th>';
                    }
                }
            }else{
                foreach($value as $val){
                    if(trim($val) != ""){
                        $td .=   '<td>'.  trim($val) .'</td>';
                    }
                }
            }
            if( $td != ""){
                $UI .= '<tr>
                            '.$td.'
                        </tr>  
                ';
            }
        }
        $table = '<table class="table ">' . $UI . '</table>';
        return json_encode([
            'data'  => $table,
            'href'  => asset($getFile->url)
        ]);
    }

    public function addfilenew(Request $req) {
        if($req->file('file') != null){
            $check = DB::table('excel_import_data2')->where("type_excel", '40')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Congkhaidngvch'), $picName);

            $data = [
                'type_excel'    => '40',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Congkhaidngvch/'.$picName,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
            DB::table('excel_import_data2')->insert($data);
        }
        return back()->with('success', 
                Lang::get('project/Standard/message.success.create'));
    }

    public function createUnit(Request $req){
        // excel_import_gvch
        $data = [
            'noi_dung'  => $req->tennganh,
            'tong_so'   => $req->tongso,
            'giao_su'   => $req->giaosu,
            'pho_giao_su'   => $req->phogiaosu,
            'tien_si'       => $req->tiensi,
            'thac_si'        => $req->thacsi,
            'dai_hoc'        => $req->daihoc,
            'cao_dang'       => $req->caodang,
            'trinh_do_khac'   => $req->trinhdokhac,
            'hang_3'       => $req->hangIII,
            'hang_2'        => $req->hangII,
            'hang_1'         => $req->hangI,
            'loai'          => $req->loaigv,
            'khoinganh'     => $req->khoinganh
        ];
        DB::table('excel_import_gvch')->insert($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Ckdngv;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->hoten != "" && $dt->namsinh != "" && $dt->tddt != "" && $dt->cngd != ""){
            	$dataInport = array(
                    'hoten'  => $dt->hoten,
                    'namsinh' => $dt->namsinh,
                    'gioitinh' => $dt->gioitinh,
                    'chucdanh' => $dt->chucdanh,
                    'tddt' => $dt->tddt,
                    'cngd' => $dt->cngd,
                    'khoinganh' => $dt->khoinganh,
                );
                DB::table("excel_import_gvtkn")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCkdtdsv() {
        return Excel::download(new CkdsgvknExport, 'Cong-khai-giang-vien-theo-khoi-nganh.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_gvtkn AS ckgvtkn");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ckgvtkn.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ckgvtkn.hoten', 'ckgvtkn.namsinh', 'ckgvtkn.chucdanh',
                            'ckgvtkn.tddt', 'ckgvtkn.cngd', 'ckgvtkn.khoinganh', 'ckgvtkn.id'
	                 );

	        return DataTables::of($donviExcel)          
	       
            ->addColumn(
	                'actions',
	                function ($donvi) {
	                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
	                    $actions = $actions. '<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('excel_import_gvch')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }
    public function getInfoUnit(Request $req){
        $data = DB::table('excel_import_gvch')->where("id", $req->id)->first();
        return json_encode($data);
    }
    public function updateUnit(Request $req){
    	$data = [
            'noi_dung'  => $req->tennganh,
            'tong_so'   => $req->tongso,
            'giao_su'   => $req->giaosu,
            'pho_giao_su'   => $req->phogiaosu,
            'tien_si'       => $req->tiensi,
            'thac_si'        => $req->thacsi,
            'dai_hoc'        => $req->daihoc,
            'cao_dang'       => $req->caodang,
            'trinh_do_khac'   => $req->trinhdokhac,
            'hang_3'       => $req->hangIII,
            'hang_2'        => $req->hangII,
            'hang_1'         => $req->hangI,
            'loai'          => $req->loaigv,
            'khoinganh'     => $req->khoinganh
        ];
        DB::table('excel_import_gvch')
                    ->where("id", $req->id)
                    ->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}