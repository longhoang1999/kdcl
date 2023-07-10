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

    div.colspan-3 {
      grid-column: span 3;
    }

    #pills-profile table,tr,th,td{
        padding: 5px;
    }
    #pills-contact table,tr,th,td{
        padding: 5px;
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
        @lang('project/Selfassessment/title.htkhbc')
    </h2>
    <div class="line"></div><br/>

    <ul class="nav nav-pills mb-5 list-css d-flex justify-content-around mt-3" id="pills-tab" role="tablist">
         
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                Tổng quan
            </button>
            
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                Hoàn thành
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                Chưa hoàn thành
            </button>
          </li>
          
    </ul>


    <div class="form-group">
        <div class="row d-flex" style="flex-wrap: nowrap !important;">
            <div class="col-md-5">
                <div class="container-fuild">
                    <h4 class="h4-left">@lang('project/Selfassessment/title.bccv')</h4><br/>
                    <table class="table table-striped table-bordered" id="table" width="100%">
                        <thead>
                            <th width="50"></th>
                            <th>@lang('project/Selfassessment/title.tenbc')</th>
                            <th>@lang('project/Selfassessment/title.loaitieuchuan')</th>
                            <th>@lang('project/Selfassessment/title.nam')</th>
                        </thead>
                        <tbody class="tbodys">                        
                        </tbody>                
                    </table> 


                </div>

            </div>


            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="col-md-7">       
                        <div id="div_showbc" style="margin-left: 20px; padding-bottom: 22px;"></div>
                    </div>
                    <div class="modal" tabindex="-1" role="dialog" id="myModal">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Tiêu chuẩn : </p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" style="width: 55rem !important;padding: 10px;box-shadow: 3px 3px 5px 4px lightgray; border-radius: 5px;">

                    <table class="table_hoanthanh table-striped table-bordered" id="table_hoanthanh" width="100%">
                        <thead>
                            <th>Tiêu chuẩn</th>
                            <th>Tiêu chí</th>
                            <th>Mốc chuẩn / chỉ báo</th>
                            <th>Người viết</th>
                            <th>Trạng thái</th>
                            <th>Ngày hoàn thành</th>
                            <th></th>
                        </thead>
                        <tbody class="tbodys" id="table_showbcht">                        
                        </tbody>                
                    </table> 
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" style="width: 55rem !important;padding: 10px;box-shadow: 3px 3px 6px 7px lightgray;border-radius: 5px;">
                     
                     <table class="table_choanthanh table-striped table-bordered" id="ctable_hoanthanh" width="100%">
                        <thead>
                            <th>Tiêu chuẩn</th>
                            <th>Tiêu chí</th>
                            <th>Mốc chuẩn / chỉ báo</th>
                            <th>Người viết</th>
                            <th>Trạng thái</th>
                            <th>Ngày hoàn thành</th>
                            <th></th>
                        </thead>
                        <tbody class="tbodys" id="table_showbccht">                        
                        </tbody>                
                    </table> 

                </div>
                <!-- <div class="tab-pane fade" id="pills-date" role="tabpanel" aria-labelledby="pills-date-tab">
                    sd
                </div> -->
                
            </div>
            
        </div>
    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
