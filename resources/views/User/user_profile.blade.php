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
<div class="col-11">
    <form method="post" action="{{ route('user_profiles') }}" style="padding: 11px 119px 136px 112px;" enctype="multipart/form-data">
        <div class="row">
            <div class="col-5">
                @if (isset(Auth::user()->image_path))
                <div class="d-flex justify-content-center">
                    <div style="height: 222px;width: 219px;">
                        <img src="{{ asset('storage/img/'.Auth::user()->image_path) }}" style="object-fit: contain;height: 100%;width: 100%;" alt="">
                    </div>
                </div>
                <div class="container" style="margin-top: 109px;">
                    <div class="folder">
                        <div class="front-side">
                            <div class="tip"></div>
                            <div class="cover"></div>
                        </div>
                        <div class="back-side cover"></div>
                    </div>
                    <label class="custom-file-upload">
                        <input class="title" type="file" name="file" />
                        Upload a File
                    </label>
                </div>
                @else
                <div class="mt-4">
                    Add Your Images
                    <div class="d-flex justify-content-center">
                        <div style="height: 222px;width: 219px;">
                            <img style="height: 187px;width: 175px;" src="{{ asset('img/galleryimg.png') }}" alt="">
                        </div>
                    </div>
                    <div class="container" style="margin-top: 80px;">
                        <div class="folder">
                            <div class="front-side">
                                <div class="tip"></div>
                                <div class="cover"></div>
                            </div>
                            <div class="back-side cover"></div>
                        </div>
                        <label class="custom-file-upload">
                            <input class="title" type="file" name="file" />
                            Upload a File
                        </label>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-6 scroll-container" style="overflow: scroll; padding-bottom: 80px;overflow-y: auto;" id="scrollbarid">
                <h3 class="text-center mt-5 d-flex justify-content-center align-items-center" style="  background: linear-gradient(135deg, #4942e7, #f9d8c9);-webkit-background-clip: text;-webkit-text-fill-color: transparent;background-clip: text;color: transparent;height: 50px;">User Inforamtion</h3>

                @csrf
                <div class="mb-3">
                    <label class="form-label ">User Name</label>
                    <input type="text" name="id" value="{{ Auth::id() }}" hidden>
                    <input type="text" class="form-control" name="username" value="{{ old('username',Auth::user()->name) }}">
                    @error('username')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone No.</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone',Auth::user()->phone) }}">
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">

                    <label class="form-label">Gender</label> <br>
                    <input type="radio" name="gender" value="Men" {{ old('gender',Auth::user()->gender)=='Men'?'checked':'' }}>Men
                    <input type="radio" name="gender" value="Women" {{ old('gender',Auth::user()->gender)=='Women'?'checked':'' }}>Women
                    @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email',Auth::user()->email) }}">
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">

                    <a href="{{ route('dashboard') }}"><button type="button" class="btn btn-primary">Back</button></a>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                </div>
    </form>
</div>
</div>
</div>
@endsection
