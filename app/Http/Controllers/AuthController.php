<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $response = $this->authService->AuthenticateLogin($request);

        switch ($response->status()) {
            case 200:
                // Authentication successful
                $data = $response->json();

                // Decode the JWT token to extract user information
                $payload = json_decode(base64_decode(
                    explode('.', $data['accessToken'])[1]),
                    true
                );

                // Store the token in session or cookie as needed
                session([
                    'auth_token' => $data['accessToken'],
                    'user' => [
                        'id' => $payload['sub'],
                        'email' => $payload['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress'],
                        'name' => $payload['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'],
                        'role' => $payload['http://schemas.microsoft.com/ws/2008/06/identity/claims/role'],
                    ]
                ]);
                // Redirect to dashboard or intended page
                return redirect()->intended('/')->withErrors(['success' => 'Bienvenido. '. session('user.name')]); // Redirect to dashboard or intended page
            case 401:
                // Authentication failed
                return back()->withErrors(['error' => 'Invalid email or password.']);
            default:
                // Other errors
                return back()->withErrors(['error' => 'An error occurred. Please try again.']);
        }
    }

    public function register()
    {
        return view('register');
    }

    public function createCustomer(Request $request)
    {
        $response = $this->authService->createCustomer($request);

        switch($response->status()){
            case 200:
                $data = $response->json();
                // Store the token in session or cookie as needed
                session([
                    'user' => [
                        'email' => $request['email'],
                        'name' => $request['fullName'],
                        'role' => 'customer',
                    ]
                ]);
                
                return back()->withErrors(['success' => 'Customer created successfully. Please login to continue.']);
                break;
            case 400:
                //Somenthing went wrong
                return back()->withErrors(['error' => 'Password must have at least 8 characters.'.$response->body()]);
                break;
            case 500:
                //Somenthing went wrong
                return back()->withErrors(['error' => 'Somenthing went wrong.'.$response->body()]);
                break;
            default:
                //Somenthing else went wrong
                return back()->withErrors(['error' => 'Somenthing else went wrong.'.$response->body()]);
                break;
        }
        
    }

    public function logout()
    {
        $response = $this->authService->closeSession();

        // Clear the authentication token from session
        session()->forget(['auth_token', 'user']);

        switch($response->status()){
            case 200:
                    // Logout successful
                    return redirect()->route('welcome')->withErrors(['success' => 'Session cerrada exitosamente.']);
                break;
            case 401:
                // Unauthorized, token might be invalid or expired
                return back()->withErrors(['error' => 'Unauthorized. Please login again.']);
                break;
            default:
                // Logout failed, but we will clear the session anyway
                return back()->withErrors(['error' => 'Unable to connect to authentication service.
                                        Please try again later.']);
                break;
        }

    }


}
