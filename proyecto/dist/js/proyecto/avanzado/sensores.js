
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/avanzado/sensores.php',function(data)
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

 var informacion_sensor=document.getElementById("descripcion_sensor").value;
var id_tipo=document.getElementById("clase_sensores").value;
 var id_dispositivo=document.getElementById("clase_dispositivos").value;
 var clave =document.getElementById("clave_dispositivo").value;
 var resultado;

   var datos=$.post('../../php/avanzado/crear/crear_sensor.php',{Descripcion:informacion_sensor,Tipo:id_tipo,Dispositivos:id_dispositivo,Clave:clave},
 function (data)
  {
 alert(data);
 actualizar_sensores();   
   });
   

});


	  
    $(function () 
{		

$(".select2").select2();

//muestra los dispositivos que estan en este momento
var dispositivos=$.post('../../php/general/dispositivos/dispositivos.php',function (data)
{
var option = document.createElement("option");
   option.text ='Ninguno';
   option.value ='0';
   document.getElementById("clase_dispositivos").appendChild(option); 
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("clase_dispositivos").appendChild(option); 

}
});

var sensor_tipo_disponible=$.post('../../php/general/sensores/sensores_tipo.php',function (data)
{
$("#clase_sensores").select2("val", "");
$("#clase_sensores").empty();
var option = document.createElement("option");
   option.text = 'Ninguno';
   option.value ='0';
   document.getElementById("clase_sensores").appendChild(option);
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("clase_sensores").appendChild(option); 

}
});
		
	
actualizar_sensores();
	



		  
      });
	   //uniciar la icheck (esto puede ser util mas adelante por posibilidades de cambio en el codigo);
	/* $('input').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
          increaseArea: '20%' // optional
        });*/

function actualizar_sensores()
		{ 

var sensores_informacion=$.post('../../php/general/sensores/sensores_especifico.php',function (data)
{

var resultado=eval(data);

var tabla=document.createElement("tbody");
tabla.id="cuerpo_tabla";
document.getElementById("tabla_datos").appendChild(tabla); 
var tama=resultado.length;
var contador=0;
$("#cuerpo_tabla").empty();
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
		
		};	  },500);