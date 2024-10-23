<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de edificios') }}
    </h2>
    <br>
    <td><a href="{{route('edificios.create')}}"><button type="button" class="btn btn-primary">Criar</button></a></td>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light bg-light">
            <form action="{{ route('edificios.filtrar') }}" method="GET">
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
                <!-- <th scope="col">Morada</th> -->
                <!-- <th scope="col">Código Postal</th> -->
                <th scope="col">Cidade</th>
                <!-- <th scope="col">Localidade</th> -->
                <th scope="col" colspan="3">Opções</th>
              </tr>
            </thead>
            <tbody>
              <!-- loop para buscar os edifícios -->
              @foreach($edificios as $edificio)
              <tr>
                <th scope="row">{{$edificio->id}}</th>
                <td>{{$edificio->nome}}</td>
                <!-- <td>{{$edificio->morada}}</td> -->
                <!-- <td>{{$edificio->cod_postal}}</td> -->
                <td>{{$edificio->cidade->nome}}</td>
                <!-- <td>{{$edificio->localidade}}</td> -->
                <td><a href="{{route('edificios.show', $edificio->id)}}"><button type="button" class="btn btn-success">Detalhes</button></a></td>
                <td><a href="{{route('edificios.edit', $edificio->id)}}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                <td>
                  <form action="{{ route('edificios.destroy', $edificio->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este edifício?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </td>
                </td>
              </tr>
              @endforeach
              <!-- Exibe os links de paginação -->
              {{ $edificios->links() }}
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