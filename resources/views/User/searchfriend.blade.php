@foreach ($user_data as $item)
<div class="card" style="padding: 16px;margin: 2px;" onclick="setsenduser({{ $item->id }})">
    {{ $item->name }}
</div>
@endforeach