<script>

    function showhidetieuchi(id){
        if($('#btn_tieuchuan_' + id).text() == '-'){
            $('#div_tieuchi_' + id).hide();
            $('#btn_tieuchuan_' + id).text('+');
        }else{
            $('#div_tieuchi_' + id).show();
            $('#btn_tieuchuan_' + id).text('-');
        }
    }

    function selectBC(dat){    
        var textout = '<br/><h4 id="div_showbcs" style="text-align: center;width: 100%;">' + dat.ten_bc + '</h4><br/>';
        var id_khbc = dat.id;
        var name_bc = dat.ten_bc;
        $.ajax({
            url: "{!! route('admin.tonghop.dbcl.data') !!}?id=" + dat.id,
            type: 'GET',
            error: function(err) {

            },            
            
            success: function(data) {
                var texto = `<li class="dd-item">${(data.solieutonghop)?data.solieutonghop:"Không có dữ liệu"}</li>`;
                var texto2;
                var tableht;
                var tabcht;
                texto += `<li class="dd-item">${(data.cosodulieu)?data.cosodulieu:"Không có dữ liệu"}</li>`;
                
                if(data.tieuchuan_tieuchi == 0 || data.tieuchuan_tieuchi == undefined || data.tieuchuan_tieuchi == null){
                    texto += '<div class="alert alert-warning">' + "@lang('project/Selfassessment/message.alert.kocobctc')" + '</div>';
                }else{
                    let temp = 0;
                  
                        texto += data.phan1 ;
                    
                    texto += data.phan2 ;
                    var name_trangthai = '';
                    var testm = '';
                    data.tieuchuan_tieuchi.forEach((value)=>{

                        if(value.mo_ta != null){
                            var css_trangthai = 'css_action_1';
                            var css_color;
                            testm = value.tiendo;
                            texto += '<p class="css_p">'+ '<button class="btn btn-default button_css" id="btn_tieuchuan_'+value.id+'" onclick="showhidetieuchi('+value.id+');return false;"> + </button>' +'<span class="label label-warning span_css"><i class="fas fa-file" style="font-size: 25px;color: #e56f3e;"></i></span>' + 
                            "<span> @lang('project/Selfassessment/title.tc')" +  
                            value.stt_tc + ": &nbsp; </span>" + '<a href="" style="width: 50%;",>' + value.mo_ta + '</a>' + '<strong style="color:red;margin-left: 10px;"">'+testm+'%</strong>' +'</br>'+'</p>';

                            texto += '<div id="div_tieuchi_' + value.id +'" style="display:none">';
                            let dem = value.stt_tc;
                            let dem2 = 1;
                            for(var i = 0; i<value.tieuchi.length;i++){
                                texto += '<p class="tieuchi_css">'+'<span><i class="far fa-calendar-check"></i></span>'+ '<b>'+`&emsp14;&emsp14;&emsp14;&emsp14;&emsp14;${dem} `+'.'+`${dem2++}`+'&nbsp;'+value.tieuchi[i].mo_ta+'</b>'+'<strong style="color:red;margin-left: 10px;"">'+value.tieuchi[i].tiendo+'%</strong>'+'</p>';    
                            }
                            texto += '</div>';
                        }

                        if(value.tiendo == 100){
                            tableht += `<tr>
                                            <td colspan="3">TC ${value.stt_tc} : ${value.mo_ta}</td>
                                            <td>${value.nguoiviet}</td>
                                            <td>${(value.baoCaoTieuChuan)?value.baoCaoTieuChuan.trang_thai_bctc:"Không có dữ liệu"}</td>
                                            <td>${value.ngayhoanthanh}</td>
                                            <td>${value.tiendo}</td>

                                        </tr>`

                            for(var i = 0; i<value.tieuchi.length;i++){
                                tableht += `<tr>
                                            <td></td>
                                            <td colspan="2">${value.stt_tc}.${value.tieuchi[i].stt} : ${value.tieuchi[i].mo_ta}</td>
                                            <td></td>
                                            <td>dangsua</td>
                                            <td></td>
                                            <td>${value.tieuchi[i].tiendo}</td>
                                           
                                        </tr>` 

                                for (var j = 0; j < value.tieuchi[i].kehoachtieuchi.length; j++) {

                                    for(var t = 0 ; t < value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde.length; t++){
                                        tableht += `<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Mệnh đề ${value.stt_tc}.${value.tieuchi[i].stt}.${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.stt} : ${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.mo_ta}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.name}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.trang_thai}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].ngayht}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].tiendo}</td>
                                                </tr>`;
                                    }
                                    
                                }
                            }
                        }else{
                            tabcht += `<tr>
                                            <td colspan="3">TC ${value.stt_tc} : ${value.mo_ta}</td>
                                            <td>${value.nguoiviet}</td>
                                            <td>${(value.baoCaoTieuChuan)?value.baoCaoTieuChuan.trang_thai_bctc:"Không có dữ liệu"}</td>
                                            <td>${value.ngayhoanthanh}</td>
                                            <td style="color:red;width: 10%;">${value.tiendo} %</td>

                                        </tr>`

                            for(var i = 0; i<value.tieuchi.length;i++){
                                tabcht += `<tr>
                                            <td></td>
                                            <td colspan="2">${value.stt_tc}.${value.tieuchi[i].stt} : ${value.tieuchi[i].mo_ta}</td>
                                            <td></td>
                                            <td>dangsua</td>
                                            <td></td>
                                            <td style="color:red;width: 10%;">${value.tieuchi[i].tiendo} %</td>
                                           
                                        </tr>` 

                                for (var j = 0; j < value.tieuchi[i].kehoachtieuchi.length; j++) {

                                    for(var t = 0 ; t < value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde.length; t++){
                                        tabcht += `<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Mệnh đề ${value.stt_tc}.${value.tieuchi[i].stt}.${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.stt} : ${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.mo_ta}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.name}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].baocaomenhde.trang_thai}</td>
                                                    <td>${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].ngayht}</td>
                                                    <td style="color:red;width: 10%;">${value.tieuchi[i].kehoachtieuchi[j].kehoachmenhde[t].tiendo} %</td>
                                                </tr>`;
                                    }
                                    
                                }
                            }
                        }  



                    })
                 
                    texto += data.phan3;
                 
                }
                $("#div_showbc").empty();
                $('#div_showbc').html(textout);    
                $('#div_showbc').append(texto + '<br/>');
                $('#div_showbc').css({'background' : 'white','box-shadow' : '0 0 12px #ababab'});          
                $("#div_showbcht").empty();
                $('#table_showbcht').html(tableht);    
                $('#table_showbccht').html(tabcht);    
                $('#div_showbcht').css({'background' : 'white','box-shadow' : '0 0 12px #ababab'});           
            }
        });

    }


    $(function () {
        table = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true, 
            searching:false,
            ajax: "{!! route('admin.tonghop.dbcl.data') !!}",
            order: [],  
            columns: [
                { data: 'actions', orderable: false, searchable: false },
                { data: 'ten_bc', name: 'ten_bc' },
                { data: 'loai_tieuchuan', name: 'loai_tieuchuan' },
                { data: 'nam', name: 'nam' },
            ],           
        });

        $('#table tbody').on('click', 'tr', function () {            
            var data = table.row( this ).data();    
            //console.log(data)    
            if(data != undefined){
                $('#selectbc_' + data.id).prop('checked', true);
                selectBC(data);
             
            }   
        });
    });


    // $('#table .tbodys').on('click', 'tr', function () {
    //     let idkh_bc = $(this).find('input').attr('attr');
    //     if (typeof newTable !== 'undefined') {
    //         newTable.destroy();
    //     }
    //     newTable = $('#table_hoanthanh').DataTable({
    //         responsive: true,
    //         processing: true,
    //         serverSide: true,
    //         searching: false,
    //         ajax: {
    //             url: "{!! route('admin.tonghop.dbcl.bacaohoanthanh') !!}",
    //             type: "POST",
    //             data: {
    //                 id_bc: idkh_bc
    //             }
    //         },
    //         order: [],
    //         columns: [
    //             {
    //                 data: null,
    //                 className: 'details-control',
    //                 orderable: false,
    //                 defaultContent: '',
    //                 createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
    //                     $(cell).attr('colspan', 3);
    //                 },
    //                 render: function (data, type, row, meta) {
    //                     return data.motawith;
    //                 }
    //             },
    //             { data: 'nguoiviet', name: 'nguoiviet' },
    //             { data: 'trang_thai', name: 'trang_thai' },
    //             { data: 'ngayhoanthanh', name: 'ngayhoanthanh' },

                
    //         ],
    //         createdRow: function (row, data, dataIndex) {
    //             $(row).addClass('parent-row');
    //         }
    //     });
    // });
