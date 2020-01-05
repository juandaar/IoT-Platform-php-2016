
<?php
// Desactivar toda notificación de error
//error_reporting(0);
// Notificar solamente errores de ejecución
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$host = "localhost";
//db0 es la base de datos de pruebas 
$db= "mydb";
$usuario="JUAN";
$contrasena="judaarco";
// se crea la conexion
if(!$base= new mysqli("$host","$usuario","$contrasena","$db"))
{
echo"<br>No se logro la conexión<br>";
}

if($nombre=htmlspecialchars($_POST['NOMBRE']) and $tipo=(int)($_POST['TIPO'])>=0 and ($analisis=(int)($_POST['ANALISIS']))>=0 and $python=$_FILES['PY'] and $pdf=$_FILES['PDF'])
{
     $ruta_algoritmo = "../../../python/";
	 $ruta_descripcion="../../../pdf/";
     $ruta_algoritmo = $ruta_algoritmo.$python['name']; 
	$ruta_descripcion=$ruta_descripcion.$pdf['name'];
 

     if ($pdf['name']!='' and $python['name']!='')
	 {
		 
      if( strpos($pdf['type'],"pdf") and strpos($python['type'], "py"))
		   {   
	  $existe=0;   
	  if($analisis==0)
	 {
	  $query="select * from Analisis";
	 foreach($base->query($query) as $elemento)
	 {
	 if($python['name']==$elemento['archivo'] or $nombre==$elemento['Nombre'] or $pdf['name']==$elemento['PDF'])
	 {
	 $existe=1;
	 }
	 }//foreach
	
  
	 if($existe==0)
	    {  
		 if(move_uploaded_file($python['tmp_name'],$ruta_algoritmo) and chmod($ruta_algoritmo, 0666)  and move_uploaded_file($pdf['tmp_name'],$ruta_descripcion) and chmod($ruta_descripcion, 0666) )
				   {
					 $a=$python['name'];
					 $b=$pdf['name'];
					
					$query="INSERT INTO `Analisis`(`Nombre`, `archivo`,`Tipo_analisis`, `PDF`) VALUES ('$nombre','$a',1,'$b')";
					  
					  if($base->query($query))
					  {
					  echo("procedimiento exitoso");
					  }
					  else
					  {
					  echo("error en la base de datos");
					  }
					  
                        
                   }
		 else
		 {
		 echo("No se logro cargar los archivos");
		 }
	   
	    }
	 else
	    {
		echo("Ya existe un algoritmo o archivo con ese nombre");
	    }
	  }
	  else
	  {
	 $query="select archivo,PDF from Analisis where id=$analisis";
	if($resultado=$base->query($query))
	{
	$respuesta=$resultado->fetch_array();
		
	if($respuesta[0]==$python['name'] and $respuesta[1]==$pdf['name'])
	   {
	  $query="UPDATE `Analisis` SET `Nombre`='$nombre' WHERE id='$analisis'";
		   
		    if($base->query($query))
			{
		if(move_uploaded_file($python['tmp_name'],$ruta_algoritmo) and chmod($ruta_algoritmo, 0666)  and move_uploaded_file($pdf['tmp_name'],$ruta_descripcion) and chmod($ruta_descripcion, 0666) )
		{
		echo("Los archivos fueron modificados satisfactoriamente");
		}
		else
		{
		echo("no se logro modificar los archivos");
		}
			}
		   else
		   {
			echo("Error en la base de datos");
		   }
	   }
	else
	{
	echo("los nombres de los archivos no coinciden");
	}
	}
	else
	{
	echo("Error en la base de datos");
	}
	  }
          
            }     
		  else
		  {
           echo("Los archivos no son del tipo correcto");      
          }
             
     }  
     else 
	 {
	echo("Falta información");
	 }

}
else
{
echo("FALTAN DATOS");
}
?>