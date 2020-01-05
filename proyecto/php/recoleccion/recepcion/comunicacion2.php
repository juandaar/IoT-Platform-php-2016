<?php

$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
$host = "localhost";
date_default_timezone_set("America/Bogota");
$fecha_completa=date("Y-m-d H:i:s");

if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
//
}
//respuestas;
//codigo 100, no llego informacion basica 
//codigo 110, el dispositivo no existe
//codigo 120, el dispositivo esta registrado como 	
//codigo 130, contrasenha incorrecta
//codigo 200, se actualizo el estado y aun no se requiere la transmision de informacion
//codigo 250, se actualizo el estado y se realizan ajustes por problemas de  desconexion o implementacion
//codigo 300, enviar informacion
//codigo 400, la informacion llego correctamente
//codigo 500, se realizara alguna accion en algun sensor
//(codigo 500, aun no se ha realizado el diseño de esta area)

// ultimo estado: la informacion que se obtendra de este dato es 0, 15,30,45 ya que se maneja una logica en la cual la informacion llegara cada 15 minutos
// para no tener que emplear un reloj en el dispositivo, el cual requiere logica extra

if($ids=$_POST['IDS'] and $id_dispositivo=$_POST['ID_DISPOSITIVO']; and $contrasenha=$_POST['CONTRASENHA'] and $ultimoestado=$_POST['ESTADO'] and $fecha=$_POST['FECHA'])
{//principal
$longitud=count($ids); //cantidad de sensores
// se selecciona la clave registrada del dispositivo
$query_sensor="SELECT  `clave`, Activa FROM `dispositivo` WHERE id=$id_dispositivo";

	if($resultado = $base->query($query_sensor))
    {//existencia del dispositivo
		$respuesta = $resultado->fetch_field(); // se sacan los datos	
        if($respuesta->Activa=='1')
        {//verificacion de estado , si el estado es 1 significa que esta activo 
			if($respuesta->clave==$contrasenha)
			{//contrasenha 
			//se actualiza el estado del dispositivo 
			$query_sensor="UPDATE `dispositivo` SET `estado`='1',`ultimo_estado`='$fecha_completa' WHERE id=$id_dispositivo";
            $base->query($query_sensor);
			$contador=0;
            $contador_segundo=0;
            $sensores_activos;
			//se comienza a cambiar el estado de los sensores que esten registrados como activos
				while($contador<$longitud)
				{
                 $query_sensor="UPDATE `sensor` SET `estado`='1',`ultimo_estado`='$fecha_completa' WHERE id=$ids[$contador] and id_dispositivo=$id_dispositivo and tipo<9990";
					if($base->query($query_sensor))
					{
					//se registran los sensores que estan activos
					$sensores_activos[$contador_segundo]['id']=$ids[$contador];
					$sensores_activos[$contador_segundo]['informacion']=$informacion[$contador];
					$contador_segundo++;
                    }
				$contador=$contador++;
                }
				//el dispositivo transmitio informacion
				if($informacion=$_POST['INFORMACION'])
				{
				$hora_actual=date("H:i:s");
					$fecha_actual=date("Y-m-d");
					$tiempo=date("i");				
				}
			    else 
				{//el dispositivo no ha enviado informacion
				$fecha_segundos=strtotime($fecha_completa);
				$diferencia=($fecha_segundos-$fecha)/60;
                    if($diferencia<16)
					{//esta en un rango aceptable desde la ultima vez que se conecto
						$minutos=date("i"); // se toman el minuto actual
						$diferencia=$minutos-$ultimoestado;
						if($diferencia>15 and $diferencia<16)
						{
							if($ultimoestado==0)
							{
							$ultimoestado=15;
							}
							else
							{
						    if($ultimoestado==15)
							{
							$ultimoestado==30;
							}
						    else
							{
							if($ultimoestado==30)
							{
                            $ultimoestado==45;
							}
							}
							}
							echo('[{"codigo:"300","estado":"'.$ultimoestado.'","fecha":"'.$fecha_segundos.'"}]');
						}
				        else
				        {
						$numero=-45;
							if($diferencia<$numero and $diferencia>($numero-2))
							{
							$ultimoestado=0;
							echo('[{"codigo:"300","estado":"'.$ultimoestado.'","fecha":"'.$fecha_segundos.'"}]');
							}
							else
							{//controla el tiempo en que se va a hacer el proximo envio
								if($diferencia>0 and $diferencia<2)
								{
								echo('[{"codigo:"200","tiempo":"600"}]'); //significa que se le brindan 600 segundos sin transmitir informacion(ahorro de bateria)
								}
								if($diferencia>10 and $diferencia<12)
								{
								echo('[{"codigo:"200","tiempo":"120"}]'); //significa que se le brindan 120 segundos sin transmitir informacion(ahorro de bateria)
								}
							    if($diferencia>14 and $diferencia<15)
								{
								$tiempo=date("s");
								echo('[{"codigo:"200","tiempo":"':$tiempo.'"}]'); //significa que se le brindan los segundos que faltan para  transmitir informacion(ahorro de bateria)
								}
							}//controla el tiempo en que se va a transmitir la siguiente informacion
						
				        }
					}
					else
					{
					 $minutos=date("i"); // se toman el minuto actual
						if($minuto<15)
						{
						 echo('[{"codigo:"250","estado":"0","fecha":"'.$fecha_segundos.'"}]');
						}
						else
						{
						if($minuto<30)
						{
						echo('[{"codigo:"250","estado":"15","fecha":"'.$fecha_segundos.'"}]');
						}
						else
						{
						if($minuto<45)
						{
					    echo('[{"codigo:"250","estado":"30","fecha":"'.$fecha_segundos.'"}]');
						}
						else
						{
					    echo('[{"codigo:"250","estado":"45","fecha":"'.$fecha_segundos.'"}]');
						}
						}
						}
					  
					}
				}//el dispositivo no ha enviado informacion

		    }//contrasenha correcta
			else
			{
	         echo('[{"codigo":"130"}]'); //contrasenha incorrecta			
			}
		}
		else 
		{
	    echo('[{"codigo":"120"}]'); //dispositivo inactivo
		}
		
		
	}
	else
	{
	echo('[{"codigo":"110"}']); //el dispositivo no existe
	}
}//cierre principal
else
{
echo('[{"codigo":"100"}]'); 
}










	
	
$query_sensor="UPDATE `sensor` SET `id`=[value-1],`id_dispositivo`=[value-2],`descripcion`=[value-3],`tipo`=[value-4],`referencia`=[value-5],`estado`=[value-6],`ultimo_estado`=[value-7] WHERE 1";

}//A>
else
{
echo("120");//el dispositivo esta desactivado o la contrasenha es incorrecta
}
}//1>





?>