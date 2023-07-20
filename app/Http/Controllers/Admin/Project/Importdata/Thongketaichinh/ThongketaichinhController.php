<?php namespace App\Http\Controllers\Admin\Project\Importdata\Thongketaichinh;
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
use App\Imports\Tktaichinh;
// export excel
use App\Exports\Tktcexport;


class ThongketaichinhController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.tktc')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Tktaichinh;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $key => $dt){
            if($dt->noidung != "" ){
            	$dataInport = array(
                    'noi_dung'  => $dt->noidung,
                );
                $id = DB::table("excel_import_tk_tai_chinh")->insertGetId($dataInport);
                foreach((array)$dt as $year => $money){
                    if($year != 'noidung'){
                        $dataImport2 = array(
                            'parent_id'  => $id,
                            'nam'       => $year,
                            'doanhthu'  => $money
                        );
                        DB::table("excel_import_tk_tai_chinh")->insert($dataImport2);
                    }
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportTktc() {
        return Excel::download(new Tktcexport, 'Thông kê tài chính.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tk_tai_chinh AS tktc");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tktc.id", $req->id)->first();
            $child = DB::table("excel_import_tk_tai_chinh AS tktc")
                    ->where("parent_id", $donviExcel->id)->get();
            return json_encode([$donviExcel, $child]);
        }else{
	        $donviExcel = $donviExcel
                    ->where('parent_id', null)
	                ->select('tktc.id', 'tktc.noi_dung');

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
        DB::table('excel_import_tk_tai_chinh')->where("id", $req->id_delete)->delete();
        DB::table('excel_import_tk_tai_chinh')->where("parent_id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
        $parent = DB::table("excel_import_tk_tai_chinh")->where("parent_id", null)
                ->where("id", $req->id_unit);

    	$data = [
            'noi_dung'  => $req->noidung,
        ];
        $parent->update($data);
        
        DB::table("excel_import_tk_tai_chinh")->where("parent_id", $req->id_unit)->delete();


        foreach($req->id_nam as $key => $value){
            if($value != "" && $req->doanhthu[$key] != ""){
                $data2 = [
                    'parent_id' => $req->id_unit,
                    'nam'       => $value,
                    'doanhthu'  => $req->doanhthu[$key]
                ];
                DB::table("excel_import_tk_tai_chinh")->insert($data2);
            }
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}