@if (isset($friendList))
@if ($friendList->isNotEmpty())

<div class="row w-100 text-white" style="background: #1c1d1d;margin: 0;padding: 22px;">
    Forword User Select...
</div>

<div class="scroll-container1" style="height: 477px;">
    @foreach ($friendList as $item)

    @if ($item->sender_user_id==Auth::id())

    <div class="d-flex text-white" onclick="SelectedForwordUser(this)" data-id="{{ $item->receiverData->id }}" style="background-color:#212529;border-radius: 20px;position: relative;padding: 16px;margin: 4px;">
        <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

            @if ($item->receiverData->image_path!=Null)
            <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->receiverData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','{{ $item->receiverData->image_path }}','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" alt="">
            @else
            @if ($item->receiverData->gender=='Men')
            <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','male.png','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" src="{{ asset('img/male.png') }}" alt=""></div>
            @else
            <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiverData->name }}','female.png','{{ $item->receiverData->phone }}','{{ $item->receiverData->email }}')" src="{{ asset('img/female.png') }}" alt=""></div>
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

    <div class="d-flex text-white" onclick="SelectedForwordUser(this)" data-id="{{ $item->sendersData->id }}" style="background-color:#212529;border-radius: 20px;position: relative;padding: 16px;margin: 4px;">
        <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

            @if ($item->sendersData->image_path!=Null)
            <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" alt="">
            @else
            @if ($item->sendersData->gender=='Men')
            <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','male.png','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
            @else
            <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','female.png','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
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
    <div onclick="ForwordMessageUserSelect()" style="position: absolute;right: 3%;bottom: 8%;height: 50px;width: 50px;display: flex;background: #007c00ba;justify-content: center;align-items: center;border-radius: 50px;">
        <i class="fa-solid fa-paper-plane" style="color:white;"></i>
    </div>
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
