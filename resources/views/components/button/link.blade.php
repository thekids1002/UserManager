@props(['to', 'label'])

<a {{ $attributes->merge(['href' => $to]) }}>
    <x-button.base type="button" :label="$label" />
</a>
