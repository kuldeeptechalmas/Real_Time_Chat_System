<div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 90px;overflow-y: auto;" id="scrollbarid">
    @foreach ($message as $item)

    @if ($item->send_id==Auth::user()->id)
    <div class="messagehover" id="m{{ $item->id }}" style="margin: 18px 14px 14px 14px;display: flex;justify-content: flex-end;">
        <div class="messagehovercontent" onclick="removemessagebyone({{ $item->id }})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-right: 13px;padding: 4px;cursor: default;">
            Remove
        </div>

        <div class="w_message d-flex gap-2">
            <div class="sub-w_message" style="position: relative;background: #fdf1ec;padding: 28px 7px 7px 7px;border-radius: 10px 0px 10px 10px;cursor: default;min-width: 72px;">

                @php
                $etc = explode('.',$item->message);
                @endphp

                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg'|| $etc[1]=='svg'|| $etc[1]=='pdf')
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
                @if ($item->response==1)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>👍</div>
                @endif
                @if ($item->response==2)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>❤️</div>
                @endif
                @if ($item->response==3)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😂</div>
                @endif
                @if ($item->response==4)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😮</div>
                @endif
                @if ($item->response==5)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😢</div>
                @endif
                @if ($item->response==6)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😡</div>
                @endif
                {{-- </div> --}}
            </div>
        </div>

    </div>
    @else
    {{-- @dump($item) --}}
    <div class="messagehover" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;">
        <div class="w_message d-flex gap-2" style="position: relative;">

            <div style="min-width: 66px;position: relative;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
                @php
                $etc = explode('.',$item->message);
                @endphp
                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg' || $etc[1]=='svg'|| $etc[1]=='pdf')
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
                @if ($item->response==1)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>👍</div>
                @endif
                @if ($item->response==2)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>❤️</div>
                @endif
                @if ($item->response==3)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😂</div>
                @endif
                @if ($item->response==4)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😮</div>
                @endif
                @if ($item->response==5)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😢</div>
                @endif
                @if ($item->response==6)
                <div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😡</div>
                @endif
            </div>
        </div>

        <div class="emoji-bar">
            <div class="emoji-reaction" data-reaction="like">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="1">👍</div>
            </div>
            <div class="emoji-reaction" data-reaction="love">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="2">❤️</div>
            </div>
            <div class="emoji-reaction" data-reaction="haha">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="3">😂</div>
            </div>
            <div class="emoji-reaction" data-reaction="wow">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="4">😮</div>
            </div>
            <div class="emoji-reaction" data-reaction="sad">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="5">😢</div>
            </div>
            <div class="emoji-reaction" data-reaction="angry">
                <div class="emoji" onclick="emojigetshow(this,'{{ $item->id }}')" data-code="6">😡</div>
            </div>
            <div class="emoji-reaction" onclick="removemessagebyone({{ $item->id }})">
                <div class="emoji">Remove</div>
            </div>
            <div class="emoji-reaction" onclick="forwordmessage('{{ $item->id }}',`{{ $item->message }}`)">
                <div class="emoji"><i class="fa-regular fa-share-from-square"></i></div>
            </div>
        </div>
        {{-- <div class="messagehovercontent" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">
            Remove
        </div> --}}

    </div>
    @endif
    @endforeach
</div>
