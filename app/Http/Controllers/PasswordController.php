<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordController extends Controller
{
    // Paso 1 - Mostrar form de email
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Paso 2 - Enviar email a la API
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Http::post(config('services.auth_service.url').'/api/auth/forgot-password', [
            'email' => $request->email,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Te enviamos un correo con las instrucciones para recuperar tu contraseña.');
        }

        return back()->with('error', 'No encontramos una cuenta con ese correo.');
    }

    // Paso 3 - Mostrar form de nueva contraseña con el token
    public function showResetForm(Request $request)
    {
        if (!$request->has('token')) {
            return redirect()->route('password.forgot')
                ->with('error', 'El enlace de recuperación no es válido.');
        }

        return view('auth.reset-password', [
            'token' => $request->token,
        ]);
    }

    // Paso 4 - Enviar nueva contraseña a la API
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'                 => 'required',
            'newPassword'           => 'required|min:8|confirmed',
        ]);

        $response = Http::post(config('services.auth_service.url').'/api/auth/reset-password', [
            'token'       => $request->token,
            'newPassword' => $request->newPassword,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')
                ->with('success', 'Contraseña actualizada correctamente. Ya puedes iniciar sesión.');
        }

        return back()->with('error', 'El enlace expiró o no es válido. Solicita uno nuevo.');
    }
}