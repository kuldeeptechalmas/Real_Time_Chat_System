<div class="text-white" style="padding: 20px 20px 20px 16px;">
    <div>
        <i class="fa-solid fa-xmark text-white" onclick="setsenduser({{ $select_user_data->id }})"></i>
        <span style="padding-left: 17px;">
            Contact Info
        </span>
    </div>
    <div style="display: flex;justify-content: center;margin-top: 33px;">
        @if ($select_user_data->image_path==Null)
        @if ($select_user_data->gender=='Men')
        <div style="height: 137px;width: 137px;">
            <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt="">
        </div>
        @else
        <div style="height: 137px;width: 137px;">
            <img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt="">
        </div>
        @endif
        @else
        <div style="height: 137px;width: 137px;">
            <img style="height: 100%;width: 100%;object-fit: cover;border-radius: 22px;" src="{{ asset('storage/img/'.$select_user_data->image_path) }}" alt="">
        </div>
        @endif
    </div>
    <div style="display: flex;justify-content: center;margin-top: 15px;">
        {{ $select_user_data->name }}
    </div>
    <div style="display: flex;justify-content: center;margin-top: 15px;">
        <span style="padding-right: 5px;">+91</span>{{ $select_user_data->phone }}
    </div>
    <hr style="margin: 3px;">
    <div class="hover_change_all_remove hover_change_all d-flex" onclick="removeallmessage({{ $select_user_data->id }})" style="height: 49px;border-radius: 16px;">
        <i class="fa-regular fa-trash-can d-flex justify-content-center align-items-center" style="margin-left: 20px;"></i>
        <span class="d-flex justify-content-center align-items-center" style="padding-left: 13px;">
            Delete Chat
        </span>
    </div>
    <hr style="margin: 3px;">
</div>
