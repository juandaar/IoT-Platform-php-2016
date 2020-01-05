
$(document).ready(function(){

var visibilidad=$.post('../../../php/proyecto/general/sensores/dashboard.php',function(data)
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
        $.post('../../../php/autentificacion/logout.php',function(data)
     {
	alert("desconectado");
	document.getElementById("conectado").click();
        })},2500);
    })},100);
	
});

	   
  $(function () {		
 //inicializa select2
  $.fn.select2.defaults.set('language', 'es');
	$(".select2").select2();

    $('#fecha').daterangepicker({ timePicker: true, timePickerIncrement: 15, format: 'YYYY-MM-DD HH:mm:ss ',timePicker12Hour: false,	
								});
//creacion y busqueda de sensores base de datos
	  
var sensores_tipo=$.post('../../../php/general/sensores/sensores_tipo.php',
function (data)
{
var option = document.createElement("option");
   option.text ='Ninguno';
   option.value ='0';
   document.getElementById("clase_sensor").appendChild(option); 	 
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
	/*
    var att = document.createAttribute("onclick");
    var actividad="sensores_del_tipo()";
	att.value = actividad;
   option.setAttributeNode(att);
   */
   document.getElementById("clase_sensor").appendChild(option); 
}
 });

 var analisis_tipo=$.post('../../../php/general/analisis/tipo_analisis.php',
function (data)
{
var option = document.createElement("option");
   option.text ='Ninguno';
   option.value ='[{"id":"0","tipo":"0"}]';
   document.getElementById("analisis").appendChild(option); 	 
var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['nombre'];
   option.value ='[{"id":"'+resultado[i]['id']+'","tipo":"'+resultado[i]['Tipo_analisis']+'"}]';

   document.getElementById("analisis").appendChild(option); 
}
 });
	
		  

		  

		  
  });
	  
var primero=0;
 function actualizar()
{
$('#barras').empty();
var fecha=document.getElementById("fecha").value;
var sensores=$("#sensores").select2("val");
var informacion_analisis=$("#analisis").select2("val");
informacion_analisis=eval(informacion_analisis);
var analisis=informacion_analisis[0]['id'];
var tipo_analisis=informacion_analisis[0]['tipo'];
var dias=$("#dias").select2("val");
var TIPO=$("#clase_sensor").select2("val");
if(analisis=='0')
{
sin_analisis(fecha,sensores,analisis,dias,TIPO);
}
else
{
if(tipo_analisis==1)
{
predictivo_2_dimension_valor_tiempo(fecha,sensores,analisis,dias,TIPO);
}
}

};

function descargar()
  {
var fecha=document.getElementById("fecha").value;
var sensores=$("#sensores").select2("val");
var analisis=$("#analisis").select2("val");
var dias=$("#dias").select2("val");
var resultado;
var TIPO=$("#clase_sensor").select2("val");
  

   var datos=$.post('../../../php/dashboard/sensores/descarga.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
  {
  
	   
	  JSONToCSVConvertor(data, "Consumo Gas", true);
   });
  };


function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';   
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

	

 
}

function aleatorio(inferior,superior){
    numPosibilidades = superior - inferior
    aleat = Math.random() * numPosibilidades
    aleat = Math.floor(aleat)
    return parseInt(inferior) + aleat
} 
function color(){
	hexadecimal = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F")
	color_aleatorio = "#";
	for (i=0;i<6;i++){
		pos = aleatorio(0,hexadecimal.length)
		color_aleatorio += hexadecimal[pos]
	}
	return color_aleatorio
} 

function sensores_del_tipo()
{
	

$("#sensores").select2("val", "");

var TIPO=$("#clase_sensor").select2("val");
$('#sensores').empty();
var sensores_tipo=$.post('../../../php/general/sensores/sensores.php',{Tipo:TIPO},function (data)
{

var resultado=eval(data);
for (i = 0; i < resultado.length; i++) {
var option = document.createElement("option");
   option.text = resultado[i]['descripcion'];
   option.value =resultado[i]['id'];
   document.getElementById("sensores").appendChild(option); 

}

		
}); //sensores tipo, peticion 
}
	
