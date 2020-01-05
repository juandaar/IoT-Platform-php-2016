
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
$transmitir['mensaje']='10';
$transmitir['cuenta']='<li><a  class="btn btn-default btn-flat" id="sessionKiller" style="background-color:#00a65a;color: white;"><b>Cerrar sesión</b></a></li>';
$transmitir['usuario']=$_SESSION['username'];

$transmitir['visibilidad']='<li class="treview">
              <a href="#"><i class=" fa fa-file-pdf-o"></i> <span>Información</span> </a>
              <ul class="treeview-menu">
            	     
                     <li class="treview"><a href="../../index.html"><i class="fa fa-circle-o"></i>General</a></li>
                     <li class="treview"><a href="../../pages/basico/sensores.html"><i class="fa fa-circle-o"></i>Sensores</a></li>
					<li class="treview"> <a href="../../pages/basico/analisis.html"><i class="fa fa-circle-o"></i>Análisis</a></li>
	                <li class="treview"><a href="conexion.html"><i class="fa fa-circle-o"></i>Conexión</a></li>
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
			 <li class="active">
                <a href="#"><i class="fa fa-star-o"></i> <span>Creación</span> </a>
              <ul class="treeview-menu">

                     <li class="treview"><a href="sensores.html"><i class="fa  fa-flash"></i>Sensores</a></li>
                     <li class="active"><a href="#"><i class="fa fa-flash"></i>Dispositivos</a></li>
				     <li class="treview">
				      <a href="#"><i class="fa fa-cloud"></i>Analisís de Datos</a>
				         <ul class="treeview-menu">
					         <li><a href="../../pages/avanzado/analisis.html"><i class="fa fa-book"></i>Explicación</a></li>
                         </ul>
	                 </li>
              </ul>';
$transmitir['contenido']='         <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           <b>Dispositivos</b>. 
          </h1>

		
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-star"></i>Administración</a></li>
			<li><a href="#">Dispositivos</a></li>
          </ol>
         </section>

        <!-- Main content -->
        <section class="content">
	<div class="row">
		      <div class="col-md-15">
			  <div class="box box-success" >
               <div class="box-header with-border">
               <h3 class="box-title">Creación de nuevos dispositivos</h3>
               </div>
               <div class="box-body chart-responsive">
				   
			<form class="form-horizontal">
                  
                      <div class="form-group">
                      <label for="descripcion_dispositivo" class="col-sm-2 control-label">Dipositivo</label>
                      <div class="col-sm-8">
                        <input type="descripción" class="form-control" id="descripcion_dispositivo" placeholder="Descripción del dispositivo">
                      </div>
				     </div>
			
					<div class="form-group">
                      <label for="clave_dispositivo" class="col-sm-2 control-label">Clave del dispositivo</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" id="clave_dispositivo" placeholder="Clave">
                      </div>
                    </div>
					
             
               
                </form>
				   <label class="col-sm-4"></label>
				<div class=" col-sm-2 centered"  style="clear: none;" >
		       <input type="submit" class=" btn btn-block  btn-success " id="creacion" value="Crear"   onclick="crear()" />
					</div>
			
             
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
                        <th>Propietario</th>
                      </tr>
                    </thead>
					</table>
				  
              </div><!-- /.box -->
			
		</div>
		
			
		  </section>';
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
					<li class="treview"><a href="conexion.html"><i class="fa fa-circle-o"></i>Conexión</a></li>
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
			 <li class="active">
                <a href="#"><i class="fa fa-star-o"></i> <span>Creación</span> </a>
              <ul class="treeview-menu">

                     <li class="treview"><a href="sensores.html"><i class="fa  fa-flash"></i>Sensores</a></li>
                     <li class="active"><a href="#"><i class="fa fa-flash"></i>Dispositivos</a></li>
				     <li class="treview">
				      <a href="#"><i class="fa fa-cloud"></i>Analisís de Datos</a>
				         <ul class="treeview-menu">
					         <li><a href="../../pages/avanzado/analisis.html"><i class="fa fa-book"></i>Explicación</a></li>
                         </ul>
	                 </li>
              </ul>
			<!--requiere permisos de administracion-->
			 <li class="treeview">
               <a href="#"><i class="fa fa-star-o"></i> <span>Administración</span> </a>
              <ul class="treeview-menu">
                    <li class="treview"><a href="../../pages/administrador/sensores.html"><i class="fa  fa-flash"></i>Sensores</a></li>
                    <li class="treview"><a href="../../pages/administrador/dispositivos.html"><i class="fa fa-flash"></i>Dispositivos</a></li>
				    <li class="treview"><a href="../../pages/administrador/usuarios.html"><i class="fa fa-book"></i>Usuarios</a></li>
                    <li><a href="../../pages/administrador/analisis.html"><i class="fa fa-cloud"></i>Ingresar Algoritmo</a></li>
              </ul>				  

		     <!-- finalizado-->';
$transmitir['contenido']='         <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           <b>Dispositivos</b>. 
          </h1>

		
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-star"></i>Administración</a></li>
			<li><a href="#">Dispositivos</a></li>
          </ol>
         </section>

        <!-- Main content -->
        <section class="content">
	<div class="row">
		      <div class="col-md-15">
			  <div class="box box-success" >
               <div class="box-header with-border">
               <h3 class="box-title">Creación de nuevos dispositivos</h3>
               </div>
               <div class="box-body chart-responsive">
				   
			<form class="form-horizontal">
                  
                      <div class="form-group">
                      <label for="descripcion_dispositivo" class="col-sm-2 control-label">Dipositivo</label>
                      <div class="col-sm-8">
                        <input type="descripción" class="form-control" id="descripcion_dispositivo" placeholder="Descripción del dispositivo">
                      </div>
				     </div>
			
					<div class="form-group">
                      <label for="clave_dispositivo" class="col-sm-2 control-label">Clave del dispositivo</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" id="clave_dispositivo" placeholder="Clave">
                      </div>
                    </div>
					
             
               
                </form>
				   <label class="col-sm-4"></label>
				<div class=" col-sm-2 centered"  style="clear: none;" >
		       <input type="submit" class=" btn btn-block  btn-success " id="creacion" value="Crear"   onclick="crear()" />
					</div>
			
             
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
                        <th>Propietario</th>
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