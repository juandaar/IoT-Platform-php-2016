
<?php 
session_start(); 

if ( isset($_SESSION['username']) && isset($_SESSION['userid']) && $_SESSION['username'] != '' && $_SESSION['userid'] != '0' )
{

include '../../bd/localhost.php';
$query='SELECT perfil FROM usuario WHERE Nombre="'.$_SESSION['username'].'" and ID="'. $_SESSION['userid'].'" LIMIT 1';
if($respuesta=$base->query($query))
{

if ( $respuesta->num_rows == 1 )
{

$perfil = $respuesta->fetch_array();
$perfil=$perfil['perfil'];
$transmitir['mensaje']="$perfil";

if($perfil==1)
{
$transmitir['mensaje']='20';

}
else
{
if($perfil==2)
{
$transmitir['mensaje']='20';
}
else
{
if($perfil==3)
{
$transmitir['mensaje']='10';
$transmitir['cuenta']='<li><a  class="btn btn-default btn-flat" id="sessionKiller" style="background-color:#00a65a;color: white;"><b>Cerrar sesión</b></a></li>';
$transmitir['usuario']=$_SESSION['username'];

$transmitir['visibilidad']='<li class="treview">
              <a href="#"><i class=" fa fa-file-pdf-o"></i> <span>Información</span> </a>
              <ul class="treeview-menu">
            	     
                     <li class="treview"><a href="../../index.html"><i class="fa fa-circle-o"></i>General</a></li>
                     <li class="treview"><a href="../../pages/basico/sensores.html"><i class="fa fa-circle-o"></i>Sensores</a></li>
					<li class="treview"> <a href="../../pages/basico/analisis.html"><i class="fa fa-circle-o"></i>Análisis</a></li>
					<li class="treview"><a href="../../pages/avanzado/conexión"><i class="fa fa-circle-o"></i>Conexión</a></li>
             </ul>
            </li>
			<li class="treeview">
             <a href="#"><i class=" fa fa-file-pdf-o"></i> <span>ProyectoUdea</span> </a>
             <ul class="treeview-menu">
                     <li class="treview"><a href="../../pages/basico/informacion.html"><i class="fa fa-circle-o"></i>¿Qué es?</a></li>
                     <li class="treview"><a href="../../pages/basico/guias.html"><i class="fa fa-circle-o"></i>Guia</a></li>
					<li class="treview"> <a href="../../pages/basico/agradecimientos.html"><i class="fa fa-circle-o"></i>Agradecimientos</a></li>
              </ul>
             </li>
             <li class="treeview"><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
			    <ul class="treeview-menu">
					<li class="treview"><a href="../../pages/basico/dashboard.html"><i class="fa fa-book"></i>General</a></li>
                    <li class="treview"><a href="../../pages/basico/sensores/dashboard.html"><i class="fa fa-wifi "></i>Sensores</a></li>
					
                </ul>
			 </li> <!-- requiere permisos avanzados dados por el administrador de la pagina -->
			 <li class="treeview">
                <a href="#"><i class="fa fa-star-o"></i> <span>Creación</span> </a>
              <ul class="treeview-menu">

                     <li class="treview"><a href="../../pages/avanzado/sensores.html"><i class="fa  fa-flash"></i>Sensores</a></li>
                     <li class="treview"><a href="../../pages/avanzado/dispositivos.html"><i class="fa fa-flash"></i>Dispositivos</a></li>
				     <li class="treview">
				      <a href="#"><i class="fa fa-cloud"></i>Analisís de Datos</a>
				         <ul class="treeview-menu">
					         <li><a href="../../pages/avanzado/analisis.html"><i class="fa fa-book"></i>Explicación</a></li>
                         </ul>
	                 </li>
              </ul>
			<!--requiere permisos de administracion-->
			 <li class="active">
               <a href="#"><i class="fa fa-star-o"></i> <span>Administración</span> </a>
              <ul class="treeview-menu">
                    <li class="active"><a href="../../pages/administrador/sensores.html"><i class="fa  fa-flash"></i>Sensores</a></li>
                    <li class="treview"><a href="../../pages/administrador/dispositivos.html"><i class="fa fa-flash"></i>Dispositivos</a></li>
				    <li class="treview"><a href="../../pages/administrador/usuarios.html"><i class="fa fa-book"></i>Usuarios</a></li>
                    <li class="treview"><a href="../../pages/administrador/analisis.html"><i class="fa fa-cloud"></i>Ingresar Algoritmo</a></li>
              </ul>				  

		     <!-- finalizado-->';
$transmitir['contenido']='      <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           <b>Sensores</b>. 
          </h1>

		
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-star"></i>Administración</a></li>
			<li><a href="#">Sensores</a></li>
          </ol>
         </section>

           <section class="content">
	<div class="row">
		      <div class="col-md-15">
			  <div class="box box-success" >
               <div class="box-header with-border">
               <h3 class="box-title">Administrador sensores</h3>
               </div>
               <div class="box-body chart-responsive">
				   
			<form class="form-horizontal">
                  
				   <div class="form-group">
                      <label class="col-sm-2 control-label">Tipo Sensor</label>
					 <div class="col-sm-8">					
                      <select class="form-control select2" data-placeholder="Seleccione el tipo de sensor" style="width: 100%;" id="clase_sensores" ">
                       
                      </select>
				
					</div> </div>
				
				
                      <div class="form-group">
                      <label for="descripcion_sensor" class="col-sm-2 control-label">Sensor</label>
                      <div class="col-sm-8">
                      <select class="form-control select2" data-placeholder="Seleccione el sensor" style="width: 100%;" id="sensores" >
                       
                      </select>
                      </div>
				     </div>
				
				     <div class="form-group">
                      <label for="descripcion_sensor" class="col-sm-2 control-label">Nueva Descripción</label>
                      <div class="col-sm-8">
                        <input type="descripción" class="form-control" id="descripcion_sensor" placeholder="Defina la nueva descripción del sensor">
                      </div>
				     </div>
					 
 
				    <div class="form-group">
					  <label class="col-sm-2 control-label">Dispositivo</label>
						<div class="col-sm-8">
                      <select class="form-control select2" data-placeholder="Seleccione el dispositivo"   allowClear: true style="width: 100%;" id="clase_dispositivos" >
         
                      </select>
						</div></div>
					
				 
					
             
               
                </form>
				   <label class="col-sm-4"></label>
				<div class=" col-sm-2 centered"  style="clear: none;" >
		       <input type="submit" class=" btn btn-block  btn-success " id="modificacion" value="Modificar"    />
					</div>
			    <div class=" col-sm-2 centered"  style="clear: none;" >
		       <input type="submit" class=" btn btn-block  btn-success " id="ocultar" value=""   />
					</div>
             
                  </div>   
				   <div>
					<i class="fa fa-warning"></i><b> Advertencia:</b>ocultar el sensor, evita el ingreso de nuevos datos,  los sensores que no han reportado datos por  1 mes seran catalogados  como  ocultos automaticamente
				    </div>
				
				   
                </div>
                </div><!-- /.box-body -->
             
				  
		
              <div class="box box-success" >
                <div class="box-header with-border">
                  <h3 class="box-title">Sensores</h3>
                </div>
                <table id="tabla_datos" class="table table-bordered table-hover">
				    <thead>
                      <tr>
					   <th>ID</th>
                        <th>Sensor</th>
                        <th>Dipositivo</th>
                        <th>Tipo</th>
          
                      </tr>
                    </thead>
					</table>
				  
              </div><!-- /.box -->
			
		</div>
		
			
		  </section>';
}
else
{
$transmitir['mensaje']='20';
}
}
}
			  
}
else
{
$transmitir['mensaje']='20';
}
}
else
{
$transmitir['mensaje']='20';
}

}
else
{
$transmitir['mensaje']='20';
}
$transmitir=json_encode($transmitir);
echo($transmitir);
?>
	
	



