@extends('admin/layouts/default')
{{-- Page title --}}
@section('title')
    @lang('project/Selfassessment/title.cbbc')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" href="{{ asset('css/project/Selfassessment/selfassessment.css') }}">

@stop

@section('title_page')
    @lang('project/Selfassessment/title.qlmcdxl')
@stop

@section('content')
    <section class="content indexpage pr-3 pl-3">
        <!-- Bắt đầu trang -->
<!-- page trang ở đây -->
<section class="content-body">
    <h2>
        @lang('project/Selfassessment/title.qlmcdxl')
    </h2>
    <div class="line"></div>
    <h3 class="rp-h3">@lang('project/Selfassessment/title.timkiem')</h3>
    <div class="preparereport">
        <div class="select2s rp-select2s">
            <div class="select2-left rp-select2-left">
                <select id="select2-css-left" class="searchs">
                  <option value="AL">@lang('project/Selfassessment/title.tenbc')</option>
                  <option value="WY">@lang('project/Selfassessment/title.timkiem')</option>
                </select>
            </div>
        </div>
        <div class="list-select2" id="pr-list-select2">
            <div class="select2-1 ">
                <select class="searchs size">
                    <option value="">@lang('project/Selfassessment/title.tieuchuan')</option>
                </select>
            </div>
            <div class="select2-2 rp-select2-2">
                <select class="searchs size">
                    <option value="">@lang('project/Selfassessment/title.tieuchi')</option>
                </select>
            </div>
            <div class="select2-3 pr-select2-3">
                <select class="searchs size">
                    <option value="">@lang('project/Selfassessment/title.mctt')</option>
                </select>
            </div>
            <div class="select2-4 size rp-select2-4 size-2">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    <span>Lọc</span>
                </button>
            </div>
        </div>
    </div>
    <div class="form-standard">
        <div class="item-group-button right-block mb-2">
            <button class="btn btn-success btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                  </svg> 
                <span>@lang('project/Selfassessment/title.xlmc')</span>
            </button>
            <button class="btn btn-success btn-benchmark mr-2 mt-3 ml-4 pl-3 pr-3" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel mr-2" viewBox="0 0 16 16">
                    <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>  
                <span>@lang('project/Selfassessment/title.xuat_excel')</span>
            </button>
        </div>
        <table id="table" class="display table-striped table-bordered" style="width:100%">
            <thead>
             <tr>
                <th >@lang('project/Selfassessment/title.tmcdxl')</th>
                <th >@lang('project/Selfassessment/title.tieuchi')</th>
                <th >@lang('project/Selfassessment/title.ngayxl')</th>
                <th >@lang('project/Selfassessment/title.mctp')</th>
                <th >@lang('project/Selfassessment/title.hanhdong')</th>
             </tr>
            </thead>               
        </table> 
    </div>
</section>
<!-- /Kết thúc page trang -->

    <!-- Kết thúc trang -->
    </section>
@stop



{{-- page level scripts --}}
@section('footer_scripts')
<script >
    /* Formatting function for row details - modify as you need */
    function format(d) {
        // `d` is the original data object for the row
        return (
            `
                <table cellpadding="5" cellspacing="0" border="0" > 
                <tr> 
                <td class="css-criteria"> 
                    ${d.id} 
                </td>
                <td class="css-date-start"> 
                    ${d.id} 
                </td>
                <td class="css-date-end"> 
                    ${d.id} 
                </td> 
                <td class="css-leader"> 
                    ${d.id} 
                </td>
                <td> 
                    ${d.id} 
                </td>    
                </tr> 
                <tr> 
                    <td class="css-criteria"> 
                    ${d.ngay_batdau} 
                    </td> 
                    <td class="css-date-start"> 
                    ${d.ngay_batdau} 
                    </td> 
                    <td class="css-date-end"> 
                    ${d.ngay_batdau} 
                    </td> 
                    <td class="css-leader"> 
                    ${d.ngay_batdau} 
                    </td>
                    <td> 
                    ${d.ngay_batdau} 
                    </td> 
                </tr> 
               
                </table>
            `
        );
    }
    $(document).ready(function () {
        table = $('#table').DataTable({
            lengthMenu: [[7, 10, 20, -1], [7, 10, 20, "All"]],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{!! route('admin.tudanhgia.preparereport.data') !!}",
            columns: [
                { data: 'nametc', name: 'nametc', className: 'dt-control'  },
                { data: 'datebd', name: 'datebd' },
                { data: 'dateht', name: 'dateht' },
                { data: 'leader', name: 'leader' },
                { data: 'actions', name: 'actions' },
            ],            
        });
     
        // Add event listener for opening and closing details
        $('#table tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown ');
                tr.removeClass('dt-hasChild');
            } else {
                // Open this row
                let id_tc = row.data().id;

                // $ajax({
                // });
                console.log(row.data().id);
                row.child(format(row.data())).show();
                tr.addClass('shown dt-hasChild');
            }
        });
    });
    $('.searchs').select2(); 
</script>

@stop
