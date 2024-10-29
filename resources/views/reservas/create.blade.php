<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Adicionar nova reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('reservas.store') }}" method="POST" onsubmit="console.log('Formulário submetido')">
                        @csrf
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Utilizador</label>
                            <input type="text" id="usuario" name="usuario" value="{{ $usuarioLogado->name }}" class="form-control" readonly>
                        </div>
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
                            <label for="data" class="form-label">Data</label>
                            <input type="date" id="data" name="data" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="periodo" class="form-label">Período</label>
                            <select id="periodo" name="periodo" class="form-select" required>
                                <option value="">Selecionar Período</option>
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="ambos">Ambos</option>
                            </select>
                        </div>

                        <!-- Campo para mostrar a disponibilidade -->
                        <div hidden class="mb-3">
                            <label>Disponibilidade:</label>
                            <input type="text" id="disponibilidade" class="form-control"></input>
                        </div>

                        <button type="submit" class="btn btn-primary">Criar Reserva</button>
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

    <!-- Script para mostrar a disponibilidade -->
    <script>
        document.getElementById('periodo').addEventListener('change', function() {
            const edificioId = document.getElementById('edificio').value;
            const data = document.getElementById('datepicker').value;
            const periodo = this.value;

            console.log('ID do edifício:', edificioId);
            console.log('Data selecionada:', data);
            console.log('Período selecionado:', periodo);

            // Fazer uma requisição AJAX para calcular a disponibilidade
            fetch('/reservas/disponibilidade', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Adicione o token CSRF
                    },
                    body: JSON.stringify({
                        edificio_id: edificioId,
                        data: data,
                        periodo: periodo
                    })
                })
                .then(response => {
                    console.log('Resposta do servidor:', response);
                    return response.json();
                })
                .then(data => {
                    if (data.disponibilidade !== undefined) {
                        document.getElementById('disponibilidade').innerText = data.disponibilidade;
                    } else {
                        console.error('Erro ao calcular a disponibilidade:', data.error);
                    }
                })
                .catch(error => console.error('Erro na requisição:', error));
        });
    </script>


</x-app-layout>