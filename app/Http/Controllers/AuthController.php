<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'clave_institucional' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $usuario = usuario::where('clave_institucional', $validated['clave_institucional'])->first();

        if (!$usuario || !Hash::check($validated['contraseña'], $usuario->contraseña)) {
            return back()->withErrors([
                'login' => 'Las credenciales proporcionadas no coinciden.',
            ])->onlyInput('clave_institucional');
        }

        // Verificar que el usuario esté activo
        if (!$usuario->activo) {
            return back()->withErrors([
                'login' => 'Esta cuenta ha sido desactivada.',
            ])->onlyInput('clave_institucional');
        }

        Auth::login($usuario);

        // Redirigir según el rol
        if ($usuario->rol === 'maestro') {
            return redirect()->route('tareas.maestro');
        } elseif ($usuario->rol === 'alumno') {
            return redirect()->route('tareas.alumno');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave_institucional' => 'required|string|unique:usuarios',
            'contraseña' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:maestro,alumno,usuario',
        ]);

        usuario::create([
            'nombre' => $validated['nombre'],
            'clave_institucional' => $validated['clave_institucional'],
            'contraseña' => Hash::make($validated['contraseña']),
            'rol' => $validated['rol'],
            'activo' => true,
        ]);

        return redirect()->route('login')->with('success', 'Registro completado. Por favor inicia sesión.');
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Has cerrado sesión.');
    }
}
