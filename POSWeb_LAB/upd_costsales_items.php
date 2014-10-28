<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
set_time_limit(0);
 	         $rc_pos_sales=mysql_query('select * from pos_sales',$conn_2);
			 $row=mysql_fetch_assoc($rc_pos_sales);
    $i = 0;
	$aa = 0;
	$kj=0;
    
	?><table align="center" class="KT_tngtable">
  <tr>
    <td align="center"><div align="center"><strong>#</strong></div></td>
    <td align="center"><div align="center"><strong>ID FACTURA</strong></div></td>
    <td align="center"><div align="center"><strong>NUMERO FACTURA</strong></div></td>
    <td align="center"><div align="center"><strong>FECHA</strong></div></td>
     <td align="center"><div align="center"><strong>TOTAL VENTA CABECERA</strong></div></td>
     <td align="center">TOTAL COSTO CABECERA</td>
     <td align="center"><strong>PRODUCTOS / VTA</strong></td>
    </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_pos_sales))
		{
			 $qtyend = 0;
			 $totalitemssales = 0;
			 //$rc_sales_items=mysql_query('select * from pos_sales_items where item_id = '.$row["itemid"].' ',$conn_2);
		     //$rc_itemqty=mysql_query('select * from pos_items where id = '.$row["itemid"].' ',$conn_2);
			 //$row_3=mysql_fetch_assoc($rc_itemqty);
				 				 
			     ?>
                  <tr>
                <td align="center"><?=$j?></td>
                <td align="center"><?=$row["id"]?></td>
				<td align="center"><?=$row["invoicenumber"]?></td>
                <td align="center"><?=$row["date"]?></td>
                <td align="center"><?=$row["sale_sub_total"]?></td>
				<td align="center"><?=$row["sale_total_cost"]?></td>
				<td align="center">
                <table  border="1" >
                 <tr>
                   <td><div align="center"><strong>PACK ITEM</strong></div></td>
                   <td><div align="center"><strong>PACK VTA</strong></div></td>
                   <td>&nbsp;</td>
                   <td><div align="center"><strong>NOMBRE</strong></div></td>
                     <td><div align="center"><strong>QTY BUY FACC</strong></div></td>
                     <td><div align="center"><strong>UNIT SALE</strong></div></td>
                     <td><div align="center"><strong>QTY VTA</strong></div></td>
                   <td><div align="center"><strong>PRECIO EN VTA</strong></div>
                     <strong>                     ANTES</strong></td>
                   <td><div align="center"><strong>NEW PVP DESPUES</strong></div></td>
                   <td><div align="center"></div></td>
                 </tr>
                <? $totqtybuy = 0; $asd = 0; $asd_new = 0;
				$rc_pos_sales_items=mysql_query('select * from  pos_sales_items, pos_items  where pos_sales_items.sale_id = '.$row["id"].' and  pos_sales_items.item_id = pos_items.id',$conn_2);
				while($row_2=mysql_fetch_assoc($rc_pos_sales_items))
					{ 
					
				?>
                  
                  <tr>
                    <td><div align="center">
                        <?=$row_2['pack']?>
                    </div></td>
                    <td><div align="center">
                        <?=$row_2['sale_frac']?>
                    </div></td>
                    <td><? if($row_2['pack'] != $row_2['sale_frac']) echo '<font color="#FF0000">Cambio</font>'; else echo '&nbsp;';  ?></td>
                    <td><div align="center">
                    <?=substr($row_2['item_name'],0,15)?>
                    </div></td>
                     <td><div align="center">
                     <?=$row_2['quantity_purchased']?>
                     </div></td>
                     <td><div align="center">
                       <? if($row_2['unit_sale'] == 1 ) echo 'Caja'; else echo 'Fraccion'; ?>
                     </div></td>
                     <td><div align="center">
                       <? if($row_2['unit_sale'] == 2)	echo $qtys = round($row_2['sale_frac'] * $row_2['quantity_purchased']);  else  
					   echo $qtys = $row_2['quantity_purchased'];
					      ?>
                     </div></td>
                     <td><div align="center">
                     <?=$row_2['item_unit_price']?>
                    </div></td>
                     <td><div align="center"><?  
					 if($row_2['unit_sale'] == 2)
					 $nuevopvp_unit = ( $row_2['unit_price'] / $row_2['sale_frac'] ); 
					 else
					 $nuevopvp_unit = $row_2['unit_price']; 
					  $nuevopvp = $qtys * $nuevopvp_unit;
					  
                      echo 'Precio Und.'.$nuevopvp_unit.'  -- Total costo:'.$nuevopvp;
					  
					  $rc_upd_1=mysql_query('update pos_sales_items set item_unit_price = '.$nuevopvp_unit.', item_total_cost = '.$nuevopvp.' where sale_id = '.$row_2["sale_id"].' and item_id = '.$row_2["item_id"].'',$conn_2);
					
					  
					 // update en  pos_sales_items -> item_unit_price
					   ?></div></td>
                     <td><div align="center"></div></td>
                  </tr>
                  <? $totqtybuy+= $row_2['quantity_purchased'];
				     $asd+= $row_2['item_unit_price']; 
					 $asd_new+=$nuevopvp;
				   //$newpvp = 
				  
				  } ?>
                <tr>
                   <td colspan="4"><div align="center"><strong>TOTAL:</strong></div></td>
                  <td><div align="center"><?=$totqtybuy?></div></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><div align="center"><?=$asd?><? if($row["sale_sub_total"] != $asd) echo '<font color="#FF0000">Error</font>'; ?></div></td>
                  <td><div align="center">
                    <?=$asd_new?>
                    <? if($row["sale_sub_total"] != round($asd_new)) { echo '<font color="#FF0000">Error_new</font>'; $kj++;}
					else
					   {
					   // actualizar 
					   
					   }
					
					?>
                  </div></td>
                   <td><div align="center"></div></td>
                 </tr>
                </table>                </td>
			  </tr>
				 <? 
		 $j++;
		}
		 ?></table>
    TOTAL ERROR NEW = <?=$kj?>