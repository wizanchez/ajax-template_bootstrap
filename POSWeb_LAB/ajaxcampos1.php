<?php 

if($_REQUEST['type']=='json'){
	
			header('Content-type: application/json');

	}else{
		if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
			header("Content-type: application/xhtml+xml");
		} else {
			header("Content-type: text/html");
		}
}


 $style = true;
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");

$cadena = $_REQUEST['cadena'];
$a = $_REQUEST['a'];
$b = $_REQUEST['b'];
$c = $_REQUEST['c'];
$d = $_REQUEST['d'];
$e = $_REQUEST['e'];
$f = $_REQUEST['f'];
$g = $_REQUEST['g'];
$h = $_REQUEST['h'];

if ($c == 0) {

	echo '<datos> 
			  <valor>22</valor> 
			  </datos>';

}
if ($c == 1) {
	$partes = explode(" :: ",$cadena);
	$barcn = 0;
	$qty = 0;
	$price = 0;
	$cost = 0;

	$rc_itemqty = mysql_query(' select quantity, buy_price, unit_price  from pos_items where item_number = '.$partes[0].'',$conn_2);
	$row_2 = mysql_fetch_assoc($rc_itemqty);
	if ($row_2["quantity"] > 0) {
		$qty = 1;
		if ($row_2["unit_price"] > 0)
			$price = 1;
		if ($row_2["buy_price"] > 0)
			$cost = 1;
		$SQL_UNO='	SELECT 	pos_barcode.barcodenumber
				    FROM    pos_items, 
							pos_itembarcode, 
							pos_barcode 
					WHERE   pos_items.item_number= '.$partes[0].'  and 
							pos_items.active = 1 and 
							pos_items.id = pos_itembarcode.itemid and 
							pos_itembarcode.barcodeid = pos_barcode.id';	
		//echo $SQL_UNO;					
		$rc_barc = mysql_query($SQL_UNO,$conn_2);

		$row = mysql_fetch_assoc($rc_barc);
		if ($row["barcodenumber"] != '')
			$barcn = $row["barcodenumber"];
		else
			$barcn = 0;
	}

	echo '<datos> 
			  <valor>'.$partes[0].'</valor> 
			  <barcnumb>'.$barcn.'</barcnumb>
			  <cantinv>'.$qty.'</cantinv>
			  <price>'.$price.'</price>
			  <cost>7</cost>
			  </datos>';

	// <cost>'.$cost.'</cost>

}
if ($c == 2) {
	$j = 0;
	$k = 0;
	$in = 0;
	if ($a != '') {

		if ($_REQUEST['tipo_vta'] == '2') {
			if (DISTRI_VTA) {
				$SQLK='SELECT
 pos_items.item_name,pos_items.unit_price,pos_items.tax_percent,pos_items.brand_id,pos_items.item_number,pos_items.quantity,pos_items.id,pos_items.active,  pos_items.pack
 FROM 
pos_items, pos_itembarcode, pos_barcode 
WHERE
 ( pos_items.item_number= '.$a.' or pos_items.id = '.$a.
					' or pos_barcode.barcodenumber = '.$a.')  and pos_items.active = 1 
and pos_items.id = pos_itembarcode.itemid and pos_itembarcode.barcodeid = pos_barcode.id';
				$rc_item = mysql_query($SQLK,$conn_2);
			} else {
			
			$SQLK='SELECT
 							pos_items.item_name,
							pos_items.unit_price,
							pos_items.tax_percent,
							pos_items.brand_id,
							pos_items.item_number,
							pos_items.quantity,
							pos_items.id,
							pos_items.active,  
							pos_items.pack
 					FROM 
							pos_items, 
							pos_itembarcode, 
							pos_barcode,
							pos_itemconvenio,
							pos_pacientes 
					WHERE
 							( pos_items.item_number= '.$a.' or pos_items.id = '.$a.' or pos_barcode.barcodenumber = '.$a.')  and pos_items.active = 1 
							and pos_items.id = pos_itembarcode.itemid and pos_itembarcode.barcodeid = pos_barcode.id and 
							pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid and 
							pos_pacientes.id = "'.$_REQUEST['customer_list'].'"';
			
				$rc_item = mysql_query($SQLK,$conn_2);
			}
		} else {
				
				$SQLK='SELECT
 pos_items.item_name,pos_items.unit_price,pos_items.tax_percent,pos_items.brand_id,pos_items.item_number,pos_items.quantity,pos_items.id,pos_items.active,  pos_items.pack
 FROM 
pos_items, pos_itembarcode, pos_barcode 
WHERE
 ( pos_items.item_number= '.$a.' or pos_items.id = '.$a.
				' or pos_barcode.barcodenumber = '.$a.')  and pos_items.active = 1 
and pos_items.id = pos_itembarcode.itemid and pos_itembarcode.barcodeid = pos_barcode.id';
			$rc_item = mysql_query($SQLK,$conn_2);
		}
		$row = mysql_fetch_assoc($rc_item);
		if ($row["item_number"] != '') {
			//			if ($row["quantity"] == 0) {
			//				$j = 1;
			//				$k = $row["item_number"].' :: '.strtoupper($row["item_name"]).' Cantidad [ '.
			//					number_format($row["quantity"]).' ]';
			//				$in = 0;
			//			}
			if ($row["quantity"] <= 0) {
				$j = $row["item_number"];
				$k = $row["item_number"].' :: '.strtoupper($row["item_name"]).' Cantidad [ '.
					number_format($row["quantity"]).' ]';
				$in = 0;
			} else {
				$prunit = $row["unit_price"] / $row["pack"];
				$j = $row["item_number"];
				$k = $row["item_number"].' :: '.strtoupper($row["item_name"]).' $'.$row["unit_price"].
					' Tot $'.$prunit.' Und. QTY[ '.$row["quantity"].' ]';
				$in = $row["quantity"];
			}
		} else {
			$j = 0;
			$k = 0;
			$in = 0;
		}
	}

/*	echo '<li onClick="fill(\''.$rc_items['item_number'].' :: '.$rc_items['item_name'].
						' $'.number_format($rc_items['unit_price'],0).' Tot  $ '.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]\');">'.$rc_items['item_number'].
						' :: '.substr($rc_items['shortdescription'],0,40).'<font color="#000000">  $ '.
						number_format($rc_items['unit_price'],0).' Tot. $'.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]</font></li>';*/

if($_REQUEST['type']=='json'){
	
	
	
		$a_result['descrip']	=$row["item_number"].' :: '.$row["item_name"];
		$a_result['nume']		=mysql_num_rows($rc_item);
		$a_result['val']		=($a_result['nume']>0)?'TRUE':'FALSE';
			
						echo json_encode($a_result);
		
	
	}else{

	echo '<datos> 
			  <valor>'.$j.'</valor>
			  <valor2>'.$k.'</valor2>
			  <valor3>'.$in.'</valor3> 
			  </datos>';
			  
	}
}

if ($c == 3) {

	$rc_possitems = mysql_query(' select sum(item_total_cost)  as sub_tot  from pos_sales_items where sale_id = '.
		$a.' and quantity_purchased >  0  and id !=  '.$b.' and tipo = 1',$conn_2);
	$possitems = mysql_fetch_assoc($rc_possitems);
	if ($possitems["sub_tot"] == '')
		$subt = 0;
	else
		$subt = $possitems["sub_tot"];
	if ($d == 1) {
		if ($f == 2)
			$priceunit = $h / $g;
		else
			$priceunit = $h;
		$pvptot = $priceunit * $e;
		$subt = $subt + $pvptot;
	}

	echo '<datos> 
			      <subtot>'.round($subt).'</subtot>
			 	  </datos>';
}
?>