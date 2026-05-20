<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TicketNow') }} — Tu plataforma de eventos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --gray:        #DDDCDB;
            --orange:      #FD7B41;
            --orange-dk:   #e5622a;
            --pastel:      #EDBF9B;
            --dark:        #3C4044;
            --dark-soft:   #4e5459;
            --text-muted:  #6c757d;
            --bg-light:    #f8f7f6;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--dark);
            background: #fff;
        }

        /* ── NAV ── */
        .navbar {
            background: var(--dark) !important;
            padding: .9rem 0;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: -.5px;
        }
        .navbar-brand span { color: var(--orange); }
        .nav-link {
            color: var(--gray) !important;
            font-size: .9rem;
            transition: color .2s;
        }
        .nav-link:hover { color: #fff !important; }
        .btn-nav {
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: .875rem;
            font-weight: 600;
            padding: .45rem 1.3rem;
            transition: background .2s;
        }
        .btn-nav:hover { background: var(--orange-dk); color: #fff; }
        .navbar-toggler { border-color: var(--gray); }
        .navbar-toggler-icon { filter: invert(1); }

        /* ── HERO ── */
        #hero {
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
        }
        #hero::before {
            content: '';
            position: absolute;
            top: -120px; right: -120px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: var(--orange);
            opacity: .08;
        }
        #hero::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -80px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: var(--pastel);
            opacity: .07;
        }
        .hero-tag {
            display: inline-block;
            background: rgba(237,191,155,.15);
            border: 1px solid rgba(237,191,155,.3);
            color: var(--pastel);
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .3rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
        }
        #hero h1 {
            font-size: clamp(2.4rem, 5.5vw, 4rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 1.25rem;
        }
        #hero h1 span { color: var(--orange); }
        .hero-sub {
            color: var(--gray);
            font-size: 1.05rem;
            line-height: 1.75;
            max-width: 500px;
            margin-bottom: 2.5rem;
        }
        .btn-primary-custom {
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: .95rem;
            padding: .75rem 2rem;
            transition: background .2s, transform .15s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary-custom:hover {
            background: var(--orange-dk);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-ghost {
            background: transparent;
            color: var(--gray);
            border: 1px solid rgba(221,220,219,.3);
            border-radius: 8px;
            font-weight: 600;
            font-size: .95rem;
            padding: .75rem 2rem;
            transition: border-color .2s, color .2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-ghost:hover { border-color: var(--gray); color: #fff; }

        /* Hero stats */
        .hero-stats {
            border-top: 1px solid rgba(221,220,219,.15);
            margin-top: 3rem;
            padding-top: 2rem;
        }
        .hero-stat-val {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--orange);
        }
        .hero-stat-label {
            font-size: .78rem;
            color: var(--gray);
            margin-top: .1rem;
        }

        /* Hero visual card */
        .hero-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 16px;
            padding: 1.75rem;
            color: #fff;
        }
        .hero-card-event {
            background: var(--orange);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
        }
        .hero-card-event-name { font-weight: 700; font-size: 1.05rem; }
        .hero-card-event-date { font-size: .8rem; opacity: .85; margin-top: .2rem; }
        .ticket-badge {
            display: inline-block;
            background: rgba(255,255,255,.2);
            border-radius: 4px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .05em;
            padding: .15rem .6rem;
            margin-top: .5rem;
        }
        .ticket-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .75rem 0;
            border-bottom: 1px solid rgba(255,255,255,.08);
            font-size: .875rem;
        }
        .ticket-row:last-child { border-bottom: none; }
        .ticket-price { font-weight: 700; color: var(--orange); }
        .ticket-avail { font-size: .75rem; color: var(--gray); }
        .btn-ticket-sm {
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: .75rem;
            font-weight: 700;
            padding: .3rem .8rem;
            cursor: pointer;
            transition: background .2s;
        }
        .btn-ticket-sm:hover { background: var(--orange-dk); }

        /* ── SEARCH BAR ── */
        #search {
            background: var(--bg-light);
            padding: 56px 0;
        }
        .search-box {
            background: #fff;
            border: 1px solid var(--gray);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 24px rgba(60,64,68,.06);
        }
        .search-box h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        .form-control-custom, .form-select-custom {
            border: 1px solid var(--gray);
            border-radius: 6px;
            padding: .6rem 1rem;
            font-size: .875rem;
            width: 100%;
            color: var(--dark);
            background: #fff;
            outline: none;
            transition: border-color .2s;
        }
        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--orange);
        }
        .btn-search {
            background: var(--orange);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: .9rem;
            padding: .6rem 1.5rem;
            width: 100%;
            transition: background .2s;
            cursor: pointer;
        }
        .btn-search:hover { background: var(--orange-dk); }

        /* ── EVENTS ── */
        #events { padding: 80px 0; }
        .section-tag {
            font-size: .78rem;
            font-weight: 700;
            color: var(--orange);
            text-transform: uppercase;
            letter-spacing: .1em;
        }
        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 800;
            color: var(--dark);
            margin-top: .4rem;
        }
        .event-card {
            border: 1px solid var(--gray);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            transition: box-shadow .2s, transform .2s;
            height: 100%;
        }
        .event-card:hover {
            box-shadow: 0 8px 32px rgba(60,64,68,.12);
            transform: translateY(-3px);
        }
        .event-thumb {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            position: relative;
        }
        .thumb-concert  { background: linear-gradient(135deg, #3C4044 0%, #FD7B41 100%); }
        .thumb-sports   { background: linear-gradient(135deg, #3C4044 0%, #EDBF9B 100%); }
        .thumb-theater  { background: linear-gradient(135deg, #FD7B41 0%, #3C4044 100%); }
        .thumb-conf     { background: linear-gradient(135deg, #EDBF9B 0%, #3C4044 100%); }
        .event-cat {
            position: absolute;
            top: 12px; left: 12px;
            background: rgba(60,64,68,.7);
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            padding: .2rem .7rem;
            border-radius: 999px;
        }
        .event-body { padding: 1.25rem; }
        .event-name { font-weight: 700; font-size: 1rem; color: var(--dark); margin-bottom: .4rem; }
        .event-meta { font-size: .8rem; color: var(--text-muted); margin-bottom: .75rem; }
        .event-meta i { margin-right: .3rem; color: var(--orange); }
        .event-prices {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        .price-pill {
            font-size: .75rem;
            font-weight: 700;
            padding: .25rem .75rem;
            border-radius: 999px;
        }
        .pill-general {
            background: rgba(221,220,219,.4);
            color: var(--dark);
        }
        .pill-vip {
            background: rgba(253,123,65,.15);
            color: var(--orange-dk);
        }
        .btn-buy {
            display: block;
            text-align: center;
            background: var(--dark);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            font-size: .85rem;
            padding: .55rem 1rem;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-buy:hover { background: var(--orange); color: #fff; }

        /* ── TICKETS ── */
        #tickets { background: var(--bg-light); padding: 80px 0; }
        .ticket-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1.5px solid var(--gray);
            background: #fff;
            height: 100%;
            position: relative;
            transition: box-shadow .2s;
        }
        .ticket-card:hover { box-shadow: 0 8px 32px rgba(60,64,68,.1); }
        .ticket-card.featured {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(253,123,65,.15);
        }
        .ticket-header {
            padding: 1.75rem 1.75rem 1.25rem;
            background: var(--dark);
            color: #fff;
            position: relative;
        }
        .ticket-header.vip-header {
            background: var(--orange);
        }
        .ticket-type { font-size: .78rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; opacity: .8; }
        .ticket-name { font-size: 1.6rem; font-weight: 800; margin: .2rem 0; }
        .ticket-desc { font-size: .8rem; opacity: .75; }
        .ticket-deco {
            position: absolute;
            bottom: -18px; left: 0; right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 1.25rem;
        }
        .ticket-hole {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--bg-light);
            border: 1.5px solid var(--gray);
        }
        .ticket-featured-badge {
            position: absolute;
            top: 12px; right: 12px;
            background: #fff;
            color: var(--orange);
            font-size: .7rem;
            font-weight: 700;
            padding: .2rem .7rem;
            border-radius: 999px;
        }
        .ticket-body {
            padding: 2rem 1.75rem 1.75rem;
        }
        .ticket-price-big { font-size: 2.4rem; font-weight: 800; color: var(--dark); line-height: 1; }
        .ticket-price-big sup { font-size: 1rem; vertical-align: top; margin-top: .5rem; }
        .ticket-price-big .per { font-size: .85rem; font-weight: 400; color: var(--text-muted); }
        .ticket-feature-list { list-style: none; padding: 0; margin: 1.25rem 0 1.75rem; }
        .ticket-feature-list li {
            font-size: .875rem;
            color: var(--dark);
            padding: .4rem 0;
            display: flex;
            align-items: center;
            gap: .6rem;
            border-bottom: 1px solid rgba(221,220,219,.5);
        }
        .ticket-feature-list li:last-child { border-bottom: none; }
        .ticket-feature-list li i { color: var(--orange); font-size: 1rem; flex-shrink: 0; }
        .btn-get-ticket {
            display: block;
            text-align: center;
            border-radius: 8px;
            font-weight: 700;
            font-size: .95rem;
            padding: .75rem 1rem;
            text-decoration: none;
            transition: background .2s, transform .15s;
        }
        .btn-get-ticket:hover { transform: translateY(-1px); }
        .btn-general {
            background: var(--dark);
            color: #fff;
        }
        .btn-general:hover { background: var(--dark-soft); color: #fff; }
        .btn-vip {
            background: var(--orange);
            color: #fff;
        }
        .btn-vip:hover { background: var(--orange-dk); color: #fff; }

        /* Perforated line */
        .ticket-perforation {
            border-top: 2px dashed var(--gray);
            margin: 0 1.75rem;
        }

        /* ── HOW IT WORKS ── */
        #how { padding: 80px 0; }
        .step-num {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: var(--orange);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            flex-shrink: 0;
        }
        .step-title { font-weight: 700; font-size: 1rem; color: var(--dark); margin-bottom: .4rem; }
        .step-desc { font-size: .875rem; color: var(--text-muted); line-height: 1.65; }

        /* ── CONTACT ── */
        #contact { background: var(--dark); padding: 80px 0; }
        #contact .section-tag { color: var(--pastel); }
        #contact .section-title { color: #fff; }
        #contact p { color: var(--gray); }
        .contact-form-card {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 12px;
            padding: 2.5rem;
        }
        .contact-form-card .form-label { color: var(--gray); font-size: .85rem; font-weight: 500; }
        .contact-form-card .form-control,
        .contact-form-card .form-select {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            border-radius: 6px;
            font-size: .875rem;
            padding: .65rem 1rem;
        }
        .contact-form-card .form-control::placeholder { color: rgba(255,255,255,.3); }
        .contact-form-card .form-control:focus,
        .contact-form-card .form-select:focus {
            border-color: var(--orange);
            box-shadow: none;
            background: rgba(255,255,255,.1);
            color: #fff;
        }
        .contact-form-card .form-select option { background: var(--dark); color: #fff; }

        /* ── FOOTER ── */
        footer {
            background: #2a2d30;
            border-top: 1px solid rgba(221,220,219,.1);
            padding: 1.75rem 0;
            font-size: .85rem;
            color: var(--gray);
        }
        footer a { color: var(--gray); text-decoration: none; }
        footer a:hover { color: var(--orange); }
        .footer-brand span { color: var(--orange); }
    </style>
</head>
<body>

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
                    <li class="nav-item"><a class="nav-link" href="#tickets">Tickets</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how">¿Cómo funciona?</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
                </ul>
                <div class="d-flex gap-2 mt-2 mt-md-0">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-nav">Mi cuenta</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-ghost text-decoration-none" style="color:var(--gray);border:1px solid rgba(221,220,219,.3);border-radius:6px;padding:.45rem 1rem;font-size:.875rem;">Ingresar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-nav">Registrarse</a>
                            @endif
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
                    <div class="hero-tag"><i class="bi bi-lightning-fill me-1"></i> La forma más fácil de conseguir tu entrada</div>
                    <h1>Vive el evento que <span>siempre quisiste</span></h1>
                    <p class="hero-sub">
                        Conciertos, festivales, teatro, deportes y más. Encuentra, compra y disfruta tu boleto en minutos. Sin complicaciones.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#events" class="btn-primary-custom">Ver eventos <i class="bi bi-arrow-right ms-1"></i></a>
                        <a href="#how" class="btn-ghost">¿Cómo funciona?</a>
                    </div>
                    <div class="hero-stats row g-0">
                        <div class="col-4 text-center">
                            <div class="hero-stat-val">+500</div>
                            <div class="hero-stat-label">Eventos activos</div>
                        </div>
                        <div class="col-4 text-center" style="border-left:1px solid rgba(221,220,219,.15);border-right:1px solid rgba(221,220,219,.15)">
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
                        <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:var(--gray);text-transform:uppercase;margin-bottom:1rem;">
                            <i class="bi bi-fire me-1" style="color:var(--orange)"></i> Eventos destacados
                        </div>
                        <div class="hero-card-event">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                                <div>
                                    <div class="hero-card-event-name">Festival Electrónico 2025</div>
                                    <div class="hero-card-event-date"><i class="bi bi-calendar3 me-1"></i>15 Ago · Medellín</div>
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
                                <div class="ticket-avail"><i class="bi bi-star-fill me-1" style="color:var(--orange)"></i>28 disponibles</div>
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
                        <label class="form-label small fw-semibold mb-1">¿Qué buscas?</label>
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
                    <div class="section-tag">Próximos eventos</div>
                    <h2 class="section-title">Eventos disponibles</h2>
                </div>
                <a href="#" style="color:var(--orange);font-size:.875rem;font-weight:600;text-decoration:none">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @php
            $events = [
                ['emoji'=>'🎵','thumb'=>'thumb-concert','cat'=>'Concierto','name'=>'Festival Electrónico 2025','date'=>'15 Ago 2025','place'=>'Medellín','general'=>'$120.000','vip'=>'$280.000'],
                ['emoji'=>'⚽','thumb'=>'thumb-sports','cat'=>'Deportes','name'=>'Clásico Nacional','date'=>'22 Ago 2025','place'=>'Bogotá','general'=>'$85.000','vip'=>'$200.000'],
                ['emoji'=>'🎭','thumb'=>'thumb-theater','cat'=>'Teatro','name'=>'El Fantasma de la Ópera','date'=>'30 Ago 2025','place'=>'Cali','general'=>'$95.000','vip'=>'$220.000'],
                ['emoji'=>'🎤','thumb'=>'thumb-conf','cat'=>'Conferencia','name'=>'Summit Tech Colombia','date'=>'5 Sep 2025','place'=>'Medellín','general'=>'$150.000','vip'=>'$350.000'],
            ];
            @endphp

            <div class="row g-4">
                @foreach($events as $e)
                <div class="col-sm-6 col-lg-3">
                    <div class="event-card">
                        <div class="event-thumb {{ $e['thumb'] }}">
                            <span class="event-cat">{{ $e['cat'] }}</span>
                            {{ $e['emoji'] }}
                        </div>
                        <div class="event-body">
                            <div class="event-name">{{ $e['name'] }}</div>
                            <div class="event-meta">
                                <i class="bi bi-calendar3"></i>{{ $e['date'] }}<br>
                                <i class="bi bi-geo-alt-fill"></i>{{ $e['place'] }}
                            </div>
                            <div class="event-prices">
                                <span class="price-pill pill-general">General {{ $e['general'] }}</span>
                                <span class="price-pill pill-vip"><i class="bi bi-star-fill me-1"></i>VIP {{ $e['vip'] }}</span>
                            </div>
                            <a href="#tickets" class="btn-buy">Comprar entrada &rarr;</a>
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
                <div class="section-tag">Tipos de ticket</div>
                <h2 class="section-title">Elige tu experiencia</h2>
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
                                <li><i class="bi bi-check-circle-fill"></i> Acceso al área general</li>
                                <li><i class="bi bi-check-circle-fill"></i> Disfruta todo el espectáculo</li>
                                <li><i class="bi bi-check-circle-fill"></i> Entrada válida todo el día</li>
                                <li><i class="bi bi-check-circle-fill"></i> QR de acceso digital</li>
                                <li><i class="bi bi-x-circle" style="color:var(--gray)"></i> <span style="color:var(--text-muted)">Zona preferencial</span></li>
                                <li><i class="bi bi-x-circle" style="color:var(--gray)"></i> <span style="color:var(--text-muted)">Consumibles incluidos</span></li>
                            </ul>
                            <div class="ticket-perforation mb-4"></div>
                            <a href="#contact" class="btn-get-ticket btn-general">Obtener ticket General</a>
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
                                <li><i class="bi bi-check-circle-fill"></i> Acceso zona VIP preferencial</li>
                                <li><i class="bi bi-check-circle-fill"></i> Vista privilegiada del escenario</li>
                                <li><i class="bi bi-check-circle-fill"></i> Entrada válida todo el día</li>
                                <li><i class="bi bi-check-circle-fill"></i> QR de acceso digital</li>
                                <li><i class="bi bi-check-circle-fill"></i> Consumibles incluidos</li>
                                <li><i class="bi bi-check-circle-fill"></i> Lounge exclusivo & meet & greet</li>
                            </ul>
                            <div class="ticket-perforation mb-4"></div>
                            <a href="#contact" class="btn-get-ticket btn-vip">Obtener ticket VIP <i class="bi bi-star-fill ms-1"></i></a>
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
                    ['n'=>'1','icon'=>'bi-search','title'=>'Encuentra tu evento','desc'=>'Explora nuestra cartelera de conciertos, shows, deportes y más. Filtra por ciudad, fecha o categoría.'],
                    ['n'=>'2','icon'=>'bi-ticket-perforated','title'=>'Elige tu ticket','desc'=>'Selecciona entre General o VIP según tu presupuesto y la experiencia que quieres vivir.'],
                    ['n'=>'3','icon'=>'bi-qr-code-scan','title'=>'¡Disfruta el evento!','desc'=>'Recibe tu QR por email, preséntalo en la entrada y vive el momento que estabas esperando.'],
                ];
                @endphp
                @foreach($steps as $s)
                <div class="col-md-4">
                    <div class="step-num">{{ $s['n'] }}</div>
                    <i class="bi {{ $s['icon'] }}" style="font-size:2rem;color:var(--pastel);margin-bottom:.75rem;display:block"></i>
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
                    <p>Publica tus eventos en nuestra plataforma y llega a miles de personas. Te respondemos en menos de 24 horas.</p>
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
                                    <input type="text" name="name" class="form-control" placeholder="Tu nombre">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="tu@correo.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nombre del evento</label>
                                    <input type="text" name="event" class="form-control" placeholder="¿Cómo se llama tu evento?">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Tipo de evento</label>
                                    <select name="type" class="form-select">
                                        <option>Selecciona...</option>
                                        <option>Concierto / Música</option>
                                        <option>Teatro / Show</option>
                                        <option>Deportes</option>
                                        <option>Conferencia</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Aforo estimado</label>
                                    <input type="text" name="capacity" class="form-control" placeholder="Ej: 500 personas">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Cuéntanos más</label>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Fecha, lugar, detalles del evento..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-primary-custom w-100 text-center border-0" style="width:100%">
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
                <a href="#tickets">Tickets</a>
                <a href="#how">¿Cómo funciona?</a>
                <a href="#contact">Contacto</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>