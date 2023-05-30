<?php namespace App\Http\Controllers\Admin\Project\Importdata\Chuongtrinhdaotao;
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
use App\Imports\Admissions;
use App\Imports\Chtrinhdaotao;
// export excel
use App\Exports\CtdtExport_;


class Chuongtrinhdaotao extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.ctdt')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Chtrinhdaotao;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->khoabm != "" && $dt->cndt != "" ){
            	$dataInport = array(
                    'khoa_BM'  => $dt->khoabm,
                    'cndt' => $dt->cndt,
                    'ma_nganh' => $dt->manganh,
                    'ten_ctdt' => $dt->tenctdt,
                    'lhdt' => $dt->lhdt,
                    'nam_bddt' => $dt->nambddt,
                    'diadiem_tochuc' => $dt->ddtcdt,
                    'slsv' => $dt->slsv,
                    'sl_svtn' => $dt->slsvtn,
                    'ten_vanbang' => $dt->tenvb,
                    'tddt' => $dt->tddt,
                    'tgdtc' => $dt->tgdtc,
                    'cttshn' => $dt->cttshn,
                    'mkndt' => $dt->mkndt,
                    'mlvdt' => $dt->mlvdt,
                    
                );
                DB::table("export_import_ctdt")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportCtdt() {
        return Excel::download(new CtdtExport_, 'CtdtExport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("export_import_ctdt AS ctdt");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ctdt.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ctdt.id', 'ctdt.khoa_BM', 'ctdt.cndt',
	                 'ctdt.ma_nganh', 'ctdt.ten_ctdt', 'ctdt.nam_bddt', 'ctdt.diadiem_tochuc',
                     'ctdt.slsv','ctdt.sl_svtn','ctdt.ten_vanbang','ctdt.tddt',
                     'ctdt.tgdtc','ctdt.cttshn','ctdt.mkndt','ctdt.mlvdt');

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
        DB::table('export_import_ctdt')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'khoa_BM'  => $req->khoabm,
            'cndt' => $req->cndt,
            'ma_nganh' => $req->manganh,
            'ten_ctdt' => $req->tenctdt,
            'lhdt' => $req->lhdt,
            'nam_bddt' => $req->nambddt,
            'diadiem_tochuc' => $req->ddtcdt,
            'slsv' => $req->slsv,
            'sl_svtn' => $req->slsvtn,
            'ten_vanbang' => $req->tenvb,
            'tddt' => $req->tddt,
            'tgdtc' => $req->tgdtc,
            'cttshn' => $req->cttshn,
            'mkndt' => $req->mkndt,
            'mlvdt' => $req->mlvdt,
        ];
        DB::table("export_import_ctdt")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}