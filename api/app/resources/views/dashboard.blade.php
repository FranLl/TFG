<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 dark:text-gray-200 overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="text-xl">Blocks list</h1>
                {{-- https://stackoverflow.com/questions/39342608/laravel-check-if-array-is-empty --}}
                @if($arrayBlocks->isEmpty())
                    <h2>No data</h2>
                @else
                    {{-- https://stackoverflow.com/questions/47979448/difference-between-foreach-and-forelse-in-laravel --}}
                    <table class="text-center">
                        <thead>
                            <tr>
                                <th>Created</th>
                                <th>Location</th>
                                <th>Identification</th>
                                <th>Block ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($arrayBlocks as $block)
                            <tr class="border-t">
                                <td>{{ $block->created_at }}</td>
                                <td>{{ $block->sensorLoc }}</td>
                                <td>{{ $block->sensorId }}</td>
                                <td><a href="/block/{{ $block->blockId }}">{{ $block->blockId }}</a></td>
                            </tr>
                            @empty
                            <tr class="border-t">
                                <td>No blocks</td>
                                <td>No blocks</td>
                            </tr>
                            @endforelse
                        </tbody>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>