<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Terblokir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f44336, #e57373);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .blocked-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 450px;
            width: 100%;
        }
        .blocked-icon {
            font-size: 80px;
            color: #f44336;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }
        .btn-logout {
            background: #f44336;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="blocked-card">
        <div class="blocked-icon">🚫</div>
        <h1>Akun {{ Illuminate\Support\Facades\Auth::user()->full_name }} Terblokir</h1>
        <p>
            Akun ini telah diblokir karena melanggar aturan sistem.<br>
            Silakan hubungi <strong>Admin</strong> untuk mengaktifkan kembali akun Anda.
        </p>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="btn btn-logout">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>
</html>
