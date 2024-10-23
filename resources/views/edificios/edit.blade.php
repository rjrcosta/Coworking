<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Editar Edificio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('edificios.update', $edificio->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <h2>{{ $edificio->nome }}</h2>
                        <br>
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ $edificio->nome }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="morada" class="block text-sm font-medium text-gray-700">Morada</label>
                            <input type="text" id="morada" name="morada" value="{{ $edificio->morada }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Adicionar uma cidade --}}
                        <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                        <select name='cod_cidade' id="cidade" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" aria-label="Default select example">
                            @foreach($cidades as $item)
                            @if($cidade->id == $item->id)
                            <option selected value="{{ $item->id }}">{{ $item->nome }}</option>
                            @else
                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endif
                            @endforeach
                        </select>   
                        <br>

                        <div class="mb-4">
                            <label for="cod_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" id="cod_postal" name="cod_postal" value="{{ $edificio->cod_postal }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                            <input type="text" id="contacto" name="contacto" value="{{ $edificio->contacto }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('edificios.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar edificio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>