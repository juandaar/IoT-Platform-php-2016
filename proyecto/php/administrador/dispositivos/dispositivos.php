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

$query_sensor="select id,descripcion,propietario,Activa from `dispositivo`  ";
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