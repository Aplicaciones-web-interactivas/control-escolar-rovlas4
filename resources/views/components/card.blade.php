<!-- Card Component -->
<div class="card {{ $class ?? '' }}">
    @if(isset($header))
        <div class="card-header {{ $headerClass ?? '' }}">
            {{ $header }}
        </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
