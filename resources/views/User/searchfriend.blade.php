@php
use Carbon\Carbon;
@endphp
<style>
    /* Responsive adjustments for friend list */
    @media (max-width: 768px) {
        .d-flex.hover_change_all {
            padding: 12px !important;
            margin: 3px !important;
        }

        .d-flex.justify-content-center {
            height: 32px !important;
            width: 32px !important;
        }

        div[style*="margin-left: 21px"] {
            margin-left: 15px !important;
            font-size: 14px;
        }

        div[style*="max-width: 210px"] {
            max-width: 150px !important;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .d-flex.hover_change_all {
            padding: 10px !important;
            border-radius: 12px !important;
        }

        div[style*="max-width: 210px"] {
            max-width: 120px !important;
        }
    }

</style>

@if (isset($user_data))

@if ($user_data->isNotEmpty())

@foreach ($user_data as $item)
<div class="d-flex hover_change_all text-white" id="{{ $item->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
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
            <br>
            <div style="max-width: 210px;color: gray;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                @if ($item->status=='send')
                <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                @endif

                @if ($item->status=='view')
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: -13px;"></i>
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: 1px;"></i>
                @endif
                {{ $item->message }}
            </div>
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

<div class="d-flex hover_change_all text-white" id="{{ $item->sender->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
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
            <br>
            <div style="max-width: 210px;color: gray;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                @if ($item->status=='send')
                <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                @endif

                @if ($item->status=='view')
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: -13px;"></i>
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: 1px;"></i>
                @endif
                {{ $item->message }}
            </div>
        </div>
        @if (isset($item->sender->last_seen_at))
        @php
        $old_time = $item->sender->last_seen_at
        ->copy()
        ->setTimezone('Asia/Kolkata');

        $now = now()->setTimezone('Asia/Kolkata');
        @endphp

        @if ($item->message_count != 0)
        <div style="font-size: 12px;color: black;top: 46px;right: 33px;position: absolute;background: #21c063;height: 20px;width: 20px;display: flex;justify-content: center;border-radius: 14px;align-items: center;">
            {{ $item->message_count }}
        </div>
        @endif

        <div class="TimeOldOnline" style="font-family: 'Inter', sans-serif;font-size: 12px;position: absolute;top: 29%;right: 6%;">

            @if($old_time->isToday())
            {{ $old_time->format('h:i A') }}

            @elseif($old_time->isYesterday())
            Yesterday

            @elseif($old_time->greaterThanOrEqualTo($now->copy()->subDays(7)))
            {{ $old_time->format('l') }}

            @else
            {{ $old_time->format('d/m/y') }}
            @endif

        </div>

        @endif
    </div>
</div>

@else

<div class="d-flex hover_change_all text-white" id="{{ $item->user_data_to_message->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
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
        <div style="margin-left: 21px;font-family: 'Inter', sans-serif;" id="{{ $item->user_data_to_message->name }}">
            {{ $item->user_data_to_message->name }}
            <br>
            <div style="max-width: 210px;color: gray;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                @if ($item->status=='send')
                <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                @endif

                @if ($item->status=='view')
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: -13px;"></i>
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: 1px;"></i>
                @endif
                {{ $item->message }}
            </div>
        </div>

        @if (isset($item->user_data_to_message->last_seen_at))
        @php
        $old_time = $item->user_data_to_message->last_seen_at
        ->copy()
        ->setTimezone('Asia/Kolkata');

        $now = now()->setTimezone('Asia/Kolkata');
        @endphp

        @if ($item->message_count != 0)
        <div style="font-size: 12px;color: black;top: 46px;right: 33px;position: absolute;background: #21c063;height: 20px;width: 20px;display: flex;justify-content: center;border-radius: 14px;align-items: center;">
            {{ $item->message_count }}
        </div>
        @endif

        <div class="TimeOldOnline" style="font-family: 'Inter', sans-serif;font-size: 12px;position: absolute;top: 29%;right: 6%;">

            @if($old_time->isToday())
            {{ $old_time->format('h:i A') }}

            @elseif($old_time->isYesterday())
            Yesterday

            @elseif($old_time->greaterThanOrEqualTo($now->copy()->subDays(7)))
            {{ $old_time->format('l') }}

            @else
            {{ $old_time->format('d/m/y') }}
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
