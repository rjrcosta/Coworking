<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes das salas') }} {{$salas->nome}} ({{$salas->id}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <p><strong>Nome</strong></p>
                    {{ __("$salas->nome") }}
                    <br><br>
                    <p><strong>Lotação</strong></p>
                    {{ __("$salas->lotacao") }}
                    <br><br>
                    <div class="d-flex mb-3">
                        <div class="me-auto p-2"></div>
                        <a href="{{ route('salas.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                        <div class="p-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>