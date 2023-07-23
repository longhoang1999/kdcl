<?php namespace App\Http\Controllers\Admin\Project\Thuongtruc\Standard;

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
// export excel
use App\Exports\StandardExport;
use App\Exports\ListStandardExport;
use App\Exports\MinimunExport;
use App\Exports\GyhdExport;




class StandardController extends DefinedController
{
    public function getCsdt() {
        if(Sentinel::check()){
            return Sentinel::getUser()->csdt_id;
        }
    }

    public function index(Request $req){
        $loai_tieuchuan = (object) array(
            'csgd'  => Lang::get('project/Standard/title.csgd'),
            'ctdt'  => Lang::get('project/Standard/title.ctdt'),
        );
        return view('admin.project.Standard.index')->with(
            'loai_tieuchuan'    , $loai_tieuchuan
        );  //  thường trực - Bộ tiêu chuẩn

        // return view('admin.project.Standard.mana_stracriteria'); // thường trực - Đối sách (Tiêu chí đối sách)
        // return view('admin.project.Standard.mana_strasubject'); // thường trực - Đối sách (Đối tượng đối sách)

        // $role = Sentinel::getRoleRepository()->createModel()->create([
        //     'name' => 'canbo',
        //     'slug' => 'canbo',
        // ]);
    }
    public function data(Request $req){
        $users = DB::table('customers');
        return DataTables::of($users)               
            ->addColumn(
                'actions',
                function ($user) {
                    $actions = '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>';
                    return $actions;
                }
            )
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function dataStandard(Request $req){
        $btcs = $this->dataExceptDelete(
                DB::table('bo_tieuchuan')
            );
        $btcs = $btcs->orderBy("created_at", "desc");
        return DataTables::of($btcs)               
            ->addColumn(
                'actions',
                function ($btc) {
                    $actions = '<a href="'.
                        route('admin.thuongtruc.setstandard.configStandard', $btc->id)  
                    .'" class="btn" data-id="'.$btc->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.tlbtc').'">'. '<i class="bi bi-gear-fill" style="font-size: 25px;color: #009ef7;"></i>' .'</a>'; 
                    
                    $actions = $actions.'<a href="" class="btn" data-toggle="modal" data-target="#modalDelete" data-id="'.$btc->id.'" data-bs-toggle="tooltip">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</a>';
                    return $actions;
                }
            )
            ->addColumn(
                'loaiTC',
                function ($btc) {
                    if($btc->loai_tieuchuan == 'csgd')
                        return '<span>'. Lang::get('project/Standard/title.csgd') .'<span>';
                    else
                        return '<span>'. Lang::get('project/Standard/title.ctdt') .'<span>';
                }
            )
            ->addColumn(
                'createAt',
                function ($btc) {
                    return date("d/m/Y", strtotime($btc->created_at));
                }
            )
            ->addColumn(
                'status',
                function ($btc) {
                    if($btc->trang_thai == "active"){
                        return '<span class="badge badge-success">Active</span>';
                    }else if($btc->trang_thai == "inactive"){
                        return '<span class="badge badge-warning">Inactive</span>';
                    }else if($btc->trang_thai == "deleted"){
                        return '<span class="badge badge-danger">deleted</span>';
                    }
                }
            )
            ->addColumn(
                'createHuman',
                function ($btc) {
                    $createHuman = DB::table('users')->where('id', $btc->nguoi_tao)
                                    ->select('name')->first();
                    if($createHuman){
                        return $createHuman->name;
                    }else{
                        return '';
                    }
                }
            )
            ->rawColumns(['actions', 'loaiTC', 'status', 'createHuman'])
            ->make(true);
    }
    
    public function createStandard(Request $req){ 
        $data = [
            'tieu_de'               => $req->tbtc,
            'loai_tieuchuan'        => $req->ldg,
            'nguoi_tao'             => Sentinel::getUser()->id,
            'csdt_id'               => $this->getCsdt(),
            'trang_thai'            => 'active',
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table('bo_tieuchuan')->insert($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function deleteStandard($id){
        DB::table('bo_tieuchuan')->where("id", $id)
                ->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);
        // ẩn cả tiêu chuẩn và tiêu chí
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function exportStandard() {
        return Excel::download(new StandardExport, 'standard.xlsx');
    }

    public function configStandard($id){
        $findStandard = DB::table('bo_tieuchuan')
            ->select("tieu_de", "loai_tieuchuan")
            ->where("deleted_at", null)
            ->where("id", $id)->first();
        $loai_tieuchuan = (object) array(
            'csgd'  => Lang::get('project/Standard/title.csgd'),
            'ctdt'  => Lang::get('project/Standard/title.ctdt'),
        );
        return view('admin.project.Standard.config_standard')
            ->with([
                "id"    => $id,
                "title" => $findStandard->tieu_de,
                "ldg"   => $findStandard->loai_tieuchuan,
                'ltcs'   =>  $loai_tieuchuan,
            ]); // thường trực - TL bộ tc
    }

    public function searchStandardName(Request $req){
        if($req->type != null && $req->type != ""){
            $search = DB::table("bo_tieuchuan")->select("id", "tieu_de")
                        ->where("loai_tieuchuan", $req->type)
                        ->where("deleted_at", null)
                        ->get();
            return json_encode($search);
        }else if($req->type_search != null && $req->type_search != "" ){
            $search = DB::table("tieuchuan AS tc")
                        ->select("tc.id", "tc.mo_ta", "tc.created_at", "tc.nguoi_tao", "us.name")
                        ->leftjoin('users AS us', 'us.id', '=', 'tc.nguoi_tao');
            if($req->type_search != null && $req->type_search != "")
                $search = $search->where("tc.loai_tieuchuan", $req->type_search);
            if($req->id_btc != null && $req->id_btc != "")
                $search = $search->where("tc.bo_tieuchuan_id", $req->id_btc);
            if($req->year != null && $req->year != "")
                $search = $search->whereYear("tc.created_at", $req->year);
            $search = $search->get();
            return json_encode($search);         
        }
        else{
            $search = DB::table("bo_tieuchuan")->select("id", "tieu_de")
                        ->where("loai_tieuchuan", $req->ldg)
                        ->where("id", "<>", $req->id_)
                        ->where("deleted_at", null)
                        ->get();
            return json_encode($search);
        }
    }
    public function copyStandar(Request $req) {
        foreach($req->id_copy as $idtc){
            // copy tiêu chuẩn
            $findData = DB::table("tieuchuan")->where("id", $idtc)->first();
            $data = [
                'bo_tieuchuan_id'   =>  $req->id_,
                'loai_tieuchuan'    =>  $findData->loai_tieuchuan,
                'stt'               =>  $findData->stt,
                'mo_ta'             =>  $findData->mo_ta,
                'nam'               =>  Carbon::now()->year,
                'ns_phutrach'       =>  $findData->ns_phutrach,
                'nguoi_tao'         =>  Sentinel::getUser()->id,
                'csdt_id'           =>  $this->getCsdt(),
                'trang_thai'        =>  'active',
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),
            ];
            $idtc_new = DB::table("tieuchuan")->insertGetId($data);

            // copy tiêu chí
            $findDataTc = DB::table("tieuchi")->where("tieuchuan_id", $idtc)->get();
            foreach($findDataTc as $tieuchi){
                $data = [
                    'tieuchuan_id'      =>  $idtc_new,
                    'stt'               =>  $tieuchi->stt,
                    'tc_dieu_kien'      =>  $tieuchi->tc_dieu_kien,
                    'mo_ta'             =>  $tieuchi->mo_ta,
                    'tu_khoa'           =>  $tieuchi->tu_khoa,
                    'ns_phutrach'       =>  $tieuchi->ns_phutrach,
                    'nguoi_tao'         =>  Sentinel::getUser()->id,
                    'csdt_id'           =>  $this->getCsdt(),
                    'trang_thai'        =>  'active',
                    'created_at'        =>  Carbon::now()->toDateTimeString(),
                    'updated_at'        =>  Carbon::now()->toDateTimeString(),
                ];
                $idTieuChiNew = DB::table("tieuchi")->insertGetId($data);


                // Copy mốc chuẩn
                $findMc = DB::table("mocchuan")->where("tieuchi_id" , $tieuchi->id)->get();
                foreach($findMc as $mocchuan){
                    $dataMC = [
                        'loai_tieuchuan' => $mocchuan->loai_tieuchuan,
                        'gia_tri'       => $mocchuan->gia_tri,
                        'trong_so'      => $mocchuan->trong_so,
                        'bo_tieuchuan_id'   => $req->id_,
                        'tieuchi_id'    => $idTieuChiNew,
                        'mo_ta'         => $mocchuan->mo_ta,
                        'nguoi_tao'     => Sentinel::getUser()->id,
                        'csdt_id'       => $this->getCsdt(),
                        'trang_thai'    => $mocchuan->trang_thai,
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ];
                    DB::table("mocchuan")->insert($dataMC);
                }
                // Copy chỉ báo
                $findChibao = DB::table("menhde")->where("tieuchi_id", $tieuchi->id)->get();
                foreach($findChibao as $chibao){
                    $dataCB = [
                        'tieuchi_id'    => $idTieuChiNew,
                        'stt'           => $chibao->stt,
                        'mo_ta'         => $chibao->mo_ta,
                        'tu_khoa'       => $chibao->tu_khoa,
                        'ns_phutrach'   => $chibao->ns_phutrach,
                        'nguoi_tao'     => $chibao->nguoi_tao,
                        'csdt_id'       => $this->getCsdt(),
                        'gioihantu'     => $chibao->gioihantu,
                        'kiemtra_mc'    => $chibao->kiemtra_mc,
                        'kiemtra_tp'    => $chibao->kiemtra_tp,
                        'trang_thai'    => $chibao->trang_thai,
                        'created_at'    => Carbon::now()->toDateTimeString(),
                        'updated_at'    => Carbon::now()->toDateTimeString(),
                    ];
                    DB::table("menhde")->insert($dataCB);
                }
            }

            // thiếu
        };
        

        return json_encode(
            (object) array("message" => "ok")
        );

    }

    public function updateStandard(Request $req){
        $data = [
            'tieu_de' => $req->tbtc,
            'loai_tieuchuan' => $req->ldg,
            'nguoi_tao' => Sentinel::getUser()->id
        ];
        DB::table('bo_tieuchuan')->where("id", $req->id)->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }

    public function showStandard($id){
        $tcs = $this->dataExceptDelete(
            DB::table('tieuchuan')->where("bo_tieuchuan_id", $id)
                                ->orderBy("stt", "asc")
        );
        return DataTables::of($tcs)               
            ->addColumn(
                'actions',
                function ($tc) {
                    $actions = '<a href="'.
                        route('admin.thuongtruc.setstandard.configCriteria', $tc->id)  
                    .'" class="btn"data-bs-placement="top" title="'.Lang::get('project/Standard/title.tmtchi').'">'. '<i class="bi bi-plus-square" style="font-size: 25px;color: #009ef7;"></i>' .'</a>'; 
                    $actions =$actions. '<button type="button" data-toggle="modal" data-target="#modalDelete" class="btn" data-id="'.$tc->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: #d9214e;"></i>' .'</button>';
                    return $actions;
                }
            )
            ->addColumn(
                'nameTC',
                function ($tc) {
                    return "<span>". $tc->mo_ta ."</span>";
                }
            )
            ->addColumn(
                'createAt',
                function ($tc) {
                    return date("d/m/Y", strtotime($tc->created_at));
                }
            )
            ->addColumn(
                'sohieutc',
                function ($tc) {
                    return '<span class="badge badge-primary">'. $tc->stt .'</span>';
                }
            )
            ->addColumn(
                'createHuman',
                function ($tc) {
                    $createHuman = DB::table('users')->where('id', $tc->nguoi_tao)
                                    ->select('name')->first();
                    if($createHuman){
                        return $createHuman->name;
                    }else{
                        return '';
                    }
                }
            )
            ->rawColumns(['actions' , 'nameTC', 'sohieutc'])
            ->make(true);
    }

    public function createSgStandard($id) {
        $btc = DB::table('bo_tieuchuan')->where("id", $id)
                ->select('tieu_de', 'loai_tieuchuan')
                ->first();
        return view('admin.project.Standard.create_standard')
                    ->with([
                        'id'             => $id,
                        'tieu_de'        => $btc->tieu_de,
                        'loai_tieuchuan' => $btc->loai_tieuchuan
                    ]); // thường trực - Thêm mới Tiêu chuẩn
    }

    public function ExportSgStandard($id) {
        return Excel::download(new ListStandardExport($id), 'list-standard.xlsx');
    }

    public function createLiStandard($id, Request $req) {
        $btcs = DB::table('bo_tieuchuan')->where("id", $id)
                ->select('id' ,'loai_tieuchuan')
                ->first();

        $max = DB::select("select MAX(stt) as max FROM tieuchuan where bo_tieuchuan_id = ". $btcs->id )[0]->max != "" ? 
            DB::select("select MAX(stt) as max FROM tieuchuan where bo_tieuchuan_id = " . $btcs->id)[0]->max : 0;

        foreach($req->tieuchuan as $key => $tc){
            if($tc != null && $tc != ""){
                $max++;
                $data = [
                    'bo_tieuchuan_id'   => $btcs->id,
                    'loai_tieuchuan'    => $btcs->loai_tieuchuan,
                    'stt'               => $max,
                    'mo_ta'             => $tc,
                    'nam'               => Carbon::now()->year,
                    'ns_phutrach'       => Sentinel::getUser()->id,
                    'nguoi_tao'         => Sentinel::getUser()->id,
                    'csdt_id'           => $this->getCsdt(),
                    'trang_thai'        => 'active',
                    'created_at'        => Carbon::now()->toDateTimeString(),
                    'updated_at'        => Carbon::now()->toDateTimeString(),
                ];
                DB::table('tieuchuan')->insert($data);
            }
        }
        return redirect()
                ->route('admin.thuongtruc.setstandard.configStandard', $id)
                ->with('success', 
                    Lang::get('project/Standard/message.success.create'));

    }

    public function deleteSgStandard($id) {
        // Xóa tiêu chí sau
        DB::table('tieuchuan')->where("id", $id)
                ->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));

    }
    public function configCriteria($id){
        $tc = DB::table('tieuchuan')->where("id", $id)
                ->select('mo_ta', 'bo_tieuchuan_id', 'stt')
                ->first();
        $btc = DB::table('bo_tieuchuan')->where("id", $tc->bo_tieuchuan_id)
                ->select('tieu_de', 'loai_tieuchuan')
                ->first();
        return view('admin.project.Standard.create_criteria')
                    ->with([
                        'id_tc'             => $id,
                        'mo_ta'             => $tc->mo_ta,
                        'stt'               => $tc->stt,
                        'tieu_de'           => $btc->tieu_de,
                        'loai_tieuchuan'    => $btc->loai_tieuchuan,
                    ]); // thường trực - Thêm mới Tiêu chí
    } 

    public function createCriteria($id_tc, Request $req){
        $max = DB::select("select MAX(stt) as max FROM tieuchi where tieuchuan_id = ". $id_tc )[0]->max != "" ? 
            DB::select("select MAX(stt) as max FROM tieuchi where tieuchuan_id = " . $id_tc)[0]->max : 0;

        foreach($req->tieuchi as $key => $tieuchi){
            if($tieuchi != null && $tieuchi != ""){
                $max++;
                $data = [
                    'tieuchuan_id'      => $id_tc,
                    'stt'               => $max,
                    'mo_ta'             => $tieuchi,
                    'tu_khoa'           => $tieuchi,
                    'ns_phutrach'       => Sentinel::getUser()->id,
                    'nguoi_tao'         => Sentinel::getUser()->id,
                    'csdt_id'           => $this->getCsdt(),
                    'trang_thai'        => 'active',
                    'tc_dieu_kien'      =>  $req->tieuchidk[$key],
                    'created_at'        => Carbon::now()->toDateTimeString(),
                    'updated_at'        => Carbon::now()->toDateTimeString(),
                ];
                DB::table("tieuchi")->insert($data);
            }
        };
        $id_btc = DB::table("tieuchuan")->where("id", $id_tc)->select("bo_tieuchuan_id")
                    ->first()->bo_tieuchuan_id;
        return redirect()->route('admin.thuongtruc.setstandard.configStandard', $id_btc)
                    ->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function showCriteria(Request $req){
        $id_tc = $req->idtc;
        $sttTchuan = DB::table("tieuchuan")->where("id", $id_tc)->select("stt")->first()->stt;
        $tchis = DB::table("tieuchi")->where("tieuchuan_id", $id_tc)
                ->where("deleted_at", null)
                ->orderBy("stt", "asc")
                ->get();

        $data = [];
        foreach($tchis as $key => $tchi){
            $createHuman = DB::table("users")->where("id", $tchi->nguoi_tao)
                            ->select("name")->first();
            if($createHuman)
                $createHumanName = $createHuman->name;
            else
                $createHumanName = "";
            $obj = (object) array(
                'id_tchi'   => $tchi->id,
                'stt'       => $tchi->stt,
                'mo_ta'     => $tchi->mo_ta,
                'sohieu'    =>  '<span class="badge badge-primary">'. $sttTchuan .'.'. $tchi->stt .'</span>',
                'createAt'  => date('d/m/Y', strtotime($tchi->created_at)),
                'createHuman'   => $createHumanName
            );
            array_push($data, $obj);
        }

        return json_encode($data);
    }

    public function updateSttCriteria(Request $req){
        DB::table("tieuchi")->where("id", $req->id_tieuchi)
            ->update([
                'stt'   =>  $req->stt
            ]);
        return json_encode(
            (object) array("message" => "ok")
        );
    }

    public function deleteSgCriteria(Request $req){
        DB::table('tieuchi')->where("id", $req->idtchi)
                ->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }


    // 
    public function criteria(Request $req){
        $tchi   = DB::table('tieuchi')->where("id", $req->id_tchi)
                ->select("mo_ta", "tieuchuan_id")
                ->first();
        $tc     = DB::table('tieuchuan')->where("id", $tchi->tieuchuan_id)
                ->select("mo_ta", "bo_tieuchuan_id")
                ->first();
        $btc    = DB::table('bo_tieuchuan')->where("id", $tc->bo_tieuchuan_id)
                ->select("tieu_de", "loai_tieuchuan")
                ->first();

        return view('admin.project.Standard.create_benchmark')
                ->with([
                    'id_tchi'   =>  $req->id_tchi,
                    'btc_name'  =>  $btc->tieu_de,
                    'btc_ldg'   =>  $btc->loai_tieuchuan,
                    'tc_name'   =>  $tc->mo_ta,
                    'tchi_name' =>  $tchi->mo_ta
                ]); // thường trực - Thiết lập tiêu chí (Mốc chuẩn)

    }

    public function createBenchmark(Request $req){
        $noidung = $req->noidung;
        $giatri = $req->giatri; // chưa dùng
        $trongso = $req->trongso;   // chưa dùng


        foreach($req->noidung as $key => $noidung){
            $tieuchi = DB::table("tieuchi")
                    ->where("id", $req->id_tchi)
                    ->select("tieuchuan_id")
                    ->first();
            $tieuchuan = DB::table("tieuchuan")
                    ->where("id", $tieuchi->tieuchuan_id)
                    ->select("bo_tieuchuan_id", "loai_tieuchuan")
                    ->first();
            
            $data = [
                'loai_tieuchuan'    => $tieuchuan->loai_tieuchuan,
                'bo_tieuchuan_id'   => $tieuchuan->bo_tieuchuan_id,
                'tieuchi_id'        => $req->id_tchi,
                'mo_ta'             => $noidung,
                'nguoi_tao'         => Sentinel::getUser()->id,
                'csdt_id'           => $this->getCsdt(),
                'trang_thai'        => 'active',
                'gia_tri'           => $giatri[$key],
                'trong_so'          => $trongso[$key],
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),
            ];
            DB::table("mocchuan")->insert($data);
            
        };

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function showMinimum() {
        $loai_tieuchuan = (object) array(
            'csgd'  => Lang::get('project/Standard/title.csgd'),
            'ctdt'  => Lang::get('project/Standard/title.ctdt'),
        );
        return view('admin.project.Standard.show_minimum')->with(
            'loai_tieuchuan'    , $loai_tieuchuan
        ); // thường trực - Minh chứng tối thiểu
    }

    public function findStandard(Request $req){
        $findStandard = DB::table("bo_tieuchuan")
            ->where("loai_tieuchuan", $req->ldg)
            ->where("deleted_at",null)
            ->select("id", "tieu_de")
            ->get();
        return json_encode($findStandard);
    }

    public function dataMinimum(Request $req) {
        $mctts = DB::table('minhchung_tt AS mctt')
                ->select("mctt.id", "mctt.tieu_de as tieu_de_mctt", "mctt.loai_tieuchuan", "mctt.bo_tieuchuan_id", "btc.tieu_de as tieu_de_btc")
                ->leftjoin('bo_tieuchuan AS btc', 'btc.id', '=', 'mctt.bo_tieuchuan_id')
                ->where("mctt.deleted_at", null)
                ->orderBy("mctt.id", "asc");

        if($req->mctt_name != "" && $req->ldg == "" && $req->btc_id == ""){
            $mctts = $mctts->where('mctt.tieu_de', 'like', '%'. $req->mctt_name .'%');
        };
        if($req->mctt_name == "" && $req->ldg != "" && $req->btc_id == ""){
            $mctts = $mctts->where('mctt.loai_tieuchuan', $req->ldg );
        };
        if($req->mctt_name == "" && $req->ldg != "" && $req->btc_id != ""){
            $mctts = $mctts->where('btc.id', $req->btc_id);
        };
        if($req->mctt_name != "" && $req->ldg != "" && $req->btc_id == ""){
            $mctts = $mctts->where('mctt.tieu_de', 'like', '%'. $req->mctt_name .'%')
                    ->where('mctt.loai_tieuchuan', $req->ldg );
        };
        if($req->mctt_name != "" && $req->ldg != "" && $req->btc_id != ""){
            $mctts = $mctts->where('mctt.tieu_de', 'like', '%'. $req->mctt_name .'%')
                    ->where('btc.id', $req->btc_id);
        };
        return DataTables::of($mctts)  
            ->addColumn(
                'tchi_ad',
                function ($mctt) {
                    $roles = DB::table("role_mctt_tchi")->where("mctt_id", $mctt->id)
                        ->where("bo_tieuchuan_id", $mctt->bo_tieuchuan_id)
                        ->select("tieuchi_id")
                        ->get();
                    $spanUI = "";
                    foreach($roles as $role){
                        $tchi_tc = DB::table("tieuchi as tchi")
                                    ->select(
                                        "tchi.stt as stt_tchi", 
                                        "tchi.id", 
                                        "tchi.mo_ta", 
                                        "tchi.tieuchuan_id",
                                        "tc.stt as stt_tc", 
                                    )
                                    ->leftjoin('tieuchuan AS tc', 'tc.id', '=', 'tchi.tieuchuan_id')
                                    ->where("tchi.id", $role->tieuchi_id)
                                    ->first();

                        $spanUI .= "<span class='badge badge-primary mr-2 mt-2'>". $tchi_tc->stt_tc .".". $tchi_tc->stt_tchi ."</span>";
                    }
                    return $spanUI;
                }
            )             
            ->addColumn(
                'actions',
                function ($mctt) {
                    $actions = '<button type="button" data-toggle="modal" data-target="#modalUpdate" class="btn mr-2 btn-block" data-id="'.$mctt->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.chinhsua').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #7239ea;"></i>' .'</button>';
                    $actions = $actions . '<button type="button" data-toggle="modal" data-target="#modalDelete" class="btn mr-2 btn-block" data-id="'.$mctt->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
                    return $actions;
                }
            )
            ->rawColumns(['actions', 'tchi_ad'])
            ->make(true);
    }

    public function deleteMctt(Request $req) {
        $delete_mctt = DB::table("minhchung_tt")->where("id", $req->id_delete)
                        ->update([
                            'deleted_at' => Carbon::now()->toDateTimeString()
                        ]);
        $delete_role = DB::table("role_mctt_tchi")->where("mctt_id", $req->id_delete)
                        ->update([
                            'deleted_at' => Carbon::now()->toDateTimeString()
                        ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }



    public function minimum(Request $req){
        $noidung = $req->noidung;
        foreach($req->noidung as $key => $noidung){
            $tieuchi = DB::table("tieuchi")
                    ->where("id", $req->id_tchi)
                    ->select("tieuchuan_id")
                    ->first();
            $tieuchuan = DB::table("tieuchuan")
                    ->where("id", $tieuchi->tieuchuan_id)
                    ->select("bo_tieuchuan_id", "loai_tieuchuan")
                    ->first();
            
            $data = [
                'tieuchi_id'        => $req->id_tchi,
                'tieu_de'           => $noidung,
                'trich_yeu'         => $noidung,
                'tu_khoa'           => '',
                'nguoi_tao'         => Sentinel::getUser()->id,
                'csdt_id'           => $this->getCsdt(),
                'loai_tieuchuan'    => $tieuchuan->loai_tieuchuan,
                'bo_tieuchuan_id'   => $tieuchuan->bo_tieuchuan_id,
                'trang_thai'        => 'active',
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),
            ];
            DB::table("minhchung_tt")->insert($data);
            
        };

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }


    public function suggestions(Request $req){
        $noidung = $req->noidung;
        foreach($req->noidung as $key => $noidung){
            $tieuchi = DB::table("tieuchi")
                    ->where("id", $req->id_tchi)
                    ->select("tieuchuan_id")
                    ->first();
            $tieuchuan = DB::table("tieuchuan")
                    ->where("id", $tieuchi->tieuchuan_id)
                    ->select("bo_tieuchuan_id", "loai_tieuchuan")
                    ->first();
            
            $data = [
                'loai_tieuchuan'    => $tieuchuan->loai_tieuchuan,
                'bo_tieuchuan_id'   => $tieuchuan->bo_tieuchuan_id,
                'tieuchi_id'        => $req->id_tchi,
                'mo_ta'             => $noidung,
                'nguoi_tao'         => Sentinel::getUser()->id,
                'csdt_id'           => $this->getCsdt(),
                'trang_thai'        => 'active',
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),                
            ];
            DB::table("huongdan")->insert($data);
        };
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));

    }
    
    
    public function searchVSUpdateSttSt(Request $req) {
        if($req->idbtc_search != null && $req->idbtc_search != ""){
            $finds = DB::table("tieuchuan")->where("bo_tieuchuan_id", $req->idbtc_search)
                ->select("id", "mo_ta", "stt")
                ->where("deleted_at", null)
                ->orderBy("stt", "asc");

            return DataTables::of($finds)               
                ->addColumn(
                    'stt_custom',
                    function ($finds) {
                        return " 
                            <input type='hidden' value='". $finds->id ."' name='idtc[]'>
                            <input type='number' value='". $finds->stt ."' class='form-control' name='stt[]'>
                        ";
                    }
                )
                ->rawColumns(['stt_custom'])
                ->make(true);
        }
    }

