<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Real Time Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f2027 0%, #0b3d4a 40%, #021114 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .login-container {
            min-height: 100vh;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 255, 0.2);
        }

        .form-control {
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #01a58b;
            box-shadow: 0 0 0 0.2rem rgba(1, 165, 139, 0.25);
            background: rgba(255, 255, 255, 0.05);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
            opacity: 1;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #01a58b 0%, #00c9a7 100%);
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 12px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00c9a7 0%, #01a58b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(1, 165, 139, 0.4);
        }

        .password-toggle {
            color: rgba(255, 255, 255, 0.6) !important;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        a {
            color: #01a58b;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #00c9a7;
            text-decoration: underline;
        }

        .login-image {
            object-fit: cover;
            height: 100%;
        }

        @media (max-width: 768px) {
            .form-card {
                margin: 20px;
                padding: 30px 25px !important;
            }

            .login-image {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 25px 20px !important;
            }

            h4 {
                font-size: 1.5rem;
            }
        }

    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row g-0 vh-100">
            <!-- Left image column -->
            <div class="col-md-6 d-none d-md-block p-0">
                <img src="{{ asset('img/login.png') }}" alt="Login Image" class="login-image w-100 h-100">
            </div>

            <!-- Right form column -->
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center p-3 p-md-5">
                <div class="form-card text-light w-100" style="max-width: 500px; border-radius: 20px; padding: 40px 50px;">
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <!-- Title -->
                        <h4 class="text-center mb-4 fw-bold">Sign In Your Account</h4>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="user_name_email" class="form-label">
                                <i class="fa-solid fa-user me-2"></i>Username or Email
                            </label>
                            <input type="text" class="form-control rounded-pill bg-transparent text-light border-0" id="user_name_email" name="user_name_email" placeholder="Enter your username or email" value="{{ old('user_name_email') }}" style="border-radius: 20px; padding: 12px 20px;">
                            @error('user_name_email')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">
                                <i class="fa-solid fa-lock me-2"></i>Password
                            </label>
                            <input type="password" class="form-control rounded-pill bg-transparent text-light border-0" id="password" name="password" placeholder="Enter your password" value="{{ old('password') }}" style="border-radius: 20px; padding: 12px 50px 12px 20px;">
                            <div class="password-toggle" style="position: absolute; top: 70%; right: 20px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                <i class="fa-solid fa-eye" id="showpassword" onclick="passwordicon(this)"></i>
                                <i class="fa-solid fa-eye-slash" id="hidepassword" onclick="passwordicon(this)" style="display:none;"></i>
                            </div>
                            @error('password')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="text-end mb-4">
                            <a href="{{ route('forgotpassword') }}" class="small">
                                <i class="fa-solid fa-key me-1"></i>Forgot Password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-4 rounded-pill">
                            <i class="fa-solid fa-sign-in-alt me-2"></i>Sign In
                        </button>

                        <hr class="bg-light opacity-25 my-4">

                        <!-- Registration Link -->
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 small">Don't have an account?</p>
                            <a href="{{ route('registration') }}" class="fw-bold">
                                <i class="fa-solid fa-user-plus me-1"></i>Register Now
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        function passwordicon(e) {
            const passwordInput = document.getElementById('password');
            if (e.id == 'showpassword') {
                $('#showpassword').css('display', 'none');
                $('#hidepassword').css('display', 'block');
                passwordInput.type = 'text';
            } else {
                $('#hidepassword').css('display', 'none');
                $('#showpassword').css('display', 'block');
                passwordInput.type = 'password';
            }
        }

    </script>
</body>
</html>
