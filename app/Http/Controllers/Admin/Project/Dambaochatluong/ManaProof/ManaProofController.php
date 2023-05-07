<?php namespace App\Http\Controllers\Admin\Project\Dambaochatluong\ManaProof;

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
use App\Exports\ProofExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
class ManaProofController extends DefinedController
{
    public function index(){
        $linhvuc = DB::table('nhom_mc_sl')->orderBy('mo_ta')->select('id', 'mo_ta')->get();
        $donvi = DB::table('donvi')->orderBy('ten_donvi')->select('id', 'ten_donvi')->get();
        return view('admin.project.QualiAssurance.manaproof')->with([
            "linhvuc" =>  $linhvuc,
            "donvi" =>  $donvi,
            
        ]);
    }

    public function getHD(Request $req){            
        $res = DB::table('hoatdongnhom')
            ->whereNull('deleted_at');

        if(isset($req->year) && $req->year != ''){
            $res = $res
            ->where('year',$req->year);
        }

        if(isset($req->linhvuc) && $req->linhvuc != ''){
            $res = $res->where('nhom_mc_sl_id',$req->linhvuc);
        }

        if(isset($req->hoatdong) && $req->hoatdong != ''){
            $res = $res->where('parent',$req->hoatdong);
        }else{
            $res = $res->where("parent", 0);
        }
        $res = $res->orderBy('noi_dung')->get();
        $arr = array();
        foreach ($res as $key => $value) {
            array_push($arr, array($value->id,$value->noi_dung));
        }
        return $arr;
    }

    public function getQL(Request $req){
        $res = DB::table('users')->select('id','name')->whereNull('deleted_at');
        
        $from = (intval($req->page) - 1) * 10;
        $search = $req->search;
        if($search != ''){
            $res = $res->where('name','like',"%".$search."%");
        }
        
        $count = $res->count();

        $res = $res->skip($from)->take(10)->get();
        $arr = array();
        foreach ($res as $key => $value) {
            array_push($arr, array('id' => $value->id, 'text' => $value->name));
        }
        return array( 'result' => $arr, 'count_filtered' => $count);
    }

    public function getTukhoa(Request $req){
        $res = DB::table('tukhoa');                
        if(isset($req->linhvuc) && $req->linhvuc != ''){
            $res = $res->leftJoin('tukhoa_minhchung','tukhoa.tk_id','=','tukhoa_minhchung.tkmc_tk_id')->where('tkmc_nhom_mc_sl_id',$req->linhvuc);
        }
        if(isset($req->tukhoa) && $req->tukhoa != ''){
            $res = $res->where('tk_name','like', $req->tukhoa . '%')->orderBy('tk_name');
        }
        $res = $res->get();
        $arr = array();
        foreach ($res as $key => $value) {
            array_push($arr, $value->tk_name);
        }
        return json_encode($arr);
    }
    
