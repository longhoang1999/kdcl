<?php namespace App\Http\Controllers\Admin\Project\Importdata\Thongkemaytinh;
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
use App\Imports\Tkmaytinh;
// export excel
use App\Exports\Tkmtexport;


class ThongkemaytinhController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.tkmt')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Tkmaytinh;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->donvi != "" && $dt->tongso != ""){
            	$dataInport = array(
                    'don_vi'  => $dt->donvi,
                    'tong_so' => $dt->tongso,
                    'so_may_moi'   => $dt->tongso,
                    'so_may_cu'   => $dt->smc,
                    'dchtvp'  => $dt->dcvp,
                    'dcht'  => $dt->dcht,
                    'ghi_chu' => $dt->ghichu,
                    
                );
                DB::table("excel_import_tk_mt")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel 
	public function exportTkmt() {
        return Excel::download(new Tkmtexport, 'Tkmtexport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tk_mt AS tkmt");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tkmt.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tkmt.id', 'tkmt.don_vi', 'tkmt.tong_so',
	                 'tkmt.so_may_moi', 'tkmt.so_may_cu', 'tkmt.dchtvp','tkmt.dcht','tkmt.ghi_chu');

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
        DB::table('excel_import_tk_mt')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'don_vi'  => $req->donvi,
            'tong_so' => $req->tongso,
            'so_may_moi' => $req->smm,
            'so_may_cu' => $req->smc,
            'dchtvp' => $req->dcvp,
            'dcht' => $req->dcht,
            'ghi_chu' => $req->ghichu,
        ];
        DB::table("excel_import_tk_mt")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}