<?php namespace App\Http\Controllers\Admin\Project\Dambaochatluong\CheckProof;

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
use App\Exports\MchdExport;


class CheckProofController extends DefinedController
{
    public String $viewBase = 'admin.project.QualiAssurance.KtraMinhchungHoatdong';
    public String $langBase = 'project/QualiAssurance/KtraMCHoatDong/title';
    public String $routeBase = 'admin.dambaochatluong.checkproof';

    public function index(Request $req){
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        return view( $this->viewBase . '.kt-mc-hoatdong')->with([
            "linhvuc" =>  $linhvuc
        ]);
    }

    public function getData(Request $req){
        $hdns = DB::table("hoatdongnhom")
                    ->where("parent", 0)
                    ->where('deleted_at',null)
                    ->orderBy('created_at', 'desc');
        // foreach($hdns as $hdn){
        //     $hdn_dv = DB::table("hoatdongnhom_donvi")->where("hoatdongnhom_id", $hdn->id)
        //                 ->get();
        //     foreach($hdn_dv as $hdndv){
        //         $userId = DB::table("users")->where("donvi_id", $hdndv->donvi_id)->select("id")->get();
        //         $hdn_mc = DB::table("hoatdongnhom_minhchung")->whereIn("nguoitao", $userId->id)->count();
        //     }
            
        // }

        if($req->tieude != "" && $req->lvuc == "" && $req->year == ""){
            $hdns = $hdns->where('noi_dung', 'like', '%'. $req->tieude .'%');
        };
        if($req->tieude == "" && $req->lvuc != "" && $req->year == ""){
            $hdns = $hdns->where('nhom_mc_sl_id', $req->lvuc );
        };
        if($req->tieude == "" && $req->lvuc == "" && $req->year != ""){
            $hdns = $hdns->where('year', $req->year );
        };
        if($req->tieude != "" && $req->lvuc != "" && $req->year == ""){
            $hdns = $hdns->where('noi_dung', 'like', '%'. $req->tieude .'%')
                        ->where('nhom_mc_sl_id', $req->lvuc );
        };
        if($req->tieude == "" && $req->lvuc != "" && $req->year != ""){
            $hdns = $hdns->where('noi_dung', 'like', '%'. $req->tieude .'%')
                        ->where('year', $req->year );
        };
        if($req->tieude != "" && $req->lvuc == "" && $req->year != ""){
            $hdns = $hdns->where('nhom_mc_sl_id', $req->lvuc )->where('year', $req->year );
        };
        if($req->tieude != "" && $req->lvuc != "" && $req->year != ""){
            $hdns = $hdns->where('noi_dung', 'like', '%'. $req->tieude .'%')
                    ->where('nhom_mc_sl_id', $req->lvuc )->where('year', $req->year );
        };

        return DataTables::of($hdns) 
            ->addColumn('actions',function($hdn){
                $actions = '<a href="'. route( $this->routeBase . '.detailData', $hdn->id) .'" class="btn mr-2 btn-block" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.ctiet').'">
                    '. '<i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>' .'
                </a>';
                return $actions;
            })
            ->addColumn('lvuc',function($hdn){
                $lvuc = DB::table("nhom_mc_sl")->where("id", $hdn->nhom_mc_sl_id);
                if($lvuc->count() == 0){
                    return "Lĩnh vực không tồn tại";
                }else{
                    return $lvuc->first()->mo_ta;
                }
            })
            ->addColumn('hd_parent',function($hdn){
                return DB::table("hoatdongnhom")->where("parent", $hdn->id)->count();
            })
            ->rawColumns(['actions'])           
            ->make(true);
    }
    
    public function detailData($id) {
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        $query = DB::table('hoatdongnhom');
        $hoatDongNhom = $query->where('id', $id)->first();
        $lv_hdn = DB::table("nhom_mc_sl")->select("mo_ta")
                ->where("id", $hoatDongNhom->nhom_mc_sl_id)->first();   

        return view( $this->viewBase . '.danh-sach-mcyc')->with([
            "linhvuc" =>  $linhvuc,
            "id_hdn"   => $id,
            'hoatDongNhom'  => $hoatDongNhom,
            'lv_hdn'            => $lv_hdn
        ]);
    }
    public function getListMcyc($id){
        $hdns = DB::table("hoatdongnhom")->where('parent', $id)
            ->orderBy('created_at', 'desc');
        // foreach ($hdns as $hoatDongNhomC) {
        //     $hdndvBase = DB::table("hoatdongnhom_donvi AS hdndv")
        //             ->leftjoin('donvi AS dv', 'dv.id', '=', 'hdndv.donvi_id')
        //             ->where("hdndv.hoatdongnhom_id", $hoatDongNhomC->id)
        //             ->select("hdndv.donvi_id", "hdndv.hoatdongnhom_id", "dv.ten_donvi");
        //     $hdn_dv = $hdndvBase->get();

        //     foreach ($hdn_dv as $donViThucHien) {
        //         $user = DB::table("users")->where("donvi_id", $donViThucHien->donvi_id)->get();
        //         $id = [];
        //         foreach($user as $us){
        //             array_push($id, $us->id);
        //         }
        //         $hdn_mc = DB::table("hoatdongnhom_minhchung")
        //                 ->where("hoatdongnhom_id", $hoatDongNhomC->id)
        //                 ->whereIn('nguoitao', $id);
        //                 ->count();
        //         $hoatDongNhomC->minhChungCount = $count;
        //     }
        // }

        return DataTables::of($hdns) 
            ->addColumn('actions',function($hdn){
                $actions = '<a href="'. route( $this->routeBase . '.editData', $hdn->id) .'" class="btn mr-2 btn-block" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.ctiet').'">
                    '. '<i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>' .'
                </a>';
                return $actions;
            })
            ->addColumn('dvpc',function($hdn){
                $span = '';
                $hdndvBase = DB::table("hoatdongnhom_donvi AS hdndv")
                    ->leftjoin('donvi AS dv', 'dv.id', '=', 'hdndv.donvi_id')
                    ->where("hdndv.hoatdongnhom_id", $hdn->id)
                    ->select("hdndv.donvi_id", "hdndv.hoatdongnhom_id", "dv.ten_donvi");
                if($hdndvBase->count() > 0){
                    foreach($hdndvBase->get() as $dvth){
                        $user = DB::table("users")->where("donvi_id", $dvth->donvi_id)->get();
                        $id = [];
                        foreach($user as $us){
                            array_push($id, $us->id);
                        }
                        $hdn_mc = DB::table("hoatdongnhom_minhchung")
                                ->where("hoatdongnhom_id", $hdn->id)
                                ->whereIn('nguoitao', $id)->count();
                        if($hdn_mc > 0){
                            $span .= '<span class="badge badge-success">' .
                                $dvth->ten_donvi . '(' . $hdn_mc .')'. '</span>';
                        }else{
                            $span .= '<span class="badge badge-danger">' .
                                $dvth->ten_donvi . '</span>';     
                        }
                    }
                }
                return $span;
            })
            ->addColumn('times',function($hdn){
                $startDay = date("d/m/Y", strtotime($hdn->ngay_batdau));
                $endDay = date("d/m/Y", strtotime($hdn->ngay_hoanthanh));
                return $startDay . '->'  . $endDay;
            })
            ->addColumn('timesConlai',function($hdn){
                $conLai = Carbon::parse($hdn->ngay_hoanthanh)->diffInDays(Carbon::now());
                if($conLai <= 0)
                    return "<i class='text-danger'>". 
                        Lang::get( $this->langBase . '.quahan') ."</i>";
                else
                    return $conLai . " " . Lang::get( $this->langBase . '.ngay');
            })
            ->addColumn('trang_thai',function($hdn){
                if($hdn->cong_bo == "Y")
                    return '<span class="badge badge-success">'. Lang::get( $this->langBase . '.dxnvcb') .'</span>';
                else if($hdn->cong_bo == "P")
                    return '<span class="badge badge-danger">'. Lang::get( $this->langBase . '.kxn') .'</span>';
                else{
                    $hdn_mc = DB::table("hoatdongnhom_minhchung")
                        ->where("hoatdongnhom_id", $hdn->id);
                    if($hdn_mc->count() == 0)
                        return '<span class="badge badge-secondary">'. Lang::get( $this->langBase . '.cht') .'</span>';
                    else 
                        return '<span class="badge badge-warning">'. Lang::get( $this->langBase . '.dth') .'</span>';
                }
            })

            ->rawColumns(['actions', 'dvpc', 'times', 'timesConlai', 'trang_thai'])           
            ->make(true);
    }
    public function editData($id) {
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        $query = DB::table('hoatdongnhom');
        $hoatDongNhom = $query->where('id', $id)->first();
        $lv_hdn = DB::table("nhom_mc_sl")->select("mo_ta")
                ->where("id", $hoatDongNhom->nhom_mc_sl_id)->first();   

        // find đơn vị
        $hdn_dv = DB::table("hoatdongnhom_donvi")->where("hoatdongnhom_id", $id)->get();
        $dvid = [];
        foreach($hdn_dv as $hdndv){
            array_push($dvid, $hdndv->donvi_id);
        }
        $donvi = DB::table("donvi")->whereIn("id", $dvid)->get();
        foreach($donvi as $dv){
            $user = DB::table("users")->where("donvi_id", $dv->id)->select("id")->get();
            $idUser = [];
            foreach($user as $us){
                array_push($idUser, $us->id);
            }
            $hdnmc = DB::table("hoatdongnhom_minhchung")->where("hoatdongnhom_id", $id)
                    ->whereIn("nguoitao",  $idUser);
            $dv->minhChungCount = $hdnmc->count();
        }

        return view( $this->viewBase . '.cap-nhat-hd')->with([
            "linhvuc" =>  $linhvuc,
            "id_hdn"   => $id,
            'hoatDongNhom'  => $hoatDongNhom,
            'lv_hdn'            => $lv_hdn,
            'donvi'         => $donvi
        ]);
    }
    public function cancelMc(Request $req) {
        $hoatDongNhom = DB::table("hoatdongnhom")->where("id", $req->id);
        // dơn vị count = 0
        $hdn_dv = DB::table("hoatdongnhom_donvi")->where("hoatdongnhom_id", $req->id)->get();
        $dvid = [];
        foreach($hdn_dv as $hdndv){
            array_push($dvid, $hdndv->donvi_id);
        }
        $donvi = DB::table("donvi")->whereIn("id", $dvid)->get();
        $dvChuaDus = [];
        foreach($donvi as $dv){
            $user = DB::table("users")->where("donvi_id", $dv->id)->select("id")->get();
            $idUser = [];
            foreach($user as $us){
                array_push($idUser, $us->id);
            }
            $hdnmc = DB::table("hoatdongnhom_minhchung")->where("hoatdongnhom_id", $req->id)
                    ->whereIn("nguoitao",  $idUser);
            if ($hdnmc->count() == 0) {
                array_push($dvChuaDus, $dv->id);
            }
        }
        // update hdn
        $hoatDongNhom->update([
            'cong_bo' => 'P'
        ]);
        foreach ($dvChuaDus as $dvChuaDu) {
            $donVi = DB::table("donvi")->where("id",$dvChuaDu)->first();
            if (!$donVi) continue;

            $data = [
                'hoatdongnhom_id'   => $req->id,
                'tieu_de'   => $hoatDongNhom->first()->tieu_de,
                'nhom_mc_sl_id' =>  $hoatDongNhom->first()->nhom_mc_sl_id,
                'year'          => $hoatDongNhom->first()->year,
                'donvi_id'      => $dvChuaDu,
                'ngay_batdau' => date("Y-m-d", strtotime($req->ngay_batdau)),
                'ngay_hoanthanh' => date("Y-m-d", strtotime($req->ngay_hoanthanh)),
                'ghi_chu' => $req->ghi_chu,
                'nguoi_tao' => Sentinel::getUser()->id,
                'csdt_id'   => Sentinel::getUser()->csdt_id,
            ];
            $keHachHanhDong = DB::table("kehoach_hanhdong")->where([
                ['hoatdongnhom_id', '=', $req->id],
                ['donvi_id', '=', $dvChuaDu]
            ]);

            if ($keHachHanhDong->count() == 0) {
                DB::table("kehoach_hanhdong")->insert($data);
            }else{
                $keHachHanhDong->update($data);
            }
            // Thông báo ....
        }
        return back()->with('success',  
                   Lang::get( $this->langBase . '.mcycbtc'));
    }

    public function openAgain($id) {
        $hoatDongNhom = DB::table("hoatdongnhom")->where("id", $id)
            ->update([
                'cong_bo' => 'N'
            ]);
        DB::table("kehoach_hanhdong")->where("hoatdongnhom_id", $id)->delete();
        return back()->with('success',  
                    Lang::get( $this->langBase . '.mcycdcml'));
    }

    public function getListMc($id) {
        $hdn_mc = DB::table("hoatdongnhom_minhchung")
                ->where("hoatdongnhom_minhchung.hoatdongnhom_id", $id)->get();
        $mcId = [];
        foreach($hdn_mc as $hdnmc){
            array_push($mcId , $hdnmc->minhchung_id );
        }
        $minhchung = DB::table("minhchung")->whereIn("id", $mcId);

        return DataTables::of($minhchung) 
            ->addColumn('actions',function($mc){
                $actions = "";
                $actions .= ' <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  ';

                if(isset($mc->url) && $mc->url != ''){
                    $actions .='
                        <a class="dropdown-item" target="_blank" href="' . $mc->url .'" class="btn">
                            '. Lang::get('project/QualiAssurance/title.xemduongdan') .'
                        </a>
                    ';
                }

                if(isset($mc->duong_dan) && $mc->duong_dan != ''){
                    $actions .='
                        <a class="dropdown-item" target="_blank" href="' . route('admin.dambaochatluong.manaproof.showProof',$mc->id) .'" class="btn">
                            '. Lang::get('project/QualiAssurance/title.xemminhchung') .'
                        </a>
                    ';
                }
                $actions .= "</div> </div>";

                // Bỏ chỉnh sửa
                if( !Sentinel::inRole('ns_thuchien'))
                {
                    $actions .= '<a href="'. route('admin.dambaochatluong.manaproof.editProof',$mc->id) .'" class="btn" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.chinhsua').'">
                    '. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'
                </a>';
                }
                return $actions;
            })
            ->addColumn('linhvuc',function($mc){
                return $lv = DB::table("nhom_mc_sl")->where("id", $mc->nhom_mc_sl_id)
                            ->select("mo_ta")->first()->mo_ta;
            })
            ->addColumn('ngayBan_hanh',function($mc){
                return date("d/m/Y", strtotime($mc->ngay_ban_hanh));
            })
            ->addColumn('ng_Quanly',function($mc){
                return $user = DB::table("users")->where("id", $mc->nguoi_quan_ly)->select("name")
                        ->first()->name;
            })
            ->addColumn('donVi',function($mc){
                $lv = DB::table("nhom_mc_sl")->where("id", $mc->nhom_mc_sl_id)
                            ->select("donvi_id")->first();
                $checkdv = DB::table("donvi")
                                ->where("id", $lv->donvi_id)
                                ->select("ten_donvi")
                                ->first();
                if($checkdv){
                    return $checkdv->ten_donvi;
                }else{
                    return "Không có dữ liệu";
                }
            })
            ->addColumn('trang_thai',function($mc){
                if($mc->tinh_trang == 'xacnhan')
                    return '<span class="badge badge-success">'. Lang::get( $this->langBase . '.dxn') .'</span>';
                else if($mc->tinh_trang == 'khongxacnhan')
                    return '<span class="badge badge-danger">'. Lang::get( $this->langBase . '.kxn') .'</span>';
                else
                    return '<span class="badge badge-warning">'. Lang::get( $this->langBase . '.dangcho') .'</span>';
            })

            ->rawColumns(['actions', 'trang_thai'])           
            ->make(true);
    }
    public function congbo($id){
        $hdn = DB::table("hoatdongnhom")->where("id", $id);
        $findMc = DB::table("hoatdongnhom_minhchung")
            ->where("hoatdongnhom_id", $hdn->first()->id );
        if($findMc->count() == 0){
            return back()->with('error',  
                    Lang::get( $this->langBase . '.cbhdccmc'));
        }
        $idMc = [];
        foreach($findMc->get() as $value){
            array_push($idMc, $value->minhchung_id);
        }

        $minhChungFailed = DB::table("minhchung")
                ->whereIn("id", $idMc)
                ->whereIn('tinh_trang', ['dangcho', 'khongxacnhan']);
        if($minhChungFailed->count() > 0){
            return back()->with('error',  
                    Lang::get( $this->langBase . '.cmccxn'));
        }
        $hdn->update([
            'cong_bo'       => 'Y'
        ]);
        return back()->with('success',  
                    Lang::get( $this->langBase . '.cbtc'));
    }

    public function mchdata(){
        return Excel::download(new MchdExport(), 'mchd.xlsx');
    }
}