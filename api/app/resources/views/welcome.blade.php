<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    {{-- Make the logo light/dark https://laracasts.com/discuss/channels/nova/is-there-a-way-to-add-lightdark-version-of-the-logo-in-nova --}}
                    <x-application-logo class="block h-12 w-auto text-gray-800 dark:text-white fill-current"/>

                    <h1 class="mt-8 text-2xl font-medium text-black dark:text-white">
                        ¡Bienvenidos al Trabajo de Fin de Grado de Francisco Llamas Nuflo!
                    </h1>

                    <p class="mt-6 text-gray-800 dark:text-gray-200 leading-relaxed">
                        Esta es la interfaz web que permite ver y obtener información sobre los datos insertados en la blockchain.
                    </p>

                    <!-- <div dir="rtl" class="flex items-right right-0"> -->
                    <div class="flex text-black dark:text-white">
                        <div class="flex-auto" >
                            <h3 class="text-xl font-semibold">
                                <a href="https://tfg.comiendolomo.com/login">Acceder</a>
                            </h3>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
