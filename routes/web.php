<?php

require_once 'web_builder.php';
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

// Thường trực cho Ban Giám Hiệu và nhân sự TT đảm bảo chất lượng
Route::get("update-per", function() {
    $users = DB::table("users")->select("id")->where("donvi_id", "95")->get();
    foreach($users as $us){
        $data = [
            'user_id'   => $us->id,
            'role_id'  => '3',
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ];
        DB::table("role_users")->insert($data);
    }
    
});

Route::get("update-time", function() {
    $users = DB::table("users")->select("id", "created_at", "updated_at")->get();
    foreach($users as $us){
        $data = [
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ];
        DB::table("users")->where("id", $us->id)->update($data);
    }
    
});
Route::get("active", function() {
    $users = DB::table("users")->select("id")->get();
    foreach($users as $us){
        $data = [
            'user_id'   => $us->id,
            'code'  => 'AbVBHza2L6knwXRJNuxK2Cb67w5xG2cI',
            'completed' => '1',
            'completed_at' => Carbon::now()->toDateTimeString(),
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ];
        DB::table("activations")->insert($data);
    }
    
});

Route::get("active-role-user", function() {
    $users = DB::table("users")->select("id")->get();
    foreach($users as $us){
        $data = [
            'user_id'   => $us->id,
            'role_id'  => '2',
            'created_at'    => Carbon::now()->toDateTimeString(),
            'updated_at'    => Carbon::now()->toDateTimeString(),
        ];
        DB::table("role_users")->insert($data);
    }
    
});

Route::get("create-pass", function() {
    $users = DB::table("users")->select("id", "password", "email")->get();
    foreach($users as $us){
        if($us->password == "" || $us->password == null){
        	$pass = Hash::make($us->email );
          	DB::table("users")->where("id",$us->id )->update([
            	'password' => $pass
            ]);
        }
    }
    
});

// Route::get("create-role", function(){
//     $role = Sentinel::getRoleRepository()->createModel()->create([
//         'name' => 'ns_kiemtra',
//         'slug' => 'ns_kiemtra',
//     ]);
// });

// Route::get("delete-role", function(){
//     $arr = [];
//     $users = DB::table("users")->select("id")->get();
//     foreach($users as $us){
//         array_push($arr, $us->id);
//     }
//     foreach($arr as $value){
//         if($value != "1"){
//             $user = Sentinel::findById($value);
//             $role = Sentinel::findRoleByName('User');
//             $role->users()->attach($user); 
//         }
        
//     }
// });
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::pattern('slug', '[a-z0-9- _]+');

Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin'],
    function () {

        // Error pages should be shown without requiring login
        Route::get(
            '404',
            function () {
                return view('admin/404');
            }
        );
        Route::get(
            '500',
            function () {
                return view('admin/500');
            }
        );
        // Lock screen
        Route::get('{id}/lockscreen', 'LockscreenController@show')->name('lockscreen');
        Route::post('{id}/lockscreen', 'LockscreenController@check')->name('lockscreen');
        // All basic routes defined here
        Route::get('login', 'AuthController@getSignin')->name('login');
        Route::get('signin', 'AuthController@getSignin')->name('signin');
        Route::post('signin', 'AuthController@postSignin')->name('postSignin');
        // link login token
        Route::get('signin-token', 'AuthController@getLoginToken')->name('getLoginToken');

        Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
        Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
        Route::get(
            'login2',
            function () {
                return view('admin/login2');
            }
        );


        // Register2
        Route::get(
            'register2',
            function () {
                return view('admin/register2');
            }
        );
        Route::post('register2', 'AuthController@postRegister2')->name('register2');

        // Forgot Password Confirmation
        //    Route::get('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm')->name('forgot-password-confirm');
        //    Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@getForgotPasswordConfirm');

        // Logout
        Route::get('logout', 'AuthController@getLogout')->name('admin.logout');

        // Account Activation
        Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate')->name('activate');
    }
);


