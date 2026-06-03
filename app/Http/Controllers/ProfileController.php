<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // ← esta línea faltaba

class ProfileController extends Controller
{
    public function index(){
        return view('users.profile');
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $response = Http::withToken(session('auth_token'))
            ->attach(
                'file',
                file_get_contents($request->file('image')->getRealPath()),
                $request->file('image')->getClientOriginalName()
            )
            ->post(config('services.auth_service.url').'/api/auth/upload-photo');

        $responseMe = Http::withToken(session('auth_token'))
                        ->get(config('services.auth_service.url').'/auth/me');
        

        if ($response->successful() && $responseMe) {
            session(['user.photo' => $response->json()['photoUrl']]);
            return back()->with('success', 'Imagen actualizada correctamente');
        }

        return back()->with('error', 'Error al actualizar la imagen');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|min:6',
            'newPassword'     => 'required|min:6|confirmed',
        ]);

        $response = Http::withToken(session('auth_token'))
            ->put(config('services.auth_service.url').'/api/auth/change-password', [
                'currentPassword' => $request->currentPassword,
                'newPassword'     => $request->newPassword,
            ]);

        if ($response->successful()) {
            return back()->with('success', 'Contraseña actualizada correctamente');
        }

        return back()->with('error', 'Contraseña actual incorrecta');
    }
}
