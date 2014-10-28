<?php
session_start();
	
				#----------------------------------------------------------------------------------------
				#	DEFINE PARA LOS SEGUNDO EN LA SINCRONIZACION ONLINE
							define(DF_SEGUNDO_ONLINE,30);
				#----------------------------------------------------------------------------------------

include ("settings.php");
include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");
			

				#----------------------------------------------------------------------------------------
				#	DEFINE PARA LOS MENUS
							define(DF_SUBIR_PASCIENTE, false);
				#----------------------------------------------------------------------------------------


			define(FOLDER_RAIZ,'');
		#################################################################################################
		##	CARGO EL FRAMEWORK
        	require_once	FOLDER_RAIZ.'framework_jvm/Fjvm_cargar.frj.php';
		#################################################################################################

						#######################################################################################################
						##	INCLUIMOS LAS LIBRERIAS DEL FRAMEWORK	
								$a_vec_libreria		=array(
															'formulario',
															'seguridad',
															'consulta',
															'mensaje',
															'jquery'
															);
															
								Fjvm_cargar::fjvm_importar_libreria($a_vec_libreria);

//create 3 objects that are needed in this script.
$lang 		= new language();
$dbf 		= new db_functions(
								$cfg_server
								, $cfg_username
								, $cfg_password
								, $cfg_database
								,$cfg_tableprefix
								, $cfg_theme
								, $lang
							);
$sec 			= new security_functions($dbf, 'Public', $lang);

$tablename 		= $cfg_tableprefix . 'users';
$auth 			= $dbf->idToField($tablename, 'type', $_SESSION['session_user_id']);
$userLoginName 	= $dbf->idToField($tablename, 'username', $_SESSION['session_user_id']);

$dbf->closeDBlink();

// Display HTML--

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $cfg_company?>--<?php echo $lang->poweredBy?> POS Web - JVM Company S.A. <?PHP echo date('Y');?> </title>
	<link rel="stylesheet" rev="stylesheet" href="css/phppos.css" />

    <script src="jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<?php
						#######################################################################################################
						#######################################################################################################
						##	COLOCAMOS LAS LIBRERIAS PARA ORDENAMIENTO DE TABLAS
								Fjvm_formulario::tooltips_main();
						#######################################################################################################


?>	<script src="js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="js/swfobject.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script>

var div_id_old;

function js_sostener_pest(div)
{

	var div_of  =div_id_old;


	jQuery('.cl_menu').removeClass('menu_item_active');
	jQuery('.cl_menu').addClass('menu_item');


	jQuery('#'+div).removeClass('menu_item');

	jQuery('#'+div).addClass('menu_item_active');
	

	


	var div_id_old=div;



}

function decision(message, url)
{
	if(confirm(message) )
  {
    parent.location.href = url;
  }
}
</script>
 
<style type="text/css">
html {
    overflow: auto;
}
</style> 

<style type="text/css"> 
 <!-- 
 a.nav:link
 {
 	font-weight:bold;
	 font-size:7pt;
	 font-family:Verdana;
	 color:white;
	

 }
 
 a.nav:visited
 {
 	font-weight:bold;
	 font-size:7pt;
	 font-family:Verdana;
	 color:white;
 }
 
 a.nav:active
 {
 	font-weight:bold;
	 font-size:7pt;
	 font-family:Verdana;
	 color:white;
 }

 a.nav:hover
 {
	 font-size:7pt;
	 font-family:Verdana;
	 color:#CCCCCC;
	

 }

 //--> 
 </style>

<?PHp

							Fjvm_cargar::bundler_ext([
														
														'bootstrap'
														,'jquery'
													]);

?>

<TITLE><?php echo $cfg_company?>--<?php echo $lang->poweredBy?> POS Web - JVM Company S.A. <?php echo date('Y');?></TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</HEAD>
<BODY   >

<? 

#include('menubar_new.php');
#exit;
?>






<div id="menubar">
	<div id="menubar_container">
		<div id="menubar_company_info">
		<span id="company_title"><?php //echo $cfg_company;?><img src="imagenes/logo/logo_cliente.png" alt=""></span><br />
	</div>
    
		<div id="menubar_navigation">
			<div class="cl_menu menu_item" onClick="window.open('home.php','MainFrame'); js_sostener_pest('d_home')" title="<?php echo $lang->home;?>" id="d_home" >
				<img src="<?php echo 'images/menubar/home.png';?>" border="0" width="25" height="25"/><br />
			</div>
            <?php
			Fjvm_formulario::tooltips('d_home', 'derecho');
