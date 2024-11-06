<!-- 
<div class="container mt-5">
    <h1 class="mb-4">Detalhes da Mesa</h1>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informações da Mesa</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>ID da Mesa</th>
                        <td>{{ $mesa->id }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Estado da mesa</th>
                        <td>{{ $mesa->status }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Sala</th>
                        <td>{{ $sala->nome }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Piso</th>
                        <td>{{ $piso->andar }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Edifício</th>
                        <td>{{ $edificio->nome }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Cidade</th>
                        <td>{{$cidade->nome}}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>QR Code</th>
                        <td>
                            <img src="{{ asset($mesa->qrcode) }}" alt="qrcode" class="img-fluid" style="max-width: 200px;">
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('mesa.index') }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</div> -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes da Mesa') }} {{$mesa->id}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="d-flex flex-row justify-content-between">
                    <div class="p-6 text-black-900 dark:text-black-100 w-50">
                      

                         <x-input-label value="ID" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{ $mesa->id }}" readonly /> 

                        <x-input-label value="Disponibilidade" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{ $mesa->status }}" readonly />

                        <x-input-label value="Sala" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{ $sala->nome }}" readonly />

                        <x-input-label value="Piso" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{ $piso->andar }}" readonly />

                        <x-input-label value="Edificio" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{ $edificio->nome }}" readonly />

                        <x-input-label value="Cidade" />
                        <x-text-input class="form-control mt-2 mb-2" value="{{$cidade->nome}}" readonly /> 



                    </div>
                    <!-- QR CODE -->
                    <div id="" style="height:400px; width:500px; " class="z-0 m-4 rounded-3">
                        <img src="{{ asset($mesa->qrcode) }}" alt="qrcode" class="img-fluid" style="max-width: 200px;">
                    </div>

                </div>
                <div class="d-flex mb-3 p-2">
                    <a href="{{ route('mesa.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                </div>
            </div>
        </div>
  

</x-app-layout>