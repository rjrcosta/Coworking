<x-app-layout>

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

        <style>

        </style>
    </head>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Adicionar Novo edificio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">



                    <form action="{{ route('edificios.store') }}" method="POST" onsubmit="console.log('Formulário submetido')" class="d-flex flex-row">
                        @csrf
                        <div style="width:50%">
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
                        </div>

                        <!-- Mapa e campos de coordenadas -->
                        <div style="padding:40px;">
                            <div id="map" style="height:400px; width:500px; " class="z-0 rounded-3">
                                <p>hello</p>
                            </div>
                            <div class="d-flex flex-row">
                                <x-text-input id="lat" name="lat" class="block mt-1 w-full" placeholder="Latitude" />
                                <x-text-input id="lng" name="lng" class="block mt-1 w-full" placeholder="Longitude" />
                            </div>
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

    <script>
        // Inicializa o mapa na div com id "map"
        var map = L.map('map').setView([38.7169, -9.1399], 3); // Coordenadas de Lisboa e zoom inicial



        // Adiciona o tile layer do OpenStreetMap
        L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Variável para armazenar o marcador
        var marker;

        // Evento para capturar o clique no mapa e exibir latitude e longitude
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6); // Latitude
            var lng = e.latlng.lng.toFixed(6); // Longitude

            // Atualiza os campos de texto com as coordenadas
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            // Remove o marcador anterior, se existir
            if (marker) {
                map.removeLayer(marker);
            }

            // Adiciona um novo marcador no local do clique
            marker = L.marker([lat, lng]).addTo(map);
        });
    </script>
</x-app-layout>