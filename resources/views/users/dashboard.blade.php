<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel — {{ config('app.name', 'TicketNow') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gray:       #DDDCDB;
            --orange:     #FD7B41;
            --orange-dk:  #e5622a;
            --pastel:     #EDBF9B;
            --dark:       #3C4044;
            --dark-soft:  #4e5459;
            --text-muted: #6c757d;
            --bg-light:   #f8f7f6;

            /* Dashboard surfaces (dark premium sobre la paleta) */
            --bg:         #2a2d30;
            --surface:    #323538;
            --surface2:   #3c4044;
            --border:     rgba(221,220,219,.1);
            --radius:     14px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--gray);
            min-height: 100vh;
            display: flex;
        }

        /* ────────────────── SIDEBAR ────────────────── */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--dark);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.25rem;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 2.5rem;
            text-decoration: none;
        }
        .sidebar-logo i  { color: var(--orange); font-size: 1.4rem; }
        .sidebar-logo span { color: var(--orange); }

        .nav-label {
            font-size: .62rem;
            font-weight: 700;
            letter-spacing: .12em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin: 1.25rem 0 .5rem .5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem .9rem;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            transition: all .2s;
            margin-bottom: .2rem;
        }
        .nav-item i { font-size: 1rem; width: 18px; text-align: center; }
        .nav-item:hover  { background: var(--surface2); color: var(--gray); }
        .nav-item.active { background: rgba(253,123,65,.15); color: var(--orange); }

        .sidebar-spacer { flex: 1; }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: .9rem 1rem;
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }
        .s-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--orange), var(--pastel));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700; font-size: .95rem; color: #fff;
            flex-shrink: 0; overflow: hidden;
        }
        .s-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .s-info { overflow: hidden; }
        .s-name  { font-weight: 600; font-size: .83rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--gray); }
        .s-role  { font-size: .7rem; color: var(--text-muted); }

        /* ────────────────── MAIN ────────────────── */
        .main {
            margin-left: 250px;
            flex: 1;
            padding: 2rem 2.25rem;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .topbar-left h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--gray);
        }
        .topbar-left h2 span { color: var(--orange); }
        .topbar-left p { color: var(--text-muted); font-size: .875rem; margin-top: .3rem; }

        .topbar-right { display: flex; align-items: center; gap: .75rem; }

        .profile-pill {
            display: flex; align-items: center; gap: .65rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50px;
            padding: .4rem .9rem .4rem .4rem;
        }
        .profile-pill .p-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--orange), var(--pastel));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 700; font-size: .8rem; color: #fff;
            overflow: hidden; flex-shrink: 0;
        }
        .profile-pill .p-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-pill .p-name { font-size: .83rem; font-weight: 600; color: var(--gray); }
        .profile-pill .p-email { font-size: .7rem; color: var(--text-muted); }

        .btn-logout {
            display: flex; align-items: center; gap: .45rem;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: .5rem 1rem;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: .83rem; cursor: pointer;
            transition: all .2s; text-decoration: none;
        }
        .btn-logout:hover { border-color: var(--orange); color: var(--orange); }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: border-color .2s, transform .2s;
            animation: fadeUp .4s ease both;
        }
        .stat-card:hover { border-color: rgba(253,123,65,.4); transform: translateY(-2px); }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(253,123,65,.12);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: var(--orange); flex-shrink: 0;
        }
        .stat-label { font-size: .75rem; color: var(--text-muted); margin-bottom: .15rem; }
        .stat-value { font-family: 'Syne', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--gray); }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            flex-wrap: wrap; gap: .75rem;
        }
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gray);
        }
        .section-title span {
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--orange);
            margin-right: .45rem;
            vertical-align: middle;
        }
        .btn-ver-todos {
            font-size: .8rem;
            color: var(--orange);
            text-decoration: none;
            font-weight: 600;
            display: flex; align-items: center; gap: .3rem;
            transition: opacity .2s;
        }
        .btn-ver-todos:hover { opacity: .75; }

        /* ── EVENTS GRID ── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .event-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: border-color .25s, transform .25s, box-shadow .25s;
            animation: fadeUp .5s ease both;
        }
        .event-card:hover {
            border-color: rgba(253,123,65,.45);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,.3);
        }

        .event-thumb {
            height: 110px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            position: relative;
        }
        .thumb-concert  { background: linear-gradient(135deg, #1a1a2e 0%, #3d2c4e 100%); }
        .thumb-sports   { background: linear-gradient(135deg, #0f2027 0%, #203a43 100%); }
        .thumb-theater  { background: linear-gradient(135deg, #2c1654 0%, #4a2040 100%); }
        .thumb-conf     { background: linear-gradient(135deg, #1c3a2e 0%, #2d5a3d 100%); }

        .event-cat-badge {
            position: absolute; top: .65rem; left: .65rem;
            font-size: .65rem; font-weight: 700; letter-spacing: .06em;
            text-transform: uppercase;
            background: rgba(253,123,65,.2);
            color: var(--orange);
            border: 1px solid rgba(253,123,65,.35);
            border-radius: 6px;
            padding: .2rem .55rem;
        }

        .ticket-type-badge {
            position: absolute; top: .65rem; right: .65rem;
            font-size: .65rem; font-weight: 700;
            border-radius: 6px;
            padding: .2rem .55rem;
        }
        .badge-vip     { background: rgba(245,200,66,.15); color: var(--pastel); border: 1px solid rgba(237,191,155,.3); }
        .badge-general { background: rgba(221,220,219,.1); color: var(--gray); border: 1px solid var(--border); }

        .event-body { padding: 1rem 1.1rem 1.1rem; }
        .event-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            color: var(--gray);
            margin-bottom: .5rem;
            line-height: 1.3;
        }
        .event-meta {
            display: flex; flex-direction: column; gap: .3rem;
            font-size: .78rem; color: var(--text-muted);
            margin-bottom: .9rem;
        }
        .event-meta i { color: var(--orange); margin-right: .3rem; }

        .event-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
        }
        .event-price {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--orange);
        }
        .btn-ver-entrada {
            display: flex; align-items: center; gap: .35rem;
            background: rgba(253,123,65,.12);
            color: var(--orange);
            border: 1px solid rgba(253,123,65,.3);
            border-radius: 8px;
            padding: .38rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
        }
        .btn-ver-entrada:hover { background: var(--orange); color: #fff; border-color: var(--orange); }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: var(--surface);
            border: 1px dashed rgba(253,123,65,.3);
            border-radius: var(--radius);
            padding: 3.5rem 2rem;
            text-align: center;
            animation: fadeUp .5s ease both;
        }
        .empty-state i { font-size: 3rem; color: rgba(253,123,65,.4); margin-bottom: 1rem; display: block; }
        .empty-state h4 { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--gray); margin-bottom: .5rem; }
        .empty-state p  { font-size: .875rem; color: var(--text-muted); max-width: 320px; margin: auto; }
        .btn-explorar {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--orange);
            color: #fff;
            padding: .65rem 1.4rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: .875rem;
            text-decoration: none;
            margin-top: 1.25rem;
            transition: background .2s;
        }
        .btn-explorar:hover { background: var(--orange-dk); }

        /* ── MODAL QR ── */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center; justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: var(--dark);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            width: 340px;
            text-align: center;
            position: relative;
            animation: popIn .25s ease;
        }
        .modal-close {
            position: absolute; top: 1rem; right: 1rem;
            background: var(--surface2); border: none;
            width: 32px; height: 32px; border-radius: 50%;
            color: var(--text-muted); font-size: 1rem;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: color .2s;
        }
        .modal-close:hover { color: var(--orange); }
        .modal-event-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700; font-size: 1rem;
            color: var(--gray); margin-bottom: .3rem;
        }
        .modal-event-meta { font-size: .78rem; color: var(--text-muted); margin-bottom: 1.25rem; }
        .qr-box {
            background: #fff;
            border-radius: 12px;
            width: 160px; height: 160px;
            margin: 0 auto 1.25rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 4.5rem;
        }
        .modal-ticket-type {
            display: inline-block;
            font-size: .75rem; font-weight: 700;
            border-radius: 6px;
            padding: .25rem .75rem;
            margin-bottom: 1rem;
        }
        .modal-info { font-size: .78rem; color: var(--text-muted); line-height: 1.6; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(.94); }
            to   { opacity: 1; transform: scale(1); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 1.25rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .stats-grid { grid-template-columns: 1fr; }
            .topbar { flex-direction: column; }
        }
    </style>
