<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel — {{ config('app.name', 'TicketNow') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite('resources/css/dashboard.css')
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
        @if (session('success'))
            <div class="alert alert-success" id="alert-success">
                <div class="alert-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="alert-body">
                    <div class="alert-title">¡Operación exitosa!</div>
                    <div class="alert-msg">{{ session('success') }}</div>
                </div>
                <button class="alert-close" onclick="closeAlert('alert-success')">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" id="alert-error">
                <div class="alert-icon"><i class="bi bi-x-circle-fill"></i></div>
                <div class="alert-body">
                    <div class="alert-title">¡Ocurrió un error!</div>
                    <div class="alert-msg">{{ session('error') }}</div>
                </div>
                <button class="alert-close" onclick="closeAlert('alert-error')">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif
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