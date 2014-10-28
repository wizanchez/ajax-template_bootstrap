<?php

class Fjvm_cargar
{


	public function bundler_ext($a_vect)
	{

			/**
			 * libreria de boostrap si se necesita
			 */
			if(in_array('bootstrap',$a_vect)){

						Fjvm_cargar::libreria_bootstrap();
			}

			/**
			 * libreria para el jquery 
			 */
			if(in_array('jquery',$a_vect)){

						Fjvm_cargar::libreria_jquery();
			}




	}
	
	public function fjvm_require_once($url) 
	{
			/* Description: metodo para saber si existe el archivo
			* @param n/a
			* @return n/a
			* @Creado Julio 28 de 2010
			* @autor luis Sanchez
			*/
			$url_class = $url;
			if (!file_exists($url_class)) {
				echo 'Error include { ' . $url_class . ' }<br>';
			} else {
				require_once ($url_class);
			}
		}
		
	public function fjvm_importar_libreria($a_vec_libreria,$url_raiz='') 
	{
			/* Description: metodo para saber si existe el archivo
			* @param n/a
			* @return n/a
			* @Creado Julio 28 de 2010
			* @autor luis Sanchez
			*/
			
			for($i=0;$i<count($a_vec_libreria);++$i){
				$url_class = $url_raiz.'framework_jvm/Fjvm_'.$a_vec_libreria[$i].'.class.php';
				
					if (!file_exists($url_class)) {
							echo 'Error include { ' . $url_class . ' }<br>';
						} else {
							require_once ($url_class);
					}
			
			}
			
		}
		
	public function fjvm_include($url) 
	{
			/* Description: metodo para saber si existe el archivo
			* @param n/a
			* @return n/a
			* @Creado Julio 28 de 2010
			* @autor luis Sanchez
			*/
			$url_class = $url;
			if (!file_exists($url_class)) {
				echo 'Error include { ' . $url_class . ' }<br>';
			} else {
				include ($url_class);
			}
		}
		
		
	public function fjvm_cache($valor) 
	{
			/* Description: metodo para utilizar o no cache
			* @valor; true o false,
			* @Creado Marzo 24 de 2011
			* @autor luis Sanchez
			*/
					$cachear	=($valor===false)?'no-cache':'cache';
					$almacenar	=($valor===false)?'no-store':'cache';
					
							header	("Cache-Control: ".$almacenar.", ".$cachear.", must-revalidate");
							header 	('Cache-Control: private, pre-check=0, post-check=0'); 
							header 	('Expires: 0'); 
							header 	('Pragma: '.$cachear);
		}
	
	public function fjvm_mvc($clases) 
	{global $actionID;
			/* Description: metodo para instanciar el modelo y controlador
			* @clases; nombre de la clase con la cual va a interactuar,
			* @Creado Marzo 24 de 2011
			* @autor luis Sanchez
			*/
					Fjvm_cargar::fjvm_require_once('mvc_modelo/'.SUB_SISTEMA.'_mod_'.$clases.'.class.php');
					Fjvm_cargar::fjvm_require_once('mvc_controlador/'.SUB_SISTEMA.'_ctr_'.$clases.'.class.php');
				
				##	obtengo la accion de la entrada 	
				$actionID	=$_REQUEST['actionID'];
						
		}
	
	
	public function fjvm_coneccion_adodb() 
	{global $userid,$conn;
			/* Description: metodo para la coneccion de forma adodb
			* @Creado Marzo 24 de 2011
			* @autor luis Sanchez
			*/
					Fjvm_cargar::fjvm_require_once('includes/defines.php');
					Fjvm_cargar::fjvm_require_once('includes/defines_2.php');
					Fjvm_cargar::fjvm_require_once('includes/adodb/adodb.inc.php');
					Fjvm_cargar::fjvm_require_once('includes/functions.php');
  						
						ADOLoadCode(DB_TYPE);
  						$conn = &ADONewConnection();
  						$conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
					Fjvm_cargar::fjvm_require_once('framework_jvm/Fjvm_consulta.class.php');
		}
	

