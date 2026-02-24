<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 - Access Denied</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('assets/vendor/css/core.css') }}" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #fbbe1a;
            --brand-dark: #1f1f1f;
            --brand-muted: #6c757d;
            --bg-light: #f8f9fa;
        }

        body {
            margin: 0;
            height: 100vh;
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .error-card {
            background: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 550px;
            width: 90%;
            border-top: 6px solid var(--brand-primary);
        }

        .error-code {
            font-size: 110px;
            font-weight: 800;
            color: var(--brand-primary);
            line-height: 1;
        }

        .error-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--brand-dark);
            margin-top: 1rem;
        }

        .error-text {
            margin-top: 0.75rem;
            color: var(--brand-muted);
            line-height: 1.6;
        }

        .btn-brand {
            margin-top: 2rem;
            padding: 0.7rem 2rem;
            background: var(--brand-primary);
            color: #000;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-block;
        }

        .btn-brand:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .lock-icon {
            font-size: 42px;
            color: var(--brand-primary);
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="error-card">

    <div class="lock-icon">🔒</div>

    <div class="error-code">403</div>

    <div class="error-title">
        Access Forbidden
    </div>

    <div class="error-text">
        {{ $exception->getMessage() ?: 'You are not authorized to access this page.' }}
    </div>

    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                Back to Admin Dashboard
            </a>
        @else
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">
            Go to Login
        </a>
    @endauth

</div>

</body>
</html>
