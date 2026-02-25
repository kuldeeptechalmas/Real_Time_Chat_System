<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration - Real Time Chat</title>
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
            background: linear-gradient(225deg, #0f2027 0%, #0b3d4a 40%, #021114 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .registration-container {
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
            box-shadow: 0 12px 40px rgba(0, 255, 200, 0.2);
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

        .form-check-input:checked {
            background-color: #01a58b;
            border-color: #01a58b;
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.9);
            margin-left: 0.5rem;
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

        .registration-image {
            object-fit: contain;
            height: 100vh;
            padding: 20px;
        }

        @media (max-width: 992px) {
            .registration-image {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .form-card {
                padding: 25px 20px !important;
            }

            h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid registration-container">
        <div class="row g-0 min-vh-100">
            <!-- Left form column -->
            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center p-3 p-lg-5">
                <div class="form-card text-light w-100" style="max-width: 500px; border-radius: 25px; padding: 40px 50px;">
                    <h2 class="text-center mb-4 fw-bold">
                        <i class="fa-solid fa-user-plus me-2"></i>Registration
                    </h2>

                    <form method="post" action="{{ route('registration') }}">
                        @csrf

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fa-solid fa-user me-2"></i>User Name
                            </label>
                            <input type="text" class="form-control rounded-pill bg-transparent text-white border-0" 
                                   placeholder="Enter username" id="username" name="username" 
                                   value="{{ old('username') }}" 
                                   style="border-radius: 20px; padding: 12px 20px;">
                            @error('username')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="fa-solid fa-phone me-2"></i>Phone No.
                            </label>
                            <input type="text" class="form-control rounded-pill bg-transparent text-white border-0" 
                                   placeholder="Enter 10-digit phone number" id="phone" name="phone" 
                                   value="{{ old('phone') }}" 
                                   style="border-radius: 20px; padding: 12px 20px;">
                            @error('phone')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <i class="fa-solid fa-venus-mars me-2"></i>Gender
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderMen" value="Men" {{ old('gender')=='Men'?'checked':'' }}>
                                    <label class="form-check-label" for="genderMen">
                                        <i class="fa-solid fa-mars me-1"></i>Men
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderWomen" value="Women" {{ old('gender')=='Women'?'checked':'' }}>
                                    <label class="form-check-label" for="genderWomen">
                                        <i class="fa-solid fa-venus me-1"></i>Women
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fa-solid fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" class="form-control rounded-pill bg-transparent text-white border-0" 
                                   placeholder="Enter email (Gmail/Yahoo/Yopmail)" id="email" name="email" 
                                   value="{{ old('email') }}" 
                                   style="border-radius: 20px; padding: 12px 20px;">
                            @error('email')
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
                            <input type="password" class="form-control rounded-pill bg-transparent text-white border-0" 
                                   placeholder="Enter password (min 8 chars)" id="password" name="password" 
                                   value="{{ old('password') }}" 
                                   style="border-radius: 20px; padding: 12px 50px 12px 20px;">
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

                        <!-- Confirm Password -->
                        <div class="mb-3 position-relative">
                            <label for="cpassword" class="form-label">
                                <i class="fa-solid fa-lock me-2"></i>Confirm Password
                            </label>
                            <input type="password" class="form-control rounded-pill bg-transparent text-white border-0" 
                                   placeholder="Re-enter password" id="cpassword" name="cpassword" 
                                   value="{{ old('cpassword') }}" 
                                   style="border-radius: 20px; padding: 12px 50px 12px 20px;">
                            <div class="password-toggle" style="position: absolute; top: 70%; right: 20px; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                                <i class="fa-solid fa-eye" id="showcpassword" onclick="cpasswordicon(this)"></i>
                                <i class="fa-solid fa-eye-slash" id="hidecpassword" onclick="cpasswordicon(this)" style="display:none;"></i>
                            </div>
                            @error('cpassword')
                            <div class="text-danger mt-2 small">
                                <i class="fa-solid fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Login link -->
                        <div class="text-center mb-4">
                            <p class="mb-0 small">Already have an account? 
                                <a href="{{ route('login') }}" class="fw-bold">
                                    <i class="fa-solid fa-sign-in-alt me-1"></i>Login
                                </a>
                            </p>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">
                            <i class="fa-solid fa-user-plus me-2"></i>Register
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right image column -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center p-0">
                <img src="{{ asset('img/registration.png') }}" alt="Registration Image" class="registration-image">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function cpasswordicon(e) {
            const cpasswordInput = document.getElementById('cpassword');
            if (e.id == 'showcpassword') {
                $('#showcpassword').css('display', 'none');
                $('#hidecpassword').css('display', 'block');
                cpasswordInput.type = 'text';
            } else {
                $('#hidecpassword').css('display', 'none');
                $('#showcpassword').css('display', 'block');
                cpasswordInput.type = 'password';
            }
        }

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
