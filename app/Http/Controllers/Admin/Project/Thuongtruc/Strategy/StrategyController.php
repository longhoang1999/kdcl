<?php namespace App\Http\Controllers\Admin\Project\Thuongtruc\Strategy;

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

class StrategyController extends DefinedController
{
    public function index(Request $req){
        echo "StrategyController";
    }

    public function stracriteria(Request $req){
        echo "StrategyController stracriteria";
    }

    public function strasubject(Request $req){
        echo "StrategyController strasubject";
    }
    
    
	
}