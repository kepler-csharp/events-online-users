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

    public function reserveSeats(Request $request, $idShowTime)
    {
        /* Convert JSON string to array */
        $seatIds = json_decode($request->input('seats'), true);
        
        if(!$seatIds || !$request->json()){
            return redirect()
                ->back()
                ->withErrors(['error' => 'Selecciona al menos una silla.']);
        }

        try{
            $response = Http::withToken(session('auth_token'))
            ->post(config('services.auth_service.url') . '/api/seats/reserve', [
                'showtimeId' => $idShowTime,
                'seatIds' => $seatIds,
            ]);
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Error reserving seats: ' . $e->getMessage()], 500);
        }

        dd($response->status(), $response->body(), $request->json());

        if($response->status() === 200){
            return redirect()->route('dashboard')->with('success', 'Seats reserved successfully!');
        }else{
            return redirect()->back()->with('error', 'Failed to reserve seats: ' . $response->json()['message']);
        }
    }
}
