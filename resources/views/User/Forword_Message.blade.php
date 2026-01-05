@php
use Carbon\Carbon;
@endphp
@if (isset($last_message_send_data))

@if ($last_message_send_data->isNotEmpty())
<div class="row w-100" style="background: #f9d8c9;margin: 0;padding: 22px;">
    Forword User Select...
</div>
@foreach ($last_message_send_data as $item)
@if ($item->receive_id==Auth::id())
<div class="d-flex bg-white" id="{{ $item->sender->id }}" style="position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->sender->image_path!=Null)
        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sender->name }}','{{ $item->user_data_to_message->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
        @else
        @if ($item->sender->gender=='Men')
        <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
        @else
        <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
        @endif
        @endif
    </div>
    <div style="width: 100%;" onclick="ForwordMessageUserSelect({{ $item->sender->id }})">
        <div style="margin-left: 21px;" id="{{ $item->sender->name }}">
            {{ $item->sender->name }}
        </div>
    </div>
</div>

@else

<div class="d-flex bg-white" id="{{ $item->user_data_to_message->id }}" style="position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->user_data_to_message->image_path!=Null)
        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->user_data_to_message->name }}','{{ $item->user_data_to_message->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
        @else
        @if ($item->user_data_to_message->gender=='Men')
        <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
        @else
        <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
        @endif
        @endif
    </div>
    <div style="width: 100%;display: flex;" onclick="ForwordMessageUserSelect({{ $item->user_data_to_message->id }})">
        <div style="margin-left: 21px;display: flex;" id="{{ $item->user_data_to_message->name }}">
            {{ $item->user_data_to_message->name }}
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
@endif
