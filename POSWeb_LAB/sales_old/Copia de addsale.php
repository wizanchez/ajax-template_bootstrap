<?php session_start(); ?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../../erp/css/print.css" media="print">
</head>
<?
/* $numberit=count($_SESSION['items_in_sale']);
for($g=0;$g<$numberit;$g++)
{ 
	echo $item_info_1=explode(' ',$_SESSION['items_in_sale'][$g]); echo '<br>';
	$rc_cronic=mysql_query('select id, cronico, item_name from pos_items where item_number = '.$item_info_1[0].'',$conn_2);
	$rowcronic=mysql_fetch_assoc($rc_cronic);
	echo $rowcronic["item_name"].'  victor '.$rowcronic["cronico"]; echo '<br>';
}
$kk = 0;
if($kk == 2)
$func = 'pedircust()';
else $func = '';*/
?>
<body>
<?php

include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");
include ("../classes/display.php");
include ("../Connections/conexion.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);
$tablename = $cfg_tableprefix.'users';
$userLoginName= $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$userLoginLastName = $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);
$NameUser = $userLoginName.' '.$userLoginLastName;
if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

$table_bg=$display->sale_bg;
 $num_items=count($_SESSION['items_in_sale']); 
 $num_pay=count($_SESSION['sales_paywith']); 


if($num_items==0)
{
	echo "<b>$lang->youMustSelectAtLeastOneItem</b><br>";
	echo "<a href=javascript:history.go(-1)>$lang->refreshAndTryAgain</a>";
	exit();
}
$customers_table=$cfg_tableprefix.'customers';
$items_table=$cfg_tableprefix.'items';
$sales_items_table=$cfg_tableprefix.'sales_items';
$sales_table=$cfg_tableprefix.'sales';
$paywith_table=$cfg_tableprefix.'sales_paywith';

//general sale info
$paid_with=isset($_POST['paid_with'])?$_POST['paid_with']:'';
$comment=isset($_POST['comment'])?$_POST['comment']:'';
$customer_name=$dbf->idToField($customers_table,'first_name',$_SESSION['current_sale_customer_id']).' '.$dbf->idToField($customers_table,'last_name',$_SESSION['current_sale_customer_id']);
$customer_codigo=$dbf->idToField($customers_table,'account_number',$_SESSION['current_sale_customer_id']);

//totals
$finalTax=$_POST['totalTax'];
$sale_total_cost=$_POST['finalTotal'];
$temp_total_items_purchased=$_POST['totalItemsPurchased'];
$totalsale =$_POST['totalvta'];

$amt_tendered=$_POST['amt_tendered']; 
$amt_change=$amt_tendered-$sale_total_cost; 
$amt_tendered=number_format($amt_tendered, 0,'.',''); 
$amt_change=number_format($amt_change, 0,'.',''); 

?>
<table align="center" >
  <tr>
    <td align="center"><font size='-4'>
<? echo"<br><br><b>$cfg_company</b><br><b>$lang->nit : </b><b>$cfg_company_nit</b><p>";
if($cfg_address!='')
{
	$temp_address=nl2br($cfg_address);
	echo "$lang->address: $temp_address <br>";

}
if($cfg_phone!='' or $cfg_fax!='' )
{
	echo "$lang->phoneNumber: $cfg_phone , $lang->fax: $cfg_fax <br>";

}

if($cfg_email!='')
{
	echo "$lang->email: $cfg_email <br>";

}

if($cfg_website!='')
{
	echo "$lang->website <a href=$cfg_website>$cfg_website</a> <br>";

}
/////////////////
if($cfg_res_fact!='')
{
	echo "$lang->res_fact: $cfg_res_fact <br>";

}
if($cfg_res_fact!='')
{
	echo "$lang->desdeno: $cfg_fact_desde  $lang->hastano: $cfg_fac_hasta  <br>";

}
//////////////////


?>
</font></td>
  </tr>
</table>
<?
$now=date("F j, Y, g:i a");

