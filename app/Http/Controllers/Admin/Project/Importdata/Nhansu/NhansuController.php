<?php namespace App\Http\Controllers\Admin\Project\Importdata\Nhansu;
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
use App\Imports\Nhansu;

// export excel
use App\Exports\UnitsExport;

class NhansuController extends DefinedController{

	public function index(){
		$donvi = DB::table("excel_import_donvi")
				->select("id", "ten_donvi_TV", "ma_donvi")
                ->where("deleted_at", null)
                ->get();
		
        return view('admin.project.Importdata.personnel')->with([
           	'donvi'             => $donvi,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new Nhansu;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->thoidiem != "" && $dt->hodem != "" && $dt->ten != ""){
                //$check = DB::table("excel_import_nhansu")->where("ma_donvi", $dt->madv);
                $iddv = DB::table("excel_import_donvi")->select("id", "ma_donvi")
                        ->where("ma_donvi",  $dt->dvsdvc)->first();
                $dataInport = array(
                    'thoidiem' =>   $dt->thoidiem,
                    'hodem' =>   $dt->hodem,
                    'ten' =>   $dt->ten, 
                    'shvc' =>   $dt->shvc, 
                    'cccd' =>   $dt->cccd, 
                    'dvct' =>   $dt->dvct, 
                    'phone' =>   $dt->phone,
                    'email' =>   $dt->email,
                    'gender' =>   $dt->gender,
                    'ngaysinh' =>   $dt->ngaysinh,
                    'quoctich' =>   $dt->quoctich,
                    'tdcm'	=>   $dt->tdcm,
                    'tdnv' =>   $dt->tdnv,
                    'namtn' =>   $dt->namtn,
                    'noitn' =>   $dt->noitn,
                    'gvsp' =>   $dt->gvsp,
                    'qlnn' =>   $dt->qlnn,
                    'llct' =>   $dt->llct,
                    'tinhoc' =>   $dt->tinhoc,
                    'ngoaingu' =>   $dt->ngoaingu,
                    'hocham' =>   $dt->hocham,
                    'namphong' =>   $dt->namphong,
                    'cdnn' =>   $dt->cdnn,
                    'masocd' =>   $dt->masocd,
                    'namtd' =>   $dt->namtd,
                    'cdnnht' =>   $dt->cdnnht,
                    'masocdht' =>   $dt->masocdht,
                    'chuyenngach' =>   $dt->chuyenngach,
                    'namcn' =>   $dt->namcn,
                    'dvsdvc'  =>   $iddv->id,
                    'cdctht' =>   $dt->cdctht,
                    'tdbn'	=>   $dt->tdbn,
                    'qdbn' =>   $dt->qdbn,
                    'cdkm' =>   $dt->cdkm,
                    'tdgkm'  =>   $dt->tdgkm,
                    'loaihd' =>   $dt->loaihd,
                    'shdtd' =>   $dt->shdtd,
                    'ngaycdhd' =>   $dt->ngaycdhd,
                    'tggdht' =>   $dt->tggdht,
                    'nvdpc' =>   $dt->nvdpc,
                    'ltggd' =>   $dt->ltggd,
                    'khbd' =>   $dt->khbd,
                    'xa' =>   $dt->xa,
                    'huyen' =>   $dt->huyen,
                    'tinh' =>   $dt->tinh,
                    'trangthai' =>   $dt->trangthai,
                );
                DB::table("excel_import_nhansu")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Unit
	public function ExportUnit() {
        return Excel::download(new UnitsExport, 'unit.xlsx');
    }
    
    public function dataUnit(Request $req){
    	$nhansuExcel = DB::table("excel_import_nhansu AS nsex");
        if(isset($req->id) && $req->id != ''){
            $nhansuExcel = $nhansuExcel->where("nsex.id", $req->id)->first();
            return json_encode($nhansuExcel);
        }else{
	        $nhansuExcel = $nhansuExcel
	        		//->leftjoin('loai_donvi AS ldv', 'dvex.loai_dv_id', '=', 'ldv.id')
	                ->select('nsex.id', 'nsex.thoidiem', 'nsex.hodem', 'nsex.ten',
	            		'nsex.tdcm', 'nsex.loaihd', 'nsex.trangthai');

	        return DataTables::of($nhansuExcel)  
            ->addColumn(
                'stt',
                function ($donvi) {
                    return "";
                }
            ) 
	        	->addColumn(
	                'fullname',
	                function ($nhansu) {
	                    return $nhansu->hodem . " " . $nhansu->ten;
	                }
	            )             
	            ->addColumn(
	                'actions',
	                function ($nhansu) {
	                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$nhansu->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>'; 
	                    $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$nhansu->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>'.'</button>';
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions', 'fullname'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('excel_import_nhansu')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'thoidiem'  => $req->thoidiem,
            'hodem' => $req->hodem,
            'ten' => $req->ten,
            'shvc'  => $req->shvc,
            'cccd' =>   $req->cccd, 
            'dvct' =>   $req->dvct, 
            'phone'  => $req->dienthoai,
            'email'   => $req->email,
            'gender' => $req->gioitinh,
            'ngaysinh'		=> $req->ngaysinh,
            'quoctich'	=> $req->quoctich,
            'tdcm'		=> $req->tdcmcn,
            'tdnv'			=> $req->tdnvtcn,
            'namtn'			=> $req->ntn,
            'noitn'			=> $req->noitn,
            'gvsp'			=> $req->GVSP,
            'qlnn'		=> $req->QLNN,
            'llct'		=> $req->LLCT,
            'tinhoc'		=> $req->tinhoc,
            'ngoaingu'		=> $req->ngoaingu,
            'hocham'		=> $req->hhdp,
            'namphong'		=> $req->ndp,
            'cdnn'		=> $req->cdnnktd,
            'masocd'		=> $req->mscdktd,
            'namtd'		=> $req->ntd,
            'cdnnht'		=> $req->cdnnht,
            'masocdht'		=> $req->mscdht,
            'chuyenngach'		=> $req->ccn,
            'namcn'		=> $req->ncn,
            'dvsdvc'		=> $req->dvsdvc,
            'cdctht'		=> $req->cdctht,
            'tdbn'		=> $req->tdbm,
            'qdbn'		=> $req->qdbm,
            'cdkm'		=> $req->cdkm,
            'tdgkm'		=> $req->tdgkm,
            'loaihd'		=> $req->lhdlv,
            'shdtd' =>   $req->shdtd,
            'ngaycdhd'		=> $req->ncdhd,
            'tggdht'		=> $req->tggd,
            'nvdpc'		=> $req->nvdpc,
            'ltggd'		=> $req->ltggd,
            'khbd'		=> $req->ckhbd,
            'xa' =>   $req->xa,
            'huyen' =>   $req->huyen,
            'tinh' =>   $req->tinh,
            'trangthai'		=> $req->trangthai

        ];
        DB::table("excel_import_nhansu")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}