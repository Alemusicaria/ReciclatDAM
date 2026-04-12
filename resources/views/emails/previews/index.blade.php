<!doctype html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Previsualitzacions de correu</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            margin: 0;
            background: #f5f7fb;
            color: #0f172a;
        }
        .wrap {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
            padding: 28px;
        }
        h1 {
            margin-top: 0;
            font-size: 26px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }
        a.card {
            display: block;
            text-decoration: none;
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 14px;
            color: #0f172a;
            font-weight: 600;
            transition: transform .15s ease;
        }
        a.card:hover {
            transform: translateY(-2px);
        }
        .hint {
            color: #475569;
            font-size: 14px;
            margin-top: 6px;
        }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Previsualitzacions de correus</h1>
    <p class="hint">Aquesta pantalla es per entorn local. Clica qualsevol targeta per veure el correu renderitzat.</p>

    <div class="grid">
        @foreach($templates as $key => $label)
            <a class="card" href="{{ route('dev.emails.show', ['template' => $key]) }}">{{ $label }}</a>
        @endforeach
    </div>
</div>
</body>
</html>
