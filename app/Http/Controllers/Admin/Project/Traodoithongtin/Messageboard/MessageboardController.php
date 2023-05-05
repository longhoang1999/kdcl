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
}

?>