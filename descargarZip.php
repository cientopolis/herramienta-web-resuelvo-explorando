<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="libs\bootstrap\css\bootstrap.css">
  <meta charset="utf-8">
  <title>Descargar configuración</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>
<body style="background-color: #f3f3f3">
  <div class="container" style="margin-top: 50px">
    <div class="jumbotron">
      <h1>Herramienta Web para la configuración de Resuelvo Explorando</h1>
      <h2>Actividad: <?php echo $_GET['actividad']; ?></h2>
      <h3> Ya puedes descargar todos los archivos necesarios para la realización de la activdad educativa</h3>
      <div class="row" style="margin-top: 30px">
        <div class="col-3">
          <button type="button" class="btn btn-primary col-12" onclick="window.open('utils/Instrucciones de instalación.pdf','_blank')"><i class="fas fa-file-pdf"></i> Instrucciones de instalaci&oacute;n</button>
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-primary col-12" onclick="location.href='utils/ResuelvoExplorando.zip';"><i class="fas fa-file-archive"></i> Aplicaci&oacute;n configurada</button>
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-primary col-12"onclick="location.href='utils/CodigosQR.zip';"><i class="fas fa-qrcode"></i> C&oacute;digos QR</button>
        </div>
        <div class="col-3">
          <button type="button" class="btn btn-primary col-12" onclick="window.open('generarPDF.php?espaciosDeUso=<?php echo $_GET['espaciosDeUso'] ?>&verQRs=1&verEspacios=1','_blank');"><i class="fas fa-file-pdf"></i> Instructivo</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
