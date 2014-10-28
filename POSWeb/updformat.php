<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
set_time_limit(0);
 	         $rc_pos_sales=mysql_query('select * from pos_sales_items',$conn_2);
			 $row=mysql_fetch_assoc($rc_pos_sales);
    $i = 0;
	$aa = 0;
    
	?><table align="center" class="KT_tngtable">
  <tr>
    <td align="center">ID SALES_POS_ITEMS</td>
    <td align="center"><div align="center"><strong>PVP VIEJO</strong></div></td>
    <td align="center"><div align="center"><strong>PVP NUEVO</strong></div></td>
    <td align="center"><div align="center"><strong>COSTO VIEJO</strong></div></td>
    <td align="center"><div align="center"><strong>COSTO NUEVO</strong></div></td>
    <td align="center"><div align="center"><strong>ITEM TOTAL COST</strong></div></td>
    <td align="center"><div align="center"><strong>NEW ITEM TOTAL COST</strong></div></td>
  </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_pos_sales))
		{
					 				 
			     ?>
                  <tr>
                    <td align="center">  <?=$row['id']?></td>
                <td align="center"><div align="center">
                  <?=$row['item_unit_price']?>
                </div></td>
                <td align="center">
                  <div align="center">
                    <?
                  $pvpn = explode(",",$row['item_unit_price']);
                   echo $pvpnnew = $pvpn[0].$pvpn[1];
				 $rc_upd_1=mysql_query('update pos_sales_items set item_unit_price = '.$pvpnnew.' where id = '.$row['id'].' ',$conn_2);
				?>                
                  </div></td>
			    <td align="center"><div align="center">
			      <?=$row['item_buy_price']?>
			      </div></td>
			    <td align="center"><div align="center">
			      <?
                  $costn = explode(",",$row['item_buy_price']);
                   echo $costnnew = $costn[0].$costn[1];
				 $rc_upd_2=mysql_query('update pos_sales_items set item_buy_price = '.$costnnew.' where id = '.$row['id'].' ',$conn_2);
				?>
			      </div></td>
                <td align="center"><div align="center">
                  <?=$row['item_total_cost']?>
                </div></td>
                <td align="center"><div align="center">
                  <?
                  $itemtotcostn = explode(",",$row['item_total_cost']);
                   echo $itemtotcostnnew = $itemtotcostn[0].$itemtotcostn[1];
				 $rc_upd_3=mysql_query('update pos_sales_items set item_total_cost = '.$itemtotcostnnew.' where id = '.$row['id'].' ',$conn_2);
				?>
                </div></td>
              </tr>
				 <? 
		 $j++;
		}
		 ?></table>
    