//////////////////////
$todaysDate=date("Y-m-d");
$subtotal=number_format($sale_total_cost-$finalTax,0,'.', '');
$final_tax=number_format($finalTax,0,'.', '');
$totrec = number_format($_POST['amountpay'],2,'.', '');
$change = $totrec - $sale_total_cost;
$field_names=array('date','customer_id','sale_sub_total','sale_total_cost','paid_with','items_purchased','sold_by','comment','changee','invoicenumber');
$rc_maxin=mysql_query('SELECT MAX(invoicenumber) as maxin  FROM pos_sales',$conn_2);
$maxin=mysql_fetch_assoc($rc_maxin);
$maxin=$maxin['maxin']+1;
//$maxin++;
$field_data=array($todaysDate,$_SESSION['current_sale_customer_id'],$subtotal,$sale_total_cost,$paid_with,$temp_total_items_purchased,$_SESSION['session_user_id'],$comment,$change,$maxin);
$dbf->insert($field_names,$field_data,$sales_table,false);
$saleID=mysql_insert_id();
////////////////////////
echo "<tr><td><div align='center'><font size='-4'>$lang->saleID: $cfg_pref_fac  $maxin  --  $now</font></div></td></tr>";
echo "
<center><h4><font size='-4'>$lang->orderBy: $customer_codigo -- $customer_name </font></h4>

<table border='0' cellspacing='0' cellpadding='2' bgcolor='$table_bg'>

		   <tr>
		    <th><font color='CCCCCC' size='-4'>$lang->itemID</font></th>
		   <th><font color='CCCCCC' size='-4'>$lang->sentencelong</font></th>
	   	   <th><font color='CCCCCC' size='-4'>$lang->priceuni</font></th>
		   <th><font color='CCCCCC' size='-4'>$lang->quantity</font></th>
		   <th><font color='CCCCCC' size='-4'>$lang->tot</font></th>
		   </tr>";



$field_names=array('sale_id','item_id','quantity_purchased','item_unit_price','item_buy_price','item_tax_percent','item_total_tax','item_total_cost','unit_sale','sale_frac');
$field_paywith=array('sale_id','paymethod_id','amount','doc_number','entity','authorized_num','cancel','entrydate','entryuserid','paymethoddetail_id');

$temp_item_id='';
$temp_item_name='';
$temp_quantity_purchased=0;
$temp_item_unit_price=0;
$temp_item_buy_price=0;
$temp_item_tax_percent=0;
$temp_item_tax=0;
$temp_item_cost=0;
$item_info=array();
$temp_item_code = '';


//Add to sales_items table
$kk = 0;
for($k=0;$k<$num_items;$k++)
{
	$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
	$rc_posit=mysql_query('select id from pos_items where item_number = '.$item_info[0].'',$conn_2);
	$rowposit=mysql_fetch_assoc($rc_posit);
	$temp_item_id=$rowposit["id"];
	$temp_item_unit_price2=$dbf->idToField($items_table,'unit_price',$temp_item_id);
	$pric = $_POST['price'.$k.''];
	$temp_item_name=$dbf->idToField($items_table,'shortdescription',$temp_item_id);
	$temp_quantity_purchased=$item_info[3];
	$pack=$item_info[5];
	$temp_item_unit_price=$item_info[1];
	$temp_item_buy_price=$dbf->idToField($items_table,'buy_price',$temp_item_id);
	$temp_item_tax_percent=$item_info[2];
	$temp_item_tax=$temp_item_tax_percent/100*$temp_item_unit_price*$temp_quantity_purchased;
	$temp_pric=$temp_item_unit_price2+$item_info[2];
	$temp_item_cost=($dbf->idToField($items_table,'unit_price',$temp_item_id)*$temp_quantity_purchased)+$temp_item_tax;
    $temp_item_code=$dbf->idToField($items_table,'item_number',$temp_item_id);
	$past = $_POST['past'.$k.''];
	$pack = $_POST['pack'.$k.''];
	
		
	if($past == 2) { $temp_quantity_purchased_new = $temp_quantity_purchased / $pack; } else  { $temp_quantity_purchased_new = $temp_quantity_purchased;	}
	
	$new_quantity=$dbf->idToField($items_table,'quantity',$temp_item_id)-$temp_quantity_purchased_new;
	$qty = $_POST['quantity'.$k.''];
	
	if($past == 2)
	  {
	  
	    $prunit = $temp_item_unit_price2 / $pack;
		$temp_item_cost = $prunit * $qty;
		$pck = 'Frac';
		$prec_unit = $temp_item_unit_price2 / $pack;
		$costtot_item =  $prec_unit * $temp_quantity_purchased;
	  }
	  else
	      { $pck = 'Caja';
		    $prec_unit = $temp_item_unit_price2;
			$costtot_item =  $prec_unit * $temp_quantity_purchased;
		  }
		  
		  $field_data=array("$saleID","$temp_item_id","$temp_quantity_purchased_new","$prec_unit","$temp_item_buy_price","$temp_item_tax_percent","$temp_item_tax","$costtot_item","$past","$pack");
	   
	$query="UPDATE $items_table SET quantity=\"$new_quantity\" WHERE $temp_item_id=id";
	mysql_query($query,$dbf->conn);
	$dbf->insert($field_names,$field_data,$sales_items_table,false);
	echo "<tr><td align='center'><font color='white' size='-4'>$temp_item_code</font></td>
	          <td align='left'><font color='white' size='-4'>$temp_item_name</font></td>
			  <td align='center'><font color='white' size='-4'>$cfg_currency_symbol$pric</font></td>
			  <td align='center'><font color='white' size='-4'>$qty $pck</font></td>
			  <td align='center'><font color='white' size='-4'>$cfg_currency_symbol$temp_item_cost</font></td>
			  <td>$showitem.$k</td>
		  </tr>";
  $temp_cronico=number_format($dbf->idToField($items_table,'cronico',$temp_item_id),0);
   // echo $temp_cronico.'  cronico'; echo '<br>';
	if($temp_cronico == 1 and $kk == 0)
	   $kk = 2;
	
}


