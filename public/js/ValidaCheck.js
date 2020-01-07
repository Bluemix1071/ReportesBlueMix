$('#FormActivacion').submit(function(e){
  // si la cantidad de checkboxes "chequeados" es cero,
  // entonces se evita que se envíe el formulario y se
  // muestra una alerta al usuario
  if ($('input[type=checkbox]:checked').length === 0) {
      e.preventDefault();
      alert('Debe seleccionar al menos una tarjeta ');
  }
  var desde = document.getElementById('Desde').value;
  var desdeEnviar= document.getElementById('DesdeEnviar').value = desde;

  var hasta = document.getElementById('Hasta').value;
  var hastaEnviar= document.getElementById('HastaEnviar').value = hasta;
 // console.log(desdeEnviar,hastaEnviar);
});

// Use 'prop' instead of 'attr'
// 'attr' only work the first time, better use 'prop'

// add multiple select/unselect functionality
$("#selectall").on("click", function() {
    $(".case").prop("checked", this.checked);
  });
  
  // if all checkbox are selected, check the selectall checkbox and viceversa
  $(".case").on("click", function() {
    if ($(".case").length == $(".case:checked").length) {
      $("#selectall").prop("checked", true);
    } else {
      $("#selectall").prop("checked", false);
    }
  });