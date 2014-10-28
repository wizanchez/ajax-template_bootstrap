<?php

class db_functions
{	
	//class variable that represents the database connection.
	var $conn;
	var $lang;
	var $tblprefix;
	
	var $table_bgcolor,$cellspacing,$cellpadding,$border_style,$border_width,
	$border_color,$header_rowcolor,$header_text_color,$headerfont_face,$headerfont_size,
	$rowcolor,$rowcolor2,$rowcolor_text,$rowfont_face,$rowfont_size;
	
	//user-defined constructor
	function db_functions($server,$username,$password,$database,$tableprefix,$theme,$language)
	{
		//pre: parameters must be correct in order to connect to database.
		//post: connects to database.
		$this->tblprefix=$tableprefix;
		$this->lang=$language;
		$this->conn = mysql_connect("$server", "$username", "$password") or die("Could not connecta : " . mysql_error());
		mysql_select_db("$database",$this->conn) or die("Could not select database <b>$database</b>");
		
		switch($theme)
		{
			//add more themes
			
			case $theme=='serious':
				$this->table_bgcolor='white';
				$this->cellspacing='1';
				$this->cellpadding='0';
				$this->border_style='solid';
				$this->border_width='1';
				$this->border_color='black';
				
				$this->header_rowcolor='black';
				$this->header_text_color='white';
				$this->headerfont_face='arial';
				$this->headerfont_size='2';

				
				$this->rowcolor='#DDDDDD';
				$this->rowcolor_text='black';
				$this->rowfont_face='geneva';
				$this->rowfont_size='2';
			break;
			
			case $theme=='big blue':
			
				$this->table_bgcolor='white';
				$this->cellspacing='1';
				$this->cellpadding='0';
				$this->border_style='solid';
				$this->border_width='1';
				$this->border_color='black';
				
				$this->header_rowcolor='navy';
				$this->header_text_color='white';
				$this->headerfont_face='arial';
				$this->headerfont_size='2';

				
				$this->rowcolor='#15759B';
				$this->rowcolor_text='white';
				$this->rowfont_face='geneva';
				$this->rowfont_size='2';
				
				
			break;
		
		}
	}
	
	function getUserID($username,$password)
	{
		//pre: $username is a string and $password (encrypted) is the user's encrypted password.
		//post: returns the id of the user with the specific username and password supplied.
		
		$tablename = "$this->tblprefix".'users';
		$result = mysql_query("SELECT * FROM $tablename WHERE username=\"$username\" and password=\"$password\"",$this->conn);
		$row = mysql_fetch_assoc($result);
		
		return $row['id'];
	}
	
	function getAllElements($tablename,$field,$orderby)
	{
		//pre: $tablename,$field,$orderby must be valid
		/*post: returns all elements in an array of specified table
		and sets first position to an empty string.  This function will be used for filling
		select fields, which requires the first position for the selected value
		*/
		
		$result = mysql_query("SELECT $field FROM $tablename ORDER BY $orderby",$this->conn);
		$numRows = mysql_num_rows($result);
		$data = array();
		
		$data[0]='';
		for($k=1; $k< $numRows+1; $k++)
		{
			$data[$k]= mysql_result($result,$k-1);	
			
		}
		
		return $data;
	}

	function getElements($tablename,$view,$field,$value,$orderby,$limit)
	{
		//pre: $tablename,$field,$orderby must be valid
		/*post: returns all elements in an array of specified table
		and sets first position to an empty string.  This function will be used for filling
		select fields, which requires the first position for the selected value
		*/
        //echo "SELECT $view FROM $tablename WHERE $field $value ORDER BY $orderby $limit";
		$result = mysql_query("SELECT $view FROM $tablename WHERE $field $value ORDER BY $orderby $limit",$this->conn);
		$numRows = mysql_num_rows($result);
		$data = array();
		
//		$data[0]='';
//		while ($result = mysql_fetch_assoc($result)) {
//		{
//			$data[$k]= mysql_result($result,$k-1);	
//			
//		}
		
		return $result;
	}
	
	function idToField($tablename,$field,$id)
	{
		//pre: $tablename, field, and id all must be valid
		//post: returns a specified field based on the ID from a specified table.
		
		$result = mysql_query("SELECT $field FROM $tablename WHERE id=\"$id\"",$this->conn);
		
		$row = mysql_fetch_assoc($result);
		
		return $row[$field];
	}
	
