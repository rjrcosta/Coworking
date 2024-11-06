<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Editar sala') }}: {{ $salas->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('salas.update', $salas->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Aqui está o método correto -->

                        <br>
                        <div class="mb-4">
                            <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                            <input type="text" id="id" name="id" value="{{ old('id', $salas->id) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>

                            <label for="Nome" class="block text-sm font-medium text-gray-700 mt-2">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome', $salas->nome) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nome')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('salas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar sala</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>