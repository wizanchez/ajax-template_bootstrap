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

$lang= new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);
if(!$sec->isLoggedIn())
{
    header ("location: ../login.php");
    exit();
}

$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$cfg_company $lang->dailyReport");
$today=date("F j, Y");
$todaysDate=date("Y-m-d");
$tableheaders=array("$lang->invoicenumber","$lang->date","$lang->customer","$lang->itemsPurchased","$lang->paidWith","$lang->soldBy","$lang->saleSubTotal","$lang->saleTotalCost","$lang->saleDetails");
$tablefields=array('invoicenumber','date','customer_id','items_purchased','sales_paywith','sold_by','sale_sub_total','sale_total_cost','sale_details');
$display->displayReportTable("$cfg_tableprefix",'sales',$tableheaders,$tablefields,'date',"$todaysDate",'','','invoicenumber',"$lang->listOfSalesFor $today");

?>
</body>
</html> 