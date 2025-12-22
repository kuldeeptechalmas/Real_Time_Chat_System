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
    <style>
        .scroll-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
            overflow-y: scroll;
        }

        .scroll-container::-webkit-scrollbar {
            display: none;
        }

        .messagehovercontent {
            display: none;
        }

        .messagehover:hover .messagehovercontent {
            display: block;
        }

        .w_message {
            max-width: 60%;
        }

    </style>

</head>
<body style="height: 100vh;overflow: hidden;cursor: default;">

    <div class="row" style="margin: 0px;width: 100%;height: 100%;border-radius: 8px;">

        {{-- first side manu --}}
        <div class="col-1" style="position: relative;">
            <div class="row" style="padding: 15px;background: #f9d8c9;">
                <a href="{{ route('user_profiles') }}" style="color: black;">

                    @if (Auth::user()->image_path==Null)
                    @if (Auth::user()->gender=='Men')
                    <i class="fa-solid fa-user" style="font-size: 21px;"></i>
                    @else
                    <i class="fa-regular fa-user" style="font-size: 21px;"></i>
                    @endif
                    @else
                    {{ Auth::user()->image_path }}
                    @endif
                </a>
                {{-- {{ Auth::user()->name }} --}}
            </div>
            <div style="position: absolute;bottom: 9px;">
                <a href="{{ route('logout') }}"><button type="button" style="background: #fbdfd2;" class="btn btn-info">Logout</button></a>
            </div>
        </div>

        {{-- searching and show user --}}
        <div class="col-4 bg-light" style="padding: 0px;">
            <div style="padding: 15px;background-color: #fbdfd2">
                <div>
                    Real Time Chat
                </div>
            </div>
            <div class="row" style="padding: 15px;">
                <input style="width: 87%;margin-left: 20px;" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" />
            </div>
            <div class="scroll-container" id="search_data" style="padding: 0px 20px 7px 20px;">
                @if (isset($last_message_send_data))
                @foreach ($last_message_send_data as $item)
                <div class="card" style="padding: 16px;margin: 2px;" onclick="setsenduser({{ $item->user_data_to_message->id }})">
                    {{ $item->user_data_to_message->name }}
                </div>
                @endforeach
                @endif
            </div>
        </div>

        {{-- chatboard --}}
        <div class="col-7" style="background: white;padding: 0px;" id="chatboardofreceiver">
            <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
                <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {

            Pusher.logToConsole = true;
            window.Echo.channel("send-channel")
                .listen(".send-event", (e) => {
                    userfriendlist();
                    if ("{{ Auth::user()->id }}" == e.message['receive_id']) {

                        if (localStorage.getItem('current_user_chatboard') == e.message['send_id']) {
                            console.log(e.message['message']);
                            const data = e.message['message'].replace(/(?:\r\n|\r|\n)/g, '<br>');

                            var scrollbardiv = $("#scrollbarid").html();
                            var addhtmldiv = `<div class="messagehover" style="margin: 14px;display: flex;justify-content: flex-start;">
                            <div class=w_message d-flex gap-2"><div style="background: #fbdfd2;padding: 7px;border-radius: 0px 10px 10px;cursor: default;">
                            ${data}
                            </div></div><div class="messagehovercontent" onclick="removemessagebyone(${e.message['id']})" style="background-color: #d28fa8;height: 32px;color: white;border-radius: 11px;margin-left: 13px;padding: 4px;cursor: default;">Remove</div></div>`;
                            $("#scrollbarid").html(scrollbardiv + addhtmldiv);

                            const element = document.getElementById("scrollbarid");
                            element.scrollTop = element.scrollHeight;
                        } else {
                            Toastify({
                                text: `${e.message['name']} Send Message to ${e.message['message']}`
                                , duration: 3000
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
            if ("{{ isset($last_send_message_user) }}" != 0) {
                localStorage.setItem('current_user_chatboard', "{{ isset($last_send_message_user) }}");
                setsenduser("{{ isset($last_send_message_user)?$last_send_message_user:'' }}");
            }

            // messages textarea

        });

        function removeallmessage(messageuserid) {
            // console.log(messageuserid);
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/message-remove-all'
                , data: {
                    messageuserid: messageuserid
                }
                , success: function(res) {
                    $('#moreoptiondiv').css('display', 'none')
                    console.log(messageuserid);
                    message_show(messageuserid);
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function removemessagebyone(messageid) {
            console.log(messageid);
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/message-remove'
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

        function closemanu() {
            $('#moreoptiondiv').css('display', 'none')
        }

        function moreoptionshow() {
            $('#moreoptiondiv').css('display', 'block');
        }

        function Searchfriend() {
            console.log($('#searchfriendname').val());
            if ($('#searchfriendname').val() == '') {
                userfriendlist();
            } else {
                $.ajax({
                    type: 'post'
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , url: '/search-friend'
                    , data: {
                        searchdata: $('#searchfriendname').val()
                    }
                    , success: function(res) {
                        $('#search_data').html(res);
                    }
                    , error: function(e) {
                        console.log(e);
                    }
                });
            }
        }

        function setsenduser(user_id) {
            // console.log(user_id);
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/user-select'
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

        function sendmessagetosender(senduserid) {
            // console.log($('#messages').val());
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/message-send'
                , data: {
                    message: $('#messages').val()
                    , receive_data_id: senduserid
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

        function message_show(select_user_id) {
            $.ajax({
                type: 'get'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/message-show'
                , data: {
                    select_user_id: select_user_id
                }
                , success: function(res) {
                    $('#message_to_show').html(res);
                    $('#messages').val('');
                    userfriendlist();
                    const element = document.getElementById("scrollbarid");
                    element.scrollTop = element.scrollHeight;

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function userfriendlist() {
            $.ajax({
                type: 'get'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: '/user-friend-list'
                , success: function(res) {
                    $('#search_data').html(res);

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

    </script>
</body>
</html>
