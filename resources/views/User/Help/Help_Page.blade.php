@extends('User.dashbord')

@section('content')
{{-- searching and show user --}}
<div class="col-4 bg-light" style="padding: 0px;">

    <div onclick="CreateGroupDiv()" style="display: flex;justify-content: center;align-items: center;font-size: 21px;position: absolute;background: #828CAC;border-radius: 27px;bottom: 20px;right: 61%;z-index: 99;height: 40px;width: 40px;">
        <i class="fa-solid fa-plus" style="color: white;"></i>
    </div>

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
    <div class="scroll-container" style="height: 500px;overflow: scroll; padding-bottom: 80px;overflow-y: auto;" style="padding: 0px 20px 7px 20px;">
        <div class="d-flex bg-white" style="position: relative;padding: 16px;margin: 4px;">
            <div class="d-flex justify-content-center" style="height: 37px;width: 37px;">
                @if ($help_user->image_path!=Null)
                <img data-bs-toggle="modal" data-bs-target="#imageshowmodel" onclick="imagesetshow('{{ $help_user->name }}','{{ $help_user->image_path }}')" style="height: 100%;width: 100%;object-fit: cover;border-radius: 21px;" src="{{ asset('storage/img/'.$help_user->image_path) }}" alt="">
                @else
                @if ($help_user->gender=='Men')
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/male.png') }}" alt=""></div>
                @else
                <div style="height: 37px;width: 37px;"><img style="height: 100%;width: 100%;border-radius: 114px;object-fit: cover;" src="{{ asset('img/female.png') }}" alt=""></div>
                @endif
                @endif
            </div>
            <div style="width: 100%;" onclick="setsenduserHelpuser({{ $help_user->id }})">
                <div style="margin-left: 21px;" id="{{ $help_user->name }}">
                    {{ $help_user->name }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- chatboard --}}
<div class="col-7" style="background: white;padding: 0px;" id="chatboardofreceiverHelpUser">
    <div style="width: 292px;height: 283px;margin-left: 250px;margin-top: 92px;">
        <img src="{{ asset('img/messages.png') }}" style="height: 100%;width: 100%;" alt="">
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("hello");
        console.log($($('.fa-solid.fa-plus').parent()[0]).css('display', 'none'));

        $('.fa-solid.fa-plus').css('display', 'none');
    });

    function setsenduserHelpuser(helpuser_id) {

        console.log(helpuser_id);
        $.ajax({
            type: 'post'
            , headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            , url: "{{ route('help.user.select') }}"
            , data: {
                select_user_id: helpuser_id
            }
            , success: function(res) {

                localStorage.setItem('current_user_chatboard', helpuser_id);
                $('#chatboardofreceiverHelpUser').html(res);
                message_show(helpuser_id);
            }
            , error: function(e) {
                console.log(e);
            }
        });
    }

</script>
@endsection
