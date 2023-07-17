<?php namespace App\Http\Controllers\Admin\Project\Thuongtruc\Category;

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
// export excel
use App\Exports\ManafieldExport;
use App\Exports\ListUserExport;
use App\Exports\CTDTExport;
use App\Exports\UnitExport;

//Import Excel
use App\Imports\UnitImportEx;
use App\Exports\CSDTExport;




class CategoryController extends DefinedController
{
    public function getCsdt() {
        if(Sentinel::check()){
            return Sentinel::getUser()->csdt_id;
        }
    }


    public function index(Request $req){
        echo "CategoryController";
    }

    public function data(Request $req){
        $linhvucs = $this->dataExceptDelete(
            DB::table('nhom_mc_sl')->orderBy('created_at', 'desc')
        );
        return DataTables::of($linhvucs)               
            ->addColumn(
                'actions',
                function ($linhvuc) {
                    $actions = '<button class="btn btn-block turnon-modalDe" data-id="'.$linhvuc->id.'">' . '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' . '</button>';
                    return $actions;
                }
            )
            ->addColumn(
                'human',
                function ($linhvuc) {
                    $user = DB::table("users")->where("id", $linhvuc->nguoi_tao)
                            ->select("name")->first();
                    return $user->name;
                }
            )
            ->addColumn(
                'dvpt',
                function ($linhvuc) {
                    $donvi = DB::table("donvi")->where("id", $linhvuc->donvi_id)
                            ->select("ten_donvi")->first();
                    if($donvi){
                        return $donvi->ten_donvi;
                    }else{
                        return "Không có dữ liệu";
                    }
                    
                }
            )
            ->addColumn(
                'id_dvpt',
                function ($linhvuc) {
                    $donvi = DB::table("donvi")->where("id", $linhvuc->donvi_id)
                            ->select("id")->first();
                    if($donvi){
                        return $donvi->id;
                    }else{
                        return "Không có dữ liệu";
                    }
                    
                }
            )
            ->addColumn(
                'createdAt',
                function ($linhvuc) {
                    return date("d/m/Y", strtotime($linhvuc->created_at));
                }
            )
            
            ->rawColumns(['actions', 'human'])
            ->make(true);
    }

    public function field(Request $req){
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();
        return view('admin.project.Standard.mana_manafield')->with([
            'donvis'     => $donvi
        ]); // thường trực - Quản lý danh mục (quản lý lĩnh vực)
    }

