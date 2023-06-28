<?php namespace App\Http\Controllers\Admin\Project\Tonghop\Dambaocl;

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
class ToghopControntroller extends DefinedController
{
     public function index(Request $req){                        
          return view('admin.project.Synthetic.dambaocl');
     }
    
     public function datadbcl(Request $req){
          $nhommcsl = DB::table('nhom_mc_sl')
                         ->select('nhom_mc_sl.mo_ta','nhom_mc_sl.id','kehoach_cc_solieu.dv_thuchien','kehoach_cc_solieu.year')
                         ->leftjoin('kehoach_cc_solieu','nhom_mc_sl.id','kehoach_cc_solieu.nhom_mc_sl_id');

          return DataTables::of($nhommcsl)
                    ->addColumn('donvipt',function($dt){
                         $donvi = DB::table('donvi')
                                      ->where('id',$dt->dv_thuchien)
                                      ->first();
                         if($donvi){
                              return $donvi->ten_donvi;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->addColumn('allhd',function($dt){
                         $hoatdongnhom = DB::table('hoatdongnhom')
                                             ->where('year',$dt->year)
                                             ->where('parent',0)
                                             ->count();
                         if($hoatdongnhom){
                              return $hoatdongnhom;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->addColumn('allmcyc',function($dt){
                         $hoatdongnhom = DB::table('hoatdongnhom')
                                             ->where('year',$dt->year)
                                             ->where('parent','>',0)
                                             ->count();
                         if($hoatdongnhom){
                              return $hoatdongnhom;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->addColumn('allmcdpc',function($dt){
                         if($dt->dv_thuchien){
                              $hoatdongnhom = DB::table('hoatdongnhom')
                                             ->where('year',$dt->year)
                                             ->where('parent','>',0)
                                             ->count();
                         }else{
                              $hoatdongnhom = 0;
                         }
                         
                         return $hoatdongnhom;
                    })
                    ->addColumn('allmcdcn',function($dt){
                         $totalMinhChung = 0;
                         $hoatDongNhomList = DB::table('hoatdongnhom')
                            ->where('year', $dt->year)
                            ->where('parent', '>', 0)
                            ->get();

                         foreach ($hoatDongNhomList as $hoatDongNhom) {
                            $minhChung = DB::table('minhchung')
                                             ->where('hoatdongnhom_id',$hoatDongNhom->id)
                                             ->count();
                            $totalMinhChung += $minhChung;
                         }
                         return $totalMinhChung;
                    })
                    ->addColumn('allmcdxn',function($dt){
                         $hoatdongnhom = 0;
                              return $hoatdongnhom;
                    })
                    ->addColumn('allmcccn', function ($dt) {
                        $minhChung = DB::table('minhchung')
                            ->where('nhom_mc_sl_id', $dt->id)
                            ->first();

                        if ($minhChung != null) {
                            $data = '<a href="">0</a>';
                        } else {
                            $sl = DB::table('hoatdongnhom')
                                ->where('year', $dt->year)
                                ->where('parent', '>', 0)
                                ->count();
                            $data = '<a href="' . route('admin.tonghop.dbcl.minhchungyc', ['id_nhom_mc_sl' => $dt->id, 'year' => $dt->year, 'trang_thai' => 'chuacapnhat']) . '" class="badge badge-warning" data-toggle="tooltip" title="Xem chi tiết">' . $sl . '</a>';
                        }

                        return $data;
                    })

                    ->rawColumns(['allmcccn'])
                    ->make(true);
     }

     public function baocaotiendo(Request $req){

          return view('admin.project.Synthetic.bctd');
     }

     public function data(Request $req){
          $user_id = Sentinel::getUser()->id;
          $keHoachBaoCaoList = DB::table('kehoach_baocao')
          ->orderBy('created_at','desc')->get();; 
          if(isset($req->id) && $req->id > 0){
               $bc = $keHoachBaoCaoList->where('id',$req->id)->first();
               $kehoachung = DB::table('kehoach_chung')->select('kehoach_chung.id')
                                   ->where('kehoach_chung.kh_baocao_id','=',$bc->id)->first();
               $arrout = array();
               if($bc){
                    $arrout['solieutonghop'] = '<a class="synthetic" href="'.route('admin.danhgiangoai.baocaotudanhgia.baoCaoKhac',[$req->id]).'"><i class="fas fa-tasks"></i><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.slth') . '</span>';
                    $arrout['cosodulieu'] = '<a class="data" href="'.route('admin.danhgiangoai.baocaotudanhgia.index',['id'=>$req->id,'tag'=>'pl1','page'=>'phuluc']).'"><i class="fas fa-edit"></i><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.csdl') . '</span>';
                    $arrout['phan1'] = '<a class="a_css" href="' . route('admin.tudanhgia.detailedplanning.general',[$req->id,$kehoachung->id]).'"><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan1') . '</span></a>';
                    $arrout['phan3'] = '<a class="a_bottom" href="'.route('admin.tudanhgia.detailedplanning.conclusion',[$req->id,$kehoachung->id]).'"><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan3') . '</span></a>';
                    $arrout['kehoachchung'] = $kehoachung;

                    $tieuchuan = DB::table('kehoach_tieuchuan')
                              ->select('kehoach_tieuchuan.*','tieuchuan.mo_ta','tieuchuan.stt as stt_tc')
                              ->leftjoin('tieuchuan','tieuchuan.id','=','kehoach_tieuchuan.tieuchuan_id')
                              ->where('kehoach_tieuchuan.id_kh_baocao',$req->id)
                              ->orderBy('stt_tc','ASC')->get();
                    foreach ($tieuchuan as $key => $value) {
                         $tieuchi = DB::table('tieuchi')->where('tieuchuan_id',$value->tieuchuan_id)->get();
                         $tieuchi_id = DB::table('tieuchi')->where('tieuchuan_id',$value->tieuchuan_id)->first();
                         $value->tieuchi = $tieuchi; 
                         $value->kehoachtieuchi = DB::table('kehoach_tieuchi')
                                                       ->where('id_kh_tieuchuan',$value->id)
                                                       ->where('id_tieuchi',$tieuchi_id->id)
                                                       ->get();
                         $tieuChuanTiendo = [];
                         foreach($value->kehoachtieuchi as $pttc){
                              $pttc->tiendo = 0;
                              $tieuChiTienDo = [];
                              $menhde = DB::table('menhde')
                                             ->where('tieuchi_id',$pttc->id_tieuchi)
                                             ->first();
                              $mocchuan = DB::table('mocchuan')
                                             ->where('tieuchi_id',$pttc->id_tieuchi)
                                             ->first();
                              if($bc->writeFollow == 1){
                                   $pttc->kehoachmenhde = DB::table('kehoach_menhde')
                                                  ->where('id_kh_tieuchi',$pttc->id)
                                                  ->where('id_menhde',$menhde->id)
                                                  ->get();
                                   $tieuChiTienDo = [];
                                   foreach($pttc->kehoachmenhde as $khmd){
                                        $khmd->tiendo = 0;
                                        $baocaomenhde = DB::table('baocao_menhde')
                                                       ->where('id_kehoach_bc',$bc->id)
                                                       ->where('id_kh_menhde',$khmd->id)
                                                       ->where('id_menhde',$khmd->id_menhde)
                                                       ->first();
                                        if(!$baocaomenhde){
                                             $khmd->tiendo = 0;
                                        }else{
                                             if(strlen($baocaomenhde->mota) > 1){
                                                  $khmd->tiendo++;
                                             }
                                             if(strlen($baocaomenhde->diemmanh) > 1){
                                                  $khmd->tiendo++;
                                             }
                                             if(strlen($baocaomenhde->tontai) > 1){
                                                  $khmd->tiendo++;
                                             }

                                             if($baocaomenhde->trang_thai == "dangsua"){
                                                  $khmd->tiendo = round($khmd->tiendo / 4, 2) * 100;
                                             }else{
                                                  $khmd->tiendo = 100;
                                             }
                                        }

                                        $tieuChiTienDo[] = $khmd->tiendo;
                                   }
                                   

                              }else if($bc->writeFollow == 2){
                                   $pttc->kehoachmenhde = DB::table('kehoach_menhde')
                                                  ->where('id_kh_tieuchi',$pttc->id)
                                                  ->where('mocchuan_id',$mocchuan->id)
                                                  ->get();
                                   $tieuChiTienDo = [];

                                   foreach($pttc->kehoachmenhde as $khmd){
                                        $khmd->tiendo = 0;
                                        $baocaomenhde = DB::table('baocao_menhde')
                                                       ->where('id_kehoach_bc',$bc->id)
                                                       ->where('id_kh_menhde',$khmd->id)
                                                       ->where('mocchuan_id',$khmd->mocchuan_id)
                                                       ->first();
                                        if(!$baocaomenhde){
                                             $khmd->tiendo = 0;
                                        }else{
                                             if(strlen($baocaomenhde->mota) > 1){
                                                  $khmd->tiendo++;
                                             }
                                             if(strlen($baocaomenhde->diemmanh) > 1){
                                                  $khmd->tiendo++;
                                             }
                                             if(strlen($baocaomenhde->tontai) > 1){
                                                  $khmd->tiendo++;
                                             }

                                             if($baocaomenhde->trang_thai == "dangsua"){
                                                  $khmd->tiendo = round($khmd->tiendo / 4, 2) * 100;
                                             }else{
                                                  $khmd->tiendo = 100;
                                             }
                                        }

                                        $tieuChiTienDo[] = $khmd->tiendo;
                                   }
                              }

                              $pttc->tiendo = round(collect($tieuChiTienDo)->avg(),2);
                              $tieuChuanTiendo[] = $pttc->tiendo;
                              
                         }
                         $value->tiendo = round(collect($tieuChuanTiendo)->avg(),2);
                         $value->link = "https://www.google.com.vn";    
                         $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                              ->select('baocao_tieuchuan.trang_thai as trang_thai_bctc')
                                              // ->where('id_kh_tieuchuan',$value->id)
                                              ->where('id_kehoach_bc',$req->id)
                                              ->where('id_tieuchuan',$value->tieuchuan_id)
                                              ->first();
                         $value->baoCaoTieuChuan = $baoCaoTieuChuan;                     
                    }


                    $arrout['phan2'] = '<a class="a_mid" href="https://www.google.com.vn"><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan2') . '</span></a>';
                    $arrout['tieuchuan_tieuchi'] = $tieuchuan;
                    return (array) $arrout;
               }else{
                    return 0;
               }
          }else{         
               return DataTables::of($keHoachBaoCaoList)
                    ->addColumn('actions',function($bc){
                        return '<input type="radio" name="selectbc" id="selectbc_' . $bc->id . '" class="form-control">';
                    })               
                    ->rawColumns(['actions'])
                    ->make(true);
          }
     }

     public function minhchungyc(Request $req){
          $id_nhom_mc_sl = 0;
          if($req->id_nhom_mc_sl != ''){
                $id_nhom_mc_sl = $req->id_nhom_mc_sl;
          }
          return view('admin.project.Synthetic.minhchungyc')
                         ->with([
                              "id_nhom_mc_sl" => $id_nhom_mc_sl,
                         ]);
     }

     public function datamcyc(Request $req){
          
          $hoatdongnhom = DB::table('hoatdongnhom')
                              ->orderBy('noi_dung','asc');
          if ($req->id_nhom_mc_sl != 0) {
                 $hoatdongnhom->where('nhom_mc_sl_id',$req->id_nhom_mc_sl);
             }
          
          return DataTables::of($hoatdongnhom)
                    ->addColumn("key", function ($dt) {
                         static $count = 1;
                         return $count++;
                    })
                    ->addColumn('tendonvi',function($dt){
                         $donvi = DB::table('donvi')
                                   ->where('id',$dt->dv_thuchien)
                                   ->first();
                         if($donvi){
                              return $donvi->ten_donvi;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->addColumn("ngay",function($dt){
                         if($dt->ngay_batdau  && $dt->ngay_hoanthanh){
                              return $dt->ngay_batdau .' <i class="fas fa-arrow-right"></i> '. $dt->ngay_hoanthanh;
                         }else{
                              return "Không có dữ liệu";
                         }
                         
                    })

                    ->addColumn("thoigiancl", function ($dt) {
                         $conLai = Carbon::parse($dt->ngay_hoanthanh)->diffInDays(Carbon::now());
                        return (Carbon::parse($dt->ngay_hoanthanh)->lt(Carbon::now())) ? "<i class='text-danger'>Quá hạn</i>" : "$conLai ngày";
                    })
                    ->addColumn("trangthai", function ($dt) {
                        $minhChung = DB::table('minhchung')
                            ->where('hoatdongnhom_id', $dt->id)
                            ->count();
                        if ($minhChung > 0) {
                            return '<span class="badge badge-success">Đã cập nhật</span>';
                        } else {
                            return '<span class="badge badge-warning">Chưa cập nhật</span>';
                        }
                    })

                    ->rawColumns(['ngay','thoigiancl','trangthai'])
                    ->make(true);
     }
}