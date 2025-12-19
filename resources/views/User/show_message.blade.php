{{-- <div style="height: 500px;overflow: scroll; margin-bottom: 60px;"> --}}

<div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 60px;overflow-y: auto;" id="scrollbarid">
    @foreach ($message as $item)
    @if ($item->send_id==Auth::user()->id)
    <div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-end;">
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-right: 13px;padding: 4px;cursor: default;">
            Remove
        </div>
        <div class="w_message d-flex gap-2">
            <div style="background: #fdf1ec;padding: 7px;border-radius: 10px 0px 10px 10px;cursor: default;">
                {{ $item->message }}
            </div>
        </div>

    </div>
    @else
    <div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-start;">
        <div class=w_message d-flex gap-2">

            <div style="background: #fbdfd2;padding: 7px;border-radius: 0px 10px 10px;cursor: default;">
                {{ $item->message }}
            </div>

        </div>
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">
            Remove
        </div>
    </div>
    @endif
    @endforeach
</div>
