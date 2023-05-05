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
        @foreach($getMinimum as $minimun)
            <tr class="row1">
                <th>{{ $minimun->tieu_de_mctt }}</th>
                <td>{{ $minimun->tieu_de_btc }}</td>
                <td>{{ $minimun->spanUI }}</td>
            </tr>
        @endforeach
    </tbody>
</table>