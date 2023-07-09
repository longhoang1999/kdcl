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
                              ->select('kehoach_tieuchuan.*','tieuchuan.mo_ta','tieuchuan.stt as stt_tc','tieuchuan.id as id_tc')
                              ->leftjoin('tieuchuan','tieuchuan.id','=','kehoach_tieuchuan.tieuchuan_id')
                              ->where('kehoach_tieuchuan.id_kh_baocao',$req->id)
                              ->orderBy('stt_tc','ASC')->get();
                    foreach ($tieuchuan as $key => $value) {
                         $baocaotc = DB::table('baocao_tieuchuan')
                                        ->select('users.name','baocao_tieuchuan.updated_at')
                                        ->where('baocao_tieuchuan.id_tieuchuan',$value->id_tc)
                                        ->where('baocao_tieuchuan.id_kh_tieuchuan',$value->id)
                                        ->where('id_kehoach_bc',$req->id)
                                        ->leftjoin('users','users.id','baocao_tieuchuan.nguoi_viet')
                                        ->first();
                         $value->nguoiviet = $baocaotc->name;
                         $value->ngayhoanthanh = $this->toShowDate($baocaotc->updated_at);
                         $tieuchi = DB::table('tieuchi')->where('tieuchuan_id',$value->tieuchuan_id)->get();
                         $tieuchi_id = DB::table('tieuchi')->where('tieuchuan_id',$value->tieuchuan_id)->first();
                         $value->tieuchi = $tieuchi; 
                         
                         $tieuChuanTiendo = [];
 
                              if($bc->writeFollow == 1){
                                   foreach($value->tieuchi as $pttc){
                                        $pttc->kehoachtieuchi = DB::table('kehoach_tieuchi')
                                                                 ->where('id_kh_tieuchuan',$value->id)
                                                                 ->where('id_tieuchi',$pttc->id)
                                                                 ->get();
                                        $pttc->tiendo = 0;
                                        $tieuChiTienDo = [];
                                        foreach($pttc->kehoachtieuchi as $valmd){
                                             $valmd->tiendo = 0;
                                             $valmd->kehoachmenhde = DB::table('kehoach_menhde')
                                                       ->where('kehoach_menhde.id_kh_tieuchi',$valmd->id)
                                                       ->get();

                                             $tieuChiTienDo = [];
                                        
                                             foreach ($valmd->kehoachmenhde as $khmd) {
                                                 $khmd->tiendo = 0;
                                                 $khmd->baocaomenhde = DB::table('baocao_menhde')
                                                     ->select('menhde.stt', 'menhde.mo_ta', 'users.name', 'baocao_menhde.trang_thai', 'baocao_menhde.mota', 'baocao_menhde.diemmanh', 'baocao_menhde.tontai', 'baocao_menhde.updated_at', 'baocao_menhde.danhgia')
                                                     ->leftJoin('menhde', 'menhde.id', '=', 'baocao_menhde.id_menhde')
                                                     ->leftJoin('users', 'users.id', '=', 'baocao_menhde.nguoi_viet')
                                                     ->where('baocao_menhde.id_kehoach_bc', $bc->id)
                                                     ->where('baocao_menhde.id_kh_menhde', $khmd->id)
                                                     // ->where('baocao_menhde.id_menhde', $khmd->menhde_id)
                                                     ->first();
                                                 $khmd->ngayht = $this->toShowDate($khmd->baocaomenhde->updated_at);
                                                 if (!$khmd->baocaomenhde) {
                                                     $khmd->tiendo = 0;
                                                 } else {
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->mota) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->diemmanh) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->tontai) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && $khmd->baocaomenhde->danhgia) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && $khmd->baocaomenhde->trang_thai == "dangsua") {
                                                         $khmd->tiendo = round($khmd->tiendo / 4, 2) * 100;
                                                     } else {
                                                         $khmd->tiendo = 100;
                                                     }
                                                 }
                                                 
                                               
                                                 array_push($tieuChiTienDo, $khmd->tiendo);
                                                
                                             }
                                           
                                             $pttc->tiendo = round(collect($tieuChiTienDo)->avg(), 2);
                                             $tieuChuanTiendo[] = $pttc->tiendo;

                                        
                                                  
                                        }
                                   }
                                      

                              }else if($bc->writeFollow == 2){
                                   foreach($value->tieuchi as $pttc){
                                        $pttc->kehoachtieuchi = DB::table('kehoach_tieuchi')
                                                                 ->where('id_kh_tieuchuan',$value->id)
                                                                 ->where('id_tieuchi',$pttc->id)
                                                                 ->get();
                                        $pttc->tiendo = 0;
                                        $tieuChiTienDo = [];
                                        foreach($pttc->kehoachtieuchi as $valmd){
                                             $valmd->tiendo = 0;
                                             $valmd->kehoachmenhde = DB::table('kehoach_menhde')
                                                       ->where('kehoach_menhde.id_kh_tieuchi',$valmd->id)
                                                       ->get();

                                             $tieuChiTienDo = [];
                                        
                                             foreach ($valmd->kehoachmenhde as $khmd) {
                                                 $khmd->tiendo = 0;
                                                 $khmd->baocaomenhde = DB::table('baocao_menhde')
                                                     ->select('mocchuan.stt', 'mocchuan.mo_ta', 'users.name', 'baocao_menhde.trang_thai', 'baocao_menhde.mota', 'baocao_menhde.diemmanh', 'baocao_menhde.tontai', 'baocao_menhde.updated_at', 'baocao_menhde.danhgia')
                                                     ->leftJoin('mocchuan', 'mocchuan.id', '=', 'baocao_menhde.mocchuan_id')
                                                     ->leftJoin('users', 'users.id', '=', 'baocao_menhde.nguoi_viet')
                                                     ->where('baocao_menhde.id_kehoach_bc', $bc->id)
                                                     ->where('baocao_menhde.id_kh_menhde', $khmd->id)
                                                     // ->where('baocao_menhde.id_menhde', $khmd->menhde_id)
                                                     ->first();
                                                 $khmd->ngayht = $this->toShowDate($khmd->baocaomenhde->updated_at);
                                                 if (!$khmd->baocaomenhde) {
                                                     $khmd->tiendo = 0;
                                                 } else {
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->mota) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->diemmanh) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && strlen($khmd->baocaomenhde->tontai) > 1) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && $khmd->baocaomenhde->danhgia) {
                                                         $khmd->tiendo++;
                                                     }
                                                     if ($khmd->baocaomenhde && $khmd->baocaomenhde->trang_thai == "dangsua") {
                                                         $khmd->tiendo = round($khmd->tiendo / 4, 2) * 100;
                                                     } else {
                                                         $khmd->tiendo = 100;
                                                     }
                                                 }
                                                 
                                               
                                                 array_push($tieuChiTienDo, $khmd->tiendo);
                                                
                                             }
                                           
                                             $pttc->tiendo = round(collect($tieuChiTienDo)->avg(), 2);
                                             $tieuChuanTiendo[] = $pttc->tiendo;
      
                                        }
                                   }

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
                        return '<input type="radio" name="selectbc" id="selectbc_' . $bc->id . '" attr="' . $bc->id . '" class="form-control">';
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


     // Báo cáo nhận xét
     public function baocaonhanxet(){

               $keHoachBaoCaoList = DB::table('kehoach_baocao')
                                        ->get();

               $user = DB::table('users')
                              ->get();

          return view('admin.project.Synthetic.danhgianoibo')
                         ->with([
                                   'keHoachBaoCaoList'  => $keHoachBaoCaoList,
                                   'userList' => $user,
                         ]);
     }


     public function datafgnb(Request $req){
          $i = 1;
          $kehoachbaocao = DB::table('kehoach_baocao')
                              ->where('id',$req->id_khbc)
                              ->first();
          if($kehoachbaocao->writeFollow == 1){
               $baocaonhanhxetkhoi = DB::table('baocao_nhanxetkhoi')
                                   ->select('baocao_nhanxetkhoi.id','tieuchuan.stt as stt_tchuan','tieuchi.stt as stt_tchi','baocao_nhanxetkhoi.nhanxet','menhde.mo_ta')
                                   ->leftjoin('baocao_menhde','baocao_menhde.id','=','baocao_nhanxetkhoi.id_menhde_bc')
                                   ->leftjoin('menhde','menhde.id','=','baocao_menhde.id_menhde')
                                   ->leftjoin('tieuchi','tieuchi.id','=','menhde.tieuchi_id')
                                   ->leftjoin('tieuchuan','tieuchuan.id','=','tieuchi.tieuchuan_id')
                                   ->where('baocao_nhanxetkhoi.id_kehoach_bc','=',$req->id_khbc)
                                   ->where('baocao_nhanxetkhoi.nguoi_tao','=',$req->id_user)
                                   ->where('menhde.mo_ta','<>','');
               }else{
                    $baocaonhanhxetkhoi = DB::table('baocao_nhanxetkhoi')
                                   ->select('baocao_nhanxetkhoi.id','tieuchuan.stt as stt_tchuan','tieuchi.stt as stt_tchi','baocao_nhanxetkhoi.nhanxet','mocchuan.mo_ta')
                                   ->leftjoin('baocao_menhde','baocao_menhde.id','=','baocao_nhanxetkhoi.id_menhde_bc')
                                   ->leftjoin('mocchuan','mocchuan.id','=','baocao_menhde.mocchuan_id')
                                   ->leftjoin('tieuchi','tieuchi.id','=','mocchuan.tieuchi_id')
                                   ->leftjoin('tieuchuan','tieuchuan.id','=','tieuchi.tieuchuan_id')
                                   ->where('baocao_nhanxetkhoi.id_kehoach_bc','=',$req->id_khbc)
                                   ->where('baocao_nhanxetkhoi.nguoi_tao','=',$req->id_user)
                                   ->where('mocchuan.mo_ta','<>','');
               }
               



          return DataTables::of($baocaonhanhxetkhoi)

                    ->addColumn('stt',function($dt) use (&$i) {
                         return $i++;
                    })

                    ->addColumn('tctc',function($dt){
                         if($dt->stt_tchuan){
                              return $dt->stt_tchuan.'.'.$dt->stt_tchi;     
                         }
                         
                         
                    })
                    ->make(true);
     }
     public function bacaohoanthanh(Request $req)
     {
         $kehoachbaocao = DB::table('kehoach_baocao')
             ->select('tieuchuan.mo_ta','tieuchuan.stt','baocao_tieuchuan.nguoi_viet','baocao_tieuchuan.trang_thai','baocao_tieuchuan.updated_at','tieuchi.stt as stt_tieuchi','tieuchi.mo_ta as mo_ta_tieuchi')
             ->leftJoin('kehoach_tieuchuan', 'kehoach_tieuchuan.id_kh_baocao', '=', 'kehoach_baocao.id')
             ->leftJoin('tieuchuan', 'tieuchuan.id', '=', 'kehoach_tieuchuan.tieuchuan_id')
             ->leftjoin('baocao_tieuchuan','baocao_tieuchuan.id_kh_tieuchuan','=','kehoach_tieuchuan.id')
             ->leftjoin('kehoach_tieuchi','kehoach_tieuchi.id_kh_tieuchuan','=','kehoach_tieuchuan.id')
             ->leftjoin('tieuchi','tieuchi.id','kehoach_tieuchi.id_tieuchi')
             ->orderBy('kehoach_baocao.created_at', 'desc')
             ->where('kehoach_baocao.id', $req->id_bc);

         return DataTables::of($kehoachbaocao)
                    ->addColumn('motawith',function($dt){
                         if($dt->mo_ta){
                              return "TC".$dt->stt." : ".$dt->mo_ta;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })

                    ->addColumn('nguoiviet',function($dt){
                         $nguoiviet = DB::table('users')
                                        ->where('users.id',$dt->nguoi_viet)
                                        ->first();

                         if($nguoiviet){
                              return $nguoiviet->name;
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->addColumn('tieuchi',function($dt){
                         if($dt->stt_tieuchi){
                              return "TC".$dt->stt.".".$dt->stt_tieuchi." : ".$dt->mo_ta_tieuchi;
                         }else{
                              return "không có dữ liệu";
                         }
                    })
                    ->addColumn('ngayhoanthanh',function($dt){
                         if($dt->updated_at){
                              return $this->toShowDate($dt->updated_at);
                         }else{
                              return "Không có dữ liệu";
                         }
                    })
                    ->make(true);
     }

     public function baocaodgn(){

          return view('admin.project.Synthetic.danhgiangoai');
     }

    public function datadgn(Request $req)
     {
         $kehoachbaocao = DB::table('kehoach_baocao')
             ->whereNotNull('duong_dan');

         return DataTables::of($kehoachbaocao)
             ->addColumn('actions', function ($dt) {
                 return '<a href="' . route('admin.tonghop.dbcl.showfile', ['id' => $dt->id]) . '" target="_blank" title="xem file"><i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i></a>';
             })
             ->rawColumns(['actions'])
             ->make(true);
     }


     public function tailieudgn(){
          $kehoachbaobao = DB::table('kehoach_baocao')
                              ->get();
          return view('admin.project.Synthetic.tailieudgn');
     }

     public function baocaodgn_nx(Request $req){
          $kehoachbaobao = DB::table('kehoach_baocao')
                              ->where('nam',$req->nam)
                              ->where('duong_dan',null)
                              ->get();
          return $kehoachbaobao;
     }

     public function uploadfile(Request $req){
        // $filename = $req->filename;
        // $size = $req->size;

        // $checkmcexisted = DB::table('minhchung')
        //                 ->where('count_size',$size)
        //                 ->where('ten_file',$filename)->first();
        
        // if($checkmcexisted){
        //     return route('admin.dambaochatluong.manaproof.editProof',$checkmcexisted->id);
        // }else{
        //     return 1;
        // }
     }

     public function update_nx(Request $req){

          $data = array(
          );
          $duong_dan = '';

          if($file = $req->file('file')){
           
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();               
            $size = $file->getClientSize();

            $checkmcexisted = DB::table('kehoach_baocao')
                            ->where('id',$req->idkhbc);
           
            $duong_dan = $this->upload($file, 'minhchung');            
            if($duong_dan == false){
                return Redirect::back()->withInput()->with('error',Lang::get('project/QualiAssurance/message.error.uploadfile'));
            }   
            $data['duong_dan'] = $duong_dan;
            $data['ten_file'] = $filename;
            $checkmcexisted->update($data);


           return redirect()->route('admin.tonghop.dbcl.baocaodgn')->with('success',Lang::get('project/QualiAssurance/message.success.update'));
        }
     }

     public function showfile(Request $req){
          $id = $req->id;

        $minhChungData = DB::table('kehoach_baocao')->where('id',$id)->first();
   
        return $this->downloadfile($minhChungData->duong_dan,$minhChungData->ten_file);
     }
}