if ($auth == "Admin"){?>
			<div class="cl_menu menu_item" onClick="window.open('customers/index.php','MainFrame'); js_sostener_pest('d_customer');" title="<?php echo $lang->customers;?>"  id="d_customer" >
				<img src="<?php echo 'images/menubar/customers.png';?>" border="0"width="25" height="25" /><br />
			</div>
<?php
			Fjvm_formulario::tooltips('d_customer', 'derecho');
}
if ($auth == "Admin")
{
?>           
			<div class="cl_menu menu_item" onClick="window.open('items/index.php','MainFrame'); js_sostener_pest('d_items');" title="<?php echo $lang->items;?>"  id="d_items" >
				<img src="<?php echo 'images/menubar/items.png'; ?>" border="0" width="25" height="25" /><br />
			</div>         
<?php
				Fjvm_formulario::tooltips('d_items', 'derecho');
}
if ($auth == "Admin" || $auth == "Report Viewer")
{
?>            
			<div class="cl_menu menu_item" onClick="window.open('index.php?jvm=reporte/ini_panel_reporte.jvm','MainFrame'); js_sostener_pest('d_reports');"title="<?php echo $lang->reports;?>"  id="d_reports" >
				<img src="<?php echo 'images/menubar/reports.png';?>" border="0" width="25" height="25" /><br />
			</div>  
<?php
				Fjvm_formulario::tooltips('d_reports', 'derecho');
}
if ($auth == "Admin" || $auth == "Sales Clerk")
{
?>            
			<div class="cl_menu menu_item" onClick="window.open('sales/sale_ui.php','MainFrame'); js_sostener_pest('d_sales');" title="<?php echo $lang->sales;?>" id="d_sales">
				<img src="<?php echo 'images/menubar/sales.png'; ?>" border="0"  width="25" height="25"  /><br />
			</div>   
<?php
			Fjvm_formulario::tooltips('d_sales', 'derecho');
}
if ($auth == "Admin")
{
?>    
			<div class="cl_menu menu_item" onClick="window.open('settings/index.php','MainFrame'); js_sostener_pest('d_config');"title="<?php echo 'configuracion'; ?>"  id="d_config" >
				<img src="<?php echo 'images/menubar/config.png';?>" border="0" width="25" height="25" /><br />
			</div>   
                                                  <!-- ws_sincronizar_all.wsc.php?ws_sinronizar_all=menu -->
			<div class="cl_menu menu_item" onClick="window.open('index.php?jvm=sincronizar/ini_panel_sincronizar.jvm','MainFrame'); js_sostener_pest('d_sincro');" title="Sincronizar" id="d_sincro">
			<img src="<?php echo 'images/menubar/sincro.png'; ?>" border="0"  width="25" height="25" /><br />
			</div>                                         

                        <!-- #-> Yaruro 
http://192.168.1.135/POSWeb/POSWeb_LAB/?jvm=sincronizar/ini_panel_sincronizar.jvm
                        -->
  <?PHp if(DF_SUBIR_PASCIENTE===true){?>                      
        <div class="cl_menu menu_item" onClick="window.open('formulario.php','MainFrame'); js_sostener_pest('d_upload');" title="SubirPacientes"  id="d_upload" >
			<img src="<?php echo 'images/subirdatos.png'; ?>" border="0"width="25" height="25"/><br />
		</div> 
                       
<?php 
	}#if(DF_SUBIR_PASCIENTE===true){

			Fjvm_formulario::tooltips('d_config', 'derecho');
			Fjvm_formulario::tooltips('d_sincro', 'derecho');
                        Fjvm_formulario::tooltips('d_upload', 'derecho');
}   
?>

			<div class="cl_menu menu_item" title="<?php echo $lang->logout;?>" id="d_exit"  >
				<a href="javascript:decision('<?php    echo $lang->logoutConfirm?>','logout.php')" >
                <img src="<?php echo 'images/menubar/exit.png';?>" border="0"width="25" height="25" /></a><br />
			</div> 
        </div>
        
		<div id="menubar_footer" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px">
		<?php	Fjvm_formulario::tooltips('d_exit', 'derecho');?><span style="color:#FC0;"><?php echo LOCATION_NOMBRE?></span> - <?php echo $lang->welcome . " $userLoginName! ";?>
		</div>

		<div id="menubar_date" style="font-family:Tahoma, Geneva, sans-serif; font-size:10px">
		<?php echo date('F d, Y h:i a')?>
		</div>        
    </div> 
</div> <!--
              
