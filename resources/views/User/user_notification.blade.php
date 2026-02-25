@extends('User.dashbord')

@section('content')
<style>
    /* Responsive notification styles */
    @media (max-width: 768px) {
        .col-4 {
            width: 100% !important;
            border-right: none !important;
        }

        /* When sidebar is open, show both sidebar and notification list side by side */
        body.rtc-menu-open .col-12.col-md-4 {
            margin-left: 72px;
            width: calc(100% - 72px) !important;
            transition: margin-left 0.25s ease, width 0.25s ease;
        }

        .col-7 {
            display: none !important;
        }

        .d-flex.bg-dark.text-white {
            padding: 12px !important;
            margin: 3px !important;
            flex-wrap: wrap;
        }

        button.btn-primary {
            padding: 8px 16px !important;
            font-size: 14px !important;
        }
    }

    @media (max-width: 576px) {
        .d-flex.bg-dark.text-white {
            padding: 10px !important;
            flex-wrap: wrap;
        }

        button.btn-primary {
            padding: 6px 12px !important;
            font-size: 12px !important;
            margin-top: 5px;
            width: 100%;
        }
    }

</style>
{{-- searching and show user --}}
<div class="col-12 col-md-4" style="padding: 0px;border-right: 1px solid #504f4f;">
    <div class="text-white" style="padding: 21px;">
        <div class="d-flex">
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <div class="row" style="padding: 15px;color: white;margin: 0px;">
        <div style="display: flex;justify-content: center;">Show All Notification</div>
        {{-- <input style="width: 87%;margin-left: 20px;" autocomplete="off" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" /> --}}
    </div>

    {{-- here --}}
    <div class="scroll-container" style="padding: 0px 20px 7px 20px;height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">
        @if (isset($friendlistrequest))
        @if ($friendlistrequest->isNotEmpty())
        @foreach ($friendlistrequest as $item)

        <div class="d-flex bg-dark text-white justify-content-between align-items-center flex-wrap gap-2" style="padding: 16px;margin: 4px;position: relative;">
            <div class="d-flex">
                <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                    @if ($item->sendersData->image_path!=Null)
                    <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sendersData->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','{{ $item->sendersData->image_path }}','{{$item->sendersData->phone}}','{{$item->sendersData->email}}')" alt="">
                    @else
                    @if ($item->sendersData->gender=='Men')
                    <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','male.png','{{$item->sendersData->phone}}','{{$item->sendersData->email}}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                    @else
                    <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sendersData->name }}','female.png','{{$item->sendersData->phone}}','{{$item->sendersData->email}}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                    @endif
                    @endif
                </div>
                <div style="display: flex;justify-content: center;align-items: center;padding-left: 19px;">
                    {{ $item->sendersData->name }} is strat following you
                </div>
            </div>

            <div class="ms-auto">
                @if ($item->status==0)
                <button type="button" class="btn btn-primary" onclick="RequestIsAccept('{{ $item->sendersData->id }}',this)">Follow Back</button></div>
            @else
            <button type="button" class="btn btn-primary">Following</button>
        </div>
        @endif
    </div>
    @endforeach
    @else
    <div class="text-white" style="display: flex;justify-content: center;margin-top: 25%;">Result Not found</div>
    @endif
    @endif
</div>

</div>
<div class="col-7 d-none d-md-block" style="padding: 0px;" id="chatboardofreceiver">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 135px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>
@endsection
