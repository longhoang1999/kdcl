<?php namespace App\Http\Controllers\Admin\Project\Importdata2\Baibaobc;
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
use App\Imports\ReportArticle;

// export excel
use App\Exports\ReportArticleExport;

class BaibaobcController extends DefinedController{

    public function index(){
		$loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		$donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $getFile = DB::table('excel_import_data2')->where('type_excel', '6')->select("id", "year")->get();
		if(Sentinel::inRole('truongdonvi')){
            $phanquen = DB::table('lkh_phanquyen_excel')
                            ->where('bang_stt',6)
                            ->first();
            if($phanquen->donvi_id == Sentinel::getUser()->donvi_id){
                return view('admin.project.Importdata2.report_article')->with([
                    'loai_dv'           => $loai_dv,
                    'donvi'             => $donvi,
                    'getFile'           => $getFile
                ]);
            }else{
                return redirect()->back();
            }

        }
        return view('admin.project.Importdata2.report_article')->with([
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
            $check = DB::table('excel_import_data2')->where("type_excel", '6')
                        ->where("year", $req->year);
            if($check->count() > 0){
                File::delete(public_path($check->first()->url));
                $check->delete();
            }
            $image = $req->file('file');
            $picName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('UpdateExcelFile/Baibaobc'), $picName);

            $data = [
                'type_excel'    => '6',
                'year'  => $req->year,
                'url'   => 'UpdateExcelFile/Baibaobc/'.$picName,
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
        $excel = new ReportArticle;
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->maso != ""){
                $check = DB::table("excel_import_baibao_baocao")->where("maso", $dt->maso);
                if($check->count() == 0){
                    $dataInport = array(
                        'tbbbc'  => $dt->tbbbc,
                        'maso' => $dt->maso,
                        'linhvuc' => $dt->linhvuc,
                        'tacgia' => $dt->tacgia,
                        'donvi' => $dt->donvipk,
                        'tcd' => $dt->tapchidang,
                        'so_issn_isbn' => $dt->soissn,
                        'sodang' => $dt->sodang,
                        'tgcb' => $dt->tgcb,

                        'namdang' => $dt->namdang,
                        'loai' => $dt->loai,
                        'ltc' => $dt->loaitc,
                        'dmtc' => $dt->dmtc,
                        'url' => $dt->url,
                    );
                    DB::table("excel_import_baibao_baocao")->insert($dataInport);
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel bài báo-báo cáo
    public function exportUnit() {
        return Excel::download(new ReportArticleExport, 'Bài báo báo cáo.xlsx');
    }


    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_baibao_baocao AS bcbcex");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("bcbcex.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('bcbcex.id', 'bcbcex.tbbbc', 'bcbcex.maso',
	                 'bcbcex.tcd', 'bcbcex.ltc', 'bcbcex.dmtc');

	        return DataTables::of($donviExcel) 
            ->addColumn(
                'stt',
                function ($donvi) {
                    return "";
                }
            )   
	        	->addColumn(
	                'danhmuc',
	                function ($donvi) {
	                	if($donvi->dmtc == "1")
	                    	return Lang::get('project/ImportdataExcel/title.dmisi');
	                    else if($donvi->dmtc == "2")
	                    	return Lang::get('project/ImportdataExcel/title.dmsc');
	                    else
	                    	return Lang::get('project/ImportdataExcel/title.dmk');
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
	            ->rawColumns(['actions', 'danhmuc'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        DB::table('excel_import_baibao_baocao')->where("id", $req->id_delete)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateUnit(Request $req){
    	$data = [
            'tbbbc'  => $req->tbbbc,
            'maso' => $req->maso,
            'linhvuc' => $req->linhvuc,
            'tacgia'  => $req->tacgia,
            'donvi'  => $req->donvipk,
            'tcd'  => $req->tapchidang,
            'so_issn_isbn'   => $req->soissn,
            'sodang' => $req->sodang,
            'tgcb' => $req->tgcb,

            'namdang'		=> $req->namdang,
            'loai'	=> $req->loai,
            'ltc'		=> $req->loaitc,
            'dmtc'			=> $req->dmtc,
            'url'			=> $req->url,
        ];
        DB::table("excel_import_baibao_baocao")->where("id", $req->id_unit)
        		->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}