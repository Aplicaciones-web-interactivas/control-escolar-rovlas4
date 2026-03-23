<!-- Form Select Component -->
@php
    $errorClass = $errors->has($name ?? '') ? 'border-red-500' : '';
@endphp

<div class="form-group">
    @if(isset($label))
        <label for="{{ $name ?? '' }}" class="form-label">
            @if(isset($icon))
                <i class="icon {{ $icon }}"></i>
            @endif
            {{ $label }}
            @if($required ?? false)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <select 
        name="{{ $name ?? '' }}"
        id="{{ $name ?? '' }}"
        class="form-select {{ $errorClass }}"
        @if($required ?? false) required @endif
    >
        @if(isset($placeholder))
            <option value="">{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
    
    @if($errors->has($name ?? ''))
        <span class="text-red-500 text-sm mt-1">{{ $errors->first($name ?? '') }}</span>
    @endif
</div>
