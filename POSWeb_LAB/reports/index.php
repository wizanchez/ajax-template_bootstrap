<?php 


session_start();
include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");


if(!$_REQUEST['jvm']){




define(URL_RAIZ_FONDO,'../');
include(URL_RAIZ_FONDO.'classes/TextDecoracion.php'); 
include(URL_RAIZ_FONDO.'classes/stylos_new.class.php'); 
	$ObjDeco=new TextDecoracion();		

        #----------------------------------------------------------------------------------------
        #  AHORA SE DEFINIRA LOS REPORTES
              define(DF_FUNCIONES_REPORTE,false);
        #----------------------------------------------------------------------------------------


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}
?>


<html>
<head>
</head>
<body>







<table border="0" width="600">
  <tr>
    <td><img border="0" src="../images/menubar/reports.png" width="55" height="55" valign='top'>
    <font color='#005B7F' size='4'>&nbsp;<b><?=$lang->reports?></b></font><br>
      <br>
      <font face="Verdana" size="2"><?=$lang->reportsWelcomeMessage?></font>
        <ul>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->allCustomersReport,'form.php?report='.$lang->allCustomersReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE==true)$ObjDeco->Cuadro_Links($lang->allPacientesReport,'form.php?report='.$lang->allPacientesReport);?>

        <?=$ObjDeco->Cuadro_Links(
                                    'Venta X Hora'
                                    ,'../?jvm=reporte/ini_reporte_venta_horaria.jvm'
                                    );?>

        <?=$ObjDeco->Cuadro_Links($lang->allItemsReport,'form.php?report='.$lang->allItemsReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->allDisItemsReport,'form.php?report='.$lang->allDisItemsReport);?>
   			<?=$ObjDeco->Cuadro_Links($lang->allEmployeesReport,'form.php?report='.$lang->allEmployeesReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->allDisEmployeesReport,'form.php?report='.$lang->allDisEmployeesReport);?>
        
<!--        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->allBrandsReport">$lang->allBrandsReport</a></font></li>
        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->allCategoriesReport">$lang->allCategoriesReport</a></font></li>
        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->allCustomersReport">$lang->allCustomersReport</a></font></li>
        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->allPacientesReport">$lang->allPacientesReport</a></font></li>
    <li><font face="Verdana" size="2"><a href="form.php?report=$lang->allItemsReport">$lang->allItemsReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->allDisItemsReport">$lang->allDisItemsReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->allItemsReportDateRange">$lang->allItemsReportDateRange</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->allEmployeesReport">$lang->allEmployeesReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->allDisEmployeesReport">$lang->allDisEmployeesReport</a></font></li>-->	
			<br />
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->employeeDisReport,'form.php?report='.$lang->brandReport);?>
   			<?=$ObjDeco->Cuadro_Links($lang->customerReport,'form.php?report='.$lang->customerReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->pacienteReport,'form.php?report='.$lang->pacienteReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->pacienteReport,'form.php?report='.$lang->customerReportDateRange);?>
   			<?=$ObjDeco->Cuadro_Links($lang->itemReport,'form.php?report='.$lang->itemDispReport);?>
   			<?=$ObjDeco->Cuadro_Links($lang->employeeReport,'form.php?report='.$lang->employeeReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->employeeDisReport,'form.php?report='.$lang->employeeDisReport);?>
      
<!--	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->brandReport">$lang->employeeDisReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->categoryReport">$lang->categoryReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->customerReport">$lang->customerReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->pacienteReport">$lang->pacienteReport</a></font></li>
        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->customerReportDateRange">$lang->customerReportDateRange</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->itemReport">$lang->itemReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->itemDispReport">$lang->itemDispReport</a></font></li>
        <li><font face="Verdana" size="2"><a href="form.php?report=$lang->itemReportDateRange">$lang->itemReportDateRange</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->employeeReport">$lang->employeeReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->employeeDisReport">$lang->employeeDisReport</a></font></li>
     </ul>
      <ul>--> 
      		<br />
   			<?=$ObjDeco->Cuadro_Links($lang->dailyReport,'daily.php');?>
        <?=$ObjDeco->Cuadro_Links('REPORTE DIARIO DE VENTAS POR OPERADOR','daily_operador.php');?>
        <?=$ObjDeco->Cuadro_Links('REPORTE PRODUCTOS POR HORA','productos_hora.php');?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->dailyDipReport,'dailyDipReport.php');?>
   			<?=$ObjDeco->Cuadro_Links($lang->dateRangeReport,'form.php?report='.$lang->dateRangeReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->dateRangeDisReport,'form.php?report='.$lang->dateRangeDisReport);?>
   			<?=$ObjDeco->Cuadro_Links($lang->profitReport,'form.php?report='.$lang->profitReport);?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->profitReportDispen,'form.php?report='.$lang->profitReportDispen);?>
   			<?=$ObjDeco->Cuadro_Links($lang->closedailyreport,'endday.php');?>
   			<?PHp if(DF_FUNCIONES_REPORTE===true)$ObjDeco->Cuadro_Links($lang->closedailyDispreport,'enddayDisp.php');?>
   			<?=$ObjDeco->Cuadro_Links($lang->vtas_consolid,'vta_consolidadas.php');?>
   			<?=$ObjDeco->Cuadro_Links($lang->Disp_consolid,'Disp_consolidadas.php');?>
      
<!--	<li><font face="Verdana" size="2"><a href="daily.php">$lang->dailyReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="dailyDipReport.php">$lang->dailyDipReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->dateRangeReport">$lang->dateRangeReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->dateRangeDisReport">$lang->dateRangeDisReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->profitReport">$lang->profitReport</a></font></li>
    <li><font face="Verdana" size="2"><a href="form.php?report=$lang->profitReportDispen">$lang->profitReportDispen</a></font></li>
	<li><font face="Verdana" size="2"><a href="form.php?report=$lang->taxReport">$lang->taxReport</a></font></li>
	<li><font face="Verdana" size="2"><a href="endday.php">$lang->closedailyreport</a></font></li>
	<li><font face="Verdana" size="2"><a href="enddayDisp.php">$lang->closedailyDispreport</a></font></li>
	<li><font face="Verdana" size="2"><a href="vta_consolidadas.php">$lang->vtas_consolid</a></font></li>
	<li><font face="Verdana" size="2"><a href="Disp_consolidadas.php">$lang->Disp_consolid</a></font></li>
-->	

      </ul>

    </td>
  </tr>
</table>
</body>
</html>
<?PHp
  
  }#EL ACTION MAYOR

$dbf->closeDBlink();


?>