Route::group(
    ['prefix' => 'admin', 'middleware' => 'operator', 'as' => 'admin.'],
    function () {
        // GUI Crud Generator
        Route::get('generator_builder', 'JoshController@builder')->name('generator_builder');
        Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');
        Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');
        // Model checking
        Route::post('modelCheck', 'ModelcheckController@modelCheck');

        // Dashboard / Index
        Route::get('/', 'JoshController@showHome')->name('dashboard');
        // crop demo
        Route::post('crop_demo', 'JoshController@cropDemo')->name('crop_demo');
        //Log viewer routes
        Route::get('log_viewers', 'Admin\LogViewerController@index')->name('log-viewers');
        Route::get('log_viewers/logs', 'Admin\LogViewerController@listLogs')->name('log_viewers.logs');
        Route::delete('log_viewers/logs/delete', 'Admin\LogViewerController@delete')->name('log_viewers.logs.delete');
        Route::get('log_viewers/logs/{date}', 'Admin\LogViewerController@show')->name('log_viewers.logs.show');
        Route::get('log_viewers/logs/{date}/download', 'Admin\LogViewerController@download')->name('log_viewers.logs.download');
        Route::get('log_viewers/logs/{date}/{level}', 'Admin\LogViewerController@showByLevel')->name('log_viewers.logs.filter');
        Route::get('log_viewers/logs/{date}/{level}/search', 'Admin\LogViewerController@search')->name('log_viewers.logs.search');
        Route::get('log_viewers/logcheck', 'Admin\LogViewerController@logCheck')->name('log-viewers.logcheck');
        //end Log viewer
        // Activity log
        Route::get('activity_log/data', 'JoshController@activityLogData')->name('activity_log.data');
        //    Route::get('/', 'JoshController@index')->name('index');
    }
);
Route::get('createRole', function() {
    Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'ttchuyentrach',
        'slug' => 'ttchuyentrach',
    ]);
    // Sentinel::getRoleRepository()->createModel()->create([
    //     'name' => 'khac',
    //     'slug' => 'khac',
    // ]);
});

Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'operator', 'as' => 'admin.'],
    function () {

        // User Management
        Route::group(
            ['middleware' => 'admin'],
            function () {
                Route::get('data', 'UsersController@data')->name('users.data');
                Route::get('{user}/delete', 'UsersController@destroy')->name('users.delete');
                Route::get('{user}/confirm-delete', 'UsersController@getModalDelete')->name('users.confirm-delete');
                Route::get('{user}/restore', 'UsersController@getRestore')->name('restore.user');
                //        Route::post('{user}/passwordreset', 'UsersController@passwordreset')->name('passwordreset');
                Route::post('passwordreset', 'UsersController@passwordreset')->name('passwordreset');   
                Route::resource('users', 'UsersController');     
                Route::post('change-pass', 'UsersController@changePass')->name('changePass'); 
                Route::post('update-user', 'UsersController@updateUser')->name('updateUser');       
            }            
        );
        
        
        
        /************
     * bulk import
    ****************************/
        Route::get('bulk_import_users', 'UsersController@import');
        Route::post('bulk_import_users', 'UsersController@importInsert');
        /****************
     bulk download
    **************************/
        Route::get('download_users/{type}', 'UsersController@downloadExcel');

        Route::get('deleted_users', ['before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'])->name('deleted_users');

        // Email System
        Route::group(
            ['prefix' => 'emails'],
            function () {
                Route::get('compose', 'EmailController@create');
                Route::post('compose', 'EmailController@store');
                Route::get('inbox', 'EmailController@inbox');
                Route::get('sent', 'EmailController@sent');
                Route::get('{email}', ['as' => 'emails.show', 'uses' => 'EmailController@show']);
                Route::get('{email}/reply', ['as' => 'emails.reply', 'uses' => 'EmailController@reply']);
                Route::get('{email}/forward', ['as' => 'emails.forward', 'uses' => 'EmailController@forward']);
            }
        );
        Route::resource('emails', 'EmailController');

        // Role Management
        Route::group(
            ['prefix' => 'roles'],
            function () {
                Route::get('{group}/delete', 'RolesController@destroy')->name('roles.delete');
                Route::get('{group}/confirm-delete', 'RolesController@getModalDelete')->name('roles.confirm-delete');
                Route::get('{group}/restore', 'RolesController@getRestore')->name('roles.restore');
            }
        );
        Route::resource('roles', 'RolesController');
       
        // Route for Project
        Route::group(
            ['namespace' => 'Project'],
            function () {
                // Route for thường trực
                Route::group(
                    ['prefix' => 'thuong-truc', 'as' => 'thuongtruc.', 'namespace' => 'Thuongtruc', 'middleware' => ['super_check:admin,operator,truongdonvi']],
                    function () {
                        /*routes for set standard*/
                        Route::group(['prefix' => 'setstandard', 'as' => 'setstandard.',
                            'namespace' => 'Standard','middleware' => ['super_check:admin,operator']],
                            function () {
                                // Quản lý bộ tiêu chuẩn
                                Route::get('index', 'StandardController@index')->name('index');
                                // test datatable
                                Route::get('data', 'StandardController@data')->name('data');
                                Route::get('data-standard', 'StandardController@dataStandard')->name('dataStandard');
                                Route::post('create-standard', 'StandardController@createStandard')->name('createStandard');
                                Route::get('delete-standard/{id}', 'StandardController@deleteStandard');
                                Route::get('export-standard', 'StandardController@exportStandard')->name('exportStandard');
                                Route::post('search-standard-name', 'StandardController@searchStandardName')->name('searchStandardName');
                                Route::post('copy-standar', 'StandardController@copyStandar')->name('copyStandar');
                                Route::get('search-and-update-stt', 'StandardController@searchVSUpdateSttSt')->name('searchVSUpdateSttSt');
                                Route::post('search-and-update-stt2', 'StandardController@searchVSUpdateSttSt2')->name('searchVSUpdateSttSt2');
                                
                                

                                // Thiết lập BTC
                                Route::get('config-standard/{id}', 'StandardController@configStandard')->name('configStandard');
                                Route::post('update-standard', 'StandardController@updateStandard')->name('updateStandard');
                                Route::get('show-standard/{id}', 'StandardController@showStandard')->name('showStandard');
                                // Thêm mới tiêu chuẩn
                                Route::get('create-single-standard/{id}', 'StandardController@createSgStandard')->name('createSgStandard');
                                Route::get('export-single-standard/{id}', 'StandardController@ExportSgStandard')->name('ExportSgStandard');
                                Route::post('create-list-standard/{id}', 'StandardController@createLiStandard')->name('createLiStandard');
                                Route::get('delete-single-standard/{id}', 'StandardController@deleteSgStandard')->name('deleteSgStandard');
                                Route::get('config-criteria/{id}', 'StandardController@configCriteria')->name('configCriteria');
                                // Thêm mới tiêu chí
                                Route::post('change-nametc', 'StandardController@updateNameTC')->name('updateNameTC');
                                Route::post('create-criteria/{id_tc}', 'StandardController@createCriteria')->name('createCriteria');
                                Route::get('show-criteria', 'StandardController@showCriteria')->name('showCriteria');
                                Route::get('delete-single-criteria', 'StandardController@deleteSgCriteria')->name('deleteSgCriteria');
                                Route::post('update-stt-sriteria', 'StandardController@updateSttCriteria')->name('updateSttCriteria');
                                
                                // Quản lý tiêu chuẩn, tiêu chí
                                Route::get('criteria', 'StandardController@criteria')->name('criteria');
                                Route::post('up-criteria', 'StandardController@upCriteria')->name('upCriteria');
                                // Mốc chuẩn
                                Route::post('create-benchmark', 'StandardController@createBenchmark')->name('createBenchmark');
                                Route::get('data-mocchuan', 'StandardController@dataMocchuan')->name('dataMocchuan');
                                Route::get('delete-mocchuan', 'StandardController@deleteMocchuan')->name('deleteMocchuan');
                                Route::get('get-mocchuan', 'StandardController@getDataMocchuan')->name('getDataMocchuan');
                                Route::post('update-mocchuan', 'StandardController@updateMocchuan')->name('updateMocchuan');
                                
                                
                                
                                // Minh chứng tối thiểu
                                Route::get('show-minimum', 'StandardController@showMinimum')->name('showMinimum');
                                Route::post('minimum', 'StandardController@minimum')->name('minimum');
                                Route::get('find-standard', 'StandardController@findStandard')->name('findStandard');
                                Route::post('data-minimun', 'StandardController@dataMinimum')->name('dataMinimum');
                                Route::get('delete-mctt', 'StandardController@deleteMctt')->name('deleteMctt');
                                Route::get('export-minimun', 'StandardController@exportMinimun')->name('exportMinimun');
                                Route::get('find-standard-criteria', 'StandardController@fStandardCriteria')->name('fStandardCriteria');
                                Route::post('create-mctt', 'StandardController@createMctt')->name('createMctt');
                                Route::get('load-data-mctt', 'StandardController@loadDataMctt')->name('loadDataMctt');
                                Route::get('load-tieuchi-mctt', 'StandardController@loadTchiMctt')->name('loadTchiMctt');
                                Route::post('update-mctt', 'StandardController@updateMctt')->name('updateMctt');

                                
                                // Gợi ý hướng dẫn
                                Route::get('show-suggestions', 'StandardController@showSugges')->name('showSugges');
                                Route::post('suggestions', 'StandardController@suggestions')->name('suggestions');
                                Route::post('data-suggestions', 'StandardController@dataSugges')->name('dataSugges');
                                Route::get('delete-sugge', 'StandardController@deleteSugge')->name('deleteSugge');
                                Route::post('create-gyhd', 'StandardController@createGyhd')->name('createGyhd');
                               Route::get('export-gyhd', 'StandardController@exportGyhd')->name('exportGyhd');
                               Route::get('load-data-gyhd', 'StandardController@loadDataSugg')->name('loadDataSugg');
                               Route::get('find-standard-criteria2', 'StandardController@fStandardCriteria2')->name('fStandardCriteria2');
                               Route::get('load-tieuchi-mctt2', 'StandardController@loadTchiMctt2')->name('loadTchiMctt2');
                               Route::post('update-gyhd', 'StandardController@updateGyhd')->name('updateGyhd');
                                
                                // Chỉ báo
                                Route::post('chibao', 'StandardController@postChibao')->name('postChibao');
                                Route::get('data-chibao', 'StandardController@dataChibao')->name('dataChibao');
                                Route::get('delete-chibao', 'StandardController@deleteChibao')->name('deleteChibao');
                                Route::post('update-chibao', 'StandardController@updateChibao')->name('updateChibao');

                                

                                
                            }
                        );
                        /*routes for set category*/
                        Route::group(
                            ['prefix' => 'manacategory', 'as' => 'manacategory.', 'namespace' => 'Category'],
                            function () {
                                // Quản lý danh mục
                                Route::get('index', 'CategoryController@index')->name('index');
                                // Lĩnh vực
                                Route::get('manafield', 'CategoryController@field')
                                    ->middleware(['super_check:admin,operator'])
                                    ->name('field');
                                Route::get('data', 'CategoryController@data')->name('data');
                                Route::post('update-manafield', 'CategoryController@updateManafield')->name('updateManafield');
                                Route::get('delete-manafield', 'CategoryController@deleteManafield')->name('deleteManafield');
                                Route::get('create-manafield', 'CategoryController@createManafield')->name('createManafield');
                                Route::post('create-manafields', 'CategoryController@createManafields')->name('createManafields');
                                Route::get('export-manafield', 'CategoryController@exportManafield')->name('exportManafield');

                                // Quản lý đơn vị
                                Route::get('manaunit', 'CategoryController@unit')
                                    ->middleware(['super_check:admin,operator,truongdonvi'])
                                    ->name('unit');
                                Route::get('data-unit', 'CategoryController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CategoryController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CategoryController@updateUnit')->name('updateUnit');
                                Route::post('create-unit', 'CategoryController@createUnit')->name('createUnit');
                                Route::post('import-unit', 'CategoryController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CategoryController@importDataUnit')->name('importDataUnit');
                                Route::get('export-data-unit', 'CategoryController@exportUnit')->name('exportUnit');
                                
                                
                                // QL nhân sự
                                Route::get('manahuman', 'CategoryController@human')
                                    ->middleware(['super_check:admin,operator'])
                                    ->name('human');
                                Route::post('create-manahuman', 'CategoryController@createHuman')->name('createHuman');
                                Route::get('data-manahuman', 'CategoryController@dataHuman')->name('dataHuman');
                                Route::get('delete-manahuman', 'CategoryController@deleteHuman')->name('deleteHuman');
                                Route::get('export-manahuman', 'CategoryController@exportHumans')->name('exportHumans');
                                Route::post('update-manahuman', 'CategoryController@updateHuman')->name('updateHuman');
                                Route::get('upload-img-dropzone', 'CategoryController@uploadDropzone')->name('uploadDropzone');
                                Route::get('reset-password', 'CategoryController@resetPass')->name('resetPass');

                                // QL CTĐT
                                Route::get('manactdt', 'CategoryController@ctdt')
                                    ->middleware(['super_check:admin,operator,truongdonvi'])
                                    ->name('ctdt');
                                Route::get('datactdt', 'CategoryController@datactdt')->name('datactdt');
                                Route::get('export-ctdt', 'CategoryController@exportCTDT')->name('exportCTDT');
                                Route::post('create-ctdt', 'CategoryController@createCTDT')->name('createCTDT');
                                Route::get('delete-ctdt', 'CategoryController@deleteCTDT')->name('deleteCTDT');
                                Route::post('update-ctdt', 'CategoryController@updateCTDT')->name('updateCTDT');
                                
                                // Quản lý cơ sở đào tạo
                                Route::get('manacsdt', 'CategoryController@csdt')
                                    ->middleware(['super_check:admin,operator'])
                                    ->name('csdt');
                                Route::get('datacsdt', 'CategoryController@datacsdt')->name('datacsdt');
                                Route::get('export-csdt', 'CategoryController@exportCSDT')->name('exportCSDT');
                                Route::get('delete-csdt', 'CategoryController@deleteCSDT')->name('deleteCSDT');
                                Route::post('update-csdt', 'CategoryController@updateCSDT')->name('updateCSDT');
                                Route::post('create-csdt', 'CategoryController@createCSDT')->name('createCSDT');

                                
                                // Quản lý link báo cáo ngoài
                                Route::get('linkreport', 'CategoryController@linkreport')
                                    ->middleware(['super_check:admin,operator'])
                                    ->name('linkreport');
                                Route::get('data-linkreport', 'CategoryController@dataLinkreport')->name('dataLinkreport');
                                Route::post('add-baocao-url', 'CategoryController@addbaocaourl')->name('addbaocaourl');
                                Route::get('deletebaocaourl', 'CategoryController@deletebaocaourl')->name('deletebaocaourl');
                                Route::get('find-linkreport', 'CategoryController@findbaocaourl')->name('findbaocaourl');
                                Route::post('edit-baocao-url', 'CategoryController@editbaocaourl')->name('editbaocaourl');
                            }
                        );
                        /*routes for set strategy*/
                        Route::group(
                            ['prefix' => 'manastrategy', 'as' => 'manastrategy.', 'namespace' => 'Strategy'],
                            function () {
                                // Đối sách
                                Route::get('index', 'StrategyController@index')->name('index');
                                // Tiêu chí đối sách
                                Route::get('stracriteria', 'StrategyController@stracriteria')->name('stracriteria');
                                // Đối tượng đối sách
                                Route::get('strasubject', 'StrategyController@strasubject')->name('strasubject');
                            }
                        );

                    }
                );

                // Route for function trao đổi thông tin
                Route::group(
                    ['prefix' => 'trao-doi-thong-tin', 'as' => 'traodoithongtin.', 'namespace' => 'Traodoithongtin'],
                    function () {
                        /*routes for Bảng Tin*/
                        Route::group(
                            ['prefix' => 'messageboard', 'as' => 'messageboard.', 'namespace' => 'Messageboard'],
                            function(){
                                //Bảng Tin
                                Route::get('index', 'MessageboardController@index')->name('index');
                                Route::post('create-bantin', 'MessageboardController@createbantin')->name('createbantin');
                                Route::get('render-ui', 'MessageboardController@renderUI')->name('renderUI');
                                Route::get('xoa-comment', 'MessageboardController@xoaComment')->name('xoaComment');
                                Route::post('post-parent', 'MessageboardController@postParent')->name('postParent');
                                Route::get('like-post', 'MessageboardController@likePosst')->name('likePosst');
                                
                            }
                        );
                        /*routes for Chat*/
                        Route::group(
                            ['prefix' => 'chat', 'as' => 'chats.', 'namespace' => 'Chat'],
                            function(){
                                //Chat
                                Route::get('index', 'ChatController@chat')->name('chat');
                            }
                        );
                    }   
                );

                // Route for function so chuẩn
                Route::group(
                    ['prefix' => 'so-chuan', 'as' => 'sochuan.', 'namespace' => 'Sochuan'],
                    function () {
                        /*routes for Lập kế hoạch*/
                        Route::group(
                            ['prefix' => 'planning', 'as' => 'planning.', 'namespace' => 'Planning'],
                            function(){
                                //Lập kế hoạch
                                Route::get('index', 'PlanningController@index')->name('index');
                                Route::get('data', 'PlanningController@data')->name('data');
                            }
                        );
                        /*routes for Thực hiện so chuẩn*/
                        Route::group(
                            ['prefix' => 'makecomparisons', 'as' => 'makecomparisons.', 'namespace' => 'Makecomparisons'],
                            function(){
                                //Thực hiện so chuẩn
                                Route::get('index', 'MakecomparisonsController@index')->name('index');
                            }
                        );
                        // /*routes for Tổng hợp kết quả*/
                        Route::group(
                            ['prefix' => 'totalresults', 'as' => 'totalresults.', 'namespace' => 'Totalresults'],
                            function(){
                                //Tổng hợp kết quả
                                Route::get('index', 'TotalresultsController@index')->name('index');
                            }
                        );

                    }   
                );
                // Route for function đảm bảo chất lượng
                Route::group(
                    ['prefix' => 'dam-bao-chat-luong', 'as' => 'dambaochatluong.', 'namespace' => 'Dambaochatluong', 'middleware' => 
                        ['super_check:admin,operator,canboDBCL,truongdonvi,khac']
                    ],
                    function () {
                        /*routes for set planning*/
                        Route::group(
                            ['prefix' => 'planning', 'as' => 'planning.', 'namespace' => 'Planning'],
                            function () {
                                // Lập kế hoạch
                                Route::get('index', 'PlanningController@index')
                                    ->middleware(['super_check:admin,operator'])
                                    ->name('index');
                                Route::get('delete-ccsl', 'PlanningController@deleteCcsl')->name('deleteCcsl');
                                Route::post('create-ccsl', 'PlanningController@createCcsl')->name('createCcsl');
                                Route::post('update-ccsl', 'PlanningController@updateCcsl')->name('updateCcsl');
                               
                                
                                Route::post('show-not-plan', 'PlanningController@showNotPlan')->name('showNotPlan');
                                Route::get('update-plan', 'PlanningController@updatePlan')->name('updatePlan');
                                Route::post('show-plan', 'PlanningController@showPlan')->name('showPlan');
                                Route::post('copy-plan', 'PlanningController@copyPlan')->name('copyPlan');
                                Route::post('create-plan', 'PlanningController@createPlan')->name('createPlan');

                                Route::get('exportplaning', 'PlanningController@exportplaning')->name('exportplaning');
                                Route::get('load-data-copy', 'PlanningController@loadDataCopy')->name('loadDataCopy');
                                
                                
                            }
                        );
                        // /*routes for set updateaci*/
                        Route::group(
                            ['prefix' => 'updateaci', 'as' => 'updateaci.', 'namespace' => 'UpdateAci'],
                            function () {
                                // Cập nhật hành động
                                Route::get('index', 'UpdateAciController@index')
                                    ->middleware(['super_check:admin,operator,canboDBCL,truongdonvi'])
                                    ->name('index');
                                Route::post('view-action', 'UpdateAciController@viewAction')->name('viewAction');
                                // Quản lý hoạt động
                                Route::get('mana-action', 'UpdateAciController@manaAction')->name('manaAction');
                                Route::post('create-action', 'UpdateAciController@createAction')->name('createAction');
                                Route::get('delete-action', 'UpdateAciController@deleteAction')->name('deleteAction');
                                Route::get('show-mcyc/{id}', 'UpdateAciController@showMcyc')->name("showMcyc");
                                Route::post('update-mcyc', 'UpdateAciController@updateMcyc')->name("updateMcyc");
                                Route::post('create-mcyc', 'UpdateAciController@createMcyc')->name("createMcyc");
                                Route::get('show-hdn-mc/{id}', 'UpdateAciController@showHdnMc')->name("showHdnMc");
                                
                                Route::post("post-update-mcyc", "UpdateAciController@postUpdateMcyc")->name("postUpdateMcyc");
                                Route::get('show-data-mc', 'UpdateAciController@showDataMc')->name("showDataMc");
                                Route::get('chen-mc', 'UpdateAciController@chenMc')->name("chenMc");
                                
                                
                                Route::get('get-update-mcyc', 'UpdateAciController@upGetMcyc')->name("upGetMcyc");
                                Route::get('delete-mcyc', 'UpdateAciController@deleteMcyc')->name("deleteMcyc");
                                Route::get('get-data-mc', 'UpdateAciController@getDataMc')->name("getDataMc");
                                Route::get('get-list-user', 'UpdateAciController@getListUser')->name('getListUser');
                                Route::get('get-list-tag', 'UpdateAciController@getListTag')->name('getListTag');
                                Route::get('exceltaction', 'UpdateAciController@exceltaction')->name('exceltaction');
                            }
                        );
                        
                        //  /*routes for set manaproof*/
                        Route::group(
                            ['prefix' => 'manaproof', 'as' => 'manaproof.', 'namespace' => 'ManaProof'],
                            function () {
                                Route::get('create-mc', "ManaProofController@newProof")->name("createMc");
                                // quản lý minh chứng
                                Route::get('index', 'ManaProofController@index')
                                    ->middleware(['super_check:admin,operator,canboDBCL,truongdonvi,khac'])
                                    ->name('index');
                                // Thêm mới minh chứng
                                Route::get('new-proof', 'ManaProofController@newProof')->name('newProof');
                                Route::get('edit-proof/{id}', 'ManaProofController@editProof')->name('editProof');
                                Route::post('view-proof', 'ManaProofController@viewProof')->name('viewProof');
                                Route::get('show-proof/{id?}', 'ManaProofController@showProof')->name('showProof');
                                Route::get('getHD', 'ManaProofController@getHD')->name('getHD');
                                Route::get('getQL', 'ManaProofController@getQL')->name('getQL');
                                Route::get('getTukhoa', 'ManaProofController@getTukhoa')->name('getTukhoa');
                                Route::post('updateMC', 'ManaProofController@updateMC')->name('updateMC');
                                Route::post('deleteMC', 'ManaProofController@deleteMC')->name('deleteMC');
                                Route::post('checkuploadfile', 'ManaProofController@checkuploadfile')->name('checkuploadfile');
                                Route::get('exportProof', 'ManaProofController@exportProof')->name('exportProof');
                                Route::get('xac-nhan-mc', 'ManaProofController@xacnhanMC')->name('xacnhanMC');

                            }
                        );

                        // /*routes for set checkproof*/
                        Route::group(
                            ['prefix' => 'kiem-tra-mc-hoat-dong', 'as' => 'checkproof.', 'namespace' => 'CheckProof'],
                            function () {
                                // kiểm tra minh chứng theo hoạt động
                                Route::get('index', 'CheckProofController@index')
                                    ->middleware(['super_check:admin,operator,canboDBCL,truongdonvi'])
                                    ->name('index');
                                Route::post('du-lieu-hoat-dong', 'CheckProofController@getData')->name('getData');
                                Route::get('chi-tiet/{id}', 'CheckProofController@detailData')->name('detailData');
                                Route::get('chinh-sua/{id}', 'CheckProofController@editData')->name('editData');
                                Route::get('danh-sach-minh-chung/{id}', 'CheckProofController@getListMc')->name('getListMc');
                                Route::get('cong-bo-hoat-dong/{id}', 'CheckProofController@congbo')->name('congbo');
                                
                                Route::get('danh-sach-minh-chung-yeu-cau/{id}', 'CheckProofController@getListMcyc')->name('getListMcyc');
                                Route::post('tu-choi', 'CheckProofController@cancelMc')->name('cancelMc');
                                Route::get('mo-lai-hoat-dong/{id}', 'CheckProofController@openAgain')->name('openAgain');
                                Route::get('mchdata', 'CheckProofController@mchdata')->name('mchdata');
                                
                            }
                        );

                        // /*routes for set proofclaim*/
                        Route::group(
                            ['prefix' => 'ke-hoach-hanh-dong', 'as' => 'proofclaim.', 'namespace' => 'ProofClaim'],
                            function () {
                                // kế hoạch hoạt động
                                Route::get('index', 'ProofClaimController@index')
                                    ->middleware(['super_check:admin,operator,canboDBCL,truongdonvi'])    
                                    ->name('index');
                                Route::post('danh-sach', 'ProofClaimController@getListKhhd')->name('getListKhhd');
                                Route::get('exportlistKhhd', 'ProofClaimController@exportlistKhhd')->name('exportlistKhhd');
                                
                            }
                        );
                    }
                );

                // Route for function đối sánh
                Route::group(
                    ['prefix' => 'doi-sanh', 'as' => 'doisanh.', 'namespace' => 'Doisanh'],
                    function () {
                        /*routes for Lập kế hoạch*/
                        Route::group(
                            ['prefix' => 'planning', 'as' => 'planning.', 'namespace' => 'Planning'],
                            function(){
                                //Lập kế hoạch
                                Route::get('index', 'PlanningController@index')->name('index');
                                Route::get('update', 'PlanningController@update')->name('update');
                            }
                        );
                        /*routes for Thực hiện đối sánh*/
                        Route::group(
                            ['prefix' => 'makestrategy', 'as' => 'makestrategy.', 'namespace' => 'MakeStrategy'],
                            function(){
                                //Thực hiện đối sánh
                                Route::get('index', 'MakeStrategyController@index')->name('index');
                            }
                        );
                        /*routes for Tổng hợp kết quả*/
                        Route::group(
                            ['prefix' => 'syntresult', 'as' => 'syntresult.', 'namespace' => 'SyntResult'],
                            function(){
                                //Tổng hợp kết quả
                                Route::get('index', 'SyntResultController@index')->name('index');
                            }
                        );
                    }   
                );

                // Tổng hợp
                Route::group(
                    ['prefix' => 'tonghop', 'as' => 'tonghop.', 'namespace' => 'Tonghop'],
                    function(){
                        //Tổng hợp
                        Route::group(
                            ['prefix' => 'tong-hop', 'as' => 'dbcl.', 'namespace' => 'Dambaocl'],
                            function(){
                                // Tổng hợp
                                Route::get('index', 'ToghopControntroller@index')->name('index');
                                Route::get('datadbcl', 'ToghopControntroller@datadbcl')->name('datadbcl');
                                Route::get('baocaotiendo', 'ToghopControntroller@baocaotiendo')->name('baocaotiendo');
                                Route::get('data', 'ToghopControntroller@data')->name('data');
                                Route::get('minhchungyc', 'ToghopControntroller@minhchungyc')->name('minhchungyc');
                                Route::get('datamcyc', 'ToghopControntroller@datamcyc')->name('datamcyc');
                            }
                        );
                    }
                );
                // Route for function tự đánh giá
                Route::group(
                    ['prefix' => 'tu-danh-gia', 'as' => 'tudanhgia.', 'namespace' => 'Tudanhgia', 'middleware' => [
                        'super_check:admin,operator,ns_thuchien,ns_phutrach,ns_kiemtra,ttchuyentrach'
                    ]],
                    function () {
                        // Danh sách báo cáo tự đánh giá
                        Route::group(
                            ['prefix' => 'report', 'as' => 'report.', 'namespace' => 'Report'],
                            function(){
                                //DS Báo cáo tự đánh giá 
                                Route::get('index', 'ReportController@index')
                                    ->middleware(['super_check:admin,operator,ttchuyentrach'])
                                    ->name('index');
                                //Data 
                                Route::get('data', 'ReportController@data')->name('data');
                                Route::get('lap-ke-hoach/{id}', 'ReportController@planning')->name('planning');
                                //update date
                                Route::get('upadate_kq', 'ReportController@upadate_kq')->name('upadate_kq');
                                Route::get('upadate_tieuchuan', 'ReportController@upadate_tieuchuan')->name('upadate_tieuchuan');
                                Route::get('upadate_tieuchi', 'ReportController@upadate_tieuchi')->name('upadate_tieuchi');
                                Route::get('upadate_menhde', 'ReportController@upadate_menhde')->name('upadate_menhde');
                                Route::get('star_tieuchuan', 'ReportController@star_tieuchuan')->name('star_tieuchuan');

                                Route::post('datadetail', 'ReportController@datadetail')->name('datadetail');
                                Route::get('dsbctdg', 'ReportController@dsbctdg')->name('dsbctdg');
                                Route::get('detail_bc/{id}', 'ReportController@detail_bc')->name('detail_bc');
                                Route::get('data_deatial', 'ReportController@data_deatial')->name('data_deatial');
                                Route::post('show_nsth', 'ReportController@show_nsth')->name('show_nsth');
                                Route::get('show_tctieuchi', 'ReportController@show_tctieuchi')->name('show_tctieuchi');
                                Route::post('show_nsth_tc', 'ReportController@show_nsth_tc')->name('show_nsth_tc');
                                Route::get('data_deatial_khvbc', 'ReportController@data_deatial_khvbc')->name('data_deatial_khvbc');
                                //chi tiết kế hoạch viết báo cáo
                                Route::get('detail_baocao/{id}', 'ReportController@detail_baocao')->name('detail_baocao');
                                Route::get('data_deatial_khbc', 'ReportController@data_deatial_khbc')->name('data_deatial_khbc');
                                Route::post('show_nskt', 'ReportController@show_nskt')->name('show_nskt');
                                Route::get('show_tctieuchi_bc', 'ReportController@show_tctieuchi_bc')->name('show_tctieuchi_bc');
                                Route::post('show_nskt_tc', 'ReportController@show_nskt_tc')->name('show_nskt_tc');
                                Route::get('show_tctieuchi_md', 'ReportController@show_tctieuchi_md')->name('show_tctieuchi_md');
                                Route::post('show_nskt_md', 'ReportController@show_nskt_md')->name('show_nskt_md');
                                Route::post('updatebosung', 'ReportController@updatebosung')->name('updatebosung');
                            }
                        );
                        //Thêm mới báo cáo
                        Route::group(
                            ['prefix' => 'addreport', 'as' => 'addreport.', 'namespace' => 'Addreport'],
                            function(){
                                //Thêm mới báo cáo  
                                Route::get('index', 'AddreportController@index')->name('index');
                                Route::post('insert', 'AddreportController@insert')->name('insert');
                                Route::get('searchLtc', 'AddreportController@searchLtc')->name('searchLtc');
                                
                            }
                        );

                        //Lập kế hoạch chi tiết
                        Route::group(
                            ['prefix' => 'detailedplanning', 'as' => 'detailedplanning.', 'namespace' => 'Detailedplanning'],
                            function(){
                                //Lập kế hoạch chi tiết
                                Route::get('index', 'DetailedplanningController@index')
                                    ->middleware(['super_check:admin,operator,ns_thuchien,ttchuyentrach'])
                                    ->name('index');
                                Route::get('data', 'DetailedplanningController@data')->name('data');
                                Route::get('showCriteria','DetailedplanningController@showCriteria' )->name('showCriteria');
                                Route::get('detail/{id}','DetailedplanningController@detail')->name('detail');
                                Route::get('general/{id}/{id_khchung?}', 'DetailedplanningController@general')->name('general');
                                Route::get('update', 'DetailedplanningController@update')->name('update');
                                Route::get('show', 'DetailedplanningController@show')->name('show');
                                Route::get('datatext', 'DetailedplanningController@datatext')->name('datatext');
                                Route::get('showmochuan', 'DetailedplanningController@showmochuan')->name('showmochuan');
                                Route::post('showmctt', 'DetailedplanningController@showmctt')->name('showmctt');
                                Route::get('showhuongdan', 'DetailedplanningController@showhuongdan')->name('showhuongdan');
                                Route::get('showcongbotieuchi', 'DetailedplanningController@showcongbotieuchi')->name('showcongbotieuchi');
                                Route::get('moLaiTieuChi', 'DetailedplanningController@moLaiTieuChi')->name('moLaiTieuChi');
                                Route::post('updategeneral', 'DetailedplanningController@updategeneral')->name('updategeneral');
                                Route::post('updatetieuchuan', 'DetailedplanningController@updatetieuchuan')->name('updatetieuchuan');
                                Route::post('updatetieuchuan2', 'DetailedplanningController@updatetieuchuan2')->name('updatetieuchuan2');

                                Route::post('updatemenhde', 'DetailedplanningController@updatemenhde')->name('updatemenhde');
                                Route::post('creat_khhd', 'DetailedplanningController@creat_khhd')->name('creat_khhd');
                                Route::get('conclusion/{id}/{id_khchung?}', 'DetailedplanningController@conclusion')->name('conclusion');
                                Route::post('updateconclusion', 'DetailedplanningController@updateconclusion')->name('updateconclusion');
                                Route::post('updatemenhdedm', 'DetailedplanningController@updatemenhdedm')->name('updatemenhdedm');
                                Route::post('updatemenhdett', 'DetailedplanningController@updatemenhdett')->name('updatemenhdett');
                                Route::post('updtecbmd', 'DetailedplanningController@updtecbmd')->name('updtecbmd');
                                Route::post('updtemlmd', 'DetailedplanningController@updtemlmd')->name('updtemlmd');  
                                Route::post('update_muc', 'DetailedplanningController@update_muc')->name('update_muc'); 

                                Route::get('showmcgop', 'DetailedplanningController@showmcgop')->name('showmcgop'); 
                                Route::post('modalminhchung', 'DetailedplanningController@modalminhchung')->name('modalminhchung');

                                Route::post('tontai_diemmanh', 'DetailedplanningController@tontai_diemmanh')->name('tontai_diemmanh');
                                Route::post('delete_diemmanh', 'DetailedplanningController@delete_diemmanh')->name('delete_diemmanh');
                                Route::post('show_tontai_diemmanh', 'DetailedplanningController@show_tontai_diemmanh')->name('show_tontai_diemmanh');
                            }
                        );

                         //Nhận xét báo cáo
                        Route::group(
                            ['prefix' => 'commentreport', 'as' => 'commentreport.', 'namespace' => 'Commentreport'],
                            function(){
                                Route::get('index', 'CommentreportController@index')
                                    ->middleware(['super_check:admin,operator,ns_kiemtra,ttchuyentrach']) 
                                    ->name('index');
                                //Data
                                Route::get('data', 'CommentreportController@data')->name('data');
                                Route::get('general/{id}', 'CommentreportController@general')->name('general');
                                Route::get('conclusion/{id}', 'CommentreportController@conclusion')->name('conclusion');
                                Route::post('createComment', 'CommentreportController@createComment')->name('createComment');
                                Route::post('nhanXetDelete', 'CommentreportController@nhanXetDelete')->name('nhanXetDelete'); 

                                Route::get('viewreport', 'CommentreportController@viewReport')->name('viewReport');
                                Route::post('createCommentBlock', 'CommentreportController@createCommentBlock')->name('createCommentBlock'); 
                                Route::post('update_nx', 'CommentreportController@update_nx')->name('update_nx'); 
                                Route::post('delete_nx', 'CommentreportController@delete_nx')->name('delete_nx'); 
                                Route::post('update_comment', 'CommentreportController@update_comment')->name('update_comment');
                            }
                        );
                        //Hoàn thành báo cáo
                        Route::group(
                            ['prefix' => 'completionreport', 'as' => 'completionreport.', 'namespace' => 'Completionreport'],
                            function(){
                                //Chuẩn bị báo cáo
                                Route::get('index', 'CompletionreportController@index')
                                    ->middleware(['super_check:admin,operator,ttchuyentrach'])
                                    ->name('index');
                                //Data
                                Route::get('data', 'CompletionreportController@data')->name('data');
                                Route::get('detail/{id}', 'CompletionreportController@detail')->name('detail');
                                Route::post('exit_hoanthanh', 'CompletionreportController@exit_hoanthanh')->name('exit_hoanthanh');
                                Route::post('exit_molai', 'CompletionreportController@exit_molai')->name('exit_molai');
                                Route::post('encode', 'CompletionreportController@encode')->name('encode');
                            }
                        );

                        //Chuẩn bị đánh giá
                        Route::group(
                            ['prefix' => 'preparereport', 'as' => 'preparereport.', 'namespace' => 'Preparereport'],
                            function(){
                                //Chuẩn bị báo cáo
                                Route::get('index', 'PreparereportController@index')->name('index');
                                 Route::get('data', 'PreparereportController@data')->name('data');
                                // Phân tích yêu cầu
                                Route::get('phan-tich-yeu-cau', 'PreparereportController@requireAnalysis')->name('requireAnalysis');
                                Route::post('search-ptyc', 'PreparereportController@searchPtyc')->name('searchPtyc');
                                Route::get('manacollect', 'PreparereportController@manacollect')->name('manacollect');
                                Route::get('proof-handling', 'PreparereportController@proofHandling')
                                    ->middleware(['super_check:admin,operator,ns_phutrach,ttchuyentrach'])
                                    ->name('proofHandling');
                                Route::post('show-minh-chung-gop', 'PreparereportController@showmcgop')->name('showmcgop');
                                Route::get('view-mcgop/{id}', 'PreparereportController@viewmcgop')->name('viewmcgop');
                                Route::post('xoa-mc-thanh-phan', 'PreparereportController@deleteMctp')->name('deleteMctp');
                                Route::post('xoa-mc-gop', 'PreparereportController@deleteMcGroup')->name('deleteMcGroup');
                                Route::get('xu-ly-mc', 'PreparereportController@proofHandGroup')->name('proofHandGroup');
                                Route::get('search-mctt', 'PreparereportController@searchMctt')->name('searchMctt');
                                Route::post('gop-minh-chung', 'PreparereportController@gopMinhChung')->name('gopMinhChung');
                                Route::get('edit-mc-gop/{id}', 'PreparereportController@editmcgop')->name('editmcgop');
                                
                                // đối chiếu minh chứng
                                Route::get('doi-chieu-mc', 'PreparereportController@proofCompare')
                                    ->middleware(['super_check:admin,operator,ns_phutrach,ttchuyentrach'])
                                    ->name('proofCompare');
                                Route::post('show-dsmc', 'PreparereportController@showdsmc')->name('showdsmc');
                                Route::post('xac-nhan-tieu-chi', 'PreparereportController@xacnhanTchi')->name('xacnhanTchi');
                                Route::post('bo-xac-nhan-tieu-chi', 'PreparereportController@boxacnhanTchi')->name('boxacnhanTchi');
                                Route::post('xoa-minh-chung', 'PreparereportController@xoaMinhChung')->name('xoaMinhChung');
                                Route::get('create-mc-gop', 'PreparereportController@createMcGop')->name('createMcGop');
                                

                                
                            }
                        );
                    }
                );

                // Route for function đánh giá ngoài 
                Route::group(
                    ['prefix' => 'danh-gia-ngoai', 'as' => 'danhgiangoai.', 'namespace' => 'Danhgiangoai'],
                    function(){
                        // Báo cáo tự đánh giá
                        Route::group(
                            ['prefix' => 'bao-cao-tdg', 'as' => 'baocaotudanhgia.', 'namespace' => 'ExternalReview'],
                            function(){
                                // Đánh giá ngoài
                                Route::get('bao-cao/{id?}','ExternalReviewController@index')->name('index');
                                Route::get('data','ExternalReviewController@data')->name('data');
                                Route::get('bao-cao-khac/{id?}','ExternalReviewController@baoCaoKhac')->name('baoCaoKhac');
                                Route::get('thu-vien_minhchung/{id?}','ExternalReviewController@thuvienminhchung')->name('thuvienminhchung');
                                Route::get('thuvien','ExternalReviewController@thuvien')->name('thuvien');
                                Route::post('get-data-minhching','ExternalReviewController@dataMinhChung')->name('dataMinhChung');
                                 Route::get('du-gio-truc-tuyen/{id?}','ExternalReviewController@dugiotructuyen')->name('dugiotructuyen');
                                 Route::get('phong-van-truc-tuyen/{id?}','ExternalReviewController@phongvantructuyen')->name('phongvantructuyen');
                                 // Route::get('listMinhChung','ExternalReviewController@listMinhChung')->name('listMinhChung');
                                 Route::get('test','ExternalReviewController@test')->name('test');

                            }
                        );

                        // Lập kế hoạch đánh giá ngoài
                        Route::group(
                            ['prefix' => 'lap-ke-hoach-dgn', 'as' => 'lapkehoachdanhgian.', 'namespace' => 'Planningassessment'],
                            function(){
                                // Đánh giá ngoài
                                Route::get('/','PlanningassessmentController@index')
                                ->middleware(['super_check:admin,operator'])
                                ->name('index');
                                Route::post("phanquyen", 'PlanningassessmentController@phanquyen')->name('phanquyen');
                                Route::get('get-data','PlanningassessmentController@getdata')->name('getdata');
                                Route::get('delete-data','PlanningassessmentController@deletedata')->name('deletedata');
                                
                            }
                        );
                    }


                );


                // Route for function Import dữ liệu thô 
                Route::group(
                    ['prefix' => 'import-du-lieu-excel', 'as' => 'importdata.', 'namespace' => 'Importdata', 'middleware' => ['super_check:admin,operator']],
                    function(){
                        // Import thông tin cơ bản
                        Route::group(
                            ['prefix' => 'thong-tin-co-ban', 'as' => 'thongtincoban.', 'namespace' => 'Thongtincoban'],
                            function(){
                                Route::get('index','BasicInforController@index')->name('index');
                                Route::post('import-unit', 'BasicInforController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'BasicInforController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'BasicInforController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'BasicInforController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'BasicInforController@updateUnit')->name('updateUnit');

                                //Export thông tin cơ bản
                                Route::get('export-basiclnfor', 'BasicInforController@exportBasiclnfor')->name('exportBasiclnfor');
                            }
                        );

                        // Import thông tin nhân sự
                        Route::group(
                            ['prefix' => 'nhan-su', 'as' => 'nhansu.', 'namespace' => 'Nhansu'],
                            function(){
                                Route::get('index','NhansuController@index')->name('index');
                                Route::post('import-unit', 'NhansuController@importUnit')->name('importUnit');
                                Route::get('data-unit', 'NhansuController@dataUnit')->name('dataUnit');
                                Route::post('import-data-unit', 'NhansuController@importDataUnit')->name('importDataUnit');
                                Route::get('delete-unit', 'NhansuController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'NhansuController@updateUnit')->name('updateUnit');
                                
                                //Export nhân sự
                                Route::get('export-unit', 'NhansuController@exportUnit')->name('exportUnit');
                            }
                        );

                        // Import dữ liệu sinh viên
                        Route::group(
                            ['prefix' => 'du-lieu-sinh-vien', 'as' => 'dlsinhvien.', 'namespace' => 'Dlsinhvien'],
                            function(){
                                Route::get('index','DlsinhvienController@index')->name('index');
                                Route::post('import-unit', 'DlsinhvienController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 
                                    'DlsinhvienController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'DlsinhvienController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'DlsinhvienController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'DlsinhvienController@updateUnit')->name('updateUnit');
                                //Export sinh viên
                                Route::get('export-unit', 'DlsinhvienController@exportUnit')->name('exportUnit');
                                
                            }
                        );
                        // Import KHCN
                        Route::group(
                            ['prefix' => 'khcn', 'as' => 'khcn.', 'namespace' => 'Khcn'],
                            function(){
                                Route::get('index','KhcnController@index')->name('index');
                                Route::post('import-unit', 'KhcnController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'KhcnController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'KhcnController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'KhcnController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'KhcnController@updateUnit')->name('updateUnit');
                                //Export KHCN
                                Route::get('export-unit', 'KhcnController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import Doanh thu KHCN
                        Route::group(
                            ['prefix' => 'doanh-thu-khcn', 'as' => 'dtkhcn.', 'namespace' => 'Dtkhcn'],
                            function(){
                                Route::get('index','DtkhcnController@index')->name('index');
                                Route::post('import-unit', 'DtkhcnController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'DtkhcnController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'DtkhcnController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'DtkhcnController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'DtkhcnController@updateUnit')->name('updateUnit');
                                //Export Doanh thu KHCN
                                Route::get('export-unit', 'DtkhcnController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import biên soạn sách
                        Route::group(
                            ['prefix' => 'bien-soan-sach', 'as' => 'bssach.', 'namespace' => 'Bssach'],
                            function(){
                                Route::get('index','BssachController@index')->name('index');
                                Route::post('import-unit', 'BssachController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'BssachController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'BssachController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'BssachController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'BssachController@updateUnit')->name('updateUnit');
                                //Export biên soạn sách
                                Route::get('export-unit', 'BssachController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import bài báo-báo cáo
                        Route::group(
                            ['prefix' => 'bai-bao-bao-cao', 'as' => 'baibaobc.', 'namespace' => 'Baibaobc'],
                            function(){
                                Route::get('index','BaibaobcController@index')->name('index');
                                Route::post('import-unit', 'BaibaobcController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'BaibaobcController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'BaibaobcController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'BaibaobcController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'BaibaobcController@updateUnit')->name('updateUnit');
                                //Export bài báo-báo cáo
                                Route::get('export-unit', 'BaibaobcController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import sáng chế
                        Route::group(
                            ['prefix' => 'sang-che', 'as' => 'sangche.', 'namespace' => 'Sangche'],
                            function(){
                                Route::get('index','SangcheController@index')->name('index');
                                Route::post('import-unit', 'SangcheController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'SangcheController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'SangcheController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'SangcheController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'SangcheController@updateUnit')->name('updateUnit');
                                //Export sáng chế
                                Route::get('export-unit', 'SangcheController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import giải thưởng
                        Route::group(
                            ['prefix' => 'giai-thuong', 'as' => 'giaithuong.', 'namespace' => 'Giaithuong'],
                            function(){
                                Route::get('index','GiaithuongController@index')->name('index');
                                Route::post('import-unit', 'GiaithuongController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'GiaithuongController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'GiaithuongController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'GiaithuongController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'GiaithuongController@updateUnit')->name('updateUnit');

                                //Export giải thưởng
                                Route::get('export-unit', 'GiaithuongController@exportUnit')->name('exportUnit');
                            }
                        );
                        // Import tuyển sinh
                        Route::group(
                            ['prefix' => 'tuyen-sinh', 'as' => 'tuyensinh.', 'namespace' => 'Tuyensinh'],
                            function(){
                                Route::get('index','TuyensinhController@index')->name('index');
                                Route::post('import-unit', 'TuyensinhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'TuyensinhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'TuyensinhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'TuyensinhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'TuyensinhController@updateUnit')->name('updateUnit');

                                //Export tuyển sinh
                                Route::get('export-admissions', 'TuyensinhController@exportAdmissions')->name('exportAdmissions');


                                Route::get('delete-table-data', 'TuyensinhController@deleteDataTable')->name('deleteDataTable');
                            }
                        );

                        // Import chương trình đào tạo
                        Route::group(
                            ['prefix' => 'chuong-trinh-dao-tao', 'as' => 'ctdt.', 'namespace' => 'Chuongtrinhdaotao'],
                            function(){
                                Route::get('index','Chuongtrinhdaotao@index')->name('index');
                                Route::post('import-unit', 'Chuongtrinhdaotao@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'Chuongtrinhdaotao@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'Chuongtrinhdaotao@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'Chuongtrinhdaotao@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'Chuongtrinhdaotao@updateUnit')->name('updateUnit');

                                //Export chương trình đào tạo
                                Route::get('export-ctdt', 'Chuongtrinhdaotao@exportCtdt')->name('exportCtdt');

                            }
                        );

                        // Import thống kê tài chính
                        Route::group(
                            ['prefix' => 'thong-ke-tai-chinh', 'as' => 'tktc.', 'namespace' => 'Thongketaichinh'],
                            function(){
                                Route::get('index','ThongketaichinhController@index')->name('index');
                                Route::post('import-unit', 'ThongketaichinhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'ThongketaichinhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'ThongketaichinhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'ThongketaichinhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'ThongketaichinhController@updateUnit')->name('updateUnit');

                                //Export thống kê tài chính
                                Route::get('export-tktc', 'ThongketaichinhController@exportTktc')->name('exportTktc');

                            }
                        );

                        // Import thống kê ký túc xá
                        Route::group(
                            ['prefix' => 'thong-ke-ky-tuc-xa', 'as' => 'tkktx.', 'namespace' => 'Thongkekytucxa'],
                            function(){
                                Route::get('index','ThongkekytucxaController@index')->name('index');
                                Route::post('import-unit', 'ThongkekytucxaController@importUnit')->name('importUnit');
                                // Route::post('import-data-unit', 'ThongkekytucxaController@importDataUnit')->name('importDataUnit');
                                // Route::get('data-unit', 'ThongkekytucxaController@dataUnit')->name('dataUnit');
                                Route::post('delete-unit', 'ThongkekytucxaController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'ThongkekytucxaController@updateUnit')->name('updateUnit');

                                //Export thống kê ký túc xá
                                Route::get('export-tkktx', 'ThongkekytucxaController@exportTkktx')->name('exportTkktx');

                            }
                        );

                        // Import thống kê máy tính
                        Route::group(
                            ['prefix' => 'thong-ke-may-tinh', 'as' => 'tkmt.', 'namespace' => 'Thongkemaytinh'],
                            function(){
                                Route::get('index','ThongkemaytinhController@index')->name('index');
                                Route::post('import-unit', 'ThongkemaytinhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'ThongkemaytinhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'ThongkemaytinhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'ThongkemaytinhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'ThongkemaytinhController@updateUnit')->name('updateUnit');

                                //Export thống kê máy tính
                                Route::get('export-tkmt', 'ThongkemaytinhController@exportTkmt')->name('exportTkmt');

                            }
                        );

                        // Import doanh thu KHCN2
                        Route::group(
                            ['prefix' => 'doanh-thu-khcn2', 'as' => 'dtkhcn2.', 'namespace' => 'Dtkhcn2'],
                            function(){
                                Route::get('index','Dtkhcn2Controller@index')->name('index');
                                Route::post('import-unit', 'Dtkhcn2Controller@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'Dtkhcn2Controller@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'Dtkhcn2Controller@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'Dtkhcn2Controller@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'Dtkhcn2Controller@updateUnit')->name('updateUnit');

                                //Export danh thu KHCN2
                                Route::get('export-dtkhcn2', 'Dtkhcn2Controller@exportDtkhcn2')->name('exportDtkhcn2');

                            }
                        );

                        // Import kết quả kiểm định chất lượng
                        Route::group(
                            ['prefix' => 'kiem-dinh-chat-luong', 'as' => 'kdcl.', 'namespace' => 'Kdcl'],
                            function(){
                                Route::get('index','KdclController@index')->name('index');
                                Route::post('import-unit', 'KdclController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'KdclController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'KdclController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'KdclController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'KdclController@updateUnit')->name('updateUnit');

                                //Export Kiểm định chất lượng
                                Route::get('export-kdcl', 'KdclController@exportKdcl')->name('exportKdcl');

                            }
                        );

                        // Import tài liệu thư viện
                        Route::group(
                            ['prefix' => 'tai-lieu-thu-vien', 'as' => 'tltv.', 'namespace' => 'Tlthuvien'],
                            function(){
                                Route::get('index','TltvController@index')->name('index');
                                Route::post('import-unit', 'TltvController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'TltvController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'TltvController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'TltvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'TltvController@updateUnit')->name('updateUnit');

                                //Export tài liệu thư viện
                                Route::get('export-tltv', 'TltvController@exportTltv')->name('exportTltv');

                            }
                        );

                        // Import thống kê phòng, trang thiết bị
                        Route::group(
                            ['prefix' => 'thong-ke-phong-trang-thiet-bi', 'as' => 'tkpttb.', 'namespace' => 'Tkphongtrangthietbi'],
                            function(){
                                Route::get('index','TkpttbController@index')->name('index');
                                Route::post('import-unit', 'TkpttbController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'TkpttbController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'TkpttbController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'TkpttbController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'TkpttbController@updateUnit')->name('updateUnit');

                                //Export thống kê phòng, trang thiết bị
                                Route::get('export-tkpttb', 'TkpttbController@exportTkpttb')->name('exportTkpttb');

                            }
                        );

                        // Import thu gọn lĩnh vực
                        Route::group(
                            ['prefix' => 'thu-gon-linh-vuc', 'as' => 'tglv.', 'namespace' => 'Thugonlinhvuc'],
                            function(){
                                Route::get('index','ThugonlvController@index')->name('index');
                                Route::post('import-unit', 'ThugonlvController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'ThugonlvController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'ThugonlvController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'ThugonlvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'ThugonlvController@updateUnit')->name('updateUnit');

                                //Export thu gọn lĩnh vực
                                Route::get('export-tglv', 'ThugonlvController@exportTglv')->name('exportTglv');

                            }
                        );

                        // Import diện tích sàn xây dựng
                        Route::group(
                            ['prefix' => 'dien-tich-san-xay-dung', 'as' => 'dtsxd.', 'namespace' => 'Dientichsanxdung'],
                            function(){
                                Route::get('index','DientichSanController@index')->name('index');
                                Route::post('import-unit', 'DientichSanController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'DientichSanController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'DientichSanController@dataUnit')->name('dataUnit');
                                // Route::get('delete-unit', 'ThugonlvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'DientichSanController@updateUnit')->name('updateUnit');

                                //Export diện tích sàn xây dựng
                                Route::get('export-tglv', 'DientichSanController@exportDtSan')->name('exportDtSan');
                            }
                        );

                        // Import khảo sát tình trạng tốt nghiệp sinh viên
                        Route::group(
                            ['prefix' => 'tinh-trang-tot-nghiep', 'as' => 'tttn.', 'namespace' => 'TinhTrangTotNghiep'],
                            function(){
                                Route::get('index','TtTotNghiepController@index')->name('index');

                                Route::post('import-unit', 'TtTotNghiepController@importUnit')->name('importUnit');
                                // Route::post('import-data-unit', 'DientichSanController@importDataUnit')->name('importDataUnit');
                                // Route::get('data-unit', 'DientichSanController@dataUnit')->name('dataUnit');
                                Route::post('delete-unit', 'TtTotNghiepController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'TtTotNghiepController@updateUnit')->name('updateUnit');

                                //Export khảo sát tình trạng tốt nghiệp sinh viên
                                Route::get('export-tglv', 'TtTotNghiepController@exportTttnsv')->name('exportTttnsv');
                            }
                        );


                        // Import thông tin đồ án, khóa luận, luận văn, luận án tốt nghiệp
                        Route::group(
                            ['prefix' => 'thong-tin-do-an-khoa-luan', 'as' => 'ttdakl.', 'namespace' => 'Thongtindakl'],
                            function(){
                                Route::get('index','ThongtindaklController@index')->name('index');
                                Route::post('import-unit', 'ThongtindaklController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'ThongtindaklController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'ThongtindaklController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'ThongtindaklController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'ThongtindaklController@updateUnit')->name('updateUnit');

                                //Export thông tin đồ án, khóa luận, luận văn, luận án tốt nghiệp
                                Route::get('export-ttdakl', 'ThongtindaklController@exportTtdakl')->name('exportTtdakl');

                            }
                        );

                        // Import công khai hội nghị, hội thảo khoa học do csgd tổ chức
                        Route::group(
                            ['prefix' => 'cong-khai-hoi-nghi', 'as' => 'ckhnhtkh.', 'namespace' => 'Congkhaihnhtkh'],
                            function(){
                                Route::get('index','CongkhaihnhtkhController@index')->name('index');
                                Route::post('import-unit', 'CongkhaihnhtkhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaihnhtkhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaihnhtkhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaihnhtkhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaihnhtkhController@updateUnit')->name('updateUnit');

                                //Export công khai hội nghị, hội thảo khoa học do csgd tổ chức
                                Route::get('export-ckhnhtkh', 'CongkhaihnhtkhController@exportCkhnhtkh')->name('exportCkhnhtkh');

                            }
                        );

                         // Import công khai giáo trình, tài liệu tham khảo do cơ sở giáo dục tổ chức biên soạn 
                         Route::group(
                            ['prefix' => 'cong-khai-tai-lieu', 'as' => 'ckgttl.', 'namespace' => 'Congkhaigttl'],
                            function(){
                                Route::get('index','CongkhaigttlController@index')->name('index');
                                Route::post('import-unit', 'CongkhaigttlController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaigttlController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaigttlController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaigttlController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaigttlController@updateUnit')->name('updateUnit');

                                //Export  giáo trình, tài liệu tham khảo do cơ sở giáo dục tổ chức biên soạn 
                                Route::get('export-ckgttl', 'CongkhaigttlController@exportCkgttl')->name('exportCkgttl');

                            }
                        );

                         // Import công khai các môn học của từng khóa học, chuyên ngành 
                         Route::group(
                            ['prefix' => 'cong-khai-mon-hoc', 'as' => 'ckmh.', 'namespace' => 'Congkhaimh'],
                            function(){
                                Route::get('index','CongkhaimhController@index')->name('index');
                                Route::post('import-unit', 'CongkhaimhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaimhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaimhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaimhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaimhController@updateUnit')->name('updateUnit');

                                //Export công khai các môn học của từng khóa học, chuyên ngành
                                Route::get('export-ckmh', 'CongkhaimhController@exportCkmh')->name('exportCkmh');

                            }
                        );

                        // Import công khai thông tin về quy mô đào tạo hiện tại   
                        Route::group(
                            ['prefix' => 'cong-khai-quy-mo-dao-tao', 'as' => 'ckqmdt.', 'namespace' => 'Congkhaiqmdt'],
                            function(){
                                Route::get('index','CongkhaiqmdtController@index')->name('index');
                                Route::post('import-unit', 'CongkhaiqmdtController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaiqmdtController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaiqmdtController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaiqmdtController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaiqmdtController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về quy mô đào tạo hiện tại
                                Route::get('export-ckqmdt', 'CongkhaiqmdtController@exportCkqmdt')->name('exportCkqmdt');

                            }
                        );

                         // Import công khai thông tin về các phòng thí nghiệm, phòng thực hành, xưởng thực tập, nhà tập đa năng, hội trường, phòng học, thư viện, trung tâm học liệu
                         Route::group(
                            ['prefix' => 'cong-khai-cac-phong', 'as' => 'ckcp.', 'namespace' => 'Congkhaicp'],
                            function(){
                                Route::get('index','CongkhaicpController@index')->name('index');
                                Route::post('import-unit', 'CongkhaicpController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaicpController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaicpController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaicpController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaicpController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về các phòng thí nghiệm, phòng thực hành, xưởng thực tập, nhà tập đa năng, hội trường, phòng học, thư viện, trung tâm học liệu
                                Route::get('export-ckcp', 'CongkhaicpController@exportCkcp')->name('exportCkcp');

                            }
                        );

                         // Import công khai thông tin về sinh viên tốt nghiệp và tỷ lệ sinh viên có việc làm
                         Route::group(
                            ['prefix' => 'cong-khai-sinh-vien-tot-nghiep', 'as' => 'cksvtn.', 'namespace' => 'Congkhaisvtn'],
                            function(){
                                Route::get('index','CongkhaisvtnController@index')->name('index');
                                Route::post('import-unit', 'CongkhaisvtnController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaisvtnController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaisvtnController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaisvtnController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaisvtnController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về sinh viên tốt nghiệp và tỷ lệ sinh viên có việc làm
                                Route::get('export-cksvtn', 'CongkhaisvtnController@exportCksvtn')->name('exportCksvtn');

                            }
                        );

                        // Import công khai thông tin kiểm định cơ sở giáo dục và chương trình giáo dục
                        Route::group(
                            ['prefix' => 'cong-khai-co-so-giao-duc', 'as' => 'ckcsgd.', 'namespace' => 'Congkhaicsgd'],
                            function(){
                                Route::get('index','CongkhaicsgdController@index')->name('index');
                                Route::post('import-unit', 'CongkhaicsgdController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaicsgdController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaicsgdController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaicsgdController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaicsgdController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin kiểm định cơ sở giáo dục và chương trình giáo dục
                                Route::get('export-ckcsgd', 'CongkhaicsgdController@exportCkcsgd')->name('exportCkcsgd');

                            }
                        );

                        // Import công khai thông tin kiểm định cơ sở giáo dục và chương trình giáo dục
                        Route::group(
                            ['prefix' => 'cong-khai-co-so-giao-duc', 'as' => 'ckcsgd.', 'namespace' => 'Congkhaicsgd'],
                            function(){
                                Route::get('index','CongkhaicsgdController@index')->name('index');
                                Route::post('import-unit', 'CongkhaicsgdController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaicsgdController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaicsgdController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaicsgdController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaicsgdController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin kiểm định cơ sở giáo dục và chương trình giáo dục
                                Route::get('export-ckcsgd', 'CongkhaicsgdController@exportCkcsgd')->name('exportCkcsgd');

                            }
                        );

                        // Import công khai tỷ lệ sinh viên/giảng viên quy đổi 
                        Route::group(
                            ['prefix' => 'cong-khai-sinh-vien-giang-vien', 'as' => 'cksvgv.', 'namespace' => 'Congkhaisvgv'],
                            function(){
                                Route::get('index','CongkhaisvgvController@index')->name('index');
                                Route::post('import-unit', 'CongkhaisvgvController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaisvgvController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaisvgvController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaisvgvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaisvgvController@updateUnit')->name('updateUnit');

                                //Export công khai tỷ lệ sinh viên/giảng viên quy đổi 
                                Route::get('export-cksvgv', 'CongkhaisvgvController@exportCksvgv')->name('exportCksvgv');

                            }
                        );

                        // Import diện tích đất/sinh viên; diện tích sàn/sinh viên  
                        Route::group(
                            ['prefix' => 'dien-tich-dat-sinh-vien', 'as' => 'ckdtdsv.', 'namespace' => 'Congkhaidtdsv'],
                            function(){
                                Route::get('index','CongkhaidtdsvController@index')->name('index');
                                Route::post('import-unit', 'CongkhaidtdsvController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaidtdsvController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaidtdsvController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaidtdsvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaidtdsvController@updateUnit')->name('updateUnit');

                                //Export công khai tỷ lệ sinh viên/giảng viên quy đổi 
                                Route::get('export-ckdtdsv', 'CongkhaidtdsvController@exportCkdtdsv')->name('exportCkdtdsv');

                            }
                        );

                        // Import công khai thông tin đào tạo theo đơn đặt hàng của nhà nước, địa phương và doanh nghiệp  
                        Route::group(
                            ['prefix' => 'thong-tin-dao-tao', 'as' => 'ckttdt.', 'namespace' => 'Congkhaittdt'],
                            function(){
                                Route::get('index','CongkhaittdtController@index')->name('index');
                                Route::post('import-unit', 'CongkhaittdtController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaittdtController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaittdtController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaittdtController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaittdtController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin đào tạo theo đơn đặt hàng của nhà nước, địa phương và doanh nghiệp
                                Route::get('export-ckttdt', 'CongkhaittdtController@exportCkttdt')->name('exportCkttdt');

                            }
                        );

                        // Import công khai thông tin về diện tích đất, tổng diện tích sàn xây dựng
                        Route::group(
                            ['prefix' => 'thong-tin-dien-tich-dat', 'as' => 'ckttdtd.', 'namespace' => 'Congkhaittdtd'],
                            function(){
                                Route::get('index','CongkhaittdtdController@index')->name('index');
                                Route::post('import-unit', 'CongkhaittdtdController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaittdtdController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaittdtdController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaittdtdController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaittdtdController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về diện tích đất, tổng diện tích sàn xây dựng
                                Route::get('export-ckttdtd', 'CongkhaittdtdController@exportCkttdtd')->name('exportCkttdtd');

                            }
                        );

                        // Import công khai thông tin về học liệu (sách, tạp chí, e-book, cơ sở dữ liệu điện tử) của thư viện và trung tâm học liệu 
                        Route::group(
                            ['prefix' => 'cong-khai-tt-ve-hoc-lieu', 'as' => 'ckttvhl.', 'namespace' => 'Congkhaittvhl'],
                            function(){
                                Route::get('index','CongkhaittvhlController@index')->name('index');
                                Route::post('import-unit', 'CongkhaittvhlController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaittvhlController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaittvhlController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaittvhlController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaittvhlController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về học liệu (sách, tạp chí, e-book, cơ sở dữ liệu điện tử) của thư viện và trung tâm học liệu 
                                Route::get('export-cksvgv', 'CongkhaittvhlController@exportCksvgv')->name('exportCksvgv');

                            }
                        );

                        // Import công khai thông tin về các hoạt động nghiên cứu khoa học, chuyển giao công nghệ, sản xuất thử và tư vấn  
                        Route::group(
                            ['prefix' => 'cong-khai-nghien-cuu-khoa-hoc', 'as' => 'cknckh.', 'namespace' => 'Congkhainckh'],
                            function(){
                                Route::get('index','CongkhainckhController@index')->name('index');
                                Route::post('import-unit', 'CongkhainckhController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhainckhController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhainckhController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhainckhController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhainckhController@updateUnit')->name('updateUnit');

                                //Export công khai thông tin về các hoạt động nghiên cứu khoa học, chuyển giao công nghệ, sản xuất thử và tư vấn  
                                Route::get('export-cknckh', 'CongkhainckhController@exportCknckh')->name('exportCknckh');

                            }
                        );


                        // Import công khai cam kết chất lượng đào tạo của Trường Đại học Công nghiệp Dệt May Hà Nội năm học 
                        Route::group(
                            ['prefix' => 'cong-khai-cam-ket-chat-luong', 'as' => 'ckcldt.', 'namespace' => 'Congkhaickcl'],
                            function(){
                                Route::get('index','CongkhaickclController@index')->name('index');
                                Route::post('update-ckcldt', 'CongkhaickclController@updateCkcldt')->name('updateCkcldt');
                                Route::get('get-ckcldt', 'CongkhaickclController@getCkcldt')->name('getCkcldt');

                                //Export công khai cam kết chất lượng đào tạo của Trường Đại học Công nghiệp Dệt May Hà Nội năm học
                                Route::get('export-ckcldt', 'CongkhaickclController@exportCkcldt')->name('exportCkcldt');
                            }
                        );

                        // Import công khai tài chính năm học
                        Route::group(
                            ['prefix' => 'tai-chinh-nam-hoc', 'as' => 'cktcnh.', 'namespace' => 'Congkhaitcnh'],
                            function(){
                                Route::get('index','CongkhaitcnhController@index')->name('index');
                                Route::post('updatedata','CongkhaitcnhController@updatedata')->name('updatedata');
                                Route::post('loaddata','CongkhaitcnhController@loaddata')->name('loaddata');
                            }
                        );
                        
                        // Import công khai thông tin danh sách chi tiết đội ngũ giảng viên theo khối ngành
                        Route::group(
                            ['prefix' => 'cong-khai-doi-ngu-gv', 'as' => 'ckdngv.', 'namespace' => 'Congkhaidngv'],
                            function(){
                                Route::get('index','CongkhaidngvController@index')->name('index');
                                Route::post('import-unit', 'CongkhaidngvController@importUnit')->name('importUnit');
                                Route::post('import-data-unit', 'CongkhaidngvController@importDataUnit')->name('importDataUnit');
                                Route::get('data-unit', 'CongkhaidngvController@dataUnit')->name('dataUnit');
                                Route::get('delete-unit', 'CongkhaidngvController@deleteUnit')->name('deleteUnit');
                                Route::post('update-unit', 'CongkhaidngvController@updateUnit')->name('updateUnit');
                                
                                //Export công khai thông tin danh sách chi tiết đội ngũ giảng viên theo khối ngành
                                Route::get('export-cknckh', 'CongkhaidngvController@exportCkdtdsv')->name('exportCkdtdsv');

                            }
                        );

                        // Import Công khai thông tin về đội ngũ giảng viên cơ hữu
                        Route::group(
                            ['prefix' => 'cong-khai-dn-gv-co-huu', 'as' => 'ckdngvch.', 'namespace' => 'Congkhaidngvch'],
                            function(){
                                Route::get('index','CongkhaidngvchController@index')->name('index');
                                Route::post('create-unit','CongkhaidngvchController@createUnit')->name('createUnit');
                                Route::get('delete-unit', 'CongkhaidngvchController@deleteUnit')->name('deleteUnit');
                                Route::get('get-info-unit', 'CongkhaidngvchController@getInfoUnit')->name('getInfoUnit');
                                
                                Route::post('update-unit', 'CongkhaidngvchController@updateUnit')->name('updateUnit');

                            }
                        );

                    }
                );
            }
        );

        



        

        Route::get(
            'crop_demo',
            function () {
                return redirect('admin/imagecropping');
            }
        );


        /* laravel example routes */
        // Charts
        Route::get('laravel_charts', 'ChartsController@index')->name('laravel_charts');
        Route::get('database_charts', 'ChartsController@databaseCharts')->name('database_charts');

        // datatables
        Route::get('datatables', 'DataTablesController@index')->name('index');
        Route::get('datatables/data', 'DataTablesController@data')->name('datatables.data');

        // datatables
        Route::get('jtable/index', 'JtableController@index')->name('index');
        Route::post('jtable/store', 'JtableController@store')->name('store');
        Route::post('jtable/update', 'JtableController@update')->name('update');
        Route::post('jtable/delete', 'JtableController@destroy')->name('delete');



        // SelectFilter
        Route::get('selectfilter', 'SelectFilterController@index')->name('selectfilter');
        Route::get('selectfilter/find', 'SelectFilterController@filter')->name('selectfilter.find');
        Route::post('selectfilter/store', 'SelectFilterController@store')->name('selectfilter.store');

        // editable datatables
        Route::get('editable_datatables', 'EditableDataTablesController@index')->name('index');
        Route::get('editable_datatables/data', 'EditableDataTablesController@data')->name('editable_datatables.data');
        Route::post('editable_datatables/create', 'EditableDataTablesController@store')->name('store');
        Route::post('editable_datatables/{id}/update', 'EditableDataTablesController@update')->name('update');
        Route::get('editable_datatables/{id}/delete', 'EditableDataTablesController@destroy')->name('editable_datatables.delete');

        //    # custom datatables
        Route::get('custom_datatables', 'CustomDataTablesController@index')->name('index');
        Route::get('custom_datatables/sliderData', 'CustomDataTablesController@sliderData')->name('custom_datatables.sliderData');
        Route::get('custom_datatables/radioData', 'CustomDataTablesController@radioData')->name('custom_datatables.radioData');
        Route::get('custom_datatables/selectData', 'CustomDataTablesController@selectData')->name('custom_datatables.selectData');
        Route::get('custom_datatables/buttonData', 'CustomDataTablesController@buttonData')->name('custom_datatables.buttonData');
        Route::get('custom_datatables/totalData', 'CustomDataTablesController@totalData')->name('custom_datatables.totalData');

        //tasks section
        Route::post('task/create', 'TaskController@store')->name('store');
        Route::get('task/data', 'TaskController@data')->name('data');
        Route::post('task/{task}/edit', 'TaskController@update')->name('update');
        Route::post('task/{task}/delete', 'TaskController@delete')->name('delete');
    }
);



// Remaining pages will be called from below controller method
// in real world scenario, you may be required to define all routes manually

Route::group(
    ['prefix' => 'admin', 'middleware' => 'admin'],
    function () {
        Route::get('{name?}', 'JoshController@showView');
    }
);


Route::get('login', 'FrontEndController@getLogin')->name('login');
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::get('register', 'FrontEndController@getRegister')->name('register');
Route::post('register', 'FrontEndController@postRegister')->name('register');
Route::get('activate/{userId}/{activationCode}', 'FrontEndController@getActivate')->name('activate');
Route::get('forgot-password', 'FrontEndController@getForgotPassword')->name('forgot-password');
Route::post('forgot-password', 'FrontEndController@postForgotPassword');

// Social Logins
Route::get('facebook', 'Admin\FacebookAuthController@redirectToProvider');
Route::get('facebook/callback', 'Admin\FacebookAuthController@handleProviderCallback');

Route::get('linkedin', 'Admin\LinkedinAuthController@redirectToProvider');
Route::get('linkedin/callback', 'Admin\LinkedinAuthController@handleProviderCallback');

Route::get('google', 'Admin\GoogleAuthController@redirectToProvider');
Route::get('google/callback', 'Admin\GoogleAuthController@handleProviderCallback');


// Forgot Password Confirmation
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
Route::get('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@getForgotPasswordConfirm')->name('forgot-password-confirm');
// My account display and update details
Route::group(
    ['middleware' => 'user'],
    function () {
        Route::put('my-account', 'FrontEndController@update');
        Route::get('my-account', 'FrontEndController@myAccount')->name('my-account');
    }
);
// Email System
Route::group(
    ['prefix' => 'user_emails'],
    function () {
        Route::get('compose', 'UsersEmailController@create');
        Route::post('compose', 'UsersEmailController@store');
        Route::get('inbox', 'UsersEmailController@inbox');
        Route::get('sent', 'UsersEmailController@sent');
        Route::get('{email}', ['as' => 'user_emails.show', 'uses' => 'UsersEmailController@show']);
        Route::get('{email}/reply', ['as' => 'user_emails.reply', 'uses' => 'UsersEmailController@reply']);
        Route::get('{email}/forward', ['as' => 'user_emails.forward', 'uses' => 'UsersEmailController@forward']);
    }
);
Route::resource('user_emails', 'UsersEmailController');
Route::get('logout', 'FrontEndController@getLogout')->name('logout');
// contact form
Route::post('contact', 'FrontEndController@postContact')->name('contact');

// frontend views
Route::get(
    '/',
    ['as' => 'home', function () {
        //return view('index');
        return redirect('admin');
    }]
);

Route::get('checkduplicate', 'Admin\DuplicateController@checkduplicate')->name('checkduplicate');

Route::get('blog', 'BlogController@index')->name('blog');
Route::get('blog/{slug}/tag', 'BlogController@getBlogTag');
Route::get('blogitem/{slug?}', 'BlogController@getBlog');
Route::post('blogitem/{blog}/comment', 'BlogController@storeComment');

//news
Route::get('news', 'NewsController@index')->name('news');
Route::get('news/{news}', 'NewsController@show')->name('news.show');

Route::get('{name?}', 'FrontEndController@showFrontEndView');
// End of frontend views
