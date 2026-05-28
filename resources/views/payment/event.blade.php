<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago — {{ config('app.name', 'TicketNow') }}</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;700&display=swap"
          rel="stylesheet">
   @vite('resources/css/paymentEvent.css')

</head>
<body>

<div class="payment-wrapper">

    <div class="payment-layout">

        <!-- LEFT -->
        <div class="payment-card">

            <h1 class="page-title">
                Finalizar pago
            </h1>

            <p class="page-subtitle">
                Completa tu compra de manera segura.
            </p>

            <!-- PAYMENT METHODS -->
            <h3 class="section-title">
                Método de pago
            </h3>

            <div class="payment-methods">

                <div class="payment-method active">
                    <i class="bi bi-credit-card-2-front"></i>

                    <h5>Tarjeta</h5>

                    <p>Visa, Mastercard</p>
                </div>

                <div class="payment-method">
                    <i class="bi bi-bank"></i>

                    <h5>PSE</h5>

                    <p>Pago bancario</p>
                </div>

                <div class="payment-method">
                    <i class="bi bi-phone"></i>

                    <h5>Nequi</h5>

                    <p>Billetera digital</p>
                </div>

            </div>

            <!-- FORM -->
            <form action="{{ route('payment.process', $showtime['id']) }}" method="POST" class="payment-form">

                <div class="form-grid">
                    <input type="hidden" name="seats" value="{{ implode(', ', $seats) }}">
                    <input type="hidden" name="idShowTime" value="{{ $showtime['id'] }}">
                    <div class="form-group full">
                        <label>
                            Nombre del titular
                        </label>

                        <input type="text"
                               class="custom-input"
                               placeholder="Nombre completo"
                               value="{{ session('user.name') }}">
                    </div>

                    <div class="form-group full">
                        <label>
                            Número de tarjeta
                        </label>

                        <input type="text"
                               class="custom-input"
                               placeholder="1234 5678 9012 3456">
                    </div>

                    <div class="form-group">
                        <label>
                            Fecha expiración
                        </label>

                        <input type="text"
                               class="custom-input"
                               placeholder="MM/YY">
                    </div>

                    <div class="form-group">
                        <label>
                            CVV
                        </label>

                        <input type="password"
                               class="custom-input"
                               placeholder="***">
                    </div>

                </div>

                <button class="pay-btn">
                    Pagar ahora
                </button>

                <div class="secure-payment">
                    <i class="bi bi-shield-lock-fill"></i>
                    Pago 100% seguro y cifrado
                </div>

            </form>

        </div>

        <!-- RIGHT -->
        <div class="summary-card">

            <h3 class="summary-title">
                Resumen
            </h3>

            <div class="event-preview">

                <img src="{{ $event['posterUrl'] }}">

                <div class="event-info">

                    <h4>
                        {{ $event['name'] }}
                    </h4>

                    <p>
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($showtime['startTime'])->format('d M Y') }}
                    </p>

                    <p>
                        <i class="bi bi-geo-alt"></i>
                        {{ $event['venueName'] }}
                    </p>

                </div>

            </div>

            <div class="summary-box">

                <div class="summary-item">
                    <span>Entradas</span>
                    <span>{{ count($seats) }}</span>
                </div>

                <div class="summary-item">
                    <span>Puestos</span>
                    <span>{{ implode(', ', $seats) }}</span>
                </div>

                <div class="summary-item">
                    <span>Servicio</span>
                    <span>{{ $showtime['basePrice'] }}</span>
                </div>

                <hr style="border-color: rgba(255,255,255,.08);">

                <div class="summary-total">
                    <span>Total</span>
                    <span>${{ number_format($showtime['basePrice'] * count($seats)) }}</span>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>