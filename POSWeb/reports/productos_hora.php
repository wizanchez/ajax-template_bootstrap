<?php session_start(); ?>
<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=600,height=300,left = 362,top = 234');");
}

</script>
</head>

<body>
<?php

include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
$submit=$_REQUEST['submit'];
if($submit==1){
	$lang= new language();
	$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
	$sec=new security_functions($dbf,'Report Viewer',$lang);
	if(!$sec->isLoggedIn())
	{
		header ("location: ../login.php");
		exit();
	}
	
	$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
	$display->displayTitle("REPORTE DIARIO DE VENTAS POR OPERADOR");
	$today=date("F j, Y");
	$todaysDate=date("Y-m-d");
	$tableheaders=array('Fecha','Producto','6 - 10 am','10 - 12 pm','12 - 4 pm','4 - 9 pm');
	$tablefields=array('date','sold_by','sale_total_cost');
	$todaysDate=$_REQUEST['datepicker'];
	$display->displayProductosHora("$cfg_tableprefix",'sales',$tableheaders,$tablefields,'date',"$todaysDate",'','','invoicenumber',"Ventas Productos Horas");
}else{
	?>
	<link rel="stylesheet" href="../js/jquery/modal/jquery-ui.css">
    <script src="../jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="../jquery_ui/js/jquery-ui-1.8.7.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../jquery_ui/css/ui-lightness/jquery-ui-1.8.7.custom.css" media="all" />
	 <script>
    $(function() {
		$.datepicker.setDefaults({ dateFormat: "yy-mm-dd"});
		$( "#datepicker" ).datepicker();
    });
    </script>
    <form action="productos_hora.php">
    <input type="hidden" value="1" id="submit" name="submit">
    <br>
	<table align="center" id="myTable" class="ui-widget">
    	<tr class="ui-widget-header">
        	<td align="center">Fecha:</td>
            <td align="center"><input type="text" id="datepicker" name="datepicker"></td>
        </tr>
        <tr>
        	<td align="center"  colspan="2"><br></td>
        </tr>
        <tr>
        	<td align="center"  colspan="2"><input type="submit" value="Generar" /></td>
        </tr>
        <tr>
        	<td align="center"  colspan="2"><br></td>
        </tr>
    </table>
    </form>
	<?php
}
?>
</body>
</html> 