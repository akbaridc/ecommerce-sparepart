@props(['disabled' => false, 'readonly' => false])

<select @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['class' => 'select select-sm custom-field ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>
    {{ $slot }}
</select>
