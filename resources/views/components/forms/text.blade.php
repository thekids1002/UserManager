@props([
    'label',
    'type' => 'text',
    'name',
    'value' => '',
    'idSelector' => '',
    'placeholder' => '',
    'isDisabled' => false,
    'isReadonly' => false,
])

@php
    if (empty($idSelector)) {
        $idSelector = str_contains($name, '_') ? str_replace('_', '-', $name) : $name;
    }
@endphp

<input
    {{ $attributes->merge([
        'type' => $type,
        'name' => $name,
        'value' => $value,
        'data-label' => $label,
        'class' => 'form-control',
        'id' => $idSelector,
        'placeholder' => $placeholder,
        'disabled' => $isDisabled,
        'readonly' => $isReadonly,
    ]) }}
/>
