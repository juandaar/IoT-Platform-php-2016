<?php
//parte inicial, conexión y arreglos varios
//las pruebas se inician en el host local.
$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";

if($id=$_POST['ID'] and $tipo=$_POST['TIPO'])
{
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}
//finaliza conexión
	
	
if($tipo>9990)
{
$tipo=$tipo-9990;
$query_sensor="UPDATE `sensor` SET `tipo`=$tipo WHERE id=$id";
if($base->query("$query_sensor"))
{
echo("La acción fue realizada satisfactoriamente");
}
else
{
echo("La acción no fue realizada");
}

}

else
{
$tipo=9990+$tipo;
$query_sensor="UPDATE `sensor` SET `tipo`=$tipo WHERE id=$id";

if($base->query("$query_sensor"))
{
echo("La acción fue realizada satisfactoriamente");
}
else
{
echo("La acción no fue realizada");
}
}

}
else
{
echo("Falta información");
}
?>