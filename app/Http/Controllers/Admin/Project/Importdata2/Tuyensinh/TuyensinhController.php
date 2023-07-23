<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Tuyensinh;
use App\Http\Controllers\Admin\DefinedController;
use App\Http\Requests\UserRequest;
use App\Mail\Register;
use Illuminate\Support\Facades\File;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
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
use Illuminate\Support\Facades\Input;

//Import Excel
use App\Imports\Admissions;

// export excel
use App\Exports\AdmissionsExport;

class TuyensinhController extends DefinedController{

	public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '1')->select("id", "year")->get();
		
        return view('admin.project.Importdata2.admissions')->with([
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
            $check = DB::table('excel_import_data2')->where("type_excel", '1')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Tuyensinh'), $picName);

            $data = [
                'type_excel'    => '1',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Tuyensinh/'.$picName,
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
        $excel = new Admissions;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->dttg != "" && $dt->loai != "" ){
            	$dataInport = array(
                    'dt_tg'  => $dt->dttg,
                    'loai' => $dt->loai,
                    'ctdt' => $dt->ctdt,
                    'stsdt' => $dt->stsdt,
                    's_t_t' => $dt->sttuyen,
                    'tlct' => $dt->tlct,
                    'snhtt' => $dt->snhtt,
                    'dtdv' => $dt->dtdv,
                    'dtbcnhdt' => $dt->dtbcnhdt,
                    'slsvqtnh' => $dt->slsvqtnh,
                    'hdt' => $dt->hdtao,
                );
                DB::table("excel_import_tuyensinh")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }

    public function deleteDataTable(Request $req){
        if($req->nametable != null && $req->nametable != ""){
            DB::table($req->nametable)->delete();
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    //Export excel Admissions
	public function ExportAdmissions() {
        return Excel::download(new AdmissionsExport, 'admissions.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tuyensinh AS tsex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tsex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tsex.id', 'tsex.loai', 'tsex.s_t_t',
	                 'tsex.dtdv', 'tsex.hdt', 'tsex.snhtt','tsex.ctdt','tsex.dt_tg');


	        return DataTables::of($donviExcel)  
            ->filter(function ($query) use ($req)  {
                if (isset($req->search['value']) && $req->search['value'] != '') {
                    $search = strtolower($req->search['value']);                        
                    $query = $query
                        ->orWhereRaw("LOWER(tsex.dt_tg) like ?",['%'.$search.'%'])
                        ->orWhereRaw("LOWER(tsex.snhtt) like ?",['%'.$search.'%']);
                } 
            })   
	        	->addColumn(
	                'loai_TS',
	                function ($donvi) {
	                    if($donvi->loai == 1)
	                    	return Lang::get('project/ImportdataExcel/title.nghiencs');
	                    else if($donvi->loai == 2)
	                    	return Lang::get('project/ImportdataExcel/title.hvch');
	                    else if($donvi->loai == 3)
	                    	return Lang::get('project/ImportdataExcel/title.daihoc');
	                    else if($donvi->loai == 4)
	                    	return Lang::get('project/ImportdataExcel/title.caodang');
	                    else if($donvi->loai == 5)
	                    	return Lang::get('project/ImportdataExcel/title.trungcap');
	                   	else if($donvi->loai == 6)
	                    	return Lang::get('project/ImportdataExcel/title.khac');
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
	                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
	                    $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>'; 
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions', 'loai_TS'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('excel_import_tuyensinh')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'dt_tg'  => $req->dttg,
            'loai' => $req->loai,
            'ctdt' => $req->ctdt,
            'stsdt' => $req->stsdt,
            's_t_t' => $req->sttuyen,
            'tlct' => $req->tlct,
            'snhtt' => $req->snhtt,
            'dtdv' => $req->dtdv,
            'dtbcnhdt' => $req->dtbcnhdt,
            'slsvqtnh' => $req->slsvqtnh,
            'hdt' => $req->hdtao,
        ];
        DB::table("excel_import_tuyensinh")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}