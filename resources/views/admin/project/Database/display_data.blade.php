@extends('admin/layouts/default')
@section('title')
    Cơ sở dữ liệu
@parent
@stop

@section('header_styles')

<style type="text/css">

</style>
@stop

@section('title_page')
    <h2>Cơ sở dữ liệu</h2>
    
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
    	<!-- Thêm tệp CSS của SweetAlert2 -->
        <!-- Bắt đầu trang -->
        @if($check == "sua")
            <style>
                .import_ex table{
                    border: 1px solid;
                     border-collapse: collapse;
                }
                .import_ex table th{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                    background: lightblue;
                }
                .import_ex table td{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                }
                .edit_input{
                        padding: 7px;
                        color: red;
                        font-weight: bold;
                        margin: 5px;
                }
                .edit_input::-webkit-inner-spin-button,
                .edit_input::-webkit-outer-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
                }

                .edit_input {
                  -moz-appearance: textfield; /* Firefox */
                }

                .table-borderless{
                    border: 1px solid;
                }
                .table-borderless tr,td{
                    border: 1px solid;
                } 
            </style>
        
        @else
             <style>
                .import_ex table{
                    border: 1px solid;
                     border-collapse: collapse;
                }
                .import_ex table th{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                    background: lightblue;
                }
                .import_ex table td{
                    border: 1px solid;
                    text-align: center;
                    vertical-align: middle;
                }
                .edit_input{
                        padding: 7px;
                        color: red;
                        font-weight: bold;
                        margin: 5px;
                        border: none;
                        outline: none;
                        background: none;
                }
                .btn-benchmarkbtn-benchmark{
                    display: none;
                }
                .edit_input::-webkit-inner-spin-button,
                .edit_input::-webkit-outer-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
                }

                .edit_input {
                  -moz-appearance: textfield; /* Firefox */
                }
                .btn-benchmark{
                    display: none;
                }
                #btn_submit{
                    display: none;
                }
            </style>
        
        
        @endif
      	<div class="m-t-md">

		    <div class="h5 text-center">
		        @lang('project/Externalreview/title.csdlkdclcsdt')
		    </div>

		    <p class="text-center">@lang('project/Externalreview/title.tdbc2') {{ (($keHoachBaoCaoDetail2)?\Carbon\Carbon::parse($keHoachBaoCaoDetail2->thoi_diem_bao_cao)->format('d/m/Y'):"Chưa cập nhật") }}</p>

		    <p> <strong>@lang('project/Externalreview/title.phan1')</strong></p>
            <p><i><strong>@lang('project/Externalreview/title.1')</strong></i></p>
            <p>- TRƯỜNG ĐẠI HỌC HỌC CÔNG NGHIỆP DỆT MAY HÀ NỘI</p>
            <p>- HA NOI INDUSTRIAL TEXTTILE GARMENT UNIVERSITY</p>
            <p><i><strong>@lang('project/Externalreview/title.2')</strong></i></p>
            <p>- ĐHCNDMHN</p>
            <p>- HTU</p>
            <p><i><strong>@lang('project/Externalreview/title.3')</strong></i></p>
            <p><i><strong>4. Cơ quan/Bộ chủ quản: Tập đoàn Dệt May Việt Nam</strong></i></p>
            <p><i><strong>5. Địa chỉ : Lệ Chi - Gia Lâm - Hà Nội</strong></i></p>
            <p><i><strong>6. Thông tin liên hệ: Điện thoại: (0234) 38276514 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.fax')</strong></i></p>
            <p><i><strong> phongtchc@hict.edu.vn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   ww.hict.edu.vn</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.7') </strong></i><i>01/06/2015 (QĐ 3993/VPCP- ĐMDN) </i></p>
            <p><i><strong>8. Thời gian bắt đầu đào tạo khóa I: 2016</strong></i></p>
            <p><i><strong>9. Thời gian cấp bằng tốt nghiệp cho khoá I:  2020</strong></i></p>
            <p><i><strong>@lang('project/Externalreview/title.10') </strong></i></p>
		    <div class="m-l-lg">
		        <p>
		            <label class="checkbox-inline">
		                <input type="checkbox" class="m-t-xs" disabled checked> @lang('project/Externalreview/title.conglap')
		            </label>
		            <label class="checkbox-inline">
		                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.bancong')
		            </label>
		            <label class="checkbox-inline">
		                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.danlap')
		            </label>
		            <label class="checkbox-inline">
		                <input type="checkbox" class="m-t-xs" disabled> @lang('project/Externalreview/title.tuthuc')
		            </label>
		        </p>
		        <p>@lang('project/Externalreview/title.lhk')</p>
		    </div>

		    @php $fiveYearAgo = $keHoachBaoCaoDetail2->nam -5 @endphp

		    <p> <strong>@lang('project/Externalreview/title.ii')</strong></p>
		    <p><i><strong>@lang('project/Externalreview/title.12ten')</strong></i> </p>
		    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_donvi)? $keHoachBaoCaoDetail2->phutrach->ten_donvi : ''}}</p>
		    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_tienganh)? $keHoachBaoCaoDetail2->phutrach->ten_tienganh : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.13ten')</strong></i></p>
		    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_ngan)? $keHoachBaoCaoDetail2->phutrach->ten_ngan : ''}}</p>
		    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->phutrach->ten_tienganh)? $keHoachBaoCaoDetail2->phutrach->ten_tienganh :''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.14ten') </strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ten_donvi_cu)? $keHoachBaoCaoDetail2->phutrach->ten_donvi_cu : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.15ten') </strong></i>{{ isset($keHoachBaoCaoDetail2->ctdt->tennganh)? $keHoachBaoCaoDetail2->ctdt->tennganh : ''}}</p>
		    <p>- @lang('project/Externalreview/title.tiengviett') {{ isset($keHoachBaoCaoDetail2->ctdt->tennganh)? $keHoachBaoCaoDetail2->ctdt->tennganh :''}}</p>
		    <p>- @lang('project/Externalreview/title.tienganhh') {{ isset($keHoachBaoCaoDetail2->ctdt->tennganh_en)? $keHoachBaoCaoDetail2->ctdt->tennganh_en : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.16')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ma_ctdt)? $keHoachBaoCaoDetail2->phutrach->ma_ctdt : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.17') </strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->ten_ctdt_cu)? $keHoachBaoCaoDetail2->phutrach->ten_ctdt_cu : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.18')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->dia_chi)? $keHoachBaoCaoDetail2->phutrach->dia_chi : ''}}</p>
		    <p><i><strong>@lang('project/Externalreview/title.19')</strong></i> {{ (isset($keHoachBaoCaoDetail2->phutrach->dien_thoai)?$keHoachBaoCaoDetail2->phutrach->dien_thoai:'.................. ')  }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;@lang('project/Externalreview/title.fax')</p>
		    <p><i><strong>@lang('project/Externalreview/title.20')</strong></i> {{ (($keHoachBaoCaoDetail2->phutrach->email)?$keHoachBaoCaoDetail2->phutrach->email:'.................. ') }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; @lang('project/Externalreview/title.webs') {{ (($keHoachBaoCaoDetail2->phutrach->website)?$keHoachBaoCaoDetail2->phutrach->website:'..................')  }}</p>
		    <p>
		        <i><strong>@lang('project/Externalreview/title.21')</strong></i>
		        {{ isset($keHoachBaoCaoDetail2->phutrach->nam_thanhlap)?$keHoachBaoCaoDetail2->phutrach->nam_thanhlap:'' }} <br>
		      <div> {!! isset($keHoachBaoCaoDetail2->phutrach->mota_nam_thanhlap)?$keHoachBaoCaoDetail2->phutrach->mota_nam_thanhlap : '' !!} </div>
		    </p>
		    <p><i><strong>@lang('project/Externalreview/title.22')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->nam_batdau)?$keHoachBaoCaoDetail2->phutrach->nam_batdau : '' }}</p>
		    <p><i><strong>@lang('project/Externalreview/title.23')</strong></i> {{ isset($keHoachBaoCaoDetail2->phutrach->nam_capbang)?$keHoachBaoCaoDetail2->phutrach->nam_capbang : '' }}</p>
		    <p> <strong>@lang('project/Externalreview/title.iii')</strong></p>
		    <p><i><strong>@lang('project/Externalreview/title.24') <br></strong></i>
		    	@php
		            if(isset($keHoachBaoCaoDetail2->phutrach->gioi_thieu)){

		                if($keHoachBaoCaoDetail2->phutrach->gioi_thieu != null){
		                   echo($keHoachBaoCaoDetail2->phutrach->gioi_thieu);
		                }
		                
		            }
		        @endphp

		    </p>
		    <p><i><strong>@lang('project/Externalreview/title.25') <br>
		        @php
		            if(isset($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc)){
		                if($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc != null){
		                    echo($keHoachBaoCaoDetail2->phutrach->co_cau_tochuc);
		                }
		                
		            }
		        @endphp
		        </strong></i>
		        
		    </p>

		    <form action="{{route('admin.tudanhgia.database.save_file_ctdt')}}" method="POST" enctype="multipart/form-data">
		    	<input type="text" hidden value="{{$idkhbc}}" name="id">
			    <p>
			        <i><strong>@lang('project/Externalreview/title.26')</strong></i>
			    </p>

			    <p>
			        <em>@lang('project/Externalreview/title.rieng')</em>
			    </p>
			    <div>
		    		<input hidden type="file" class="inputFile" name="p26">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p26']) ? $data['p26'] : '' !!}
		       	 	</div>
			    </div>
			  	
			  	<p><i><strong>@lang('project/Externalreview/title.27')</strong></i></p>
			  	<div>
			  		<span>Số lượng chuyên ngành đào tạo Cao đẳng :</span>
			  		<input type="number" class="edit_input" value="{{$dulieu->p27_caodang}}" data_key="p27_caodang" min="0">
			  	</div>
			  	<div>
			  		<span>Số lượng chuyên ngành đào tạo Đại học :</span>
			  		<input type="number" class="edit_input" value="{{$dulieu->p27_daihoc}}" data_key="p27_daihoc" min="0">
			  	</div>
			  	<div>
			  		<span>Số lượng chuyên ngành đào tạo Thạc sĩ :</span>
			  		<input type="number" class="edit_input" value="{{$dulieu->p27_thacsi}}" data_key="p27_thacsi" min="0">
			  	</div>
			  	<div>
			  		<span>Số lượng chuyên ngành đào tạo Tiến sĩ :</span>
			  		<input type="number" class="edit_input" value="{{$dulieu->p27_tiensi}}" data_key="p27_tiensi" min="0">
			  	</div>
			  	
			  	<p>@lang('project/Externalreview/title.slcndtk')</p>
			  	<p>
			        <em>
			        @lang('project/Externalreview/title.donvi')
			        </em>
			    </p>
			    <p><i><strong>@lang('project/Externalreview/title.28')</strong></i></p>
			    <div class="row m-t-lg">
		       

		        <!-- đây là thẻ form -->
		        <div id="save_contenty">
		            @csrf
		            <input type="hidden" value="phuluc28" name="ten">
		            <input type="hidden" value="{{ $keHoachBaoCaoDetail2->id }}" name="id_kehoach_bc">
		            <table class="table-borderless table table-condensed">
		                <tr>
		                    <td></td>
		                    <td>@lang('project/Externalreview/title.co')</td>
		                    <td>@lang('project/Externalreview/title.khong')</td>
		                </tr>
		                <tr>
		                    <td>@lang('project/Externalreview/title.chinhquy')</td>
		                    <td><input {{ ($noiDungThem->chinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[chinhquy]" value="co" data_key="chinhquy"></td>
		                    <td><input {{ ($noiDungThem->chinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[chinhquy]" value="khong" data_key="chinhquy"></td>
		                </tr>

		                <tr>
		                    <td>@lang('project/Externalreview/title.khongchinhquy')</td>
		                    <td><input {{ ($noiDungThem->khongchinhquy=='co')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[khongchinhquy]" value="co" data_key="khongchinhquy"></td>
		                    <td><input {{ ($noiDungThem->khongchinhquy=='khong')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[khongchinhquy]" value="khong" data_key="khongchinhquy"></td>
		                </tr>

		                <tr>
		                    <td>@lang('project/Externalreview/title.tuxa')</td>
		                    <td><input {{ ($noiDungThem->tuxa=='co')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[tuxa]" value="co" data_key="tuxa"></td>
		                    <td><input {{ ($noiDungThem->tuxa=='khong')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[tuxa]" value="khong" data_key="tuxa"></td>
		                </tr>

		                <tr>
		                    <td>@lang('project/Externalreview/title.lknn')</td>
		                    <td><input {{ ($noiDungThem->nuocngoai=='co')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[nuocngoai]" value="co" data_key="nuocngoai"></td>
		                    <td><input {{ ($noiDungThem->nuocngoai=='khong')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[nuocngoai]" value="khong" data_key="nuocngoai"></td>
		                </tr>

		                <tr>
		                    <td>@lang('project/Externalreview/title.lktn')</td>
		                    <td><input {{ ($noiDungThem->trongnuoc=='co')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[trongnuoc]" value="co" data_key="trongnuoc"></td>
		                    <td><input {{ ($noiDungThem->trongnuoc=='khong')?'checked':"" }} class="radiobox" type="radio"
		                               name="noidungthem[trongnuoc]" value="khong" data_key="trongnuoc"></td>
		                </tr>
		            </table>
		        </div>
		    
			    <p><i><strong>@lang('project/Externalreview/title.29')<b>
			    	<input type="number" class="edit_input" value="{{$dulieu->p29_tongnganhdt}}" data_key="p29_tongnganhdt" min="0">
			    </b></strong></i></p>

			    <p> <strong>@lang('project/Externalreview/title.iv')</strong></p>
		    	<p><i><strong>@lang('project/Externalreview/title.30')</strong></i></p>
		    	<div>
		    		<input hidden type="file" class="inputFile" name="p30">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p30']) ? $data['p30'] : '' !!}
		       	 	</div>
			    </div>
			   
		        

		        <p><em>@lang('project/Externalreview/title.donvithuchien')</em></p>
			    <p><i><strong>@lang('project/Externalreview/title.31')</strong></i></p>
			    <p>
			        <small>@lang('project/Externalreview/title.cbchla')
			        </small>
			    </p>
			    <p>
			        <small>@lang('project/Externalreview/title.gvtgla')
			    </p>

			    <div>
		    		<input hidden type="file" class="inputFile" name="p31_1">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p31_1']) ? $data['p31_1'] : '' !!}
		       	 	</div>
			    </div>

			    <p><em>@lang('project/Externalreview/title.khitinhsl')</em></p>
			    <p>Tổng số giảng viên cơ hữu : 
			    	<input type="number" class="edit_input" value="{{$dulieu->p31_tongvcohuu}}" data_key="p31_tongvcohuu" min="0">
			    </p>
			    <p>@lang('project/Externalreview/title.tile')
			       <input type="number" class="edit_input" value="{{$dulieu->p31_tylegvch}}" data_key="p31_tylegvch" min="0"> 
			     </p>
			    
			    <br/>
			    <p><i><strong>@lang('project/Externalreview/title.32')</strong></i></p>
			  	<p>
			        <small>@lang('project/Externalreview/title.solieub32')
			        </small>
			    </p>
			    <div>
		    		<input hidden type="file" class="inputFile" name="p31">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p31']) ? $data['p31'] : '' !!}
		       	 	</div>
			    </div>

		        <p><i><strong>@lang('project/Externalreview/title.33')</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p32">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p32']) ? $data['p32'] : ''!!}
		       	 	</div>
			    </div>

		        <p>@lang('project/Externalreview/title.33cham1')
		        	<input type="number" class="edit_input" value="{{$dulieu->p33_1_tuoitb}}" data_key="p33_1_tuoitb" min="0">
		        </p>
		        <p>@lang('project/Externalreview/title.33cham2') 
		        	<input type="number" class="edit_input" value="{{$dulieu->p33_2_tdts}}" data_key="p33_2_tdts" min="0">
		        </p>
		        <p>@lang('project/Externalreview/title.33cham3')
		        	<input type="number" class="edit_input" value="{{$dulieu->p33_3_tdths}}" data_key="p33_3_tdths" min="0">
		        </p>
		        <p><i><strong>@lang('project/Externalreview/title.34')</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p33">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p33']) ? $data['p33'] : '' !!}
		       	 	</div>
			    </div>
		        <p> <strong>@lang('project/Externalreview/title.v')</strong></p>
			    <p><i><strong>@lang('project/Externalreview/title.35')</strong></i></p>
			    <p>@lang('project/Externalreview/title.tongsonguoidk')</p>
			    <div>
		    		<input hidden type="file" class="inputFile" name="p34">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p34']) ? $data['p34'] : '' !!}
		       	 	</div>
			    </div>
		        <p><i><strong>@lang('project/Externalreview/title.36')</strong></i></p>
	    		<p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
	    		<div>
		    		<input hidden type="file" class="inputFile" name="p35">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p35']) ? $data['p35'] : '' !!}
		       	 	</div>
			    </div>
		        <p><i><strong>@lang('project/Externalreview/title.37')</strong></i></p>
	    		<p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
	    		<div>
		    		<input hidden type="file" class="inputFile" name="p36">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p36']) ? $data['p36'] : '' !!}
		       	 	</div>
			    </div>
		        <p><i><strong>@lang('project/Externalreview/title.38')</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p37">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p37']) ? $data['p37'] : '' !!}
		       	 	</div>
			    </div>
		        <p><i><strong>@lang('project/Externalreview/title.39')</strong></i></p>
	    		<p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
	    		<div>
		    		<input hidden type="file" class="inputFile" name="p38">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p38']) ? $data['p38'] : '' !!}
		        		
		       	 	</div>
			    </div>

		        <p><i><strong>@lang('project/Externalreview/title.40')</strong></i></p>
	    		<p style="text-align:right"><em>@lang('project/Externalreview/title.donvii')</em></p>
	    		<div>
		    		<input hidden type="file" class="inputFile" name="p39">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p39']) ? $data['p39'] : '' !!}
		        		
		       	 	</div>
			    </div>
		        <p>(Tính cả những người học đã đủ điều kiện tốt nghiệp theo quy định nhưng đang chờ cấp bằng)</p>
		        <p><i><strong>41. Tình trạng tốt nghiệp của sinh viên hệ chính quy của CTĐT:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p40">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p40']) ? $data['p40'] : '' !!}
		        		
		       	 	</div>
			    </div>
		        <p>Ghi chú:</p>
		        <p>Người học tốt nghiệp là người học có đủ điều kiện để được công nhận tốt nghiệp theo quy định, kể cả những người học chưa nhận được bằng tốt nghiệp</p>
		        <p>Năm đầu tiên sau khi tốt nghiệp: 12 tháng kể từ ngày tốt nghiệp.</p>
		        <p>Các mục bỏ trống đều được xem là cơ sở giáo dục/đơn vị thực hiện CTĐT không điều tra về việc này.</p>
		        <p> <strong>VI. Nghiên cứu khoa học và chuyển giao công nghệ</strong></p>
		        <p><i><strong>42. Số lượng đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ của đơn vị thực hiện CTĐT được nghiệm thu trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p41">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p41']) ? $data['p41'] : '' !!}
		       	 	</div>
			    </div>
		        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước.</p>
		        <div>
		        	<p>Hệ số quy đổi: Dựa trên nguyên tắc tính điểm công trình của Hội đồng chức danh giáo sư Nhà nước (có điều chỉnh).</p>
		        	<span>Tổng số đề tài quy đổi : </span>
		        	<input type="number" class="edit_input" value="{{$dulieu->p42_tsdetaiqd}}" data_key="p42_tsdetaiqd" min="0">
		        </div>
		        <div>
		        	<span>
		        	      Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ (quy đổi) trên cán bộ cơ hữu của đơn vị thực hiện CTĐT: 
		            </span>
		            <input type="number" class="edit_input" value="{{$dulieu->p42_tysodtqd}}" data_key="p42_tysodtqd" min="0">
		        </div>
		        <p><i><strong>43. Doanh thu từ nghiên cứu khoa học và chuyển giao công nghệ của đơn vị thực hiện CTĐT trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p42">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p42']) ? $data['p42'] : '' !!}
		        		
		       	 	</div>
			    </div>

		        <p><i><strong>44. Số lượng cán bộ cơ hữu của đơn vị thực hiện CTĐT tham gia thực hiện đề tài khoa học trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p43">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p43']) ? $data['p43'] : '' !!}
		       	 	</div>
			    </div>
		        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
		        <p><i><strong>45. Số lượng đầu sách của đơn vị thực hiện CTĐT được xuất bản trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p44">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p44']) ? $data['p44'] : '' !!}
		        		
		       	 	</div>
			    </div>
		        <p>**Hệ số quy đổi: Dựa trên nguyên tắc tính điểm công trình của Hội đồng chức danh giáo sư Nhà nước (có điều chỉnh).</p>
		        <div>
		        	<span>Tổng số sách (quy đổi):</span>
		        	<input type="number" class="edit_input" value="{{$dulieu->p45_tsosach}}" data_key="p45_tsosach" min="0">
		        </div>
		        <div>
		        	<span>Tỷ số sách đã được xuất bản (quy đổi) trên cán bộ cơ hữu:</span>
		        	<input type="number" class="edit_input" value="{{$dulieu->p45_tysosach}}" data_key="p45_tysosach" min="0">
		        </div>
		        <p><i><strong>46. Số lượng cán bộ cơ hữu của đơn vị thực hiện CTĐT tham gia viết sách trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p45">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p45']) ? $data['p45'] : '' !!}
		        		
		       	 	</div>
			    </div>
		        <p><i><strong>47. Số lượng bài của các cán bộ cơ hữu của đơn vị thực hiện CTĐT được đăng tạp chí trong 5 năm gần đây:</strong></i></p>
		        <div>
		    		<input hidden type="file" class="inputFile" name="p46">
			    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
		            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
		        	</button>

		        	<div class="import_ex">
		        		{!! isset($data['p46']) ? $data['p46'] : '' !!}
		       	 	</div>
			    </div>
		        <p>**Hệ số quy đổi: Dựa trên nguyên tắc tính điểm công trình của Hội đồng chức danh giáo sư Nhà nước (có điều chỉnh).</p>
		        <div>
		        	<span>Tổng số bài đăng tạp chí (quy đổi) : </span>
		        	<input type="number" class="edit_input" value="{{$dulieu->p47_tsobaitapchi}}" data_key="p47_tsobaitapchi" min="0">
		        </div>
		        <div>
		        	<span>Tỷ số bài đăng tạp chí (quy đổi) trên cán bộ cơ hữu : </span>
		        	<input type="number" class="edit_input" value="{{$dulieu->p47_tysobaitapchi}}" data_key="p47_tysobaitapchi" min="0">
		        </div>
	      	</div>
	      	<p><i><strong>48. Số lượng cán bộ cơ hữu của đơn vị thực hiện CTĐT tham gia viết bài đăng tạp chí trong 5 năm gần đây:</strong></i></p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p47">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p47']) ? $data['p47'] : '' !!}
	        		
	       	 	</div>
		    </div>
		    <p><i><strong>49. Số lượng báo cáo khoa học do cán bộ cơ hữu của đơn vị thực hiện CTĐT báo cáo tại các hội nghị, hội thảo, được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:</strong></i></p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p48">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p48']) ? $data['p48'] : '' !!}
	        		
	       	 	</div>
		    </div>
		    <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của cơ sở giáo dục vì đã được tính 1 lần)</p>
		    <p>**Hệ số quy đổi: Dựa trên nguyên tắc tính điểm công trình của Hội đồng chức danh giáo sư Nhà nước (có điều chỉnh).</p>
		    <div>
	        	<span>Tổng số bài báo cáo (quy đổi):Tổng số bài báo cáo (quy đổi) : </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p49_tsobaibc}}" data_key="p49_tsobaibc" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số bài báo cáo (quy đổi) trên cán bộ cơ hữu : </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p49_tysobaibc}}" data_key="p49_tysobaibc" min="0">
	        </div>

	        <p><i><strong>50. Số lượng cán bộ cơ hữu của đơn vị thực hiện CTĐT có báo cáo khoa học tại các hội nghị, hội thảo được đăng toàn văn trong tuyển tập công trình hay kỷ yếu trong 5 năm gần đây:</strong></i></p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p49">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p49']) ? $data['p49'] : '' !!}
	        		
	       	 	</div>
		    </div>
	        <p>(Khi tính Hội thảo trong nước sẽ không bao gồm các Hội thảo của trường)</p>
	        <p><i><strong>51. Số bằng phát minh, sáng chế được cấp</strong></i></p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p50">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p50']) ? $data['p50'] : '' !!}
	        		
	       	 	</div>
		    </div>

	        <p><i><strong>52. Nghiên cứu khoa học của người học</strong></i></p>
	        <p>52.1. Số lượng người học của đơn vị thực hiện CTĐT tham gia thực hiện đề tài khoa học trong 5 năm gần đây:</p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p51">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p51']) ? $data['p51'] : '' !!}
	        		
	       	 	</div>
		    </div>
	        <p>* Bao gồm đề tài cấp Bộ hoặc tương đương, đề tài nhánh cấp Nhà nước</p>
	        <p>52.2. Thành tích nghiên cứu khoa học của sinh viên:</p>
	        <p>(Thống kê các giải thưởng nghiên cứu khoa học, sáng tạo, các bài báo, công trình được công bố)</p>
	        <div>
	    		<input hidden type="file" class="inputFile" name="p52">
		    	<button href="" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-original-title="Nhập Excel">
	            	<i class="bi bi-file-earmark-arrow-up" style="font-size: 35px;color: #50cd89;"></i>
	        	</button>

	        	<div class="import_ex">
		        	{!! isset($data['p52']) ? $data['p52'] : '' !!}
	        		
	       	 	</div>
		    </div>

	        <p><strong>VII. Cơ sở vật chất, thư viện</strong></p>
	        <p><i><strong>
	        	53. Tổng diện tích đất sử dụng của cơ sở giáo dục (tính bằng m2):
	        	<input type="number" class="edit_input" value="{{$dulieu->p53_tongdtdcsgd}}" data_key="p53_tongdtdcsgd" min="0">
	        </strong></i></p>
	        <p><i><strong>
	        	54. Tổng diện tích đất sử dụng của đơn vị thực hiện CTĐT (tính bằng m2):
	        	<input type="number" class="edit_input" value="{{$dulieu->p53_tongdtdvth}}" data_key="p53_tongdtdvth" min="0">
	        </strong></i></p>
	        <p><i>
	        	<strong>55. Diện tích sử dụng cho các hạng mục sau (tính bằng m2):</strong>
	        </i></p>
	        <div>
	        	<span>- Nơi làm việc:</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p55_noilmv}}" data_key="p55_noilmv" min="0">
	        </div>
	        <div>
	        	<span>- Nơi học:</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p55_noihoc}}" data_key="p55_noihoc" min="0">
	        </div>
	        <div>
	        	<span>- Nơi vui chơi giải trí:</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p55_noigt}}" data_key="p55_noigt" min="0">
	        </div>
	        <p><i><strong>
	        	56. Diện tích phòng học (tính bằng m2)
	        </strong></i></p>
	        <div>
	        	<span>- Tổng diện tích phòng học:</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p56_tdtphong}}" data_key="p56_tdtphong" min="0">
	        </div>
	         <div>
	        	<span>- Tỷ số diện tích phòng học trên người học chính quy:</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p56_tysodtpcq}}" data_key="p56_tysodtpcq" min="0">
	        </div>
	        <p><i><strong>
	        	57. Tổng số đầu sách thuộc ngành đào tạo được sử dụng tại Trung tâm Thông tin – Thư viện :
	        	<input type="number" class="edit_input" value="{{$dulieu->p57_tsodstndt}}" data_key="p57_tsodstndt" min="0">
	        </strong></i></p>
	        <div>
	        	<span>- Tổng số đầu sách trong phòng tư liệu của đơn vị thực hiện CTĐT (nếu có):</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p57_tsodstptl}}" data_key="p57_tsodstptl" min="0">
	        </div>
	        <p><i><strong>
	        	58. Tổng số máy tính của đơn vị thực hiện CTĐT:
	        </strong></i></p>
	        <div>
	        	<span>- Dùng cho hệ thống văn phòng : </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p58_dchtvp}}" data_key="p58_dchtvp" min="0">
	        </div>
	        <div>
	        	<span>- Dùng cho người học học tập : </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p58_dcnht}}" data_key="p58_dcnht" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số số máy tính dùng cho người học/người học chính quy: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->p58_tsomtdcnh}}" data_key="p58_tsomtdcnh" min="0">
	        </div>
	        <p><strong>VIII. Tóm tắt một số chỉ số quan trọng</strong></p>
	        <p>Từ kết quả khảo sát ở trên, tổng hợp thành một số chỉ số quan trọng dưới đây:</p>
	        <p><i><strong>1. Giảng viên:</strong></i></p>
	        <div>
	        	<span>Tổng số giảng viên cơ hữu (người): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_1_tsgvch}}" data_key="viii_1_tsgvch" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ giảng viên cơ hữu trên tổng số cán bộ cơ hữu (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_1_tlgvch}}" data_key="viii_1_tlgvch" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ giảng viên cơ hữu có trình độ tiến sĩ trở lên trên tổng số giảng viên cơ hữu của đơn vị thực hiện CTĐT (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_1_gvchts}}" data_key="viii_1_gvchts" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ giảng viên cơ hữu có trình độ thạc sĩ trên tổng số giảng viên cơ hữu của đơn vị thực hiện CTĐT (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_1_gvchths}}" data_key="viii_1_gvchths" min="0">
	        </div>
	        <p><i>
	        	<strong>2. Người học:</strong>
	        </i></p>
	        <div>
	        	<span>Tổng số người học chính quy theo CTĐT (người) : </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_2_tsnhcq}}" data_key="viii_2_tsnhcq" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số người học chính quy trên giảng viên theo CTĐT: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_2_tsngcqtgv}}" data_key="viii_2_tsngcqtgv" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ người học tốt nghiệp so với số tuyển vào (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_2_tlnhtn}}" data_key="viii_2_tlnhtn" min="0">
	        </div>
	        <p><i>
	        	<strong>3. Đánh giá của người học tốt nghiệp về chất lượng CTĐT:</strong>
	        </i></p>
	        <div>
	        	<span>Tỷ lệ người học trả lời đã học được những kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%):</span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_3_tlngtldh}}" data_key="viii_3_tlngtldh" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ người học trả lời chỉ học được một phần kiến thức và kỹ năng cần thiết cho công việc theo ngành tốt nghiệp (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_3_tlhmpkt}}" data_key="viii_3_tlhmpkt" min="0">
	        </div>
	        <p><i>
	        	<strong>4. Người học có việc làm trong năm đầu tiên sau khi tốt nghiệp:</strong>
	        </i></p>
	        <p><i>
	        	<strong>5. Đánh giá của nhà tuyển dụng về người học tốt nghiệp có việc làm đúng ngành đào tạo:</strong>
	        </i></p>
	        <div>
	        	<span>Tỷ lệ người học đáp ứng yêu cầu của công việc, có thể sử dụng được ngay (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_5_tlhdunc}}" data_key="viii_5_tlhdunc" min="0">
	        </div>
	        <div>
	        	<span>Tỷ lệ người học cơ bản đáp ứng yêu cầu của công việc, nhưng phải đào tạo thêm (%): </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_5_nhcbdu}}" data_key="viii_5_nhcbdu" min="0">
	        </div>
	        <p><i><strong>
	        	6. Nghiên cứu khoa học và chuyển giao công nghệ:
	        </strong></i></p>
	        <div>
	        	<span>Tỷ số đề tài nghiên cứu khoa học và chuyển giao khoa học công nghệ (quy đổi) trên cán bộ cơ hữu: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_6_tldtnckh}}" data_key="viii_6_tldtnckh" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số doanh thu từ NCKH và chuyển giao công nghệ trên cán bộ cơ hữu: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_6_tldtnckh}}" data_key="viii_6_tldtnckh" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số sách đã được xuất bản (quy đổi) trên cán bộ cơ hữu: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_6_tssddsb}}" data_key="viii_6_tssddsb" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số bài đăng tạp chí (quy đổi) trên cán bộ cơ hữu: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_6_tsbdtc}}" data_key="viii_6_tsbdtc" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số bài báo cáo (quy đổi) trên cán bộ cơ hữu: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_6_tsbdbc}}" data_key="viii_6_tsbdbc" min="0">
	        </div>
	        <p><i><strong>
	        	7. Cơ sở vật chất:
	        </strong></i></p>
	        <div>
	        	<span>Tỷ số máy tính dùng cho người học trên người học chính quy: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_7_tsmtdcnh}}" data_key="viii_7_tsmtdcnh" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số diện tích phòng học trên người học chính quy: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_7_tsdtp}}" data_key="viii_7_tsdtp" min="0">
	        </div>
	        <div>
	        	<span>Tỷ số diện tích ký túc xá trên người học chính quy: </span>
	        	<input type="number" class="edit_input" value="{{$dulieu->viii_7_tsdtkt}}" data_key="viii_7_tsdtkt" min="0">
	        </div>
	        <div class="text-center mt-3">
	    		<button id="btn_submit" class="btn btn-success w-25" type="submit">Cập nhật bảng biểu</button>
	    	</div>
		</form>


