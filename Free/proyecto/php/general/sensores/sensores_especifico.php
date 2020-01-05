<?php
//parte inicial, conexión y arreglos varios
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
//finaliza conexión

// disponibles (dependiendo del dashboard todo se analizara con 1. agua 2. energia 3.gas 

$query_sensor="select sensor.id, Tipo_sensores.descripcion as tipo,sensor.descripcion, dispositivo.descripcion as dispositivo, Tipo_sensores.id as sensor from sensor,dispositivo,Tipo_sensores where sensor.id_dispositivo=dispositivo.id and Tipo_sensores.id=sensor.tipo and Tipo_sensores.id<9990  order by Tipo_sensores.descripcion";
//los datos importantes de los  son el id y la descripción los cuales se descargas desde la tabla 
$valor;
$contador=0;

foreach ($base->query("$query_sensor")as $elemento)
{
    $valor[$contador]=  $elemento;
	$contador=$contador+1;
}
$contador=0;

$java=json_encode($valor);
echo($java);
?>