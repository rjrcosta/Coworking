<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de pisos') }}
    </h2>
    <a href="{{route('pisos.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Novo') }}</x-buttons.create-button>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light">
            <form action="{{ route('pisos.filtrar') }}" method="GET" class="d-flex justify-content-between align-items-center">
            <x-text-input type="text" name="pesquisa" id="pesquisa" placeholder="Filtrar por piso"/>
            <x-buttons.search-button type="submit"></x-buttons.search-button>
            </form>
          </nav>
          <br><br>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Andarxx</th>
                <th scope="col" colspan="3">Opções</th>
              </tr>
            </thead>
            <tbody>
              <!-- loop para buscar os pisos -->
              @foreach($pisos as $piso)
              <tr>
                <th scope="row">{{$piso->id}}</th>
                <td>{{$piso->andar}}</td>

                <td><a href="{{route('pisos.edit', $piso->id)}}"><button type="button" class="btn btn-warning">Editar</button></a></td>
                <td>
                  <form action="{{ route('pisos.destroy', $piso->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta piso e todos os edifícios associados?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </td>
                <td><a href="{{route('pisos.showAssociate', $piso->id)}}"><button type="button" class="btn btn-success">Associar a edifícios</button></a></td>
                </td>
              </tr>
              @endforeach

              <!-- Exibe os links de paginação -->
              {{ $pisos->links() }}

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