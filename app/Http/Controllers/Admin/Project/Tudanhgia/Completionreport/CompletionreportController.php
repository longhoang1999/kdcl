<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Completionreport;

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
use PHPHtmlParser\Dom;

class CompletionreportController extends DefinedController
{
     public function index(Request $req){
          return view('admin.project.Selfassessment.completereport');
     }
     public function data(Request $req){

            if(Sentinel::inRole('operator') || Sentinel::inRole('admin')){

                $bcs = DB::table('kehoach_baocao')
                    ->select('kehoach_baocao.*','ctdt.manganh')
                    ->leftjoin('ctdt','ctdt.id','=','kehoach_baocao.ctdt_id');

                }else{

                    $bcs = DB::table('kehoach_baocao')
                                ->select('kehoach_baocao.*','ctdt.manganh')
                                ->leftjoin('ctdt','ctdt.id','=','kehoach_baocao.ctdt_id')
                                ->where('kehoach_baocao.deleted_at', null)
                                ->where(function ($query) {
                                    $user_id = Sentinel::getUser()->id;
                                    $query->where('kehoach_baocao.ns_phutrach', '=', $user_id)
                                        ->orWhereExists(function ($subquery) use ($user_id) {
                                            $subquery->from('kehoach_baocao_nhansu')
                                                ->whereRaw('kehoach_baocao.id = kehoach_baocao_nhansu.id_kehoach')
                                                ->where(function ($subsubquery) use ($user_id) {
                                                    $subsubquery->where('kehoach_baocao_nhansu.id_nhansuthuchien', '=', $user_id)
                                                                ->orWhere('kehoach_baocao_nhansu.id_nhansukiemtra', '=', $user_id);
                                                });
                                        });
                                })->get();
                }

        return DataTables::of($bcs)
            ->addColumn(
                'tenbaocao',
                function($bc){
                    if($bc->ten_bc){
                        return '<a href="'.route('admin.tudanhgia.completionreport.detail',$bc->id).'" class="" d-id='.$bc->id.'>'.$bc->ten_bc.'</a>';
                    }else{
                        return Lang::get('project/Selfassessment/title.khongcodl');
                    }
                }
            )
            ->addColumn(
                'ma_nganh',
                function ($bc) {
                        $manganh = isset($bc->manganh)? $bc->manganh: Lang::get('project/Selfassessment/title.khongcodl');
                    return $manganh;
                }
            )
            ->addColumn(
                'ngPhutrach',
                function ($bc) {
                    $userName = DB::table("users")
                        ->where("id", $bc->ns_phutrach)->select("name")->first();
                        $user = isset($userName->name)? $userName->name: Lang::get('project/Selfassessment/title.khongcodl');
                    return $user;
                }
            )
            ->addColumn(
                'dvpt',
                function ($bc) {

                    $donvi = DB::table("users")
                                    ->leftjoin("donvi","donvi.id","=","users.donvi_id")
                                    ->where("users.id", $bc->ns_phutrach)
                                    ->select("donvi.ten_donvi")->first();
                    $dvs = isset($donvi->ten_donvi)? $donvi->ten_donvi: Lang::get('project/Selfassessment/title.khongcodl');
                    return $dvs;
                }
            )
            ->addColumn(
                'createdAt',
                function ($bc) {
                    return date("d/m/Y", strtotime($bc->thoi_diem_bao_cao));
                }
            )
            ->addColumn(
                'tgTh',
                function ($bc) {
                    return date("d/m/Y", strtotime($bc->ngay_batdau)) . '=>' . date("d/m/Y", strtotime($bc->ngay_hoanthanh));
                }
            )
            ->addColumn(
                'status',
                function ($btc) {
                    if($btc->trang_thai == "completed"){
                        return '<button href="'.route('admin.tudanhgia.completionreport.detail',$btc->id).'" class="badge badge-success" style="border: none;">'. lang::get('project/Selfassessment/title.dahoanthanh') .'</button>';
                    }else {
                        return '<button class="badge badge-warning" style="border: none;">'. lang::get('project/Selfassessment/title.chuahoanthanh') .'</button>';
                    }
                }
            )
            ->rawColumns(['status','tenbaocao'])
            ->make(true);
    }

