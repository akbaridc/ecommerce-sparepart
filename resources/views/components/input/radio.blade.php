@props([
    'disabled' => false,
    'readonly' => false,
    'looping' => 1,
    'name' => 'radio',
    'label' => 'Label name',
    'checked' => false,
    'value' => '',
    'model' => '',
    'counter' => '',
])

@php
    $model = $model ? "x-model={$model}" : '';
    $identity = "radio-{$name}-{$counter}";
@endphp

@foreach (range(1, $looping) as $index)
    <div class="flex gap-1 cursor-pointer">
        <input @disabled($disabled) @readonly($readonly) @checked($checked) id="{{ $identity }}"
            name="{{ $identity }}"
            {{ $attributes->merge([
                'type' => 'radio',
                // 'name' => $attributes->get('name'),
                'class' => 'radio radio-primary scale-75 ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : ''),
            ]) }}
            {{ $model }} value="{{ $value }}" />
        <x-input-label for="{{ $identity }}" value="{{ __($label) }}" />
    </div>
@endforeach
