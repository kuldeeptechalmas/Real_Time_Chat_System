@php
use Carbon\Carbon;
@endphp
<div style="position: relative;height: 100vh;" class="bg-light">
    {{-- header of chating user --}}
    <div style="position: relative;padding: 22px;background-color: #fbdfd26e;display: flex;justify-content: space-between;">
        Create Group...
    </div>
    <div class="d-flex mt-2" style="padding: 10px;">
        <input type="text" placeholder="Group Namge" class="form-control scroll-container" style="width: 31%;" name="" id="group_name">
        <button type="button" onclick="FinalCreateGroup()" style="position: absolute;background: rgba(208, 242, 208, 0.5);right: 3%;" class="btn btn-info">New Group Create</button>
    </div>
    <div>
        @if (isset($last_message_send_data))

        @if ($last_message_send_data->isNotEmpty())
        @foreach ($last_message_send_data as $item)

        <div class="d-flex" onclick="SelectedGroupUser(this)" data-id="{{ $item->user_data_to_message->id }}" id="{{ $item->user_data_to_message->id }}" style="background-color: white;position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                @if ($item->user_data_to_message->image_path!=Null)
                <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $item->user_data_to_message->name }}','{{ $item->user_data_to_message->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$item->user_data_to_message->image_path) }}" alt="">
                @else
                @if ($item->user_data_to_message->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
            </div>
            <div style="width: 100%;display: flex;">
                <div style="margin-left: 21px;display: flex;" id="{{ $item->user_data_to_message->name }}">
                    {{ $item->user_data_to_message->name }}

                </div>

                @if (isset($item->user_data_to_message->last_seen_at))

                @php
                $old_time = Carbon::parse($item->user_data_to_message->last_seen_at->timezone('Asia/Kolkata'));
                $current = Carbon::now();
                $diff = $old_time->diff($current);
                @endphp
                <div style="font-size: 12px;position: absolute;top: 29%;right: 6%;">

                    @if ($old_time->diffInMinutes($current)>60)
                    @if ($old_time->diffInHours($current)>24)
                    {{ $diff->format('%d') }}d

                    @else
                    {{ $diff->format('%h') }}h
                    {{ $diff->format('%i') }}m

                    @endif
                    @else
                    {{ $diff->format('%i') }}m
                    @endif

                    @endif
                </div>
            </div>
        </div>

        @endforeach

        @else
        <div style="display: flex;justify-content: center;margin-top: 25%;">
            Not Found Result
        </div>
        @endif
        @endif

    </div>
</div>
