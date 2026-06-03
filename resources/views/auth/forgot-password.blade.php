<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña — TicketNow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/login.css'])
</head>
<body>

<div class="circle-top"></div>
<div class="circle-bottom"></div>

<div class="login-card">

    <div class="logo">
        <i class="bi bi-ticket-perforated-fill" style="color:#ff7f3d"></i>
        Ticket<span>Now</span>
    </div>

    <h1 class="title">Recuperar <span>contraseña</span></h1>
    <p class="subtitle">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

    @if(session('success'))
    <div class="login-alert" style="background:rgba(29,158,117,.08); border-color:rgba(29,158,117,.25);">
        <div class="login-alert-icon" style="background:rgba(29,158,117,.18); color:#1D9E75;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="login-alert-content">
            <span style="color:#5DCAA5;">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="login-alert">
        <div class="login-alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="login-alert-content">
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" class="login-alert-close" onclick="this.parentElement.remove()">
            <i class="bi bi-x"></i>
        </button>
    </div>
    @endif

    <form action="{{ route('password.forgot.send') }}" method="POST">
        @csrf

        <div class="input-group">
            <label class="input-label">Correo electrónico</label>
            <div class="input-box">
                <i class="bi bi-envelope"></i>
                <input type="email"
                       name="email"
                       placeholder="tucorreo@ejemplo.com"
                       value="{{ old('email') }}"
                       required>
            </div>
        </div>

        <button type="submit" class="login-btn">
            <i class="bi bi-send"></i> Enviar enlace
        </button>
    </form>

    <p class="register">
        <a href="{{ route('login') }}">← Volver al login</a>
    </p>

</div>

</body>
</html>