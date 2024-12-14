@props(['disabled' => false, 'readonly' => false])

<textarea @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['class' => 'textarea textarea-sm custom-field ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>{{ $slot ?? '' }}</textarea>
