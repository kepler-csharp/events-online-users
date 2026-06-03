<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña — TicketNow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>
<body>
<div class="auth-container">
    <div class="auth-card">

        <div class="auth-logo">
            <i class="bi bi-ticket-perforated-fill"></i>
            Ticket<span>Now</span>
        </div>

        <h2 class="auth-title">Nueva contraseña</h2>
        <p class="auth-subtitle">Ingresa tu nueva contraseña para recuperar el acceso.</p>

        @if(session('error'))
        <div class="login-alert">
            <div class="login-alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="login-alert-content"><span>{{ session('error') }}</span></div>
            <button type="button" class="login-alert-close" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="login-alert">
            <div class="login-alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="login-alert-content">
                @foreach($errors->all() as $error)
                    <span class="d-block">{{ $error }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('password.reset.send') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password"
                       name="newPassword"
                       class="form-control custom-input"
                       placeholder="Mínimo 8 caracteres"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password"
                       name="newPassword_confirmation"
                       class="form-control custom-input"
                       placeholder="Repite la contraseña"
                       required>
            </div>

            <button type="submit" class="btn custom-btn-primary w-100 mt-2">
                <i class="bi bi-lock"></i> Restablecer contraseña
            </button>
        </form>

    </div>
</div>
</body>
</html>