/**
 * Description
 *
 * @author Jorge Vicente Ramiro
 * DAW2
 */
var fecha = new Date();
function crearTitulo(tiempo) {
  titulo = document.getElementById("reloj");
  titulo.innerHTML = tiempo;
}
function cambiarTitulo(tiempo) {
  titulo = document.getElementById("reloj");
  titulo.innerHTML = tiempo;
}
function cronometro(fecha) {
  let segundos = 0;
  var fecha2 = new Date();
  segundos = Math.floor(((fecha2.getTime() - fecha.getTime()) / 1000) % 60);
  segundos = 15 - segundos;
  cambiarTitulo(segundos);
}
function iniciarCronometro() {
  fecha = new Date();
  crearTitulo("15");
  parada = setInterval("cronometro(fecha)", 1000);
}

iniciarCronometro();
