<?php include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");

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
						'id, item_number, item_name, unit_price, pack, quantity','item_name',' LIKE "%'.
						$queryString.'%" and active = 1 ','3',' LIMIT 200');
				} else {

					$items = $dbf->getElements('pos_items, pos_itemconvenio,pos_pacientes ',
						'pos_items.id, pos_items.item_number, pos_items.item_name, pos_itemconvenio.price_vta as unit_price, pos_items.pack, pos_items.quantity',
						'pos_items.item_name',' LIKE "%'.$queryString.'%" and pos_items.active = 1
			and pos_itemconvenio.estado = 1 and
			pos_items.id = pos_itemconvenio.items_id AND pos_itemconvenio.convenio_id = pos_pacientes.convenioid
			and pos_pacientes.id = "'.$_REQUEST['customer_list'].'"','3',' LIMIT 200');
				}
			} else {
				//
				//
				//
				//
				$items = $dbf->getElements('pos_items',
					'id, item_number, item_name, unit_price, pack, quantity','item_name',' LIKE "%'.
					$queryString.'%" and active = 1 ','3',' LIMIT 200');
			}
			if ($items) {
				// While there are results loop through them - fetching an Object (i like PHP5 btw!).

				while ($rc_items = mysql_fetch_assoc($items)) {
					// Format the results, im using <li> for the list, you can change it.
					// The onClick function fills the textbox with the result.

					// YOU MUST CHANGE: $result->value to $result->your_colum
					//$fracc = $rc_items[$i]['unit_price'] / $rc_items[$i]['pack'];

					echo '<li onClick="fill(\''.$rc_items['item_number'].' :: '.$rc_items['item_name'].
						' $'.number_format($rc_items['unit_price'],0).' Tot  $ '.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]\');">'.$rc_items['item_number'].
						' :: '.substr($rc_items['item_name'],0,40).'<font color="#000000">  $ '.
						number_format($rc_items['unit_price'],0).' Tot. $'.number_format($fracc,0).
						' Und.  Qty [ '.$rc_items['quantity'].' ]</font></li>';
				}

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
?>