@if (isset($user_data))

@foreach ($user_data as $item)
<div class="d-flex bg-white" id="{{ $item->id }}" style="position: relative;padding: 16px;margin: 4px;" onclick="setsenduser({{ $item->id }})">
    <div style="height: 37px;width: 37px;">
        <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->image_path) }}" alt="">
    </div>
    <div style="margin-left: 21px;" id="{{ $item->name }}">
        {{ $item->name }}
    </div>
</div>
@endforeach
@endif

@if (isset($last_message_send_data))

@foreach ($last_message_send_data as $item)
<div class="d-flex bg-white" id="{{ $item->user_data_to_message->id }}" style="position: relative;padding: 16px;margin: 4px;" onclick="setsenduser({{ $item->user_data_to_message->id }})">
    <div style="height: 37px;width: 37px;">
        <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
    </div>
    <div style="margin-left: 21px;" id="{{ $item->user_data_to_message->name }}">
        {{ $item->user_data_to_message->name }}
    </div>
</div>
@endforeach
@endif
