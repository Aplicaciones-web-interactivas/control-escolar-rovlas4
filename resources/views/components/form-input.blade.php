<!-- Form Input Component -->
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
    
    <input 
        type="{{ $type ?? 'text' }}"
        name="{{ $name ?? '' }}"
        id="{{ $name ?? '' }}"
        class="form-input {{ $errorClass }}"
        @if($required ?? false) required @endif
        @if(isset($placeholder)) placeholder="{{ $placeholder }}" @endif
        @if(isset($value)) value="{{ $value }}" @endif
    >
    
    @if($errors->has($name ?? ''))
        <span class="text-red-500 text-sm mt-1">{{ $errors->first($name ?? '') }}</span>
    @endif
</div>
