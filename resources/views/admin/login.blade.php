<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dolza Properties</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .login-page {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(124,58,237,0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(6,182,212,0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(139,92,246,0.1) 0%, transparent 50%),
                var(--bg-primary);
        }

        .login-box {
            background: linear-gradient(160deg, rgba(15,15,26,0.98), rgba(10,10,15,0.99));
            border: 1px solid var(--border-light);
            padding: 48px 40px 40px;
            border-radius: 16px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
            animation: fadeInUp 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .login-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--accent), var(--cyan));
        }

        .login-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--gold), #d9a020);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.4rem;
            color: #0a0a0f;
            box-shadow: 0 0 30px var(--gold-glow);
        }

        .login-box h1 {
            text-align: center;
            font-size: 1.35rem;
            margin-bottom: 4px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 30%, var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.84rem;
            margin-bottom: 32px;
        }

        .login-error {
            background: rgba(239,68,68,0.1);
            color: var(--danger);
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.84rem;
            border: 1px solid rgba(239,68,68,0.2);
        }

        .login-box .admin-btn {
            width: 100%;
            justify-content: center;
            padding: 12px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .login-box { margin: 20px; padding: 36px 24px 28px; }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-box">
            <div class="login-icon"><i class="fas fa-building"></i></div>
            <h1>Admin Login</h1>
            <p class="login-subtitle">Dolza Property Management System</p>

            @if($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="admin-form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="admin@dolza.com" value="{{ old('email') }}" required>
                </div>
                <div class="admin-form-group" style="margin-bottom:28px;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary">Sign In <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
</body>
</html>
