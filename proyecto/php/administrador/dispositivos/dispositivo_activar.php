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
$id=$_POST['ID'];
// disponibles (dependiendo del dashboard todo se analizara con 1. agua 2. energia 3.gas 

$query_sensor="select Activa from `dispositivo` where id=$id and id!=9999";
//los datos importantes de los  son el id y la descripción los cuales se descargas desde la tabla 
$valor;
foreach ($base->query("$query_sensor")as $elemento)
{
    $valor=  $elemento['Activa'];
}
if($valor)
{
$valor='0';
}
else
{
$valor='1';
}

$query_sensor="UPDATE `dispositivo` SET `Activa`=$valor WHERE id=$id and id!=9999";
if($base->query("$query_sensor"))
{
if($valor)
{
echo("Se ha activado satisfactoriamente");
}
else
{
echo("Se ha desactivado satisfactoriamente");
$query_sensor="select  descripcion from sensor where id_dispositivo=$id";
$notificacion="Los sensores conectados a este dispositivo son:";

if($base->query("$query_sensor"))
{
$query_sensor="select  descripcion from sensor where id_dispositivo=$id";
foreach ($base->query("$query_sensor")as $elemento)
{
$valor=$elemento['descripcion'] ;
$notificacion=$notificacion."[$valor]";
}

}

$query_sensor="UPDATE `sensor` SET id_dispositivo=9999 WHERE id_dispositivo=$id";
if($base->query("$query_sensor"))
{
echo($notificacion);
echo("Y e han movido a 'Dispositivo  no definido'");
}
else
{
echo(" este Dispositivo no tenia  sensores conectados");
}
}
}
else
{
echo("Error");
}

if($id=='9999')
{
echo(" El dispositivo 'Dispositivo no definido' puede ser desactivado");
}
?>