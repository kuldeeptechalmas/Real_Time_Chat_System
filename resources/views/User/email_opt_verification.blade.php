<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email-Verification</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="row w-100">
        <div class="col-7">
            <img style="width: 77%;" src="{{ asset('img/eamilverification.png') }}" alt="">
        </div>
        <div class="col-5" style="padding: 94px 110px 0px 70px;">
            <div class="card" style="padding: 27px;border-radius: 46px;">
                <h4 style="text-align: center;padding: 15px;">E-Mail Varification</h4>
                <h7>
                    We have mailed you a 6-digit code. please check you
                    email & enter the<br>code
                    here to complete the verification
                </h7>
                <h5 style="text-align: center;padding: 10px;">Enter Code</h5>
                <form action="{{ route('email_verification') }}" method="post">
                    @csrf
                    <div style="display: flex;justify-content: center;">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input1">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input2">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input3">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input4">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input5">
                        <input type="text" class="form-control mx-1" maxlength="1" style="width: 13%;" name="input6">
                    </div>
                    @error('otperror')
                    <div class="text-danger my-2 " style="margin-left: 12px;">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary my-3 mt-4 w-100">Verify Email</button>
                </form>
                <div>
                    Didn`t receive the OTP ? <a href="{{ route('email_generate') }}">Resend</a>
                </div>
                {{-- <div class="d-flex justify-content-center">
                    <input type="text" class="m-2 text-center form-control rounded" id="otp-1" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="m-2 text-center form-control rounded" id="otp-2" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="m-2 text-center form-control rounded" id="otp-3" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" class="m-2 text-center form-control rounded" id="otp-4" maxlength="1" inputmode="numeric" pattern="[0-9]*" /> --}}
                <!-- Add more inputs for longer OTPs -->
                {{-- </div> --}}

            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });

    </script>
</body>
</html>
