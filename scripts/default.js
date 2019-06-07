function showTab(n) {
  // This function will display the specified tab of the form...
  scrollToTop();
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    document.getElementById("nextBtn").innerHTML = "Comenzar";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("descargarBtn").style.display = "inline"
    crearActividad();
    mostrarDepositos();
    mostrarTareas();
  } else if (n != 0) {
    document.getElementById("nextBtn").style.display = "inline";
    document.getElementById("descargarBtn").style.display = "none"
    document.getElementById("nextBtn").innerHTML = "Siguiente";
  }
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  valid = validateFields("input");
  valid = validateFields("textarea") && valid;
  valid = validateFields("select") && valid;
  if(esTarea(currentTab)){
    if (esVacio(esTarea(currentTab))) {
      alert("Debe ingresar al menos un elemento");
      return false;
    } else{
      if (elementosIguales(esTarea(currentTab))){
        return false
      }
    }
  }
  if (esDeposito(currentTab) && valid) {
     if (criteriosDeDepositoIguales()){
       return false
     }
  }
  return valid; // return the valid status
}

function validateFields(className) {
  var x, y, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName(className);
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if ((y[i].value == "") && !(y[i].classList.contains("optional")))  {
      //Revisar que sea un campo de elemento
      var esValido = true
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    } else {
      var esValido = false
    }
    if (y[i].id.startsWith('depoelemento') || y[i].id.startsWith('nombreelemento')) {
      validarElementoCompleto(y[i].parentElement.parentElement,esValido)
    }
  }
  return valid;
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("nav-item");
  for (i = 0; i < x.length; i++) {
    if(i < n){
      x[i].className = "nav-item done"
    } else {
      x[i].className = "nav-item"
    }
  }
  //... and adds the "active" class on the current step:
  x.item(n).className += " active";
}

