<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de Cidades') }}
    </h2>
    <a href="{{route('cidades.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Nova') }}</x-buttons.create-button>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light">

            <!-- Pesquisa -->
            <x-slot name="pesquisa">
              <form action="{{ route('cidades.filtrar') }}" method="GET" class="d-flex justify-content-between align-items-center">
                <x-text-input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisa" />
                <x-buttons.search-button></x-buttons.search-button>
              </form>
            </x-slot>

            <!-- Paginação -->
            <x-slot name="paginacao">
              {{ $cidades->links() }}
            </x-slot>

            <!-- Mostrar etiquetas para tabela - Variável "labels" -->
            <x-slot name="labels">
              <th scope="col">Id</th>
              <th scope="col">Nome</th>

              <th scope="col" colspan="3" class="text-end">Opções</th>
            </x-slot>

            <!-- Loop para  mostrar os dados  nas linhas da tabela - Variável "foreach"  -->
            <x-slot name="foreach">
              @foreach($cidades as $cidade)
              <tr>
                <td>{{$cidade->id}}</td>
                <td>{{$cidade->nome}}</td>

                <td class="d-flex justify-content-end">
                  <!-- Botão Show-->
                  <a href="{{route('cidades.show', $cidade->id)}}">
                    <x-buttons.show-button></x-buttons.delete-button>
                  </a>
                  <!-- Botão Edit -->
                  <a href="{{route('cidades.edit', $cidade->id)}}">
                    <x-buttons.edit-button></x-buttons.delete-button>
                  </a>
                  <!-- Botão  Delete -->
                  <form action="{{ route('cidades.destroy', $cidade->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta cidade?');">
                    @csrf
                    @method('DELETE')
                    <x-buttons.delete-button type="Submit"></x-buttons.delete-button>
                  </form>
                </td>
              </tr>
              @endforeach
            </x-slot>

          </nav>
        </div>
      </div>
    </div>
  </div>

</x-index-layout>