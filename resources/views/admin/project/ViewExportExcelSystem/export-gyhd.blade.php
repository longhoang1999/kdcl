
<style>
    tr th{
        font-weight: bold;
    }
    .row1{
        width: 500px;
    }
</style>
<table>
    <thead>
    <tr>
        <th class="row1">
            @lang('project/Standard/title.tdmctt')
        </th>
        <th>
            @lang('project/Standard/title.btcad')
        </th>
        <th>
            @lang('project/Standard/title.tchiad')
        </th>
    </tr>
    </thead>
    <tbody>
        @foreach($getGyhd as $value)
            <tr class="row1">
                <th>{!! $value->mo_ta !!}</th>
                <td>{{ $value->tieu_de_btc }}</td>
                <td>{!! $value->spanUI !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>