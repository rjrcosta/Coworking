<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes do edificios') }} {{$edificios->nome}} ({{$edificios->id}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <p><strong>Nome</strong></p>
                    {{ __("$edificios->nome") }}
                    <br><br>
                    <p><strong>Morada</strong></p>
                    {{$edificios->morada}}
                    <br><br>
                    <p><strong>Código Postal</strong></p>
                    {{$edificios->cod_postal}}
                    <br><br>
                    <p><strong>Localidade</strong></p>
                    {{$edificios->cidade->nome}}
                    <br><br>
                    <p><strong>Contacto</strong></p>
                    {{$edificios->contacto}}
                    <br><br>
                    <p><strong>Data de criação</strong></p>
                    {{$edificios->created_at}}
                    <br><br>
                    <div class="d-flex mb-3">
                        <div class="me-auto p-2"></div>
                        <a href="{{ route('edificios.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>   
                        <div class="p-2"></div>
                    </div>
                    <!-- <div class="flex items-right justify-right">
                        <a href="{{ route('edificios.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                    </div> -->

                </div>

            </div>

        </div>

    </div>
</x-app-layout>