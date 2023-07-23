<?php namespace App\Http\Controllers\Admin\Project\Importdata\Congkhaitcnh;
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
use App\Imports\Cksvtn;

// export excel
use App\Exports\CksvtnExport;
use App\Exports\CktcnhExport;

class CongkhaitcnhController extends DefinedController{

	public function index(){
        return view('admin.project.Importdata.cktcnh')->with([
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Cksvtn;
        Excel::import($excel, $req->file);
        return $excel->read();
    }
    public function updatedata(Request $req){
        $find = DB::table("excel_import_tcnh")
                ->where("parent_II", $req->childGloble)
                ->where("nam", $req->year)->delete();
        foreach($req->donvitinhArr as $key => $donvitinhArr){
            if($donvitinhArr != "" && $req->hp1namArr[$key] != "" && $req->hpkhoaArr[$key] != ""){
                $data = [
                    'parent_I'  => $this->convertParentGloble($req->parentGloble),
                    'parent_II' => $req->childGloble,
                    'ten_khoinganh' => count($req->khoinganhArr) == 0 ? null : $req->khoinganhArr[$key],
                    'hocphi_1nam'   => $req->hp1namArr[$key],
                    'hocphi_cakhoa' => $req->hpkhoaArr[$key],
                    'donvitinh'     => $donvitinhArr,
                    'nam'           => $req->year
                ];
                DB::table("excel_import_tcnh")->insert($data);
            }
        }
        return json_encode([
            'mes' => 'done'
        ]);
    }
    public function convertParentGloble($parentGloble){
        if($parentGloble == "I"){
            return "1";
        }
        else if($parentGloble == "II"){
            return "2";
        }else if($parentGloble == "III"){
            return "3";
        }else if($parentGloble == "IV"){
            return "4";
        }else return null;
    }
    public function loaddata(Request $req){
        $parent_I = $this->convertParentGloble($req->parentGloble);
        $parent_II = $req->childGloble;
        $find = DB::table("excel_import_tcnh")->where("nam", $req->year)
                ->where("parent_I", $parent_I)
                ->where("parent_II" , $parent_II)
                ->get();
    
        return json_encode($find);

    }


    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->khoinganh != "" && $dt->ssvtn != ""){
            	$dataInport = array(
                    'khoi_nganh'  => $dt->khoinganh,
                    'ssvtn' => $dt->ssvtn,
                    'xuat_sac'   => $dt->loaixs,
                    'gioi'   => $dt->loaig,
                    'kha'   => $dt->loaikha,
                    'ty_le'   => $dt->tlsncvl,
                    
                );
                DB::table("excel_import_svtn_cvl")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportCktcnh() {
        return Excel::download(new CktcnhExport, 'Cong khai tài chính năm học.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_svtn_cvl AS cksvtn");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("cksvtn.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('cksvtn.id', 'cksvtn.khoi_nganh', 'cksvtn.ssvtn',
	                 'cksvtn.xuat_sac','cksvtn.gioi','cksvtn.kha','cksvtn.ty_le');

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
        DB::table('excel_import_svtn_cvl')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'khoi_nganh'  => $req->khoinganh,
            'ssvtn' => $req->ssvtn,
            'xuat_sac'   => $req->loaixs,
            'gioi'   => $req->loaig,
            'kha'   => $req->loaikha,
            'ty_le'   => $req->tlsncvl,
        ];
        DB::table("excel_import_svtn_cvl")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}