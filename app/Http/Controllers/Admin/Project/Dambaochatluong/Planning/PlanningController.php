<?php namespace App\Http\Controllers\Admin\Project\Dambaochatluong\Planning;

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
use App\Exports\PlanningExport;
class PlanningController extends DefinedController
{
    public function getCsdt() {
        if(Sentinel::check()){
            return Sentinel::getUser()->csdt_id;
        }
    }

    public function index(Request $req){
        $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();

        $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $linh_vuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();

        $nsKiemTra =  DB::table("users AS us")
                    ->select("us.name", "dv.ten_donvi", "us.id")
                    ->leftjoin('donvi AS dv', 'dv.id', '=', 'us.donvi_id')->get();

        

        return view('admin.project.QualiAssurance.planning')->with([
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'linh_vuc'          => $linh_vuc,
            'nskt'              => $nsKiemTra
        ]);
    }

    public function loadDataCopy(Request $req) {
        $plannings = DB::table('kehoach_cc_solieu AS ccsl')
                    ->leftjoin('nhom_mc_sl AS mcsl', 'mcsl.id', '=', 
                'ccsl.nhom_mc_sl_id')
                    ->where("year", $req->namcopykh)
                    ->where("ccsl.deleted_at"  ,null)
                    ->select("ccsl.id", "ccsl.nhom_mc_sl_id", "ccsl.dv_thuchien", "ccsl.dv_kiemtra", "mcsl.mo_ta", "ccsl.notes");

        $planningExits = DB::table("kehoach_cc_solieu")
                    ->where("year", $req->namlkh)
                    ->pluck("nhom_mc_sl_id");

        $plannings = $plannings->whereNotIn("ccsl.nhom_mc_sl_id", $planningExits);
        $plannings = $plannings->get();
        return json_encode($plannings);
    }
    
