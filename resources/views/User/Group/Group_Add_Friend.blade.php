<div style="position: relative;height: 100vh;" class="bg-light">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 22px;background-color: #FBDFD1;">
        Group name <span style="font-weight: bold;">{{ $group_data->name }}</span> in Add Friend....
    </div>
    <div class="d-flex mt-2" style="padding: 10px;height: 52px;">
        <button type="button" onclick="ExistGroupAddFriend('{{ $group_data->id }}')" style="position: absolute;background: rgba(208, 242, 208, 0.5);right: 3%;" class="btn btn-info">Add Friend In Group</button>
    </div>
    <div>

        @if (isset($friendList))
        @if ($friendList->isNotEmpty())

        @foreach ($friendList as $item)

        @if ($item->sender_user_id==Auth::id())
        <div class="d-flex" onclick="SelectedGroupUser(this)" data-id="{{ $item->receiverData->id }}" style="background-color: white;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

                @if ($item->receiverData->image_path!=Null)
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->receiverData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','{{ $item->receiverData->image_path }}','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" alt="">
                @else
                @if ($item->receiverData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','male.png','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','female.png','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
            </div>
            <div style="width: 100%;">
                <div style="margin-left: 21px;" id="{{ $item->receiverData->name }}">
                    {{ $item->receiverData->name }}
                </div>
            </div>
        </div>
        @else
        <div class="d-flex" onclick="SelectedGroupUser(this)" data-id="{{ $item->sendersData->id }}" style="background-color: white;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

                @if ($item->sendersData->image_path!=Null)
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" alt="">
                @else
                @if ($item->sendersData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else

                @endif
                @endif
            </div>
            <div style="width: 100%;">
                <div style="margin-left: 21px;" id="{{ $item->sendersData->name }}">
                    {{ $item->sendersData->name }}
                </div>
            </div>
        </div>
        @endif

        @endforeach
        @else
        <div class="text-white" style="display: flex;justify-content: center;margin-top: 25%;">
            Result Not found
        </div>
        @endif

        @else
        <div class="text-white" style="display: flex;justify-content: center;margin-top: 25%;">
            Result Not found
        </div>
        @endif
    </div>
</div>
