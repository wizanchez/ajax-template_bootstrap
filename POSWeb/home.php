<?php 
session_start();

        #----------------------------------------------------------------------------------------
        #  DEFINE PARA EXCLUIR OPCIONES
              define(DF_OPCION_ADMINISTRAR_DISPENSACION, none);
              
        #----------------------------------------------------------------------------------------


include ("settings.php");
include("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

define(URL_RAIZ_FONDO,'');
include(URL_RAIZ_FONDO.'classes/TextDecoracion.php'); 
include(URL_RAIZ_FONDO.'classes/stylos_new.class.php'); 
	$ObjDeco=new TextDecoracion();		


$lang=new language();
$dbf=new db_functions(
                        $cfg_server
                        ,$cfg_username
                        ,$cfg_password
                        ,$cfg_database
                        ,$cfg_tableprefix
                        ,$cfg_theme
                        ,$lang
                      );

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
<body   class="fondo">
<?php

      //#############################################################################################################
			//					empezamos el web service
			//#############################################################################################################
/*							define(FOLDER_RAIZ,'');//CARPETA PARA LOS WEBSIERVECI
							define(MAX_RegistrosSZ,'500');
							$tiempo = microtime();
							$tiempo = explode(" ", $tiempo);
							$tiempo = $tiempo[1] + $tiempo[0];
							$tiempoInicial = $tiempo;

							//incluyo las clases de webservice asistencial
							
						include(FOLDER_RAIZ.'ws_asistencial.wsc.php');
							
							//incluyo la coneccion
							  $url_class = FOLDER_RAIZ.'classes/adodb/adodb.inc.php';
							if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
								  ADOLoadCode(DB_TYPE);
								  $conn = &ADONewConnection();
								  $conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
						
							//incluyo la consulta
							$url	=FOLDER_RAIZ.'classes/consulta.class.php';
      						ws_asistencial::incluir_archivo_ws($url);
							
							//############################################
							//sincronizamos pos_pacientes
							//	ws_asistencial::sincronizarPacientes();
							//############################################
							//sincronizamos pos_convenios
							//	ws_asistencial::sincronizarConvenios();
							//############################################
							//sincronizamos pos_productos
							$total_registros=ws_asistencial::sincronizarProductos();


					if($total_registros>MAX_RegistrosSZ){
						echo '<blink> Favor espere...</blink>';echo "<META HTTP-EQUIV='refresh' CONTENT='1; URL=$PHP_SELF'>";  
						}else{
							echo' Fin de sincronizacion productos <br>';
							$tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoFinal = $tiempo;
							$tiempoTotal = $tiempoFinal - $tiempoInicial;
							echo "La Sincronizacion tardó en generarse " . $tiempoTotal . " segundos.";
						}
*/											
			//#############################################################################################################
			//#############################################################################################################

			
if($auth=="Admin"){ 
	?>

    <p>
    <img border="0" src="images/menubar/home.png" width="55" height="55" valign="top"><font color="#005B7F" size="4">&nbsp;<b><?php echo $lang->home ?></b></font></p>
  <font face="Verdana" size="2"><font color="#005B7F" size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Sucursal <?php echo LOCATION_NOMBRE;?></b></font><br><br><?php echo "$lang->welcomeTo $cfg_company $lang->adminHomeWelcomeMessage"; ?> </font></p>
    <ul>
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?=$ObjDeco->Cuadro_Links('Venta X Hora','./?jvm=reporte/ini_reporte_venta_horaria.jvm');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->processSale,'sales/sale_ui.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->manageSales,'sales/manage_sales.php');?></td>
      </tr>
      <tr style="display:<?PHp echo DF_OPCION_ADMINISTRAR_DISPENSACION;?>" >
        <td><?=$ObjDeco->Cuadro_Links($lang->manageDispe,'sales/manage_distri.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->manageEvento,'sales/manage_evento.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageUsers,'users/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageCustomers,'customers/index.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->viewReports,'reports/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->copyRango,'reports/form.php?report='.$lang->copyRango);?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->configureSettings,'settings/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->viewOnlineSupport,'http://www.jvmcompany.com');?></td>
      </tr>
    </table>

    
<!--    <li><font face="Verdana" size="2"><a href="sales/sale_ui.php">< ?php echo $lang->processSale ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_sales.php">< ?=$lang->manageSales?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_distri.php">< ?=$lang->manageDispe?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_evento.php">< ?=$lang->manageEvento?></a></font></li>
    <li><font face="Verdana" size="2"><a href="users/index.php">< ?php echo $lang->addRemoveManageUsers ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="customers/index.php">< ?php echo $lang->addRemoveManageCustomers ?></a></font></li>
    <!--<li><font face="Verdana" size="2"><a href="items/index.php">< ?php echo $lang->addRemoveManageItems ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="reports/index.php">< ?php echo $lang->viewReports ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="reports/form.php?report=< ?=$lang->copyRango?>">< ?php echo $lang->copyRango ?></a></font></li>  
    <li><font face="Verdana" size="2"><a href="settings/index.php">< ?php echo $lang->configureSettings ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com">< ?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>-->
	</ul>
    
     
    
    
	<?php 
} elseif($auth=="Sales Clerk") {
	?>
	<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->salesClerkHomeWelcomeMessage"; ?> </font></p><ul>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td><?=$ObjDeco->Cuadro_Links('Venta X Hora','./?jvm=reporte/ini_reporte_venta_horaria.jvm');?></td>
      </tr>
    
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->processSale,'sales/sale_ui.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->manageSales,'sales/manage_sales.php');?></td>
      </tr>

      <tr style="display:<?PHp echo DF_OPCION_ADMINISTRAR_DISPENSACION;?>">
        <td><?=$ObjDeco->Cuadro_Links($lang->manageDispe,'sales/manage_distri.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->manageEvento,'sales/manage_evento.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageUsers,'users/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageCustomers,'customers/index.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->viewReports,'reports/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->configureSettings,'settings/index.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->viewOnlineSupport,'http://www.jvmcompany.com');?></td>
        <td>&nbsp;</td>
      </tr>
    </table>

    
	<!--<li><font face="Verdana" size="2"><a href="< ?php //echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>" >< ?php echo $lang->backupDatabase ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/sale_ui.php">< ?php echo $lang->processSale ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_sales.php">< ?=$lang->manageSales?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_distri.php">< ?=$lang->manageDispe?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_evento.php">< ?=$lang->manageEvento?></a></font></li>
    <li><font face="Verdana" size="2"><a href="users/index.php">< ? php echo $lang->addRemoveManageUsers ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="customers/index.php">< ?php echo $lang->addRemoveManageCustomers ?></a></font></li>
    <!--<li><font face="Verdana" size="2"><a href="items/index.php">< ?php echo $lang->addRemoveManageItems ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="reports/index.php"> < ?php echo $lang->viewReports ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="settings/index.php">< ?php echo $lang->configureSettings ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com">< ?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>-->
	</ul>
	<?php
	}
else{
	?>
	<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->reportViewerHomeWelcomeMessage"; ?> </font></p>
	<ul>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td><?=$ObjDeco->Cuadro_Links('Venta X Hora','./?jvm=reporte/ini_reporte_venta_horaria.jvm');?></td>
      </tr>
    
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->processSale,'sales/sale_ui.php');?></td>
        <td> <?=$ObjDeco->Cuadro_Links($lang->manageSales,'sales/manage_sales.php');?></td>
      </tr>
      <tr style="display:<?PHp echo DF_OPCION_ADMINISTRAR_DISPENSACION;?>">
        <td><?=$ObjDeco->Cuadro_Links($lang->manageDispe,'sales/manage_distri.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->manageEvento,'sales/manage_evento.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageUsers,'users/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->addRemoveManageCustomers,'customers/index.php');?></td>
      </tr>
      <tr>
        <td> <?=$ObjDeco->Cuadro_Links($lang->viewReports,'reports/index.php');?></td>
        <td><?=$ObjDeco->Cuadro_Links($lang->configureSettings,'settings/index.php');?></td>
      </tr>
      <tr>
        <td><?=$ObjDeco->Cuadro_Links($lang->viewOnlineSupport,'http://www.jvmcompany.com');?></td>
        <td>&nbsp;</td>
      </tr>
    </table>

   
  
   
   
   
   
  
   
   
    
	<!--<li><font face="Verdana" size="2"><a href="< ?php //echo "backupDB.php?onlyDB=$cfg_database&StartBackup=complete&nohtml=1"?>" >< ?php echo $lang->backupDatabase ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/sale_ui.php">< ?php echo $lang->processSale ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_sales.php">< ?=$lang->manageSales?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_distri.php">< ?=$lang->manageDispe?></a></font></li>
    <li><font face="Verdana" size="2"><a href="sales/manage_evento.php">< ?=$lang->manageEvento?></a></font></li>
    <li><font face="Verdana" size="2"><a href="users/index.php">< ?php echo $lang->addRemoveManageUsers ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="customers/index.php">< ?php echo $lang->addRemoveManageCustomers ?></a></font></li>
    <!--<li><font face="Verdana" size="2"><a href="items/index.php">< ?php echo $lang->addRemoveManageItems ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="reports/index.php">< ?php echo $lang->viewReports ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="settings/index.php">< ?php echo $lang->configureSettings ?></a></font></li>
    <li><font face="Verdana" size="2"><a href="http://www.jvmcompany.com">< ?php echo $lang->viewOnlineSupport ?></a><br>&nbsp;</font></li>-->
	</ul>
	<?php
}
$dbf->closeDBlink();
?>
