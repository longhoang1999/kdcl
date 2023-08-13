<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Thongtincoban;
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
use App\Imports\BasicInformation;

// export excel
use App\Exports\BasiclnforExport;

class BasicInforController extends DefinedController{
	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '11')->select("id", "year")->get();
        $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',11)
                            ->first();
		// Phân quyền
        if(Sentinel::inRole('truongdonvi')){
            if($phanquen){
                if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    if(Carbon::now() > $phanquen->ngay_bd  && Carbon::now() < $phanquen->ngay_kt){
                        return view('admin.project.Importdata2.basic_information')->with([
                            'loai_dv'           => $loai_dv,
                            'donvi'             => $donvi,
                            'getFile'           => $getFile
                        ]);
                    }else{
                        // return redirect()->back()->with("error", "Hết thời gian lên kế hoạch");
                    }
                }
            }
        }

        if(Sentinel::inRole('canboDBCL')){
            $donvi = DB::table("donvi")->where("canbo_dbcl", Sentinel::getUser()->id)->first();
            if($phanquen && $donvi){
                if($phanquen->donvi_id == $donvi->id){
                    if(Carbon::now() > $phanquen->ngay_bd  && Carbon::now() < $phanquen->ngay_kt){
                        return view('admin.project.Importdata2.basic_information')->with([
                            'loai_dv'           => $loai_dv,
                            'donvi'             => $donvi,
                            'getFile'           => $getFile
                        ]);
                    }else{
                       // return redirect()->back()->with("error", "Hết thời gian lên kế hoạch");
                    }
                }
            }
        }
        
        // if($phanquen){
        //     if(Sentinel::getUser()->id == $phanquen->nskt_id){
        //         return view('admin.project.Importdata2.basic_information')->with([
        //             'loai_dv'           => $loai_dv,
        //             'donvi'             => $donvi,
        //             'getFile'           => $getFile,
        //             'kiemtra'           => 'nskt'
        //         ]);
        //     }
        // }


        if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){
            return view('admin.project.Importdata2.basic_information')->with([
                'loai_dv'           => $loai_dv,
                'donvi'             => $donvi,
                'getFile'           => $getFile
            ]);
        }


        return view('admin.project.Importdata2.basic_information')->with([
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'getFile'           => $getFile,
            'kiemtra'           => 'nskt'
        ]);
        //return redirect()->back()->with("error", "Bạn không có quyền lập kế hoạch cho bảng này");

        
        
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
            $check = DB::table('excel_import_data2')->where("type_excel", '11')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Thongtincoban'), $picName);

            $data = [
                'type_excel'    => '11',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Thongtincoban/'.$picName,
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
        $excel = new BasicInformation;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->tendvTV != "" && $dt->tendvTA != "" 
                    &&  $dt->tenvtTV != "" && $dt->tenvtTA
                    &&  $dt->ntl != "" 
                ){
                $check = DB::table("excel_import_donvi")->where("ma_donvi", $dt->madv);
                if($check->count() == 0){
                    $dataInport = array(
                        'ma_donvi'  => $dt->madv,
                        'ten_donvi_TV' => $dt->tendvTV,
                        'ten_donvi_TA' => $dt->tendvTA,
                        'viet_tat_TV'  => $dt->tenvtTV,
                        'viet_tat_TA'  => $dt->tenvtTA,
                        'loai_dv_id'   => $dt->loaidv,
                        'ten_truoc_day' => $dt->tenTD,

						'loaiht'	=> $dt->loaiht,
						'sqdcdlh'	=> $dt->sqdcdlh,
						'ntncdlh'	=> $dt->ntncdlh,

                        'chu_quan'		=> $dt->cqbcq,
                        'ngay_thanh_lap'	=> date("Y-m-d", strtotime($dt->ntl)),
						'soqd'			=> $dt->soqd,

						'soqdcapp'			=> $dt->soqdcapp,
						'ngcapphd'			=> $dt->ngcapphd,
						'plcs'				=> $dt->plcs,
						'lhcsdt'			=> $dt->lhcsdt,
						'soqdgtc'			=> $dt->soqdgtc,


                        'phone'			=> $dt->sdtlh,
                        'fax'			=> $dt->fax,
                        'email'			=> $dt->email,
                        'website'		=> $dt->website,
                        'ghichu'		=> $dt->notes,
                        'loai_hinh'		=> $dt->lhcsgd,
                        'tgdtk1'		=> $dt->tgdtk1,
                        'tgcbk1'		=> $dt->tgcbk1
                    );
                    DB::table("excel_import_donvi")->insert($dataInport);
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }
	//Export excel unit
	public function ExportBasiclnfor() {
        return Excel::download(new BasiclnforExport, 'Export_Thông tin cơ bản.xlsx');
    }

    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_donvi AS dvex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("dvex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	        		->leftjoin('loai_donvi AS ldv', 'dvex.loai_dv_id', '=', 'ldv.id')
	                ->select('dvex.id', 'dvex.ten_donvi_TV', 'dvex.ma_donvi',
	                 'dvex.loai_dv_id', 'dvex.ngay_thanh_lap', 'dvex.lv_hoat_dong',
	             	'ldv.loai_donvi');

	        return DataTables::of($donviExcel)  
				->addColumn(
					'stt',
					function ($donvi) {
						return "";
					}
				) 
	        	->addColumn(
	                'ngay_TL',
	                function ($donvi) {
	                    return date("d-m-Y", strtotime($donvi->ngay_thanh_lap));;
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
        DB::table('excel_import_donvi')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$check = DB::table("excel_import_donvi")->where("ma_donvi", $req->madv)
    		->where("id", "<>", $req->id_unit);
    	if($check->count() == 0){
    		$data = [
	            'ma_donvi'  => $req->madv,
	            'ten_donvi_TV' => $req->tendviTV,
	            'ten_donvi_TA' => $req->tendviTA,
	            'viet_tat_TV'  => $req->viettatTV,
	            'viet_tat_TA'  => $req->viettatTA,
	            'loai_dv_id'   => $req->loaidv,
	            'ten_truoc_day' => $req->tentruocday,

	            'loaiht' => $req->loaiht,
	            'sqdcdlh' => $req->sqdcdlh,
	            'ntncdlh' => $req->ntncdlh,
				
	            'chu_quan'		=> $req->chuquan,
	            'ngay_thanh_lap'	=> date("Y-m-d", strtotime($req->ngay_thanhlap)),
				'soqd'			=> $req->soqd,

				'soqdcapp'			=> $req->soqdcapp,
				'ngcapphd'			=> $req->ngcapphd,
				'plcs'				=> $req->plcs,
				'lhcsdt'			=> $req->lhcsdt,
				'soqdgtc'			=> $req->soqdgtc,


	            'phone'			=> $req->phone,
	            'fax'			=> $req->fax,
	            'email'			=> $req->email,
	            'website'		=> $req->website,
	            'ghichu'		=> $req->note,
	            'loai_hinh'		=> $req->lhcsgd,
	            'tgdtk1'		=> $req->tgbdk1,
	            'tgcbk1'		=> $req->tgcbk1
	        ];
	        DB::table("excel_import_donvi")->where("id", $req->id_unit)
	        		->update($data);
	        return back()->with('success', 
	                    Lang::get('project/Standard/message.success.update'));
    	}else{
    		return back()->with('error', 
	                    Lang::get('project/Standard/message.error.notupdate'));
    	}
    }
}