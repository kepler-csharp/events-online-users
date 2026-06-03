<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil — TicketNow</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/profile.css'])
</head>

<body>

<!-- OVERLAY -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- MOBILE BTN -->
<button class="mobile-menu-btn" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

<!-- SIDEBAR -->
<aside class="sidebar">

    <a href="{{ url('/') }}" class="sidebar-logo">
        <i class="bi bi-ticket-perforated-fill"></i>
        Ticket<span>Now</span>
    </a>

    <div class="nav-label">Menú</div>

    <a href="{{ url('/dashboard') }}" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
    </a>

    <a href="#" class="nav-item active">
        <i class="bi bi-person"></i> Mi Perfil
    </a>

    <div class="sidebar-spacer"></div>

    <div class="sidebar-user">
        <div class="s-avatar">
            {{ strtoupper(substr(session('user.name','U'),0,1)) }}
        </div>
        <div>
            <div class="fw-bold">{{ session('user.name','Usuario') }}</div>
            <small>Cliente</small>
        </div>
    </div>

</aside>

<!-- MAIN -->
<main class="main">
       @if($errors->any())
        <div class="alert alert-error" id="alert-validation">
            <div class="alert-icon"><i class="bi bi-x-circle-fill"></i></div>
            <div class="alert-body">
                <div class="alert-title">¡Error de validación!</div>
                <div class="alert-msg">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            </div>
            <button class="alert-close" onclick="closeAlert('alert-validation')"><i class="bi bi-x"></i></button>
        </div>
        @endif

        @foreach(['success', 'error'] as $type)
            @if(session($type))
            <div class="alert alert-{{ $type }}" id="alert-{{ $type }}">
                <div class="alert-icon">
                    <i class="bi bi-{{ $type === 'success' ? 'check' : 'x' }}-circle-fill"></i>
                </div>
                <div class="alert-body">
                    <div class="alert-title">{{ $type === 'success' ? '¡Listo!' : '¡Ocurrió un error!' }}</div>
                    <div class="alert-msg">{{ session($type) }}</div>
                </div>
                <button class="alert-close" onclick="closeAlert('alert-{{ $type }}')"><i class="bi bi-x"></i></button>
            </div>
            @endif
        @endforeach

    <!-- PROFILE HEADER -->
    <section class="profile-card">

        <div class="profile-avatar">
            @if(session('user.photo'))
                <img src="{{ session('user.photo') }}" alt="avatar">
            @else
                {{ strtoupper(substr(session('user.name', 'U'), 0, 1)) }}
            @endif
            <button class="avatar-btn" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
                <i class="bi bi-camera"></i>
            </button>
        </div>

        <div>
            <h2 class="mb-1"><b>{{ session('user.name','Usuario') }}</b></h2>
            <p class="mb-2">{{ session('user.email','') }}</p>

            <span class="badge bg-warning text-dark">Cliente</span>
            <span class="badge bg-secondary">Activo</span>
        </div>

        <div class="d-flex gap-2">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="action danger">
                    <i class="bi bi-trash"></i> Cerrar Session
                </button>
            </form>
        </div>

    </section>

    <!-- GRID -->
    <section class="grid">

        <div class="card">
            <h5 class="card-title">
                <i class="bi bi-person-circle text-warning"></i> Información
            </h5>

            <div class="info">
                <div class="row">
                    <span>Nombre</span>
                    <strong>{{ session('user.name') }}</strong>
                </div>

                <div class="row">
                    <span>Email</span>
                    <strong>{{ session('user.email') }}</strong>
                </div>

                <div class="row">
                    <span>Rol</span>
                    <strong>{{ session('user.role') }}</strong>
                </div>

                <div class="row">
                    <span>ID</span>
                    <strong class="text-truncate">{{ session('user.id') }}</strong>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-title">
                <i class="bi bi-shield-lock text-warning"></i> Seguridad
            </h5>

            <button class="action" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="bi bi-key"></i> Cambiar contraseña
            </button>

            <a class="action mt-3 text-decoration-none" href="{{ route('password.forgot') }}">
                <i class="bi bi-key"></i> Recuperar contraseña
            </a>
           
        </div>

    </section>

</main>

<!-- MODAL -->
<div class="modal fade" id="editProfileModal">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content custom-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-person-gear text-orange"></i> Editar perfil
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('update.image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <label class="p-2" for="image">
                            Por favor seleccione una imagen <span class="text-danger">*</span>
                        </label>
                        <input type="file" id="image" class="form-control" name="image" required>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn custom-btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>



        </div>

    </div>
</div>

{{-- Modal change password --}}
<div class="modal fade" id="changePasswordModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">

            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-key text-orange"></i> Cambiar contraseña
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="password"
                           name="currentPassword"
                           class="form-control custom-input mb-3"
                           placeholder="********"
                           value="{{ session('user.password') }}"
                           disabled>

                    <input type="password"
                           name="newPassword"
                           class="form-control custom-input mb-3"
                           placeholder="Nueva contraseña"
                           required>

                    <input type="password"
                           name="newPassword_confirmation"
                           class="form-control custom-input mb-3"
                           placeholder="Confirmar nueva contraseña"
                           required>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn custom-btn-primary">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
}

function closeAlert(id) {
    const el = document.getElementById(id);
    el.classList.add('hiding');
    setTimeout(() => el.remove(), 300);
}

// Auto-cierre después de 4 segundos
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.classList.add('hiding');
        setTimeout(() => alert.remove(), 300);
    }, 4000);
});
</script>

</body>
</html>