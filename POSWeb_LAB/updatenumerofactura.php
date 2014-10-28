<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
 	         $rc_items=mysql_query('select id,date  from pos_sales',$conn_2);
    $i = 0;
	$aa = 0;
    ?><table align="center" class="KT_tngtable">
  <tr>
    <td align="center"><div align="center"><strong># FACTURA</strong></div></td>
    <td align="center"><div align="center"><strong>ID</strong></div></td>
    <td align="center"><div align="center"><strong>FECHA</strong></div></td>
    </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_items))
		{
		  	 $rc_updcron=mysql_query('update pos_sales set invoicenumber = '.$j.' where id =  '.$row["id"].'',$conn_2);
				
			     ?>
                  <tr>
                <td align="center"><?=$j?></td>
                <td align="center"><?=$row["id"]?></td>
				<td align="center"><?=$row["date"]?></td>
			  </tr>
				 <? 
		 $j++;
		}
		 ?></table>
