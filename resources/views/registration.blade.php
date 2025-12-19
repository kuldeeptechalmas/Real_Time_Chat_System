<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="row" style="width: 100%">
        <div class="col-6" style="padding: 75px 66px 110px 132px;">
            <div class="bg-white card" style="border-radius: 41px;">
                <h2 style="text-align: center;padding: 22px;">
                    registration
                </h2>
                <form method="post" action="{{ route('registration') }}" style="padding-left: 46px;padding-right: 52px;">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                        @error('username')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone No.</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
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
                            <input type="password" class="form-control" id="cpassword" name="cpassword" value="{{ old('cpassword') }}">
                            <div style="position: absolute;top: 27%;right: 5%;">
                                <i class="fa-solid fa-eye" id="showcpassword" style="display: block;" onclick="cpasswordicon(this)"></i>
                                <i class="fa-solid fa-eye-slash" id="hidecpassword" style="display: none;" onclick="cpasswordicon(this)"></i>
                            </div>
                        </div>
                        @error('cpassword')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    You have Account then <a href="{{ route('login') }}">Login</a>
                    <button type="submit" class="btn btn-primary w-100 my-3">Registration</button>
                </form>
            </div>
        </div>
        <div class="col-6">
            <img style="height: 100%;object-fit: contain;position: fixed" src="{{ asset('img/registration.png') }}" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        function cpasswordicon(e) {
            if (e.id == 'showcpassword') {
                $('#showcpassword').css('display', 'none');
                $('#hidecpassword').css('display', 'block');
                document.getElementById('cpassword').type = 'text';
            } else {
                $('#hidecpassword').css('display', 'none');
                $('#showcpassword').css('display', 'block');
                document.getElementById('cpassword').type = 'password';
            }
        }

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

    </script>
</body>
</html>
