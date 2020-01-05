<?php

if(!$descripcion=$_POST['Descripcion'] or !$clave=$_POST['Clave'] )
{
echo("falta un dato");
return 0;
}
else
{
$contra;
$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$RESULTADO;
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}

$query_ingreso="INSERT INTO `dispositivo`(`descripcion`, `clave`,propietario,Activa) VALUES ('$descripcion','$clave','juan david arias correa','1')";




if(!$base->query($query_ingreso))
   {
  echo("Error de conexion");
   }
else
   {
 echo("Registrado Satisfactoriamente");
   }
}
mysqli_close($base);

?>
