@php
    $componentName = 'forms.text';
    $props = [
        'label',
        'type' => 'text',
        'name',
        'value' => '',
        'idSelector' => '',
        'placeholder' => '',
        'isDisabled' => false,
        'isReadonly' => false,
        'isRequired' => false,
    ];
    $allProps = array_merge($props, [
        'isHidden' => false,
        'valueHidden' => '',
    ]);
@endphp
@props($allProps)

<div class="input-group" style="{{ $attributes['style'] }}">
    @if (isset($label))
        <x-forms.label :label="$label" :isRequired="$isRequired" class="{{ 'col-6  '. $attributes['classLabel'] }}" />
    @endif
    <div class="col-sm-6">
        <x-forms.text
            :type="$type"
            :label="$label"
            :name="$name"
            :value="$value"
            :idSelector="$idSelector"
            :placeholder="$placeholder"
            :isDisabled="$isDisabled"
            :isHidden="$isHidden"
            class="{{ $attributes['classInput'] }}"
        />
        <x-error-message field="{{$name}}" />
        @if ($isHidden)
            <input
                type="hidden"
                name="{{ $name }}"
                value={{ !empty($valueHidden) ? $valueHidden : $value }}
            />
        @endif
    </div>

</div>
