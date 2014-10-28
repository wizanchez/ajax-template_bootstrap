<?php 
set_time_limit(5000);
include ("../settings.php");
include ("../Connections/conexion.php");
include ("../classes/db_functions.php");
$imagenes='cargando.gif';
	global $cfg_locationid;
	echo 'BODEGA ='.$cfg_locationid.'<br>';
	print '<img src="'.$imagenes.'">';
	$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);

	$conn_erp = mysql_connect("191.168.0.56","webservice","webservice") or die("Could not connecta : ".mysql_error());
	mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
		
	$SQL = "SELECT id,item_number FROM pos_items";
	$respta = mysql_query($SQL,$dbf->conn);
	while ($rowdel = mysql_fetch_assoc($respta)) {
				$item = mysql_query('SELECT id FROM item WHERE itemcode ='.$rowdel['item_number'],$conn_erp);
				while ($rowdel_item = mysql_fetch_assoc($item)) {
$itemlocation_copy = mysql_query('SELECT id,onhandqty FROM itemlocation WHERE itemid ='.$rowdel_item['id'].' AND inventorylocationid = '.$cfg_locationid,$conn_erp);
			//	echo ('SELECT id,onhandqty FROM itemlocation  WHERE itemid ='.$rowdel_item['id'].' AND inventorylocationid = '.$cfg_locationid);
					while ($rowdel_itemlocation_copy = mysql_fetch_assoc($itemlocation_copy)) {
						if($rowdel_itemlocation_copy['onhandqty']<'0'){$cantidad=0;}else{$cantidad=$rowdel_itemlocation_copy['onhandqty'];}
echo('update pos_items set quantity = "'.$cantidad.'" where item_number = '.$rowdel['item_number'].'');
							$SQL1 = 'update pos_items set quantity = "'.$cantidad.'" where item_number = '.$rowdel['item_number'];
							$result_queryupd = mysql_query($SQL1,$dbf->conn);
											
							echo 'PLU ='.$rowdel['item_number'].'<br>';
							echo 'CANTIDAD ='.$cantidad.'<br>';
							echo '***************************************************<br>';
					}
				}
	}
	
	echo'<blink>Todos Los Productos Fueron Actualizados!</blink>';

?>