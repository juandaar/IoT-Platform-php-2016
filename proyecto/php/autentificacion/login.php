<?php
session_start();

include '../bd/localhost.php';
if ( !isset($_SESSION['username']) && !isset($_SESSION['userid']))
{

// se crea la conexion
if($base= new mysqli("$host","$usuario","$contrasena","$db"))
{

$correo=$_POST['CORREO'];
$contrasenha=$_POST['CONTRASENHA'];
  $sql = "SELECT Nombre,ID FROM usuario WHERE correo='$correo' and contrasenha='$contrasenha' LIMIT 1";
            if ($res=$base->query($sql))
		     {
		  
                if ( $res->num_rows == 1 ){
                         
                    $user = $res->fetch_array();
                     
                    $_SESSION['username']   = $user['Nombre'];
                    $_SESSION['userid'] = $user['ID'];
                    echo 1;
                         
                }
                else
				{
					
                    echo 0;
				}
            }
            else
			{
				
                echo 2;
			}
                 
    mysqli_close($base);              
   }
      else
	  {
		echo 3;
	  }

   }

else
{
	
    echo 3;
    }


?>