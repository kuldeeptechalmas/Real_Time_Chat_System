<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>forgotpassword</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="row h-100 w-100">

        <div class="col-6" style="padding: 61px 103px 0px 114px;">
            <form method="post" action="{{ route('forgotpassword') }}" class="card" style="padding: 17px 48px 19px 50px;border-radius: 60px;">
                @csrf
                <h2 style="text-align: center;margin-top: 18px;margin-bottom: 20px;">Forgot Password</h2>
                <div class="mb-3">
                    <label class="form-label">User Name Or Email address</label>
                    <input type="text" class="form-control" name="user_name_email" value="{{ old('user_name_email') }}">
                    @error('user_name_email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                        <div style="position: absolute;top: 27%;right: 5%;">
                            <i class="fa-solid fa-eye" id="showpassword" style="display: block;" onclick="passwordicon(this)"></i>
                            <i class="fa-solid fa-eye-slash" id="hidepassword" style="display: none;" onclick="passwordicon(this)"></i>
                        </div>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Conform Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" id="confpassword" name="confpassword" value="{{ old('confpassword') }}">
                        <div style="position: absolute;top: 27%;right: 5%;">
                            <i class="fa-solid fa-eye" id="confshowpassword" style="display: block;" onclick="confpasswordicon(this)"></i>
                            <i class="fa-solid fa-eye-slash" id="confhidepassword" style="display: none;" onclick="confpasswordicon(this)"></i>
                        </div>
                    </div>
                    @error('confpassword')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('login') }}">
                        <button type="button" style="margin-bottom: 20px;" class="btn btn-primary mt-2">Back</button>
                    </a>
                    <button type="submit" style="margin-bottom: 20px;" class="btn btn-primary mt-2">Forgot Password</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <img style="height: 100%;position: fixed;" src="{{ asset('img/forgotpassword.jpg') }}" alt="">
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        function passwordicon(e) {
            if (e.id == 'showpassword') {
                $('#showpassword').css('display', 'none');
                $('#hidepassword').css('display', 'block');
                document.getElementById('password').type = 'text';
            } else {
                $('#hidepassword').css('display', 'none');
                $('#showpassword').css('display', 'block');
                document.getElementById('password').type = 'password';
            }
        }

        function confpasswordicon(e) {
            if (e.id == 'confshowpassword') {
                $('#confshowpassword').css('display', 'none');
                $('#confhidepassword').css('display', 'block');
                document.getElementById('confpassword').type = 'text';
            } else {
                $('#confhidepassword').css('display', 'none');
                $('#confshowpassword').css('display', 'block');
                document.getElementById('confpassword').type = 'password';
            }
        }

    </script>
</body>
</html>
