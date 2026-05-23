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
}
