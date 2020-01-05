<?php
//por el metodo post estas variables toman su valor del documento dashboard.php
//esta peticion funciona en los 3 dashboard.html de agua energia y gas
//esta peticion entrega los datos separados respecto a la id
// su utilidad es permitid descargar estos archivos en formato json para luego descargarlo en formato xls
$fecha=$_POST['Fecha'];
$sensores=$_POST['Sensores'];
$analisis=$_POST['Analisis'];
$dias=$_POST['Dias'];
$tipo=$_POST['Tipo'];

//explode separa un string de caracteres dependiendo de que caracter se nombre como criterio, en este caso un espacio,
$separar=explode(" ",$fecha);
//parte el string en un arreglo.
$fechaphp[0]=$separar[0];
$horaphp[0]=$separar[1];
$fechaphp[1]=$separar[4];
$horaphp[1]=$separar[5];

$valor1=new DateTime($horaphp[0]);
$valor2=new DateTime($horaphp[1]);
if($valor1>$valor2)
{
$horaphp[0]=$separar[5];
$horaphp[1]=$separar[1];

}

// activacion base de datos

$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$RESULTADO;
$contador=0;
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}
//cuenta el numero de sensores y el numero de dias, tiene una utilidad logica al final
$numerosensores=count($sensores);
$numerodias=count($dias);
$query_dias=" ";
//primero se analizan los dias 
if($dias=='')
{

}
else
{
$contador=0;
$query_dias="and (dia='$dias[$contador]' ";
	$contador=$contador+1;
while($contador<$numerodias)
{
$query_dias=$query_dias." or dia='$dias[$contador]' ";
$contador=$contador+1;
}
$query_dias=$query_dias.") ";
}

//sensores
$query_numero_sensores="select count(id) as contador from  sensor where sensor.tipo='$tipo'";
$query_sensor=" ";
//primero se analizan los dias 
if($sensores=='')
{
$query_sensor=" and historial.id_sensor=sensor.id and sensor.tipo='$tipo'"; 

foreach($base->query($query_numero_sensores) as $elemento )
{
$numerosensores=$elemento['contador'];
}
}
else
{
$contador=0;
$query_sensor=" and (sensor.id='$sensores[$contador]' ";
$contador=$contador+1;
while($contador<$numerosensores)
{
$query_sensor=$query_sensor."or sensor.id='$sensores[$contador]' ";
$contador=$contador+1;
}
$query_sensor=$query_sensor.") and historial.id_sensor=sensor.id ";
}



$query_data="WHERE fecha BETWEEN '$fechaphp[0]' AND '$fechaphp[1]' AND hora between '$horaphp[0]' and '$horaphp[1]'  ";


$query_where=$query_data."$query_sensor $query_dias";


$query_final="select sensor.descripcion, historial.dato as valor, historial.fecha, historial.hora from historial,sensor";
$query_final=$query_final." $query_where order by sensor.descripcion ";
$contador=0;
$descripcion;
//para separar los datos en multiples filas
$segundocontador=0;
foreach($base->query($query_final) as $elemento)
{
if($contador==0 or $descripcion==$elemento['descripcion'])
{
$descripcion=$elemento['descripcion'];
if($segundocontador==$contador)
{
$RESULTADO[$contador]['fecha']=$elemento['fecha'];
$RESULTADO[$contador]['hora']=$elemento['hora'];
}
$RESULTADO[$segundocontador][$elemento['descripcion']]=$elemento['valor'];


}
else
{
$segundocontador=0;
$descripcion=$elemento['descripcion'];
$RESULTADO[$segundocontador][$elemento['descripcion']]=$elemento['valor'];	

}
$contador=$contador+1;
$segundocontador=$segundocontador+1;
}



$java=json_encode($RESULTADO);

echo($java);

mysqli_close($base);

?>