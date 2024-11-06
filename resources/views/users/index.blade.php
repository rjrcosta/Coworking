<x-index-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de Clientes') }}
    </h2>

    {{-- <a href="{{route('user.create')}}"><button class="btn btn-primary">Novo cliente</button></a> --}}
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">

         <!-- Pesquisa -->
         <x-slot name="pesquisa">
              <form action="" method="GET" class="d-flex justify-content-between align-items-center">
                <x-text-input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisa" />
                <x-buttons.search-button></x-buttons.search-button>
              </form>
            </x-slot>

          <!-- Paginação -->
          <x-slot name="paginacao">
            {{$users->links()}}
          </x-slot>
          <table class="table">
            <x-slot name="labels">

              <th scope="col">ID</th>
              <th scope="col">Nome</th>

              <th scope="col">role</th>

              <th colspan="3" scope="col" class="text-end">Opções</th>

            </x-slot>
            <x-slot name="foreach">
              @foreach($users as $user)
              @if($user->role == 'user')
              <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>

                <td>{{$user->role}}</td>

                <!-- <td><a href="{{route('users.show',$user->id)}}"><button type="button" class="btn btn-info">Mostrar</button></a></td>
                <td><a href="{{route('users.edit',$user->id)}}"><button type="button" class="btn btn-warning">editar</button></a> </td>

                <td>
                  <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este usuário?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">eliminar</button>
                  </form>
                </td> -->

                <td class="d-flex justify-content-end">
                  <!-- Botão Show-->
                  <a href="{{route('users.show',$user->id)}}">
                    <x-buttons.show-button></x-buttons.show-button>
                  </a>
                  <!-- Botão Edit -->
                  <a href="{{route('users.edit',$user->id)}}">
                    <x-buttons.edit-button></x-buttons.show-button>
                  </a>
                  <!-- Botão  Delete -->
                  <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                    @csrf
                    @method('DELETE')
                    <x-buttons.delete-button type="Submit"></x-buttons.delete-button>
                  </form>
                </td>

              </tr>
              @endif
              @endforeach

            </x-slot>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-index-layout>