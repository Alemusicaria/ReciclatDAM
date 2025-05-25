<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Recuperar Contrasenya</title>
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
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('images/bg-01.jpg') }}');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form action="{{ route('password.email') }}" method="POST" class="login100-form validate-form flex-sb flex-w">
                    @csrf
                    <div class="login100-form-title p-b-20">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 150px;">
                    </div>

                    <span class="login100-form-title p-b-53">
                        Recuperar Contrasenya
                    </span>

                    <div class="p-b-9 text-center w-100">
                        <p class="txt1">
                            Introdueix el teu correu electrònic i t'enviarem un enllaç per restablir la contrasenya.
                        </p>
                    </div>

                    <div class="p-t-31 p-b-9 w-100">
                        <span class="txt1">
                            Email
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input w-100" data-validate="Es requereix un email vàlid">
                        <input class="input100" type="email" name="email" value="{{ old('email') }}" required>
                        <span class="focus-input100"></span>
                    </div>
                    
                    @error('email')
                        <div class="text-danger w-100 p-t-10">
                            <small>{{ $message }}</small>
                        </div>
                    @enderror

                    <div class="container-login100-form-btn m-t-17 w-100">
                        <button class="login100-form-btn">
                            Enviar enllaç de recuperació
                        </button>
                    </div>

                    <div class="w-full text-center p-t-55">
                        <a href="{{ route('login') }}" class="txt2 bo1">
                            Tornar a l'inici de sessió
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>