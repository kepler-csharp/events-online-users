<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    //
    public function index()
    {
        return view('welcome');
    }

    public function showEvents()
    {
        try {
            $events = Http::get(config('services.auth_service.url').'/api/events');
            $showtimes = Http::get(config('services.auth_service.url').'/api/showtimes');

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error fetching events: '.$e->getMessage(),
            ], 500);
        }

        if ($events->successful() && $showtimes->successful()) {
            // Validate the date of startTime of showtimes to be greater than the current date
            $events = $events->json()['data']['items'];
            $showtimes = $showtimes->json()['data']['items'];
            /*             dd(collect($events)->where('isActive', true), collect($showtimes)->where('availableSeats', '>', 0)); */

            // Take the next showtime with available seats and the event of that showtime
            usort($showtimes, function ($a, $b) {
                return strtotime($a['startTime']) <=> strtotime($b['startTime']);
            });

            $featuredShowtime = $showtimes[1] ?? null;

            $featuredEvent = collect($events)
                ->firstWhere('id', $featuredShowtime['eventId'] ?? null);

            /* dd($featuredEvent, $featuredShowtime, $events, $showtimes); */
            /* dd($featuredEvent, $featuredShowtime, $events, $showtimes); */
            return view('welcome', compact(
                'events', // all events general
                'showtimes', // all showtimes of her event
                'featuredEvent', // the event of the next showtime
                'featuredShowtime' // the next showtime
            ));
        }

        return response()->json([
            'error' => 'Failed to fetch events',
        ], $events->status());
    }

    public function showEventDetails($id)
    {
        try {
            $event = Http::get(config('services.auth_service.url').'/api/events/'.$id);
            $showtime = Http::get(config('services.auth_service.url').'/api/showtimes/'.$id);
            $seats = Http::get(config('services.auth_service.url').'/api/showtimes/'.$id.'/seats');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching event details: '.$e->getMessage()], 500);
        }

        if ($event->status() === 200) {
            $event = $event->json()['data'];
            $showtime = $showtime->json()['data'];
            $seats = $seats->json()['data'];

            return view('events.show', compact('event', 'showtime', 'seats'));

        } else {
            return response()->json(['error' => 'Failed to fetch event details'], $event->status());
        }
    }

    /* Validated and Send the user to the payment page */
    public function paymentSeats(Request $request, $idShowTime)
    {
        $seatIds = json_decode($request->input('seats'), true); // "[20]" → [20]
        $seatIds = array_map('intval', (array) $seatIds);       // garantiza ints

        if (empty($seatIds)) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Selecciona al menos una silla.']);
        }

        return $this->reserveSeats($idShowTime, $seatIds);
    }

    /* Make reservation for the system */
    /* Logic to reserve seats using the auth service API */
    public function reserveSeats($idShowTime, array $seatIds)
    {
        // Take the reservation data to the session for later use in case of payment failure or timeout
        session()->put(
            'reservation_data',
            [
                'idShowTime' => $idShowTime,
                'seatIds' => $seatIds,
                now()->addSeconds(120), // Expired in 2 minutes
            ]
        );

        // Change way to reserve: wait the pay and then act
        return $this->showPaymentPage($idShowTime, $seatIds);

        /*
        try {
            $response = Http::withToken(session('auth_token'))
                ->asJson()                                        // ← Content-Type: application/json
                ->post(config('services.auth_service.url').'/api/seats/reserve', [
                    'showtimeId' => (int) $idShowTime,           // int, no string
                    'seatIds' => $seatIds,                    // [20], no ["[20]"]
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occupating seat: '.$e->getMessage());
        }
        */

        // Refactoring This
        /*         dd(
                    $response->status(),
                    $response->json(),
                    $response->body()
                ); */

        /*         if ($response->status() === 200) {
                    $seatsEncoded = json_encode($seatIds);

                    return redirect()
                        ->route('payment.event', [
                            'idShowTime' => $idShowTime,
                            'seats' => $seatsEncoded,
                        ])
                        ->with('success', 'Reservación exitosa!');
                } */

        /*         return redirect()->back()->with('error',
                    $response->json()['message'] ?? 'Fallo al reservar asientos.'
                ); */
    }

    public function showPaymentPage($idShowTime, $seatsEncoded)
    {
        // Logic to show the payment page with the event and showtime details and the seats selected
        try {
            $responseShowTime = Http::withToken(session('auth_token'))
                ->get(config('services.auth_service.url').'/api/showtimes/'.$idShowTime);

            if ($responseShowTime->status() === 200) {
                try {
                    $responseEvent = Http::withToken(session('auth_token'))
                        ->get(config('services.auth_service.url').'/api/events/'.$responseShowTime->json()['data']['eventId']);

                    if ($responseEvent->status() === 200) {
                        $event = $responseEvent->json()['data'];
                        $showtime = $responseShowTime->json()['data'];
                        $seats = $seatsEncoded;

                        return view('payment.event', compact('event', 'showtime', 'seats'));

                    } else {
                        return response()->json(['error' => 'Failed to fetch event details'], $responseEvent->status());
                    }

                } catch (\Exception $e) {
                    return response()->json(['error' => 'Error fetching showtime details: '.$e->getMessage()], 500);
                }

            } else {
                return response()->json(['error' => 'Failed to fetch showtime details'], $responseShowTime->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error showing payment page: '.$e->getMessage()], 500);
        }

    }

    public function processOrder(Request $request)
    {

        $seats = $request->input('seats');
        $seatIds = array_map('intval', explode(',', $seats)); // [60, 59]
        /*         dd($seatIds, $seats); */
        // First make a register of the order with the auth service and then process the payment
        try {
            $responseResev = Http::withToken(session('auth_token'))
                ->asJson()                                        // ← Content-Type: application/json
                ->post(config('services.auth_service.url').'/api/seats/reserve', [
                    'showtimeId' => (int) $request->input('idShowTime'),           // int, no string
                    'seatIds' => $seatIds,                    // [20], no ["[20]"]
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occupating seat: '.$e->getMessage());
        }

        // We validate the reservation and if it is not successful we try to create the order without reservation, this is for the case that the reservation expires or the user takes too long to pay and the reservation is released, but we want to give them a chance to pay without reservation if they really want to, but if the seats are already reserved by someone else or sold we will show an error message in the payment page when they try to pay
        if ($responseResev->successful()) {

            // Set the data seats reservation to create order without pay until
            try {
                $response = Http::withToken(session('auth_token'))
                    ->post(config('services.auth_service.url').'/api/orders', [
                        'seatIds' => $seatIds,
                    ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Upss... Hubo un error al intentarlo');
            }

            // We validate the order creation and if it is successful we process the payment with the order id, if not we show an error message in the payment page
            if ($response->successful()) {
                $data = $response->json()['data'];

                return $this->processPay($data['id'], 'Completed');

            } else {

                return redirect()->route('dashboard')->with('error', 'Error procesando el pago: '.$response->json() ?? 'Fallo al procesar el pago el asiento ya fue reservado o esta en proceso.');
            }

        } else {
            return $this->processPay($responseResev->json()['data']['orderId'], 'Failed');
        }
    }

    public function processPay($orderId, $methodPayment)
    {
        /* dd($orderId, $methodPayment); */
        try {
            $response = Http::withToken(session('auth_token'))
                ->post(config('services.auth_service.url').'/api/orders/pay', [
                    'orderId' => $orderId,
                    'paymentMethod' => $methodPayment,
                ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Upss algo sucedio mal:'.$e->getMessage());
        }

        if ($response->successful()) {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Pago procesado exitosamente!');
        }
    }

    public function dashboardPage()
    {
        try {
            $response = Http::withToken(session('auth_token'))
                ->get(config('services.auth_service.url').'/api/orders/');
        } catch (\Exception $e) {
            return view('users.dashboard')->with('error', 'Error de conexión: '.$e->getMessage());
        }

        // 3. Usar successful() es más seguro ya que cubre códigos 200, 201, etc.
        if ($response->successful()) {
            $data = $response->json()['data']['items'] ?? []; // Evita errores si 'data' no viene en la respuesta

            /*  dd($data); */
            return view('users.dashboard', compact('data'));

        } else {
            // Si el estado no es exitoso (ej. token expirado o 401), pasamos el error a la vista
            $data = [];

            return view('users.dashboard', compact('data'))->with('error', 'No se pudieron cargar las órdenes.');
        }
    }
}
