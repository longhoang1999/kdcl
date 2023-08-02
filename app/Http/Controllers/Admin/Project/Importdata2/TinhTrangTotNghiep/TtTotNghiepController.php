<?php namespace App\Http\Controllers\Admin\Project\Importdata2\TinhTrangTotNghiep;
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
use App\Imports\Chtrinhdaotao;
// export excel
use App\Exports\TttnsvExport;


class TtTotNghiepController extends DefinedController{
    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '16')->select("id", "year")->get();
        $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',16)
                            ->first();
		// Phân quyền
        if(Sentinel::inRole('truongdonvi')){
            if($phanquen){
                if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    if(Carbon::now() > $phanquen->ngay_bd  && Carbon::now() < $phanquen->ngay_kt){
                        return view('admin.project.Importdata2.tttnsv')->with([
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
                        return view('admin.project.Importdata2.tttnsv')->with([
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
                return view('admin.project.Importdata2.tttnsv')->with([
                    'loai_dv'           => $loai_dv,
                    'donvi'             => $donvi,
                    'getFile'           => $getFile,
                    'kiemtra'           => 'nskt'
                ]);
            }
        }


        if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){
            return view('admin.project.Importdata2.tttnsv')->with([
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
            $check = DB::table('excel_import_data2')->where("type_excel", '16')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/TinhTrangTotNghiep'), $picName);

            $data = [
                'type_excel'    => '16',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/TinhTrangTotNghiep/'.$picName,
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
        foreach($req->checkbox as $key => $value){
            if($value == "on"){
                if($key == 0){
                    // check cha
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 3);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.dgsvtn'),
                            'tc_number' => 3,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    // check con
                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[0])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){
                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsv'),
                            'nam'       => $req->nam[0],
                            'gia_tri'   => $req->name3_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name3_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsvtl'),
                            'nam'       => $req->nam[0],
                            'gia_tri'   => $req->name3_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name3_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);

                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsctlk'),
                            'nam'       => $req->nam[0],
                            'gia_tri'   => $req->name3_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name3_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                    }
                    
                }
                if($key == 1){
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 4);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.svcvl'),
                            'tc_number' => 4,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[1])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsvcvl'),
                            'nam'       => $req->nam[1],
                            'gia_tri'   => $req->name4_1_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name4_1_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsvcvl2'),
                            'nam'       => $req->nam[1],
                            'gia_tri'   => $req->name4_1_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name4_1_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);
                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.svtndt'),
                            'nam'       => $req->nam[1],
                            'gia_tri'   => $req->name4_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name4_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                        $data4 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tltvl'),
                            'nam'       => $req->nam[1],
                            'gia_tri'   => $req->name4_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name4_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data4);
                        $data5 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.svcvl2'),
                            'nam'       => $req->nam[1],
                            'gia_tri'   => $req->name4_4,
                            'parent'    => $idParent
                        ];
                        $save = $req->name4_4 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data5);    
                    }
                }
                if($key == 2){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 5);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.dgnsd'),
                            'tc_number' => 5,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[2])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.duyccv'),
                            'nam'       => $req->nam[2],
                            'gia_tri'   => $req->name5_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name5_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.yccvcdt'),
                            'nam'       => $req->nam[2],
                            'gia_tri'   => $req->name5_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name5_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);
                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsvdtl'),
                            'nam'       => $req->nam[2],
                            'gia_tri'   => $req->name5_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name5_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                    }
                }
                if($key == 3){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 6);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlph'),
                            'tc_number' => 6,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }
                    
                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[3])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlph'),
                            'nam'       => $req->nam[3],
                            'gia_tri'   => $req->name6_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name6_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
        
                    }
                }

                if($key == 4){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 7);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlcvl'),
                            'tc_number' => 7,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }
                    
                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[4])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlcvl'),
                            'nam'       => $req->nam[4],
                            'gia_tri'   => $req->name7_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name7_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
        
                    }
                }
                if($key == 5){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 8);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlvtvl'),
                            'tc_number' => 8,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[5])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.vtql'),
                            'nam'       => $req->nam[5],
                            'gia_tri'   => $req->name8_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name8_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.vtktcn'),
                            'nam'       => $req->nam[5],
                            'gia_tri'   => $req->name8_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name8_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);
                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.vttn'),
                            'nam'       => $req->nam[5],
                            'gia_tri'   => $req->name8_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name8_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                    }
                }
                if($key == 6){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 9);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tlsvckv'),
                            'tc_number' => 9,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[6])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.nhanuoc'),
                            'nam'       => $req->nam[6],
                            'gia_tri'   => $req->name9_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name9_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tunhan'),
                            'nam'       => $req->nam[6],
                            'gia_tri'   => $req->name9_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name9_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);
                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tutvl'),
                            'nam'       => $req->nam[6],
                            'gia_tri'   => $req->name9_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name9_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                        $data4 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.cytnn'),
                            'nam'       => $req->nam[6],
                            'gia_tri'   => $req->name9_4,
                            'parent'    => $idParent
                        ];
                        $save = $req->name9_4 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data4);
                    }
                }
                if($key == 7){
                    
                    $checkTc1 = DB::table("excel_import_tinh_trang_tn")
                        ->where('parent', null)
                        ->where('tc_number', 10);
                    if($checkTc1->count() == 0){
                        $data0 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.muctn'),
                            'tc_number' => 10,
                        ];
                        $idParent = DB::table("excel_import_tinh_trang_tn")
                                ->insertGetId($data0);
                    }else{
                        $idParent = $checkTc1->first()->id;
                    }

                    $checkCon = DB::table("excel_import_tinh_trang_tn")
                            ->where("nam", $req->nam[7])
                            ->where("parent", $idParent);
                    if($checkCon->count() == 0){

                        $data1 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.caonhat'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_1,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_1 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data1);
                        $data2 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.thapnhat'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_2,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_2 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data2);
                        $data3 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.duoi5tr'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_3,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_3 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data3);
                        $data4 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tu5den8'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_4,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_4 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data4);
                        $data5 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tu8den12'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_5,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_5 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data5);
                        $data6 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tu12den15'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_6,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_6 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data6);
                        $data7 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tu15den20'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_7,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_7 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data7);
                        $data8 = [
                            'tieu_chi' => Lang::get('project/ImportdataExcel/title.tren20'),
                            'nam'       => $req->nam[7],
                            'gia_tri'   => $req->name10_8,
                            'parent'    => $idParent
                        ];
                        $save = $req->name10_8 == "" ? "" : DB::table("excel_import_tinh_trang_tn")->insert($data8);
                    }
                }
            }
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create')); 


    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->content != "" && $dt->stt != "" ){
            	$dataInport = array(
                    'stt'  => $dt->stt,
                    'parent' => $dt->parent,
                    'noi_dung' => $dt->content,
                    'dien_tich' => $dt->dientich,
                    'so_huu' => $dt->sohuu,
                    'lien_ket' => $dt->lienket,
                    'thue' => $dt->thue,
                );
                DB::table("excel_import_dientich_xaydung")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportTttnsv() {
        return Excel::download(new TttnsvExport, 'Tình trạng tốt nghiệp sinh viên.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_dientich_xaydung AS ctdt");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("ctdt.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('ctdt.id', 'ctdt.khoa_BM', 'ctdt.cndt',
	                 'ctdt.ma_nganh', 'ctdt.ten_ctdt', 'ctdt.nam_bddt');

	        return DataTables::of($donviExcel)          
	            ->addColumn(
	                'actions',
	                function ($donvi) {
	                    $actions = '<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
	                    $actions = $actions.'<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>'; 
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        foreach($req->nam_delete as $value){
            DB::table('excel_import_tinh_trang_tn')
                ->where("nam", $value)
                ->where("parent", $req->id_parent)
                ->delete();
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
        $data = [
            'gia_tri'   => $req->tieu_chi_giatri
        ];
        DB::table("excel_import_tinh_trang_tn")
            ->where("id", $req->id)
            ->update($data);
    	return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}