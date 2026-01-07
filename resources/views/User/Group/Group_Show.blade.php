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
        <input style="width: 87%;margin-left: 20px;" autocomplete="off" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" />
    </div>

    {{-- here --}}
    <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">

        <div onclick="CreateGroupDiv()" style="display: flex;justify-content: center;align-items: center;font-size: 21px;position: absolute;background: #828CAC;border-radius: 27px;bottom: 20px;right: 61%;z-index: 99;height: 40px;width: 40px;">
            <i class="fa-solid fa-plus" style="color: white;"></i>
        </div>

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
        @endif
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
    function ExistGroup(gid) {
        console.log(gid);
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

    function imagesetshowGroup(gid, name, image_path) {

        $('#ImageShowUserNameGroup').html(name);
        $('#ImageShowUserImage_pathGroup').html(`
            <img style="height: 47%;width: 47%;object-fit: contain;" src="storage/img/${image_path}" alt="">
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

    $(document).ready(function() {

        // userfriendlist();
        // Pusher.logToConsole = true;
        Pusher.logToConsole = false;
        window.Echo.channel("groups-channel")
            .listen(".groups-event", (e) => {
                console.log(localStorage.getItem('current_group_chatboard'));

                if (localStorage.getItem('current_group_chatboard') == e.message) {
                    console.log(e.message);
                    // message_show(e.users_data['receive_id']);
                    message_show_group(e.message)
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
        console.log(gid);
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
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

</script>
@endsection
