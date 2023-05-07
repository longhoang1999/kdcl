@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Externalreview/title.lkhdgn')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/ExternalReview/externalreview.css') }}">

@stop

@section('title_page')
    @lang('project/Externalreview/title.khvbc')
@stop
@section('content')
<section class="content-body">
    
    <style>
    	.css-t{
    		margin-top: 3rem;
    	}
    	.select2-container{
    		border: 1px solid #e4e6ef;
    		padding-top: 9px;
    	}
    	.block_css{
    		box-shadow: 2px 4px 9px 5px lightgrey;
		    margin-left: 4rem;
		    padding: 21px 467px 212px 41px;
    	}
    	.save{
    		margin-top: 3rem;
		    border-radius: 4px;
		    box-shadow: 2px 2px 5px 1px lightgrey !important;
    	}
		button i {
			font-size: 30px !important;
		}
		
		/*.select2-container .select2-dropdown {
			max-height: 150px; 
			overflow-y: scroll;
		}*/





    </style>
	<div class="container mt-5 block_css">
			<div class="row form-group css-t d-flex align-items-center">
				<label for="" class="col-4 control-label">@lang('project/Externalreview/title.tenbaocao')</label>
				<div class="col-8" id="parentDiv" style="width: 250px;">
					<select name="" id="select2" class="form-control name_bc scrollbar" style="width: 100%">
						@foreach($baocao as $value)
							<option value="" id="{{$value->id}}">{{$value->ten_bc}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row css-t d-flex align-items-center">
				<label for="" class="col-4 control-label ">@lang('project/Externalreview/title.ttct')</label>
				<div class="col-8">
					<select name="" id="select2_tt" class="form-control select2">
						@foreach($data as $nhansu)
							<option value="{{$nhansu->id}}">{{$nhansu->name}}-({{$nhansu->ten_donvi}})</option>
						@endforeach
					</select>	
				</div>
			</div>

			<div class="row css-t d-flex align-items-center">
				<label for="" class="col-4 control-label">@lang('project/Externalreview/title.nhansuthuchien')</label>
				<div class="col-8">
					<button class="btn btn-xs pd-css" data-toggle="modal" type="button" data-target="#nhanSuThucHienModal">
                            <i class="bi bi-person-lines-fill" style="font-size: 35px;color: #5014d0;"></i>
                    </button>
				</div>
			</div>

			<div class="row css-t d-flex align-items-center">
				<label for="" class="col-4 control-label">@lang('project/Externalreview/title.khth')</label>
				<div class="col-4">
					<input name="gioihan_start" class="start-date form-control flatpickr flatpickr-input ngaybd_bc" id="gioihan_start" type="text" value=""/>
				</div>
				<div class="col-4">
					<input name="gioihan_start" class="start-end form-control flatpickr flatpickr-input ngaybd_bc" id="gioihan_start" type="text" value=""/>
				</div>
			</div>
			@if(Sentinel::inRole('admin') || Sentinel::inRole('operator'))
				<button type="button" class="btn btn-success save">@lang('project/Externalreview/title.luu')</button>
			@endif

	</div>
		
	<!-- modal nhân sự thực hiện -->
                <div class="modal inmodal fade" id="nhanSuThucHienModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex flex-row-reverse">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">@lang('project/Selfassessment/title.nsth')</h4>
                            </div>
                            <div class="text-center m-auto d-flex align-items-center mt-3">
                            	<input type="text" class="search form-control" id="searchInput" placeholder="Tìm kiếm">
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="list-group exchangeList_cb" data-target="#nhanSuThucHienAll"
                                             id="nhanSuThucHienList" d-form="#nhanSuThucHienForm" d-name="ns_thuchien">
                                             <b class="btn btn-primary">@lang('project/Selfassessment/title.nscb')</b>
                                             <div class="appen">
                                             	
                                             </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-2 text-center justify-content-center">
                                        <button class="btn btn-default"><i class="fas fa-arrows-alt-h"></i></button>
                                    </div>
                                    <div class="col-lg-5">

                                        <div class="list-group exchangeList_th" data-target="#nhanSuThucHienList"
                                             id="nhanSuThucHienAll">
                                            <b class="btn btn-primary">@lang('project/Selfassessment/title.dsns')</b>
                                            <div class="append_ns">
	                                            @foreach($data as $nhansu)
	                                            	<div class="convertir">
		                                            	<div class="border text-center" id="{{$nhansu->id}}">
		                                            		<strong class="nhansu_th">{{$nhansu->name}}</strong>
		                                            		<p class="">{{$nhansu->ten_donvi}}</p>
		                                            	</div>
		                                            </div>
	                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">@lang('project/Selfassessment/title.dong')</button>
                            </div>
                        </div>
                    </div>
                </div>
</section>
@stop





{{-- page level scripts --}}
@section('footer_scripts')

<script>

	$(".start-date").flatpickr({
        dateFormat: 'd-m-Y',
    });

	$(".start-end").flatpickr({
        dateFormat: 'd-m-Y',
    });

    $(function(){

	    $('#select2').select2({

	    	theme: "bootstrap-5",
	        selectionCssClass: "select2--small",
	        dropdownCssClass: "select2--small",
	        // dropdownAutoWidth: false,
	        // dropdownParent: $('#parentDiv'),
	    });
	   	
	   	$('#select2_tt').select2({

	    	theme: "bootstrap-5",
	        selectionCssClass: "select2--small",
	        dropdownCssClass: "select2--small",
	        // dropdownAutoWidth: false,
	        // dropdownParent: $('#parentDiv'),
	    });
	 	// const ps = new PerfectScrollbar('.scrollbar', {
		//     suppressScrollX: true
		//   });
    })


  
	function update_menhde(){
		console.log('s');
	}
	$('.tienduc').on('click',function(){
		console.log('ssss')
	})

	$('.exchangeList_th').on('click','.convertir',function(){
		let add = $(this).html();
		$(this).remove();
		$('.appen').append(`<div class="convertir">${add}</div>`);
	});

	$('.exchangeList_cb').on('click','.convertir',function(){
		let add2 = $(this).html();
		$(this).remove();
		$('.append_ns').append(`<div class="convertir">${add2}</div>`);
	})

	$(document).ready(function() {
	  $("#searchInput").on("keyup", function() {
	    var query = $(this).val().toLowerCase();
	    $('.append_ns .nhansu_th').each(function() {
	      var text = $(this).text().toLowerCase();
	      
	      if (text.indexOf(query) === -1) {
	        $(this).parent().hide();
	      } else {
	        $(this).parent().show();
	      }
	    });


	  });

	  $("#searchInput").on("keyup", function() {
	    var query = $(this).val().toLowerCase();
	    $('.appen strong').each(function() {
	      var text = $(this).text().toLowerCase();
	     
	      if (text.indexOf(query) === -1) {
	        $(this).parent().hide();
	      } else {
	        $(this).parent().show();
	      }
	    });

	  });
	});

</script>
@stop