<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Adicionar nova sala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('salas.store') }}" method="POST" onsubmit="console.log('Formulário submetido')">
                        @csrf
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nome')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="lotacao" class="block text-sm font-medium text-gray-700">Lotacao</label>
                            <input type="text" id="lotacao" name="lotacao" value="{{ old('lotacao') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('lotacao')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <label for="edificio_id">Edifício:</label>
                        <select name="edificio_id" id="edificio_id" required class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" aria-label="Default select example">
                            <option value="">Selecione um edifício</option>
                            @foreach($edificios as $edificio)
                            <option value="{{ $edificio->id }}">{{ $edificio->nome }}</option>
                            @endforeach
                        </select>
                        <br>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('salas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Criar sala</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>