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
                        <div class="mb-3">
                            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <select id="cidade" name="cidade_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Cidade</option>
                                @foreach ($cidades as $cidade)
                                <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edificio" class="block text-sm font-medium text-gray-700">Edifício</label>
                            <select id="edificio" name="edificio_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Edifício</option>
                            </select>
                        </div>
                        <br>
                        <!-- Select para Piso -->
                        <label for="pisoSelect">Selecione o Piso:</label>
                        <select id="pisoSelect" name="piso_id" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Primeiro selecione um edifício</option>
                            <!-- Opções de piso serão carregadas dinamicamente pelo JavaScript -->
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

     <!-- Script para obter os edifícios da cidade selecionada -->
     <script>
        document.getElementById('cidade').addEventListener('change', function() {
            const cidadeId = this.value;

            // Fazer uma requisição AJAX para buscar os edifícios da cidade selecionada
            fetch(`/reservas/edificios/${cidadeId}`)
                .then(response => response.json())
                .then(data => {
                    const edificioSelect = document.getElementById('edificio');
                    edificioSelect.innerHTML = '<option value="">Selecionar Edifício</option>'; // Limpar opções

                    data.forEach(edificio => {
                        const option = document.createElement('option');
                        option.value = edificio.id;
                        option.textContent = edificio.nome;
                        edificioSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar edifícios:', error));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona o elemento do edifício
            const edificioSelect = document.getElementById('edificio');
            const pisoSelect = document.getElementById('pisoSelect');

            // Adiciona o evento de mudança ao select de edifício
            edificioSelect.addEventListener('change', function() {
                const edificioId = this.value;

                // Verifica se o ID do edifício está correto
                console.log("Edifício selecionado ID:", edificioId);

                // Faz a requisição AJAX para buscar os pisos associados ao edifício selecionado
                fetch(`/edificios/${edificioId}/pisos`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Pisos recebidos:", data);
                        pisoSelect.innerHTML = ''; // Limpa as opções de piso

                        // Adiciona cada piso como uma nova opção no select de pisos
                        data.forEach(piso => {
                            const option = document.createElement('option');
                            option.value = piso.id;
                            option.textContent = piso.andar;
                            pisoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Erro ao buscar pisos:', error));
            });
        });
    </script>

</x-app-layout>