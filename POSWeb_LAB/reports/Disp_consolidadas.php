<?php session_start();
include ("../settings.php");
include ("../language/$cfg_language");
include ("../Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="../css/pos.css">
<? set_time_limit(0);
$rc_pos_sales = mysql_query('select  pos_sales.date  from pos_sales,pos_sales_items where pos_sales.id = pos_sales_items.sale_id and
pos_sales.tipo_vta = 2 AND 
pos_sales_items.tipo = 2 AND 
pos_sales_items.qtyrecetada > 0 AND 
pos_sales_items.quantity_purchased > 0  group by pos_sales.date',$conn_2);

$i = 0;
$aa = 0;

while ($row = mysql_fetch_assoc($rc_pos_sales)) {
?><table align="center" class="KT_tngtable">
    <tr>
    <td colspan="5" align="center"><div align="center"><strong>DISPENSACION CONSOLIDADAS DEL
      <?= $row['date']
?>
    </strong></div></td>
  </tr>
    <tr>
      <td align="center"><div align="center"><strong>CODIGO</strong></div></td>
      <td align="center"><div align="center"><strong>DESCRIPCION</strong></div></td>
      <td align="center"><div align="center"><strong>CANTIDADES</strong></div></td>
      <td align="center"><div align="center"><strong>PVP</strong></div></td>
      <td align="center"><div align="center"><strong>COSTO</strong></div></td>
    </tr>
    <? 	
    
    $rc_pos_sales_2 = mysql_query('select pos_items.item_number, 
pos_items.item_name, 
sum(pos_sales_items.quantity_purchased) as cant,
sum(pos_sales_items.item_total_cost) as item_total_cost, 
sum(pos_sales_items.quantity_purchased*pos_sales_items.item_buy_price) as item_unit_price
from pos_sales, pos_sales_items, pos_items
where pos_sales.date = "'.$row['date'].'"  and
pos_sales.id = pos_sales_items.sale_id and
pos_items.id = pos_sales_items.item_id and
pos_sales.tipo_vta = 2 AND 
pos_sales_items.tipo = 2 AND 
pos_sales.status = 1 AND 
pos_sales_items.qtyrecetada > 0 AND 
pos_sales_items.quantity_purchased > 0 
group by pos_sales_items.item_id
',$conn_2);

	while ($row_4 = mysql_fetch_assoc($rc_pos_sales_2)) {
?>
    
    <tr>
      <td align="center"><div align="center"><strong><?= $row_4['item_number']
?></strong></div></td>
      <td align="center"><div align="center"><strong><?= $row_4['item_name']
?></strong></div></td>
      <td align="center"><div align="center"><strong><?= $row_4['cant']
?></strong></div></td>
      <td align="center"><div align="center"><strong><?= $row_4['item_total_cost']
?></strong></div></td>
      <td align="center"><div align="center"><strong><?= $row_4['item_unit_price']
?></strong></div></td>
    </tr>
    <? }
?>
    </table><br />
<br />

	<? }
?>
    