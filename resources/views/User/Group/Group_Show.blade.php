@extends('User.dashbord')

@section('content')
<style>
    .emoji-wrapper:hover .emoji-users {
        display: block !important;
    }

    /* Responsive group page styles */
    @media (max-width: 768px) {
        #searchpanel {
            width: 100% !important;
        }

        /* When sidebar is open, show both sidebar and group list side by side */
        body.rtc-menu-open #searchpanel {
            margin-left: 72px;
            width: calc(100% - 72px) !important;
            transition: margin-left 0.25s ease, width 0.25s ease;
        }

        #chatboardofreceiverGroup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 999;
        }

        .d-flex.bg-dark.text-white {
            padding: 12px !important;
            margin: 3px !important;
        }
    }

    @media (max-width: 576px) {
        .d-flex.bg-dark.text-white {
            padding: 10px !important;
        }

        input[type="search"] {
            font-size: 14px !important;
            padding: 8px 15px !important;
        }
    }

    #moreOptionDivMain {
        opacity: 0;
        transform: scale(0.70);
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
        pointer-events: none;
    }

    #moreOptionDivMain.show {
        opacity: 1;
        transform: scale(1);
        pointer-events: auto;
    }

</style>
<div id="searchpanel" class="col-sm-4 col-12" style="padding: 0px;">

    <div style="padding: 21px;background-color: transparent;position: relative;">
        <div class="d-flex">
            {{-- <div class="hover_change_all sm:hidden block" onclick="openMianMenu()">
                <i class="fa-solid fa-bars text-white"></i>
            </div> --}}
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div class="size-9 d-flex justify-content-center align-items-center" style="position: absolute;right: 7%;">
                <i class="fa-solid fa-ellipsis-vertical text-white" id="showMenuId" onclick="MainMoreOpetionShow()"></i>
            </div>
            <div id="moreOptionDivMain" style="border: 1px solid rgb(94 89 89); z-index: 999; padding: 6px; position: absolute; top: 97%; right: 3%; background-color: #161717; color:white; border-radius: 18px;">
                <div class="hover_change_all" style="padding: 5px;border-radius: 20px;">
                    <div class="d-flex">
                        <i class="fa-solid fa-circle-minus d-flex justify-content-center align-items-center"></i>
                        <div style="padding-left: 5px;font-family: 'Inter', sans-serif;" onclick="CreateGroupDiv()">
                            New Group
                        </div>
                    </div>
                </div>
                <div class="hover_change_all hover_change_all_remove" style="padding: 5px;border-radius: 20px;">
                    <div>
                        <a class="d-flex hover_change_all_remove text-white" style="text-decoration: none;" href="{{ route('logout') }}">
                            <i class="fa-solid fa-right-from-bracket d-flex justify-content-center align-items-center"></i>
                            <div style="padding-left: 5px;font-family: 'Inter', sans-serif;">
                                Logout
                            </div>

                        </a>
                    </div>
                </div>
            </div>
            <div class="text-white" style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <i class="fa-brands fa-sistrix" style="position: absolute;color: white;top: 16.5%;left: 12%;"></i>
    <div class="row" style="padding: 15px;background-color: transparent;margin: 0px;">
        <input style="padding-left: 41px;color: white;width: 91%;margin-left: 20px;background-color: transparent;border-radius: 20px;" autocomplete="off" id="searchfriendnameGroup" oninput="SearchGroup()" class="form-control" type="search" placeholder="Search" aria-label="Search" />
        {{-- <input style="color: white;width: 91%;margin-left: 20px;background-color: #2e2f2f;border-radius: 20px;border: none;" autocomplete="off" id="searchfriendnameGroup" oninput="SearchGroup()" class="form-control" type="search" placeholder="Search" aria-label="Search" /> --}}
    </div>

    {{-- here --}}
    <div class="scroll-container2" style="height:456px;padding: 0px 20px 7px 20px;background-color: transparent;overflow: scroll; padding-bottom: 80px;overflow-y: auto;padding: 0px 20px 7px 20px;">

        <div id="searchDiv">

            @if ($group->isNotEmpty())

            @if (isset($group))
            @foreach ($group as $item)

            <div class="d-flex hover_change_all text-white" id="g{{ $item->GroupData->id }}" style="border-radius: 16px;position: relative;padding: 16px;margin: 4px;">
                <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">

                    <div style="height: 37px;width: 37px;">
                        @if ($item->GroupData->image_path!=Null)
                        <img data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="imagesetshowGroup('{{ $item->GroupData->id }}','{{ $item->GroupData->name }}','{{ $item->GroupData->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->GroupData->image_path) }}" alt="">
                        @else
                        <img data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="imagesetshowGroup('{{ $item->GroupData->id }}','{{ $item->GroupData->name }}','freepik__talk__488.png')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/freepik__talk__488.png') }}" alt="">
                        @endif
                    </div>
                </div>

                <div style="width: 100%;display: flex;" onclick="setsendGroupMessage({{ $item->GroupData->id }})">
                    <div style="margin-left: 21px;display: flex;" id="{{ $item->GroupData->name }}">
                        {{ $item->GroupData->name }}
                    </div>
                </div>
                @if ($item->NotViewData->count()!=0)

                <div id="gc{{ $item->GroupData->id }}">
                    <div class="d-flex justify-content-center align-items-center" style="color: black;background: #21c063;height: 21px;width: 21px;border-radius: 20px;font-size: 15px;">
                        {{ $item->NotViewData->count() }}
                    </div>
                </div>
                @else

                <div id="gc{{ $item->GroupData->id }}" style="display: none">
                    <div class="d-flex justify-content-center align-items-center" style="color: black;background: #21c063;height: 21px;width: 21px;border-radius: 20px;font-size: 15px;">
                        {{ $item->NotViewData->count() }}
                    </div>
                </div>

                @endif

            </div>
            @endforeach
            @else
            <div class="text-white" style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
            @endif
            @else
            <div class="text-white" style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
            @endif
        </div>
    </div>
