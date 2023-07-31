<?php namespace App\Http\Controllers\Admin\Project\Dambaochatluong\ProofClaim;

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
use App\Exports\ListKhhdExport;

class ProofClaimController extends DefinedController
{
    public String $viewBase = 'admin.project.QualiAssurance.Kehoachhanhdong';
    public String $langBase = 'project/QualiAssurance/Kehoachhanhdong/title';
    public String $routeBase = 'admin.dambaochatluong.proofclaim';

    public function index(Request $req){
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta')->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();
        return view( $this->viewBase . '.danhsach')->with([
            "linhvuc" =>  $linhvuc,
            'donvi'     => $donvi
        ]);
    }

    public function getListKhhd(Request $req) {
        $khhds = DB::table("kehoach_hanhdong")->orderBy('kehoach_hanhdong.tieu_de', 'asc')
                    ->leftjoin('hoatdongnhom', 'hoatdongnhom.id', '=', 'kehoach_hanhdong.hoatdongnhom_id')
                    ->where("kehoach_hanhdong.deleted_at",null)
                    ->groupBy('kehoach_hanhdong.hoatdongnhom_id')
                    ->select(
                        'hoatdongnhom.id as idhdn',
                        'hoatdongnhom.id as hoatdongnhom_id',
                        'hoatdongnhom.noi_dung',
                        'kehoach_hanhdong.ngay_batdau',
                        'kehoach_hanhdong.ngay_hoanthanh',
                        'kehoach_hanhdong.donvi_id',
                        'hoatdongnhom.kehoach_id',
                        'kehoach_hanhdong.ghi_chu',
                        'hoatdongnhom.cong_bo'
                    );
        if($req->nam_search != ""){
            $khhds = $khhds->where('kehoach_hanhdong.year', $req->nam_search);
        }
        if($req->donvi_search != ""){
            $khhds = $khhds->where('kehoach_hanhdong.donvi_id', $req->donvi_search);
        }
        if($req->lvuc_search){
            $khhds = $khhds->where('kehoach_hanhdong.nhom_mc_sl_id', $req->lvuc_search);
        }
        if($req->tthai_search){
            $khhds = $khhds->where('hoatdongnhom.cong_bo', $req->tthai_search);
        }

        return DataTables::of($khhds)
            // ->addColumn('actions',function($khhd){
            //     $actions = '<a href="" class="btn btn-primary mr-2 btn-block">
            //         '. Lang::get( $this->langBase . '.ctiet') .'
            //     </a>';
            //     return $actions;
            // })
            ->addColumn('nbd',function($khhd){
                return date("d-m-Y", strtotime($khhd->ngay_batdau));
            })
            ->addColumn('nht',function($khhd){
                return date("d-m-Y", strtotime($khhd->ngay_hoanthanh));
            })
            ->addColumn('donViTh',function($khhd){
                $span = '';
                $all = DB::table("kehoach_hanhdong")->where("hoatdongnhom_id", $khhd->hoatdongnhom_id)->get();
                foreach($all as $val){
                    $donvi = DB::table("donvi")->where("id", $val->donvi_id)
                        ->select('ten_donvi')->first();
                    if($donvi){
                        $span .= "<span class='badge bg-primary'>" . $donvi->ten_donvi . "</span>" ;
                    }else{
                        $span .= "";
                    }
                }

                return  $span;
            })
            // ->addColumn('ngKiemtra',function($khhd){
            //     $khccsl = DB::table("kehoach_cc_solieu")->where("id", $khhd->kehoach_id)
            //             ->select('dv_kiemtra')->first();
            //     $ns_kiemtra = DB::table("users")->where("id", $khccsl->dv_kiemtra)
            //             ->select('name','donvi_id')->first();
            //     $dv_kiemtra = DB::table("donvi")->where("id", $ns_kiemtra->donvi_id)
            //             ->select("ten_donvi")->first();
            //     return $ns_kiemtra->name . ' - ' . $dv_kiemtra->ten_donvi;
            // })
            ->addColumn('trangthai',function($khhd){
                if($khhd->cong_bo == 'Y')
                    return '<span class="badge badge-success">'. Lang::get( $this->langBase . '.dxn') .'</span>';
                else if($khhd->cong_bo == 'P')
                    return '<span class="badge badge-danger">'. Lang::get( $this->langBase . '.kxn') .'</span>';
                else
                    return '<span class="badge badge-warning">'. Lang::get( $this->langBase . '.cxn') .'</span>';
            })
            ->addColumn('noiDung',function($khhd){
                return '<a href="'.
                    route('admin.dambaochatluong.checkproof.editData', $khhd->idhdn)
                .'" class="text-primary">'. $khhd->noi_dung .'</a>';
            })
            ->rawColumns(['noiDung', 'trangthai', 'donViTh'])
            ->make(true);
    }

    public function exportlistKhhd(){
        return Excel::download(new ListKhhdExport(), 'listKhhd.xlsx');
    }

}
