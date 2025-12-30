@if (isset($user_data))

@if ($user_data->isNotEmpty())

@foreach ($user_data as $item)
<div class="d-flex bg-white" id="{{ $item->id }}" style="position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

        @if ($item->image_path!=Null)
        <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->image_path) }}" data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->name }}','{{ $item->image_path }}')" alt="">
        @else
        @if ($item->gender=='Men')
        <i class="fa-solid fa-user" style="font-size: 21px;"></i>
        @else
        <i class="fa-regular fa-user" style="font-size: 21px;"></i>
        @endif
        @endif
    </div>
    <div onclick="setsenduser({{ $item->id }})">
        <div style="margin-left: 21px;" id="{{ $item->name }}">
            {{ $item->name }}
        </div>
    </div>
</div>
@endforeach
@else
<div style="display: flex;justify-content: center;margin-top: 25%;">
    Not Found Result
</div>
@endif
@endif

@if (isset($last_message_send_data))

@if ($last_message_send_data->isNotEmpty())
@foreach ($last_message_send_data as $item)
@if ($item->receive_id==Auth::id())
<div class="d-flex bg-white" id="{{ $item->sender->id }}" style="position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->sender->image_path!=Null)
        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->sender->name }}','{{ $item->user_data_to_message->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
        @else
        @if ($item->sender->gender=='Men')
        <i class="fa-solid fa-user" style="font-size: 21px;"></i>
        @else
        <i class="fa-regular fa-user" style="font-size: 21px;"></i>
        @endif
        @endif
    </div>
    <div onclick="setsenduser({{ $item->sender->id }})">
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
        <i class="fa-solid fa-user" style="font-size: 21px;"></i>
        @else
        <i class="fa-regular fa-user" style="font-size: 21px;"></i>
        @endif
        @endif
    </div>
    <div onclick="setsenduser({{ $item->user_data_to_message->id }})">
        <div style="margin-left: 21px;" id="{{ $item->user_data_to_message->name }}">
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
