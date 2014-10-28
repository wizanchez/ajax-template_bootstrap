<?php class display
{

	var $conn;
	var $lang;
	var $title_color,$list_of_color,$table_bgcolor,$cellspacing,$cellpadding,$border_style,
		$border_width,$border_color,$header_rowcolor,$header_text_color,$headerfont_face,
		$headerfont_size,$rowcolor1,$rowcolor2,$rowcolor_text,$rowfont_face,$rowcolor_link,
		$rowfont_size,$sale_bg;

	function display($connection,$theme,$currency_symbol,$language)
	{
		$this->conn = $connection;
		$this->lang = $language;
		$this->currency_symbol = $currency_symbol;
		switch ($theme) {
			case $theme == 'big blue':

				$this->title_color = '#005B7F';
				$this->list_of_color = '#247392';

				$this->table_bgcolor = 'white';
				$this->cellspacing = '1';
				$this->cellpadding = '0';
				$this->border_style = 'solid';
				$this->border_width = '1';
				$this->border_color = '#0A6184';

				$this->header_rowcolor = 'navy';
				$this->header_text_color = 'white';
				$this->headerfont_face = 'arial';
				$this->headerfont_size = '2';

				$this->rowcolor1 = '#15759B';
				$this->rowcolor2 = '#0A6184';
				$this->rowcolor_text = 'white';
				$this->rowfont_face = 'geneva';
				$this->rowcolor_link = 'CCCCCC';
				$this->rowfont_size = '2';
				$this->sale_bg = '#015B7E';

				break;

			case $theme == 'serious':

				$this->title_color = 'black';
				$this->list_of_color = 'black';

				$this->table_bgcolor = 'white';
				$this->cellspacing = '1';
				$this->cellpadding = '0';
				$this->border_style = 'solid';
				$this->border_width = '1';
				$this->border_color = 'black';

				$this->header_rowcolor = 'black';
				$this->header_text_color = 'white';
				$this->headerfont_face = 'arial';
				$this->headerfont_size = '2';

				$this->rowcolor1 = '#DDDDDD';
				$this->rowcolor2 = '#CCCCCC';
				$this->rowcolor_text = 'black';
				$this->rowfont_face = 'geneva';
				$this->rowcolor_link = 'black';
				$this->rowfont_size = '2';
				$this->sale_bg = '#999999';
				break;

		}
	}

	function displayTitle($title)
	{
		//pre: Title must be a string.
		//post: Applys title to page.

		echo "<center><h3><font color='$this->title_color'>$title</font></h3></center>";
	}

	function idToField($tablename,$field,$id)
	{
		//pre: $tablename, field, and id all must be valid
		//post: returns a specified field based on the ID from a specified table.

		$result = mysql_query("SELECT $field FROM $tablename WHERE id=\"$id\"",$this->
			conn);

		$row = mysql_fetch_assoc($result);

		return $row[$field];
	}

	function idToFieldWh($tablename,$field,$field2,$id)
	{
		// return data where  especified  a field

		$result = mysql_query("SELECT $field FROM $tablename WHERE $field2=\"$id\"",$this->
			conn);

		$row = mysql_fetch_assoc($result);

		return $row[$field];
	}

	function getNumRows($table)
	{
		$query = "SELECT id FROM $table";
		$result = mysql_query($query,$this->conn);

		return mysql_num_rows($result);

	}

	function displayManageTable($tableprefix,$tablename,$tableheaders,$tablefields,
		$wherefield,$wheredata,$orderby)
	{
		//pre:params must be right type
		//post: outputs a nice looking table that is used for manage parts of the program

		if ($tablename == 'brands' or $tablename == 'categories') {
			$tablewidth = '35%';
		} else {
			$tablewidth = '95%';
		}

		$table = "$tableprefix"."$tablename";
		echo "\n".'<center>';

		if ($wherefield == 'quantity' and $wheredata == 'outofstock') {
			$result = mysql_query("SELECT * FROM $table WHERE quantity < 1 ORDER BY $orderby",
				$this->conn);
		} elseif ($wherefield == 'quantity' and $wheredata == 'reorder') {
			$result = mysql_query("SELECT * FROM $table WHERE quantity <= reorder_level ORDER BY $orderby",
				$this->conn);

		} elseif ($wherefield != '' and $wheredata != '') {
			$result = mysql_query("SELECT * FROM $table WHERE $wherefield like \"%$wheredata%\" ORDER BY $orderby",
				$this->conn);
		} elseif ($this->getNumRows($table) > 200) {
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby LIMIT 0,200",$this->
				conn);
			echo "{$this->lang->moreThan200} $tableprefix $table".'\'s'."{$this->lang->first200Displayed}";
		} else {
			$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",$this->conn);
		}
		echo '<hr>';
		if (@mysql_num_rows($result) == 0) {
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<center><h4><font color='$this->list_of_color'>{$this->lang->listOf} $tablename</font></h4></center>";
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		for ($k = 0; $k < count($tableheaders); $k++) {
			echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";

		$rowCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
			if ($rowCounter % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			for ($k = 0; $k < count($tablefields); $k++) {
				$field = $tablefields[$k];
				$data = $this->formatData($field,$row[$field],$tableprefix);

				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}

			echo "<td align='center'>\n<a href=\"form_$tablename.php?action=update&id=$row[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
				 <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $table {$this->lang->table}?','process_form_$tablename.php?action=delete&id=$row[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";
		}
		echo '</table>'."\n";
	}

	function displayReportTable($tableprefix,$tablename,$tableheaders,$tablefields,
		$wherefield,$wheredata,$date1,$date2,$orderby,$subtitle)
	{
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth = '85%';

		$table = "$tableprefix"."$tablename";
		echo "\n".'<center>';
		if ($tablename == 'sales_items') {
			if ($wherefield != '' and $wheredata != '' and $date1 == '' and $date2 == '') {
				$result = mysql_query("SELECT * FROM $table WHERE  $wherefield = \"$wheredata\" ORDER BY $orderby",
					$this->conn);
			} elseif ($wherefield != '' and $wheredata != '' and $date1 != '' and $date2 !=
			'') {
				$result = mysql_query("SELECT * FROM $table WHERE  $wherefield = \"$wheredata\" and date between \"$date1\" and \"$date2\" ORDER BY $orderby",
					$this->conn);
			} elseif ($date1 != '' and $date2 != '') {
				$result = mysql_query("SELECT * FROM $table WHERE  date between \"$date1\" and \"$date2\" ORDER BY $orderby",
					$this->conn);

			} else {
				$result = mysql_query("SELECT * FROM $table ORDER BY $orderby",
					$this->conn);
			}
		} else {

			if ($wherefield != '' and $wheredata != '' and $date1 == '' and $date2 == '') {
				$result = mysql_query("SELECT * FROM $table WHERE tipo_vta = 1 AND $wherefield = \"$wheredata\" ORDER BY $orderby",
					$this->conn);
			} elseif ($wherefield != '' and $wheredata != '' and $date1 != '' and $date2 !=
			'') {
				$result = mysql_query("SELECT * FROM $table WHERE tipo_vta = 1 AND $wherefield = \"$wheredata\" and date between \"$date1\" and \"$date2\" ORDER BY $orderby",
					$this->conn);
			} elseif ($date1 != '' and $date2 != '') {
				$result = mysql_query("SELECT * FROM $table WHERE tipo_vta = 1 AND date between \"$date1\" and \"$date2\" ORDER BY $orderby",
					$this->conn);

			} else {
				$result = mysql_query("SELECT * FROM $table WHERE tipo_vta = 1 ORDER BY $orderby",
					$this->conn);
			}
		}
		echo '<hr>';
		if (@mysql_num_rows($result) == 0) {
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		for ($k = 0; $k < count($tableheaders); $k++) {
			echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";

		$rowCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
			if ($rowCounter % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			for ($k = 0; $k < count($tablefields); $k++) {
				$field = $tablefields[$k];

				if ($field == 'sale_details') {
					$temp_customer_id = $row['customer_id'];
					$temp_date = $row['date'];
					$temp_sale_id = $row['id'];
					$data = "<a href=\"javascript:popUp('show_details.php?sale_id=$temp_sale_id&sale_customer_id=$temp_customer_id&sale_date=$temp_date')\"><font color='$this->rowcolor_link'>{$this->lang->showSaleDetails}</font></a>";

				} else {
					if ($field == 'brand_id' or $field == 'category_id' or $field == 'supplier_id') {
						$field_data = $this->idToField("$tableprefix".'items',"$field",$row['item_id']);
						$data = $this->formatData($field,$field_data,$tableprefix);
					} else
						if ($field == 'sales_paywith') {
							/* $field2 = 'paymethod_id';
							$fieldwh = 'sales_id';
							$field_data=$this->idToFieldWh("$tableprefix".'sales_paywith',"$field2","$fieldwh",$row['item_id']);
							$data=$this->formatData($field2,$field_data,$tableprefix);*/
						} else {
							$data = $this->formatData($field,$row[$field],$tableprefix);

						}
				}

				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}

		}
		echo '</table>'."\n";

	}

	function displayReportTableDispe($tableprefix,$tablename,$tableheaders,$tablefields,
		$wherefield,$wheredata,$date1,$date2,$orderby,$subtitle)
	{
		echo "<center><h4><font color='$this->list_of_color'>$subtitle</font></h4></center>";
		$tablewidth = '85%';
		$table = "$tableprefix"."$tablename";
		$sales_items_table = $tableprefix.'sales_items';
		echo "\n".'<center>';

		if ($tablename == 'sales_items') {
			if ($wherefield != '' and $wheredata != '' and $date1 == '' and $date2 == '') {
				$result = mysql_query("SELECT * FROM $table WHERE  $wherefield = \"$wheredata\"  ORDER BY $orderby",
					$this->conn);
				//echo '1';

			} elseif ($wherefield != '' and $wheredata != '' and $date1 != '' and $date2 !=
			'') {

				$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\"  and date between \"$date1\" and \"$date2\" ORDER BY $orderby",
					$this->conn);
				//echo '2';
			} elseif ($date1 != '' and $date2 != '') {

				$result = mysql_query("SELECT * FROM $table WHERE  date between \"$date1\" and \"$date2\"   ORDER BY $orderby",
					$this->conn);
				//echo '3';
			} else {

				$result = mysql_query("SELECT * FROM $table  ORDER BY $orderby",$this->conn);
				//echo '4';
			}
		} else {

			if ($wherefield != '' and $wheredata != '' and $date1 == '' and $date2 == '') {
				$result = mysql_query("SELECT $table.id, $table.date, $table.customer_id as paciente_id, $table.sale_sub_total, $table.sale_total_cost, $table.paid_with, $table.items_purchased, $table.sold_by, $table.comment, $table.changee, $table.invoicenumber, $table.status, $table.descuentporc, $table.value_discount, $table.tipo_vta  
				FROM $table,$sales_items_table 
				WHERE $table.id = $sales_items_table.sale_id AND $table.status = 1 and $table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 
				AND $table.$wherefield = \"$wheredata\"   
				GROUP BY $table.id ORDER BY $table.$orderby",$this->conn);
				//$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\" AND tipo_vta = 2 ORDER BY $orderby",
				//$this->conn);
				//echo '1';

			} elseif ($wherefield != '' and $wheredata != '' and $date1 != '' and $date2 !=
			'') {
				$result = mysql_query("SELECT $table.id, $table.date, $table.customer_id as paciente_id, $table.sale_sub_total, $table.sale_total_cost, $table.paid_with, $table.items_purchased, $table.sold_by, $table.comment, $table.changee, $table.invoicenumber, $table.status, $table.descuentporc, $table.value_discount, $table.tipo_vta  
				FROM $table,$sales_items_table 
				WHERE $table.id = $sales_items_table.sale_id AND $table.status = 1 and $table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 
				AND $table.$wherefield = \"$wheredata\" AND $table.date between \"$date1\" and \"$date2\"   
				GROUP BY $table.id ORDER BY $table.$orderby",$this->conn);
				//$result = mysql_query("SELECT * FROM $table WHERE $wherefield = \"$wheredata\" AND tipo_vta = 2 and date between \"$date1\" and \"$date2\" ORDER BY $orderby",
				//$this->conn);
				//echo '2';
			} elseif ($date1 != '' and $date2 != '') {
				$result = mysql_query("SELECT $table.id, $table.date, $table.customer_id as paciente_id, $table.sale_sub_total, $table.sale_total_cost, $table.paid_with, $table.items_purchased, $table.sold_by, $table.comment, $table.changee, $table.invoicenumber, $table.status, $table.descuentporc, $table.value_discount, $table.tipo_vta  
				FROM $table,$sales_items_table 
				WHERE $table.id = $sales_items_table.sale_id AND $table.status = 1 and $table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 
				AND $table.date between \"$date1\" and \"$date2\"  
				GROUP BY $table.id ORDER BY $table.$orderby",$this->conn);
				//$result = mysql_query("SELECT * FROM $table WHERE  date between \"$date1\" and \"$date2\"  AND tipo_vta = 2 ORDER BY $orderby",
				//$this->conn);
				//echo '3';
			} else {
				$result = mysql_query("SELECT $table.id, $table.date, $table.customer_id as paciente_id, $table.sale_sub_total, $table.sale_total_cost, $table.paid_with, $table.items_purchased, $table.sold_by, $table.comment, $table.changee, $table.invoicenumber, $table.status, $table.descuentporc, $table.value_discount, $table.tipo_vta  
				FROM $table,$sales_items_table 
				WHERE $table.id = $sales_items_table.sale_id AND $table.status = 1 and $table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 
				GROUP BY $table.id ORDER BY $table.$orderby",$this->conn);
				//$result = mysql_query("SELECT * FROM $table WHERE tipo_vta = 2 ORDER BY $orderby",
				//$this->conn);
				//echo '4';
			}
		}
		echo '<hr>';
		if (@mysql_num_rows($result) == 0) {
			echo "<div align='center'>{$this->lang->noDataInTable} <b>$table</b> {$this->lang->table}.</div>";
			exit();
		}
		echo "<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
		<tr bgcolor=$this->header_rowcolor>\n\n";
		for ($k = 0; $k < count($tableheaders); $k++) {
			echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
		}
		echo '</tr>'."\n\n";

		$rowCounter = 0;
		while ($row = mysql_fetch_assoc($result)) {
			if ($rowCounter % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter++;
			for ($k = 0; $k < count($tablefields); $k++) {
				$field = $tablefields[$k];

				if ($field == 'sale_details') {
					$temp_customer_id = $row['customer_id'];
					$temp_date = $row['date'];
					$temp_sale_id = $row['id'];
					$data = "<a href=\"javascript:popUp('show_detailsDisp.php?sale_id=$temp_sale_id&sale_customer_id=$temp_customer_id&sale_date=$temp_date')\"><font color='$this->rowcolor_link'>{$this->lang->showSaleDetails}</font></a>";

				} else {
					if ($field == 'brand_id' or $field == 'category_id' or $field == 'supplier_id') {
						$field_data = $this->idToField("$tableprefix".'items',"$field",$row['item_id']);
						$data = $this->formatData($field,$field_data,$tableprefix);
					} else
						if ($field == 'sales_paywith') {
							/* $field2 = 'paymethod_id';
							$fieldwh = 'sales_id';
							$field_data=$this->idToFieldWh("$tableprefix".'sales_paywith',"$field2","$fieldwh",$row['item_id']);
							$data=$this->formatData($field2,$field_data,$tableprefix);*/
						} else {
							$data = $this->formatData($field,$row[$field],$tableprefix);

						}
				}

				echo "\n<td  align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
			}

		}
		echo '</table>'."\n";

	}

	function displaySaleManagerTable($tableprefix,$where1,$where2)
	{
		$tablewidth = '85%';
		$sales_table = "$tableprefix"."sales";
		$sales_items_table = "$tableprefix"."sales_items";

		if ($where1 != '' and $where2 != '') {

			$sale_query = "SELECT * FROM $sales_table WHERE status = 1 and tipo_vta = 1 and id between \"$where1\" and \"$where2\" ORDER BY id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		} else {
			$sale_query = "SELECT * FROM $sales_table WHERE status = 1 and tipo_vta = 1 ORDER BY id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		}

		$sales_tableheaders = array("{$this->lang->date}","{$this->lang->customerName}",
			"{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}",
			"{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
		$sales_tablefields = array('date','customer_id','items_purchased','paid_with',
			'sold_by','sale_sub_total','sale_total_cost','comment');

		$sales_items_tableheaders = array("{$this->lang->itemName}","{$this->lang->brand}",
			"{$this->lang->category}","{$this->lang->supplier}","{$this->lang->quantityPurchased}",
			"{$this->lang->unitPrice}","{$this->lang->tax}","{$this->lang->itemTotalCost}",
			"{$this->lang->updateItem}","{$this->lang->deleteItem}");
		$sales_items_tablefields = array('item_id','brand_id','category_id',
			'supplier_id','quantity_purchased','item_unit_price','item_total_tax',
			'item_total_cost');

		if (@mysql_num_rows($sale_result) < 1) {
			echo "<div align='center'>You do not have any data in the <b>sales</b> tables.</div>";
			exit();
		}

		$rowCounter1 = 0;
		echo "<center><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color 3 px\"><tr><td><br>";
		while ($row = mysql_fetch_assoc($sale_result)) {

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\"><tr><td align='center'><br><b>{$this->lang->saleID} $row[invoicenumber]</b>
			[<a href='update_sale.php?id=$row[id]'>{$this->lang->updateSale}</a>]
			[<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_table {$this->lang->table}?','delete_sale.php?id=$row[id]')\">{$this->lang->deleteEntireSale}]</a>
            [<a href=\"printcopysale.php?sale_id=$row[id]\" target=\"_new\">IMPRIMIR TICKET]</a>
			<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
			<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";
			if ($rowCounter1 % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter1++;
			for ($k = 0; $k < count($sales_tablefields); $k++) {
				$field = $sales_tablefields[$k];
				$data = $this->formatData($field,$row[$field],$tableprefix);

				echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";

			}

			echo '</tr></table>';
			$sale_items_query = "SELECT * FROM $sales_items_table WHERE sale_id=\"$row[id]\" AND quantity_purchased > 0";
			$sale_items_result = mysql_query($sale_items_query,$this->conn);
			echo "<br><b>{$this->lang->itemsInSale}</b><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
					<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_items_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_items_tableheaders[$k]</font>\n</th>\n";
			}
			echo '</tr>';

			$rowCounter2 = 0;
			while ($newrow = mysql_fetch_assoc($sale_items_result)) {
				if ($rowCounter2 % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				$rowCounter2++;
				for ($k = 0; $k < count($sales_items_tablefields); $k++) {
					$field = $sales_items_tablefields[$k];
					if ($field == 'brand_id' or $field == 'category_id' or $field == 'supplier_id') {
						$field_data = $this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
						$data = $this->formatData($field,$field_data,$tableprefix);
					} else {
						$data = $this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}

				echo "<td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			  <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_items_table {$this->lang->table}?','delete_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";

				echo '</tr>'."\n\n";
			}
			echo '</table><br></table><br>';
		}
		echo "</table></td></tr></table></center>";
	}

	function displayEventoManagerTable($tableprefix,$where1,$where2)
	{
		$tablewidth = '85%';
		$sales_table = "$tableprefix"."sales";
		$sales_items_table = "$tableprefix"."sales_items";

		if ($where1 != '' and $where2 != '') {

			$sale_query = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table WHERE $sales_table.id = $sales_items_table.sale_id AND  $sales_table.status = 1 AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 3 AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0  and $sales_table.id between \"$where1\" and \"$where2\" GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		} else {
			$sale_query = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table WHERE $sales_table.id = $sales_items_table.sale_id AND  $sales_table.status = 1 AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 3 AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		}

		$sales_tableheaders = array("{$this->lang->date}","{$this->lang->customerPac}",
			"{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}",
			"{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
		$sales_tablefields = array('date','paciente_id','items_purchased','paid_with',
			'sold_by','sale_sub_total','sale_total_cost','comment');

		$sales_items_tableheaders = array("{$this->lang->itemName}","{$this->lang->brand}",
			"{$this->lang->category}","{$this->lang->supplier}","{$this->lang->quantityFormula}",
			"{$this->lang->quantityDispensa}","{$this->lang->unitPrice}","{$this->lang->tax}",
			"{$this->lang->itemTotalCost}","{$this->lang->updateItem}","{$this->lang->deleteItem}");
		$sales_items_tablefields = array('item_id','brand_id','category_id',
			'supplier_id','qtyrecetada','quantity_purchased','item_unit_price',
			'item_total_tax','item_total_cost');

		if (@mysql_num_rows($sale_result) < 1) {
			echo "<div align='center'>You do not have any data in the <b>sales</b> tables.</div>";
			exit();
		}

		$rowCounter1 = 0;
		echo "<center><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color 3 px\"><tr><td><br>";
		while ($row = mysql_fetch_assoc($sale_result)) {

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\"><tr><td align='center'><br><b>{$this->lang->saleID} $row[invoicenumber]</b>
			[<a href='update_sale.php?id=$row[id]'>{$this->lang->updateDistri}</a>]
			[<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_table {$this->lang->table}?','delete_sale.php?id=$row[id]')\">{$this->lang->deleteEntireDistri}]</a>
            [<a href=\"printcopysale.php?sale_id=$row[id]\" target=\"_new\">IMPRIMIR TICKET]</a>
			<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
			<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";
			if ($rowCounter1 % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter1++;
			for ($k = 0; $k < count($sales_tablefields); $k++) {
				$field = $sales_tablefields[$k];
				$data = $this->formatData($field,$row[$field],$tableprefix);

				echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";

			}

			echo '</tr></table>';
			$sale_items_query = "SELECT * FROM $sales_items_table WHERE sale_id=\"$row[id]\" AND tipo = 3 AND qtyrecetada > 0 AND quantity_purchased > 0";
			$sale_items_result = mysql_query($sale_items_query,$this->conn);
			echo "<br><b>{$this->lang->itemsInSale}</b><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
					<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_items_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_items_tableheaders[$k]</font>\n</th>\n";
			}
			echo '</tr>';

			$rowCounter2 = 0;
			while ($newrow = mysql_fetch_assoc($sale_items_result)) {
				if ($rowCounter2 % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				$rowCounter2++;
				for ($k = 0; $k < count($sales_items_tablefields); $k++) {
					$field = $sales_items_tablefields[$k];
					if ($field == 'brand_id' or $field == 'category_id' or $field == 'supplier_id') {
						$field_data = $this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
						$data = $this->formatData($field,$field_data,$tableprefix);
					} else {
						$data = $this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}

				echo "<td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			  <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_items_table {$this->lang->table}?','delete_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";

				echo '</tr>'."\n\n";
			}
			echo '</table><br></table><br>';
		}
		echo "</table></td></tr></table></center>";
	}


	function displayDistriManagerTable($tableprefix,$where1,$where2)
	{
		$tablewidth = '85%';
		$sales_table = "$tableprefix"."sales";
		$sales_items_table = "$tableprefix"."sales_items";

		if ($where1 != '' and $where2 != '') {

			$sale_query = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table WHERE $sales_table.id = $sales_items_table.sale_id AND  $sales_table.status = 1 AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0  and $sales_table.id between \"$where1\" and \"$where2\" GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		} else {
			$sale_query = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table WHERE $sales_table.id = $sales_items_table.sale_id AND  $sales_table.status = 1 AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";
			$sale_result = mysql_query($sale_query,$this->conn);

		}

		$sales_tableheaders = array("{$this->lang->date}","{$this->lang->customerPac}",
			"{$this->lang->itemsPurchased}","{$this->lang->paidWith}","{$this->lang->soldBy}",
			"{$this->lang->saleSubTotal}","{$this->lang->saleTotalCost}","{$this->lang->saleComment}");
		$sales_tablefields = array('date','paciente_id','items_purchased','paid_with',
			'sold_by','sale_sub_total','sale_total_cost','comment');

		$sales_items_tableheaders = array("{$this->lang->itemName}","{$this->lang->brand}",
			"{$this->lang->category}","{$this->lang->supplier}","{$this->lang->quantityFormula}",
			"{$this->lang->quantityDispensa}","{$this->lang->unitPrice}","{$this->lang->tax}",
			"{$this->lang->itemTotalCost}","{$this->lang->updateItem}","{$this->lang->deleteItem}");
		$sales_items_tablefields = array('item_id','brand_id','category_id',
			'supplier_id','qtyrecetada','quantity_purchased','item_unit_price',
			'item_total_tax','item_total_cost');

		if (@mysql_num_rows($sale_result) < 1) {
			echo "<div align='center'>You do not have any data in the <b>sales</b> tables.</div>";
			exit();
		}

		$rowCounter1 = 0;
		echo "<center><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color 3 px\"><tr><td><br>";
		while ($row = mysql_fetch_assoc($sale_result)) {

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\"><tr><td align='center'><br><b>{$this->lang->saleID} $row[invoicenumber]</b>
			[<a href='update_sale.php?id=$row[id]'>{$this->lang->updateDistri}</a>]
			[<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_table {$this->lang->table}?','delete_sale.php?id=$row[id]')\">{$this->lang->deleteEntireDistri}]</a>
            [<a href=\"printcopysale.php?sale_id=$row[id]\" target=\"_new\">IMPRIMIR TICKET]</a>
			<table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
		
			<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";
			if ($rowCounter1 % 2 == 0) {
				echo "\n<tr bgcolor=$this->rowcolor1>\n";
			} else {
				echo "\n<tr bgcolor=$this->rowcolor2>\n";
			}
			$rowCounter1++;
			for ($k = 0; $k < count($sales_tablefields); $k++) {
				$field = $sales_tablefields[$k];
				$data = $this->formatData($field,$row[$field],$tableprefix);

				echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";

			}

			echo '</tr></table>';
			$sale_items_query = "SELECT * FROM $sales_items_table WHERE sale_id=\"$row[id]\" AND tipo = 2 AND qtyrecetada > 0 AND quantity_purchased > 0";
			$sale_items_result = mysql_query($sale_items_query,$this->conn);
			echo "<br><b>{$this->lang->itemsInSale}</b><table cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='$tablewidth' style=\"border: $this->border_style $this->border_color $this->border_width px\">
					<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($sales_items_tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$sales_items_tableheaders[$k]</font>\n</th>\n";
			}
			echo '</tr>';

			$rowCounter2 = 0;
			while ($newrow = mysql_fetch_assoc($sale_items_result)) {
				if ($rowCounter2 % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				$rowCounter2++;
				for ($k = 0; $k < count($sales_items_tablefields); $k++) {
					$field = $sales_items_tablefields[$k];
					if ($field == 'brand_id' or $field == 'category_id' or $field == 'supplier_id') {
						$field_data = $this->idToField("$tableprefix".'items',"$field",$newrow['item_id']);
						$data = $this->formatData($field,$field_data,$tableprefix);
					} else {
						$data = $this->formatData($field,$newrow[$field],$tableprefix);
					}
					echo "\n<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$data</font>\n</td>\n";
				}

				echo "<td align='center'>\n<a href=\"update_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]\"><font color='$this->rowcolor_link'>{$this->lang->update}</font></a></td>
			  <td align='center'>\n<a href=\"javascript:decision('{$this->lang->confirmDelete} $sales_items_table {$this->lang->table}?','delete_item.php?sale_id=$newrow[sale_id]&item_id=$newrow[item_id]&row_id=$newrow[id]')\"><font color='$this->rowcolor_link'>{$this->lang->delete}</font></a></td>\n</tr>\n\n";

				echo '</tr>'."\n\n";
			}
			echo '</table><br></table><br>';
		}
		echo "</table></td></tr></table></center>";
	}

	function displayTotalsReport($tableprefix,$total_type,$tableheaders,$date1,$date2,
		$where1,$where2)
	{
		$sales_table = "$tableprefix".'sales';
		$sales_items_table = "$tableprefix".'sales_items';
		$items_table = "$tableprefix".'items';
		$brands_table = "$tableprefix".'brands';
		$categories_table = "$tableprefix".'categories';
		$suppliers_table = "$tableprefix".'suppliers';
		$customer_table = "$tableprefix".'customers';
		$users_table = "$tableprefix".'users';

		if ($total_type == 'customers') {
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT $customer_table.first_name, $customer_table.last_name, $customer_table.account_number, $customer_table.phone_number, $customer_table.email, $customer_table.street_address, $customer_table.comments, $customer_table.id  FROM $customer_table,$sales_table WHERE $sales_table.status = 1 and $sales_table.tipo_vta = 1 and $customer_table.id = $sales_table.customer_id ORDER BY $customer_table.last_name";
			$customer_result = mysql_query($query,$this->conn);
			$temp_cust_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($customer_result)) {
				$temp_cust_id = $row['id'];
				$customer_name = $this->formatData('customer_id',$temp_cust_id,$tableprefix);
				$query2 = "SELECT * FROM $sales_table WHERE status = 1 and tipo_vta=1 AND customer_id=\"$temp_cust_id\" and date between \"$date1\" and \"$date2\"";
				$result2 = mysql_query($query2,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result2)) {
					$sub_total += $row2['sale_sub_total'];
					$accum_sub_total += $row2['sale_sub_total'];

					$total_cost += $row2['sale_total_cost'];
					$accum_total_cost += $row2['sale_total_cost'];

					$items_purchased += $row2['items_purchased'];
					$accum_items_purhcased += $row2['items_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$customer_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}: <b>$accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b>$this->currency_symbol$accum_total_cost</b></td></tr></table>";
		} elseif ($total_type == 'employees') {
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $users_table ORDER BY last_name";
			$employee_result = mysql_query($query,$this->conn);
			$temp_cust_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($employee_result)) {
				$temp_empl_id = $row['id'];
				$employee_name = $this->formatData('user_id',$temp_empl_id,$tableprefix);
				$query2 = "SELECT * FROM $sales_table WHERE status = 1 and tipo_vta=1 AND sold_by=\"$temp_empl_id\" and date between \"$date1\" and \"$date2\"";
				$result2 = mysql_query($query2,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result2)) {
					$sub_total += $row2['sale_sub_total'];
					$accum_sub_total += $row2['sale_sub_total'];

					$total_cost += $row2['sale_total_cost'];
					$accum_total_cost += $row2['sale_total_cost'];

					$items_purchased += $row2['items_purchased'];
					$accum_items_purhcased += $row2['items_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$employee_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";

		} elseif ($total_type == 'items') {
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='70%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $items_table ORDER BY item_name";
			$item_result = mysql_query($query,$this->conn);
			$temp_item_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($item_result)) {
				$temp_item_id = $row['id'];
				$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);
				$temp_brand = $this->idToField($brands_table,'brand',$this->idToField($items_table,
					'brand_id',$temp_item_id));
				$temp_category = $this->idToField($categories_table,'category',$this->idToField
					($items_table,'category_id',$temp_item_id));
				$temp_supplier = $this->idToField($suppliers_table,'supplier',$this->idToField($items_table,
					'supplier_id',$temp_item_id));

				$query2 = mysql_query("SELECT * FROM $sales_table WHERE status = 1 and tipo_vta=1 AND date between \"$date1\" and \"$date2\" ORDER by id ASC",
					$this->conn);
				$sale_row1 = mysql_fetch_assoc($query2);
				$low_sale_id = $sale_row1['id'];

				$query3 = mysql_query("SELECT * FROM $sales_table WHERE status = 1 and tipo_vta=1 AND date between \"$date1\" and \"$date2\" ORDER by id DESC",
					$this->conn);
				$sale_row2 = mysql_fetch_assoc($query3);
				$high_sale_id = $sale_row2['id'];

				$query4 = "SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
				$result4 = mysql_query($query4,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result4)) {
					$sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];
					$accum_sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];

					$total_cost += $row2['item_total_cost'];
					$accum_total_cost += $row2['item_total_cost'];

					$items_purchased += $row2['quantity_purchased'];
					$accum_items_purhcased += $row2['quantity_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>

		
			
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";
		} elseif ($total_type == 'item') {
			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $items_table WHERE $where1=\"$where2\" ORDER BY item_name";
			$item_result = mysql_query($query,$this->conn);
			$row = mysql_fetch_assoc($item_result);
			$temp_item_id = $row['id'];
			$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);
			$temp_brand = $this->idToField($brands_table,'brand',$this->idToField($items_table,
				'brand_id',$temp_item_id));
			$temp_category = $this->idToField($categories_table,'category',$this->idToField
				($items_table,'category_id',$temp_item_id));
			$temp_supplier = $this->idToField($suppliers_table,'supplier',$this->idToField($items_table,
				'supplier_id',$temp_item_id));

			$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);

			$query2 = mysql_query("SELECT * FROM $sales_table WHERE tipo_vta=1 AND date between \"$date1\" and \"$date2\" ORDER by id ASC",
				$this->conn);
			$sale_row1 = mysql_fetch_assoc($query2);
			$low_sale_id = $sale_row1['id'];

			$query3 = mysql_query("SELECT * FROM $sales_table WHERE tipo_vta=1 AND date between \"$date1\" and \"$date2\" ORDER by id DESC",
				$this->conn);
			$sale_row2 = mysql_fetch_assoc($query3);
			$high_sale_id = $sale_row2['id'];

			$query4 = "SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
			$result4 = mysql_query($query4,$this->conn);

			$sub_total = 0;
			$total_cost = 0;
			$items_purchased = 0;

			while ($row2 = mysql_fetch_assoc($result4)) {
				$sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];
				$total_cost += $row2['item_total_cost'];
				$items_purchased += $row2['quantity_purchased'];
			}

			$sub_total = number_format($sub_total,2,'.','');
			$total_cost = number_format($total_cost,2,'.','');

			echo "\n<tr bgcolor=$this->rowcolor1>\n";

			echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					
					
					</tr>";

			echo '</table>';

		} elseif ($total_type == 'profit') {

			echo "<center><b>{$this->lang->totalsShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT DISTINCT date FROM $sales_table WHERE status = 1 and tipo_vta=1 AND date between \"$date1\" and \"$date2\" ORDER by date ASC";
			$result = mysql_query($query);

			$amount_sold = 0;
			$profit = 0;
			$total_amount_sold = 0;
			$total_profit = 0;
			while ($row = mysql_fetch_assoc($result)) {

				$amount_sold = 0;
				$profit = 0;

				$distinct_date = $row['date'];
				$result2 = mysql_query("SELECT * FROM $sales_table WHERE status = 1 and tipo_vta=1 AND date=\"$distinct_date\"",
					$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";

				while ($row2 = mysql_fetch_assoc($result2)) {
					$amount_sold += $row2['sale_sub_total'];
					$total_amount_sold += $row2['sale_sub_total'];
					$profit += $this->getProfit($row2['id'],$tableprefix);
					$total_profit += $this->getProfit($row2['id'],$tableprefix);

				}

				$porcmargen = number_format(($profit / $amount_sold) * 100,2,'.','');
				$amount_sold = number_format($amount_sold,2,'.','');
				$profit = number_format($profit,2,'.','');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$profit</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$porcmargen</font>\n</td>";

				echo "</tr>";
			}

			echo '</table>';

			$total_amount_sold = number_format($total_amount_sold,2,'.','');
			$total_profit = number_format($total_profit,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalAmountSold}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	<tr><td>{$this->lang->totalProfit}: <b>$this->currency_symbol$total_profit</b></td></tr>
				 </table>";

		} elseif ($total_type == 'valpvpcost') {

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT item_name,item_number,description,supplier_id,buy_price,unit_price,quantity,id FROM  pos_items where id < 10";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$result2 = mysql_query("SELECT supplier FROM pos_suppliers WHERE id = ".$row['supplier_id'].
					" ",$this->conn);
				$row_2 = mysql_fetch_assoc($result2);

				if ($row['unit_price'] != 0)
					$margen = ($row['unit_price'] - $row['buy_price']) / $row['unit_price'] * 100;
				else
					$margen = 0;
				$tot_a_costo = $row['buy_price'] * $row['quantity'];
				$tot_a_veta = $row['unit_price'] * $row['quantity'];
				echo "\n<tr bgcolor=$this->rowcolor1>\n";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row['item_number']."</font>\n</td>";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row['item_name']."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row_2['supplier']."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['buy_price'],2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['unit_price'],2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($margen,2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['quantity'])."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($tot_a_costo,2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($tot_a_veta,2)."</font>\n</td>";

				echo "</tr>";

				$tot_costo += $row['buy_price'];
				$tot_pvp += $row['unit_price'];
				$tot_margen += $margen;
				$tot_quantity += $row['quantity'];
				$total_a_costo += $tot_a_costo;
				$total_a_vta += $tot_a_veta;
			}

			echo " <tr bgcolor=$this->rowcolor1>
    <td colspan='3' align='center'><b>Total</b></td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_costo,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_pvp,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_margen,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_quantity)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($total_a_costo,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($total_a_vta,2)."</td>
  </tr>";

			echo '</table>';

		}
	}
	////----------////
	function displayDispeTotalsReport($tableprefix,$total_type,$tableheaders,$date1,
		$date2,$where1,$where2)
	{
		$sales_table = "$tableprefix".'sales';
		$sales_items_table = "$tableprefix".'sales_items';
		$items_table = "$tableprefix".'items';
		$brands_table = "$tableprefix".'brands';
		$categories_table = "$tableprefix".'categories';
		$suppliers_table = "$tableprefix".'suppliers';
		$customer_table = "$tableprefix".'pacientes';
		$users_table = "$tableprefix".'users';

		if ($total_type == 'pos_pacientes') {
			echo "<center><b>{$this->lang->totaldShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			//$query = "SELECT * FROM $customer_table ORDER BY last_name";

			$query = "SELECT $customer_table.first_name, $customer_table.last_name, $customer_table.account_number, $customer_table.phone_number, $customer_table.email, $customer_table.street_address, $customer_table.comments, $customer_table.id  FROM $customer_table,$sales_table,$sales_items_table 
				WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0 AND $customer_table.id = $sales_table.customer_id GROUP BY $sales_table.customer_id  ORDER BY $customer_table.last_name";            
                                    
			$customer_result = mysql_query($query,$this->conn);
			$temp_cust_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($customer_result)) {
				$temp_cust_id = $row['id'];
				$customer_name = $this->formatData('paciente_id',$temp_cust_id,$tableprefix);
				//echo $customer_name;
				$query2 = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
				WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0  
				AND $sales_table.customer_id=\"$temp_cust_id\" and $sales_table.date between \"$date1\" and \"$date2\"
				GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";

				//$query2 = "SELECT * FROM $sales_table WHERE  tipo_vta=1 AND customer_id=\"$temp_cust_id\" and date between \"$date1\" and \"$date2\"";
				$result2 = mysql_query($query2,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result2)) {
					$sub_total += $row2['sale_sub_total'];
					$accum_sub_total += $row2['sale_sub_total'];

					$total_cost += $row2['sale_total_cost'];
					$accum_total_cost += $row2['sale_total_cost'];

					$items_purchased += $row2['items_purchased'];
					$accum_items_purhcased += $row2['items_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$customer_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}: <b>$accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b>$this->currency_symbol$accum_total_cost</b></td></tr></table>";
		} elseif ($total_type == 'employees') {
			echo "<center><b>{$this->lang->totaldShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $users_table ORDER BY last_name";
			$employee_result = mysql_query($query,$this->conn);
			$temp_cust_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($employee_result)) {
				$temp_empl_id = $row['id'];
				$employee_name = $this->formatData('user_id',$temp_empl_id,$tableprefix);
				$query2 = "SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
				WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 
				AND $sales_items_table.qtyrecetada > 0 AND $sales_items_table.quantity_purchased > 0  
				AND $sales_table.sold_by=\"$temp_empl_id\" and $sales_table.date between \"$date1\" and \"$date2\"
				GROUP BY $sales_table.id ORDER BY $sales_table.id DESC";

				//$query2 = "SELECT * FROM $sales_table WHERE sold_by=\"$temp_empl_id\" and date between \"$date1\" and \"$date2\"";
				$result2 = mysql_query($query2,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result2)) {
					$sub_total += $row2['sale_sub_total'];
					$accum_sub_total += $row2['sale_sub_total'];

					$total_cost += $row2['sale_total_cost'];
					$accum_total_cost += $row2['sale_total_cost'];

					$items_purchased += $row2['items_purchased'];
					$accum_items_purhcased += $row2['items_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$employee_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";

		} elseif ($total_type == 'items') {
			echo "<center><b>{$this->lang->totaldShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='70%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $items_table ORDER BY item_name";
			$item_result = mysql_query($query,$this->conn);
			$temp_item_id = 0;

			$accum_sub_total = 0;
			$accum_total_cost = 0;
			$accum_items_purhcased = 0;
			$row_counter = 0;
			while ($row = mysql_fetch_assoc($item_result)) {
				$temp_item_id = $row['id'];
				$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);
				$temp_brand = $this->idToField($brands_table,'brand',$this->idToField($items_table,
					'brand_id',$temp_item_id));
				$temp_category = $this->idToField($categories_table,'category',$this->idToField
					($items_table,'category_id',$temp_item_id));
				$temp_supplier = $this->idToField($suppliers_table,'supplier',$this->idToField($items_table,
					'supplier_id',$temp_item_id));
				$query2 = mysql_query("SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
				WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0 
				AND $sales_table.date between \"$date1\" and \"$date2\"
				AND $sales_items_table.quantity_purchased > 0 GROUP BY $sales_table.id ORDER BY $sales_table.id ASC",
					$this->conn);
				//$query2 = mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id ASC",
				$sale_row1 = mysql_fetch_assoc($query2);
				$low_sale_id = $sale_row1['id'];
				$query3 = mysql_query("SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
				WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0 
				AND $sales_table.date between \"$date1\" and \"$date2\"
				AND $sales_items_table.quantity_purchased > 0 GROUP BY $sales_table.id ORDER BY $sales_table.id DESC",
					$this->conn);
				//$query3 = mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id DESC",
				$sale_row2 = mysql_fetch_assoc($query3);
				$high_sale_id = $sale_row2['id'];

				$query4 = "SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
				$result4 = mysql_query($query4,$this->conn);

				$sub_total = 0;
				$total_cost = 0;
				$items_purchased = 0;

				while ($row2 = mysql_fetch_assoc($result4)) {
					$sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];
					$accum_sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];

					$total_cost += $row2['item_total_cost'];
					$accum_total_cost += $row2['item_total_cost'];

					$items_purchased += $row2['quantity_purchased'];
					$accum_items_purhcased += $row2['quantity_purchased'];
				}
				$row_counter++;

				$sub_total = number_format($sub_total,2,'.','');
				$total_cost = number_format($total_cost,2,'.','');

				if ($row_counter % 2 == 0) {
					echo "\n<tr bgcolor=$this->rowcolor1>\n";
				} else {
					echo "\n<tr bgcolor=$this->rowcolor2>\n";
				}

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>

		
			
					 </tr>";
			}
			echo '</table>';
			$accum_sub_total = number_format($accum_sub_total,2,'.','');
			$accum_total_cost = number_format($accum_total_cost,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalItemsPurchased}:<b> $accum_items_purhcased</b></td></tr>
			 	<tr><td>{$this->lang->totalWithOutTax}: <b>$this->currency_symbol$accum_sub_total</b></td></tr>
				 <tr><td>{$this->lang->totalWithTax}: <b> $this->currency_symbol$accum_total_cost</b></td></tr></table>";
		} elseif ($total_type == 'item') {
			echo "<center><b>{$this->lang->totaldShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT * FROM $items_table WHERE $where1=\"$where2\" ORDER BY item_name";
			$item_result = mysql_query($query,$this->conn);
			$row = mysql_fetch_assoc($item_result);
			$temp_item_id = $row['id'];
			$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);
			$temp_brand = $this->idToField($brands_table,'brand',$this->idToField($items_table,
				'brand_id',$temp_item_id));
			$temp_category = $this->idToField($categories_table,'category',$this->idToField
				($items_table,'category_id',$temp_item_id));
			$temp_supplier = $this->idToField($suppliers_table,'supplier',$this->idToField($items_table,
				'supplier_id',$temp_item_id));

			$item_name = $this->formatData('item_id',$temp_item_id,$tableprefix);
			$query2 = mysql_query("SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
			WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0
			AND $sales_items_table.quantity_purchased > 0 
			AND $sales_table.date between \"$date1\" and \"$date2\"
			GROUP BY $sales_table.id ORDER BY $sales_table.id ASC",$this->conn);
			//$query2 = mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id ASC",
			//$this->conn);
			$sale_row1 = mysql_fetch_assoc($query2);
			$low_sale_id = $sale_row1['id'];
			$query3 = mysql_query("SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta  FROM $sales_table,$sales_items_table 
			WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0
			AND $sales_items_table.quantity_purchased > 0 
			AND $sales_table.date between \"$date1\" and \"$date2\"
			GROUP BY $sales_table.id ORDER BY $sales_table.id DESC",$this->conn);
			//$query3 = mysql_query("SELECT * FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by id DESC",
			//$this->conn);
			$sale_row2 = mysql_fetch_assoc($query3);
			$high_sale_id = $sale_row2['id'];

			$query4 = "SELECT * FROM $sales_items_table WHERE item_id=\"$temp_item_id\" and sale_id between \"$low_sale_id\" and \"$high_sale_id\"";
			$result4 = mysql_query($query4,$this->conn);

			$sub_total = 0;
			$total_cost = 0;
			$items_purchased = 0;

			while ($row2 = mysql_fetch_assoc($result4)) {
				$sub_total += $row2['item_total_cost'] - $row2['item_total_tax'];
				$total_cost += $row2['item_total_cost'];
				$items_purchased += $row2['quantity_purchased'];
			}

			$sub_total = number_format($sub_total,2,'.','');
			$total_cost = number_format($total_cost,2,'.','');

			echo "\n<tr bgcolor=$this->rowcolor1>\n";

			echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$item_name</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_brand</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_category</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$temp_supplier</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$items_purchased</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$sub_total</font>\n</td>
					<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$total_cost</font>\n</td>
					
					
					</tr>";

			echo '</table>';

		} elseif ($total_type == 'profit') {

			echo "<center><b>{$this->lang->totaldShownBetween} $date1 {$this->lang->and} $date2</b></center>";
			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";
			$query = "SELECT DISTINCT $sales_table.date
			FROM $sales_table,$sales_items_table 
			WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0
			AND $sales_items_table.quantity_purchased > 0
			AND $sales_table.date between \"$date1\" and \"$date2\"
			GROUP BY $sales_table.id ORDER BY $sales_table.id ASC";

			//$query = "SELECT DISTINCT date FROM $sales_table WHERE date between \"$date1\" and \"$date2\" ORDER by date ASC";
			$result = mysql_query($query);

			$amount_sold = 0;
			$profit = 0;
			$total_amount_sold = 0;
			$total_profit = 0;
			while ($row = mysql_fetch_assoc($result)) {

				$amount_sold = 0;
				$profit = 0;

				$distinct_date = $row['date'];
				$result2 = mysql_query("SELECT $sales_table.id, $sales_table.date, $sales_table.customer_id as paciente_id, $sales_table.sale_sub_total, $sales_table.sale_total_cost, $sales_table.paid_with, $sales_table.items_purchased, $sales_table.sold_by, $sales_table.comment, $sales_table.changee, $sales_table.invoicenumber, $sales_table.status, $sales_table.descuentporc, $sales_table.value_discount, $sales_table.tipo_vta 
		    FROM $sales_table,$sales_items_table 
			WHERE $sales_table.id = $sales_items_table.sale_id AND $sales_table.tipo_vta = 2 AND $sales_items_table.tipo = 2 AND $sales_items_table.qtyrecetada > 0
			AND $sales_items_table.quantity_purchased > 0 
			AND $sales_table.date=\"$distinct_date\"
			GROUP BY $sales_table.id ORDER BY $sales_table.id DESC",$this->conn);
				//$result2 = mysql_query("SELECT * FROM $sales_table WHERE date=\"$distinct_date\"",
				//$this->conn);

				echo "\n<tr bgcolor=$this->rowcolor1>\n";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$distinct_date</font>\n</td>";

				while ($row2 = mysql_fetch_assoc($result2)) {
					$amount_sold += $row2['sale_sub_total'];
					$total_amount_sold += $row2['sale_sub_total'];
					$profit += $this->getProfit($row2['id'],$tableprefix);
					$total_profit += $this->getProfit($row2['id'],$tableprefix);

				}

				$porcmargen = number_format(($profit / $amount_sold) * 100,2,'.','');
				$amount_sold = number_format($amount_sold,2,'.','');
				$profit = number_format($profit,2,'.','');

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$amount_sold</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$profit</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$this->currency_symbol$porcmargen</font>\n</td>";

				echo "</tr>";
			}

			echo '</table>';

			$total_amount_sold = number_format($total_amount_sold,2,'.','');
			$total_profit = number_format($total_profit,2,'.','');

			echo "<br><table align='right' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='60%' border=0>";
			echo "<tr><td>{$this->lang->totalAmountSold}: <b>$this->currency_symbol$total_amount_sold</b></td></tr>
			 	<tr><td>{$this->lang->totalProfit}: <b>$this->currency_symbol$total_profit</b></td></tr>
				 </table>";

		} elseif ($total_type == 'valpvpcost') {

			echo "<table align='center' cellspacing='$this->cellspacing' cellpadding='$this->cellpadding' bgcolor='$this->table_bgcolor' width='40%' style=\"border: $this->border_style $this->border_color $this->border_width px\">";

			echo "<tr bgcolor=$this->header_rowcolor>\n\n";

			for ($k = 0; $k < count($tableheaders); $k++) {
				echo "<th align='center'>\n<font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>$tableheaders[$k]</font>\n</th>\n";
			}

			echo '</tr>'."\n\n";

			$query = "SELECT item_name,item_number,description,supplier_id,buy_price,unit_price,quantity,id FROM  pos_items where id < 10";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				$result2 = mysql_query("SELECT supplier FROM pos_suppliers WHERE id = ".$row['supplier_id'].
					" ",$this->conn);
				$row_2 = mysql_fetch_assoc($result2);

				if ($row['unit_price'] != 0)
					$margen = ($row['unit_price'] - $row['buy_price']) / $row['unit_price'] * 100;
				else
					$margen = 0;
				$tot_a_costo = $row['buy_price'] * $row['quantity'];
				$tot_a_veta = $row['unit_price'] * $row['quantity'];
				echo "\n<tr bgcolor=$this->rowcolor1>\n";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row['item_number']."</font>\n</td>";

				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row['item_name']."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					$row_2['supplier']."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['buy_price'],2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['unit_price'],2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($margen,2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($row['quantity'])."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($tot_a_costo,2)."</font>\n</td>";
				echo "<td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
					number_format($tot_a_veta,2)."</font>\n</td>";

				echo "</tr>";

				$tot_costo += $row['buy_price'];
				$tot_pvp += $row['unit_price'];
				$tot_margen += $margen;
				$tot_quantity += $row['quantity'];
				$total_a_costo += $tot_a_costo;
				$total_a_vta += $tot_a_veta;
			}

			echo " <tr bgcolor=$this->rowcolor1>
    <td colspan='3' align='center'><b>Total</b></td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_costo,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_pvp,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_margen,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($tot_quantity)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($total_a_costo,2)."</td>
    <td align='center'>\n<font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>".
				number_format($total_a_vta,2)."</td>
  </tr>";

			echo '</table>';

		}
	}
	////----------////

	function getProfit($sale_id,$tableprefix)
	{
		$sales_items_table = "$tableprefix".'sales_items';
		$query = "SELECT * FROM $sales_items_table WHERE sale_id=\"$sale_id\"";
		$result = mysql_query($query,$this->conn);

		$profit = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$profit += ($row['item_unit_price'] - $row['item_buy_price']) * $row['quantity_purchased'];
		}

		return $profit;
	}

	function formatData($field,$data,$tableprefix)
	{
		if ($field == 'unit_price' or $field == 'total_cost' or $field == 'buy_price' or
			$field == 'sale_sub_total' or $field == 'sale_total_cost' or $field ==
			'item_unit_price' or $field == 'item_total_cost' or $field == 'item_total_tax') {
			return "$this->currency_symbol"."$data";
		} elseif ($field == 'tax_percent' or $field == 'percent_off') {
			return "$data".'%';
		} elseif ($field == 'brand_id') {
			return $this->idToField("$tableprefix".'brands','brand',$data);
		} elseif ($field == 'category_id') {
			return $this->idToField("$tableprefix".'categories','category',$data);
		} elseif ($field == 'supplier_id') {
			return $this->idToField("$tableprefix".'suppliers','supplier',$data);
		} elseif ($field == 'customer_id') {
			$field_first_name = $this->idToField("$tableprefix".'customers','first_name',$data);
			$field_last_name = $this->idToField("$tableprefix".'customers','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		} elseif ($field == 'paciente_id') {
			$field_first_name = $this->idToField("$tableprefix".'pacientes','first_name',$data);
			$field_last_name = $this->idToField("$tableprefix".'pacientes','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		} elseif ($field == 'user_id') {
			$field_first_name = $this->idToField("$tableprefix".'users','first_name',$data);
			$field_last_name = $this->idToField("$tableprefix".'users','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		} elseif ($field == 'item_id') {
			return $this->idToField("$tableprefix".'items','item_name',$data);
		} elseif ($field == 'sold_by') {
			$field_first_name = $this->idToField("$tableprefix".'users','first_name',$data);
			$field_last_name = $this->idToField("$tableprefix".'users','last_name',$data);
			return $field_first_name.' '.$field_last_name;
		} elseif ($field == 'supplier_id') {
			return $this->idToField("$tableprefix".'suppliers','supplier',$data);
		} elseif ($field == 'sales_id') {
			return $this->idToField("$tableprefix".'sales_paywith','supplier',$data);
		} elseif ($field == 'paymethod_id') {
			return $this->idToField("$tableprefix".'sales_paywith','supplier',$data);
		} elseif ($field == 'password') {
			return '*******';

		} else {
			return "$data";
		}



	}

}
?>
