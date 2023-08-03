<?php namespace App\Http\Controllers\Admin\Project\Danhgiangoai\ExternalReview;
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
use PHPHtmlParser\Dom;
class ExternalReviewController extends DefinedController{

		public function baseIndex($id = null){
			$keHoachBaoCaoDetail2 = null;

			$keHoachBaoCaoList2 = DB::table('kehoach_baocao')->get();


    		if($id){

    			$keHoachBaoCaoDetail2 = DB::table('kehoach_baocao')
    							->select('kehoach_baocao.*','bo_tieuchuan.loai_tieuchuan as loai_tieuchuan_bc')
    							->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
    							->where('kehoach_baocao.id',$id)->first();

    			if ($keHoachBaoCaoDetail2) {
    				$danhGiaMenhDe = [];
		        	$keHoachBaoCaoDetail2->keHoachTieuChuanList = $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')->where('id_kh_baocao',$keHoachBaoCaoDetail2->id)->get();
		        	$keHoachBaoCaoDetail2->phutrach = DB::table('users')
		        										->select('excel_import_donvi.*','excel_import_donvi.ma_donvi as id_donvi')
		        										->leftjoin('excel_import_donvi','excel_import_donvi.id','=','users.donvi_id')
		        										->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();

		        	$keHoachBaoCaoDetail2->phutrachr = DB::table('users')
		        										->select('donvi.*','donvi.ma_donvi as id_donvi')
		        										->leftjoin('donvi','donvi.id','=','users.donvi_id')
		        										->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();


		        	$keHoachBaoCaoDetail2->ctdt = DB::table('ctdt')
		        										->where('id',$keHoachBaoCaoDetail2->ctdt_id)->first();
		        	$keHoachBaoCaoDetail2->keHoachChung = DB::table('kehoach_chung')
		        											->where('kh_baocao_id',$keHoachBaoCaoDetail2->id)
		        											->first();
		        	if($keHoachBaoCaoDetail2->keHoachChung){
		        		$keHoachBaoCaoDetail2->keHoachChung->baoCaoChung = DB::table('baocao_chung')
					        											->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
					        											->where('id_kh_chung',$keHoachBaoCaoDetail2->keHoachChung->id)
					        											->first();
		        	}


		        	foreach($keHoachTieuChuanList as $keHoachTieuChuan){
		        		$tieuChuan = DB::table('tieuchuan')->where('id',$keHoachTieuChuan->tieuchuan_id)->first();
		        		$keHoachTieuChuan->tieuChuan = $tieuChuan;
		        		$keHoachTieuChuan->baoCaoTieuChuan = DB::table('baocao_tieuchuan')
		        												->where('id_kehoach_bc',$id)
		        												->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
		        												->where('id_tieuchuan',$keHoachTieuChuan->tieuchuan_id)
		        												->first();

		        		if($tieuChuan){
		        			$keHoachTieuChuan->moTaWithStt = "TC $tieuChuan->stt: $tieuChuan->mo_ta";
			            	$keHoachTieuChuan->keHoachTieuChiList =	$keHoachTieuChiList = DB::table('kehoach_tieuchi')->where('id_kh_tieuchuan',$keHoachTieuChuan->id)->get();
			            	foreach($keHoachTieuChiList as $keHoachTieuChi){
			            		$tieuChi = DB::table('tieuchi')->where('id',$keHoachTieuChi->id_tieuchi)->first();

			            		if($keHoachBaoCaoDetail2->writeFollow == 1){

			            			$keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('menhde')
											            					->where('tieuchi_id',$tieuChi->id)
											            					->get();

				            		$keHoachTieuChi->tieuChi = $tieuChi;

				            		foreach($menhde as $value){

				            			$value->khmenhde = DB::table('kehoach_menhde')
            												->where('id_kh_tieuchi',$keHoachTieuChi->id)
            												->where('id_menhde',$value->id)
            												->first();

				            			$baoCaoMenhDe = DB::table('baocao_menhde')
				            								->where('id_kehoach_bc',$id)
				            								->where('id_kh_menhde',$value->khmenhde->id)
				            								->where('id_menhde',$value->khmenhde->id_menhde)
				            								->first();

				            			$value->baoCaoMenhDe = $baoCaoMenhDe;

				            			$baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
				            													->where('menhde_id',$value->khmenhde->id_menhde)
				            													->where('kehoach_bc_id',$id)
				            													->whereNull('deleted_at')
				            													->get();

				            			foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
				            				$val->donViThucHien = DB::table('donvi')
				            										->where('id',$val->ns_thuchien)
				            										->first();
					            			$val->donViKiemTra = DB::table('donvi')
					            									->where('id',$val->ns_kiemtra)
					            									->first();
				            			}



				            			$danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
				            		}



				                	$baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
				                	$danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
				                	$keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
			            		}elseif($keHoachBaoCaoDetail2->writeFollow == 2){

			            			$keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('mocchuan')
											            					->where('tieuchi_id',$tieuChi->id)
											            					->get();
				            		$keHoachTieuChi->tieuChi = $tieuChi;
				            		foreach($menhde as $value){

				            			$value->khmenhde = DB::table('kehoach_menhde')
            												->where('id_kh_tieuchi',$keHoachTieuChi->id)
            												->where('mocchuan_id',$value->id)
            												->first();

				            			$baoCaoMenhDe = DB::table('baocao_menhde')
				            								->where('id_kehoach_bc',$id)
				            								->where('id_kh_menhde',$value->khmenhde->id)
				            								->where('mocchuan_id',$value->khmenhde->mocchuan_id)
				            								->first();

				            			$value->baoCaoMenhDe = $baoCaoMenhDe;

				            			$baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
				            													->where('mocchuan_id',$value->khmenhde->mocchuan_id)
				            													->where('kehoach_bc_id',$id)
				            													->whereNull('deleted_at')
				            													->get();


				            			foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
				            				$val->donViThucHien = DB::table('donvi')
				            										->where('id',$val->ns_thuchien)
				            										->first();
					            			$val->donViKiemTra = DB::table('donvi')
					            									->where('id',$val->ns_kiemtra)
					            									->first();
				            			}



				            			$danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
				            		}



				                	$baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
				                	$danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
				                	$keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
			            		}


			            		if($tieuChi){
			            			$keHoachTieuChi->moTaWithStt = "$tieuChuan->stt.$tieuChi->stt: $tieuChi->mo_ta";
			            		}

			            	}
		        		}


		        	}
		        }
    		}

	        return array($keHoachBaoCaoList2,$keHoachBaoCaoDetail2);
		}





		public function listDatakeHoachBaoCaoDetail($id){
			$check_mccb = DB::table('kehoach_baocao')
					->where('id',$id)
					->first();
			if(isset($check_mccb->writeFollow)){
				if($check_mccb->writeFollow == 1){
					$keHoachBaoCaoDetail = DB::table('kehoach_baocao')
											->select('kehoach_baocao.id as khbc_id','kehoach_baocao.ten_bc','kehoach_tieuchuan.*')
											->leftjoin('kehoach_tieuchuan','kehoach_tieuchuan.id_kh_baocao','=','kehoach_baocao.id')
											->where('kehoach_baocao.id',$id)->get();

					foreach($keHoachBaoCaoDetail as $keHoachTieuChuan){
						$keHoachTieuChuan->keHoachTieuChuans = $keHoachTieuChuans = DB::table('baocao_tieuchuan')
														->leftjoin('tieuchuan','tieuchuan.id','baocao_tieuchuan.id_tieuchuan')
														->where('baocao_tieuchuan.id_kh_tieuchuan',$keHoachTieuChuan->id)
														->where('baocao_tieuchuan.id_kehoach_bc',$keHoachTieuChuan->khbc_id)
														->where('tieuchuan.id',$keHoachTieuChuan->tieuchuan_id)
														->first();
						if (!$keHoachTieuChuans) {
		                	continue;
		            	}

						$keHoachTieuChuan->danhgia = 'Chưa hoàn thành';
						//Loại bỏ các kế hoạch mệnh đề chưa xác nhận, và lấy dữ liệu kế hoạch hành động
			            $danhGiaTieuChi = [];
			            $minhChungid = [];

			            $checkMC = collect([]); //tạo 1 collect riêng chỉ chứa minhChungCode


			            $keHoachTieuChuan->keHoachTieuChiList = $keHoachTieuChiList = DB::table('kehoach_tieuchi')
							            						->where('kehoach_tieuchi.id_kh_tieuchuan',$keHoachTieuChuan->id)
							            						->get();

			            foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
			            	$danhGiaMenhDe = [];
		                	$minhChungStt = 1;
		                	$tieuChi = DB::table('tieuchi')
		                				->where('id',$keHoachTieuChi->id_tieuchi)
		                				->first();
		                	$keHoachTieuChi->tieuChi = $tieuChi;
		                	$keHoachTieuChi->keHoachMenhDeList = $keHoachMenhDeList = DB::table('kehoach_menhde')
		                												->where('id_kh_tieuchi',$keHoachTieuChi->id)->get();
		                	foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
		                		$keHoachMenhDe->baocao_menhde = DB::table('baocao_menhde')
						                							->where('baocao_menhde.id_kh_menhde',$keHoachMenhDe->id)
						                							->where('baocao_menhde.id_kehoach_bc',$id)
						                							->where('baocao_menhde.id_menhde',$keHoachMenhDe->id_menhde)
						                							->first();
						        $keHoachMenhDe->baocao_menhde->keHoachHanhDongList = DB::table('kehoach_hd')
						        														->where('kehoach_bc_id',$id)
						        														->where('menhde_id',$keHoachMenhDe->baocao_menhde->id_menhde)
						        														->get();
						        foreach($keHoachMenhDe->baocao_menhde->keHoachHanhDongList as $valuekhd){
						        	$donViThucHien = DB::table('donvi')
						        						->where('id',$valuekhd->ns_thuchien)
						        						->first();
						        	$valuekhd->donViThucHien = $donViThucHien;

						        	$donViKiemTra = DB::table('donvi')
						        						->where('id',$valuekhd->ns_kiemtra)
						        						->first();
						        	$valuekhd->donViKiemTra = $donViKiemTra;
						        }
		                		// if (!$keHoachMenhDe->baoCaoMenhDe) {
			                    //     continue;
			                    // }

			                    $danhGiaMenhDe[] = $keHoachMenhDe->baocao_menhde->danhgia;
			                    // $keHoachMenhDe->baoCaoMenhDe->keHoachHanhDongList = KeHoachHanhDong::where([
			                    //     ['id_kehoach_bc', '=', $id],
			                    //     ['id_menhde', '=', $keHoachMenhDe->menhDe->id]
			                    // ])->orderBy('kieu_kehoach', 'ASC')->get();
		                	}

		                	$baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
		                	$danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
		                	$keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
			            }
						$keHoachTieuChuan->danhgia = round(collect($danhGiaTieuChi)->avg(), 1);
					}
					return array($keHoachBaoCaoDetail);
				}else if($check_mccb->writeFollow == 2){
					$keHoachBaoCaoDetail = DB::table('kehoach_baocao')
											->select('kehoach_baocao.id as khbc_id','kehoach_baocao.ten_bc','kehoach_tieuchuan.*')
											->leftjoin('kehoach_tieuchuan','kehoach_tieuchuan.id_kh_baocao','=','kehoach_baocao.id')
											->where('kehoach_baocao.id',$id)->get();

					foreach($keHoachBaoCaoDetail as $keHoachTieuChuan){
						$keHoachTieuChuan->keHoachTieuChuans = $keHoachTieuChuans = DB::table('baocao_tieuchuan')
														->leftjoin('tieuchuan','tieuchuan.id','baocao_tieuchuan.id_tieuchuan')
														->where('baocao_tieuchuan.id_kh_tieuchuan',$keHoachTieuChuan->id)
														->where('baocao_tieuchuan.id_kehoach_bc',$keHoachTieuChuan->khbc_id)
														->where('tieuchuan.id',$keHoachTieuChuan->tieuchuan_id)
														->first();
						if (!$keHoachTieuChuans) {
		                	continue;
		            	}

						$keHoachTieuChuan->danhgia = 'Chưa hoàn thành';
						//Loại bỏ các kế hoạch mệnh đề chưa xác nhận, và lấy dữ liệu kế hoạch hành động
			            $danhGiaTieuChi = [];
			            $minhChungid = [];

			            $checkMC = collect([]); //tạo 1 collect riêng chỉ chứa minhChungCode


			            $keHoachTieuChuan->keHoachTieuChiList = $keHoachTieuChiList = DB::table('kehoach_tieuchi')
							            						->where('kehoach_tieuchi.id_kh_tieuchuan',$keHoachTieuChuan->id)
							            						->get();

			            foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
			            	$danhGiaMenhDe = [];
		                	$minhChungStt = 1;
		                	$tieuChi = DB::table('tieuchi')
		                				->where('id',$keHoachTieuChi->id_tieuchi)
		                				->first();
		                	$keHoachTieuChi->tieuChi = $tieuChi;
		                	$keHoachTieuChi->keHoachMenhDeList = $keHoachMenhDeList = DB::table('kehoach_menhde')
		                												->where('id_kh_tieuchi',$keHoachTieuChi->id)->get();
		                	foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
		                		$keHoachMenhDe->baocao_menhde = DB::table('baocao_menhde')
						                							->where('baocao_menhde.id_kh_menhde',$keHoachMenhDe->id)
						                							->where('baocao_menhde.id_kehoach_bc',$id)
						                							->where('baocao_menhde.mocchuan_id',$keHoachMenhDe->mocchuan_id)
						                							->first();
						        $keHoachMenhDe->baocao_menhde->keHoachHanhDongList = DB::table('kehoach_hd')
						        														->where('kehoach_bc_id',$id)
						        														->where('menhde_id',$keHoachMenhDe->baocao_menhde->mocchuan_id)
						        														->get();
						        foreach($keHoachMenhDe->baocao_menhde->keHoachHanhDongList as $valuekhd){
						        	$donViThucHien = DB::table('donvi')
						        						->where('id',$valuekhd->ns_thuchien)
						        						->first();
						        	$valuekhd->donViThucHien = $donViThucHien;

						        	$donViKiemTra = DB::table('donvi')
						        						->where('id',$valuekhd->ns_kiemtra)
						        						->first();
						        	$valuekhd->donViKiemTra = $donViKiemTra;
						        }
		                		// if (!$keHoachMenhDe->baoCaoMenhDe) {
			                    //     continue;
			                    // }

			                    $danhGiaMenhDe[] = $keHoachMenhDe->baocao_menhde->danhgia;
			                    // $keHoachMenhDe->baoCaoMenhDe->keHoachHanhDongList = KeHoachHanhDong::where([
			                    //     ['id_kehoach_bc', '=', $id],
			                    //     ['id_menhde', '=', $keHoachMenhDe->menhDe->id]
			                    // ])->orderBy('kieu_kehoach', 'ASC')->get();
		                	}

		                	$baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
		                	$danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
		                	$keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
			            }
						$keHoachTieuChuan->danhgia = round(collect($danhGiaTieuChi)->avg(), 1);
					}
					return array($keHoachBaoCaoDetail);
				}
			}



		}

		public function index(Request $req,$id =null){
			$keHoachBaoCaoList = DB::table('kehoach_baocao')
									->select('kehoach_baocao.id as id_khbc','kehoach_baocao.*','users.*')
									->leftjoin('users','users.id','=','kehoach_baocao.ns_phutrach')->get();

			foreach($keHoachBaoCaoList as $value){
				$ten_dv = DB::table('donvi')->where('id',$value->donvi_id)->first();

				$value->ten_donvi = $ten_dv;

			}

			$page = $req->page;
			$kh = null;
			$keHoachChungs = null;
			$KHBaCaoDetails = null;
			$nhanXetKhoiLists = null;
			$title = null;
			$khtc = null;
			$key = null;
			$tag = null;
			$ThongKeTruongDonViList = null;
			$TruongPhoDonViPhuTrach = null;
			$noiDungThem = null;
			$Trinhdo = null;
			$tongSoNganhDaoTao = null;
			$Gvcohuunam = null;
			$Gvcohuunu = null;
			$Gvkhacmen = null;
			$Gvkhacwn = null;
			$list_tdcm = null;
			$thongKeTuyenSinh = null;
			$thongKeTuyenSinh = null;
			$arrayngoaingu = null;
			$tuoitb = null;
			$Bang13_CSGD = null;
			$minhChungList = null;
			$dulieu = '';
          	$list = "";
          	$sua = "xem";


			list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex($id);


			list($keHoachBaoCaoDetail) = $this->listDatakeHoachBaoCaoDetail($id);

			list($keHoachBaoCaokehoachchung,$keHoachTieuChuan) = $this->scollSearch($id);

			if($page == 'chung'){
				$title = 'Khái quát';
				$kh = $req->idkh;
				$key = $req->key;
				$tag = $req->tag;
				list($KHBaCaoDetail,$keHoachChung,$nhanXetKhoiList) = $this->getKhaiquat($id,$req->idkh);
				$keHoachChungs = $keHoachChung;
				$KHBaCaoDetails = $KHBaCaoDetail;
				$nhanXetKhoiLists = $nhanXetKhoiList;
			}elseif($page == 'baocao'){
				$title = 'Báo cáo TĐG';
				$id_khc = DB::table('kehoach_chung')
	        				->where('kehoach_chung.kh_baocao_id',$id)
	        				->first();
	        	if($id_khc){
	        		list($KHBaCaoDetail,$keHoachChung,$nhanXetKhoiList) = $this->getKhaiquat($id,$id_khc->id);
					$keHoachChungs = $keHoachChung;
					$KHBaCaoDetails = $KHBaCaoDetail;
					$nhanXetKhoiLists = $nhanXetKhoiList;
	        	}


			}elseif($page == 'tieuchuan'){
				list($mcCollect) = $this->listMinhChung($keHoachBaoCaoDetail2);
	            $minhChungList = $mcCollect;
				$khtc = $req->idkhtc;
				$kh = $req->idkh;
			}elseif($page == 'ketluan'){
				$title = 'Phần III: Kết luận';
				$key = $req->key;
			}elseif($page == 'phuluc'){
				$tag = $req->tag;
				$title = 'Phần VI: Phụ lục';

				if($req->tag == 'pl4'){
	                list($mcCollect) = $this->listMinhChung($keHoachBaoCaoDetail2);
	                $minhChungList = $mcCollect;
	            }else{
	            	if($req->tag != 'pl3'){
	            		if($keHoachBaoCaoDetail2->loai_tieuchuan_bc == 'csgd'){
	            		  $data = DB::table('coso_dulieu')
			                    ->where('id_khbc',$req->id)
			                    ->first();
			          	  $dulieu = json_decode($data->dulieu);
				          list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex2($id);
				          list($noiDungThem) = $this->getDataPhuLucCSDT($keHoachBaoCaoDetail2);

				          $list = $this->showFileData($id);
	            		}else{

				            $data = DB::table('coso_dulieu')
				                    ->where('id_khbc',$req->id)
				                    ->first();
				          	$dulieu = json_decode($data->dulieu);
				            list($keHoachBaoCaoList2,$keHoachBaoCaoDetail2) = $this->baseIndex2($id);
				            list($noiDungThem) = $this->getDataPhuLuc($keHoachBaoCaoDetail2);
				            $list = $this->showFileData($id);
	            			// list($ThongKeTruongDonViList,$TruongPhoDonViPhuTrach,$noiDungThem,$Trinhdo,$tongSoNganhDaoTao,$Gvcohuunam,$Gvcohuunu,$Gvkhacmen,$Gvkhacwn,$list_tdcm,$arrayngoaingu,$thongKeTuyenSinh,$tuoitb) = $this->getDataPhuLuc($keHoachBaoCaoDetail2);
	            		}
	            	}
	            }

			}

			return view('admin.project.ExternalReview.index')
						->with([
								'keHoachBaoCaoList' => $keHoachBaoCaoList,
								'page' => $page,
								'id' => $id,
								'idkhbc' => $id,
								'keHoachBaoCaoListDetail' => $keHoachBaoCaoDetail,
								'keHoachBaoCaoList2' => $keHoachBaoCaoList2,
								'keHoachBaoCaoDetail2' => $keHoachBaoCaoDetail2,
								'keHoachChung' => $keHoachChungs,
								'KHBaCaoDetail' => $KHBaCaoDetails,
								'nhanXetKhoiList' => $nhanXetKhoiLists,
								'title' => $title,
								'keHoachBaoCaokehoachchung' => $keHoachBaoCaokehoachchung,
								'keHoachTieuChuan' => $keHoachTieuChuan,
								'kh' => $kh,
								'khtc' => $khtc,
								'key' => $key,
								'tag' => $tag,
								'ThongKeTruongDonViList' => $ThongKeTruongDonViList,
								'TruongPhoDonViPhuTrach' => $TruongPhoDonViPhuTrach,
								'noiDungThem' => $noiDungThem,
								'Trinhdo' => $Trinhdo,
								'tongSoNganhDaoTao' => $tongSoNganhDaoTao,
								'Gvcohuunam' => $Gvcohuunam,
								'Gvcohuunu' => $Gvcohuunu,
								'Gvkhacmen' => $Gvkhacmen,
								'Gvkhacwn' => $Gvkhacwn,
								'list_tdcm' => $list_tdcm,
								'arrayngoaingu' => $arrayngoaingu,
								'thongKeTuyenSinh' => $thongKeTuyenSinh,
								'tuoitb' => $tuoitb,
								'noiDungThem' => $noiDungThem,
								'Bang13_CSGD' => $Bang13_CSGD,
								'minhChungList' => $minhChungList,
								"dulieu"  => $dulieu,
                                'data'    => $list,
                                'check'   => $sua,

						]);
		}

		public function data(Request $req){
			$keHoachBaoCaoList = DB::table('kehoach_baocao')
									->select('kehoach_baocao.id as id_khbc','kehoach_baocao.*','users.*')
									->leftjoin('users','users.id','=','kehoach_baocao.ns_phutrach')
									->where('kehoach_baocao.deleted_at',null)
									->get();
			if(!Sentinel::inRole('operator') && !Sentinel::inRole('admin')){
				foreach($keHoachBaoCaoList as $key => $value){
					$find = DB::table("role_user_dgn")
							->where("user_id", Sentinel::getUser()->id)
							->where("baocao_tdg_id", $value->id_khbc);
					if($find->count() == 0){
						$keHoachBaoCaoList->forget($key);
					}
				}
			}

			return DataTables::of($keHoachBaoCaoList)
						->addColumn(
							'ten_donvi',
							function($keHoachBaoCaoList){
								$ten_dv = DB::table('donvi')->where('id',$keHoachBaoCaoList->donvi_id)->first();
								if($ten_dv){
									return $ten_dv->ten_donvi;
								}else{
									return '';
								}
							}
						)
						->addColumn(
							'ten_baocao',
							function($keHoachBaoCaoList){
								if($keHoachBaoCaoList->ten_bc){
									return $keHoachBaoCaoList->ten_bc;
								}else{
									return '';
								}
							}
						)
						->addColumn(
							'nam_vietbao',
							function($keHoachBaoCaoList){
								if($keHoachBaoCaoList->ngay_batdau){
									return date("Y", strtotime($keHoachBaoCaoList->ngay_batdau));
								}else{
									return '';
								}
							}
						)
						->addColumn(
							'thoidiem_bc',
							function($keHoachBaoCaoList){
								if($keHoachBaoCaoList->thoi_diem_bao_cao){
									return date("d/m/Y", strtotime($keHoachBaoCaoList->thoi_diem_bao_cao));
								}else{
									return '';
								}
							}
						)
						->addColumn('actions',function($keHoachBaoCaoList){
		                    $actions = '<a href="'.route('admin.danhgiangoai.baocaotudanhgia.index', $keHoachBaoCaoList->id_khbc) . '?page=baocao' .'" class="btn" data-bs-placement="top" title="'.Lang::get('project/ExternalReview/title.xct').'"> '.
							'<i class="bi bi-eye-fill" style="font-size: 25px;color: #50cd89;"></i>'
		                        .'</a>';
		                        return $actions;
		                })
					->rawColumns(['actions'])
					->make(true);
		}
		public function getKhaiquat($id,$id_khc){
			 $KHBaCaoDetail = DB::table('kehoach_baocao')
			 					->where('kehoach_baocao.id',$id)->first();

			//  if (!$KHBaCaoDetail) {
	        //     return abort(422, "Không nhận dạng được kế hoạch");
	        // }
	        $keHoachChung = DB::table('baocao_chung')
	        				->where('baocao_chung.id_kh_chung',$id_khc)
	        				->where('baocao_chung.id_kehoach_bc',$id)
	        				->first();

	        // if (!$keHoachChung) {
	        //     return abort(422, "Không nhận dạng được kế hoạch");
	        // }

	        $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')
	        						->where('id_kehoach_bc',$KHBaCaoDetail->id)
	        						->orderBy('created_at', 'asc')->get();
	       	return array($KHBaCaoDetail,$keHoachChung,$nhanXetKhoiList);
		}

		public function scollSearch($id){
			$KehoachBaocaoDetaliscoll = null;
			$keHoachTieuChuan = null;
			if($id){
				$KehoachBaocaoDetaliscoll = DB::table('kehoach_baocao')
											->select('kehoach_chung.*','bo_tieuchuan.loai_tieuchuan')
											->leftjoin('kehoach_chung','kehoach_chung.kh_baocao_id','=','kehoach_baocao.id')
											->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
											->where('kehoach_baocao.id',$id)->first();
			}

			if($id){
				$keHoachTieuChuan = DB::table('kehoach_baocao')
										->select('kehoach_tieuchuan.*')
										->leftjoin('kehoach_tieuchuan','kehoach_tieuchuan.id_kh_baocao','=','kehoach_baocao.id')
										->where('kehoach_baocao.id',$id)->get();
				foreach($keHoachTieuChuan as $value){
					$tieuchuan = DB::table('tieuchuan')
									->where('tieuchuan.id',$value->tieuchuan_id)
									->first();

					$tieuchi = DB::table('kehoach_tieuchi')
									->select('tieuchi.*','kehoach_tieuchi.id_tieuchi','kehoach_tieuchi.id as id_khtc')
									->leftjoin('tieuchi','tieuchi.id','=','kehoach_tieuchi.id_tieuchi')
									->where('kehoach_tieuchi.id_kh_tieuchuan',$value->id)->get();
					if(isset($tieuchuan)){
						$value->tieuchuan = $tieuchuan;
					}else{
						$value->tieuchuan = 1;
					}

					$value->tieuchi = $tieuchi;
					$danhGiaTieuChi = [];

					foreach($value->tieuchi as $val){
						$danhGiaMenhDe = [];
						$keHoachMenhDeList = DB::table('kehoach_menhde')
											->where('kehoach_menhde.id_kh_tieuchi',$val->id_khtc)
											->get();
						$val->keHoachMenhDeList = $keHoachMenhDeList;

						foreach($val->keHoachMenhDeList as $val_bcmd){
							$baoCaoMenhDe = DB::table('baocao_menhde')
												->select('baocao_menhde.*','menhde.id as id_md')
												->leftjoin('menhde','menhde.id','=','baocao_menhde.id_menhde')
												->where('baocao_menhde.id_kh_menhde',$val_bcmd->id)
												->where('baocao_menhde.id_kehoach_bc',$id)
												->first();
							if($baoCaoMenhDe){
								$keHoachHanhDongList = DB::table('kehoach_hd')
														->where('kehoach_bc_id',$id)
														->where('menhde_id',$baoCaoMenhDe->id_md)
														->get();

								$val_bcmd->baoCaoMenhDe = $baoCaoMenhDe;
								$val_bcmd->baoCaoMenhDe->keHoachHanhDongList = $keHoachHanhDongList;

								$danhGiaMenhDe = $baoCaoMenhDe->danhgia;
								// var_dump($keHoachHanhDongList);
								// die;
								foreach($val_bcmd->baoCaoMenhDe->keHoachHanhDongList as $val_dvth){
									$donViThucHien = DB::table('donvi')
														->where('id',$val_dvth->ns_thuchien)
														->first();
									$val_dvth->donViThucHien = $donViThucHien;

									$donViKiemTra = DB::table('donvi')
														->where('id',$val_dvth->ns_kiemtra)
														->first();
									$val_dvth->donViKiemTra = $donViKiemTra;



									// if($donViThucHien){
									// 	$val_dvth->donViThucHien->ten_donvi = $donViThucHien->ten_donvi;
									// }else{
									// 	$val_dvth->donViThucHien = new \stdClass();
									// 	$val_dvth->donViThucHien->ten_donvi = "";

									// }
									// echo($val_dvth->ns_thuchien);
									// $val_dvth->donViThucHien = $donViThucHien;

									// var_dump($donViThucHien);

								}
							}





						}

						$baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
						// $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
						$val->baoCaoTieuChi = $baoCaoTieuChi;
					}
				}
			}
			return array($KehoachBaocaoDetaliscoll,$keHoachTieuChuan);
		}

		public function getDataPhuLucCSDT($keHoachBaoCaoDetail2){

	        $noiDungThem = DB::table('baocao_noidungthem')
                                        ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                                        ->first();

            $noidung = json_decode($noiDungThem->noidung);
            return array($noidung);

	     }

		public function getDataPhuLuc($keHoachBaoCaoDetail2){

               $noiDungThem = DB::table('baocao_noidungthem')
                                        ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                                        ->first();

               $noidung = json_decode($noiDungThem->noidung);
               return array($noidung);
          }
		public function baoCaoKhac(Request $req){
			$url = '';
			list($keHoachBaoCaoList,$keHoachBaoCaoDetail) = $this->baseIndex($req->id);
			$baocao_url = DB::table('baocao_url')->first();
			if($baocao_url){
				$url = DB::table('baocao_url')
	                ->where('is_active', '=', 1)->first()->url;
			}


	        return view('admin.project.ExternalReview.baocaokhac')->with([
	            'title' => "Số liệu tổng hợp",
	            'url' => $url,
	            'keHoachBaoCaoList'   => $keHoachBaoCaoList,
	            'keHoachBaoCaoDetail' => $keHoachBaoCaoDetail,
	            'id'   => $req->id,
	            'page' => 'baocaokhac',
	            'kh' =>'',
	            'khtc'=>'',
	            'key'=>'',
	            'tag'=>''
	        ]);
			return $req->id;
		}

		public function thuvienminhchung(Request $req){

			return view('admin.project.ExternalReview.thuvienminhchung')
							->with([
								'id' => $req->id,
							]);
		}
		public function thuvien(Request $req){

			list($keHoachBaoCaoList,$keHoachBaoCaoDetail) = $this->baseIndex($req->id);
			$getIdDonvi = DB::table('users')
					->select('donvi.id')
					->leftjoin('donvi','donvi.id','=','users.donvi_id')
					->where('users.id',$keHoachBaoCaoDetail->ns_phutrach)
					->first();

	        $getIdDonvikhoa = DB::table('users')->where('donvi_id',$getIdDonvi->id)->pluck('id')->toArray();

	        $querydonvichung =DB::select('select users.id from users,donvi where users.donvi_id = donvi.id and donvi.ten_donvi not like "Khoa%"');
        	$getIdDonvichung = [];

	        foreach($querydonvichung as $value){
			 	array_push($getIdDonvichung, $value->id);
			 }

			$data = DB::table('minhchung')
						->orwhereIn('nguoi_quan_ly', $getIdDonvikhoa)
                		->orwhereIn('nguoi_quan_ly', $getIdDonvichung)
						->orderBy('created_at', 'desc');

			return DataTables::of($data)
					->addColumn('ten_ngan',function($dt){
						$ten_ngan = DB::table('users')
										->leftjoin('donvi','donvi.id','=','users.donvi_id')
										->where('users.id',$dt->nguoi_tao)
										->first();
						if($ten_ngan){
							return $dt->tieu_de.' ('.$ten_ngan->ten_ngan.')';
						}else{
							return 'Không có dữ liệu';
						}

					})

					->addColumn('tendonvi',function($dt){
						$tendonvi = DB::table('users')
										->leftjoin('donvi','donvi.id','=','users.donvi_id')
										->where('users.id',$dt->nguoi_tao)
										->first();
						if($tendonvi){
							return $tendonvi->ten_donvi;
						}else{
							return ''.Lang::get('project/ExternalReview/title.khongcodulieu').'';
						}

					})

					->addColumn('trang_t',function($dt){
						if($dt->cong_khai == 'Y'){
							return '<span class="badge badge-primary">'.Lang::get('project/Externalreview/title.congkhai').'</span>';
						}else{
							return '<span class="badge badge-secondary">'.Lang::get('project/Externalreview/title.khongck').'</span>';
						}

					})

					->addColumn('status',function($dt){
						if($dt->trang_thai == 'active'){
							return '<button class="btn btn-success btn-xs" data-toggle="tooltip"
                                                title="'.Lang::get('project/ExternalReview/title.cofile').'">
                                            <i class="fas fa-check-circle"></i>
                                    </button>';
						}else if($dt->trang_thai == 'inactive'){
							return '<button class="btn btn-danger btn-xs" data-toggle="tooltip"
                                            title="'.Lang::get('project/ExternalReview/title.khongcofile').'">
                                        <i class="fas fa-ban"></i>
                                    </button>';
						}else{
							return '<button class="btn btn-default btn-xs" data-toggle="tooltip" title="'.Lang::get('project/ExternalReview/title.dangcho').'">
                                        <i class="far fa-circle"></i>
                                    </button>';
						}

					})

					->addColumn('quanly',function($dt){
						if($dt){
							$text =	'<div class="btn-group"><button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                                    <i class="fas fa-eye"></i> <span class="caret"></span>
		                                </button>
		                                <ul class="dropdown-menu">';
		                    if($dt->url){
		                        $text .= '<li>
                                            <a target="_blank" href="' . $dt->url. '"><i class="fas fa-link"></i>'.Lang::get('project/ExternalReview/title.url').'</a>
                                        </li>';
		                    }

                            if($dt->duong_dan){
                            	$text .= '<li>
		                                       <a target="_blank" href="' . route('admin.dambaochatluong.manaproof.showProof',$dt->id) .'">
		                                            <i class="fas fa-file-alt"></i> ' .Lang::get('project/ExternalReview/title.xemfile').'
		                                       </a>
		                                   </li>';
                            }
                            $text .= '</ul>
                        				</div>';

                        	return $text;

						}

					})
					->rawColumns(['trang_t','status','quanly'])
					->make(true);



		}

		public function dataMinhChung(Request $req){
			$minhChung = DB::table("minhchung")->where("id", $req->id)
					->select("tieu_de", "nguoi_tao")
					->first();
			$user = DB::table("users")->where("id", $minhChung->nguoi_tao)
					->select("donvi_id")
					->first();
			$donvi = DB::table("donvi")->where("id", $user->donvi_id)
					->select("ten_ngan")
					->first();
			$arr_data = array();
			array_push($arr_data, $minhChung->tieu_de, $donvi->ten_ngan);
			return json_encode($arr_data);

		}

		 public function dugiotructuyen(Request $req){
		 	$url = "https://dhcnhn.vn/xreport-embed/training.m/giamsat?token=7875ad3f5cce854275455f412b6d5f51ca03f791";
        	return view('admin.project.ExternalReview.dugiotructuyen')
        					->with([
        						"url" => $url,
        					]);
    	 }

    	 public function phongvantructuyen(Request $req){
		 	$url = "https://dhcnhn.vn/xreport-embed/hrm.m/listpv?token=7875ad3f5cce854275455f412b6d5f51ca03f791";
        	return view('admin.project.ExternalReview.phongvantructuyen')
        					->with([
        						"url" => $url,
        					]);
    	 }

    	 public function test(Request $req){
    	 	$kehoachbao = DB::table('kehoach_baocao')
                            ->first();
		    $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
		                            ->where('id_kh_baocao',$kehoachbao->id)
		                            ->get();
		    $mcCollect = collect([]);
		    $minhChungid = [];
		    $checkMC = collect([]);
		    foreach($keHoachTieuChuanList as $keHoachTieuChuan){
		        $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
		                                                    ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
		                                                    ->get();
		        $keHoachTieuChuan->tieuChuan = DB::table('tieuchuan')
		                                                    ->where('id',$keHoachTieuChuan->tieuchuan_id)
		                                                    ->first();
		        foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
		        	$minhChungStt = 1;
		            $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
		                                                    ->where('id_kh_tieuchi',$keHoachTieuChi->id)
		                                                    ->get();
		            $keHoachTieuChi->tieuChi = DB::table('tieuchi')
		                                                    ->where('id',$keHoachTieuChi->id_tieuchi)
		                                                    ->first();
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
		                foreach ($contents as $key => $danMinhChung) {
		                	if(!in_array($danMinhChung->{'d-id'}, $minhChungid)){
		                		$minhChungCode = "[H{$keHoachTieuChuan->tieuChuan->stt}." .
                                        str_pad($keHoachTieuChuan->tieuChuan->stt, 2, '0', STR_PAD_LEFT) . "." .
                                        str_pad($keHoachTieuChi->tieuChi->stt, 2, '0', STR_PAD_LEFT) .
                                        "." . str_pad($minhChungStt, 2, '0', STR_PAD_LEFT) . "]";

                                $minhChungid[$minhChungCode] = $danMinhChung->{'d-id'};
                                $minhChungStt++;
		                	}
		                	else{
		                		$minhChungCode = array_search($danMinhChung->{'d-id'}, $minhChungid);
		                	}

		                	if($checkMC->contains($minhChungCode)){
                                continue;
                            }

                            $checkMC->push($minhChungCode);

                            if (!$danMinhChung->{'d-type'} || $danMinhChung->{'d-type'} == 'mc') {
                                $mcDetail = DB::table('minhchung')->find($danMinhChung->{'d-id'});
                                if ($mcDetail) {
                                	 $mcCollect->push([
                                        'mcCode' => $minhChungCode,
                                        'mcType' => 'mc',
                                        'mcDetail' => $mcDetail,
                                        // 'qlmc'    => $mcDetail->nguoiTao->donVi->ten_ngan
                                     ]);
                                }

                            } else {
                                $mcGop = DB::table('minhchung_gop')->find($danMinhChung->{'d-id'});
                                if ($mcGop) {
                                	$mcCollect->push([
                                        'mcCode' => $minhChungCode,
                                        'mcType' => 'mcGop',
                                        'mcDetail' => $mcGop,
                                        // 'qlmc'=>$mcGop->nguoiTao->donVi->ten_ngan
                                    ]);
                                }

                            }
		                    // $html = $minhChungCode;

		                }
		            }
		        }
		    }

    	 }

    	 public function listMinhChung($keHoachBaoCaoDetail,$idTieuChuan = null,$idTieuChi = null,$statusMC = true){

    	 	$kehoachbaocao = DB::table('kehoach_baocao')
                                ->where('id',$keHoachBaoCaoDetail->id)
                                ->first();
		    $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')
		                            ->where('id_kh_baocao',$keHoachBaoCaoDetail->id)
		                            ->get();
		    $mcCollect = collect([]);
		    $minhChungid = [];
		    $checkMC = collect([]);
		    foreach($keHoachTieuChuanList as $keHoachTieuChuan){
		        $keHoachTieuChuan->keHoachTieuChiList = DB::table('kehoach_tieuchi')
		                                                    ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
		                                                    ->get();
		        $keHoachTieuChuan->tieuChuan = DB::table('tieuchuan')
		                                                    ->where('id',$keHoachTieuChuan->tieuchuan_id)
		                                                    ->first();
		        foreach($keHoachTieuChuan->keHoachTieuChiList as $keHoachTieuChi){
		        	$minhChungStt = 1;
		            $keHoachTieuChi->keHoachMenhDeList = DB::table('kehoach_menhde')
		                                                    ->where('id_kh_tieuchi',$keHoachTieuChi->id)
		                                                    ->get();
		            $keHoachTieuChi->tieuChi = DB::table('tieuchi')
		                                                    ->where('id',$keHoachTieuChi->id_tieuchi)
		                                                    ->first();
		            if($kehoachbaocao->writeFollow == 1){
                        foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                            $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                                ->where('id_kehoach_bc',$keHoachBaoCaoDetail->id)
                                                                ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                                ->where('id_menhde',$keHoachMenhDe->id_menhde)
                                                                ->first();

                            if(isset($keHoachMenhDe->baoCaoMenhDe->mota)){
                                $dom = new Dom;
                                $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);

                                $anchorTags = $dom->find('.danMinhChung');

                                foreach ($anchorTags as $anchorTag) {
                                    $anchorData = $anchorTag->outerHtml;

                                    $classValue = $anchorTag->getAttribute('class');
                                    $idValue = $anchorTag->getAttribute('id');
                                    $valueAfterUnderscore = substr($idValue, strpos($idValue, '_') + 1);
                                    // echo($valueAfterUnderscore);
                                    if (strpos($classValue, 'mcGop') !== false) {
                                        $sohieubh = '__';
                                        $tenmc = '';
                                        $noibanhanh = '';
                                        $minhchunggop = DB::table('minhchung_gop')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchunggop){
                                            $tenmc = $minhchunggop->tieu_de;
                                            $sohieubh = DB::table('minhchung')
                                                                ->leftjoin('minhchunggop_minhchung','minhchung.id','=','minhchunggop_minhchung.minhchung_id')
                                                                ->where('minhchunggop_minhchung.minhchunggop_id',$minhchunggop->id)
                                                                ->count();
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.mcgop'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }else{
                                        $noibanhanh = '';
                                        $tenmc = '';
                                        $sohieubh = '__';
                                        $minhchung = DB::table('minhchung')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchung){
                                            $tenmc = $minhchung->tieu_de;
                                            $ngaybh = $this->toShowDate($minhchung->ngay_ban_hanh);
                                            $sohieubh = $minhchung->sohieu.','.$ngaybh;
                                            $noibanhanh = $minhchung->noi_banhanh;
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.minhchung'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }
                                }

                            }

                        }
                    }elseif($kehoachbaocao->writeFollow == 2){

                        foreach($keHoachTieuChi->keHoachMenhDeList as $keHoachMenhDe){
                            $keHoachMenhDe->baoCaoMenhDe = DB::table('baocao_menhde')
                                                                ->where('id_kehoach_bc',$keHoachBaoCaoDetail->id)
                                                                ->where('id_kh_menhde',$keHoachMenhDe->id)
                                                                ->where('mocchuan_id',$keHoachMenhDe->mocchuan_id)
                                                                ->first();

                            if(isset($keHoachMenhDe->baoCaoMenhDe->mota)){
                                $dom = new Dom;
                                $dom->loadStr($keHoachMenhDe->baoCaoMenhDe->mota);

                                $anchorTags = $dom->find('.danMinhChung');

                                foreach ($anchorTags as $anchorTag) {
                                    $anchorData = $anchorTag->outerHtml;

                                    $classValue = $anchorTag->getAttribute('class');
                                    $idValue = $anchorTag->getAttribute('id');
                                    $valueAfterUnderscore = substr($idValue, strpos($idValue, '_') + 1);
                                    // echo($valueAfterUnderscore);
                                    if (strpos($classValue, 'mcGop') !== false) {
                                        $sohieubh = '__';
                                        $tenmc = '';
                                        $noibanhanh = '';
                                        $minhchunggop = DB::table('minhchung_gop')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchunggop){
                                            $tenmc = $minhchunggop->tieu_de;
                                            $sohieubh = DB::table('minhchung')
                                                                ->leftjoin('minhchunggop_minhchung','minhchung.id','=','minhchunggop_minhchung.minhchung_id')
                                                                ->where('minhchunggop_minhchung.minhchunggop_id',$minhchunggop->id)
                                                                ->count();
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.mcgop'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }else{
                                        $noibanhanh = '';
                                        $tenmc = '';
                                        $sohieubh = '__';
                                        $minhchung = DB::table('minhchung')
                                                            ->where('id',$valueAfterUnderscore)
                                                            ->first();
                                        if($minhchung){
                                            $tenmc = $minhchung->tieu_de;
                                            $ngaybh = $this->toShowDate($minhchung->ngay_ban_hanh);
                                            $sohieubh = $minhchung->sohieu.','.$ngaybh;
                                            $noibanhanh = $minhchung->noi_banhanh;
                                        }

                                        $mcCollect->push([
                                            'mamc' => $anchorData,
                                            'minhchung' => Lang::get('project/Selfassessment/title.minhchung'),
                                            'tenmc' => $tenmc,
                                            'sohieubh' => $sohieubh,
                                            'noibanhanh' => $noibanhanh,
                                        ]);
                                    }
                                }

                            }

                        }
                    }
		        }
		    }

		    return array($mcCollect);
		}

		public function showFileData($idbc){

              $getFile = DB::table('coso_dulieu')->where('id_khbc', $idbc);
              $dataJson = json_decode($getFile->first()->Url_ex);
              $tableList = [];

              foreach ($dataJson as $key => $value) {
                  if ($value != '0') {
                      $address = public_path($value);
                      $a = Excel::toArray([], $address);

                      $table = "";
                      $UI = "";
                      foreach ($a[0] as $subKey => $subValue) { // Change the variable names here to avoid conflicts
                          $td = "";
                          if ($subKey == 0) {
                              foreach ($subValue as $val) {
                                  if (trim($val) != "") {
                                      $td .= '<th>' . trim($val) . '</th>';
                                  }
                              }
                          } else {
                              foreach ($subValue as $val) {
                                  if (trim($val) != "") {
                                      $td .= '<td>' . trim($val) . '</td>';
                                  }
                              }
                          }

                          if ($td != "") {
                              $UI .= '<tr>' . $td . '</tr>';
                          }
                      }

                      $table = '<table class="table ">' . $UI . '</table>';
                      $tableList[$key] = $table; // Assign the $table to the corresponding $key in $tableList
                  }
              }

              return $tableList;
         }

         public function baseIndex2($id = null){
               $keHoachBaoCaoDetail2 = null;

               $keHoachBaoCaoList2 = DB::table('kehoach_baocao')->get();

               // if ($id) {
             //     $keHoachBaoCaoDetail = DB::table('kehoach_baocao')->find(3);
             // }
          if($id){
               $keHoachBaoCaoDetail2 = DB::table('kehoach_baocao')
                                   ->select('kehoach_baocao.*','bo_tieuchuan.loai_tieuchuan as loai_tieuchuan_bc')
                                   ->leftjoin('bo_tieuchuan','bo_tieuchuan.id','=','kehoach_baocao.bo_tieuchuan_id')
                                   ->where('kehoach_baocao.id',$id)->first();

               if ($keHoachBaoCaoDetail2) {
                    $danhGiaMenhDe = [];
                    $keHoachBaoCaoDetail2->keHoachTieuChuanList = $keHoachTieuChuanList = DB::table('kehoach_tieuchuan')->where('id_kh_baocao',$keHoachBaoCaoDetail2->id)->get();
                    $keHoachBaoCaoDetail2->phutrach = DB::table('users')
                                                                 // ->select('excel_import_donvi.*','excel_import_donvi.ma_donvi as id_donvi')
                                                                 // ->leftjoin('excel_import_donvi','excel_import_donvi.id','=','users.donvi_id')
                                                                 ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                 ->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();

                    $keHoachBaoCaoDetail2->phutrachr = DB::table('users')
                                                                 ->select('donvi.*','donvi.ma_donvi as id_donvi')
                                                                 ->leftjoin('donvi','donvi.id','=','users.donvi_id')
                                                                 ->where('users.id',$keHoachBaoCaoDetail2->ns_phutrach)->first();


                    $keHoachBaoCaoDetail2->ctdt = DB::table('ctdt')
                                                                 ->where('id',$keHoachBaoCaoDetail2->ctdt_id)->first();
                    $keHoachBaoCaoDetail2->keHoachChung = DB::table('kehoach_chung')
                                                                      ->where('kh_baocao_id',$keHoachBaoCaoDetail2->id)
                                                                      ->first();

                    // $keHoachBaoCaoDetail2->keHoachChung->baoCaoChung = DB::table('baocao_chung')
                    //                                                                  ->where('id_kehoach_bc',$keHoachBaoCaoDetail2->id)
                    //                                                                  ->where('id_kh_chung',$keHoachBaoCaoDetail2->keHoachChung->id)
                    //                                                                  ->first();

                    foreach($keHoachTieuChuanList as $keHoachTieuChuan){
                         $tieuChuan = DB::table('tieuchuan')->where('id',$keHoachTieuChuan->tieuchuan_id)->first();
                         $keHoachTieuChuan->tieuChuan = $tieuChuan;
                         $keHoachTieuChuan->baoCaoTieuChuan = DB::table('baocao_tieuchuan')
                                                                           ->where('id_kehoach_bc',$id)
                                                                           ->where('id_kh_tieuchuan',$keHoachTieuChuan->id)
                                                                           ->where('id_tieuchuan',$keHoachTieuChuan->tieuchuan_id)
                                                                           ->first();

                         if($tieuChuan){
                              $keHoachTieuChuan->moTaWithStt = "TC $tieuChuan->stt: $tieuChuan->mo_ta";
                              $keHoachTieuChuan->keHoachTieuChiList = $keHoachTieuChiList = DB::table('kehoach_tieuchi')->where('id_kh_tieuchuan',$keHoachTieuChuan->id)->get();
                              foreach($keHoachTieuChiList as $keHoachTieuChi){
                                   $tieuChi = DB::table('tieuchi')->where('id',$keHoachTieuChi->id_tieuchi)->first();
                                   if($keHoachBaoCaoDetail2->writeFollow == 1){
                                        $keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('menhde')
                                                                                          ->where('tieuchi_id',$tieuChi->id)
                                                                                          ->get();
                                        $keHoachTieuChi->tieuChi = $tieuChi;
                                        foreach($menhde as $value){

                                             $value->khmenhde = DB::table('kehoach_menhde')
                                                                      ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                                      ->where('id_menhde',$value->id)
                                                                      ->first();

                                             $baoCaoMenhDe = DB::table('baocao_menhde')
                                                                      ->where('id_kehoach_bc',$id)
                                                                      ->where('id_kh_menhde',$value->khmenhde->id)
                                                                      ->where('id_menhde',$value->khmenhde->id_menhde)
                                                                      ->first();

                                             $value->baoCaoMenhDe = $baoCaoMenhDe;

                                             $baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
                                                                                               ->where('menhde_id',$value->khmenhde->id_menhde)
                                                                                               ->where('kehoach_bc_id',$id)
                                                                                               ->whereNull('deleted_at')
                                                                                               ->get();

                                             foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
                                                  $val->donViThucHien = DB::table('donvi')
                                                                                ->where('id',$val->ns_thuchien)
                                                                                ->first();
                                                  $val->donViKiemTra = DB::table('donvi')
                                                                                ->where('id',$val->ns_kiemtra)
                                                                                ->first();
                                             }



                                             $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                                        }



                                        $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                                        $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                                        $keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
                                   }elseif($keHoachBaoCaoDetail2->writeFollow == 2){
                                        $keHoachTieuChi->keHoachMenhDeList = $menhde = DB::table('mocchuan')
                                                                                          ->where('tieuchi_id',$tieuChi->id)
                                                                                          ->get();
                                        $keHoachTieuChi->tieuChi = $tieuChi;
                                        foreach($menhde as $value){

                                             $value->khmenhde = DB::table('kehoach_menhde')
                                                                      ->where('id_kh_tieuchi',$keHoachTieuChi->id)
                                                                      ->where('mocchuan_id',$value->id)
                                                                      ->first();

                                             $baoCaoMenhDe = DB::table('baocao_menhde')
                                                                      ->where('id_kehoach_bc',$id)
                                                                      ->where('id_kh_menhde',$value->khmenhde->id)
                                                                      ->where('mocchuan_id',$value->khmenhde->mocchuan_id)
                                                                      ->first();

                                             $value->baoCaoMenhDe = $baoCaoMenhDe;

                                             $baoCaoMenhDe->keHoachHanhDongList = DB::table('kehoach_hd')
                                                                                               ->where('mocchuan_id',$value->khmenhde->mocchuan_id)
                                                                                               ->where('kehoach_bc_id',$id)
                                                                                               ->whereNull('deleted_at')
                                                                                               ->get();


                                             foreach($baoCaoMenhDe->keHoachHanhDongList as $val){
                                                  $val->donViThucHien = DB::table('donvi')
                                                                                ->where('id',$val->ns_thuchien)
                                                                                ->first();
                                                  $val->donViKiemTra = DB::table('donvi')
                                                                                ->where('id',$val->ns_kiemtra)
                                                                                ->first();
                                             }



                                             $danhGiaMenhDe[] = $baoCaoMenhDe->danhgia;
                                        }



                                        $baoCaoTieuChi = collect(['danhgia' => round(collect($danhGiaMenhDe)->avg())]);
                                        $danhGiaTieuChi[] = round(collect($danhGiaMenhDe)->avg());
                                        $keHoachTieuChi->baoCaoTieuChi = $baoCaoTieuChi;
                                   }


                                   if($tieuChi){
                                        $keHoachTieuChi->moTaWithStt = "$tieuChuan->stt.$tieuChi->stt: $tieuChi->mo_ta";
                                   }

                              }
                         }


                    }
                  }
          }

             return array($keHoachBaoCaoList2,$keHoachBaoCaoDetail2);
          }
}