</head>
<body>

    {{-- ─── SIDEBAR ─── --}}
    <aside class="sidebar">
        <a href="{{ url('/') }}" class="sidebar-logo">
            <i class="bi bi-ticket-perforated-fill"></i>
            Ticket<span>Now</span>
        </a>

        <div class="nav-label">Menú</div>
        <a href="{{ url('/dashboard') }}" class="nav-item active">
            <i class="bi bi-grid-1x2-fill"></i> Mi Panel
        </a>
        <a href="#mis-eventos" class="nav-item">
            <i class="bi bi-ticket-perforated"></i> Mis Entradas
        </a>
        <a href="{{ url('/') }}#events" class="nav-item">
            <i class="bi bi-calendar3"></i> Explorar Eventos
        </a>

        <div class="nav-label">Cuenta</div>
        <a href="#" class="nav-item">
            <i class="bi bi-person"></i> Mi Perfil
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-gear"></i> Configuración
        </a>

        <div class="sidebar-spacer"></div>

        <div class="sidebar-user">
            <div class="s-avatar">
                @if(session('user.avatar'))
                    <img src="{{ session('user.avatar') }}" alt="foto">
                @else
                    {{ strtoupper(substr(session('user.name', 'U'), 0, 1)) }}
                @endif
            </div>
            <div class="s-info">
                <div class="s-name">{{ session('user.name', 'Usuario') }}</div>
                <div class="s-role">Cliente</div>
            </div>
        </div>
    </aside>

    {{-- ─── MAIN ─── --}}
    <main class="main">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="topbar-left">
                <h2>Hola, <span>{{ session('user.name', 'Usuario') }}</span> 👋</h2>
                <p>Aquí están tus eventos y entradas registradas.</p>
            </div>
            <div class="topbar-right">
                <div class="profile-pill">
                    <div class="p-avatar">
                        @if(session('user.avatar'))
                            <img src="{{ session('user.avatar') }}" alt="foto">
                        @else
                            {{ strtoupper(substr(session('user.name', 'U'), 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="p-name">{{ session('user.name', 'Usuario') }}</div>
                        <div class="p-email">{{ session('user.email', '') }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="bi bi-power"></i> Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        {{-- STATS --}}
        @php
            $totalEntradas = isset($tickets) ? count($tickets) : 0;
            $totalVip      = isset($tickets) ? collect($tickets)->where('type', 'VIP')->count() : 0;
            $proximoEvento = isset($tickets) && count($tickets) > 0 ? $tickets[0]['event_date'] ?? '—' : '—';
        @endphp

        <div class="stats-grid">
            <div class="stat-card" style="animation-delay:.05s">
                <div class="stat-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
                <div>
                    <div class="stat-label">Total de entradas</div>
                    <div class="stat-value">{{ $totalEntradas }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay:.1s">
                <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
                <div>
                    <div class="stat-label">Entradas VIP</div>
                    <div class="stat-value">{{ $totalVip }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay:.15s">
                <div class="stat-icon"><i class="bi bi-calendar-event-fill"></i></div>
                <div>
                    <div class="stat-label">Próximo evento</div>
                    <div class="stat-value" style="font-size:1rem">{{ $proximoEvento }}</div>
                </div>
            </div>
        </div>

        {{-- MIS EVENTOS --}}
        <div id="mis-eventos">
            <div class="section-header">
                <div class="section-title"><span></span>Mis Entradas</div>
                <a href="{{ url('/') }}#events" class="btn-ver-todos">
                    Explorar más eventos <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if(isset($tickets) && count($tickets) > 0)
                <div class="events-grid">
                    @foreach($tickets as $i => $ticket)
                    <div class="event-card" style="animation-delay:{{ $i * 0.08 }}s">
                        <div class="event-thumb thumb-{{ $ticket['thumb'] ?? 'concert' }}">
                            <span class="event-cat-badge">{{ $ticket['category'] ?? 'Evento' }}</span>
                            {{ $ticket['emoji'] ?? '🎵' }}
                            <span class="ticket-type-badge {{ $ticket['type'] === 'VIP' ? 'badge-vip' : 'badge-general' }}">
                                @if($ticket['type'] === 'VIP') <i class="bi bi-star-fill me-1"></i> @endif
                                {{ $ticket['type'] }}
                            </span>
                        </div>
                        <div class="event-body">
                            <div class="event-name">{{ $ticket['event_name'] }}</div>
                            <div class="event-meta">
                                <div><i class="bi bi-calendar3"></i>{{ $ticket['event_date'] }}</div>
                                <div><i class="bi bi-geo-alt-fill"></i>{{ $ticket['place'] }}</div>
                                <div><i class="bi bi-hash"></i>{{ $ticket['ticket_code'] ?? 'TKN-' . strtoupper(substr(md5($ticket['event_name']), 0, 8)) }}</div>
                            </div>
                            <div class="event-footer">
                                <div class="event-price">{{ $ticket['price'] }}</div>
                                <button
                                    class="btn-ver-entrada"
                                    onclick="openModal(
                                        '{{ $ticket['event_name'] }}',
                                        '{{ $ticket['event_date'] }}',
                                        '{{ $ticket['place'] }}',
                                        '{{ $ticket['type'] }}',
                                        '{{ $ticket['price'] }}',
                                        '{{ $ticket['ticket_code'] ?? 'TKN-' . strtoupper(substr(md5($ticket['event_name']), 0, 8)) }}',
                                        '{{ $ticket['emoji'] ?? '🎵' }}'
                                    )">
                                    <i class="bi bi-qr-code"></i> Ver entrada
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            @else
                {{-- ESTADO VACÍO --}}
                <div class="empty-state">
                    <i class="bi bi-ticket-perforated"></i>
                    <h4>Aún no tienes entradas</h4>
                    <p>Explora nuestra cartelera y vive experiencias increíbles. Tu primera entrada te está esperando.</p>
                    <a href="{{ url('/') }}#events" class="btn-explorar">
                        <i class="bi bi-search"></i> Explorar eventos
                    </a>
                </div>
            @endif
        </div>

    </main>

    {{-- ─── MODAL QR ─── --}}
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal()"><i class="bi bi-x"></i></button>
            <div class="modal-event-name" id="modalName"></div>
            <div class="modal-event-meta" id="modalMeta"></div>
            <div class="qr-box" id="modalEmoji"></div>
            <div id="modalBadge" class="modal-ticket-type"></div>
            <div class="modal-info" id="modalInfo"></div>
        </div>
    </div>

    <script>
        function openModal(name, date, place, type, price, code, emoji) {
            document.getElementById('modalName').textContent  = name;
            document.getElementById('modalMeta').textContent  = date + ' · ' + place;
            document.getElementById('modalEmoji').textContent = emoji;

            const badge = document.getElementById('modalBadge');
            if (type === 'VIP') {
                badge.textContent = '⭐ VIP';
                badge.style.cssText = 'background:rgba(237,191,155,.15);color:#EDBF9B;border:1px solid rgba(237,191,155,.3)';
            } else {
                badge.textContent = 'General';
                badge.style.cssText = 'background:rgba(221,220,219,.1);color:#DDDCDB;border:1px solid rgba(221,220,219,.15)';
            }

            document.getElementById('modalInfo').innerHTML =
                '<strong style="color:#DDDCDB">Código:</strong> ' + code +
                '<br><strong style="color:#DDDCDB">Precio:</strong> ' + price +
                '<br><br><span style="color:#6c757d;font-size:.72rem">Presenta este QR en la entrada del evento.</span>';

            document.getElementById('modalOverlay').classList.add('open');
        }

        function closeModal(e) {
            if (!e || e.target === document.getElementById('modalOverlay') || e.currentTarget.classList.contains('modal-close')) {
                document.getElementById('modalOverlay').classList.remove('open');
            }
        }
    </script>

</body>
</html>