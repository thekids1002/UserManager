@props(['to'])

<a {{ $attributes->merge(['href' => $to]) }}>
    {{ $slot }}
</a>