    public function viewProof(Request $req){
        $res = DB::table('minhchung')
                ->leftJoin('users','users.id','=','minhchung.nguoi_tao')
                ->leftJoin('donvi','users.donvi_id','=','donvi.id')
                ->select('minhchung.id as mc_id','tieu_de','ngay_ban_hanh','noi_banhanh','cong_khai','count_size','ten_donvi', 'trich_yeu', 'minhchung.duong_dan', 'minhchung.url', 'minhchung.tinh_trang','minhchung.sohieu')
                ->where('minhchung.deleted_at',NULL)
                ->orderBy('minhchung.updated_at','desc');

        if(isset($req->tieude) && $req->tieude != ''){
            $res = $res->where(function ($q) use ($req){
                $q->orWhere('minhchung.tieu_de','like',"%$req->tieude%")
                    ->orWhere('minhchung.trich_yeu','like',"%$req->tieude%")
                    ->orWhere('minhchung.ten_file','like',"%$req->tieude%");
            }); 
        }

        if(isset($req->nam) && $req->nam != ''){
            $res = $res->whereYear('minhchung.ngay_ban_hanh',$req->nam);  
            //echo $req->nam . "<br/>";   
        }

        if(isset($req->linhvuc) && $req->linhvuc != ''){
            $res = $res->where('nhom_mc_sl_id',$req->linhvuc);  
            //echo $req->linhvuc . "<br/>";    
        }

        if(isset($req->hoatdong) && $req->hoatdong != ''){
            $res = $res->where('hoatdongnhom_id',$req->hoatdong);   
            //echo $req->hoatdong . "<br/>";
        }

        if(isset($req->tdmc) && $req->tdmc != ''){
            $res = $res->where('minhchung.tieu_de','like',"%$req->tdmc%");
        }

        if(isset($req->tyeu) && $req->tyeu != ''){
            $res = $res->where('minhchung.trich_yeu','like',"%$req->tyeu%");
        }

        if(isset($req->sohieu) && $req->sohieu != ''){
            $res = $res->where('minhchung.sohieu','like',"%$req->sohieu%");
        }

        if(isset($req->diachi) && $req->diachi != ''){
            $res = $res->where('minhchung.address','like',"%$req->diachi%");
        }

        if(isset($req->tukhoa) && $req->tukhoa != ''){
            $res = $res->leftjoin('tukhoa_minhchung','tukhoa_minhchung.tkmc_mc_id','=','minhchung.id')->leftjoin('tukhoa','tukhoa_minhchung.tkmc_tk_id','=','tukhoa.tk_id')->where('tk_name','like',"%" . mb_strtolower($req->tukhoa,'UTF-8') . "%");
        }

        return DataTables::of($res) 
            ->addColumn('actions',function($user){                    
                    $actions = '';
                    $actions .= ' <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        
                      ';

                    if(isset($user->url) && $user->url != ''){
                        $actions .='
                            <a class="dropdown-item" target="_blank" href="' . $user->url .'" class="btn">
                                '. Lang::get('project/QualiAssurance/title.xemduongdan') .'
                            </a>
                        ';
                    }

                    if(isset($user->duong_dan) && $user->duong_dan != ''){
                        $actions .='
                            <a class="dropdown-item" target="_blank" href="' . route('admin.dambaochatluong.manaproof.showProof',$user->mc_id) .'" class="btn">
                                '. Lang::get('project/QualiAssurance/title.xemminhchung') .'
                            </a>
                        ';
                    }
                    $actions .= "</div> </div>";

                                        
                    $actions = $actions.'<a href="' . route('admin.dambaochatluong.manaproof.editProof',$user->mc_id) .'" 
                    class="btn" data-bs-placement="top" title="'.Lang::get('project/QualiAssurance/title.chinhsua').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</a>';                    
                    $actions = $actions. '<button type="button" class="btn " onclick="deleteconfirm(' . $user->mc_id . ');">
                        '. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'
                    </button>';
                    return $actions;
            })
            ->addColumn('ngayBan_hanh',function($user){
                if($user->ngay_ban_hanh != '' && $user->ngay_ban_hanh != '0000-00-00')
                    return date("d/m/Y", strtotime($user->ngay_ban_hanh));
                else 
                    return '';
            })
            ->addColumn('cong_khai_text',function ($user){
                if($user->cong_khai == 'Y'){
                    return '<span class="badge badge-success">' . Lang::get('project/QualiAssurance/title.congkhai') . '</span>';
                }else{
                    return '<span class="badge badge-danger">' . Lang::get('project/QualiAssurance/title.kocongkhai') . '</span>';
                }
            })
            ->addColumn('tinhTrang',function ($user){
                if($user->tinh_trang == 'xacnhan'){
                    return '<span class="badge badge-success">' . Lang::get('project/QualiAssurance/title.xacnhan') . '</span>';
                }else if($user->tinh_trang == 'dangcho'){
                    return '<span class="badge badge-warning">' . Lang::get('project/QualiAssurance/title.dangcho') . '</span>';
                }else if($user->tinh_trang == 'khongxacnhan'){
                    return '<span class="badge badge-danger">' . Lang::get('project/QualiAssurance/title.khongxacnhan') . '</span>';
                }
            })
            
            ->addColumn('checkBoxSelect',function($user){
                return '<button class="btn btn-info btn-block btn-select-item" 
                        data-id="'. $user->mc_id .'"
                        data-content = "'. $user->tieu_de .'"
                        data-trichyeu = "'. $user->trich_yeu .'"
                         >'.  
                         Lang::get('project/Selfassessment/title.chon') 
                 .'</button>';
            })
        ->rawColumns(['cong_khai_text','actions', 'checkBoxSelect', 'tinhTrang'])            
        ->make(true);
    }