    public function updateManafield(Request $req) {
        $req->validate([
            'content_manafield' => 'required',
            'id_manafield'      => 'required',
        ]);

        $data = [
            'mo_ta'         =>  $req->content_manafield,
            'donvi_id'      =>  $req->select_dvpt,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ];
        DB::table("nhom_mc_sl")->where("id", $req->id_manafield)
                                ->update($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }

    public function deleteManafield(Request $req) {
        DB::table("nhom_mc_sl")->where("id", $req->id_manafield)
                ->delete();
                // ->update([
                //     'deleted_at' => Carbon::now()->toDateTimeString()
                // ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }
    
    public function createManafield() {
        $donvi = DB::table("donvi")->select("id", "ten_donvi")->get();
        return view('admin.project.Standard.create_manafield')->with([
            'donvi'     => $donvi
        ]); // thường trực - Quản lý danh mục (quản lý lĩnh vực - thêm mới lĩnh vực)
    }
    public function createManafields(Request $req){
        foreach($req->linhvuc as $key => $linhvuc){
            if($linhvuc != "" && $req->donvi[$key] != ""){
                 $data = [
                    'mo_ta'             =>   $linhvuc,
                    'so_lieu_mau'       =>   '',
                    'donvi_id'          =>   $req->donvi[$key],
                    'nguoi_tao'         =>   Sentinel::getUser()->id,
                    'csdt_id'           =>   $this->getCsdt(),
                    'created_at'        =>   Carbon::now()->toDateTimeString(),
                    'updated_at'        =>   Carbon::now()->toDateTimeString(),
                ];
                DB::table("nhom_mc_sl")->insert($data);
            }
           
        }
        return redirect()->route("admin.thuongtruc.manacategory.field")
                    ->with('success', 
                        Lang::get('project/Standard/message.success.create'));
    }

    public function exportManafield() {
        return Excel::download(new ManafieldExport(), 'manafield.xlsx');
    }
    public function unit(Request $req){
        $truong_dv = DB::table("users")->select("id", "name")->get();
        $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();

        $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $users = DB::table("users")->select("id", "name")->get();
        return view('admin.project.Standard.mana_manaunit')->with([
            'truong_dv'         => $truong_dv,
            'loai_dv'           => $loai_dv,
            'donvi'             => $donvi,
            'users'             => $users
        ]); // thường trực - Quản lý danh mục (quản lý đơn vị)
    }

    public function dataUnit(Request $req){
        $donvis = DB::table('donvi')->orderBy('id', 'desc');
        if(isset($req->id) && $req->id != ''){
            $donvis = $donvis->where("id", $req->id)->first();
            $users = DB::table("users")->where("donvi_id", $req->id)->select("id", "name")->get();
            return json_encode([$donvis, $users]);
        }else{
            $donvis = $donvis
                    ->select('id', 'ma_donvi', 'ten_donvi',
                     'created_at', 'truong_dv', 'nguoi_tao', 'deleted_at', 'loai_dv_id','dvcc')
                    ->where("trang_thai", "<>" ,"deleted");
            
            if(Sentinel::inRole('truongdonvi')){
                $donvis = $donvis->where("id", Sentinel::getUser()->donvi_id);
            }

            return DataTables::of($donvis)               
                ->addColumn(
                    'truongDv',
                    function ($donvi) {
                        $truong_dv = DB::table("users")->where("id", $donvi->truong_dv)
                                    ->select("name")
                                    ->first();
                        if($truong_dv){
                            return '<span>'. $truong_dv->name  .'</span>';
                        }else{
                            return '<span>'. Lang::get('project/Standard/title.kctt') .'</span>';
                        }
                    }
                )
                ->addColumn(
                    'loai_dv',
                    function ($donvi) { 
                        $loai_dv = DB::table("loai_donvi")->where("id", $donvi->loai_dv_id)
                                    ->select("loai_donvi")->first();
                        return $loai_dv->loai_donvi;
                    }
                )
                ->addColumn(
                    'dvcc',
                    function ($donvi) { 
                        $textDv = "";
                        $respon = $this->dequi($textDv, $donvi);
                        if($respon == "")
                            return '<span class="badge badge-warning">'. Lang::get('project/Standard/title.kcdvcc') .'</span>';
                        else
                            return $respon;
                    }
                )
                ->addColumn(
                    'createdAt',
                    function ($donvi) {
                        if($donvi->created_at)
                            return date("d/m/Y", strtotime($donvi->created_at));
                        else
                            return Lang::get('project/Standard/title.kctt');
                    }
                )
                ->addColumn(
                    'createHuman',
                    function ($donvi) {
                        $createHuman = DB::table("users")->where("id", $donvi->nguoi_tao)
                                    ->select("name")
                                    ->first();
                        if($createHuman){
                            return '<span>'. $createHuman->name  .'</span>';
                        }else{
                            return '<span>'. Lang::get('project/Standard/title.kctt') .'</span>';
                        }
                    }
                )
                ->addColumn(
                    'actions',
                    function ($donvi) {
                        $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$donvi->id.'" data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>'; 
                        $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
                        return $actions;
                    }
                )
                ->rawColumns(['actions', 'truongDv', 'createHuman', 'dvcc'])
                ->make(true);
        }
    }

    public function dequi($textDv, $donvi) {
        if($donvi->dvcc != null){
            $dvPa = DB::table("donvi")->where("id", $donvi->dvcc)
                    ->select("ten_donvi", "id", "dvcc")->first();
            if($textDv != "")
                $textDv = $dvPa->ten_donvi  . " - " . $textDv;
            else $textDv = $dvPa->ten_donvi;
            return $this->dequi($textDv, $dvPa);
        }else{
            return $textDv;
        }
    }



    public function deleteUnit(Request $req){
        DB::table('donvi')->where("id", $req->id_delete)
                ->update([
                    'trang_thai' => 'deleted'
                ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }
    public function updateUnit(Request $req){
        $tdv = DB::table("donvi")->where("id", $req->id_unit)->select("truong_dv")->first();
        if($tdv->truong_dv != ""){
            //echo $req->truongdvi;
            $usr = Sentinel::findById($tdv->truong_dv);
            $role = Sentinel::findRoleByName('truongdonvi');
            $role->users()->detach($usr);
        }

        $data = [
            'ma_donvi'              =>  $req->madvi,
            'ten_donvi'             =>  $req->tendvi,
            'ten_ngan'              =>  $req->tenngan,
            'dia_chi'               =>  $req->diachi,
            'mo_ta'                 =>  $req->mota,
            'truong_dv'             =>  $req->truongdvi,
            'canbo_dbcl'            =>  $req->cbdbcl,
            'nguoi_tao'             =>  Sentinel::getUser()->id,
            'csdt_id'               =>  $this->getCsdt(),
            'trang_thai'            =>  'active',
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
            'ten_tienganh'          =>  $req->tenen,
            'ten_donvi_cu'          =>  $req->tendvcu,
            'loai_dv_id'            =>  $req->loai_dv,
            'dvcc'                  =>  $req->dvcc == "" ? null : $req->dvcc,

            //'ten_ctdt'              =>  $req->tenctdt,
            //'ten_ctdt_tienganh'     =>  $req->tenctdten,
            //'ten_ctdt_cu'           =>  $req->tenctdtcu,
            //'ma_ctdt'               =>  $req->mactdt,

            'lhcsgd'                =>  $req->lhcsgd,
            'lvhd'                  =>  $req->linhvuc,
            'dien_thoai'            =>  $req->dienthoai,
            'email'                 =>  $req->email,
            'website'               =>  $req->website,
            'nam_thanhlap'          =>  $req->namtl,
            'nam_batdau'            =>  $req->nambd,
            'nam_capbang'           =>  $req->namcb,
            'mota_nam_thanhlap'     =>  $req->motantl,
            'gioi_thieu'            =>  $req->gioithieu,
            'co_cau_tochuc'         =>  $req->cctc,
        ];
        DB::table("donvi")->where("id", $req->id_unit)->update($data);

        
        $us = Sentinel::findById($req->truongdvi);
        $role_ = Sentinel::findRoleByName('truongdonvi');
        $role_->users()->attach($us);


        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
    public function createUnit(Request $req){
        $req->validate([
            'tendvi' => 'required',
        ]);
        $data = [
            'ma_donvi'              =>  $req->madvi,
            'ten_donvi'             =>  $req->tendvi,
            'mo_ta'                 =>  '',
            'loai_dv_id'            =>  $req->loaidv,
            'truong_dv'             =>  $req->truongdvi, 
            'canbo_dbcl'            =>  Sentinel::getUser()->id,
            'nguoi_tao'             =>  Sentinel::getUser()->id,
            'csdt_id'               =>  $this->getCsdt(),
            'trang_thai'            =>  'active',
            'created_at'            =>  Carbon::now()->toDateTimeString(),
            'updated_at'            =>  Carbon::now()->toDateTimeString(),
        ];

        if($req->truongdvi != ""){
            $find = DB::table("role_users")->where("user_id", $req->truongdvi)
                ->where("role_id", 8);
            if($find->count() == 0){
                $us = Sentinel::findById($req->truongdvi);
                $role_ = Sentinel::findRoleByName('truongdonvi');
                $role_->users()->attach($us);
            }
        }

        DB::table("donvi")->where("id", $req->id_unit)->insert($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }
    public function human(Request $req){
        // foreach(Sentinel::getRoleRepository()->all() as  $va){
        //     echo $va->id ."<br>";
        // }
        // @foreach($roles as $role)
        //     <option value="{{ $role->id }}"
        //         @if($role->id == old('role')) selected="selected" @endif >{{ $role->name}}
        //     </option>
        // @endforeach

        $donvi = DB::table('donvi')->select("id", "ten_donvi", "deleted_at")
                ->where("deleted_at", null)
                ->get();
        $chucvu = DB::table("chuc_vu")->select("id", "ten_chuc_vu")->get();
        return view('admin.project.Standard.mana_manahuman')->with([
            'donvi'     =>      $donvi,
            'chucvu'    =>      $chucvu
        ]); // thường trực - Quản lý danh mục (quản lý nhân sự)
    }

    public function createHuman(Request $req) {
        $req->validate([
            'mans' => 'required',
            'tendn' => 'required',
            'tenns' => 'required',
            'donvi' => 'required',
            'chucvu' => 'required',
        ]);
        // check exit tendn
        $checkTendn = DB::table("users")->where("email", $req->tendn)->count();
        if($checkTendn > 0) {
            return back()->with('error', 
                    Lang::get('project/Standard/message.error.duplicateData'));
        }else{
            // create folder
            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code = substr(str_shuffle($permitted_chars), 0, 20);
            $path = public_path().'/uploads/users/' . $code;
            File::makeDirectory( $path,0777,true);

            $data = [
                'ma_nhansu'     =>  $req->mans,
                'name'          =>  $req->tenns,
                'email'         =>  $req->tendn,
                'password'      =>  $req->tendn,
                'nguoi_tao'     =>  Sentinel::getUser()->id,
                'created_at'    =>  Carbon::now()->toDateTimeString(),
                'updated_at'    =>  Carbon::now()->toDateTimeString(),
                'code'          =>  $code,
                'donvi_id'      =>  $req->donvi,
                'csdt_id'       =>  $this->getCsdt(),   // chú ý
            ];
            // create Account
            $activeAcc = true;
            $user = Sentinel::register($data, $activeAcc);

            $us = Sentinel::findById($user->id);
            $activation = Activation::create($us);

            // admin role
            if($req->chucvu == 2){
                $role = Sentinel::findRoleById("4");
            }else if($req->chucvu == 3){
                $role = Sentinel::findRoleById("9");
            }else if($req->chucvu == 4){
                $role = Sentinel::findRoleById("2");
            }
            if ($role) {
                $role->users()->attach($user);
            }

            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New User Created by '.Sentinel::getUser()->full_name);
            // create role
            // $dataRole = [
            //     'user_id'   =>  $user->id,
            //     'chucvu_id' =>  $req->chucvu,
            //     'created_at'    =>  Carbon::now()->toDateTimeString(),
            //     'updated_at'    =>  Carbon::now()->toDateTimeString(),
            // ];
            // DB::table("role_chucvu_users")->insert($dataRole);
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
        }
    }

    public function dataHuman(Request $req) {
        $users = DB::table("users");
        if(isset($req->id_user) && $req->id_user != ""){
            $user = DB::table("users AS us")
                    ->select("us.id", "us.email", "us.ma_nhansu", "us.name", "us.donvi_id", "us.pic", "us.address", "us.phone", "us.description", "role.chucvu_id")
                    ->leftjoin('role_chucvu_users AS role', 'us.id', '=', 'role.user_id')
                    ->where("us.id", $req->id_user)
                    ->first();
            return json_encode($user);
        }else{
            $users = $this->dataExceptDelete(
                $users->select('id', 'ma_nhansu', 'email',
                     'name', 'donvi_id', 'created_at', 'nguoi_tao', 'deleted_at')
            );
            $users = $users->orderBy('created_at', 'desc');
            return DataTables::of($users)               
                ->addColumn(
                    'tenDV',
                    function ($user) {
                        $tenDV = DB::table("donvi")->where("id", $user->donvi_id)
                                ->select("ten_donvi")->first();
                        if($tenDV)
                            return $tenDV->ten_donvi;
                        else return " ";
                    }
                )
                ->addColumn(
                    'tenChucvu',
                    function ($user) {
                        $chucvu = "";
                        $role = DB::table("role_users")->where("user_id", $user->id)->select("role_id")->get();
                        foreach($role as $value){
                            if($value->role_id == "4" || $value->role_id == "9"){
                                $r = DB::table("roles")->select("fullname")->where("id", $value->role_id)->first();
                                $chucvu .= '<span class="badge badge-warning">'. $r->fullname .'</span>';
                            }
                        }
                        return $chucvu;
                    }
                )
                ->addColumn(
                    'createAt',
                    function ($user) {
                        return date("d/m/Y", strtotime($user->created_at));
                    }
                )
                ->addColumn(
                    'createHuman',
                    function ($user) {
                        $createHuman = DB::table('users')->where('id', $user->nguoi_tao)
                                    ->select('name')->first();
                        if($createHuman){
                            return $createHuman->name;
                        }else{
                            return '';
                        }
                    }
                )
                ->addColumn(
                    'actions',
                    function ($user) {
                        $checkUser = Sentinel::findById($user->id);
                        if($checkUser->inRole('admin') || $checkUser->inRole('operator'))
                            $actions = "";
                        else{
                            $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$user->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'. '<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>' .'</button>'; 
                            $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$user->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
                        }
                        return $actions;
                    }
                )
                ->rawColumns(['actions', 'createHuman', 'tenChucvu'])
                ->make(true);
        }
    }
    public function deleteHuman(Request $req) {
        if($req->id_delete != "1"){
            // DB::table("role_chucvu_users")
            //         ->where("user_id", $req->id_delete)
            //         ->delete();
            DB::table("users")->where("id", $req->id_delete)
                ->update([
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ]);
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
        }else{
            return back()->with('error', 
                    Lang::get('project/Standard/message.error.cannotDelete'));
        }
        
    }
    public function exportHumans() {
        return Excel::download(new ListUserExport, 'list-users.xlsx');
    }
    public function updateHuman(Request $req){
        $user = DB::table("users")->where("id", $req->id_user)
                ->select("code", "pic")
                ->first();
        if($req->file('image')){
            if($user->pic != null){
                File::delete(public_path($user->pic));
            }
            $file_temp = $req->file('image');
            $extension = $file_temp->getClientOriginalExtension() ?: 'png';
            $picName   = time().'-imageAvatar'.'.'.$extension;
            $file_temp->move(public_path('uploads/users/'.$user->code), $picName);
            $routePic = 'uploads/users/'.$user->code.'/'.$picName;
        }else{
            $routePic = $user->pic;
        }

        $data = [
            'ma_nhansu'     => $req->upmans,
            'name'          =>  $req->uptenns,
            'address'       =>  $req->updiachi,
            'phone'         =>  $req->upsdt,
            'donvi_id'      =>  $req->updonvi,
            'description'   =>  $req->upmota,
            'pic'           =>  $routePic
        ];
        DB::table("users")->where("id", $req->id_user)->update($data);

        
        if($req->upchucvu == '1'){
            $this->detachRole($req->id_user);
            $us = Sentinel::findById($req->id_user);
            $role_ = Sentinel::findRoleByName('truongdonvi');
            $role_->users()->attach($us);
        }else if($req->upchucvu == '2'){
            $this->detachRole($req->id_user);
            $us = Sentinel::findById($req->id_user);
            $role_ = Sentinel::findRoleByName('canboDBCL');
            $role_->users()->attach($us);
        }else if($req->upchucvu == '3'){
            $this->detachRole($req->id_user);
            $us = Sentinel::findById($req->id_user);
            $role_ = Sentinel::findRoleByName('khac');
            $role_->users()->attach($us);
        }else{
            $this->detachRole($req->id_user);
        }
       
        
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
    }
    public function detachRole($id_user){
        $us = Sentinel::findById($id_user);
        if(DB::table("role_users")->where("user_id", $id_user)->where("role_id", 8)->count() != 0){
            $role_1 = Sentinel::findRoleByName('truongdonvi');
            $role_1->users()->detach($us);
        }
        if(DB::table("role_users")->where("user_id", $id_user)->where("role_id", 4)->count() != 0){
            $role_2 = Sentinel::findRoleByName('canboDBCL');
            $role_2->users()->detach($us);
        }
        if(DB::table("role_users")->where("user_id", $id_user)->where("role_id", 9)->count() != 0){
            $role_3 = Sentinel::findRoleByName('khac');
            $role_3->users()->detach($us);
        }
    }

    public function ctdt(Request $req){
        $hdt = DB::table("he_dao_tao")->select("id", "ten_hdt")->get();
        $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
                ->where("deleted_at", null)
                ->get();
        $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
        return view('admin.project.Standard.mana_manactdt')->with([
            'hdt'       =>      $hdt,
            'donvi'     =>      $donvi,
            'loai_dv'   =>      $loai_dv
        ]); // thường trực - Quản lý danh mục (quản lý chương trình đào tạo)
    }

    public function datactdt(Request $req) {
        $ctdts = DB::table("ctdt");
        if(Sentinel::inRole('truongdonvi')){
            $ctdts = $ctdts->where('donvi_id', Sentinel::getUser()->donvi_id);
        }
        if(isset($req->id_search)  && $req->id_search != ""){
            $ctdt = $ctdts->where("id", $req->id_search)
                    ->select("id", "ma_ctdt", "tennganh", "tennganh_en", "hedaotao_id", "donvi_id", "sdt_lienhe", "dtkhoa1", "ncbkhoa1", "tentd")
                    ->first();
            return json_encode($ctdt);
        }else{
            $ctdts = $this->dataExceptDelete(
                $ctdts->select("id", "ma_ctdt", "tennganh", "tennganh_en", "hedaotao_id", "donvi_id", "created_at", "nguoi_tao", "deleted_at")
            );
            return DataTables::of($ctdts)               
                ->addColumn(
                    'hedaotao',
                    function ($ctdt) {
                        $hdt = DB::table("he_dao_tao")->where("id", $ctdt->hedaotao_id)
                                ->select("ten_hdt")->first();
                        if($hdt)
                            return $hdt->ten_hdt;
                        else return " ";
                    }
                )
                ->addColumn(
                    'donvi',
                    function ($ctdt) {
                        $donvi = DB::table("donvi")->where("id", $ctdt->donvi_id)
                                ->select("ten_donvi")->first();
                        if($donvi)
                            return $donvi->ten_donvi;
                        else return " ";
                    }
                )
                ->addColumn(
                    'createAt',
                    function ($ctdt) {
                        return date("d/m/Y", strtotime($ctdt->created_at));
                    }
                )
                ->addColumn(
                    'createHuman',
                    function ($ctdt) {
                        $createHuman = DB::table('users')->where('id', $ctdt->nguoi_tao)
                                        ->select('name')->first();
                        if($createHuman)
                            return $createHuman->name;
                        else return '';
                    }
                )

                ->addColumn(
                    'actions',
                    function ($ctdt) {
                        $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$ctdt->id.'"data-bs-placement="top" title="'.Lang::get('project/Standard/title.capnhat').'">'.'<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>'.'</button>';
                        $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$ctdt->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>'.'</button>'; 
                        return $actions;
                    }
                )
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
    public function exportCTDT() {
        return Excel::download(new CTDTExport(), 'ctdt.xlsx');
    }
    public function createCTDT(Request $req) {
        $req->validate([
            'mactdt'    => 'required',
            'tctdttv'   => 'required',
            'hdt'       => 'required',
            'dvql'      => 'required'
        ]);
        $checkExits = DB::table("ctdt")->where("manganh", $req->mactdt)
            ->where("deleted_at", null)
            ->count();
        if($checkExits == 0){
            $data = [
                'donvi_id'      =>  $req->dvql,
                'tennganh'      =>  $req->tctdttv,
                'tennganh_en'   =>  $req->tctdtta,
                'manganh'       =>  $req->mactdt,
                'hedaotao_id'   =>  $req->hdt,
                'ma_ctdt'       =>  $req->mactdt,
                'manganhts'     =>  $req->mactdt,
                'nguoi_tao'     =>  Sentinel::getUser()->id,
                'csdt_id'       =>  $this->getCsdt(),
                'trang_thai'    =>  'active',
                'created_at'    =>  Carbon::now()->toDateTimeString(),
                'updated_at'    =>  Carbon::now()->toDateTimeString(),
            ];
            DB::table("ctdt")->insert($data);
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
        }else{
            return back()->with('error', 
                    Lang::get('project/Standard/message.error.exists'));
        }
    }
    public function deleteCTDT(Request $req){
        DB::table("ctdt")->where("id", $req->id_delete)
            ->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateCTDT(Request $req){
        $req->validate([
            'up_mactdt'    => 'required',
            'up_tenctdt'   => 'required',
            'up_hdt'       => 'required',
            'up_dvql'      => 'required'
        ]);
        $data = [
            'donvi_id'      =>  $req->up_dvql,
            'tennganh'      =>  $req->up_tenctdt,
            'tennganh_en'   =>  $req->up_tenctdten,
            'manganh'       =>  $req->up_mactdt,
            'hedaotao_id'   =>  $req->up_hdt,
            'ma_ctdt'       =>  $req->up_mactdt,
            'manganhts'     =>  $req->up_mactdt,
            'sdt_lienhe'    =>  $req->up_sdt,
            'dtkhoa1'       =>  $req->up_dtKhoa1,
            'ncbkhoa1'      =>  $req->up_cbKhoa1,
            'tentd'         =>  $req->up_tenTd,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ];
        DB::table("ctdt")->where("id", $req->id_update)->update($data);
        return back()->with('success', 
                Lang::get('project/Standard/message.success.update'));
    }
    

    public function linkreport(Request $req){
        $kehoachbaocao = DB::table('kehoach_baocao')->select("id", "ten_bc")
                        ->get();

        return view('admin.project.Standard.mana_linkreport')
                ->with([
            'kehoachbaocao'       =>      $kehoachbaocao,
        ]);
        // thường trực - Quản lý danh mục (quản lý link báo cáo)
    }
    
    public function dataLinkreport(){
        $linkreport = DB::table("baocao_url")->get();
        return DataTables::of($linkreport) 
            ->addColumn(
                'ten_bc',
                function ($csdt) {
                    $nameBC = DB::table("kehoach_baocao")
                        ->where("id", $csdt->id_kehoach_baocao)
                        ->select("ten_bc")
                        ->first();
                    return $nameBC->ten_bc;
                }
            )
            ->addColumn(
                'createdAt',
                function ($csdt) {
                    return date("d-m-Y", strtotime($csdt->created_at));
                }
            )            
            
            ->addColumn(
                'actions',
                function ($csdt) {
                    $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$csdt->id.'" data-bs-placement="top" title="'.Lang::get('project/Standard/title.chinhsua').'">'.'<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>'.'</button>'; 
                    $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$csdt->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
                    return $actions;
                }
            )
            
            
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function addbaocaourl(Request $req){
        if($req->id_report != "" && $req->link_report != ""){
            $data = [
                'id_kehoach_baocao' => $req->id_report,
                'url'               => $req->link_report,
                'is_active'         => 1,
                'id_csdt'           => Sentinel::getUser()->csdt_id,
                'created_at'        => Carbon::now()->toDateTimeString(),
                'updated_at'        => Carbon::now()->toDateTimeString(),
            ];
            DB::table("baocao_url")->insert($data);
            return json_encode([
                "mes" => "done"
            ]);
        }else{
            return json_encode([
                "mes" => 'not done'
            ]);
        }
    }
    public function deletebaocaourl(Request $req){
        $baocaoUrl = DB::table("baocao_url")->where("id", $req->id)
                    ->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }
    public function findbaocaourl(Request $req){
        $baocaoUrl = DB::table("baocao_url")->where("id", $req->id)
                ->select("id", "id_kehoach_baocao", "url")
                ->first();
        return json_encode($baocaoUrl);
    }
    public function editbaocaourl(Request $req){
        if($req->id_bc != "" && $req->link_url != ""){
            $baocaoUrl = DB::table("baocao_url")->where("id", $req->id_url);
            $data = [
                'id_kehoach_baocao' => $req->id_bc,
                'url'               => $req->link_url,
                'created_at'        => Carbon::now()->toDateTimeString(),
            ];
            $baocaoUrl->update($data);
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.update'));
        }else{
            return back()->with('error', 
                    Lang::get('project/Standard/message.error.update'));
        }
    }
	//Import excel unit
    public function importUnit (Request $req) {
        $excel = new UnitImportEx;
        // $file = $req->file('file');
        Excel::import($excel, $req->file);
        return $excel->read();
    }

    public function csdt(Request $req){
        $csdt = DB::table("csdt")->select("id", "dia_chi" , "img_logo", )
        // ->where("deleted_at", null)
        ->get();
        return view('admin.project.Standard.mana_manacsdt')->with([
            'csdt'       =>      $csdt,
            
        ]); // thường trực - Quản lý danh mục (quản lý cơ sở đào tạo)
    }

    public function datacsdt(Request $req) {
        $csdts = DB::table("csdt")->where("deleted_at", null);
        if(isset($req->id_search)  && $req->id_search != ""){
            $csdt = $csdts->where("id", $req->id_search)
                    ->select("id", "ten_csdt", "dia_chi","img_logo","sdt_lienhe","ns_phutrach")
                    ->first();
            return json_encode($csdt);
        }else{
            // $csdts = $this->dataExceptDelete(
            //     $csdts->select("id", "ten_csdt", "dia_chi","sdt_lienhe","ns_phutrach", "deleted_at")
            // );
            return DataTables::of($csdts)               
                ->addColumn(
                    'createAt',
                    function ($csdt) {
                        return date("d/m/Y", strtotime($csdt->created_at));
                    }
                )
                ->addColumn(
                    'actions',
                    function ($csdt) {
                        $actions = '<button data-toggle="modal" data-target="#modalUpdate" class="btn btn-block mt-2" data-id="'.$csdt->id.'" data-bs-placement="top" title="'.Lang::get('project/Standard/title.chinhsua').'">'.'<i class="bi bi-pencil-square" style="font-size: 25px;color: #009ef7;"></i>'.'</button>'; 
                        $actions = $actions.'<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$csdt->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
                        return $actions;
                    }
                )
                ->addColumn(
                    'img',
                    function ($csdt) {
                        if($csdt->img_logo != "")
                            return '<img src="'. asset($csdt->img_logo) .'" alt="">';
                        else
                            return "";
                        return  ;
                    }
                )
                
                ->rawColumns(['actions', 'img'])
                ->make(true);
        }
    }
    
    public function exportCSDT() {
        return Excel::download(new CSDTExport(), 'csdt.xlsx');
    }
    
    public function deleteCSDT(Request $req){
        DB::table("csdt")->where("id", $req->id_delete)
            ->update([
                'deleted_at' => Carbon::now()->toDateTimeString()
            ]);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function updateCSDT(Request $req){
        $req->validate([
            'up_tencsdt'    => 'required',
            'up_dc'         => 'required',
            // 'up_hanh'       => 'required',
            'up_npc'        => 'required', 
            'up_sdt'        => 'required'
        ]);
        $data = [
            'ten_csdt'      =>  $req->up_tencsdt,
            'dia_chi'       =>  $req->up_dc,
            // 'img_logo'      =>  $req->up_hanh,
            'ns_phutrach'   =>  $req->up_npc,
            'sdt_lienhe'    =>  $req->up_sdt,
            'updated_at'    =>  Carbon::now()->toDateTimeString(),
        ];
        DB::table("csdt")->where("id", $req->id_update)->update($data);
        return back()->with('success', 
                Lang::get('project/Standard/message.success.update'));
    }

    public function createCSDT(Request $req) {
        $req->validate([
            'tcsdt'         => 'required',
            'dchi'          => 'required',
            // 'hanh'          => 'required',
            'sdt'           => 'required',
            'npt'           => 'required'
        ]);
        $checkExits = DB::table("csdt")->where("sdt_lienhe", $req->sdt)
            // ->where("deleted_at", null)
            ->count();
        if($checkExits == 0){
            $data = [
                'ten_csdt'      =>  $req->tcsdt,
                'dia_chi'       =>  $req->dchi,
                'img_logo'      =>  $req->hanh,
                'sdt_lienhe'    =>  $req->sdt,
                'ns_phutrach'   =>  $req->npt,
                'trang_thai'    =>  'active',
                // 'han_noptien'   =>  $req->npt,
                'created_at'    =>  Carbon::now()->toDateTimeString(),
                'updated_at'    =>  Carbon::now()->toDateTimeString(),
            ];
            DB::table("csdt")->insert($data);
            return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
        }else{
            return back()->with('error', 
                    Lang::get('project/Standard/message.error.exists'));
        }
    }

    public function importDataUnit(Request $req){
        $data = json_decode($req->getContent());
        foreach($data as $dt){
            if($dt->madv  != "" && $dt->tendv != "" 
                    &&  $dt->listtruondv != "" && $dt->listcbdbcl){
                $check = DB::table("donvi")->where("ma_donvi", $dt->madv);
                if($check->count() == 0){
                    $dataInport = array(
                        'ma_donvi'  => $dt->madv,
                        'ten_donvi' => $dt->tendv,
                        'loai_dv_id'=> $dt->listloaidv,
                        'ten_ngan'  => $dt->tenngan,
                        'dia_chi'   => $dt->diachi,
                        'mo_ta'      => $dt->mota,
                        'lvhd'      => $dt->lvhd,
                        'lhcsgd'    => $dt->listlhcsg,
                        'truong_dv' => $dt->listtruondv,
                        'canbo_dbcl'    => $dt->listcbdbcl,
                        'dvcc'          => $dt->pcc == "" ? null : $dt->pcc,
                        'ten_tienganh'  => $dt->tenta,
                        'ten_donvi_cu'  => $dt->tendvc,
                        'dien_thoai'    => $dt->dienthoai,
                        'email'         => $dt->email,
                        'website'       => $dt->website,
                        'nam_thanhlap'  => $dt->namtl,
                        'nam_batdau'    => $dt->nambd,
                        'nam_capbang'   => $dt->namcb,
                        'nguoi_tao'     => Sentinel::getUser()->id,
                        'csdt_id'       => $this->getCsdt(),
                        'trang_thai'    => 'active'
                    );
                    DB::table("donvi")->insert($dataInport);
                    // array_push($respon, $dataInport);
                }
            }
        }
        $respon = [
            'mes'   => 'done'
        ];
        return json_encode($respon);
    }
    public function exportUnit() {
        return Excel::download(new UnitExport(), 'unit.xlsx');
    }

    public function resetPass(Request $req){
        $userReset = DB::table("users")->where("id", $req->id_user);
        $userReset->update([
            'password'     => Hash::make($userReset->first()->email)
        ]);
        return back()->with('success', 
                    Lang::get('project/Standard/title.updatePassSuccess'));
    }
}