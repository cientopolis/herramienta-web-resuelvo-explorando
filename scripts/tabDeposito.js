function crearDeposito(){
  cantidadDepositos++;
  if(cantidadDepositos<=3){
    var div = document.createElement('div');
    div.setAttribute("class","jumbotron");
    div.setAttribute("id","deposito"+cantidadDepositos);
    div.innerHTML = "<h3>Depósito "+ cantidadDepositos + "</h3>" +
      "<p> Criterio de depósito*: </p>"+
      "<p><input maxlength=\"50\" id=\"inputDepo" + cantidadDepositos + "\" placeholder=\"Ingrese el criterio de depósito\" oninput=\"this.className = '';limpiarCriterios()\" name=\"depoCriterio"+ cantidadDepositos + "\"></p>" +
      "<p> Descripción: </p>"+
      "<p><input maxlength=\"70\" class=\"optional\" id=\"descripcionDepo" + cantidadDepositos + "\" placeholder=\"Ingrese una descripción\" oninput=\"this.className = 'optional'\" name=\"depoDescripcion"+ cantidadDepositos + "\"></p>"+
      "<p>* campos obligatorios</p>";
    $("#botonCrearDepo").before(div);
    if(!criteriosDeDepositoIguales){
    if(cantidadDepositos == 3){
      $("#botonCrearDepo").hide();
    }
    if(cantidadDepositos > 2){
      $("#botonEliminarDepo").show();
    } else {
      $("#botonEliminarDepo").hide();
    }
  }
}
}

function eliminarDeposito(){
  $("#deposito"+cantidadDepositos).slideUp(300, function(){ $(this).remove();});
  cantidadDepositos--;
  if(cantidadDepositos <= 2){
    $("#botonEliminarDepo").hide();
  }
  if(cantidadDepositos <= 3){
    $("#botonCrearDepo").show();
  }
}

function limpiarCriterios() {
  for (var i = 1; i <= 3; i++) {
    limpiarCriteriosDeElementos(i)
  }
}

function esDeposito(tab) {
  return (tab == 3)
}

function criteriosDeDepositoIguales() {
  var depos = getDepositos();
  depos = depos
    .filter(Boolean)
    .map(({ criterio }) => criterio.value);
  if (new Set(depos).size == depos.length){
    return false
  }
  alert('No puede haber depósitos con criterios repetidos')
  return true
}