    public function searchVSUpdateSttSt2(Request $req){
        foreach($req->idtc as $key => $idtc){
            $changeSttTC = DB::table("tieuchuan")->where("id", $idtc)
                    ->update([
                        'stt'   =>  $req->stt[$key]
                    ]);
        }
        return back()->with('success', 
                Lang::get('project/Standard/message.success.update'));
    }
    
	public function exportMinimun() {
        return Excel::download(new MinimunExport, 'mctt.xlsx');
    }

    public function fStandardCriteria(Request $req) {
        $dataWrap1 = [];
        $dataWrap2 = [];
        $findStandard = DB::table("tieuchuan")->where("bo_tieuchuan_id", $req->btc)
                        ->select("id", "mo_ta" , "stt")
                        ->orderBy("stt", "asc")
                        ->where("deleted_at", null)
                        ->get();
        foreach($findStandard as $Stan){
            array_push($dataWrap1, (object)array(
                'id_tc'     =>      $Stan->id,
                'mo_ta_tc'  =>      $Stan->mo_ta,
                'stt'  =>      $Stan->stt,
            )); 

            $findCriteria = DB::table("tieuchi")->where("tieuchuan_id", $Stan->id)
                        ->select("id", "mo_ta", "stt");
            if($findCriteria->count() > 0){
                foreach($findCriteria->get() as $Crit){
                    array_push($dataWrap2, (object)array(
                        'id_tc'       =>      $Stan->id,
                        'data_tchi'   =>      "yes",
                        'id_tchi'     =>      $Crit->id,
                        'mo_ta_tchi'  =>      $Crit->mo_ta,
                        'stt'         =>      $Crit->stt,
                    )); 
                }
            }else{
                array_push($dataWrap2, (object)array(
                    'id_tc'       =>    $Stan->id,
                    'data_tchi'   =>    "none"
                )); 
            }
            
        }
        $dataWrap1 = json_encode($dataWrap1);
        $dataWrap2 = json_encode($dataWrap2);

        if($req->id_mctt != null && $req->id_mctt != ""){
            $dataWrap3 = [];
            $role_mctt_tc = DB::table("role_mctt_tchi")->where("mctt_id", $req->id_mctt)
                            ->where("bo_tieuchuan_id", $req->btc)
                            ->select("tieuchi_id")->get();
            return "[" . $dataWrap1 . ","  . $dataWrap2 . "," . $role_mctt_tc  . "]";
        }else{
            return "[" . $dataWrap1 . ","  . $dataWrap2 . "]";
        }
    }