<TABLE WIDTH=750 BORDER=0 CELLPADDING=0 CELLSPACING=0 style="border-collapse: collapse" bordercolor="#111111">
	<TR>
		<TD width="434" background="images/menubar_01.gif" height="78">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber1">
                <tr>
                  <td width="100%"><b>
                  <font face="Verdana" color="#FFFFFF" size="4">< ?php    echo $cfg_company?></font></b></td>
                </tr>
                <tr>
                  <td width="100%">
                  <font face="Verdana" size="1" color="#FFFFFF">< ?php    echo $lang->poweredBy?> 
                  POS Web - JVM Company S.A.</font></td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
		<?php
    if ($auth == " Adm in")
    {
?>
		<TD background="images/menubar_02.gif" WIDTH="62" HEIGHT="78" style="cursor: hand;" onClick="window.open('home.php','MainFrame')">
		
		<center><br><br>&nbsp;&nbsp;&nbsp;&nbsp;<a href="home.php" target="MainFrame" class="nav">< ?php echo $lang->home?></a></center>
		
		</TD>
		<TD background="images/menubar_03.gif" WIDTH="65" HEIGHT="78" style="cursor: hand;" onClick="window.open('customers/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="customers/index.php" target="MainFrame" class="nav">< ?php echo $lang->customers?></a></center>

		</TD>
		<TD background="images/menubar_04.gif" WIDTH="48" HEIGHT="78" style="cursor: hand;" onClick="window.open('items/index.php','MainFrame')">
			
		<center><br><br>&nbsp;<a href="items/index.php" target="MainFrame" class="nav">< ?php echo $lang->items ?></a></center>

		</TD>
		<TD background="images/menubar_05.gif" WIDTH="52" HEIGHT="78" style="cursor: hand;" onClick="window.open('reports/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="reports/index.php" target="MainFrame" class="nav">< ?php echo $lang->reports?></a></center>

		</TD>
		<TD background="images/menubar_06.gif" WIDTH="42" HEIGHT="78" style="cursor: hand;" onClick="window.open('sales/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="sales/index.php" target="MainFrame" class="nav">< ?php  echo $lang->sales?></a></center>

		</TD>
		<TD background="images/menubar_06.gif" WIDTH="42" HEIGHT="78" style="cursor: hand;" onClick="window.open('sales/sale_ui.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="sales/sale_ui.php" target="MainFrame" class="nav">< ?php echo $lang->salesNow?></a></center>

		</TD>
		<TD background="images/menubar_07.gif" WIDTH="47" HEIGHT="78" style="cursor: hand;" onClick="window.open('settings/index.php','MainFrame')">
	
		<center><br><br>&nbsp;<a href="settings/index.php" target="MainFrame" class="nav">< ?php  echo $lang->config?></a></center>

		</TD>
		
		
	</TR>
	<?php
    }
    if ($auth == "Sales Clerk")
    {
?>
		
		<TD background="images/menubar_sales_01.gif" WIDTH="62" HEIGHT="78">
			
		
		</TD>
		
		<TD background="images/menubar_sales_02.gif" WIDTH="65" HEIGHT="78">
			
		
		</TD>
	
	
		<TD background="images/menubar_03.gif" WIDTH="65" HEIGHT="78" style="cursor: hand;" onClick="window.open('customers/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="customers/index.php" target="MainFrame" class="nav">< ?php        echo $lang->customers?></a></center>

		</TD>
	    <TD background="images/menubar_05.gif" WIDTH="52" HEIGHT="78" style="cursor: hand;" onClick="window.open('reports/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="reports/endday.php" target="MainFrame" class="nav">< ?php        echo $lang->reports?></a></center>

		</TD>
		
		<TD background="images/menubar_sales_04.gif" WIDTH="52" HEIGHT="78">
			
		
		</TD>
		
		<TD background="images/menubar_sales_05.gif" WIDTH="42" HEIGHT="78" style="cursor: hand;" onClick="window.open('home.php','MainFrame')">
			
		<center><br><br>&nbsp;<a href="home.php" target="MainFrame" class="nav">< ?php       echo $lang->home?></a></center>

		</TD>
		
		<TD background="images/menubar_sales_06.gif" WIDTH="47" HEIGHT="78" style="cursor: hand;" onClick="window.open('sales/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="sales/index.php" target="MainFrame" class="nav">< ?php        echo $lang->sales?></a></center>

		</TD>
		
	<?php
    }
    if ($auth == "Report Viewer")
    {
?>
		
		<TD background="images/menubar_reports_01.gif" WIDTH="62" HEIGHT="78">
			
		
		</TD>
		
		<TD background="images/menubar_reports_02.gif" WIDTH="65" HEIGHT="78">
			
		
		</TD>
	
	
		<TD background="images/menubar_reports_03.gif" WIDTH="48" HEIGHT="78">
			
		
		</TD>
	
		
		<TD background="images/menubar_reports_04.gif" WIDTH="52" HEIGHT="78">
			
		
		</TD>
		
		<TD background="images/menubar_reports_05.gif" WIDTH="42" HEIGHT="78" style="cursor: hand;" onClick="window.open('home.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="home.php" target="MainFrame" class="nav">< ?php       echo $lang->home?></a></center>

		
		</TD>
		
		<TD background="images/menubar_reports_06.gif" WIDTH="47" HEIGHT="78" style="cursor: hand;" onClick="window.open('reports/index.php','MainFrame')">
		
		<center><br><br>&nbsp;<a href="reports/index.php" target="MainFrame" class="nav">< ?php       echo $lang->reports?></a></center>

		
		</TD>
	</TR>
	<?php
    }
