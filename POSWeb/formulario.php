<?php session_start();


if($_REQUEST['AJAXX']!='TRUE'){

define(URL_RAIZ_FONDO,'');
include(URL_RAIZ_FONDO.'classes/stylos_new.class.php'); 

include(URL_RAIZ_FONDO.'classes/TextDecoracion.php'); 
	$ObjDeco=new TextDecoracion();		

}

 ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link href="css/estilo.css" media="screen" rel="stylesheet" type="text/css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script>
        	$(document).ready(function(){
        	   
              	
				$("#frmArchivo").submit(function(){
      		 	jQuery('#respuesta').html('Jvm Cargando....  Puede tardar unos minutos');		     				
      				var datos = new FormData();
      				datos.append('archivo',$('#archivo')[0].files[0]);
									
      				$.ajax({
      					type:"post",
      					dataType:"json",
      					url:"importar.php",      					
      					contentType:false,
						data:datos,
						processData:false,
						cache:false
      				}).done(function(respuesta){      					
      					//alert(respuesta.mensaje);
                        $('#respuesta').html(respuesta.mensaje);        					
      				});
      				return false;
      			});
      		});
        </script>        
    </head>
    <body>   
    
   <br /><br />
    <img border="0" src="images/subirdatos.png" width="55" height="55" valign="top"><font color="#005B7F" size="4">&nbsp;<b>Insercion Masiva de Pacientes</b></font></p>
    <p><font face="Verdana" size="2">Inserte Los datos de los nuevos Pacientes Por Aqui</font></p>              
    <p><font face="Verdana" size="2">Archivo Soportado (.txt), Tama&nacute;o Maximo: 2Mb</font></p>
       	<form name='frmArchivo' id="frmArchivo" method="post">       	
  		
          <table align="center" style="font:Verdana, Geneva, sans-serif; size:2;">
            <tr>
            	<td  ><font color="#005B7F" size="4"><strong>Archivo:</strong></font></td>
            	<td  width="100" class="popScripts  EfectoZoom "><input type="file" name="archivo" id="archivo" accept=".txt" /></td>
            	<td  ><input type="hidden" name="MAX_FILE_SIZE" value="20000" /><input type = "submit" name="enviar" value="Importar"/>   </td>
            </tr>
            <tr>
            	<td colspan="3"></td>
            	</tr>
        </table>
          	
   			
   		    			       
   			
                      	
      	</form>
        <table align="center" style="font:Verdana, Geneva, sans-serif; size:2;">
         
        <tr>
        	<td colspan="3" width="100" class="popScripts  EfectoZoom "><div id="respuesta" >Resultados:</div>   </td>
        	</tr>
         </table>
              
        
    </body>
</html>
