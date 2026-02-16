<div class="scroll-container1" style="padding-bottom: 20px;height: 409px;overflow: scroll;overflow-x: hidden;" id="scrollbarid">

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

    {{-- Message show User --}}
    {{-- Message Receive then condition is True --}}
    @if ($item->send_id==Auth::user()->id)
    @php
    $etc = explode('.',$item->message);
    @endphp

    <div class="messagehover sender_message" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-end;">
        <div class="emoji-bar">
            <div class="emoji-reaction" onclick="removemessagebyone({{ $item->id }})">
                <div class="emoji">Remove</div>
            </div>
            @if ($item->message!='This Message is Deleted')

            @if (isset($etc[1]))
            @if ($etc[1]!='png' || $etc[1]!='jpg' || $etc[1]!='svg'|| $etc[1]!='pdf')

            @else
            <div class="emoji-reaction" onclick="editmessagebyone('{{ $item->id }}')">
                <div class="emoji">Edit</div>
            </div>

            @endif
            @else
            <div class="emoji-reaction" onclick="editmessagebyone('{{ $item->id }}')">
                <div class="emoji">Edit</div>
            </div>
            @endif

            <div class="emoji-reaction" onclick="ClearMessageByOne({{ $item->id }})">
                <div class="emoji">Clear</div>
            </div>

            <div class="emoji-reaction" onclick="forwordmessage('{{ $item->id }}',`{{ $item->message }}`)">
                <div class="emoji"><i class="fa-regular fa-share-from-square"></i></div>
            </div>

            @endif


            @if (isset($etc[1]))
            @if ($etc[1]=='png' || $etc[1]=='jpg' || $etc[1]=='svg'|| $etc[1]=='pdf')
            <div class="emoji-reaction">
                <a href="/pdf-download/{{ $item->message }}" style="color: black;" rel="noopener noreferrer">
                    <div class="emoji"><i class="fa-solid fa-download"></i></div>
                </a>
            </div>
            @endif
            @endif
        </div>

        {{-- use to arrow code --}}
        {{-- <div class="showoption text-white" style="border: 1px solid rebeccapurple;border-radius: 12px;background-color:#1c1d1d;z-index: 999;position: absolute;display: none;right: 21%;width: 209px;">
            <div style="padding: 10px">
                <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="removemessagebyone({{ $item->id }})">
        <i class="fa-regular fa-trash-can d-flex align-items-center" style="padding-left: 10px;"></i>
        <span style="padding-left: 17px;">Delete</span>
    </div>

    @if ($item->message!='This Message is Deleted')

    @if (isset($etc[1]))
    @if ($etc[1]!='png' || $etc[1]!='jpg' || $etc[1]!='svg'|| $etc[1]!='pdf')

    @else
    <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="editmessagebyone('{{ $item->id }}')">
        <i class="fa-regular fa-pen-to-square d-flex align-items-center" style="padding-left: 10px;"></i>
        <span style="padding-left: 17px;">Edit</span>
    </div>

    @endif
    @else
    <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="editmessagebyone('{{ $item->id }}')">
        <i class="fa-regular fa-pen-to-square d-flex align-items-center" style="padding-left: 10px;"></i>
        <span style="padding-left: 17px;">Edit</span>
    </div>
    @endif

    <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="ClearMessageByOne({{ $item->id }})">
        <i class="fa-solid fa-circle-minus d-flex align-items-center" style="padding-left: 10px;"></i>
        <span style="padding-left: 17px;">Clear</span>
    </div>

    <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="forwordmessage('{{ $item->id }}',`{{ $item->message }}`)">
        <i class="fa-regular fa-share-from-square d-flex align-items-center" style="padding-left: 10px;"></i>
        <span style="padding-left: 17px;">Forword</span>
    </div>

    @endif

</div>

</div> --}}

<div class="w_message d-flex gap-2">
    <div class="sub-w_message" style="position: relative;background: #fdf1ec;padding: 28px 7px 7px 7px;border-radius: 10px 0px 10px 10px;cursor: default;min-width: 102px;">

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
            <div class="showmoareoptionArrow" onclick="showOtherOption(this)">
                <div class="d-flex" style="height: 8px;justify-content: center;">
                    <i class="fa-solid fa-angle-down m-0" style="font-size: 11px;"></i>
                </div>
            </div>

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

@else
{{-- Message Send then condition is True --}}

{{-- <div class="messagehover receiver_message" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;"> --}}
<div class="messagehover receiver_message" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;">
    {{-- <div class="showoption text-white" style="border: 1px solid rebeccapurple;border-radius: 12px;background-color:#1c1d1d;z-index: 999;position: absolute;display: none;right: 44%;width: 209px;">
        <div style="padding: 10px">

            <div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="removemessagebyone({{ $item->id }})">
    <i class="fa-regular fa-trash-can d-flex align-items-center" style="padding-left: 10px;"></i>
    <span style="padding-left: 17px;">Delete</span>
</div>

@if ($item->message!='This Message is Deleted')

<div class="d-flex hover_change_all" style="border-radius: 10px;padding: 5px;" onclick="forwordmessage('{{ $item->id }}',`{{ $item->message }}`)">
    <i class="fa-regular fa-share-from-square d-flex align-items-center" style="padding-left: 10px;"></i>
    <span style="padding-left: 17px;">Forword</span>
</div>
@endif

</div>

</div> --}}

<div class="w_message d-flex gap-2" style="position: relative;">

    <div style="min-width: 102px;position: relative;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
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
        {{-- {{ $item->message }} --}}

        @endif
        <div style="position: absolute;top: 0px;right: 16px;display: flex;">
            <span style="font-size: 11px;">{{ $item->created_at->timezone('Asia/Kolkata')->format('g:i a') }}</span>
            <div class="showmoareoptionArrow" onclick="showOtherOptionSenderMessage(this)">
                <div class="d-flex" style="padding-top: 5px;justify-content: center;">
                    <i class="fa-solid fa-angle-down m-0" style="font-size: 11px;"></i>
                </div>
            </div>
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

    @if (isset($etc[1]))
    @if ($etc[1]=='png' || $etc[1]=='jpg' || $etc[1]=='svg'|| $etc[1]=='pdf')
    <div class="emoji-reaction">
        <a href="/pdf-download/{{ $item->message }}" style="color: black;" rel="noopener noreferrer">
            <div class="emoji"><i class="fa-solid fa-download"></i></div>
        </a>
    </div>
    @endif
    @endif

</div>
</div>
@endif
@endforeach

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function editmessagebyone(message_id) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('edit.get_message') }}"
            , data: {
                message_id: message_id
            }
            , success: function(res) {
                $("#messages").val(res['message']);
                localStorage.setItem('editMessageId', message_id);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

</script>
