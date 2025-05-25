<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Restablir Contrasenya</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!--===============================================================================================-->
    <style>
        .wrap-input100 {
            position: relative;
        }
        
        .btn-show-pass {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        
        .btn-show-pass i {
            font-size: 18px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('images/bg-01.jpg') }}');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form action="{{ route('password.update') }}" method="POST" class="login100-form validate-form flex-sb flex-w">
                    @csrf
                    
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="login100-form-title p-b-20">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 150px;">
                    </div>

                    <span class="login100-form-title p-b-53">
                        Restablir Contrasenya
                    </span>

                    <div class="p-t-31 p-b-9 w-100">
                        <span class="txt1">
                            Email
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input w-100" data-validate="Es requereix un email vàlid">
                        <input class="input100" type="email" name="email" value="{{ $email ?? old('email') }}" required>
                        <span class="focus-input100"></span>
                    </div>
                    
                    @error('email')
                        <div class="text-danger w-100 p-t-10">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror

                    <div class="p-t-13 p-b-9 w-100">
                        <span class="txt1">
                            Nova Contrasenya
                        </span>
                    </div>
                    
                    <div class="wrap-input100 validate-input w-100" data-validate="Es requereix una contrasenya">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                        <span class="btn-show-pass">
                            <i class="fa fa-eye" id="toggle-password"></i>
                        </span>
                    </div>
                    
                    @error('password')
                        <div class="text-danger w-100 p-t-10">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror

                    <div class="p-t-13 p-b-9 w-100">
                        <span class="txt1">
                            Confirmar Contrasenya
                        </span>
                    </div>
                    
                    <div class="wrap-input100 validate-input w-100" data-validate="Cal confirmar la contrasenya">
                        <input class="input100" type="password" name="password_confirmation" required>
                        <span class="focus-input100"></span>
                        <span class="btn-show-pass">
                            <i class="fa fa-eye" id="toggle-password-confirm"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn m-t-17 w-100">
                        <button class="login100-form-btn">
                            Restablir Contrasenya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            togglePasswordVisibility('password', this);
        });
        
        document.getElementById('toggle-password-confirm').addEventListener('click', function() {
            togglePasswordVisibility('password_confirmation', this);
        });
        
        function togglePasswordVisibility(inputName, icon) {
            const passwordInput = document.querySelector(`input[name="${inputName}"]`);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>