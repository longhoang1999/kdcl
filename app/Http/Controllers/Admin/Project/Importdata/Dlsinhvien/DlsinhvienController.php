<?php namespace App\Http\Controllers\Admin\Project\Importdata\Dlsinhvien;
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
use App\Imports\DataStudent;

// export excel
use App\Exports\StudentExport;

class DlsinhvienController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.data_student')->with([
           	'loai_dv'           => $loai_dv,
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new DataStudent;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->msv != "" ){
            	$check = DB::table("excel_import_dlsinhvien")->where("masv", $dt->msv);
            	if($check->count() == 0){
	                $dataInport = array(
	                    'masv'  => $dt->msv,
	                    'ho' => $dt->ho,
	                    'ten' => $dt->ten,
						'ntns' => $dt->ntns,
						'gioitinh' => $dt->gioitinh,
						'email' => $dt->email,
						'phone' => $dt->phone,
						'cccd' => $dt->cccd,
	                    'lop'  => $dt->lop,
	                    'xa'  => $dt->xa,
	                    'huyen'   => $dt->huyen,
	                    'tinh' => $dt->tinh,
	                    'dantoc'		=> $dt->dantoc,
	                    'quoctich'	=> $dt->quoctich,
	                    'tennganh'		=> $dt->tennganh,
	                    'manganh'	=> $dt->manganh,
	                    'manganhTS'	=> $dt->manganhts,
	                    'kqxhtnam1'	=> $dt->kqxhtnam1,
	                    'kqxhtnam2'	=> $dt->kqxhtnam2,
	                    'kqxhtnam3'		=> $dt->kqxhtnam3,
	                    'kqxhtnam4'		=> $dt->kqxhtnam4,
	                    'kqxhtnam5'		=> $dt->kqxhtnam5,
	                    'nbdck'		=> $dt->nbdck,
	                    'nktkh'		=> $dt->nktkh,
	                    'trangthai'		=> $dt->trangthai,
	                    'namnh'		=> $dt->namnh,
	                    'namtn'		=> $dt->namtn,
	                    'namqd'		=> $dt->namqd,
	                    'namnb'		=> $dt->namnb,
	                    'baocaobo'		=> $dt->baocaobo,
	                    'trinhdo'		=> $dt->trinhdo,
	                    'namdulien'		=> $dt->namdulien,

	                );
	                DB::table("excel_import_dlsinhvien")->insert($dataInport);
	            }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }

//Export excel Admissions
public function exportUnit() {
	return Excel::download(new StudentExport, 'student.xlsx');
}

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_dlsinhvien AS dlex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("dlex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('dlex.id', 'dlex.masv', 'dlex.ho','dlex.ten',
	            	'dlex.tennganh', 'dlex.nbdck', 'dlex.trinhdo');

	        return DataTables::of($donviExcel)  
	        	->addColumn(
	                'hoten',
	                function ($donvi) {
	                    return $donvi->ho . " " . $donvi->ten ;
	                }
	            )   
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
        DB::table('excel_import_dlsinhvien')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'masv'  => $req->msv,
            'ho'  => $req->ho,
            'ten'  => $req->ten,
			'ntns'  => $req->ntns,
			'gioitinh'  => $req->gioitinh,
			'email' => $req->email,
			'phone' => $req->phone,
			'cccd' => $req->cccd,
            'lop'  => $req->lop,
            'xa'  => $req->xa,
            'huyen'  => $req->huyen,
            'tinh'  => $req->tinh,
            'dantoc'  => $req->dantoc,
            'quoctich'  => $req->quoctich,
            'tennganh'  => $req->tennganh,
            'manganh'  => $req->manganh,
            'manganhTS'  => $req->manganhts,
            'kqxhtnam1'  => $req->kqxhtnam1,
            'kqxhtnam2'  => $req->kqxhtnam2,
            'kqxhtnam3'  => $req->kqxhtnam3,
            'kqxhtnam4'  => $req->kqxhtnam4,
            'kqxhtnam5'  => $req->kqxhtnam5,
            'nbdck'  => $req->nbdck,
            'nktkh'  => $req->nktkh,
            'trangthai'  => $req->trangthai,
            'namnh'  => $req->namnh,
            'namtn'  => $req->namtn,
            'namqd'  => $req->namqd,
            'namnb'  => $req->namnb,
            'baocaobo'  => $req->baocaobo,
            'trinhdo'  => $req->trinhdo,
            'namdulien'  => $req->namdulien,
        ];
        DB::table("excel_import_dlsinhvien")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}