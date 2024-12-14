@props(['disabled' => false, 'readonly' => false])

<input @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['type' => 'file', 'class' => 'file-input file-input-sm custom-field ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>
