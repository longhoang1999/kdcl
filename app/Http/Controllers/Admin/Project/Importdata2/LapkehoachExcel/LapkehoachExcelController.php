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
        $user = DB::table("users")
            ->leftjoin("donvi", "users.donvi_id", "=", "donvi.id")
            ->select("users.id","users.name", "donvi.ten_donvi")->get();
        $donvi = DB::table("donvi")->select("ten_donvi", "id")->get();
        return view('admin.project.Importdata2.lkhoach')->with([
            'user'  => $user,
            'donvi' => $donvi
        ]);
	}
    public function excelLog(){
        $excel_log = [
            '1' => 'Tuyển sinh',
            '2' => 'Dữ liệu sinh viên',
            '3' => 'Chương trình đào tạo',
            '4' => 'Khoa học công nghệ',
            '5' => 'Biên soạn sách',
            '6' => 'Bài báo',
            '7' => 'Phát minh sáng chế',
            '8' => 'Giải thưởng',
            '9' => 'Sáng kiến kinh nghiệm',
            '10' => 'Hội thảo hội nghị',
            '11' => 'Thông tin cơ bản',
            '12' => 'Nhân sự',
            '13' => 'Doanh thu khoa học công nghệ',
            '14' => 'Doanh thu khoa học công nghệ 2',
            '15' => 'Thống kê tài chính',
            '16' => 'Khảo sát tình trạng tốt nghiệm sinh viên',
            '17' => 'Diện tính KTX',
            '18' => 'Thống kê phòng học, thiết bị',
            '19' => 'Thông kê máy tính',
            '20' => 'Diện tích sàn xây dựng',
            '21' => 'Kiểm định',
            '22' => 'Tài liệu thư viện',
            '23' => 'Đồ án khóa luận',
            '24' => 'Hội nghị hội thảo',
            '25' => 'Giáo trình tài liệu',
            '26' => 'Môn học',
            '27' => 'Quy mô đào tạo',
            '28' => 'Thông tin các phòng',
            '29' => 'Thông tin sinh viên tốt nghiệp',
            '30' => 'Thông tin cơ sở giáo dục',
            '31' => 'Tỉ lệ sinh viên, giảng viên',
            '32' => 'Diện tích đất',
            '33' => 'Đào tạo theo đơn',
            '34' => 'Diện tích đất, tổng diện tích sàn xây dựng',
            '35' => 'Thông tin về học liệu',
            '36' => 'Nghiên cứu khoa học',
            '37' => 'Công khai cam kết chất lượng đào tạo',
            '38' => 'Công khai tài chính năm học',
            '39' => 'Công khai đội ngũ giảng viên theo khối ngành',
            '40' => 'Công khai đội ngũ giảng viên theo khối ngành',
        ];
        return $excel_log;
    }

    public function createKH(Request $req){
        $data = [
            //'danhmuc'   => $req->danhmuc,
            'bang_stt'   => $req->tenbang,
            'donvi_id'      => $req->dvth,
            'nskt_id'    => $req->ns_kiemtra,
            'ngay_bd'   => date("Y-m-d", strtotime($req->ngay_batdau_chuanbi)),
            'ngay_kt'    => date("Y-m-d", strtotime($req->ngay_hoanthanh_chuanbi)), 
            'notes'      => $req->note,
            'created_at'    =>  date('Y-m-d H:i:s'),
        ];
        DB::table('lkh_phanquyen_excel')->insert($data);

        return back()->with('success', 
        Lang::get('project/Standard/message.success.create'));
    }
    
    public function getDanhmuc($b){
        $danhmuc = "";
        if($b == 1 || $b == 2 || $b == 3 || $b == 4)
            $danhmuc = "Đào tạo";
        else if($b == 5 || $b == 6 || $b == 7 || $b == 8 || $b == 9 || $b == 10)
            $danhmuc = "Khoa học công nghệ";
        else if($b == 11 || $b == 12)
            $danhmuc = "Nhân sự";
        else if($b == 13 || $b == 14 || $b == 15)
            $danhmuc = "Tài chính";
        else if($b == 16)
            $danhmuc = "Khảo sát sinh viên";
        else if($b == 17 || $b == 18 || $b == 19 || $b == 20)
            $danhmuc = "Cơ sở vật chất";
        else if($b == 21)
            $danhmuc = "Kiểm định";
        else if($b == 22)
            $danhmuc = "Tài liệu thư viện";
        else
            $danhmuc = "Tài liệu 3 công khai";
        return $danhmuc;
    }

    public function data(Request $req){
        

        $users = DB::table('lkh_phanquyen_excel')->orderBy("created_at", "desc");
        return DataTables::of($users)  
            ->addColumn(
                'time',
                function ($user) {
                    $log = date("d-m-Y", strtotime($user->ngay_bd)) . ' => ' . date("d-m-Y", strtotime($user->ngay_kt));
                    return "<span class='badge bg-success'>$log</span>";
                   
                }
            )    
            ->addColumn(
                'donvi',
                function ($user) {
                    $donvi = DB::table('donvi')->where("id", $user->donvi_id)->first();
                    return $donvi->ten_donvi;
                }
            )   
            ->addColumn(
                'nhansukt',
                function ($user) {
                    $nhansu = DB::table('users')->where("id", $user->nskt_id)->first();
                    return $nhansu->name;
                }
            )  
            ->addColumn(
                'table_name',
                function ($user) {
                    $excel_log = $this->excelLog();
                    $table_name = "";
                    foreach($excel_log as $key => $value){
                        if( $key  == $user->bang_stt){
                            $table_name =  $value;
                        }
                    }
                    $table_name = "<a data-id=" . $user->id . " type='button'  data-toggle='modal' data-target='#modelShow'>$table_name</a>";
                    return $table_name;
                }
            )  
            ->addColumn(
                'danhmuc',
                function ($user) {
                    $danhmuc = $this->getDanhmuc($user->bang_stt);
                    return $danhmuc;
                }
            )
            
                      
            ->addColumn(
                'action',
                function ($user) {                    
                     $actions = '<a href="#" class="btn" data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.chsua').'"  data-id='.$user->id.' data-toggle="modal" data-target="#modalUpdateBC">'.
                                    '<i data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.chsua').'" class="bi bi-pencil-square" style="font-size: 25px;color: #ce186a;"></i>'
                                        .
                                '</a>';
                    $actions .= '<a href="#" class="btn" data-bs-placement="top" title="'.Lang::get('project/       Selfassessment/title.xoa').'" data-id='.$user->id.' data-toggle="modal" data-target="#modalDelete">'.
                                    '<i data-bs-placement="top" title="'.Lang::get('project/Selfassessment/title.xoa').'" class="bi bi-trash" style="font-size: 25px;color: #d9214e;"></i>'
                                        .
                                '</a>';
                        
                    return $actions;
                }
            )
            ->rawColumns(['action', 'time', 'table_name'])
            ->make(true);
    }

    public function deleteKehoach(Request $req){
        $deleteItem = DB::table("lkh_phanquyen_excel")->where("id", $req->id_delete)
                        ->delete();
        $respon = (object)array('result' => 'done');
        return json_encode($respon);
    }

    public function getDataOne(Request $req) {
        if($req->id != ""){
            $data = DB::table('lkh_phanquyen_excel')->where('id', $req->id)->first();
            $danhmuc = $this->getDanhmuc($data->bang_stt);

            $excel_log = $this->excelLog();
            $table_name = "";
            foreach($excel_log as $key => $value){
                if( $key  == $data->bang_stt){
                    $table_name =  $value;
                }
            }

            $donvi = DB::table('donvi')->where("id", $data->donvi_id)->first();
            $nhansu = DB::table('users')->where("id", $data->nskt_id)->first();
            $log = date("d-m-Y", strtotime($data->ngay_bd)) . ' => ' . date("d-m-Y", strtotime($data->ngay_kt));     
            
            
            $response = [
                'danhmuc'   => $danhmuc,
                'tablename' => $table_name,
                'ten_donvi' => $donvi->ten_donvi,
                'nskt'      => $nhansu->name,
                'kehoach'   => $log,
                'note'      => $data->notes 
            ];
        }else{
            $response = DB::table('lkh_phanquyen_excel')->where('id', $req->idUpdate)->first();
        }
        return json_encode($response);
    }
    

    public function updateKH(Request $req){
        $data = [
            'bang_stt'   => $req->tenbang,
            'donvi_id'      => $req->dvth,
            'nskt_id'    => $req->ns_kiemtra,
            'ngay_bd'   => date("Y-m-d", strtotime($req->ngay_batdau_chuanbi)),
            'ngay_kt'    => date("Y-m-d", strtotime($req->ngay_hoanthanh_chuanbi)), 
            'notes'      => $req->note,
            'update_at'    =>  date('Y-m-d H:i:s'),
            
        ];
        
        DB::table('lkh_phanquyen_excel')->where("id", $req->idkh)->update($data);

        return back()->with('success', 
        Lang::get('project/Standard/message.success.update'));
    }
	
}