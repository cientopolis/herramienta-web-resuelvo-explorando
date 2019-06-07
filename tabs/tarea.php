<div class="tab"><h2>Tarea <?php echo $numTarea; ?>:</h2>
  <div class="jumbotron">
    <div class="col-12">
      <p>Nombre*:</p>
      <p><input maxlength="50" id="nombreTarea<?php echo $numTarea; ?>" placeholder="Nombre" oninput="this.className = ''; ajustarValor('charactersName<?php echo $numTarea; ?>','nombreTarea<?php echo $numTarea; ?>', 50) " name="t<?php echo $numTarea; ?>nombre"></p>
      <p id = "charactersName<?php echo $numTarea; ?>" style="float:right;" >50</p>
    </div>
    <div class="col-12">
      <p>Consigna larga*:</p>
      <p><textarea maxlength="360" id="descripcionTarea<?php echo $numTarea; ?>" style="min-width: 100%" rows="4" placeholder="Consigna larga" oninput=" this.className = ''; ajustarValor('charactersCantConsLarga<?php echo $numTarea; ?>','descripcionTarea<?php echo $numTarea; ?>', 360) " name="t<?php echo $numTarea; ?>desc"></textarea></p>
      <p  id = "charactersCantConsLarga<?php echo $numTarea; ?>">360</p>
    </div>
    <div class="col-12">
      <p>Consigna corta*:</p>
      <p><textarea maxlength="140" id="consignaTarea<?php echo $numTarea; ?>" style="min-width: 100%" rows="2" placeholder="Consigna corta" oninput="this.className = ''; ajustarValor('charactersCantConsCorta<?php echo $numTarea; ?>','consignaTarea<?php echo $numTarea; ?>', 140)" name="t<?php echo $numTarea; ?>con"></textarea></p>
      <p  id = "charactersCantConsCorta<?php echo $numTarea; ?>">140</p>
    </div>
    <p>* campos obligatorios</p>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPreview" onclick="actualizarPreview(<?php echo $numTarea; ?>)">
      <i class="material-icons">phone_android</i>
      Previsualizar en el dispositivo
    </button>
  </div>
  <div class="row">
    <div class="col-xl-5 col-12 jumbotron">
      <h3>Elementos</h3>
      <button type="button" id="agregarElementos<?php echo $numTarea; ?>" onclick="agregarElemento(<?php echo $numTarea; ?>)"> <img src="images/plusIcon.png" height="20" width="20" >Agregar elemento</button>
    </div>
    <div class="col-xl-5 col-12 jumbotron">
      <h3>Material adicional</h3>
      <button type="button" id="agregarExtras<?php echo $numTarea; ?>" onclick="agregarExtra(<?php echo $numTarea; ?>)"><img src="images/plusIcon.png" height="20" width="20" > Agregar material </button>
    </div>
  </div>
</div>




<script type="text/javascript">
function actualizarPreview(tarea) {
  document.getElementById('preview1').innerHTML = (document.getElementById("descripcionTarea"+tarea).value);
  document.getElementById('preview2').innerHTML = (document.getElementById("consignaTarea"+tarea).value);
  if (document.getElementById('espacio1').checked) {
      var direccion = "utils/ResuelvoExplorando1/Configuracion/Imagenes/task";
  }
  else {
    var direccion = "utils/ResuelvoExplorando2/Configuracion/Imagenes/task";
  }
  var imagen = direccion.concat(tarea , ".png");
  document.getElementById('espacioDeUso').src = imagen;
}

function ajustarValor(id, idInput, cantCarcteres){
  var cantRestante = (cantCarcteres - document.getElementById(idInput).value.length);
  document.getElementById(id).innerHTML = (cantCarcteres - document.getElementById(idInput).value.length);
  if (cantRestante <= 20) {
    convertToRed(id);
  }
  else {
    convertToBlack(id);
  }
}

function convertToRed(id){
  document.getElementById(id).style.color = 'red';
}

function convertToBlack(id){
  document.getElementById(id).style.color = 'black';
}

</script>
