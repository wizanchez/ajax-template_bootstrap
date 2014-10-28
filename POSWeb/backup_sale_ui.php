<?php session_start(); 

include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
$lang=new language();
?>
<script type="text/javascript" src="../js/ajax.js"></script>
<script src="../ajax/ajaxjs.js"></script>
<script language="JavaScript">
 function cambpay()
       {
        
		if(document.getElementById("paid_with").value  != 'Efectivo')
		  {
		document.getElementById("amt_tendered").value = document.getElementById("finalTotal").value;
		document.getElementById("amt_tendered").disabled = true;
          }
		 else
		    {
			  document.getElementById("amt_tendered").value = '';
		      document.getElementById("amt_tendered").disabled = false;
			} 
	   }

 function cambamount()
       {
        var j=document.getElementById("amount["+nummp+"]").value ;
		var monto = 0;
		  for( var i=0;i<=j ;i++)
		           {
                      if(document.getElementById("amount["+i+"]").value != "")
				      monto =  parseInt(monto) + parseInt(document.getElementById("amount["+i+"]").value);
					  				  
				   }
				   document.getElementById("amountpay").value = monto;
	   
	   }
	   function checkvalue() 
	          {
			   var m=3;
			   var sumanochange = 0;
					
					 if(document.getElementById("amountpay").value == ""  || document.getElementById("amountpay") == 0)
                   {
				   alert("Digite como minimo 1 cantidad en la seccion de medios de pago");
				   return false;
				  }   
				  
				    
				    for( var i=1;i<=m ;i++)
		           		{
                     		if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value == "" )
				     		     {
								 alert("Digite # documento para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
					  		     }		  
							if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value != "" && document.getElementById("entity["+i+"]").value == 0 )
				     		     {
								 alert("Elija una entidad  para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
					  		     }		 
							 
							 if(document.getElementById("amount["+i+"]").value != "" && document.getElementById("doc_num["+i+"]").value != "" && document.getElementById("entity["+i+"]").value != 0  && document.getElementById("auth_num["+i+"]").value == "" )
				     		     {
								 alert("Digite un numero de autorizacion para el metodo de pago ("+document.getElementById("paymethodname["+i+"]").value+")"); return false;
					  		     }	
							if(document.getElementById("change["+i+"]").value != 0 && document.getElementById("amount["+i+"]").value != "")	
							  {
							    sumanochange =  parseInt(sumanochange) + parseInt(document.getElementById("amount["+i+"]").value);
								
							  } 	
							    	 	  	 
				   	   } 
					
				 if(parseInt(sumanochange) != 0 && (parseInt(sumanochange) > parseInt(document.getElementById("finalTotal").value)))
				  {
				   alert("La sumatoria de los medios de pago no puede ser mayor al total de la venta");
				   return false;
				  }	
					
				
				 if(document.getElementById("amountpay").value != "")
				   {
				     if(parseInt(document.getElementById("amountpay").value) <  parseInt(document.getElementById("finalTotal").value))
				       {
				         alert("La suma de los montos es menor al total de la venta");
				   		 return false;
				  		}
				  }
				   
			  }  
			  
	  
</script>
<?
//updating row for an item already in sale.
if(isset($_GET['update_item']))
{
	$k=$_GET['update_item'];
	$new_price=$_POST["price$k"];
	$new_tax=$_POST["tax$k"];
	$new_quantity=$_POST["quantity$k"];

	$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
	$item_id=$item_info[0];
	$percentOff=$item_info[4];
	
	$_SESSION['items_in_sale'][$k]=$item_id.' '.$new_price.' '.$new_tax.' '.$new_quantity.' '.$percentOff;
	echo "<script>window.open('sale_ui.php','_self')</script>";
//	header("location: sale_ui.php");
	
}

