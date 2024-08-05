<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Block info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 dark:text-gray-200 overflow-hidden shadow-xl sm:rounded-lg">
                <table>
                    <tbody>
                        <tr>
                            <td class="font-semibold">Block ID</td>
                            <td>{{ $blockData['blockId'] }}</td>
                        </tr>
                        <tr>
                            <td class="border-t font-semibold" rowspan="2">Tag</td>
                            <td class="border-t">{{ $blockData['hexTag'] }}</td>
                        </tr>
                        <tr>
                            <td class="border-t">{{ $blockData['tag'] }}</td>
                        </tr>
                        <tr>
                            <td class="border-t font-semibold" rowspan="{{ count($blockData['parents']) }}">Parents</td>
                            <td class="border-t">{{ $blockData['parents'][0] }}s</td>
                        </tr>
                        @if (count($blockData['parents']) > 1 )
                            @for ($i = 1; $i < count($blockData['parents']); $i++)
                        <tr>
                            <td class="border-t">{{ $blockData['parents'][$i] }}</td>
                        </tr>
                            @endfor
                        @endif
                        <tr>
                            <td class="border-t font-semibold" rowspan="2">Data</td>
                            <td class="border-t">{{ $blockData['hexData'] }}</td>
                        </tr>
                        <tr>
                            <td class="border-t">{{ $blockData['data'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>