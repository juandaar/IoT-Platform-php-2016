<?php
//por el metodo post estas variables toman su valor del documento dashboard.php
//esta peticion funciona en los 3 dashboard.html de agua energia y gas
//realiza una peticion respecto al tipo y entrega como resultado la sumatoria de los valores respectos a la id, el cual se usa en la grafica barras
if(!$descripcion=$_POST['Descripcion'] or !$dispositivos=$_POST['Dispositivos'] or !$clave=$_POST['Clave'] or !$tipo=$_POST['Tipo'])
{
echo("falta un dato");
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

$query_ingreso="INSERT INTO `sensor`(`id_dispositivo`, `descripcion`, `tipo`) VALUES ($dispositivos,'$descripcion',$tipo)";
$query_clave="SELECT `clave` FROM `dispositivo` WHERE id=$dispositivos";

$contador=0;
foreach($base->query($query_clave) as $elemento)
{
$contra=$elemento;
}

if($contra['clave']==$clave)
{
if(!$base->query($query_ingreso))
   {
  echo("Error de conexion");
   }
else
   {
 echo("Registrado Satisfactoriamente");
   }
}
else
{
echo("clave errada");
}
}
mysqli_close($base);
?>