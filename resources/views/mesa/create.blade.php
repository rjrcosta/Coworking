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
                            <select id="cidade" name="cidade_id" class="form-select" required>
                                <option value="">Selecionar Cidade</option>
                                @foreach ($cidades as $cidade)
                                    <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edificio" class="form-label">Edifício</label>
                            <select id="edificio" name="edificio_id" class="form-select" required>
                                <option value="">Selecionar Edifício</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="piso" class="form-label">Piso</label>
                            <select id="piso" name="piso_id" class="form-select" required>
                                <option value="">Selecionar Piso</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sala" class="form-label">Sala</label>
                            <select id="sala" name="sala_id" class="form-select" required>
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


        document.getElementById('piso').addEventListener('change', function() {
            const pisoId = this.value;

            // Verifica se o ID do edifício está correto
            console.log("Piso selecionado ID:", pisoId);

            fetch(`/mesa/salas/${pisoId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.ok ? response.json() : Promise.reject('Erro ao buscar salas'))
                .then(data => {
                    console.log("Salas recebidas:", data);
                    const salaSelect = document.getElementById('sala');
                    salaSelect.innerHTML = '<option value="">Selecionar Sala</option>';
                    data.forEach(sala => {
                        const option = document.createElement('option');
                        option.value = sala.id;
                        option.textContent = sala.nome;
                        salaSelect.appendChild(option);
                    });
                })
                .catch(error => console.error(error));
        });

    </script>

    {{-- // document.getElementById('edificio').addEventListener('change', function() {
        //     const edificioId = this.value;
        //     fetch(`/mesa/pisos/${edificioId}`, {
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken
        //         }
        //     })
        //     .then(response => response.ok ? response.json() : Promise.reject('Erro ao buscar pisos'))
        //     .then(data => {
        //         console.log(data)
        //         const pisoSelect = document.getElementById('piso');
        //         pisoSelect.innerHTML = '<option value="">Selecionar Piso</option>';
        //         data.forEach(piso => {
        //             const option = document.createElement('option');
        //             option.value = piso.id;
        //             option.textContent = piso.andar;
        //             pisoSelect.appendChild(option);
        //         });
        //     })
        //     .catch(error => console.error(error));
        // }); --}}
</x-app-layout>