function sin_analisis(fecha,sensores,analisis,dias,TIPO)
	{
	var resultado;
var barra=$.post('../../../php/dashboard/sensores/graficas/barras_y_tablas.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
{
resultado=eval(data);
$("#barras").empty();
 var bar = new Morris.Bar({
          element: 'barras',
          resize: false,
          data: resultado,
          xkey: ['descripcion'],
          ykeys: ['valor'],
          labels: ['Total(kw)'],
         barColors:['#45B549'],
          hideHover: 'false'
        });

var contador=0;

var tabla=document.createElement("tbody");
tabla.id="cuerpo_tabla";
document.getElementById("tabla_datos").appendChild(tabla); 
$("#cuerpo_tabla").empty();
var tama=resultado.length;
while(eval(contador)<eval(tama))
{

tabla=document.createElement("tr");
tabla.id="c"+contador+"";
document.getElementById("cuerpo_tabla").appendChild(tabla); 
//llenado
//descripcion
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['descripcion']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	
//unidades
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['unidades']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//
//total
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['valor']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	
//maximo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['maximo']);
contenido.appendChild(texto);
contenido.value="maximo";
document.getElementById("c"+contador+"").appendChild(contenido); 
//minimo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['minimo']);
contenido.appendChild(texto);
contenido.value="minimo";
document.getElementById("c"+contador+"").appendChild(contenido); 
//media
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['media']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//desviacion
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['desviacion']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//cantidad
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['cantidad']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//recopilados
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['recopilados']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//porcentaje
var contenido=document.createElement("td");
var porcentaje=(100-100*(resultado[contador]['recopilados']/resultado[contador]['cantidad'])).toPrecision(4);
var texto = document.createTextNode(porcentaje+"%");
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//fin
contador++;
}



}); 
var grafica_total=$.post('../../../php/dashboard/sensores/graficas/grafica_total.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
{
var contador=0;
$("#consumo_total").empty();

resultado=eval(data);
            var chart;
            var chartCursor;

                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = resultado;
                chart.categoryField = "fecha";
       

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true;
                categoryAxis.minPeriod = "mm";
                //ategoryAxis.dashLength = 1;
                categoryAxis.dataDateFormat ="YYYY-MM-DD JJ:NN:SS";
                categoryAxis.axisColor = "#45B549";
	            categoryAxis.equalSpacing=true;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "green line";
                graph.valueField = "valor";
                graph.lineColor = "#45B549";
                chart.addGraph(graph);

                // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
	            chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
	            chartCursor.color="white";
	            chartCursor.cursorColor="#45B549";
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
	            chartScrollbar.gridColor="#45B549";
                chart.addChartScrollbar(chartScrollbar);
	     

                // WRITE
                chart.write("consumo_total");      
}); //fin grafica_total


var grafica_multiple=$.post('../../../php/dashboard/sensores/graficas/grafica_multiple.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
  {

 var contador=0;
 var resultado=eval(data);
 $("#consumo_separado").empty();
var otro=data;
var contador=0;

//grafica consumo

            var chart;
            var chartCursor;

                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = resultado;
                chart.categoryField = "fecha";
                // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
                //chart.addListener("dataUpdated", zoomChart);

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true;
                categoryAxis.minPeriod = "mm";
                categoryAxis.dashLength = 1;
                categoryAxis.dataDateFormat ="YYYY-MM-DD JJ:NN:SS";
                categoryAxis.axisColor = "#45B549";
	            categoryAxis.equalSpacing=true;
	            //categoryAxis.parseDates = false;
 var colores;
 	   
	 while (resultado[0][contador])
  {   
	colores=color();

  var graficar=resultado[0][contador];


	

               eval("var axis"+contador+"= new AmCharts.ValueAxis()");
               eval("axis"+contador+".axisColor = colores");
               eval("axis"+contador+".axisThickness = 2");
	           
               chart.addValueAxis(eval("axis"+contador));
	 
	  if(eval(contador+1)%2==0)
	  {
		 var separacion=eval(50*(contador-1)/2);
	eval("axis"+contador+".offset = separacion");
	   eval("axis"+contador+".position = 'right'");
	  }
	  else
	  {
	var separacion=eval(50*contador/2);
	eval("axis"+contador+".offset = separacion");
	  }
		 
      eval("var graph"+contador+"= new AmCharts.AmGraph()");
               eval("graph"+contador+".valueAxis = eval('axis'+contador)"); // we have to indicate which value axis should be used
               eval("graph"+contador+".title = graficar");
		       eval("graph"+contador+".lineColor = colores");
               eval("graph"+contador+".valueField = graficar");
               chart.addGraph(eval("graph"+contador));
            
	
                 
	 contador++;
  }
	                 // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
	            chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
	            chartCursor.color="white";
	            chartCursor.cursorColor="#45B549";
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
	             chartScrollbar.gridColor="#45B549";
                chart.addChartScrollbar(chartScrollbar);
	     
               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart.addLegend(legend);
	   
	   
                // WRITE
                chart.write("consumo_separado");
        

   });
	}
