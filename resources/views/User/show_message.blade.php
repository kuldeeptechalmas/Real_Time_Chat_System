<div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 90px;overflow-y: auto;" id="scrollbarid">
    @foreach ($message as $item)

    @if ($item->send_id==Auth::user()->id)
    <div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-end;">
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-right: 13px;padding: 4px;cursor: default;">
            Remove
        </div>

        <div class="w_message d-flex gap-2">
            <div style="position: relative;background: #fdf1ec;padding: 28px 7px 7px 7px;border-radius: 10px 0px 10px 10px;cursor: default;min-width: 72px;">

                @php
                $etc = explode('.',$item->message);
                @endphp

                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg')
                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>
                @else
                {!! nl2br(e($item->message)) !!}
                @endif

                @else
                {!! nl2br(e($item->message)) !!}
                {{-- {{ $item->message }} --}}

                @endif

                {{-- <div style="position: absolute;top: 5px;right: 6px;"> --}}
                <div style="position: absolute;top: 0%;right: 3%;" class="d-flex justify-content-end align-items-center mt-2">
                    <span style="font-size: 11px;">{{ $item->created_at->timezone('Asia/Kolkata')->format('g:i a') }}</span>
                    @if ($item->status=='send')
                    <i class="fa-solid fa-check" style="font-size: 11px;"></i>
                    @endif
                    @if ($item->status=='view')
                    <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: -9px;"></i>
                    <i class="fa-solid fa-check" style="color: #7a7afc;font-size: 11px;margin-right: 1px;"></i>
                    @endif
                </div>
                {{-- </div> --}}
            </div>
        </div>

    </div>
    @else
    {{-- @dump($item) --}}
    <div class="messagehover " style="position: relative;margin: 14px;display: flex;justify-content: flex-start;">
        <div class="w_message d-flex gap-2">

            <div style="min-width: 66px;position: relative;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
                @php
                $etc = explode('.',$item->message);
                @endphp
                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg')
                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>

                @else
                {!! nl2br(e($item->message)) !!}
                @endif

                @else
                {!! nl2br(e($item->message)) !!}
                {{-- {{ $item->message }} --}}

                @endif
                <div style="position: absolute;top: 0px;right: 16px;">
                    <span style="font-size: 11px;">{{ $item->created_at->timezone('Asia/Kolkata')->format('g:i a') }}</span>
                </div>
            </div>
        </div>

        <div class="emoji-bar">
            <div class="emoji-reaction" data-reaction="like">
                <div class="emoji">👍</div>
            </div>
            <div class="emoji-reaction" data-reaction="love">
                <div class="emoji">❤️</div>
            </div>
            <div class="emoji-reaction" data-reaction="haha">
                <div class="emoji">😂</div>
            </div>
            <div class="emoji-reaction" data-reaction="wow">
                <div class="emoji">😮</div>
            </div>
            <div class="emoji-reaction" data-reaction="sad">
                <div class="emoji">😢</div>
            </div>
            <div class="emoji-reaction" data-reaction="angry">
                <div class="emoji">😡</div>
            </div>
            <div class="emoji-reaction" onclick="removemessagebyone({{ $item->id }})">
                <div class="emoji">Remove</div>
            </div>
        </div>
        {{-- <div class="messagehovercontent" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">
            Remove
        </div> --}}

    </div>
    @endif
    @endforeach
</div>
