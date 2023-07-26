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

         $kehbc = DB::table('kehoach_baocao')
                     ->where('id',$id_kehoach)
                     ->first();
         $btc = DB::table('bo_tieuchuan')
                  ->where('id',$kehbc->bo_tieuchuan_id)
                  ->first();
         if($btc->loai_tieuchuan == "ctdt"){
            $dulieu = '{"p27_caodang":"0","p27_tiensi":"0","p27_thacsi":"0","p27_daihoc":"0","p29_tongnganhdt":"0","p31_tongvcohuu":"0","p31_tylegvch":"0","p33_1_tuoitb":"0","p33_2_tdts":"0","p33_3_tdths":"0","p42_tsdetaiqd":"0","p42_tysodtqd":"0","p45_tsosach":"0","p45_tysosach":"0","p47_tsobaitapchi":"0","p47_tysobaitapchi":"0","p49_tsobaibc":"0","p49_tysobaibc":"0","p53_tongdtdcsgd":"0","p53_tongdtdvth":"0","p55_noilmv":"0","p55_noihoc":"0","p55_noigt":"0","p56_tdtphong":"0","p56_tysodtpcq":"0","p57_tsodstndt":"0","p57_tsodstptl":"0","p58_dchtvp":"0","p58_dcnht":"0","p58_tsomtdcnh":"0","viii_1_tsgvch":"0","viii_1_tlgvch":"0","viii_1_gvchts":"0","viii_1_gvchths":"0","viii_2_tsnhcq":"0","viii_2_tsngcqtgv":"0","viii_2_tlnhtn":"0","viii_3_tlngtldh":"0","viii_3_tlhmpkt":"0","viii_5_tlhdunc":"0","viii_5_nhcbdu":"0","viii_6_tldtnckh":"0","viii_6_tssddsb":"0","viii_6_tsbdtc":"0","viii_6_tsbdbc":"0","viii_7_tsmtdcnh":"0","viii_7_tsdtp":"0","viii_7_tsdtkt":"0","g42_2":"0","vii_7_tscokt":"0"}';
            $Url_ex = '{"p26":"0","p30":"0","p31":"0","p32":"0","p33":"0","p34":"0","p35":"0","p36":"0","p37":"0","p38":"0","p39":"0","p40":"0","p41":"0","p42":"0","p43":"0","p44":"0","p45":"0","p46":"0","p47":"0","p48":"0","p49":"0","p50":"0","p51":"0","p52_1":"0"}';
            $cosodulieu = DB::table('coso_dulieu')
                        ->insert([
                           'id_khbc' => $id_kehoach,
                           'dulieu'  => $dulieu,
                           'Url_ex'  => $Url_ex
                        ]);
            $js = '{"chinhquy":"co","khongchinhquy":"co","tuxa":"co","nuocngoai":"co","trongnuoc":"co"}';
            $baocaothem = DB::table('baocao_noidungthem')
                        ->insert([
                           'id_kehoach_bc' => $id_kehoach,
                           'id_csdt' => Sentinel::getUser()->csdt_id,
                           'noidung' => $js,

                        ]);
         }else{
            $dulieu = '{"g21_slnhcq": "0", "g28_tysdtnckh": "0", "g31_tyssddxb": "0", "g33_tysbdtc": "0", "g35_tysbbc": "0", "g42_1": "0", "g42_2": "0", "g42_3": "0", "g42_4": "0", "g42_5": "0", "g43_1": "0", "g43_2": "0", "g43_3": "0", "g43_4": "0", "g43_5": "0", "g44_1": "0", "g44_2": "0", "g44_3": "0", "g44_4": "0", "g44_5": "0", "g45_1": "0", "g45_2": "0", "g45_3": "0", "g45_4": "0", "g45_5": "0", "g46_1": "0", "g46_2": "0", "g46_3": "0", "g46_4": "0", "g46_5": "0", "g47_1": "0", "g47_2": "0", "g47_3": "0", "g47_4": "0", "g47_5": "0", "g48_1": "0", "g48_2": "0", "g48_3": "0", "g48_4": "0", "g48_5": "0", "vii_1_tsgvch": "0", "vii_1_tlgvch": "0", "vii_1_tlgvchts": "0", "vii_1_tlgvchths": "0", "vii_2_tssvcq": "0", "vii_2_tssvtgv": "0", "vii_2_tlsvtn": "0", "vii_3_tlsvtl": "0", "vii_3_tlsvknct": "0", "vii_4_tlsvdn": "0", "vii_4_tlsvtn": "0", "vii_4_tlttdvl": "0", "vii_4_tnbq": "0", "vii_5_tlsvduyc": "0", "vii_5_tlsvcb": "0", "vii_6_tlsdtnckh": "0", "vii_6_dtnckh": "0", "vii_6_tssxb": "0", "vii_6_tsbdtc": "0", "vii_6_tsbbc": "0", "vii_7_tsdts": "0", "vii_7_tscokt": "0"}';
            $Url_ex = '{"g12": "0", "g13": "0", "g14": "0", "g15": "0", "g16": "0", "g17": "0", "g18_1": "0", "g18_2": "0", "g19_1": "0", "g19_2": "0", "g20": "0", "g21": "0", "g22": "0", "g23": "0", "g24": "0", "g25": "0", "g26": "0", "g27": "0", "g28": "0", "g29": "0", "g30": "0", "g31": "0", "g32": "0", "g33": "0", "g34": "0", "g35": "0", "g36": "0", "g37": "0", "g38_1": "0", "g38_2": "0", "g39": "0", "g40": "0", "g41": "0", "gvi": "0"}';

            $cosodulieu = DB::table('coso_dulieu')
                        ->insert([
                           'id_khbc' => $id_kehoach,
                           'dulieu'  => $dulieu,
                           'Url_ex'  => $Url_ex
                        ]);
            $js = '{"chinhquy":"co","khongchinhquy":"co","tuxa":"co","nuocngoai":"co","trongnuoc":"co"}';
            $baocaothem = DB::table('baocao_noidungthem')
                        ->insert([
                           'id_kehoach_bc' => $id_kehoach,
                           'id_csdt' => Sentinel::getUser()->csdt_id,
                           'noidung' => $js,

                        ]);
         }
         
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
