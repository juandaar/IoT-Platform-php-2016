
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/administrador/sensores.php',function(data)
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
	
 $.fn.select2.defaults.set('language', 'es');
$(".select2").select2();    
//muestra los dispositivos que estan en este momento
var option = document.createElement("option");
   option.text ='Ningun dispositivo';
   option.value ='0';
   document.getElementById("clase_dispositivos").appendChild(option); 
var dispositivos=$.post('../../php/general/dispositivos/dispositivos.php',function (data)
{
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("clase_dispositivos").appendChild(option); 

}
});
var option = document.createElement("option");
   option.text ='Ningun Tipo';
   option.value ='0';
   document.getElementById("clase_sensores").appendChild(option); 
var sensor_tipo_disponible=$.post('../../php/administrador/sensores/sensores_tipo_administrador.php',function (data)
{

var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("clase_sensores").appendChild(option); 

}
});
		
	
actualizar_sensores();
	



		  

$("#ocultar").click(function()
{


var informacion_sensor=$("#sensores").select2("val");
var TIPO=$("#clase_sensores").select2("val");
var resultado;
$("#sensores").select2("val", "");
var datos=$.post('../../php/administrador/sensores/ocultar_sensor.php',{ID:informacion_sensor,TIPO:TIPO},
function (data)
 {
    alert(data);
	actualizar_sensores();   
 });
   
});
$("#modificacion").click(function()
{
var informacion_sensor=$("#sensores").select2("val");
var descripcion= document.getElementById("descripcion_sensor").value;
var id_tipo=$("#clase_sensores").select2("val");
var id_dispositivo=$("#clase_dispositivos").select2("val");
var resultado;

   var datos=$.post('../../php/administrador/sensores/modificar_sensor.php',{ID:informacion_sensor,TIPO:id_tipo,DISPOSITIVO:id_dispositivo,DESCRIPCION:descripcion},
 function (data)
  {
 alert(data);
 actualizar_sensores();   
  });
   
actualizar_sensores();
});
 	     	
$("#clase_sensores").change(function()
{
$("#sensores").empty();
$("#sensores").select2("val", "");
var TIPO=$("#clase_sensores").select2("val");
var option = document.createElement("option");
   option.text = 'Ningun sensor';
   option.value = '0';
   document.getElementById("sensores").appendChild(option); 
var sensores_tipo=$.post('../../php/general/sensores/sensores.php',{Tipo:TIPO},function (data)
{
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("sensores").appendChild(option); 

}

}); //sensores tipo, peticion 
if(TIPO<9990)
{
document.getElementById("ocultar").value='Ocultar';
}
else
{
document.getElementById("ocultar").value='Mostrar';
}		
});

	  

	  

function actualizar_sensores()
{ 
var sensores_informacion=$.post('../../php/administrador/sensores/sensores_especifico_administrador.php',function (data)
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
var texto = document.createTextNode(resultado[contador]['dispositivo']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//Tipo

var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['tipo']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 

//fin
contador++;
}


}); //sensores tipo, peticion 
		
		};},500);