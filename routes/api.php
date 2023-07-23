<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use PHPHtmlParser\Dom;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test_html',function (Request $req){    
    $kehoachbao = DB::table('kehoach_baocao')
                            ->first();
    $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
                            ->where('id_kh_baocao',$kehoachbao->id)
                            ->get();
    $toEncode["str"] = array();
    foreach($keHoachTieuChuanList as $keHoachTieuChuan){
        $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
                                                    ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                                    ->get();
        foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
            $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
                                                    ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                    ->get();

            foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                    ->where('id_kehoach_bc',$kehoachbao->id)
                                                    ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                    ->where('id_menhde',$keHoachMenhDe->id_menhde)
                                                    ->first();


                $dom = new Dom;
                $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);
                $contents = $dom->find('.danMinhChung');  
                $arr = array();
                foreach ($contents as $key => $value) {
                    $html = $value->innerHtml;
                    array_push($arr,[$value->getAttribute('id'), $html]);
                }
                array_push($toEncode["str"],$arr);
            }
        }
    }

    $toEncode["result"] = "ok";
    return response($toEncode,200); 
    
});



Route::get('product-api',function (Request $req){    
    $obj = [];
    $arr1 = [
        'id' => 1,
        'title' => 'Xiaomi Redmi Note 12 8GB 128GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/_/7/_76666_7__3-3.jpg',
        'price' => 5390000,
        'hot'   => true
    ];
    $arr2 = [
        'id' => 2,
        'title' => 'iPhone 14 Pro Max 128GB | Chính hãng VN/A',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/t/_/t_m_18.png',
        'price' => 26390000,
        'hot'   => true
    ];
    $arr3 = [
        'id' => 3,
        'title' => 'Samsung Galaxy A34 5G 8GB 128GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/s/a/samsung-galaxy-a34_3_.jpg',
        'price' => 7490000,
        'hot'   => false
    ];
    $arr4 = [
        'id' => 4,
        'title' => 'iPhone 14 Pro Max 256GB | Chính hãng VN/A',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/v/_/v_ng_20.png',
        'price' => 29500000,
        'hot'   => false
    ];
    $arr5 = [
        'id' => 5,
        'title' => 'Samsung Galaxy S22 Ultra (12GB - 256GB)',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/s/m/sm-s908_galaxys22ultra_front_phantomblack_211119_2.jpg',
        'price' => 19590000,
        'hot'   => true
    ];
    $arr6 = [
        'id' => 6,
        'title' => 'iPhone 11 128GB | Chính hãng VN/A',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/4/_/4_187_1.jpg',
        'price' => 12100000,
        'hot'   => false
    ];
    $arr7 = [
        'id' => 7,
        'title' => 'Samsung Galaxy Z Flip4 128GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/s/a/samsung_galaxy_z_flip_m_i_2022-1_1.jpg',
        'price' => 15900000,
        'hot'   => true
    ];
    $arr8 = [
        'id' => 8,
        'title' => 'Xiaomi Redmi Note 12 Pro 4G 8GB 256GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/r/e/redmi-note-12-pro-4g-1-den.jpg',
        'price' => 7400000,
        'hot'   => true
    ];
    $arr9 = [
        'id' => 9,
        'title' => 'Xiaomi Redmi Note 12 8GB 128GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/_/7/_76666_7__3-3.jpg',
        'price' => 5390000,
        'hot'   => true
    ];
    $arr10 = [
        'id' => 10,
        'title' => 'iPhone 11 64GB | Chính hãng VN/A',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/3/_/3_225.jpg',
        'price' => 10590000,
        'hot'   => true
    ];
    $arr11 = [
        'id' => 11,
        'title' => 'Realme 9 Pro Plus',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/9/_/9_ro_plus.png',
        'price' => 5490000,
        'hot'   => false
    ];
    $arr12 = [
        'id' => 12,
        'title' => 'Itel S23 8GB 128GB',
        'photo'  => 'https://cdn2.cellphones.com.vn/358x358,webp,q100/media/catalog/product/i/t/itel-s23-2.jpg',
        'price' => 2690000,
        'hot'   => false
    ];

    array_push($obj, $arr1 , $arr2, $arr3, $arr4, $arr5, $arr6, $arr7, $arr8, $arr9, $arr10, $arr11, $arr12);

    $result = [
        'log'   => 'true',
        'data'  => $obj
    ];
    $result = (object) $result;
    return json_encode($result);
    
});

