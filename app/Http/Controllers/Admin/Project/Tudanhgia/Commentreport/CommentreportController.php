<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Commentreport;

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

class CommentreportController extends DefinedController
{
     public function index(Request $req){                        
          return view('admin.project.Selfassessment.comreport');
     }
    
     public function data(Request $req){
          $user_id = Sentinel::getUser()->id;
          $keHoachBaoCaoList = DB::table('kehoach_baocao')->where('trang_thai', '!=', 'completed');

          if(isset($req->id) && $req->id > 0){
               $bc = $keHoachBaoCaoList->where('id',$req->id)->first();
               $kehoachung = DB::table('kehoach_chung')->select('kehoach_chung.id')
                                   ->where('kehoach_chung.kh_baocao_id','=',$bc->id)->first();
               $arrout = array();
               if($bc){
                    


                    $arrout['phan1'] = '<a class="a_css" href="#"><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan1') . '</span></a>';
                    $arrout['phan3'] = '<a class="a_bottom" href="#"><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan3') . '</span></a>';


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
                    $arrout['phan2'] = '<div class="a_mid" "><span class="label label-primary"><i class="fas fa-edit"></i></span><span style="color:blue;font-weight:bold;">' . Lang::get('project/Selfassessment/title.phan2') . '</span></div>';
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
          $id = $req->id;
          $id_khbc = $req->id;

          $KHBaCaoDetail = DB::table('kehoach_baocao')
                              ->leftjoin('bo_tieuchuan', 'kehoach_baocao.bo_tieuchuan_id', '=', 'bo_tieuchuan.id')
                              ->select('bo_tieuchuan.loai_tieuchuan','kehoach_baocao.id','kehoach_baocao.ten_bc')
                              ->where('kehoach_baocao.id',$id)
                              ->first();
                           // var_dump($KHBaCaoDetail);
                           // die();

          $KHBaCaochung = DB::table('kehoach_baocao')
                              ->select('baocao_chung.text as text','kehoach_baocao.id as kh_bc_id', 'baocao_chung.id as bcc_id')
                              ->leftjoin('baocao_chung', 'kehoach_baocao.id', '=', 'baocao_chung.id_kehoach_bc')
                              ->where('kehoach_baocao.id',$id)
                              ->first();
          $text = isset($KHBaCaochung->text) ? $KHBaCaochung->text : '';
          $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')
                                ->leftjoin('users','users.id','=','baocao_nhanxetkhoi.nguoi_tao')
                                ->where('id_kehoach_bc',$id_khbc)
                                ->get();
          foreach($nhanXetKhoiList as $value){
               $name_dv = DB::table('donvi')
                              ->where('id',$value->donvi_id)->first();
               $value->tendonvi = $name_dv;
          }

          return view("admin.project.Selfassessment.first")
               ->with(["kehoachbaocaos" =>  $KHBaCaoDetail,
               'text' => $text,
               'id' => $id,
               "id_khbc" => $id_khbc,
               "nhanXetKhoiList" => $nhanXetKhoiList,
          ]);
    }

