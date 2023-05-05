<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaickcl;
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
use App\Imports\Cknckh;

// export excel
use App\Exports\CknckhExport;

class CongkhaickclController extends DefinedController{

	public function index(){
		$current = DB::table("excel_import_cccldt")->where("nam", intVal(date('Y')));
        return view('admin.project.Importdata.ckcldt')->with([
           	'current'           => $current->count() == 0 ?  "" : $current->first(),
        ]);
	}
    public function updateCkcldt(Request $req){
        $checkExit = DB::table("excel_import_cccldt")->where("nam", $req->year);
        $data = [
            'nam'   => $req->year,
            'dkdkts'    => $req->dkkyts,
            'kienthuc'  => $req->kienthuc,
            'kynang'    => $req->kynang,
            'nltctn'    => $req->nltctn,
            'ccshd'     => $req->ccshd,
            'ctdt'      => $req->ctdtnt,
            'knht'      => $req->knhtrt,
            'vtstn'     => $req->vtlv
        ];
        if($checkExit->count() == 0){
            DB::table("excel_import_cccldt")->insert($data);
        }else{
            $checkExit->update($data);
        }
        
        return json_encode(['mes' => 'done']);
    }
    public function getCkcldt(Request $req){
        $find = DB::table("excel_import_cccldt")->where("nam", $req->nam);
        return json_encode([
            'result'    => $find->count() == 0 ? "" : $find->first(),
        ]);
    }

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Cknckh;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->tendanv != "" && $dt->nctvtv != ""){
            	$dataInport = array(
                    'ten_du_an'  => $dt->tendanv,
                    'nct_ctv' => $dt->nctvtv,
                    'cdttn_qt'  => $dt->dttn,
                    'tgth'   => $dt->tgth,
                    'kpth'   => $dt->kpth,
                    'tom_tat'   => $dt->ttspnd,
                    
                );
                DB::table("excel_import_hoat_dong_nckh")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCknckh() {
        return Excel::download(new CknckhExport, 'Cong-khai-nghien-cuu-khoa-hoc.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_hoat_dong_nckh AS cknckh");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("cknckh.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('cknckh.id', 'cknckh.ten_du_an', 'cknckh.nct_ctv',
	                 'cknckh.cdttn_qt','cknckh.tgth','cknckh.kpth','cknckh.tom_tat');

	        return DataTables::of($donviExcel)          
	       
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
        DB::table('excel_import_hoat_dong_nckh')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'ten_du_an'  => $req->tendanv,
            'nct_ctv' => $req->nctvtv,
            'cdttn_qt'  => $req->dttn,
            'tgth'   => $req->tgth,
            'kpth'   => $req->kpth,
            'tom_tat'   => $req->ttspnd,
        ];
        DB::table("excel_import_hoat_dong_nckh")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}