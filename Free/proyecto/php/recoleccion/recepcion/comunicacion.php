
<?php

$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$host = "localhost";
date_default_timezone_set("America/Bogota");
$datetime=date("Y-m-d H:i:s");
$dato =date("Y-m-d H:i:s");
$tiempo=date("H:i:s");
$fecha_actual=date("Y-m-d");
$tiempo_minutos=date("i:s");


if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"0";
}


if($ids=$_POST['IDS'] and $id_dispositivo=$_POST['ID_DISPOSITIVO']; and $contrasenha=$_POST['CONTRASENHA'] and $informacion=$_POST['INFORMACION'] and $hora=$_POST['HORA'] and $fecha=$_POST['FECHA'] and $estado=$_POST['ESTADO'])
{//0
$ids=json_decode($ids);
$longitud=count($ids);

$query_sensor="SELECT  `clave`, Activa FROM `dispositivo` WHERE id=$id_dispositivo";
if($resultado = $base->query($query_sensor))
{//1
$respuesta = $resultado->fetch_field();
	
if($respuesta->clave==$contrasenha and $respuesta->Activa=='1')
{//A
$query_sensor="UPDATE `dispositivo` SET `estado`='1',`ultimo_estado`='$datetime' WHERE id=$id_dispositivo";
$base->query($query_sensor);
$contador=0;
$contador_segundo=0;
$sensores_activos;

	

//
while($contador<$longitud)
{
$query_sensor="UPDATE `sensor` SET `estado`='1',`ultimo_estado`='$datetime' WHERE id=$ids[$contador] and id_dispositivo=$id_dispositivo and tipo<9990";
$base->query($query_sensor);
$query_sensor="select tipo from sensor where id=$ids[$contador] and id_dispositivo=$id_dispositivo and tipo<9990";
if($base->query($query_sensor))
{
$sensores_activos[$contador_segundo]['id']=$ids[$contador];
$sensores_activos[$contador_segundo]['informacion']=$informacion[$contador];
$contador_segundo++;
}
$contador=$contador++;
}

	
	
$query_sensor="UPDATE `sensor` SET `id`=[value-1],`id_dispositivo`=[value-2],`descripcion`=[value-3],`tipo`=[value-4],`referencia`=[value-5],`estado`=[value-6],`ultimo_estado`=[value-7] WHERE 1";

}//A>
else
{
echo("120");//el dispositivo esta desactivado o la contrasenha es incorrecta
}
}//1>
else
{
echo("110");//el dispositivo no existe
}
}//0>
else
{
echo("100");//no llegaron los datos basicos
}



?>
