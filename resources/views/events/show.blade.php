<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Evento — {{ config('app.name', 'TicketNow') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/kepler-csharp/events-online-users@main/public/css/showEvent.css" rel="stylesheet">

</head>
<body>

<div class="container purchase-wrapper">
    <!-- TOP NAV -->
    <div class="purchase-topbar">

        <a href="{{ route('dashboard') }}"
        class="topbar-link">

            <i class="bi bi-arrow-left"></i>

            Volver al dashboard

        </a>

        <div class="topbar-divider"></div>

        <a href="{{ url()->previous() }}"
        class="topbar-link secondary">

            <i class="bi bi-grid"></i>

            Volver a eventos

        </a>

    </div>

    @if($errors->any())
        <div class="custom-alert error-alert">

            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div class="alert-content">
                <strong>{{ $errors->first('error') }}</strong>

                <p>
                    {{ session('error') }}
                </p>
            </div>

            <button type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>
    @endif
    <div class="purchase-layout">

        <!-- LEFT -->
        <div class="main-card">
            <div class="event-top">
                <div class="event-image">
                    <img src="{{ $event['posterUrl'] }}">

                    <div class="event-status active">
                        {{ $event['isActive'] ? 'Activo' : 'Inactivo' }}
                    </div>
                </div>

                <div class="w-100">

                    <h1 class="event-title">
                        {{ $event['name'] }} 
                    </h1>

                    <div class="event-meta">

                        <div>
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($showtime['startTime'])->format('d M Y') }}
                        </div>

                        <div>
                            <i class="bi bi-geo-alt"></i>
                            {{ $event['venueName'] }}
                        </div>

                    </div>

                    <p class="event-description">
                        {{ $event['description'] }}<br />
                        Vive una experiencia inolvidable con uno de los mejores eventos del año.
                    </p>

                </div>

            </div>

            <div class="purchase-content">

                <!-- TICKETS -->
                <section>
                    <h3 class="section-title">
                        Asientos disponibles:
                        <span>{{ $showtime['availableSeats'] }}</span>
                    </h3>
                </section>
                {{--               
                <div class="ticket-grid">
                    <div class="ticket-option">
                        <checkbox>
                            <input type="checkbox" name="ticketType" value="general">
                        </checkbox>
                        <h5>General</h5>

                        <div class="ticket-price">
                            $80.000
                        </div>

                        <p>Acceso estándar al evento</p>

                    </div>

                    <div class="ticket-option">
                        <checkbox>
                            <input type="checkbox" name="ticketType" value="vip">
                        </checkbox>
                        <h5>VIP</h5>

                        <div class="ticket-price">
                            $200.000
                        </div>

                        <p>
                            Zona exclusiva + beneficios
                        </p>

                    </div>
                </div>
                --}}
                
                <!-- SCREEN -->
                <div class="screen"></div>

                <div class="screen-text">
                    ESCENARIO
                </div>

                <!-- SEATS -->
                <h3 class="section-title">
                    Selecciona tus puestos
                </h3>

                <div class="seats-wrapper">
                    @foreach($seats as $seat)
                        <div class="seat {{ $seat['status']? 'occupied' : 'available' }}"
                            data-seat-id="{{ $seat['id'] }}">

                            {{ $seat['row'] }}{{ $seat['number'] }}
                        </div>
                    @endforeach
                </div>

                <!-- LEGEND -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-box" style="background: var(--dark-soft)"></div>
                        Disponible
                    </div>

                    <div class="legend-item">
                        <div class="legend-box" style="background: var(--orange)"></div>
                        Seleccionado
                    </div>

                    <div class="legend-item">
                        <div class="legend-box" style="background: #1f2123"></div>
                        Ocupado
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="summary-card">

            <h3 class="summary-title">
                Resumen de compra
            </h3>

            {{-- Form to all data send --}}
            <form action="{{ route('event.reservation', $showtime['id']) }}" method="POST" class="summary-form">
                @csrf   
                <input type="hidden"
                        name="seats"
                        id="selectedSeats">

                <div class="mb-3">

                    <label class="mb-2">
                        Nombre completo
                    </label>

                    <input type="text"
                            class="form-control custom-input"
                            value="{{ session('user.name') }}" 
                            readonly>
                </div>

                <div class="mb-3">
                    <label class="mb-2">
                        Correo electrónico
                    </label>

                    <input type="email"
                            class="form-control custom-input"
                            value="{{ session('user.email') }}" 
                            readonly>
                </div>
                {{-- Form of details reservation --}}
                <div class="summary-box">
                        
                    <div class="summary-item">
                        <span>Tipo</span>
                        <span id="ticket-type" class="badge bg-dark">GENERAL</span>
                    </div>

                    <div class="summary-item">
                        <span>Puestos</span>
                        <span id="selected-seats"></span> {{-- Render by JavaScript --}}
                    </div>

                    <div class="summary-item">
                        <span>Cantidad</span>
                        <span id="quantity-seats"></span> {{-- Render by JavaScript --}}
                    </div>

                    <div class="summary-item">
                        <span>Servicio</span>
                        <span id="ticket-price"
                            data-price="{{ $showtime['basePrice'] }}">

                            ${{ number_format($showtime['basePrice'], 0, ',', '.') }}

                        </span>
                    </div>

                    <hr>

                    <div class="summary-total">
                        <span>Total</span>
                        <span id="total-price">{{-- Render by JavaScript --}}</span>
                    </div>

                </div>

                <button class="btn-buy">
                    Confirmar compra
                </button>

            </form>

        </div>
    </div>

