{{-- <div style="height: 500px;overflow: scroll; margin-bottom: 60px;"> --}}

<div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" id="scrollbarid">
    @foreach ($message as $item)
    @if ($item->send_id==Auth::user()->id)
    <div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-end;">
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-right: 13px;padding: 4px;cursor: default;">
            Remove
        </div>

        <div class="w_message d-flex gap-2">
            <div style="background: #fdf1ec;padding: 7px;border-radius: 10px 0px 10px 10px;cursor: default;">

                @php
                $etc = explode('.',$item->message);
                @endphp

                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg')
                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>
                @endif

                @else
                {!! nl2br(e($item->message)) !!}

                @endif

                <span style="font-size: 11px;">{{ $item->created_at->timezone('Asia/Kolkata')->format('g:i a') }}</span>
                @if ($item->status=='send')
                <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                @endif
                @if ($item->status=='view')
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-left: 5px;margin-right: -23px;"></i>
                <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;"></i>
                @endif
            </div>
        </div>

    </div>
    @else
    <div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-start;">
        <div class=w_message d-flex gap-2">

            <div style="background: #fbdfd2;padding: 7px;border-radius: 0px 10px 10px;cursor: default;">
                @php
                $etc = explode('.',$item->message);
                @endphp

                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg')
                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>
                @endif

                @else
                {!! nl2br(e($item->message)) !!}

                @endif
                <span style="font-size: 11px;">{{ $item->created_at->timezone('Asia/Kolkata')->format('g:i a') }}</span>
            </div>

        </div>
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">
            Remove
        </div>
    </div>
    @endif
    @endforeach
</div>
