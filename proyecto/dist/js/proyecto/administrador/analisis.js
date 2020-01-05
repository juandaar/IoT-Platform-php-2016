
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/administrador/analisis.php',function(data)
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

	$("#analisis").change(function()
			 {
			var informacion_analisis=$("#analisis").select2("val");
            informacion_analisis=eval(informacion_analisis);
           var analisis=informacion_analisis[0]['id'];
			if(analisis==0)
			{
				document.getElementById("creacion").value='crear';
			}
			else
			{
				document.getElementById("creacion").value='Modificar';
			}
		
			
			 });
	$("#analisis_python").click(function()
		 {
			 $('#archivo_algoritmo').click();
		});
					
	$("#archivo_algoritmo").change(function() 
		{
						  
		     var file = document.getElementById("archivo_algoritmo");
		     document.getElementById("analisis_python").placeholder=file.files[0].name;
		 });
		$("#analisis_pdf").click(function()
		{
		   $('#archivo_explicacion').click();
		});
	
	
		$("#archivo_explicacion").change(function() 
	    {				  
		var file = document.getElementById("archivo_explicacion");
		 document.getElementById("analisis_pdf").placeholder=file.files[0].name;
        });
        
	  $("#creacion").click(function()
	  {
var formulario=new FormData();
var nombre=document.getElementById("nombre").value;
formulario.append("NOMBRE",nombre)
var informacion_analisis=$("#analisis").select2("val");
informacion_analisis=eval(informacion_analisis);
var analisis=informacion_analisis[0]['id'];
formulario.append("ANALISIS",analisis)
var tipo_analisis=informacion_analisis[0]['tipo'];
formulario.append("TIPO",tipo_analisis)
var file_algoritmo= $("#archivo_algoritmo").prop("files")[0]; 
formulario.append("PY", file_algoritmo)
var file_pdf = $("#archivo_explicacion").prop("files")[0]; 
formulario.append("PDF", file_pdf)

$.ajax({
                url: "../../php/administrador/analisis/crear_analisis.php",
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data:formulario,                       
                type: 'post',
                success: 
	           function(data){
                    alert(data); 
				   actualizar();
                }
     });
});



	  
    $(function () {		
$.fn.select2.defaults.set('language', 'es');
$(".select2").select2();
actualizar();
		  
      });
	  
function actualizar()
	  {
	var analisis_tipo=$.post('../../php/general/analisis/tipo_analisis.php',
function (data)
{
$("#analisis").empty();
var option = document.createElement("option");
   option.text ='Ninguno';
   option.value ='[{"id":"0","tipo":"0","archivo":"0"}]';
   document.getElementById("analisis").appendChild(option); 	 
var resultado=eval(data);
	
var tabla=document.createElement("tbody");
tabla.id="cuerpo_tabla";
document.getElementById("tabla_datos").appendChild(tabla); 
var tama=resultado.length;
var contador=0;
$("#cuerpo_tabla").empty();
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['nombre'];
   option.value ='[{"id":"'+resultado[i]['id']+'","tipo":"'+resultado[i]['Tipo_analisis']+'","archivo":"'+resultado[i]['PDF']+'"}]';

   document.getElementById("analisis").appendChild(option); 
	

tabla=document.createElement("tr");
tabla.id="c"+i+"";
document.getElementById("cuerpo_tabla").appendChild(tabla); 

var contenido=document.createElement("td");

var texto = document.createTextNode(resultado[i]['nombre']);
contenido.appendChild(texto);
document.getElementById("c"+i+"").appendChild(contenido); 	
//Sensor
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[i]['archivo']);
contenido.appendChild(texto);
document.getElementById("c"+i+"").appendChild(contenido); 	
//dispositivo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[i]['PDF']);
contenido.appendChild(texto);
document.getElementById("c"+i+"").appendChild(contenido); 

}
$("#analisis").select2("val",'[{"id":"0","tipo":"0","archivo":"0"}]');
 });
	  };},500);
	   //uniciar la icheck (esto puede ser util mas adelante por posibilidades de cambio en el codigo);
	/* $('input').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
          increaseArea: '20%' // optional
        });*/
