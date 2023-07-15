@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">
<style>
    .form-control{
        height: 34px;
        appearance: auto !important;
    }
    .select2-container .select2-selection--single{
        height: 43px !important;
    }
</style>
@stop

@section('title_page')
    @lang('project/Selfassessment/title.bctdg')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <h2>
        Nhận xét báo cáo
    </h2>
    <div class="line"></div><br/>
    <div class="form-group" style="background: white;padding: 20px 43px;box-shadow: 2px 2px 11px lightgray;">
           
            <div class="row ">
                <div class="col-md-2 " style="display: flex;justify-content: flex-start;align-items: center;"> <h3 class="mb-3">Tìm kiếm</h3></div>
                <div class="col-md-5">   
                    <select name="" id="select2" class="id_khbc form-control" data-placeholder="Chọn báo cáo">
                        <option value="" hidden></option>
                        @foreach($keHoachBaoCaoList as $keHoachBaoCao)
                            <option value="{{ $keHoachBaoCao->id }}">
                                {{ $keHoachBaoCao->ten_bc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="col-sm-5">
                    <select class="form-control user_id" name="nguoi_tao" id="select_user" data-placeholder="Chọn người viết">
                        <option hidden></option>
                        @foreach($userList as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="search" style="background: none !important; outline: none !important;border: none !important;" title="Tìm kiếm và nhận xét">
                        <i class="bi bi-search" style="color: blue; font-size: 26px;"></i>
                    </button>
                </div> -->
            </div>
    </div>
    <div style="background-color: white;box-shadow: 3px 2px 7px 2px lightgray;">   
         <table class="table table-striped table-bordered" id="table" width="100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu chí</th>
                    <th>Chỉ báo / mốc chuẩn</th>
                    <th>Nội dung nhận xét</th>
                </tr>
            </thead>
            <tbody class="tbodys">                        
            </tbody>                
        </table> 
    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
<script>

    $('.id_khbc').on('change',function(){
        let id_user = $('.user_id').val();
        let id_khbc = $('.id_khbc').val();
        if ($.fn.DataTable.isDataTable('#table')) {
            $('#table').DataTable().destroy();
        }
        table = $('#table').DataTable({
                lengthMenu: [[6, 10, 20, -1], [6, 10, 20, "All"]],
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{!! route('admin.tonghop.dbcl.datafgnb') !!}",
                    type: "POST",
                    data: {
                        id_user: id_user,
                        id_khbc: id_khbc
                    }
                },
                columns: [
                    { data: 'stt', name: 'stt'},
                    { data: 'tctc', name: 'tctc'},
                    { data: 'mo_ta', name: 'mo_ta'},
                    { data: 'nhanxet', name: 'nhanxet'},
             
                ],   
            });
     })

    $(document).ready(function() {
      $('#select2').select2();
      $('#select_user').select2();
    });

</script>
@stop











