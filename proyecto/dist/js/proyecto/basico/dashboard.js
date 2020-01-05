
$(document).ready(function(){

var visibilidad=$.post('../../php/proyecto/general/dashboard.php',function(data)
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
        $.post('../../php/autentificacion/logout.php',function(data)
     {
	alert("desconectado");
	document.getElementById("conectado").click();
        })},2500);
    })},100);
	
});


 function grafica(consumo,resultado,colorA,colorH)
 {
  var ayer=consumo+"1";
  var hoy=consumo+"2";
  var id_grafica=consumo+"_line_comparativa_2_dias";
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = resultado;
                chart.categoryField = "hora";
                var categoryAxis = chart.categoryAxis;
                categoryAxis.parseDates = false;
          
                categoryAxis.axisColor = "white";
        
               // first value axis (on the left)
               var valueAxis1 = new AmCharts.ValueAxis();
               valueAxis1.axisColor = colorA;
               valueAxis1.axisThickness = 2;
               chart.addValueAxis(valueAxis1);

               // second value axis (on the right)
               var valueAxis2 = new AmCharts.ValueAxis();
               valueAxis2.position = "right"; // this line makes the axis to appear on the right
               valueAxis2.axisColor = colorH;
               valueAxis2.gridAlpha = 0;
               valueAxis2.axisThickness = 2;
               chart.addValueAxis(valueAxis2);

               // GRAPHS
               // first graph
               var graph1 = new AmCharts.AmGraph();
               graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
               graph1.lineColor = colorA;
               graph1.title = "Ayer";
               graph1.valueField =ayer;
        
               chart.addGraph(graph1);

               // second graph
               var graph2 = new AmCharts.AmGraph();
               graph2.valueAxis = valueAxis2; // we have to indicate which value axis should be used
               graph2.lineColor = colorH;
               graph2.title = "Hoy";
               graph2.valueField =hoy;
               chart.addGraph(graph2);

              chartCursor = new AmCharts.ChartCursor();
              chartCursor.cursorPosition = "mouse";
              chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
              chartCursor.color="white";
              chartCursor.cursorColor="#45B549";
                chart.addChartCursor(chartCursor);

              
       
               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart.addLegend(legend);
               // WRITE
               chart.write(id_grafica);
 }


  function graficas_y_datos()
  {

 var d = new Date();
 //var fecha1=(d.getFullYear()+"-"+("0"+(d.getMonth())).slice(-2)+"-"+("0" + (d.getDate()-22)).slice(-2));
 //var fecha2=(d.getFullYear()+"-"+("0"+(d.getMonth())).slice(-2)+"-"+("0" + (d.getDate()-21)).slice(-2));
var fecha2="2016-07-19";
var fecha1="2016-07-20";
var colorH=["#0101DF","#0B610B","#B40404"];
var colorA=["#CEF6EC","#9FF781","#F5BCA9"];
var grafica_1=$.post('../../php/dashboard/graficas_morris_line.php',{ Fecha1:fecha1,Fecha2:fecha2},
function (data)
{
var contador=0;
var resultado=eval(data);
var chart;
var chartCursor;

grafica("agua",resultado,colorA[0],colorH[0]);
grafica("energia",resultado,colorA[1],colorH[1]);
grafica("gas",resultado,colorA[2],colorH[2]);

});
var grafica_2=$.post('../../php/dashboard/graficas_morris_donut.php',{ Fecha1:fecha1,Fecha2:fecha2},
function (data)
{
var resultado=eval(data);

          //consumo de agua
        var donut_agua = new Morris.Donut({
          element: 'circular_agua',
          resize: true,
			  parseTime: false,
          colors: ["#CEF6EC","#0101DF"],
          data: [
            {label: 'Ayer', value: resultado[0]['agua']},
            {label: 'Hoy', value: resultado[1]['agua']},
          ], 
		  formatter:function (y, data) { return y+ ' m3' } ,
          hideHover: 'auto'
        });
		         //consumo de energia
        var donut_energia = new Morris.Donut({
          element: 'circular_energia',
          resize: true,
		 parseTime: false,
          colors: ["#9FF781","#0B610B"],
          data: [
            {label: 'Ayer', value: resultado[0]['energia']},
            {label: 'Hoy', value: resultado[1]['energia']},
          ],
          formatter:function (y, data) { return y+ ' KW' } ,
          hideHover: 'auto'
        });
		         //consumo de agua
        var donut_agua = new Morris.Donut({
          element: 'circular_gas',
          resize: true,
			  parseTime: false,
          colors: ["#F5BCA9","#B40404"],
          data: [
            {label: 'Ayer', value: resultado[0]['gas']},
            {label: 'Hoy', value: resultado[1]['gas']},
          ],
          formatter:function (y, data) { return y+ ' KW' } ,								
          hideHover: 'auto'	
        });
	
});
};

  $(function () { graficas_y_datos();  });
