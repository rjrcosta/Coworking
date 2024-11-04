<x-app-layout>

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

        <style>

        </style>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-black leading-tight">
            {{ __('Editar Edificio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('edificios.update', $edificio->id)}}" method="POST" class="d-flex flex-row">
                        @csrf
                        @method('PUT')
                        <div style="width:50%">
                            <h2>{{ $edificio->nome }}</h2>
                            <br>
                            <div class="mb-4">
                                <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input type="text" id="nome" name="nome" value="{{ $edificio->nome }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="mb-4">
                                <label for="morada" class="block text-sm font-medium text-gray-700">Morada</label>
                                <input type="text" id="morada" name="morada" value="{{ $edificio->morada }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            {{-- Adicionar uma cidade --}}
                            <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <select name='cod_cidade' id="cidade" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" aria-label="Default select example">
                                @foreach($cidades as $item)
                                @if($cidade->id == $item->id)
                                <option selected value="{{ $item->id }}">{{ $item->nome }}</option>
                                @else
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                @endif
                                @endforeach
                            </select>
                            <br>

                            <div class="mb-4">
                                <label for="cod_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                <input type="text" id="cod_postal" name="cod_postal" value="{{ $edificio->cod_postal }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="mb-4">
                                <label for="contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                                <input type="text" id="contacto" name="contacto" value="{{ $edificio->contacto }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>



                            <div class="p-3 flex items-center justify-between">
                                <a href="{{ route('edificios.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Atualizar edificio</button>
                            </div>
                        </div>

                        <!-- Mapa e campos de coordenadas -->
                        <div style="padding:40px;">
                            <!-- mapa -->
                            <div id="map" style="height:400px; width:500px; " class="z-0 rounded-3"></div>
                            <!-- campos  de coordenadas -->
                            <div class="d-flex flex-row">
                                <x-text-input id="lat" name="lat" class="block mt-1 w-full" placeholder="Latitude" />
                                <x-text-input id="lng" name="lng" class="block mt-1 w-full" placeholder="Longitude" />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        //receber o objecto edificio para  usar as coordenadas
        var pin = <?php echo $edificio; ?>;
        
        // Adiciona o tile layer do OpenStreetMap
        // Inicializa o mapa na div com id "map"
        var map = L.map('map').setView([pin.lat, pin.lng], 13); // Coordenadas do edificio

        // Adiciona o tile layer do OpenStreetMap
        L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Variável para armazenar o marcador
        // adicionar marcador da posição
        var marker = L.marker([pin.lat, pin.lng]).addTo(map)
        .bindPopup(nome);
      
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