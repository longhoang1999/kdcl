<?php namespace App\Http\Controllers\Admin\Project\Tudanhgia\Preparereport;

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

class PreparereportController extends DefinedController
{

    public function index(Request $req){
         return view('admin.project.Selfassessment.preparereport');
    }
    
    public function data(Request $req){        
            $tcs = DB::table('tieuchuan')
                    ->leftJoin('bo_tieuchuan','bo_tieuchuan.id','=','tieuchuan.bo_tieuchuan_id')
                    ->leftJoin('kehoach_baocao','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id');

            return DataTables::of($tcs)    
                ->addColumn('actions',function($tc){
                    $actions = '<a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModal">'.
                            Lang::get('project/Comparison/title.dsns')
                        .'</a>';
                        return $actions;
                })
                ->addColumn('createAt',function($tc){
                    return date("d/m/Y", strtotime($tc->created_at));
                })
                ->addColumn('nametc',function($tc){
                    return "<span>". $tc->mo_ta ."</span>";
                })
                ->addColumn('datebd',function($tc){
                    if($tc->ngay_batdau){
                        return date("d/m/y", strtotime($tc->ngay_batdau));                        
                    }else{
                        return '';
                    }   
                })


                ->addColumn('dateht',function($tc){                                        
                    if($tc->ngay_hoanthanh){
                        return date("d/m/y", strtotime($tc->ngay_hoanthanh));                        
                    }else{
                        return '';
                    }    
                })

                ->addColumn('leader',function($tc){                    
                    $leader = DB::table('users')->where('id', $tc->ns_phutrach)->select('first_name','last_name')->first();
                    if($leader){
                        return $leader->first_name.' '.$leader->last_name;
                    }else{
                        return '';
                    }    
                })
                ->rawColumns(['actions','nametc'])        
                ->make(true);
    }


    public function requireAnalysis(){
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        return view('admin.project.Selfassessment.requireanalysis')->with([
            'kehoach_baocao' => $kehoach_baocao,

        ]);
    }
    public function searchPtyc(Request $req){
        if(isset($req->id_report) && $req->id_report != null){
            $kehoach_tieuchuan = DB::table("kehoach_tieuchuan")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', 
                        '=', 'kehoach_tieuchuan.tieuchuan_id')
                    ->where("kehoach_tieuchuan.id_kh_baocao", $req->id_report)
                    ->select('kehoach_tieuchuan.id_kh_baocao',
                            'kehoach_tieuchuan.tieuchuan_id',
                            'kehoach_tieuchuan.truongnhom',
                            'tieuchuan.stt', 'tieuchuan.mo_ta'
                    )
                    ->get();


            return json_encode([
                'kehoach_tieuchuan' => $kehoach_tieuchuan
            ]);
        }

