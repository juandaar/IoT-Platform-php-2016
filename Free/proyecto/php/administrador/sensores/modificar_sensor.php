<?php
//parte inicial, conexión y arreglos varios
//las pruebas se inician en el host local.
$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";

if($id=$_POST['ID'] and $tipo=$_POST['TIPO'])
{//0
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{//1
echo"<br>No se logro la conexión<br>";
}//!1
//finaliza conexión
	
if($tipo<9990)
{//1
if($dispositivo=$_POST['DISPOSITIVO'] and $descripcion=$_POST['DESCRIPCION'])
{//2
$query_sensor="UPDATE sensor SET id_dispositivo=$dispositivo ,  descripcion='$descripcion' where id=$id";

if($base->query("$query_sensor"))
{
echo("la modificación fue exitosa");
}
else
{
echo("No se pudo realizar la modificación");
}
}//!2
else
{//2
if($_POST['DISPOSITIVO'])
{//3
$query_sensor="UPDATE `sensor` SET `id_dispositivo`=$dispositivo where id=$id";

if($base->query("$query_sensor"))
{
echo("la modificación fue exitosa");
}
else
{
echo("No se pudo realizar la modificación");
}
}//!3
else
{//3
if($_POST['DESCRIPCION'])
{//4
$query_sensor="UPDATE `sensor` SET `descripcion`='$descripcion' where id=$id";
if($base->query("$query_sensor"))
{
echo("la modificación fue exitosa");
}
else
{
echo("No se pudo realizar la modificación");
}
}//!4
else
{//4
echo("se requiere realizar alguna modificación");
}//!4
}//!3
}//!2
}//!1
else
{//1
echo("El dispositivo esta oculto");	
}//!1
}//!0
else
{//0

echo("Falta información");
}//!0
?>