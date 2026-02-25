@extends('User.dashbord')
@section('content')
<style>
    .container {
        --transition: 350ms;
        --folder-W: 130px;
        --folder-H: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding: 10px;
        background: linear-gradient(135deg, #837ef0, #f9d8c9);
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        width: var(--folder-W);
        height: calc(var(--folder-H) * 1.7);
        position: relative;
    }

    .folder {
        position: absolute;
        top: -20px;
        left: calc(50% - 60px);
        animation: float 2.5s infinite ease-in-out;
        transition: transform var(--transition) ease;
    }

    .folder:hover {
        transform: scale(1.05);
    }

    .folder .front-side,
    .folder .back-side {
        position: absolute;
        transition: transform var(--transition);
        transform-origin: bottom center;
    }

    .folder .back-side::before,
    .folder .back-side::after {
        content: "";
        display: block;
        background-color: white;
        opacity: 0.5;
        z-index: 0;
        width: var(--folder-W);
        height: var(--folder-H);
        position: absolute;
        transform-origin: bottom center;
        border-radius: 15px;
        transition: transform 350ms;
        z-index: 0;
    }

    .container:hover .back-side::before {
        transform: rotateX(-5deg) skewX(5deg);
    }

    .container:hover .back-side::after {
        transform: rotateX(-15deg) skewX(12deg);
    }

    .folder .front-side {
        z-index: 1;
    }

    .container:hover .front-side {
        transform: rotateX(-40deg) skewX(15deg);
    }

    .folder .tip {
        background: linear-gradient(135deg, #ff9a56, #ff6f56);
        width: 80px;
        height: 20px;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        position: absolute;
        top: -10px;
        z-index: 2;
    }

    .folder .cover {
        background: linear-gradient(135deg, #ffe563, #ffc663);
        width: var(--folder-W);
        height: var(--folder-H);
        box-shadow: 0 15px 30px #0000004d;
        border-radius: 10px;
    }

    .custom-file-upload {
        font-size: 1.1em;
        color: #ffffff;
        text-align: center;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: background var(--transition) ease;
        display: inline-block;
        padding: 10px 10px;
        position: relative;
        font-family: Arial, Helvetica, sans-serif;
    }

    .custom-file-upload:hover {
        background: rgba(255, 255, 255, 0.4);
    }

    .custom-file-upload input[type="file"] {
        display: none;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }

</style>
<div class="col-12 col-sm-4">
    <form method="post" action="{{ route('user_profiles') }}" enctype="multipart/form-data">
        <div class="row" style="padding: 20px;">
            <h3 class="text-white" style="font-family: 'Inter', sans-serif;">Profile</h3>

            <div class="row scroll-container2" style="height: 89vh;">
                @if (isset(Auth::user()->image_path))
                <div class="d-flex justify-content-center" style="padding: 30px;">

                    <div style="position: relative; height: 151px; width: 150px;" onclick="imageMoreMenuShow()" class="d-flex justify-content-center">

                        <!-- Profile Image -->
                        <img id="UserImagePreview" style="height: 100%; width:100%; object-fit: cover; border-radius: 180px;" src="{{ asset('storage/img/'.Auth::user()->image_path) }}" alt="">

                        <!-- Camera/Icon Button -->
                        <div style="top: 11px;position: absolute;bottom: 0;right: 0;height: 40px;width: 40px;background: #0a3843;display: flex;justify-content: center;align-items: center;border-radius: 50%;color: white;">

                            <i class="fa-solid fa-image"></i>

                        </div>

                    </div>

                </div>

                <div id="imageMenu" style="display:none;position: absolute;background: rgb(22, 23, 23);height: 81px;width: 168px;top: 29%;left: 26%;border-radius: 20px;">

                    <div class="hover_change_all" style="margin-top: 7px;padding: 5px;border-radius: 20px;">
                        <div class="d-flex text-white" onclick="triggerInputFile()">
                            <i class="fa-solid fa-folder-open d-flex justify-content-center align-items-center"></i>
                            <div style="padding-left: 5px;font-family: 'Inter', sans-serif;">
                                Upload Image
                            </div>
                        </div>
                    </div>
                    <div class="hover_change_all" style="padding: 5px;border-radius: 20px;">
                        <a href="{{ route('user_profiles_image_remove') }}" style="text-decoration: none;">
                            <div class="d-flex text-white">
                                <i class="fa-regular fa-trash-can d-flex justify-content-center align-items-center"></i>
                                <div style="padding-left: 5px;font-family: 'Inter', sans-serif;">
                                    Remove Image
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
                @else
                <div class="d-flex justify-content-center" style="padding: 30px;">
                    <div style="height: 151px;width: 150px;" onclick="imageMoreMenuShow()" class="d-flex justify-content-center">
                        @if (Auth::user()->gender=='Men')
                        <img id="UserImagePreview" style="height: 100%;width:100%;object-fit: cover;border-radius: 180px;" src="{{ asset('img/male.png') }}" alt="">

                        @else
                        <img id="UserImagePreview" style="height: 100%;width:100%;object-fit: cover;border-radius: 180px;" src="{{ asset('img/female.png') }}" alt="">
                        @endif
                    </div>
                </div>

                <div id="imageMenu" style="display:none;position: absolute;background: rgb(22, 23, 23);height: 50px;width: 168px;top: 29%;left: 26%;border-radius: 20px;">

                    <div class="hover_change_all" style="margin-top: 7px;padding: 5px;border-radius: 20px;">
                        <div class="d-flex text-white" onclick="triggerInputFile()">
                            <i class="fa-solid fa-folder-open d-flex justify-content-center align-items-center"></i>
                            <div style="padding-left: 5px;font-family: 'Inter', sans-serif;">
                                Upload Image
                            </div>
                        </div>
                    </div>

                </div>
                @endif
                @error('file')

                <div style="margin: px 0px 0px 40px;" class="text-danger">{{ $message }}</div>

                @enderror

                @csrf
                <input class="title" type="file" id="UserImage" name="file" hidden />
                <div class="mb-3">
                    <label class="form-label" style="color: gray;">Name</label>
                    <input type="text" name="id" value="{{ Auth::id() }}" hidden>
                    <div class="d-flex">
                        <input type="text" id="username" readonly style="border-radius: 0px;background: transparent;border: none;color: white;padding: 10px 0px;box-shadow: none;" class="form-control" name="username" value="{{ old('username',Auth::user()->name) }}">
                        <div class="d-flex justify-content-center align-items-center" onclick="editInputBox(this)">
                            <i class="fa-solid fa-pen-fancy text-white"></i>
                            <i class="fa-solid fa-check text-white" style="display: none"></i>
                        </div>
                    </div>
                    @error('username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: gray;">Phone No.</label>
                    <div class="d-flex">
                        <input type="text" readonly style="border-radius: 0px;background: transparent;border: none;color: white;padding: 10px 0px;box-shadow: none;" class="form-control profile-input-border" name="phone" value="{{ old('phone',Auth::user()->phone) }}">
                        <div class="d-flex justify-content-center align-items-center" onclick="editInputBox(this)">
                            <i class="fa-solid fa-pen-fancy text-white"></i>
                            <i class="fa-solid fa-check text-white" style="display: none"></i>
                        </div>
                    </div>
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">

                    <label class="form-label" style="color: gray;">Gender</label> <br>
                    <input type="radio" name="gender" value="Men" {{ old('gender',Auth::user()->gender)=='Men'?'checked':'' }}><span class="text-white">Men</span>
                    <input type="radio" name="gender" value="Women" {{ old('gender',Auth::user()->gender)=='Women'?'checked':'' }}><span class="text-white">Women</span>
                    @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" style="color: gray;">Email Address</label>
                    <div class="d-flex">
                        <input type="text" readonly style="border-radius: 0px;background: transparent;border: none;color: white;padding: 10px 0px;box-shadow: none;" class="form-control profile-input-border" name="email" value="{{ old('email',Auth::user()->email) }}">
                        <div class="d-flex justify-content-center align-items-center" onclick="editInputBox(this)">
                            <i class="fa-solid fa-pen-fancy text-white"></i>
                            <i class="fa-solid fa-check text-white" style="display: none"></i>
                        </div>
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between" style="padding-top: 26px;padding-bottom: 26px;">

                    <a href="{{ route('dashboard') }}"><button type="button" class="rounded-5 btn btn-primary">Back</button></a>
                    <button type="submit" class="btn btn-primary rounded-5">Save Change</button>
                </div>

            </div>
    </form>
</div>
</div>
<div class="col-0 col-sm-7">
    <div class="d-flex justify-content-center align-items-center text-white" style="height: 100vh">
        <h3>
            Profile
        </h3>
    </div>
</div>
</div>


<script>
    function triggerInputFile() {
        $("#UserImage").click();
        $('#imageMenu').css('display', 'none');
    }

    function imageMoreMenuShow() {

        if ($('#imageMenu').css('display') == 'none') {
            $('#imageMenu').css('display', 'block');
        } else {
            $('#imageMenu').css('display', 'none');
        }

    }

    function editInputBox(thisDiv) {

        if ($($(thisDiv).children()[1]).css('display') == 'none') {
            $($(thisDiv).children()[0]).css('display', 'none');
            $($(thisDiv).children()[1]).css('display', 'block');
            $(thisDiv).parent().children().eq(0).prop('readonly', false);
            $(thisDiv).parent().children().eq(0).css("border-bottom", "1px solid");

        } else {
            $($(thisDiv).children()[0]).css('display', 'block');
            $($(thisDiv).children()[1]).css('display', 'none');
            $(thisDiv).parent().children().eq(0).prop('readonly', true);
            $(thisDiv).parent().children().eq(0).css("border-bottom", "none");

        }
    }


    fileInput = document.getElementById('UserImage');
    imagePreview = document.getElementById('UserImagePreview');


    fileInput.addEventListener('change', function(event) {

        const files = event.target.files;

        if (files && files[0] && files[0].name.split('.')[1] == 'png' || files[0].name.split('.')[1] == 'jpg' || files[0].name.split('.')[1] == 'svg') {

            reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                console.log(e.target.result);

            };

            reader.readAsDataURL(files[0]);

        }
    });

</script>
@endsection
