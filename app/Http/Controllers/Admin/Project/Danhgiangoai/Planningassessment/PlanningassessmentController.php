<?php namespace App\Http\Controllers\Admin\Project\Danhgiangoai\Planningassessment;
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

class PlanningassessmentController extends DefinedController{

	public function index(){
		$data = DB::table('users')
					->select('users.id','users.name','donvi.ten_donvi')
					->leftjoin('donvi','donvi.id','=','users.donvi_id')
					->get();
		$baocao = DB::table('kehoach_baocao')
					->select('id','ten_bc')
					->get();
		return view('admin.project.Planningassessment.index')
			->with([
					'data'  => $data,
					'baocao'  => $baocao,
			]);
	}
	public function phanquyen(Request $req){
		if($req->ds_chuanbi != null && $req->ds_chuanbi != ""){
			foreach($req->ds_chuanbi as $ds_chuanbi){
				$exit = DB::table("role_user_dgn")->where("user_id", $ds_chuanbi)
							->where("baocao_tdg_id", $req->id_bc);
				if($exit->count() == 0){
					$data = [
						'user_id'	=> $ds_chuanbi,
						"start_time"	=> date("Y-m-d", strtotime($req->start_date)),
						"end_time"		=> date("Y-m-d", strtotime($req->end_date)),
						"baocao_tdg_id"	=> $req->id_bc,
						"to_truong"		=> $req->ns_phutrach
					];
					DB::table("role_user_dgn")->insert($data);
				}
				
			}
		}
		return json_encode([
			'mes' => 'done'
		]);
	}

	public function getdata(){
		$donvis = DB::table("role_user_dgn")->get();

		return DataTables::of($donvis)  
			->addColumn(
				'ten_kh',
				function ($donvi) {
					$khbc = DB::table("kehoach_baocao")->where("id", $donvi->baocao_tdg_id)
							->select("ten_bc");
					if($khbc->count() > 0){
						return $khbc->first()->ten_bc;
					}else{
						return "Không xác định kế hoạch";
					}
				}
			)       
			->addColumn(
				'totruong',
				function ($donvi) {
					$user = DB::table("users")->where("id", $donvi->to_truong)->select("name")->first();
					if($user){
						return $user->name;
					}else{
						return "Không có dữ liệu";
					}
					
				}
			)    
			->addColumn(
				'nvth',
				function ($donvi) {
					$user = DB::table("users")->where("id", $donvi->user_id)->select("name")->first();
					if($user){
						return $user->name;
					}else{
						return "Không có dữ liệu";
					}
				}
			)  
			->addColumn(
				'time',
				function ($donvi) {
					$start = date("d-m-Y", strtotime($donvi->start_time));
					$end = date("d-m-Y", strtotime($donvi->end_time));
					return $start . " => " .$end;
				}
			)  
			->addColumn(
				'actions',
				function ($donvi) { 
					$actions = '<button class="btn btn-block" data-toggle="modal" data-target="#modalDelete" data-id="'.$donvi->id.'">'. '<i class="bi bi-trash" style="font-size: 25px;color: red;"></i>' .'</button>';
					return $actions;
				}
			)
			->rawColumns(['actions', 'truongDv', 'createHuman', 'dvcc'])
			->make(true);
	}

	public function deletedata(Request $req){
		DB::table("role_user_dgn")->where("id", $req->id)->delete();
		return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
	}
}