@props(['disabled' => false, 'readonly' => false])

<input @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['class' => 'input input-sm custom-field  ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>
