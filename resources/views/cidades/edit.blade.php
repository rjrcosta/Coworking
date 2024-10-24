<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Editar cidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('cidades.update', $cidades->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <h2>{{ $cidades->nome }}</h2>
                        <br>
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ $cidades->nome }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nome')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('cidades.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar cidade</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>