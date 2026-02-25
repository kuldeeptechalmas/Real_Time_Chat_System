<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - Real Time Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(225deg, #0f2027 0%, #0b3d4a 40%, #021114 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .forgot-container {
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
            box-shadow: 0 12px 40px rgba(255, 100, 100, 0.2);
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
            padding: 12px 30px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00c9a7 0%, #01a58b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(1, 165, 139, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid #01a58b;
            color: #01a58b;
            transition: all 0.3s ease;
            padding: 12px 30px;
        }

        .btn-outline-primary:hover {
            background: #01a58b;
            color: white;
            transform: translateY(-2px);
        }

        .password-toggle {
            color: rgba(255, 255, 255, 0.6) !important;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .forgot-image {
            object-fit: cover;
            height: 100vh;
        }

        @media (max-width: 992px) {
            .forgot-image {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 30px 20px !important;
            }

            h2 {
                font-size: 1.75rem;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid forgot-container d-flex align-items-center">
        <div class="row w-100">
            <!-- Form Section -->
            <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center p-4">
                <div class="form-card p-4 p-lg-5 shadow rounded-4 w-100 text-light" style="max-width: 500px;">
                    <form method="post" action="{{ route('forgotpassword') }}">
                        @csrf
                        <h2 class="text-center mb-4 fw-bold">
                            <i class="fa-solid fa-key me-2"></i>Forgot Password
                        </h2>
                        <p class="text-center text-white-50 mb-4 small">Enter your credentials to reset your password</p>

                        <!-- Username / Email -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fa-solid fa-user me-2"></i>Username or Email
                            </label>
                            <input type="text" class="form-control bg-transparent text-white border-0 rounded-pill" 
                                   placeholder="Enter username or email" name="user_name_email" 
                                   value="{{ old('user_name_email') }}" 
                                   style="border-radius: 20px; padding: 12px 20px;">
                            @error('user_name_email')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">
                                <i class="fa-solid fa-lock me-2"></i>New Password
                            </label>
                            <input type="password" class="form-control bg-transparent text-white border-0 rounded-pill" 
                                   placeholder="Enter new password (min 8 chars)" id="password" name="password" 
                                   value="{{ old('password') }}" 
                                   style="border-radius: 20px; padding: 12px 50px 12px 20px;">
                            <span class="password-toggle position-absolute" style="top: 70%; right: 20px; transform: translateY(-50%); z-index: 10;">
                                <i class="fa-solid fa-eye" id="showpassword" onclick="passwordicon(this)"></i>
                                <i class="fa-solid fa-eye-slash d-none" id="hidepassword" onclick="passwordicon(this)"></i>
                            </span>
                            @error('password')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 position-relative">
                            <label class="form-label">
                                <i class="fa-solid fa-lock me-2"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control bg-transparent text-white border-0 rounded-pill" 
                                   placeholder="Re-enter password" id="confpassword" name="confpassword" 
                                   value="{{ old('confpassword') }}" 
                                   style="border-radius: 20px; padding: 12px 50px 12px 20px;">
                            <span class="password-toggle position-absolute" style="top: 70%; right: 20px; transform: translateY(-50%); z-index: 10;">
                                <i class="fa-solid fa-eye" id="confshowpassword" onclick="confpasswordicon(this)"></i>
                                <i class="fa-solid fa-eye-slash d-none" id="confhidepassword" onclick="confpasswordicon(this)"></i>
                            </span>
                            @error('confpassword')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between gap-3 mt-4">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill flex-fill">
                                <i class="fa-solid fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill flex-fill">
                                <i class="fa-solid fa-key me-2"></i>Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Image Section -->
            <div class="col-lg-6 d-none d-lg-block p-0">
                <img src="{{ asset('img/forgotpassword.png') }}" class="forgot-image w-100" alt="Forgot Password Image">
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
                $('#hidepassword').removeClass('d-none');
                passwordInput.type = 'text';
            } else {
                $('#hidepassword').addClass('d-none');
                $('#showpassword').css('display', 'block');
                passwordInput.type = 'password';
            }
        }

        function confpasswordicon(e) {
            const confpasswordInput = document.getElementById('confpassword');
            if (e.id == 'confshowpassword') {
                $('#confshowpassword').css('display', 'none');
                $('#confhidepassword').removeClass('d-none');
                confpasswordInput.type = 'text';
            } else {
                $('#confhidepassword').addClass('d-none');
                $('#confshowpassword').css('display', 'block');
                confpasswordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
