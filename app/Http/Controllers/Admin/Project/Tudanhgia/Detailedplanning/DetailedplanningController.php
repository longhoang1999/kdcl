<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Detailedplanning;

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


class DetailedplanningController extends DefinedController
{
     public function index(Request $req){                        
          return view('admin.project.Selfassessment.planning');
     }
    
     public function data(Request $req){
          $user_id = Sentinel::getUser()->id;
          $keHoachBaoCaoList = DB::table('kehoach_baocao')->where('trang_thai', '!=', 'completed'); 
          // if (Sentinel::inRole('admin') || Sentinel::inRole('operator')) {
                             
          // }else {               
          //      $keHoachBaoCaoList = DB::table('kehoach_baocao')
          //           ->leftJoin('kehoach_baocao_nhansu','kehoach_baocao_nhansu.kehoach_baocao_id','=','kehoach_baocao.id')
          //           ->whereRaw("(id_nhansuthuchien = ? OR ns_phutrach = ?)", [$user_id,$user_id])
          //           ->where('trang_thai', '!=', 'completed');              
          // }

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
                         $value->tieuchi = $tieuchi; 
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



     public function general(Request $req){
          $id_kehoacchung = $req->id_khchung;
          $id = $req->id;
          $kehoachbaocaochung = DB::table('kehoach_chung')->where('kh_baocao_id', $id)->first();
          $KHBaCaoDetail = DB::table('kehoach_baocao')
                              ->select('bo_tieuchuan.loai_tieuchuan','kehoach_baocao.id','kehoach_baocao.ten_bc')
                              ->leftjoin('bo_tieuchuan', 'kehoach_baocao.bo_tieuchuan_id', '=', 'bo_tieuchuan.id')
                              ->where('kehoach_baocao.id',$id)
                              ->first();

          $KHBaCaochung = DB::table('kehoach_baocao')
                              ->select('baocao_chung.text as text','kehoach_baocao.id as kh_bc_id', 'baocao_chung.id as bcc_id')
                              ->leftjoin('baocao_chung', 'kehoach_baocao.id', '=', 'baocao_chung.id_kehoach_bc')
                              ->where('kehoach_baocao.id',$id)
                              ->first();
          $text = isset($KHBaCaochung->text) ? $KHBaCaochung->text : '';
          return view("admin.project.Selfassessment.general")->with(["kehoachbaocaos" =>  $KHBaCaoDetail,
                                                                      'text' => $text, 
                                                                      'id' => $id,
                                                                      'KHBaCaochung' => $kehoachbaocaochung,
                                                                      'id_kehoacchung' => $id_kehoacchung,       
                                                                 ]);
    }

    public function datatext(Request $req){
          $KHBaCaochung = DB::table('kehoach_baocao')
                           ->leftjoin('baocao_chung', 'kehoach_baocao.id', '=', 'baocao_chung.id_kehoach_bc')->select('baocao_chung.text')->first();
          $text = isset($KHBaCaochung->text) ? $KHBaCaochung->text : '';
          return $text;
     }
    public function update(Request $req){
          $text = $req->text;
          return with(["text" => $text]);
    }

    public function show(Request $req){
         $tieuchuan_id = $req->tieuchuan_id;
         $id_khbc = $req->id;
         $chuancongbo = true;
         // Phần này cần sửa lại
         $start = [];
         try{     
            if(Sentinel::inRole('admin') || Sentinel::inRole('operator')) {

                $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                                        ->select('kehoach_baocao.*','kehoach_baocao.loai_tieuchuan as loai_tieuchuan_bc','bo_tieuchuan.*')
                                        ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                                        ->where('kehoach_baocao.id', $id_khbc)
                                        ->first();

               // $bo_tieuchuan = DB::table('bo_tieuchuan')
               //                     ->where('bo_tieuchuan.id',$keHoachBaoCaoDetail->bo_tieuchuan_id)->first();
                $keHoachTieuChuan = Db::table('kehoach_tieuchuan')->select('kehoach_tieuchuan.*', 'users.id as id_truong_nhom')->leftjoin('users','users.id','=','kehoach_tieuchuan.truongnhom')->where('tieuchuan_id',$tieuchuan_id)->first();
            } else {

                $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                                        ->select('kehoach_baocao.*','kehoach_baocao.loai_tieuchuan as loai_tieuchuan_bc','bo_tieuchuan.*')
                                        ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                                        ->where('kehoach_baocao.id', $id_khbc)
                                        ->first();
                // $bo_tieuchuan = DB::table('bo_tieuchuan')
                //                    ->where('bo_tieuchuan.id',$keHoachBaoCaoDetail->bo_tieuchuan_id)->first();
                $keHoachTieuChuan = Db::table('kehoach_tieuchuan')->select('kehoach_tieuchuan.*', 'users.id as id_truong_nhom')->leftjoin('users','users.id','=','kehoach_tieuchuan.truongnhom')->where('tieuchuan_id',$tieuchuan_id)->first();
            }
            
            // $keHoachBaoCaoDetail->bo_tieuchuan = $bo_tieuchuan;
     

         }catch (\Exception $e) {
            return abort(422, $e->getMessage());
         }

         $KHBaCaoDetail = DB::table('kehoach_baocao')->find($id_khbc);
         $kehoachtieuchuan = DB::table('kehoach_baocao')
                              ->select('kehoach_baocao.*','kehoach_tieuchuan.id as khtc_id',  'kehoach_tieuchuan.tieuchuan_id')
                              ->leftjoin('kehoach_tieuchuan','kehoach_tieuchuan.id_kh_baocao','=', 'kehoach_baocao.id')
                              ->where('kehoach_tieuchuan.tieuchuan_id',$tieuchuan_id)
                              ->where('kehoach_baocao.id',$id_khbc)->first();
         
          $tieuchi = DB::table('kehoach_tieuchi')
                         ->select('tieuchi.*','kehoach_tieuchi.id as khtt_id')
                         ->leftjoin('tieuchi','tieuchi.id','=','kehoach_tieuchi.id_tieuchi')
                         ->where('kehoach_tieuchi.id_kh_tieuchuan',$kehoachtieuchuan->khtc_id)
                         ->where('tieuchi.tieuchuan_id',$tieuchuan_id)
                         ->orderBy('tieuchi.stt', 'asc')
                         ->get();
          $isTieuChuanCongBo = true;

          foreach($tieuchi as $value){
               $baocao = DB::table('baocao_tieuchi')
                           ->where('id_kehoach_bc', $kehoachtieuchuan->id)
                           ->where('id_tieuchi', $value->id)
                           ->first();
               if($baocao){
                    if($baocao->trang_thai == 'dangsua'){
                         $isTieuChuanCongBo = false;
                         $chuancongbo = false;

                    }
               }else{
                    $chuancongbo = false;
                    $isTieuChuanCongBo = true;
               }
               // $bacao_menhde = DB::table('kehoach_menhde')
               //                     ->select('kehoach_menhde.id as id_khmd', 'menhde.*')
               //                     ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
               //                     ->where('menhde.tieuchi_id',$value->id)
               //                     ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
               //                     ->get();

               // $menhde_baocao = DB::table('baocao_menhde')
               //            ->select('menhde.id as menhde_id', 'menhde.mo_ta','menhde.*', 'baocao_menhde.*')
               //            ->leftjoin('menhde','menhde.id','=','baocao_menhde.id_menhde')
               //            ->where('baocao_menhde.id_kehoach_bc',$kehoachtieuchuan->id)
               //            ->where('menhde.tieuchi_id',$value->id)
               //            // ->where('id_kh_menhde',$val->id_khmd)
               //           ->get();

               if($KHBaCaoDetail->writeFollow == 1){
                    $bacao_menhde = DB::table('kehoach_menhde')
                                   ->select('kehoach_menhde.id as id_khmd', 'menhde.*')
                                   ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                   ->where('menhde.tieuchi_id',$value->id)
                                   ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                   ->first();
                   
                    if($bacao_menhde){
                         $menhde_baocao = DB::table('baocao_menhde')
                               ->select('menhde.id as menhde_id', 'menhde.mo_ta','menhde.*', 'baocao_menhde.*')
                               ->leftjoin('menhde','menhde.id','=','baocao_menhde.id_menhde')
                               ->where('baocao_menhde.id_kehoach_bc',$kehoachtieuchuan->id)
                               ->where('menhde.tieuchi_id',$value->id)
                               // ->where('baocao_menhde.id_kh_menhde',$bacao_menhde->id_khmd)
                              ->get();
                    }          
               
                    $kh_menhde_start = DB::table('kehoach_menhde')
                                             ->select('kehoach_menhde.id as id_khmd','menhde.id')
                                             ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                             ->where('menhde.tieuchi_id',$value->id)
                                             ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                             ->first();

                    if($kh_menhde_start){
                         $menhde_baocao_start = DB::table('baocao_menhde')
                               ->select('danhgia')
                               ->where('id_kehoach_bc',$kehoachtieuchuan->id)
                               ->where('id_kh_menhde',$kh_menhde_start->id_khmd)
                               ->where('id_menhde',$kh_menhde_start->id)
                               ->first();
                    }
                    
               }else if($KHBaCaoDetail->writeFollow == 2){
                    
                    $bacao_menhde = DB::table('kehoach_menhde')
                                   ->select('kehoach_menhde.id as id_khmd', 'mocchuan.*')
                                   ->leftjoin('mocchuan','mocchuan.id','=','kehoach_menhde.mocchuan_id')
                                   ->where('mocchuan.tieuchi_id',$value->id)
                                   ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                   ->first();
                    

                    if($bacao_menhde){
                         $menhde_baocao = DB::table('baocao_menhde')
                               ->select('mocchuan.id as menhde_id', 'mocchuan.mo_ta','mocchuan.*', 'baocao_menhde.*')
                               ->leftjoin('mocchuan','mocchuan.id','=','baocao_menhde.mocchuan_id')
                               ->where('baocao_menhde.id_kehoach_bc',$kehoachtieuchuan->id)
                               ->where('mocchuan.tieuchi_id',$value->id)
                               // ->where('id_kh_menhde',$bacao_menhde->id_khmd)
                              ->get();
                            

            
                    }
                                   
                    $kh_menhde_start = DB::table('kehoach_menhde')
                                             ->select('kehoach_menhde.id as id_khmd', 'mocchuan.id')
                                             ->leftjoin('mocchuan','mocchuan.id','=','kehoach_menhde.mocchuan_id')
                                             ->where('mocchuan.tieuchi_id',$value->id)
                                             ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                             ->first();
                    if($kh_menhde_start){
                         $menhde_baocao_start = DB::table('baocao_menhde')
                                              ->select('danhgia')
                                              ->where('id_kehoach_bc',$kehoachtieuchuan->id)
                                              ->where('id_kh_menhde',$kh_menhde_start->id_khmd)
                                              ->where('mocchuan_id',$kh_menhde_start->id)
                                              ->first();
                    }                        
                    
               }
               // var_dump($menhde_baocao);
               // echo('<br/>');
               // echo("hãy giúp tôi ngăt quãng ở vị trí này ở đây ");
               // echo('<br/>');
               
               if(isset($menhde_baocao)){
                    $value->bc_menhde = $menhde_baocao;
                    $value->bacao_menhde = $menhde_baocao;
               }
               if(isset($menhde_baocao_start)){
                    $value->menhde_baocao_start = $menhde_baocao_start;
               }
               
               $value->baocao_tieuchi = $baocao;
               
               $value->menhde_khmd = $bacao_menhde;
               if(!empty($value->menhde_baocao_start->danhgia)){
                   array_push($start,$value->menhde_baocao_start->danhgia); 
               }
                              

          }
          // die;
          $sum_start = Collection::make($start)->avg();
          $sum_danhgia = round($sum_start);
          $kehoachtieuchuan->tieuchi = $tieuchi; 
          foreach($kehoachtieuchuan->tieuchi as $value){
               $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('menhde.id as id_md', 'kehoach_menhde.*','kehoach_tieuchi.id_tieuchi')
                                        ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                        ->leftjoin('kehoach_tieuchi','kehoach_tieuchi.id','=','kehoach_menhde.id_kh_tieuchi')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                        ->get();

          }

         $KHBaoCao = DB::table('kehoach_baocao')->where('kehoach_baocao.id', '=', $id_khbc)->select('kehoach_baocao.ten_bc')->get();
         $tieuChuan = DB::table('tieuchuan')
                         ->select('id','stt','trang_thai','mo_ta')
                         ->where('tieuchuan.id', $tieuchuan_id)
                         ->orderBy('stt', 'desc')
                         ->first();

          $baoCaoTieuChuan = DB::table('baocao_tieuchuan')->where([
                ['id_kehoach_bc', '=', $id_khbc],
                ['id_tieuchuan', '=', $tieuchuan_id],
                // ['id_kh_tieuchuan', '=', $kehoachtieuchuan->khtc_id],
          ])->orderBy('created_at', 'desc')->first();

          if($isTieuChuanCongBo && !$baoCaoTieuChuan){
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')->insert([
                                   'id_kehoach_bc'     => $id_khbc,
                                   'id_tieuchuan'      => $tieuchuan_id,
                                   'id_kh_tieuchuan'   => $kehoachtieuchuan->khtc_id,

                               ]);
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')->where([
                                    ['id_kehoach_bc', '=', $id_khbc],
                                    ['id_tieuchuan', '=', $tieuchuan_id],
                                    // ['id_kh_tieuchuan', '=', $kehoachtieuchuan->khtc_id],
                              ])->orderBy('created_at', 'desc')->first();
          }
          if ($isTieuChuanCongBo && $baoCaoTieuChuan) {
                $tieuChuan->trang_thai = 'congbo';
                // $baoCaoTieuChuan->trang_thai = 'congbo';
                $save = DB::table('baocao_tieuchuan')->where([
                               ['id_kehoach_bc', '=', $id_khbc],
                               ['id_tieuchuan', '=', $tieuchuan_id],
                               // ['id_kh_tieuchuan', '=', $kehoachtieuchuan->khtc_id],
                         ])
                         ->update([
                              'trang_thai' => 'congbo',
                         ]);
          }

         $nhanxetbc = DB::table('baocao_nhanxet')
                         ->leftjoin('users','users.id','=','baocao_nhanxet.nguoi_tao')
                         ->where([
                              ['id_kehoach_bc', '=', $id_khbc],
                              ['id_tieuchuan', '=', $tieuchuan_id],
                         ])->get();

         $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')
                                ->leftjoin('users','users.id','=','baocao_nhanxetkhoi.nguoi_tao')
                                ->where('id_kehoach_bc',$id_khbc)
                                ->get();
          foreach($nhanXetKhoiList as $value){
               $name_dv = DB::table('donvi')
                              ->where('id',$value->donvi_id)->first();
               $value->tendonvi = $name_dv;
          }

          $arr_mc = array();
          $minhchung_gmc = DB::table('minhchunggop_minhchung')
                                   ->get();
          foreach($minhchung_gmc as $val_mc){
               array_push($arr_mc,$val_mc->minhchung_id);
          }
         
         $donViData = DB::table('donvi')->get();
         return view("admin.project.Selfassessment.show")
                ->with(["KHBaoCao" =>  $KHBaoCao,
                        "baoCaoTieuChuan" => $baoCaoTieuChuan,
                        "nhanxetbc" => $nhanxetbc,
                        "tieuchuans_tieuchi" => $kehoachtieuchuan,
                        "tieuChuan" => $tieuChuan,
                        "keHoachBaoCaoDetail" => $keHoachBaoCaoDetail,
                        "keHoachTieuChuan" => $keHoachTieuChuan,
                        "donViData" => $donViData,
                        "id_khbc" => $id_khbc,
                        "tieuchuan_id" => $tieuchuan_id,
                        // "danhGiaTieuChiData" => $danhGiaTieuChiData,
                        "nhanXetKhoiList" => $nhanXetKhoiList,
                        "sum_danhgia" => $sum_danhgia,
                        "arr_mc" => $arr_mc,
                    ]);
    }

    public function showmochuan(Request $req){
          
          try {
              $mo_chuan = DB::table('mocchuan')->where('tieuchi_id',$req->id)->get();

              if ($mo_chuan->count() == 0) {
                  return 1;
              }
              if(!$mo_chuan){
                  return 1;
              }

              return $mo_chuan;
          } catch (\Exception $e) {
              return abort(422, $e->getMessage());
          }
    }

    public function showmctt(Request $req){
          
          try {

              $minhchunggop_minhchungtt = DB::table('minhchunggop_minhchungtt')
              // ->leftjoin('minhchung_gop','minhchunggop_minhchungtt.minhchunggop_id','=','minhchung_gop.id')
              ->leftjoin('minhchung_gop','minhchung_gop.id','=','minhchunggop_minhchungtt.minhchunggop_id')
              ->where('minhchung_gop.id_tieuchi',$req->id)
              ->get();
            

              $listtieude = array();

               foreach($minhchunggop_minhchungtt as $value){
                    $minhchung_tt = DB::table('minhchung_tt')
                                         ->where('minhchung_tt.id',$value->minhchungtt_id)
                                         ->first();
                    if(!in_array($minhchung_tt->tieu_de,$listtieude)){
                         $value->tieuchis = $minhchung_tt;
                         array_push($listtieude, $minhchung_tt->tieu_de);
                    }
               }

              // echo($minhchunggop_minhchungtt->tieuchis);
              // die;
              if (!$minhchunggop_minhchungtt) {
                return 1;
            }

              if ($minhchunggop_minhchungtt->count() == 0) {
                return 1;
            }

              return $minhchunggop_minhchungtt;
          } catch (\Exception $e) {
              return abort(422, $e->getMessage());
          }
    }

    public function showhuongdan(Request $req){

          $goi_y_hd_id = DB::table('role_gyhd_tchi')
                         ->where('tieuchi_id',$req->id)
                         ->pluck('gyhd_id');     
          $huongDanData = DB::table('huongdan')
                              ->select('mo_ta')
                              ->whereIn('id',$goi_y_hd_id)
                              ->get();
        return $huongDanData;
    }

    public function showcongbotieuchi(Request $req){

          $baocaomenhde = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_kh_menhde',$req->kehmd)
                              ->where('id_menhde',$req->menhde_id)
                              ->first();
          // if($baocaomenhde){
          //      if($baocaomenhde->mota == null){
          //           return 3;
          //      }else if($baocaomenhde->diemmanh == null){
          //           return 4;
          //      }else if($baocaomenhde->tontai == null){
          //           return 5;
          //      }
          // }

          $KHBaCaoDetail = DB::table('kehoach_baocao')->where('id',$req->id_khbc)->first();

          $tieuChi = DB::table('tieuchi')->where('tieuchi.id',$req->tieuchi_id)
                         ->leftjoin('tieuchuan','tieuchuan.id','=','tieuchi.tieuchuan_id')
                         ->first();

          $keHoachTieuChuan = DB::table('kehoach_tieuchuan')
                                   ->where('kehoach_tieuchuan.tieuchuan_id',$tieuChi->tieuchuan_id)
                                   ->where('kehoach_tieuchuan.id_kh_baocao',$req->id_khbc)->first();

          $keHoachTieuChi = DB::table('kehoach_tieuchi')
                              ->where('id_tieuchi',$tieuChi->id)
                              ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)->first();
            $baoCaoTieuChi = DB::table('baocao_tieuchi')
                                   ->where('id_kehoach_bc',$req->id_khbc)
                                   ->where('id',$req->baocao_id)->first();
            if (!$baoCaoTieuChi){
               $save = DB::table('baocao_tieuchi')
                                   ->insert([
                                        'id_kehoach_bc' => $req->id_khbc,
                                        'id_kh_tieuchi' => $keHoachTieuChi->id,
                                        'id_tieuchi'    => $req->tieuchi_id,
                                        'nguoi_viet' => Sentinel::getUser()->id,
                                        'id_csdt' => Sentinel::getUser()->id_csdt,
                                   ]);
               $reload = 'Tiêu chí đã công bố thành công';
            }else{
               $save_bctc = DB::table('baocao_tieuchi')
                                   ->where('id_kehoach_bc',$req->id_khbc)
                                   ->where('id',$req->baocao_id)
                                   ->update([
                                        'trang_thai' => 'congbo',
                                   ]);

               $reload = 'Tiêu chí đã công bố thành công . Bấm OK để reload lại trang';
            }


          return (array)$reload;
    }

    public function updategeneral(Request $req){

          try {
               $KHBaCaoDetail = DB::table('kehoach_baocao')->where('kehoach_baocao.id',$req->kh)->first();

               if (!$KHBaCaoDetail) {
                     return abort(422, Lang::get('project/Selfassessment/title.knddck'));
                 }

               if (!Sentinel::inRole('admin') || Sentinel::inRole('operator') && $KHBaCaoDetail->ns_phutrach != ASentinel::getUser()->id) {
                     return abort(401, Lang::get('project/Selfassessment/title.tcbtc'));
                 }
               $keHoachChung = DB::table('kehoach_chung')
                                   ->where('kehoach_chung.kh_baocao_id',$KHBaCaoDetail->id)
                                   ->where('kehoach_chung.id',$req->id_kehoacchung)->first();

               if (!$keHoachChung) {
                     return abort(422, Lang::get('project/Selfassessment/title.knddck'));
                 }

               if (!$req->has("text") || $req->text == "") {
                     return abort(422, Lang::get('project/Selfassessment/title.vlnnd'));
               }
               $baoCaoChung = DB::table('baocao_chung')
                                   ->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                   ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->first();
              
               if (!$baoCaoChung) {
                     $s = DB::table('baocao_chung')
                                   ->insert([
                                        'text' => $req->text,
                                        'id_kehoach_bc' => $KHBaCaoDetail->id,
                                        'id_csdt' => Sentinel::getUser()->id_csdt,
                                        'id_kh_chung' => $keHoachChung->id,
                                   ]);
                 } else {

                     $baoCaoChung->text = $req->text;
                     
                     $save = DB::table('baocao_chung')
                                   ->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                   ->where('baocao_chung.id_kh_chung',$keHoachChung->id)
                                   ->update([
                                             'text' => $req->text,
                                           ]);
                     
                 }
               return back()->with('success', 
                         Lang::get('project/Selfassessment/title.capnhattc'));
          } catch (\Exception $e) {
            return abort(422, $e->getMessage());
          }
          
    }


    public function updatetieuchuan(Request $req){
          $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                              ->where('baocao_tieuchuan.id_kehoach_bc',$req->id_khbc)
                              ->where('baocao_tieuchuan.id_tieuchuan',$req->id_tc)
                              // ->where('baocao_tieuchuan.id_kh_tieuchuan',$req->id_kh_tc)
                              ->first();

           if (!$baoCaoTieuChuan) {
                $saves = DB::table('baocao_tieuchuan')
                              ->insert([
                                   "id_kehoach_bc"  => $req->id_khbc,
                                   "id_tieuchuan"  => $req->id_tc,
                                   "id_kh_tieuchuan"  => $req->id_kh_tc,
                                   'modau' => $req->modau,

                              ]);
                return $req->modau;
            }


          $save = DB::table('baocao_tieuchuan')
                              ->where('baocao_tieuchuan.id_kehoach_bc',$req->id_khbc)
                              // ->where('baocao_tieuchuan.id_kh_tieuchuan',$req->id_kh_tc)
                              ->where('baocao_tieuchuan.id_tieuchuan',$req->id_tc)->update([
                                   'modau' => $req->modau,

                              ]);

          return $req->modau;
    }

    public function updatetieuchuan2(Request $req){
          $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                              ->where('baocao_tieuchuan.id_kehoach_bc',$req->id_khbc)
                              ->where('baocao_tieuchuan.id_tieuchuan',$req->id_tc)->first();
          

           if (!$baoCaoTieuChuan) {
              $saves = DB::table('baocao_tieuchuan')
                              ->insert([
                                   "id_kehoach_bc"  => $req->id_khbc,
                                   "id_tieuchuan"  => $req->id_tc,
                                   'ketluan' => $req->ketluan,

                              ]);
                              
               return $req->ketluan;
            }


          $save = DB::table('baocao_tieuchuan')
                              ->where('baocao_tieuchuan.id_kehoach_bc',$req->id_khbc)
                              ->where('baocao_tieuchuan.id_tieuchuan',$req->id_tc)->update([
                                   'ketluan' => $req->ketluan,

                              ]);
                              
          return $req->ketluan;
    }

    public function updatemenhde(Request $req){
          $kehoachbaocao = DB::table("kehoach_baocao")
                              ->where('id',$req->id_khbc)
                              ->first();
          if($kehoachbaocao->writeFollow == 1){
               $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_menhde',$req->id_menhde)->first();

               $save = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_menhde',$req->id_menhde)->update([
                                   'mota' => $req->mota_md,
                              ]);
          }else{

               $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('mocchuan_id',$req->id_menhde)->first();

               $save = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('mocchuan_id',$req->id_menhde)->update([
                                   'mota' => $req->mota_md,
                              ]);
          }
          

     return $req->mota_md;
    }

    public function creat_khhd(Request $req){
          try{
               $date1  = Carbon::parse($this->toDBDate($req->ngay_batdau));
               $date2  = Carbon::parse($this->toDBDate($req->ngay_hoanthanh));

               if($date1->gt($date2)){
                     return 0;
               }
               $baoCaoKeHoach = DB::table('kehoach_hd')->insert([
                              'kehoach_bc_id' => $req->id_khbc,
                              'menhde_id'     => $req->id_menhde,
                              'tieu_de'       =>   $req->tieu_de,
                              'noi_dung'      => $req->noi_dung,
                              'de_xuat_moi'   => $req->de_xuat_moi,
                              'ns_thuchien'   => $req->ns_thuchien,
                              'ns_kiemtra'    => $req->ns_kiemtra,
                              'ngay_batdau'   => $this->toDBDate($req->ngay_batdau),
                              'ngay_hoanthanh'=> $this->toDBDate($req->ngay_hoanthanh),
                              'kieu_kehoach'  => $req->kieu_kehoach,
                              'trang_thai'    => 'todo',
                              'nguoi_tao'     => Sentinel::getUser()->id,
                              'csdt_id'       => Sentinel::getUser()->csdt_id,
                           ]);

               return 1;
          }catch (\Exception $e) {
            return abort(422, $e->getMessage());
          }
          
    }

    public function conclusion(Request $req){
               $KHBaCaoDetail = DB::table('kehoach_baocao')->where('id',$req->id)->first();
               $id_kehoacchung = $req->id_khchung;
               $KHBaCaochung = DB::table('kehoach_baocao')
                              ->select('baocao_chung.ketluan as ketluan','kehoach_baocao.id as kh_bc_id', 'baocao_chung.id as bcc_id')
                              ->leftjoin('baocao_chung', 'kehoach_baocao.id', '=', 'baocao_chung.id_kehoach_bc')
                              ->where('kehoach_baocao.id',$req->id)
                              ->first();
               $text = isset($KHBaCaochung->ketluan) ? $KHBaCaochung->ketluan : '';
          return view('admin.project.Selfassessment.conclusion')
                         ->with([
                              'KHBaCaoDetail'  => $KHBaCaoDetail,
                              'text'           => $text,
                              'id_kehoacchung' => $id_kehoacchung,
                         ]);


    }

    public function updateconclusion(Request $req){
          try {
               $KHBaCaoDetail = DB::table('kehoach_baocao')->where('kehoach_baocao.id',$req->kh)->first();
               // ->find($req->kh);

               if (!$KHBaCaoDetail) {
                     return abort(422, Lang::get('project/Selfassessment/title.knddck'));
                 }

               if (!Sentinel::inRole('admin') || Sentinel::inRole('operator') && $KHBaCaoDetail->ns_phutrach != ASentinel::getUser()->id) {
                     return abort(401, Lang::get('project/Selfassessment/title.tcbtc'));
                 }
               $keHoachChung = DB::table('kehoach_chung')->where('kehoach_chung.kh_baocao_id',$KHBaCaoDetail->id)
                                   ->where('kehoach_chung.id',$req->id_kehoacchung)->first();

               // ->find($req->id_kehoacchung);
               if (!$keHoachChung) {
                     return abort(422, Lang::get('project/Selfassessment/title.knddck'));
                 }

               $baoCaoChung = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                   ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->first();
               if (!$baoCaoChung) {
                     $s = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                   ->insert([
                                        'ketluan' => $req->text,
                                        'id_kehoach_bc' => $KHBaCaoDetail->id,
                                        'id_kh_chung' => $keHoachChung->id,
                                        'id_csdt' => Sentinel::getUser()->id_csdt,
                                   ]);
                 } else {
                     // $baoCaoChung->text = $req->text;
                     $save = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                   ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->update([
                                                            'ketluan' => $req->text,
                                                       ]);
                 }
               return back()->with('success', 
                         Lang::get('project/Selfassessment/title.capnhattc'));
          } catch (\Exception $e) {
            return abort(422, $e->getMessage());
          }
    }

    public function updatemenhdedm(Request $req){

          $kehoachbaocao = DB::table("kehoach_baocao")
                              ->where('id',$req->id_khbc)
                              ->first();
          if($kehoachbaocao->writeFollow == 1){
               $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_menhde',$req->id_menhde)->first();
                              
               $save = DB::table('baocao_menhde')
                         ->where('id_kehoach_bc',$req->id_khbc)
                         ->where('id_menhde',$req->id_menhde)->update([
                              'diemmanh' => $req->mota_dm,
                         ]);
          }else{
               $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('mocchuan_id',$req->id_menhde)->first();
                              
               $save = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('mocchuan_id',$req->id_menhde)->update([
                                   'diemmanh' => $req->mota_dm,
                              ]);
          }                  
          

          return $req->mota_dm;
    }
     public function updatemenhdett(Request $req){
          $kehoachbaocao = DB::table("kehoach_baocao")
                              ->where('id',$req->id_khbc)
                              ->first();

          if($kehoachbaocao->writeFollow == 1){
               $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_menhde',$req->id_menhde)->first();

               $save = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_menhde',$req->id_menhde)->update([
                                   'tontai' => $req->mota_tt,
                              ]);
               }else{
                   $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('mocchuan_id',$req->id_menhde)->first();

                    $save = DB::table('baocao_menhde')
                                   ->where('id_kehoach_bc',$req->id_khbc)
                                   ->where('mocchuan_id',$req->id_menhde)->update([
                                        'tontai' => $req->mota_tt,
                                   ]); 
               }                 
          

          return $req->mota_tt;
    }

    public function moLaiTieuChi(Request $req){
           
          if(Sentinel::inRole('admin') || Sentinel::inRole('operator')){

               $updateTieuChi = DB::table('baocao_tieuchi')
                                        ->where('id', $req->baocao_id)
                                             ->update([
                                                  'trang_thai' => 'dangsua',
                                             ]);
               // // Lấy id_kh_tieuchuan
                     $id_kh_tieuchuan =  DB::table('kehoach_tieuchuan')
                                             ->where('id_kh_baocao',$req->id_khbc)
                                             ->where('tieuchuan_id',$req->id_tieuchuan)->first();
               // //  Lấy id_kh_tieuchi  

                    if($id_kh_tieuchuan){
                         $id_kh_tieuchi  = DB::table('kehoach_tieuchi')
                                             ->where('kehoach_tieuchi.id_tieuchi',$req->tieuchi_id)
                                             ->where('kehoach_tieuchi.id_kh_tieuchuan',$id_kh_tieuchuan->id)
                                             ->first();
                    }
               // Lấy list id_kh_menhde
                $id_kh_menhde = DB::table('kehoach_menhde')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$id_kh_tieuchi->id)->first();
               // Mở lại tất cả mệnh đề thành 'dangsua' trong tiêu chí
               if($id_kh_menhde){
                    $updateBCMenhDe = DB::table('baocao_menhde')
                                        ->where('id_kh_menhde',$id_kh_menhde->id)
                                        ->update([
                                             'trang_thai' => 'dangsua',
                                        ]);
               }
                
               $response = 'Mở lại tiêu chí thành công . Bấm OK để reload lại trang';

          }else{
               $response = 'Bạn không có quyền mở lại tiêu chí này';

               
          }
                
          return $response;
          
          
    }

    public function updtecbmd(Request $req){

          $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('baocao_menhde.id_kehoach_bc','=',$req->id_khbc)
                              ->where('baocao_menhde.id','=',$req->bacaomd_id)
                              ->where('baocao_menhde.trang_thai','!=','congbo')->first();
          if(!$baoCaoMenhDe){

          }else{
               $save =  DB::table('baocao_menhde')
                              ->where('baocao_menhde.id_kehoach_bc','=',$req->id_khbc)
                              ->where('baocao_menhde.id','=',$req->bacaomd_id)
                              ->where('baocao_menhde.trang_thai','!=','congbo')
                              ->update([
                                   'trang_thai' => 'congbo'
                              ]);
          }
         $reload = 'Mệnh đề đã công bố. Bấm OK để tải lại trang';
          return (array)$reload;
    }

    public function updtemlmd(Request $req){
          
          try {
            if (Sentinel::inRole('admin') || Sentinel::inRole('operator')) {
                $menhDe = DB::table('baocao_menhde')
                              ->where('id', $req->bacaomd_id)
                              ->update(['trang_thai' => 'dangsua']);

                $response = 'Mở lại tiêu mệnh đề thành công . Bấm OK để reload lại trang';

            }else{
                $response = 'Bạn không có quyền mở lại tiêu mệnh đề này . Bấm OK để reload lại trang';

            }
           
        } catch (\Throwable $th) {
            $response = [
                'message' => $th->getMessage(),
                'success' => false
            ];
        }
        return $response;
    }

    public function update_muc(Request $req){

          $baoCaoMenhDe = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc','=',$req->id_khbc)
                              ->where('id','=',$req->bacaomd_id)->first();
          $save = DB::table('baocao_menhde')
                              ->where('id_kehoach_bc','=',$req->id_khbc)
                              ->where('id','=',$req->bacaomd_id)
                              ->update([
                                   'danhgia' => $req->muc,
                              ]);

          $reload = 'Bạn đã chấm điểm thành công . Bấm OK để reload trang';
          return $reload;
    }

    public function showmcgop(Request $req){
          $tieuchi = DB::table('tieuchi')
                         ->select('tieuchi.id')
                         ->where('id',$req->id_tieuchi)
                         ->first();
          if($tieuchi){
               $minhChungList = DB::table('minhchung_gop')
                                   ->where('id_tieuchi',$tieuchi->id)
                                   ->get();

               $minhchung = DB::table('minhchung')
                                   ->where('trang_thai','active')
                                   ->get();

               $data = [
                'minhChungList' => $minhChungList,
                'tieuChiDetail' => $tieuchi,
                'minhchung'     => $minhchung,
               ];
          }else{
               return 0;
          }
          return array($data);
     }

    public function modalminhchung(Request $req){
          $check = '0';
          if($req->mcg == 'mcGop'){
               $check = "1";
               $minhchunggop = DB::table('minhchung_gop')
                              ->where('id',$req->id_minhchunggop)
                              ->first();
          }else{
               $check = "0";
               $minhchunggop = DB::table('minhchung')
                              ->where('id',$req->id_minhchunggop)
                              ->first();
               $minhchunggop->linkview = route('admin.dambaochatluong.manaproof.showProof',$minhchunggop->id);
          }
          
          return [array($minhchunggop), $check];
    }

    public function tontai_diemmanh(Request $req){
          try {

            $baoCaoKeHoachData = DB::table('kehoach_hd')
                                   ->where('kehoach_bc_id','=',$req->id_khbc )
                                   ->whereNull('deleted_at')
                                   ->get();

            foreach ($baoCaoKeHoachData as $baoCaoKeHoach) {

                $donvi_th = DB::table('donvi')
                              ->where('id','=',$baoCaoKeHoach->ns_thuchien)
                              ->first();

                $donvi_kt = DB::table('donvi')
                              ->where('id','=',$baoCaoKeHoach->ns_kiemtra)
                              ->first();
                $baoCaoKeHoach->nhanSuThucHien = $donvi_th;
                $baoCaoKeHoach->nhanSuKiemTra = $donvi_kt;
            }
            return response()->json($baoCaoKeHoachData);
        } catch (\Exception $e) {
            return abort(422, $e->getMessage());
        }
    }

    public function show_tontai_diemmanh(Request $req){
          try {

            $baoCaoKeHoachData = DB::table('kehoach_hd')
                                   ->where('kehoach_bc_id','=',$req->id_khbc )
                                   ->where('id','=',$req->id_kh_hd)
                                   ->whereNull('deleted_at')
                                   ->get();

            foreach ($baoCaoKeHoachData as $baoCaoKeHoach) {

                $donvi_th = DB::table('donvi')
                              ->where('id','=',$baoCaoKeHoach->ns_thuchien)
                              ->first();

                $donvi_kt = DB::table('donvi')
                              ->where('id','=',$baoCaoKeHoach->ns_kiemtra)
                              ->first();
                $baoCaoKeHoach->nhanSuThucHien = $donvi_th;
                $baoCaoKeHoach->nhanSuKiemTra = $donvi_kt;
            }
            return response()->json($baoCaoKeHoachData);
        } catch (\Exception $e) {
            return abort(422, $e->getMessage());
        }
    }

    public function delete_diemmanh(Request $req){
          $res = DB::table('kehoach_hd')
                    ->where('kehoach_bc_id','=',$req->id_khbc)
                    ->where('menhde_id','=',$req->id_menhde)
                    ->where('id','=',$req->id_kh_hd)
                    ->update([
                         'deleted_at' => date('Y-m-d H:i:s'),
                    ]);
          return 1;
    }
}