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
$contrasenha=$_POST['CLAVE'];
$nombre=$_POST['NOMBRE'];
// disponibles (dependiendo del dashboard todo se analizara con 1. agua 2. energia 3.gas 

$query_sensor="UPDATE `dispositivo` SET clave='$contrasenha',descripcion='$nombre' WHERE id=$id and id!=9999";
if($base->query("$query_sensor"))
{

echo("Se ha modificado satisfactoriamente");

}
else
{
echo("Error");
}

if($id=='9999')
{
echo(" El dispositivo 'Dispositivo no definido' no puede ser seleccionado como objetivo");
}
?>