	function fieldToid($tablename,$field,$value)
	{
		//pre: $tablename, field, and value all must be valid
		//post: returns a specified id based on the field from a specified table.

		$result = mysql_query("SELECT * FROM $tablename WHERE $field=\"$value\"",$this->conn);
		
		$row=mysql_fetch_assoc($result);
		
		return $row['id'];

	}
	
	function getFields($database,$tablename)
	{	
		//returns fields in table
	
		$fields=array();
		$fieldsRef=mysql_list_fields ($database, $tablename);
		$columns=mysql_num_fieldsfieldsRef;
		
		for($k=0;$k<$columns;$k++)
		{
			$fields[]=mysql_field_name($fieldsRef,$k);
		}

		return $fields;
	}
	
	function insert($field_names,$field_data,$tablename,$output)
	{
		//pre: $field_names and $field_data are pararell arrays and $tablename is a string.
		//post: creates a query then executes it.
		
		if(!($this->isValidData($field_data)))
		{
			echo "{$this->lang->invalidCharactor}";
			exit();
		}
		
		$query = "INSERT INTO $tablename ($field_names[0]";
			
		for($k=1;$k< count($field_names);$k++)
		{
			$query.=', '."$field_names[$k]";
		
		}
		
		$query.=") VALUES (\"$field_data[0]\"";
		
		for($k=1;$k< count($field_data);$k++)
		{
			$query.=', '."\"$field_data[$k]\"";
		
		}
			$query.=')';
			mysql_query($query,$this->conn);
			
			
			if($output)
			{
				echo "<center><b>{$this->lang->successfullyAdded} $tablename</b></center><br>";
				
				echo "<center><table width=350 cellspacing=$this->cellspacing cellpadding=$this->cellpadding bgcolor=$this->table_bgcolor style=\"border: $this->border_style $this->border_color $this->border_width px\">
				<tr bgcolor=$this->header_rowcolor>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->field}</th></font>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->data}</th></font>
				</tr>";
				for($k=0;$k<count($field_names);$k++)
				{
					//certain fields I do not want displayed.
					if($field_names[$k]!="password")
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_data[$k]</font></td></tr>\n";
					}
					else
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>*******</font></td></tr>\n";
					
					}
				}
				echo '</table></center>';
	
			}
		}
	
	
	
	function update($field_names,$field_data,$tablename,$id,$output)
	{
		//pre: $field_names and $field_data are pararell arrays and tablename and id are strings.
		//post: creates a query then executes it limites based on id.
		
		if($id=='')
		{
			echo "{$this->lang->didNotEnterID}";
			exit();
		}
		if(!($this->isValidData($field_data)))
		{
			echo "{$this->lang->invalidCharactor}";
			exit();
		}
			$query="UPDATE $tablename SET $field_names[0]=\"$field_data[0]\"";
			
		for($k=1;$k< count($field_names);$k++)
		{
			$query.=', '."$field_names[$k]=\"$field_data[$k]\"";
		
		}
		
			$sales_items_table=$this->tblprefix.'sales_items';
			if($output)
			{
				$query.=" WHERE id=\"$id\"";
			}
			else
			{
				$query.=" WHERE sale_id=\"$id\"";
			}
			
					
			mysql_query($query,$this->conn);
	
	
		if($output)
		{
			echo "<center><b>{$this->lang->successfullyUpdated} $tablename</b></center><br>";
				
				echo "<center><table width=350 cellspacing=$this->cellspacing cellpadding=$this->cellpadding bgcolor=$this->table_bgcolor style=\"border: $this->border_style $this->border_color $this->border_width px\">
				<tr bgcolor=$this->header_rowcolor>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->field}</th></font>
				<th align='left'><font color='$this->header_text_color' face='$this->headerfont_face' size='$this->headerfont_size'>{$this->lang->data}</th></font>
				</tr>";
				for($k=0;$k<count($field_names);$k++)
				{
					//certain fields I do not want displayed.
					if($field_names[$k]!="password")
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_data[$k]</font></td></tr>\n";
					}
					else
					{
						echo "<tr bgcolor=$this->rowcolor><td width='120'><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>$field_names[$k]". '</font></td>'."<td><font color='$this->rowcolor_text' face='$this->rowfont_face' size='$this->rowfont_size'>*******</font></td></tr>\n";
					
					}
				}
				echo '</table></center>';
	
		}
	}	
	
	function deleteRow($tablename,$id)
	{
		//pre: $tablename and id are strings.
		//post: Does extensive error checking and then deletes row is allowed.
		
		if($this->tblprefix=='')
		{
			$baseTable=$tablename;
		}
		else
		{
			$splitTable= explode ("$this->tblprefix",$tablename);
			$baseTable=$splitTable[1];
		}
			
		$canDelete=true;
		$errmessage='';
		
		if($id=='')
		{
			echo "{$this->lang->didNotEnterID}";
			exit();
		}
		elseif($baseTable=='brands')
		{

			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT brand_id FROM $checkTable WHERE brand_id=\"$id\"",$this->conn);
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteBrand}";

			} 	
		
		}
		elseif($baseTable=='categories')
		{
			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT category_id FROM $checkTable WHERE category_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;	
				$errmessage="{$this->lang->cantDeleteCategory}";

			} 	
		
		}
		elseif($baseTable=='customers')
		{
			$checkTable = "$this->tblprefix".'sales';
			$result = mysql_query("SELECT customer_id FROM $checkTable WHERE customer_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteCustomer}";
			} 	
		
		}
		elseif($baseTable=='items')
		{
			$checkTable = "$this->tblprefix".'sales_items';
			$result = mysql_query("SELECT item_id FROM $checkTable WHERE item_id=\"$id\"",$this->conn);
			
			if(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteItem}";
			} 	
		
		}
		elseif($baseTable=='suppliers')
		{

			$checkTable = "$this->tblprefix".'items';
			$result = mysql_query("SELECT supplier_id FROM $checkTable WHERE supplier_id=\"$id\"",$this->conn);
			if(@mysql_num_rows($result) >= 1)
			{ 
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteSupplier}";

			} 	
		
		}
		elseif($baseTable=='sales')
		{
			$sales_items_table="$this->tblprefix".'sales_items';
			$items_table="$this->tblprefix".'items';
			$result=mysql_query("SELECT * FROM $sales_items_table WHERE sale_id=\"$id\"");
			
			while($row=mysql_fetch_assoc($result))
			{
				$quantityToAdd =$row['quantity_purchased'];
				$newQuantity=$this->idToField($items_table,'quantity',"$row[item_id]")+$quantityToAdd;
				$this->updateItemQuantity($row['item_id'],$newQuantity);
			}
		    mysql_query("DELETE FROM $sales_items_table WHERE sale_id=\"$id\"",$this->conn);	
		}
		elseif($baseTable=='users')
		{
			
			$checkTable = "$this->tblprefix".'sales';

			$result = mysql_query("SELECT sold_by FROM $checkTable WHERE sold_by=\"$id\"",$this->conn);
			if($_SESSION['session_user_id']==$id)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteUserLoggedIn}";
	

			}
			elseif(@mysql_num_rows($result) >= 1)
			{
				$canDelete=false;
				$errmessage="{$this->lang->cantDeleteUserEnteredSales}";
			}
			
			
				
		} 	
		
		if($canDelete==true)
		{
			$query="DELETE FROM $tablename WHERE id=\"$id\"";
			mysql_query($query,$this->conn);
	
			echo "<center>{$this->lang->successfullyDeletedRow} <b>$id</b> {$this->lang->fromThe} <b>$tablename</b> {$this->lang->table}</center>";
		}
		else
		{
			echo "<center>$errmessage</center><br>";
		}
	}
	
	
	function isValidData($data_to_check)
	{
		//checks data for errors
	
		for($k=0;$k<count($data_to_check);$k++)
		{
			if(ereg('\"',$data_to_check[$k]) or ereg('<',$data_to_check[$k]) or ereg('>',$data_to_check[$k]) )
			{
				return false;
			}
		}
		
		return true;
	
	}
	
	function isValidItem($item)
	{
		$table=$this->tblprefix.'items';
		$result=mysql_query("SELECT id FROM $table WHERE item_number=\"$item\" and active = 1",$this->conn);
		
		if(mysql_num_rows($result)==0)
		{
			return false;
		}
		
		return true;
	}
	
	function isItemOnDiscount($itemID)
	{
		$table=$this->tblprefix.'discounts';
		$query="SELECT item_id FROM $table WHERE item_id=\"$itemID\"";
		$result=mysql_query($query,$this->conn);
		
		if(mysql_num_rows($result) >0)
		{
			return true;
		}
		return false;

	}
	
	function getPercentDiscount($itemID)
	{
		$table=$this->tblprefix.'discounts';
		$query="SELECT percent_off FROM $table WHERE item_id=\"$itemID\"";
		$result=mysql_query($query,$this->conn);
		
		if(mysql_num_rows($result) >0)
		{
			$row=mysql_fetch_assoc($result);
			return $row['percent_off'];
		}
		return -1;
	}
	
	function getDiscountedPrice($itemID)
	{
		$itemtable=$this->tblprefix.'items';
		$discounttable=$this->tblprefix.'discounts';
		
		$query1="SELECT * FROM $discounttable WHERE item_id=\"$itemID\"";
		$row=mysql_fetch_assoc(mysql_query($query1,$this->conn));
		$percent_off=$row['percent_off'];
		
		$query2="SELECT * FROM $itemtable WHERE id=\"$itemID\"";
		$row=mysql_fetch_assoc(mysql_query($query2,$this->conn));
		$discounted_price=$row['unit_price']*(1-($percent_off/100));
		
		return number_format($discounted_price,2,'.', '');

		

	}
	
	function isValidCustomer($customer)
	{
		$table=$this->tblprefix.'customers';
		$result=mysql_query("SELECT id FROM $table WHERE id=\"$customer\"",$this->conn);
		
		if(mysql_num_rows($result)==0)
		{
			return false;
		}
		
		return true;
	}
		
	function getNumRows($table)
	{
		//gets the number of rows in a table
		
		$query="SELECT id FROM $table";
		$result=mysql_query($query,$this->conn);
		
		return mysql_num_rows($result);
	
	}
	
	
	
	function updateSaleTotals($sale_id)
	{
		//updates the totals for a sale
		
		$sales_items_table=$this->tblprefix.'sales_items';
		$sales_table=$this->tblprefix.'sales';
		
		$query="SELECT item_total_cost,item_total_tax,quantity_purchased FROM $sales_items_table WHERE sale_id=\"$sale_id\"";
		
		$result=mysql_query($query,$this->conn);
		
		
		
		if(@mysql_num_rows($result) > 0)
		{
			$sale_sub_total=0;
			$sale_total_cost=0;
			$items_purchased=0;
		
			while($row=mysql_fetch_assoc($result))
			{
				$sale_sub_total+=$row['item_total_cost']-$row['item_total_tax'];
				$sale_total_cost+=$row['item_total_cost'];
				$items_purchased+=$row['quantity_purchased'];
			}
			
			$sale_sub_total=number_format($sale_sub_total,2,'.', '');
			$sale_total_cost=number_format($sale_total_cost,2,'.', '');
			
			$query2="UPDATE $sales_table SET sale_sub_total=\"$sale_sub_total\",sale_total_cost=\"$sale_total_cost\",items_purchased=\"$items_purchased\" WHERE id=\"$sale_id\"";
			mysql_query($query2,$this->conn);
		}
		else
		{
			$this->deleteRow($sales_table,$sale_id);	
		}
	}
	
	function updateItemQuantity($item_id,$newQuantity)
	{
		$items_table=$this->tblprefix.'items';
		$query="UPDATE $items_table SET quantity=\"$newQuantity\" WHERE id=\"$item_id\"";
		mysql_query($query,$this->conn);
		
	}
	
	function optimizeTables()
	{
		//optimizes the sales
		
		$tableprefix=$this->tblprefix;
		$brandsTable="$tableprefix".'brands';
		$categorieTable="$tableprefix".'categories';
		$customersTable="$tableprefix".'customers';
		$itemsTable="$tableprefix".'items';
		$salesTable="$tableprefix".'sales';
		$sales_itemsTable="$tableprefix".'sales_items';
		$suppliersTable="$tableprefix".'suppliers';
		$usersTable="$tableprefix".'users';

		$query="OPTIMIZE TABLE $brandsTable, $categorieTable, $customersTable, $itemsTable, $salesTable, $sales_itemsTable,$suppliersTable, $usersTable";
		mysql_query($query,$this->conn);
	}
	
	
	function closeDBlink()
	{
		mysql_close($this->conn);
	}
	
