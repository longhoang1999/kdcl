@php
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

@if($nhanXetKhoiList->count()>0)
    <div class="social-feed-box">
        <div class="social-footer" style="background: #fcf8e3; !important">
            @foreach($nhanXetKhoiList as $nhanXetKhoi)
                <div class="social-comment" id="comment-{{ $nhanXetKhoi->id }}">
                    <a href="" class="pull-left">
                        {{--@if($nhanXetKhoi->user->img_avatar)
                            <img alt="image"
                                 src="{{ URL::asset("uploads/user_avatar/") }}/{{$nhanXetKhoi->user->img_avatar}}">
                        @else
                            <img alt="image" src="{{ URL::asset("img/default-avatar.png") }}">
                        @endif--}}
                    </a>
                    <div class="media-body p-4">
                        <a href="#">
                            {{ $nhanXetKhoi->name }} ({{ ($nhanXetKhoi->tendonvi) ? $nhanXetKhoi->tendonvi->ten_donvi : ""}})
                        </a><br>
                        {!! nl2br($nhanXetKhoi->nhanxet) !!}
                    </div>
                    @foreach($nhanXetKhoiListMains->where('parent',$nhanXetKhoi->id) as $nhanXetKhoiListMain)
                        <div class="social-comment">
                            <a href="" class="pull-left">
                                {{--@if($nhanXetKhoiListMain->user->img_avatar)
                                    <img alt="image"
                                         src="{{ URL::asset("uploads/user_avatar/") }}/{{$nhanXetKhoiListMain->user->img_avatar}}">
                                @else
                                    <img alt="image" src="{{ URL::asset("img/default-avatar.png") }}">
                                @endif--}}
                            </a>
                            <div class="media-body">
                                <a href="#">
                                    {{ $nhanXetKhoiListMain->name }}
                                    ({{ $nhanXetKhoiListMain->tendonvi->ten_donvi }})
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


        </div>

    </div>
@endif