if(isset($_GET['discount']))
{
	$discount=$_POST['global_sale_discount'];

	if(is_numeric($discount))
	{
		for($k=0;$k<count($_SESSION['items_in_sale']);$k++)
		{
			$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
			$item_id=$item_info[0];
			$new_price=$item_info[1]*(1-($discount/100));
			$tax=$item_info[2];
			$quantity=$item_info[3];
			$percentOff=$item_info[4];
			
			$new_price=number_format($new_price,0,'.', '');
	
			$_SESSION['items_in_sale'][$k]=$item_id.' '.$new_price.' '.$tax.' '.$quantity.' '.$percentOff.' '.$tax;
		}
	
//		header("location: sale_ui.php?global_sale_discount=$discount");
		echo "<script>window.open('sale_ui.php?global_sale_discount=".$discount."','_self')</script>";


	}
}


include ("../classes/db_functions.php");
include ("../classes/security_functions.php");		
include ("../classes/display.php");

$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(isset($_POST['customer']))
{	
	if($cfg_numberForBarcode=="Row ID")
	{
		if($dbf->isValidCustomer($_POST['customer']))
		{
			$_SESSION['current_sale_customer_id']=$_POST['customer'];
		}
	}
	else//try account_number
	{
		$id=$dbf->fieldToid($cfg_tableprefix.'customers','account_number',$_POST['customer']);
				
		if($dbf->isValidCustomer($id))
		{
			$_SESSION['current_sale_customer_id']=$id;
			

		}
		else
		{
			echo "$lang->customerWithID/$lang->accountNumber ".$_POST['customer'].', '."$lang->isNotValid";
		}
	}
}


?>
<html>
<head>
<title>JVM Point Of Sale</title>
<script type="text/javascript" language="javascript">
<!--
function customerFocus()
{
	document.scan_customer.customer.focus();
	updateScanCustomerField();
}

function itemFocus()
{
	document.scan_item.item.focus();
	updateScanItemField();
}

function updateScanCustomerField()
{
	document.scan_customer.customer.value=document.scan_customer.customer_list.value;
}

function updateScanItemField()
{
	document.scan_item.item.value=document.scan_item.item_list.value;
}

//-->
</script>
</head>
<?php
if(isset($_SESSION['current_sale_customer_id']))
{
?>
<body onLoad="itemFocus();">
<?php
}
else
{
?>
<body onLoad="customerFocus();">
<?php
}

if(!$actionID){

$table_bg=$display->sale_bg;
$items_table="$cfg_tableprefix".'items';

if(!$sec->isLoggedIn())
{
	echo "<script>window.open('../login.php','_self')</script>";
//	header ("location: ../login.php");
	exit();
}


if(empty($_SESSION['current_sale_customer_id']))
{
	$customers_table="$cfg_tableprefix".'customers';
	
	if(isset($_POST['customer_search']) and $_POST['customer_search']!='')
	{
	 	$search=$_POST['customer_search'];
		$_SESSION['current_customer_search']=$search;
	 	$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\"  ORDER by last_name",$dbf->conn);
    }
    elseif(isset($_SESSION['current_customer_search']))
	{
	 	$search=$_SESSION['current_customer_search'];
	 	$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table WHERE last_name like \"%$search%\" or first_name like \"%$search%\" or id =\"$search\"  ORDER by last_name",$dbf->conn);

	}
	elseif($dbf->getNumRows($customers_table) >200)
	{
		$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name LIMIT 0,200",$dbf->conn);	
	}
	else
  	{
		$customer_result=mysql_query("SELECT first_name,last_name,account_number,id FROM $customers_table ORDER by last_name",$dbf->conn);
	}
	
	$customer_title=isset($_SESSION['current_customer_search']) ? "<b><font color='white'>$lang->selectCustomer: </font></b>":"<font color='white'>$lang->selectCustomer: </font>";

	echo "<table align='center' cellpadding='2' cellspacing='2' bgcolor='$table_bg'>
	<form name='select_customer' action='sale_ui.php' method='POST'>
	<tr><td align='left'><font color='white'>$lang->findCustomer:</font>
	<input type='text' size='8' name='customer_search'>
	<input type='submit' value='Go'><a href='delete.php?action=customer_search'><font size='-1' color='white'>[$lang->clearSearch]</font></a>
	</form></td>	
	<form name='scan_customer' action='sale_ui.php' method='POST'>
	<td align='left'>$customer_title<select name='customer_list' onChange=\"updateScanCustomerField()\";>";
 		
 		while($row=mysql_fetch_assoc($customer_result))
		{
			 if($cfg_numberForBarcode=="Row ID")
			 {
			 	$id=$row['id'];
			 }
			 elseif($cfg_numberForBarcode=="Account/Item Number")
			 {
			 	$id=$row['account_number'];
			 }
			 echo $id;
			 $display_name=$row['last_name'].', '.$row['first_name'];
			 echo "<option value=$id>$display_name</option></center>";
		}
	echo "</select></td>";
	// echo "<tr><td align='left'><center><small><font color='white'>($lang->scanInCustomer)</font></small></center>";
	echo "<tr><td align='left'>";
	echo"<font color='white'>$lang->customerID / $lang->accountNumber: </font><input type='text' name='customer' size='10'>
	<input type='submit'></td></tr>
	</form>";
	
}

