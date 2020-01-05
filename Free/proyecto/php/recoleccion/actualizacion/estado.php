<?php
//parte inicial, conexión y arreglos varios
//las pruebas se inician en el host local.
$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "Arduino";
$usuario="root";
$contrasena="judaarco";
// se crea la conexion
date_default_timezone_set("America/Bogota");
$datetime=date("Y-m-d H:i:s");
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}


$query_sensor="select id_sensor,fecha from estado ";

$valor;
$contador=0;

foreach ($base->query("$query_sensor")as $elemento)
{
    $valor[$contador]=  $elemento;
	$contador=$contador+1;
}
$contador=$contador;
$segundocontador=0;
date_default_timezone_set("America/Bogota");
$date_actual=date("Y-m-d");
$date_actual=strtotime($datetime_actual);
$diferencia=($datetime_actual-$valor[0]['fecha'])/30;

while($segundocontador<$contador)
{
$valor[$segundocontador]['fecha']=strtotime($valor[$segundocontador]['fecha']);

$diferencia=($datetime_actual-$valor[$segundocontador]['fecha'])/30;
$id=$valor[$segundocontador]['id_sensor'];
if($diferencia<=1)
{
$query_sensor="UPDATE `sensor` SET `conexion`=1 WHERE id=$id";
$base->query("$query_sensor");
}
else
{
$query_sensor="UPDATE `sensor` SET `conexion`=0 WHERE id=$id";
$base->query("$query_sensor");
}
$segundocontador=$segundocontador+1;
}

$query_sensor="select sensor.id,sensor.descripcion,sensor.conexion,sensor.estado from sensor ";
//los datos importantes de los  son el id y la descripción los cuales se descargas desde la tabla 
$valor;
$contador=0;

foreach ($base->query("$query_sensor")as $elemento)
{
    $valor[$contador]=  $elemento;
	$contador=$contador+1;
}
$valor[$contador]['id']="fin";
$valor[$contador]['sensor']="fin";
$valor[$contador]['descripcion']="fin";
$valor[$contador]['conexion']="fin";
$java=json_encode($valor);
echo($java);
?>