        if(isset($req->id_standard) && $req->id_standard != null && $req->id_standard != ""){
            $tieuchi = DB::table("tieuchi")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', '=', 'tieuchi.tieuchuan_id')
                    ->where("tieuchi.tieuchuan_id", $req->id_standard)
                    ->select('tieuchi.stt', 'tieuchi.id', 'tieuchi.tieuchuan_id', 'tieuchi.mo_ta','tieuchuan.stt AS sttTC')
                    ->get();



            return json_encode([
                'tieuchi' => $tieuchi
            ]);
        }
        return json_encode([]);
    }
    public function manacollect(Request $req){
        $menhde = DB::table("menhde")->where("tieuchi_id", $req->id_criteria)
                ->select("id", "stt", "tieuchi_id", "mo_ta")
                ->get();
        foreach($menhde as $md){
            $mocchuan = DB::table("mocchuan")->where("tieuchi_id", $md->tieuchi_id)
                        ->select("id", "mo_ta", "tieuchi_id")->get();
            // treo ---
            //foreach($mocchuan as $mc){
                //$mcc_thuthap = DB::table("minhchung_canthuthap")->where("")
            // }
            $md->mocchuan = $mocchuan;
        }

        return json_encode([
            'menhde' => $menhde
        ]);
    }


    public function proofHandling() {
        $kehoach_baocao = DB::table("kehoach_baocao")
                    ->select("id", "ten_bc")->get();
        foreach($kehoach_baocao as $key => $khbc){
            $findTC = DB::table("kehoach_tieuchuan")->where("id_kh_baocao", $khbc->id);
            if($findTC->count() == 0){
                unset($kehoach_baocao[$key]);
            }
        }

        return view('admin.project.Selfassessment.proofhandling')->with([
            'kehoach_baocao' => $kehoach_baocao,

        ]);
    }
    public function showmcgop(Request $req) {
        $minhchung_gop = DB::table("minhchung_gop")
                ->orderBy('created_at', 'asc');
        if($req->report_id != null && $req->report_id != ""){
            $minhchung_gop = $minhchung_gop->where("id_kehoach_baocao", $req->report_id);
        }
        if($req->standard_id != null && $req->standard_id != ""){
            $minhchung_gop = $minhchung_gop->where("id_tieuchuan", $req->standard_id);
        }
        if($req->criteria_id != null && $req->criteria_id != ""){
            $minhchung_gop = $minhchung_gop->where("id_tieuchi", $req->criteria_id);
        }
        return DataTables::of($minhchung_gop)  
            ->addColumn(
                'tieuDe',
                function ($mcg) {
                    return '<a href="'. 
                        route('admin.tudanhgia.preparereport.editmcgop', $mcg->id)
                     .'" title="'. $mcg->trich_yeu .'">'. 
                        str_limit($mcg->tieu_de,60)
                     .'</a>';
                }
            )
            ->addColumn(
                'kieuMC',
                function ($mcg) {
                    $countMCG = DB::table("minhchunggop_minhchung")
                                ->where("minhchunggop_id", $mcg->id)->count();
                    if($countMCG > 1)
                        return '<span class="badge badge-warning">'. 
                            Lang::get('project/Selfassessment/title.mcgop')
                         .'</span>';
                    else
                        return '<span class="badge badge-info">'. 
                            Lang::get('project/Selfassessment/title.mcdl')
                         .'</span>';
                }
            )
            ->addColumn(
                'sttTieuchi',
                function ($mcg) {
                    $tieuchi = DB::table("tieuchi")->where("id", $mcg->id_tieuchi)
                            ->select("tieuchuan_id", "stt")->first();
                    $tieuchuan = DB::table("tieuchuan")->where("id", $tieuchi->tieuchuan_id)
                            ->select("stt")->first();
                    return '<span class="badge badge-success">' 
                            . $tieuchuan->stt . '.' . $tieuchi->stt.
                     '</span>';
                }
            )
            ->addColumn(
                'countMctt',
                function ($mcg) {
                    $countMctt = DB::table("minhchunggop_minhchungtt")
                                ->where("minhchunggop_id", $mcg->id)->count();
                    if($countMctt == 0 )
                        return '<span class="badge badge-warning">'. 
                            Lang::get('project/Selfassessment/title.kcmctt')
                         .'</span>';
                    else
                        return '<span class="badge badge-success">'. 
                            Lang::get('project/Selfassessment/title.cmctt')
                         .'</span>';
                }
            )
            ->addColumn(
                'minhchung',
                function ($mcg) {
                    $mcg_mc = DB::table("minhchunggop_minhchung")
                                ->where("minhchunggop_id", $mcg->id)->get();
                    $minhchungid = [];
                    foreach($mcg_mc as $value){
                        array_push($minhchungid, $value->minhchung_id);
                    }
                    $minhchung = DB::table("minhchung")->whereIn("id", $minhchungid)
                                ->select("tieu_de", "id")->get();
                    $html = "";
                    foreach($minhchung as $mc){
                        $html .= ' 
                            <div class="block-minhchung">
                                <span class="text-info">'. $mc->tieu_de .'</span>';
                            
                                $html .= '<button title="'. 
                                        Lang::get('project/Selfassessment/title.xmctp')
                                     .'" class="btn" data-toggle="modal" data-target="#modalDeleteItem" data-minhchunggop="'. $mcg->id .'" data-minhchung="'. $mc->id .'"><i class="bi bi-x-circle" style="font-size: 35px;color: orange;"></i></button>
                                </div>';
                            


                    }
                    return $html;
                }
            )
            ->addColumn(
                'actions',
                function ($mcg) {
                    $actions = '<a href="'. route('admin.tudanhgia.preparereport.viewmcgop', $mcg->id) .'" title="'. 
                        Lang::get('project/Selfassessment/title.xemmcg')
                     .'" class="btn">
                        <i class="bi bi-eye-fill" style="font-size: 30px;color: #50cd89;"></i>
                        </a>';
                    
                        $actions = $actions. '<button title="'. 
                        Lang::get('project/Selfassessment/title.xmcg')
                     .'" class="btn" data-toggle="modal" data-target="#modalDeleteGroup" data-minhchunggop="' .$mcg->id. '"><i class="bi bi-x-circle" style="font-size: 35px;color: red;"></i></button>';
                    
                    
                    return $actions;
                }
            )
            
            
            ->rawColumns(['actions', 'tieuDe', 'kieuMC', 'sttTieuchi', 'countMctt', 'minhchung'])
            ->make(true);
    }
    public function viewmcgop($id){
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        $linhvuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();

        $mcgop = DB::table("minhchung_gop")->where("id", $id)->first();

        // lấy minh chứng
        $mcg_mc = DB::table("minhchunggop_minhchung")
                ->where("minhchunggop_id", $id);
        $countMc = $mcg_mc->count();
        $list_id_mc = [];
        foreach($mcg_mc->get() as $value){
            array_push($list_id_mc, $value->minhchung_id);
        }
        $minhchung = DB::table("minhchung")->whereIn("id", $list_id_mc)->get();

        // lấy minh chứng tối thiểu
        $mcg_mctt = DB::table("minhchunggop_minhchungtt")
                ->where("minhchunggop_id", $id);
        $countMctt = $mcg_mctt->count();
        $list_id_mctt = [];
        foreach($mcg_mctt->get() as $value){
            array_push($list_id_mctt, $value->minhchungtt_id);
        }
        $minhchungtt = DB::table("minhchung_tt")->whereIn("id", $list_id_mctt)->get();
        $listminhchungtoithieu = array();
        foreach ($minhchungtt as $key => $value) {
            array_push($listminhchungtoithieu,$value->id);
        }
        
        // if(empty($mcgop->id_kehoach_baocao)){
        //     return "<h1 style = 'color:red; text-align : center'>Không tìm thấy minh chứng vui lòng thêm minh chứng</h1>";
        // }
        // báo cáo, tiêu chuẩn, tiêu chí
        $baocao = DB::table("kehoach_baocao")->where("id", $mcgop->id_kehoach_baocao)
                    ->first();
        $tieuchuan = DB::table("tieuchuan")->where("id", $mcgop->id_tieuchuan)->first();
        $tieuchi = DB::table("tieuchi")->where("id", $mcgop->id_tieuchi)->first();
        // load list
        if($baocao){
            $listTC =  DB::table("kehoach_tieuchuan")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', 
                        '=', 'kehoach_tieuchuan.tieuchuan_id')
                    ->where("kehoach_tieuchuan.id_kh_baocao", $baocao->id)
                    ->select('kehoach_tieuchuan.id_kh_baocao',
                            'kehoach_tieuchuan.tieuchuan_id',
                            'kehoach_tieuchuan.truongnhom',
                            'tieuchuan.stt', 'tieuchuan.mo_ta'
                    )
                    ->get();
            }else{
                $listTC = Collect();
            }
        

        $listTChi = DB::table("tieuchi")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', '=', 'tieuchi.tieuchuan_id')
                    ->where("tieuchi.tieuchuan_id", $mcgop->id_tieuchuan)
                    ->select('tieuchi.stt', 'tieuchi.id', 'tieuchi.tieuchuan_id', 'tieuchi.mo_ta', 'tieuchuan.stt AS sttTC')
                    ->get();

        $tchi_mctt = DB::table("role_mctt_tchi")
                        ->where("tieuchi_id", $mcgop->id_tieuchi)->get();
        $mctt_id = [];
        foreach($tchi_mctt as $value){
            array_push($mctt_id, $value->mctt_id);
        }
        $listMCTT = DB::table("minhchung_tt")->whereIn("id", $mctt_id)
                ->select('id', 'tieu_de')
                ->get();

        return view('admin.project.Selfassessment.viewmcgop')->with([
            'kehoach_baocao' => $kehoach_baocao,
            'linhvuc'       => $linhvuc,
            'donvi'         => $donvi,
            'mcgop'         => $mcgop,
            'countMc'       => $countMc,
            'minhchung'     => $minhchung,
            'countMctt'     => $countMctt,
            'minhchungtt'   => $minhchungtt,
            'baocao'        => $baocao,
            'tieuchuan'     => $tieuchuan,
            'tieuchi'       => $tieuchi,
            'listTC'        => $listTC,
            'listTChi'      => $listTChi,
            'listMCTT'      => $listMCTT,
            'listminhchungtoithieu' => $listminhchungtoithieu,
        ]);
    }
    public function deleteMctp(Request $req){
        $minhchungtp_id = $req->minhchungid;
        $minhchunggop_id = $req->minhchunggopid;

        $minhchungGop = DB::table("minhchung_gop")->where("id", $minhchunggop_id)->first();
        //$kehoach_baocao = DB::table("kehoach_baocao")->where("id", $minhchungGop->id_kehoach_baocao)->first();

        $minhChungGop_minhchung = DB::table('minhchunggop_minhchung')
                            ->where('minhchunggop_id', $minhchunggop_id)
                            ->where('minhchung_id', $minhchungtp_id)
                            ->delete();
        $response = [
                'message'=> Lang::get('project/Selfassessment/title.xmctptc'),
                'status' => true
        ];
        return json_encode($response);
    }
    public function deleteMcGroup(Request $req){
        $minhchunggop_id = $req->minhchunggopid;
        $minhchungGop = DB::table("minhchung_gop")->where("id", $minhchunggop_id);

        $minhChungGop_minhchung = DB::table('minhchunggop_minhchung')
                        ->where('minhchunggop_id', $minhchungGop->first()->id)->delete();
        $minhchungGop->delete();
        $response = [
                'message'=> Lang::get('project/Selfassessment/title.xmcgtc'),
                'status' => true
        ];
        return json_encode($response);
    }
    public function proofHandGroup() {
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        foreach($kehoach_baocao as $key => $khbc){
            $findTC = DB::table("kehoach_tieuchuan")->where("id_kh_baocao", $khbc->id);
            if($findTC->count() == 0){
                unset($kehoach_baocao[$key]);
            }
        }
        
        $linhvuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();

        return view('admin.project.Selfassessment.proofhandgroup')->with([
            'kehoach_baocao' => $kehoach_baocao,
            'linhvuc'       => $linhvuc,
            'donvi'         => $donvi
        ]);
    }

    public function searchMctt(Request $req) {
        if($req->id_criteria != null && $req->id_criteria != ""){
            $tchi_mctt = DB::table("role_mctt_tchi")
                        ->where("tieuchi_id", $req->id_criteria)->get();
            $mctt_id = [];
            foreach($tchi_mctt as $value){
                array_push($mctt_id, $value->mctt_id);
            }
            $mctt = DB::table("minhchung_tt")->whereIn("id", $mctt_id)
                    ->select('id', 'tieu_de')
                    ->get();
            return json_encode($mctt);
        }else{
            return json_encode([]);
        }
    }

    public function gopMinhChung(Request $req){
        if($req->update != null && $req->update != ""){
            $data = [
                'tieu_de'       => $req->tenminhchung,
                'trich_yeu'     => $req->trichyeu,
                'cong_khai'     => $req->congkhai,
                'id_tieuchuan'  => $req->tieuchuan,
                'id_tieuchi'    => $req->tieuchi,
                'nguoi_tao'     => Sentinel::getUser()->id,
                'id_csdt'       => Sentinel::getUser()->csdt_id,
                'id_kehoach_baocao'     => $req->baocao_id
            ];
            $mcgop = DB::table("minhchung_gop")->where("id", $req->idmcGop)->update($data);
            DB::table("minhchunggop_minhchungtt")->where("minhchunggop_id", $req->idmcGop)
                    ->delete();
            DB::table("minhchunggop_minhchung")->where("minhchunggop_id", $req->idmcGop)
                    ->delete();
            foreach($req->mctthieu as $value){
                $data2 = [
                    'minhchunggop_id' => $req->idmcGop,
                    'minhchungtt_id' => $value
                ];
                DB::table("minhchunggop_minhchungtt")->insert($data2);
            }
            foreach($req->listMinhChung as $value){
                $data3 = [
                    'minhchunggop_id' => $req->idmcGop,
                    'minhchung_id' => $value['id']
                ];
                DB::table("minhchunggop_minhchung")->insert($data3);
            }

            $response = [
                'message'=> Lang::get('project/Selfassessment/title.cnmctc'),
                'status' => true
            ];
            return json_encode($response);
        }else{
            $data = [
                'tieu_de'       => $req->tenminhchung,
                'trich_yeu'     => $req->trichyeu,
                'cong_khai'     => $req->congkhai,
                'id_tieuchuan'  => $req->tieuchuan,
                'id_tieuchi'    => $req->tieuchi,
                'nguoi_tao'     => Sentinel::getUser()->id,
                'id_csdt'       => Sentinel::getUser()->csdt_id,
                // 'id_hoatdongnhom'   => $req->hoatdongId,
                'id_kehoach_baocao'     => $req->baocao_id
            ];
            $id_mcGop = DB::table("minhchung_gop")->insertGetId($data);
            
            foreach($req->mctthieu as $value){
                $data2 = [
                    'minhchunggop_id' => $id_mcGop,
                    'minhchungtt_id' => $value
                ];
                DB::table("minhchunggop_minhchungtt")->insert($data2);
            }
            foreach($req->listMinhChung as $value){
                $data3 = [
                    'minhchunggop_id' => $id_mcGop,
                    'minhchung_id' => $value['id']
                ];
                DB::table("minhchunggop_minhchung")->insert($data3);
            }
            
            $response = [
                'message'=> Lang::get('project/Selfassessment/title.gmctc'),
                'status' => true
            ];
            return json_encode($response);
        }
    }
    public function editmcgop($id) {
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        $linhvuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();

        $mcgop = DB::table("minhchung_gop")->where("id", $id)->first();

        // lấy minh chứng
        $mcg_mc = DB::table("minhchunggop_minhchung")
                ->where("minhchunggop_id", $id);
        $countMc = $mcg_mc->count();
        $list_id_mc = [];
        foreach($mcg_mc->get() as $value){
            array_push($list_id_mc, $value->minhchung_id);
        }
        $minhchung = DB::table("minhchung")->whereIn("id", $list_id_mc)->get();

        // lấy minh chứng tối thiểu
        $mcg_mctt = DB::table("minhchunggop_minhchungtt")
                ->where("minhchunggop_id", $id);
        $countMctt = $mcg_mctt->count();
        $list_id_mctt = [];
        foreach($mcg_mctt->get() as $value){
            array_push($list_id_mctt, $value->minhchungtt_id);
        }
        $minhchungtt = DB::table("minhchung_tt")->whereIn("id", $list_id_mctt)->get();
        $listminhchungtoithieu = array();
        foreach ($minhchungtt as $key => $value) {
            array_push($listminhchungtoithieu,$value->id);
        }

    
        // báo cáo, tiêu chuẩn, tiêu chí
        // if(empty($mcgop->id_kehoach_baocao)){
        //     return view('admin.project.Selfassessment.michchungpdf');
        // }
        $baocao = DB::table("kehoach_baocao")->where("id", $mcgop->id_kehoach_baocao)
                    ->first();
        $tieuchuan = DB::table("tieuchuan")->where("id", $mcgop->id_tieuchuan)->first();
        $tieuchi = DB::table("tieuchi")->where("id", $mcgop->id_tieuchi)->first();
        // load list
        if($baocao){
            $listTC =  DB::table("kehoach_tieuchuan")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', 
                        '=', 'kehoach_tieuchuan.tieuchuan_id')
                    ->where("kehoach_tieuchuan.id_kh_baocao", $baocao->id)
                    ->select('kehoach_tieuchuan.id_kh_baocao',
                            'kehoach_tieuchuan.tieuchuan_id',
                            'kehoach_tieuchuan.truongnhom',
                            'tieuchuan.stt', 'tieuchuan.mo_ta'
                    )
                    ->get();
            }else{
                $listTC = Collect();
            }
        

        $listTChi = DB::table("tieuchi")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', '=', 'tieuchi.tieuchuan_id')
                    ->where("tieuchi.tieuchuan_id", $mcgop->id_tieuchuan)
                    ->select('tieuchi.stt', 'tieuchi.id', 'tieuchi.tieuchuan_id', 'tieuchi.mo_ta', 'tieuchuan.stt AS sttTC')
                    ->get();

        $tchi_mctt = DB::table("tieuchi_minhchungtt")
                        ->where("tieuchi_id", $mcgop->id_tieuchi)->get();
        $mctt_id = [];
        foreach($tchi_mctt as $value){
            array_push($mctt_id, $value->minhchungtt_id);
        }
        $listMCTT = DB::table("minhchung_tt")->whereIn("id", $mctt_id)
                ->select('id', 'tieu_de')
                ->get();

        return view('admin.project.Selfassessment.editproofgroup')->with([
            'kehoach_baocao' => $kehoach_baocao,
            'linhvuc'       => $linhvuc,
            'donvi'         => $donvi,
            'mcgop'         => $mcgop,
            'countMc'       => $countMc,
            'minhchung'     => $minhchung,
            'countMctt'     => $countMctt,
            'minhchungtt'   => $minhchungtt,
            'baocao'        => $baocao,
            'tieuchuan'     => $tieuchuan,
            'tieuchi'       => $tieuchi,
            'listTC'        => $listTC,
            'listTChi'      => $listTChi,
            'listMCTT'      => $listMCTT,
            'listminhchungtoithieu' => $listminhchungtoithieu,
        ]);
    }


    // đối chiếu minh chứng
    public function proofCompare(Request $req){
        $keHoachBaoCaoDetail = null;
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        $listTieuChi = DB::table("tieuchi")->orderBy('created_at', 'asc')
                        ->select("id", "stt", "mo_ta", "tieuchuan_id");

        $renderView = false;
        if($req->report_id != null){
            $keHoachBaoCaoDetail = DB::table("kehoach_baocao")->where("id", $req->report_id)
                            ->first();
            $renderView = true;
        }
        if($req->standard_id != null){
            $listTieuChi = $listTieuChi->where("tieuchuan_id", $req->standard_id);
            $renderView = true;
        }
        if($req->criteria_id != null){
            $listTieuChi = $listTieuChi->where('id', $req->criteria_id);
            $renderView = true;
        }

        $listTieuChi = $listTieuChi->paginate(20);

        return view('admin.project.Selfassessment.proofcompare')->with([
            'kehoach_baocao'        => $kehoach_baocao,
            'listTieuChi'           => $listTieuChi,
            'keHoachBaoCaoDetail'       => $keHoachBaoCaoDetail,
            'renderView'            => $renderView
        ]);
        
    }

    public function createMcGop(Request $req){
        $kehoach_baocao = DB::table("kehoach_baocao")->select("id", "ten_bc")->get();
        $linhvuc = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();

        if(isset($req->minhchung_tt) && $req->minhchung_tt != null){
            $kehoach_baocao_search = DB::table("kehoach_baocao")
                    ->where("id", Request()->report_id)
                    ->select("id", "ten_bc")->first();

            $kehoach_tieuchuan = null;
            $tieuchi = null;
            $mctt = null;
            if(isset($req->standard_id) && $req->standard_id != null){
                $kehoach_tieuchuan = DB::table("kehoach_tieuchuan")
                        ->leftjoin('tieuchuan', 'tieuchuan.id', 
                            '=', 'kehoach_tieuchuan.tieuchuan_id')
                        ->where("kehoach_tieuchuan.id_kh_baocao", Request()->report_id)
                        ->select('kehoach_tieuchuan.id_kh_baocao',
                                'kehoach_tieuchuan.tieuchuan_id',
                                'kehoach_tieuchuan.truongnhom',
                                'tieuchuan.stt', 'tieuchuan.mo_ta'
                        )
                        ->get();
                $tieuchi = DB::table("tieuchi")
                    ->leftjoin('tieuchuan', 'tieuchuan.id', '=', 'tieuchi.tieuchuan_id')
                    ->where("tieuchi.tieuchuan_id", Request()->standard_id)
                    ->select('tieuchi.stt', 'tieuchi.id', 'tieuchi.tieuchuan_id', 'tieuchi.mo_ta',
                     'tieuchuan.stt AS sttTC')
                    ->get();

                $tchi_mctt = DB::table("tieuchi_minhchungtt")
                            ->where("tieuchi_id", Request()->criteria_id)->get();
                $mctt_id = [];
                foreach($tchi_mctt as $value){
                    array_push($mctt_id, $value->minhchungtt_id);
                }
                $mctt = DB::table("minhchung_tt")->whereIn("id", $mctt_id)
                        ->select('id', 'tieu_de')
                        ->get();
            }




            return view('admin.project.Selfassessment.proofhandgroup')->with([
                'kehoach_baocao' => $kehoach_baocao,
                'linhvuc'       => $linhvuc,
                'donvi'         => $donvi,
                'kehoach_baocao_search' => $kehoach_baocao_search,
                'kehoach_tieuchuan' => $kehoach_tieuchuan,
                'tieuchi'              => $tieuchi,
                'mctt'         => $mctt,
                'minhchung_tt'  => $req->minhchung_tt
            ]);
        }else{
            return view('admin.project.Selfassessment.proofhandgroup')->with([
                'kehoach_baocao' => $kehoach_baocao,
                'linhvuc'       => $linhvuc,
                'donvi'         => $donvi
            ]);
        }        
    }

    public function xoaMinhChung(Request $req){
        $kehoach_baocao = DB::table("kehoach_baocao")->where("id", $req->idKhbc);            
        if($kehoach_baocao->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddbc'),
            ]);
        }

        $minhChungGop = DB::table("minhchung_gop")->where([
            ['id', $req->mcGopId],
            ['id_kehoach_baocao', $req->idKhbc]
        ]);
        if($minhChungGop->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddmctp'),
            ]);
        }

        // Xóa minh chứng thành phần
        $mcgmc = DB::table("minhchunggop_minhchung")
                ->where("minhchunggop_id", $req->mcGopId)
                ->where("minhchung_id", $req->mcId)
                ->delete();
        if(DB::table("minhchunggop_minhchung")->where("minhchunggop_id", $req->mcGopId)
            ->count() == 0){
            $mcgmctt = DB::table("minhchunggop_minhchungtt")
                ->where("minhchunggop_id", $req->mcGopId)
                ->delete();
            $minhChungGop->delete(); 
        }
          

        return json_encode([
            'mes'   => Lang::get('project/Selfassessment/title.mcddx'),
        ]);
    }


    public function xacnhanTchi(Request $req){
        $kehoach_baocao = DB::table("kehoach_baocao")->where("id", $req->idKhbc);            
        if($kehoach_baocao->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddbc'),
            ]);
        }

        $tieuchi = DB::table("tieuchi")->where("id", $req->idTchi);
        if($tieuchi->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddtc'),
            ]);
        }

        $minhChungGop = DB::table("minhchung_gop")->where([
            ['id_tieuchi', $req->idTchi],
            ['id_kehoach_baocao', $req->idKhbc]
        ])->update(['xacnhan' => 'Y']);

        return json_encode([
            'mes'   => Lang::get('project/Selfassessment/title.xnmctc'),
        ]);
    }

    public function boxacnhanTchi(Request $req){
        $kehoach_baocao = DB::table("kehoach_baocao")->where("id", $req->idKhbc);            
        if($kehoach_baocao->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddbc'),
            ]);
        }

        $tieuchi = DB::table("tieuchi")->where("id", $req->idTchi);
        if($tieuchi->count() == 0){
            return json_encode([
                'mes'   => Lang::get('project/Selfassessment/title.knddtc'),
            ]);
        }

        $minhChungGop = DB::table("minhchung_gop")->where([
            ['id_tieuchi', $req->idTchi],
            ['id_kehoach_baocao', $req->idKhbc]
        ])->update(['xacnhan' => 'N']);

        return json_encode([
            'mes'   => Lang::get('project/Selfassessment/title.bxnmctc'),
        ]);
    }

    
}