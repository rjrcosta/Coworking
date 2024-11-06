<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Adicionar nova mesa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('mesa.store') }}" method="POST" onsubmit="console.log('Formulário submetido')">
                        @csrf
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <select id="cidade" name="cidade_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Cidade</option>
                                @foreach ($cidades as $cidade)
                                <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edificio" class="form-label">Edifício</label>
                            <select id="edificio" name="edificio_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Edifício</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="piso" class="form-label">Piso</label>
                            <select id="piso" name="piso_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Piso</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sala" class="form-label">Sala</label>
                            <select id="sala" name="sala_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Selecionar Sala</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Criar mesa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Script para atualizar edifícios, pisos e salas -->
    <script>
        // Adiciona token CSRF para requisições AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.getElementById('cidade').addEventListener('change', function() {
            const cidadeId = this.value;
            fetch(`/mesa/edificios/${cidadeId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.ok ? response.json() : Promise.reject('Erro ao buscar edifícios'))
                .then(data => {
                    const edificioSelect = document.getElementById('edificio');
                    edificioSelect.innerHTML = '<option value="">Selecionar Edifício</option>';
                    data.forEach(edificio => {
                        const option = document.createElement('option');
                        option.value = edificio.id;
                        option.textContent = edificio.nome;
                        edificioSelect.appendChild(option);
                    });
                })
                .catch(error => console.error(error));
        });
    </script>

    <!-- Script para atualizar pisos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Seleciona o elemento do edifício
            const edificioSelect = document.getElementById('edificio');
            const pisoSelect = document.getElementById('piso');

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
                        pisoSelect.innerHTML = '<option value="">Selecionar Piso</option>';
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

    <!-- Script para atualizar pisos -->
    <script>
        // Captura os elementos de seleção do piso e da combobox de salas
        const pisoSelect = document.getElementById('piso'); // Presume-se que exista um elemento com o ID 'piso'
        const edificioSelect = document.getElementById('edificio'); // Presume-se que exista um elemento com o ID 'edificio'
        const salaSelect = document.getElementById('sala'); // Combobox de salas

        // Adiciona um evento apenas na combobox de piso
        pisoSelect.addEventListener('change', carregarSalas);

        function carregarSalas() {
            const codPiso = pisoSelect.value;
            const codEdificio = edificioSelect.value;

            // Limpar as opções da combobox de salas
            salaSelect.innerHTML = '<option>Selecione uma sala</option>';

            // Verifica se ambos os valores estão preenchidos
            if (!codPiso || !codEdificio) return;

            // Requisição para buscar as salas com o piso e edifício selecionados
            fetch(`/mesa/create/devolver_salas?cod_piso=${codPiso}&cod_edificio=${codEdificio}`)
                .then(response => response.json())
                .then(data => {
                    // Itera sobre as salas retornadas e adiciona como opções na combobox
                    data.forEach(sala => {
                        const option = document.createElement('option');
                        option.value = sala.id;
                        option.textContent = sala.nome;
                        salaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar as salas:', error);
                });
        }
    </script>



</x-app-layout>