    public function copyPlan(Request $req){
        foreach($req->linhvuc_id as $key => $value){
            if($value != null && $req->startDate[$key] != null && $req->endDate[$key] != null 
                && $req->dvpt[$key] != null && $req->nskt[$key] != null){
                $data = [
                    'dv_thuchien'   => $req->dvpt[$key],
                    'dv_kiemtra'    => $req->nskt[$key],
                    'ngay_batdau'   => date("Y-m-d", strtotime($req->startDate[$key])),
                    'ngay_hoanthanh'    => date("Y-m-d", strtotime($req->endDate[$key])),
                    'nguoi_tao'             => Sentinel::getUser()->id,
                    'csdt_id'               => Sentinel::getUser()->csdt_id,
                    'kehoach_baocao_id'     => '',
                    'nhom_mc_sl_id'         => $value,
                    'trang_thai'            => 'todo',
                    'year'                  => $req->nam_lkhCopy,
                    'notes'              => $req->notes[$key] == null ? "" : $req->notes[$key],
                    'created_at'            => Carbon::now()->toDateTimeString(),
                    'updated_at'            => Carbon::now()->toDateTimeString(),
                ];
                DB::table("kehoach_cc_solieu")->insert($data);
            }
        }

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));

    }
    public function createPlan(Request $req){
        $data = [
            'dv_thuchien'   => $req->dvpt,
            'dv_kiemtra'    => $req->nskt,
            'ngay_batdau'   => date("Y-m-d", strtotime($req->startDate)),
            'ngay_hoanthanh'    => date("Y-m-d", strtotime($req->endDate)),
            'nguoi_tao'             => Sentinel::getUser()->id,
            'csdt_id'               => Sentinel::getUser()->csdt_id,
            'kehoach_baocao_id'     => '',
            'nhom_mc_sl_id'         => $req->linhvuc,
            'trang_thai'            => 'todo',
            'year'                  => date("Y", strtotime($req->startDate)),
            'notes'              => $req->notes == null ? "" : $req->notes,
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table("kehoach_cc_solieu")->insert($data);

        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }


    public function showPlan(Request $req){
        $plannings = DB::table('kehoach_cc_solieu AS ccsl')
                    ->leftjoin('nhom_mc_sl AS mcsl', 'mcsl.id', '=', 
                'ccsl.nhom_mc_sl_id')
                    ->select("ccsl.id AS id_ccsl", "ccsl.nhom_mc_sl_id", "ccsl.ngay_batdau", 
                        "ccsl.ngay_hoanthanh", "ccsl.dv_thuchien", "ccsl.dv_kiemtra", "mcsl.mo_ta","mcsl.id AS id_mcsl", "ccsl.notes")
                    ->where("ccsl.deleted_at"  ,null);

        if($req->year != "" && $req->mcsl == "" && $req->donvi == ""){
            $plannings = $plannings->whereYear('ccsl.year', $req->year);
        };
        if($req->year == "" && $req->mcsl != "" && $req->donvi == ""){
            $plannings = $plannings->where("nhom_mc_sl_id", $req->mcsl);
        };
        if($req->year == "" && $req->mcsl == "" && $req->donvi != ""){
            $plannings = $plannings->where("dv_thuchien", $req->donvi);
        };
        if($req->year != "" && $req->mcsl != "" && $req->donvi == ""){
            $plannings = $plannings->whereYear('ccsl.year', $req->year)
                        ->where("nhom_mc_sl_id", $req->mcsl);
        };
        if($req->year != "" && $req->mcsl == "" && $req->donvi != ""){
            $plannings = $plannings->whereYear('ccsl.year', $req->year)
                        ->where("dv_thuchien", $req->donvi);
        };
        if($req->year == "" && $req->mcsl != "" && $req->donvi != ""){
            $plannings = $plannings->where("nhom_mc_sl_id", $req->mcsl)
                        ->where("dv_thuchien", $req->donvi);
        };
        if($req->year != "" && $req->mcsl != "" && $req->donvi != ""){
            $plannings = $plannings->whereYear('ccsl.year', $req->year)
                        ->where("nhom_mc_sl_id", $req->mcsl)
                        ->where("dv_thuchien", $req->donvi);
        };
        return DataTables::of($plannings) 
            ->addColumn('actions',function($planning){
                    $actions ='<button class="btn updateBtn" data-toggle="modal" data-target="#modalUpdate" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.cnkh').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
                    $actions = $actions .'<button type="button" class="btn" data-toggle="modal" data-target="#modalDelete" data-id="'. $planning->id_ccsl .'">
                        '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                    </button>';
                    return $actions;
            })
            ->addColumn('ngayBatdau',function ($planning){
                    return date("d-m-Y", strtotime($planning->ngay_batdau)); 
            })
            ->addColumn('dvThucHien',function ($planning){
                    $dvThucHien = DB::table("donvi")->where("id", $planning->dv_thuchien)
                                ->select("ten_donvi");
                    if($dvThucHien->count() > 0)
                        return $dvThucHien->first()->ten_donvi;
                    else return "";
            })
            ->addColumn('nsKiemTra',function ($planning){
                    $nsKiemTra =  DB::table("users AS us")
                                ->where("us.id", $planning->dv_kiemtra)
                                ->select("us.name", "dv.ten_donvi")
                                ->leftjoin('donvi AS dv', 'dv.id', '=', 'us.donvi_id');
                    if($nsKiemTra->count() > 0)
                        return $nsKiemTra->first()->name . " - " . $nsKiemTra->first()->ten_donvi;
                    else
                        return "";
            })
            ->addColumn('ngayHoanthanh',function ($planning){
                    return date("d-m-Y", strtotime($planning->ngay_hoanthanh)); 
            })
            ->rawColumns(['actions', 'dvThucHien', 'nsKiemTra'])            
            ->make(true);
    }
    public function showNotPlan(Request $req){
        $mcslList = DB::table('kehoach_cc_solieu')->distinct('nhom_mc_sl_id')->get();
        $arr = [];
        foreach($mcslList as $mcsl){
            array_push($arr , $mcsl->nhom_mc_sl_id);
        }
        $notPlans = DB::table("nhom_mc_sl")->whereNotIn('id',$arr);
                
        return DataTables::of($notPlans) 
            ->addColumn('actions',function($notPlan){
                    $actions = '<button type="button" class="btn btn-block control" data-toggle="modal" data-target="#modalLkh" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.lkh').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>';
                    return $actions;
            })
            ->addColumn('note',function($notPlan){
                    return '<span class="badge badge-light font-italic">'. Lang::get('project/QualiAssurance/title.clkh') .'</span>';
            })
            ->rawColumns(['actions', 'note'])            
            ->make(true);
    }
    public function createCcsl(Request $req){
        $data = [
            'dv_thuchien'   => $req->dvpt,
            'dv_kiemtra'    => $req->nskt,
            'ngay_batdau'   => date("Y-m-d", strtotime($req->ngaybd)),
            'ngay_hoanthanh'    => date("Y-m-d", strtotime($req->nht)),
            'nguoi_tao'             => Sentinel::getUser()->id,
            'csdt_id'               => $this->getCsdt(),
            'kehoach_baocao_id'     => '',
            'year'                  => date("Y", strtotime($req->ngaybd)),
            'nhom_mc_sl_id'         => $req->id_mcsl,
            'trang_thai'            => 'todo',
            'notes'                 => $req->ghichu,
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table("kehoach_cc_solieu")->insert($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
        
    }
    public function updateCcsl(Request $req){
        $data = [
            'dv_thuchien'   => $req->up_dvpt,
            'dv_kiemtra'    => $req->up_nskt,
            'ngay_batdau'   => date("Y-m-d", strtotime($req->up_ngaybd)),
            'ngay_hoanthanh'    => date("Y-m-d", strtotime($req->up_nht)),
            'notes'                 => $req->up_ghichu,
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table("kehoach_cc_solieu")->where("id", $req->id_ccsl)->update($data);
        $respon = (object)array('result' => 'done');
        return json_encode($respon);
    }
    public function deleteCcsl(Request $req){
        // $deleteItem = DB::table("kehoach_cc_solieu")->where("id", $req->id_delete)
        //                 ->update([
        //                     'deleted_at' => Carbon::now()->toDateTimeString()
        //                 ]);
        $deleteItem = DB::table("kehoach_cc_solieu")->where("id", $req->id_delete)
                        ->delete();
        $respon = (object)array('result' => 'done');
        return json_encode($respon);
    }

    public function updatePlan(Request $req){
        return view('admin.project.QualiAssurance.updateplan');
    } 

    public function exportplaning(Request $req){
        return Excel::download(new PlanningExport(), 'planning.xlsx');
    }
    // public function update() {
    //     $old = DB::table("users_old")->get();
    //     foreach($old as $value){
    //         // $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         // $code = substr(str_shuffle($permitted_chars), 0, 20);
    //         // $path = public_path().'/uploads/users/' . $code;
    //         // File::makeDirectory( $path,0777,true);

    //         $data = [
    //             'id'    => $value->id,
    //             'ma_nhansu' => $value->ma_nhansu,
    //             'name'      => $value->name,
    //             'email'     => $value->email,
    //             'password'  => $value->password,
    //             'nguoi_tao' => 1,
    //             'created_at'        =>   Carbon::now()->toDateTimeString(),
    //             'updated_at'        =>   Carbon::now()->toDateTimeString(),
    //             'pic'               => '',
    //             'phone'         =>$value->phone,
    //             'description'   => $value->description,
    //             'address'       => $value->address,
    //             'donvi_id'         => $value->id_donvi, 
    //             'csdt_id'       => $value->id_csdt,
    //             'code'  => ""

    //         ];
    //         DB::table("users")->insert($data);
    //     }
    // }
}