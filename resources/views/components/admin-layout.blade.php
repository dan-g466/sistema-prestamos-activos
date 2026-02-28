@isset($header)
    <x-slot name="header">
        {{ $header }}
    </x-slot>
@endisset

@include('layouts.admin', ['slot' => $slot])
