<nav x-data="{ open: false }" class="">

  <!-- SCRIPTS BOOTSTRAP -->
  <!-- Styles / Scripts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



  <form class="m-0 w-100" id="regForm" action="{{ route('login') }}">
    
    <div class="tab">

    <h3 class="text-center m-5">You have to log in to make a reservation</h3>

    </div>

    <div class="modal-footer">
      <button id="login" type="submit" class="btn btn-outline-dark  rounded-1">Log in</button>
     
    </div>

  </form>
 
  <!-- Javascript para multistep form -->
  <script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
      // This function will display the specified tab of the form ...
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      // ... and fix the Previous/Next buttons:
      document.getElementById("login").style.display = "inline";
      document.getElementById("signin").style.display = "inline";

    }
    // Call this function when the page loads to ensure the state is correct
    window.onload = function() {
      showTab(currentTab);
    };


  </script>



  
</nav>