@isset($header)
    <x-slot name="header">
        {{ $header }}
    </x-slot>
@endisset

@include('layouts.user', ['slot' => $slot])
