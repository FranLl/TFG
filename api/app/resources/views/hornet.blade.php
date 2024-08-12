<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Hornet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <iframe class="w-full aspect-video" src="http://<IP_nodo_hornet>:8081">Your browser isn't compatible</iframe>
            </div>
        </div>
    </div>
</x-app-layout>
