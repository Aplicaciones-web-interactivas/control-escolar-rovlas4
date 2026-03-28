<div class="mb-6 w-full">
    <form method="GET" action="" class="flex items-stretch gap-2 w-full" style="min-height: 40px;">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="{{ $placeholder ?? 'Buscar...' }}"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-white"
        >
        <button type="submit" style="background-color: #4f46e5; color: white; padding: 8px 24px; border-radius: 8px; font-weight: 500; border: none; cursor: pointer; white-space: nowrap; flex-shrink: 0;">
            Buscar
        </button>
        @if($search ?? false)
            <a href="?" style="background-color: #d1d5db; color: #374151; padding: 8px 24px; border-radius: 8px; font-weight: 500; text-decoration: none; white-space: nowrap; flex-shrink: 0; display: inline-block;">
                Limpiar
            </a>
        @endif
    </form>
</div>
