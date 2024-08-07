@props(['field'])

@if ($errors->any())
    @if ($errors->has($field))
        @foreach ($errors->get($field) as $error)
            <span class="error-message"> {{ $error }}</span><br>
            @break
        @endforeach
    @endif
@endif
