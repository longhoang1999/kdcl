<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Nhansu;
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
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '12')->select("id", "year")->get();
        $phanquen = DB::table('lkh_phanquyen_excel')
        ->where('bang_stt',12)
        ->first();
		// Phân quyền
        if(Sentinel::inRole('truongdonvi')){
            if($phanquen){
                if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    if(Carbon::now() > $phanquen->ngay_bd  && Carbon::now() < $phanquen->ngay_kt){
                        return view('admin.project.Importdata2.personnel')->with([
                            'loai_dv'           => $loai_dv,
                            'donvi'             => $donvi,
                            'getFile'           => $getFile
                        ]);
                    }else{
                        return redirect()->back()->with("error", "Hết thời gian lên kế hoạch");
                    }
                }
            }
        }

        if(Sentinel::inRole('canboDBCL')){
            $donvi = DB::table("donvi")->where("canbo_dbcl", Sentinel::getUser()->id)->first();
            if($phanquen && $donvi){
                if($phanquen->donvi_id == $donvi->id){
                    if(Carbon::now() > $phanquen->ngay_bd  && Carbon::now() < $phanquen->ngay_kt){
                        return view('admin.project.Importdata2.personnel')->with([
                            'loai_dv'           => $loai_dv,
                            'donvi'             => $donvi,
                            'getFile'           => $getFile
                        ]);
                    }else{
                        return redirect()->back()->with("error", "Hết thời gian lên kế hoạch");
                    }
                }
            }
        }
        
        if($phanquen){
            if(Sentinel::getUser()->id == $phanquen->nskt_id){
                return view('admin.project.Importdata2.personnel')->with([
                    'loai_dv'           => $loai_dv,
                    'donvi'             => $donvi,
                    'getFile'           => $getFile,
                    'kiemtra'           => 'nskt'
                ]);
            }
        }


        if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){
            return view('admin.project.Importdata2.personnel')->with([
                'loai_dv'           => $loai_dv,
                'donvi'             => $donvi,
                'getFile'           => $getFile
            ]);
        }
        return redirect()->back()->with("error", "Bạn không có quyền lập kế hoạch cho bảng này");

        
        
	}

    public function showFileData(Request $req){
        $getFile = DB::table('excel_import_data2')->where('id',$req->id )
                    ->first();
        $address = public_path($getFile->url);
        $a = Excel::toArray([],$address);
        $table = "";
        $UI = "";
        foreach($a[0] as $key => $value) {
            $td = "";
            if($key == 0){
                foreach($value as $val){
                    if(trim($val) != ""){
                        $td .=   '<th>'.  trim($val)   .'</th>';
                    }
                }
            }else{
                foreach($value as $val){
                    if(trim($val) != ""){
                        $td .=   '<td>'.  trim($val) .'</td>';
                    }
                }
            }
            if( $td != ""){
                $UI .= '<tr>
                            '.$td.'
                        </tr>  
                ';
            }
        }
        $table = '<table class="table ">' . $UI . '</table>';
        return json_encode([
            'data'  => $table,
            'href'  => asset($getFile->url)
        ]);
    }

    public function addfilenew(Request $req) {
        if($req->file('file') != null){
            $check = DB::table('excel_import_data2')->where("type_excel", '12')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Nhansu'), $picName);

            $data = [
                'type_excel'    => '12',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Nhansu/'.$picName,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
            DB::table('excel_import_data2')->insert($data);
        }
        return back()->with('success', 
                Lang::get('project/Standard/message.success.create'));
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
                    'phone' =>   $dt->phone,
                    'email' =>   $dt->email,
                    'gender' =>   $dt->gender,
                    'ngaysinh' =>  date("Y-m-d", strtotime($dt->ngaysinh)),
                    'quoctich' =>   $dt->quoctich,

                    'sosobh' =>   $dt->sosobh,
                    'xaphuongtc' =>   $dt->xaphuongtc,
                    'quanhuytc' =>   $dt->quanhuytc,
                    'tinhtptc' =>   $dt->tinhtptc,
                    'cvct' =>   $dt->cvct,
                    'dvct' =>   $dt->dvct,
                    'chdanh' =>   $dt->chdanh,
                    'tddt' =>   $dt->tddt,
                    'cmdt' =>   $dt->cmdt,
                    'csdt' =>   $dt->csdt,
                    'namtn' =>   $dt->namtn,
                    'ccspgv' =>   $dt->ccspgv,

                    'ttqlnn' =>   $dt->ttqlnn,
                    'tdllct' =>   $dt->tdllct,
                    'tinhoc' =>   $dt->tinhoc,
                    'ngoaingu' =>   $dt->ngoaingu,
                    'cdnnktd' =>   $dt->cdnnktd,
                    'mscdktd' =>   $dt->mscdktd,
                    'ntd' =>   $dt->ntd,
                    'cdnnht' =>   $dt->cdnnht,
                    'mscdht' =>   $dt->mscdht,
                    'ccn' =>   $dt->ccn,
                    'ncn' =>   $dt->ncn,
                    'dvsdvc' =>   $dt->dvsdvc,
                    'cdctht' =>   $dt->cdctht,
                    'tdbm' =>   $dt->tdbm,
                    'qdbm' =>   $dt->qdbm,
                    'htbn' =>   $dt->htbn,
                    'nqdbn' =>   $dt->nqdbn,
                    'cdnn' =>   $dt->cdnn,
                    'cdgv' =>   $dt->cdgv,
                    
                    'cdkm' =>   $dt->cdkm,
                    'tdgkm' =>   $dt->tdgkm,
                    'lhdlv' =>   $dt->lhdlv,
                    'shdtd' =>   $dt->shdtd,
                    'nkhd' =>   $dt->nkhd,
                    
                    'ncdhd' =>   $dt->ncdhd,
                    'soqdnh' =>   $dt->soqdnh,
                    'ngqdnh' =>   $dt->ngqdnh,
                    'htcd' =>   $dt->htcd,
                    'tggd' =>   $dt->tggd,
 
                    'nvdpc' =>   $dt->nvdpc,
                    'ltggd' =>   $dt->ltggd,
                    'ckhbd' =>   $dt->ckhbd,
                    'ttlamv' =>   $dt->ttlamv,
                    'tncongt' =>   $dt->tncongt,
                    'bacl' =>   $dt->bacl,
                    'hesol' =>   $dt->hesol,
                    'pcthamn' =>   $dt->pcthamn,
                    'pcudn' =>   $dt->pcudn,
                    'pccv' =>   $dt->pccv,
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
        return Excel::download(new UnitsExport, 'Thông tin nhân sự.xlsx');
    }
    
    public function dataUnit(Request $req){
    	$nhansuExcel = DB::table("excel_import_nhansu AS nsex");
        if(isset($req->id) && $req->id != ''){
            $nhansuExcel = $nhansuExcel->where("nsex.id", $req->id)->first();
            return json_encode($nhansuExcel);
        }else{
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
            'phone'  => $req->dienthoai,
            'email'   => $req->email,
            'gender' => $req->gioitinh,
            'ngaysinh'		=> $req->ngaysinh,
            'quoctich'	=> $req->quoctich,
            
            'sosobh' =>   $req->sosobh,
            'xaphuongtc' =>   $req->xaphuongtc,
            'quanhuytc' =>   $req->quanhuytc,
            'tinhtptc' =>   $req->tinhtptc,
            'cvct' =>   $req->cvct,
            'dvct' =>   $req->dvct,
            'chdanh' =>   $req->chdanh,
            'tddt' =>   $req->tddt,
            'cmdt' =>   $req->cmdt,
            'csdt' =>   $req->csdt,
            'namtn' =>   $req->namtn,
            'ccspgv' =>   $req->ccspgv,

            'ttqlnn' =>   $req->ttqlnn,
            'tdllct' =>   $req->tdllct,
            'tinhoc' =>   $req->tinhoc,
            'ngoaingu' =>   $req->ngoaingu,
            'cdnnktd' =>   $req->cdnnktd,
            'mscdktd' =>   $req->mscdktd,
            'ntd' =>   $req->ntd,
            'cdnnht' =>   $req->cdnnht,
            'mscdht' =>   $req->mscdht,
            'ccn' =>   $req->ccn,
            'ncn' =>   $req->ncn,
            'dvsdvc' =>   $req->dvsdvc,
            'cdctht' =>   $req->cdctht,
            'tdbm' =>   $req->tdbm,
            'qdbm' =>   $req->qdbm,
            'htbn' =>   $req->htbn,
            'nqdbn' =>   $req->nqdbn,
            'cdnn' =>   $req->cdnn,
            'cdgv' =>   $req->cdgv,
            
            'cdkm' =>   $req->cdkm,
            'tdgkm' =>   $req->tdgkm,
            'lhdlv' =>   $req->lhdlv,
            'shdtd' =>   $req->shdtd,
            'nkhd' =>   $req->nkhd,
            
            'ncdhd' =>   $req->ncdhd,
            'soqdnh' =>   $req->soqdnh,
            'ngqdnh' =>   $req->ngqdnh,
            'htcd' =>   $req->htcd,
            'tggd' =>   $req->tggd,

            'nvdpc' =>   $req->nvdpc,
            'ltggd' =>   $req->ltggd,
            'ckhbd' =>   $req->ckhbd,
            'ttlamv' =>   $req->ttlamv,
            'tncongt' =>   $req->tncongt,
            'bacl' =>   $req->bacl,
            'hesol' =>   $req->hesol,
            'pcthamn' =>   $req->pcthamn,
            'pcudn' =>   $req->pcudn,
            'pccv' =>   $req->pccv,


        ];
        DB::table("excel_import_nhansu")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}