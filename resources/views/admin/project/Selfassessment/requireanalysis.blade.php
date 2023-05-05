@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.bctdg')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

@stop

@section('title_page')
    @lang('project/Selfassessment/title.ptyc')
@stop
@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <div class="form pl-5 pr-5">
        <div class="block-form">
            <label for="select-report">
                @lang('project/Selfassessment/title.baocao')
            </label>
            <select name="" id="select-report" class="form-control">
                <option value="" hidden></option>
                @foreach($kehoach_baocao as $khbc)
                    <option value="{{ $khbc->id }}">{{ $khbc->ten_bc }}</option>
                @endforeach
            </select>
        </div>
        <div class="block-form">
            <label for="standard">
                @lang('project/Selfassessment/title.tctchi')
            </label>
            <select name="" id="standard" class="form-control">
                <option value="" hidden></option>
            </select>
            <select name="" id="criteria" class="form-control">
                <option value="" hidden></option>
            </select>
        </div>
        <button class="btn btn-primary" id="btn-search">
            @lang('project/Selfassessment/title.timkiem')
        </button>
    </div>
</section>

<section class="content-body pl-5 pr-5">
    <h3>@lang('project/Selfassessment/title.qlmcctt')</h3>
    <div class="block-mana">
        
    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript">
        $("#select-report").select2({
            placeholder: "@lang('project/Selfassessment/title.lcbc')"
        })
        $("#standard").select2({
            placeholder: "@lang('project/Selfassessment/title.lctc')"
        })
        $("#criteria").select2({
            placeholder: "@lang('project/Selfassessment/title.lctchi')"
        })
        $('#select-report').on('change', function (e) {
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_report=" + $(this).val();
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.kehoach_tieuchuan != undefined){
                        $('#standard').empty().trigger("change");
                        data.kehoach_tieuchuan.forEach((item, index) => {
                            let title = `TC ${item.stt}: ${item.mo_ta}`;
                            var option = new Option(title, item.tieuchuan_id, true, true);
                            $("#standard").append(option);
                        })
                    }
                    var option = new Option("", "", true, true);
                    $("#standard").append(option).trigger('change');
                })
        });
        $('#standard').on('change', function (e) {
            var route = "{{ route('admin.tudanhgia.preparereport.searchPtyc') }}" + "?id_standard=" + $(this).val();
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST', 
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.tieuchi != undefined){
                        $('#criteria').empty().trigger("change");
                        data.tieuchi.forEach((item, index) => {
                            let title = `TChi ${item.stt}: ${item.mo_ta}`;
                            var option = new Option(title, item.id, true, true);
                            $("#criteria").append(option);
                        })
                    }
                    var option = new Option("", "", true, true);
                    $("#criteria").append(option).trigger('change');
                })
        });
        

        $("#btn-search").click(function(){
            let idBc = $('#select-report').val();
            let idTieuchuan  = $('#standard').val();
            let idTieuchi = $("#criteria").val();

            var route = "{{ route('admin.tudanhgia.preparereport.manacollect') }}" + "?id_report=" + idBc + "&id_standard=" + idTieuchuan + "&id_criteria=" + idTieuchi;
            fetch(route, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    $(".block-mana").empty();
                    if(data.menhde != undefined && data.menhde != null){
                        data.menhde.forEach((item, index) => {
                            let html = `
                                <div class="block-item">
                                    <p>
                                        <span class="font-weight-bold">@lang('project/Selfassessment/title.chibao') </span>
                                        <span>${item.mo_ta}</span>
                                    </p>
                              `;
                            item.mocchuan.forEach((item2, index2) => {
                                html += `
                                    <p class="ml-3">
                                        <span class="font-weight-bold">@lang('project/Selfassessment/title.mctc') </span>
                                        <span>
                                            ${item2.mo_ta}
                                        </span>
                                        <button class="btn btn-primary">
                                            @lang('project/Selfassessment/title.themmoi')
                                            <ion-icon name="add-outline"></ion-icon>
                                        </button>
                                    </p>
                                 `;
                                // Thêm phần treo vào đây
                            })
                            
                            html += `<hr>
                                </div>`;

                            $(".block-mana").append(html);
                        })
                    }
                })
        })
    </script>


@stop


<!-- Treo -->
<!-- <div class="block-table ml-5">
    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">@lang('project/Selfassessment/title.mcctt')</th>
          <th scope="col">@lang('project/Selfassessment/title.ntt')</th>
          <th scope="col">@lang('project/Selfassessment/title.ghichu')</th>
          <th scope="col">@lang('project/Selfassessment/title.trangthai')</th>
          <th scope="col">@lang('project/Selfassessment/title.quanly')</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">Chiến lược phát triển Trường Đại học Công nghiệp Hà Nội giai đoạn 2016 - 2020, tầm nhìn 2025_</th>
          <td>Đại học điện tử</td>
          <td>Trích yếu nội dung của minh chứng</td>
          <td>Đã có minh chứng</td>
          <td>
              <button class="btn btn-warning btn-block">
                   @lang('project/Selfassessment/title.xmc')
              </button>
              <button class="btn btn-danger btn-block">
                  @lang('project/Selfassessment/title.xoamc') 
              </button>
          </td>
        </tr>
      </tbody>
    </table>
</div> -->







