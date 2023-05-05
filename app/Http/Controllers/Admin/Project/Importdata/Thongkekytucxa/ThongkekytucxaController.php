<?php namespace App\Http\Controllers\Admin\Project\Importdata\Thongkekytucxa;
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
use App\Imports\Tkkytucxa;
// export excel
use App\Exports\Tkktxexport;


class ThongkekytucxaController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.tkktx')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Tkkytucxa;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->noidung != "" ){
            	$dataInport = array(
                    'noi_dung'  => $dt->noidung,
                    'n_2019' => $dt->n_2019,
                    'n_2020' => $dt->n_2020,
                    'n_2021' => $dt->n_2021,
                    'n_2022' => $dt->n_2022,
                    'n_2023' => $dt->n_2023,
                    
                );
                DB::table("excel_import_tk_ktx")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportTkktx() {
        return Excel::download(new Tkktxexport, 'Tkktxexport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tk_ktx AS tkktx");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tkktx.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tkktx.id', 'tkktx.noi_dung', 'tkktx.n_2019',
	                 'tkktx.n_2020', 'tkktx.n_2021', 'tkktx.n_2022','tkktx.n_2023');

	        return DataTables::of($donviExcel)          
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
        DB::table('excel_import_tk_ktx')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'noi_dung'  => $req->noidung,
            'n_2019' => $req->n_2019,
            'n_2020' => $req->n_2020,
            'n_2021' => $req->n_2021,
            'n_2022' => $req->n_2022,
            'n_2023' => $req->n_2023,
        ];
        DB::table("excel_import_tk_ktx")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}