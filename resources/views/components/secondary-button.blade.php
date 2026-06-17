<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary w-100']) }}>
    {{ $slot }}
</button>
