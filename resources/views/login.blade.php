<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light" style="width: 100%;">

    <div class="row" style="width: 100%;">
        <div class="col-6">
            <img src="{{ asset('img/login.png') }}" style="position: fixed;height: 100%;" alt="">
        </div>
        <div class="col-6" style="padding: 84px 114px 0px 114px;">
            <form method="post" action="{{ route('login') }}" class="card" style="padding: 27px 50px 27px 50px;border-radius: 60px;">
                @csrf
                <h2 style="text-align: center;margin-top: 18px;margin-bottom: 20px;">Login</h2>
                <div class="mb-3">
                    <label class="form-label">User Name Or Email address</label>
                    <input type="text" class="form-control" name="user_name_email" value="{{ old('user_name_email') }}">
                    @error('user_name_email')
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
                <div style="display: flex;justify-content: space-between;">
                    <p>You have not Account ?</p>
                    <a href="{{ route('registration') }}">Registration</a>
                </div>
                <button type="submit" style="margin-bottom: 20px;" class="btn btn-primary">Login</button>
            </form>
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

    </script>
</body>
</html>
