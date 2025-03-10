<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
            font-family: 'Instrument Sans', sans-serif;
        }
        .register-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-container h1 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #333;
            text-align: center;
        }
        .register-container input,
        .register-container textarea,
        .register-container button {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .register-container input:focus,
        .register-container textarea:focus,
        .register-container button:focus {
            outline: none;
            border-color: #f53003;
        }
        .register-container button {
            background-color: #f53003;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-container button:hover {
            background-color: #d42a02;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="cognoms" placeholder="Cognoms" required>
            <input type="date" name="data_naieixement" placeholder="Data Naixement">
            <input type="text" name="telefon" placeholder="Telefon">
            <textarea name="ubicacio" placeholder="Ubicacio"></textarea>
            <input type="number" name="punts_totals" placeholder="Punts Totals" value="0" required>
            <input type="number" name="punts_actuals" placeholder="Punts Actuals" value="0" required>
            <input type="number" name="punts_gastats" placeholder="Punts Gastats" value="0" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>