<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Tlthuvien;
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
use App\Imports\Tltv;
// export excel
use App\Exports\TltvExport;


class TltvController extends DefinedController{
    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '22')->select("id", "year")->get();
		if(Sentinel::inRole('truongdonvi')){
    
            $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',22)
                            ->first();
            if($phanquen){
                if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    return view('admin.project.Importdata2.tltv')->with([
                        'loai_dv'           => $loai_dv,
                        'donvi'             => $donvi,
                        'getFile'           => $getFile
                    ]);
                }else{
                    return redirect()->back()->withErrors("");
                }
            }else{
                return redirect()->back()->withErrors(""); 
            }
            

        }
        return view('admin.project.Importdata2.tltv')->with([
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
            $check = DB::table('excel_import_data2')->where("type_excel", '22')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Tlthuvien'), $picName);

            $data = [
                'type_excel'    => '22',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Tlthuvien/'.$picName,
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
        $excel = new Tltv;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->mhp != "" && $dt->tenhp != ""){
            	$dataInport = array(
                    'ma_hoc_phan'  => $dt->mhp,
                    'ten_hoc_phan' => $dt->tenhp,
                    'khoi_nganh' => $dt->khoinganh,
                    'syctdc_sck' => $dt->ychp,
                    'sach_in_sck'  => $dt->sachin,
                    'sach_dt_sck'  => $dt->sachdt,
                    'syctdc_sgt'  => $dt->ychp1,
                    'sach_in_sgt' => $dt->sachin1,
                    'sach_dt_sgt' => $dt->sachdt1,
                    'ttnn'  => $dt->trennn,
                    'tnndn'  => $dt->tnndn,
                    'syctdchp_stk' => $dt->ychp4,
                    'sach_in_stk'  => $dt->sachin4,
                    'sach_dt_stk'  => $dt->sachdt4,
                    'syctdc_shd' => $dt->ychp5,
                    'sach_in_shd'  => $dt->sachin5,
                    'sach_dt_shd'  => $dt->sachdt5,
                    'sldtcbi' => $dt->sldtcbi,
                    'sldtcdt'  => $dt->sldtcdt,
                    'ttnn_tltk' => $dt->trennn1,
                    'tnndn_tltk' => $dt->tnndn1,
                );
                DB::table("excel_import_tailieu_thuvien")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel 
	public function exportTltv() {
        return Excel::download(new TltvExport, 'Tltvexport.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tailieu_thuvien AS tltv");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tltv.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tltv.id', 'tltv.ma_hoc_phan', 'tltv.ten_hoc_phan','tltv.khoi_nganh',
	                 'tltv.syctdc_sck','tltv.sach_in_sck','tltv.sach_dt_sck','tltv.syctdc_sgt',
                     'tltv.sach_in_sgt','tltv.sach_dt_sgt','tltv.ttnn','tltv.tnndn',
                     'tltv.syctdchp_stk','tltv.sach_in_stk', 'tltv.sach_dt_stk', 'tltv.syctdc_shd','tltv.sach_in_shd',
                     'tltv.sach_dt_shd','tltv.sldtcbi','tltv.sldtcdt','tltv.ttnn_tltk','tltv.tnndn_tltk');

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
        DB::table('excel_import_tailieu_thuvien')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'ma_hoc_phan'  => $req->mhp,
                    'ten_hoc_phan' => $req->tenhp,
                    'khoi_nganh' => $req->khoinganh,
                    'syctdc_sck' => $req->ychp,
                    'sach_in_sck'  => $req->sachin,
                    'sach_dt_sck'  => $req->sachdt,
                    'syctdc_sgt'  => $req->ychp1,
                    'sach_in_sgt' => $req->sachin1,
                    'sach_dt_sgt' => $req->sachdt1,
                    'ttnn'  => $req->trennn,
                    'tnndn'  => $req->tnndn,
                    'syctdchp_stk' => $req->ychp4,
                    'sach_in_stk'  => $req->sachin4,
                    'sach_dt_stk'  => $req->sachdt4,
                    'syctdc_shd' => $req->ychp5,
                    'sach_in_shd'  => $req->sachin5,
                    'sach_dt_shd'  => $req->sachdt5,
                    'sldtcbi' => $req->sldtcbi,
                    'sldtcdt'  => $req->sldtcdt,
                    'ttnn_tltk' => $req->trennn1,
                    'tnndn_tltk' => $req->tnndn1,
        ];
        DB::table("excel_import_tailieu_thuvien")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}