// $('#table .tbodys').on('click', 'tr', function () {
//     let idkh_bc = $(this).find('input').attr('attr');
//     if (typeof newTable !== 'undefined') {
//         newTable.destroy();
//     }
//     newTable = $('#table_hoanthanh').DataTable({
//         responsive: true,
//         processing: true,
//         serverSide: true,
//         searching: false,
//         ajax: {
//             url: "{!! route('admin.tonghop.dbcl.bacaohoanthanh') !!}",
//             type: "POST",
//             data: {
//                 id_bc: idkh_bc
//             }
//         },
//         order: [],
//         columns: [
//             {
//                 data: null,
//                 className: 'details-control',
//                 orderable: false,
//                 defaultContent: '',
//                 createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
//                     $(cell).attr('colspan', 3);
//                 },
//                 render: function (data, type, row, meta) {
//                     return data.motawith;
//                 }
//             },
//             { data: 'nguoiviet', name: 'nguoiviet' },
//             { data: 'trang_thai', name: 'trang_thai' },
//             { data: 'ngayhoanthanh', name: 'ngayhoanthanh' },
//             { data: 'tieuchi', name: 'tieuchi', visible: false }, // Ẩn cột "tieuchi"
//         ],
//         createdRow: function (row, data, dataIndex) {
//             $(row).addClass('parent-row');
//             $(row).after('<tr><td colspan="4">' + data.tieuchi + '</td></tr>'); // Append dữ liệu "tieuchi" vào sau mỗi bản ghi
//         }
//     });
// });













</script>
@stop