    public function showProof(Request $req){
        $id = $req->id;

        $minhChungData = DB::table('minhchung')->where('trang_thai','active')->where('id',$id);

        $minhChungData = $this->dataExceptDelete($minhChungData)->first();

        if (!$minhChungData) {
            return abort(422, Lang::get('project/Selfassessment/title.minhchungkhongtontai'));
        }

        $viewMC = false;
        
        if (Sentinel::inRole('operator')) {
            $viewMC = true;
        }

        // if ($minhChungData->cong_khai == 'N') {
        //     if (Auth::user()->id == Auth::user()->donVi->truong_dv || Auth::user()->id == Auth::user()->donVi->canbo_dbcl) {
        //         //Trưởng đơn vị được xem tất của đơn vị mình và công khai của đơn vị khác
        //         if (Auth::user()->donVi->nhanSuList->pluck('id')->contains($minhChungData->nguoi_tao)) {
        //             $viewMC = true;
        //         }
        //     } else {
        //         //Người tạo được xem không công khai của chính mình và công khai của những người khác
        //         if ($minhChungData->nguoi_tao == Sentinel::getUser()->id) {
        //             $viewMC = true;
        //         }
        //     }
        // } else {
        //     $viewMC = true;
        // }

        $viewMC = true;
        if (!$viewMC) {
            return abort(422, "Bạn không được xem nội dung minh chứng này");
        }


        if (!Storage::disk('public')->exists($minhChungData->duong_dan)) {
            if ($minhChungData->url != '') {
                return redirect($minhChungData->url);
            }
            return abort(422, Lang::get('project/QualiAssurance/message.error.minhchungkhongtontai'));
        }
        return $this->downloadfile($minhChungData->duong_dan,$minhChungData->ten_file);
    }
    
    public function newProof(Request $req){
        $nguoi_quan_ly = DB::table("users")
            ->leftjoin("donvi", "users.donvi_id", "=", "donvi.id")
            ->select("users.id","users.name", "donvi.ten_donvi")->get();
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta');
        $linhvuc = $this->dataExceptDelete($linhvuc)->get();
        $hoatdong = DB::table('hoatdongnhom')->select('id', 'noi_dung');
        $hoatdong = $this->dataExceptDelete($hoatdong)->get();
        $idhdn = null;
        $hdn = null;
        $hoatDongNhomParent = null;
        $linhvucAll = null;
        $lv = null;
        if(isset($req->idhdn) && $req->idhdn != null){
            $idhdn = $req->idhdn;
            $hdn = DB::table('hoatdongnhom')->select("id", "noi_dung", "nhom_mc_sl_id", 
                "ngay_batdau", "ngay_hoanthanh", "cong_bo", "parent")
                        ->where("id", $idhdn)->first();
            if ($hdn->cong_bo == 'Y') {
                return back()->with('error', 
                        Lang::get('project/QualiAssurance/title.kcdmccb'));
            }
            if ($hdn->parent != 0) {
                $hoatDongNhomParent = DB::table("hoatdongnhom")
                        ->where("id", $hdn->parent)->first();
                $lv = DB::table("nhom_mc_sl")->where("id", $hoatDongNhomParent->nhom_mc_sl_id)
                            ->select("id", "mo_ta")->first();
            }
            $linhvucAll = DB::table("nhom_mc_sl")->select("id", "mo_ta")->get();
        }
        return view('admin.project.QualiAssurance.newproof')->with([
            "linhvuc" =>  $linhvuc,
            "hoatdong" =>  $hoatdong,
            // fix cứng
            "hdn" =>  $hdn,
            'hoatDongNhomParent'   => $hoatDongNhomParent,
            'linhvucAll'        => $linhvucAll,
            'lv'   => $lv,
            'nguoi_quan_ly' => $nguoi_quan_ly,
            'idhdn'     => $idhdn
        ]);

    }

