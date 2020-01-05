

$(document).ready(function()
{
$('#boton').click(function(){

        setTimeout(function(){
            if ( $('#correo').val() != "" && $('#contrasenha').val() != "" ){
                 $.post("../php/autentificacion
                $.ajax({
                    type: 'POST',
                    url: 'log.inout.ajax.php',
                    data: 'login_username=' + $('#login_username').val() + '&login_userpass=' + $('#login_userpass').val(),
                     
//si la sesion se inicia correctamente presentamos el mensaje
                    success:function(msj){
						alert(msj);
                        if ( msj == 1 ){
                            $('#alertBoxes').html('<div class="box-success"></div>');
                            $('.box-success').hide(0).html('Espera un momento…');
                            $('.box-success').slideDown(timeSlide);
                            setTimeout(function(){
                                window.location.href = ".";
                            },(timeSlide + 500));
                        }
                         
//caso contrario los datos son incorrectos
                        else{
                            $('#alertBoxes').html('<div class="box-error"></div>');
                            $('.box-error').hide(0).html('Lo sentimos, pero los datos son incorrectos: ' + msj);
                            $('.box-error').slideDown(timeSlide);
                        }
                        $('#timer').fadeOut(300);
                    },
//si se pierden los datos presentamos error de ejecucion.
                    error:function(){
                        $('#timer').fadeOut(300);
                        $('#alertBoxes').html('<div class="box-error"></div>');
                        $('.box-error').hide(0).html('Ha ocurrido un error durante la ejecución');
                        $('.box-error').slideDown(timeSlide);
                    }
                });
                 
            }
             
//caso cantrario si los campos estan vacios debemos llenarlos
            else{
                $('#alertBoxes').html('<div class="box-error"></div>');
                $('.box-error').hide(0).html('Los campos estan vacios');
                $('.box-error').slideDown(timeSlide);
                $('#timer').fadeOut(300);
            }
        },timeSlide);
         
        return false;
         
    });
     

});