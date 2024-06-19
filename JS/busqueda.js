
function buscarPorUsuario() {
  var input, filter, tarjetas, tarjeta, usuario, i, txtValue;
  input = document.getElementById("buscarUsuario");
  filter = input.value.toUpperCase();
  tarjetas = document.getElementById("contenido").getElementsByClassName("row");
  
  for (i = 0; i < tarjetas.length; i++) {
      tarjeta = tarjetas[i];
      usuario = tarjeta.querySelector(".nombreUsuario"); // Selecciona el título del usuario en la tarjeta
      if (usuario) {
          txtValue = usuario.textContent || usuario.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tarjeta.classList.remove("d-none")
          } else {
              tarjeta.classList.add("d-none")
          }
      }       
  }
}
function buscarPorEvento() {
  var input, filter, tarjetas, tarjeta, usuario, i, txtValue;
  input = document.getElementById("buscarEvento");
  filter = input.value.toUpperCase();
  tarjetas = document.getElementById("contenido").getElementsByClassName("row");
  
  for (i = 0; i < tarjetas.length; i++) {
      tarjeta = tarjetas[i];
      usuario = tarjeta.querySelector(".nombreEvento"); // Selecciona el título del usuario en la tarjeta
      if (usuario) {
          txtValue = usuario.textContent || usuario.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tarjeta.classList.remove("d-none")
          } else {
              tarjeta.classList.add("d-none")
          }
      }       
  }
}


function mostrarInputBuscarUsuario(){
  let buscarUsuario = document.getElementById("buscarUsuario");
  let buscarEvento = document.getElementById("buscarEvento");
  if(buscarUsuario.classList.contains("d-none")){
    buscarUsuario.classList.remove("d-none");
  }else{
    buscarUsuario.classList.add("d-none")
  }
  if(!buscarEvento.classList.contains("d-none")){
    buscarEvento.classList.add("d-none");
  }
}

function mostrarInputBuscarEvento(){
  let buscarUsuario = document.getElementById("buscarUsuario");
  let buscarEvento = document.getElementById("buscarEvento");
  if(buscarEvento.classList.contains("d-none")){
    buscarEvento.classList.remove("d-none");
  }else{
    buscarEvento.classList.add("d-none")
  }
  if(!buscarUsuario.classList.contains("d-none")){
    buscarUsuario.classList.add("d-none");
  }
}
