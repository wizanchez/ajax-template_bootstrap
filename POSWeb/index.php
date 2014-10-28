<?php 


session_start();
$style = true;
include ("settings.php");
if (empty($cfg_language) or empty($cfg_database)) {
	echo "It appears that you have not installed Point Of Sale, please
	go to the <a href='install/index.php'>install page</a>.";
	exit;
}

include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");


				#----------------------------------------------------------------------------------------
				#	ENTRO A LA FUNCION INDEX
				
if(!$_REQUEST['jvm']){


	//create 3 objects that are needed in this script.
	$lang = new language();
	$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,
		$cfg_theme,$lang);
	$sec = new security_functions($dbf,'Public',$lang);

	if (!$sec->isLoggedIn()) {
		header("location: login.php");
		exit();
	}

	$dbf->optimizeTables();
	$dbf->closeDBlink();
	if($_GET['reloadVta'] == '1'){
	    $strMainframe = 'sales/sale_ui.php';
	}else{
	    $strMainframe = 'home.php';
	}

	?>


	<HTML>
	<head>
	<title><?php echo $cfg_company
	?>-- <?php echo $lang->PoweredBy
	?> JVM Company Soft SAS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	</head>
	<frameset border="0" frameborder="no" framespacing="0" rows="45,*">
	<frame name="TopFrame" noresize scrolling="no" src="menubar.php">
	<frame name="MainFrame" id="MainFrame" noresize src="<?=$strMainframe?>">

	</frameset>
	<noframes>
	  <body bgcolor="#FFFFFF" text="#000000">

	  </body>
	</noframes>
	</HTML>
	<?PHp 

}else{

$lang 	=new language();
$dbf 	=new db_functions(
							$cfg_server
							,$cfg_username
							,$cfg_password
							,$cfg_database
							,$cfg_tableprefix
							,$cfg_theme
							,$lang
						);
/*
$sec  	=new security_functions(
								$dbf
								,'Report Viewer'
								,$lang
								);
*/

	date_default_timezone_set("America/Bogota");

	if(!$_REQUEST['jvm']){

		echo 'Error Mod ->declare wiz';
		exit;
	}


		$a_mod_meth 	=explode("/",$_REQUEST['jvm']);
		$a_mod_meth_2	=explode(".",$a_mod_meth[1]);


			if($a_mod_meth_2[1]!="jvm"){
				echo 'Error En extencion del Archivo .jvm';
				exit;
			}

				###--------------------------------------------------------------------------------------
				## CLASE PARA ADICIONAR
													define(C_FOLDERDB,'');
													define(CLASS_MODULO,$a_mod_meth[0]);
													define(CLASS_METODO,$a_mod_meth_2[0]);
				##	NOMBRE DE LA EMPRESA PARA VALIDAR, EN ESTE CASO ES PASTELO
													define(DF_NOMBRE_EMPRESA,'PASTELO');
				###--------------------------------------------------------------------------------------


							  $v_val_error 	=false;
							  $v_metodo		=CLASS_METODO.'_ctr';
							  $v_modulo 	=CLASS_MODULO.'_ctr';

/*
							$cfg_server
							,$cfg_username
							,$cfg_password
							,$cfg_database
							,$cfg_tableprefix
							,$cfg_theme
							,$lang

 */
		###--------------------------------------------------------------------------------------
		## funcion para autenticar, y crear la coneccion
					$URL_CLASS = C_FOLDERDB . 'framework_jvm/Fjvm_cargar.frj.php';
					if (!file_exists($URL_CLASS)) {echo 'Error '.$URL_CLASS;}else{require_once ($URL_CLASS);}
					$URL_CLASS = C_FOLDERDB . 'classes/adodb/adodb.inc.php';
					if (!file_exists($URL_CLASS)) {echo 'Error '.$URL_CLASS;}else{require_once ($URL_CLASS);}
					$URL_CLASS = C_FOLDERDB . 'framework_jvm/Fjvm_consulta.class.php';
					if (!file_exists($URL_CLASS)) {echo 'Error '.$URL_CLASS;}else{require_once ($URL_CLASS);}
				
										$conn = NewADOConnection('mysql');
										$conn->Connect($cfg_server, $cfg_username, $cfg_password, $cfg_database);

		###--------------------------------------------------------------------------------------
									Fjvm_cargar::objeto_modulo3(CLASS_MODULO);

				#----------------------------------------------------------------------------------------
				#	OBTENGO LO GENERADO POR METODO POST O GET Y LO ENVIO EN UN ARRAY
					global $a_request,$conn,$lang;
						$a_request 	=Fjvm_cargar::get_request();
				#----------------------------------------------------------------------------------------


							/*instancianmos el objeto, para reconocer el modulo, si es login o si esta en registro*/
				##------------------------------------------------------------------------------------------------------------------
				#	VERIFICO QUE LAS CLASES ESTE BIEN INSCRITAS
						if(!class_exists(CLASS_MODULO.'_ctr',false)){
								ni_error_metodo('Class No existe :'.CLASS_MODULO.'_ctr');
								$v_val_error 	=true;
						}
						if(!class_exists(CLASS_MODULO.'_view',false)){
								ni_error_metodo('Class No existe :'.CLASS_MODULO.'_view');
								$v_val_error 	=true;
						}
						if(!class_exists(CLASS_MODULO.'_js',false)){
								ni_error_metodo('Class No existe :'.CLASS_MODULO.'_js');
								$v_val_error 	=true;
						}
						if(!class_exists(CLASS_MODULO,false)){
								ni_error_metodo('Class No existe :'.CLASS_MODULO);
								$v_val_error 	=true;
						}

						if($v_val_error===true)exit;




							$obj_modulo 	=new $v_modulo();


						if (method_exists($obj_modulo,$v_metodo)) {
										 
					            ##------------------------------------------------------------------------------------ 
					              /*instancianmos el objeto, para reconocer el modulo, si es login o si esta en registro*/
					                $v_modulovew  	=CLASS_MODULO.'_view';
					                $obj_modulovew	=new $v_modulovew();
					            ##------------------------------------------------------------------------------------

			                		#----------------------------------------------------------------------
			                		#	AVERIGUO SI TIENE EL MODULO DE LA VISTA
			                		 if (!method_exists($obj_modulovew,CLASS_METODO.'_view')) {

			                		 		ni_error_metodo(CLASS_MODULO.'.'.CLASS_METODO.'_view');
			                		 }
			                		#----------------------------------------------------------------------



										   $obj_modulo->$v_metodo();
										



										}else{
												echo 'Pagina NO Encontrada';
									##---------------------------------------------------------------------------------------
									##	INCLUYO CLASES A UTILIZAR DEL FRAMEWORK
										#class_general::importar_libreria(array(
										#										'decoracion',
										#										
										#									));
									##---------------------------------------------------------------------------------------

										##-------------------------------------------------
										#	SI NO EXISTE EL METODO
										 	#class_decoracion::Falso('EN Construccion', '');

											
											echo '<br>method='.CLASS_METODO.'<br>';
											echo 'sub_meth='.$_REQUEST['sub_mth'].'<br>';
											echo 'modulo='.CLASS_MODULO.'<br>';
										##-------------------------------------------------
										
										}	





}#ELSE

function ni_error_metodo($_error)
	{

		echo '<h1>Error en modulo -> '.$_error.'</h1>';
		exit;
	}





