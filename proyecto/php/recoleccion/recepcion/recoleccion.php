
<?php
$id=$_POST['IDS'];
$id_dispositivo=$_POST['ID_DISPOSITIVO'];
$estado=$_POST['INFORMACION'];
$contrasenha=$_POST['CONTRASENHA'];

$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"0";
}


date_default_timezone_set("America/Bogota");
$datetime=date("Y-m-d H:i:s");
// se crea la conexion


if($negado==1)
{
if($estado==0)
{
$estado=1;
}
else
{

$estado=0;
}
}

if($negado_A==1)
{
if($estado_A==0 )
{
$estado_A=1;
}
else
{
if($estado_A==1)
{
$estado_A=0;
}
}	
}

$query_sensor="UPDATE `estado` SET `fecha`=$datetime WHERE id_sensor=$id";
$base->query("$query_sensor");
if($estado==0 or $estado==1)
{
$query_sensor="UPDATE `sensor` SET `estado`=$estado WHERE id=$id";
$base->query("$query_sensor");
}
$valor=500;
$query_sensor="select nuevo_estado from  programacion where id_sensor=$id and fecha_F>'$datetime' and '$datetime'>fecha_I";
foreach($base->query("$query_sensor") as $elemento)
{
if($elemento)
{

$valor=$elemento['nuevo_estado'];
}

}



if($valor!=500)
{
$dato=$valor;
}
 else
{
		
$query_sensor="select nuevo_estado from  historial where  id_sensor=$id";
$resultado=$base->query("$query_sensor");
$valor=$resultado->fetch_array ();
$dato=$valor['nuevo_estado'];
}
	

if($negado==1)
{

if($dato==0)
{
$dato=1;
}
else
{
$dato=0;
}
}
$dato="$dato";
$java=json_encode($dato);

if($estado_A!==2)
{

$query_sensor="UPDATE `sensor` SET `estado`=$estado_A WHERE id=$id_A";
$base->query("$query_sensor");
}

echo($java);
$query_sensor="DELETE FROM `programacion` WHERE fecha_F<'$datetime'";
$base->query("$query_sensor");


?>