    public function loadTchiMctt(Request $req) {
        $role_ = DB::table("role_mctt_tchi")->where("mctt_id", $req->mctt)->select("tieuchi_id")->get();
        $respon = [];
        foreach($role_ as $ro){
            array_push($respon, strval($ro->tieuchi_id));
        }
        return json_encode($respon);
    }

    public function createMctt(Request $req){
        $req->validate([
            'tieude' => 'required'
        ]);

        $data = [
            'tieu_de' => $req->tieude,
            'trich_yeu'    => $req->ndmctt,
            'tu_khoa'      => '',
            'nguoi_tao'    => Sentinel::getUser()->id,
            'csdt_id'           => $this->getCsdt(),
            'loai_tieuchuan'    => $req->ldg,
            'bo_tieuchuan_id'   => $req->btc,
            'trang_thai'        => 'active',
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),    
        ];
        
        $idmctt = DB::table("minhchung_tt")->insertGetId($data);
        foreach($req->id_tchi as $id_tchi){
            $data_role = [
                'mctt_id'   =>  $idmctt,
                'tieuchi_id'    => $id_tchi,
                'bo_tieuchuan_id'   => $req->btc,
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),   
            ];
            DB::table("role_mctt_tchi")->insert($data_role);
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function updateMctt(Request $req){
        $req->validate([
            'tieude' => 'required'
        ]);
        $exit_role = DB::table("role_mctt_tchi")->where('mctt_id', $req->idmctt)
                    ->select("bo_tieuchuan_id")
                    ->delete();

        $data = [
            'tieu_de' => $req->tieude,
            'trich_yeu'    => $req->ndmctt,
            'loai_tieuchuan'    => $req->ldg,
            'bo_tieuchuan_id'   => $req->btc,
            'updated_at'        => Carbon::now()->toDateTimeString(),    
        ];
        
        DB::table("minhchung_tt")->where("id", $req->idmctt)->update($data);
        foreach($req->up_id_tchi as $id_tchi){
            $data_role = [
                'mctt_id'   =>  $req->idmctt,
                'tieuchi_id'    => $id_tchi,
                'bo_tieuchuan_id'   => $req->btc,
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),   
            ];
            DB::table("role_mctt_tchi")->insert($data_role);
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function loadDataMctt (Request $req){
        $findMctt = DB::table("minhchung_tt as mctt")->where("mctt.id", $req->mctt)
                    ->select("mctt.id", 
                            "mctt.tieu_de AS tieu_de_mctt", 
                            "mctt.trich_yeu", 
                            "mctt.loai_tieuchuan", 
                            "mctt.bo_tieuchuan_id", 
                            "btc.tieu_de AS tieu_de_btc")
                    ->leftjoin('bo_tieuchuan AS btc', 'btc.id', '=', 'mctt.bo_tieuchuan_id')
                    ->first();
        $btc = DB::table("bo_tieuchuan")->where("loai_tieuchuan", $findMctt->loai_tieuchuan)
                ->select("id", "tieu_de")
                ->get();
        $respon = [];
        array_push($respon, $findMctt, $btc);
        return json_encode($respon);
    } 

    public function postChibao(Request $req){
        foreach($req->noidung as $key => $content){
            $data = [
                'tieuchi_id'  => $req->id_tchi,
                'stt'         => $key + 1,
                'mo_ta'       => $content,
                'tu_khoa'     => $content,
                'ns_phutrach' => Sentinel::getUser()->id,
                'nguoi_tao'   => Sentinel::getUser()->id,
                'csdt_id'     => $this->getCsdt(),
                'kiemtra_mc'  => $req->ktmc[$key],
                'kiemtra_tp'  => $req->kttp[$key],
                'trang_thai'        => 'active',
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),
            ];
            DB::table("menhde")->insert($data);
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function dataMocchuan(Request $req) {
        $findMCs = DB::table("mocchuan")->where("tieuchi_id", $req->id_tchi)
                    ->where("trang_thai" , "<>", "deleted")
                    ->orderBy("created_at", "desc");
        return DataTables::of($findMCs)               
            ->addColumn(
                'createAt',
                function ($findMC) {
                    return  date('d/m/Y', strtotime($findMC->created_at));
                }
            )
            ->addColumn(
                'createHuman',
                function ($findMC) {
                    $createHuman = DB::table('users')->where('id', $findMC->nguoi_tao)
                                    ->select('name')->first();
                    if($createHuman) return $createHuman->name;
                    else return '';
                }
            )
            ->addColumn(
                'actions',
                function ($findMC) {
                    $actions = '<button type="button" data-toggle="modal" data-target="#modalUpdate" class="btn mr-2 btn-block" data-id="'.$findMC->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 30px;color: #7239ea;"></i>' .'</button>';
                    $actions = $actions . '<button type="button" data-toggle="modal" data-target="#modalDelete" class="btn mr-2 btn-block" data-id="'.$findMC->id.'">'. '<i class="bi bi-trash" style="font-size: 30px;color: red;"></i>' .'</button>';
                    return $actions;
                }
            )
            ->rawColumns(['mo_ta', 'createAt', 'actions'])
            ->make(true);
    }

    public function deleteMocchuan(Request $req){
        $mocchuan = DB::table("mocchuan")->where("id", $req->id_delete)
                    ->update([
                        'trang_thai'   => 'deleted'
                    ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }
    public function getDataMocchuan(Request $req) {
        $mocchuan = DB::table("mocchuan")->where("id", $req->id_mc)
                    ->select("id", "loai_tieuchuan", "gia_tri", "trong_so", "mo_ta")
                    ->first();
        return json_encode($mocchuan);
    }

    public function updateMocchuan(Request $req){
        $data = [
            'gia_tri'   => $req->inputGiatri,
            'trong_so'  => $req->inputTrongso,
            'mo_ta'     => $req->inputNdmc
        ];
        DB::table("mocchuan")->where("id", $req->id_mch)->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }

    public function dataChibao(Request $req) {
        if($req->id_cb != null && $req->id_cb != ""){
            $findCb = DB::table("menhde")->where("id", $req->id_cb)
                    ->select("mo_ta", "tu_khoa", "kiemtra_mc", "kiemtra_tp", "gioihantu")
                    ->first();
            return json_encode($findCb);
        }else{
            $findMds = DB::table("menhde")->where("tieuchi_id", $req->id_tchi)
                ->select("id", "tieuchi_id", "stt", "mo_ta", "tu_khoa", "gioihantu", "kiemtra_mc",  "kiemtra_tp")
                ->where("trang_thai", "active")
                ->orderBy("created_at", "desc");
            return DataTables::of($findMds)               
                ->addColumn(
                    'ktmc',
                    function ($findMd) {
                        if($findMd->kiemtra_mc == 'Y'){
                            return '<ion-icon name="checkmark-outline" class="text-info"></ion-icon>';
                        }else{
                            return '<ion-icon name="ellipse-outline" class="text-danger"></ion-icon>';
                        }
                    }
                )
                ->addColumn(
                    'kttp',
                    function ($findMd) {
                        if($findMd->kiemtra_tp == 'Y'){
                            return '<ion-icon name="checkmark-outline" class="text-info"></ion-icon>';
                        }else{
                            return '<ion-icon name="ellipse-outline" class="text-danger"></ion-icon>';
                        }
                    }
                )
                ->addColumn(
                    'actions',
                    function ($findMd) {
                        $actions = '<button type="button" data-toggle="modal" data-target="#modalUpdateCb" class="btn mr-2 btn-block" data-id="'.$findMd->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 30px;color: #7239ea;"></i>' .'</button>';
                        $actions = $actions . '<button type="button" data-toggle="modal" data-target="#modalDeleteCb" class="btn mr-2 btn-block" data-id="'.$findMd->id.'">'. '<i class="bi bi-trash" style="font-size: 30px;color: red;"></i>' .'</button>';
                        return $actions;
                    }
                )
                ->rawColumns(['ktmc', 'kttp' , 'actions'])
                ->make(true);
        }
        
    }

    public function deleteChibao(Request $req){
        $findCb = DB::table("menhde")->where("id", $req->id_delete)
                    ->update([
                        'trang_thai' => 'deleted'
                    ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateChibao(Request $req){
        $data = [
            'mo_ta'     =>  $req->ndcb,
            'tu_khoa'   =>  $req->tukhoa,
            'kiemtra_mc'=>  $req->value_inputKtmc,
            'kiemtra_tp'=>  $req->value_inputKttp,
            'gioihantu' =>  $req->gioihan
        ];
        $findCb = DB::table("menhde")->where("id", $req->id_chibao)->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }

    public function showSugges(){
        $loai_tieuchuan = (object) array(
            'csgd'  => Lang::get('project/Standard/title.csgd'),
            'ctdt'  => Lang::get('project/Standard/title.ctdt'),
        );
        return view('admin.project.Standard.show_suggestions')->with(
            'loai_tieuchuan'    , $loai_tieuchuan
        ); // thường trực - Minh chứng tối thiểu
    }

    public function dataSugges(Request $req) { 
        $gyhds = DB::table('huongdan AS hd')
                ->select("hd.id", "hd.mo_ta as mo_ta_gyhd", "hd.loai_tieuchuan", "hd.bo_tieuchuan_id", "btc.tieu_de as tieu_de_btc")
                ->leftjoin('bo_tieuchuan AS btc', 'btc.id', '=', 'hd.bo_tieuchuan_id')
                ->where("hd.trang_thai", "<>",  "deleted")
                ->orderBy("hd.id", "asc");

        if($req->mctt_name != "" && $req->ldg == "" && $req->btc_id == ""){
            $gyhds = $gyhds->where('hd.mo_ta', 'like', '%'. $req->mctt_name .'%');
        };
        if($req->mctt_name == "" && $req->ldg != "" && $req->btc_id == ""){
            $gyhds = $gyhds->where('hd.loai_tieuchuan', $req->ldg );
        };
        if($req->mctt_name == "" && $req->ldg != "" && $req->btc_id != ""){
            $gyhds = $gyhds->where('btc.id', $req->btc_id);
        };
        if($req->mctt_name != "" && $req->ldg != "" && $req->btc_id == ""){
            $gyhds = $gyhds->where('hd.mo_ta', 'like', '%'. $req->mctt_name .'%')
                    ->where('hd.loai_tieuchuan', $req->ldg );
        };
        if($req->mctt_name != "" && $req->ldg != "" && $req->btc_id != ""){
            $gyhds = $gyhds->where('hd.mo_ta', 'like', '%'. $req->mctt_name .'%')
                    ->where('btc.id', $req->btc_id);
        };
        return DataTables::of($gyhds)  
            ->addColumn(
                'tchi_ad',
                function ($gyhd) {
                    $roles = DB::table("role_gyhd_tchi")->where("gyhd_id", $gyhd->id)
                        ->where("bo_tieuchuan_id", $gyhd->bo_tieuchuan_id)
                        ->where("trang_thai", "<>",  "deleted")
                        ->select("tieuchi_id")
                        ->get();
                    $spanUI = "";
                    foreach($roles as $role){
                        $tchi_tc = DB::table("tieuchi as tchi")
                                    ->select(
                                        "tchi.stt as stt_tchi", 
                                        "tchi.id", 
                                        "tchi.mo_ta", 
                                        "tchi.tieuchuan_id",
                                        "tc.stt as stt_tc", 
                                    )
                                    ->leftjoin('tieuchuan AS tc', 'tc.id', '=', 'tchi.tieuchuan_id')
                                    ->where("tchi.id", $role->tieuchi_id)
                                    ->first();

                        $spanUI .= "<span class='badge badge-primary mr-2 mt-2'>". $tchi_tc->stt_tc .".". $tchi_tc->stt_tchi ."</span>";
                    }
                    return $spanUI;
                }
            )             
            ->addColumn(
                'actions',
                function ($gyhd) {
                    $actions = '<button type="button" data-toggle="modal" data-target="#modalUpdate" class="btn" data-id="'.$gyhd->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 30px;color: #5014d0;"></i>' .'</button>';
                    $actions = $actions . '<button type="button" data-toggle="modal" data-target="#modalDelete" class="btn" data-id="'.$gyhd->id.'">'. '<i class="bi bi-trash" style="font-size: 30px;color: red;"></i>' .'</button>';
                    return $actions;
                }
            )
            ->addColumn(
                'ldg',
                function ($gyhd) {
                    if($gyhd->loai_tieuchuan == 'csgd')
                        return Lang::get('project/Standard/title.csgd');
                    else if($gyhd->loai_tieuchuan == 'ctdt')
                        return Lang::get('project/Standard/title.ctdt');
                }
            )
            
            ->rawColumns(['actions', 'tchi_ad', 'mo_ta_gyhd'])
            ->make(true);
    }

    public function deleteSugge(Request $req) {
        $delete_suggu = DB::table("huongdan")->where("id", $req->id_delete)
                        ->update([
                            'trang_thai' => 'deleted'
                        ]);
        $delete_role = DB::table("role_gyhd_tchi")->where("gyhd_id", $req->id_delete)
                        ->update([
                            'trang_thai' => 'deleted'
                        ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function createGyhd(Request $req){
        $req->validate([
            'ndmctt' => 'required'
        ]);

        $data = [
            'mo_ta'    => $req->ndmctt,
            'nguoi_tao'    => Sentinel::getUser()->id,
            'csdt_id'           => $this->getCsdt(),
            'loai_tieuchuan'    => $req->ldg,
            'bo_tieuchuan_id'   => $req->btc,
            'trang_thai'        => 'active',
            'created_at'        => Carbon::now()->toDateTimeString(),
            'updated_at'        => Carbon::now()->toDateTimeString(),    
        ];
        
        $idmctt = DB::table("huongdan")->insertGetId($data);

        foreach($req->id_tchi as $id_tchi){
            $data_role = [
                'gyhd_id'   =>  $idmctt,
                'tieuchi_id'    => $id_tchi,
                'bo_tieuchuan_id'   => $req->btc,
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),   
            ];
            DB::table("role_gyhd_tchi")->insert($data_role);
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function exportGyhd() {
        return Excel::download(new GyhdExport, 'goi_y_huong_dan.xlsx');
    }

    public function loadDataSugg (Request $req){
        $findMctt = DB::table("huongdan as mctt")->where("mctt.id", $req->mctt)
                    ->select("mctt.id", 
                            "mctt.mo_ta AS tieu_de_mctt", 
                            "mctt.loai_tieuchuan", 
                            "mctt.bo_tieuchuan_id", 
                            "btc.tieu_de AS tieu_de_btc")
                    ->leftjoin('bo_tieuchuan AS btc', 'btc.id', '=', 'mctt.bo_tieuchuan_id')
                    ->first();
        $btc = DB::table("bo_tieuchuan")->where("loai_tieuchuan", $findMctt->loai_tieuchuan)
                ->select("id", "tieu_de")
                ->get();
        $respon = [];
        array_push($respon, $findMctt, $btc);
        return json_encode($respon);
    } 


    public function fStandardCriteria2(Request $req) {
        $dataWrap1 = [];
        $dataWrap2 = [];
        $findStandard = DB::table("tieuchuan")->where("bo_tieuchuan_id", $req->btc)
                        ->select("id", "mo_ta", "stt")
                        ->orderBy("stt", "asc")
                        ->where("deleted_at", null)
                        ->get();
        foreach($findStandard as $Stan){
            array_push($dataWrap1, (object)array(
                'id_tc'     =>      $Stan->id,
                'mo_ta_tc'  =>      $Stan->mo_ta,
                'stt'       => $Stan->stt,
            )); 

            $findCriteria = DB::table("tieuchi")->where("tieuchuan_id", $Stan->id)
                        ->select("id", "mo_ta" , "stt");
            if($findCriteria->count() > 0){
                foreach($findCriteria->get() as $Crit){
                    array_push($dataWrap2, (object)array(
                        'id_tc'       =>      $Stan->id,
                        'data_tchi'   =>      "yes",
                        'id_tchi'     =>      $Crit->id,
                        'mo_ta_tchi'  =>      $Crit->mo_ta,
                        'stt'  =>      $Crit->stt,
                    )); 
                }
            }else{
                array_push($dataWrap2, (object)array(
                    'id_tc'       =>    $Stan->id,
                    'data_tchi'   =>    "none"
                )); 
            }
            
        }
        $dataWrap1 = json_encode($dataWrap1);
        $dataWrap2 = json_encode($dataWrap2);

        if($req->id_mctt != null && $req->id_mctt != ""){
            $dataWrap3 = [];
            $role_mctt_tc = DB::table("role_gyhd_tchi")->where("gyhd_id", $req->id_mctt)
                            ->where("bo_tieuchuan_id", $req->btc)
                            ->select("tieuchi_id")->get();
            return "[" . $dataWrap1 . ","  . $dataWrap2 . "," . $role_mctt_tc  . "]";
        }else{
            return "[" . $dataWrap1 . ","  . $dataWrap2 . "]";
        }
    }

    public function loadTchiMctt2(Request $req) {
        $role_ = DB::table("role_gyhd_tchi")->where("gyhd_id", $req->mctt)->select("tieuchi_id")->get();
        $respon = [];
        foreach($role_ as $ro){
            array_push($respon, strval($ro->tieuchi_id));
        }
        return json_encode($respon);
    }

    public function updateGyhd(Request $req){
        $req->validate([
            'ndmctt' => 'required'
        ]);
        $exit_role = DB::table("role_gyhd_tchi")->where('gyhd_id', $req->idmctt)
                    ->select("bo_tieuchuan_id")
                    ->delete();

        $data = [
            'mo_ta'    => $req->ndmctt,
            'loai_tieuchuan'    => $req->ldg,
            'bo_tieuchuan_id'   => $req->btc,
            'updated_at'        => Carbon::now()->toDateTimeString(),    
        ];
        
        DB::table("huongdan")->where("id", $req->idmctt)->update($data);
        foreach($req->up_id_tchi as $id_tchi){
            $data_role = [
                'gyhd_id'   =>  $req->idmctt,
                'tieuchi_id'    => $id_tchi,
                'bo_tieuchuan_id'   => $req->btc,
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),   
            ];
            DB::table("role_gyhd_tchi")->insert($data_role);
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }
    public function updateNameTC(Request $req){
        $tieuchuan = DB::table("tieuchuan")->where("id", $req->id_tchuan)
                    ->update([
                        'mo_ta'     => $req->nameTC
                    ]);
        return redirect()->back()
                    ->with('success', 
                    Lang::get('project/Standard/message.success.update'));  
    }
    public function upCriteria(Request $req){
        $tieuChi = DB::table("tieuchi")->where("id" , $req->id_tchi)
                    ->update([
                        'mo_ta'     => $req->nameTchi
                    ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
}