	public function fjvm_seguridad() 
	{global $userid,$entered_login,$entered_password,$external_login,$pocket_login,$conn;
			/* Description: metodo para obtener la seguridad
			* @Creado Marzo 24 de 2011
			* @autor luis Sanchez
			*/
			session_start();
					Fjvm_cargar::fjvm_coneccion_adodb();
						
							$login		=$_SESSION['login'];
							$password	=$_SESSION['password'];

			$url_class = 'authentication/secure.php';
			if (!file_exists($url_class)) {echo 'Error include { ' . $url_class . ' }<br>';} else {require_once ($url_class);}
					 
			$url_class = 'includes/genuser_online.php';
			if (!file_exists($url_class)) {echo 'Error include { ' . $url_class . ' }<br>';} else {require_once ($url_class);}
					 
					 

		}
		
	public function fjvm_menu_general() 
	{ global $userid,$conn;
			/* Description: metodo mostrar o incluir los nuevos templates y menus
			* @Creado Marzo 24 de 2011
			* @autor luis Sanchez
			*/
						
					Fjvm_cargar::fjvm_require_once('class/Fjvm_stylos_azul.class.php');
					$url_class = 'Fjvm_crear_menus.php';
					if (!file_exists($url_class)) {echo 'Error include { ' . $url_class . ' }<br>';} else {require_once ($url_class);}
					//Fjvm_cargar::fjvm_require_once('class/Fjvm_template.class.php');
					$url_class = 'class/Fjvm_template.class.php';
					if (!file_exists($url_class)) {echo 'Error include { ' . $url_class . ' }<br>';} else {require_once ($url_class);}
				
		}
	

	public function objeto_modulo3($nombre_modulo,$incluir_otras_clases='') 
	{
	/* 
		* Description: metodo para incluir el archivo controlador y vista
		* @nombre_modulo: nombre de los archivos y clases
		* @incluir_otras_clases:si vamos a incluir otras clases
		* @Creado Julio 28 de 2010
		* @Actualizado Agosto 02 de 2011
		* @autor luis Sanchez
	*/
/*incluyo el nombre de la clase modelo*/



			if($incluir_otras_clases){

				$sub_carpeta	=C_FOLDERDB.$incluir_otras_clases.'/';

				}



			Fjvm_cargar::incluir_archivo($nombre_modulo.'/'.$sub_carpeta.$nombre_modulo . '.class.php');

		/*incluyo el nombre de la clase controlador*/

			Fjvm_cargar::incluir_archivo($nombre_modulo.'/'.$sub_carpeta.$nombre_modulo . '.ctr.php');


			Fjvm_cargar::incluir_archivo($nombre_modulo.'/'.$sub_carpeta.'template/'.$nombre_modulo . '.view.php');
			Fjvm_cargar::incluir_archivo($nombre_modulo.'/'.$sub_carpeta.'template/'.$nombre_modulo . '.js.php');


		/*incluyo el nombre de la clase vista*/
		//$modulo_view = $nombre_modulo . '_view';
		//${'cl_' . $nombre_modulo} = new $nombre_modulo();
		//${'cl_' . $nombre_modulo . '_view'} = new $modulo_view();

	}

	public function incluir_archivo($url,$include=true) 
	{

		/* Description: metodo para saber si existe el archivo
		* @param n/a
		* @return n/a
		* @Creado Julio 28 de 2010
		* @autor luis Sanchez
		*/

		$url_class = $url;

		if (!file_exists($url_class)) {

			echo 'Error include { ' . $url_class . ' }<br>';

		} else {
			
			if($include===true)
				include ($url_class);
			else
				require_once ($url_class);

		}

		/*incluyo el nombre de la clase controlador*/

	}

public function libreria_bootstrap()
	{

			?><!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="js/bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="js/bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap/js/bootstrap.min.js"></script><?PHp

	}
public function libreria_jquery()
	{

			?>
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
			<link rel="stylesheet" href="js/jquery/modal/jquery-ui.css">
    <script src="jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="jquery_ui/css/ui-lightness/jquery-ui-1.8.7.custom.css" media="all" />
<?PHp

	}



/**
 * funcion para obtener todos las datos enviados
 * @return [type] [description]
 */
public function get_request()
	{

		##------------------------------------------------------------
		# 	SEPARO LOS NOMBRE DE LO OBTENIDO
		#$a_rep 	=explode(",",$v_get_resp);

			foreach($_REQUEST as $nombre_campo => $valor){ 
			   $asignacion = "\$a_vect['" . $nombre_campo . "']='" . $valor . "';"; 
			   
			   $a_vect[''. $nombre_campo .'']	=$valor;

			} 

				return $a_vect;
	}




}#classs











