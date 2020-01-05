<?php
//por el metodo post estas variables toman su valor del documento dashboard.php
//esta peticion funciona en los 3 dashboard.html de agua energia y gas
//realiza una peticion respecto al tipo y entrega como resultado la sumatoria de los valores respectos a la id, el cual se usa en la grafica barras
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
/*
//generar colores aleatorios
function randomColor() {
    $str = '#';
    for($i = 0 ; $i < 6 ; $i++) {
        $randNum = rand(0 , 15);
        switch ($randNum) {
            case 10: $randNum = 'A'; break;
            case 11: $randNum = 'B'; break;
            case 12: $randNum = 'C'; break;
            case 13: $randNum = 'D'; break;
            case 14: $randNum = 'E'; break;
            case 15: $randNum = 'F'; break;
        }
        $str .= $randNum;
    }
    return $str;
}
*/
//para las barras


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
$query_sensor=" and historial.id_sensor=sensor.id and sensor.tipo='$tipo' and sensor.tipo=Tipo_sensores.ID"; 

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


$query_data="WHERE fecha BETWEEN '$fechaphp[0]' AND '$fechaphp[1]' AND hora between '$horaphp[0]' and '$horaphp[1]'  ";


$query_where=$query_data."$query_sensor $query_dias";

$query_final="select ROUND(sum(historial.dato),2) as valor,ROUND((sum(historial.dato)/count(historial.dato)),2) as promedio,sum(historial.estado) as recopilados, ROUND(max(historial.dato),2) as maximo, ROUND(min(historial.dato),2) as minimo, ROUND(AVG(historial.dato),2) as media,ROUND(2,STDDEV(historial.dato)) as desviacion, count(historial.dato) as cantidad,historial.id_sensor, sensor.descripcion, Tipo_sensores.unidades from historial,sensor,Tipo_sensores";
$query_final=$query_final." $query_where group by(historial.id_sensor)";

$contador=0;
foreach($base->query($query_final) as $elemento)
{
$RESULTADO[$contador]=$elemento;
//$RESULTADO[$contador]['color']=randomColor();
$contador=$contador+1;
}
/*
$contador=0;
$query_final="select  max(historial.dato)";
$query_final=$query_final." $query_where and   group by(historial.id_sensor, historial.dia )  ";

foreach($base->query($query_final) as $elemento)
{
$RESULTADO[$contador]['fecha']=$elemento['fecha']." ".$elemento['hora'];
$contador=$contador+1;
}
*/
$java=json_encode($RESULTADO);

echo($java);



mysqli_close($base);

?>
