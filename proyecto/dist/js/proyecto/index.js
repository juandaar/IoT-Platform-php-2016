
$(document).ready(function(){

var visibilidad=$.post('php/proyecto/proyecto.php',function(data)
{
var resultado;

resultado=JSON.parse(data);
$("#nombre_usuario").html(resultado['usuario']);
$("#cuenta").html(resultado['cuenta']);

$("#opciones").html(resultado['visibilidad']);
		
});
setTimeout(function()
		   {	
   $('#sessionKiller').click(function(){
        setTimeout(function(){
        $.post('php/autentificacion/logout.php',function(data)
     {
	alert("desconectado");
	location.reload();
        })},2500);
    })},100);
	
});