<?php

namespace App\Http\Controllers;

use App\Models\tarea;
use App\Models\grupo;
use App\Models\inscripcion;
use App\Models\entrega_tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    // Mostrar tareas del maestro
    public function indexMaestro()
    {
        $usuario = auth()->user();

        // Revisar que sea maestro
        if ($usuario->rol !== 'maestro') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $tareas = tarea::where('usuario_id', $usuario->id)->get();

        return view('admin.tareas.index', compact('tareas'));
    }

    // Mostrar formulario para crear tarea
    public function create()
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'maestro') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $grupos = grupo::all();

        return view('admin.tareas.create', compact('grupos'));
    }

    // Guardar tarea
    public function store(Request $request)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'maestro') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'grupo_id' => 'required|exists:grupos,id',
            'fecha_entrega' => 'required|date',
        ]);

        tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'grupo_id' => $request->grupo_id,
            'usuario_id' => $usuario->id,
            'fecha_entrega' => $request->fecha_entrega,
        ]);

        return redirect()->route('tareas.maestro')->with('success', 'Tarea creada correctamente');
    }

    // Mostrar tareas del alumno
    public function indexAlumno()
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'alumno') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        // Obtener grupos del alumno
        $grupos = inscripcion::where('usuario_id', $usuario->id)->pluck('grupo_id');

        // Obtener tareas de esos grupos
        $tareas = tarea::whereIn('grupo_id', $grupos)->get();

        return view('alumno.tareas.index', compact('tareas'));
    }

    // Ver detalle de tarea (alumno)
    public function show($id)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'alumno') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $tarea = tarea::find($id);

        if (!$tarea) {
            return redirect()->route('tareas.alumno')->with('error', 'Tarea no encontrada');
        }

        // Verificar que la tarea sea de un grupo del alumno
        $gruposAlumno = inscripcion::where('usuario_id', $usuario->id)->pluck('grupo_id');

        if (!$gruposAlumno->contains($tarea->grupo_id)) {
            return redirect()->route('tareas.alumno')->with('error', 'No tienes permiso');
        }

        $entrega = entrega_tarea::where('tarea_id', $id)->where('usuario_id', $usuario->id)->first();

        return view('alumno.tareas.show', compact('tarea', 'entrega'));
    }

    // Mostrar entregas de una tarea (maestro)
    public function showEntregas($id)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'maestro') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $tarea = tarea::find($id);

        if (!$tarea || $tarea->usuario_id !== $usuario->id) {
            return redirect()->route('tareas.maestro')->with('error', 'No tienes permiso');
        }

        $entregas = entrega_tarea::where('tarea_id', $id)->get();

        return view('admin.tareas.entregas', compact('tarea', 'entregas'));
    }
}

