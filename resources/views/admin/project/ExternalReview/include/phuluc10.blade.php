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
                <tr>
                    <td>{!! $minhChung['mamc'] !!}</td>
                    <td>{!! $minhChung['tenmc'] !!}</td>
                    <td>{!! $minhChung['sohieubh'] !!}</td>
                    <td>{!! $minhChung['noibanhanh'] !!}</td>
                    <td>{!! $minhChung['minhchung'] !!}</td>
                </tr>           
                
            @endforeach
            </tbody>
        </table>
    </div>
</div>

