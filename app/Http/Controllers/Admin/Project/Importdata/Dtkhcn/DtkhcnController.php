<?php namespace App\Http\Controllers\Admin\Project\Importdata\Dtkhcn;
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
use App\Imports\Dtkhcn;

// export excel
use App\Exports\DtkhcnExport;

class DtkhcnController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $dvex = DB::table("excel_import_donvi")->select("ten_donvi_TV", "ma_donvi", "id")->get();
		
        return view('admin.project.Importdata.dtkhcn')->with([
            'dvex'              => $dvex,
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Dtkhcn;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->mahd != ""){
                $check = DB::table("export_import_dtkhcn")->where("mahd", $dt->mahd);
                if($check->count() == 0){
                    $iddv = DB::table("excel_import_donvi")->select("id", "ma_donvi")
                        ->where("ma_donvi",  $dt->dvtn)->first();
                    $dataInport = array(
                        'tenhd'  => $dt->tenhd,
                        'mahd' => $dt->mahd,
                        'sanphamcua' => $dt->sanphamcua,
                        'dvtn' => $iddv->id,
                        'namcg' => $dt->namcg,
                        'stcg' => $dt->stcg,
                        'trangthai' => $dt->trangthai,
                    );
                    DB::table("export_import_dtkhcn")->insert($dataInport);
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
	return Excel::download(new DtkhcnExport, 'dtkhcn.xlsx');
    }
    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("export_import_dtkhcn AS dtkhcnex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("dtkhcnex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('dtkhcnex.id', 'dtkhcnex.tenhd', 'dtkhcnex.mahd', 'dtkhcnex.dvtn',
	                 'dtkhcnex.namcg', 'dtkhcnex.trangthai');

	        return DataTables::of($donviExcel)           
                ->addColumn(
                    'actions',
                    function ($donvi) {
                        $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
                        $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>'; 
                        return $actions;
                    }
                )
                ->addColumn(
                    'donvitn',
                    function ($donvi) {
                        $iddv = DB::table("excel_import_donvi")->select("id", "ten_donvi_TV", "ma_donvi")
                                ->where("id",  $donvi->dvtn)->first();
                        return $iddv->ten_donvi_TV;
                    }
                )   
                ->addColumn(
					'stt',
					function ($donvi) {
						return "";
					}
				) 
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('export_import_dtkhcn')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tenhd'  => $req->tenhd,
            'mahd' => $req->mahd,
            'sanphamcua' => $req->sanphamcua,
            'dvtn' => $req->dvtn,
            'namcg' => $req->namcg,
			'stcg'=> $req->stcg,
			'trangthai'=> $req->trangthai,
        ];
        DB::table("export_import_dtkhcn")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}