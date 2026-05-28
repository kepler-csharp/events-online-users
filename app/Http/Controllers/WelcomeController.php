<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        try{
            $events = Http::get(config('services.auth_service.url') . '/api/events');

        }catch(\Exception $e){
            return response()->json(['error' => 'Error fetching events: ' . $e->getMessage()], 500);
        }
        
        if($events->status() === 200){
            
            $events = $events->json()['data']['items'];
           
            return view('welcome', compact('events'));
        }else{
            return response()->json(['error' => 'Failed to fetch events'], $events->status());
        }   
        
    }

    public function showEventDetails($id)
    {
        try{
            $event = Http::get(config('services.auth_service.url') . '/api/events/' . $id);
            $showtime = Http::get(config('services.auth_service.url') . '/api/showtimes/' . $id);
            $seats = Http::get(config('services.auth_service.url') . '/api/showtimes/' . $id.'/seats');
            }catch(\Exception $e){
            return response()->json(['error' => 'Error fetching event details: ' . $e->getMessage()], 500);
        }
        
        if($event->status() === 200){
            $event = $event->json()['data'];
            $showtime = $showtime->json()['data'];
            $seats = $seats->json()['data'];

            return view('events.show', compact('event', 'showtime', 'seats'));

        }else{
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
        try {
            $response = Http::withToken(session('auth_token'))
                ->asJson()                                        // ← Content-Type: application/json
                ->post(config('services.auth_service.url') . '/api/seats/reserve', [
                    'showtimeId' => (int) $idShowTime,           // int, no string
                    'seatIds'    => $seatIds,                    // [20], no ["[20]"]
                ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occupating seat: ' . $e->getMessage());
        }

        /*         dd(
            $response->status(),
            $response->json(),
            $response->body()
        ); */

        if ($response->status() === 200) {
            $seatsEncoded = json_encode($seatIds);
            return redirect()
                ->route('payment.event', [
                    'idShowTime' => $idShowTime,
                    'seats'      => $seatsEncoded,
                ])
                ->with('success', 'Reservación exitosa!');
        }

        return redirect()->back()->with('error', 
            $response->json()['message'] ?? 'Fallo al reservar asientos.'
        );
    }

    public function showPaymentPage($idShowTime, $seatsEncoded)
    {
        try{
            $responseShowTime = Http::withToken(session('auth_token'))
            ->get(config('services.auth_service.url') . '/api/showtimes/' . $idShowTime);

            if($responseShowTime->status() === 200){
                try{
                    $responseEvent = Http::withToken(session('auth_token'))
                    ->get(config('services.auth_service.url') . '/api/events/' . $responseShowTime->json()['data']['eventId']); 

                    if($responseEvent->status() === 200){
                        $event = $responseEvent->json()['data'];
                        $showtime = $responseShowTime->json()['data'];
                        $seats = json_decode($seatsEncoded);
                        return view('payment.event', compact('event', 'showtime', 'seats'));

                    }else{
                        return response()->json(['error' => 'Failed to fetch event details'], $responseEvent->status());
                    }
                
                }catch(\Exception $e){
                    return response()->json(['error' => 'Error fetching showtime details: ' . $e->getMessage()], 500);
                }

            }else{
                return response()->json(['error' => 'Failed to fetch showtime details'], $responseShowTime->status());  
            }
        }catch(\Exception $e){
            return response()->json(['error' => 'Error showing payment page: ' . $e->getMessage()], 500);
        }

    }

    public function processOrder(Request $request)
    {
        $seats = $request->input('seats');
        $seatIds = array_map('intval', explode(',', $seats)); // [60, 59]

        try{
            $response = Http::withToken(session('auth_token'))
                ->post(config('services.auth_service.url') . '/api/orders', [
                    'seatIds' => $seatIds,
                ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Upss... Hubo un error al intentarlo');
        }
        
        if($response->successful()){
            $data = $response->json()['data'];
            return $this->processPay($data['id'], 'Completed');
        }else{
            return redirect()->route('events')->with('error', 'Error procesando el pago: ' . $response->json()['message']);
        }
    }

    public function processPay($orderId, $methodPayment){
        /* dd($orderId, $methodPayment); */
        try{
            $response = Http::withToken(session('auth_token'))
            ->post(config('services.auth_service.url').'/api/orders/pay', [
                'orderId'=> $orderId,
                'paymentMethod' => $methodPayment
            ]);
        }catch(\Exception $e){
            return back()->with('error', 'Upss algo sucedio mal:'. $e->getMessage());
        }

        if($response->successful()){
            return redirect()
            ->route('dashboard')
            ->with('success', 'Pago procesado exitosamente!');
        }
    }


}
