<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhe da sala') }} {{$salas->nome}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">

                    <x-input-label value="ID" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $salas->id }}" readonly />

                    <x-input-label value="Nome" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $salas->nome }}" readonly />

                    <x-input-label value="Lotação" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $salas->lotacao }}" readonly />

                    <div class="d-flex justify-content-end  mb-3 p-2">
                        <a href="{{ route('salas.index') }}">
                            <button type="button" class="btn btn-primary">Voltar</button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>