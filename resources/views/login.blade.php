<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{--   <link href="https://cdn.jsdelivr.net/gh/kepler-csharp/events-online-users@main/public/css/login.css" rel="stylesheet"> --}}
    @vite(['resources/css/login.css'])
</head>

<body>
    <!-- DECORATION BACKGROUND -->
    <div class="circle-top"></div>
    <div class="circle-bottom"></div>
    <!-- END DECORATION BACKGROUND -->
    <!-- LOGIN -->
    <section class="login-card">
        <div class="logo">
            <i class="bi bi-ticket-perforated-fill"></i>
            Ticket<span>Now</span>
        </div>
        <h1 class="title">
            Bienvenido <span>de nuevo</span>
        </h1>
        <p class="subtitle">
            Inicia sesión para comprar entradas, gestionar tus eventos
            y disfrutar de la experiencia TicketNow.
        </p>
        @if ($errors->has('error'))
            <div class="login-alert">
                <div class="login-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="login-alert-content">
                    <span>Error de autenticación</span>
                    <p>{{ $errors->first('error') }}</p>
                </div>
                <button type="button" class="login-alert-close" onclick="this.parentElement.remove()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        @endif
        <!-- LOGIN FORM -->
        <form action="{{ route('login.submit') }}" method="POST">
            {{-- Email input --}}
            <div class="input-group">
                <label class="input-label">Correo electrónico</label>
                <div class="input-box">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" placeholder="ejemplo@correo.com">
                </div>
                @error('email')
                    <small class="input-error">
                        {{ $message }}
                    </small>
                @enderror
            </div>
            {{-- Password input --}}
            <div class="input-group">
                <label class="input-label">Contraseña</label>
                <div class="input-box">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="********">
                </div>
                @error('password')
                    <small class="input-error">
                        {{ $message }}
                    </small>
                @enderror
            </div>
            {{-- Options to forget password --}}
            <div class="options">
                <label class="remember">
                    <input type="checkbox">
                    Recuérdame
                </label>
                <a href="{{ route('password.forgot') }}">¿Olvidaste tu contraseña?</a>
            </div>
            {{-- Login route --}}
            <button class="login-btn" type="submit">
                Iniciar sesión
            </button>
            
            {{-- Go back landing --}}
            <a href="{{ route('welcome') }}" class="back-btn">
                Volver
            </a>
        </form>
        {{-- Create Account --}}
        <div class="register">
            ¿No tienes una cuenta?
            <a href="{{ route('register') }}">Crear cuenta</a>
        </div>
    </section>
</body>

</html>
