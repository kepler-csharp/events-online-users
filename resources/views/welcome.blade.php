<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TicketNow') }} — Tu plataforma de eventos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite('resources/css/welcome.css')
</head>

<body>
    @if ($errors->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
            style="position:fixed;top:1rem;right:1rem;z-index:1050">
            {{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @elseif($errors->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="position:fixed;top:1rem;right:1rem;z-index:1050">
            {{ $errors->first('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
{{-- NAV --}}
<nav class="navbar navbar-expand-md fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-ticket-perforated-fill me-1"></i>
            <span>Ticket</span>Now
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto gap-md-2">
                <li class="nav-item"><a class="nav-link" href="#events">Eventos</a></li>
                <li class="nav-item"><a class="nav-link" href="#tickets">Entradas</a></li>
                <li class="nav-item"><a class="nav-link" href="#how">¿Cómo funciona?</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
            </ul>
            <div class="d-flex gap-4 mt-2 mt-md-0">
                @if (Route::has('login'))
                    @if (session('user') && session('auth_token'))
                        <!-- <a href="{ url('/dashboard') }" class="btn-nav">Mi cuenta</a> -->
                        <a href="{{ route('dashboard') }}" class="text-white mt-2">Perfil de
                            <strong>{{ session('user.name') }}</strong></a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout"><i class="bi bi-power"></i></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost text-decoration-none"
                            style="color:var(--gray);border:1px solid rgba(221,220,219,.3);border-radius:6px;padding:.45rem 1rem;font-size:.875rem;">Iniciar
                            sesión</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section id="hero">
    <div class="container" style="position:relative;z-index:1">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-tag"><i class="bi bi-lightning-fill me-1"></i> La forma más fácil de conseguir tu
                    entrada</div>
                <h1>Vive el evento que <span>siempre quisiste</span></h1>
                <p class="hero-sub">
                    Conciertos, festivales, teatro, deportes y más. Encuentra, compra y disfruta tu entrada en
                    minutos. Sin complicaciones.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#events" class="btn-primary-custom">Ver eventos <i
                            class="bi bi-arrow-right ms-1"></i></a>
                    <a href="#how" class="btn-ghost">¿Cómo funciona?</a>
                </div>
                <div class="hero-stats row g-0">
                    <div class="col-4 text-center">
                        <div class="hero-stat-val">+500</div>
                        <div class="hero-stat-label">Eventos activos</div>
                    </div>
                    <div class="col-4 text-center"
                        style="border-left:1px solid rgba(221,220,219,.15);border-right:1px solid rgba(221,220,219,.15)">
                        <div class="hero-stat-val">98%</div>
                        <div class="hero-stat-label">Clientes satisfechos</div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="hero-stat-val">24/7</div>
                        <div class="hero-stat-label">Soporte disponible</div>
                    </div>
                </div>
            </div>

            {{-- Visual card --}}
            <div class="col-lg-6">
                <div class="hero-card">
                    <div
                        style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:var(--gray);text-transform:uppercase;margin-bottom:1rem;">
                        <i class="bi bi-fire me-1" style="color:var(--orange)"></i> Evento destacado
                    </div>
                    <div class="hero-card-event">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start">
                            <div>
                                <div class="hero-card-event-name">Festival Electrónico 2025</div>
                                <div class="hero-card-event-date"><i class="bi bi-calendar3 me-1"></i>15 Ago ·
                                    Medellín</div>
                            </div>
                            <span style="font-size:1.5rem">🎵</span>
                        </div>
                        <span class="ticket-badge">Pocas entradas</span>
                    </div>
                    <div class="ticket-row">
                        <div>
                            <div style="font-weight:600;font-size:.875rem">General</div>
                            <div class="ticket-avail"><i class="bi bi-people-fill me-1"></i>142 disponibles</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="ticket-price">$120.000</span>
                            <button class="btn-ticket-sm">Comprar</button>
                        </div>
                    </div>
                    <div class="ticket-row">
                        <div>
                            <div style="font-weight:600;font-size:.875rem">VIP</div>
                            <div class="ticket-avail"><i class="bi bi-star-fill me-1"
                                    style="color:var(--orange)"></i>28 disponibles</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="ticket-price">$280.000</span>
                            <button class="btn-ticket-sm">Comprar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- SEARCH --}}
<div id="search">
    <div class="container">
        <div class="search-box">
            <h5><i class="bi bi-search me-2" style="color:var(--orange)"></i>Encuentra tu evento</h5>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold mb-1">¿Qué estás buscando?</label>
                    <input type="text" class="form-control-custom" placeholder="Nombre del evento o artista">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-1">Ciudad</label>
                    <select class="form-select-custom">
                        <option>Todas las ciudades</option>
                        <option>Medellín</option>
                        <option>Bogotá</option>
                        <option>Cali</option>
                        <option>Barranquilla</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold mb-1">Categoría</label>
                    <select class="form-select-custom">
                        <option>Todas las categorías</option>
                        <option>Concierto / Música</option>
                        <option>Teatro / Show</option>
                        <option>Deportes</option>
                        <option>Conferencia</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn-search"><i class="bi bi-search me-1"></i> Buscar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- EVENTS --}}
<section id="events">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
            <div>
                <div class="section-tag">Próximos Eventos</div>
                <h2 class="section-title">Eventos Disponibles</h2>
            </div>
            <a href="#" style="color:var(--orange);font-size:.875rem;font-weight:600;text-decoration:none">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>


        <div class="row g-4">
            @foreach ($events as $e)
            <div class="col-sm-6 col-lg-3">
                <div class="event-card">
                    <div class="event-image-container">
                        <img src="{{ $e['posterUrl'] }}" alt="Evento" class="event-img">

                        <span class="event-status active">
                            Activo
                        </span>
                    </div>
                    <div class="event-body">
                        <div class="event-name">{{ $e['name'] }}</div>
                        <div class="event-meta">
                            <i class="bi bi-calendar3"></i>{{ $e['createdAt'] }}<br>
                            <i class="bi bi-geo-alt-fill"></i>{{ $e['venueName'] }}
                        </div>
                        <div class="event-prices">
                            <span class="price-pill pill-general">General {{-- {{ $e['general'] }} --}}</span>
                            <span class="price-pill pill-vip"><i class="bi bi-star-fill me-1"></i>VIP
                                {{-- {{ $e['vip'] }} --}}</span> 
                        </div>
                        <a href="#" 
                            class="btn-buy"
                            data-bs-toggle="modal"
                            data-bs-target="#eventModal{{ $e['id'] }}">
                            Ver evento →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TICKETS --}}
<section id="tickets">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">Tipos de Entrada</div>
            <h2 class="section-title">Elige Tu Experiencia</h2>
            <p class="text-muted mt-3" style="max-width:460px;margin:auto">
                Cada evento ofrece dos modalidades. Tú decides cómo quieres vivir el momento.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- General --}}
            <div class="col-md-5">
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="ticket-type">Acceso</div>
                        <div class="ticket-name">General</div>
                        <div class="ticket-desc">La experiencia completa del evento</div>
                        <div class="ticket-deco">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                    </div>
                    <div class="ticket-body">
                        <div class="ticket-price-big">
                            <sup>$</sup>Desde 80K <span class="per">/ persona</span>
                        </div>
                        <ul class="ticket-feature-list">
                            <li><i class="bi bi-check-circle-fill"></i> Acceso a la zona general</li>
                            <li><i class="bi bi-check-circle-fill"></i> Disfruta todo el espectáculo</li>
                            <li><i class="bi bi-check-circle-fill"></i> Entrada válida todo el día</li>
                            <li><i class="bi bi-check-circle-fill"></i> Acceso digital por QR</li>
                            <li><i class="bi bi-x-circle" style="color:var(--gray)"></i> <span
                                    style="color:var(--text-muted)">Zona preferencial</span></li>
                            <li><i class="bi bi-x-circle" style="color:var(--gray)"></i> <span
                                    style="color:var(--text-muted)">Consumibles incluidos</span></li>
                        </ul>
                        <div class="ticket-perforation mb-4"></div>
                        <a href="#contact" class="btn-get-ticket btn-general">Obtener Entrada General</a>
                    </div>
                </div>
            </div>

            {{-- VIP --}}
            <div class="col-md-5">
                <div class="ticket-card featured">
                    <div class="ticket-header vip-header">
                        <span class="ticket-featured-badge"><i class="bi bi-star-fill me-1"></i>Premium</span>
                        <div class="ticket-type">Acceso</div>
                        <div class="ticket-name">VIP</div>
                        <div class="ticket-desc">Vívelo sin límites, con privilegios exclusivos</div>
                        <div class="ticket-deco">
                            <div class="ticket-hole"></div>
                            <div class="ticket-hole"></div>
                        </div>
                    </div>
                    <div class="ticket-body">
                        <div class="ticket-price-big">
                            <sup>$</sup>Desde 200K <span class="per">/ persona</span>
                        </div>
                        <ul class="ticket-feature-list">
                            <li><i class="bi bi-check-circle-fill"></i> Acceso a zona preferencial VIP</li>
                            <li><i class="bi bi-check-circle-fill"></i> Vista privilegiada al escenario</li>
                            <li><i class="bi bi-check-circle-fill"></i> Entrada válida todo el día</li>
                            <li><i class="bi bi-check-circle-fill"></i> Acceso digital por QR</li>
                            <li><i class="bi bi-check-circle-fill"></i> Consumibles incluidos</li>
                            <li><i class="bi bi-check-circle-fill"></i> Lounge exclusivo y meet & greet</li>
                        </ul>
                        <div class="ticket-perforation mb-4"></div>
                        <a href="#contact" class="btn-get-ticket btn-vip">Obtener Entrada VIP <i
                                class="bi bi-star-fill ms-1"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section id="how">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">Proceso</div>
            <h2 class="section-title">¿Cómo funciona?</h2>
            <p class="text-muted mt-3">Tu entrada en 3 simples pasos</p>
        </div>
        <div class="row g-4 text-center">
            @php
                $steps = [
                    [
                        'n' => '1',
                        'icon' => 'bi-search',
                        'title' => 'Encuentra tu evento',
                        'desc' =>
                            'Explora nuestra cartelera de conciertos, shows, deportes y más. Filtra por ciudad, fecha o categoría.',
                    ],
                    [
                        'n' => '2',
                        'icon' => 'bi-ticket-perforated',
                        'title' => 'Elige tu entrada',
                        'desc' =>
                            'Selecciona entre General o VIP según tu presupuesto y la experiencia que quieres vivir.',
                    ],
                    [
                        'n' => '3',
                        'icon' => 'bi-qr-code-scan',
                        'title' => '¡Disfruta el evento!',
                        'desc' =>
                            'Recibe tu QR por correo, preséntalo en la entrada y vive el momento que tanto esperabas.',
                    ],
                ];
            @endphp
            @foreach ($steps as $s)
                <div class="col-md-4">
                    <div class="step-num">{{ $s['n'] }}</div>
                    <i class="bi {{ $s['icon'] }}"
                        style="font-size:2rem;color:var(--pastel);margin-bottom:.75rem;display:block"></i>
                    <div class="step-title">{{ $s['title'] }}</div>
                    <p class="step-desc">{{ $s['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center mb-5">
                <div class="section-tag">Contacto</div>
                <h2 class="section-title">¿Tienes un evento?</h2>
                <p>Publica tus eventos en nuestra plataforma y llega a miles de personas. Respondemos en menos de 24
                    horas.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="contact-form-card">
                    <form method="POST" action="#">
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Tu nombre">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Correo electrónico</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="tu@correo.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nombre del evento</label>
                                <input type="text" name="event" class="form-control"
                                    placeholder="¿Cómo se llama tu evento?">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Tipo de evento</label>
                                <select name="type" class="form-select">
                                    <option>Seleccionar...</option>
                                    <option>Concierto / Música</option>
                                    <option>Teatro / Show</option>
                                    <option>Deportes</option>
                                    <option>Conferencia</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Asistencia estimada</label>
                                <input type="text" name="capacity" class="form-control"
                                    placeholder="Ej: 500 personas">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Cuéntanos más</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Fecha, lugar, detalles del evento..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom w-100 text-center border-0"
                                    style="width:100%">
                                    Enviar solicitud <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
        <span class="footer-brand fw-bold">
            <i class="bi bi-ticket-perforated-fill me-1"></i>
            <span>Ticket</span>Now &copy; {{ date('Y') }}
        </span>
        <div class="d-flex gap-4 flex-wrap">
            <a href="#events">Eventos</a>
            <a href="#tickets">Entradas</a>
            <a href="#how">Cómo funciona</a>
            <a href="#contact">Contacto</a>
        </div>
    </div>
</footer>

@foreach ($events as $e)

<div class="modal fade" id="eventModal{{ $e['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content event-modal">

            <div class="modal-body p-0">

                <div class="event-modal-banner">
                    <img src="{{ $e['posterUrl'] }}" class="w-100">

                    <span class="event-status active">
                        {{ $e['isActive'] ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>

                <div class="p-4">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                        <div>
                            <h2 class="event-modal-title">
                                {{ $e['name'] }}
                            </h2>

                            <div class="event-modal-meta">
                                <div>
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $e['createdAt'] }}
                                </div>

                                <div>
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $e['venueName'] }}
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="event-price-label">
                                Desde
                            </div>

                            <div class="event-price">
                                $80K
                            </div>
                        </div>

                    </div>

                    <hr>

                    <p class="event-description">
                        Vive una experiencia inolvidable con uno de los mejores eventos del año.
                        Disfruta música, entretenimiento y una producción de primer nivel.
                    </p>

                    <div class="row g-3 mt-3">

                        <div class="col-md-6">
                            <div class="ticket-option">
                                <h5>General</h5>
                                <p>Acceso estándar al evento.</p>

                                <div class="ticket-price-small">
                                    $80.000
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ticket-option vip">
                                <h5>VIP</h5>
                                <p>Zona preferencial + beneficios exclusivos.</p>

                                <div class="ticket-price-small">
                                    $200.000
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-3">

                        <button class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Cerrar
                        </button>

                        <a href="{{ route('events.show', $e['id']) }}"
                           class="btn btn-buy px-4">
                            Comprar entrada
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
