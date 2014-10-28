<?php
 define(DB_TYPE,'mysql');
 define(DB_SERVER,"localhost");
 define(DB_SERVER_USERNAME,"root");
 define(DB_SERVER_PASSWORD,"");
 define(DB_DATABASE,"jvmcompa_posweb_1");
 /*
 error_reporting(E_ALL);
ini_set("display_errors", 1);*/
set_time_limit(o);
include ("classes/db_functions.php");
include ("classes/security_functions.php");

#########################################################################################################################################################
	###ENTRA A LA CONECCION
	/*	$style		='FALSE';
		$url_class 	= 'settings.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}*/
		$url_class 	= 'classes/adodb/adodb.inc.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
		ADOLoadCode(DB_TYPE);
		$conn 		= &ADONewConnection();
		$conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
		//$url_class 	= 'classes/consulta.class.php';
	  	//	if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}

	#########################################################################################################################################################




	$tipo = $_FILES['archivo']['type'];
	$tamanio = $_FILES['archivo']['size'];
	$archivotmp = $_FILES['archivo']['tmp_name'];
    //$ruta = "uploads/" . $_FILES['file']['name'];
	$respuesta = new stdClass();
	
	if( $tipo == 'text/plain'){
		
         
		$archivo = "uploads/pacientes.txt";
	
		if(move_uploaded_file($archivotmp, $archivo) ){
	 		$respuesta->estado = true;		
		} else {
    		$respuesta->estado = false;
			$respuesta->mensaje = "El archivo no se pudo subir al servidor, intentalo mas tarde";
		}
	
		if($respuesta->estado){
		    
            //echo 'LA RUTA'.$ruta; 
            
           	$lineas = file('uploads/pacientes.txt'); 
			//$lineas = file($ruta);

			$respuesta->mensaje = "";
			$respuesta->estado = true;
            
		//	$conexion = new mysqli('localhost','root','','jvmcompa_posweb1',3306);
                     
                     
                          
			foreach ($lineas as $linea_num => $linea)
			{ 
                            
				$datos = explode(",",$linea);
                                 
				$first_name = trim($datos[0]);
				$first_name2= trim($datos[1]);
				$last_name = trim($datos[2]);
				$last_name2 = trim($datos[3]);
                $cedula = trim($datos[4]);
                $phone_number = trim($datos[5]);
                $email= trim($datos[6]);
                $street_address = trim($datos[7]);
                $convenioid = trim($datos[8]);
                $carnet_number = trim($datos[9]);
                
                $fecha = explode("/", $datos[10]);
                $data10 = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $lastchangedate = $data10 ;
                $almacenid = trim($datos[11]);
                $parent_id = trim($datos[12]);
                                
                
                
		        //$rc_sql = &$conn->Prepare($consulta); 
                //if($conn->Execute($rc_sql)===false){echo 'error SQL ['.$rc_sql.']['.$conn->ErrorMsg().']';}                                
			 
                
               // $respuesta->mensaje .="$datos";
                // $entidad=&$conn->Execute('SELECT id,tipo_cotizacion FROM paciente_tipo_cotizacion WHERE cancel=0 group by id');
                
                 $sql_valid = "select id from pos_pacientes where account_number  = '" . $cedula . "' ";
               	if ($rc_carnet = &$conn->Execute($sql_valid) === false) { $respuesta->mensaje .="El Paciente No se Puedo Adocionar ocurrio un error ln 97 $cedula \n";exit;}
                 
                if($rc_carnet->RecordCount() > 0){
                     
                      $respuesta->mensaje .="El Paciente ya Existe  $cedula \n".'<br />';
                     
                  }else{
                    
                    $consulta =" INSERT INTO pos_pacientes ( first_name, first_name2, last_name, 
                last_name2, account_number, phone_number, 
                email, street_address, convenioid, 
                carnet_number, lastchangedate, almacenid, 
                parent_id) 
                VALUES ( UPPER('" . $first_name . "'), UPPER('" . $first_name2 . "'), UPPER('" . $last_name . "'), UPPER('" . $last_name2 . "'),
                '" . $cedula . "', 
                '" . $phone_number . "', '" . $email . "', UPPER('" . $street_address . "'), '" . $convenioid . "',
                '" . $carnet_number . "', '" . $lastchangedate . "', '" . $almacenid . "', '" . $parent_id . "')"; 

                $rc_sql = &$conn->Prepare($consulta);
                if($conn->Execute($rc_sql)===false){$respuesta->mensaje .= "El alumno $first_name $first_name2 $last_name no se guardo, verifica la información \n";}
                  
                  
                }
                      
	    		        //$consulta = "INSERT INTO tblalumno(matricula,paterno, materno, nombre) VALUES('$matricula','$paterno','$materno','$nombre');";			
				/*if(!$conexion->query($consulta)){			
					$respuesta->estado = false;
					$respuesta->mensaje .= "El alumno $first_name $first_name2 $last_name no se guardo, verifica la información \n"; 				
				}*/
			}//froeach
           //die('ACA ENTRO dd');
		}
              
                     
                
		if($respuesta->estado == true)
			$respuesta->mensaje .= "Todos los registros se revisaron correctamente\n";
	}
	else {
		$respuesta->mensaje = "Solo se admiten archivos .txt, vuelvelo a intentar\n";
	}
        
	echo json_encode($respuesta);
?>