    public function conclusion(Request $req){
          $id = $req->id;
          $id_khbc = $req->id;

          $KHBaCaoDetail = DB::table('kehoach_baocao')
                              ->leftjoin('bo_tieuchuan', 'kehoach_baocao.bo_tieuchuan_id', '=', 'bo_tieuchuan.id')
                              ->select('bo_tieuchuan.loai_tieuchuan','kehoach_baocao.id','kehoach_baocao.ten_bc')
                              ->where('kehoach_baocao.id',$id)
                              ->first();
                           // var_dump($KHBaCaoDetail);
                           // die();

          $KHBaCaochung = DB::table('kehoach_baocao')
                              ->select('baocao_chung.ketluan as ketluan','kehoach_baocao.id as kh_bc_id', 'baocao_chung.id as bcc_id')
                              ->leftjoin('baocao_chung', 'kehoach_baocao.id', '=', 'baocao_chung.id_kehoach_bc')
                              ->where('kehoach_baocao.id',$id)
                              ->first();
          $ketluan = isset($KHBaCaochung->ketluan) ? $KHBaCaochung->ketluan : '';
          $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')
                                ->leftjoin('users','users.id','=','baocao_nhanxetkhoi.nguoi_tao')
                                ->where('id_kehoach_bc',$id_khbc)
                                ->get();
          foreach($nhanXetKhoiList as $value){
               $name_dv = DB::table('donvi')
                              ->where('id',$value->donvi_id)->first();
               $value->tendonvi = $name_dv;
          }
          return view("admin.project.Selfassessment.conclusion_comment")
               ->with(["kehoachbaocaos" =>  $KHBaCaoDetail, 
                    'ketluan' => $ketluan, 
                    'id' => $id,
                    "id_khbc" => $id_khbc,
                    "nhanXetKhoiList" => $nhanXetKhoiList,
               ]);
    }
     public function viewReport(Request $req){
         $tieuchuan_id = $req->tieuchuan_id;
         $id_khbc = $req->id;
         $userId = Sentinel::getUser()->id;
         $start = [];
         $keHoachBaoCaoDetail = DB::table('kehoach_baocao')->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')->where('kehoach_baocao.id', $id_khbc)->first();

               $bo_tieuchuan = DB::table('bo_tieuchuan')
                                   ->where('bo_tieuchuan.id',$keHoachBaoCaoDetail->bo_tieuchuan_id)->first();
                $keHoachTieuChuan = Db::table('kehoach_tieuchuan')->select('kehoach_tieuchuan.*', 'users.id as id_truong_nhom')->leftjoin('users','users.id','=','kehoach_tieuchuan.truongnhom')->where('tieuchuan_id',$tieuchuan_id)->first();
            
            $keHoachBaoCaoDetail->bo_tieuchuan = $bo_tieuchuan;
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
                         ->get();

          foreach($tieuchi as $value){
               $baocao = DB::table('baocao_tieuchi')
                           ->where('id_kehoach_bc', $kehoachtieuchuan->id)
                           // ->where('id_kh_tieuchi', $value->khtt_id)
                           ->where('id_tieuchi', $value->id)
                           ->first();
               $bacao_menhde = DB::table('kehoach_menhde')
                                   ->select('kehoach_menhde.id as id_khmd', 'menhde.*')
                                   ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                   ->where('menhde.tieuchi_id',$value->id)
                                   ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                   ->get();

               $menhde_baocao = DB::table('baocao_menhde')
                          ->select('menhde.id as menhde_id', 'menhde.mo_ta','menhde.*', 'baocao_menhde.*')
                          ->leftjoin('menhde','menhde.id','=','baocao_menhde.id_menhde')
                          ->where('id_kehoach_bc',$kehoachtieuchuan->id)
                          ->where('menhde.tieuchi_id',$value->id)
                          // ->where('id_kh_menhde',$val->id_khmd)
                               ->get();
               $kh_menhde_start = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.id as id_khmd', 'menhde.id')
                                        ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                        ->where('menhde.tieuchi_id',$value->id)
                                        ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                        ->first();
               if(isset($kh_menhde_start->id_khmd)){
                    $menhde_baocao_start = DB::table('baocao_menhde')
                                         ->select('danhgia')
                                         ->where('id_kehoach_bc',$kehoachtieuchuan->id)
                                         ->where('id_kh_menhde',$kh_menhde_start->id_khmd)
                                         ->where('id_menhde',$kh_menhde_start->id)
                                         ->first();
               }                      
               
               $value->bc_menhde = $menhde_baocao;
               $value->menhde_baocao_start = $menhde_baocao_start;
               $value->baocao_tieuchi = $baocao;
               $value->bacao_menhde = $menhde_baocao;
               array_push($start,$value->menhde_baocao_start->danhgia);
              
          }
          $sum_start = Collection::make($start)->avg();
          $sum_danhgia = round($sum_start);

          $kehoachtieuchuan->tieuchi = $tieuchi; 

          $danhGiaMenhDeData = [];
          $danhGiaTieuChiData = [];
          foreach($kehoachtieuchuan->tieuchi as $value){
               $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('menhde.id as id_md', 'kehoach_menhde.*','kehoach_tieuchi.id_tieuchi')
                                        ->leftjoin('menhde','menhde.id','=','kehoach_menhde.id_menhde')
                                        ->leftjoin('kehoach_tieuchi','kehoach_tieuchi.id','=','kehoach_menhde.id_kh_tieuchi')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$value->khtt_id)
                                        ->get();
               foreach($keHoachMenhDeList as $keHoachMenhDe){
                    if($keHoachMenhDe){
                       $baoCaoMenhDe =  DB::table('baocao_menhde')
                                             ->where('id_kehoach_bc',$id_khbc)
                                             ->where('id_menhde',$keHoachMenhDe->id_md)->first();
                    }
                    if($baoCaoMenhDe){
                          $danhGiaMenhDeData[$keHoachMenhDe->id_tieuchi][] = $baoCaoMenhDe->danhgia;
                    }
               }

          }

          foreach ($danhGiaMenhDeData as $tieuChiId => $danhGiaMenhDe) {
                $danhGiaTieuChiData[$tieuChiId] = round(collect($danhGiaMenhDe)->avg());
            };

         
         $KHBaoCao = DB::table('kehoach_baocao')->where('kehoach_baocao.id', '=', $id_khbc)->select('kehoach_baocao.ten_bc')->get();
         $tieuChuan = DB::table('tieuchuan')->where('tieuchuan.id', $tieuchuan_id)->first();

