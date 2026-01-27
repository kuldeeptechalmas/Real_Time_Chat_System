@if ($group->isNotEmpty())


@if (isset($group))
@foreach ($group as $item)
@if (isset($item->GroupData))


<div class="d-flex bg-white" id="{{ $item->GroupData->id }}" style="position: relative;padding: 16px;margin: 4px;">
    <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
        @if ($item->GroupData->image_path!=Null)
        <img data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="imagesetshowGroup('{{ $item->GroupData->id }}','{{ $item->GroupData->name }}','{{ $item->GroupData->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->GroupData->image_path) }}" alt="">
        @else
        <img data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="imagesetshowGroup('{{ $item->GroupData->id }}','{{ $item->GroupData->name }}','freepik__talk__488.png')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/freepik__talk__488.png') }}" alt="">
        @endif
    </div>

    <div style="width: 100%;display: flex;" onclick="setsendGroupMessage({{ $item->GroupData->id }})">
        <div style="margin-left: 21px;display: flex;" id="{{ $item->GroupData->name }}">
            {{ $item->GroupData->name }}
        </div>
    </div>
</div>
@endif
@endforeach
@else
<div style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
@endif
@else
<div style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
@endif