if($kk == 2)
$func = 'pedircust()';
else $func = '';
?>
<body onLoad="<?=$func?>"></body>
<?
// Adicionar formas de pago de la venta

$j = $_POST['k'];
 
for($m=0;$m<=$j;$m++)
{
  $temp_paymethodid= $_POST['paymethodid'.$m.''];
  $temp_amount=$_POST['amount'.$m.''];
  $temp_doc_num=$_POST['doc_num'.$m.''];
  $temp_entity=$_POST['entity'.$m.''];
  $temp_auth_num=$_POST['auth_num'.$m.''];
  $item_info=explode(' ',$_SESSION['items_in_sale'][$m]);
  $temp_item_unit_price=number_format($item_info[1],0,'.', '');
  $temp_entity=$_POST['entity'.$m.'']; 
    if($temp_amount != "")
	{
	   $field_datapay=array($saleID,$temp_paymethodid,$temp_amount,$temp_doc_num,$temp_entity,$temp_auth_num,0,date("Y-m-d"),$_SESSION['session_user_id'],$temp_entity);
       $dbf->insert($field_paywith,$field_datapay,$paywith_table,false);
	   
	   /////////////////////
//	   mysql_query("INSERT INTO $paywith_table (usu_cc, usu_nom, usu_apell, usu_nomu, usu_pass, usu_tipo, usu_mail, usu_tel, usu_dir,   usu_cargo) 
	//VALUES ('$usu_cc', '$usu_nom', '$usu_apell', '$usu_cc', '$usu_cc', '$usu_tipo' , '$usu_mail', '$usu_tel', '$usu_dir', '$usu_cargo')");
	 }
///// impuestos
  /*$temp_taxa= $_POST['taxa']; 
  if($temp_taxa == "") { $temp_taxa = 0; $base_impa = 0;} else { $base_impa = $temp_taxa / 1.16; $valivaa = $temp_taxa - $base_impa;  }
  $temp_taxd= $_POST['taxd']; if($temp_taxd == "") { $temp_taxd = 0; $base_impd = 0;} else { $base_impd = $temp_taxd / 1.1; $valivad = $temp_taxd - $base_impd; }
  $temp_taxe= $_POST['taxe']; if($temp_taxe == "") { $temp_taxe = 0; $base_impe = 0;  $valivae=0;} else { $base_impe = $temp_taxe ; $valivae = 0; }
  $temp_tottax= $temp_taxa + $temp_taxd + $temp_taxe;
  $temp_totbase = $base_impa + $base_impd + $base_impe;
  $totvaliva = $valivaa + $valivad + $valivae;*/
  //////
  
}
echo "<tr><td></td></tr><tr><td colspan='3'><b><font color='white' size='4'>$lang->tot</font></td><td align='center'><font color='white' size='3'><b>".$temp_total_items_purchased."</b></font></td><td align='center'><font color='white' size='2'><b>".$cfg_currency_symbol.number_format($totalsale,0)."</b></font></td></tr></table><br>
<table border='0' align='center'>";
echo "<tr><td><b><font size='-4'>$lang->saleSubTotal: $cfg_currency_symbol$subtotal</font></b></td></tr><tr><td>";
?>
<table width="100%">
  <tr>
    <td colspan="4" align="center"><b><? echo "$lang->dettax"; ?></font></b></td>
  </tr>
  <tr>
    <td align="center"><div align="center"><font size='-4'><? echo "<b>$lang->tar</b>"; ?></div></td>
    <td><div align="center"><font size='-4'><? echo "<b>$lang->sale</b>"; ?></font></div></td>
    <td><div align="center"><font size='-4'><? echo "<b>$lang->base_imp</b>"; ?></font></div></td>
    <td><div align="center"><font size='-4'><? echo "<b>$lang->vlriva</b>"; ?></font></div></td>
  </tr>
  <? 
  	 $jh= $_POST['jh'];
	 for($k=0;$k<$jh;$k++)
	   {
	     $tax= $_POST['tax'.$k.''];
 	     $taxid= $_POST['taxid'.$k.''];
		 $taxrate= $_POST['taxrate'.$k.''];
		 
		 if($taxid)
		    {
	         $rc_tax=mysql_query('select tax_rates_id  , tax_rate  from pos_tax_class, pos_tax_rates where pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id and pos_tax_rates.tax_rates_id  = '.$taxid.'',$conn_2);
			 
			 $rc_key=mysql_query('SELECT `key`
FROM
pos_tax_rates
WHERE
pos_tax_rates.tax_rates_id  = '.$taxid.'',$conn_2);
           
		   
            $row5=mysql_fetch_assoc($rc_key);
			 
			 //echo 'select pos_tax_rates.tax_rates_id  , pos_tax_rates.tax_rate from pos_tax_class, pos_tax_rates where pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id and pos_tax_rates.tax_rates_id  = '.$taxid.'';
			 
			 	
		     $number=mysql_num_rows($rc_tax); 
		
				while($row4=mysql_fetch_assoc($rc_tax))
					 {
						$base_impa = $tax / 1.16; 
						$valivaa = $tax - $base_impa;
						//if($item_info[2] == $row4["tax_rate"])
						  //{
						   ?> 
							  <tr>
                                <td align="center"><div align="left"><font size='-4'><? echo $row5["key"]; ?></font></div></td>
                                <td><div align="center"><font size='-4'><? echo number_format($tax,0); ?></font></div></td>
                                <td><div align="center"><font size='-4'><? echo number_format($base_impa,0); ?></font></div></td>
                                <td><div align="center"><font size='-4'><? echo number_format($valivaa,0); ?></font></div></td>
                              </tr>
							<? $taxa+=$rowTotal; 
							echo "<input type=hidden name='tax".$row4["tax_rates_id"]."' id=''   value='".$taxa."'>";
							$taxa = '';
							
					      //}
//					 echo $row4["tax_rate"].' victor'.'<br>';
					 }	
			 }
		} // for 	 
   ?>

   <tr>
    <td colspan="4" align="center"><? echo "$lang->asteric"; ?></td>
  </tr>
  </table>
<?
$totalsale = number_format($sale_total_cost,0);
// echo "<b>$lang->tax: $cfg_currency_symbol$final_tax</b></td></tr>
echo "</td></tr>
<tr><td><b>$lang->saleTotalCost: $cfg_currency_symbol$totalsale</b></td></tr>";
//echo "<tr><td><b>$lang->paidWithdet<br>";
echo "<tr><td>";
?>
<table width="100%">
  <tr>
    <td colspan="3" align="center"><? echo "<b>$lang->paidWithdet<br>"; ?></td>
  </tr>
  <tr>
    <td align="center"><div align="center"><font size="-4"><? echo "<b>$lang->type</b>"; ?></font></div></td>
    <td><div align="center"><font size="-4"><? echo "<b>$lang->entity</b>"; ?></font></div></td>
    <td><div align="center"><font size="-4"><? echo "<b>$lang->extendedPrice</b>"; ?></font></div></td>
  </tr>
<?
$tablename = $cfg_tableprefix.'pay_method';
for($m=0;$m<=$j;$m++)
{
 $temp_paymethodid= $_POST['paymethodid'.$m.''];
 $temp_amount=$_POST['amount'.$m.''];
 $paymethod_result=mysql_query("SELECT name FROM $tablename  where id = $temp_paymethodid",$dbf->conn);	 
 $temp_entity=$_POST['entity'.$m.'']; 
while($row=mysql_fetch_assoc($paymethod_result))
		{
		  ////////////////////////////
           switch ($temp_entity) {
                         case 0:
        					$entidad = '';
         				 break;
					 	
    					 case 1:
						 $entidad = 'Visa';
				         break;
					     case 2:
						 $entidad = 'Visa Electron';
				         break;
						  case 3:
						 $entidad = 'Red Multicolor';
				         break;
						  case 4:
						 $entidad = 'American Express';
				         break;
						  case 5:
						 $entidad = 'Diners';
				         break;
						  case 6:
						 $entidad = 'Visa';
				         break;
						  case 7:
						 $entidad = 'Credencial';
				         break;
						  case 8:
						 $entidad = 'Mastercard';
				         break;
						  case 9:
						 $entidad = 'Bancolombia';
				         break;
						  case 10:
						 $entidad = 'Banco de bogota';
				         break;
						  case 11:
						 $entidad = 'Davivienda';
				         break;
						  case 12:
						 $entidad = 'BBVA';
				         break;
						  case 13:
						 $entidad = 'Banco de Credito';
				         break;
						  case 14:
						 $entidad = 'Citybank';
				         break;
						  case 15:
						 $entidad = 'SODEXHO PASS';
				         break;
						  case 16:
						 $entidad = 'BIG PASS';
				         break;
						 
 						}
		  ////////////////////////////
		  if($temp_amount != 0) {   ?><tr> 
		  <td><div align="center"><font size="-4"><? echo $name=$row['name'];  if( $temp_paymethodid == 1) $showchange = 0; else $showchange =1;
 ?></font></div></td><td><div align="center"><font size="-4"><? if($entidad != '') echo $entidad;  else echo '-------'; ?></font></div></td><td> <div align="center"><font size="-4"><? echo number_format($temp_amount,0); ?></font></div></td>
		  </tr>
  <? }
		}

}



//if($paid_with == 'Efectivo')
//{

$subtotal=number_format($sale_total_cost-$finalTax,0);
$totrec = number_format($amountpay,0);
$change = number_format($amountpay - $sale_total_cost,0);
$totsales = number_format($sale_total_cost,0);
	echo "<tr><td colspan='3'></td></tr><tr><td align='left'><b><font size='-4'>$lang->amtTendered</font></b></td><td></td><td><font size='-4'>$cfg_currency_symbol$totrec</font></td></tr>"; 
	if($showchange == 0)
	  {
	    echo "<tr><td align='left'><b><font size='-4'>$lang->amtChange</font></b></td><td></td><td><font size='-4'>$cfg_currency_symbol$change</font></td></tr>"; 
      }
//}

?>
<tr>
    <td colspan="3" align="center"><font size='-4'><? echo "$lang->asteric"; ?></font></td>
  </tr>
</table>
<?
echo "</b></td></tr><tr><td align = 'center'><b><font size='-4'>$lang->atendio: ".$NameUser."</font></b></td></tr>
      </table></table>";

$sec->closeSale();
$dbf->closeDBlink();


if($cfg_other!='')
{
	echo "<font size='-4'>$cfg_other</font><br>";

}


?>
<br><br>
<SCRIPT Language="Javascript">

/*
This script is written by Eric (Webcrawl@usa.net)
For full source code, installation instructions,
100's more DHTML scripts, and Terms Of
Use, visit dynamicdrive.com
*/

function printit(){  
if (window.print) {
    window.print() ;  
} else {
    var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
    WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = "";  
}
}
</script>

<SCRIPT Language="Javascript">  
var NS = (navigator.appName == "Netscape");
var VERSION = parseInt(navigator.appVersion);
if (VERSION > 3) {
    document.write('<form><input type=button value="Print" name="Print" onClick="printit()"></form>');        
}
</script>
<script type="text/javascript" language="javascript">
<!--
function pedircust ()
       {
	    ventanaSecundaria(this);
	   }
function ventanaSecundaria (URL){
window.open("sale_ui.php?actionID=addcustomer&titulo=2&saleID=<?=$saleID?>","ventana1","width=600, height=270, scrollbars=yes, menubar=no, location=no, resizable=yes")
}
</script>
</body>
</html>