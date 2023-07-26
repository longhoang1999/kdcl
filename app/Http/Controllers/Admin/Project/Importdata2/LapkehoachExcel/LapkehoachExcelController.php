<?php namespace App\Http\Controllers\Admin\Project\Importdata2\LapkehoachExcel;
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

//Import Excel
use App\Imports\Khcn;
// export excel
use App\Exports\KhcnExport;

class LapkehoachExcelController extends DefinedController{

	public function index(){
		// $loai_dv = DB::table("loai_donvi")->select("id", "loai_donvi")->get();
		// $donvi = DB::table("donvi")->select("id", "ten_donvi", "deleted_at","loai_dv_id")
        //         ->where("deleted_at", null)
        //         ->get();
		
        // return view('admin.project.Importdata.khcn')->with([
        //    	'loai_dv'           => $loai_dv,
        //    	'donvi'             => $donvi,
        // ]);

        echo "123";
	}

	
}