<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary py-2 mt-2']) }}>
    {{ $slot }}
</button>
