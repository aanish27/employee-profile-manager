@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => '.text-success p-1']) }}>
        {{ $status }}
    </div>
@endif
