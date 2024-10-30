<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de Mensagens') }}
    </h2>

  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-black-900 dark:text-black-100">
          <nav class="navbar navbar-light">

            <!-- Paginação -->
            <x-slot name="paginacao">
              {{ $contactos->links() }}
            </x-slot>

            <!-- Mostrar etiquetas para tabela - Variável "labels" -->
            <x-slot name="labels">
              <th scope="col">Id</th>
              <th scope="col">Nome</th>
              <th scope="col">mensagem</th>
              <th scope="col" colspan="3" class="text-end">Opções</th>
            </x-slot>

            <!-- Loop para  mostrar os dados  nas linhas da tabela - Variável "foreach"  -->
            <x-slot name="foreach">
              @foreach($contactos as $contacto)
              <tr>
                <td>{{$contacto->id}}</td>
                <td>{{$contacto->nome}}</td>
                <td>{{$contacto->message}}</td>
                <td class ="d-flex justify-content-end">
                  <!-- Botão Show -->
                  <a href="">
                    <x-buttons.show-button></x-buttons.delete-button>
                  </a>
                  <!-- Botão Edit -->
                  <!-- <a href="">
                    <x-buttons.edit-button></x-buttons.delete-button>
                  </a> -->
                  <!-- Botão  Delete -->
                  <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta mensagem?');">
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