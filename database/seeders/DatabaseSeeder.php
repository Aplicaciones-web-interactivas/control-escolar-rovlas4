<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\usuario;
use App\Models\materia;
use App\Models\horario;
use App\Models\grupo;
use App\Models\inscripcion;
use App\Models\tarea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios de prueba
        $maestro = usuario::create([
            'nombre' => 'Juan Pérez',
            'clave_institucional' => 'maestro001',
            'contraseña' => Hash::make('123456'),
            'rol' => 'maestro',
            'activo' => true,
        ]);

        $maestro2 = usuario::create([
            'nombre' => 'María García',
            'clave_institucional' => 'maestro002',
            'contraseña' => Hash::make('123456'),
            'rol' => 'maestro',
            'activo' => true,
        ]);

        $alumno1 = usuario::create([
            'nombre' => 'Carlos López',
            'clave_institucional' => 'alumno001',
            'contraseña' => Hash::make('123456'),
            'rol' => 'alumno',
            'activo' => true,
        ]);

        $alumno2 = usuario::create([
            'nombre' => 'Ana Martínez',
            'clave_institucional' => 'alumno002',
            'contraseña' => Hash::make('123456'),
            'rol' => 'alumno',
            'activo' => true,
        ]);

        $alumno3 = usuario::create([
            'nombre' => 'Pedro Rodríguez',
            'clave_institucional' => 'alumno003',
            'contraseña' => Hash::make('123456'),
            'rol' => 'alumno',
            'activo' => true,
        ]);

        $usuario = usuario::create([
            'nombre' => 'Admin General',
            'clave_institucional' => 'admin001',
            'contraseña' => Hash::make('123456'),
            'rol' => 'usuario',
            'activo' => true,
        ]);

        // Crear materias
        $mate = materia::create([
            'nombre' => 'Matemáticas',
            'clave' => 'MAT101',
        ]);

        $español = materia::create([
            'nombre' => 'Español',
            'clave' => 'ESP101',
        ]);

        $ciencias = materia::create([
            'nombre' => 'Ciencias',
            'clave' => 'CIE101',
        ]);

        // Crear horarios
        $horario1 = horario::create([
            'materia_id' => $mate->id,
            'maestro_id' => $maestro->id,
            'hora_inicio' => '08:00',
            'hora_fin' => '09:30',
            'dias' => 'Lunes, Miércoles, Viernes',
        ]);

        $horario2 = horario::create([
            'materia_id' => $español->id,
            'maestro_id' => $maestro2->id,
            'hora_inicio' => '09:45',
            'hora_fin' => '11:15',
            'dias' => 'Martes, Jueves',
        ]);

        $horario3 = horario::create([
            'materia_id' => $ciencias->id,
            'maestro_id' => $maestro2->id,
            'hora_inicio' => '14:00',
            'hora_fin' => '15:30',
            'dias' => 'Lunes, Miércoles, Viernes',
        ]);

        // Crear grupos
        $grupo1 = grupo::create([
            'nombre' => '3A',
            'horario_id' => $horario1->id,
        ]);

        $grupo2 = grupo::create([
            'nombre' => '3B',
            'horario_id' => $horario2->id,
        ]);

        $grupo3 = grupo::create([
            'nombre' => '4A',
            'horario_id' => $horario3->id,
        ]);

        // Inscribir alumnos en grupos
        inscripcion::create([
            'usuario_id' => $alumno1->id,
            'grupo_id' => $grupo1->id,
        ]);

        inscripcion::create([
            'usuario_id' => $alumno2->id,
            'grupo_id' => $grupo1->id,
        ]);

        inscripcion::create([
            'usuario_id' => $alumno3->id,
            'grupo_id' => $grupo1->id,
        ]);

        inscripcion::create([
            'usuario_id' => $alumno1->id,
            'grupo_id' => $grupo2->id,
        ]);

        inscripcion::create([
            'usuario_id' => $alumno2->id,
            'grupo_id' => $grupo3->id,
        ]);

        // Crear tareas
        tarea::create([
            'titulo' => 'Ejercicios de Álgebra',
            'descripcion' => 'Resuelve los ejercicios 1-10 de la página 45 del libro. Debes entregar un PDF con tus soluciones paso a paso.',
            'grupo_id' => $grupo1->id,
            'usuario_id' => $maestro->id,
            'fecha_entrega' => now()->addDays(3),
        ]);

        tarea::create([
            'titulo' => 'Análisis de Novela',
            'descripcion' => 'Lee el capítulo 5 de "Don Quijote" y realiza un análisis crítico. Máximo 5 páginas en PDF.',
            'grupo_id' => $grupo2->id,
            'usuario_id' => $maestro2->id,
            'fecha_entrega' => now()->addDays(5),
        ]);

        tarea::create([
            'titulo' => 'Proyecto de Biología',
            'descripcion' => 'Investiga sobre el ciclo de vida de las plantas. Presenta un resumen en PDF con imágenes y explicaciones.',
            'grupo_id' => $grupo3->id,
            'usuario_id' => $maestro2->id,
            'fecha_entrega' => now()->addDays(7),
        ]);

        tarea::create([
            'titulo' => 'Problemas Avanzados',
            'descripcion' => 'Resuelve los problemas de la sección de desafíos. Incluye el procedimiento completo.',
            'grupo_id' => $grupo1->id,
            'usuario_id' => $maestro->id,
            'fecha_entrega' => now()->addDays(2),
        ]);

        echo "✅ Datos de prueba creados exitosamente.\n";
        echo "\n📋 Credenciales para prueba:\n";
        echo "Maestro: maestro001 / 123456\n";
        echo "Alumno: alumno001 / 123456\n";
        echo "Usuario: admin001 / 123456\n";
    }
}

