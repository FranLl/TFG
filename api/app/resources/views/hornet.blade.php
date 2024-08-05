<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Hornet') }}
        </h2>
    </x-slot>

    {{-- <iframe src="{{url('parent/child')}}">Your browser isn't compatible</iframe> --}}
    {{-- Bloquear iframe mediante autenticacion. Ver: https://stackoverflow.com/questions/4159500/can-i-authenticate-an-iframe-page-from-the-parent-page --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <iframe class="w-full aspect-video" src="https://node1.comiendolomo.com">Your browser isn't compatible</iframe>
            </div>
        </div>
    </div>
</x-app-layout>
