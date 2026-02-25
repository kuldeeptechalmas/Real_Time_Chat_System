<div class="scroll-container1 message_div_width" style="height: 456px;padding-bottom: 20px;overflow: scroll;overflow-x: hidden;" id="scrollbarid">

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

    <div class="messagehover " id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-end;">

        <div class="w_message sender_message d-flex gap-2">

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

                <div style="width:196px;height:192px">
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

    <div class="messagehover" id="m{{ $item->id }}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;">

        <div class="w_message d-flex gap-2 receiver_message" style="position: relative;">

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

                <div style="width:196px;height:192px">
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
                <div class="emoji-reaction" style="width: 86px;font-size: 14px;display: flex;justify-content: center;align-items: center;" onclick="removemessagebyone({{ $item->id }})">
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


    </div>
    @endif
    @endforeach

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function deleteallmessage(chatboard_user_id) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('message_remove_current_all.delete') }}"
            , data: {
                chatboard_user_id: chatboard_user_id
            }
            , success: function(res) {
                $('#moreoptiondiv').css('display', 'none')
                message_show(chatboard_user_id);
                userfriendlist();
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

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
