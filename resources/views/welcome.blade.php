@extends('layouts.app')
@section('content')

<div>
    <div>
        <form action="" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la materia:</label>
                <input type="text" name="nombre" id="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="clave" class="block text-gray-700 text-sm font-bold mb-2">Clave de la materia:</label>
                <input type="text" name="clave" id="clave" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </form>
    </div>
</div>