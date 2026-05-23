<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite('resources/css/login.css')
</head>

<body>

    <!-- Decorations -->
    <div class="circle-top"></div>
    <div class="circle-bottom"></div>

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
    <!-- REGISTER -->
    <div class="login-card">

        <div class="logo">
            <i class="bi bi-ticket-perforated-fill"></i>
            Ticket<span>Now</span>
        </div>

        <h1 class="title">
            Crear <span>Cuenta</span>
        </h1>

        <p class="subtitle">
            Únete a TicketNow para comprar entradas, gestionar tus eventos
            y disfrutar de experiencias inolvidables.
        </p>

        <form method="POST" action="{{ route('register') }}">

            @csrf

            <!-- NOMBRE -->
            <div class="input-group">
                <label class="input-label">Nombre completo</label>

                <div class="input-box">
                    <i class="bi bi-person"></i>

                    <input type="text" name="fullName" placeholder="Juan Pérez">
                </div>
                @error('fullName')
                    <small class="input-error">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- CORREO -->
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

            <!-- CONTRASEÑA -->
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

            <!-- CONFIRMAR CONTRASEÑA -->
            <div class="input-group">
                <label class="input-label">Confirmar contraseña</label>

                <div class="input-box">
                    <i class="bi bi-shield-lock"></i>

                    <input type="password" name="password_confirmation" placeholder="********" required>
                </div>
            </div>

            <button class="login-btn" type="submit">
                Crear cuenta
            </button>

        </form>

        <div class="register">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>

    </div>

</body>

</html>