    public function editProof(Request $req){
        $linhvuc = DB::table('nhom_mc_sl')->select('id', 'mo_ta');
        $linhvuc = $this->dataExceptDelete($linhvuc)->get();
        $hoatdong = DB::table('hoatdongnhom')->select('id', 'noi_dung');
        $hoatdong = $this->dataExceptDelete($hoatdong)->get();

        $minhchung = DB::table('minhchung')->where('id',$req->id)->first();
        if(!$minhchung){
            return Redirect::back()->with('error',Lang::get('project/QualiAssurance/message.error.minhchungkhongtontai'));
        }

        $minhchung->ngay_ban_hanh_text = Carbon::parse($minhchung->ngay_ban_hanh)->format('d-m-Y');

        $minhchung->nguoi_quan_ly_text = '';
        $nql = DB::table('users')->select('name')->where('id',$minhchung->nguoi_quan_ly)->first();
        if($nql){
            $minhchung->nguoi_quan_ly_text = $nql->name;
        } 
        $str = explode('.', $minhchung->ten_file);
        $minhchung->extfile = $str[sizeof($str) - 1];
        if($minhchung->duong_dan != '' && $minhchung->extfile != 'PDF' && $minhchung->extfile != 'pdf'){            
            $linkfile = $this->getlinkfile($minhchung->duong_dan);
            //$linkfile = str_replace('/','\\',$linkfile);
            if(file_exists($linkfile)){
                $fileContent = File::get($linkfile);
                $minhchung->imgfile = 'data:image/png;base64,' . base64_encode($fileContent);
            }else{
                $minhchung->imgfile = '';
            }
        }

        // get hoatdongnhom_id
        $hdn = DB::table('hoatdongnhom')
                ->select('hoatdongnhom.id','hoatdongnhom.parent')
                ->leftjoin('hoatdongnhom_minhchung','hoatdongnhom.id','=','hoatdongnhom_minhchung.hoatdongnhom_id')
                ->where('hoatdongnhom_minhchung.deleted_at',NULL)
                ->where('hoatdongnhom.deleted_at',NULL)
                ->where('minhchung_id',$req->id)->get();
        $minhchung->hoatdongnhom_id = '';
        foreach ($hdn as $key => $value) {
            $minhchung->hoatdongnhom_id = $value->parent;
            if($value->parent == ''){
                $minhchung->hoatdongnhom_id = $value->id;
            }
            break;            
        }         
        $minhchung->hoatdongnhom = $hdn;

        //get tu khoa
        $tk = DB::table('tukhoa')
                ->leftjoin('tukhoa_minhchung','tukhoa.tk_id','=','tukhoa_minhchung.tkmc_tk_id')
                ->where('tkmc_mc_id',$req->id)->orderBy('tk_name')->get();
        $minhchung->tukhoa = $tk;

        return view('admin.project.QualiAssurance.editproof')->with([
            "linhvuc" =>  $linhvuc,
            "hoatdong" =>  $hoatdong,
            "minhchung" => $minhchung,
        ]);
    }

    public function updateMC(Request $req){
        $mc_id = $req->mc_id;
        $str = explode('-', $req->ngay_ban_hanh);
        if(sizeof($str) == 3){
            $nbh = $str[2] . '-' . $str[1] . '-' . $str[0];
        }else{
            $nbh = null;
        }

        $data = array(
            'nhom_mc_sl_id' => $req->nhom_mc_sl_id,
            'tieu_de'       => $req->tieu_de,
            'trich_yeu'     => $req->trich_yeu,
            'noi_banhanh'   => $req->noi_banhanh,
            'address'       => $req->address,
            'sohieu'        => $req->sohieu,
            'ngay_ban_hanh' => $nbh,
            'url'           => $req->duong_dan,
            'nguoi_quan_ly' => $req->nguoi_quan_ly,
            'updated_at'    => date('Y-m-d H:i:s'),
            'cong_khai'     => isset($req->cong_khai) ? $req->cong_khai : 'N',
        );
        $duong_dan = '';

        if($file = $req->file('file')){
            // if (!$file->isValid()) {
            //     return Redirect::back()->withInput()->with('error',Lang::get('project/QualiAssurance/message.error.uploadfile'));
            // } 

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();               
            $size = $file->getClientSize();

            $checkmcexisted = DB::table('minhchung')
                            ->where('count_size',$size)
                            ->where('ten_file',$filename)->first();
            if($checkmcexisted){
                return Redirect::back()->withInput()->with('error',Lang::get('project/QualiAssurance/message.error.fileexisted'));
            }
            $duong_dan = $this->upload($file, 'minhchung');            
            if($duong_dan == false){
                return Redirect::back()->withInput()->with('error',Lang::get('project/QualiAssurance/message.error.uploadfile'));
            }   
            $data['duong_dan'] = $duong_dan;
            $data['count_size'] = $size;         
            $data['ten_file'] = $filename;
        }
        
        
        if($mc_id == 0 && $req->duong_dan == '' && $duong_dan == ''){
            return Redirect::back()->withInput()->with('error',Lang::get('project/QualiAssurance/message.error.emptymc'));
        }
        $user = Sentinel::getUser();        
                
        if($mc_id == 0){            
            $data['nguoi_tao'] = $user->id;
            $data['csdt_id'] = $user->csdt_id;
            $mc_id = DB::table('minhchung')->insertGetId($data);
        }else{
            $res = DB::table('minhchung')->where('id',$mc_id)->update($data);
        }

        // xử lý hoat dong nhom        
        $mcyc = $req->mcyc_id;
        $listhoatdong = array();
        if($mcyc != null && $mcyc != '' && sizeof($mcyc) > 0){
            foreach ($mcyc as $key => $value) {
                array_push($listhoatdong,$value);
            }
        }else{
            if(isset($req->hoatdongnhom_id) && $req->hoatdongnhom_id != ''){
                array_push($listhoatdong,$req->hoatdongnhom_id);
            }
        }

        if(sizeof($listhoatdong) > 0){
            foreach ($listhoatdong as $key => $value) {
                $chekhdn = DB::table('hoatdongnhom')->where('id',$value);
                $chek = $this->dataExceptDelete($chekhdn)->first();
                if($chek && $chek->cong_bo != 'Y'){
                    $dat = array(
                        'minhchung_id'      => $mc_id,
                        'hoatdongnhom_id'   => $value,
                        'nguoitao'          => $user->id,
                        'csdt_id'           => $user->csdt_id,
                        'created_at'        => date('Y-m-d H:i:s'),
                        'updated_at'        => date('Y-m-d H:i:s'),
                    );
                    $re = DB::table('hoatdongnhom_minhchung')->insert($dat);
                    $chekhdn = $chekhdn->update(array('cong_bo' => 'N'));
                }
            }
        }

        // remove all key assign for this mc
        $res = DB::table('tukhoa_minhchung')->where('tkmc_mc_id',$mc_id)->delete();

        // xử lý từ khóa
        $tukhoa = explode(',',$req->tukhoa);
        foreach ($tukhoa as $key => $value) {
            $tk = str_replace('  ', ' ', trim($value));
            $chek = DB::table('tukhoa')->whereRaw('LOWER(tk_name) = ?',[$tk])->first();
            if(!$chek){
                $tk_id = DB::table('tukhoa')->insertGetId(['tk_name' => $tk]);
            }else{
                $tk_id = $chek->tk_id;
            }

            $re = DB::table('tukhoa_minhchung')->insert([
                'tkmc_tk_id'    => $tk_id,
                'tkmc_mc_id'    => $mc_id,
                'tkmc_nhom_mc_sl_id'    => $req->nhom_mc_sl_id,
            ]);
        }

        // return Redirect::route('admin.dambaochatluong.manaproof.index')->with('success',Lang::get('project/QualiAssurance/message.success.store'));
        if(isset($req->idhdn) && $req->idhdn != ""){
            // $link = route('admin.dambaochatluong.updateaci.upGetMcyc') . "?id=" .$req->idhdn;
            // return redirect()->to($link)
            //     ->with('success',Lang::get('project/QualiAssurance/message.success.store'));
            return redirect()->route('admin.dambaochatluong.manaproof.index')->with('success',Lang::get('project/QualiAssurance/message.success.update'));
        }else{
            // return Redirect::back()->with('success',Lang::get('project/QualiAssurance/message.success.store'));
            return redirect()->route('admin.dambaochatluong.manaproof.index')->with('success',Lang::get('project/QualiAssurance/message.success.update'));
        }
    } 

