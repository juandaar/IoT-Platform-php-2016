<?php
$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$RESULTADO;
	
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo("La base de datos no responde");
}
?>
