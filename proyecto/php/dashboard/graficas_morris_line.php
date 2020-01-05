
<?php
//Peticion usada por dashboard.html General, para entregar como resultado dos lineas de datos, una para el dia actual y otra para el dia anterior.
// estas lineas de datos se grafican en dicha pagina
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



$query_agua="Select sum(historial.dato)as dato , historial.hora, historial.fecha from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=1 and historial.fecha between '$fecha' and '$fecha2' group by historial.hora, historial.fecha ";
$query_energia="Select sum(historial.dato)as dato, historial.fecha  from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=2 and historial.fecha between '$fecha' and '$fecha2' group by historial.hora, historial.fecha";
$query_gas="Select sum(historial.dato)as dato, historial.fecha from `historial`, `sensor` where historial.id_sensor=sensor.id and  sensor.tipo=3 and historial.fecha between '$fecha' and '$fecha2' group by historial.hora, historial.fecha";

$dato;


//agua_fecha
$contador=0;
$contador2=0;
foreach ($base->query("$query_agua")as $elemento)
{
   
	if($elemento['fecha']=="$fecha")
	{
	$dato[$contador]['hora' ]=  $elemento['hora'];
	$dato[$contador]['agua1']=  round($elemento['dato'],2);
	$dato[$contador]['agua2']=0;
	$contador=$contador+1;
	}
	else
	{
	$dato[$contador2]['agua2']= round($elemento['dato'],2);
	$contador2=$contador2+1;
	}
	
}

$contador=0;
$contador2=0;

foreach ($base->query("$query_gas")as $elemento)
{

	if($elemento['fecha']==$fecha)
	{
	$dato[$contador]['gas1']=round($elemento['dato'],2);
	$dato[$contador]['gas2']=0;
			$contador=$contador+1;
	}
	else
	{
	$dato[$contador2]['gas2']=round($elemento['dato'],2);
	$contador2=$contador2+1;
	}

}


$contador=0;
$contador2=0;

foreach ($base->query("$query_energia")as $elemento)
{

	if($elemento['fecha']==$fecha)
	{
	$dato[$contador]['energia1']=round($elemento['dato'],2);
	$dato[$contador]['energia2']=0;
		$contador=$contador+1;
	}
	else
	{
	$dato[$contador2]['energia2']=round($elemento['dato'],2);
	$contador2=$contador2+1;
	}
	
}
$java=json_encode($dato);
echo($java);
mysqli_close($base);


?>