    public function detail(Request $req){

        $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                            ->where('id',$req->id)
                            ->first();

        list($mcCollect) = $this->listMinhChung($req->id);
        $minhChungList = $mcCollect;
        if ($req->id) {
            list($title,$keHoachBaoCaoDetail) = $this->listDatakeHoachBaoCaoDetail($req->id);
            $keHoachBaoCaoListDetail = $keHoachBaoCaoDetail;
        }
        $keHoachBaoCaoDetail->boTieuChuan = DB::table('bo_tieuchuan')
                                        ->where('id',$keHoachBaoCaoDetail->bo_tieuchuan_id)
                                        ->first();

        $keHoachBaoCaoDetail->keHoachChung = DB::table('kehoach_chung')
                                        ->where('kh_baocao_id',$keHoachBaoCaoDetail->id)
                                        ->first();
        if($keHoachBaoCaoDetail->keHoachChung){
            $keHoachBaoCaoDetail->keHoachChung->baoCaoChung = DB::table('baocao_chung')
                                                    ->where('id_kh_chung',$keHoachBaoCaoDetail->keHoachChung->id)
                                                    ->first();
        }

        $keHoachBaoCaoDetail->keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                                                    ->where('kehoach_tieuchuan.id_kh_baocao','=',$keHoachBaoCaoDetail->id)
                                                    ->get();
        foreach($keHoachBaoCaoDetail->keHoachTieuChuanList as $value){
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                    ->where('baocao_tieuchuan.id_kehoach_bc',$req->id)
                                    ->where('baocao_tieuchuan.id_tieuchuan',$value->tieuchuan_id)
                                    ->first();
            $value->baoCaoTieuChuan = $baoCaoTieuChuan;
            $tieuChuan = DB::table('tieuchuan')
                                    ->where('tieuchuan.id',$value->tieuchuan_id)
                                    ->first();
            $value->tieuChuan = $tieuChuan;
            $keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                    ->where('id_kh_tieuchuan',$value->id)
                                    ->get();
            $value->keHoachTieuChiList = $keHoachTieuChiList;
            foreach($value->keHoachTieuChiList as $valuetc){
                if($keHoachBaoCaoDetail->writeFollow == 1){
                    $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.*','menhde.id as id_md')
                                        ->leftjoin('menhde','menhde.id','kehoach_menhde.id_menhde')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$valuetc->id)
                                        ->get();
                    $valuetc->keHoachMenhDeList = $keHoachMenhDeList;

                    $tieuChi = DB::table('tieuchi')
                                            ->where('id',$valuetc->id_tieuchi)
                                            ->first();
                    $valuetc->tieuChi = $tieuChi;

                    foreach($valuetc->keHoachMenhDeList as $valuekhmd){
                        $baoCaoMenhDe = DB::table('baocao_menhde')
                                            ->where('id_kehoach_bc',$req->id)
                                            ->where('id_kh_menhde',$valuekhmd->id)
                                            ->where('id_menhde',$valuekhmd->id_md)
                                            ->first();

                        $valuekhmd->baoCaoMenhDe = $baoCaoMenhDe;

                        if( isset($baoCaoMenhDe->danhgia)){
                            $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                        }

                        $keHoachHanhDongList = DB::table('kehoach_hd')
                                                ->where('kehoach_bc_id',$req->id)
                                                ->where('menhde_id',$valuekhmd->id_md)
                                                ->get();
                        $valuekhmd->keHoachHanhDongList = $keHoachHanhDongList;
                        foreach($valuekhmd->keHoachHanhDongList as $valuekhhd){
                            $donViThucHien = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_thuchien)
                                                ->first();
                            $valuekhhd->donViThucHien = $donViThucHien;

                            $donViKiemTra = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_kiemtra)
                                                ->first();
                            $valuekhhd->donViKiemTra = $donViKiemTra;
                        }
                    }
                }else if($keHoachBaoCaoDetail->writeFollow == 2){

                    $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.*','mocchuan.id as id_md')
                                        ->leftjoin('mocchuan','mocchuan.id','=','kehoach_menhde.mocchuan_id')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$valuetc->id)
                                        ->get();
                    $valuetc->keHoachMenhDeList = $keHoachMenhDeList;

                    $tieuChi = DB::table('tieuchi')
                                            ->where('id',$valuetc->id_tieuchi)
                                            ->first();
                    $valuetc->tieuChi = $tieuChi;

