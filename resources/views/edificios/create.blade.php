<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Adicionar Novo edificio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('edificios.store') }}" method="POST" onsubmit="console.log('Formulário submetido')">
                        @csrf
                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nome')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="morada" class="block text-sm font-medium text-gray-700">Morada</label>
                            <input type="text" id="morada" name="morada" value="{{ old('morada') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('morada')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            {{-- Escolher uma cidade --}}
                            <select name='cod_cidade' id="cidade" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" aria-label="Default select example">
                                <option value="Selecione">Selecione uma cidade</option>
                                @foreach($cidades as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                @endforeach
                            </select>

                            {{-- Botão para chamar um modal que irá adicionar uma nova Cidade --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCidadeModal">
                                +
                            </button>
                        </div>


                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <br>

                        <div class="mb-4">
                            <label for="cod_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" id="cod_postal" name="cod_postal" value="{{ old('cod_postal') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('cod_postal')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="contacto" class="block text-sm font-medium text-gray-700">contacto</label>
                            <input type="text" id="contacto" name="contacto" value="{{ old('contacto') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('contacto')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('edificios.index') }}" class="btn btn-secondary">Cancelar</a>

                            <x-buttons.submit-button type="submit" class="ms-4">{{ __('Salvar') }}</x-buttons.submit-button>
                        </div>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="addCidadeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCidadeModalLabel">Adicionar Cidade</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" onsubmit="console.log('Formulário do modal submetido')">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="add_mome" class="block text-sm font-medium text-gray-700">Nome da Cidade</label>
                                            <input type="text" id="add_nome" name="add_nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button id="addCidadeButton" onclick="return false;" class="btn btn-primary">Adicionar</button>
                                            
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>