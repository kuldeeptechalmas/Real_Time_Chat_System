@extends('User.dashbord')

@section('content')
<div class="col-4 bg-light" style="padding: 0px;">

    <div style="padding: 21px;background-color: #fbdfd2">
        <div class="d-flex">
            <div style="height: 26px;width: 49px;">
                <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
            </div>
            <div style="display: flex;align-items: center;margin-left: 20px;">
                Real Time Chat
            </div>
        </div>
    </div>
    <div class="row" style="padding: 15px;">
        <input style="width: 87%;margin-left: 20px;" autocomplete="off" id="searchfriendnameGroup" oninput="SearchGroup()" class="form-control" type="search" placeholder="Search" aria-label="Search" />
    </div>

    {{-- here --}}
    <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">

        <div onclick="CreateGroupDiv()" style="display: flex;justify-content: center;align-items: center;font-size: 21px;position: absolute;background: #828CAC;border-radius: 27px;bottom: 20px;right: 61%;z-index: 99;height: 40px;width: 40px;">
            <i class="fa-solid fa-plus" style="color: white;"></i>
        </div>
        <div id="searchDiv">


            @if ($group->isNotEmpty())


            @if (isset($group))
            @foreach ($group as $item)

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
            @endforeach
            @else
            <div style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
            @endif
            @else
            <div style="padding: 144px 20px 20px 20px;display: flex;justify-content: center;">Group Data is Not found</div>
            @endif
        </div>
    </div>
</div>

{{-- chatboard --}}
<div class="col-7" style="background: white;padding: 0px;" id="chatboardofreceiverGroup">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog mt-0 mb-0">
        <div class="modal-content" style="background: white;">
            <div style="text-align: end;padding: 5px 10px 0px 0px;">
                <button style="right: 11px;top: 9px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ImageShowUserImage_pathGroup" style="align-items: center;text-align: center;">

                </div>
                <h3 class="modal-title fs-5" style="text-align: center;" id="ImageShowUserNameGroup"></h3>
            </div>
            <div id="userOfGroup" style="padding: 0px 20px 20px 20px;">

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    

    function SearchGroup() {
        console.log($('#searchfriendnameGroup').val());
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
                console.log(res);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Clean Message in Group
    function ClearMessageByOneGroup(message_id, group_id) {
        console.log(message_id);
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
                // $('#message_to_show').html(res);
                // const element = document.getElementById("scrollbarid");
                // element.scrollTop = element.scrollHeight;

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

        if (document.getElementById('groupimage').files.length != 0) {
            var fileInput = document.getElementById('groupimage');
            if (fileInput.files[0].name.split('.')[1] == 'png' || fileInput.files[0].name.split('.')[1] == 'jpg' || fileInput.files[0].name.split('.')[1] == 'svg') {
                var formData = new FormData();
                formData.append('group_id', gid);
                formData.append('file', fileInput.files[0]);

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
                        console.log(res);
                        window.location.href = "http://127.0.0.1:8000/Groups";
                    }
                    , error: function(e) {
                        console.log(e);
                    }
                });

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

    }

    function RemoveGroupImage(gid) {
        console.log(gid);
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
                console.log(res);
                window.location.href = "http://127.0.0.1:8000/Groups";

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

            console.log(Select_User_Array);

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
                    window.location.href = "http://127.0.0.1:8000/Groups";
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
            $(thisdiv).css('background-color', 'rgb(255, 255, 255)');

            const index = Select_User_Array_Forword_Group.indexOf($(thisdiv).data('id'));
            Select_User_Array_Forword_Group.splice(index, 1);

        } else {
            $(thisdiv).css('background-color', 'rgba(208, 242, 208, 0.5)');
            Select_User_Array_Forword_Group.push($(thisdiv).data('id'));
        }

        console.log(Select_User_Array_Forword_Group);


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

        var message_div = $(div).parent().parent().parent().find('div.w_message.d-flex.gap-2').children()[0];

        if ($(div).data('code') == 1) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>👍</div>");
        }
        if ($(div).data('code') == 2) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>❤️</div>");
        }
        if ($(div).data('code') == 3) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😂</div>");
        }
        if ($(div).data('code') == 4) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😮</div>");
        }
        if ($(div).data('code') == 5) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😢</div>");
        }
        if ($(div).data('code') == 6) {
            var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😡</div>");
        }

        $(message_div).append(newdiv);
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
                // console.log(res);

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
                window.location.href = "http://127.0.0.1:8000/Groups";
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

    // Group User List Show in Model
    function imagesetshowGroup(gid, name, image_path) {

        $('#ImageShowUserNameGroup').html(name);
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
        console.log(groupuserid);

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
                console.log(res['group_id']);

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

        // Pusher.logToConsole = true;
        Pusher.logToConsole = false;
        window.Echo.channel("groups-channel")
            .listen(".groups-event", (e) => {

                if (localStorage.getItem('current_group_chatboard') == e.message) {
                    message_show_group(e.message)
                }
            });

        Echo.channel('emoji-channel')
            .listen('.emoji-event', (e) => {
                if ("{{ Auth::user()->id }}" == e.message['user_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/Groups") {
                    if (localStorage.getItem('current_group_chatboard') == e.message['group_id']) {
                        console.log(e);

                        if ($("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html() == null) {

                            var message_div = $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message');
                            console.log(message_div);

                            if (e.message['response'] == 1) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>👍</div>");
                            }
                            if (e.message['response'] == 2) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>❤️</div>");
                            }
                            if (e.message['response'] == 3) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😂</div>");
                            }
                            if (e.message['response'] == 4) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😮</div>");
                            }
                            if (e.message['response'] == 5) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😢</div>");
                            }
                            if (e.message['response'] == 6) {
                                var newdiv = $("<div class='emoji-div' style='position: absolute;background: #828CAC;border-radius: 28px;'>😡</div>");
                            }

                            $(message_div).append(newdiv);

                        } else {

                            if (e.message['response'] == 1) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("👍");
                            } else
                            if (e.message['response'] == 2) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("❤️");
                            } else
                            if (e.message['response'] == 3) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("😂");
                            } else
                            if (e.message['response'] == 4) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("😮");
                            } else
                            if (e.message['response'] == 5) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("😢");
                            } else
                            if (e.message['response'] == 6) {
                                $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html("😡");
                            }
                        }
                    }
                }

            });
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
                // message_show(user_id);
                message_show_group(gid);
                Select_User_Array_Forword_Group.length = 0;
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

</script>
@endsection
