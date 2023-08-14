<?php namespace App\Http\Controllers\Admin\Project\Dambaochatluong\UpdateAci;

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
use App\Exports\exceltactionExport;

class UpdateAciController extends DefinedController
{
    public function index(Request $req){
        $linh_vuc = "";
        if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){
            $linh_vuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        }else if(Sentinel::inRole('truongdonvi')){
            $kehoach = DB::table('kehoach_cc_solieu')
                        ->select('nhom_mc_sl_id')
                        ->where('dv_thuchien',Sentinel::getUser()->donvi_id)
                        ->get();
            $arr = [];
            foreach($kehoach as $val){
                array_push($arr,$val->nhom_mc_sl_id);
            }
            $linh_vuc = DB::table("nhom_mc_sl")
                        ->select("id", "mo_ta")
                        ->whereIn('id',$arr)
                        ->get();

        }

        // if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){
        //     $linh_vuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        // }else if(Sentinel::inRole('truongdonvi')){
            
        //     $linh_vuc = DB::table("nhom_mc_sl")
        //                     ->select("id", "mo_ta")
        //                     ->where("donvi_id",Sentinel::getUser()->donvi_id)
        //                     ->get();
        // }
        if($linh_vuc != ""){
            return view('admin.project.QualiAssurance.updateaci')->with([
                "linhvuc" =>  $linh_vuc
            ]);   
        }else{
            return back()->with('error', 
                    'Bạn không có quyền thực hiện chức năng này');
        }
        
        
    }


    public function viewAction(Request $req){
        $hdns = DB::table('hoatdongnhom AS hdn')
                ->where('hdn.parent', 0)
                ->where("hdn.deleted_at", null)
                ->leftjoin("nhom_mc_sl AS mcsl" , 'mcsl.id', '=', 'hdn.nhom_mc_sl_id')
                ->select("hdn.id AS id_hdn", "hdn.year", "hdn.nhom_mc_sl_id", "mcsl.mo_ta",
                 "hdn.noi_dung", "hdn.parent", 'mcsl.id')
                ->orderBy('hdn.year', 'desc');
        
        if(!Sentinel::inRole('operator') && Sentinel::inRole('truongdonvi')){
            $kehoach = DB::table('kehoach_cc_solieu')
                        ->select('nhom_mc_sl_id')
                        ->where('dv_thuchien',Sentinel::getUser()->donvi_id)
                        ->get();
            $arr = [];
            foreach($kehoach as $val){
                array_push($arr,$val->nhom_mc_sl_id);
            }
            $hdns->whereIn("hdn.nhom_mc_sl_id",$arr);
        }
        
        if($req->content != "" && $req->year == "" && $req->mcsl == ""){
            $hdns = $hdns->where('hdn.noi_dung', 'like', '%'. $req->content .'%');
        }
        if($req->content == "" && $req->year != "" && $req->mcsl == ""){
            $hdns = $hdns->where('hdn.year', $req->year);
        }
        if($req->content == "" && $req->year == "" && $req->mcsl != ""){
            $hdns = $hdns->where('mcsl.id', $req->mcsl);
        }
        if($req->content != "" && $req->year != "" && $req->mcsl == ""){
            $hdns = $hdns->where('hdn.noi_dung', 'like', '%'. $req->content .'%')
                            ->where('hdn.year', $req->year);
        }
        if($req->content != "" && $req->year == "" && $req->mcsl != ""){
            $hdns = $hdns->where('hdn.noi_dung', 'like', '%'. $req->content .'%')
                            ->where('mcsl.id', $req->mcsl);
        }
        if($req->content == "" && $req->year != "" && $req->mcsl != ""){
            $hdns = $hdns->where('hdn.year', $req->year)->where('mcsl.id', $req->mcsl);
        }
        if($req->content != "" && $req->year != "" && $req->mcsl != ""){
            $hdns = $hdns->where('hdn.noi_dung', 'like', '%'. $req->content .'%')
                    ->where('hdn.year', $req->year)->where('mcsl.id', $req->mcsl);
        }

        return DataTables::of($hdns) 
            ->addColumn('mcyc',function ($hdn){
                return $count = DB::table("hoatdongnhom")->where("parent", $hdn->id_hdn)->count();
            })
            ->addColumn('actions',function ($hdn){
                    $actions = '<a href="'. route('admin.dambaochatluong.updateaci.manaAction', ['id' => $hdn->id_hdn]) .'" class="btn mt-2 btn-block" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.qlhd').'">'. '<i class="bi bi-gear-fill" style="font-size: 25px;color: #009ef7;"></i>' .'</a>';

                    if( Sentinel::inRole('truongdonvi') || Sentinel::inRole('admin') || Sentinel::inRole('operator')){
                        $actions = $actions . '<button type="button" class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'. $hdn->id_hdn .'">
                            '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                        </button>';
                    }
                    
                    // $actions = $actions . '<button type="button" class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'. $hdn->id_hdn .'">
                    //         '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                    //     </button>';
                
                    return $actions;
            })
            ->rawColumns(['actions'])           
            ->make(true);
    }

    
    public function createMcyc(Request $req){
        $hoatDongNhom = [];
        if ($req->parent != '') {
            $checkHoatDongNhom = DB::table("hoatdongnhom")
                                ->where("id", $req->parent)->first();
            $isDonViPhuTrach = false;
            $hdn_khtl = DB::table("kehoach_cc_solieu")
                    ->where("id", $checkHoatDongNhom->kehoach_id)
                    ->select("dv_thuchien");


            // // tạm bỏ check đơn vị phụ trách
            // if($hdn_khtl->count() > 0){
            //     $khtl_dvth = DB::table("donvi")->where("id", $hdn_khtl->first()->dv_thuchien)
            //                 ->select("truong_dv", "canbo_dbcl")
            //                 ->first();
            //     if($khtl_dvth->truong_dv == Sentinel::getUser()->id ||
            //        $khtl_dvth->canbo_dbcl == Sentinel::getUser()->id ){
            //         $isDonViPhuTrach = true;
            //     }
            // }
            $isDonViPhuTrach = true;

            if($isDonViPhuTrach){
                $hoatDongNhom['parent'] = $req->parent;
                $hoatDongNhom['ngay_batdau'] = date("Y-m-d", strtotime($req->startDate));
                $hoatDongNhom['ngay_hoanthanh'] = date("Y-m-d", strtotime($req->endDate));
                $hoatDongNhom['nhom_mc_sl_id'] = $checkHoatDongNhom->nhom_mc_sl_id;
                $hoatDongNhom['year'] = $checkHoatDongNhom->year;
                $hoatDongNhom['kehoach_id'] = $checkHoatDongNhom->kehoach_id;
                $hoatDongNhom['noi_dung'] = $req->noidung;
                $hoatDongNhom['csdt_id'] = Sentinel::getUser()->csdt_id;
                $hoatDongNhom['nguoi_tao'] = Sentinel::getUser()->id;
                $id_hdn_new = DB::table("hoatdongnhom")->insertGetId($hoatDongNhom);

                if($req->dv_thuchien != null){
                    foreach ($req->dv_thuchien as $dv_thuchien) {
                        $donVi = DB::table("donvi")->where("id", $dv_thuchien)
                                ->select("truong_dv", "canbo_dbcl");
                        if ($donVi->count() > 0) {
                            $donVi = $donVi->first();
                            // echo($donVi->truong_dv);
                            // die;
                            $dataThongBao1 = [
                                'nguoi_gui'     => Sentinel::getUser()->id,
                                'nguoi_nhan'    => $donVi->truong_dv,
                                'tieude'        => Lang::get('project/QualiAssurance/title.bvnmcv'),
                                'noidung'       => Lang::get('project/QualiAssurance/title.xdndmcyc') . $hoatDongNhom['noi_dung'] . Lang::get('project/QualiAssurance/title.tungay') . $hoatDongNhom['ngay_batdau'] . Lang::get('project/QualiAssurance/title.denngay') . $hoatDongNhom['ngay_hoanthanh'],
                                'icon'          => '',
                                'route'         => 'tailieu.hoatdongnhom.edit',
                                'route_value'   => json_encode(['id' => $id_hdn_new]),
                                'csdt_id'       => Sentinel::getUser()->csdt_id,
                            ];
                            $dataThongBao2 = [
                                'nguoi_gui'     => Sentinel::getUser()->id,
                                'nguoi_nhan'    => $donVi->canbo_dbcl,
                                'tieude'        => Lang::get('project/QualiAssurance/title.bvnmcv'),
                                'noidung'       => Lang::get('project/QualiAssurance/title.xdndmcyc') . $hoatDongNhom['noi_dung'] . Lang::get('project/QualiAssurance/title.tungay') . $hoatDongNhom['ngay_batdau'] . Lang::get('project/QualiAssurance/title.denngay') . $hoatDongNhom['ngay_hoanthanh'],
                                'icon'          => '',
                                'route'         => 'tailieu.hoatdongnhom.edit',
                                'route_value'   => json_encode(['id' => $id_hdn_new]),
                                'csdt_id'       => Sentinel::getUser()->csdt_id,
                            ];
                            DB::table("thongbao")->insert($dataThongBao1);
                            DB::table("thongbao")->insert($dataThongBao2);
                            DB::table("hoatdongnhom_donvi")->insert([
                                'hoatdongnhom_id'   => $id_hdn_new,
                                'donvi_id'          => $dv_thuchien
                            ]);
                        }
                    }
                }
            }
        };
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function manaAction(Request $req){
        $hdn = DB::table('hoatdongnhom')->select("id", "noi_dung", "nhom_mc_sl_id")
                    ->where("id", $req->id)->first();
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();

        return view('admin.project.QualiAssurance.manaaction')->with([
            "hdn" =>  $hdn,
            'linhvuc'   => $linhvuc,
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
        ]);
    }
	
    public function updateMcyc(Request $req) {
        $data = [
            'nhom_mc_sl_id' => $req->id_mcsl,
            'noi_dung' => $req->name_hd
        ];
        DB::table("hoatdongnhom")->where("id", $req->id_hdn)->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }

    public function createAction(Request $req){
        $logCheck = false;
        foreach($req->content as $content){
            $checkExit = DB::table("hoatdongnhom")
                ->where('nhom_mc_sl_id', $req->id_mcsl)
                ->where('year', $req->year)
                ->where('noi_dung', $content);
            if($checkExit->count() > 0){
                $logCheck = true;
            }
            if($content != "" && $checkExit->count() == 0){
                $data = [
                    'nhom_mc_sl_id'     => $req->id_mcsl,
                    'year'              => $req->year,
                    'noi_dung'          => $content,
                    'nguoi_tao'         => Sentinel::getUser()->id,
                    'created_at'        => Carbon::now()->toDateTimeString(),
                    'updated_at'        => Carbon::now()->toDateTimeString(),
                ];
                DB::table("hoatdongnhom")->insert($data);
            }
            
        }
        if($logCheck == true){
            return back()->with('warning', 
                    Lang::get('project/Standard/title.logCheck'));
        }else{
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
        }
    }
    
    public function deleteAction(Request $req){
        DB::table("hoatdongnhom")->where("id", $req->id_delete)->delete();

        $child =  DB::table("hoatdongnhom")->where("parent", $req->id_delete);
        

        DB::table("kehoach_hanhdong")->whereIn("hoatdongnhom_id", $child->pluck("id"))
            ->delete();

        $child->delete();
        

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function showMcyc($id) {
        // $hoatDongNhom = DB::table("hoatdongnhom")->where('id', '=', $id)->first();
        $querys = DB::table("hoatdongnhom")
                ->where('parent', $id)
                ->where("deleted_at", null)
                ->orderBy('noi_dung', 'asc');

        return DataTables::of($querys) 
            ->addColumn('tenDv',function ($query){
                $hdn_dv = DB::table("hoatdongnhom_donvi AS hdnDv")
                        ->leftjoin("donvi AS dv" , 'dv.id', '=', 'hdnDv.donvi_id')
                        ->where("hdnDv.hoatdongnhom_id", $query->id)
                        ->select("hdnDv.donvi_id", "dv.ten_donvi")->get();
                $respon = '';
                foreach($hdn_dv as $hdndv){
                    $respon .= '<span class="badge badge-success">'. $hdndv->ten_donvi .'</span>';
                }
                return $respon;
            })
            ->addColumn('actions',function ($query){
                    $actions = '<a href="'. route('admin.dambaochatluong.updateaci.upGetMcyc', ['id' => $query->id]) .'" class="btn"data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.cnmcyc').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</a>';
                    $actions = $actions . '<button type="button" class="btn" data-toggle="modal" data-target="#modalDelete" data-id="'. $query->id .'">
                            '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                        </button>';
                    return $actions;
            })
            ->addColumn('thoi_gian',function ($query){
                    return date("d/m/Y", strtotime($query->ngay_batdau)) . ' - ' . 
                    date("d/m/Y", strtotime($query->ngay_hoanthanh));
            })
            ->addColumn('trang_thai',function ($query){
                $hdn_mc = DB::table("hoatdongnhom_minhchung")->where("hoatdongnhom_id", $query->id)->count();
                if($query->cong_bo == "Y")
                    return '<span class="badge badge-success">'. Lang::get('project/QualiAssurance/title.dxnvcb') .'</span>';
                else if($query->cong_bo == "P")
                    return '<span class="badge badge-success">'. Lang::get('project/QualiAssurance/title.kxn') .'</span>';
                else{
                    if($hdn_mc == 0)
                        return '<span class="badge badge-success">'. Lang::get('project/QualiAssurance/title.cht') .'</span>';
                    else
                        return '<span class="badge badge-success">'. Lang::get('project/QualiAssurance/title.dth') .'</span>';
                }

            })
            ->rawColumns(['tenDv', 'actions', 'thoi_gian', 'trang_thai'])           
            ->make(true);
    }
    public function upGetMcyc(Request $req) {
        $hdn = DB::table('hoatdongnhom')->select("id", "noi_dung", "nhom_mc_sl_id", 
            "ngay_batdau", "ngay_hoanthanh")
                    ->where("id", $req->id)->first();

        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();

        $hdn_dv = DB::table("hoatdongnhom_donvi")
                    ->where("hoatdongnhom_id", $req->id)
                    ->select("donvi_id")->get();
        $minhchung = DB::table("minhchung")->where("nhom_mc_sl_id", $hdn->nhom_mc_sl_id)
                    ->limit(6)->select("id", "tieu_de")->get();
        return view('admin.project.QualiAssurance.mcycupdate')->with([
            "hdn" =>  $hdn,
            'hdn_dv'    => $hdn_dv,
            'linhvuc'   => $linhvuc,
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'minhchung'         => $minhchung
        ]);
    }
    public function postUpdateMcyc(Request $req) {
        $hoatDongNhom = [];
        $hoatDongNhom['ngay_batdau'] = date("Y-m-d", strtotime($req->startDate));
        $hoatDongNhom['ngay_hoanthanh'] = date("Y-m-d", strtotime($req->endDate));
        $hoatDongNhom['noi_dung'] = $req->noidung;
        DB::table("hoatdongnhom")
                ->where("id", $req->hdn_id)
                ->update($hoatDongNhom);

        if($req->dv_thuchien != null){
            $check = DB::table("hoatdongnhom_donvi")
                ->where("hoatdongnhom_id", $req->hdn_id)
                ->delete();
            foreach ($req->dv_thuchien as $dv_thuchien) {
                $donVi = DB::table("donvi")->where("id", $dv_thuchien)
                        ->select("truong_dv", "canbo_dbcl");
                if ($donVi->count() > 0) {
                    $donVi = $donVi->first();
                    // $dataThongBao1 = [
                    //     'nguoi_gui'     => Sentinel::getUser()->id,
                    //     'nguoi_nhan'    => $donVi->truong_dv,
                    //     'tieude'        => Lang::get('project/QualiAssurance/title.bvnmcv'),
                    //     'noidung'       => Lang::get('project/QualiAssurance/title.xdndmcyc') . $hoatDongNhom['noi_dung'] . Lang::get('project/QualiAssurance/title.tungay') . $hoatDongNhom['ngay_batdau'] . Lang::get('project/QualiAssurance/title.denngay') . $hoatDongNhom['ngay_hoanthanh'],
                    //     'icon'          => '',
                    //     'route'         => 'tailieu.hoatdongnhom.edit',
                    //     'route_value'   => json_encode(['id' => $id_hdn_new]),
                    //     'csdt_id'       => Sentinel::getUser()->csdt_id,
                    // ];
                    // $dataThongBao2 = [
                    //     'nguoi_gui'     => Sentinel::getUser()->id,
                    //     'nguoi_nhan'    => $donVi->canbo_dbcl,
                    //     'tieude'        => Lang::get('project/QualiAssurance/title.bvnmcv'),
                    //     'noidung'       => Lang::get('project/QualiAssurance/title.xdndmcyc') . $hoatDongNhom['noi_dung'] . Lang::get('project/QualiAssurance/title.tungay') . $hoatDongNhom['ngay_batdau'] . Lang::get('project/QualiAssurance/title.denngay') . $hoatDongNhom['ngay_hoanthanh'],
                    //     'icon'          => '',
                    //     'route'         => 'tailieu.hoatdongnhom.edit',
                    //     'route_value'   => json_encode(['id' => $id_hdn_new]),
                    //     'csdt_id'       => Sentinel::getUser()->csdt_id,
                    // ];
                    // DB::table("thongbao")->insert($dataThongBao1);
                    // DB::table("thongbao")->insert($dataThongBao2);
                    
                    DB::table("hoatdongnhom_donvi")->insert([
                        'hoatdongnhom_id'   => $req->hdn_id,
                        'donvi_id'          => $dv_thuchien
                    ]);
                }
            }
        }
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
    public function showHdnMc($id) {
        $hdn_mcs = DB::table("hoatdongnhom_minhchung")
                ->where("hoatdongnhom_id", $id)->get();
        $id_Minhchung = [];
        foreach($hdn_mcs as $value){
            array_push($id_Minhchung, $value->minhchung_id);
        };
        $minhchung = DB::table("minhchung")->whereIn("id", $id_Minhchung);

        return DataTables::of($minhchung) 
            ->addColumn('linhvuc',function ($mc){
                $lv = DB::table("nhom_mc_sl")->where("id", $mc->nhom_mc_sl_id)
                        ->select("mo_ta");
                if($lv->count = 0){
                    return Lang::get('project/QualiAssurance/title.ltlv');
                }else{
                    return $lv->first()->mo_ta;
                }   
            })
            ->addColumn('ngayBanhanh',function ($mc){
                return date("d-m-Y", strtotime($mc->ngay_ban_hanh));   
            })
            ->addColumn('quan_ly',function ($mc){
                $quan_ly = DB::table("users")->where("id", $mc->nguoi_quan_ly)
                            ->select("name");
                if($quan_ly->count() > 0)
                    return $quan_ly->first()->name;
                else return Lang::get('project/QualiAssurance/title.kcql');
            })
            
            ->addColumn('actions',function ($mc){
                $actions = '<a href="'. route('admin.dambaochatluong.manaproof.editProof',$mc->id) .'" class="btn"data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.capnhatminhchung').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</a>';
                $actions = $actions . '<button type="button" class="btn" data-toggle="modal" data-target="#modalDelete" data-id="'. $mc->id .'">
                        '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                    </button>';
                return $actions;
            })
            ->rawColumns(['actions'])           
            ->make(true);
    }
    public function deleteMcyc(Request $req) {
        DB::table("hoatdongnhom")->where("id", $req->id_delete)
            ->delete();
        DB::table("kehoach_hanhdong")->where("hoatdongnhom_id", $req->id_delete)->delete();
            // ->update([
            //         'deleted_at'      => Carbon::now()->toDateTimeString()
            // ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function showDataMc(Request $req){
        if($req->id_mcsl != null && $req->id_mcsl != ""){
            $findMc = DB::table("minhchung")->where("nhom_mc_sl_id", $req->id_mcsl)
                ->limit(6)->select("id", "tieu_de")->get();
            return json_encode($findMc);
        }else if($req->id_mc != null && $req->id_mc != ""){
            $findMc = DB::table("minhchung")->where("minhchung.id", $req->id_mc)
                    ->leftjoin('users', 'users.id', '=', 'minhchung.nguoi_quan_ly')
                    ->select(
                        "minhchung.tieu_de",
                        "minhchung.id",
                        "minhchung.sohieu",
                        "minhchung.ngay_ban_hanh",
                        "minhchung.noi_banhanh",
                        "minhchung.address",
                        "users.name"
                    )
                ->first();
            $findMc->ngay_ban_hanh = date("d/m/Y", strtotime($findMc->ngay_ban_hanh));
            return json_encode($findMc);
        }
    }
    public function chenMc(Request $req){
        $hoatDongNhom = DB::table("hoatdongnhom")->where('id', $req->id_hdn);
        if ($hoatDongNhom->first()->cong_bo == 'Y') {
            return json_encode(
                array(
                    'status'    => 'fail',
                    'mes'  => Lang::get('project/QualiAssurance/title.ktccb')
                )
            );
        }
        $minhChung = DB::table("minhchung")->where("id", $req->id_mc)->first();

        $hoatDongNhomMinhChung = DB::table("hoatdongnhom_minhchung")->where([
            ['hoatdongnhom_id', $req->id_hdn],
            ['minhchung_id', $req->id_mc],
        ]);

        if ($hoatDongNhomMinhChung->count() > 0) {
            return json_encode(
                array(
                    'status'    => 'fail',
                    'mes'  => Lang::get('project/QualiAssurance/title.mcdcr')
                )
            );
        }
        $data = [
            'hoatdongnhom_id' => $req->id_hdn,
            'minhchung_id'    => $req->id_mc,
            'nguoitao'        => Sentinel::getUser()->id,
            'csdt_id'         => Sentinel::getUser()->csdt_id,
        ];
        DB::table("hoatdongnhom_minhchung")->insert($data);
        $hoatDongNhom->update([
            'cong_bo'   => 'N'
        ]);
        return json_encode(
            array(
                'status'    => 'done',
                'mes'  => Lang::get('project/QualiAssurance/title.cmctc')
            )
        );
    }

    public function createMc(Request $req) {
        $idhdn = $req->idhdn;
        $hoatDongNhomParent = null;
        $linhvuc = null;
        $hoatDongNhom = DB::table('hoatdongnhom')->select("id", "noi_dung", "nhom_mc_sl_id", 
            "ngay_batdau", "ngay_hoanthanh", "cong_bo", "parent")
                    ->where("id", $idhdn)->first();
        if ($hoatDongNhom->cong_bo == 'Y') {
            return back()->with('error', 
                    Lang::get('project/QualiAssurance/title.kcdmccb'));
        }
        if ($hoatDongNhom->parent != 0) {
            $hoatDongNhomParent = DB::table("hoatdongnhom")
                    ->where("id", $hoatDongNhom->parent)->first();
            $linhvuc = DB::table("nhom_mc_sl")->where("id", $hoatDongNhomParent->nhom_mc_sl_id)
                        ->select("id", "mo_ta")->first();
        }

        $linhvucAll = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
                        
        return view('admin.project.QualiAssurance.createmc')->with([
            "hdn" =>  $hoatDongNhom,
            'hoatDongNhomParent'   => $hoatDongNhomParent,
            'linhvucAll'        => $linhvucAll,
            // 'hdn_dv'    => $hdn_dv,
            'linhvuc'   => $linhvuc,
            // 'loai_dv'           => $loai_dv,
            // 'donvi'             => $donvi,
            // 'minhchung'         => $minhchung
        ]);
    }

    public function getDataMc(Request $request) {
        $query = DB::table("minhchung")->where('trang_thai', '=', 'active')
                    ->select("tieu_de", "id", "nguoi_quan_ly", "address", "trich_yeu",
                    "noi_banhanh", "sohieu", "ngay_ban_hanh", "url", "ten_file");
        if(!empty($request->search)){
            $query->where('tieu_de', 'like', '%'.$request->search.'%');
        }
        $minhChungList = $query->paginate(15);

        $minhChungList->map(function ($item){
            $name = DB::table("users")->select("name")->where("id", $item->nguoi_quan_ly);
            if($name->count() == 0)
                $item->ten_quan_ly = "";
            else
                $item->ten_quan_ly = $name->first()->name;
            $item->ng_bh = date("d-m-Y", strtotime($item->ngay_ban_hanh));
        });
        return $minhChungList;
    }

    public function getListUser(Request $request) {
        $query = DB::table("users")->select("id", "name");
        if(!empty($request->search)){
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        $user = $query->paginate(15);
        return $user;
    }

    public function getListTag() {
        // tag từ khóa minh chứng
        $data = array("Amsterdam",
          "London",
          "Paris",
          "Cape Town",
          "Kinshasa");
        return json_encode($data);
    }
    
    public function exceltaction(){
        return Excel::download(new exceltactionExport(), 'exceltaction.xlsx');
    }
}
    