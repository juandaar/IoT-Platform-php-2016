
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/avanzado/conexion.php',function(data)
{
var resultado;
resultado=JSON.parse(data);
if(resultado['mensaje']==10)
{
$("#nombre_usuario").html(resultado['usuario']);
$("#cuenta").html(resultado['cuenta']);

$("#opciones").html(resultado['visibilidad']);
}
else
{
document.getElementById("conectado").click();
}
});
setTimeout(function()
		   {	
   $('#sessionKiller').click(function(){
        setTimeout(function(){
        $.post('../../php/autentificacion/logout.php',function(data)
     {
	alert("desconectado");
	document.getElementById("conectado").click();
        })},2500);
    })},100);
	
});