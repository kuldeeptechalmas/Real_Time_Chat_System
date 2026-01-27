@extends('User.dashbord')

@section('content')
{{-- searching and show user --}}
<div class="col-4 bg-light" style="padding: 0px;">
    <div style="padding: 21px;background-color: #fbdfd2">
        <div class="d-flex">
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <div class="row" style="padding: 15px;">
        <div style="display: flex;justify-content: center;">Show All Notification</div>
        {{-- <input style="width: 87%;margin-left: 20px;" autocomplete="off" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" /> --}}
    </div>

    {{-- here --}}
    <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">
        @if (isset($friendlistrequest))
        @if ($friendlistrequest->isNotEmpty())
        @foreach ($friendlistrequest as $item)

        <div class="d-flex bg-white" style="padding: 16px;margin: 4px;position: relative;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                @if ($item->sendersData->image_path!=Null)
                <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{$item->sendersData->phone}}','{{$item->sendersData->email}}')" alt="">
                @else
                @if ($item->sendersData->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
            </div>
            <div style="display: flex;justify-content: center;align-items: center;padding-left: 19px;">
                {{ $item->sendersData->name }}
            </div>
            <div style="position: absolute;right: 2%;top: 19%;">
                @if ($item->status==0)
                <button style="margin-left: 163px;" type="button" class="btn btn-primary" onclick="RequestIsAccept('{{ $item->sendersData->id }}',this)">Follow Back</button></div>
            @else
            <button style="margin-left: 163px;" type="button" class="btn btn-primary">Following</button>
        </div>
        @endif
    </div>
    @endforeach
    @else
    <div style="display: flex;justify-content: center;margin-top: 25%;">Result Not found</div>
    @endif
    @endif
</div>

</div>
<div class="col-7" style="background: white;padding: 0px;" id="chatboardofreceiver">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>
@endsection
