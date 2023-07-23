<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Database;

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


class databaseController extends DefinedController
{
     public function dulieutest(Request $req){
          // $arr = [
          //      "ck" => 0,
          //      "sk" => 0
          // ];
          // $arr = json_encode($arr);

          // DB::table('dulieutest')
          //      ->insert([
          //           "daitest" => $arr,
          //      ]);


          $data = DB::table('dulieutest'); 
          $datas = json_decode($data->first()->daitest);

          $datas->{$req->key} = $req->val;

          $da = json_encode($datas);
          $data->update([
               "daitest" => $da,
          ]);
     }

     public function index(){
          return view('admin.project.Database.index');
     }

     public function data(){
          $keHoachBaoCaoList = DB::table('kehoach_baocao')
                                             ->select('kehoach_baocao.id as id_khbc','kehoach_baocao.*','users.*')
                                             ->leftjoin('users','users.id','=','kehoach_baocao.ns_phutrach')
                                             ->where('kehoach_baocao.deleted_at',null)
                                             ->get();
               if(!Sentinel::inRole('operator') && !Sentinel::inRole('admin')){
                    foreach($keHoachBaoCaoList as $key => $value){
                         $find = DB::table("role_user_dgn")
                                   ->where("user_id", Sentinel::getUser()->id)
                                   ->where("baocao_tdg_id", $value->id_khbc);
                         if($find->count() == 0){
                              $keHoachBaoCaoList->forget($key);
                         }
                    }
               }

               return DataTables::of($keHoachBaoCaoList)
                              ->addColumn(
                                   'ten_donvi',
                                   function($keHoachBaoCaoList){
                                        $ten_dv = DB::table('donvi')->where('id',$keHoachBaoCaoList->donvi_id)->first();
                                        if($ten_dv){
                                             return $ten_dv->ten_donvi;
                                        }else{
                                             return '';
                                        }
                                   }
                              )
                              ->addColumn(
                                   'ten_baocao',
                                   function($keHoachBaoCaoList){
                                        if($keHoachBaoCaoList->ten_bc){
                                             return $keHoachBaoCaoList->ten_bc;
                                        }else{
                                             return '';
                                        }
                                   }
                              )
                              ->addColumn(
                                   'nam_vietbao',
                                   function($keHoachBaoCaoList){
                                        if($keHoachBaoCaoList->ngay_batdau){
                                             return date("Y", strtotime($keHoachBaoCaoList->ngay_batdau)); 
                                        }else{
                                             return '';
                                        }
                                   }
                              )
                              ->addColumn(
                                   'thoidiem_bc',
                                   function($keHoachBaoCaoList){
                                        if($keHoachBaoCaoList->thoi_diem_bao_cao){
                                             return date("d/m/Y", strtotime($keHoachBaoCaoList->thoi_diem_bao_cao)); 
                                        }else{
                                             return '';
                                        }
                                   }
                              )
                              ->addColumn('actions',function($keHoachBaoCaoList){
                                   $botieuchuan = DB::table('bo_tieuchuan')
                                                       ->where('id',$keHoachBaoCaoList->bo_tieuchuan_id)
                                                       ->first();

                                   if($botieuchuan->loai_tieuchuan == "ctdt"){
                                        $actions = '<a href="'.route("admin.tudanhgia.database.data_school",$keHoachBaoCaoList->id_khbc).'" class="btn" data-bs-placement="top" title="'.Lang::get('project/ExternalReview/title.xct').'"> '.'<i class="fas fa-edit" style="font-size: 25px;color: #50cd89;"></i>'
                                                   .'</a>';
                                   }else{
                                        $actions = '<a href="'.route("admin.tudanhgia.database.data_school_csgd",$keHoachBaoCaoList->id_khbc).'" class="btn" data-bs-placement="top" title="'.Lang::get('project/ExternalReview/title.xct').'"> '.'<i class="fas fa-edit" style="font-size: 25px;color: #50cd89;"></i>'
                                                   .'</a>';
                                   }
                              
                                  return $actions;
                          })
                         ->rawColumns(['actions'])
                         ->make(true);
     }
     

