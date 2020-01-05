
<?php
//esta peticion de usa en dashboard general, genera peticiones en las cuales se realiza la sumatoria de valores respecto a la id de todos los sensores
//cualquier variable seguida de un numero es : 1 (agua), 2(energia), 3 (gas)
$fecha=$_POST['Fecha2'];
$fecha2=$_POST['Fecha1'];
//las pruebas se inician en el host local.
$host = "localhost";

//db0 es la base de datos de pruebas 

$db= "mydb";

$usuario="JUAN";
$contrasena="judaarco";

// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}



$query_agua="Select sum(historial.dato)as dato , historial.fecha from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=1 and historial.fecha between '$fecha' and '$fecha2' group by historial.fecha ";
$query_energia="Select sum(historial.dato)as dato  , historial.fecha from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=2 and historial.fecha between '$fecha' and '$fecha2' group by historial.fecha";
$query_gas="Select sum(historial.dato)as dato  , historial.fecha from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=3 and historial.fecha between '$fecha' and '$fecha2' group by  historial.fecha";

$dato;


//agua_fecha
$contador=0;

foreach ($base->query("$query_agua")as $elemento)
{
   

	$dato[$contador]['agua']=  round($elemento['dato'],2);
	
	$contador=$contador+1;


	
}

$contador=0;


foreach ($base->query("$query_gas")as $elemento)
{


	$dato[$contador]['gas']=round($elemento['dato'],2);
	$contador=$contador+1;
	

}


$contador=0;

foreach ($base->query("$query_energia")as $elemento)
{

	
	$dato[$contador]['energia']=round($elemento['dato'],2);
		$contador=$contador+1;

	
}
$java=json_encode($dato);
echo($java);

mysqli_close($base);


?>