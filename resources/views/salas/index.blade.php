<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de Salas') }}
    </h2>
    <a href="{{route('salas.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Nova') }}</x-buttons.create-button>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light">

            <!-- Paginação -->
            <x-slot name="paginacao">
              {{ $salas->links() }}
            </x-slot>

            <!-- Mostrar etiquetas para tabela - Variável "labels" -->
            <x-slot name="labels">
              <th scope="col">Id</th>
              <th scope="col">Nome</th>
              <th scope="col">Lotação</th>
              <th scope="col">Cidade</th>
              <th scope="col" colspan="3" class="text-end">Opções</th>
            </x-slot>

            <!-- Loop para  mostrar os dados  nas linhas da tabela - Variável "foreach"  -->
            <x-slot name="foreach">
              @foreach($salas as $sala)
              <tr>
                <td>{{$sala->id}}</td>
                <td>{{$sala->nome}}</td>
                <td>{{$sala->lotacao}}</td>
                <td>{{ $sala->cidadeNome ? $sala->cidadeNome->nome : 'Cidade não encontrada' }}</td>
                <td class ="d-flex justify-content-end">
                  <!-- Botão Show-->
                  <a href="{{route('salas.show', $sala->id)}}">
                    <x-buttons.show-button></x-buttons.show-button>
                  </a>
                  <!-- Botão Edit -->
                  <a href="{{route('salas.edit', $sala->id)}}">
                    <x-buttons.edit-button></x-buttons.show-button>
                  </a>
                  <!-- Botão  Delete -->
                  <form action="{{ route('salas.destroy', $sala->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta sala?');">
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

