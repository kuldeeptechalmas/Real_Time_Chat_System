@extends('User.dashbord')

@section('content')
{{-- searching and show user --}}
<div class="col-4 bg-light" style="padding: 0px;width: 36.333333%;border-right: 1px solid #504f4f;">
    <div style="padding: 21px;background-color: #1c1d1d">
        <div class="d-flex">
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div class="text-white" style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <div class="row" style="margin: 0px;padding: 15px;display: flex;justify-content: center;background: #1c1d1d;color: white;">
        Friend List
    </div>

    {{-- here --}}
    <div class="scroll-container" style="padding: 0px 20px 7px 20px;background: #1c1d1d;height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">
        @if (isset($friendList))
        @if ($friendList->isNotEmpty())



        @foreach ($friendList as $item)

        @if ($item->sender_user_id==Auth::id())
        <div class="d-flex bg-dark text-white" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
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
            <button style="position: absolute;right: 4%;" type="button" onclick="unfollowbyid('{{ $item->id }}',this)" class="btn btn-primary">UnFollow</button>
        </div>
        @else
        <div class="d-flex bg-dark text-white" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                @if (isset($item->sendersData->image_path))


                {{-- @if ($item->sendersData->image_path!=Null) --}}
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{ $item->sendersData->phone }}','{{ $item->sendersData->email }}')" alt="">
                @else
                @if ($item->sendersData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
                {{-- @endif --}}

            </div>
            {{-- <div style="width: 100%;" onclick="setsenduser({{ $item->sendersData->id }})"> --}}
            <div style="width: 100%;">
                <div style="margin-left: 21px;" id="{{ $item->sendersData->name }}">
                    {{ $item->sendersData->name }}
                </div>
            </div>
            <button style="position: absolute;right: 4%;" type="button" onclick="unfollowbyid('{{ $item->id }}',this)" class="btn btn-primary">UnFollow</button>
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

{{-- chatboard --}}
<div class="col-7" style="background: #1c1d1d;color: white;padding: 0px;" id="chatboardofreceiver">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>
@endsection
