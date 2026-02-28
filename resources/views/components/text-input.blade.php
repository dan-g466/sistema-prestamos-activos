@props(['disabled' => false, 'value' => ''])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full text-sm'
    ]) !!}
    value="{{ old($attributes->get('name'), $value) }}"
>
