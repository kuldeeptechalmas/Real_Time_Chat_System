<div style="position: relative;height: 100vh;">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 15px;background-color: #fbdfd26e;display: flex;justify-content: space-between;">
        <div style="height: 37px;width: 37px;">
            @if ($user_send_user_data->image_path!=Null)
            <img style="object-fit: cover;height: 100%;width: 100%;border-radius: 20px;" src="{{ asset('storage/img/'.$user_send_user_data->image_path) }}" alt="">
            @else
            @if ($user_send_user_data->gender=='Men')
            <i class="fa-solid fa-user" style="font-size: 21px;"></i>
            @else
            <i class="fa-regular fa-user" style="font-size: 21px;"></i>
            @endif
            @endif
        </div>
        <div>{{ $user_send_user_data->name }}</div>

        <i class="fa-solid fa-ellipsis-vertical" onclick="moreoptionshow()"></i>
        <div id="moreoptiondiv" style="padding: 16px;display: none;position: absolute;top: 110%;right: 4%;background: lightblue;border-radius: 6px;">
            <i class="fa-solid fa-xmark" onclick="closemanu()" style="position: absolute;top: 3%;right: 3%;"></i>
            <div onclick="removeallmessage({{ $user_send_user_data->id }})" style="margin-top: 4px;padding: 5px;border: #8e8e8e solid;border-radius: 11px;">
                Clean All
            </div>
        </div>
    </div>
    {{-- messages --}}
    <div id="message_to_show">

    </div>

    {{-- message input --}}
    <div class="bg-light" style="position: absolute;bottom: 1px;padding: 16px;width: 100%;display: flex;border-radius: 129px;">
        <input type="file" name="files[]" multiple id="files" style="display: none">
        <i class="fa-solid fa-paperclip" style="padding-top: 14px;font-size: 19px;" onclick="FilesImageSend()"></i>
        <textarea style="width: 87%;margin-left: 20px; resize: none;" rows="1" autocomplete="off" class="form-control scroll-container" id="messages" placeholder="Type Message Here..." aria-label="Search"></textarea>
        {{-- <input type="text" /> --}}
        <input type="submit" value="" hidden>
        <i type class="fa-solid fa-paper-plane" onclick="sendmessagetosender({{ $user_send_user_data->id }})" style="padding-top: 9px;margin-left: 15px;font-size: 20px;"></i>
    </div>
</div>
<script>
    var inputId = document.getElementById('messages');

    inputId.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            if (!event.shiftKey) {
                event.preventDefault();
                const data_of_message = $('#messages').val();
                $('#messages').val('');

                sendmessagetosender("{{ $user_send_user_data->id }}", data_of_message);
            }
        }
    });

    document.getElementById('files').addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            $('#messages').val(this.files[0].name);
            console.log(this.files);
        } else {
            console.log('no file ok');
        }
    })

</script>
