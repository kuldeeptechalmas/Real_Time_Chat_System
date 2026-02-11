@extends('User.dashbord')

@section('content')

{{-- star and show user --}}
<div class="col-4 " style="padding: 0px;width: 36.333333%;border-right: 1px solid #504f4f;">
    <div class="text-white" style="padding: 21px;background-color: #1d1f1f">
        <div class="d-flex">
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <div class="row text-white" style="padding: 15px;margin: 0px;">
        <div style="display: flex;justify-content: center;">Show Star User</div>
        {{-- <input style="width: 87%;margin-left: 20px;" autocomplete="off" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" /> --}}
    </div>

    {{-- here --}}
    <div class="scroll-container" style="padding: 0px 20px 7px 20px;height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">

        @if ($last_message_send_data->isNotEmpty())

        @if (isset($last_message_send_data))
        @foreach ($last_message_send_data as $item)

        @if (isset($item->StarUserWithMessage))

        <div class="d-flex bg-dark text-white" id="{{ $item->receiver->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                @if ($item->receiver->image_path!=Null)
                <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiver->name }}','{{ $item->receiver->image_path }}','{{ $item->receiver->phone }}','{{ $item->receiver->email }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->receiver->image_path) }}" alt="">
                @else
                @if ($item->receiver->gender=='Men')
                <div style="height: 37px;width: 37px;"><img data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiver->name }}','male.png','{{ $item->receiver->phone }}','{{ $item->receiver->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->receiver->name }}','female.png','{{ $item->receiver->phone }}','{{ $item->receiver->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
            </div>
            <div style="width: 100%;display: flex;" onclick="setsenduser({{ $item->receiver->id }})">
                <div style="margin-left: 21px;display: flex;" id="{{ $item->receiver->name }}">
                    {{ $item->receiver->name }}
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
<div class="col-7" style="background: #1d1f1f;padding: 0px;" id="chatboardofreceiver">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>
@endsection
