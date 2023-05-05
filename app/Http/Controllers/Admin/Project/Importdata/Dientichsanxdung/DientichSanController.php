<?php namespace App\Http\Controllers\Admin\Project\Importdata\Dientichsanxdung;
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
use App\Exports\DtSanExport;


class DientichSanController extends DefinedController{

	public function index(){
		$dtsan = DB::table("excel_import_dientich_xaydung")->get();

		
        return view('admin.project.Importdata.dtsxd')->with([
           	'dtsan'           => $dtsan,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        // $excel = new Chtrinhdaotao;
        // Excel::import($excel, $req->file);
        // return $excel->read();
        return json_encode("ok");
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->content != "" && $dt->stt != "" ){
            	$dataInport = array(
                    'stt'  => $dt->stt,
                    'parent' => $dt->parent,
                    'noi_dung' => $dt->content,
                    'dien_tich' => $dt->dientich,
                    'so_huu' => $dt->sohuu,
                    'lien_ket' => $dt->lienket,
                    'thue' => $dt->thue,
                );
                DB::table("excel_import_dientich_xaydung")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportDtSan() {
        return Excel::download(new DtSanExport, 'DtSanExport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_dientich_xaydung AS ctdt");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ctdt.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ctdt.id', 'ctdt.khoa_BM', 'ctdt.cndt',
	                 'ctdt.ma_nganh', 'ctdt.ten_ctdt', 'ctdt.nam_bddt');

	        return DataTables::of($donviExcel)          
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
            'dien_tich'  => $req->dientich,
            'so_huu' => $req->sohuu,
            'lien_ket' => $req->lienket,
            'thue' => $req->thue,
        ];
        DB::table("excel_import_dientich_xaydung")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}