<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de reservas') }}
    </h2>
    <a href="{{route('reservas.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Novo') }}</x-buttons.create-button>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light">


            <!-- Pesquisa -->
            <x-slot name="pesquisa">
              <x-pesquisa action=""></x-pesquisa>
            </x-slot>

            <!-- Paginação -->
            <x-slot name="paginacao">
              {{ $reservas->links() }}
            </x-slot>

            <!-- Mostrar etiquetas para tabela - Variável "labels" -->
            <x-slot name="labels">
              <th scope="col">Id</th>
              <th scope="col">Utilizador</th>
              <th scope="col">Código Mesa</th>
              <th scope="col">Edifício</th>
              <th scope="col">Cidade</th>
              <th scope="col">Data</th>
              <th scope="col" colspan="3" class="text-end">Opções</th>
            </x-slot>

            <!-- Loop para  mostrar os dados  nas linhas da tabela - Variável "foreach"  -->
            <x-slot name="foreach">
              @foreach($reservas as $reserva)
              <tr>
                <td>{{$reserva->id}}</td>
                <td>{{$reserva->user ? $reserva->user->name : 'Usuário não encontrado'}}</td>
                <td>{{$reserva->cod_mesa}}</td>
                <td>{{$reserva->edificio ? $reserva->edificio->nome : 'Edifício não encontrado'}}</td> <!-- Mostra o nome do Edifício -->
                <td>{{$reserva->edificio ? $reserva->edificio->cidade->nome : 'Cidade não encontrada'}}</td>
                <td>{{$reserva->date}}</td>
                <td class="d-flex justify-content-end">
                  <!-- Botão Show-->
                  <a href="{{route('reservas.show', $reserva->id)}}">
                    <x-buttons.show-button></x-buttons.delete-button>
                  </a>
                  <!-- Botão Edit 
                  <a href="{{route('reservas.edit', $reserva->id)}}">
                    <x-buttons.edit-button></x-buttons.delete-button>
                  </a> -->

                  <!-- Botão Delete -->
                  <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta Reserva?');">
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