<style>
    .img-thumbs {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.5rem;
        margin: 1rem 0;
        padding: 0.75rem;
        backdrop-filter: blur(10px);
    }

    .img-thumbs-hidden {
        display: none;
    }

    .wrapper-thumb {
        padding: 9px;
        height: 67px;
        width: 84px;
        position: relative;
        display: inline-block;
        margin: 0.5rem;
        justify-content: space-around;
    }

    .img-preview-thumb {
        height: 100%;
        width: 100%;
        object-fit: cover;
        background: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.5rem;
        box-shadow: 0.125rem 0.125rem 0.5rem rgba(0, 0, 0, 0.2);
        margin-right: 1rem;
        max-width: 140px;
        padding: 0.25rem;
        transition: transform 0.3s ease;
    }

    .img-preview-thumb:hover {
        transform: scale(1.05);
    }

    .remove-btn {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: .7rem;
        top: -5px;
        right: 10px;
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        font-weight: bold;
        cursor: pointer;
        color: #161717;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .remove-btn:hover {
        box-shadow: 0px 2px 8px rgba(255, 0, 0, 0.4);
        transform: scale(1.1);
        background: #ff4444;
        color: white;
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

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .wrapper-thumb {
            height: 60px;
            width: 75px;
            margin: 0.3rem;
        }

        .img-thumbs {
            padding: 0.5rem;
            margin: 0.5rem 0;
        }

        #moreoptiondiv {
            right: 5% !important;
            top: 12% !important;
            max-width: 200px;
        }
    }

    @media (max-width: 576px) {
        .wrapper-thumb {
            height: 55px;
            width: 70px;
        }

        .remove-btn {
            width: 20px;
            height: 20px;
            font-size: 0.6rem;
        }

        #emoji_picker {
            width: 280px !important;
            height: 200px !important;
            bottom: 12% !important;
        }

        .bg-dark {
            padding: 10px 12px !important;
        }

        textarea {
            font-size: 14px !important;
            margin-left: 10px !important;
        }

        i.fa-solid {
            font-size: 16px !important;
        }
    }

    /* Tablet adjustments */
    @media (max-width: 992px) and (min-width: 769px) {
        #emoji_picker {
            width: 300px !important;
            height: 220px !important;
        }
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        right: 0;
        /* Attach to right side */
        width: 345px;
        height: 100%;
        background-color: #111;
        padding-top: 60px;
        z-index: 999;
        transform: translateX(100%);
        /* Hidden outside screen */
        transition: transform 0.4s ease;
    }

    /* Show sidebar */
    .sidebar.active {
        transform: translateX(0);
        /* Slide into screen */
    }

    /* Links */
    .sidebar a {
        display: block;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
    }

    .sidebar a:hover {
        background-color: #575757;
    }

    /* Close button */
    .close {
        position: absolute;
        top: 10px;
        left: 15px;
        font-size: 15px;
    }

    .sidebar .close i {
        transition: 0.3s ease;
        cursor: pointer;
    }

    /* Hover only icon */
    .sidebar .close i:hover {
        color: #00ffcc;
        transform: translateX(-5px);
    }

    .form-check-input:checked {
        background-color: #25D366 !important;
        border-color: #25D366;
    }

    .radio-group {
        color: white;
        width: 250px;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 20px 0;
        cursor: pointer;
        font-size: 15px;
    }

    /* Hide default radio */
    .radio-item input {
        display: none;
    }

    /* Custom circle */
    .custom-radio {
        width: 20px;
        height: 20px;
        border: 2px solid #777;
        border-radius: 50%;
        position: relative;
        transition: 0.3s ease;
    }

    /* Green border when checked */
    .radio-item input:checked+.custom-radio {
        border-color: #25D366;
    }

    /* Inner green dot */
    .radio-item input:checked+.custom-radio::after {
        content: "";
        width: 12px;
        height: 12px;
        background-color: #25D366;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

</style>

<div id="sidebar" class="sidebar" style="color: white;padding-left: 21px;font-family: 'Roboto', sans-serif;">
    <a href="javascript:void(0)" class="close" onclick="toggleSidebar()">
        <i class="fa-solid fa-arrow-left"></i>
        Disappearing messages
    </a>

    <div style="height: 150px;width: 213px;margin:43px 0px 20px 57px;">
        <img src="{{ asset('img/disappearing.png') }}" style="height: 100%;width: 100%;object-fit: cover;" alt="">
    </div>

    <div style="color: gray;font-family: 'Roboto', sans-serif;font-size: 14px;padding-bottom: 5px;font-weight: bold;">
        Make messages in this chat disappear
    </div>

    <div style="color: gray;font-family: 'Roboto', sans-serif;font-size: 14px;">
        For more privacy and storage, all new messages will disappear from this chat after the selected duration, except when kept. You can change this setting at any time.
    </div>

    <div class="radio-group">


        <label class="radio-item">
            <input type="radio" name="time" value="1" @checked(optional($user_send_user_data->DisappearMessageData)->expiring_time == 1)
            onchange="disappearing({{ $user_send_user_data->id }},1)" />
            <span class="custom-radio"></span>
            1 mins
        </label>

        <label class="radio-item">
            <input type="radio" name="time" value="3" @checked(optional($user_send_user_data->DisappearMessageData)->expiring_time == 3)
            onchange="disappearing({{ $user_send_user_data->id }},3)" />
            <span class="custom-radio"></span>
            3 hours
        </label>

        <label class="radio-item">
            <input type="radio" name="time" value="24" @checked(optional($user_send_user_data->DisappearMessageData)->expiring_time == 24)
            onchange="disappearing({{ $user_send_user_data->id }},24)" />
            <span class="custom-radio"></span>
            24 hours
        </label>

        <label class="radio-item">
            <input type="radio" name="time" value="off" @checked(optional($user_send_user_data->DisappearMessageData)->expiring_time === null)
            onchange="disappearing({{ $user_send_user_data->id }},'off')" />
            <span class="custom-radio"></span>
            Off
        </label>

    </div>

</div>


<div style="position: relative;height: 100vh;background-image: url({{ asset('img/background_image_message.png') }});background-size: cover;background-position: center;">

    {{-- loader --}}
    <div style="position: absolute;height: 100%;width: 100%;display:none;z-index: 9999;background: linear-gradient(135deg,#0f2027 0%,#0b3d4a 40%,#021114 100%);" id="loader">

        <div class="spinner position-absolute" style="top: 50%;left:50%">
            <div class="spinner1"></div>
        </div>
    </div>
    <div style="position: absolute;left: 50%;top: 50%;">
        <div class="loader" style="display: none" id="loaderSmall"></div>
    </div>

    {{-- header of chating user --}}
    <div style="position: relative;padding: 15px;display: flex;justify-content: space-between;background: transparent;backdrop-filter: blur(45px);">

        <div style="height: 37px;width: 66px;display: flex;align-items: center;cursor: pointer;">

            @if (Auth::id()!=3)
            @if (isset($user_send_user_data->starUserFind))
            <i id="showStar" class="fa-solid fa-star" style="padding-right: 27px;color:#fbdfd2"></i>
            <i id="addStar" class="fa-solid fa-star" style="padding-right: 27px;display:none;color:#2e2f2f"></i>
            @else
            <i id="showStar" class="fa-solid fa-star" style="padding-right: 27px;display:none;color:#fbdfd2"></i>
            <i id="addStar" class="fa-solid fa-star" style="padding-right: 27px;color:#2e2f2f"></i>
            @endif
            @endif
            <div onclick="showContactInfo({{ $user_send_user_data->id }})">
                <div style="height: 37px;width: 37px;">

                    @if ($user_send_user_data->image_path!=Null)
                    <img style="object-fit: cover;height: 100%;width: 100%;border-radius: 20px;" src="{{ asset('storage/img/'.$user_send_user_data->image_path) }}" alt="">
                    @else
                    @if ($user_send_user_data->gender=='Men')
                    <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                    @else
                    <div style="height: 37px;width: 37px;">
                        <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt="">
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            <div onclick="showContactInfo({{ $user_send_user_data->id }})" style="color: white;padding-left: 27px;">{{ $user_send_user_data->name }}</div>
        </div>

        <div data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="Menu" data-bs-custom-class="custom-tooltip-style" data-bs-placement="left" class="manu_chatbord_top_userDetails d-flex justify-content-center align-items-center size-9 rounded-[50px]">
            <i class="fa-solid fa-ellipsis-vertical" id="toggleId" onclick="moreoptionshow()"></i>
        </div>

    </div>
    <div id="moreoptiondiv" style="border: 1px solid rgb(94 89 89);z-index: 999;padding: 6px;display: none;position: absolute;top: 14%;right: 3%;background-color: #161717;color:white;border-radius: 18px;">
        <div class="hover_change_all" style="padding: 5px;cursor: pointer;border-radius: 11px;">
            <div class="d-flex" style="font-size: 14px;">
                <i class="fa-solid fa-circle-info d-flex justify-content-center align-items-center"></i>
                <div onclick="showContactInfo({{ $user_send_user_data->id }})" style="padding-left: 10px;">
                    Contact info
                </div>
            </div>
        </div>
        <div class="hover_change_all" style="padding: 5px;cursor: pointer;border-radius: 11px;">
            <div class="d-flex" style="font-size: 14px;">
                <i class="fa-regular fa-trash-can d-flex justify-content-center align-items-center"></i>
                <div onclick="toggleSidebar()" style="padding-left: 10px;">
                    Disappearing messages
                </div>
            </div>
        </div>
        <div class="hover_change_all hover_change_all_remove" style="padding: 5px;cursor: pointer;border-radius: 11px;">
            <div class="d-flex" style="font-size: 14px;">
                <i class="fa-solid fa-circle-minus d-flex justify-content-center align-items-center"></i>
                <div onclick="removeallmessage({{ $user_send_user_data->id }})" style="padding-left: 10px;">
                    Clear Chat
                </div>
            </div>
        </div>
        <div class="hover_change_all hover_change_all_remove" style="padding: 5px;cursor: pointer;border-radius: 11px;">
            <div class="d-flex" style="font-size: 14px;">
                <i class="fa-regular fa-trash-can d-flex justify-content-center align-items-center"></i>
                <div onclick="deleteallmessage({{ $user_send_user_data->id }})" style="padding-left: 10px;">
                    Delete Chat
                </div>
            </div>
        </div>

    </div>

    {{-- messages --}}
    <div id="message_to_show">

    </div>

    {{-- message input --}}
    <emoji-picker id="emoji_picker" class="light" no-search style="display:none;width: 339px;height: 247px;position: absolute;bottom: 14%;z-index: 100;"></emoji-picker>
    <div class="bg-dark" style="margin: 10px;color: white;position: absolute;bottom: 1px;padding: 12px 16px;width: calc(100% - 20px);display: flex;border-radius: 129px;max-width: 100%;">

        <input type="file" class="form-control" name="oldfiles[]" multiple id="oldfiles" style="display: none" hidden>
        <input type="file" class="form-control" name="files[]" multiple id="files" style="display: none">
        <i class="fa-solid fa-paperclip" style="font-size: 19px;align-items: center;display: flex;justify-content: center;" onclick="FilesImageSend()"></i>
        <i class="fa-solid fa-face-smile" id="emoji_id" style="font-size: 19px;align-items: center;display: flex;justify-content: center;padding-left: 25px;"></i>

        <textarea style="color: white;border: none;background-color: #212529;width: 87%;margin-left: 15px;field-sizing: content;resize: none;max-height: 5lh;" rows="1" onclick="closeMoreOption()" oninput="userWriteText(this,{{ $user_send_user_data->id }})" autocomplete="off" class="form-control shadow-none scroll-container" id="messages" placeholder="Type a message" aria-label="Search"></textarea>

        <div class="img-thumbs img-thumbs-hidden scroll-container" id="img-preview" style="overflow: scroll;overflow-y: auto;width: 86%;margin: 0px;height: 97px;margin-left:15px"></div>

        <div class="d-flex justify-content-center align-items-center">
            <i id="sendmessageid" class="fa-solid fa-paper-plane" onclick="sendmessagetosender({{ $user_send_user_data->id }})" style="height: 40px;align-items: center;display: flex;justify-content: center;font-size: 20px;background: #212529;width: 42px;border-radius: 44px;padding-top: 4px;"></i>
        </div>
    </div>
</div>
@once
<script>
    function disappearing(to_user_id, expired_time) {
        console.log(to_user_id);
        console.log(expired_time);

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('message.deisappearing.set') }}"
            , data: {
                to_user_id: to_user_id
                , expired_time: expired_time
            }
            , success: function(res) {
                // 
            }
            , error: function(e) {
                console.log(e);
            }
        });

    }

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        $('#moreoptiondiv').css('display', 'none');
    }

    localStorage.setItem('cuurentCatboard', "{{ $user_send_user_data->name}}");

    $('#addStar').on('click', function() {
        $('#addStar').css('display', 'none');
        $('#showStar').css('display', 'block');

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('user.star.add') }}"
            , data: {
                star_user_id: "{{ $user_send_user_data->id }}"
            }
            , success: function(res) {
                // console.log(res);

            }
            , error: function(e) {
                console.log(e);
            }
        });

    });

    $('#showStar').on('click', function() {
        $('#showStar').css('display', 'none');
        $('#addStar').css('display', 'block');

        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('user.star.remove') }}"
            , data: {
                star_user_id: "{{ $user_send_user_data->id }}"
            }
            , success: function(res) {
                // console.log(res);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    });

    // Close div to Menu 
    var myDiv = document.getElementById('moreoptiondiv');
    var myDivEmoji = document.getElementById('emoji_picker');
    var toggleButton = document.getElementById('toggleId');
    var emojiButton = document.getElementById('emoji_id');
    var messages = document.getElementById('messages');

    document.addEventListener('click', function(event) {
        var isClickInsideDiv = myDiv.contains(event.target);
        var isClickOnButton = toggleButton.contains(event.target);
        var isClickOnEmojiButton = emojiButton.contains(event.target);
        var isClickOnEmojiDiv = myDivEmoji.contains(event.target);
        var messageTextarea = messages.contains(event.target);

        if (!isClickInsideDiv && !isClickOnButton) {
            if ($('#moreoptiondiv').css('display') == 'block') {
                $('#moreoptiondiv').css('display', 'none');
            }

        }
        if (!isClickOnEmojiButton && !isClickOnEmojiDiv && !messageTextarea) {
            if ($('#emoji_picker').css('display') == 'block') {
                $('#emoji_picker').css('display', 'none');
            }
        }
    });

    // Emoji Picker
    document.querySelector('emoji-picker').addEventListener('emoji-click', event => {

        const inputField = document.getElementById('messages');
        var startPos = inputField.selectionStart;
        var endPos = inputField.selectionEnd;

        inputField.value = inputField.value.substring(0, startPos) + event.detail.unicode + inputField.value.substring(endPos, inputField.value.length)
        inputField.focus();
        inputField.setSelectionRange(startPos + event.detail.unicode.length, startPos + event.detail.unicode.length);

        if ($("#sendmessageid").css('background-color') == "rgb(33, 37, 41)") {
            $("#sendmessageid").css('background-color', 'green');
        }
    });

    $('#emoji_id').on('click', function() {

        if ($('#emoji_picker').css('display') == 'none') {
            $('#emoji_picker').css('display', 'block');
        } else {
            if ($('#emoji_picker').css('display') == 'block') {
                $('#emoji_picker').css('display', 'none');
            }
        }

    });

    var inputId = document.getElementById('messages');

    inputId.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            if (!event.shiftKey) {
                event.preventDefault();
                const data_of_message = $('#messages').val().replace(/\s/g, '');

                const data_message = $('#messages').val();

                if (data_of_message.length == 0) {
                    $('#messages').val('');
                    document.getElementById('messages').rows = 1;
                } else {
                    $('#messages').val('');
                    $('#messages').attr('placeholder', 'Sending...').prop('readonly', true);
                    sendmessagetosender("{{ $user_send_user_data->id }}", data_message);

                }
            }
        }
    });

    document.getElementById('files').addEventListener('change', function() {

        var inputtag = document.getElementById('messages');
        if (this.files && this.files.length > 0) {
            $("#messages").css('display', "none")
            $("#img-preview").css('display', "block")

            var oldFiles = document.getElementById('oldfiles');
            var newFiles = document.getElementById('files');
            var oldfilesArray = Array.from(oldFiles.files);
            var newfilesArray = Array.from(newFiles.files);
            var finalArray = oldfilesArray.concat(newfilesArray);

            const dataTransfer = new DataTransfer();
            finalArray.forEach(files => {
                dataTransfer.items.add(files);
            });
            document.getElementById('files').files = dataTransfer.files;

        } else {
            $('#img-preview').html('');
            $('#img-preview').css('display', "none");
            $('#messages').css('display', "block");
        }
    })

    var imgUpload = document.getElementById('files')
        , imgPreview = document.getElementById('img-preview')
        , imgUploadForm = document.getElementById('form-upload')
        , totalFiles
        , previewTitle
        , previewTitleText
        , img;

    imgUpload.addEventListener('change', previewImgs, true);

    function previewImgs(event) {
        var oldFiles = document.getElementById('oldfiles');
        var newFiles = document.getElementById('files');
        var oldfilesArray = Array.from(oldFiles.files);
        var newfilesArray = Array.from(newFiles.files);
        var finalArray = oldfilesArray.concat(newfilesArray);

        const dataTransfer = new DataTransfer();
        finalArray.forEach(files => {
            dataTransfer.items.add(files);
        });
        document.getElementById('files').files = dataTransfer.files;

        $('#img-preview').html('');
        var imgUpload = document.getElementById('files');

        totalFiles = imgUpload.files.length;

        if (!!totalFiles) {
            imgPreview.classList.remove('img-thumbs-hidden');
        }

        for (var i = 0; i < totalFiles; i++) {
            wrapper = document.createElement('div');
            wrapper.classList.add('wrapper-thumb');
            removeBtn = document.createElement("span");
            nodeRemove = document.createTextNode('x');
            removeBtn.classList.add('remove-btn');
            removeBtn.classList.add('closeid' + i);
            removeBtn.appendChild(nodeRemove);
            img = document.createElement('img');
            img.src = URL.createObjectURL(event.target.files[i]);
            img.classList.add('img-preview-thumb');
            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            imgPreview.appendChild(wrapper);
            removeBtn.setAttribute("data-id", i);
        }

        var filesArray = Array.from(imgUpload.files);
        $('.remove-btn').click(function() {

            var data_id = $(this).attr('data-id');
            filesArray.forEach((file, index) => {
                if (index == $(this).attr('data-id')) {
                    delete filesArray[index];
                }
            });

            const dataTransfer = new DataTransfer();
            filesArray.forEach(files => {
                dataTransfer.items.add(files);
            });

            document.getElementById('files').files = dataTransfer.files;
            $(this).parent('.wrapper-thumb').remove();
            var remainingImages = $('#img-preview').find('.wrapper-thumb').length;

            if (remainingImages === 0) {
                $("#messages").css('display', "block");
                $("#file").val('');
                $('#img-preview').css('display', "none");
                $('#img-preview').html('');
                imgPreview.classList.add('img-thumbs-hidden');
            }
        });
    }

</script>

@endonce
