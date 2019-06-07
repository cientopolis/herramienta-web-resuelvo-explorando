function generarOpcionesDepositos(item){
  if(item != null){
    return "<option>"+item.criterio.value+"</option>";
  }
  else return "";
}

function agregarExtra(t){
  if(cantExtras[t]>1){
    contraerExtra(t,(cantExtras[t]-1))
  }
  var div = document.createElement('div');
  var idExtra = "extra"+ t + "-" + cantExtras[t];
  div.setAttribute("id",idExtra);
  div.setAttribute("class","jumbotron jumbotronChico");
  div.innerHTML =
    "<div id='contenedor"+idExtra+"'>"+
      "<div class=\"row\">"+
        "<p class=\"col-8\">Título:</p>"+"<href onclick=\"contraerExtra('" + t + "','" + cantExtras[t] + "')\"style='float:right'><i class=\"material-icons\">keyboard_arrow_up</i></href>"+
      "</div>"+
      "<p><input maxlength=\"50\" placeholder=\"Título\" oninput=\"this.className = ''\" id=\"titulo"+ idExtra + "\" name=\"titulo"+ idExtra + "\"></p>"+
      "<p>Contenido:</p>"+
      "<p><textarea maxlength=\"350\" style=\"min-width: 100%\" rows=\"4\" placeholder=\"Contenido\" oninput=\"this.className = ''\" name=\"contenido"+ idExtra + "\"></textarea></p>"+
      "<href onclick=\"eliminarExtra('" + idExtra + "','" + t + "')\" style='float:right'>Eliminar</href>"+
    "</div>"+
    "<div id='resumen"+idExtra+"'>"+
    "</div>";
  $("#agregarExtras"+t).before(div);
  cantExtras[t]++;
}

function agregarElemento(t){
  if(cantElems[t]>1){
    contraerElemento(t,(cantElems[t]-1))
  }
  var div = document.createElement('div');
  var idElemento = "elemento"+ t + "-" + cantElems[t];
  div.setAttribute("id",idElemento);
  div.setAttribute("class","jumbotron jumbotronChico");
  var depoOptions = "<option></option>";
  var depositos = getDepositos();
  for (var i = 0; i <= cantidadDepositos; i++) {
    depoOptions += generarOpcionesDepositos(depositos[i]);
  };
  div.innerHTML =
    "<div id='contenedor"+idElemento+"'>"+
      "<div class=\"row\">"+
        "<p class=\"col-8\">Nombre*:</p>"+
        "<div class=\"col-4\">"+
          "<href onclick=\"contraerElemento('" + t + "','" + cantElems[t] + "')\" style='float:right'><i class=\"material-icons\">keyboard_arrow_up</i></href>"+
        "</div>"+
      "</div>"+
      "<p><input maxlength=\"50\" placeholder=\"Nombre\" oninput=\"this.className = ''\" id=\"nombre"+ idElemento + "\" name=\"nombre"+ idElemento + "\"></p>"+
      "<p>Descripción:</p>"+
      "<p><input maxlength=\"50\" class=\"optional\" placeholder=\"Descripción\" oninput=\"this.className = 'optional'\" id=\"descripcion"+ idElemento + "\" name=\"descripcion"+ idElemento + "\"></p>" +
      "<p>Criterio de depósito:</p>"+
      "<select class=\"form-control\" oninput=\"this.className = 'form-control'\" name=\"depo" + idElemento + "\" id=\"depo" + idElemento + "\">"+depoOptions+"</select>"+
      "<p>¿Es correcto recolectarlo?</p>"+
      "<div class=\"form-check-inline\">"+
        "<input style=\"width:auto\" class=\"form-check-input\" type=\"radio\" name=\"ok" + idElemento + "\" id=\"ok" + idElemento + "\" value=\"1\" checked>"+
        "<label class=\"form-check-label\" for=\"inlineRadio2\">Si</label>"+
      "</div>"+
      "<div class=\"form-check-inline\">"+
        "<input style=\"width:auto\" class=\"form-check-input\" type=\"radio\" name=\"ok" + idElemento + "\" id=\"noOk" + idElemento + "\" value=\"0\">"+
        "<label class=\"form-check-label\" for=\"inlineRadio2\">No</label>"+
      "</div>"+
      "<href onclick=\"eliminarElemento('" + idElemento + "','" + t + "')\" style='float:right; margin-top: 25px' >Eliminar</href>"+
    "</div>"+
    "<div id='resumen"+idElemento+"'>"+
    "</div>";
  //$("#agregarElementos"+t).before(div);
  $(div).insertBefore("#agregarElementos"+t).slideDown();
  cantElems[t]++;
  getDepositos();
}



