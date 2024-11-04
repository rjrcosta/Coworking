<nav x-data="{ open: false }" class="">

  <!-- SCRIPTS BOOTSTRAP -->
  <!-- Styles / Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



  <form class="m-0 w-100" id="regForm" action="#">

    <!-- One "tab" for each step in the form: -->
    <!-- Primeira TAB -->
    <div class="tab">
      <h5>Data</h5>
      <input type="text" id="datepicker" placeholder="Choose Date" name="data" class="rounded-2">



      <!-- Escolha Horário -->
      <div class="mt-5">
        <h5>Horário</h5>
        <div class="form-check">
          <input class="form-check-input input" type="radio" name="periodo" id="periodoManha" value="option1">
          <label class="form-check-label" for="exampleRadios1">
            Manhã
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input input" type="radio" name="periodo" id="periodoTarde" value="option2">
          <label class="form-check-label" for="exampleRadios2">
            Tarde
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input input" type="radio" name="periodo" id="periodoCompleto" value="option3">
          <label class="form-check-label" for="exampleRadios3">
            Dia completo
          </label>
        </div>
      </div>
    </div>


    <!-- Segunda TAB -->
    <div class="tab">

      <!-- Escolha Cidade -->
      <select class="form-select m-3" name="cod_cidade" id="cod_cidade_picker" aria-label="Default select example">
        <option selected>Selecionar Cidade</option>
        @foreach ($cidades as $cidade)
        <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
        @endforeach
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>

      <!-- Escolha Edificio -->
      <select class="form-select m-3" name="id"  id="id_edificio_picker" aria-label="Default select example">
        <option selected>Selecionar Edificio</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>

    </div>

    <!-- Terceira TAB -->
    <div class="tab">

    <div class="tab">
        <select class="form-select m-3" name="lugares" aria-label="Numero de Lugares a Reservar" required>
            <option selected disabled>Numero de Lugares a Reservar</option>
            <?php for ($i = 1; $i <= 20; $i++) : ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>

    </div>

    <!-- Quarta TAB -->
    <div class="tab">

      <h5>Estás Quase lá!. Só precisas de confirmar a tua reserva</h5>

    </div>


    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
      <span class="step"></span>
      <span class="step"></span>
      <span class="step"></span>
      <span class="step"></span>

    </div>

    <div class="modal-footer">
      <button id="prevBtn" onclick="nextPrev(-1)" type="button" class="btn btn-outline-dark rounded-1">Previous</button>
      <button id="nextBtn" onclick="nextPrev(1)" type="button" class="btn btn-outline-dark rounded-1">Next</button>
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
      $("#datepicker").datepicker();
    });
  </script>

  <!-- Javascript para multistep form -->
  <script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
      // This function will display the specified tab of the form ...
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      // ... and fix the Previous/Next buttons:
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
      }
      if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
      } else {
        document.getElementById("nextBtn").innerHTML = "Next";
      }
      // ... and run a function that displays the correct step indicator:
      fixStepIndicator(n)
    }
    // Call this function when the page loads to ensure the state is correct
    window.onload = function() {
      showTab(currentTab);
    };

    function nextPrev(n) {
      // This function will figure out which tab to display
      var x = document.getElementsByClassName("tab");
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()) return false;
      // Hide the current tab:
      x[currentTab].style.display = "none";
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;
      // if you have reached the end of the form... :
      if (currentTab >= x.length) {
        //...the form gets submitted:
        document.getElementById("regForm").submit();
        return false;
      }
      // Otherwise, display the correct tab:
      showTab(currentTab);
    }

    function validateForm() {
      // This function deals with validation of the form fields
      var x, y, z, i, valid = true;
      x = document.getElementsByClassName("tab");
      y = x[currentTab].getElementsByTagName("input");
      z = x[currentTab].getElementsByTagName("select");
      t = x[currentTab].getElementsByClassName('form-check-input')

      // A loop that checks every input field in the current tab:
      for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
          // add an "invalid" class to the field:
          y[i].className += " invalid";
          // and set the current valid status to false:
          valid = false;
        }
      }

      // A loop that checks every select field in the current tab:
      for (i = 0; i < z.length; i++) {
        // If the selected value is the default option (e.g., "Selecionar Cidade")
        if (z[i].value === "Selecionar Cidade" || z[i].value === "Selecionar Edificio" || z[i].value === "Numero de Lugares a Reservar") {
          // add an "invalid" class to the select:
          z[i].className += " invalid";
          // and set the current valid status to false:
          valid = false;
        }
      }

      // Check for radio button groups
      var radioGroups = {}; // Object to track radio button groups
      for (i = 0; i < t.length; i++) {
        var name = t[i].name; // Get the name of the radio button group
        if (!radioGroups[name]) {
          radioGroups[name] = false; // Initialize as not selected
        }
        if (t[i].checked) {
          radioGroups[name] = true; // Mark as selected if checked
        }
      }

      // Check if any radio group is not selected
      for (var group in radioGroups) {
        if (!radioGroups[group]) {
          // If the group is not selected, add invalid class to the first radio button in the group
          var firstRadio = document.querySelector(`input[name="${group}"]`);
          if (firstRadio) {
            firstRadio.className += " invalid";
          }
          valid = false; // Set valid to false
        }
      }

      // If the valid status is true, mark the step as finished and valid:
      if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
      }
      return valid; // return the valid status
    }

    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
      }
      //... and adds the "active" class to the current step:
      x[n].className += " active";
    }
  </script>

</nav>