<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
set_time_limit(0);
 	         $rc_items=mysql_query('select * from loadinvreceive',$conn_2);
			 $row=mysql_fetch_assoc($rc_items);
    $i = 0;
	$aa = 0;
    ?><table align="center" class="KT_tngtable">
  <tr>
    <td align="center"><div align="center"><strong>#</strong></div></td>
    <td align="center"><div align="center"><strong>ITEMID</strong></div></td>
    <td align="center"><div align="center"><strong>CODIGO</strong></div></td>
    <td align="center"><div align="center"><strong>DESCRIPCION</strong></div></td>
     <td align="center"><div align="center"><strong>CANTIDAD INV INIC</strong></div></td>
     <td align="center"><strong>VTAS</strong></td>
     <td align="center"><div align="center"><strong>CANT POS</strong></div></td>
    <td align="center"><div align="center"><strong>ACTUALIZADO</strong></div></td>
    </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_items))
		{
			 $qtyend = 0;
			 $totalitemssales = 0;
			 $rc_sales_items=mysql_query('select * from pos_sales_items where item_id = '.$row["itemid"].' ',$conn_2);
		     $rc_itemqty=mysql_query('select * from pos_items where id = '.$row["itemid"].' ',$conn_2);
			 $row_3=mysql_fetch_assoc($rc_itemqty);
				 				 
			     ?>
                  <tr>
                <td align="center"><?=$j?></td>
                <td align="center"><?=$row["itemid"]?></td>
				<td align="center"><?=$row["codigo"]?></td>
                <td align="center"><?=$row["descripcion"]?></td>
                <td align="center"><?=$row["qty"]?></td>
				<td align="center">
                <?
				while($row_2=mysql_fetch_assoc($rc_sales_items))
		            {
					 echo 'id factura: '.$row_2['sale_id'].' qty vendida: '.$row_2['quantity_purchased'].'<br>';
					 $totalitemssales+=$row_2['quantity_purchased'];
					}
		$qtyend = $row["qty"] - $totalitemssales; 
		      		  
					  if (mysql_query('update pos_items set quantity = '.$qtyend.' where id =  '.$row["itemid"].'',$conn_2) === false)
					     {
					      $a = 'No'; $color = '#FF0000'; 
					     } else {  $a = 'Si'; $color = '#000099'; }
                ?></td>
				<td align="center"><?=$row_3['quantity']?></td>
				<td align="center"><font color="<?=$color?>"><?=$a.' -- '.$qtyend?></font></td>
              </tr>
				 <? 
		 $j++;
		}
		 ?></table>
<!--      $tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoInicial = $tiempo;
   $tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoFinal = $tiempo; // Cálculo de la diferencia de tiempo
  $tiempoTotal = $tiempoFinal - $tiempoInicial;
  echo "La página tardó en generarse " . $tiempoTotal . " segundos.<br>";-->