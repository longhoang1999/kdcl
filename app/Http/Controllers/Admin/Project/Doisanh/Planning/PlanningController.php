<?php namespace App\Http\Controllers\Admin\Project\Doisanh\Planning;

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

class PlanningController extends DefinedController
{

    public function index(Request $req){
         return view('admin.project.Strategy.planning');
    }

    public function update(){
        $users = DB::table('customers');
        return DataTables::of($users)               
            ->addColumn(
                'actions',
                function ($user) {
                    $actions = '<a href="" class="btn btn-primary" data-toggle="modal" data-target="#myModal">'.
                        Lang::get('project/Strategy/title.dsns')
                    .'</a>';
                    return $actions;
                }
            )
            ->rawColumns(['actions'])
            ->make(true);
    }
    	
}