</div>
<script>

    /*
    |--------------------------------------------------------------------------
    | Obtener sillas disponibles
    |--------------------------------------------------------------------------
    */

    const seats = document.querySelectorAll(
        '.seat.available'
    );

    /*
    |--------------------------------------------------------------------------
    | Array de seleccionadas
    |--------------------------------------------------------------------------
    */

    let selectedSeats = [];

    /*
    |--------------------------------------------------------------------------
    | Elementos resumen
    |--------------------------------------------------------------------------
    */

    const selectedSeatsText = document.getElementById(
        'selected-seats'
    );/* Selected seats text */

    const quantitySeatsText = document.getElementById(
        'quantity-seats'
    );/* Quantity of selected seats */

    const totalPriceText = document.getElementById(
        'total-price'
    );/* Total price of bough tickets */

    const hiddenInput = document.getElementById(
        'selectedSeats'
    );

    /*
    |--------------------------------------------------------------------------
    | Precio base
    |--------------------------------------------------------------------------
    */

    const ticketPrice = parseFloat(
        document.getElementById(
            'ticket-price'
        ).dataset.price
    );/* Price by every ticket */

    /*
    |--------------------------------------------------------------------------
    | Click silla
    |--------------------------------------------------------------------------
    */

    seats.forEach(seat => {

        seat.addEventListener('click', () => {

            /*
            |--------------------------------------------------------------------------
            | Toggle visual
            |--------------------------------------------------------------------------
            */

            seat.classList.toggle('selected');

            /*
            |--------------------------------------------------------------------------
            | Obtener id
            |--------------------------------------------------------------------------
            */

            const seatId = parseInt(
                seat.dataset.seatId
            );

            /*
            |--------------------------------------------------------------------------
            | Obtener label visual
            |--------------------------------------------------------------------------
            */

            const label = seat.innerText.trim();

            /*
            |--------------------------------------------------------------------------
            | Agregar o remover
            |--------------------------------------------------------------------------
            */

            if(
                selectedSeats.some(
                    s => s.id === seatId
                )
            ){

                selectedSeats = selectedSeats.filter(
                    s => s.id !== seatId
                );

            }else{

                selectedSeats.push({
                    id: seatId,
                    label: label
                });

            }

            /*
            |--------------------------------------------------------------------------
            | Actualizar hidden input
            |--------------------------------------------------------------------------
            */

            hiddenInput.value = JSON.stringify(
                selectedSeats.map(
                    s => s.id
                )
            );

            /*
            |--------------------------------------------------------------------------
            | Actualizar resumen sillas
            |--------------------------------------------------------------------------
            */

            selectedSeatsText.innerText = selectedSeats.length > 0
                ? selectedSeats.map(s => s.label).join(', ')
                : 'Ninguno';
            quantitySeatsText.innerText = selectedSeats.length;

            /*
            |--------------------------------------------------------------------------
            | Calcular total
            |--------------------------------------------------------------------------
            */

            const total =
                selectedSeats.length * ticketPrice;

            totalPriceText.innerText =
                '$' + total;

            /*
            |--------------------------------------------------------------------------
            | Debug
            |--------------------------------------------------------------------------
            */

            console.log(
                hiddenInput.value
            );

        });

    });

    document.addEventListener('DOMContentLoaded', () => {
        hiddenInput.value = null;
        selectedSeatsText.innerText = 'Ninguno';

        quantitySeatsText.innerText = '0';

        totalPriceText.innerText = '$0';
    });

</script>

</body>
</html>