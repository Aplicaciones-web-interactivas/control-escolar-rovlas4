@if ($paginator->hasPages())
<nav class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="hidden sm:block">
        <p class="text-sm text-gray-700">
            Mostrando
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            a
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-medium">{{ $paginator->total() }}</span>
            resultados
        </p>
    </div>

    <div class="flex items-center justify-center gap-2 flex-1">
        @if ($paginator->onFirstPage())

        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 12px; color: #374151; background-color: white; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; display: inline-block;">
                ← Anterior
            </a>
        @endif

        <div style="display: flex; align-items: center; justify-content: center; gap: 0;">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="padding: 8px 12px; text-align: center; font-size: 14px; font-weight: 600; color: #6b7280; background-color: white; border: 1px solid #d1d5db; margin-left: -1px; display: inline-flex; align-items: center; justify-content: center;">
                        {{ $element }}
                    </span>
                @endif
                
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 8px 12px; text-align: center; font-size: 14px; font-weight: 600; color: white; background-color: #4f46e5; border: 1px solid #4f46e5; margin-left: -1px; display: inline-flex; align-items: center; justify-content: center;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="padding: 8px 12px; text-align: center; font-size: 14px; font-weight: 600; color: #374151; background-color: white; border: 1px solid #d1d5db; margin-left: -1px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 12px; color: #374151; background-color: white; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; display: inline-block;">
                Siguiente →
            </a>
        @else
            <span style="padding: 8px 12px; color: #9ca3af; background-color: white; border: 1px solid #d1d5db; border-radius: 6px; cursor: not-allowed;">
                Siguiente →
            </span>
        @endif
    </div>
</nav>
@endif
