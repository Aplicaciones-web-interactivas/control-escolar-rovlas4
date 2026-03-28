<?php

namespace App\Http\Controllers;

use App\Models\entrega_tarea;
use App\Models\tarea;
use App\Models\inscripcion;
use Illuminate\Http\Request;

class EntregaTareaController extends Controller
{
    // Subir archivo de entrega
    public function store(Request $request, $tareaId)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'alumno') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $tarea = tarea::find($tareaId);

        if (!$tarea) {
            return redirect()->route('tareas.alumno')->with('error', 'Tarea no encontrada');
        }

        // Verificar que el alumno esté inscrito en el grupo
        $inscripcion = inscripcion::where('usuario_id', $usuario->id)
            ->where('grupo_id', $tarea->grupo_id)
            ->first();

        if (!$inscripcion) {
            return redirect()->route('tareas.alumno')->with('error', 'No tienes permiso');
        }

        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Eliminar entrega anterior si existe
        entrega_tarea::where('tarea_id', $tareaId)
            ->where('usuario_id', $usuario->id)
            ->delete();

        // Guardar nuevo archivo
        $ruta = $request->file('archivo')->store('entregas', 'public');

        entrega_tarea::create([
            'tarea_id' => $tareaId,
            'usuario_id' => $usuario->id,
            'archivo' => $ruta,
            'fecha_entrega' => now(),
        ]);

        return redirect()->route('tareas.alumno.show', $tareaId)->with('success', 'Archivo enviado correctamente');
    }

    // Descargar archivo de entrega (maestro)
    public function download($id)
    {
        $usuario = auth()->user();

        if ($usuario->rol !== 'maestro') {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $entrega = entrega_tarea::find($id);

        if (!$entrega) {
            return redirect('/admin')->with('error', 'Entrega no encontrada');
        }

        // Verificar que el maestro sea el propietario de la tarea
        if ($entrega->tarea->usuario_id !== $usuario->id) {
            return redirect('/admin')->with('error', 'No tienes permiso');
        }

        $rutaArchivo = storage_path('app/public/' . $entrega->archivo);

        if (!file_exists($rutaArchivo)) {
            return redirect('/admin')->with('error', 'Archivo no encontrado');
        }

        return response()->download($rutaArchivo);
    }
}

