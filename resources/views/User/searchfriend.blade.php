@if (isset($user_data))

@foreach ($user_data as $item)
<div class="card" style="padding: 16px;margin: 2px;" onclick="setsenduser({{ $item->id }})">
    {{ $item->name }}
</div>
@endforeach
@endif
@if (isset($last_message_send_data))

@foreach ($last_message_send_data as $item)
<div class="card" style="padding: 16px;margin: 2px;" onclick="setsenduser({{ $item->user_data_to_message->id }})">
    {{ $item->user_data_to_message->name }}
</div>
@endforeach
@endif
