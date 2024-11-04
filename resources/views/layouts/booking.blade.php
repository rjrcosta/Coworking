<nav x-data="{ open: false }">

  <!-- SCRIPTS BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <form class="m-0 w-100" id="regForm" action="{{ route('reservas.store') }}" method="POST" onsubmit="console.log('Formulário submetido')">
    @csrf <!-- Token CSRF para segurança -->

    <!-- Primeira TAB -->
    <div class="tab">
      <label hidden for="user_id" class="form-label">Utilizador</label>
      <input hidden type="text" id="user_id" name="usuario" value="{{ Auth::user()->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
      <br><br>
      <h5>Escolha Cidade e Edifício</h5>
      <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="cidade_id" id="cod_cidade_picker" aria-label="Default select example">
        <option selected>Selecionar Cidade</option>
        @foreach ($cidades as $cidade)
        <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
        @endforeach
      </select>

      <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="edificio_id" id="id_edificio_picker" aria-label="Default select example">
        <option selected>Selecionar Edificio</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>

    <!-- Segunda TAB -->
    <div class="tab" style="display:none;">
      <h5>Data e Horário</h5>
      <input type="text" id="datepicker" placeholder="Escolher Data" name="data" class="rounded-2">

      <h5>Horário</h5>
      <div class="form-check">
        <input class="form-check-input input" type="radio" name="periodo" id="manha" value="manha">
        <label class="form-check-label" for="manha">Manhã</label>
      </div>

      <div class="form-check">
        <input class="form-check-input input" type="radio" name="periodo" id="tarde" value="tarde">
        <label class="form-check-label" for="tarde">Tarde</label>
      </div>

      <div class="form-check">
        <input class="form-check-input input" type="radio" name="periodo" id="ambos" value="ambos">
        <label class="form-check-label" for="ambos">Dia completo</label>
      </div>
    </div>

    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
      <span class="step"></span>
      <span class="step"></span>
    </div>

    <!-- Botões de Navegação -->
    <div style="margin-top: 20px;">
      <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">Next</button>
      <button type="button" id="prevBtn" class="btn btn-secondary" onclick="nextPrev(-1)" style="display:none;">Previous</button>
      <button type="button" id="submitBtn" class="btn btn-primary" onclick="capturarDados()" style="display:none;">Submit</button>
    </div>

  </form>
  <!-- fim do formulário _________________________________________________-->

  <!-- DATAPICKER -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- Javascript para escolher data -->
  <script>
    $(function() {
      $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0
      });
    });
  </script>

  <!-- Script para obter os edifícios da cidade selecionada -->
  <script>
    document.getElementById('cod_cidade_picker').addEventListener('change', function() {
      const cidadeId = this.value;
      fetch(`/reservas/edificios/${cidadeId}`)
        .then(response => response.json())
        .then(data => {
          const edificioSelect = document.getElementById('id_edificio_picker');
          edificioSelect.innerHTML = '<option value="">Selecionar Edifício</option>'; // Limpar opções
          data.forEach(edificio => {
            const option = document.createElement('option');
            option.value = edificio.id;
            option.textContent = edificio.nome;
            edificioSelect.appendChild(option);
          });
        })
        .catch(error => console.error('Erro ao buscar edifícios:', error));
    });
  </script>

  <!-- Javascript para multistep form -->
  <script>
    var currentTab = 0; // Tab atual é a primeira (0)
    showTab(currentTab); // Exibe a tab atual

    function showTab(n) {
      var x = document.getElementsByClassName("tab");
      if (!x[n]) return; // Sai da função se a aba não existir
      x[n].style.display = "block"; // Exibe a aba atual
      fixStepIndicator(n);

      // Esconde o botão Previous na primeira aba
      document.getElementById("prevBtn").style.display = (n === 0) ? "none" : "inline";
      // Mostra o botão Submit apenas na última aba
      document.querySelector("button[onclick='capturarDados()']").style.display = (n === 1) ? "inline" : "none";
      // Esconde o botão Next na última aba
      document.getElementById("nextBtn").style.display = (n === 1) ? "none" : "inline";
    }

    function nextPrev(n) {
      var x = document.getElementsByClassName("tab");
      if (n === 1 && !validateForm()) return; // Se "Next" for clicado, valida o formulário da aba atual

      x[currentTab].style.display = "none"; // Oculta a aba atual
      currentTab += n; // Avança ou retrocede na aba
      if (currentTab >= x.length) {
        // Se na última aba, chamar a função para capturar dados
        capturarDados();
        return;
      }
      showTab(currentTab); // Exibe a nova aba
    }

    function validateForm() {
      // Aqui você pode adicionar validações para os campos da aba atual
      // Exemplo: verificar se um campo está vazio
      var x = document.getElementsByClassName("tab")[currentTab].getElementsByTagName("input");
      for (var i = 0; i < x.length; i++) {
        if (x[i].value === "") {
          alert("Por favor, preencha todos os campos.");
          return false;
        }
      }
      return true; // Todos os campos estão preenchidos
    }

    function capturarDados() {
      const cidade = document.getElementById('cod_cidade_picker').value;
      const edificio = document.getElementById('id_edificio_picker').value;
      const data = document.getElementById('datepicker').value;
      const periodo = document.querySelector('input[name="periodo"]:checked')?.id || "Não selecionado";
      const utilizadorId = document.getElementById('user_id').value;

      console.log("Cidade:", cidade);
      console.log("Edifício:", edificio);
      console.log("Data:", data);
      console.log("Período:", periodo);
      console.log("Utilizador ID:", utilizadorId);

      if (validateForm()) {
        console.log("Formulário preenchido corretamente");
        document.getElementById("regForm").submit(); // Envia o formulário
      } else {
        alert("Por favor, preencha todos os campos obrigatórios.");
      }

    }

    function fixStepIndicator(n) {
      var x = document.getElementsByClassName("step");
      for (var i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", ""); // Remove 'active' da classe
      }
      x[n].className += " active"; // Adiciona 'active' à aba atual
    }
  </script>

</nav>