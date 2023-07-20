@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/ImportdataExcel/title.cktcnh')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" href="{{ asset('css/project/Standard/standard.css') }}">
<link href="{{ asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"  rel="stylesheet" media="screen"/>
<link href="{{ asset('css/pages/editor.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .wrraper-table{
        padding: 2rem;
        background: white;
        border-radius: 5px;
        box-shadow: 0 0 12px grey;
    }
    .table td:first-child{
        padding-left: 0.75rem !important ;
    }
</style>

@stop

@section('title_page')
    @lang('project/ImportdataExcel/title.cktcnh')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            <a href="{{ route('admin.importdata.cktcnh.exportCktcnh') }}" class="btn btn-benchmark mr-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/Selfassessment/title.xuat_excel')">
                <i class="bi bi-file-earmark-excel " style="font-size: 35px;color: #50cd89;"></i>
            </a>
            <button class="btn" data-toggle="modal" data-target="#modalDeleteAll__" data-nametable="excel_import_tcnh" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('project/ImportdataExcel/title.xoatatca')">
                <i class="bi bi-trash" style="font-size: 35px;color: red;"></i>
            </button>
        </div>
        
        <div class="wrraper-table">
            <select name="" id="year" class="form-control">
                <option value="" hidden>-- @lang('project/ImportdataExcel/title.cnck')</option>
                @for($i = intVal(date('Y')) + 1 ;$i >= 2017; $i--)
                    <option  value="{{ $i }}" 
                        @if($i == intVal(date('Y')))
                            selected
                        @endif
                    >{{$i}}</option>
                @endfor
            </select>
            <br>
            <table class="table table-striped table-bordered" id="table" width="100%">
                <thead>
                 <tr>
                    <th>
                        @lang('project/ImportdataExcel/title.stt')
                    </th>
                    <th>
                        @lang('project/ImportdataExcel/title.noidung')
                    </th>
                    <th>
                        @lang('project/ImportdataExcel/title.xemct')
                    </th>
                 </tr>
                </thead>
                <tbody>  
                    <tr>
                        <td>I</td>
                        <td>Học phí chính quy chương trình đại trà</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tiến sĩ</td>
                        <td>
                            <button data-p="I" data-c="1" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Thạc sỹ</td>
                        <td>
                            <button data-p="I" data-c="2" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Đại học</td>
                        <td>
                            <button data-p="I" data-c="3" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Cao đẳng sư phạm</td>
                        <td>
                            <button data-p="I" data-c="4" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Trung cấp sư phạm</td>
                        <td>
                            <button data-p="I" data-c="5" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>II</td>
                        <td>Học phí chính quy chương trình khác</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tiến sĩ</td>
                        <td>
                            <button data-p="II" data-c="1" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Thạc sỹ</td>
                        <td>
                            <button data-p="II" data-c="2" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Đại học</td>
                        <td>
                            <button data-p="II" data-c="3" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Cao đẳng sư phạm</td>
                        <td>
                            <button data-p="II" data-c="4" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Trung cấp sư phạm</td>
                        <td>
                            <button data-p="II" data-c="5" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>III</td>
                        <td>Học phí hình thức vừa học vừa làm</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Đại học</td>
                        <td>
                            <button data-p="III" data-c="3" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Cao đẳng sư phạm</td>
                        <td>
                            <button data-p="III" data-c="4" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Trung cấp sư phạm</td>
                        <td>
                            <button data-p="III" data-c="5" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>IV</td>
                        <td>Tổng thu năm</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Từ ngân sách</td>
                        <td>
                            <button data-p="IV" data-c="6" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Từ học phí</td>
                        <td>
                            <button data-p="IV" data-c="7" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Từ nghiên cứu khoa học và chuyển giao công nghệ</td>
                        <td>
                            <button data-p="IV" data-c="8" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Từ nguồn hợp pháp khác</td>
                        <td>
                            <button data-p="IV" data-c="9" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Từ nguồn sản xuất dịch vụ</td>
                        <td>
                            <button data-p="IV" data-c="10" class="btn btn-info btn-show" >Xem chi tiết</button>
                        </td>
                    </tr>
                </tbody>                
            </table>
        </div>
    </div>
</section>
<!-- /Kết thúc page trang -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xem chi tiết</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fuild ">
            <div class="row">
                <div class="col-md-5">
                    Năm: <span class="year-info"></span> <br>
                    Nội dung: <span class="content2"></span> <br>
                    <span class="content2-child"></span>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn_add">Thêm mới</button>
                </div>
            </div>
            <div class="add_content"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-update">Cập nhật</button>
      </div>
    </div>
  </div>
