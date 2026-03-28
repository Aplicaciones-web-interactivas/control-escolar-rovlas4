<!-- Data Table Header Component -->
<table class="data-table">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th @if(isset($column['width'])) style="width: {{ $column['width'] }}" @endif>
                    {{ $column['label'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
