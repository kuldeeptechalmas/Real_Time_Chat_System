<div style="position: relative;height: 100vh;background-color: #1c1d1d;">
    {{-- header of chating user --}}
    <div class="text-white" style="position: relative;padding: 22px;background-color: #1c1d1d;display: flex;justify-content: space-between;">
        Create Group...
    </div>
    <div class="d-flex mt-2 text-white" style="padding: 10px;background-color: #1c1d1d;">
        <input type="text" placeholder="Group Name" class="form-control scroll-container" style="width: 31%;" name="" id="group_name">
        <button type="button" onclick="FinalCreateGroup()" style="position: absolute;background: rgba(208, 242, 208, 0.5);right: 3%;" class="btn btn-info">New Group Create</button>
    </div>
    <div>

        @if (isset($friendList))
        @if ($friendList->isNotEmpty())

        @foreach ($friendList as $item)

        @if ($item->sender_user_id==Auth::id())
        <div class="d-flex text-white" onclick="SelectedGroupUser(this)" data-id="{{ $item->receiverData->id }}" style="background-color:#212529;border-radius: 28px;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

                @if ($item->receiverData->image_path!=Null)
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->receiverData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','{{ $item->receiverData->image_path }}','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" alt="">
                @else
                @if ($item->receiverData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
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
        <div class="d-flex text-white" onclick="SelectedGroupUser(this)" data-id="{{ $item->sendersData->id }}" style="background-color:#212529;border-radius: 28px;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

                @if ($item->sendersData->image_path!=Null)
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" alt="">
                @else
                @if ($item->sendersData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
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
        <div style="display: flex;justify-content: center;margin-top: 25%;">
            Not Found Result
        </div>
        @endif

        @else
        <div style="display: flex;justify-content: center;margin-top: 25%;">
            Not Found Result
        </div>
        @endif
    </div>
</div>
