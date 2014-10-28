<?php 
	set_time_limit(5000);
	require_once ("settings_erp.php");
	require_once ("../settings.php");
	require_once ("../Connections/conexion.php");
	require_once ("../classes/db_functions.php");
	$imagenes='sales/cargando.gif';
	global $cfg_locationid;
	if($_REQUEST['actionID']=='VER'){
	echo 'BODEGA ='.$cfg_locationid.'<br>';
	print '<img src="'.$imagenes.'"><br>';
	}
	$INSERT=array();
	$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);

	$conn_erp = mysql_connect($cfg_server_erp,$cfg_username_erp,$cfg_password_erp) or die("Could not connecta : ".mysql_error());
	mysql_select_db($cfg_database_erp,$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");

//[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[			

	$itemlocation = mysql_query('SELECT itemlocation.id,
								itemlocation.itemid, 
								itemlocation.onhandqty, 
								item.itemcode,
								itemlocation.nlastcost,
								item.catalogdescription
								FROM itemlocation Inner Join item ON itemlocation.itemid = item.id
								WHERE itemlocation.inventorylocationid = '.$cfg_locationid,$conn_erp);
	while ($rowdel_itemlocation = mysql_fetch_assoc($itemlocation)) {//1
		$INSERT['id_itemlocation']	=$rowdel_itemlocation['id'];
		$INSERT['itemid']				=$rowdel_itemlocation['itemid'];
		$INSERT['onhandqty']			=$rowdel_itemlocation['onhandqty'];
		$INSERT['itemcode']			=$rowdel_itemlocation['itemcode'];
		$INSERT['ultimo_costo']		=$rowdel_itemlocation['nlastcost'];
		$INSERT['descrp_larga']		=$rowdel_itemlocation['catalogdescription'];
//[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[			
			
		$SQL = "SELECT id,item_number FROM pos_items WHERE item_number =".$INSERT['itemcode'];
		$respta = mysql_query($SQL,$dbf->conn);
		if(mysql_num_rows($respta)> 0){	
		
		$lista = Consultar_Precio_Evento($INSERT['itemid'],$INSERT['id_itemlocation'],$INSERT['ultimo_costo']);// calculo el precio de envento	
		if($INSERT['ultimo_costo']==0){//->Si no tiene ultimo costo se asignan los valores de la lista de precios
		//	echo '(((((((((((((price((((('.$lista['price'].')))))))))'.$lista['precio_venta'].')))))))))))<br>';
			$INSERT['ultimo_cost']=$lista['price'];
			$INSERT['precio_eve']=$lista['precio_venta'];
		}else{
			//echo '(((((((((((precio_even((((((('.$lista['precio_eve'].'))))))))))))))))))))<br>';
			if(!$lista['price']){//->Entra aca cuando el producto no esta en la lista de precios
				$INSERT['ultimo_cost']=$INSERT['ultimo_costo'];
				$INSERT['precio_eve']=0;
				}
			else{
				$INSERT['ultimo_cost']=$INSERT['ultimo_costo'];
				$INSERT['precio_eve']=$lista['precio_eve'];
			}
			
		}
		
			$rowdel = mysql_fetch_assoc($respta);
			$INSERT['id_pos_items']	=$rowdel['id'];
			
			Actualizar_Producto($INSERT);//->Actualizo en la tabla pos_item y pos_itemconvenios
			
			
			
			echo 'PRODUCTO ACTUALIZADO CON EL PLU=('.$INSERT['itemcode'].')<br><br>';
		}else{
			//[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[			
			$item = mysql_query('SELECT 
							item.description,
							item.brandid,
							item.catalogdescription
							FROM
							item
							WHERE
							item.itemcode ='.$INSERT['itemcode'],$conn_erp);
			$rowdel_item = mysql_fetch_assoc($item);
			$INSERT['description']		=$rowdel_item['description'];
			$INSERT['brandid']			=$rowdel_item['brandid'];
			$INSERT['descrp_larga']	=$rowdel_item['catalogdescription'];
			
			$lista = Consultar_Precio_Evento($INSERT['itemid'],$INSERT['id_itemlocation'],$INSERT['ultimo_costo']);// calculo el precio de envento	
			if($INSERT['ultimo_costo']==0){//->Si no tiene ultimo costo se asignan los valores de la lista de precios
				//echo '(((((((((((((price((((('.$lista['price'].')))))))))'.$lista['precio_venta'].')))))))))))<br>';
				$INSERT['ultimo_cost']=$lista['price'];
				$INSERT['precio_eve']=$lista['precio_venta'];
			}else{
				//echo '(((((((((((precio_even((((((('.$lista['precio_eve'].'))))))))))))))))))))<br>';
				$INSERT['precio_eve']=$lista['precio_eve'];
				$INSERT['ultimo_cost']=$INSERT['ultimo_costo'];
			}
			$INSERT['id_li']=$lista['id_li'];
			
			Insertar_Producto($INSERT);//->inserto en la tabla pos_item
																																										
			
			
			
			//echo " (( $description - $itemcode2 - $brandid - $catalogdescription - $itemid - $ultimo_costo - $precio_even<br>";
				
			echo 'PRODUCTO CREADO CON EL PLU '.$INSERT['itemcode'].'<br>';
		//	echo'********************************************';
		}
	}//1
			
	//insertado wsdl //http://191.168.0.56/emssanar/v3.01/oserp/ws_asistencial.wsdl.php				
	function Consultar_Precio_Evento($itemid,$id_itemlocation,$ultimo_costo){global $conn_erp;
		$lista = mysql_query('SELECT
							pricesubperpriceunit.porcenaument,
							pricesubperpriceunit.price,
							pricesubperpriceunit.precio_venta,
							pricesubperpriceunit.id
							FROM
							pricesubperpriceunit
							WHERE
							pricesubperpriceunit.pricesublevelid = 1 AND
							pricesubperpriceunit.itemid = '.$itemid.' AND
							pricesubperpriceunit.itemlocationid ='.$id_itemlocation,$conn_erp);
		$rowdel_lista = mysql_fetch_assoc($lista);
		$listas['porcen']				=$rowdel_lista['porcenaument'];
		$listas['price']				=$rowdel_lista['price'];
		$listas['precio_venta']			=$rowdel_lista['precio_venta'];
		$listas['id_li']			=$rowdel_lista['id'];


		$porciento=($ultimo_costo*$listas['porcen']/100);
		//echo '// u_c='.$ultimo_costo.' - porcen='.$listas['porcen'].' - resul'.$porciento.'<br>';		
		
		$listas['precio_eve']=$porciento + $ultimo_costo;// Sumo el porcentaje al ultimo costo para optene el precio de evento
		//echo "itemid $itemid --- id_temloc $id_itemlocation ---ultimo_c $ultimo_costo ---porcen ".$listas['porcen']." --- price ".$listas['price']." --- precio_v ".$listas['precio_venta']." porcien $porciento --   precio_ev".$listas['precio_eve']."<br>";
		return $listas; 
		}

	function Insertar_Producto($INSERT){global $dbf;
		//echo'<pre>';print_r($INSERT);
		$SQLIN = 'INSERT INTO pos_items (	item_name, 
												item_number, 
												description,
												brand_id,
												category_id,
												buy_price,
												unit_price,
												total_cost,
												quantity,
												shortdescription,
												active,
												pack,
												parent_id										
												) VALUES (
												"'.$INSERT['descrp_larga'].'",
												"'.$INSERT['itemcode'].'",
												"",
												"'.$INSERT['brandid'].'",
												1,
												"'.$INSERT['ultimo_cost'].'",
												"'.$INSERT['precio_eve'].'",
												"'.$INSERT['precio_eve'].'",
												"'.$INSERT['onhandqty'].'",
												"'.$INSERT['descrp_larga'].'",
												1,
												0,
												"'.$INSERT['itemid'].'"												
												)';
			//	echo $SQLIN.'<br>';
			mysql_query($SQLIN,$dbf->conn);
			$Ultimo_Insert = mysql_insert_id($dbf->conn);	//-> Ultimo id insertado		
		$SQLLI = 'INSERT INTO pos_itemconvenio (	items_id, 
												convenio_id, 
												price_vta,
												estado,
												price_evento,
												parent_id
												) VALUES (
												"'.$Ultimo_Insert.'",
												1,
												"'.$INSERT['ultimo_cost'].'",
												1,
												"'.$INSERT['precio_eve'].'",
												"'.$INSERT['id_li'].'"
												)';
			//	echo $SQLLI.'<br>';
			mysql_query($SQLLI,$dbf->conn);
			
		}
	function Actualizar_Producto($INSERT){global $dbf;
		//echo'<pre>';print_r($INSERT);
			$SQL1 = '	update 	pos_items 
								set quantity = "'.$INSERT['onhandqty'].'",
								parent_id = "'.$INSERT['itemid'].'",
								buy_price ="'.$INSERT['ultimo_cost'].'",
								unit_price ="'.$INSERT['precio_eve'].'" ,
								total_cost ="'.$INSERT['precio_eve'].'" ,
								item_name ="'.$INSERT['descrp_larga'].'" 
						where item_number = '.$INSERT['itemcode']	;
			//	echo $SQL1.'<br>';
			mysql_query($SQL1,$dbf->conn);
	
			$SQL2 = '	update 	pos_itemconvenio 
								set price_vta = "'.$INSERT['ultimo_cost'].'",
								price_evento = "'.$INSERT['precio_eve'].'"
						where items_id = '.$INSERT['id_pos_items']	;
			//	echo $SQL1.'<br>';
			mysql_query($SQL2,$dbf->conn);
			
		}
	echo'<blink>Todos Los Productos Fueron Actualizados!</blink>';

?>