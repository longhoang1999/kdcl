<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaihnhtkh;
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
use App\Imports\Ckhnhtkh;

// export excel
use App\Exports\CkhnhtkhExport;

class CongkhaihnhtkhController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.ckhnhtkh')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Ckhnhtkh;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->tenchude != "" && $dt->tgtc != ""){
            	$dataInport = array(
                    'tcd'  => $dt->tenchude,
                    'tgtc' => date("Y-m-d", strtotime($dt->tgtc)),
                    'ddtc'   => $dt->diadiemtc,
                    'so_luong'   => $dt->sldbtd,
                    
                );
                DB::table("excel_import_hn_htkh")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCkhnhtkh() {
        return Excel::download(new CkhnhtkhExport, 'Cong-khai-hoi-nghi-hoi-thao-khoa-hoc.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_hn_htkh AS hnhtkh");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("hnhtkh.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('hnhtkh.id', 'hnhtkh.tcd', 'hnhtkh.ddtc',
	                 'hnhtkh.tgtc', 'hnhtkh.so_luong');

	        return DataTables::of($donviExcel)
            ->addColumn(
                'stt',
                function ($donvi) {
                    return "";
                }
            )           
	        ->addColumn(
                'tgtc',
                function ($donvi) {
                    return date("d/m/Y", strtotime($donvi->tgtc));
                }
            )    
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
        DB::table('excel_import_hn_htkh')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tcd'  => $req->tenchude,
            'tgtc' => $req->tgtc,
            'ddtc'   => $req->diadiemtc,
            'so_luong'   => $req->sldbtd,
        ];
        DB::table("excel_import_hn_htkh")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}