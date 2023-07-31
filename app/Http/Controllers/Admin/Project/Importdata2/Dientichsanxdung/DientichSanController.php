<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Dientichsanxdung;
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
use App\Exports\DtSanExport;


class DientichSanController extends DefinedController{
    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '20')->select("id", "year")->get();
		if(Sentinel::inRole('truongdonvi')){
    
            $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',20)
                            ->first();
            if($phanquen){
                if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                    return view('admin.project.Importdata2.dtsxd')->with([
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
        return view('admin.project.Importdata2.dtsxd')->with([
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
            $check = DB::table('excel_import_data2')->where("type_excel", '20')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Dientichsanxdung'), $picName);

            $data = [
                'type_excel'    => '20',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Dientichsanxdung/'.$picName,
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
        // $excel = new Chtrinhdaotao;
        // Excel::import($excel, $req->file);
        // return $excel->read();
        return json_encode("ok");
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        $checkEmp = DB::table('excel_import_dientich_xaydung')->where('nam', $data[0]->year_data);
        if($checkEmp->count() > 0){
            $checkEmp->delete();
        }
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
                    'nam'   =>  $dt->year_data
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
	public function exportDtSan() {
        return Excel::download(new DtSanExport, 'DtSanExport.xlsx');
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
        DB::table('export_import_ctdt')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'dien_tich'  => $req->dientich,
            'so_huu' => $req->sohuu,
            'lien_ket' => $req->lienket,
            'thue' => $req->thue,
        ];
        DB::table("excel_import_dientich_xaydung")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}