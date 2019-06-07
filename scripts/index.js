function submitear(){
  for (var i = 1; i <= 3; i++) {
    enviarCantElems(i);
    enviarCantExtras(i);
  }
}

function enviarCantElems(tarea){
  var inp = document.createElement('input');
  inp.setAttribute("name","cantElems"+tarea);
  inp.setAttribute("hidden","true");
  inp.value=(cantElems[tarea]-1);
  $("#regForm").append(inp);
}

function enviarCantExtras(tarea){
  var inp = document.createElement('input');
  inp.setAttribute("name","cantExtras"+tarea);
  inp.setAttribute("hidden","true");
  inp.value=(cantExtras[tarea]-1);
  $("#regForm").append(inp);
}

function scrollToTop(){
  $('html,body').animate({ scrollTop: 0 }, 'slow');
  return false;
}

//Script para anular el enter
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
