<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AuthService
{
    public function AuthenticateLogin(Request $request){
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        try{
            // Attempt to authenticate the user with API token
            $response = Http::post(config('services.auth_service.url').'/api/auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

        }catch(\Exception $e){
            return back()->withErrors(['error' => 'Unable to connect to authentication service.
                                        Please try again later.']);
        }
        return $response;
    }

    public function createCustomer(Request $request){
        //Validate request form
        $request->validate([
            'fullName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'password_confirmation' => 'required|string'
        ]);

        try{
            // Attempt to authenticate the user with API token
            $response = Http::post(config('services.auth_service.url').'/api/auth/register-customer', [
                'fullName' => $request['fullName'],
                'email' => $request['email'],
                'password' => $request['password']
            ]);

        }catch(\Exception $e){
            return back()->withErrors(['error' => 'Unable to connect to authentication service.
                                        Please try again later.']); 
        }
        return $response;
    }

    public function closeSession(){
        try{
            $response = Http::withToken(session('auth_token'))
            ->post(config('services.auth_service.url').'/api/auth/logout');
        }catch(\Exception $e){
            return back()->withErrors(['error' => 'Unable to connect to authentication service.
                                        Please try again later.']);
        }      
        return $response;  
    }

}