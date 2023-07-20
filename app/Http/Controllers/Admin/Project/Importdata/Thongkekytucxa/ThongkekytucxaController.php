<?php namespace App\Http\Controllers\Admin\Project\Importdata\Thongkekytucxa;
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
use App\Imports\Tkkytucxa;
// export excel
use App\Exports\Tkktxexport;


class ThongkekytucxaController extends DefinedController{

	public function index(){
		$tttnsv = DB::table("excel_import_tk_ktx")
                ->where("parent", null)
                ->orderBy('id', 'asc')
                ->get();

        $nams = DB::table("excel_import_tk_ktx")
                ->where("nam" , "<>", null)
                ->select("nam")
                ->groupBy('nam')
                ->get();
		
        return view('admin.project.Importdata.tkktx')->with([
           	'tttnsv'           => $tttnsv,
           	'nams'             => $nams,
        ]);
	}

	//Import excel unit
    public function importUnit (Request $req) {
        // foreach($req->checkbox as $key => $value){
        //     if($value == "on"){
        //         if($key == 0){
        //             // check cha
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 3);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tdtktx'),
        //                     'tc_number' => 3,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             // check con
        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[0])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){
        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tdtktx'),
        //                     'nam'       => $req->nam[0],
        //                     'gia_tri'   => $req->name3_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name3_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
                        
        //             }
                    
        //         }
        //         if($key == 1){
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 4);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tdtpo'),
        //                     'tc_number' => 4,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[1])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tdtpo'),
        //                     'nam'       => $req->nam[1],
        //                     'gia_tri'   => $req->name4_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name4_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
                            
        //             }
        //         }
        //         if($key == 2){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 5);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ssvcnc'),
        //                     'tc_number' => 5,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[2])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tong3'),
        //                     'nam'       => $req->nam[2],
        //                     'gia_tri'   => $req->name5_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name5_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
        //                 $data2 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct13'),
        //                     'nam'       => $req->nam[2],
        //                     'gia_tri'   => $req->name5_2,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name5_2 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data2);
        //                 $data3 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct23'),
        //                     'nam'       => $req->nam[2],
        //                     'gia_tri'   => $req->name5_3,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name5_3 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data3);
        //                 $data4 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct33'),
        //                     'nam'       => $req->nam[2],
        //                     'gia_tri'   => $req->name5_4,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name5_4 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data4);
        //             }
        //         }
        //         if($key == 3){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 6);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.slsvoktx'),
        //                     'tc_number' => 6,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }
                    
        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[3])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tong4'),
        //                     'nam'       => $req->nam[3],
        //                     'gia_tri'   => $req->name6_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name6_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
        
        //                 $data2 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct14'),
        //                     'nam'       => $req->nam[3],
        //                     'gia_tri'   => $req->name6_2,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name6_2 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data2);
        //                 $data3 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct24'),
        //                     'nam'       => $req->nam[3],
        //                     'gia_tri'   => $req->name6_3,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name6_3 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data3);
        //                 $data4 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ct34'),
        //                     'nam'       => $req->nam[3],
        //                     'gia_tri'   => $req->name6_4,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name6_4 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data4);
        //             }
        //         }

        //         if($key == 4){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 7);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tscoktx'),
        //                     'tc_number' => 7,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }
                    
        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[4])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.tscoktx'),
        //                     'nam'       => $req->nam[4],
        //                     'gia_tri'   => $req->name7_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name7_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
        
        //             }
        //         }
        //         if($key == 5){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 8);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ttcsvs'),
        //                     'tc_number' => 8,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[5])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.bankc'),
        //                     'nam'       => $req->nam[5],
        //                     'gia_tri'   => $req->name8_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name8_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
        //                 $data2 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.dangsc'),
        //                     'nam'       => $req->nam[5],
        //                     'gia_tri'   => $req->name8_2,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name8_2 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data2);
        //                 $data3 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.kienco'),
        //                     'nam'       => $req->nam[5],
        //                     'gia_tri'   => $req->name8_3,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name8_3 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data3);
        //             }
        //         }
        //         if($key == 6){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 9);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.ndvsd'),
        //                     'tc_number' => 9,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[6])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.nhanuoc'),
        //                     'nam'       => $req->nam[6],
        //                     'gia_tri'   => $req->name9_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name9_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
                        
        //             }
        //         }
        //         if($key == 7){
                    
        //             $checkTc1 = DB::table("excel_import_tk_ktx")
        //                 ->where('parent', null)
        //                 ->where('tc_number', 10);
        //             if($checkTc1->count() == 0){
        //                 $data0 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.htsh'),
        //                     'tc_number' => 10,
        //                 ];
        //                 $idParent = DB::table("excel_import_tk_ktx")
        //                         ->insertGetId($data0);
        //             }else{
        //                 $idParent = $checkTc1->first()->id;
        //             }

        //             $checkCon = DB::table("excel_import_tk_ktx")
        //                     ->where("nam", $req->nam[7])
        //                     ->where("parent", $idParent);
        //             if($checkCon->count() == 0){

        //                 $data1 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.muon'),
        //                     'nam'       => $req->nam[7],
        //                     'gia_tri'   => $req->name10_1,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name10_1 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data1);
        //                 $data2 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.sohuu8'),
        //                     'nam'       => $req->nam[7],
        //                     'gia_tri'   => $req->name10_2,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name10_2 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data2);
        //                 $data3 = [
        //                     'tieu_chi' => Lang::get('project/ImportdataExcel/title.chothue8'),
        //                     'nam'       => $req->nam[7],
        //                     'gia_tri'   => $req->name10_3,
        //                     'parent'    => $idParent
        //                 ];
        //                 $save = $req->name10_3 == "" ? "" : DB::table("excel_import_tk_ktx")->insert($data3);
                       
        //             }
        //         }
        //     }
        // }

        // dd($req->nam);
        // dd($req->key1);
        // dd($req->value1);
        // dd($req->key2);
        // dd($req->value2);
        // dd($req->key3);
        // dd($req->value3);
        // dd($req->key4);
        // dd($req->value4);
        // dd($req->key5);
        // dd($req->value5);
        // dd($req->key6);
        // dd($req->value6);
        // dd($req->key7);
        // dd($req->value7);
        // dd($req->key8);
        // dd($req->value8);

        if($req->nam[0] != null ){
            $nam = $req->nam[0];
            foreach($req->key1 as $index => $key1){
                if($key1 != null && $req->value1[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key1,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value1[$index],
                        'parent'    => '1'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[1] != null ){
            $nam = $req->nam[1];
            foreach($req->key2 as $index => $key2){
                if($key2 != null && $req->value2[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key2,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value2[$index],
                        'parent'    => '3'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[2] != null ){
            $nam = $req->nam[2];
            foreach($req->key3 as $index => $key3){
                if($key3 != null && $req->value3[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key3,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value3[$index],
                        'parent'    => '5'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[3] != null ){
            $nam = $req->nam[3];
            foreach($req->key4 as $index => $key4){
                if($key4 != null && $req->value4[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key4,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value4[$index],
                        'parent'    => '10'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[4] != null ){
            $nam = $req->nam[4];
            foreach($req->key5 as $index => $key5){
                if($key5 != null && $req->value5[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key5,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value5[$index],
                        'parent'    => '15'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[5] != null ){
            $nam = $req->nam[5];
            foreach($req->key6 as $index => $key6){
                if($key6 != null && $req->value6[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key6,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value6[$index],
                        'parent'    => '17'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[6] != null ){
            $nam = $req->nam[6];
            foreach($req->key7 as $index => $key7){
                if($key7 != null && $req->value7[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key7,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value7[$index],
                        'parent'    => '21'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        if($req->nam[7] != null ){
            $nam = $req->nam[7];
            foreach($req->key8 as $index => $key8){
                if($key8 != null && $req->value8[$index] != null){
                    $data_ = [
                        'tieu_chi'  => $key8,
                        'nam'   => $nam,
                        'gia_tri'   => $req->value8[$index],
                        'parent'    => '23'
                    ];
                    DB::table("excel_import_tk_ktx")->insert($data_);
                }
            }
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create')); 


    }
    public function deleteAll(){
        DB::table('excel_import_tk_ktx')->where('parent', '<>', null)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete')); 
    }


    public function importDataUnit(Request $req) {
    	$data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->noidung != "" ){
            	$dataInport = array(
                    'noi_dung'  => $dt->noidung,
                    'n_2019' => $dt->n_2019,
                    'n_2020' => $dt->n_2020,
                    'n_2021' => $dt->n_2021,
                    'n_2022' => $dt->n_2022,
                    'n_2023' => $dt->n_2023,
                    
                );
                DB::table("excel_import_tk_ktx")->insert($dataInport);
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }


    //Export excel Admissions
	public function exportTkktx() {
        return Excel::download(new Tkktxexport, 'Thông kê ký túc xá.xlsx');
    }

    
    public function dataUnit(Request $req){
    	$donviExcel = DB::table("excel_import_tk_ktx AS tkktx");
        if(isset($req->id) && $req->id != ''){
            $donviExcel = $donviExcel->where("tkktx.id", $req->id)->first();
            return json_encode($donviExcel);
        }else{
	        $donviExcel = $donviExcel
	                ->select('tkktx.id', 'tkktx.noi_dung', 'tkktx.n_2019',
	                 'tkktx.n_2020', 'tkktx.n_2021', 'tkktx.n_2022','tkktx.n_2023');

	        return DataTables::of($donviExcel)          
	            ->addColumn(
	                'actions',
	                function ($donvi) {
	                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
	                    $actions = $actions. '<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
	                    return $actions;
	                }
	            )
	            ->rawColumns(['actions'])
	            ->make(true);
	    }
    }


    public function deleteUnit(Request $req){
        foreach($req->nam_delete as $value){
            DB::table('excel_import_tk_ktx')
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
        DB::table("excel_import_tk_ktx")
            ->where("id", $req->id)
            ->update($data);
    	return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}