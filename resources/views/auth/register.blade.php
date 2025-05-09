<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Register</title>
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
        
        .required-field {
            color: red;
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('images/bg-01.jpg') }}');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form action="{{ route('register') }}" method="POST" class="login100-form validate-form flex-sb flex-w"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="login100-form-title p-b-20">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 150px;">
                    </div>

                    <span class="login100-form-title p-b-53">
                        Registra't
                    </span>

                    <a href="{{ url('login/facebook') }}" class="btn-face m-b-20">
                        <i class="fa fa-facebook-official"></i>
                        Facebook
                    </a>

                    <a href="{{ url('login/google') }}" class="btn-google m-b-20">
                        <img src="{{ asset('images/icons/icon-google.png') }}" alt="GOOGLE">
                        Google
                    </a>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1">
                            Nom <span class="required-field">*</span>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="El nom és obligatori">
                        <input class="input100" type="text" name="nom" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Cognoms <span class="required-field">*</span>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Els cognoms són obligatoris">
                        <input class="input100" type="text" name="cognoms" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Data Naixement
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="date" name="data_naixement">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Telefon
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="telefon">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Ubicacio
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <textarea class="input100" name="ubicacio"></textarea>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Foto de Perfil
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="file" name="foto_perfil">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Email <span class="required-field">*</span>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="L'email és obligatori">
                        <input class="input100" type="email" name="email" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Contrasenya <span class="required-field">*</span>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="La contrasenya és obligatòria">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                        <span class="btn-show-pass">
                            <i class="fa fa-eye" id="toggle-password"></i>
                        </span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">
                            Confirma Contrasenya <span class="required-field">*</span>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="La confirmació és obligatòria">
                        <input class="input100" type="password" name="password_confirmation" required
                            autocomplete="new-password">
                        <span class="focus-input100"></span>
                        <span class="btn-show-pass">
                            <i class="fa fa-eye" id="toggle-password-confirm"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn">
                            Registrar
                        </button>
                    </div>

                    <div class="w-full text-center p-t-55">
                        <span class="txt2">
                            Ja tens un compte?
                        </span>

                        <a href="{{ route('login') }}" class="txt2 bo1">
                            Inicia sessió
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

    <script>
        // Toggle para el campo de contraseña
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordInput = document.querySelector('input[name="password"]');
            const icon = this;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Toggle para el campo de confirmación de contraseña
        document.getElementById('toggle-password-confirm').addEventListener('click', function () {
            const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
            const icon = this;
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        (function ($) {
            "use strict";

            var input = $('.validate-input .input100');

            $('.validate-form').on('submit', function () {
                var check = true;

                for (var i = 0; i < input.length; i++) {
                    if (validate(input[i]) == false) {
                        showValidate(input[i]);
                        check = false;
                    }
                }

                return check;
            });

            $('.validate-form .input100').each(function () {
                $(this).focus(function () {
                    hideValidate(this);
                });
            });

            function validate(input) {
                if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                    if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                        return false;
                    }
                } else if ($(input).attr('name') == 'password_confirmation') {
                    var passwordVal = $('input[name="password"]').val().trim();
                    if ($(input).val().trim() !== passwordVal) {
                        return false;
                    }
                } else if ($(input).attr('required')) {
                    if ($(input).val().trim() == '') {
                        return false;
                    }
                }
                return true;
            }

            function showValidate(input) {
                var thisAlert = $(input).parent();
                $(thisAlert).addClass('alert-validate');
            }

            function hideValidate(input) {
                var thisAlert = $(input).parent();
                $(thisAlert).removeClass('alert-validate');
            }

        })(jQuery);
    </script>

</body>

</html>