<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\usuario;
use App\Models\inscripcion;
use App\Models\horario;
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

    public function indexHorarios()
    {
        $horarios = horario::with(['materia', 'maestro'])->get();
        $materias = Materia::all();
        $maestros = usuario::where('activo', true)->get();
        
        return view('admin.horarios', compact('horarios', 'materias', 'maestros'));
    }

    public function saveHorario(Request $request)
    {
        $validated = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'maestro_id' => 'required|exists:usuarios,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'dias_arr' => 'required|array|min:1',
        ]);

        $dias = implode(',', $validated['dias_arr']);

        horario::create([
            'materia_id' => $validated['materia_id'],
            'maestro_id' => $validated['maestro_id'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fin' => $validated['hora_fin'],
            'dias' => $dias,
        ]);

        return redirect()->route('admin.horarios')->with('success', 'Horario creado exitosamente!');
    }
}