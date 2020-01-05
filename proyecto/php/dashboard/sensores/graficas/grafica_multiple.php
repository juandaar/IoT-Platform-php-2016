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


//
if($analisis==0)
{
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

$RESULTADO;
$query_final="select sensor.descripcion, historial.dato as valor, historial.fecha, historial.hora from historial,sensor";
$query_final=$query_final." $query_where order by sensor.descripcion ";
$contador=0;
$descripcion;
//para separar los datos en multiples filas
$segundocontador=0;
$contadortres=0;



foreach($base->query($query_final) as $elemento)
{
if($contador==0 or $descripcion==$elemento['descripcion'])
{
$descripcion=$elemento['descripcion'];
if($segundocontador==$contador)
{

$RESULTADO[$contador]['fecha']=$elemento['fecha']." ".$elemento['hora'];
}
$RESULTADO[$segundocontador][$contadortres]=$elemento['descripcion'];
$RESULTADO[$segundocontador][$elemento['descripcion']]=round($elemento['valor'],2);

}
else
{
$contadortres=$contadortres+1;
$segundocontador=0;
$descripcion=$elemento['descripcion'];
$RESULTADO[$segundocontador][$contadortres]=$elemento['descripcion'];
$RESULTADO[$segundocontador][$elemento['descripcion']]=round($elemento['valor'],2);	

}
$contador=$contador+1;
$segundocontador=$segundocontador+1;
}
$java=json_encode($RESULTADO);
}
else
{


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


$query_final="select sum(historial.dato) as valor,sum(historial.dato)/$numerosensores as promedio, historial.fecha, historial.hora from historial,sensor";
$query_final=$query_final." $query_where group by historial.fecha , historial.hora ";

$contador=0;
$datos_procesados=0;
$fecha_test=0;
$RANGO_F;
foreach($base->query($query_final) as $elemento)
{
$RESULTADO[$contador]['valor']=round($elemento['valor'],2);
$RESULTADO[$contador]['fecha']=$elemento['fecha']." ".$elemento['hora'];
$RANGO_F[$contador]['fecha']=$elemento['fecha'];
$RANGO_F[$contador]['hora']=$elemento['hora'];
#$RESULTADO[$contador]['promedio']=round($elemento['promedio'],2);
$datos_procesados=$datos_procesados+1;
$fecha_test=$elemento['fecha'];
$contador=$contador+1;
}
$datos_analizar=$datos_procesados;

$rango_fechas_analizar=rango_fechas($fecha_test,$fechaphp[1]);
$tamanho=count($rango_fechas_analizar);
$conteo=0;
$contador=0;
$fecha_test=$RANGO_F[0]['fecha'];

while($conteo<$tamanho)
{
if($fecha_test==$RANGO_F[$contador]['fecha'])
{
$RESULTADO[$datos_analizar]['fecha']=$rango_fechas_analizar[$conteo]." ".$RANGO_F[$contador]['hora'];
$RESULTADO[$datos_analizar]['valor']=0;
$datos_analizar=$datos_analizar+1;
$contador=$contador+1;
}
{
$contador=0;
$conteo=$conteo+1;
}
}

$java=json_encode($RESULTADO);
$nombre;

$query_analisis="select archivo from Analisis where id=$analisis";
foreach($base->query($query_analisis) as $elemento)
{
$nombre=$elemento['archivo'];
}
$ejecucion="/home/juan/anaconda3/bin/python  ../../../../python/$nombre '$datos_procesados'  '$java'";

exec($ejecucion, $output);
$separacion=$output[0];
$valor=json_decode($output[1]);
$evaluados=json_decode($output[2]);
$contador=0;
$resultado;
foreach($valor as $elemento)
{
$resultado[$contador]['fecha']=$RESULTADO[$separacion-1]['fecha'];
$resultado[$contador]['discreto']=($contador+1);
$resultado[$contador]['valor']=round($evaluados[$contador],2);
$resultado[$contador]['regresion']=round($valor[$contador],2);
$contador=$contador+1;
$separacion=$separacion+1;
}

$java=json_encode($resultado);	
	
}


echo($java);

mysqli_close($base);
//RANGO FECHAS
function rango_fechas($start, $end)
{
    $range = array();

    if (is_string($start) === true) $start = strtotime($start);
    if (is_string($end) === true ) $end = strtotime($end);

    if ($start > $end) return createDateRangeArray($end, $start);

    do {
        $range[] = date('Y-m-d', $start);
        $start = strtotime("+ 1 day", $start);
    } while($start <= $end);

    return $range;
}
//fin rango de fechas
?>