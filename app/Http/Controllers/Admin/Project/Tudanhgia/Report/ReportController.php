<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Report;

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
use App\Exports\DsbctdgExport;

class ReportController extends DefinedController
{

    public function index(Request $req){
        $btc = DB::table("bo_tieuchuan")->select("id", "tieu_de", "loai_tieuchuan")->get();
        $user = DB::table("users")
            ->leftjoin("donvi", "users.donvi_id", "=", "donvi.id")
            ->select("users.id","users.name", "donvi.ten_donvi")->get();
        $ctdtList = DB::table("ctdt")->get();
        return view('admin.project.Selfassessment.index')->with([
            'btc'    => $btc,
            'user'   => $user,
            'ctdtList'  => $ctdtList
        ]);
    }

    public function data(Request $req){
        $users = DB::table('kehoach_baocao')->orderBy("created_at", "desc");
        return DataTables::of($users) 
            ->addColumn(
                'loaibc',
                function ($user) {
                    if($user->loai_tieuchuan == 'csdt')
                        return Lang::get('project/Selfassessment/title.csdt');
                    else
                        return Lang::get('project/Selfassessment/title.ctdt');
                }
            )  
            ->addColumn(
                'ngBd',
                function ($user) {
                    return date("d-m-Y", strtotime($user->ngay_batdau));
                }
            )    
            ->addColumn(
                'ngHt',
                function ($user) {
                    return date("d-m-Y", strtotime($user->ngay_hoanthanh));
                }
            )   
            ->addColumn(
                'ngPhutrach',
                function ($user) {
                    $userName = DB::table("users")
                        ->where("id", $user->ns_phutrach)->select("name")->first();
                    return $userName->name;
                }
            ) 
                      
            ->addColumn(
                'action',
                function ($user) {
                    if(Sentinel::inRole('admin') || Sentinel::inRole('operator') || Sentinel::inRole('ns_phutrach')){
                        $actions =
                                '<a href="'.
                                    route('admin.tudanhgia.report.planning', $user->id) 
                                .'" class="btn" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.lkh').'">'.
                                '<i class="bi bi-gear-fill" style="font-size: 25px;color: #009ef7;"></i>'
                                    .
                               '</a>'.
                                
                               '<a href="'.
                                    route('admin.tudanhgia.report.detail_bc', $user->id) 
                                .'" class="btn" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.lkh').'">'.
                                '<i data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.xembaocao').'" class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>'
                                    .
                               '</a>'
                               ;
                    }else{
                        $actions = '<a href="'.
                                        route('admin.tudanhgia.report.detail_bc', $user->id) 
                                    .'" class="btn" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.lkh').'">'.
                                    '<i data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.xembaocao').'" class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>'
                                        .
                                   '</a>';
                    }
                    
                    return $actions;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    public function planning(Request $req){
        $id = $req->id;
        $khbc = DB::table('kehoach_baocao')->where("id", $id)->first();
        
        if(!$khbc){
            return Redirect::back()->with('error',"Không tìm thấy dữ liệu");
        }

        $listTc = DB::table("tieuchuan")                        
            ->where('bo_tieuchuan_id',$khbc->bo_tieuchuan_id)
            ->orderBy('stt')
            ->get();
        
        foreach ($listTc as $key => $value) {
            $value->tieuchi = DB::table('tieuchi')->where('tieuchuan_id',$value->id)->get();
            foreach ($value->tieuchi as $key1 => $value1) {
                if($khbc->writeFollow == 1){
                    $value1->menhde = DB::table('menhde')->where('tieuchi_id',$value1->id)->get();
                }else{
                    $value1->menhde = DB::table('mocchuan')
                                        ->where('tieuchi_id',$value1->id)
                                        // ->where('bo_tieuchuan_id',$khbc->bo_tieuchuan_id)
                                        ->get();
                }
                
                
            }
        }



        $keHoachChung = DB::table("kehoach_chung")->where("kh_baocao_id", $id)->first();

        $keHoachBaoCao = DB::table("kehoach_baocao")
                            ->select("kehoach_baocao.*")
                            ->leftjoin("kehoach_baocao_nhansu","kehoach_baocao_nhansu.id_kehoach","=","kehoach_baocao.id")
                            ->where("kehoach_baocao.id", $id)
                            ->first();
        $user = DB::table('users')
                    ->select('users.*')
                    ->where('users.id',$keHoachBaoCao->id)
                    ->get();
        $keHoachBaoCao->ngay_batdau = $this->toShowDate($keHoachBaoCao->ngay_batdau);
        $keHoachBaoCao->ngay_hoanthanh = $this->toShowDate($keHoachBaoCao->ngay_hoanthanh);
        $keHoachBaoCao->ngay_batdau_chuanbi = $this->toShowDate($keHoachBaoCao->ngay_batdau_chuanbi);
        $keHoachBaoCao->ngay_hoanthanh_chuanbi = $this->toShowDate($keHoachBaoCao->ngay_hoanthanh_chuanbi);
        
        if($keHoachChung){
            $keHoachChung->ngay_batdau = $this->toShowDate($keHoachChung->ngay_batdau);
            $keHoachChung->ngay_hoanthanh = $this->toShowDate($keHoachChung->ngay_hoanthanh);
        }
        

        if (!$keHoachChung) {
            $data = [
                'kh_baocao_id'  => $id,
                'nguoi_tao'     => $keHoachBaoCao->nguoi_tao,
                'csdt_id'       => $keHoachBaoCao->csdt_id
            ];
            DB::table("kehoach_chung")->insert($data);
        }

        return view('admin.project.Selfassessment.plandetail')->with([
            'khbc'  => $khbc,
            'listTc'    => $listTc,
            'keHoachChung'  => $keHoachChung,
            'keHoachBaoCao' => $keHoachBaoCao,
            'user' => $user,
            'id_kehoach_bc' => $id,
        ]);
    }

    public function upadate_kq(Request $req){

        $date1  = Carbon::parse($req->ngay_batdau_chung);
        $date2  = Carbon::parse($req->ngay_hoanthanh_chung);

        $keHoachChung = DB::table("kehoach_chung")->where("kh_baocao_id", $req->id_khbc)->first();

         if (!$keHoachChung) {
            return 0;
        }

        if($date1->gt($date2)){
           return 0;
        }

        $save = DB::table("kehoach_chung")
                    ->where("kh_baocao_id", $req->id_khbc)
                    ->update([
                        "ngay_batdau" => $this->toDBDate($req->ngay_batdau_chung),
                        "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_chung),
                    ]);
        return 1;
    }

    public function upadate_tieuchuan(Request $req){
        if(!$req->nhansuchuanbi || !$req->nhansuthuchien || !$req->nhansukiemtra){
            return 0;
        };
        $nhansuchuanbi = explode(',',$req->nhansuchuanbi);
        $nhansuthuchien = explode(',',$req->nhansuthuchien);
        $nhansukiemtra = explode(',',$req->nhansukiemtra);

        $date1  = Carbon::parse($req->ngay_chuanbi);
        $date2  = Carbon::parse($req->ngay_hoanthanh);
        $date3  = Carbon::parse($req->ngay_batdau_vbc);
        $date4  = Carbon::parse($req->ngay_hoanthanh_vbc);

        if($date1->gt($date2)){
           return 0;
        }
        
        if($date3->gt($date4)){
           return 0;
        }

        if(!$date1 || !$date2 || !$date3 || !$date4 || !$req->truong_nhom){
            return 0;
        }
        $data = [
                    "ngay_batdau_chuanbi" => $this->toDBDate($req->ngay_chuanbi),
                    "ngay_hoanthanh_chuanbi" => $this->toDBDate($req->ngay_hoanthanh),
                    "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc),
                    "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc),
                    "truongnhom" => $req->truong_nhom,
                    "updated_at" => date('Y-m-d H:i:s'),

                ];
        $kehoachbaocao = DB::table('kehoach_baocao')
                            ->where('id',$req->id_khbc)
                            ->first();
        $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                            ->where('id_kh_baocao', $req->id_khbc)
                            ->where('tieuchuan_id', $req->id_tieuchuan);
        
        $check = $kh_tieuchuan->first();
        $id_khtieuchuan = 0;
        if($check){
            $save = $kh_tieuchuan->update($data);
            $id_khtieuchuan = $check->id;

        }else{

            $data['id_kh_baocao'] = $req->id_khbc;
            $data['tieuchuan_id'] = $req->id_tieuchuan;
            
            $id_khtieuchuan = DB::table('kehoach_tieuchuan')->insertGetId($data);
            // $baocaotieuchan = DB::table('baocao_tieuchuan')
            //                     ->insert([
            //                         'id_kehoach_bc' => $req->id_khbc,
            //                         'id_kh_tieuchuan' => $id_khtieuchuan,
            //                         'id_tieuchuan' => $req->id_tieuchuan,
            //                     ]);
           $tieuchi_id2 = DB::table("tieuchi")
                ->where("tieuchuan_id", $req->id_tieuchuan)->pluck("id");

            foreach($tieuchi_id2 as $value2){
               $kehoach_tchi = DB::table("kehoach_tieuchi")->insertGetId([
                     'id_kh_tieuchuan'    => $id_khtieuchuan,
                     'id_tieuchi'    => $value2,
                     'id_csdt'         => Sentinel::getUser()->csdt_id,
                     'nguoi_tao'       => Sentinel::getUser()->id,
                     'truongnhom'    => $req->truong_nhom,

               ]);
                $save_bctc = DB::table("baocao_tieuchi")
                                    ->insert([
                                            'id_kehoach_bc' => $req->id_khbc,
                                            'id_tieuchi' => $value2,
                                    ]);   
               if($kehoachbaocao->writeFollow == 1){

                    $menhde_s = DB::table("menhde")
                                    ->where("tieuchi_id",$value2)->pluck("id");
                    foreach($menhde_s as $value3){
                        $kehoach_mde = DB::table("kehoach_menhde")->insertGetId([
                             'id_kh_tieuchi'    => $kehoach_tchi,
                             'id_menhde'        => $value3,
                             'id_csdt'         => Sentinel::getUser()->csdt_id,
                             'nguoi_tao'       => Sentinel::getUser()->id,
                          ]);

                        DB::table('baocao_menhde')->insert([
                            'id_kehoach_bc' =>    $req->id_khbc,
                            'id_kh_menhde' =>     $kehoach_mde,
                            'id_menhde' =>    $value3,

                         ]);
                    }
                    
               }else if($kehoachbaocao->writeFollow == 2){
                    
                   // $save_menhde = DB::table('mocchuan')
                   //          ->insertGetId([
                   //              'tieuchi_id' => $value2,
                   //          ]);
                   // $save_bcmd = DB::table('baocao_menhde')->insert([
                   //      'id_kehoach_bc' => $req->id_khbc,
                   //      'mocchuan_id' => $save_menhde,
                   //  ]);

                   //  $save_bctc = DB::table("baocao_tieuchi")
                   //                  ->insert([
                   //                          'id_kehoach_bc' => $req->id_khbc,
                   //                          'id_tieuchi' => $value2,
                   //                  ]);
                   // $menhde_id = DB::table("mocchuan")->where("tieuchi_id", $value2)->pluck("id");
                   // foreach($menhde_id as $value3){
                   //        $kehoach_mde = DB::table("kehoach_menhde")->insertGetId([
                   //           'id_kh_tieuchi'    => $kehoach_tchi,
                   //           'mocchuan_id'    => $value3,
                   //           'id_csdt'         => Sentinel::getUser()->csdt_id,
                   //           'nguoi_tao'       => Sentinel::getUser()->id,
                   //        ]);

                   //       DB::table('baocao_menhde')->insert([
                   //          'id_kehoach_bc' =>    $req->id_khbc,
                   //          'id_kh_menhde' =>     $kehoach_mde,
                   //          'mocchuan_id' =>    $value3,

                   //       ]);
                   //  }

                    
                    $menhde_s = DB::table("mocchuan")
                                    ->where("tieuchi_id",$value2)->pluck("id");
                    foreach($menhde_s as $value3){
                        $kehoach_mde = DB::table("kehoach_menhde")->insertGetId([
                             'id_kh_tieuchi'    => $kehoach_tchi,
                             'mocchuan_id'    => $value3,
                             'id_csdt'         => Sentinel::getUser()->csdt_id,
                             'nguoi_tao'       => Sentinel::getUser()->id,
                          ]);

                        DB::table('baocao_menhde')->insert([
                            'id_kehoach_bc' =>    $req->id_khbc,
                            'id_kh_menhde' =>     $kehoach_mde,
                            'mocchuan_id' =>    $value3,

                         ]);
                    }
               }
               

            }
          
            
               

        }

        // update nhan su
        if($id_khtieuchuan != 0){
            // xoa nhan su
            $del = DB::table('kehoach_tieuchuan_nhansu')->where('id_kehoach',$id_khtieuchuan)->whereNotNull('id_nhansuchuanbi')->delete();

            $del2 = DB::table('kehoach_tieuchuan_nhansu')->where('id_kehoach',$id_khtieuchuan)->whereNotNull('id_nhansuthuchien')->delete();

            $del3 = DB::table('kehoach_tieuchuan_nhansu')->where('id_kehoach',$id_khtieuchuan)->whereNotNull('id_nhansukiemtra')->delete();

            foreach ($nhansuchuanbi as $key => $value) {
                $res = DB::table('kehoach_tieuchuan_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchuan,
                    'id_nhansuchuanbi'  => $value,
                ]);
            }

            foreach ($nhansuthuchien as $key2 => $value2) {
                $res1 = DB::table('kehoach_tieuchuan_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchuan,
                    'id_nhansuthuchien'  => $value2,
                ]);
            }

            foreach ($nhansukiemtra as $key3 => $value3) {
                $res2 = DB::table('kehoach_tieuchuan_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchuan,
                    'id_nhansukiemtra'  => $value3,
                ]);
            }
        }


        if(!$req->option && $req->option == 0){
            return 1;
        }else{

            $tieuchi_id = DB::table('tieuchi')
                            ->where('tieuchuan_id',$req->id_tieuchuan)
                            ->get();
                         
            $kh_tchuan_id = 0;
            $kh_tieuchuan = $kh_tieuchuan->first();
            if($kh_tieuchuan){
                $kh_tchuan_id = $kh_tieuchuan->id;
            }
            $data_tieuchi = [
                    "ngay_batdau_chuanbi" => $this->toDBDate($req->ngay_chuanbi),
                    "ngay_hoanthanh_chuanbi" => $this->toDBDate($req->ngay_hoanthanh),
                    "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc),
                    "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc),
                    "updated_at" => date('Y-m-d H:i:s'),

            ];

            $data_menhde = [
                    "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc),
                    "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc),
                    "updated_at" => date('Y-m-d H:i:s'),
            ];  
            foreach($tieuchi_id as $value){
                $save_all_tieuchi = DB::table('kehoach_tieuchi')
                                ->where('id_kh_tieuchuan',$kh_tchuan_id)
                                ->where('id_tieuchi',$value->id);

            
                $check_tieuchi = $save_all_tieuchi->first();
                if($check_tieuchi){
                    $save = $save_all_tieuchi->update($data_tieuchi);                  
                }else{
                    $data['id_kh_tieuchuan'] = $kh_tchuan_id;
                    $data['id_tieuchi'] = $value->id;
                    $save = DB::table('kehoach_tieuchi')->insert($data_tieuchi);
                }
                

                $id_kh_tieuchi = DB::table('kehoach_tieuchi')
                                ->where('kehoach_tieuchi.id_kh_tieuchuan',$kh_tchuan_id)
                                ->where('kehoach_tieuchi.id_tieuchi',$value->id)
                                ->get();


                foreach($id_kh_tieuchi as $value_khtc){

                    if($kehoachbaocao->writeFollow == 1){
                        $menhde = DB::table('menhde')
                                ->where('tieuchi_id',$value->id)->get();    
                        foreach($menhde as $value_md){
                            $save_kh_menhde = DB::table('kehoach_menhde')
                                                ->where('id_kh_tieuchi',$value_khtc->id)        
                                                ->where('id_menhde',$value_md->id); 

                            $check_menhde = $save_kh_menhde->first();
                            if($check_menhde){
                                $save = $save_kh_menhde->update($data_menhde); 
                            }else{
                                $data['id_kh_tieuchi'] = $value_khtc->id;
                                $data['id_menhde'] = $value_md->id;
                                $save = DB::table('kehoach_menhde')->insert($data_menhde);
                            } 
                                 
                        }
                    }else if($kehoachbaocao->writeFollow == 2){
                        $menhde = DB::table('mocchuan')
                                ->where('tieuchi_id',$value->id)->get();    
                        foreach($menhde as $value_md){
                            $save_kh_menhde = DB::table('kehoach_menhde')
                                                ->where('id_kh_tieuchi',$value_khtc->id)        
                                                ->where('mocchuan_id',$value_md->id); 

                            $check_menhde = $save_kh_menhde->first();
                            if($check_menhde){
                                $save = $save_kh_menhde->update($data_menhde); 
                            }else{
                                $data['id_kh_tieuchi'] = $value_khtc->id;
                                $data['mocchuan_id'] = $value_md->id;
                                $save = DB::table('kehoach_menhde')->insert($data_menhde);
                            } 
                                 
                        }
                    }
                    

                }

            } 
        }

        return 1;
        
    }


    public function upadate_tieuchi(Request $req){
        $keHoachBaoCao = DB::table('kehoach_baocao')
                            ->where('id',$req->id_khbc)
                            ->first();
        if(!$req->nhansuchuanbi || !$req->nhansuthuchien || !$req->nhansukiemtra){
            return 0;
        };
        $nhansuchuanbi = explode(',',$req->nhansuchuanbi);
        $nhansuthuchien = explode(',',$req->nhansuthuchien);
        $nhansukiemtra = explode(',',$req->nhansukiemtra);

        $date1  = Carbon::parse($req->ngay_chuanbi_tchi);
        $date2  = Carbon::parse($req->ngay_hoanthanh_tchi);
        $date3  = Carbon::parse($req->ngay_batdau_vbc_tchi);
        $date4  = Carbon::parse($req->ngay_hoanthanh_vbc_tchi);

        if($date1->gt($date2)){
           return 0;
        }
        
        if($date3->gt($date4)){
           return 0;
        }

        if(!$date1 || !$date2 || !$date3 || !$date4 || !$req->truong_nhom){
            return 0;
        }
        $data = [
                    "ngay_batdau_chuanbi" => $this->toDBDate($req->ngay_chuanbi_tchi),
                    "ngay_hoanthanh_chuanbi" => $this->toDBDate($req->ngay_hoanthanh_tchi),
                    "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc_tchi),
                    "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc_tchi),
                    "truongnhom" => $req->truong_nhom,
                    "updated_at" => date('Y-m-d H:i:s'),

                ];

        $id_khtieuchi = 0;

        $kh_tieuchi = DB::table('kehoach_tieuchi')
                            ->where('id_kh_tieuchuan', $req->id_kh_tieuchuan)
                            ->where('id_tieuchi', $req->id_tieuchi);
        $check = $kh_tieuchi->first();
        if($check){
            $save = $kh_tieuchi->update($data);     
            $id_khtieuchi = $check->id;               
        }else{
            $data['id_kh_tieuchuan'] = $req->id_kh_tieuchuan;
            $data['id_tieuchi'] = $req->id_tieuchi;
            $id_khtieuchi = DB::table('kehoach_tieuchi')->insertGetId($data);
        }
        // update nhan su
        if($id_khtieuchi != 0){
            // xoa nhan su

            $del = DB::table('kehoach_tieuchi_nhansu')->where('id_kehoach',$id_khtieuchi)->delete();

            foreach ($nhansuchuanbi as $key => $value) {
                $res = DB::table('kehoach_tieuchi_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchi,
                    'id_nhansuchuanbi'  => $value,
                ]);
            }

            foreach ($nhansuthuchien as $key => $value) {
                $res1 = DB::table('kehoach_tieuchi_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchi,
                    'id_nhansuthuchien'  => $value,
                ]);
            }

            foreach ($nhansukiemtra as $key => $value) {
                $res2 = DB::table('kehoach_tieuchi_nhansu')->insert([
                    'id_kehoach'    => $id_khtieuchi,
                    'id_nhansukiemtra'  => $value,
                ]);
            }
        }


        if(!$req->option && $req->option == 0){

            return 1;
        }else{
            if($keHoachBaoCao->writeFollow == 1){
                $menhde = DB::table('menhde')
                ->where('tieuchi_id',$req->id_tieuchi)->get();
                         
                $data_menhde = [
                        "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc_tchi),
                        "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc_tchi),
                        "updated_at" => date('Y-m-d H:i:s'),
                ];

                foreach($menhde as $value_md){
                    $save_kh_menhde = DB::table('kehoach_menhde')
                                        ->where('id_kh_tieuchi',$check->id)        
                                        ->where('id_menhde',$value_md->id); 

                    $check_menhde = $save_kh_menhde->first();
                    if($check_menhde){
                        $save = $save_kh_menhde->update($data_menhde); 
                    }else{
                        $data['id_kh_tieuchi'] = $check->id;
                        $data['id_menhde'] = $value_md->id;
                        $save = DB::table('kehoach_menhde')->insert($data_menhde);
                    } 
                         
                } 
            }else if($keHoachBaoCao->writeFollow == 2){
                $menhde = DB::table('mocchuan')
                ->where('tieuchi_id',$req->id_tieuchi)->get();
                         
                $data_menhde = [
                        "ngay_batdau" => $this->toDBDate($req->ngay_batdau_vbc_tchi),
                        "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh_vbc_tchi),
                        "updated_at" => date('Y-m-d H:i:s'),
                ];

                foreach($menhde as $value_md){
                    $save_kh_menhde = DB::table('kehoach_menhde')
                                        ->where('id_kh_tieuchi',$check->id)        
                                        ->where('mocchuan_id',$value_md->id); 

                    $check_menhde = $save_kh_menhde->first();
                    if($check_menhde){
                        $save = $save_kh_menhde->update($data_menhde); 
                    }else{
                        $data['id_kh_tieuchi'] = $check->id;
                        $data['mocchuan_id'] = $value_md->id;
                        $save = DB::table('kehoach_menhde')->insert($data_menhde);
                    } 
                         
                }
            }
            
            
        }

        return 1;
    }

    public function upadate_menhde(Request $req){
        if(!$req->nhansuthuchien || !$req->nhansukiemtra){
            return 0;
        };
        $nhansuthuchien = explode(',',$req->nhansuthuchien);
        $nhansukiemtra = explode(',',$req->nhansukiemtra);
        $date1  = Carbon::parse($req->ngay_batdau);
        $date2  = Carbon::parse($req->ngay_hoanthanh);

        if($date1->gt($date2)){
           return 0;
        }

        if(!$date1 || !$date2){
            return 0;
        }

        $data = [
                    "ngay_batdau" => $this->toDBDate($req->ngay_batdau),
                    "ngay_hoanthanh" => $this->toDBDate($req->ngay_hoanthanh),
                    "updated_at" => date('Y-m-d H:i:s'),

                ];
        $kehoachbaocao = DB::table('kehoach_baocao')
                            ->where('id',$req->id_khbc)
                            ->first();
        if($kehoachbaocao->writeFollow == 1){
            $id_khmenhde = 0;

            $kehoach_menhde = DB::table('kehoach_menhde')
                                ->where('id_kh_tieuchi',$req->id_kh_tieuchi)        
                                ->where('id_menhde',$req->menhde_id);
            $check = $kehoach_menhde->first();
            if($check){
                $save = $kehoach_menhde->update($data);
                $id_khmenhde = $check->id; 
            }else{
                $data['id_kh_tieuchi'] = $req->id_kh_tieuchi;
                $data['id_menhde'] = $req->menhde_id;
                $id_khmenhde = DB::table('kehoach_menhde')->insertGetId($data);
            } 

            // update nhan su
            if($id_khmenhde != 0){
                // xoa nhan su

                $del = DB::table('kehoach_menhde_nhansu')->where('id_kehoach',$id_khmenhde)->delete();

                foreach ($nhansuthuchien as $key => $value) {
                    $res1 = DB::table('kehoach_menhde_nhansu')->insert([
                        'id_kehoach'    => $id_khmenhde,
                        'id_nhansuthuchien'  => $value,
                    ]);
                }

                foreach ($nhansukiemtra as $key => $value) {
                    $res2 = DB::table('kehoach_menhde_nhansu')->insert([
                        'id_kehoach'    => $id_khmenhde,
                        'id_nhansukiemtra'  => $value,
                    ]);
                }
            } 
        }else{
            $id_khmenhde = 0;

            $kehoach_menhde = DB::table('kehoach_menhde')
                                ->where('id_kh_tieuchi',$req->id_kh_tieuchi)        
                                ->where('mocchuan_id',$req->menhde_id);
            $check = $kehoach_menhde->first();
            if($check){
                $save = $kehoach_menhde->update($data);
                $id_khmenhde = $check->id; 
            }else{
                $data['id_kh_tieuchi'] = $req->id_kh_tieuchi;
                $data['mocchuan_id'] = $req->menhde_id;
                $id_khmenhde = DB::table('kehoach_menhde')->insertGetId($data);
            } 

            // update nhan su
            if($id_khmenhde != 0){
                // xoa nhan su

                $del = DB::table('kehoach_menhde_nhansu')->where('id_kehoach',$id_khmenhde)->delete();

                foreach ($nhansuthuchien as $key => $value) {
                    $res1 = DB::table('kehoach_menhde_nhansu')->insert([
                        'id_kehoach'    => $id_khmenhde,
                        'id_nhansuthuchien'  => $value,
                    ]);
                }

                foreach ($nhansukiemtra as $key => $value) {
                    $res2 = DB::table('kehoach_menhde_nhansu')->insert([
                        'id_kehoach'    => $id_khmenhde,
                        'id_nhansukiemtra'  => $value,
                    ]);
                }
            }     
        }

        return 1;
        
    }

    public function star_tieuchuan(Request $req){
        $khbc_id = $req->id;
        $keHoachBaoCao = DB::table("kehoach_baocao")
                            ->where("id",$req->id)
                            ->first();
        $botieuchuan = $req->botieuchuan;
        $listTc = DB::table("tieuchuan")                        
            ->where('bo_tieuchuan_id',$botieuchuan)
            ->get();
        
        $liststartieuchuan = array();
        $liststartieuchi = array();
        $liststarmenhde = array();

        foreach ($listTc as $key => $value) {
            $liststartieuchuan[$value->id] = 0;
            $tieuchi = DB::table('tieuchi')->where('tieuchuan_id',$value->id)->get();
            foreach ($tieuchi as $key1 => $value1) {
                $liststartieuchi[$value1->id] = 0;
                // if($keHoachBaoCao->writeFollow == 1){
                //     $menhde = DB::table('menhde')->where('tieuchi_id',$value1->id)->get();
                // }else{
                //     $menhde = DB::table('mocchuan')
                //                 ->where('tieuchi_id',$value1->id)
                //                 ->where('bo_tieuchuan_id',$req->botieuchuan)
                //                 ->get();
                // }
                if($keHoachBaoCao->writeFollow == 1){
                    $menhde = DB::table('menhde')->where('tieuchi_id',$value1->id)->get();
                }else{
                    $menhde = DB::table('mocchuan')->where('tieuchi_id',$value1->id)->get();

                }
                
                foreach ($menhde as $key2 => $value2) {
                    $liststarmenhde[$value2->id] = 0;
                }
            }
        }

        $tieuchuan = DB::table('kehoach_tieuchuan')
                ->where('id_kh_baocao',$khbc_id)->get();
        foreach($tieuchuan as $value){
            $liststartieuchuan[$value->tieuchuan_id] = 1;
            $tieuchi = DB::table('kehoach_tieuchi')
                ->where('id_kh_tieuchuan',$value->id)->get();
            foreach ($tieuchi as $key1 => $value1) {
                $liststartieuchi[$value1->id_tieuchi] = 1;
                $menhde = DB::table('kehoach_menhde')
                    ->where('id_kh_tieuchi',$value1->id)->get();
                foreach ($menhde as $key2 => $value2) {
                    if($keHoachBaoCao->writeFollow == 1){
                        $liststarmenhde[$value2->id_menhde] = 1; 
                    }else{
                        $liststarmenhde[$value2->mocchuan_id] = 1;
                    }
                    
                }
            }            
        }
        $listtieuchuan = array();
        foreach ($liststartieuchuan as $key => $value) {
            array_push($listtieuchuan, array($key,$value));
        }

        $listtieuchi = array();
        foreach ($liststartieuchi as $key => $value) {
            array_push($listtieuchi, array($key,$value));
        }

        $listmenhde = array();
        foreach ($liststarmenhde as $key => $value) {
            array_push($listmenhde, array($key,$value));
        }

        return array($listtieuchuan,$listtieuchi,$listmenhde);
    }


    function datadetail(Request $req){
            $khbc_id = $req->khbc_id;
            if($khbc_id <= 0){
                return 0;
            }

            $tieuchuan_id = $req->tieuchuan_id;
            $kh_tieuchuan_id = $req->kh_tieuchuan_id;
            
            $tieuchi_id = $req->tieuchi_id;
            $kh_tieuchi_id = $req->kh_tieuchi_id;

            $menhde_id = $req->menhde_id;

            $keHoachBaoCao = DB::table('kehoach_baocao')
                                ->where('id',$khbc_id)
                                ->first();
            // var_dump($tieuchuan_id);
            if(isset($tieuchuan_id) && $tieuchuan_id > 0){

                $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                            ->where('id_kh_baocao',$khbc_id)
                            ->where('tieuchuan_id',$tieuchuan_id)->first();
                if(!$kh_tieuchuan){
                    $kh_tieuchuan = DB::table('kehoach_baocao')
                                    // ->select('tieuchuan.id as id_tieuchuan')
                                    // ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                                    // ->leftjoin('tieuchuan','tieuchuan.bo_tieuchuan_id','=','bo_tieuchuan.id')
                                    ->where('kehoach_baocao.id',$req->khbc_id)
                                    ->first();

                    if($kh_tieuchuan){
                        $kh_tieuchuan->ngay_batdau_chuanbi = null;
                        $kh_tieuchuan->ngay_batdau = null;
                        $kh_tieuchuan->ngay_hoanthanh_chuanbi = null;
                        $kh_tieuchuan->ngay_hoanthanh = null;
                        
                        
                        $kh_tieuchuan->kh_bacao = DB::table('kehoach_baocao_nhansu')
                                                    ->where('kehoach_baocao_nhansu.id_kehoach',$kh_tieuchuan->id)
                                                    ->get();
                        
                        foreach($kh_tieuchuan->kh_bacao as $value){
                            $nhanSuThucHienList = DB::table('users')
                                                    ->select('users.*','donvi.ten_donvi')
                                                    ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                    ->where('users.id',$value->id_nhansuthuchien)
                                                    ->get();

                            $nhanSuKiemTraList = DB::table('users')
                                                    ->select('users.*','donvi.ten_donvi')
                                                    ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                    ->where('users.id',$value->id_nhansukiemtra)
                                                    ->get();

                            $nhanSuChuanBiList = DB::table('users')
                                                    ->select('users.*','donvi.ten_donvi')
                                                    ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                    ->where('users.id',$value->id_nhansuchuanbi)
                                                    ->get();

                            $value->nhanSuThucHienList = $nhanSuThucHienList;
                            $value->nhanSuKiemTraList = $nhanSuKiemTraList;
                            $value->nhanSuChuanBiList = $nhanSuChuanBiList;

                            

                        }

                         return (array) $kh_tieuchuan;
                    }
                }
                if($kh_tieuchuan){
                    $kh_tieuchuan->ngay_batdau_chuanbi = $this->toShowDate($kh_tieuchuan->ngay_batdau_chuanbi);
                    $kh_tieuchuan->ngay_batdau = $this->toShowDate($kh_tieuchuan->ngay_batdau);
                    $kh_tieuchuan->ngay_hoanthanh_chuanbi = $this->toShowDate($kh_tieuchuan->ngay_hoanthanh_chuanbi);
                    $kh_tieuchuan->ngay_hoanthanh = $this->toShowDate($kh_tieuchuan->ngay_hoanthanh);
                    
                    $kh_tieuchuan->kh_bacao = DB::table('kehoach_baocao_nhansu')
                                                ->where('kehoach_baocao_nhansu.id_kehoach',$kh_tieuchuan->id_kh_baocao)
                                                ->get();
                    $kh_tieuchuan->kh_tieuchuan_id = DB::table('kehoach_tieuchuan_nhansu')
                                                        ->where('kehoach_tieuchuan_nhansu.id_kehoach',$kh_tieuchuan->id)
                                                        ->get();
                    foreach($kh_tieuchuan->kh_tieuchuan_id as $val){
                       $nhansuthuchien =  DB::table('users')
                                            ->select('users.id')
                                            ->where('id',$val->id_nhansuthuchien)
                                            ->get();
                        $nhansukiemtra =  DB::table('users')
                                            ->select('users.id')
                                            ->where('id',$val->id_nhansukiemtra)
                                            ->get();
                        $nhansuchuanbi =  DB::table('users')
                                            ->select('users.id')
                                            ->where('id',$val->id_nhansuchuanbi)
                                            ->get();
                       $val->id_nhansuthuchien = $nhansuthuchien; 
                       $val->id_nhansukiemtra = $nhansukiemtra; 
                       $val->id_nhansuchuanbi = $nhansuchuanbi; 
                    }
                    foreach($kh_tieuchuan->kh_bacao as $value){
                        $nhanSuThucHienList = DB::table('users')
                                                ->select('users.*','donvi.ten_donvi')
                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                ->where('users.id',$value->id_nhansuthuchien)
                                                ->get();

                        $nhanSuKiemTraList = DB::table('users')
                                                ->select('users.*','donvi.ten_donvi')
                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                ->where('users.id',$value->id_nhansukiemtra)
                                                ->get();

                        $nhanSuChuanBiList = DB::table('users')
                                                ->select('users.*','donvi.ten_donvi')
                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                ->where('users.id',$value->id_nhansuchuanbi)
                                                ->get();

                        $value->nhanSuThucHienList = $nhanSuThucHienList;
                        $value->nhanSuKiemTraList = $nhanSuKiemTraList;
                        $value->nhanSuChuanBiList = $nhanSuChuanBiList;

                    }
                

                    if(isset($tieuchi_id) && $tieuchi_id > 0){
                        
                        $res = DB::table('kehoach_tieuchi')
                            ->where('id_kh_tieuchuan',$kh_tieuchuan->id)
                            ->where('id_tieuchi',$tieuchi_id)->first();
                        if($res){
                            $res->ngay_batdau_chuanbi = $this->toShowDate($res->ngay_batdau_chuanbi);
                            $res->ngay_batdau = $this->toShowDate($res->ngay_batdau);
                            $res->ngay_hoanthanh_chuanbi = $this->toShowDate($res->ngay_hoanthanh_chuanbi);
                            $res->ngay_hoanthanh = $this->toShowDate($res->ngay_hoanthanh);

                            $res->kh_tieuchuan = $kh_tieuchuan;
                            $res->kh_tieuchi = DB::table('kehoach_tieuchuan_nhansu')
                                                ->where('kehoach_tieuchuan_nhansu.id_kehoach',$res->id_kh_tieuchuan)
                                                ->get();
                            $res->kh_tieuchi_id = DB::table('kehoach_tieuchi_nhansu')
                                                    ->where('kehoach_tieuchi_nhansu.id_kehoach',$res->id)
                                                    ->get();

                            foreach($res->kh_tieuchi_id as $val_tieuchi){
                                $nhansuthuchien_tieuchi =  DB::table('users')
                                                            ->select('users.id')
                                                            ->where('id',$val_tieuchi->id_nhansuthuchien)
                                                            ->get();
                                $nhansukiemtra_tieuchi =  DB::table('users')
                                                            ->select('users.id')
                                                            ->where('id',$val_tieuchi->id_nhansukiemtra)
                                                            ->get();
                                $nhansuchuanbi_tieuchi =  DB::table('users')
                                                            ->select('users.id')
                                                            ->where('id',$val_tieuchi->id_nhansuchuanbi)
                                                            ->get();
                               $val_tieuchi->id_nhansuthuchien = $nhansuthuchien_tieuchi; 
                               $val_tieuchi->id_nhansukiemtra = $nhansukiemtra_tieuchi; 
                               $val_tieuchi->id_nhansuchuanbi = $nhansuchuanbi_tieuchi; 
                            }
                            foreach($res->kh_tieuchi as $value_tchi){
                                $nhanSuThucHienList_tc = DB::table('users')
                                                            ->select('users.*','donvi.ten_donvi')
                                                            ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                            ->where('users.id',$value_tchi->id_nhansuthuchien)
                                                            ->get();

                                $nhanSuKiemTraList_tc = DB::table('users')
                                                            ->select('users.*','donvi.ten_donvi')
                                                            ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                            ->where('users.id',$value_tchi->id_nhansukiemtra)
                                                            ->get();

                                $nhanSuChuanBiList_tc = DB::table('users')
                                                            ->select('users.*','donvi.ten_donvi')
                                                            ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                            ->where('users.id',$value_tchi->id_nhansuchuanbi)
                                                            ->get();

                                $value_tchi->nhanSuThucHienList = $nhanSuThucHienList_tc;
                                $value_tchi->nhanSuKiemTraList = $nhanSuKiemTraList_tc;
                                $value_tchi->nhanSuChuanBiList = $nhanSuChuanBiList_tc;
                            }

                            
                            if(isset($menhde_id) && $req->menhde_id > 0){
                                
                                if($keHoachBaoCao->writeFollow == 1){
                                    $kehoachmenhde = DB::table('kehoach_menhde')
                                                    ->where('kehoach_menhde.id_menhde',$req->menhde_id)
                                                    ->where('kehoach_menhde.id_kh_tieuchi',$res->id)->first();
                                
                                    if($kehoachmenhde){
                                        $kehoachmenhde->ngay_batdau = $this->toShowDate($kehoachmenhde->ngay_batdau);
                                        $kehoachmenhde->ngay_hoanthanh = $this->toShowDate($kehoachmenhde->ngay_hoanthanh);
                                        $kehoachmenhde->ke_hoach_tieuchi = $res;

                                        $kehoachmenhde->ke_hoach_bcns = DB::table('kehoach_tieuchi_nhansu')
                                                                            ->where('id_kehoach',$kehoachmenhde->id_kh_tieuchi)
                                                                            ->get();
                                        $kehoachmenhde->kh_menhde_id = DB::table('kehoach_menhde_nhansu')
                                                                        ->where('kehoach_menhde_nhansu.id_kehoach',$kehoachmenhde->id)
                                                                        ->get();

                                        foreach($kehoachmenhde->kh_menhde_id as $val_menhde){
                                            $nhansuthuchien_menhde =  DB::table('users')
                                                                        ->select('users.id')
                                                                        ->where('id',$val_menhde->id_nhansuthuchien)
                                                                        ->get();
                                            $nhansukiemtra_menhde =  DB::table('users')
                                                                        ->select('users.id')
                                                                        ->where('id',$val_menhde->id_nhansukiemtra)
                                                                        ->get();

                                           $val_menhde->id_nhansuthuchien = $nhansuthuchien_menhde; 
                                           $val_menhde->id_nhansukiemtra = $nhansukiemtra_menhde; 
                                        }

                                        foreach($kehoachmenhde->ke_hoach_bcns as $value_bcns_md){
                                            $nhanSuThucHienList_md = DB::table('users')
                                                                ->select('users.*','donvi.ten_donvi')
                                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                ->where('users.id',$value_bcns_md->id_nhansuthuchien)
                                                                ->get();

                                            $nhanSuKiemTraList_md = DB::table('users')
                                                                ->select('users.*','donvi.ten_donvi')
                                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                ->where('users.id',$value_bcns_md->id_nhansukiemtra)
                                                                ->get();

                                            $value_bcns_md->nhanSuThucHienList = $nhanSuThucHienList_md;
                                            $value_bcns_md->nhanSuKiemTraList = $nhanSuKiemTraList_md;

                                        }

                                        return (array)$kehoachmenhde;
                                    }
                                }else{
                                    $kehoachmenhde = DB::table('kehoach_menhde')
                                                    ->where('kehoach_menhde.mocchuan_id',$req->menhde_id)
                                                    ->where('kehoach_menhde.id_kh_tieuchi',$res->id)->first();
                                
                                    if($kehoachmenhde){
                                        $kehoachmenhde->ngay_batdau = $this->toShowDate($kehoachmenhde->ngay_batdau);
                                        $kehoachmenhde->ngay_hoanthanh = $this->toShowDate($kehoachmenhde->ngay_hoanthanh);
                                        $kehoachmenhde->ke_hoach_tieuchi = $res;

                                        $kehoachmenhde->ke_hoach_bcns = DB::table('kehoach_tieuchi_nhansu')
                                                                            ->where('id_kehoach',$kehoachmenhde->id_kh_tieuchi)
                                                                            ->get();
                                        $kehoachmenhde->kh_menhde_id = DB::table('kehoach_menhde_nhansu')
                                                                        ->where('kehoach_menhde_nhansu.id_kehoach',$kehoachmenhde->id)
                                                                        ->get();

                                        foreach($kehoachmenhde->kh_menhde_id as $val_menhde){
                                            $nhansuthuchien_menhde =  DB::table('users')
                                                                        ->select('users.id')
                                                                        ->where('id',$val_menhde->id_nhansuthuchien)
                                                                        ->get();
                                            $nhansukiemtra_menhde =  DB::table('users')
                                                                        ->select('users.id')
                                                                        ->where('id',$val_menhde->id_nhansukiemtra)
                                                                        ->get();

                                           $val_menhde->id_nhansuthuchien = $nhansuthuchien_menhde; 
                                           $val_menhde->id_nhansukiemtra = $nhansukiemtra_menhde; 
                                        }

                                        foreach($kehoachmenhde->ke_hoach_bcns as $value_bcns_md){
                                            $nhanSuThucHienList_md = DB::table('users')
                                                                ->select('users.*','donvi.ten_donvi')
                                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                ->where('users.id',$value_bcns_md->id_nhansuthuchien)
                                                                ->get();

                                            $nhanSuKiemTraList_md = DB::table('users')
                                                                ->select('users.*','donvi.ten_donvi')
                                                                ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                ->where('users.id',$value_bcns_md->id_nhansukiemtra)
                                                                ->get();

                                            $value_bcns_md->nhanSuThucHienList = $nhanSuThucHienList_md;
                                            $value_bcns_md->nhanSuKiemTraList = $nhanSuKiemTraList_md;

                                        }

                                        return (array)$kehoachmenhde;
                                    }
                                }
                                

                            }

                            return (array) $res;
                        }

                    }
                }
                return (array) $kh_tieuchuan;
            }

            return 0;

        }
        
    public function dsbctdg(){
        return Excel::download(new DsbctdgExport(), 'dsbctdg.xlsx');
    }

    public function detail_bc(Request $req){
        $kehoachbaocao = DB::table('kehoach_baocao')
                            ->select('ten_bc','ns_phutrach')
                            ->where('id',$req->id)
                            ->first();
        $phutrach = DB::table('users')
                        ->select('users.name','donvi.ten_donvi')
                        ->leftjoin('donvi','donvi.id','users.donvi_id')
                        ->where('users.id',$kehoachbaocao->ns_phutrach)
                        ->first();
        return view('admin.project.Selfassessment.detaitchitiet')
                    ->with([
                        'id_kehoach' =>$req->id,
                        'tenbaocao'  =>$kehoachbaocao->ten_bc,
                        'phutrach'  =>$phutrach,
                    ]);
    }

    public function data_deatial(Request $req){
        $keHoachBaoCao = DB::table('kehoach_baocao')
                    ->select('bo_tieuchuan_id')
                    ->where('kehoach_baocao.id',$req->id)
                    ->first();
        $data =  DB::table('bo_tieuchuan')
                        ->select('tieuchuan.*')
                        ->leftjoin('tieuchuan','tieuchuan.bo_tieuchuan_id','=','bo_tieuchuan.id')
                        ->where('bo_tieuchuan.id',$keHoachBaoCao->bo_tieuchuan_id);
        
        return DataTables::of($data)
                ->addColumn('tieuchuan',function($dt){
                  $tieuchuan = "<span class='show_tieuchi' d-id ='$dt->id'> TC $dt->stt : $dt->mo_ta</span>";
                    if($tieuchuan){
                        return $tieuchuan;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('time',function($dt)use($req){
                        $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->select('kehoach_tieuchuan.*')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                        if($kh_tieuchuan){
                            return $this->toShowDate($kh_tieuchuan->ngay_batdau_chuanbi) . '<i class="fas fa-arrow-right"></i>' . $this->toShowDate($kh_tieuchuan->ngay_hoanthanh_chuanbi) ;
                        }else{
                            return Lang::get('project/Selfassessment/title.khongcodl');
                        }
                    
                })
                ->addColumn('conlai',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    $second_date = null;
                    $date = date("d-m-Y"); 
                    $first_date = strtotime($date);  
                    if($kh_tieuchuan){
                        $second_date = strtotime($kh_tieuchuan->ngay_hoanthanh_chuanbi);
                    }
                    

                    if($second_date < $first_date){
                        $datediff = Lang::get('project/Selfassessment/title.quahan');
                    }else{
                        $datediff = (abs($first_date - $second_date))/ (60*60*24).' '.'Ngày';
                    }  
                    

                    if($kh_tieuchuan){
                        return $datediff ;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('truongnhom',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    $users = null;
                    if($kh_tieuchuan){
                        $users = DB::table('users')
                                ->where('id',$kh_tieuchuan->truongnhom)
                                ->first();
                    }
                    
                    if($users){
                        return $users->name ;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('actions',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    if($kh_tieuchuan){
                        $actions = '<button d-id="'.$kh_tieuchuan->id.'" class="btn btn-xs pd-css show_nhansu" type="button"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                        </button>';
                    }else{
                        $actions = '<button d-id="" class="btn btn-xs pd-css show_nhansu" type="button"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                        </button>';
                    }
                    
                    return $actions;

                })
                ->rawColumns(['actions','tieuchuan','time'])
                ->make(true);
    }


    public function show_nsth(Request $req){
        $arr = [];
        $nsth = DB::table('kehoach_tieuchuan_nhansu')
                    ->where('id_kehoach',$req->id_khtc)
                    ->get();
        foreach($nsth as $value){
            $name = DB::table('users')
                        ->where('id',$value->id_nhansuchuanbi)
                        ->first();
            if($name){
                array_push($arr,$name->name);
            }
        }
        
        $khtieuchuan = DB::table('kehoach_tieuchuan')
                        ->where('id',$req->id_khtc)
                        ->first();
        $users = DB::table('users')
                    ->where('id',$khtieuchuan->truongnhom)
                    ->first();
        if($users){
            array_push($arr,$users->name);
        }
        return $arr;

    }

    public function show_tctieuchi(Request $req){
        $list_tieuchi = array();
        $tieuchuan = DB::table('tieuchuan')
                        ->where('id',$req->id_tc)
                        ->first();            
        $khtc = DB::table('kehoach_tieuchuan')
                    ->where('id_kh_baocao',$req->id_kehoach)
                    ->where('tieuchuan_id',$req->id_tc)
                    ->first();
        $tieuchi = DB::table('tieuchi')
                        ->where('tieuchuan_id',$req->id_tc)
                        ->get();
        foreach($tieuchi as $val_tieuchi){
            $list_tieuchi[$val_tieuchi->id][8] = $tieuchuan->stt;
            $list_tieuchi[$val_tieuchi->id][1] = $val_tieuchi->stt;
            $list_tieuchi[$val_tieuchi->id][2] = $val_tieuchi->mo_ta;
            $kh_tieuchi = DB::table('kehoach_tieuchi')
                        ->where('id_tieuchi',$val_tieuchi->id)
                        ->where('id_kh_tieuchuan',$khtc->id)
                        ->first();

            $list_tieuchi[$val_tieuchi->id][3] = $this->toShowDate($kh_tieuchi->ngay_batdau_chuanbi);            
            $list_tieuchi[$val_tieuchi->id][4] = $this->toShowDate($kh_tieuchi->ngay_hoanthanh_chuanbi);
            $users = DB::table('users')
                        ->where('id',$kh_tieuchi->truongnhom)
                        ->first();
            $list_tieuchi[$val_tieuchi->id][5] = $users->name;

            $date = date("d-m-Y"); 
            $first_date = strtotime($date);  
            $second_date = strtotime($kh_tieuchi->ngay_hoanthanh_chuanbi);
            if($second_date < $first_date){
                $list_tieuchi[$val_tieuchi->id][6] = Lang::get('project/Selfassessment/title.quahan');
            }else{
                $list_tieuchi[$val_tieuchi->id][6] = (abs($first_date - $second_date))/ (60*60*24).' '.'Ngày';
            } 

            $list_tieuchi[$val_tieuchi->id][7] = 
                                                '<button d-id="'.$kh_tieuchi->id.'" class="btn btn-xs pd-css show_nhansu_tc" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                </button>';;

        }

        return $list_tieuchi;
    }

    public function show_nsth_tc(Request $req){

        $arr = [];
        $nsth = DB::table('kehoach_tieuchi_nhansu')
                    ->where('id_kehoach',$req->id_khtc)
                    ->get();
        foreach($nsth as $value){
            $name = DB::table('users')
                        ->where('id',$value->id_nhansuchuanbi)
                        ->first();
            if($name){
                array_push($arr,$name->name);
            }
        }
        
        $khtieuchuan = DB::table('kehoach_tieuchi')
                        ->where('id',$req->id_khtc)
                        ->first();
        $users = DB::table('users')
                    ->where('id',$khtieuchuan->truongnhom)
                    ->first();
        if($users){
            array_push($arr,$users->name);
        }
        return $arr;
    }

    

    public function detail_baocao(Request $req){
        $kehoachbaocao = DB::table('kehoach_baocao')
                            ->select('ten_bc','ns_phutrach')
                            ->where('id',$req->id)
                            ->first();
        $phutrach = DB::table('users')
                        ->select('users.name','donvi.ten_donvi')
                        ->leftjoin('donvi','donvi.id','users.donvi_id')
                        ->where('users.id',$kehoachbaocao->ns_phutrach)
                        ->first();
        return view('admin.project.Selfassessment.detai_vietbc')
                    ->with([
                        'id_kehoach' =>$req->id,
                        'tenbaocao'  =>$kehoachbaocao->ten_bc,
                        'phutrach'  =>$phutrach,
                    ]);
    }

    public function data_deatial_khbc(Request $req){
        $keHoachBaoCao = DB::table('kehoach_baocao')
                    ->select('bo_tieuchuan_id')
                    ->where('kehoach_baocao.id',$req->id)
                    ->first();
        $data =  DB::table('bo_tieuchuan')
                        ->select('tieuchuan.*')
                        ->leftjoin('tieuchuan','tieuchuan.bo_tieuchuan_id','=','bo_tieuchuan.id')
                        ->where('bo_tieuchuan.id',$keHoachBaoCao->bo_tieuchuan_id);
        
        return DataTables::of($data)
                ->addColumn('tieuchuan',function($dt){
                  $tieuchuan = "<span class='show_tieuchi' d-id ='$dt->id'> TC $dt->stt : $dt->mo_ta</span>";
                    if($tieuchuan){
                        return $tieuchuan;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('time',function($dt)use($req){
                        $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->select('kehoach_tieuchuan.*')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                        if($kh_tieuchuan){
                            return $this->toShowDate($kh_tieuchuan->ngay_batdau) . '<i class="fas fa-arrow-right"></i>' . $this->toShowDate($kh_tieuchuan->ngay_hoanthanh) ;
                        }else{
                            return Lang::get('project/Selfassessment/title.khongcodl');
                        }
                    
                })
                ->addColumn('conlai',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    $second_date = null;
                    $date = date("d-m-Y"); 
                    $first_date = strtotime($date);  
                    if($kh_tieuchuan){
                        $second_date = strtotime($kh_tieuchuan->ngay_hoanthanh_chuanbi);
                    }
                    
                    if($second_date < $first_date){
                        $datediff = Lang::get('project/Selfassessment/title.quahan');
                    }else{
                        $datediff = (abs($first_date - $second_date))/ (60*60*24).' '.'Ngày';
                    }  
                    

                    if($kh_tieuchuan){
                        return $datediff ;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('truongnhom',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    $users = null;
                    if($kh_tieuchuan){
                        $users = DB::table('users')
                                ->where('id',$kh_tieuchuan->truongnhom)
                                ->first();
                    }
                    
                    if($users){
                        return $users->name ;
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                    
                })
                ->addColumn('actions',function($dt)use($req){
                    $kh_tieuchuan = DB::table('kehoach_tieuchuan')
                                        ->where('id_kh_baocao',$req->id)
                                        ->where('tieuchuan_id',$dt->id)
                                        ->first();
                    if($kh_tieuchuan){
                        $actions = '<button d-id="'.$kh_tieuchuan->id.'" class="btn btn-xs pd-css show_nhansu" type="button"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                        </button>';
                    }else{
                        $actions = '<button d-id="" class="btn btn-xs pd-css show_nhansu" type="button"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                        </button>';
                    }
                    
                    return $actions;

                })
                ->rawColumns(['actions','tieuchuan','time'])
                ->make(true);
    }

    public function show_nskt(Request $req){
        $arr = array();
        $ns = DB::table('kehoach_tieuchuan_nhansu')
                    ->where('id_kehoach',$req->id_khtc)
                    ->get();
                    $i = 1;
        foreach($ns as $key => $value){
            $nsth = DB::table('users')
                        ->where('id',$value->id_nhansuthuchien)
                        ->first();
            if($nsth){
                $arr[$key][1] = $nsth->name;
            }
            

            $nskt = DB::table('users')
                        ->where('id',$value->id_nhansukiemtra)
                        ->first();
            if($nskt){
                $arr[$key][2] = $nskt->name;
            }
            

        }
        
        $khtieuchuan = DB::table('kehoach_tieuchuan')
                        ->where('id',$req->id_khtc)
                        ->first();
        $users = DB::table('users')
                    ->where('id',$khtieuchuan->truongnhom)
                    ->first();
        if($users){
            $arr[$users->id][3] = $users->name;
        }
        return $arr;

    }

    public function show_tctieuchi_bc(Request $req){
        $list_tieuchi = array();
        $tieuchuan = DB::table('tieuchuan')
                        ->where('id',$req->id_tc)
                        ->first(); 

        $khtc = DB::table('kehoach_tieuchuan')
                    ->where('id_kh_baocao',$req->id_kehoach)
                    ->where('tieuchuan_id',$req->id_tc)
                    ->first();
        $tieuchi = DB::table('tieuchi')
                        ->where('tieuchuan_id',$req->id_tc)
                        ->get();
        foreach($tieuchi as $val_tieuchi){
            $list_tieuchi[$val_tieuchi->id][8] = $tieuchuan->stt;
            $list_tieuchi[$val_tieuchi->id][9] = $val_tieuchi->id;
            $list_tieuchi[$val_tieuchi->id][10] = $khtc->id;
            $list_tieuchi[$val_tieuchi->id][1] = $val_tieuchi->stt;
            $list_tieuchi[$val_tieuchi->id][2] = $val_tieuchi->mo_ta;
            $kh_tieuchi = DB::table('kehoach_tieuchi')
                        ->where('id_tieuchi',$val_tieuchi->id)
                        ->where('id_kh_tieuchuan',$khtc->id)
                        ->first();
            $list_tieuchi[$val_tieuchi->id][3] = $this->toShowDate($kh_tieuchi->ngay_batdau);            
            $list_tieuchi[$val_tieuchi->id][4] = $this->toDBDate($kh_tieuchi->ngay_hoanthanh);
            $users = DB::table('users')
                        ->where('id',$kh_tieuchi->truongnhom)
                        ->first();
            $list_tieuchi[$val_tieuchi->id][5] = $users->name;

            $date = date("d-m-Y"); 
            $first_date = strtotime($date);  
            $second_date = strtotime($kh_tieuchi->ngay_hoanthanh_chuanbi);
            if($second_date < $first_date){
                $list_tieuchi[$val_tieuchi->id][6] = Lang::get('project/Selfassessment/title.quahan');
            }else{
                $list_tieuchi[$val_tieuchi->id][6] = (abs($first_date - $second_date))/ (60*60*24).' '.'Ngày';
            } 

            $list_tieuchi[$val_tieuchi->id][7] = 
                                                '<button d-id="'.$kh_tieuchi->id.'" class="btn btn-xs pd-css show_nhansu_tc" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                </button>';;

        }

        return $list_tieuchi;
    }


    public function show_nskt_tc(Request $req){

        $arr = [];
        $nsth = DB::table('kehoach_tieuchi_nhansu')
                    ->where('id_kehoach',$req->id_khtc)
                    ->get();
        foreach($nsth as $key => $value){
            $nsth = DB::table('users')
                        ->where('id',$value->id_nhansuthuchien)
                        ->first();
            if($nsth){
                $arr[$key][1] = $nsth->name;
            }
            $nskt = DB::table('users')
                        ->where('id',$value->id_nhansukiemtra)
                        ->first();
            if($nskt){
                $arr[$key][2] = $nskt->name;
            }
        }
        
        $khtieuchuan = DB::table('kehoach_tieuchi')
                        ->where('id',$req->id_khtc)
                        ->first();
        $users = DB::table('users')
                    ->where('id',$khtieuchuan->truongnhom)
                    ->first();
        if($users){
            $arr[$users->id][3] = $users->name;
        }
        return $arr;
    }

    public function show_tctieuchi_md(Request $req){
        $list_tieuchi = array();
        $tieuchi = DB::table('tieuchi')
                        ->where('id',$req->id_tc)
                        ->first(); 

        $khtc = DB::table('kehoach_tieuchi')
                    ->where('id_kh_tieuchuan',$req->id_khtc)
                    ->where('id_tieuchi',$req->id_tc)
                    ->first();
        $menhde = DB::table('menhde')
                        ->where('tieuchi_id',$tieuchi->id)
                        ->get();
        foreach($menhde as $val_menhde){
            $list_tieuchi[$val_menhde->id][8] = $val_menhde->id;
            $list_tieuchi[$val_menhde->id][1] = $val_menhde->stt;
            $list_tieuchi[$val_menhde->id][2] = $val_menhde->mo_ta;
            $kh_menhde = DB::table('kehoach_menhde')
                        ->where('id_kh_tieuchi',$khtc->id)
                        ->where('id_menhde',$val_menhde->id)
                        ->first();
            $list_tieuchi[$val_menhde->id][3] = $this->toShowDate($kh_menhde->ngay_batdau);            
            $list_tieuchi[$val_menhde->id][4] = $this->toDBDate($kh_menhde->ngay_hoanthanh);

            $list_tieuchi[$val_menhde->id][5] = Lang::get('project/Selfassessment/title.kcotn');

            $date = date("d-m-Y"); 
            $first_date = strtotime($date);  
            $second_date = strtotime($kh_menhde->ngay_hoanthanh);
            if($second_date < $first_date){
                $list_tieuchi[$val_menhde->id][6] = Lang::get('project/Selfassessment/title.quahan');
            }else{
                $list_tieuchi[$val_menhde->id][6] = (abs($first_date - $second_date))/ (60*60*24).' '.'Ngày';
            } 

            $list_tieuchi[$val_menhde->id][7] = 
                                                '<button d-id="'.$kh_menhde->id.'" class="btn btn-xs pd-css show_nhansu_md p-0" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="@lang("project/Selfassessment/title.xemdanhsach")">
                                                    <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                                                </button>';
            // $list_tieuchi[$val_menhde->id][9] = $val_tieuchi->id;

        }

        return $list_tieuchi;
    }

    public function show_nskt_md(Request $req){

        $arr = [];
        $nsth = DB::table('kehoach_menhde_nhansu')
                    ->where('id_kehoach',$req->id_khmd)
                    ->get();
        foreach($nsth as $key => $value){
            $nsth = DB::table('users')
                        ->where('id',$value->id_nhansuthuchien)
                        ->first();
            if($nsth){
                $arr[$key][1] = $nsth->name;
            }
            $nskt = DB::table('users')
                        ->where('id',$value->id_nhansukiemtra)
                        ->first();
            if($nskt){
                $arr[$key][2] = $nskt->name;
            }
        }
        
        return $arr;
    }
}