?>
	<TR>
		<TD COLSPAN=4 width="609" bgcolor="#0A6184" height="22">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="97%" id="AutoNumber2">
                  <tr>
                  <td width="100%"><b>
                  <font face="Verdana" size="1" color="#FFFFFF">
				  < ?php   echo $lang->welcome?>
				  < ?php    echo $userLoginName;?>!
				  | <a href="javascript:decision('< ?php    echo $lang->logoutConfirm?>','logout.php')"><font color="#FFFFFF">
                  < ?php    echo $lang->logout?></font></a></font></b>		    </td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
		<TD COLSPAN=3 width="141" bgcolor="#0A6184" height="22">
			<div align="center">
              <center>
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%" id="AutoNumber3">
                <tr>
                  <td width="100%">
                  <p align="right"><b>
                  <font face="Verdana" size="1" color="#FFFFFF">< ?php    echo date("F j, Y");?></font></b></td>
                </tr>
              </table>
              </center>
            </div>
        </TD>
	</TR>
	</TABLE>
-->
<div class="bandera_roja" id="div_conec">
	
</div>
<script>
	
setInterval(function(){check_ajax()}, <?PHp echo (DF_SEGUNDO_ONLINE*1000)?>);

var bandera_ini='bandera_roja';

function check_ajax()
	{


			    jQuery.ajax({
								url 	: './?online',
								type 	: 'POST',
								cache 	: false,
								dataType: 'json',
								error:function(objeto, quepaso, otroobj){
												
												js_cambio_bandera('bandera_roja');

								},
								data: {
									jvm 				:'verify'
									,bodega_id 			:'<?PHp echo base64_encode(LOCATION_ID)?>'
									,jvm 				:'sincronizar/send_online.jvm'
									,sold_by 			:'<?PHp echo base64_encode($_SESSION['session_user_id']);?>'
								},
			                    success: function(data) {
										

										js_cambio_bandera('bandera_verde');
									
									}
							});

	}

function js_cambio_bandera(div_new)
	{


		//alert(bandera_roja);

	if(bandera_ini!=div_new){

		jQuery('#div_conec').removeClass(bandera_ini);
		jQuery('#div_conec').addClass(div_new);

		bandera_ini=div_new;

	}



	}

</script>
<style type="text/css" media="screen">

.bandera_roja{

background-color:red; 
	height:30px;
	width:50px;
	position:fixed;
	right:0px;
	top:3px;

background: #330019; /* Old browsers */
background: -moz-linear-gradient(left,  #330019 5%, #8f0222 23%, #ff0509 43%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(5%,#330019), color-stop(23%,#8f0222), color-stop(43%,#ff0509)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  #330019 5%,#8f0222 23%,#ff0509 43%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  #330019 5%,#8f0222 23%,#ff0509 43%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  #330019 5%,#8f0222 23%,#ff0509 43%); /* IE10+ */
background: linear-gradient(to right,  #330019 5%,#8f0222 23%,#ff0509 43%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#330019', endColorstr='#ff0509',GradientType=1 ); /* IE6-9 */

border :1px #330019 solid;

-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;
 border-top-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
border-bottom-left-radius: 10px;

-webkit-box-shadow: -15px 0px 10px 0px rgba(255, 255, 255, 0.75);
-moz-box-shadow:    -15px 0px 10px 0px rgba(255, 255, 255, 0.75);
box-shadow:         -15px 0px 10px 0px rgba(255, 255, 255, 0.75);

}

.bandera_verde{

background-color:red; 
	height:30px;
	width:50px;
	position:fixed;
	right:0px;
	top:3px;

background: #b7e58b; /* Old browsers */
background: -moz-linear-gradient(left,  #b7e58b 0%, #d2ff52 50%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,#b7e58b), color-stop(50%,#d2ff52)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  #b7e58b 0%,#d2ff52 50%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  #b7e58b 0%,#d2ff52 50%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  #b7e58b 0%,#d2ff52 50%); /* IE10+ */
background: linear-gradient(to right,  #b7e58b 0%,#d2ff52 50%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b7e58b', endColorstr='#d2ff52',GradientType=1 ); /* IE6-9 */

border :1px #b7e58b solid;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;
 border-top-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
border-bottom-left-radius: 10px;

-webkit-box-shadow: -15px 0px 10px 0px rgba(255, 255, 255, 0.75);
-moz-box-shadow:    -15px 0px 10px 0px rgba(255, 255, 255, 0.75);
box-shadow:         -15px 0px 10px 0px rgba(255, 255, 255, 0.75);

}

	
</style>

</BODY>
</HTML>


