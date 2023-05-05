<?php namespace App\Http\Controllers\Admin\Project\Importdata\Sangche;
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
use App\Imports\Invent;

// export excel
use App\Exports\InventExport;

class SangcheController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.invent')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Invent;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->maso != "" ){
                $check = DB::table("excel_import_sangche")->where("maso", $dt->maso);
                if($check->count() == 0){
                    $dataInport = array(
                        'tpmsc'  => $dt->tpmsc,
                        'maso' => $dt->maso,
                        'loai' => $dt->loai,
                        'tacgia' => $dt->tacgia,
                        'cshcn' => $dt->cshcn,
                        'cshdv' => $dt->cshdv,
                        'linhvuc' => $dt->linhvuc,
                        'scn' => $dt->socongnhan,
                        'namcap' => $dt->namcap,
                        'noicap' => $dt->noicap,
                    );
                    DB::table("excel_import_sangche")->insert($dataInport);
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel sáng chế
    public function exportUnit() {
        return Excel::download(new InventExport, 'invent.xlsx');
    }

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_sangche AS scex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("scex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('scex.id', 'scex.tpmsc', 'scex.cshcn',
	                 'scex.cshdv', 'scex.scn', 'scex.namcap');

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
        DB::table('excel_import_sangche')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tpmsc'  => $req->tpmsc,
            'maso' => $req->maso,
            'loai' => $req->loai,
            'tacgia' => $req->tacgia,
            'cshcn' => $req->cshcn,
            'cshdv' => $req->cshdv,
            'linhvuc' => $req->linhvuc,
            'scn' => $req->socongnhan,
            'namcap' => $req->namcap,
            'noicap' => $req->noicap,
        ];
        DB::table("excel_import_sangche")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}