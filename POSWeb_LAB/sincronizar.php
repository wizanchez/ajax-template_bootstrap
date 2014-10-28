<?php 
session_start();

include ("settings.php");
include("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

if(!$sec->isLoggedIn()){
	header ("location: login.php");
	exit();
}
$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$first_name = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$last_name= $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);

$name=$first_name.' '.$last_name;
$dbf->optimizeTables();

?>
<HTML>
<head> 

</head>
<body>
<?php
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((     INICIO DEL WEB SERVICE     ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	define(FOLDER_RAIZ,'');//->CARPETA PARA LOS WEBSIERVECI
	define(MAX_RegistrosSZ,'500');//->DEFINE LA CANTIDAD DE REGISTROS A SINCRONIZAR EN CADA VEZ.
	$tiempo = microtime();//->GUARDO LA HORA DONDE INICIA EL PROCESO
	$tiempo = explode(" ", $tiempo);//->DIFIDO LA HORA
	$tiempo = $tiempo[1] + $tiempo[0];//->SUMO LAS POCISIONES
	$tiempoInicial = $tiempo;//->TENGO EL  TIEMPO INICIAL

//->Incluyo las clases de webservice asistencial
							
	include(FOLDER_RAIZ.'ws_asistencial.wsc.php');
						
	//->incluyo la coneccion
		$url_class = FOLDER_RAIZ.'classes/adodb/adodb.inc.php';
	  	if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
		ADOLoadCode(DB_TYPE);
		$conn = &ADONewConnection();
		$conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
  
	  //->incluyo la consulta
	  $url	=FOLDER_RAIZ.'classes/consulta.class.php';
	  ws_asistencial::incluir_archivo_ws($url);

		//$a_vec['datos']		='status, fecha_sincro,usuario_sincro';
		//$a_vec['tabla']		='pos_sincronizacion';
		//$a_vec['donde']		='fecha_sincro NOT LIKE '.date('Y-m-d');
		//AdminConsulta::ejec_consulta($a_vec,$ver_consulta='ver_consulta');


	  //->Sincronizamos pos_pacientes
		$total_registros_PA=ws_asistencial::sincronizarPacientes();
		//echo'1: '.$total_registros_PA;
		if($total_registros_PA>MAX_RegistrosSZ){
			echo 'Favor espere...<blink>1/3</blink><br>';echo "<META HTTP-EQUIV='refresh' CONTENT='1; URL=$PHP_SELF'>";  
		}else{
		  	//->Sincronizamos pos_productos
			$total_registros_PR=ws_asistencial::sincronizarProductos();
			//echo'2: '.$total_registros_PR;
			if($total_registros_PR>MAX_RegistrosSZ){
				echo 'Favor espere...<blink>2/3</blink><br';echo "<META HTTP-EQUIV='refresh' CONTENT='1; URL=$PHP_SELF'>";  
			}
			else{
				 //->Sincronizamos pos_convenios
				 	$total_registros_CO=ws_asistencial::sincronizarConvenios();
					//echo'3: '.$total_registros_CO;
					if($total_registros_CO>MAX_RegistrosSZ){
						echo 'Favor espere...<blink>3/3</blink><br';echo "<META HTTP-EQUIV='refresh' CONTENT='1; URL=$PHP_SELF'>";  
					}
					else{
						echo' Fin de sincronizacion <br>';
						$tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoFinal = $tiempo;
						$tiempoTotal = $tiempoFinal - $tiempoInicial;
						echo "La Sincronizacion tardó en generarse " . $tiempoTotal . " segundos.";
						
					}
				}
		}
	  
						
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))

if($auth=="Admin"){ 
	?>
	<p><img border="0" src="images/home_print.gif" width="33" height="29" valign="top">
    	<font color="#005B7F" size="4">
        	&nbsp;
            <b><?php echo $lang->home ?></b>
        </font>
    </p>
	<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->adminHomeWelcomeMessage"; ?> </font></p>
	<ul>
<!--
  <li><font face="Verdana" size="2"><a href="<?php //echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>" ><?php echo $lang->backupDatabase ?></a></font></li>
-->
  <li><font face="Verdana" size="2"><a href="sales/sale_ui.php"><?php echo $lang->processSale ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_sales.php"><?=$lang->manageSales?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_distri.php"><?=$lang->manageDispe?></a></font></li>
  <li><font face="Verdana" size="2"><a href="users/index.php"><?php echo $lang->addRemoveManageUsers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="customers/index.php"><?php echo $lang->addRemoveManageCustomers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="items/index.php"><?php echo $lang->addRemoveManageItems ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="reports/index.php"><?php echo $lang->viewReports ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="settings/index.php"><?php echo $lang->configureSettings ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com"><?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>

</ul>
<?php } elseif($auth=="Sales Clerk") { ?>

<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->salesClerkHomeWelcomeMessage"; ?> </font></p>
<ul>
<!--
  <li><font face="Verdana" size="2"><a href="<?php //echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>" ><?php echo $lang->backupDatabase ?></a></font></li>
-->
  <li><font face="Verdana" size="2"><a href="sales/sale_ui.php"><?php echo $lang->processSale ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_sales.php"><?=$lang->manageSales?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_distri.php"><?=$lang->manageDispe?></a></font></li>
  <li><font face="Verdana" size="2"><a href="users/index.php"><?php echo $lang->addRemoveManageUsers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="customers/index.php"><?php echo $lang->addRemoveManageCustomers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="items/index.php"><?php echo $lang->addRemoveManageItems ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="reports/index.php"><?php echo $lang->viewReports ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="settings/index.php"><?php echo $lang->configureSettings ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com"><?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>

</ul>

<?php
}
else
{
?>


<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->reportViewerHomeWelcomeMessage"; ?> </font></p>
<ul>
<!--
  <li><font face="Verdana" size="2"><a href="<?php //echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>" ><?php echo $lang->backupDatabase ?></a></font></li>
-->
  <li><font face="Verdana" size="2"><a href="sales/sale_ui.php"><?php echo $lang->processSale ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_sales.php"><?=$lang->manageSales?></a></font></li>
  <li><font face="Verdana" size="2"><a href="sales/manage_distri.php"><?=$lang->manageDispe?></a></font></li>
  <li><font face="Verdana" size="2"><a href="users/index.php"><?php echo $lang->addRemoveManageUsers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="customers/index.php"><?php echo $lang->addRemoveManageCustomers ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="items/index.php"><?php echo $lang->addRemoveManageItems ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="reports/index.php"><?php echo $lang->viewReports ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="settings/index.php"><?php echo $lang->configureSettings ?></a></font></li>
  <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com"><?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>

</ul>

<?php
}
$dbf->closeDBlink();

?>
