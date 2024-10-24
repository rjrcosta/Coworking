<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de cidades') }}
    </h2>
    <br>
    <td><a href="{{route('cidades.create')}}"><button type="button" class="btn btn-primary">Criar</button></a></td>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light bg-light">
            <form action="{{ route('cidades.filtrar') }}" method="GET">
              <input type="text" name="pesquisa" id="pesquisa" placeholder="Filtrar pelo nome" class="mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <button type="submit">Pesquisar</button>
            </form>
          </nav>
          <br><br>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col" colspan="3">Opções</th>
              </tr>
            </thead>
            <tbody>
              <!-- loop para buscar os edifícios -->
              @foreach($cidades as $cidade)
              <tr>
                <th scope="row">{{$cidade->id}}</th>
                <td>{{$cidade->nome}}</td>
                <td><a href="{{route('cidades.show', $cidade->id)}}"><button type="button" class="btn btn-success">Detalhes</button></a></td>
                <td><a href="{{route('cidades.edit', $cidade->id)}}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                <td>
                  <form action="{{ route('cidades.destroy', $cidade->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta cidade e todos os edifícios associados?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </td>
                </td>
              </tr>              
              @endforeach

              <!-- Exibe os links de paginação -->
              {{ $cidades->links() }}

              <!-- Exibe mensagem de erro quando houver -->
              @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
              @endif

              <!-- Exibe mensagem de sucesso -->
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