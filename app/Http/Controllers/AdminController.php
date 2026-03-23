<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\usuario;
use App\Models\inscripcion;
use App\Models\horario;
use App\Models\grupo;
use App\Models\calificacion;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexAdmin()
    {        
        $cantmaterias = Materia::count();
        $canthorarios = horario::count();
        $cantgrupos = grupo::count();
        $cantestudiantes = usuario::where('activo', true)->count();
        $cantcalificaciones = calificacion::count();
        return view('admin.dashboard', compact('cantmaterias', 'canthorarios', 'cantgrupos', 'cantestudiantes', 'cantcalificaciones'));
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

    public function editMateria($id)
    {
        $materia = Materia::findOrFail($id);
        return view('admin.materias-edit', compact('materia'));
    }

    public function updateMateria(Request $request, $id)
    {
        $materia = Materia::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'clave' => 'required|string|max:50|unique:materias,clave,' . $id,
        ]);

        $materia->update($validated);

        return redirect()->route('admin.materias')->with('success', 'Materia actualizada exitosamente!');
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

    public function editHorario($id)
    {
        $horario = horario::findOrFail($id);
        $materias = Materia::all();
        $maestros = usuario::where('activo', true)->get();
        return view('admin.horarios-edit', compact('horario', 'materias', 'maestros'));
    }

    public function updateHorario(Request $request, $id)
    {
        $horario = horario::findOrFail($id);
        
        $validated = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'maestro_id' => 'required|exists:usuarios,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'dias_arr' => 'required|array|min:1',
        ]);

        $dias = implode(',', $validated['dias_arr']);

        $horario->update([
            'materia_id' => $validated['materia_id'],
            'maestro_id' => $validated['maestro_id'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fin' => $validated['hora_fin'],
            'dias' => $dias,
        ]);

        return redirect()->route('admin.horarios')->with('success', 'Horario actualizado exitosamente!');
    }

    public function indexGrupos()
    {
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        $horarios = horario::with(['materia', 'maestro'])->get();
        
        return view('admin.grupos', compact('grupos', 'horarios'));
    }

    public function saveGrupo(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        grupo::create($validated);

        return redirect()->route('admin.grupos')->with('success', 'Grupo creado exitosamente!');
    }

    public function editGrupo($id)
    {
        $grupo = grupo::findOrFail($id);
        $horarios = horario::with(['materia', 'maestro'])->get();
        return view('admin.grupos-edit', compact('grupo', 'horarios'));
    }

    public function updateGrupo(Request $request, $id)
    {
        $grupo = grupo::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        $grupo->update($validated);

        return redirect()->route('admin.grupos')->with('success', 'Grupo actualizado exitosamente!');
    }

    public function indexCalificaciones()
    {
        $calificaciones = calificacion::with(['usuario', 'grupo.horario.materia', 'grupo.horario.maestro'])->get();
        $usuarios = usuario::all();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        
        return view('admin.calificaciones', compact('calificaciones', 'usuarios', 'grupos'));
    }

    public function saveCalificacion(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'grupo_id' => 'required|exists:grupos,id',
            'calificacion' => 'required|integer|min:0|max:100',
        ]);

        calificacion::create($validated);

        return redirect()->route('admin.calificaciones')->with('success', 'Calificación creada exitosamente!');
    }

    public function editCalificacion($id)
    {
        $calificacion = calificacion::findOrFail($id);
        $usuarios = usuario::all();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        return view('admin.calificaciones-edit', compact('calificacion', 'usuarios', 'grupos'));
    }

    public function updateCalificacion(Request $request, $id)
    {
        $calificacion = calificacion::findOrFail($id);
        
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'grupo_id' => 'required|exists:grupos,id',
            'calificacion' => 'required|integer|min:0|max:100',
        ]);

        $calificacion->update($validated);

        return redirect()->route('admin.calificaciones')->with('success', 'Calificación actualizada exitosamente!');
    }

    public function indexInscripciones()
    {
        $inscripciones = inscripcion::with(['usuario', 'grupo.horario.materia'])->get();
        $usuarios = usuario::where('activo', true)->get();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        
        return view('admin.inscripciones', compact('inscripciones', 'usuarios', 'grupos'));
    }

    public function saveInscripcion(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $existe = inscripcion::where('usuario_id', $validated['usuario_id'])
                              ->where('grupo_id', $validated['grupo_id'])
                              ->exists();
        
        if ($existe) {
            return redirect()->route('admin.inscripciones')->with('error', 'Este estudiante ya está inscrito en este grupo!');
        }

        inscripcion::create($validated);

        return redirect()->route('admin.inscripciones')->with('success', 'Inscripción creada exitosamente!');
    }

    public function editInscripcion($id)
    {
        $inscripcion = inscripcion::findOrFail($id);
        $usuarios = usuario::where('activo', true)->get();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        return view('admin.inscripciones-edit', compact('inscripcion', 'usuarios', 'grupos'));
    }

    public function updateInscripcion(Request $request, $id)
    {
        $inscripcion = inscripcion::findOrFail($id);
        
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        // Verificar que no exista inscripción duplicada (excepto la actual)
        $existe = inscripcion::where('usuario_id', $validated['usuario_id'])
                              ->where('grupo_id', $validated['grupo_id'])
                              ->where('id', '!=', $id)
                              ->exists();
        
        if ($existe) {
            return redirect()->route('admin.inscripciones')->with('error', 'Este estudiante ya está inscrito en este grupo!');
        }

        $inscripcion->update($validated);

        return redirect()->route('admin.inscripciones')->with('success', 'Inscripción actualizada exitosamente!');
    }

    public function deleteInscripcion($id)
    {
        $inscripcion = inscripcion::findOrFail($id);
        $inscripcion->delete();

        return redirect()->route('admin.inscripciones')->with('success', 'Inscripción eliminada exitosamente!');
    }

    public function getEstudiantesPorGrupo($grupoId)
    {
        $estudiantes = inscripcion::where('grupo_id', $grupoId)
                                  ->with('usuario')
                                  ->get()
                                  ->map(function ($inscripcion) {
                                      return [
                                          'id' => $inscripcion->usuario->id,
                                          'nombre' => $inscripcion->usuario->nombre
                                      ];
                                  });

        return response()->json($estudiantes);
    }
}
