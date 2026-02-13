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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" type="image/png" href="{{ asset('img/logo1.png') }}" sizes="50x27">
    <style>
        input::placeholder {
            color: #a5a5a5 !important;
        }

        textarea::placeholder {
            color: #a5a5a5 !important;
        }

        .manu_chatbord_top_userDetails {
            transition: 0.3s ease-in-out;
            color: white;
        }

        .manu_chatbord_top_userDetails:hover {
            background-color: #2e2f2f;

        }

        .hover_change_all {
            transition: 0.3s ease-in-out;
        }

        .hover_change_all:hover {
            background-color: #2e2f2f;
        }

        .hover_change_all_remove {
            transition: 0.3s ease-in-out;
        }

        .hover_change_all_remove:hover {
            color: #fa99a4 !important;
        }

        .tooltip .tooltip-arrow {
            display: none !important;
        }

        .custom-tooltip-style {
            --bs-tooltip-bg: white;
            --bs-tooltip-color: dark;
            --bs-tooltip-border-radius: .5rem;
        }

        .custom-tooltip-style .tooltip-inner {
            max-width: 300px;
            height: 25px;
            font-size: 13px;
            text-align: left;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .profile-input-border {
            border: 1.5px solid blue;
        }

    </style>


</head>
<body style="height: 100vh;overflow: hidden;cursor: default;background: #1c1d1d;">

    <div style="position: absolute;height: 100%;width: 100%;display:none;" id="loader">

        <div class="spinner" style="position: absolute;top: 42%;left: 68%;">
            <div class="spinner1"></div>
        </div>
    </div>
    <div class="row" style="margin: 0px;width: 100%;height: 100%;border-radius: 8px;">

        {{-- first side manu --}}
        <div class="col-1" style="border-right: 1px solid #504f4f;position: relative;width: 5.333333%;background: #1d1f1f;color: #a5a5a5;">
            <div class="d-flex justify-content-center">
                <div class="row" style="padding: 15px 0px 15px 0px;">
                    <a href="{{ route('user_profiles') }}">

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
            </div>

            <a href="{{ route('dashboard') }}" id="chatsMenu" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Chats" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center" style="position: relative;margin-top: 11px;color: #a5a5a5;text-decoration: none;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-house " style="padding: 3px;"></i>

                </div>
                <div id="chatsMenuCounter" style="display:none;">
                    <div style="color: black;background: white;position: absolute;height: 20px;width: 20px;border-radius: 20px;display: flex;justify-content: center;align-items: center;font-size: 11px;left: 54%;">

                    </div>
                </div>
            </a>

            @if (Auth::id()!=3)

            <a href="{{ route('group.show') }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Groups" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center border-radius-circle" style="margin-top: 11px;color: #a5a5a5;text-decoration: none;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-user-group" style="padding: 3px;"></i>

                </div>
                <div id="groupsMenuCounter" style="display:none;">
                    <div style="color: black;background: white;position: absolute;height: 20px;width: 20px;border-radius: 20px;display: flex;justify-content: center;align-items: center;font-size: 11px;left: 54%;">

                    </div>
                </div>

            </a>
            <a href="{{ route('user_friendlist_show') }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Friend List" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center" style="color: #a5a5a5;text-decoration: none;margin-top: 11px;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-address-card" style="padding: 3px;"></i>

                </div>

            </a>
            <a href="{{ route('user_show_notification') }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Notifications" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center" style="color: #a5a5a5;text-decoration: none;margin-top: 11px;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-bell" style="padding: 3px;"></i>

                </div>
                <div id="notificationsMenuCounter" style="display:none;">
                    <div style="color: black;background: white;position: absolute;height: 20px;width: 20px;border-radius: 20px;display: flex;justify-content: center;align-items: center;font-size: 11px;left: 54%;">

                    </div>
                </div>

            </a>
            <a href="{{ route('user.star.show') }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Star Friend" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center" style="color: #a5a5a5;text-decoration: none;margin-top: 11px;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-star" style="padding: 3px;"></i>

                </div>

            </a>

            <a href="{{ route('help.page') }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Helps" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right" class="hover_change_all d-flex justify-content-center" style="color: #a5a5a5;text-decoration: none;margin-top: 11px;border-radius: 50px;">
                <div class="row" style="padding: 9px;height: 42px;width: 40px;">
                    <i class="col-4 fa-solid fa-circle-info" style="padding: 3px;"></i>

                </div>

            </a>
            @endif
            <div class="hover_change_all justify-content-center d-flex" style="border-radius: 20px;height: 42px;width: 42px;position: fixed;bottom: 11px;left: 13px;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Logout" data-bs-custom-class="custom-tooltip-style" data-bs-placement="right">
                <a class="hover_change_all_remove" style="text-decoration: none;color: #a5a5a5;padding: 9px;" href="{{ route('logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
        @if (isset($dashboardshow))

        {{-- searching and show user --}}
        <div class="col-4 bg-light" style="border-right: 1px solid #504f4f;padding: 0px;width: 36.333333%;">

            {{-- @if (Auth::id()!=3) --}}
            {{-- <div onclick="CreateGroupDiv()" style="display: flex;justify-content: center;align-items: center;font-size: 21px;position: absolute;background: #828CAC;border-radius: 27px;bottom: 20px;right: 61%;z-index: 99;height: 40px;width: 40px;">
                <i class="fa-solid fa-plus" style="color: white;"></i>
            </div> --}}
            {{-- @endif --}}
            <div style="padding: 21px;background-color: #1c1d1d;position: relative;">
                <div class="d-flex">
                    <div style="height: 26px;width: 49px;">
                        <img style="height: 100%;width: 100%;" src="{{ asset('img/logo.png') }}" alt="">
                    </div>
                    <div style="display: flex;align-items: center;margin-left: 20px;color: white;">
                        Real Time Chat
                    </div>
                    <div class="size-9 rounded-[50px] hover_change_all d-flex justify-content-center align-items-center" style="position: absolute;right: 7%;" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Menu" data-bs-custom-class="custom-tooltip-style" data-bs-placement="left">
                        <i class="fa-solid fa-ellipsis-vertical text-white" id="showMenuId" onclick="MainMoreOpetionShow()"></i>
                    </div>
                    <div id="moreOptionDivMain" style="border: 1px solid rgb(94 89 89);z-index: 999;padding: 6px;display: none;position: absolute;top: 97%;right: 3%;background-color: #161717;color:white;border-radius: 18px;">
                        <div class="hover_change_all" style="padding: 5px;border-radius: 20px;">
                            <div class="d-flex">
                                <i class="fa-solid fa-circle-minus d-flex justify-content-center align-items-center"></i>
                                <div style="padding-left: 5px;" onclick="CreateGroupDiv()">
                                    New Group
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 15px 0px 15px 0px;background: #1c1d1d;margin: 0px;">
                <input style="color: white;width: 91%;margin-left: 20px;background-color: #2e2f2f;border-radius: 20px;border: none;" autocomplete="off" id="searchfriendname" oninput="Searchfriend()" class="form-control" type="search" placeholder="Search" aria-label="Search" />
            </div>

            {{-- here --}}
            <div class="scroll-container2" style="padding: 0px 20px 7px 20px;height: 432px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;background: #1c1d1d;" id="search_data" style="padding: 0px 20px 7px 20px;">

            </div>
        </div>

        {{-- chatboard --}}
        <div class="col-7 chatboardofreceiver" style="background: white;padding: 0px;background: #161717;" id="chatboardofreceiver">
            <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
                <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
            </div>
        </div>
        @endif
        @yield('content')
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageshowmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen mt-0 mb-0" id="imageDivforUserid">
            <div class="modal-content text-white" style="height: 543px;background: #161717;width: 100%;border: 1px solid wheat;border-radius: 27px;margin-top: 4px;">
                <div style="display: flex;padding: 19px;" data-bs-theme="dark">
                    <h3 class="modal-title fs-5 text-white" id="ImageShowUserName"></h3>
                    <button style="color: #f9d8c9;position: absolute;right: 25px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 254px;width: 100%;">
                    <div id="ImageShowUserImage_path" style="height: 100%;width: 100%;">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="module" src="https://unpkg.com/emoji-picker-element"></script>

    @stack('script')
    @once
    <script>
        $(document).ready(function() {

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        });

    </script>
    @endonce
    <script>
        var totalTimeType = 0;
        $(document).ready(function() {

            CountNotificationMessages();
            userfriendlist();


            // Pusher.logToConsole = true;
            Pusher.logToConsole = false;
            window.Echo.join("send-channel").here((mem) => {
                    localStorage.setItem('onlinedata', JSON.stringify(mem));
                    mem.forEach(element => {
                        if ($(`#${element['id']}`).html() != null) {

                            if (element['name'] == $(`#${element['name']}`).html().trim()) {

                                let img = "";
                                if (element['image_path'] != null) {
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','male.png','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','female.png','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                    }
                                }

                                $(`#${element['id']}`).append(`<div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>`);
                                $($(`#${element['id']}`).find('.TimeOldOnline')[0]).remove();

                            }
                        }
                    });
                }).joining((member) => {
                    if ($(`#${member['id']}`).html() != null) {

                        if (member['name'] == $(`#${member['name']}`).html().trim()) {
                            if (member['image_path'] != null) {
                                img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','${member['image_path']}','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${member['image_path']}" alt="">`;
                            } else {
                                if (member['gender'] == "Men") {
                                    img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','male.png','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                }
                                if (member['gender'] == "Women") {
                                    img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','female.png','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                }
                            }
                            $(`#${member['id']}`).append(`<div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>`);
                            $($(`#${member['id']}`).find('.TimeOldOnline')[0]).remove();

                        }
                    }

                }).leaving((member) => {
                    if ($(`#${member['id']}`).html() != null) {

                        if (member['name'] == $(`#${member['name']}`).html().trim()) {
                            if (member['image_path'] != null) {
                                img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','${member['image_path']}','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${member['image_path']}" alt="">`;
                            } else {
                                if (member['gender'] == "Men") {
                                    img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','male.png','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                }
                                if (member['gender'] == "Women") {
                                    img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${member['name']}','female.png','${member['phone']}','${member['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
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

                            // last_seen_at
                            $.ajax({
                                type: 'post'
                                , headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                                , url: "{{ route('user_last_seen_time') }}"
                                , data: {
                                    leav_id: member['id']
                                }
                                , success: function(res) {
                                    userfriendlist();
                                }
                                , error: function(e) {
                                    console.log(e);
                                }
                            });

                        }
                    }
                })

                .listen(".send-event", (e) => {

                    if ("{{ Auth::user()->id }}" == e.message['receive_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard" || "{{ URL::full() }}" == "http://127.0.0.1:8000/help") {

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

                            if ($(`#m${e.message['id']}`).html() != null) {

                                $($(`#m${e.message['id']}`).find('div.w_message').children()[0]).html(`${data}
                                <div style="position: absolute;top: 0px;right: 16px;">
                                <span style="font-size: 11px;">${formattedTime}</span>
                                </div>`);

                            } else {

                                // old message get
                                var scrollbardiv = $("#scrollbarid").html();

                                var extentionOfImage = data.split('.');

                                var addhtmldiv = `
                                        <div class="messagehover receiver_message" id="m${e.message['id']}" style="position: relative;margin: 18px 14px 14px 14px;display: flex;justify-content: flex-start;">
                                            <div class="w_message d-flex gap-2" style="position: relative;">
                                                <div style="min-width: 66px;position: relative;background: #fbdfd2;padding: 28px 7px 7px 7px;border-radius: 0px 10px 10px;cursor: default;">
                                                ${extentionOfImage[1]=='jpg' || extentionOfImage[1]=='svg'|| extentionOfImage[1]=='pdf' || extentionOfImage[1]=='png' ? 
                                                `${extentionOfImage[1]=='pdf' ? `
                                                <div style="height: 210px;width: 239px;">
                                                <a href="/pdf-view/${data}" target="_blank">
                                                    <img style="height: 89%;width: 100%;object-fit: cover;border-radius: 22px;" src="storage/img/pdf_image.png" alt="">
                                                </a>
                                                <div style="padding-left: 16px;">${data}</div>
                                            </div>
                                                ` : `<div style="height: 192px;width: 239px;">
                                                    <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${e.message['id']}','${e.message['message']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="storage/img/${data}" alt="">
                                                </div>`} 
                                                `
                                                 : data
                                                 }
                                                <div style="position: absolute;top: 0px;right: 16px;">
                                                    <span style="font-size: 11px;">${formattedTime}</span>
                                                </div>
                                                </div>
                                            </div>

                                                <div class="emoji-bar">
                                                    <div class="emoji-reaction" data-reaction="like">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="1">👍</div>
                                                    </div>
                                                    <div class="emoji-reaction" data-reaction="love">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="2">❤️</div>
                                                    </div>
                                                    <div class="emoji-reaction" data-reaction="haha">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="3">😂</div>
                                                    </div>
                                                    <div class="emoji-reaction" data-reaction="wow">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="4">😮</div>
                                                    </div>
                                                    <div class="emoji-reaction" data-reaction="sad">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="5">😢</div>
                                                    </div>
                                                    <div class="emoji-reaction" data-reaction="angry">
                                                        <div class="emoji" onclick="emojigetshow(this,'${e.message['id']}')" data-code="6">😡</div>
                                                    </div>
                                                    <div class="emoji-reaction" onclick="removemessagebyone(${e.message['id']})">
                                                        <div class="emoji">Remove</div>
                                                    </div>
                                                    <div class="emoji-reaction" onclick="forwordmessage('${e.message['id']}',${e.message['message']})">
                                                        <div class="emoji"><i class="fa-regular fa-share-from-square"></i></div>
                                                    </div>
                                                    ${extentionOfImage[1]=='jpg' || extentionOfImage[1]=='svg'|| extentionOfImage[1]=='pdf' || extentionOfImage[1]=='png' ?`
                                                    <div class="emoji-reaction">
                                                       <a href="/pdf-download/${data}" style="color: black;" rel="noopener noreferrer">
                                                           <div class="emoji"><i class="fa-solid fa-download"></i></div>
                                                       </a>
                                                   </div>
                                                   
                                                    `:''}
                                                    </div>
                                            `;

                                $("#scrollbarid").html(scrollbardiv + addhtmldiv);

                                const element = document.getElementById("scrollbarid");
                                element.scrollTop = element.scrollHeight;
                            }
                            userfriendlist();
                            viewNotRefresh(e.message['send_id']);
                            // message_show(e.message['send_id']);
                        } else {

                            if (e.message['receive_id'] != 3) {

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

                            }

                            // Get Not View Messages Count
                            CountNotificationMessages();

                        }
                    } else {

                        if ("{{ Auth::user()->id }}" == e.message['receive_id']) {
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

                            CountNotificationMessages();
                        }

                    }
                });

            window.Echo.channel("receive-channel")
                .listen(".receive-event", (e) => {

                    if ("{{ Auth::id() }}" == e.users_data['send_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard") {

                        message_show(e.users_data['receive_id']);
                    }
                });

            window.Echo.private('typing-channel')
                .listenForWhisper('typing', (e) => {

                    if ("{{ Auth::user()->id }}" == e.user_id && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard") {

                        if (e.user == localStorage.getItem('cuurentCatboard')) {

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
                            }, totalTimeType);
                        }
                    }

                });

            window.Echo.channel('emoji-channel')
                .listen('.emoji-event', (e) => {
                    // Group Messages
                    if ("{{ Auth::user()->id }}" == e.message['user_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/groups") {
                        if (localStorage.getItem('current_group_chatboard') == e.message['group_id']) {
                            console.log(e);

                            if ($("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html() == null) {

                                var message_div = $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message');

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

                    // User Messages
                    if ("{{ Auth::user()->id }}" == e.message['send_id'] && "{{ URL::full() }}" == "http://127.0.0.1:8000/dashboard") {
                        if (localStorage.getItem('current_user_chatboard') == e.message['receive_id']) {

                            if ($("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message').find('.emoji-div').html() == null) {

                                var message_div = $("#scrollbarid").find(`#m${e.message['id']}`).find('.w_message').find('.sub-w_message');

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
                        setsenduser(localStorage.getItem('current_user_chatboard'), 'notloader');
                    }
                });

            window.Echo.channel("groups-channel")
                .listen(".groups-event", (e) => {

                    if (localStorage.getItem('current_group_chatboard') == e.message && "{{ URL::full() }}" == "http://127.0.0.1:8000/groups") {
                        message_show_group(e.message)

                        $.ajax({
                            type: 'post'
                            , headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            , url: "{{ route('group.message.view.pusher') }}"
                            , data: {
                                group_id: e.message
                            }
                            , error: function(e) {
                                console.log(e);
                            }
                        });

                    } else {
                        Toastify({
                            text: `${e.user['name']} Send Message in Group`
                            , duration: 5000
                            , gravity: "top"
                            , position: "center"
                            , style: {
                                background: '#fbdfd2'
                                , color: "black"
                            }
                            , stopOnFocus: true
                        , }).showToast();

                        $(`#gc${e.message}`).css('display', 'block');
                        var oldHtmlCount = $($(`#gc${e.message}`).children()[0]).html();
                        $($(`#gc${e.message}`).children()[0]).html(Number(oldHtmlCount) + 1);

                        CountNotificationMessages();
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

        // Close div to Menu 
        const myDivMore = document.getElementById('moreOptionDivMain');
        const menuId = document.getElementById('showMenuId');

        document.addEventListener('click', function(event) {
            if (myDivMore) {

                const isClickOutSideDiv = myDivMore.contains(event.target);
                const isClickButton = menuId.contains(event.target);

                if (!isClickOutSideDiv && !isClickButton) {
                    if ($('#moreOptionDivMain').css('display') == 'block') {
                        $('#moreOptionDivMain').css('display', 'none');
                    }

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

        function imagesetshow(name, image_path, phone, email) {
            // console.log(image_path);

            if (phone != null && email != null) {

                const element = document.getElementById("imageDivforUserid");
                element.classList.remove("modal-fullscreen");

                $('#ImageShowUserName').html("User Profile");
                $('#ImageShowUserImage_path').html(`
                <div style="display: flex;justify-content: center;">
                <div style="height: 228px;width: 232px;">
            <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 126px;" src="storage/img/${image_path}" alt="">
            </div>
            </div>
            <div style="color: white;display: flex;justify-content: center;padding: 19px;font-size: 20px;" id='userid'>
                </div>
            <div style="color: white;display: flex;justify-content: center;padding: 10px;" id='userphone'>
                </div>
            <div style="color: white;display: flex;justify-content: center;padding: 10px;" id='useremail'>
                </div>
            `);
                $('#userid').html(name);
                $('#userphone').html(phone);
                $('#useremail').html(email);

            } else {

                const element = document.getElementById("imageDivforUserid");
                element.classList.add("modal-fullscreen");
                $('#ImageShowUserName').html("");
                $('#ImageShowUserImage_path').html(`
            <img style="height: 100%;width: 100%;object-fit: contain;" src="storage/img/${image_path}" alt="">
            `);
            }
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
            $('#moreoptiondiv').css('display', 'none');
        }

        function MainMoreOpetionShow() {
            if ($('#moreOptionDivMain').css('display') == 'block') {
                $('#moreOptionDivMain').css('display', 'none');
            } else {
                $('#moreOptionDivMain').css('display', 'block');
            }

        }

        function moreoptionshow() {

            if ($('#moreoptiondiv').css('display') == 'block') {
                $('#moreoptiondiv').css('display', 'none');
            } else {
                $('#moreoptiondiv').css('display', 'block');
            }

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
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','male.png','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','female.png','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
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
        function setsenduser(user_id, notloader) {
            $('#chatboardofreceiver').html('');
            if (notloader != 'notloader') {

                $('#loader').css('display', 'block');
            }

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
                    $('#loader').css('display', 'none');
                    userfriendlist();
                    Tolltip_Intialization();
                    CountNotificationMessages();
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        // Message Send 
        function sendmessagetosender(senduserid, message) {

            $("#sendmessageid").css('background-color', 'rgb(33, 37, 41)');
            $('#emoji_picker').css('display', 'none');

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

                if (localStorage.getItem('editMessageId') != null) {

                    formData.append('edit_message_id', localStorage.getItem('editMessageId'));
                }
                formData.append('receive_data_id', senduserid);

            }
            if (message_data == null && document.getElementById('files').files.length != 0) {

                var formData = new FormData();
                formData.append('message', message_data);

                if (localStorage.getItem('editMessageId') != null) {

                    formData.append('edit_message_id', localStorage.getItem('editMessageId'));
                }
                formData.append('receive_data_id', senduserid);

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
                                text: `Enter Image is Only png or jpg or svg or pdf Images Allows`
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

                        if (res['error']) {
                            Toastify({
                                text: `${res['error']}`
                                , duration: 5000
                                , gravity: "top"
                                , position: "center"
                                , style: {
                                    background: '#fbdfd2'
                                    , color: "black"
                                }
                                , stopOnFocus: true
                            , }).showToast();
                            $('#messages').val('');
                            $('#messages').prop('readonly', false).attr('placeholder', 'Type Message Here...');

                            localStorage.removeItem('editMessageId');
                        } else {

                            $('#message_to_show').html(res);
                            $('#messages').val('');
                            $('#files').val('');
                            $('#emoji_picker').css('display', 'none');
                            $('#img-preview').html('');
                            $('#messages').css('display', 'block');
                            $('#img-preview').css('display', 'none');

                            $('#messages').prop('readonly', false).attr('placeholder', 'Type Message Here...');
                            userfriendlist();

                            localStorage.removeItem('editMessageId');

                            const element = document.getElementById("scrollbarid");
                            element.scrollTop = element.scrollHeight;
                        }
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
                                    img = `<img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','${element['image_path']}','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="storage/img/${element['image_path']}" alt="">`;
                                } else {
                                    if (element['gender'] == "Men") {
                                        img = `<div data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','male.png','${element['phone']}','${element['email']}')" style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>`;
                                    }
                                    if (element['gender'] == "Women") {
                                        img = `<div style="height: 37px;width: 37px;"><img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('${element['name']}','female.png','${element['phone']}','${element['email']}')" style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>`;
                                    }
                                }
                                $(`#${element['id']}`).append(`<div style="position: absolute;right: 19px;background: green;width: 8px;height: 8px;border-radius: 23px;"> </div>`);
                                $($(`#${element['id']}`).find('.TimeOldOnline')[0]).remove();

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
                    // divthis.textContent = 'Following';
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

        function closeMoreOption() {
            $('#moreoptiondiv').css('display', 'none')
        }

        // User Write Text
        function userWriteText(current, id) {
            if ($('#messages').val() != "") {
                if ($("#sendmessageid").css('background-color') == "rgb(33, 37, 41)") {
                    $("#sendmessageid").css('background-color', 'green');
                }
            } else {
                if ($("#sendmessageid").css('background-color') == "rgb(0, 128, 0)") {
                    $("#sendmessageid").css('background-color', 'rgb(33, 37, 41)');
                }
            }

            Echo.private('typing-channel')
                .whisper('typing', {
                    user: "{{ Auth::user()->name }}"
                    , user_id: id
                    , typing: true
                });
            if ($('#messages').val() == null) {

                localStorage.removeItem('editMessageId');

            }


        }

        // Get Emoji And Show
        function emojigetshow(div, message_id) {

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
                , url: "{{ route('message_emoji_add') }}"
                , data: {
                    emoji_code: $(div).data('code')
                    , message_id: message_id
                }
                , success: function(res) {

                }
                , error: function(e) {
                    console.log(e);
                }
            });

        }

        // Forword Message
        function forwordmessage(mid, mmessage) {
            localStorage.setItem('m_message', mmessage);

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('user_forword_message') }}"
                , success: function(res) {
                    $('#chatboardofreceiver').html(res);
                }
                , error: function(e) {
                    console.log(e);
                }
            });

        }

        let Select_User_Array_Forword = new Array();

        function SelectedForwordUser(thisdiv) {

            if ($(thisdiv).css('background-color') == 'rgba(208, 242, 208, 0.5)') {
                $(thisdiv).css('background-color', '#212529');

                const index = Select_User_Array_Forword.indexOf($(thisdiv).data('id'));
                Select_User_Array_Forword.splice(index, 1);

            } else {
                $(thisdiv).css('background-color', 'rgba(208, 242, 208, 0.5)');
                Select_User_Array_Forword.push($(thisdiv).data('id'));
            }
        }

        function ForwordMessageUserSelect() {

            $('#chatboardofreceiver').html('');
            $('#loader').css('display', 'block');

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message_send_specific_user') }}"
                , data: {
                    message: localStorage.getItem('m_message')
                    , receive_data_id_array: Select_User_Array_Forword
                }
                , success: function(res) {
                    setsenduser(Select_User_Array_Forword[0]);
                    userfriendlist();
                    Select_User_Array_Forword.length = 0;
                    $('#loader').css('display', 'none');
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function CreateGroupDiv() {
            $('#moreOptionDivMain').css('display', 'none');

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('create.group') }}"
                , success: function(res) {
                    $('#chatboardofreceiver').html(res);
                    $('#chatboardofreceiverGroup').html(res);
                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        let Select_User_Array = new Array();

        function SelectedGroupUser(thisdiv) {

            console.log($(thisdiv).css('background-color'));

            if ($(thisdiv).css('background-color') == 'rgba(208, 242, 208, 0.5)') {
                $(thisdiv).css('background-color', '#212529');

                const index = Select_User_Array.indexOf($(thisdiv).data('id'));
                Select_User_Array.splice(index, 1);

            } else {
                $(thisdiv).css('background-color', 'rgba(208, 242, 208, 0.5)');
                Select_User_Array.push($(thisdiv).data('id'));
            }
        }

        function FinalCreateGroup() {
            const data_of_group_name = $('#group_name').val().replace(/\s/g, '');
            if (data_of_group_name.length == 0) {
                Toastify({
                    text: `Enter Group Name !...`
                    , duration: 1000
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
                    , url: "{{ route('create.group.final') }}"
                    , data: {
                        group_name: $('#group_name').val()
                        , group_user: Select_User_Array
                    }
                    , success: function(res) {
                        Select_User_Array.length = 0;
                        window.location.href = "http://127.0.0.1:8000/groups";
                        // $('#chatboardofreceiver').html(res);
                    }
                    , error: function(e) {
                        console.log(e);
                    }
                });
            }
        }

        function ClearMessageByOne(message_id) {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('message.clean') }}"
                , data: {
                    message_id: message_id
                }
                , success: function(res) {

                    $('#message_to_show').html(res);
                    const element = document.getElementById("scrollbarid");
                    element.scrollTop = element.scrollHeight;

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

        function Tolltip_Intialization() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }

        function showContactInfo(Select_user_id) {

            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('show.contact.info') }}"
                , data: {
                    select_user_id: Select_user_id
                }
                , success: function(res) {
                    $('#chatboardofreceiver').html(res);

                    // $('#message_to_show').html(res);
                    // const element = document.getElementById("scrollbarid");
                    // element.scrollTop = element.scrollHeight;

                }
                , error: function(e) {
                    console.log(e);
                }
            });

            console.log(Select_user_id);
        }

        function CountNotificationMessages() {
            $.ajax({
                type: 'post'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , url: "{{ route('get.message.not.view.count') }}"
                , success: function(res) {
                    console.log(res);

                    // Chats
                    if (res["count_message"] != 0) {
                        $("#chatsMenuCounter").css('display', 'block');
                        $($('#chatsMenuCounter').children()[0]).html(res["count_message"]);
                    } else {
                        $("#chatsMenuCounter").css('display', 'none');
                    }

                    // Groups
                    if (res["group_count_message"] != 0) {
                        $("#groupsMenuCounter").css('display', 'block');
                        $($('#groupsMenuCounter').children()[0]).html(res["group_count_message"]);
                    } else {
                        $("#groupsMenuCounter").css('display', 'none');
                    }

                    // Notifications
                    if (res["notification_count"] != 0) {
                        $("#notificationsMenuCounter").css('display', 'block');
                        $($('#notificationsMenuCounter').children()[0]).html(res["notification_count"]);
                    } else {
                        $("#notificationsMenuCounter").css('display', 'none');
                    }

                }
                , error: function(e) {
                    console.log(e);
                }
            });
        }

    </script>
</body>
</html>
