<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS -->
    <!-- Bootstrap css v5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap script v5.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 d-flex justify-content-between">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- resources/views/edificios/create.blade.php -->
    <script>
        document.getElementById('addCidadeButton').addEventListener('click', function() {
            const nomeCidade = document.getElementById('add_nome').value;
            const token = document.querySelector('input[name="_token"]').value;

            fetch('{{ route("cidades.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        nome: nomeCidade
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fecha o modal e recarrega a página para mostrar a nova cidade
                        let modal = bootstrap.Modal.getInstance(document.getElementById('addCidadeModal'));
                        modal.hide();

                        window.location.href = "{{ route('edificios.create') }}";
                    } else {
                        alert(data.message); // Mostra a mensagem de erro retornada
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao adicionar a cidade.');
                });
        });
    </script>

    <!-- resources/views/pisos/showAssociated.blade.php -->
    <script>
        // Captura os valor dos inputs ocultos e transforma em objeto JavaScript
        const pisoId = document.getElementById('piso_id').value;

        // Cptura o valor da combobox de cidades
        let cidade = document.getElementById('cidade');

        // Captura o elemento de seleção de edifícios
        const edificiosSelect = document.getElementById('edificios');

        // Corre apenas se uma cidade foi selecionada
        if (cidade.value != "Selecione uma cidade") {

            // Adiciona um evento de mudança na combobox de cidades
            cidade.addEventListener('change', function() {
                const cidadeId = this.value;
                const edificiosSelect = document.getElementById('edificios');
                edificiosSelect.innerHTML = ''; // Limpar os edifícios existentes

                // Captura o valor do input oculto e transforma em objeto JavaScript
                let edificios = JSON.parse(document.getElementById('edificio_hidden').value);

                //console.log(edificios);

                // Se a cidade foi selecionada, mostrar os edifícios
                if (cidadeId) {
                    // Obter apenas os edifícios da cidade selecionada
                    edificios.forEach(edificio => {
                        // Filtra a lista de edifícios pelo id da cidade
                        if (edificio.cod_cidade == cidadeId) {
                            // Construir uma nova opção a cada edifínio
                            const option = document.createElement('option');
                            option.value = edificio.id;
                            option.textContent = edificio.nome;
                            edificiosSelect.appendChild(option);
                        }
                    })
                }

            })

        }

        // Lógica para receber os edifícios selecionados e mandar para o controller
        // Adicionar evento ao botão de associar
        associateButton.addEventListener('click', function() {
            const selectedEdificios = Array.from(edificiosSelect.selectedOptions).map(option => option.value);
            const token = document.querySelector('input[name="_token"]').value;

            // Verificar se pelo menos um edifício foi selecionado
            if (selectedEdificios.length === 0) {
                alert('Por favor, selecione pelo menos um edifício.');
                return;
            }

            // Fazer o POST para o método associate do PisoController
            fetch('{{ route("pisos.associate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        piso_id: pisoId, // Usar o ID do piso obtido do HTML
                        edificios: selectedEdificios
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Associação realizada com sucesso!');
                        // Redirecionar ou atualizar a página conforme necessário
                        window.location.href = '{{ route("pisos.index") }}';
                    } else {
                        alert('Verifique se esse piso já foi associado a algum desses edifícios.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao associar os edifícios.');
                });
        });
        
    </script>
</body>

</html>