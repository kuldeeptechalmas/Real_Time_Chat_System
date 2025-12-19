<div style="position: relative;height: 100vh;">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 15px;background-color: #fbdfd26e;display: flex;justify-content: space-between;">
        <div>{{ $user_send_user_data->name }}</div>
        <i class="fa-solid fa-ellipsis-vertical" onclick="moreoptionshow()"></i>
        <div id="moreoptiondiv" style="padding: 16px;display: none;position: absolute;top: 110%;right: 4%;background: lightblue;border-radius: 6px;">
            <i class="fa-solid fa-xmark" onclick="closemanu()" style="position: absolute;top: 3%;right: 3%;"></i>
            {{-- <div style="padding: 5px;border: #8e8e8e solid;border-radius: 11px;">
                Menu
            </div> --}}
            <div onclick="removeallmessage($user_send_user_data->id)" style="margin-top: 4px;padding: 5px;border: #8e8e8e solid;border-radius: 11px;">
                Clean All
            </div>
        </div>
    </div>
    {{-- messages --}}
    <div id="message_to_show">

    </div>

    {{-- message input --}}
    <div class="bg-light" style="position: absolute;bottom: 1px;padding: 16px;width: 100%;display: flex;border-radius: 129px;">
        <i class="fa-solid fa-paperclip" style="padding-top: 14px;font-size: 19px;"></i>
        <input style="width: 87%;margin-left: 20px;" autocomplete="off" class="form-control" id="messages" placeholder="Type Message Here..." aria-label="Search" />
        <input type="submit" value="" hidden>
        <i class="fa-solid fa-paper-plane" onclick="sendmessagetosender({{ $user_send_user_data->id }})" style="padding-top: 9px;margin-left: 15px;font-size: 20px;"></i>
    </div>
</div>
