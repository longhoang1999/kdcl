<div class="m-t-md">
    <div  class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">Mã minh chứng</label>
            <div class="col-sm-6">
                <input type="text" value=""  id="mykeySearchInputMc"  name="search" placeholder="Nhập mã minh chứng để tìm kiếm" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-2">
                <button class="ladda-button btn btn-primary fillterMinhChung" type="submit" data-style="expand-right">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </div>
    <div id="phuluc10">
        
        
        <h3 class="text-center">DANH MỤC MINH CHỨNG</h3>
        <table class="table-bordered table m-t-md " >
            <thead>
            <tr>
                <th>Mã minh chứng</th>
                <th>Tên minh chứng</th>
                <th>Số, ngày/tháng ban hành</th>
                <th>Nơi ban hành</th>
                <th>Ghi chú</th>
            </tr>
            </thead>
            <tbody id="tableDsMinhChung" >
            @foreach($minhChungList as $minhChung)            
                @if($minhChung['mcType']=='mc')            
                    <tr>                    
                        <td>
                            <a href="javascript:;" class="danMinhChung" d-id="{{ $minhChung['mcDetail']->id }}" d-type="mc">
                                {{ $minhChung['mcCode'] }}
                            </a>
                        </td>
                        <td>{{ $minhChung['mcDetail']->tieu_de }}</td>
                        <td>{{ isset($minhChung['mcDetail']->sohieu) ? $minhChung['mcDetail']->sohieu : "--" }}, {{ \Carbon\Carbon::parse($minhChung['mcDetail']->ngay_ban_hanh)->format('d/m/Y') }}</td>
                        <td>{{ $minhChung['mcDetail']->noi_banhanh }}</td>
                        <td>Minh Chứng</td>
                    </tr>
                @else
                    @if(isset($minhChung['mcDetail']->minhChungList) && $minhChung['mcDetail']->minhChungList->count() > 1 )

                        <tr>
                            <td>
                                <a href="javascript:;" class="danMinhChung" d-id="{{ $minhChung['mcDetail']->id }}" d-type="mcGop">
                                    {{ $minhChung['mcCode'] }}
                                </a>
                            </td>
                            <td>{{ $minhChung['mcDetail']->tieu_de }}</td>
                            <td>{{ $minhChung['mcDetail']->minhChungList->count() }} minh chứng</td>
                            <td></td>
                            <td>Minh Chứng gộp</td>
                        </tr>
                        @foreach($minhChung['mcDetail']->minhChungList as $mcdetail)
                            <tr>
                                <td>
                                </td>
                                <td>{{ $mcdetail->tieu_de }}</td>
                                <td>{{ isset($mcdetail->sohieu) ? $mcdetail->sohieu : "--" }}, {{ \Carbon\Carbon::parse($mcdetail->ngay_ban_hanh)->format('d/m/Y') }}</td>
                                <td>{{ $mcdetail->noi_banhanh }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @else
                        @if(isset($minhChung['mcDetail']->minhChungList))
                            @foreach($minhChung['mcDetail']->minhChungList as $mcdetail)
                                <tr>
                                    <td>
                                        <a href="javascript:;" class="danMinhChung" d-id="{{ $minhChung['mcDetail']->id }}" d-type="mcGop">
                                            {{ $minhChung['mcCode'] }}
                                        </a>
                                    </td>
                                    <td>{{ $mcdetail->tieu_de }}</td>
                                    <td>{{ isset($mcdetail->sohieu) ? $mcdetail->sohieu : "--" }}, {{ \Carbon\Carbon::parse($mcdetail->ngay_ban_hanh)->format('d/m/Y') }}</td>
                                    <td>{{ $mcdetail->noi_banhanh }}</td>
                                    <td>Minh chứng</td>
                                </tr>
                            @endforeach
                        @endif
                        
                    @endif
                @endif 
            @endforeach
            </tbody>
        </table>
    </div>
</div>

