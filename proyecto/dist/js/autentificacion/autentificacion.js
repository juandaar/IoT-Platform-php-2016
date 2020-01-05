
$('#boton').click(function(){

            if ( $('#correo').val() != "" && $('#contrasenha').val() != "" )
			{
                 $.post("../php/autentificacion/login.php",{CORREO:$('#correo').val(),CONTRASENHA:$('#contrasenha').val()},
				function(data)
				{
				if(data == 0)
				    {
					  alert("El usuario o la contraseña son incorrectos");
	
				    }
				else
				    {
						if(data == 1)
						{
						 alert("Conectando");
						document.getElementById("conectado").click();
							
						}
						else
						{
						alert("Error de conexión");
			    
					}
					}
				 });
			}
			else
			{
			alert("Falta información");	
			}
        
 
        
     

});
