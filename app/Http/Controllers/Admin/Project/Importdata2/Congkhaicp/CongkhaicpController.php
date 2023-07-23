<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaicp;
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
use App\Imports\Ckcp;

// export excel
use App\Exports\CkcpExport;

class CongkhaicpController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.ckcp')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Ckcp;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->ten != "" && $dt->soluong != ""){
            	$dataInport = array(
                    'ten'  => $dt->ten,
                    'so_luong' => $dt->soluong,
                    'muc_dich_su_dung'   => $dt->mdsd,
                    'dtsd'   => $dt->dtsd,
                    'dien_tich'   => $dt->dtsxd,
                    'so_huu'   => $dt->sohuu,
                    'lien_ket'   => $dt->lienket,
                    'thue'   => $dt->thue,
                    
                );
                DB::table("excel_import_tt_phong")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCkcp() {
        return Excel::download(new CkcpExport, 'Cong-khai-cac-phong.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tt_phong AS ckcp");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ckcp.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ckcp.id', 'ckcp.ten', 'ckcp.so_luong',
	                 'ckcp.muc_dich_su_dung','ckcp.dtsd','ckcp.dien_tich','ckcp.so_huu','ckcp.lien_ket',
                     'ckcp.thue');

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
        DB::table('excel_import_tt_phong')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'ten'  => $req->ten,
            'so_luong' => $req->soluong,
            'muc_dich_su_dung'   => $req->mdsd,
            'dtsd'   => $req->dtsd,
            'dien_tich'   => $req->dtsxd,
            'so_huu'   => $req->sohuu,
            'lien_ket'   => $req->lienket,
            'thue'   => $req->thue,
        ];
        DB::table("excel_import_tt_phong")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}