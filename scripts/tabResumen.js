class Deposito {
  constructor(criterio, descripcion) {
    this.criterio = criterio;
    this.descripcion = descripcion;
  }
}

class Tarea {
  constructor(nombre, descripcion, consigna) {
      this.nombre = nombre;
      this.descripcion = descripcion;
      this.consigna = consigna;
  }
}

class Elemento {
  constructor(nombre, descripcion, deposito, ok) {
      this.nombre = nombre;
      this.descripcion = descripcion;
      this.deposito = deposito;
      this.ok = ok
  }
}

function getDepositos(){
  var depositos = [null];
  for (var i = 1; i <= cantidadDepositos; i++) {
    let depoAux = new Deposito(document.getElementById("inputDepo" + i),document.getElementById("descripcionDepo" + i));
    depositos[i] = depoAux;
  }
  return depositos;
}

function getTareas(){
  var tareas = [null];
  for (var i = 1; i <= 3; i++) {
    let tareaAux = new Tarea(document.getElementById("nombreTarea" + i).value,document.getElementById("descripcionTarea" + i).value,document.getElementById("consignaTarea" + i).value);
    tareas[i] = tareaAux;
  }
  return tareas;
}

function getElementos(tarea){
  var elementos = [null];
  for (var i = 1; i < cantElems[tarea]; i++) {
    var id = "#nombreelemento" + tarea + "-" + i;
    if ($(id).length > 0) {
      ok = false
      if(document.getElementById("okelemento" + tarea + "-" + i).checked) {
        ok=true
      }
      let elemAux = new Elemento(document.getElementById("nombreelemento" + tarea + "-" + i).value,document.getElementById("descripcionelemento" + tarea + "-" + i).value,document.getElementById("depoelemento" + tarea + "-" + i).value,ok);
      elementos.push(elemAux);
    }
  }
  return elementos;
}


function mostrarDepositos(){
  document.getElementById("muestraDepositos").innerHTML = "<h2>Depósitos:</h2>"
  getDepositos().forEach(imprimirDeposito);
}

function mostrarTareas(){
  document.getElementById("muestraTareas").innerHTML = "<h2>Tareas:</h2>"
  getTareas().forEach(imprimirTarea);
}

function mostrarElementos(tarea){
  getElementos(tarea).forEach(function (item, index) {
    imprimirElemento(item, index, tarea)
  });
}

function crearActividad(){
    var nombreActividad = document.getElementById("nombreActividad").value;
    document.getElementById("actividadFinal").innerHTML = "<h1>" + nombreActividad + "</h1> ";
}

function imprimirDeposito(item, index){
  if(item != null){
    var criterio = document.createElement('h4');
    criterio.appendChild(document.createTextNode(item.criterio.value));
    var descripcion = document.createElement('p');
    descripcion.appendChild(document.createTextNode(/*"Descripción:" + */item.descripcion.value));
    descripcion.classList.add("card-subtitle");
    descripcion.classList.add("mb-2");
    descripcion.classList.add("text-muted");
    var depo = document.createElement('div');
    depo.appendChild(criterio);
    depo.appendChild(descripcion);
    depo.classList.add('card-body');
    var card = document.createElement('div');
    card.classList.add("card");
    card.appendChild(depo);
    document.getElementById("muestraDepositos").append(card);
  }
}

function imprimirTarea(item, index){
  if(item != null){
    var nombre = document.createElement('h4');
    nombre.appendChild(document.createTextNode(item.nombre));
    var descripcion = document.createElement('h5');
    descripcion.appendChild(document.createTextNode(item.descripcion+" "));
    descripcion.classList.add("card-subtitle");
    descripcion.classList.add("mb-2");
    descripcion.classList.add("text-muted");
    descripcion.appendChild(document.createTextNode(item.consigna))
    var elementos = document.createElement('p');
    elementos.appendChild(document.createTextNode("Elementos:"));
    var tarea = document.createElement('div');
    var listaDeElementos = document.createElement('ul');
    listaDeElementos.setAttribute("id", "listaDeElementos"+index)
    tarea.appendChild(nombre);
    tarea.appendChild(descripcion);
    tarea.appendChild(elementos);
    tarea.appendChild(listaDeElementos);
    tarea.classList.add("card-body");
    var card = document.createElement('div');
    card.classList.add("card");
    card.appendChild(tarea);
    document.getElementById("muestraTareas").append(card);

    var correctos = document.createElement('p');
    correctos.appendChild(document.createTextNode("Elementos correctos:"));
    var elementosCorrectos = document.createElement('ul');
    elementosCorrectos.setAttribute("id", "elementosCorrectos"+index);
    var incorrectos = document.createElement('p');
    incorrectos.appendChild(document.createTextNode("Elementos incorrectos:"));
    var elementosIncorrectos = document.createElement('ul');
    elementosIncorrectos.setAttribute("id", "elementosIncorrectos"+index);
    listaDeElementos.appendChild(correctos);
    listaDeElementos.appendChild(elementosCorrectos);
    listaDeElementos.appendChild(incorrectos);
    listaDeElementos.appendChild(elementosIncorrectos);
    mostrarElementos(index);
  }
}

function imprimirElemento(item, index, tarea){
  if(item != null){
    var nombre = document.createElement('li');
    nombre.appendChild(document.createTextNode(item.nombre));
    var elemento = document.createElement('div');
    elemento.appendChild(nombre);
    if (item.ok) {
      document.getElementById("elementosCorrectos"+tarea).append(elemento);
    } else {
      document.getElementById("elementosIncorrectos"+tarea).append(elemento);
    }
  }
}
