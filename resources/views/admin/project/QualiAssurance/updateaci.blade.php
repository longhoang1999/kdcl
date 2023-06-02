@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.cnhd')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<style>
    #modalCreateHD .select2-container{
        width: 100% !important;
    }
    #modalCreateHD p{
        margin-bottom: 0;
    }
    .block_item{
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .block_item p{
        width: 15%;
        margin-bottom: 0;
    }
    .block_item input{
        flex: 1;
    }
    .block_render{
        padding-top: 10px;
        border-top: 1px dashed #d6d6d6;
    }
    .select2-container--bootstrap5 .select2-selection__clear{
        right: 1rem !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/QualiAssurance/title.cnhd')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <h4>@lang('project/QualiAssurance/title.tkiem')</h4>
            <div class="container-fuild mt-3 pl-5 ">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" placeholder="@lang('project/QualiAssurance/title.noidung')" class="form-control " id="search_content">
                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col-md-2">
                        <select class="form-control search_year" id="search_year">
                            <option></option>
                            @for($i = intVal(date('Y')) ;$i >= 2017 ;$i--)
                                <option>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control search_mcsl" id="search_mcsl">
                            <option></option>
                            @foreach ($linhvuc as $item)
                                <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-block" id="btn-search" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Standard/title.timkiem')"><i class="bi bi-search" style="font-size: 35px;color: #009ef7;"></i></button>
                    </div>
                   
                    <div class="col-md-1">
                        <button class="btn btn-benchmark mr-2" type="button" data-toggle="modal" data-target="#modalCreateHD" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.themhd')">
                            <i class="bi bi-plus-square" style="font-size: 35px;color: #50cd89;"></i>
                        </button>
                    </div>
                   
                    <div class="col-md-1">
                        <a class="btn btn-benchmark mr-2" href="{{route('admin.dambaochatluong.updateaci.exceltaction')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/QualiAssurance/title.xuat_excel')">
                            <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
                        </a>
                    </div>
                </div>
            </div>
        <h3 class="mt-3">@lang('project/QualiAssurance/title.dshd')</h3>
        <div class="item-group-button right-block mb-2">

        </div>
        <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
             <tr>
                <th >@lang('project/QualiAssurance/title.nam')</th>
                <th >@lang('project/QualiAssurance/title.lvuc')</th>
                <th >@lang('project/QualiAssurance/title.hoatd')</th>
                <th >@lang('project/QualiAssurance/title.mcyc')</th>
                <th >@lang('project/QualiAssurance/title.hanhd')</th>
             </tr>
            </thead>
            <tbody>  
            </tbody>                
        </table> 
    </div>
</section>

<!-- modal -->
<div class="modal fade" id="modalCreateHD" tabindex="-1" role="dialog" aria-labelledby="modalCreateHDLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateHDLabel">
                    @lang('project/QualiAssurance/title.themhd')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.dambaochatluong.updateaci.createAction') }}" method="post" class="form-createAc">
                @csrf
                <div class="modal-body">
                    <div class="container-fuild">
                        <div class="row">
                            <div class="col-md-4">
                                <p>@lang('project/QualiAssurance/title.nam')</p>
                                <select class="form-control search_year" name="year">
                                    <option value=""></option>
                                    @for($i = intVal(date('Y')) ;$i >= 2017 ;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-8">
                                <p>@lang('project/QualiAssurance/title.lvuc')</p>
                                <select class="form-control search_mcsl" name="id_mcsl">
                                    <option value=""></option>
                                    @foreach ($linhvuc as $item)
                                        <option value="{{ $item->id }}">{{ $item->mo_ta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <p>@lang('project/QualiAssurance/title.soluong')</p>
                                <input type="number" class="form-control " id="input_soluong">
                            </div>
                        </div>
                    </div>
                    <div class="block_render mt-5 pl-5 pr-5">
                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-submit">
                        @lang('project/QualiAssurance/title.themhd')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteLabel">
                    @lang('project/QualiAssurance/title.thongbao')
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="badge ">
                    @lang('project/QualiAssurance/message.error.hoixoaTc')
                </span>
                <br>
                <span class="badge ">
                    @lang('project/QualiAssurance/message.error.khoantac')
                </span>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="btn-delete-human">
                    @lang('project/QualiAssurance/title.xoa')
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    @lang('project/QualiAssurance/title.huy')
                </button>
            </div>
        </div>
    </div>
</div>
<!-- /Kết thúc page trang -->
    
    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script> 
    $("#btn-submit").click(function() {
        $(".form-createAc").submit();
    })


    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax:  {
                url: "{!! route('admin.dambaochatluong.updateaci.viewAction') !!}",
                type: 'POST',
                data: {
                    'content' : function() { return $("#search_content").val() },
                    'year'       : function() { return $("#search_year").val() },
                    'mcsl'    : function() { return $("#search_mcsl").val() }
                },
            },
            columns: [
                { data: 'year'},
                { data: 'mo_ta' },
                { data: 'noi_dung', },
                { data: 'mcyc' },
                { data: 'actions' ,className: 'action'},
            ],
            order: [[1, 'asc']],
        });
    });
</script>
<script>
    $(".search_year").select2({
        placeholder: "@lang('project/QualiAssurance/title.nam')",
        allowClear: true
    });
    $(".search_mcsl").select2({
        placeholder: "@lang('project/QualiAssurance/title.lclv')",
        allowClear: true
    });
    
    
    $("#btn-search").click(function() {
        table.ajax.reload();
    })

    $("#input_soluong").change(function() {
        if($(this).val() > 0){
            $(".block_render").empty();
            for(let i = 1; i <= $(this).val() ; i++){
                let item = ` 
                    <div class="block_item">
                        <p>@lang('project/QualiAssurance/title.hoatdong') ${i}: </p>
                        <input type="text" class="form-control " name="content[]">
                    </div>

                 `;
                $(".block_render").append(item)
            }
        }else{
            alert("@lang('project/QualiAssurance/title.vlndgt')")
        }
        
        
    })

    // let a = $(".block_render").find("input[name='content[]']");
    // for(let i = 0; i< a.length; i++){
    //     a[i].on('change', function(e){
    //         for(let j = 0; j< a.length; j++){
    //             if(e.target.value == a[j].value){
    //                 alert("trung")
    //             }
    //         }
            
    //     })
    // }


    $('#modalDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') 
        console.log(id)
        var route = "{{ route('admin.dambaochatluong.updateaci.deleteAction') }}" + "?id_delete=" + id;
        var modal = $(this);
        modal.find('#btn-delete-human').attr('href' , route);
    })
    $.ajaxSetup({
        		headers: {
            			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}
   		 });
</script>

@stop
