<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\usuario;
use App\Models\inscripcion;
use App\Models\horario;
use App\Models\grupo;
use App\Models\calificacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexAdmin()
    {        
        $cantmaterias = Materia::count();
        $canthorarios = horario::count();
        $cantgrupos = grupo::count();
        $cantusuarios = usuario::where('activo', true)->count();
        $cantcalificaciones = calificacion::count();
        $sesionesActivas = DB::table('sessions')->whereNotNull('user_id')->count();
        return view('admin.dashboard', compact('cantmaterias', 'canthorarios', 'cantgrupos', 'cantusuarios', 'cantcalificaciones', 'sesionesActivas'));
    }

    public function indexMaterias(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = Materia::query();
        
        if ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('clave', 'like', "%{$search}%");
        }
        
        $materias = $query->paginate(10)->appends($request->query());
        
        return view('admin.materias', compact('materias', 'search'));
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

    public function indexHorarios(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = horario::with(['materia', 'maestro']);
        
        if ($search) {
            $query->whereHas('materia', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('maestro', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }
        
        $horarios = $query->paginate(10)->appends($request->query());
        $materias = Materia::all();
        $maestros = usuario::where('activo', true)->get();
        
        return view('admin.horarios', compact('horarios', 'materias', 'maestros', 'search'));
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

    public function indexGrupos(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = grupo::with(['horario.materia', 'horario.maestro']);
        
        if ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhereHas('horario.materia', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
        }
        
        $grupos = $query->paginate(10)->appends($request->query());
        $horarios = horario::with(['materia', 'maestro'])->get();
        
        return view('admin.grupos', compact('grupos', 'horarios', 'search'));
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

    public function indexCalificaciones(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = calificacion::with(['usuario', 'grupo.horario.materia', 'grupo.horario.maestro']);
        
        if ($search) {
            $query->whereHas('usuario', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('grupo', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('grupo.horario.materia', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }
        
        $calificaciones = $query->paginate(10)->appends($request->query());
        $usuarios = usuario::all();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        
        return view('admin.calificaciones', compact('calificaciones', 'usuarios', 'grupos', 'search'));
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

    public function indexInscripciones(Request $request)
    {
        $search = $request->query('search', '');
        
        $query = inscripcion::with(['usuario', 'grupo.horario.materia']);
        
        if ($search) {
            $query->whereHas('usuario', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('grupo', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })->orWhereHas('grupo.horario.materia', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }
        
        $inscripciones = $query->paginate(10)->appends($request->query());
        $usuarios = usuario::where('activo', true)->get();
        $grupos = grupo::with(['horario.materia', 'horario.maestro'])->get();
        
        return view('admin.inscripciones', compact('inscripciones', 'usuarios', 'grupos', 'search'));
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
