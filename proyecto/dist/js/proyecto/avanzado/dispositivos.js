
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/avanzado/dispositivos.php',function(data)
{
var resultado;
resultado=JSON.parse(data);
if(resultado['mensaje']==10)
{
$("#nombre_usuario").html(resultado['usuario']);
$("#cuenta").html(resultado['cuenta']);

$("#opciones").html(resultado['visibilidad']);
$("#contenido").html(resultado['contenido']);
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
setTimeout(function()
		   {	
$('#creacion').click(function()
{

 var informacion_dispositivo=document.getElementById("descripcion_dispositivo").value;
 var clave =document.getElementById("clave_dispositivo").value;
 var resultado;

   var datos=$.post('../../php/avanzado/crear/crear_dispositivo.php',{Descripcion:informacion_dispositivo,Clave:clave},
 function (data)
  {
 alert(data);
	actualizar_dispositivos();   
   });
   

});

	  
    $(function () {		
	
actualizar_dispositivos();
	
		  
      });
	   //uniciar la icheck (esto puede ser util mas adelante por posibilidades de cambio en el codigo);
	/* $('input').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
          increaseArea: '20%' // optional
        });*/

function actualizar_dispositivos()
		{ 
		
var dispositivos=$.post('../../php/general/dispositivos/dispositivos.php',function (data)
{

var resultado=eval(data);

var tabla=document.createElement("tbody");
tabla.id="cuerpo_tabla";
document.getElementById("tabla_datos").appendChild(tabla); 
$("#cuerpo_tabla").empty();
var tama=resultado.length;
var contador=0;
while(eval(contador)<eval(tama))
{

tabla=document.createElement("tr");
tabla.id="c"+contador+"";
document.getElementById("cuerpo_tabla").appendChild(tabla); 

var contenido=document.createElement("td");

var texto = document.createTextNode(resultado[contador]['id']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	
//Sensor
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['descripcion']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	
//dispositivo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['propietario']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//Tipo

//fin
contador++;
}


}); //sensores tipo, peticion 
		
		};},500);	