<!-- page trang ở đây -->

    
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
</section>

@stop



@section('footer_scripts')
<!-- Thêm tệp JavaScript của SweetAlert2 -->
<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script type="text/javascript">
   $('.edit_input').on('change',function() {
        let val = $(this).val();
        let key = $(this).attr('data_key');
         $.ajax({
            url: "{!! route('admin.tudanhgia.database.save_data') !!}",
            type: "POST",
            data:{
                val : val,
                key : key,
                ikhbc : {{$idkhbc}},
                _token: '{{ csrf_token() }}'
            },    
            error: function(err) {

            },

            success: function(data) {
            	if(data ==1){
            		Swal.fire({
		                icon: 'success',
		                title: 'Thành công!',
		                text: 'Bạn đã cập nhật thành công.',
		            });
            	}else{
            		Swal.fire({
		                icon: 'Warning',
		                title: 'Thất bại!',
		                text: 'Bạn đã cập nhật thất bại.',
		            });
            	}
                
            },
        })
    })
   @if($check != "sua")
        $('.edit_input').prop('disabled', true);
        $('.radiobox').prop('disabled', true);
    @endif


    $("#save_contenty").on('change','.radiobox',function(){
    	let key = $(this).attr('data_key');
    	let val = $(this).val();
    	
    	$.ajax({
                url: "{{route('admin.tudanhgia.database.apiNoiDungThem')}}",
                type: "GET",
                data:{
                    id : {{$idkhbc}},
                    key : key,
                    val : val,
                },    
                error: function(err) {
                },

                success: function(data) {
                    console.log(data);
                    if(data ==1){
	            		Swal.fire({
			                icon: 'success',
			                title: 'Thành công!',
			                text: 'Bạn đã cập nhật thành công.',
			            });
	            	}else{
	            		Swal.fire({
			                icon: 'Warning',
			                title: 'Thất bại!',
			                text: 'Bạn đã cập nhật thất bại.',
			            });
	            	}
                },
        })
    })
</script>

<script type="text/javascript" src="{{ asset('js/baocaoctdt.js') }}"></script>
@stop