                    foreach($valuetc->keHoachMenhDeList as $valuekhmd){
                        $baoCaoMenhDe = DB::table('baocao_menhde')
                                            ->where('id_kehoach_bc',$req->id)
                                            ->where('id_kh_menhde',$valuekhmd->id)
                                            ->where('mocchuan_id',$valuekhmd->id_md)
                                            ->first();

                        $valuekhmd->baoCaoMenhDe = $baoCaoMenhDe;

                        if( isset($baoCaoMenhDe->danhgia)){
                            $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                        }

                        $keHoachHanhDongList = DB::table('kehoach_hd')
                                                ->where('kehoach_bc_id',$req->id)
                                                ->where('menhde_id',$valuekhmd->id_md)
                                                ->get();
                        $valuekhmd->keHoachHanhDongList = $keHoachHanhDongList;
                        foreach($valuekhmd->keHoachHanhDongList as $valuekhhd){
                            $donViThucHien = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_thuchien)
                                                ->first();
                            $valuekhhd->donViThucHien = $donViThucHien;

                            $donViKiemTra = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_kiemtra)
                                                ->first();
                            $valuekhhd->donViKiemTra = $donViKiemTra;
                        }
                    }
                }


                $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                $valuetc->baoCaoTieuChi = $baoCaoTieuChi;

            }


        }
        $tencsgd = '';
        $csgd = DB::table('csdt')
                    ->leftjoin('donvi','donvi.csdt_id','csdt.id')
                    ->where('donvi.id',Sentinel::getUser()->donvi_id)
                    ->first();
        if($csgd){
            $tencsgd = $csgd->ten_csdt;
        }


        $sua = "xem";
        $id_bc = $req->id;
        $data = DB::table('coso_dulieu')
                    ->where('id_khbc',$req->id)
                    ->first();
        $dulieu = json_decode($data->dulieu);
        list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex($id_bc);
        list($noiDungThem) = $this->getDataPhuLucCSDT($keHoachBaoCaoDetail2);
        $list = $this->showFileData($id_bc);
        return view('admin.project.Selfassessment.detail')
                        ->with([
                                'title'  => $keHoachBaoCaoDetail->ten_bc,
                                'keHoachBaoCaoDetail'  => $keHoachBaoCaoDetail,
                                'keHoachBaoCaoListDetail' => $keHoachBaoCaoListDetail,
                                'tencsgd' => $tencsgd,
                                'minhChungList' => $minhChungList,
                                'id_khbc' => $req->id,
                                "dulieu"  => $dulieu,
                                "keHoachBaoCaoDetail2"  => $keHoachBaoCaoDetail2,
                                'noiDungThem' => $noiDungThem,
                                "idkhbc"  => $id_bc,
                                'data'    => $list,
                                'check'   => $sua,

                        ]);
    }


    public function export_exht(Request $req){
        $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                            ->where('id',$req->id)
                            ->first();

        list($mcCollect) = $this->listMinhChung($req->id);
        $minhChungList = $mcCollect;
        if ($req->id) {
            list($title,$keHoachBaoCaoDetail) = $this->listDatakeHoachBaoCaoDetail($req->id);
            $keHoachBaoCaoListDetail = $keHoachBaoCaoDetail;
        }
        $keHoachBaoCaoDetail->boTieuChuan = DB::table('bo_tieuchuan')
                                        ->where('id',$keHoachBaoCaoDetail->bo_tieuchuan_id)
                                        ->first();

        $keHoachBaoCaoDetail->keHoachChung = DB::table('kehoach_chung')
                                        ->where('kh_baocao_id',$keHoachBaoCaoDetail->id)
                                        ->first();
        if($keHoachBaoCaoDetail->keHoachChung){
            $keHoachBaoCaoDetail->keHoachChung->baoCaoChung = DB::table('baocao_chung')
                                                    ->where('id_kh_chung',$keHoachBaoCaoDetail->keHoachChung->id)
                                                    ->first();
        }

        $keHoachBaoCaoDetail->keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                                                    ->where('kehoach_tieuchuan.id_kh_baocao','=',$keHoachBaoCaoDetail->id)
                                                    ->get();
        foreach($keHoachBaoCaoDetail->keHoachTieuChuanList as $value){
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                    ->where('baocao_tieuchuan.id_kehoach_bc',$req->id)
                                    ->where('baocao_tieuchuan.id_tieuchuan',$value->tieuchuan_id)
                                    ->first();
            $value->baoCaoTieuChuan = $baoCaoTieuChuan;
            $tieuChuan = DB::table('tieuchuan')
                                    ->where('tieuchuan.id',$value->tieuchuan_id)
                                    ->first();
            $value->tieuChuan = $tieuChuan;
            $keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                    ->where('id_kh_tieuchuan',$value->id)
                                    ->get();
            $value->keHoachTieuChiList = $keHoachTieuChiList;
            foreach($value->keHoachTieuChiList as $valuetc){
                if($keHoachBaoCaoDetail->writeFollow == 1){
                    $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.*','menhde.id as id_md')
                                        ->leftjoin('menhde','menhde.id','kehoach_menhde.id_menhde')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$valuetc->id)
                                        ->get();
                    $valuetc->keHoachMenhDeList = $keHoachMenhDeList;

                    $tieuChi = DB::table('tieuchi')
                                            ->where('id',$valuetc->id_tieuchi)
                                            ->first();
                    $valuetc->tieuChi = $tieuChi;

                    foreach($valuetc->keHoachMenhDeList as $valuekhmd){
                        $baoCaoMenhDe = DB::table('baocao_menhde')
                                            ->where('id_kehoach_bc',$req->id)
                                            ->where('id_kh_menhde',$valuekhmd->id)
                                            ->where('id_menhde',$valuekhmd->id_md)
                                            ->first();

                        $valuekhmd->baoCaoMenhDe = $baoCaoMenhDe;

                        if( isset($baoCaoMenhDe->danhgia)){
                            $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                        }

                        $keHoachHanhDongList = DB::table('kehoach_hd')
                                                ->where('kehoach_bc_id',$req->id)
                                                ->where('menhde_id',$valuekhmd->id_md)
                                                ->get();
                        $valuekhmd->keHoachHanhDongList = $keHoachHanhDongList;
                        foreach($valuekhmd->keHoachHanhDongList as $valuekhhd){
                            $donViThucHien = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_thuchien)
                                                ->first();
                            $valuekhhd->donViThucHien = $donViThucHien;

                            $donViKiemTra = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_kiemtra)
                                                ->first();
                            $valuekhhd->donViKiemTra = $donViKiemTra;
                        }
                    }
                }else if($keHoachBaoCaoDetail->writeFollow == 2){

                    $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.*','mocchuan.id as id_md')
                                        ->leftjoin('mocchuan','mocchuan.id','=','kehoach_menhde.mocchuan_id')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$valuetc->id)
                                        ->get();
                    $valuetc->keHoachMenhDeList = $keHoachMenhDeList;

                    $tieuChi = DB::table('tieuchi')
                                            ->where('id',$valuetc->id_tieuchi)
                                            ->first();
                    $valuetc->tieuChi = $tieuChi;

                    foreach($valuetc->keHoachMenhDeList as $valuekhmd){
                        $baoCaoMenhDe = DB::table('baocao_menhde')
                                            ->where('id_kehoach_bc',$req->id)
                                            ->where('id_kh_menhde',$valuekhmd->id)
                                            ->where('mocchuan_id',$valuekhmd->id_md)
                                            ->first();

                        $valuekhmd->baoCaoMenhDe = $baoCaoMenhDe;

                        if( isset($baoCaoMenhDe->danhgia)){
                            $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                        }

                        $keHoachHanhDongList = DB::table('kehoach_hd')
                                                ->where('kehoach_bc_id',$req->id)
                                                ->where('menhde_id',$valuekhmd->id_md)
                                                ->get();
                        $valuekhmd->keHoachHanhDongList = $keHoachHanhDongList;
                        foreach($valuekhmd->keHoachHanhDongList as $valuekhhd){
                            $donViThucHien = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_thuchien)
                                                ->first();
                            $valuekhhd->donViThucHien = $donViThucHien;

                            $donViKiemTra = DB::table('donvi')
                                                ->where('id',$valuekhhd->ns_kiemtra)
                                                ->first();
                            $valuekhhd->donViKiemTra = $donViKiemTra;
                        }
                    }
                }


                $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                $valuetc->baoCaoTieuChi = $baoCaoTieuChi;

            }


        }
        $tencsgd = '';
        $csgd = DB::table('csdt')
                    ->leftjoin('donvi','donvi.csdt_id','csdt.id')
                    ->where('donvi.id',Sentinel::getUser()->donvi_id)
                    ->first();
        if($csgd){
            $tencsgd = $csgd->ten_csdt;
        }


        $sua = "xem";
        $id_bc = $req->id;
        $data = DB::table('coso_dulieu')
                    ->where('id_khbc',$req->id)
                    ->first();
        $dulieu = json_decode($data->dulieu);
        list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex($id_bc);
        list($noiDungThem) = $this->getDataPhuLucCSDT($keHoachBaoCaoDetail2);
        $list = $this->showFileData($id_bc);
        return view('admin.project.Selfassessment.exportexht')
                        ->with([
                                'title'  => $keHoachBaoCaoDetail->ten_bc,
                                'keHoachBaoCaoDetail'  => $keHoachBaoCaoDetail,
                                'keHoachBaoCaoListDetail' => $keHoachBaoCaoListDetail,
                                'tencsgd' => $tencsgd,
                                'minhChungList' => $minhChungList,
                                'id_khbc' => $req->id,
                                "dulieu"  => $dulieu,
                                "keHoachBaoCaoDetail2"  => $keHoachBaoCaoDetail2,
                                'noiDungThem' => $noiDungThem,
                                "idkhbc"  => $id_bc,
                                'data'    => $list,
                                'check'   => $sua,

                        ]);
    }

    public function listDatakeHoachBaoCaoDetail($id){
        $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                            ->where('id',$id)
                            ->first();

        if (!$keHoachBaoCaoDetail){
            return abort(422, "Sự cố khi lấy thông tin");
        }
        $keHoachBaoCaoDetail->keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                                                    ->where('kehoach_tieuchuan.id_kh_baocao','=',$keHoachBaoCaoDetail->id)
                                                    ->get();
        //Loại bỏ các kế hoạch tiêu chuẩn chưa xác nhận

        $mcCollect = collect([]);
        foreach ($keHoachBaoCaoDetail->keHoachTieuChuanList as $key => $keHoachTieuChuan) {
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                    ->where('baocao_tieuchuan.id_kh_tieuchuan',$keHoachTieuChuan->id)
                                    ->where('baocao_tieuchuan.id_kehoach_bc',$id)
                                    ->where('baocao_tieuchuan.id_tieuchuan',$keHoachTieuChuan->tieuchuan_id)
                                    ->first();
            $keHoachTieuChuan->baoCaoTieuChuan = $baoCaoTieuChuan;
            if (!$keHoachTieuChuan->baoCaoTieuChuan) {
                continue;
            }
            $keHoachTieuChuan->baoCaoTieuChuan->danhgia = "Chưa hoàn thành";
            $baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                ->where('id_kehoach_bc',$id)
                                ->where('id_tieuchuan',$keHoachTieuChuan->tieuchuan_id)
                                ->first();
            $keHoachTieuChuan->baoCaoTieuChuan = $baoCaoTieuChuan;
            $tieuChuan = DB::table('tieuchuan')
                            ->where('id','=',$keHoachTieuChuan->tieuchuan_id)
                            ->first();
            $keHoachTieuChuan->tieuChuan = $tieuChuan;
            $keHoachTieuChuan->baoCaoTieuChuan->danhgia = "Chưa hoàn thành";

            //Loại bỏ các kế hoạch mệnh đề chưa xác nhận, và lấy dữ liệu kế hoạch hành động
            $danhGiaTieuChi = [];
            $minhChungid = [];

            $checkMC = collect([]); //tạo 1 collect riêng chỉ chứa minhChungCode
            $keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                    ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                    ->get();
            $keHoachTieuChuan->keHoachTieuChiList = $keHoachTieuChiList;
            foreach ($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi) {
                $danhGiaMenhDe = [];
                $minhChungStt = 1;

                $tieuChi = DB::table('tieuchi')
                            ->where('id',$keHoachTieuChi->id_tieuchi)
                            ->first();
                $keHoachTieuChi->tieuChi = $tieuChi;
                $keHoachMenhDeList = DB::table('kehoach_menhde')
                                        ->select('kehoach_menhde.*','menhde.id as id_md')
                                        ->leftjoin('menhde','menhde.id','kehoach_menhde.id_menhde')
                                        ->where('kehoach_menhde.id_kh_tieuchi',$keHoachTieuChi->id)
                                        ->get();
                $keHoachTieuChi->keHoachMenhDeList = $keHoachMenhDeList;
                foreach ($keHoachTieuChi->keHoachMenhDeList as $key2 => $keHoachMenhDe) {

                    $baoCaoMenhDe = DB::table('baocao_menhde')
                                        ->where('id_kehoach_bc',$id)
                                        ->where('id_kh_menhde',$keHoachMenhDe->id)
                                        ->where('id_menhde',$keHoachMenhDe->id_md)
                                        ->first();
                    $keHoachMenhDe->baoCaoMenhDe = $baoCaoMenhDe;
                    if (!$keHoachMenhDe->baoCaoMenhDe) {
                        continue;
                    }

                    $danhGiaMenhDe[] = $keHoachMenhDe->baoCaoMenhDe->danhgia;
                    $keHoachMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
                                                            ->where('kehoach_bc_id',$id)
                                                            ->where('menhde_id',$keHoachMenhDe->id_md)
                                                            ->get();

                }

                $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                $keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
            }

            $keHoachTieuChuan->baoCaoTieuChuan->danhgia = round(collect($danhGiaTieuChi)->avg(), 1);
        };
        $title = $keHoachBaoCaoDetail->ten_bc;
        return array($title,$keHoachBaoCaoDetail);
    }
    public function exit_hoanthanh(Request $req){

        $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                                    ->where('id',$req->id_khbc)
                                    ->update([
                                        'trang_thai' => "completed",
                                    ]);

        return 1;
    }

    public function exit_molai(Request $req){

        $keHoachBaoCaoDetail = DB::table('kehoach_baocao')
                                    ->where('id',$req->id_khbc)
                                    ->update([
                                        'trang_thai' => "todo",
                                    ]);

        return 1;
    }


    public function listMinhChung($id){

            $kehoachbaocao = DB::table('kehoach_baocao')
                                ->where('id',$id)
                                ->first();
            $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                                    ->where('id_kh_baocao',$id)
                                    ->get();
            $mcCollect = collect([]);
            $minhChungid = [];
            $checkMC = collect([]);
            $td = array();
            foreach($keHoachTieuChuanList as $keHoachTieuChuan){
                $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                                            ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                                            ->get();
                $keHoachTieuChuan->tieuChuan = DB::table('tieuchuan')
                                                            ->where('id',$keHoachTieuChuan->tieuchuan_id)
                                                            ->first();

                foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                    $minhChungStt = 1;
                    $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
                                                            ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                            ->get();
                    $keHoachTieuChi->tieuChi = DB::table('tieuchi')
                                                            ->where('id',$keHoachTieuChi->id_tieuchi)
                                                            ->first();

                    if($kehoachbaocao->writeFollow == 1){
                        foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                            $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                                ->where('id_kehoach_bc',$id)
                                                                ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                                ->where('id_menhde',$keHoachMenhDe->id_menhde)
                                                                ->first();

                            if(isset($keHoachMenhDe->baoCaoMenhDe->mota)){
                                $dom = new Dom;
                                $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);

                                $anchorTags = $dom->find('.danMinhChung');

                                foreach ($anchorTags as $anchorTag) {
                                    $anchorData = $anchorTag->outerHtml;

                                    $classValue = $anchorTag->getAttribute('class');
                                    $idValue = $anchorTag->getAttribute('id');
                                    $valueAfterUnderscore = substr($idValue, strpos($idValue, '_') + 1);
                                    // echo($valueAfterUnderscore);
                                    if (strpos($classValue, 'mcGop') !== false) {
                                        $sohieubh = '__';
                                        $tenmc = '';
                                        $noibanhanh = '';
                                        $minhchunggop = DB::table('minhchung_gop')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchunggop){
                                            $tenmc = $minhchunggop->tieu_de;
                                            $sohieubh = DB::table('minhchung')
                                                                ->leftjoin('minhchunggop_minhchung','minhchung.id','=','minhchunggop_minhchung.minhchung_id')
                                                                ->where('minhchunggop_minhchung.minhchunggop_id',$minhchunggop->id)
                                                                ->count();
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.mcgop'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }else{
                                        $noibanhanh = '';
                                        $tenmc = '';
                                        $sohieubh = '__';
                                        $minhchung = DB::table('minhchung')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchung){
                                            $tenmc = $minhchung->tieu_de;
                                            $ngaybh = $this->toShowDate($minhchung->ngay_ban_hanh);
                                            $sohieubh = $minhchung->sohieu.','.$ngaybh;
                                            $noibanhanh = $minhchung->noi_banhanh;
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.minhchung'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }
                                }

                            }

                        }
                    }elseif($kehoachbaocao->writeFollow == 2){

                        foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                            $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                                ->where('id_kehoach_bc',$id)
                                                                ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                                ->where('mocchuan_id',$keHoachMenhDe->mocchuan_id)
                                                                ->first();

                            if(isset($keHoachMenhDe->baoCaoMenhDe->mota)){
                                $dom = new Dom;
                                $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);

                                $anchorTags = $dom->find('.danMinhChung');

                                foreach ($anchorTags as $anchorTag) {
                                    $anchorData = $anchorTag->outerHtml;

                                    $classValue = $anchorTag->getAttribute('class');
                                    $idValue = $anchorTag->getAttribute('id');
                                    $valueAfterUnderscore = substr($idValue, strpos($idValue, '_') + 1);
                                    // echo($valueAfterUnderscore);
                                    if (strpos($classValue, 'mcGop') !== false) {
                                        $sohieubh = '__';
                                        $tenmc = '';
                                        $noibanhanh = '';
                                        $minhchunggop = DB::table('minhchung_gop')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchunggop){
                                            $tenmc = $minhchunggop->tieu_de;
                                            $sohieubh = DB::table('minhchung')
                                                                ->leftjoin('minhchunggop_minhchung','minhchung.id','=','minhchunggop_minhchung.minhchung_id')
                                                                ->where('minhchunggop_minhchung.minhchunggop_id',$minhchunggop->id)
                                                                ->count();
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.mcgop'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }else{
                                        $noibanhanh = '';
                                        $tenmc = '';
                                        $sohieubh = '__';
                                        $minhchung = DB::table('minhchung')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchung){
                                            $tenmc = $minhchung->tieu_de;
                                            $ngaybh = $this->toShowDate($minhchung->ngay_ban_hanh);
                                            $sohieubh = $minhchung->sohieu.','.$ngaybh;
                                            $noibanhanh = $minhchung->noi_banhanh;
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.minhchung'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }
                                }

                            }

                        }
                    }

                }

            }
            return array($mcCollect);
        }
        //endcode gốc
        // public function encode(Request $req){

        //     $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
        //                             ->where('id_kh_baocao',$req->id_khbc)
        //                             ->get();
        //     $mcCollect = collect([]);
        //     $minhChungid = [];
        //     $checkMC = collect([]);
        //     foreach($keHoachTieuChuanList as $keHoachTieuChuan){
        //         $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
        //                                                     ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
        //                                                     ->get();
        //         $keHoachTieuChuan->tieuChuan = DB::table('tieuchuan')
        //                                                     ->where('id',$keHoachTieuChuan->tieuchuan_id)
        //                                                     ->first();
        //         foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
        //             $minhChungStt = 1;
        //             $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
        //                                                     ->where('id_kh_tieuchi',$keHoachTieuChi->id)
        //                                                     ->get();
        //             $keHoachTieuChi->tieuChi = DB::table('tieuchi')
        //                                                     ->where('id',$keHoachTieuChi->id_tieuchi)
        //                                                     ->first();
        //             foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
        //                 $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
        //                                                     ->where('id_kehoach_bc',$req->id_khbc)
        //                                                     ->where('id_kh_menhde',$keHoachMenhDe->id)
        //                                                     ->where('id_menhde',$keHoachMenhDe->id_menhde)
        //                                                     ->first();

        //                 if($keHoachMenhDe->baoCaoMenhDe->mota){
        //                     $keHoachMenhDe->baoCaoMenhDe->mota = str_replace('id="addminhchunggop_', 'd-id="', $keHoachMenhDe->baoCaoMenhDe->mota);
        //                     $dom = new Dom;
        //                     $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);
        //                     $contents = $dom->find('.danMinhChung');
        //                     $arr = array();
        //                     if (!empty($contents)) {
        //                         foreach ($contents as $key => $danMinhChung) {
        //                             if($danMinhChung->count() > 0 && !in_array($danMinhChung->{'d-id'}, $minhChungid)){
        //                                 $minhChungCode = "[H{$keHoachTieuChuan->tieuChuan->stt}." .
        //                                         str_pad($keHoachTieuChuan->tieuChuan->stt, 2, '0', STR_PAD_LEFT) . "." .
        //                                         str_pad($keHoachTieuChi->tieuChi->stt, 2, '0', STR_PAD_LEFT) .
        //                                         "." . str_pad($minhChungStt, 2, '0', STR_PAD_LEFT) . "]";

        //                                 $contents[$key]->firstChild()->setText($minhChungCode);
        //                                 // $danMinhChung->innertext = $minhChungCode;
        //                                 $minhChungid[$minhChungCode] = $danMinhChung->{'d-id'};
        //                                 $minhChungStt++;
        //                             }
        //                             else{
        //                                 $minhChungCode = array_search($danMinhChung->{'d-id'}, $minhChungid);
        //                             }

        //                             if($checkMC->contains($minhChungCode)){
        //                                 continue;
        //                             }
        //                             $checkMC->push($minhChungCode);


        //                         }
        //                     }
        //                     DB::table('baocao_menhde')
        //                         ->where('id_kehoach_bc',$req->id_khbc)
        //                         ->where('id_kh_menhde',$keHoachMenhDe->id)
        //                         ->where('id_menhde',$keHoachMenhDe->id_menhde)->update([
        //                                 "mota"  => $dom,
        //                         ]);
        //                 }

        //             }
        //         }
        //     }

        //     return Redirect::back()->with("Lang::get('project/Selfassessment/title.mahoatc'");
        // }


        public function encode(Request $req){

            $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                                    ->where('id_kh_baocao',$req->id_khbc)
                                    ->get();
            $mcCollect = collect([]);
            $minhChungid = [];
            $checkMC = collect([]);
            foreach($keHoachTieuChuanList as $keHoachTieuChuan){
                $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                                            ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                                            ->get();
                $keHoachTieuChuan->tieuChuan = DB::table('tieuchuan')
                                                            ->where('id',$keHoachTieuChuan->tieuchuan_id)
                                                            ->first();
                foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
                    $minhChungStt = 1;
                    $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
                                                            ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                            ->get();
                    $keHoachTieuChi->tieuChi = DB::table('tieuchi')
                                                            ->where('id',$keHoachTieuChi->id_tieuchi)
                                                            ->first();
                    foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                        $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                            ->where('id_kehoach_bc',$req->id_khbc)
                                                            ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                            ->where('id_menhde',$keHoachMenhDe->id_menhde)
                                                            ->first();

                        if($keHoachMenhDe->baoCaoMenhDe->mota){
                            // $keHoachMenhDe->baoCaoMenhDe->mota = str_replace('id="addminhchunggop_', 'd-id="', $keHoachMenhDe->baoCaoMenhDe->mota);
                            $dom = new Dom;
                            $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);
                            $contents = $dom->find('.danMinhChung');
                            $arr = array();
                            if (!empty($contents)) {
                                foreach ($contents as $key => $danMinhChung) {
                                    if($danMinhChung->count() > 0){
                                        $minhChungCode = "[H{$keHoachTieuChuan->tieuChuan->stt}." .
                                                str_pad($keHoachTieuChuan->tieuChuan->stt, 2, '0', STR_PAD_LEFT) . "." .
                                                str_pad($keHoachTieuChi->tieuChi->stt, 2, '0', STR_PAD_LEFT) .
                                                "." . str_pad($minhChungStt, 2, '0', STR_PAD_LEFT) . "]";

                                        $contents[$key]->firstChild()->setText($minhChungCode);
                                        // $danMinhChung->innertext = $minhChungCode;
                                        $minhChungid[$minhChungCode] = $danMinhChung->{'d-id'};
                                        $minhChungStt++;
                                    }

                                    if($checkMC->contains($minhChungCode)){
                                        continue;
                                    }
                                    $checkMC->push($minhChungCode);


                                }
                            }
                            DB::table('baocao_menhde')
                                ->where('id_kehoach_bc',$req->id_khbc)
                                ->where('id_kh_menhde',$keHoachMenhDe->id)
                                ->where('id_menhde',$keHoachMenhDe->id_menhde)->update([
                                        "mota"  => $dom,
                                ]);
                        }

                    }
                }
            }

            return Redirect::back()->with("Lang::get('project/Selfassessment/title.mahoatc'");
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

                    // $keHoachBaoCaoDetail2->keHoachChung->baoCaoChung = DB::table('baocao_chung')
                    //                                                                  ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                    //                                                                  ->where('id_kh_chung',$keHoachBaoCaoDetail2->keHoachChung->id)
                    //                                                                  ->first();

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

     public function getDataPhuLucCSDT($keHoachBaoCaoDetail2){

           $noiDungThem = DB::table('baocao_noidungthem')
                                    ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                                    ->first();

           $noidung = json_decode($noiDungThem->noidung);
           return array($noidung);

    }

    public function showFileData($idbc){

      $getFile = DB::table('coso_dulieu')->where('id_khbc', $idbc);
      $dataJson = json_decode($getFile->first()->Url_ex);
      $tableList = [];

      foreach ($dataJson as $key => $value) {
          if ($value != '0') {
              $address = public_path($value);
              $a = Excel::toArray([], $address);

              $table = "";
              $UI = "";
              foreach ($a[0] as $subKey => $subValue) { // Change the variable names here to avoid conflicts
                  $td = "";
                  if ($subKey == 0) {
                      foreach ($subValue as $val) {
                          if (trim($val) != "") {
                              $td .= '<th>' . trim($val) . '</th>';
                          }
                      }
                  } else {
                      foreach ($subValue as $val) {
                          if (trim($val) != "") {
                              $td .= '<td>' . trim($val) . '</td>';
                          }
                      }
                  }

                  if ($td != "") {
                      $UI .= '<tr>' . $td . '</tr>';
                  }
              }

              $table = '<table class="table ">' . $UI . '</table>';
              $tableList[$key] = $table; // Assign the $table to the corresponding $key in $tableList
          }
      }

      return $tableList;
  }

}