if(isset($_SESSION['current_sale_customer_id']))
{	
	if(isset($_POST['item']))
	{
		$item=$_POST['item'];
		$discount='0%';
		if($cfg_numberForBarcode=="Account/Item Number")
		{
				$item=$dbf->fieldToid($items_table,'item_number',$_POST['item']);

		}
		
		if($dbf->isValidItem($item))
		{
			if($dbf->isItemOnDiscount($item))
			{
				$discount=$dbf->getPercentDiscount($item).'%';
				$itemPrice=$dbf->getDiscountedPrice($item);
				
			}
			else
			{	
				$itemPrice=$dbf->idToField($items_table,'unit_price',$item);
				$pack=$dbf->idToField($items_table,'pack',$item);
  		       
			}
			$itemTax=$dbf->idToField($items_table,'tax_percent',$item);
			$_SESSION['items_in_sale'][]=$item.' '.$itemPrice.' '.$itemTax.' '.'1'.' '.$discount;
			$_SESSION['sales_paywith'][]=$paymethodid.' '.$amount.' '.$doc_num.' '.$entity.' '.$auth_num;

			if($cfg_fracprod == 1)
			  {
			   if($| > 1)
			     { ?>
				  <script languaje="javascript">
           
                  </script>
					
				

		<?		 }
			 
			
			  }	
		}
		else
		{
			echo "$lang->itemWithID/$lang->itemNumber ".$_POST['item'].', '."$lang->isNotValid";
		}
	
	}
	
	if(isset($_SESSION['items_in_sale']))
	{
		$num_items=count($_SESSION['items_in_sale']);

	}
	else
	{
		$num_items=0;
	}	
	$temp_item_name='';
	$temp_item_code='';
	$temp_item_id='';
	$temp_quantity='';
	$temp_price='';
	$temp_sindsto = '';
	$finalSubTotal=0;
	$finalTax=0;
	$finalTotal=0;
	$totalItemsPurchased=0;
	
	$item_info=array();

	$customers_table="$cfg_tableprefix".'customers';
	$order_customer_first_name=$dbf->idToField($customers_table,'first_name',$_SESSION['current_sale_customer_id']);
	$order_customer_last_name=$dbf->idToField($customers_table,'last_name',$_SESSION['current_sale_customer_id']);
	$order_customer_code=$dbf->idToField($customers_table,'account_number',$_SESSION['current_sale_customer_id']);
	$order_customer_name=$order_customer_first_name.' '.$order_customer_last_name;
    $pospaymethod_table=$cfg_tableprefix.'pos_pay_method';
	
	//echo "<hr><center><a href=delete.php?action=all>[$lang->clearSale]</a></center>";
	
	
	  $items_table="$cfg_tableprefix".'items';
	 
      
  
	  if(isset($_POST['item_search'])  and $_POST['item_search']!='')
	  {
	  	$search=$_POST['item_search'];
	  	$_SESSION['current_item_search']=$search;
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table WHERE (item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" )  and active = 1 ORDER by item_name",$dbf->conn);
	  }
	  elseif(isset($_SESSION['current_item_search']))
	  {
	  	$search=$_SESSION['current_item_search'];
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table WHERE item_name like \"%$search%\" or item_number= \"$search\" or id =\"$search\" ORDER by item_name",$dbf->conn);

	  }
	  elseif($dbf->getNumRows($items_table) >200)
	  {
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table ORDER by item_name LIMIT ".$cfg_limitrecordview."",$dbf->conn);
	  }
	  else
	  {
	  	$item_result=mysql_query("SELECT item_name,unit_price,tax_percent,brand_id,item_number,quantity,id,active FROM $items_table ORDER by item_name",$dbf->conn);
	  }
	  		
  
		$item_title=isset($_SESSION['current_item_search']) ? "<b><font color='white'>$lang->selectItem: </font></b>":"<font color=white>$lang->selectItem: </font>";
	    echo " <table align='center'>
				  <tr>
					<td width='229'>$lang->newSale</td>
					<td width='243'><a href=delete.php?action=all>[$lang->clearSale]</a></td>
					<td width='300'>$lang->orderBy: <b>$order_customer_name</b>&nbsp;&nbsp;&nbsp;$lang->itemID: <b>$order_customer_code</b>  </td>
				  </tr>
				</table>";
		echo "<form name='select_item' action='sale_ui.php' method='POST'>
		<table border='0' bgcolor='$table_bg' align='center'>
		<tr><td align='left'><font color='white'>$lang->findItem:<input type='text' size='8' name='item_search'></font>
		<input type='submit' value='Go'><a href='delete.php?action=item_search'><font size='-1' color='white'>[$lang->clearSearch]</font></a></td>";
		
			echo "</form><td align='left'><form name='scan_item' action='sale_ui.php' method='POST'>";
				//////////////////////////////////////////////////////////////
		if($cfg_searchproductcombo == 1)
		  {		
				echo"$item_title <select name='item_list' onChange=\"updateScanItemField()\";>\n";
           echo "<option value=''>Elija....</option>\n";
	  while($row=mysql_fetch_assoc($item_result))
	  {
	    if($cfg_numberForBarcode=="Row ID")
	    {
	  		$id=$row['id'];
	  		
	  	}
	  	elseif($cfg_numberForBarcode=="Account/Item Number")
	  	{
	  		$id=$row['item_number'];
	  	}
	  	
	  	$quantity=$row['quantity'];
	  	$brand_id=$row['brand_id'];
	  	$brand_name=$dbf->idToField("$brands_table",'brand',"$brand_id");
	  	$unit_price=$row['unit_price'];
	  	$tax_percent=$row['tax_percent'];
	  	$option_value=$id;
		$active=$row['active'];
		$display_item="$brand_name".'- '.$row['item_name'];
	    if($row['unit_price'] != 0 and $active == 1)
		   {
				if($quantity <=0)
				{
						echo "<option value='$option_value'>$display_item ($lang->outOfStockWarn)</option>\n";
		
				}
				else 
				{
					echo "<option value='$option_value'>$display_item</option>\n";
		
				}
           }  
	  }
echo"</select></td>";
	
	} // if($cfg_searchproductcombo == 1)
	///////////////////////////////////////////////////////////////////////////////
	echo "<td>
	<font color='white'>$lang->itemID / $lang->itemNumber: </font><input type='text' name='item' size='14'>
	<input type='submit'></form></td></tr>";
	?><tr><td><div id="pregg"></div></td></tr><?
	echo"</table>";
	?>
	<hr></hr>