</div>

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>


<script>
    
    $(".btn-show").click(function() {
        let parent =$(this).attr("data-p");
        let child = $(this).attr("data-c");
        if(parent == "I"){
            if(child == "1"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("I: Học phí chính quy chương trình đại trà")
                $(".content2-child").text("1. Tiến sĩ")
                $("#exampleModal").modal("show")
            }
            if(child == "2"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("I: Học phí chính quy chương trình đại trà")
                $(".content2-child").text("2. Thạc sỹ")
                $("#exampleModal").modal("show")
            }
            if(child == "3"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("I: Học phí chính quy chương trình đại trà")
                $(".content2-child").text("3. Đại học")
                $("#exampleModal").modal("show")
            }
            if(child == "4"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("I: Học phí chính quy chương trình đại trà")
                $(".content2-child").text("4. Cao đẳng sư phạm")
                $("#exampleModal").modal("show")
            }
            if(child == "5"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("I: Học phí chính quy chương trình đại trà")
                $(".content2-child").text("5. Trung tâm sư phạm")
                $("#exampleModal").modal("show")
            }
        } 
        if(parent == "II"){
            if(child == "1"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("II: Học phí chính quy chương trình khác")
                $(".content2-child").text("1. Tiến sĩ")
                $("#exampleModal").modal("show")
            }
            if(child == "2"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("II: Học phí chính quy chương trình khác")
                $(".content2-child").text("2. Thạc sỹ")
                $("#exampleModal").modal("show")
            }
            if(child == "3"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("II: Học phí chính quy chương trình khác")
                $(".content2-child").text("3. Đại học")
                $("#exampleModal").modal("show")
            }
            if(child == "4"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("II: Học phí chính quy chương trình khác")
                $(".content2-child").text("4. Cao đẳng sư phạm")
                $("#exampleModal").modal("show")
            }
            if(child == "5"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("II: Học phí chính quy chương trình khác")
                $(".content2-child").text("5. Trung tâm sư phạm")
                $("#exampleModal").modal("show")
            }
        } 
        if(parent == "III"){
            if(child == "3"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("III: Học phí hình thức vừa học vừa làm")
                $(".content2-child").text("1. Đại học")
                $("#exampleModal").modal("show")
            }
            if(child == "4"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("III: Học phí hình thức vừa học vừa làm")
                $(".content2-child").text("2. Cao đẳng sư phạm")
                $("#exampleModal").modal("show")
            }
            if(child == "5"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("III: Học phí hình thức vừa học vừa làm")
                $(".content2-child").text("3. Trung tâm sư phạm")
                $("#exampleModal").modal("show")
            }
        } 
        if(parent == "IV"){
            if(child == "6"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("IV: Tổng thu năm")
                $(".content2-child").text("1. Từ ngân sách")
                $("#exampleModal").modal("show")
            }
            if(child == "7"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("IV: Tổng thu năm")
                $(".content2-child").text("2. Từ học phí")
                $("#exampleModal").modal("show")
            }
            if(child == "8"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("IV: Tổng thu năm")
                $(".content2-child").text("3. Từ nghiên cứu khoa học và chuyển giao công nghệ")
                $("#exampleModal").modal("show")
            }
            if(child == "9"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("IV: Tổng thu năm")
                $(".content2-child").text("4. Từ nguồn hợp pháp khác")
                $("#exampleModal").modal("show")
            }
            if(child == "10"){
                loaddata(parent, child);
                $(".year-info").text($("#year").val())
                $(".content2").text("IV: Tổng thu năm")
                $(".content2-child").text("5. Từ nguồn sản xuất dịch vụ")
                $("#exampleModal").modal("show")
            }
        } 
    })
    var parentGloble;
    var childGloble;

    function loaddata(parent, child){
        parentGloble = parent;
        childGloble = child;

        $(".add_content").empty();
        let data = {
            parentGloble, childGloble, 
            'year': $("#year").val(),
        }
        let loadData = "{{ route('admin.importdata.cktcnh.loaddata') }}";
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                data.forEach((item, index) => {
                    let UI;
                    if(parentGloble == "IV" || childGloble == "4" || childGloble == "5"){
                        UI = ` 
                            <div class="row">
                                <div class="col-md-3">
                                    Đơn vị tính: <br>
                                    <select class="form-control donvitinh" value='${item.donvitinh}'>
                                        <option value="1">Triệu đồng/năm</option>
                                        <option value="2">Tỷ đồng</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    @lang('project/ImportdataExcel/title.hp1nam'): <br>
                                    <input type="number" class="form-control hp1nam" value="${item.hocphi_1nam}">
                                </div>
                                <div class="col-md-3">
                                    @lang('project/ImportdataExcel/title.hpkhoa'): <br>
                                    <input type="number" class="form-control hpkhoa" value="${item.hocphi_cakhoa}">
                                </div>
                            </div>
                         `;
                        $(".btn_add").hide()

                    }else{
                        UI = ` 
                            <div class="row">
                                <div class="col-md-3">
                                    Khối ngành: <br>
                                    <input type="text" class="form-control khoinganh" value='${item.ten_khoinganh}'>
                                </div>
                                <div class="col-md-3">
                                    Đơn vị tính: <br>
                                    <select class="form-control donvitinh" value='${item.donvitinh}'>
                                        <option value="1">Triệu đồng/năm</option>
                                        <option value="2">Tỷ đồng</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    @lang('project/ImportdataExcel/title.hp1nam'): <br>
                                    <input type="number" class="form-control hp1nam" value="${item.hocphi_1nam}">
                                </div>
                                <div class="col-md-3">
                                    @lang('project/ImportdataExcel/title.hpkhoa'): <br>
                                    <input type="number" class="form-control hpkhoa" value="${item.hocphi_cakhoa}">
                                </div>
                            </div>
                         `
                    }
                    
                     $(".add_content").append(UI)
                })
            })
    }

    $('#exampleModal').on('show.bs.modal', function (event) {
        $(".btn_add").show();
    })

    $(".btn_add").click(function() {
        let UI = "";
        if(parentGloble == "IV" || childGloble == "4" || childGloble == "5"){
            UI = ` 
                <div class="row">
                    <div class="col-md-4">
                        Đơn vị tính: <br>
                        <select class="form-control donvitinh">
                            <option value="1">Triệu đồng/năm</option>
                            <option value="2">Tỷ đồng</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        @lang('project/ImportdataExcel/title.hp1nam'): <br>
                        <input type="number" class="form-control hp1nam">
                    </div>
                    <div class="col-md-4">
                        @lang('project/ImportdataExcel/title.hpkhoa'): <br>
                        <input type="number" class="form-control hpkhoa">
                    </div>
                </div>
             `;
            $(".btn_add").hide()
         }else{
            UI = ` 
                <div class="row">
                    <div class="col-md-3">
                        Khối ngành: <br>
                        <input type="text" class="form-control khoinganh">
                    </div>
                    <div class="col-md-3">
                        Đơn vị tính: <br>
                        <select class="form-control donvitinh">
                            <option value="1">Triệu đồng/năm</option>
                            <option value="2">Tỷ đồng</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        @lang('project/ImportdataExcel/title.hp1nam'): <br>
                        <input type="number" class="form-control hp1nam">
                    </div>
                    <div class="col-md-3">
                        @lang('project/ImportdataExcel/title.hpkhoa'): <br>
                        <input type="number" class="form-control hpkhoa">
                    </div>
                </div>
             `;
         }
         $(".add_content").append(UI)
    })

    $(".btn-update").click(function(){
        let khoinganh = document.querySelectorAll(".khoinganh")
        let khoinganhArr = []; 
        if(khoinganh.length != 0){
            for(let i = 0; i< khoinganh.length; i++){
                khoinganhArr.push(khoinganh[i].value)
            }
        }
        
        
        let donvitinh = document.querySelectorAll(".donvitinh");
        let donvitinhArr = []; 
        for(let i = 0; i< donvitinh.length; i++){
            donvitinhArr.push(donvitinh[i].value)
        }

        let hp1nam = document.querySelectorAll(".hp1nam");
        let hp1namArr = []; 
        for(let i = 0; i< hp1nam.length; i++){
            hp1namArr.push(hp1nam[i].value)
        }

        let hpkhoa = document.querySelectorAll(".hpkhoa");
        let hpkhoaArr = []; 
        for(let i = 0; i< hpkhoa.length; i++){
            hpkhoaArr.push(hpkhoa[i].value)
        }

        let data = {
            'year': $("#year").val(),
            'childGloble': childGloble,
            'parentGloble': parentGloble,
            'khoinganhArr': khoinganhArr,
            'donvitinhArr': donvitinhArr,
            'hp1namArr': hp1namArr,
            'hpkhoaArr': hpkhoaArr
        }
        let loadData = "{{ route('admin.importdata.cktcnh.updatedata') }}";
        fetch(loadData, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if(data.mes == "done"){
                    $("#exampleModal").find("button.close").trigger("click");
                }
            })
    })

</script>


@stop
