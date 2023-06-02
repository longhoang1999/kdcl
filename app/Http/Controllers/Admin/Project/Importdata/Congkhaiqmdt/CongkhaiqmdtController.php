<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaiqmdt;
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
use App\Imports\Ckqmdt;

// export excel
use App\Exports\CkqmdtExport;

class CongkhaiqmdtController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.ckqmdt')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Ckqmdt;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->khoinganh != "" && $dt->tiensi != ""){
            	$dataInport = array(
                    'khoi_nganh'  => $dt->khoinganh,
                    'tien_si' => $dt->tiensi,
                    'thac_si'   => $dt->thacsi,
                    'chinh_quy_dh'   => $dt->chinhquy,
                    'vlvh_dh'   => $dt->vlvh,
                    'chinh_quy_cd'   => $dt->chinhquy1,
                    'vlvh_cd'   => $dt->vlvh1,
                    'chinh_quy_tc'   => $dt->chinhquy2,
                    'vlvh_tc'   => $dt->vlvh2,
                    
                );
                DB::table("excel_import_quymodt")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCkqmdt() {
        return Excel::download(new CkqmdtExport, 'Cong-khai-quy-mo-dao-tao.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_quymodt AS ckqmdt");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ckqmdt.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ckqmdt.id', 'ckqmdt.khoi_nganh', 'ckqmdt.tien_si',
	                 'ckqmdt.thac_si','ckqmdt.chinh_quy_dh','ckqmdt.vlvh_dh','ckqmdt.chinh_quy_cd','ckqmdt.vlvh_cd',
                     'ckqmdt.chinh_quy_tc','ckqmdt.vlvh_tc');

	        return DataTables::of($donviExcel)          
            ->addColumn(
                'stt',
                function ($donvi) {
                    return "";
                }
            ) 
            ->addColumn(
	                'actions',
	                function ($donvi) {
	                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
	                    $actions = $actions. '<button class="btn" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('excel_import_quymodt')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'khoi_nganh'  => $req->khoinganh,
            'tien_si' => $req->tiensi,
            'thac_si'   => $req->thacsi,
            'chinh_quy_dh'   => $req->chinhquy,
            'vlvh_dh'   => $req->vlvh,
            'chinh_quy_cd'   => $req->chinhquy1,
            'vlvh_cd'   => $req->vlvh1,
            'chinh_quy_tc'   => $req->chinhquy2,
            'vlvh_tc'   => $req->vlvh2,
        ];
        DB::table("excel_import_quymodt")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}