    public function deleteMC(Request $req){
        $candelete = false;

        $mc = DB::table('minhchung')->where('id',$req->id)->first();
        if($mc){
            if(Sentinel::inRole('admin')){
                $candelete = true;
            }else{
                $userid = Sentinel::getUser()->id;
                if($mc->nguoi_tao == $userid || $mc->nguoi_quan_ly == $userid){
                    $candelete = true;
                }
            }    
        }

        if($candelete){
            $res = DB::table('minhchung')->where('id',$req->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            if($res){
                $res = DB::table('hoatdongnhom_minhchung')->where('minhchung_id',$req->id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                return 1;  
            } 
        }
        return 0;
    }


    public function checkuploadfile(Request $req){
        $filename = $req->filename;
        $size = $req->size;

        $checkmcexisted = DB::table('minhchung')
                        ->where('count_size',$size)
                        ->where('ten_file',$filename)->first();
        
        if($checkmcexisted){
            return route('admin.dambaochatluong.manaproof.editProof',$checkmcexisted->id);
        }else{
            return 1;
        }
    }

    public function exportProof(){
        return Excel::download(new ProofExport, 'Proof.xlsx');
    }
    public function xacnhanMC(Request $req){
        if($req->tinh_trang == 'xacnhan'){
            $minhchung = DB::table("minhchung")->where("id", $req->idmc)
                    ->update([
                        'tinh_trang'    => 'xacnhan'
                    ]);
        }
        if($req->tinh_trang == 'khongxacnhan'){
            $minhchung = DB::table("minhchung")->where("id", $req->idmc)
                    ->update([
                        'tinh_trang'    => 'khongxacnhan'
                    ]);
        }
        if($req->tinh_trang == 'molai'){
            $minhchung = DB::table("minhchung")->where("id", $req->idmc)
                    ->update([
                        'tinh_trang'    => 'dangcho'
                    ]);
        }
        

        return redirect()->route('admin.dambaochatluong.manaproof.index')->with('success',Lang::get('project/QualiAssurance/message.success.update'));
    }
}