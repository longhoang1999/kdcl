<div class="social-feed-box">
    <div class="social-footer" style="background: #fcf8e3 !important;">
    @php
        $nhanXetKhoiList = DB::table('baocao_nhanxetkhoi')->select('baocao_nhanxetkhoi.*','users.name','donvi.ten_donvi')
        ->leftJoin('users','users.id','=','baocao_nhanxetkhoi.nguoi_tao')
        ->leftJoin('donvi','donvi.id','=','users.donvi_id');
        $nhanXetKhoiListMains = $nhanXetKhoiList;
        if($kieu=='tieuchuan_modau' || $kieu=='tieuchuan_ketluan'){
            $nhanXetKhoiList = $nhanXetKhoiList->where('kieu',$kieu)->where('id_tieuchuan_bc',$id);
        }

        if($kieu=='menhde_diemmanh' || $kieu=='menhde_tontai'|| $kieu=='menhde_mota'){
            $nhanXetKhoiList = $nhanXetKhoiList->where('kieu',$kieu)->where('id_menhde_bc',$id);
        }

        if($kieu=='chung_modau' || $kieu=='chung_ketluan') {
            $nhanXetKhoiList = $nhanXetKhoiList->where('kieu',$kieu)->where('id_chung_bc',$id);
        }
        $nhanXetKhoiList = $nhanXetKhoiList->where('parent',0);
    @endphp
    <style>
        .comment_block{
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 20%), 0 1px 5px 0 rgb(0 0 0 / 12%);
        }
        .comment_block_p{
            display: flex;
            border-top: 1px solid #e7eaec;
            padding: 10px 15px;
            margin-top: 35px;
        }
    </style>
    @if($nhanXetKhoiList->count()>0)
        @foreach($nhanXetKhoiList->get() as $nhanXetKhoi)
            <div class="social-comment" id="comment-{{ $nhanXetKhoi->id }}">
                <div class="media-body p-4">
                    <a href="#">
                        {{ $nhanXetKhoi->name }} ({{ $nhanXetKhoi->ten_donvi }})
                    </a><br>
                    {!! nl2br($nhanXetKhoi->nhanxet) !!}
                    <br>
                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($nhanXetKhoi->created_at)->format('d-m-Y h:i') }}
                    </small>
                </div>
                @foreach($nhanXetKhoiListMains->where('parent',$nhanXetKhoi->id)->get() as $nhanXetKhoiListMain)
                    <div class="social-comment">                        
                        <div class="media-body">
                            <a href="#">
                                {{ $nhanXetKhoiListMain->name }}
                                ({{ $nhanXetKhoiListMain->ten_donvi }})
                            </a><br>
                            {!! nl2br($nhanXetKhoiListMain->nhanxet) !!}
                            <br>                            
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($nhanXetKhoiListMain->created_at)->format('d-m-Y h:i') }}
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
            
    @endif  
        <div class="comment_block">
            <form action="{!! route('admin.tudanhgia.commentreport.createCommentBlock') !!}" method="POST">
                <input type="hidden" name="id_kehoach_bc" value="{{ $id_kehoach_bc }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="kieu" value="{{ $kieu }}">
                <input type="hidden" name="parent" value="0">
                @csrf
                <div class="comment_block_p">
                    <img src="{{  asset('images/authors/no_avatar.jpg') }}" alt="" style="padding: 2px 13px 2px 0px;width: 5%;object-fit: cover;height: 100%;">
                    <textarea name="nhanxet" class="form-control" placeholder="@lang('project/Selfassessment/title.vietnhanxet')"></textarea>
                </div>
                <div class="mt-2 ml-4 pl-3 pr-3 text-right">
                    <button type="submit" class="btn btn-sm btn-primary " style="margin-bottom: 10px;">
                        @lang('project/Selfassessment/title.guinhanxet')
                    </button>
                </div>
            </form>
        </div>

    </div>

</div> 

    