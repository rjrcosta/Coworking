<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes do Piso') }} {{$pisos->andar}} ({{$pisos->id}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <p><strong>Andar</strong></p>
                    {{ $pisos->andar }}
                    <br><br>
                    <p><strong>Data de Criação</strong></p>
                    {{ $pisos->created_at }}
                    <br><br>

                    <!-- Combobox de Cidades -->
                    <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                    <select id="cidade" name="cidade" class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Selecione uma cidade</option>
                        @foreach($cidades as $cidade)
                        <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                        @endforeach
                    </select>

                    <!-- Combobox de Edifícios -->
                    <label for="edificios" class="block text-sm font-medium text-gray-700 mt-4">Edifícios</label>
                    <select id="edificios" name="edificios[]" multiple class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <!-- Os edifícios serão filtrados aqui -->
                    </select>

                    <!-- Campo oculto contendo um JSON com os dados dos edifícios -->
                    <input type="hidden" id="edificio_hidden" value='@json($edificios)'>
                    <!-- Campo oculto contendo um JSON com o id do piso -->
                    <input type="hidden" id="piso_id" value="{{ $pisos->id }}">


                    <div class="flex items-center justify-between mt-4">
                        <a href="{{ route('pisos.index') }}">
                            <button type="button" class="btn btn-primary">Voltar</button></a>
                        <button type="button" id="associateButton" class="btn btn-success">Associar Piso</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>