         $baoCaoTieuChuan = DB::table('baocao_tieuchuan')->where([
                ['id_kehoach_bc', '=', $id_khbc],
                ['id_tieuchuan', '=', $tieuchuan_id],
            ])->orderBy('created_at', 'desc')->first();

         $nhanxetbc = DB::table('baocao_nhanxet')
                         ->where([
                              ['id_kehoach_bc', '=', $id_khbc],
                              ['id_tieuchuan', '=', $tieuchuan_id],
                              ['nguoi_tao', '=', $userId],
                         ])->get();
          foreach($nhanxetbc as $valuenx){
               $valuenx->user = DB::table('users')
                                   ->select('users.name','donvi.ten_donvi')
                                   ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                   ->where('users.id',$valuenx->nguoi_tao)
                                   ->first();
          }                    
         $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')
                                ->leftjoin('users','users.id','=','baocao_nhanxetkhoi.nguoi_tao')
                                ->where('id_kehoach_bc',$id_khbc)
                                ->get();
          foreach($nhanXetKhoiList as $value){
               $name_dv = DB::table('donvi')
                              ->where('id',$value->donvi_id)->first();
               $value->tendonvi = $name_dv;
          }

          $Forward = null;

          $continue_nx = DB::table('kehoach_baocao')
                              ->select('tieuchuan.id')
                              ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                              ->leftjoin('tieuchuan','tieuchuan.bo_tieuchuan_id','=','bo_tieuchuan.id')
                              ->where('kehoach_baocao.id',$id_khbc)
                              ->get();
         foreach($continue_nx as $tieu_c_val){
               
                    $baoc_tc = DB::table('baocao_tieuchuan')
                              ->where('id_kehoach_bc',$id_khbc)
                              ->where('id_tieuchuan',$tieu_c_val->id)
                              ->first();
                    if($baoc_tc){
                         if($baoc_tc->trang_thai == 'congbo'){
                              if($tieu_c_val->id > $tieuchuan_id){
                                   $Forward = $tieu_c_val->id;
                                   break;
                              }
                         }
                     

                    }
                                   
         }
         $donViData = DB::table('donvi')->get();
         return view("admin.project.Selfassessment.viewreport")
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
                        "danhGiaTieuChiData" => $danhGiaTieuChiData,
                        "nhanXetKhoiList" => $nhanXetKhoiList,
                        "userId" => $userId,
                        "sum_danhgia" => $sum_danhgia,
                        "Forward" => $Forward,
                    ]);
     }

    public function createComment(Request $req)
    {
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

            if (!$req->has("text") || $req->text == "") {
                  return abort(422, Lang::get('project/Selfassessment/title.vlnnd'));
            }
            $baoCaoChung = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->first();
            if (!$baoCaoChung) {
                  $s = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->insert([
                                     'text' => $req->text,
                                     'id_kehoach_bc' => $KHBaCaoDetail->id,
                                     'id_csdt' => Sentinel::getUser()->id_csdt,
                                ]);
              } else {
                  $baoCaoChung->text = $req->text;
                  $save = DB::table('baocao_chung')->where('baocao_chung.id_kehoach_bc',$KHBaCaoDetail->id)
                                ->where('baocao_chung.id_kh_chung',$keHoachChung->id)->update([
                                                         'text' => $req->text,
                                                    ]);
              }
            return back()->with('success', 
                      Lang::get('project/Selfassessment/title.capnhattc'));
       } catch (\Exception $e) {
         return abort(422, $e->getMessage());
       }
    }

    public function createCommentBlock(Request $req){
          try {
               $KHBaCaoDetail = DB::table('kehoach_baocao')->where('kehoach_baocao.id',$req->id_kehoach_bc)->first();

               if (!$KHBaCaoDetail) return abort(402, 'Không nhận dạng được kế hoạch ' + $req->id_kehoach_bc);

               if ($req->kieu == 'tieuchuan_modau' || $req->kieu == 'tieuchuan_ketluan') {
                $baoCaoTieuChuan = DB::table('baocao_tieuchuan')->where('id',$req->id)->first();
                if (!$baoCaoTieuChuan) return abort(402, 'Không nhận dạng được báo cáo');
               }

               if ($req->kieu == 'menhde_diemmanh' || $req->kieu == 'menhde_tontai') {
                $baoCaoMenhDe = DB::table('baocao_menhde')->where('id',$req->id)->first();
                if (!$baoCaoMenhDe) return abort(402, 'Không nhận dạng được báo cáo');
               }

               if ($req->kieu == 'chung_modau' || $req->kieu == 'chung_ketluan') {
                $baoCaoChung = DB::table('baocao_chung')->where('id',$req->id)->first();
                if (!$baoCaoChung) return abort(402, 'Không nhận dạng được báo cáo');
               }

               $nhanXetKhoi = array(
                    'id_kehoach_bc'     => $req->id_kehoach_bc,

               );

               if ($req->kieu == 'tieuchuan_modau' || $req->kieu == 'tieuchuan_ketluan') {
                    $nhanXetKhoi['id_tieuchuan_bc']    = $req->id;
               }

               if ($req->kieu == 'menhde_diemmanh' || $req->kieu == 'menhde_tontai' || $req->kieu == 'menhde_mota') {
                    $nhanXetKhoi['id_menhde_bc']    = $req->id;
               }

               if ($req->kieu == 'chung_modau' || $req->kieu == 'chung_ketluan') {
                    $nhanXetKhoi['id_chung_bc']    = $req->id;
               }

               $nhanXetKhoi['parent'] = $req->parent;
               $nhanXetKhoi['kieu'] = $req->kieu;
               $nhanXetKhoi['nhanxet'] = $req->nhanxet;
               $nhanXetKhoi['nguoi_tao'] = Sentinel::getUser()->id;
               $nhanXetKhoi['id_csdt'] = Sentinel::getUser()->csdt_id;
               $nhanXetKhoi['created_at'] = date('Y-m-d H:i:s');
               $nhanXetKhoi['updated_at'] = date('Y-m-d H:i:s');

               $res = DB::table('baocao_nhanxetkhoi')->insert($nhanXetKhoi);

          } catch (\Exception $e) {
               return abort(422, $e->getMessage());
          }
          return Redirect::back()->with('success',''.Lang::get('project/Selfassessment/title.nxddt').'');
    }
        
    public function nhanXetDelete(Request $request)
    {
        try {
            if (Auth::user()->hasRole(['thuong-truc', 'super-admin'])) {
                $KHBaCaoDetail = KeHoachBaoCao::find($request->kh);
            } else {
                $KHBaCaoDetail = KeHoachBaoCao::where('id', $request->kh)->where(function ($q) {
                    $q->whereHas('nhanSuKiemTraList', function (Builder $query) {
                        $query->where('id', '=', Auth::user()->id);
                    })->orWhere('ns_phutrach', Auth::user()->id)
                        ->orWhere(function ($q2) {
                            $q2->whereHas('keHoachTieuChuanList', function (Builder $q2Sub) {
                                $q2Sub->where('truongnhom', Auth::user()->id);
                            });
                        });;
                })->first();

            }

            if (!$KHBaCaoDetail) return abort(402, 'Không nhận dạng được kế hoạch');

            $nhanXet = Nhanxet::find($request->id);
            $nhanXet->delete();

        } catch (\Exception $e) {
            return abort(422, $e->getMessage());
        }

        $response['success'] = true;
        $response['message'] = "Nhận xét đã được xóa";
        return response()->json($response);
    }

    public function update_nx(Request $req){
          // var_dump($req->nhanxet);
          // die;
        $nhanxet = DB::table('baocao_nhanxet')
               ->insert([
                    "noidung"  => $req->noidung,
                    "nhanxet"  => $req->nhanxet,
                    "id_kehoach_bc"  => $req->kh,
                    "id_tieuchuan"  => $req->tieuchuan_id,
                    "nguoi_tao"  => $req->userId,
                    "created_at"  => Carbon::now('Asia/Ho_Chi_Minh'),
               ]);
       
          return Redirect::back()->with('success',''.Lang::get('project/Selfassessment/title.dtnx').'');
    }

    public function delete_nx(Request $req){
          $nhanxet = DB::table('baocao_nhanxet')
                         ->where('id',$req->id_nx)
                         ->delete();
          return Redirect::back()->with('success',''.Lang::get('project/Selfassessment/title.dxnx').'');
    }

    public function update_comment(Request $req){

          $baotieuchuan = DB::table('baocao_tieuchuan')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_tieuchuan',$req->tieuchuan_id)
                              ->update([
                                   'trang_thai' => 'dangsua',
                              ]);
          $tieuchi = DB::table('tieuchi')
                                   ->where('tieuchuan_id',$req->tieuchuan_id)
                                   ->get();
          foreach($tieuchi as $value){
               $baocatieuchi = DB::table('baocao_tieuchi')
                              ->where('id_kehoach_bc',$req->id_khbc)
                              ->where('id_tieuchi',$value->id)
                              ->update([
                                   'trang_thai' => 'dangsua',
                              ]);
          }

          return Redirect()->route('admin.tudanhgia.commentreport.index');
    }
}