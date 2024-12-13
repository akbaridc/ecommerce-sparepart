@props(['disabled' => false])

<textarea @disabled($disabled)
    {{ $attributes->merge(['class' => 'textarea textarea-bordered border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' . ($disabled ? ' bg-slate-100' : '')]) }}>{{ $slot ?? '' }}</textarea>
