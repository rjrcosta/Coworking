<nav x-data="{ open: false }" class="">

  <!-- Cabeçalho para o token CSRF, necessário para requisições POST no Laravel -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- SCRIPTS BOOTSTRAP -->
  <!-- Styles / Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



  <!-- Modal -->
  <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="cidadeSelect">Selecionar Cidade</label>
            <select id="cidadeSelect" class="form-control">
              <option value="">Selecionar Cidade</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edificioSelect">Selecionar Edificio</label>
            <select id="edificioSelect" class="form-control">
              <option value="">Selecionar Edificio</option>
            </select>
          </div>
          <!-- Outros campos conforme necessário -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submitBooking">Confirmar</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Javascript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const bookingModal = document.getElementById('bookingModal');
      const cidadeSelect = document.getElementById('cidadeSelect');
      const edificioSelect = document.getElementById('edificioSelect');

      if (bookingModal) {
        // Carregar cidades ao abrir o modal
        bookingModal.addEventListener('show.bs.modal', function() {
          fetch('/cidades')
            .then(response => response.json())
            .then(data => {
              cidadeSelect.innerHTML = '<option value="">Selecionar Cidade</option>'; // Limpa opções anteriores
              data.forEach(cidade => {
                const option = document.createElement("option");
                option.value = cidade.id;
                option.textContent = cidade.nome;
                cidadeSelect.appendChild(option);
              });
            })
            .catch(error => console.error("Erro ao carregar cidades:", error));
        });

        // Focar na combobox de cidades após o modal ser mostrado
        bookingModal.addEventListener('shown.bs.modal', function() {
          cidadeSelect.focus(); // Foca na combobox de cidades
        });

        // Carregar edifícios ao mudar a cidade selecionada
        cidadeSelect.addEventListener('change', function() {
          const cidadeId = this.value;
          if (cidadeId) {
            fetch(`/reservas/edificios/${cidadeId}`)
              .then(response => response.json())
              .then(data => {
                edificioSelect.innerHTML = '<option value="">Selecionar Edificio</option>'; // Limpa opções anteriores
                data.forEach(edificio => {
                  const option = document.createElement("option");
                  option.value = edificio.id;
                  option.textContent = edificio.nome;
                  edificioSelect.appendChild(option);
                });
              })
              .catch(error => console.error("Erro ao carregar edifícios:", error));
          } else {
            edificioSelect.innerHTML = '<option value="">Selecionar Edificio</option>'; // Limpa opções se nenhuma cidade for selecionada
          }
        });
      } else {
        console.error("O modal 'bookingModal' não foi encontrado.");
      }
    });
  </script>

  <!-- Include do seu script no final do body -->
  <script src="caminho/para/seu/bookForm.js"></script>
</nav>