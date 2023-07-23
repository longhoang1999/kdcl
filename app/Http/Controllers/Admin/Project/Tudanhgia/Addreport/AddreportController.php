<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Addreport;

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

class AddreportController extends DefinedController
{

    public function index(Request $req){
         $btc = DB::table("bo_tieuchuan")->select("id", "tieu_de", "loai_tieuchuan")->get();
         $user = DB::table("users")
            ->leftjoin("donvi", "users.donvi_id", "=", "donvi.id")
            ->select("users.id","users.name", "donvi.ten_donvi")->get();
         $ctdtList = DB::table("ctdt")->get();
         return view("admin.project.Selfassessment.addreport")->with([
               'btc'    => $btc,
               'user'   => $user,
               'ctdtList'  => $ctdtList
         ]);
    }

    public function insert(Request $req){
         $boTieuChuan = DB::table("bo_tieuchuan")->where("id", $req->bo_tieuchuan)->first();
         $data = [
               'ten_bc'    => $req->ten_bc,
               'bo_tieuchuan_id'    => $req->bo_tieuchuan,
               'nam'             => date("Y", strtotime($req->thoi_diem_bao_cao)),
               'thoi_diem_bao_cao'  => date("Y-m-d", strtotime($req->thoi_diem_bao_cao)),
               'ngay_batdau'        => date("Y-m-d", strtotime($req->ngay_batdau)),
               'ngay_hoanthanh'     => date("Y-m-d", strtotime($req->ngay_hoanthanh)),
               'ngay_batdau_chuanbi'    => date("Y-m-d", strtotime($req->ngay_batdau_chuanbi)),
               'ngay_hoanthanh_chuanbi' => date("Y-m-d", strtotime($req->ngay_hoanthanh_chuanbi)),
               'nguoi_tao'       => Sentinel::getUser()->id,
               'csdt_id'         => Sentinel::getUser()->csdt_id,
               'ns_phutrach'     => $req->ns_phutrach,
               'writeFollow'     => $req->writeFollow,
               'created_at'            => Carbon::now()->toDateTimeString(),
               'updated_at'            => Carbon::now()->toDateTimeString(),

         ];

         if($req->ns_phutrach != ""){
            if(DB::table("role_users")->where("user_id", $req->ns_phutrach)->where("role_id", 10)->count() == 0){
               $us = Sentinel::findById($req->ns_phutrach);
               $role_ = Sentinel::findRoleByName('ttchuyentrach');
               $role_->users()->attach($us);
            }
         }

         if ($boTieuChuan->loai_tieuchuan == 'ctdt' && $req->ctdt_id != "") {
             $data['ctdt_id'] = $req->ctdt_id;
         }

         $id_kehoach = DB::table("kehoach_baocao")->insertGetId($data);

         $cosodulieu = DB::table('coso_dulieu')
                        ->insert([
                           'id_khbc' => $id_kehoach,
                        ]);
         // thêm mới những cái bổ sung

         
         foreach($req->ns_chuanbi as $value){
            $dt = [
               'id_kehoach'   => $id_kehoach,
               'id_nhansuchuanbi'   =>   $value
            ];
            if(DB::table("role_users")->where("user_id", $value)->where("role_id", 6)->count() == 0){
               $us = Sentinel::findById($value);
               $role_ = Sentinel::findRoleByName('ns_phutrach');
               $role_->users()->attach($us);
            }
            DB::table("kehoach_baocao_nhansu")->insert($dt);
         }
         foreach($req->ns_thuchien as $value){
            $dt = [
               'id_kehoach'   => $id_kehoach,
               'id_nhansuthuchien'   =>   $value
            ];
            if(DB::table("role_users")->where("user_id", $value)->where("role_id", 5)->count() == 0){
               $us = Sentinel::findById($value);
               $role_ = Sentinel::findRoleByName('ns_thuchien');
               $role_->users()->attach($us);
            }
            DB::table("kehoach_baocao_nhansu")->insert($dt);
         }
         foreach($req->ns_kiemtra as $value){
            $dt = [
               'id_kehoach'   => $id_kehoach,
               'id_nhansukiemtra'   =>   $value
            ];
            if(DB::table("role_users")->where("user_id", $value)->where("role_id", 7)->count() == 0){
               $us = Sentinel::findById($value);
               $role_ = Sentinel::findRoleByName('ns_kiemtra');
               $role_->users()->attach($us);
            }
            DB::table("kehoach_baocao_nhansu")->insert($dt);
         }
      return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));


    }
    public function update(Request $req){
      // Xóa cũ
      $kehoach_old = DB::table("kehoach_baocao")->where("id", $req->id_baocao);
      $us1 = Sentinel::findById($kehoach_old->first()->ns_phutrach);
      $role_1 = Sentinel::findRoleByName('ttchuyentrach');
      $role_1->users()->detach($us1);

      DB::table("kehoach_baocao_nhansu")->where("id_kehoach", $req->id_baocao)->delete();
      $kehoach_old->delete();

      // Thêm mới
      $boTieuChuan = DB::table("bo_tieuchuan")->where("id", $req->bo_tieuchuan)->first();
      $data = [
            'ten_bc'    => $req->ten_bc,
            'bo_tieuchuan_id'    => $req->bo_tieuchuan,
            'nam'             => date("Y", strtotime($req->thoi_diem_bao_cao)),
            'thoi_diem_bao_cao'  => date("Y-m-d", strtotime($req->thoi_diem_bao_cao)),
            'ngay_batdau'        => date("Y-m-d", strtotime($req->ngay_batdau)),
            'ngay_hoanthanh'     => date("Y-m-d", strtotime($req->ngay_hoanthanh)),
            'ngay_batdau_chuanbi'    => date("Y-m-d", strtotime($req->ngay_batdau_chuanbi)),
            'ngay_hoanthanh_chuanbi' => date("Y-m-d", strtotime($req->ngay_hoanthanh_chuanbi)),
            'nguoi_tao'       => Sentinel::getUser()->id,
            'csdt_id'         => Sentinel::getUser()->csdt_id,
            'ns_phutrach'     => $req->ns_phutrach,
            'writeFollow'     => $req->writeFollow,
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),

      ];
      if($req->ns_phutrach != ""){
         if(DB::table("role_users")->where("user_id", $req->ns_phutrach)->where("role_id", 10)->count() == 0){
            $us = Sentinel::findById($req->ns_phutrach);
            $role_ = Sentinel::findRoleByName('ttchuyentrach');
            $role_->users()->attach($us);
         }
      }

      if ($boTieuChuan->loai_tieuchuan == 'ctdt' && $req->ctdt_id != "") {
          $data['ctdt_id'] = $req->ctdt_id;
      }

      $id_kehoach = DB::table("kehoach_baocao")->insertGetId($data);

      // thêm mới những cái bổ sung

      
      foreach($req->ns_chuanbi as $value){
         $dt = [
            'id_kehoach'   => $id_kehoach,
            'id_nhansuchuanbi'   =>   $value
         ];
         if(DB::table("role_users")->where("user_id", $value)->where("role_id", 6)->count() == 0){
            $us = Sentinel::findById($value);
            $role_ = Sentinel::findRoleByName('ns_phutrach');
            $role_->users()->attach($us);
         }
         DB::table("kehoach_baocao_nhansu")->insert($dt);
      }
      foreach($req->ns_thuchien as $value){
         $dt = [
            'id_kehoach'   => $id_kehoach,
            'id_nhansuthuchien'   =>   $value
         ];
         if(DB::table("role_users")->where("user_id", $value)->where("role_id", 5)->count() == 0){
            $us = Sentinel::findById($value);
            $role_ = Sentinel::findRoleByName('ns_thuchien');
            $role_->users()->attach($us);
         }
         DB::table("kehoach_baocao_nhansu")->insert($dt);
      }
      foreach($req->ns_kiemtra as $value){
         $dt = [
            'id_kehoach'   => $id_kehoach,
            'id_nhansukiemtra'   =>   $value
         ];
         if(DB::table("role_users")->where("user_id", $value)->where("role_id", 7)->count() == 0){
            $us = Sentinel::findById($value);
            $role_ = Sentinel::findRoleByName('ns_kiemtra');
            $role_->users()->attach($us);
         }
         DB::table("kehoach_baocao_nhansu")->insert($dt);
      }
      return back()->with('success', 
                  Lang::get('project/Standard/message.success.create'));
    }


    public function searchLtc(Request $req){
      $btc = DB::table("bo_tieuchuan")->where("id", $req->id_btc)->select("loai_tieuchuan")->first();
      $ctdt = DB::table("ctdt")->get();

      return json_encode(
         [$btc, $ctdt]
      );
    }
}