<? echo "<form name='add_sale' action='addsale.php' method='POST' onsubmit='return checkvalue()'>";
	?> <div  style="overflow:scroll;  overflow-x:hidden; width:1230; height:280;"> <!--height:360;--><?
	echo "<table border='0' bgcolor='$table_bg' cellspacing='0' cellpadding='2' align='center'>
	";
//
echo "<tr><th><font color=CCCCCC>$lang->itemID</font></th>
	<th><font color=CCCCCC>$lang->itemName</font></th>
	<th><font color=CCCCCC>$lang->pvc</font></th>
	<th><font color=CCCCCC>$lang->porcdesto</font></th>
	<th><font color=CCCCCC>$lang->vlrdsto</font></th>
	<th><font color=CCCCCC>$lang->vlrcondsto</font></th>
	<th><font color=CCCCCC>$lang->porciva</font></th>
	<th><font color=CCCCCC>$lang->vlriva</font></th>
	<th><font color=CCCCCC>$lang->pvp</font></th>
	<th><font color=CCCCCC>$lang->cant</font></th>
	<th><font color=CCCCCC>$lang->past</font></th>
	<th><font color=CCCCCC>$lang->vlrtot</font></th>
	<th><font color=CCCCCC>$lang->update</font></th>
	<th><font color=CCCCCC>$lang->delete</font></th>
	</tr>";
