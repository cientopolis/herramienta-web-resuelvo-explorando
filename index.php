<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="estilos/index.css">
    <link rel="stylesheet" type="text/css" href="estilos/tarea.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/index.js"></script>
    <script type="text/javascript" src="scripts/tabDeposito.js"></script>
    <script type="text/javascript" src="scripts/tabTarea.js"></script>
    <script type="text/javascript" src="scripts/tabResumen.js"></script>
    <link href="libs\SmartWizard-master\src\css\smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="libs\SmartWizard-master\src\js\jquery.smartWizard.js"></script>
    <script type="text/javascript">
      var currentTab = 0; // Current tab is set to be the first tab (0)
      var cantidadDepositos = 0;
      var cantExtras = [0,1,1,1];
      var cantElems = [0,1,1,1];
      $(document).ready(function(){
        $('#smartwizard').smartWizard();
        showTab(currentTab); // Display the crurrent tab
        crearDeposito();
        crearDeposito();
      });
    </script>
    <script type="text/javascript" src="scripts/default.js"></script>
  </head>
  <body>
    <h1 id="titulo"></h1>
    <div id="smartwizard" class="sw-main sw-theme-arrows">
      <ul>
        <li><a><p>Inicio</p></a></li>
        <li><a><p>Actividad</p></a></li>
        <li><a><p>Espacio físico</p></a></li>
        <li><a><p>Depósitos</p></a></li>
        <li><a><p>Tarea 1</p></a></li>
        <li><a><p>Tarea 2</p></a></li>
        <li><a><p>Tarea 3</p></a></li>
        <li><a><p>Resumen</p></a></li>
      </ul>
    </div>
    <div class="row" style="margin:auto">
      <form id="regForm" class="col-md-9 col-xs-12" action="generarArchivo.php" method="post" onsubmit="submitear()" accept-charset="UTF-8"">
        <!-- One "tab" for each step in the form: -->
        <?php
        include 'tabs/bienvenida.html';
        include 'tabs/configuracionActividad.html';
        include 'tabs/configuracionEspacioFisico.html';
        include 'tabs/depositos.html';
        for ($numTarea=1; $numTarea <= 3 ; $numTarea++) {
          include "tabs/tarea.php";
        }
        include 'tabs/modalPreview.html';
        include 'tabs/resumen.html';
        ?>
        <div style="overflow:auto;">
          <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            <button type="submit" id="descargarBtn" name="submitButton" style="display:none">Descargar</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
