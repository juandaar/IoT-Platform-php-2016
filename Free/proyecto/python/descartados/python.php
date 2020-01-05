<?php 


$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$RESULTADO;
$RESULTADOA;
$contador=0;
$separacion;
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}
$query_sensor="SELECT  `dato`, `fecha`, `hora` FROM `historial` WHERE id_sensor='19' and fecha between '2016-07-20' and '2016-07-20'";
foreach($base->query($query_sensor) as $elemento)
{
$RESULTADOA[$contador]['fecha']=$elemento['fecha']." ".$elemento['hora'];
$RESULTADOA[$contador]['valor']=$elemento['dato'];
$contador=$contador+1;
}
$java_1=json_encode($RESULTADOA);
echo("PRIMERA:");
print_r($RESULTADOA);
$contador=0;
$query_sensor="SELECT  `dato`, `fecha`, `hora` FROM `historial` WHERE id_sensor='19' and fecha between '2016-07-19' and '2016-07-19'";
foreach($base->query($query_sensor) as $elemento)
{
$RESULTADO[$contador]['fecha']=$elemento['fecha']." ".$elemento['hora'];
$RESULTADO[$contador]['valor']=$elemento['dato'];
$contador=$contador+1;
}
echo("<br/><br/><br/>SEGUNDA:");
$java=json_encode($RESULTADO);
echo($java);
$resultado;
print_r($RESULTADO);


echo("<br/><br/><br/>");

exec("/home/juan/anaconda3/bin/python ../php/dashboard/sensores/algoritmos/ejemplo.py '$java'", $output);
$separacion=$output[0];
$valor=json_decode($output[1]);
$contador=0;
foreach($valor as $elemento)
{
$resultado[$contador]['fecha']=$RESULTADO[$separacion-1]['fecha'];
$resultado[$contador]['dato']=$RESULTADO[$separacion-1]['valor'];
$resultado[$contador]['regresion']=$valor[$contador];
$contador=$contador+1;
$separacion=$separacion+1;
}
$java=json_encode($resultado);	
echo("separacion:".$separacion);
echo($java);

mysqli_close($base);
?>