function ventasCategoriaFecha($fechaInicial,$fechaFinal)
	{
		//pre: $tablename,$field,$orderby must be valid
		/*post: returns all elements in an array of specified table
		and sets first position to an empty string.  This function will be used for filling
		select fields, which requires the first position for the selected value
		*/
		$SQL = 'SELECT 
					SUM(pos_sales_items.quantity_purchased*pos_sales_items.item_unit_price) AS venta, 
					SUM(pos_sales_items.quantity_purchased) AS cantidad, 
					pos_items.category_id AS categoria, 
					pos_sales.date AS fecha,
					CONCAT(ELT(WEEKDAY(pos_sales.date) + 1, "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo")) AS DIA_SEMANA 
				FROM pos_sales JOIN pos_sales_items ON pos_sales_items.sale_id=pos_sales.id JOIN pos_items ON pos_items.id=pos_sales_items.item_id
				WHERE pos_sales.status=1 AND pos_sales.date BETWEEN "'.$fechaInicial.'" AND "'.$fechaFinal.'"
				GROUP BY pos_sales.date, pos_items.category_id
				ORDER BY pos_sales.date, pos_items.category_id
				';
		$result = mysql_query($SQL,$this->conn);
		$numRows = mysql_num_rows($result);
		$data = array();
		
		for($k=0; $k< $numRows; $k++)
		{
			$data[$k]['venta']= mysql_result($result,$k,'venta');	
			$data[$k]['cantidad']= mysql_result($result,$k,'cantidad');
			$data[$k]['fecha']= mysql_result($result,$k,'fecha');
			$data[$k]['categoria']= mysql_result($result,$k,'categoria');
			$data[$k]['dia']= mysql_result($result,$k,'DIA_SEMANA');
		}
		
		$cantidadRegistros = count($data);
		$j=0;
		for($i=0;$i<$cantidadRegistros;$i++){

			switch ($data[$i]['categoria']) {
				case '1':
					$resultado[$j]['cantidad1']=$data[$i]['cantidad'];
					$resultado[$j]['venta1']=$data[$i]['venta'];
					break;
				case '2':
					$resultado[$j]['cantidad2']=$data[$i]['cantidad'];
					$resultado[$j]['venta2']=$data[$i]['venta'];
					break;
				case '3':
					$resultado[$j]['cantidad3']=$data[$i]['cantidad'];
					$resultado[$j]['venta3']=$data[$i]['venta'];
					break;
				case '4':
					$resultado[$j]['cantidad4']=$data[$i]['cantidad'];
					$resultado[$j]['venta4']=$data[$i]['venta'];
					break;
				case '5':
					$resultado[$j]['cantidad5']=$data[$i]['cantidad'];
					$resultado[$j]['venta5']=$data[$i]['venta'];
					break;
				case '6':
					$resultado[$j]['cantidad6']=$data[$i]['cantidad'];
					$resultado[$j]['venta6']=$data[$i]['venta'];
					break;
					case '7':
					$resultado[$j]['cantidad7']=$data[$i]['cantidad'];
					$resultado[$j]['venta7']=$data[$i]['venta'];
					break;
					case '8':
					$resultado[$j]['cantidad8']=$data[$i]['cantidad'];
					$resultado[$j]['venta8']=$data[$i]['venta'];
					break;
					case '9':
					$resultado[$j]['cantidad9']=$data[$i]['cantidad'];
					$resultado[$j]['venta9']=$data[$i]['venta'];
					break;
					case '10':
					$resultado[$j]['cantidad10']=$data[$i]['cantidad'];
					$resultado[$j]['venta10']=$data[$i]['venta'];
					break;
			}
			if($data[$i]['fecha']!=$data[$i+1]['fecha']){
				$resultado[$j]['fecha']=$data[$i]['fecha'];
				$resultado[$j]['dia']=$data[$i]['dia'];
				$j++;
			}
		}
		return $resultado;
	}

}

?>