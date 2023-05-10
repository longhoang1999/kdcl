<?php namespace App\Http\Controllers\Admin\Project\Traodoithongtin\Messageboard;

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

class MessageboardController extends DefinedController
{
    public function index(Request $req){
        $infoUser = Sentinel::getUser();
        return view('admin.project.Infexchange.index')->with([
            'idUser'    => $infoUser->id,
            'pic'       => $infoUser->pic,
        ]);
    }

    public function createbantin(Request $req){
        $data = [
            'noidung'   => $req->content,
            'user_id'   => Sentinel::getUser()->id,
            'perent'    => '0',
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table("bantin")->insert($data);
        return json_encode([
            'mes'   => 'done'
        ]);
    }

    public function renderUI(){
        $UI = DB::table("bantin")
            ->leftjoin('users', 'users.id', '=', 'bantin.user_id')
            ->select("bantin.*", "users.pic", "users.name")
            ->orderBy('created_at', 'desc')
            ->get();
        
        $like = DB::table("bantin_like")->get();
        return json_encode([$UI, $like]);
    }

    public function xoaComment(Request $req){
        DB::table("bantin")->where("id", $req->id)->delete();
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.delete'));
    }

    public function postParent(Request $req) {
        $data = [
            'noidung'   => $req->content,
            'user_id'   => Sentinel::getUser()->id,
            'perent'    => $req->id_post,
            'created_at'            => Carbon::now()->toDateTimeString(),
            'updated_at'            => Carbon::now()->toDateTimeString(),
        ];
        DB::table("bantin")->insert($data);
        return back()->with('success', 
                    Lang::get('project/Standard/message.success.create'));
    }

    public function likePosst(Request $req){
        $find = DB::table("bantin_like")
            ->where("bantin_id", $req->idPost)
            ->where("user_id", Sentinel::getUser()->id);
        if($find->count() == 0){
            $data = [
                'bantin_id' => $req->idPost,
                'user_id'   => Sentinel::getUser()->id,
                'created_at'            => Carbon::now()->toDateTimeString(),
                'updated_at'            => Carbon::now()->toDateTimeString(),
            ];
            DB::table("bantin_like")->insert($data);
        }else{
            $find->delete();
        }

        return json_encode([
            'mes'   => 'done'
        ]);
    }
}

?>