//
	for($k=0;$k<$num_items;$k++)
	{
		$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
		$temp_item_id=$item_info[0];
		$temp_item_name=$dbf->idToField($items_table,'item_name',$temp_item_id);
		$temp_item_code=$dbf->idToField($items_table,'item_number',$temp_item_id);
		$temp_price= $item_info[1];
	    $temp_sindsto= $dbf->idToField($items_table,'unit_price',$temp_item_id);
		$temp_tax=$dbf->idToField($items_table,'tax_percent',$temp_item_id);
		//$temp_pack=$dbf->idToField($items_table,'pack',$temp_item_id);
		$temp_quantity=$item_info[3];
		$temp_discount=$item_info[4];
		
		$subTotal=$temp_price*$temp_quantity;
		$tax=$subTotal*($temp_tax/100);
		$rowTotal=$subTotal+$tax;
		$rowTotal=number_format($rowTotal,0,'.', '');
        

		$finalSubTotal+=$subTotal;
		$finalTax+=$tax;
		$finalTotal+=$rowTotal;
		$totalItemsPurchased+=$temp_quantity;
	    $resto = substr ($temp_item_name, 0, 45);
		$valdsto = number_format($temp_sindsto * ($temp_discount / 100),0,'.', '');
		$valimp =  number_format(($temp_sindsto-$valdsto) * ($temp_tax / 100),0,'.', '');
		$temp_pricepub = $temp_sindsto - $valdsto + $valimp;
		$temp_sindsto2 = number_format($temp_sindsto,0);
		$temp_price2 = number_format($temp_sindsto-$valdsto,0);
		$valimp2 = number_format($valimp,0);
		$temp_pricepub2=number_format($temp_pricepub,0);
		$vlrtot = number_format($temp_pricepub * $temp_quantity ,0);
		echo "<tr> <td align='center' width='75'><font size='-1' color='white'><b>$temp_item_code</b></font></td>
				  <td align='left'><font size='-1' color='white'><b>$resto</b></font></td>
				  <td align='center'><input type=text name='price$k' style='text-align:right' readonly value='$temp_sindsto2' size='8'></td>
				  <td align='center' width='70'><font color='white'><b>$temp_discount $lang->percentOff</b></font></td>
  				  <td align='center' width='70'><font color='white'><b>".number_format($valdsto,0)."</b></font></td>
   				  <td align='center'><input type=text name='price$k' readonly style='text-align:right' value='$temp_price2' size='8'></td>
				  <td align='center'><input type=text name='tax$k' style='text-align:right'  readonly  value='$temp_tax' size='5'></td>
  				  <td align='center'><input type=text name='valimp$k' style='text-align:right'  readonly  value='$valimp2' size='6'></td>
				  <td align='center'><input type=text name='price$k' readonly style='text-align:right' value='$temp_pricepub2' size='8'></td>
				  <td align='center'><input type=text name='quantity$k' style='text-align:right' value='$temp_quantity' size='3'></td>
				   <td align='center'><select name='pack' id='pack'>
					<option value='1'>Unidad</option>
					<option value='2'>Sobre</option>
				  	</select></td>
				  <td align='center' width='120'><font color='white'><b>$cfg_currency_symbol$vlrtot</b></font></td>
				  <td align='center'><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?update_item=$k';document.add_sale.submit();\"></td>
				  <input type='hidden' name='item_id$k' value='$temp_item_id'>
				  <td align='center'><a href=delete.php?action=item&pos=$k><font color=white>[$lang->remove]</font></a></td>
				  </tr>";
	              $tot_temp_sindsto+=$temp_sindsto; 
				  $tot_valdsto+=$valdsto;
				  $tot_temp_price+=$temp_price;
				  $tot_valimp+=$valimp;
				  $tot_temp_pricepub+=$temp_pricepub;
				  $tot_temp_quantity+=$temp_quantity;
				  $tot_rowTotal+=$rowTotal;
				  $aa[$k]=$temp_pricepub;
		
	}

		$rc_tax=mysql_query('select pos_tax_rates.tax_rates_id  , pos_tax_rates.tax_rate from pos_tax_class, pos_tax_rates where pos_tax_rates.tax_class_id = pos_tax_class.tax_class_id and pos_tax_class.tax_class_id = 1',$conn_2);
		$jh = 0;	
		$number=mysql_num_rows($rc_tax); 
			if($number)
			  {	
				while($row4=mysql_fetch_assoc($rc_tax))
					 {
						for($k=0;$k<$num_items;$k++)
	                        {
							$item_info=explode(' ',$_SESSION['items_in_sale'][$k]);
							$temp_item_id=$item_info[0];
							$temp_tax=$item_info[2];
						     if($temp_tax == $row4["tax_rate"])
						       {
								$taxa+=$aa[$k]; 
								echo "<input type=hidden name='taxid".$row4["tax_rates_id"]."' id=''   value='".$row4["tax_rates_id"]."'>";
								echo "<input type=hidden name='tax".$row4["tax_rates_id"]."' id=''   value='".$taxa."'>";
								echo "<input type=hidden name='taxrate".$row4["tax_rates_id"]."' id=''   value='".$row4["tax_rate"]."'>";								
								
							
						       }
							 }  
					$taxa = 0;		 
//					 echo $row4["tax_rate"].' victor'.'<br>';
                     $jh++;
					 }	
			 echo "<input type=hidden name='jh' id=''   value='".$jh."'>";
			 }
	// $taxa=$rowTotal; 
	
		//////////////////////////////////////////////
    echo "<tr> <td align='right' width='75' colspan='2' bgcolor='#000000'><font size='+1' color='white'><b>$lang->tot</b></font></td>
				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_temp_sindsto,0)."</b></font></td>
				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b></b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_valdsto,0)."</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_temp_price)."</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b></b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_valimp)."</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_temp_pricepub)."</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>$tot_temp_quantity</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'><b>".number_format($tot_rowTotal)."</b></font></td>
  				  <td align='center' width='70' bgcolor='#000000'><font color='white'></font></td>
				  <td align='center' bgcolor='#000000'></td>
				  </tr>";
	$aa = $finalSubTotal;			  
	$finalSubTotal=number_format($finalSubTotal,0);
	$finalTax=number_format($finalTax,0);
	$totalvta = $finalTotal;
	$finalTotal=number_format($finalTotal,0);
	
	echo '</table>';
	?></div><? echo '<br><br>';
	?>	<hr></hr><?
	
	if($global_sale_discount == "") { $descuentporc = 0; $decuent = 0;} else { $descuentporc = $global_sale_discount; $decuent = ($aa * ($global_sale_discount / 100));  }
	echo "<table align='left' ><tr><td>"; ?>
	<font color="#0B0000"><? echo $lang->descuento ?>:</font><input type="text" name="global_sale_discount" id="global_sale_discount" onChange=" ajaxpage_2('sale_ui.php?actionID=quest&IDLoc='+document.getElementById('global_sale_discount').value,'preg','preg');"  size="3"> <?
		echo"<input type='button' name='updateQuantity$k' disabled='true' id='updqty' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\">
	$lang->descuento: $cfg_currency_symbol$decuent  ---  $descuentporc % </td></tr>";
	?>
	<tr><td><div id="preg"></div></td></tr>
	<?
	echo"<tr><td align='left'>$lang->saleSubTotal: $cfg_currency_symbol$finalSubTotal</td></tr>
	<tr><td align='left'>$lang->tax: $cfg_currency_symbol$finalTax</td></tr>";
	if(isset($_GET['global_sale_discount']))
	{
		$discount=$_GET['global_sale_discount'];
		echo"<tr><td align='left'>$discount% $lang->percentOff</td></tr>";

	}
	echo"<tr><td align='left'><b><font size='+1'>$lang->saleTotalCost: $cfg_currency_symbol$finalTotal</font></b></td></tr>";
	echo"<tr><td align='left'><b><font size='+1'>$lang->vrtot: <input type=text name='amountpay' id='amountpay' readonly   value='' size='8'>"; 
     echo "<input type=hidden name='j' id='j'   value='$k'><input type='submit' value='Add Sale'><input type=hidden name='totalvta' id='totalvta'   value='$totalvta'></font></b></td></tr>";
	echo'</table>';
	
	/*echo "<table align='center' bgcolor='$table_bg'><tr><td align='left'><font color='white'>$lang->globalSaleDiscount</font></td>
		<td align='left'>Descuento: <input type='text' name='global_sale_discount' size='3'></td>
		<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td></tr>
		</table>";*/

	/*echo "<table border='0' bgcolor='$table_bg' align='center'>
	<tr>
	<td>
	<font color='white'>$lang->paidWith:</font> 
	</td>
	<td>
	<select name='paid_with' id='paid_with' onchange='cambpay(this);'>
	<option value='$lang->cash'>$lang->cash</option>
	<option value='$lang->check'>$lang->check</option>
	<option value='$lang->credit'>$lang->credit</option>
	<option value='$lang->giftCertificate'>$lang->giftCertificate</option>
	<option value='$lang->account'>$lang->account</option>
	<option value='$lang->other'>$lang->other</option>
	</select>
	</td>
	<td>
	<font color='white'>$lang->amtTendered:</font></td><td><input type='text' size='8' name='amt_tendered' id='amt_tendered'></td>
	</td>
	</tr>
	<tr>
	<td>
	<font color='white'>$lang->saleComment:</font>
	</td>
	<td>
	<input type=text name=comment size=25>
	</td>
	<td>
	<font color='white'>Descuento:</font></td><td align='left'><input type='text' name='global_sale_discount' size='3'></td>
		<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td>
	</td>
	</tr>

	</table>*/
	  echo"<input type=hidden name='totalItemsPurchased' value='$totalItemsPurchased'>
  	  <input type=hidden name='totalTax' value='$finalTax'>
  	  <input type=hidden name='finalTotal' id='finalTotal' value='$totalvta'>
	  ";		


