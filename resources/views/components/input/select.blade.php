@props(['disabled' => false])

<select @disabled($disabled)
    {{ $attributes->merge(['class' => 'select select-ghost border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    {{ $slot }}
</select>
