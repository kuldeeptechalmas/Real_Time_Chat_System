<style>
    .img-thumbs {
        background: #eee;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        margin: 1.5rem 0;
        padding: 0.75rem;
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
        margin: 1rem 0;
        justify-content: space-around;
    }

    .img-preview-thumb {
        height: 100%;
        width: 100%;
        object-fit: cover;
        background: #fff;
        border: 1px solid none;
        border-radius: 0.25rem;
        box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
        margin-right: 1rem;
        max-width: 140px;
        padding: 0.25rem;
    }

    .remove-btn {
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: .7rem;
        top: -5px;
        right: 10px;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        color: #161717;
    }

    .remove-btn:hover {
        box-shadow: 0px 0px 3px grey;
        transition: all .3s ease-in-out;
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

</style>

<div style="position: relative;height: 100vh;background-image: url({{ asset('img/background_image_message.png') }})">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 15px;display: flex;justify-content: space-between;background: #1c1d1d;">

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


        <div id="moreoptiondiv" style="border: 1px solid rgb(94 89 89);z-index: 999;padding: 6px;display: none;position: absolute;top: 97%;right: 3%;background-color: #161717;color:white;border-radius: 18px;">
            <div class="hover_change_all" style="padding: 5px;cursor: pointer;border-radius: 11px;">
                <div class="d-flex">
                    <i class="fa-solid fa-circle-info d-flex justify-content-center align-items-center"></i>
                    <div onclick="showContactInfo({{ $user_send_user_data->id }})" style="padding-left: 10px;">
                        Contact info
                    </div>
                </div>
            </div>
            <div class="hover_change_all hover_change_all_remove" style="padding: 5px;cursor: pointer;border-radius: 11px;">
                <div class="d-flex">
                    <i class="fa-solid fa-circle-minus d-flex justify-content-center align-items-center"></i>
                    <div onclick="removeallmessage({{ $user_send_user_data->id }})" style="padding-left: 10px;">
                        Delete Chat
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="position: absolute;left: 50%;top: 50%;">
        <div class="loader" style="display: none" id="loader"></div>
    </div>
    {{-- messages --}}
    <div id="message_to_show">

    </div>

    {{-- message input --}}
    <emoji-picker id="emoji_picker" class="light" no-search style="display:none;width: 339px;height: 247px;position: absolute;bottom: 14%;"></emoji-picker>
    <div class="bg-dark" style="margin: 10px;color: white;position: absolute;bottom: 1px;padding: 16px;width: 96%;display: flex;border-radius: 129px;">

        <input type="file" class="form-control" name="oldfiles[]" multiple id="oldfiles" style="display: none" hidden>
        <input type="file" class="form-control" name="files[]" multiple id="files" style="display: none">
        <i class="fa-solid fa-paperclip" style="padding-top: 14px;font-size: 19px;align-items: center;display: flex;justify-content: center;" onclick="FilesImageSend()"></i>
        <i class="fa-solid fa-face-smile" id="emoji_id" style="padding-top: 14px;font-size: 19px;align-items: center;display: flex;justify-content: center;padding-left: 25px;"></i>

        <textarea style="color: white;border: none;background-color: #212529;width: 87%;margin-left: 28px;field-sizing: content;resize: none;max-height: 5lh;" rows="1" onclick="closeMoreOption()" oninput="userWriteText(this,{{ $user_send_user_data->id }})" autocomplete="off" class="form-control shadow-none scroll-container" id="messages" placeholder="Type a message" aria-label="Search"></textarea>

        <div class="img-thumbs img-thumbs-hidden scroll-container" id="img-preview" style="overflow: scroll;overflow-y: auto;width: 86%;margin: 0px;height: 97px;margin-left:20px"></div>

        <div class="d-flex justify-content-center align-items-center">
            <i id="sendmessageid" class="fa-solid fa-paper-plane" onclick="sendmessagetosender({{ $user_send_user_data->id }})" style="height: 40px;align-items: center;display: flex;justify-content: center;font-size: 20px;background: #212529;width: 42px;border-radius: 44px;padding-top: 4px;"></i>
        </div>
    </div>
</div>
@once
<script>
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
