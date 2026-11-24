<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0e14">
    <title>{{ __('Login') }} · {{ config('app.name', 'Win2x') }}</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #0b0e14;
            --surface: #141923;
            --border: #262f3f;
            --text: #e8ecf2;
            --muted: #8a94a6;
            --primary: #e5383b;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at 50% -10%, rgba(229, 56, 59, .22), transparent 55%),
                var(--bg);
            color: var(--text);
            font: 14px/1.5 Inter, system-ui, -apple-system, sans-serif;
        }
        .container { width: min(460px, 100%); }
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .45);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 22px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -.02em;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(120deg, rgba(229, 56, 59, .18), transparent);
        }
        .card-body { padding: 22px; }
        label, .col-form-label { color: var(--muted); font-size: 12px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: #0f141d;
            color: var(--text);
            outline: none;
        }
        input:focus { border-color: var(--primary); }
        .btn {
            display: inline-block;
            border: 0;
            border-radius: 9px;
            padding: 10px 18px;
            font-weight: 700;
            cursor: pointer;
            background: var(--primary);
            color: #fff;
        }
        .btn-link {
            background: none;
            color: var(--muted);
            padding: 6px 0;
            font-size: 12px;
        }
        .invalid-feedback, .alert { color: #f87171; font-size: 12px; }
        .form-group.row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
        .form-check { margin: 12px 0; color: var(--muted); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            @yield('content')
        </div>
    </div>
</body>
</html>
