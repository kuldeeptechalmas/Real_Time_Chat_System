<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Real Time Chat</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.4.0/pusher.min.js" integrity="sha512-p3rR75Is6DCK1r2D8mdxLQhe4IWVDSTUBdxqs0Veum0hHDSY+sH9M6U6Cesr1umlxbiEK9w/3IhXFlZcWT1AoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dashboard_css.css') }}">
</head>
<body style="height: 100vh;overflow: hidden;cursor: default;">
    <div class="row" style="margin: 0px;width: 100%;height: 100%;border-radius: 8px;">

        {{-- first side manu --}}
        <div class="col-1" style="position: relative;">
            <div class="row" style="padding: 15px;background: #f9d8c9;">
                <a href="{{ route('user_profiles') }}" style="color: black;">

                    @if (Auth::user()->image_path==Null)
                    @if (Auth::user()->gender=='Men')
                    <div style="height: 37px;width: 37px;">
                        <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt="">
                    </div>
                    @else
                    <div style="height: 37px;width: 37px;">
                        <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt="">
                    </div>
                    @endif
                    @else
                    <div style="height: 37px;width: 37px;">
                        <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.Auth::user()->image_path) }}" alt="">
                    </div>
                    @endif
                </a>
            </div>

            <a href="{{ route('dashboard') }}" style="color: black;text-decoration: none;">
                <div class="row" style="padding: 15px;background: #f9d8c9;margin-top: 4px;">
                    Home
                </div>

            </a>
            <a href="{{ route('user_friendlist_show') }}" style="color: black;text-decoration: none;">
                <div class="row" style="padding: 15px;background: #f9d8c9;margin-top: 4px;">
                    FriendList
                </div>

            </a>
            <a href="{{ route('user_show_notification') }}" style="color: black;text-decoration: none;">
                <div class="row" style="padding: 15px;background: #f9d8c9;margin-top: 4px;">
                    Notification
                </div>
            </a>
            <div style="position: fixed;bottom: 11px;">
                <a href="{{ route('logout') }}"><button type="button" style="background: #fbdfd2;" class="btn btn-info">Logout</button></a>
            </div>
        </div>
        @if (isset($dashboardshow))

        {{-- searching and show user --}}
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
            <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" id="search_data" style="padding: 0px 20px 7px 20px;">

            </div>
        </div>

        {{-- chatboard --}}
        <div class="col-7" style="background: white;padding: 0px;" id="chatboardofreceiver">
            <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
                <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
            </div>
        </div>
        @endif
        @yield('content')
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageshowmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mt-0 mb-0">
            <div class="modal-content text-white" style="height: 551px;background: #212529;width: 100%;">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="ImageShowUserName"></h3>
                    <button style="color: #f9d8c9" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 254px;width: 100%;">
                    <div id="ImageShowUserImage_path" style="height: 100%;width: 100%;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        var totalTimeType = 0;
        $(document).ready(function() {

            userfriendlist();
            Pusher.logToConsole = true;
            // Pusher.logToConsole = false;
            window.Echo.join("send-channel").here((mem) => {
                    localStorage.setItem('onlinedata', JSON.stringify(mem));
                    mem.forEach(element => {
                        if ($(`#${element['id']}`).html() != null) {

                            if (element['name'] == $(`#${element['name']}`).html().trim()) {

                                let img = "";
                                if (element['image_path'] != null) {
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                    }
                                }

                                $(`#${element['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        ${img}
                                        </div>
                                        <div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${element['id']} )">
                                        <div style="margin-left: 21px;" id="${element['name']}">
                                             ${element['name']} 
                                        </div>
                                        </div>
                                        `);
                            }
                        }
                    });
                }).joining((member) => {
                    if ($(`#${member['id']}`).html() != null) {

                        if (member['name'] == $(`#${member['name']}`).html().trim()) {
                            if (member['image_path'] != null) {
                                img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','${member['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${member['image_path']}" alt="">`;
                            } else {
                                if (member['gender'] == "Men") {
                                    img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                }
                                if (member['gender'] == "Women") {
                                    img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                }
                            }
                            $(`#${member['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        ${ img }
                                        </div>
                                        <div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${member['id']} )">
                                        <div style="margin-left: 21px;" id="${member['name']}">
                                             ${member['name']} 
                                        </div>
                                        </div>`);
                        }
                    }

                }).leaving((member) => {
                    if ($(`#${member['id']}`).html() != null) {

                        if (member['name'] == $(`#${member['name']}`).html().trim()) {
                            if (member['image_path'] != null) {
                                img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','${member['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${member['image_path']}" alt="">`;
                            } else {
                                if (member['gender'] == "Men") {
                                    img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                }
                                if (member['gender'] == "Women") {
                                    img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                }
                            }
                            $(`#${member['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        ${img}
                                        </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${member['id']} )">
                                        <div style="margin-left: 21px;" id="${member['name']}">
                                             ${member['name']} 
                                        </div>
                                        </div>`);
                        }
                    }
                })
                .listen(".send-event", (e) => {
                    if ("{{ Auth::user()->id }}" == e.message['receive_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard") {

                        userfriendlist();

                        if (localStorage.getItem('current_user_chatboard') == e.message['send_id']) {
                            const data = e.message['message'].replace(/(?:\r\n|\r|\n)/g, '<br>');

                            // data convertion
                            const isoString = e.message['created_at'];
                            const dateObject = new Date(isoString);

                            const options = {
                                hour: 'numeric'
                                , minute: '2-digit'
                                , hour12: true
                            };
                            const formattedTime = dateObject.toLocaleString('en-US', options);

                            // old message get
                            var scrollbardiv = $("#scrollbarid").html();
                            var addhtmldiv = `<div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-start;">
                            <div class=w_message d-flex gap-2"><div style="position: relative;min-width: 66px;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
                            ${data}
                            <div style="position: absolute;top: 0px;right: 16px;">
                            <span style="font-size: 11px;">${formattedTime}</span>
                            </div></div></div><div class="messagehovercontent" onclick="removemessagebyone(${e.message['id']})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">Remove</div></div>`;
                            $("#scrollbarid").html(scrollbardiv + addhtmldiv);

                            const element = document.getElementById("scrollbarid");
                            element.scrollTop = element.scrollHeight;

                            userfriendlist();
                            viewNotRefresh(e.message['send_id']);
                            message_show(e.message['send_id']);
                        } else {

                            Toastify({
                                text: `${e.message['sender']['name']} Send Message to ${e.message['message']}`
                                , duration: 5000
                                , gravity: "top"
                                , position: "center"
                                , style: {
                                    background: '#fbdfd2'
                                    , color: "black"
                                }
                                , stopOnFocus: true
                            , }).showToast();

                            if ($(`#${e.message['send_id']}`).html() != null) {

                                if (e.message['sender']['name'] == $(`#${e.message['sender']['name']}`).html().trim()) {

                                    $(`#${e.message['sender']['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${e.message['sender']['name']}','${e.message['sender']['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${e.message['sender']['image_path']}" alt="">
                                        </div>
                                        <div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${e.message['sender']['id']} )">
                                        <div style="margin-left: 21px;font-weight: bold;" id="${e.message['sender']['name']}">
                                             ${e.message['sender']['name']} 
                                        </div>
                                        </div>
                                        `);
                                }

                            }
                        }
                    }
                });

            window.Echo.channel("receive-channel")
                .listen(".receive-event", (e) => {

                    if ("{{ Auth::id() }}" == e.users_data['send_id']) {
                        message_show(e.users_data['receive_id']);
                    }
                });

            Echo.private('typing-channel')
                .listenForWhisper('typing', (e) => {

                    console.log(e);

                    console.log(e.user + ' is typing...');
                    if ("{{ Auth::user()->id }}" == e.user_id && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard") {
                        if ($('.typing').html() == null) {
                            var scrollbardiv = $("#scrollbarid").html();
                            var addhtmldiv = `<div style="background: #fbdfd2;width: 33px;display: flex;justify-content: center;border-radius: 18px;"" class='typing'><span>...</span></div>`;
                            $("#scrollbarid").html(scrollbardiv + addhtmldiv);
                            const element = document.getElementById("scrollbarid");
                            element.scrollTop = element.scrollHeight;
                            totalTimeType += 1000;

                        } else {
                            totalTimeType += 1000;
                        }
                        setTimeout(() => {
                            $('.typing').css('display', 'none');
                            $('.typing').remove();
                        }, totalTimeType)
                    }

                });

            window.Echo.channel("follow-channel")
                .listen(".follow-event", (e) => {

                    if ("{{ Auth::id() }}" == e.notification['receiver_id']) {
                        if (e.notification['unfollow'] == 'yes') {

                            Toastify({
                                text: `${e.notification['sender_name']} is UnFollow You`
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

                            Toastify({
                                text: `${e.notification['sender_name']} is Following You`
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
                });

            // set deshboard data
            if ("{{ isset($last_send_message_user) }}") {

                if ("{{ isset($last_send_message_user)?$last_send_message_user:''!=Auth::id() }}") {
                    localStorage.setItem('current_user_chatboard', "{{ isset($last_send_message_user)?$last_send_message_user:'' }}");
                    setsenduser("{{ isset($last_send_message_user)?$last_send_message_user:'' }}");
                }
            }
        });

        // Show image
        function FilesImageSend() {
            var oldFiles = document.getElementById('files');
            var filesArray = Array.from(oldFiles.files);
            const dataTransfer = new DataTransfer();
            filesArray.forEach(files => {
                dataTransfer.items.add(files);
            });
            document.getElementById('oldfiles').files = dataTransfer.files;
            $('#files').click();
        }

        function imagesetshow(name, image_path) {
            $('#ImageShowUserName').html(name);
            $('#ImageShowUserImage_path').html(`
            <img style="height: 100%;width: 100%;object-fit: contain;" src="storage/img/${image_path}" alt="">
            `);
        }

        // Remove messages
        function removeallmessage(messageuserid) {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message_remove_current_all') }}"
                , data: {
                    messageuserid: messageuserid
                }
                , success: function(res) {
                    $('#moreoptiondiv').css('display', 'none')
                    message_show(messageuserid);
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }


        function removemessagebyone(messageid) {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message_remove_current') }}"
                , data: {
                    messageid: messageid
                }
                , success: function(res) {
                    message_show(res['message_user']);
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Manu Show and Hide
        function closemanu() {
            $('#moreoptiondiv').css('display', 'none')
        }

        function moreoptionshow() {
            $('#moreoptiondiv').css('display', 'block');
        }

        // Search user
        function Searchfriend() {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('search_friend') }}"
                , data: {
                    searchdata: $('#searchfriendname').val()
                }
                , success: function(res) {
                    $('#search_data').html(res);
                    const onlinesuser = localStorage.getItem('onlinedata');
                    const onlineuserData = JSON.parse(onlinesuser);

                    onlineuserData.forEach(element => {
                        if ($(`#${element['id']}`).html() != null) {

                            if (element['name'] == $(`#${element['name']}`).html().trim()) {
                                if (element['image_path'] != null) {
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                    }
                                }
                                $(`#${element['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        ${img}
                                        </div>
                                        <div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${element['id']} )">
                                        <div style="margin-left: 21px;" id="${element['name']}">
                                       ${element['name']} 
                                        </div>
                                        </div>`);
                            }
                        }
                    });
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // ChatBort set user
        function setsenduser(user_id) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_select_data') }}"
                , data: {
                    select_user_id: user_id
                }
                , success: function(res) {
                    localStorage.setItem('current_user_chatboard', user_id);
                    $('#chatboardofreceiver').html(res);
                    message_show(user_id);
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Message Send 
        function sendmessagetosender(senduserid, message) {

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
                formData.append('receive_data_id', senduserid);

            }
            if (message_data == null && document.getElementById('files').files.length != 0) {

                var formData = new FormData();
                formData.append('message', message_data);
                formData.append('receive_data_id', senduserid);

                $("#messages").css('display', "block")
                $("#img-preview").css('display', "none")
                $('#messages').val('');
                $('#messages').attr('placeholder', 'Sending...').prop('readonly', true);

                var fileInput = document.getElementById('files');

                if (fileInput.files.length > 0) {
                    for (var i = 0; i < fileInput.files.length; i++) {
                        if (fileInput.files[i].name.split('.')[1] == 'png' || fileInput.files[i].name.split('.')[1] == 'jpg') {

                            formData.append('files[]', fileInput.files[i]);
                        } else {
                            $('#img-preview').html('');
                            $('#files').val('');
                            $('#img-preview').css('display', "none");
                            $('#messages').css('display', "block");
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
                    , url: "{{ route('message_send_specific_user') }}"
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

                        userfriendlist();

                        const element = document.getElementById("scrollbarid");
                        element.scrollTop = element.scrollHeight;
                    }
                    , error: function(e) {
                        console.log(e);
                    }
                });
            }
        }

        // Request Send
        function requestsend(select_id) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_send_request') }}"
                , data: {
                    select_id: select_id
                }
                , success: function(res) {
                    $('#requestid').css('display', 'none');
                    $('#requestedid').css('display', 'block');
                    $('#removerequestedid').css('display', 'block');
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function viewNotRefresh(select_id) {
            $.ajax({
                type: 'get'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message_show_send_receive_pusher') }}"
                , data: {
                    select_user_id: select_id
                }
                , success: function(res) {

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Message Show
        function message_show(select_user_id) {
            $.ajax({
                type: 'get'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message_show_send_receive') }}"
                , data: {
                    select_user_id: select_user_id
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

        // User Friend List Show
        function userfriendlist() {
            $.ajax({
                type: 'get'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_friend_list') }}"
                , success: function(res) {
                    $('#search_data').html(res);

                    const onlinesuser = localStorage.getItem('onlinedata');
                    const onlineuserData = JSON.parse(onlinesuser);

                    onlineuserData.forEach(element => {
                        if ($(`#${element['id']}`).html() != null) {

                            if (element['name'] == $(`#${element['name']}`).html().trim()) {
                                if (element['image_path'] != null) {
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                    }
                                }
                                $(`#${element['id']}`).html(`<div style="height: 37px;width: 37px;">
                                        ${img}
                                        </div>
                                        <div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>
                                        <div style="width: 100%;" onclick="setsenduser( ${element['id']} )">
                                        <div style="margin-left: 21px;" id="${element['name']}">
                                             ${element['name']} 
                                        </div></div>`);
                            }
                        }
                    });
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Remove Request to Sended
        function removerequest(select_user_id) {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_request_remove') }}"
                , data: {
                    select_user_id: select_user_id
                }
                , success: function(res) {
                    $('#requestid').css('display', 'block');
                    $('#requestedid').css('display', 'none');
                    $('#removerequestedid').css('display', 'none');

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Accept Request
        function RequestIsAccept(select_user_id, divthis) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_request_accept') }}"
                , data: {
                    select_user_id: select_user_id
                }
                , success: function(res) {
                    divthis.textContent = 'Following';
                    setsenduser(select_user_id);

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function unfollowbyid(id, btn) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_unfollow') }}"
                , data: {
                    delete_id: id
                }
                , success: function(res) {
                    btn.textContent = 'Follow';

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // User Write Text
        function userWriteText(current, id) {

            Echo.private('typing-channel')
                .whisper('typing', {
                    user: "{{ Auth::user()->name }}"
                    , user_id: id
                    , typing: true
                });

            console.log(current);
        }

    </script>
</body>
</html>
