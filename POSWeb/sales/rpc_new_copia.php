<?php 
												define(LIMIT_MAX,'30');
												
		$VALIDAR_CONVENIO	=false;											
												
include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
?><link rel="stylesheet" rev="stylesheet" href="../css/general.css" media="all" /><?php
$lang = new language();

$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,
	$cfg_theme,$lang);

function limitcad($texto)
{
	$nr = 20;
	$mitexto = explode("",trim($texto));
	$textonuevo = array();
	foreach ($mitexto as $k => $txt) {
		if (strlen($txt) > $nr) {
			$txt = wordwrap($txt,$nr,"",1);
		}
		$textonuevo[] = $txt;
	}
	return implode("",$textonuevo);
}

if (!$dbf) {
	// Show error if we cannot connect.
	echo 'ERROR: Could not connect to the database.';
} else {
	// Is there a posted query string?
	if (isset($_REQUEST['queryString'])) {
		$queryString = $_REQUEST['queryString'];

		// Is the string length greater than 0?

		if (strlen($queryString) != '') {
			// Run the query: We use LIKE '$queryString%'
			// The percentage sign is a wild-card, in my example of countries it works like this...
			// $queryString = 'Uni';
			// Returned data = 'United States, United Kindom';

			// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
			// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10
			if ($_REQUEST['tipo_vta'] == '2') {

				if (DISTRI_VTA) {
					$items = $dbf->getElements('pos_items',
						'id, item_number, item_name, unit_price, pack, quantity,shortdescription','shortdescription',' LIKE "%'.$queryString.'%"  OR item_number LIKE "%'.$queryString.'%"  and active = 1 GROUP BY item_number','3',' LIMIT '.LIMIT_MAX);
				} else {

					/*$items = $dbf->getElements('
								pos_items, 
								pos_itemconvenio,
								pos_pacientes ',
									'	pos_items.id, 
										pos_items.item_number, 
										pos_items.item_name,
										pos_items.shortdescription, 
										pos_itemconvenio.price_vta as unit_price, 
										pos_items.pack, pos_items.quantity',
							'pos_items.shortdescription',' LIKE "%'.$queryString.'%" OR item_number LIKE "%'.$queryString.'%" AND
							 pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid	and pos_pacientes.id = "'.$_REQUEST['customer_list'].'" GROUP BY item_number','3',' LIMIT '.LIMIT_MAX);
							 */
							 
					/*	$SQL='
					SELECT 
								
								pos_items.id, 
								pos_items.item_number, 
								pos_items.item_name,
								pos_items.shortdescription, 
								pos_itemconvenio.price_vta as unit_price, 
								pos_items.pack, 
								pos_items.quantity
				FROM 			
								pos_items join pos_pacientes join pos_itemconvenio
				WHERE
								(pos_items.shortdescription  LIKE "%'.$queryString.'%" OR item_number LIKE "%'.$queryString.'%") AND
							 pos_items.active = 1 and pos_itemconvenio.estado = 1 and pos_items.id = pos_itemconvenio.items_id AND 
							 pos_itemconvenio.convenio_id = pos_pacientes.convenioid	and pos_pacientes.id = "'.$_REQUEST['customer_list'].'" 
				GROUP BY item_number LIMIT '.LIMIT_MAX;*/
			$SQL='
					SELECT 
								
								pos_items.id, 
								pos_items.item_number, 
								pos_items.item_name,
								pos_items.shortdescription, 
								pos_items.pack, 
								pos_items.quantity
				FROM 			
								pos_items 
				WHERE
								(pos_items.shortdescription  LIKE "%'.$queryString.'%" OR pos_items.item_number LIKE "%'.$queryString.'%") AND
							 pos_items.active = 1
				GROUP BY 
								pos_items.item_number 
				LIMIT 
								'.LIMIT_MAX;
				 
							 $items = mysql_query($SQL,$dbf->conn);
					$VALIDAR_CONVENIO	=true;
				
				}
			
			} else {
				//
				//
				//
				//
				$items = $dbf->getElements('pos_items',
					'id, item_number, item_name, unit_price, pack, quantity,shortdescription','item_name',' LIKE "%'.$queryString.'%" OR item_number LIKE "%'.$queryString.'%"  and active = 1 GROUP BY item_number','3',' LIMIT '.LIMIT_MAX);
			}
			if ($items) {
				// While there are results loop through them - fetching an Object (i like PHP5 btw!).
?><table width="100%" border="0" cellspacing="0" cellpadding="0" style="cursor:pointer;" class="TexList">
  <tr >
    <td style="background-color:#669 !important; color:#FFF; padding-left:3px;" align="center" width="50" >PLU</td>
    <td style="background-color:#669 !important; color:#FFF; padding-left:3px;" align="center" width="350" >DESCRIPCION</td>
    <td style="background-color:#669 !important; color:#FFF; padding-left:3px;" align="center" width="50" >PRECIO</td>
    <td style="background-color:#669 !important; color:#FFF; padding-left:3px;" align="center" width="50" >FRACCION</td>
    <td style="background-color:#669 !important; color:#FFF; padding-left:3px;" align="center" width="50" >CANTIDAD</td>
  </tr>
  <?php while ($rc_items = mysql_fetch_assoc($items)) {
	
	if($VALIDAR_CONVENIO===true){
		
		##########################################################################################################################
		##	AHORA VERIFICAMOS SI VIENE POR CONVENIO VALIDAMOS SI ESOS PRODUCTOS ESTAN DENTRO DEL CONVENIO
			$SQL2='	SELECT
									pos_pacientes.id
						FROM
									pos_pacientes JOIN 
									pos_itemconvenio
						WHERE
									pos_itemconvenio.estado = 1 AND 
									pos_itemconvenio.items_id = "'.$rc_items['id'].'" AND 
							 		pos_itemconvenio.convenio_id = pos_pacientes.convenioid	AND 
									pos_pacientes.id = "'.$_REQUEST['customer_list'].'" 
						LIMIT 1 ';
				 
							 $pact = mysql_query($SQL2,$dbf->conn);
		##########################################################################################################################
					$total_registros = mysql_num_rows($pact);
					
				$MOTRAR_CLICK		=($total_registros>0)?true:false;
		$rt='si';
		
		}else{
			
				$MOTRAR_CLICK		=true;
		$rt='no';
			}
	
	  
	  $onclik=	($MOTRAR_CLICK===true) ?
'fill(\''.$rc_items['item_number'].' :: '.$rc_items['shortdescription'].' $'.number_format($rc_items['unit_price'],0).' Tot  $ '.number_format($fracc,0).' Und.  Qty [ '.$rc_items['quantity'].' ]\',\''.number_format($rc_items['unit_price'],0).'\',\''.number_format($rc_items['quantity'],1,'.',',').'\');':'alert(\'No Puede Pedir este Item No esta dentro del Convenio \');';
	  
	  $bcolor=($MOTRAR_CLICK===false) ?'!important;opacity:.2;':'';
	  
	  ?>
  <tr onclick="<?php echo $onclik;?>" style="<?php echo $bcolor;?> " >
    <td align="center"><?php echo $rc_items['item_number'];?></td>
    <td style="background-color:#FFF !important; height:25px;"><?php echo strtolower($rc_items['shortdescription']);?></td>
    <td align="right"><?php ver_precio($rc_items['unit_price']);?></td>
    <td align="right"><?php echo number_format($fracc,0);?></td>
    <td align="right"><?php echo number_format($rc_items['quantity'],1,'.',',');?></td>
 </tr>
 <tr onclick="<?php echo $onclik;?>">   
    <td colspan="5"><hr /></td>
  </tr>
  <?php }?>
</table>
<?php
				
					// Format the results, im using <li> for the list, you can change it.
					// The onClick function fills the textbox with the result.

					// YOU MUST CHANGE: $result->value to $result->your_colum
					//$fracc = $rc_items[$i]['unit_price'] / $rc_items[$i]['pack'];

					/*echo '<li onClick="fill(\''.$rc_items['item_number'].' :: '.$rc_items['item_name'].
						' $'.number_format($rc_items['unit_price'],0).' Tot  $ '.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]\');">
						
						'.$rc_items['item_number'].
						' :: '.substr($rc_items['shortdescription'],0,40).'<font color="#000000">  $ '.
						number_format($rc_items['unit_price'],0).' Tot. $'.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]</font></li>';*/
						
				

			} else {
				echo 'ERROR: There was a problem with the query.';
			}
		} else {
			// Dont do anything.
		} // There is a queryString.
	} else {
		echo 'There should be no direct access to this script!';
	}
}
$dbf->closeDBlink();

function ver_precio($precio)
{
	?><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="padding-left:3px;">$</td>
    <td align="right"><?php echo number_format($precio,0);?></td>
  </tr>
</table>
<?php
	}
?>