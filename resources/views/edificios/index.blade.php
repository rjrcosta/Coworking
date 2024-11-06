<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de edificios') }}
    </h2>
    <a href="{{route('edificios.create')}}">
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
              <form action="{{ route('edificios.filtrar') }}" method="GET" class="d-flex justify-content-between align-items-center">
                <x-text-input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisa" />
                <x-buttons.search-button></x-buttons.search-button>
              </form>
            </x-slot>

            <!-- Paginação -->
            <x-slot name="paginacao">
              {{ $edificios->links() }}
            </x-slot>

            <!-- Mostrar etiquetas para tabela - Variável "labels" -->
            <x-slot name="labels">
              <th scope="col">Id</th>
              <th scope="col">Nome</th>
              <th scope="col">Cidade</th>
              <th scope="col" colspan="3" class="text-end">Opções</th>
            </x-slot>

            <!-- Loop para  mostrar os dados  nas linhas da tabela - Variável "foreach"  -->
            <x-slot name="foreach">
              @foreach($edificios as $edificio)
              <tr>
                <td>{{$edificio->id}}</td>
                <td>{{$edificio->nome}}</td>
                <td>{{$edificio->cidade->nome}}</td>
                <td class="d-flex justify-content-end">
                  <!-- Botão Show-->
                  <a href="{{route('edificios.show', $edificio->id)}}">
                    <x-buttons.show-button></x-buttons.show-button>
                  </a>
                  <!-- Botão Edit -->
                  <a href="{{route('edificios.edit', $edificio->id)}}">
                    <x-buttons.edit-button></x-buttons.show-button>
                  </a>
                  <!-- Botão  Delete -->
                  <form action="{{ route('edificios.destroy', $edificio->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este edifício?');">
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

  <!-- resources/views/edificios/create.blade.php -->
  <script>
    document.getElementById('addCidadeButton').addEventListener('click', function() {
      const nomeCidade = document.getElementById('add_nome').value;
      const token = document.querySelector('input[name="_token"]').value;

      fetch('{{ route("cidades.store") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({
            nome: nomeCidade
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Fecha o modal e recarrega a página para mostrar a nova cidade
            let modal = bootstrap.Modal.getInstance(document.getElementById('addCidadeModal'));
            modal.hide();

            window.location.href = "{{ route('edificios.create') }}";
          } else {
            alert(data.message); // Mostra a mensagem de erro retornada
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          alert('Erro ao adicionar a cidade.');
        });
    });
  </script>

  <!-- resources/views/pisos/showAssociated.blade.php -->
  <script>
    // Captura os valor dos inputs ocultos e transforma em objeto JavaScript
    const pisoId = document.getElementById('piso_id').value;

    // Cptura o valor da combobox de cidades
    let cidade = document.getElementById('cidade');

    // Captura o elemento de seleção de edifícios
    const edificiosSelect = document.getElementById('edificios');

    // Corre apenas se uma cidade foi selecionada
    if (cidade.value != "Selecione uma cidade") {

      // Adiciona um evento de mudança na combobox de cidades
      cidade.addEventListener('change', function() {
        const cidadeId = this.value;
        const edificiosSelect = document.getElementById('edificios');
        edificiosSelect.innerHTML = ''; // Limpar os edifícios existentes

        // Captura o valor do input oculto e transforma em objeto JavaScript
        let edificios = JSON.parse(document.getElementById('edificio_hidden').value);

        //console.log(edificios);

        // Se a cidade foi selecionada, mostrar os edifícios
        if (cidadeId) {
          // Obter apenas os edifícios da cidade selecionada
          edificios.forEach(edificio => {
            // Filtra a lista de edifícios pelo id da cidade
            if (edificio.cod_cidade == cidadeId) {
              // Construir uma nova opção a cada edifínio
              const option = document.createElement('option');
              option.value = edificio.id;
              option.textContent = edificio.nome;
              edificiosSelect.appendChild(option);
            }
          })
        }

      })

    }

    // Lógica para receber os edifícios selecionados e mandar para o controller
    // Adicionar evento ao botão de associar
    associateButton.addEventListener('click', function() {
      const selectedEdificios = Array.from(edificiosSelect.selectedOptions).map(option => option.value);
      const token = document.querySelector('input[name="_token"]').value;

      // Verificar se pelo menos um edifício foi selecionado
      if (selectedEdificios.length === 0) {
        alert('Por favor, selecione pelo menos um edifício.');
        return;
      }

      // Fazer o POST para o método associate do PisoController
      fetch('{{ route("pisos.associate") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({
            piso_id: pisoId, // Usar o ID do piso obtido do HTML
            edificios: selectedEdificios
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Associação realizada com sucesso!');
            // Redirecionar ou atualizar a página conforme necessário
            window.location.href = '{{ route("pisos.index") }}';
          } else {
            alert('Verifique se esse piso já foi associado a algum desses edifícios.');
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          alert('Erro ao associar os edifícios.');
        });
    });
  </script>


</x-index-layout>