function predictivo_2_dimension_valor_tiempo(fecha,sensores,analisis,dias,TIPO)
	{
	var resultado;
var barra=$.post('../../../php/dashboard/sensores/graficas/barras_y_tablas.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
{

resultado=eval(data);
$("#barras").empty();
 var bar = new Morris.Bar({
          element: 'barras',
          resize: false,
          data: resultado,
          xkey: ['descripcion'],
          ykeys: ['promedio'],
          labels: ['Total(kw)'],
         barColors:['#45B549'],
          hideHover: 'false'
        });

var contador=0;

var tabla=document.createElement("tbody");
tabla.id="cuerpo_tabla";
document.getElementById("tabla_datos").appendChild(tabla); 
$("#cuerpo_tabla").empty();
var tama=resultado.length;
while(eval(contador)<eval(tama))
{

tabla=document.createElement("tr");
tabla.id="c"+contador+"";
document.getElementById("cuerpo_tabla").appendChild(tabla); 
//llenado
//descripcion
var contenido=document.createElement("td");

var texto = document.createTextNode(resultado[contador]['descripcion']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	

//total
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['valor']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 	
//maximo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['maximo']);
contenido.appendChild(texto);
contenido.value="maximo";
document.getElementById("c"+contador+"").appendChild(contenido); 
//minimo
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['minimo']);
contenido.appendChild(texto);
contenido.value="minimo";
document.getElementById("c"+contador+"").appendChild(contenido); 
//media
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['media']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//desviacion
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['desviacion']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//cantidad
var contenido=document.createElement("td");
var texto = document.createTextNode(resultado[contador]['cantidad']);
contenido.appendChild(texto);
document.getElementById("c"+contador+"").appendChild(contenido); 
//fin
contador++;
}



}); 
var grafica_total=$.post('../../../php/dashboard/sensores/graficas/grafica_total.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
{


var contador=0;
$("#consumo_total").empty();


	   // alert(data);
        resultado=eval(data);
            var chart;
            var chartCursor;

	
            var chart;
            var chartCursor;

                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = resultado;
                chart.categoryField = "fecha";
       

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true;
                categoryAxis.minPeriod = "mm";
                //ategoryAxis.dashLength = 1;
                categoryAxis.dataDateFormat ="YYYY-MM-DD JJ:NN:SS";
                categoryAxis.axisColor = "#45B549";
	            categoryAxis.equalSpacing=true;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Regresión";
                graph.valueField = "regresion";
                graph.lineColor = "red";
                chart.addGraph(graph);
	             
	                var graph1 = new AmCharts.AmGraph();
                graph1.title = "Reales";
                graph1.valueField = "valor";
                graph1.lineColor = "#45B549";
                chart.addGraph(graph1);
	           // first trend line
         
              
	
                // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
	            chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
	            chartCursor.color="white";
	            chartCursor.cursorColor="#45B549";
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
	            chartScrollbar.gridColor="#45B549";
                chart.addChartScrollbar(chartScrollbar);
	     

                // WRITE
                chart.write("consumo_total");

}); //fin grafica_total


var grafica_multiple=$.post('../../../php/dashboard/sensores/graficas/grafica_multiple.php',{ Fecha: fecha, Sensores:sensores,Analisis:analisis,Dias:dias,Tipo:TIPO},function (data)
  {
 var contador=0;
alert(data);
 var resultado=eval(data);
 $("#consumo_separado").empty();
        resultado=eval(data);
            var chart;
            var chartCursor;

	
            var chart;
            var chartCursor;

                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = resultado;
                chart.categoryField = "fecha";
       

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = true;
                categoryAxis.minPeriod = "mm";
                //ategoryAxis.dashLength = 1;
                categoryAxis.dataDateFormat ="YYYY-MM-DD JJ:NN:SS";
                categoryAxis.axisColor = "#45B549";
	            categoryAxis.equalSpacing=true;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.dashLength = 1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Regresión";
                graph.valueField = "regresion";
                graph.lineColor = "red";
                chart.addGraph(graph);
	             
	                var graph1 = new AmCharts.AmGraph();
                graph1.title = "Reales";
                graph1.valueField = "valor";
                graph1.lineColor = "#45B549";
                chart.addGraph(graph1);
	           // first trend line
         
              
	
                // CURSOR
                chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
	            chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
	            chartCursor.color="white";
	            chartCursor.cursorColor="#45B549";
                chart.addChartCursor(chartCursor);

                // SCROLLBAR
                var chartScrollbar = new AmCharts.ChartScrollbar();
	            chartScrollbar.gridColor="#45B549";
                chart.addChartScrollbar(chartScrollbar);
	     

                // WRITE
     chart.write("consumo_separado");
        

   });
	}