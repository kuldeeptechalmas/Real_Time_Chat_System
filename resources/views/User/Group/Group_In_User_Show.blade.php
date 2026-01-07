<div>
    @if (isset($UserAllGroup))
    @foreach ($UserAllGroup as $item)
    <div class="bg-light" style="padding: 21px;display:flex;">
        <div style="width: 27px;height: 27px;">
            @if ($item->UserData->image_path!=Null)
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('storage/img/'.$item->UserData->image_path) }}" alt="">
            @else
            @if ($item->UserData->gender=='Men')
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('img/male.png') }}" alt="">

            @else
            <img style="width: 100%;height: 100%;object-fit: cover;border-radius: 20px;" src="{{ asset('img/female.png') }}" alt="">

            @endif
            @endif
        </div>
        <div style="margin-left: 27px;">
            {{$item->UserData->name}}
        </div>
        {{-- <div>
            creater
        </div> --}}
    </div>
    @endforeach
    @endif
    <div class="bg-light btn" style="padding: 21px;display:flex;" onclick="ExistGroup('{{ $UserAllGroup[0]->group_id }}')">
        <div style="margin-left: 27px;color: red;">
            Exist Group
        </div>
    </div>
</div>
