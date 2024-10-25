<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de salas') }}
    </h2>
    <br>
    <td><a href="{{route('salas.create')}}"><button type="button" class="btn btn-primary">Criar</button></a></td>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light bg-light">
            <form action="{{ route('salas.filtrar') }}" method="GET">
              <input type="text" name="pesquisa" id="pesquisa" placeholder="Filtrar por cidade" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <button type="submit">Pesquisar</button>
            </form>
          </nav>
          <br><br>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Lotação</th>
                <th scope="col">Cidade</th>
                <!-- <th scope="col">Localidade</th> -->
                <th scope="col" colspan="3">Opções</th>
              </tr>
            </thead>
            <tbody>
              <!-- loop para buscar as salas -->
              @foreach($salas as $sala)
              <tr>
                <th scope="row">{{$sala->id}}</th>
                <td>{{$sala->nome}}</td>
                <td>{{$sala->lotacao}}</td>
                <td>{{ $sala->cidadeNome ? $sala->cidadeNome->nome : 'Cidade não encontrada' }}</td>
                <td><a href="{{route('salas.show', $sala->id)}}"><button type="button" class="btn btn-success">Detalhes</button></a></td>
                <td><a href="{{route('salas.edit', $sala->id)}}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                <td>
                  <form action="{{ route('salas.destroy', $sala->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este edifício?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </td>
                </td>
              </tr>
              @endforeach
              <!-- Exibe os links de paginação -->
              {{ $salas->links() }}
              @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>