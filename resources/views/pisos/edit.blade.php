<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Editar piso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('pisos.update', $pisos->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Aqui está o método correto -->
    
                        <br>
                        <div class="mb-4">
                            <label for="id" class="block text-sm font-medium text-gray-700">ID</label>
                            <input type="text" id="id" name="id" value="{{ old('id', $pisos->id) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
                            <label for="andar" class="block text-sm font-medium text-gray-700">Andar</label>
                            <input type="text" id="andar" name="andar" value="{{ old('andar', $pisos->andar) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('andar')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('pisos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar piso</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
