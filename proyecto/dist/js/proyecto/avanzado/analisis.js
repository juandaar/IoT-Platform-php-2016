
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/avanzado/analisis.php',function(data)
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
	



setTimeout(function()
		   {	
    $(function () {		
$.fn.select2.defaults.set('language', 'es');
$(".select2").select2();
var analisis_tipo=$.post('../../php/general/analisis/tipo_analisis.php',
function (data)
{
var option = document.createElement("option");
   option.text ='Ninguno';
   option.value ='[{"id":"0","tipo":"0","archivo":"0"}]';
   document.getElementById("analisis").appendChild(option); 	 
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['nombre'];
   option.value ='[{"id":"'+resultado[i]['id']+'","tipo":"'+resultado[i]['Tipo_analisis']+'","archivo":"'+resultado[i]['PDF']+'"}]';

   document.getElementById("analisis").appendChild(option); 
}
 });
		  
      });
	   //uniciar la icheck (esto puede ser util mas adelante por posibilidades de cambio en el codigo);
	/* $('input').iCheck({
          checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
          increaseArea: '20%' // optional
        });*/
},500); 

setTimeout(function()
		   {
 $("#analisis").change(function()
	  {

var informacion_analisis=$("#analisis").select2("val");
informacion_analisis=eval(informacion_analisis);
var analisis=informacion_analisis[0]['id'];
var tipo_analisis=informacion_analisis[0]['tipo'];
var PDF=informacion_analisis[0]['archivo']
var documento="../../pdf/"+PDF;

if(PDF=='0')
{
document.getElementById("archivo").src="../../dist/img/escudo2.jpg ";
}
else
{
document.getElementById("archivo").src=documento;
}
	  });

},100);


});