function eliminarElemento(elem, tarea){
  $("#"+elem).slideUp(300, function(){ $(this).remove();});
  cantElems[tarea]--;
}

function eliminarExtra(extra, tarea){
  console.log(tarea);
  console.log(cantExtras[tarea]);
  $("#"+extra).slideUp(300, function(){ $(this).remove();});
  cantExtras[tarea]--;
  console.log(cantExtras[tarea]);
}

function expandirElemento(tarea, elemento){
  $("#contenedorelemento"+ tarea + "-" + elemento).slideDown();
  $("#resumenelemento"+ tarea + "-" + elemento).fadeOut();
}

function contraerElemento(t, elemento){
  $("#contenedorelemento"+ t + "-" + elemento).slideUp();
  var nombre = document.getElementById("nombreelemento"+ t + "-" + elemento).value
  if(nombre.length === 0){
    nombre="..."
  }
  var resumen = "<div class='row'><p class='col-9'>"+nombre+"</p><a class='col-3' onclick='expandirElemento("+t+","+elemento+")' href='javascript:void(0);'><i class=\"material-icons\">keyboard_arrow_down</i></a></div>"
  document.getElementById("resumenelemento"+ t + "-" + elemento).innerHTML = resumen
  $("#resumenelemento"+ t + "-" + elemento).fadeIn();
}

function esVacio(t){
  if (t) {
    return ((cantElems[t]- 1) == 0)
  }
  return false;
}

function esTarea(currentTab){
  if (currentTab > 3 && currentTab <= 6) {
    return currentTab - 3;
  }
  else {
    return false;
  }
}

function expandirExtra(tarea, extra){
  $("#contenedorextra"+ tarea + "-" + extra).slideDown();
  $("#resumenextra"+ tarea + "-" + extra).fadeOut();
}

function contraerExtra(t, extra){
  $("#contenedorextra"+ t + "-" + extra).slideUp();
  var nombre = document.getElementById("tituloextra"+ t + "-" + extra).value
  if(nombre.length === 0){
    nombre="..."
  }
  var resumen = "<div class='row'><p class='col-9'>"+nombre+"</p><a onclick='expandirExtra("+t+","+extra+")' href='javascript:void(0);'><i class=\"material-icons\">keyboard_arrow_down</i></a>"
  document.getElementById("resumenextra"+ t + "-" + extra).innerHTML = resumen
  $("#resumenextra"+ t + "-" + extra).fadeIn();
}

function limpiarCriteriosDeElementos(t) {
  for (var i = 1; i < cantElems[t]; i++) {
    limpiarCriterioDeElemento("elemento"+ t + "-" + i)
  }
}

function limpiarCriterioDeElemento(id) {
  var select = document.getElementById('depo'+id)
  var depoOptions = "<option></option>";
  var depositos = getDepositos();
  for (var i = 0; i <= cantidadDepositos; i++) {
    depoOptions += generarOpcionesDepositos(depositos[i]);
  };
  select.innerHTML = depoOptions
  select.value = ''
}


function elementosIguales(tarea) {
  var elementos = getElementos(tarea);
  elementos = elementos
    .filter(Boolean)
    .map(({ nombre }) => nombre);
  if (new Set(elementos).size == elementos.length){
    return false
  }
  alert('No puede haber elementos repetidos')
  return true
}

function validarElementoCompleto(elemento, estaCompleto){
  if (estaCompleto) {
    elemento.className ='jumbotron jumbotronChico elementoInvalido'
  } else {
    elemento.className ='jumbotron jumbotronChico'
  }
}
