<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaidngv;
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

class CongkhaidngvController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.ckdngvkn')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
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
        DB::table('excel_import_gvtkn')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'hoten'  => $req->hoten,
            'namsinh' => $req->namsinh,
            'gioitinh' => $req->gioitinh,
            'chucdanh' => $req->chucdanh,
            'tddt' => $req->tddt,
            'cngd' => $req->cngd,
            'khoinganh' => $req->khoinganh,
        ];
        DB::table("excel_import_gvtkn")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}