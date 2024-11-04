<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes do edificios') }} {{$edificios->nome}} ({{$edificios->id}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="d-flex flex-row justify-content-between">
                    <div class="p-6 text-black-900 dark:text-black-100">
                        <p><strong>Nome</strong></p>
                        {{ $edificios->nome }}
                        <br><br>
                        <p><strong>Morada</strong></p>
                        {{$edificios->morada}}
                        <br><br>
                        <p><strong>Código Postal</strong></p>
                        {{$edificios->cod_postal}}
                        <br><br>
                        <p><strong>Localidade</strong></p>
                        {{$edificios->cidade->nome}}
                        <br><br>
                        <p><strong>Contacto</strong></p>
                        {{$edificios->contacto}}
                        <br><br>
                        <p><strong>Data de criação</strong></p>
                        {{$edificios->created_at}}
                        <br><br>

                        <!-- <div class="flex items-right justify-right">
                        <a href="{{ route('edificios.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                    </div> -->

                    </div>
                    <!-- Mapa -->
                    <div id="map" style="height:400px; width:500px; " class="z-0 m-4 rounded-3">
                        <!-- campos  de coordenadas -->
                        <div class="d-none">
                            <x-text-input id="lat" name="lat" class="block mt-1 w-full" value="{{$edificios->lat}}" />
                            <x-text-input id="lng" name="lng" class="block mt-1 w-full" value="{{$edificios->lng}}" />
                            <x-text-input id="nome" name="nome" class="block mt-1 w-full" value="{{$edificios->nome}}" />
                        </div>
                    </div>

                </div>
                <div class="d-flex mb-3">
                    <div class="me-auto p-2"></div>
                    <a href="{{ route('edificios.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                    <div class="p-2"></div>
                </div>
            </div>
        </div>
        <script>
            // varáveis latitude e longitude
            var longitude = document.getElementById('lat').value;
            var latitude = document.getElementById('lng').value;
            var nome = document.getElementById('nome').value;
              

            // Inicializa o mapa na div com id "map"
            var map = L.map('map').setView([longitude, latitude], 13); // Coordenadas de Lisboa e zoom inicial

            // Adiciona o tile layer do OpenStreetMap
            L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // adicionar marcador da posição
            L.marker([longitude, latitude]).addTo(map)
            .bindPopup(nome)
            .openPopup();
        </script>

</x-app-layout>