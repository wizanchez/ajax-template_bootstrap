<? class Formulas

{
	/*	    InsertarFormulla($documento='',$formula='',$tipo='',$campos1='',$campos2='')
	$documento='SE ENVIA EL DOCUMENTO CON EL QUE SE HARA LA BUSQUEDA '	
	$formula='SE ENVIA EL NUMERO DE FORMULA CON EL QUE SE HARA LA BUSQUEDA '	
	$tipo='SE ENVIA EL TIPO DE CONSULTA SI ES POR "id" O ES SOLO UNO " "'
	$campos1='SE DEBE LLENAR CON LOS CAMPOS DE LA PRIMERA TABLA O CABECERA pos_sales'
	$campos2='SE DEBE LLENAR CON LOS CAMPOS DE LA SEGUNDA TABLA O TABLA_DETALLE pos_sales_items'

	ESTA ES LA FORMA DE LLENAR  LOS VECTORES QUE CONTIENEN LOS CAMPOS A INSERTAR EN LAS DOS TABLAS DE VENTAS
	____________________________________________
	$campos1['campos'][0]	='bodega_ID';
	$campos1['condicion'][0]	='1';
	$campos1['campos'][1]	='tipo_vta';
	$campos1['condicion'][1]	='2';

	$campos2['campos'][0][0]	='item_id';
	$campos2['condicion'][0][0]	='100';
	$campos2['campos'][0][1]	='quantity_purchased';
	$campos2['condicion'][0][1]	='20';
	$campos2['campos'][0][2]	='qtyrecetada';
	$campos2['condicion'][0][2]	='1';

	$campos2['campos'][1][0]	='item_id';
	$campos2['condicion'][1][0]	='101';
	$campos2['campos'][1][1]	='quantity_purchased';
	$campos2['condicion'][1][1]	='5';
	$campos2['campos'][1][2]	='qtyrecetada';
	$campos2['condicion'][1][2]	='5';
	*/



	var $conn_erp;

	public function InsertarFormulla($documento = '',$formula = '',$campos1 = '',$campos2 =''){
		$conn_erp = mysql_connect("localhost","jvmcompa_jvm","26montoya2126castro") or	die("Could not connecta : ".mysql_error());
		mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");

		//echo 'campos1 ('.count($campos1['campos']).')__________________<br>';
		//echo 'campos2 ('.count($campos2['condicion']).')__________________<br>';


		$CADENA_CAMPOS_TABLA_1 = 'customer_id, formula';
		$CADENA_VARIABLES_TABLA_1 = '"'.$documento.'","'.$formula.'"';

		for ($i = 0; $i < count($campos1['campos']); $i++) {
			$CADENA_CAMPOS_TABLA_1 .= ','.$campos1['campos'][$i]; //->CONCATENO LOS NOMBRE DE LOS CAMPOS
			$CADENA_VARIABLES_TABLA_1 .= ',"'.$campos1['condicion'][$i].'"'; //->CONCATENO LOS VALORES
		}

		$SQL_pos_sales = 'INSERT INTO pos_sales ('.$CADENA_CAMPOS_TABLA_1.')VALUES('.$CADENA_VARIABLES_TABLA_1.')';
		//	echo $SQL_pos_sales.' - 2.1<br>';
		mysql_query($SQL_pos_sales,$conn_erp);
		$ULTIMO_INS = mysql_insert_id($conn_erp);
		//	echo count($campos2['campos']).' - campos2<br>';
		for ($j = 0; $j < count($campos2['campos']); $j++) {
			for ($k = 0; $k < count($campos2['campos'][$j]); $k++) {
				$CADENA_CAMPOS_TABLA_2 .= ','.$campos2['campos'][$j][$k]; //->CONCATENO LOS NOMBRE DE LOS CAMPOS
				$CADENA_VARIABLES_TABLA_2 .= ',"'.$campos2['condicion'][$j][$k].'"'; //->CONCATENO LOS VALORES
			}
			$SQL_pos_sales_items = 'INSERT INTO pos_sales_items (sale_id,'.substr($CADENA_CAMPOS_TABLA_2,1).')
			VALUES("'.$ULTIMO_INS.'",'.substr($CADENA_VARIABLES_TABLA_2,1).')';

			mysql_query($SQL_pos_sales_items,$conn_erp);
			//echo $SQL_pos_sales_items.' _ ('.$j.' _'.$k.' )- 2.2<br>';
			$CADENA_CAMPOS_TABLA_2 = '';
			$CADENA_VARIABLES_TABLA_2 = '';
		}

		//echo 'Primera venta del documeto '.$documento.'';
		mysql_close($conn_erp);
		$a_sales = Formulas::InsertarVentasDiarias($ULTIMO_INS);
		
		return $ULTIMO_INS;
		//return 1;
	}



	/*	    ConsultarFormula1($documento='',$formula='',$tipo='')
	$documento='SE ENVIA EL DOCUMENTO CON EL QUE SE HARA LA BUSQUEDA '	
	$formula='SE ENVIA EL NUMERO DE FORMULA CON EL QUE SE HARA LA BUSQUEDA '	
	$tipo='SE ENVIA EL TIPO DE CONSULTA SI ES POR "id" O ES SOLO UNO " "'

	SI LA BUSQUEDA NO ARROJA RESULTADOS ENTONCES EL ARRAY QUE DEVUELVE ESTARA BACIO.
	SI ENCUENTRA UNO O MAS REGISTROS O VENTAS/DISPEN ENTONCES EL VECTOR RESULTANTE LLEVARA LOS SIGUIENTES CAMPOS:
	[suma] => LA SUMA DE LA CANTIDAD DE PRODUCTOS ENTREGADOS EN ANTERIORES VENTA/DISPE
	[item_id] => EL ITEM ID DE CADA PRODUCTO DE LA FORMULA
	[quantity_purchased] => EL TOTAL DE LA CANTIDAD DE PRODUCTOS QUE SE LE DEBEN ENTREGAR
	[unit_sale] => UNIDAD DE VENTA
	[sale_frac] => UNIDA DE FRACCIONAMIENTO.
	*/

	public function ConsultarFormula($documento = '',$formula = '',$tipo = ''){
		$conn_erp = mysql_connect("localhost","jvmcompa_jvm","26montoya2126castro") or die("Could not connecta : ".mysql_error());
		mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
		if (!$documento) {
			echo 'Debe en la primera pocision de la funcion ConsultarFormula( , , ). colocar el carnet<br>';
			return false;
		}

		if (!$formula) {
			echo 'Debe en la segunda pocision de la funcion ConsultarFormula( , , ). colocar la formula<br>';
			return false;
		}

		switch ($tipo) {
			case 'id':
				{
					$VALING = 'WHERE ps.customer_id="'.$documento.'" AND ps.formula="'.$formula.'"';
				}
				break;
			default:
				{
					$VALING = 'LIMIT 1';
				}
				break;
		}
		$SQL = 'SELECT
									ps.id,
									ps.`date`,
									ps.customer_id,
									ps.sale_sub_total,
									ps.sale_total_cost,
									ps.paid_with,
									ps.items_purchased,
									ps.sold_by,
									ps.comment,
									ps.changee,
									ps.invoicenumber,
									ps.status,
									ps.descuentporc,
									ps.value_discount,
									ps.tipo_vta,
									ps.bodega_id,
									ps.formula
									FROM
									pos_sales AS ps '.$VALING;

		$result = mysql_query($SQL,$conn_erp);

		while ($rs = mysql_fetch_assoc($result)) {
			$id .= ','.$rs['id'];
		} //fin while

		if ($id) {

			$SQL_1 = 'SELECT
					pos_sales_items.item_id,
					pos_sales_items.sale_id
					FROM `pos_sales_items`
					WHERE
					pos_sales_items.sale_id IN  ('.substr($id,1).')
					GROUP BY pos_sales_items.item_id';

			$resultDet = mysql_query($SQL_1,$conn_erp);

			$contador = 0;
			$Vector = array();
			while ($r_SQL_1 = mysql_fetch_assoc($resultDet)) {
				$SQL_2 = 'SELECT
							Sum(pos_sales_items.quantity_purchased) AS suma,
							pos_sales_items.item_id,
							pos_sales_items.quantity_purchased,
							pos_sales_items.unit_sale,
							pos_sales_items.sale_frac,
                            pos_sales_items.qtyrecetada,
                            pos_sales_items.tipo
							FROM pos_sales_items
							WHERE pos_sales_items.item_id='.$r_SQL_1['item_id'].
					' AND pos_sales_items.sale_id IN ('.substr($id,1).')';

				$resultDetB = mysql_query($SQL_2,$conn_erp);
                $r_SQL_2 = mysql_fetch_assoc($resultDetB);
				$Vector[$contador]['suma'] 					= $r_SQL_2['suma'];
				$Vector[$contador]['item_id'] 				= $r_SQL_2['item_id'];
				$Vector[$contador]['quantity_purchased'] 	= $r_SQL_2['quantity_purchased'];
				$Vector[$contador]['qtyrecetada'] 			= $r_SQL_2['qtyrecetada'];
                $Vector[$contador]['unit_sale'] 			= $r_SQL_2['unit_sale'];
				$Vector[$contador]['sale_frac'] 			= $r_SQL_2['sale_frac'];
                $Vector[$contador]['tipo'] 					= $r_SQL_2['tipo'];
				$contador++;
				//echo $SQL_2;
				//$r_SQL_1->MoveNext();
			} //fin while
		} //fin if

		mysql_close($conn_erp);
		return $Vector;
	}
	
	
		public function InsertarVentasDiarias($ID_POS_SALES){
			
	/*		$conn_erp = mysql_connect("191.168.0.56","webservice","webservice") or	die("Could not connecta : ".mysql_error());
			mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
	*/		$conn_erp = mysql_connect("localhost","jvmcompa_jvm","26montoya2126castro") or	die("Could not connecta : ".mysql_error());
			mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
		
				$SQL_1 = "SELECT	ps.id,
									ps.`date`,
									ps.bodega_id
									FROM
									pos_sales AS ps WHERE id = $ID_POS_SALES";

				$result1 = mysql_query($SQL_1,$conn_erp);
				$r_SQL_1 = mysql_fetch_assoc($result1);
				
				$SQL_2 = 'SELECT	psi.id,
									psi.plu_item,
									psi.item_buy_price,
									psi.quantity_purchased,
									psi.sale_frac,
									psi.item_total_cost
									FROM
									pos_sales_items AS psi WHERE sale_id ='.$ID_POS_SALES;

				$result2 = mysql_query($SQL_2,$conn_erp);
                $r_SQL_2 = mysql_fetch_assoc($result2);		

				$SQL_3 = 'SELECT	i.id
									FROM
									item AS i WHERE itemcode ='.$r_SQL_2['plu_item'];

				$result3 = mysql_query($SQL_3,$conn_erp);
                $r_SQL_3 = mysql_fetch_assoc($result3);

				 $SQL_4 = 'SELECT	id,
									qty,
									total_sales
									FROM
									sales_log WHERE entrydate = "'.date('Y-m-d').'" AND itemid='.$r_SQL_3['id'].' 
									AND locationid ='.$r_SQL_1['bodega_id'];

				$result4 = mysql_query($SQL_4,$conn_erp);
                $r_SQL_4 = mysql_fetch_array($result4);
				 
				if($r_SQL_4==''){
					$SQL_sales_log = 'INSERT INTO sales_log (line,code,date,locationid,code_yep,sales_vr,qty,qty_fraction,total_sales,cancel,itemid,entrydate)	
												VALUES(1,
													   1,
													   "'.$r_SQL_1['date'].'",
													   "'.$r_SQL_1['bodega_id'].'",
													   "'.$r_SQL_2['plu_item'].'",
													   "'.$r_SQL_2['item_buy_price'].'",
													   "'.$r_SQL_2['quantity_purchased'].'",
													   "'.$r_SQL_2['sale_frac'].'",
													   "'.$r_SQL_2['item_total_cost'].'",
													   0,
													   "'.$r_SQL_3['id'].'",
													   "'.date('Y-m-d').'"
													   )';
					mysql_query($SQL_sales_log,$conn_erp);
					$ULTIMO_INS = mysql_insert_id($conn_erp);
					} else {
						$cantidad=$r_SQL_2['quantity_purchased']+$r_SQL_4['qty'];
						$costo=$r_SQL_2['item_total_cost']+$r_SQL_4['total_sales'];
						$SQL_U = 'UPDATE sales_log SET  qty="'.$cantidad.'",total_sales="'.$costo.'" WHERE  id="'.$r_SQL_4['id'].'"';
						$result_queryupd = mysql_query($SQL_U,$conn_erp);
						Formulas::ActualizarInventario($r_SQL_3['id'],$r_SQL_1['bodega_id'],$r_SQL_2['quantity_purchased']);
					}	
					return $ULTIMO_INS;
				}//->Fin InsertarVentasDiarias

		private function ActualizarInventario($itemid,$locationid,$descuento) {
			$descuento2=$descuento;
		//	$conn_erp = mysql_connect("191.168.0.56","webservice","webservice") or	die("Could not connecta : ".mysql_error());
		//	mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
			$conn_erp = mysql_connect("localhost","jvmcompa_jvm","26montoya2126castro") or	die("Could not connecta : ".mysql_error());
			mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
	
			$SQL_1 = 'SELECT	il.id,
								il.onhandqty
								FROM
								itemlocation AS il WHERE itemid ='.$itemid.' AND inventorylocationid = '.$locationid;
			$result1 = mysql_query($SQL_1,$conn_erp);
			$r_SQL_1 = mysql_fetch_assoc($result1);
	
			$cantidad=$r_SQL_1['onhandqty']-$descuento;
			$SQL_U = 'UPDATE itemlocation SET  onhandqty="'.$cantidad.'" WHERE  id="'.$r_SQL_1['id'].'"'; echo "<br> $SQL_U <br>";
			mysql_query($SQL_U,$conn_erp);
			
			 $SQL_2 = 'SELECT	id,
								onhandqty
								FROM
								itemlocationbatch WHERE itemlocationid ='.$r_SQL_1['id'].' ORDER BY vencimiento ASC ';
			$result2 = mysql_query($SQL_2,$conn_erp);
			//$r_SQL_2 = mysql_fetch_assoc($result2);
			//echo'<pre>';print_r($r_SQL_2);
			
			$conta=1;
			while($row = mysql_fetch_array($result2))
			  {echo '<br>--'.$descuento.' -- '.$row['onhandqty'].' -- '.$row['id'].'<br>';
			  print_r(array_count_values ($row));
					if($row['onhandqty']>=$descuento){
						$nuevo_qty=$row['onhandqty']-$descuento;
						$SQL_U1 = 'UPDATE itemlocationbatch SET  onhandqty="'.$nuevo_qty.'" WHERE  id="'.$row['id'].'"';echo "<br> $SQL_U1 <br>";
						mysql_query($SQL_U1,$conn_erp);
						break;
					}
					else{
						$descuento-=$row['onhandqty'];
						$SQL_U2 = 'UPDATE itemlocationbatch SET  onhandqty=0 WHERE  id="'.$row['id'].'"'; echo "<br> $SQL_U2 <br>";
						mysql_query($SQL_U2,$conn_erp);
						echo '<br>('.$conta.') -('.count($row).')<br>';
						 
						if($conta==count($row)-1){
							//$nuevo_qty-=$descuento;
							$SQL_U3 = 'UPDATE itemlocationbatch SET  onhandqty=onhandqty-'.$descuento.' WHERE  id="'.$row['id'].'"'; echo "<br> $SQL_U3 <br>";
							mysql_query($SQL_U3,$conn_erp);
						}
					} 
					$conta++;
			  }
  
  
			$cantidadbatch=$r_SQL_2['onhandqty']-$descuento;
			$SQL_Ubatch = 'UPDATE itemlocationbatch SET  onhandqty="'.$cantidadbatch.'" WHERE  id="'.$r_SQL_2['id'].'"'; echo "<br> $SQL_Ubatch <br>";
			mysql_query($SQL_Ubatch,$conn_erp);
			
		

			$SQL_3 = 'SELECT	id
								FROM
								inventorySubLocation WHERE inventorylocationid ='.$locationid.' AND disponible=1';
			$result3 = mysql_query($SQL_3,$conn_erp);
			$r_SQL_3 = mysql_fetch_assoc($result3);	

			 $SQL_4 = 'SELECT	id,
								onhandqty
								FROM
								itemsublocation WHERE itemlocationid ='.$r_SQL_1['id'].' AND inventorySubLocationid='.$r_SQL_3['id'];
			$result4 = mysql_query($SQL_4,$conn_erp);
			$r_SQL_4 = mysql_fetch_assoc($result4);
			
			$cantidadsub=$r_SQL_4['onhandqty']-$descuento2;
			$SQL_Usub = 'UPDATE itemsublocation SET  onhandqty="'.$cantidadsub.'" WHERE  id="'.$r_SQL_4['id'].'"';echo "<br> $SQL_Usub <br>";
			mysql_query($SQL_Usub,$conn_erp);
	//		die;
		} //-> FIN consultarProdutos_deta
		
		
	/*ConsultarInventarioERP($plu='',$locationid='')
	$plu='SE ENVIA EL PLU CON EL QUE SE HARA LA BUSQUEDA '	
	$locationid='SE ENVIA LA BODEGA CON LA QUE SE HARA LA BUSQUEDA '	

	SI LA BUSQUEDA NO ARROJA RESULTADOS ENTONCES EL ARRAY QUE DEVUELVE ESTARA BACIO.
	SI ENCUENTRA UNO O MAS REGISTROS ENTONCES EL VECTOR RESULTANTE LLEVARA LOS SIGUIENTES CAMPOS:
	[id] => EL ID DE ITEMLOCATION
	[cantidad] => LA CANTIDAD QUE HAY ACTUALMENTE EN ESA BODEGA DE EL PRODUCTO QUE SE ENVIO.
	*/

	public function ConsultarInventarioERP($plu='',$locationid='') {
		$Inventario =array();
		if(!$plu){echo 'Debe en la primera pocision de la funcion ConsultarInventarioERP( , , ). colocar el PLU<br>';return false;}
		if(!$locationid){echo 'Debe en la segunda pocision de la funcion ConsultarInventarioERP( , , ). colocar el id de la BODEGA<br>';return false;}
		
		//	$conn_erp = mysql_connect("191.168.0.56","webservice","webservice") or	die("Could not connecta : ".mysql_error());
		//	mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
			$conn_erp = mysql_connect("localhost","jvmcompa_jvm","26montoya2126castro") or	die("Could not connecta : ".mysql_error());
			mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");
			
				$SQL_1 = 'SELECT	i.id
									FROM
									item AS i WHERE itemcode ='.$plu;

				$result1 = mysql_query($SQL_1,$conn_erp);
                $r_SQL_1 = mysql_fetch_assoc($result1);
	
				$SQL_2 = 'SELECT	il.id,
									il.onhandqty
									FROM
									itemlocation AS il WHERE itemid ='.$r_SQL_1['id'].' AND inventorylocationid = '.$locationid;

				$result2 = mysql_query($SQL_2,$conn_erp);
				$r_SQL_2 = mysql_fetch_assoc($result2);
				$Inventario['id']=$r_SQL_2['id'];				
				$Inventario['cantidad']=$r_SQL_2['onhandqty'];				
				return $Inventario;
				
			} //-> FIN ConsultarInventarioERP

} //class Formulas



?>

