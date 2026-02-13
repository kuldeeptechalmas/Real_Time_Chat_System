@php
use Carbon\Carbon;
@endphp
@if (isset($user_data))

@if ($user_data->isNotEmpty())

@foreach ($user_data as $item)
<div class="d-flex bg-dark text-white" id="{{ $item->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

        @if ($item->image_path!=Null)
        <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->name }}','{{ $item->image_path }}','{{ $item->phone }}','{{ $item->email }}')" alt="">
        @else
        @if ($item->gender=='Men')
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->name }}','male.png','{{ $item->phone }}','{{ $item->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
        @else
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->name }}','female.png','{{ $item->phone }}','{{ $item->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
        @endif
        @endif
    </div>
    <div style="width: 100%;" onclick="setsenduser({{ $item->id }})">
        <div style="margin-left: 21px;" id="{{ $item->name }}">
            {{ $item->name }}
        </div>
    </div>
</div>
@endforeach
@else
<div class="text-white" style="display: flex;justify-content: center;margin-top: 25%;">
    Result Not found
</div>
@endif
@endif

@if (isset($last_message_send_data))

@if ($last_message_send_data->isNotEmpty())
@foreach ($last_message_send_data as $item)

@if ($item->receive_id==Auth::id())

<div class="d-flex bg-dark text-white" id="{{ $item->sender->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->sender->image_path!=Null)

        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sender->name }}','{{ $item->sender->image_path }}','{{ $item->sender->phone }}','{{ $item->sender->email }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->sender->image_path) }}" alt="">
        @else
        @if ($item->sender->gender=='Men')
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sender->name }}','{{ $item->sender->image_path }}','{{ $item->sender->phone }}','{{ $item->sender->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
        @else
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sender->name }}','{{ $item->sender->image_path }}','{{ $item->sender->phone }}','{{ $item->sender->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
        @endif
        @endif
    </div>
    <div style="width: 100%;" onclick="setsenduser({{ $item->sender->id }})">
        <div style="margin-left: 21px;" id="{{ $item->sender->name }}">
            {{ $item->sender->name }}
        </div>
    </div>
</div>

@else

<div class="d-flex bg-dark text-white" id="{{ $item->user_data_to_message->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->user_data_to_message->image_path!=Null)
        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->user_data_to_message->name }}','{{ $item->user_data_to_message->image_path }}','{{ $item->user_data_to_message->phone }}','{{ $item->user_data_to_message->email }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
        @else
        @if ($item->user_data_to_message->gender=='Men')
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->user_data_to_message->name }}','male.png','{{ $item->user_data_to_message->phone }}','{{ $item->user_data_to_message->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
        @else
        <div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->user_data_to_message->name }}','female.png','{{ $item->user_data_to_message->phone }}','{{ $item->user_data_to_message->email }}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
        @endif
        @endif
    </div>
    <div style="width: 100%;display: flex;height: 37px;" onclick="setsenduser({{ $item->user_data_to_message->id }})">
        <div style="margin-left: 21px;display: flex;" id="{{ $item->user_data_to_message->name }}">
            {{ $item->user_data_to_message->name }}
            {{-- {{ $item }} --}}
        </div>

        @if (isset($item->user_data_to_message->last_seen_at))

        @php
        $old_time = Carbon::parse($item->user_data_to_message->last_seen_at->timezone('Asia/Kolkata'));
        $current = Carbon::now();
        $diff = $old_time->diff($current);
        @endphp
        @if ($item->message_count!=0)
        <div style="top: 20px;right: 68px;position: absolute;background: lightblue;height: 20px;width: 20px;display: flex;justify-content: center;border-radius: 14px;align-items: center;">
            {{ $item->message_count }}
        </div>

        @endif

        <div class="TimeOldOnline" style="font-size: 12px;position: absolute;top: 29%;right: 6%;">

            @php
            $date = \Carbon\Carbon::parse($old_time);
            @endphp

            @if($date->isToday())
            {{ $date->format('H:i a') }}

            @elseif($date->isYesterday())
            Yesterday

            @elseif($date->isCurrentWeek())
            {{ $date->format('l') }}

            @else
            {{ $date->format('d/m/y') }}
            @endif

        </div>
        @endif
    </div>
</div>

@endif
@endforeach

@else
<div class="text-white" style="display: flex;justify-content: center;margin-top: 25%;">
    Result Not found
</div>
@endif
@endif
