<?php namespace App\Http\Controllers\Admin\Project\Importdata\Bssach;
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
use App\Imports\CompilationBook;

// export excel
use App\Exports\CompilationBookExport;

class BssachController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $dvex = DB::table("excel_import_donvi")
                    ->select("ten_donvi_TV", "ma_donvi", "id")
                    ->get();
        if(Sentinel::inRole('ttchuyentrach')){
            $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',5)
                            ->first();
            if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    return view('admin.project.Importdata.compilation_book')->with([
                        'loai_dv'           => $loai_dv,
                        'donvi'             => $donvi,
                        'dvex'              => $dvex
                    ]);
            }else{
                return redirect()->back();
            }

        }

        return view('admin.project.Importdata.compilation_book')->with([
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'dvex'              => $dvex
        ]);
		
        
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new CompilationBook;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if(true){
                $iddv = DB::table("excel_import_donvi")->select("id", "ma_donvi")
                        ->where("ma_donvi",  $dt->donvi)->first();
                $dataInport = array(
                    'donvi'  => $iddv->id,
                    'masach'  => $dt->masach,
                    'tensach' => $dt->tensach,
                    'loaisach' => $dt->loaisach,
                    'chubien' => $dt->chubien,
                    'thanhvien' => $dt->thanhvien,

                    'dvchutri' => $dt->dvchutri,
                    'tgdk' => $dt->tgdk,
                    'tgnt' => $dt->tgnt,
                    'tgxb' => $dt->tgxb,

                    'namdk' => $dt->namdk,
                    'namnt' => $dt->namnt,
                    'namxb' => $dt->namxuatban,
                    'nhaxb' => $dt->nhaxuatban,
                    'hpsd' => $dt->hpsd,
                    'nhsd' => $dt->nhsd,
                    'trangthai' => $dt->trangthai
                );
                DB::table("excel_import_biensoansach")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Biên soạn sách
    public function exportUnit() {
        return Excel::download(new CompilationBookExport, 'Biên soạn sách.xlsx');
        }

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_biensoansach AS bssex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("bssex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('bssex.id', 'bssex.tensach', 'bssex.loaisach',
	                 'bssex.chubien', 'bssex.hpsd', 'bssex.trangthai');

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
        DB::table('excel_import_biensoansach')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'donvi'  => $req->donvi,
            'masach'  => $req->masach,
            'tensach' => $req->tensach,
            'loaisach' => $req->loaisach,
            'chubien' => $req->chubien,
            'thanhvien' => $req->thanhvien,

            'dvchutri' => $req->dvchutri,
            'tgdk' => $req->tgdk,
            'tgnt' => $req->tgnt,
            'tgxb' => $req->tgxb,

            'namdk' => $req->namdk,
            'namnt'	=> $req->namnt,
            'namxb' => $req->namxuatban,
            'nhaxb' => $req->nhaxuatban,
            'hpsd' => $req->hpsd,
            'nhsd' => $req->nhsd,
            'trangthai' => $req->trangthai,
        ];
        DB::table("excel_import_biensoansach")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}