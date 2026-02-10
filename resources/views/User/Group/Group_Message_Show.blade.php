{{-- <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 90px;overflow-y: auto;" id="scrollbarid"> --}}
<div class="scroll-container1" style="height: 409px;overflow: scroll;overflow-x: hidden;" id="scrollbarid">

    @php
    $previosDate = null;
    @endphp

    @foreach ($message as $item)

    {{-- Date Show Code --}}
    @if ($previosDate!=$item->created_at->format('l, j F'))

    @if ($item->created_at->format('l, j F')==now()->format('l, j F'))

    <div style="position: relative">
        <hr>
        <div style="padding: 0px 20px;background: white;position: absolute;top: -14px;left: 44%;height: 30px;display: flex;justify-content: center;border: 1px solid #cbbbbb;border-radius: 20px;">
            Today
        </div>
    </div>

    @elseif($item->created_at->format('l, j F')==now()->yesterday()->format('l, j F'))

    <div style="position: relative">
        <hr>
        <div style="padding: 0px 20px;background: white;position: absolute;top: -14px;left: 44%;height: 30px;display: flex;justify-content: center;border: 1px solid #cbbbbb;border-radius: 20px;">
            Yesterday
        </div>
    </div>

    @else
    <div style="position: relative">
        <hr>
        <div style="padding: 0px 20px;background: white;position: absolute;top: -14px;left: 44%;height: 30px;display: flex;justify-content: center;border: 1px solid #cbbbbb;border-radius: 20px;">
            {{ $item->created_at->format('l, j F') }}
        </div>
    </div>

    @endif

    @php
    $previosDate = $item->created_at->format('l, j F');
    @endphp
    @endif

    @php
    $etc = explode('.',$item->message);
    @endphp

    @if ($item->user_id==Auth::id())
    @if ($item->GroupMessageDeleteAtData->isNotEmpty())

    <div class="messagehover sender_message" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-end;">
        <div class="emoji-bar">
            <div class="emoji-reaction" onclick="removemessagebyoneGroup({{ $item->id }},{{ $item->group_id }})">
                <div class="emoji">Remove</div>
            </div>
            <div class="emoji-reaction" onclick="ClearMessageByOneGroup('{{ $item->id }}','{{ $item->group_id }}')">
                <div class="emoji">Clear</div>
            </div>
            <div class="emoji-reaction" onclick="forwordmessageGroup('{{ $item->id }}',`{{ $item->message }}`)">
                <div class="emoji"><i class="fa-regular fa-share-from-square"></i></div>
            </div>

            @if (isset($etc[1]))
            <div class="emoji-reaction">
                <a href="/pdf-download/{{ $item->message }}" style="color: black;" rel="noopener noreferrer">
                    <div class="emoji"><i class="fa-solid fa-download"></i></div>
                </a>
            </div>
            @endif
        </div>

        <div class="w_message d-flex gap-2">
            <div class="sub-w_message" style="position: relative;background: #fdf1ec;padding: 28px 7px 7px 7px;border-radius: 10px 0px 10px 10px;cursor: default;min-width: 160px;">
                <div style="position: absolute;display: flex;top: 0px;left: 0px;">
                    <div style="height: 21px;width: 21px;">

                        @if ($item->UserData->image_path==Null)
                        @if ($item->UserData->gender=='Men')
                        <img style="height: 100%;width: 100%;border-radius: 18px;" src="{{ asset('img/male.png') }}" alt="">
                        @else
                        <img style="height: 100%;width: 100%;border-radius: 18px;" src="{{ asset('img/female.png') }}" alt="">
                        @endif
                        @else
                        {{-- <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.Auth::user()->image_path) }}" alt=""> --}}
                        <img style="height: 100%;width: 100%;border-radius: 18px;object-fit: cover;" src="{{ asset('storage/img/'.$item->UserData->image_path) }}" alt="">
                        @endif
                    </div>
                    <div>
                        {{ $item->UserData->name }}
                    </div>
                </div>
                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg'|| $etc[1]=='svg'|| $etc[1]=='pdf')
                @if ($etc[1]=='pdf')
                <div style="height: 210px;width: 239px;">
                    <a href="/pdf-view/{{ $item->message }}" target="_blank">
                        <img style="height: 89%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/pdf_image.png') }}" alt="">
                    </a>
                    <div style="padding-left: 16px;">{{ $item->message }}</div>
                </div>
                @else

                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>

                @endif
                @else
                {!! nl2br(e($item->message)) !!}
                @endif

                @else
                {!! nl2br(e($item->message)) !!}
                @endif

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

            </div>
        </div>

    </div>

    @endif

    @else
    {{-- Receive Message of Group --}}
    @if ($item->GroupMessageDeleteAtData->isNotEmpty())

    <div class="messagehover receiver_message" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;">
        <div class="w_message d-flex gap-2" style="position: relative;">

            <div style="min-width: 160px;position: relative;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
                @php
                $etc = explode('.',$item->message);
                @endphp
                @if (isset($etc[1]))
                @if ($etc[1]=='png' || $etc[1]=='jpg' || $etc[1]=='svg'|| $etc[1]=='pdf')
                @if ($etc[1]=='pdf')
                <div style="height: 210px;width: 239px;">
                    <a href="/pdf-view/{{ $item->message }}" target="_blank">
                        <img style="height: 89%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/pdf_image.png') }}" alt="">
                    </a>
                    <div style="padding-left: 16px;">{{ $item->message }}</div>
                </div>
                @else

                <div style="height: 192px;width: 239px;">
                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->message }}','{{ $item->message }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$item->message) }}" alt="">
                </div>

                @endif

                @else
                {!! nl2br(e($item->message)) !!}
                @endif

                @else
                {!! nl2br(e($item->message)) !!}

                @endif
                <div style="position: absolute;display: flex;top: 0px;left: 0px;">
                    <div style="height: 21px;width: 21px;">

                        @if ($item->UserData->image_path==Null)
                        @if ($item->UserData->gender=='Men')
                        <img style="height: 100%;width: 100%;border-radius: 18px;" src="{{ asset('img/male.png') }}" alt="">
                        @else
                        <img style="height: 100%;width: 100%;border-radius: 18px;" src="{{ asset('img/female.png') }}" alt="">
                        @endif
                        @else
                        <img style="height: 100%;width: 100%;border-radius: 18px;object-fit: cover;" src="{{ asset('storage/img/'.$item->UserData->image_path) }}" alt="">
                        @endif
                    </div>
                    <div>
                        {{ $item->UserData->name }}
                    </div>
                </div>
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
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="1">👍</div>
            </div>
            <div class="emoji-reaction" data-reaction="love">
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="2">❤️</div>
            </div>
            <div class="emoji-reaction" data-reaction="haha">
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="3">😂</div>
            </div>
            <div class="emoji-reaction" data-reaction="wow">
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="4">😮</div>
            </div>
            <div class="emoji-reaction" data-reaction="sad">
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="5">😢</div>
            </div>
            <div class="emoji-reaction" data-reaction="angry">
                <div class="emoji" onclick="emojigetshowGroup(this,'{{ $item->id }}')" data-code="6">😡</div>
            </div>
            <div class="emoji-reaction" onclick="removemessagebyoneGroup({{ $item->id }},{{ $item->group_id }})">
                <div class="emoji">Remove</div>
            </div>
            <div class="emoji-reaction" onclick="forwordmessageGroup('{{ $item->id }}',`{{ $item->message }}`)">
                <div class="emoji"><i class="fa-regular fa-share-from-square"></i></div>
            </div>

            @if (isset($etc[1]))
            <div class="emoji-reaction">
                <a href="/pdf-download/{{ $item->message }}" style="color: black;" rel="noopener noreferrer">
                    <div class="emoji"><i class="fa-solid fa-download"></i></div>
                </a>
            </div>
            @endif

        </div>
    </div>

    @endif
    {{-- @endif
    @endforeach --}}

    @endif

    @endforeach
</div>
