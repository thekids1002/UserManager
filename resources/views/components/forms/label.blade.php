@props(['label' => null, 'isRequired' => false])

@php
    $requiredClass= $isRequired ? 'input-required' : '';
@endphp

<label {{ $attributes->merge(['class' => $requiredClass]) }}>
    {{ $label }}
    {{ $slot }}
</label>
