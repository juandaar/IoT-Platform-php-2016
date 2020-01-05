
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/administrador/dispositivos.php',function(data)
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
var dispositivos=$.post('../../php/administrador/dispositivos/dispositivos_administrador.php',function (data)
{
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("clase_dispositivos").appendChild(option); 

}
});
	
actualizar_dispositivos();
	
		  
    


function actualizar_dispositivos()
		{ 
			
var dispositivos=$.post('../../php/administrador/dispositivos/dispositivos_administrador.php',function (data)
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
//estado
var contenido=document.createElement("td");
if(resultado[contador]['Activa']=='1')
{
var texto = document.createTextNode('Activo');
}
else
{
var texto = document.createTextNode('Inactivo')
}
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido);
//Tipo

//fin
contador++;
}


}); //sensores tipo, peticion 
		
};
	   //uniciar la icheck (esto puede ser util mas adelante por posibilidades de cambio en el codigo);
	/* $('input').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
          increaseArea: '20%' // optional
        });*/

$("#clase_dispositivos").change(function()
{
// var informacion_dispositivo=document.getElementById("descripcion_dispositivo").value;
 //var clave =document.getElementById("clave_dispositivo").value;
var ID=$("#clase_dispositivos").select2("val");

var resultado;
if(!ID)
{
}
else
{
var datos=$.post('../../php/administrador/dispositivos/dispositivo_estado.php',{ID:ID},
function (data)
{
data=eval(data);
if(data=="1")
{
document.getElementById("activar").value='Desactivar';
}
if(data=="0")
{
document.getElementById("activar").value='Activar';
}

});
   
} 
});
	
$("#modificacion").click(function()
					 {
var ID=$("#clase_dispositivos").select2("val");
var clave=$("#clave_dispositivo").val();
var nombre=$("#descripcion_dispositivo").val();
var datos=$.post('../../php/administrador/dispositivos/dispositivo_modificar.php',{ID:ID,CLAVE:clave,NOMBRE:nombre},
 function (data)
  {
alert(data);
  
   });

$("#clase_dispositivos").select2("val"," ");
document.getElementById("activar").value=" ";
actualizar_dispositivos()
});

$("activar").click(function()
{
var ID=$("#clase_dispositivos").select2("val");
var datos=$.post('../../php/administrador/dispositivos/dispositivo_activar.php',{ID:ID},
 function (data)
  {
alert(data);
  
   });

$("#clase_dispositivos").select2("val"," ");
document.getElementById("activar").value=" ";
actualizar_dispositivos();
});

	  
},500);	  
