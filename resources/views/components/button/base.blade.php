@props([
    'type' => 'submit',
    'label',
    'isDisabled' => false
])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn btn-round btn-primary', 'disabled' => $isDisabled]) }}>
    {{ $label }}
</button>
