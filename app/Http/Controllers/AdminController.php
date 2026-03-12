<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexAdmin()
    {        
        return view('admin.dashboard');
    }

    public function indexMaterias()
    {
        $materias = Materia::all();
        return view('admin.materias', compact('materias'));
    }

    public function saveMateria(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|unique:materias|max:50',
        ]);

        Materia::create($validated);

        return redirect()->route('admin.materias')->with('success', 'Materia creada exitosamente!');
    }
}