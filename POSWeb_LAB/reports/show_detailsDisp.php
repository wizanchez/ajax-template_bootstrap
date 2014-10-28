<?php session_start(); ?>
<html>
<head>
</head>

<body>
<?php

include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);
if(!$sec->isLoggedIn())
{
    header ("location: ../login.php");
    exit();
}

if(isset($_GET['sale_id']))
{
	$sale_id=$_GET['sale_id'];
	$customer_id=$_GET['sale_customer_id'];
	$sale_date=$_GET['sale_date'];
	
	$temp_first_name=$dbf->idToField("$cfg_tableprefix".'pacientes','first_name',$customer_id);
	$temp_last_name=$dbf->idToField("$cfg_tableprefix".'pacientes','last_name',$customer_id);
	$sale_customer_name=$lang->orderBy.' : '.$temp_first_name.' '.$temp_last_name;
	$temp_invoicenumber=$dbf->idToField("$cfg_tableprefix".'sales','invoicenumber',$sale_id);
}	
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$display->displayTitle("$lang->DisDetails");
$tableheaders=array("$lang->itemName","$lang->category","$lang->supplier","$lang->quantityFormula","$lang->quantityDispensa","$lang->unitPrice","$lang->costoArticulo");
$tablefields=array('item_id','category_id','supplier_id','qtyrecetada','quantity_purchased','item_unit_price','item_buy_price');
$display->displayReportTableDispe("$cfg_tableprefix",'sales_items',$tableheaders,$tablefields,'sale_id',"$sale_id",'','','id',"$sale_customer_name<br>$lang->date: $sale_date<br>$lang->invoicenumber: $temp_invoicenumber<br><br>$lang->itemsDispe<br>");

?>



</body>
</html> 