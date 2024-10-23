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
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    // resources/views/edificios/create.blade.php
    <script>
        document.getElementById('addCidadeButton').addEventListener('click', function() {
            // Obtém o nome da cidade a partir do input
            const nomeCidade = document.getElementById('add_nome').value;

            // Obtém o token CSRF
            const token = document.querySelector('input[name="_token"]').value;

            // Chama o método store do CidadeController via fetch
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
                        // Fechar o modal
                        let modal = bootstrap.Modal.getInstance(document.getElementById('addCidadeModal'));
                        modal.hide();

                        // Recarregar a página ou redirecionar para edificios/create
                        window.location.href = "{{ route('edificios.create') }}";
                    } else {
                        alert('Erro ao adicionar a cidade.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao adicionar a cidade: ' + error.message);
                });
        });
    </script>
</body>

</html>
