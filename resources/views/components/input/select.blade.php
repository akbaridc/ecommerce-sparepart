@props(['disabled' => false, 'readonly' => false])

<select @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['class' => 'select select-ghost border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>
    {{ $slot }}
</select>
