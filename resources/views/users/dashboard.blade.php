<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel — {{ config('app.name', 'TicketNow') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap"
        rel="stylesheet">
    {{--     <link href="https://cdn.jsdelivr.net/gh/kepler-csharp/events-online-users@main/public/css/dashboard.css"
        rel="stylesheet"> --}}
    @vite(['resources/css/dashboard.css'])
</head>

<body>
    <!-- Botón para abrir el menú lateral en dispositivos móviles -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

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
        <a href="{{ route('welcome') }}" class="nav-item">
            <i class="bi bi-house fw-bolder" style="transform: scale(1.4)"></i> Página principal
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
                @if (session('user.avatar'))
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
                        @if (session('user.avatar'))
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
            $totalEntradas = count($data);
            $totalVip = isset($tickets) ? collect($tickets)->where('type', 'VIP')->count() : 0;
            $proximoEvento = isset($tickets) && count($tickets) > 0 ? $tickets[0]['event_date'] ?? '—' : '—';
        @endphp

        <div class="stats-grid">
            <div class="stat-card" style="animation-delay:.05s">
                <div class="stat-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
                <div>
                    <div class="stat-label">Total de boletas</div>
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

            @if (isset($data) && count($data) > 0)
                <div class="events-grid">
                    @foreach ($data as $i => $order)
                        @php
                            $firstItem = $order['items'][0] ?? null;
                            $totalTickets = count($order['items']);
                        @endphp
                        <div class="event-card" style="animation-delay:{{ $i * 0.08 }}s">
                            <div class="event-thumb thumb-theater">
                                <span class="event-cat-badge">Cine</span>
                                🎬
                                <span
                                    class="ticket-type-badge {{ $order['status'] == 1 ? 'badge-vip' : 'badge-general' }}">
                                    {{ $totalTickets }} {{ $totalTickets > 1 ? 'Entradas' : 'Entrada' }}
                                </span>
                            </div>

                            <div class="event-body">
                                <div class="event-name">{{ $firstItem['eventName'] }}</div>

                                <div class="event-meta" style="margin-bottom: 0.5rem;">
                                    <div><i class="bi bi-calendar3"></i>
                                        {{ \Carbon\Carbon::parse($firstItem['showtimeStart'])->format('d M, Y - h:i A') }}
                                    </div>
                                    <div><i class="bi bi-hash"></i> Orden #{{ $order['id'] }} •
                                        <strong>{{ $order['status'] == 1 ? 'Pagado' : 'Pendiente' }}</strong>
                                    </div>
                                </div>

                                {{-- Mini badge de asientos dentro de la card --}}
                                <div
                                    style="display: flex; flex-wrap: wrap; gap: 0.35rem; padding: 0.6rem 0; border-top: 1px solid var(--border); margin-bottom: 0.5rem;">
                                    @foreach ($order['items'] as $ticket)
                                        <button class="seat-badge" {{-- style="background: var(--surface2); border: 1px solid var(--border); color: var(--gray); font-size: 0.72rem; padding: 0.2rem 0.4rem; border-radius: 4px; cursor: pointer; display: flex; align-items: center; gap: 0.2rem;" --}}
                                            onclick="openQrModal('{{ $ticket['eventName'] }}', '{{ $ticket['seatLabel'] }}', '{{ \Carbon\Carbon::parse($ticket['showtimeStart'])->format('d M, Y - h:i A') }}', '{{ $ticket['qrImageUrl'] }}', '{{ $ticket['qrCode'] }}')">
                                            💺 {{ $ticket['seatLabel'] }}
                                        </button>
                                    @endforeach
                                </div>

                                <div class="event-footer" style="padding-top: 0.5rem;">
                                    <div class="event-price">${{ number_format($order['total'], 0, ',', '.') }}</div>
                                    <span style="font-size: 0.75rem; color: var(--text-muted)">Total pagado</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>

    {{-- ─── MODAL QR (IDs Unificados con JavaScript) ─── --}}
    <div class="modal-overlay" id="qrModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeQrModal()"><i class="bi bi-x"></i></button>
            <div class="modal-event-name" id="modalEventName"></div>
            <div class="modal-event-meta" id="modalEventMeta"></div>

            {{-- Caja blanca que recibe la imagen del código QR que viene de tu API --}}
            <div class="qr-box"
                style="background: #fff; border-radius: 12px; width: 180px; height: 180px; margin: 0 auto 1.25rem; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <img id="modalQrImg" src="" alt="Código QR"
                    style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
            </div>

            <div id="modalSeat" class="modal-ticket-type badge-vip"></div>
            <p class="modal-info" id="modalQrCode"
                style="font-family: monospace; font-size: 0.65rem; word-break: break-all; margin-top: 10px; color: #6c757d;">
            </p>
        </div>
    </div>

    <script>
        function openQrModal(eventName, seatLabel, showtime, qrImageUrl, qrCode) {
            // Mapeamos los datos correctos en el HTML del modal
            document.getElementById('modalEventName').innerText = eventName;
            document.getElementById('modalEventMeta').innerText = showtime;
            document.getElementById('modalSeat').innerText = 'Asiento: ' + seatLabel;
            document.getElementById('modalQrCode').innerText = qrCode;

            // Inyectamos la URL de la imagen de tu API
            document.getElementById('modalQrImg').src = qrImageUrl;

            // Abrimos el modal
            document.getElementById('qrModal').classList.add('open');
        }

        function closeQrModal() {
            document.getElementById('qrModal').classList.remove('open');
            document.getElementById('modalQrImg').src = ""; // Limpiamos la imagen por seguridad
        }

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }

        // Cerrar si hacen clic fuera de la caja blanca del modal
        window.onclick = function(event) {
            const modal = document.getElementById('qrModal');
            if (event.target === modal) {
                closeQrModal();
            }
        }
    </script>

</body>

</html>
