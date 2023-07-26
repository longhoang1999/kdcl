<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Tkphongtrangthietbi;
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
use App\Imports\Tkpttb;
// export excel
use App\Exports\TkpttbExport;


class TkpttbController extends DefinedController{

    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '18')->select("id", "year")->get();
		
        return view('admin.project.Importdata2.tkpttb')->with([
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'getFile'           => $getFile
        ]);
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
            $check = DB::table('excel_import_data2')->where("type_excel", '18')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Tkphongtrangthietbi'), $picName);

            $data = [
                'type_excel'    => '18',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Tkphongtrangthietbi/'.$picName,
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
        $excel = new Tkpttb;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->tplgd != "" && $dt->soluong != ""){
            	$dataInport = array(
                    'tp_gd_lap'  => $dt->tplgd,
                    'so_luong' => $dt->soluong,
                    'dien_tich_xay'   => $dt->dientichxd,
                    'doi_tuong_sd'   => $dt->doituong,
                    'trang_thiet_bi'  => $dt->danhmuc,
                    'so_huu'  => $dt->sohuu,
                    'lien_ket' => $dt->lienket,
                    'thue' => $dt->thue,
                    'so_phong_PKC' => $dt->sophong,
                    'dien_tich_PKC' => $dt->dientich,
                    'so_phong_PBKC' => $dt->sophong1,
                    'dien_tich_PBKC' => $dt->dientich1,
                    'so_phong_PT' => $dt->sophong2,
                    'dien_tich_PT' => $dt->dientich2,
                    'loai_phong' => $dt->loaiphong,
                    
                );
                DB::table("excel_import_tk_phong_tb")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel 
	public function exportTkpttb() {
        return Excel::download(new TkpttbExport, 'Tkpttbexport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tk_phong_tb AS tkpttb");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tkpttb.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tkpttb.id', 'tkpttb.tp_gd_lap', 'tkpttb.so_luong',
	                 'tkpttb.dien_tich_xay', 'tkpttb.doi_tuong_sd', 'tkpttb.trang_thiet_bi',
                     'tkpttb.so_huu','tkpttb.lien_ket','tkpttb.thue','tkpttb.so_phong_PKC','tkpttb.dien_tich_PKC',
                     'tkpttb.so_phong_PBKC','tkpttb.dien_tich_PBKC','tkpttb.so_phong_PT','tkpttb.dien_tich_PT','tkpttb.loai_phong');

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
        DB::table('excel_import_tk_phong_tb')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tp_gd_lap'  => $req->tplgd,
            'so_luong' => $req->soluong,
            'dien_tich_xay' => $req->dientich,
            'doi_tuong_sd' => $req->doituong,
            'trang_thiet_bi' => $req->danhmuc,
            'so_huu'  => $req->sohuu,
            'lien_ket' => $req->lienket,
            'thue' => $req->thue,
            'loai_phong' => $req->loaiphong,
        ];
        DB::table("excel_import_tk_phong_tb")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}