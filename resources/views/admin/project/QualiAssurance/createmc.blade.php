@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/QualiAssurance/title.themmc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link href="{{ asset('vendors/flatpickr/css/flatpickr.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('css/pages/adv_date_pickers.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="{{ asset('css/project/QualiAssurance/qualiassurance.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
<link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/app.css') }}" />
<link href="{{ asset('css/pages/tagsinput.css') }}" rel="stylesheet" />
<style>
    .form-standard{
        background-color: #fff;
        padding: 15px;
        margin-bottom: 35px;
    }
    .form-standard form .row{
        margin-top: 5px;
    }
    .block-flex{
        display: flex;
    }
    .block-flex button{
        width: 10rem;
        margin-left: 15px;
    }
    input.bh-date{
        height: 32px;
        width: 100%;
    }
    #img_name{
        font-weight: bold;
        font-style: italic;
        margin-bottom: 0;
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
    <div class="container-fuild form-standard">
        <div class="row">
            <div class="col-md-4">
                <strong>@lang('project/QualiAssurance/title.namcapnhat'): </strong>
                <span>{{ $hoatDongNhomParent->year }}</span>
            </div>
            <div class="col-md-8">
                <strong>@lang('project/QualiAssurance/title.lvuc'): </strong>
                <span>{{ $linhvuc->mo_ta }}</span>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <strong>@lang('project/QualiAssurance/title.hoatdong'): </strong>
                <span>{{ $hoatDongNhomParent->noi_dung }}</span>
            </div>
            <div class="col-md-8">
                <strong>@lang('project/QualiAssurance/title.mcyc'): </strong>
                <span>
                    {{ $hdn->noi_dung }}
                </span>
            </div>
        </div>

        <form action="" method="post" class="mt-5">
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.tieude'): </strong>
                    <div class="block-flex">
                        <select class="form-control h-2rem" id="minhchung_id">
                        </select>
                        <button class="btn btn-info">@lang('project/QualiAssurance/title.tmoi')</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.tyeu'): </strong>
                    <textarea placeholder="@lang('project/QualiAssurance/title.tyeu')" class="form-control minhChungInput" name="trich_yeu" ></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 bs-example">
                    <strong>@lang('project/QualiAssurance/title.tukhoa'): </strong>
                    <input type="text" value=""  data-role="tagsinput" id="inputTag" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.nbh'): </strong>
                    <input type="text" class="form-control h-2rem" name="noi_banhanh">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.sohieu'): </strong>
                    <input type="text" class="form-control h-2rem" name="sohieu">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.ngaybh'): </strong>
                    <input name="ngay_ban_hanh" class="bh-date form-control flatpickr flatpickr-input" data-mindate="today" id="bhDate" type="text" placeholder="@lang('project/QualiAssurance/title.ngaybh')">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.dcluu'): </strong>
                    <input type="text" class="form-control h-2rem" placeholder="Khu A, Tòa A1, Phòng 201, Tủ B2" name="address">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.nqly'): </strong>
                    <select class="form-control h-2rem" id="nguoi_quan_ly">
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>URL: </strong>
                    <input type="text" class="form-control h-2rem" placeholder="http://">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.filetl'): </strong>
                    <br>
                    <input type="file" hidden id="file" accept="image/jpeg,image/gif,image/png,application/pdf" onchange="readUrl(this)">
                    <button type="button" class="btn btn-success" id="btn-open-file">
                        @lang('project/QualiAssurance/title.chontep')
                    </button>
                    <span id="uploadProcess">(Chỉ chọn tệp ẢNH hoặc PDF)</span>
                    <p id="img_name">@lang('project/QualiAssurance/title.openfile')</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-8">
                    <strong>@lang('project/QualiAssurance/title.congkhai'): </strong>
                    <input type="checkbox" id="congkhai" >
                    <label for="congkhai">@lang('project/QualiAssurance/title.ckmc')</label>
                </div>
            </div>
            <hr>
            <button type="button" class="btn btn-success">@lang('project/QualiAssurance/title.lmc')</button>
        </form>
    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>

<!-- modal -->
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script src="{{ asset('vendors/pickadate/js/picker.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.date.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/pickadate/js/picker.time.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/flatpickr/js/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/airDatepicker/js/datepicker.en.js') }}" type="text/javascript"></script>

<script src="{{ asset('vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"  type="text/javascript"></script>
<script src="{{ asset('vendors/typeahead.js/js/typeahead.bundle.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('vendors/typeahead.js/js/bloodhound.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('js/pages/Categorizing_tags.js') }}"  type="text/javascript"></script>

<script>
    $('#minhchung_id').select2({
        ajax: {
            url: "{{ route('admin.dambaochatluong.updateaci.getDataMc') }}",
            dataType: 'json',
            delay: 400,
            placeholder: 'Tìm kiếm minh chứng',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                resultList = $.map(data.data, function (item) {
                    return {
                        'text': item.tieu_de,
                        'id': item.id,
                        'data': item
                    }
                });
                return {
                    results: resultList,
                    pagination: {
                        more: (params.page * 15) < data.total,
                    }
                };
            },
        }
    });

    $('#nguoi_quan_ly').select2({
        ajax: {
            url: "{{ route('admin.dambaochatluong.updateaci.getListUser') }}",
            dataType: 'json',
            delay: 400,
            placeholder: 'Tìm kiếm người quản lý',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                resultList = $.map(data.data, function (item) {
                    return {
                        text: item.name,
                        id: item.id,
                    }
                });
                return {
                    results: resultList,
                    pagination: {
                        more: (params.page * 15) < data.total,
                    }
                };
            },
        }
    });
    
    flatpickr('.flatpickr', {
        minDate: 'today',
        dateFormat: 'd-m-Y',
    });


    $("#btn-open-file").click(function() {
        $("#file").click();
    })

    function readUrl(input) {  
      if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          let imgData = e.target.result;
          let imgName = input.files[0].name;
          input.setAttribute("data-title", imgName);
          $('#img_name').html(imgName);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $('#minhchung_id').on("change",function () {
        var minhChung = $(this).select2('data')[0].data;
        console.log(minhChung);
        $('input[name=address]').val(minhChung.address);
        $('textarea[name=trich_yeu]').val(minhChung.trich_yeu);
        $('input[name=noi_banhanh]').val(minhChung.noi_banhanh);
        $('input[name=sohieu]').val(minhChung.sohieu);
        $('input[name=ngay_ban_hanh]').val(minhChung.ng_bh);
        $('input[name=url]').val(minhChung.url);
        $('#uploadProcess').addClass("text-success").html('<i class="fas fa-check-circle"></i> '+minhChung.ten_file);
        $(".minhChungInput").attr("readonly","readonly");
        if($('#nguoi_quan_ly').data('select2')){
            $('#nguoi_quan_ly').select2("destroy");
        }
        $('#nguoi_quan_ly').html('<option value="'+minhChung.nguoi_quan_ly+'" selected>'+minhChung.ten_quan_ly+'</option>');
    });

    // từ khóa
    var minhchungtags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: "{{ route('admin.dambaochatluong.updateaci.getListTag') }}",
            filter: function(list) {
                return $.map(list, function(minhchungtag) {
                    return { name: minhchungtag };
                });
            },
        },
    });
    minhchungtags.initialize();

    var elt = $('#inputTag');
    elt.tagsinput({
        typeaheadjs: {
            name: 'minhchungtags',
            displayKey: 'name',
            valueKey: 'name',
            source: minhchungtags.ttAdapter(),
        },
    });
</script>

@stop
