<?php namespace App\Http\Controllers\Admin\Project\Importdata\Khcn;
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
use App\Imports\Khcn;

// export excel
use App\Exports\KhcnExport;

class KhcnController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.khcn')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Khcn;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->maso != "" ){
                $check = DB::table("export_import_khcn")->where("maso", $dt->maso);
                if($check->count() == 0){
                    $dataInport = array(
                        'maso'  => $dt->maso,
                        'tendetai' => $dt->tdtda,
                        'loai' => $dt->loai,
                        'capdetai' => $dt->capdetai,
                        'tgbd' => $dt->tgbd,
                        'tgnt' => $dt->tgnt,
                        'namdk' => $dt->namdk,
                        'namnt' => $dt->namnghiemt,
                        'linhvuc' => $dt->linhvuc,
                        'nganhlq' => $dt->nganhclq,
                        'dvct' => $dt->dvctri,
                        'cndt' => $dt->cndtai,
                        'thanhvien' => $dt->tvtgdt,
                        'nguoihd'=> $dt->nhd,
                        'dvcnph'=> $dt->dvcnph,
                        'kinhphi'=> $dt->kinhphi,
                        'ketqua'=> $dt->ketqua,
                        'trangthai'=> $dt->trangthai,
                    );
                    DB::table("export_import_khcn")->insert($dataInport);
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Khcn
    public function exportUnit() {
	return Excel::download(new KhcnExport, 'Khoa học công nghệ.xlsx');
    }

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("export_import_khcn AS khcnex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("khcnex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('khcnex.id', 'khcnex.maso', 'khcnex.tendetai',
	                 'khcnex.loai', 'khcnex.ketqua', 'khcnex.trangthai');

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
                        $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
                        $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>'; 
                        return $actions;
                    }
                )
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('export_import_khcn')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tendetai'  => $req->tdtda,
            'maso' => $req->maso,
			'loai'=> $req->loai,
			'capdetai'=> $req->capdetai,
            'tgbd'=> $req->tgbd,
            'tgnt'=> $req->tgnt,

			'namdk'=> $req->namdk,
			'namnt'=> $req->namnghiemt,
			'linhvuc'=> $req->linhvuc,
			'nganhlq'=> $req->nganhclq,
			'dvct'=> $req->dvctri,
			'cndt'=> $req->cndtai,
			'thanhvien'=> $req->tvtgdt,
			'nguoihd'=> $req->nhd,
			'dvcnph'=> $req->dvcnph,
			'kinhphi'=> $req->kinhphi,
			'ketqua'=> $req->ketqua,
			'trangthai'=> $req->trangthai,
        ];
        DB::table("export_import_khcn")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}