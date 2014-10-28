<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<?
 	         $rc_items=mysql_query('select id,codigo,costo,pvp from temp',$conn_2);
    $i = 0;
	$aa = 0;
    ?>
    <table align="center">
  <tr>
    <td align="center"><div align="center"><strong>ID</strong></div></td>
    <td align="center"><div align="center"><strong>CODIGO</strong></div></td>
    <td align="center"><div align="center"><strong>COSTO ACTUAL</strong></div></td>
    <td align="center"><div align="center"><strong>PRECIO ACTUAL</strong></div></td>
    <td align="center"><strong>COSTO ANTERIOR</strong></td>
    <td align="center"><strong>PRECIO ANTERIOR</strong></td>
    <td align="center"><strong>ID PRODUCTO</strong></td>
    <td align="center"><strong>DESCRIPCION PRODUCTO</strong></td>
  </tr>
	<?
	while($row=mysql_fetch_assoc($rc_items))
		{
				 $rc_items2=mysql_query('select pos_items.id, pos_items.unit_price, pos_items.total_cost, pos_items.item_number,  pos_items.item_name from pos_items, temp where pos_items.item_number = temp.codigo and pos_items.item_number =  '.$row["codigo"].'',$conn_2);
				 // echo 'select pastilleo, codigo from temp where codigo = '.$row["item_number"].'	';
				  while($row2=mysql_fetch_assoc($rc_items2)) {
			     ?>
                  <tr>
                <td align="center"><?=$row["id"]?></td>
                <td align="center"><?=$row["codigo"]?></td>
				<td align="center"><?=$row["costo"]?></td>
				<td align="center"><?=$row["pvp"]?></td>
                <td align="center"><?=$row2["total_cost"]?></td>
                <td align="center"><?=$row2["unit_price"]?></td>
                <td align="center"><?=$row2["id"]?></td>
                <td align="center"><?=$row2["item_name"]?></td>                
              </tr>
				 <? //$rc=mysql_query('update pos_items set buy_price = '.number_format($row["costo"],0).', unit_price = '.number_format($row2["unit_price"],0).' where id =  '.$row2["id"].'   ',$conn_2); 
				 //echo 'update pos_items set buy_price = '.$row["costo"].', unit_price = '.$row2["unit_price"].' where id =  '.$row2["id"].' '; echo '<br>';
				 } 
				  //$rc_temp=mysql_query('select pastilleo, codigo from temp where codigo = '.$row["item_number"].' ',$conn_2);
				  //if($row["pack"] != $row2["pastilleo"] ) 
				   //    $aa = 1;
					
				  //$rc=mysql_query('update pos_items set pack = '.$row2["pastilleo"].'  where item_number = '.$row["item_number"].' ',$conn_2);
				 //$i=$i+1;
		}
		 ?></table>
    <?
		/*if($aa == 0) echo 'Todo actualizado correctamente';
		else echo 'La cagaste';*/
?>