     public function data_school(Request $req){
          $id = $req->id;
          $data = DB::table('coso_dulieu')
                    ->where('id_khbc',$req->id)
                    ->first();
          $dulieu = json_decode($data->dulieu);
          list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex($id);
          list($noiDungThem) = $this->getDataPhuLuc($keHoachBaoCaoDetail2);
          // dd($keHoachBaoCaoDetail2);die;
          return view('admin.project.Database.display_data')
                    ->with([
                         "dulieu"  => $dulieu,
                         "keHoachBaoCaoDetail2"  => $keHoachBaoCaoDetail2,
                         'noiDungThem' => $noiDungThem,
                    ]);
     }

     public function data_school_csgd(){

          return view('admin.project.Database.data_school_csgd');
     }


     public function baseIndex($id = null){
               $keHoachBaoCaoDetail2 = null;

               $keHoachBaoCaoList2 = DB::table('kehoach_baocao')->get();

               // if ($id) {
             //     $keHoachBaoCaoDetail = DB::table('kehoach_baocao')->find(3);
             // }
          if($id){
               $keHoachBaoCaoDetail2 = DB::table('kehoach_baocao')
                                   ->select('kehoach_baocao.*','bo_tieuchuan.loai_tieuchuan as loai_tieuchuan_bc')
                                   ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                                   ->where('kehoach_baocao.id',$id)->first();

               if ($keHoachBaoCaoDetail2) {
                    $danhGiaMenhDe = [];
                    $keHoachBaoCaoDetail2->keHoachTieuChuanList = $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')->where('id_kh_baocao',$keHoachBaoCaoDetail2->id)->get();
                    $keHoachBaoCaoDetail2->phutrach = DB::table('users')
                                                                 // ->select('excel_import_donvi.*','excel_import_donvi.ma_donvi as id_donvi')
                                                                 // ->leftjoin('excel_import_donvi','excel_import_donvi.id','=','users.donvi_id')
                                                                 ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                 ->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();

                    $keHoachBaoCaoDetail2->phutrachr = DB::table('users')
                                                                 ->select('donvi.*','donvi.ma_donvi as id_donvi')
                                                                 ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                 ->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();
     
                              
                    $keHoachBaoCaoDetail2->ctdt = DB::table('ctdt')
                                                                 ->where('id',$keHoachBaoCaoDetail2->ctdt_id)->first();
                    $keHoachBaoCaoDetail2->keHoachChung = DB::table('kehoach_chung')
                                                                      ->where('kh_baocao_id',$keHoachBaoCaoDetail2->id)
                                                                      ->first();

                    $keHoachBaoCaoDetail2->keHoachChung->baoCaoChung = DB::table('baocao_chung')
                                                                                     ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                                                                                     ->where('id_kh_chung',$keHoachBaoCaoDetail2->keHoachChung->id)
                                                                                     ->first();

                    foreach($keHoachTieuChuanList as $keHoachTieuChuan){
                         $tieuChuan = DB::table('tieuchuan')->where('id',$keHoachTieuChuan->tieuchuan_id)->first();
                         $keHoachTieuChuan->tieuChuan = $tieuChuan;
                         $keHoachTieuChuan->baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                                                           ->where('id_kehoach_bc',$id)
                                                                           ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                                                           ->where('id_tieuchuan',$keHoachTieuChuan->tieuchuan_id)
                                                                           ->first();
                         
                         if($tieuChuan){
                              $keHoachTieuChuan->moTaWithStt = "TC $tieuChuan->stt: $tieuChuan->mo_ta";
                              $keHoachTieuChuan->keHoachTieuChiList = $keHoachTieuChiList = DB::table('kehoach_tieuchi')->where('id_kh_tieuchuan',$keHoachTieuChuan->id)->get();
                              foreach($keHoachTieuChiList as $keHoachTieuChi){
                                   $tieuChi = DB::table('tieuchi')->where('id',$keHoachTieuChi->id_tieuchi)->first();
                                   if($keHoachBaoCaoDetail2->writeFollow == 1){
                                        $keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('menhde')
                                                                                          ->where('tieuchi_id',$tieuChi->id)
                                                                                          ->get();
                                        $keHoachTieuChi->tieuChi = $tieuChi;
                                        foreach($menhde as $value){
                                             
                                             $value->khmenhde = DB::table('kehoach_menhde')
                                                                      ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                                      ->where('id_menhde',$value->id)
                                                                      ->first();

                                             $baoCaoMenhDe = DB::table('baocao_menhde')
                                                                      ->where('id_kehoach_bc',$id)
                                                                      ->where('id_kh_menhde',$value->khmenhde->id)
                                                                      ->where('id_menhde',$value->khmenhde->id_menhde)
                                                                      ->first();
                                             
                                             $value->baoCaoMenhDe = $baoCaoMenhDe;

                                             $baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
                                                                                               ->where('menhde_id',$value->khmenhde->id_menhde)
                                                                                               ->where('kehoach_bc_id',$id)
                                                                                               ->whereNull('deleted_at')
                                                                                               ->get();

                                             foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
                                                  $val->donViThucHien = DB::table('donvi')
                                                                                ->where('id',$val->ns_thuchien)
                                                                                ->first();
                                                  $val->donViKiemTra = DB::table('donvi')
                                                                                ->where('id',$val->ns_kiemtra)
                                                                                ->first();
                                             }
                                                  
                                             
                                             
                                             $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                                        }
                                        
                                        

                                        $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                                        $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                                        $keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
                                   }elseif($keHoachBaoCaoDetail2->writeFollow == 2){
                                        $keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('mocchuan')
                                                                                          ->where('tieuchi_id',$tieuChi->id)
                                                                                          ->get();
                                        $keHoachTieuChi->tieuChi = $tieuChi;
                                        foreach($menhde as $value){
                                             
                                             $value->khmenhde = DB::table('kehoach_menhde')
                                                                      ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                                      ->where('mocchuan_id',$value->id)
                                                                      ->first();

                                             $baoCaoMenhDe = DB::table('baocao_menhde')
                                                                      ->where('id_kehoach_bc',$id)
                                                                      ->where('id_kh_menhde',$value->khmenhde->id)
                                                                      ->where('mocchuan_id',$value->khmenhde->mocchuan_id)
                                                                      ->first();
                                             
                                             $value->baoCaoMenhDe = $baoCaoMenhDe;

                                             $baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
                                                                                               ->where('mocchuan_id',$value->khmenhde->mocchuan_id)
                                                                                               ->where('kehoach_bc_id',$id)
                                                                                               ->whereNull('deleted_at')
                                                                                               ->get();
                                             var_dump($value->khmenhde->mocchuan_id);die;

                                             foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
                                                  $val->donViThucHien = DB::table('donvi')
                                                                                ->where('id',$val->ns_thuchien)
                                                                                ->first();
                                                  $val->donViKiemTra = DB::table('donvi')
                                                                                ->where('id',$val->ns_kiemtra)
                                                                                ->first();
                                             }
                                                  
                                             
                                             
                                             $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                                        }
                                        
                                        

                                        $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                                        $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                                        $keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
                                   }
                                   

                                   if($tieuChi){
                                        $keHoachTieuChi->moTaWithStt = "$tieuChuan->stt.$tieuChi->stt: $tieuChi->mo_ta";
                                   }
                                   
                              }
                         }
                         
                         
                    }
                  }
          }
               
             return array($keHoachBaoCaoList2,$keHoachBaoCaoDetail2);
          }


          public function getDataPhuLuc($keHoachBaoCaoDetail2){
               
               $noiDungThem = DB::table('baocao_noidungthem')
                                        ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                                        ->get();

                                                          
               return array($noiDungThem);
          }

          public function save_data(Request $req){
               // $arr = [
               //      "ck" => 0,
               //      "sk" => 0
               // ];
               // $arr = json_encode($arr);

               // DB::table('dulieutest')
               //      ->insert([
               //           "daitest" => $arr,
               //      ]);


               $data = DB::table('coso_dulieu'); 
               $datas = json_decode($data->first()->dulieu);

               $datas->{$req->key} = $req->val;

               $save = json_encode($datas);
               $data->update([
                    "dulieu" => $save,
               ]);

               return 1;
          }
}