</div>

{{-- chatboard --}}
<div id="chatboardofreceiverGroup" class="d-sm-block d-none col-md-7 bg-cover bg-center" style="padding: 0px;background-image: url('{{ asset('img/background_image_message.png') }}');background-size: cover; background-position: center;">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 135px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-0 mb-0">
        <div class="modal-content" data-bs-theme="dark" style=" margin-bottom: 4px;background: #161717;width: 100%;border: 1px solid wheat;border-radius: 27px;margin-top: 4px;">
            <div style="text-align: end;padding: 5px 10px 0px 0px;">
                <button style="right: 11px;top: 9px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center" id="ImageShowUserImage_pathGroup" style="align-items: center;text-align: center;">

                </div>
                {{-- <h3 class="modal-title fs-5" style="color: white;padding: 18px;" id="ImageShowUserNameGroup"></h3> --}}
                <div class="d-flex" style="padding: 25px 25px 23px 18px;">
                    <input type="text" readonly style="border-radius: 0px;background: transparent;border: none;color: white;padding: 10px 0px;box-shadow: none;" class="form-control fw-bold" name="username" id="ImageShowUserNameGroup" value="{{ old('username',Auth::user()->name) }}">
                    <div class="d-flex justify-content-center align-items-center" onclick="editInputBox(this)">
                        <i class="fa-solid fa-pen-fancy text-white"></i>
                        <i class="fa-solid fa-check text-white" style="display: none"></i>
                    </div>
                </div>
            </div>
            <div id="userOfGroup" style="padding: 0px 20px 20px 20px;">

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function editmessagebyoneGroup(groupMessages) {

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('edit.get_message.group') }}"
            , data: {
                g_message_id: groupMessages
            }
            , success: function(res) {
                console.log(res);

                $("#messages").val(res['message']);
                localStorage.setItem('editMessageIdGroup', groupMessages);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    function SearchGroup() {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.search') }}"
            , data: {
                search_text: $('#searchfriendnameGroup').val()
            }
            , success: function(res) {
                $('#searchDiv').html(res);
                // console.log(res);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Clean Message in Group
    function ClearMessageByOneGroup(message_id, group_id) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.message.clean') }}"
            , data: {
                message_id: message_id
                , group_id: group_id
            }
            , success: function(res) {
                message_show_group(groupid)

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Group Images
    function OpenUpdateGroupImage() {
        $("#groupimage").click();
    }

    function SaveImageToGroup(gid) {

        var GroupName = $('#ImageShowUserNameGroup').val().trim();
        var fileInput = document.getElementById('groupimage');
        var formData = new FormData();
        formData.append('group_id', gid);

        // Check Group Name
        if (GroupName != "") {
            formData.append('groupname', GroupName);
        } else {
            Toastify({
                text: `Group Name is not Enter Empty`
                , duration: 5000
                , gravity: "top"
                , position: "center"
                , style: {
                    background: '#fbdfd2'
                    , color: "black"
                }
                , stopOnFocus: true
            , }).showToast();
        }

        // Check File is Exist or Not
        if (document.getElementById('groupimage').files.length != 0) {
            if (fileInput.files[0].name.split('.')[1] == 'png' || fileInput.files[0].name.split('.')[1] == 'jpg' || fileInput.files[0].name.split('.')[1] == 'svg') {
                formData.append('file', fileInput.files[0]);

            } else {
                Toastify({
                    text: `Enter Image is Only png or jpg or svg Images Allows`
                    , duration: 5000
                    , gravity: "top"
                    , position: "center"
                    , style: {
                        background: '#fbdfd2'
                        , color: "black"
                    }
                    , stopOnFocus: true
                , }).showToast();
            }

        }
        // const numberOfFields = Array.from(formData.entries()).length;
        // console.log("Total fields in form:", numberOfFields);
        // console.log(document.getElementById('groupimage').files.length != 0);
        // console.log(GroupName != "");


        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.image.store') }}"
            , data: formData
            , contentType: false
            , processData: false
            , success: function(res) {
                // console.log(res);
                window.location.href = "http://127.0.0.1:8000/groups";
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    function RemoveGroupImage(gid) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.image.remove') }}"
            , data: {
                group_id: gid
            }
            , success: function(res) {
                // console.log(res);
                window.location.href = "http://127.0.0.1:8000/groups";

            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    // Friend add in Groups
    function addFriendPage(gid) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , data: {
                group_id: gid
            }
            , url: "{{ route('group.add.friend.page') }}"
            , success: function(res) {
                $('#chatboardofreceiverGroup').html(res);
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    function ExistGroupAddFriend(group_id) {

        if (Select_User_Array.length == 0) {
            Toastify({
                text: `Select you friend...`
                , duration: 5000
                , gravity: "top"
                , position: "center"
                , style: {
                    background: '#fbdfd2'
                    , color: "black"
                }
                , stopOnFocus: true
            , }).showToast();
        } else {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('group.add.friend') }}"
                , data: {
                    group_id: group_id
                    , group_user: Select_User_Array
                }
                , success: function(res) {
                    Select_User_Array.length = 0;
                    window.location.href = "http://127.0.0.1:8000/groups";
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    // Forword Message
    function forwordmessageGroup(mid, mmessage) {
        localStorage.setItem('m_message', mmessage);

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.forword.message') }}"
            , success: function(res) {
                $('#chatboardofreceiverGroup').html(res);
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    let Select_User_Array_Forword_Group = new Array();

    function SelectedForwordUserGroup(thisdiv) {
        if ($(thisdiv).css('background-color') == 'rgba(208, 242, 208, 0.5)') {
            $(thisdiv).css('background-color', '#212529');

            const index = Select_User_Array_Forword_Group.indexOf($(thisdiv).data('id'));
            Select_User_Array_Forword_Group.splice(index, 1);

        } else {
            $(thisdiv).css('background-color', 'rgba(208, 242, 208, 0.5)');
            Select_User_Array_Forword_Group.push($(thisdiv).data('id'));
        }

    }

    function ForwordMessageUserSelectGroup(user_id) {
        $('#chatboardofreceiverGroup').html('');
        $('#loader').css('display', 'block');
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('message_send_specific_user') }}"
            , data: {
                message: localStorage.getItem('m_message')
                , receive_data_id_array: Select_User_Array_Forword_Group
            }
            , success: function(res) {
                $('#message_to_show').html(res);
                $('#messages').val('');
                $('#files').val('');

                $('#img-preview').html('');
                $('#messages').css('display', 'block');
                $('#img-preview').css('display', 'none');
                $('#messages').prop('readonly', false).attr('placeholder', 'Type Message Here...')
                $('#loader').css('display', 'none');
                window.location.href = "http://127.0.0.1:8000/dashboard";

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Remove messages
    function removeallmessageGroup(gid) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.message.remove.all') }}"
            , data: {
                messageGroupid: gid
            }
            , success: function(res) {
                message_show_group(gid);
                $('#moreoptiondiv').css('display', 'none');
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // remove specific message in group
    function removemessagebyoneGroup(messageid, groupid) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.message.remove') }}"
            , data: {
                messageid: messageid
                , groupid: groupid
            , }
            , success: function(res) {
                message_show_group(groupid)
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Emoji Group
    function emojigetshowGroup(div, message_id) {
        var message_div = $(div).parent().parent().parent().children().eq(1);
        var AutherName = "{{ Auth::user()->name }}";

        if ($(div).data('code') == 1) {

            if ($('#👍count').length) {
                $('#👍count').html(parseInt($('#👍count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="👍" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     👍
                        <span id="👍count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
        }
        if ($(div).data('code') == 2) {
            if ($('#❤️count').length) {
                $('#❤️count').html(parseInt($('#❤️count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="❤️" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     ❤️
                        <span id="❤️count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
            // var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;top: 85%;left: 6%;'>❤️</div>");
        }
        if ($(div).data('code') == 3) {
            if ($('#😂count').length) {
                $('#😂count').html(parseInt($('#😂count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="😂" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     😂
                        <span id="😂count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
            // var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;top: 85%;left: 6%;'>😂</div>");
        }
        if ($(div).data('code') == 4) {
            if ($('#😮count').length) {
                $('#😮count').html(parseInt($('#😮count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="😮" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     😮
                        <span id="😮count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
            // var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;top: 85%;left: 6%;'>😮</div>");
        }
        if ($(div).data('code') == 5) {
            if ($('#😢count').length) {
                $('#😢count').html(parseInt($('#😢count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="😢" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     😢
                        <span id="😢count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
            // var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;top: 85%;left: 6%;'>😢</div>");
        }
        if ($(div).data('code') == 6) {
            if ($('#😡count').length) {
                $('#😡count').html(parseInt($('#😡count').html()) + 1);

            } else {

                var newdiv = `<span class="emoji-wrapper" style="position:relative; display:inline-block;">
                    <span id="😡" style="background:#828CAC;border-radius:28px;padding:4px 8px;cursor:pointer;">
                     😡
                        <span id="😡count" style="font-size:12px;">
                            1
                        </span>
                    </span>
                    <!-- Hover User List -->
                    <div class="emoji-users" style="display:none;position:absolute;bottom:120%;left:0;background:#2c2f33;color:white;padding:8px 10px;border-radius:6px;font-size:12px;white-space:nowrap;z-index:999;">
                        <div>${AutherName}</div>
                    </div>
                </span>`;
            }
            // var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;top: 85%;left: 6%;'>😡</div>");
        }

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.message.emoji') }}"
            , data: {
                emoji_code: $(div).data('code')
                , message_id: message_id
            }
            , success: function(res) {

                if (res['group_id'] != null) {
                    message_show_group(res['group_id'])
                } else {
                    message_div.append(newdiv)
                }

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Exit Group
    function ExitGroup(gid) {
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.exit') }}"
            , data: {
                group_id: gid
            }
            , success: function(res) {
                // $('#userOfGroup').html(res);
                window.location.href = "http://127.0.0.1:8000/groups";
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    function editInputBox(thisDiv) {

        if ($($(thisDiv).children()[1]).css('display') == 'none') {
            $($(thisDiv).children()[0]).css('display', 'none');
            $($(thisDiv).children()[1]).css('display', 'block');
            $(thisDiv).parent().children().eq(0).prop('readonly', false);
            $(thisDiv).parent().children().eq(0).css("border-bottom", "1px solid");

        } else {
            $($(thisDiv).children()[0]).css('display', 'block');
            $($(thisDiv).children()[1]).css('display', 'none');
            $(thisDiv).parent().children().eq(0).prop('readonly', true);
            $(thisDiv).parent().children().eq(0).css("border-bottom", "none");

        }
    }

    // Group User List Show in Model
    function imagesetshowGroup(gid, name, image_path) {

        $('#ImageShowUserNameGroup').val(name);
        $('#ImageShowUserImage_pathGroup').html(`
            <img id="imagePreview" style="height: 47%;width: 47%;object-fit: contain;" src="storage/img/${image_path}" alt="">
            `);

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.user.show.all') }}"
            , data: {
                group_id: gid
            }
            , success: function(res) {
                $('#userOfGroup').html(res);
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Remove Group User
    function RemoveGroupUser(groupuserid) {

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.friend.remove') }}"
            , data: {
                groupuserid: groupuserid
            }
            , success: function(res) {

                $.ajax({
                    type: 'post'
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: "{{ route('group.user.show.all') }}"
                    , data: {
                        group_id: res['group_id']
                    }
                    , success: function(res) {
                        $('#userOfGroup').html(res);
                    }
                    , error: function(e) {
                        console.log(e);
                    }
                });
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    $(document).ready(function() {

        // if ("{{ isset($group[0]->group_id) }}") {
        //     setsendGroupMessage("{{ isset($group[0]->group_id)?$group[0]->group_id:'' }}");
        // }
    });

    function message_show_group(gid) {
        $.ajax({
            type: 'get'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.message.show') }}"
            , data: {
                group_id: gid
            }
            , success: function(res) {
                $('#message_to_show').html(res);
                $('#messages').val('');
                const element = document.getElementById("scrollbarid");
                element.scrollTop = element.scrollHeight;

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    function sendmessagetosenderGroup(gid, message) {

        $("#sendmessageid").css('background-color', 'rgb(33, 37, 41)');

        document.getElementById('messages').rows = 1;
        if (message == null) {

            var message_data_of = $('#messages').val().replace(/\s/g, '');
            if (message_data_of.length == 0) {
                $('#messages').val('');
            } else {
                var message_data = $('#messages').val();
                $('#messages').val('');
                $('#messages').attr('placeholder', 'Sending...').prop('readonly', true);
            }
        } else {
            var message_data = message;
        }

        if (message_data != null && document.getElementById('files').files.length == 0) {

            var formData = new FormData();
            formData.append('message', message_data);
            formData.append('group_id', gid);
            console.log(localStorage.getItem('editMessageIdGroup'));

            if (localStorage.getItem('editMessageIdGroup') != "null") {
                formData.append('editId', localStorage.getItem('editMessageIdGroup'));
            }

        }
        if (message_data == null && document.getElementById('files').files.length != 0) {

            var formData = new FormData();
            formData.append('message', message_data);
            formData.append('group_id', gid);

            $("#messages").css('display', "block")
            $("#img-preview").css('display', "none")
            $('#messages').val('');
            $('#messages').attr('placeholder', 'Sending...').prop('readonly', true);

            var fileInput = document.getElementById('files');

            if (fileInput.files.length > 0) {
                for (var i = 0; i < fileInput.files.length; i++) {
                    if (fileInput.files[i].name.split('.')[1] == 'png' || fileInput.files[i].name.split('.')[1] == 'jpg' || fileInput.files[i].name.split('.')[1] == 'svg' || fileInput.files[i].name.split('.')[1] == 'pdf') {

                        formData.append('files[]', fileInput.files[i]);
                    } else {
                        $('#img-preview').html('');
                        $('#files').val('');
                        $('#img-preview').css('display', "none");
                        $('#messages').css('display', "block");
                        $('#messages').val('');
                        $('#messages').attr('placeholder', 'Type Message Here...').prop('readonly', false);
                        Toastify({
                            text: `Enter Image is Only png or jpg Images Allows`
                            , duration: 5000
                            , gravity: "top"
                            , position: "center"
                            , style: {
                                background: '#fbdfd2'
                                , color: "black"
                            }
                            , stopOnFocus: true
                        , }).showToast();
                    }
                }
            }
        }

        if (message_data != null || document.getElementById('files').files.length != 0) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('group.send.message') }}"
                , data: formData
                , contentType: false
                , processData: false
                , success: function(res) {
                    $('#message_to_show').html(res);
                    $('#messages').val('');
                    $('#files').val('');
                    $('#emoji_picker').css('display', 'none');
                    $('#img-preview').html('');
                    $('#messages').css('display', 'block');
                    $('#img-preview').css('display', 'none');
                    $('#messages').prop('readonly', false).attr('placeholder', 'Type Message Here...')

                    localStorage.setItem('editMessageIdGroup', null);
                    message_show_group(gid)
                    const element = document.getElementById("scrollbarid");
                    element.scrollTop = element.scrollHeight;
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    function setsendGroupMessage(gid) {

        if ($('#chatboardofreceiverGroup').css('display') == "none") {
            $('#searchpanel').css('display', "none");
            $('#chatboardofreceiverGroup').css('display', "block");
            $('#chatboardofreceiverGroup').css('width', "100%");
        }

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('group.chatbort') }}"
            , data: {
                group_id: gid
            }
            , success: function(res) {
                localStorage.setItem('current_group_chatboard', gid);
                $('#chatboardofreceiverGroup').html(res);
                $($(`#gc${gid}`).children()[0]).html(0);
                $(`#gc${gid}`).css("display", "none");
                message_show_group(gid);
                Select_User_Array_Forword_Group.length = 0;
                Tolltip_Intialization_Group();
                CountNotificationMessages();
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    function Tolltip_Intialization_Group() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    }

</script>
@endsection
