<?php namespace App\Http\Controllers\Admin\Project\Importdata\Hoithaohoinghi;
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
use App\Imports\Hoithaohn;

// export excel
use App\Exports\HoithaohoinghiExport;


class Hoithaohoinghi extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $dvex = DB::table("excel_import_donvi")->select("ten_donvi_TV", "ma_donvi", "id")->get();
		
        return view('admin.project.Importdata.hoithaohn')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
            'dvex'              => $dvex,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Hoithaohn;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->chude != "" ){
                $iddv = DB::table("excel_import_donvi")->select("id", "ma_donvi")
                        ->where("ma_donvi",  $dt->dvct)->first();
                $dataInport = array(
                    'chude' => $dt->chude,
                    'dvct' => $iddv->id,
                    'diadiem' => $dt->diadiem,
                    'tgtc' => $dt->tgtc,
                    'sodb' => $dt->sodb,
                    'ghichu' => $dt->ghichu,
                );
                DB::table("excel_import_hoithohn")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel giải thưởng
    public function exportUnit() {
        return Excel::download(new HoithaohoinghiExport, 'Hội thảo hội nghị.xlsx');
    }

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_hoithohn AS gtex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("gtex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        return DataTables::of($donviExcel) 
                ->addColumn(
                    'stt',
                    function ($donvi) {
                        return "";
                    }
                )            
                ->addColumn(
                    'donvicap',
                    function ($donvi) {
                        $iddv = DB::table("excel_import_donvi")->select("id", "ten_donvi_TV", "ma_donvi")
                                ->where("id",  $donvi->dvct)->first();
                        return $iddv->ten_donvi_TV;
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
        DB::table('excel_import_hoithohn')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'chude' => $req->chude,
            'dvct' => $req->dvct,
            'diadiem' => $req->diadiem,
            'tgtc' => $req->tgtc,
            'sodb' => $req->sodb,
            'ghichu' => $req->ghichu,		
        ];
        DB::table("excel_import_hoithohn")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}