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
    }

    .remove-btn:hover {
        box-shadow: 0px 0px 3px grey;
        transition: all .3s ease-in-out;
    }

</style>

<div style="position: relative;height: 100vh;">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 15px;background-color: #fbdfd26e;display: flex;justify-content: space-between;">

        <div style="height: 37px;width: 66px;display: flex;align-items: center;">
            <div style="height: 37px;width: 37px;">

                @if ($chatboart_group->image_path!=Null)
                <img style="object-fit: cover;height: 100%;width: 100%;border-radius: 20px;" src="{{ asset('storage/img/'.$chatboart_group->image_path) }}" alt="">
                @else
                <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $chatboart_group->name }}','freepik__talk__488.png')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/freepik__talk__488.png') }}" alt="">
                @endif
            </div>
        </div>
        <div>{{ $chatboart_group->name }}</div>

        <i class="fa-solid fa-ellipsis-vertical" onclick="moreoptionshow()"></i>
        <div id="moreoptiondiv" style="z-index: 999;padding: 16px;display: none;position: absolute;top: 110%;right: 4%;background: lightblue;border-radius: 6px;">
            <i class="fa-solid fa-xmark" onclick="closemanu()" style="position: absolute;top: 3%;right: 3%;"></i>
            <div onclick="removeallmessage({{ $chatboart_group->id }})" style="margin-top: 4px;padding: 5px;border: #8e8e8e solid;border-radius: 11px;">
                Remove All
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
    <div class="bg-light" style="position: absolute;bottom: 1px;padding: 16px;width: 100%;display: flex;border-radius: 129px;">

        <input type="file" class="form-control" name="oldfiles[]" multiple id="oldfiles" style="display: none" hidden>
        <input type="file" class="form-control" name="files[]" multiple id="files" style="display: none">
        <i class="fa-solid fa-paperclip" style="padding-top: 14px;font-size: 19px;align-items: center;display: flex;justify-content: center;" onclick="FilesImageSend()"></i>
        <i class="fa-solid fa-face-smile" id="emoji_id" style="padding-top: 14px;font-size: 19px;align-items: center;display: flex;justify-content: center;padding-left: 25px;"></i>
        <textarea style="width: 87%;margin-left: 20px; resize: none;" rows="1" oninput="userWriteText(this,{{ $chatboart_group->id }})" autocomplete="off" class="form-control scroll-container" id="messages" placeholder="Type Message Here..." aria-label="Search"></textarea>

        {{-- <input type="file" class="form-control" name="images[]" multiple style="display: none" id="upload-img" /> --}}
        <div class="img-thumbs img-thumbs-hidden scroll-container" id="img-preview" style="overflow: scroll;overflow-y: auto;width: 86%;margin: 0px;height: 97px;margin-left:20px"></div>

        <input type="submit" value="" hidden>
        <i type class="fa-solid fa-paper-plane" onclick="sendmessagetosenderGroup({{ $chatboart_group->id }})" style="align-items: center;display: flex;justify-content: center;padding-top: 9px;margin-left: 15px;font-size: 20px;"></i>
    </div>
</div>
<script>
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
                star_user_id: "{{ $chatboart_group->id }}"
            }
            , success: function(res) {
                console.log(res);

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
                star_user_id: "{{ $chatboart_group->id }}"
            }
            , success: function(res) {
                console.log(res);

            }
            , error: function(e) {
                console.log(e);
            }
        });
    });

    document.querySelector('emoji-picker').addEventListener('emoji-click', event => {
        const data_message = $('#messages').val();
        $('#messages').val(data_message + event.detail.unicode);
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
                console.log($('#messages').val());

                if (data_of_message.length == 0) {
                    $('#messages').val('');
                    document.getElementById('messages').rows = 1;
                } else {
                    $('#messages').val('');
                    $('#messages').attr('placeholder', 'Sending...').prop('readonly', true);
                    sendmessagetosenderGroup("{{ $chatboart_group->id }}", data_message);

                }
            } else {
                if (inputId.rows == 1) {
                    inputId.rows = 2;
                } else if (inputId.rows == 2) {
                    inputId.rows = 3;
                } else if (inputId.rows == 3) {
                    inputId.rows = 4;
                } else if (inputId.rows == 4) {
                    inputId.rows = 5;
                } else {
                    inputId.rows = 5;
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
        console.log(imgUpload.files);

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
