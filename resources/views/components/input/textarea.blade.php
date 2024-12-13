@props(['disabled' => false, 'readonly' => false])

<textarea @disabled($disabled) @readonly($readonly)
    {{ $attributes->merge(['class' => 'textarea textarea-bordered border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' . ($disabled || $readonly ? ' bg-slate-100 cursor-not-allowed' : '')]) }}>{{ $slot ?? '' }}</textarea>