////////////// mostrar los metodos de pago 
   $pospaymethod_table="$cfg_tableprefix".'pay_method';
   $paymethod_result=mysql_query("SELECT * FROM $pospaymethod_table where cancel = 0 order by id",$dbf->conn);
	
			while($row=mysql_fetch_assoc($paymethod_result))
		{
			 $paymethod_id[]=$row['id'];
			 $paymethod_name[]=$row['name'];
			 $paymethod_change[]=$row['change'];
		//	$brands_total[$row_paymethod['id']]=0;
		

		}
		
	
		
//////////////////////////////////////////
?>
<table align="center" bgcolor="<?=$table_bg?>">
  <tr>
    <td><div align="center"><strong><font color='white'><? echo "$lang->paidWith"; ?></font></strong></div></td>
    <td><div align="center"><strong><font color='white'><? echo "$lang->amount"; ?></font></strong></div></td>
	<td><div align="center"><strong><font color='white'><? echo "$lang->doc_num"; ?></font></strong></div></td>
	<td><div align="center"><strong><font color='white'><? echo "$lang->entity"; ?></font></strong></div></td>
	<td><div align="center"><strong><font color='white'><? echo "$lang->auth_no"; ?></font></strong></div></td>
     </tr>
<?
for($k=0;$k<count($paymethod_id);$k++)
		{
		
  		 $id=$paymethod_id[$k];
		 $name=$paymethod_name[$k];
		 $change=$paymethod_change[$k];
		 
?>  
  <tr>
    <td><? echo "<font color='white' face='$display->rowfont_face' size='$display->rowfont_size'>$name</font>"; ?>
    <? echo "<input type=hidden name='paymethodid$k'   value='$id' size='8'><input type=hidden name='change$k' id='change[$k]'   value='$change' size='8'><input type=hidden name='paymethodname$k' id='paymethodname[$k]'   value='$name' size='8'>"; ?></td>
     <td><? echo "<input type=text name='amount$k' id='amount[$k]'   value='' size='8' onblur='cambamount(this);'>"; ?></td>
     <? if($change == 1) 
	      { ?>
            <td><? echo "<input type=text name='doc_num$k' id='doc_num[$k]'   value='' size='8'>"; ?></td>
            
			<? if($name == 'Tarjeta Debito') 
			      { ?>
                  <td><select name="<? echo "entity$k";?>" id="<? echo "entity[$k]";?>">
                    <option value="0">Elija</option>
                    <option value="1">Visa</option>
                    <option value="2">Visa Electron</option>
                    <option value="3">Red Multicolor</option>
                  </select></td>
            <? } if($name == 'Tarjeta de Credito ') 
			      { ?>
                  <td><select name="<? echo "entity$k";?>" id="<? echo "entity[$k]";?>">
                    <option value="0">Elija</option>
                    <option value="4">American Express</option>
                    <option value="5">Diners</option>
                    <option value="6">Visa</option>
                     <option value="7">Credencial</option>
                     <option value="8">Mastercard</option>
                  </select></td>
                    
                <? }   if($name == 'Cheque') 
			             { ?>
                  <td><select name="<? echo "entity$k";?>" id="<? echo "entity[$k]";?>">
                      <option value="0">Elija...</option>
                      <option value="9">Bancolombia</option>
                      <option value="10">Banco de bogota</option>
                      <option value="11">Davivienda</option>
                      <option value="12">BBVA</option>
                      <option value="13">Banco de Credito </option>
                      <option value="14">Citybank</option>
                    </select>                  </td>
                    
                <? } if($name == 'Bonos') 
			             { ?>
                  <td><select name="<? echo "entity$k";?>" id="<? echo "entity[$k]";?>">
                      <option value="0">Elija...</option>
                      <option value="15">SODEXHO PASS</option>
                      <option value="16">BIG PASS</option>
                      </select>                  </td>
                    
                <? } ?>
                   <td><? echo "<input type=text name='auth_num$k' id='auth_num[$k]'   value='' size='8'><input type='hidden' name='k' id='k' value='$k' />
				   <input type='hidden' name='m' id='m' value='$k' />"; ?></td>
                  
        <? } ?> 
  </tr>
<? } echo "<input type='hidden' name='nummp' id='nummp' value='$k' />";
?>
 <tr>
   <td><? echo "<font color='white' face='$display->rowfont_face' size='$display->rowfont_size'>$lang->saleComment</font>";?></td>
   <td colspan="4" ><? echo "<input type='text' name='comment' id='comment' size='40' />"; ?></td>
 </tr>
 <tr>
   <?
  /* echo "<td>
	<font color='white'>Descuento:</font></td><td align='left'><input type='text' name='global_sale_discount' size='3'></td>
		<td><input type='button' name='updateQuantity$k' value='$lang->update' onclick=\"document.add_sale.action='sale_ui.php?discount=true';document.add_sale.submit();\"></td>
	</td>";*/
   ?>
 </tr>
</table>
<? 
 // echo "<br><center><input type='submit' value='Add Sale'></center>";
 echo "</form>";

}
$dbf->closeDBlink();

}
if($actionID=='quest')
   {
      if($IDLoc != "" ) { ?>
   
<tr>
    <td><? echo $lang->username ?>:</td>
    <td><input type="text" name="username" id="username" /></td>
  </tr>
  <tr>
    <td><? echo $lang->password ?>:</td>
    <td><input type="password" name="clave" id="clave" onChange="return Validarsuperv(this.value,1);" /></td>
  </tr>
  
<? } // if($transacc == 2 )
   }  if($actionID =='quest2') {
echo 'zarate';
  }
?>

</body>
</html>

