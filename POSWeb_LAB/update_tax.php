<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
set_time_limit(0);
 	         $rc_ivas=mysql_query('select * from ivas',$conn_2);
			
    $i = 0;
	$aa = 0;
    
	?><table align="center" class="KT_tngtable">
  <tr>
    <td align="center"><strong>#</strong></td>
    <td align="center"><strong>CODIGO</strong></td>
    <td align="center"><strong>DESCRIPCION</strong></td>
    <td align="center"><div align="center"><strong>% IVA</strong></div></td>
    <td align="center"><strong>ACTUALIZADO</strong></td>
  </tr>
	<?
	$j = 1; $enc = 0; $noenc = 0;
	while($row=mysql_fetch_assoc($rc_ivas))
		{
					 				 
			     ?>
                  <tr>
                    <td align="center">  <?=$j?></td>
                    <td align="center">  <?=$row['codigo']?></td>
                    <?
					$rc_item=mysql_query('select * from pos_items where item_number = '.$row['codigo'].'',$conn_2);
					$row_2=mysql_fetch_assoc($rc_item);
                    if($row_2['item_name'] != '') 
					  {
					    $desc = $row_2['item_name'];
						mysql_query('update pos_items set tax_percent = '.$row['iva'].' where item_number = '.$row['codigo'].' ',$conn_2);
						$up = 'SI'; $enc++;
					  }	
					   else 
					       {
						     $desc = '<font color="red">PRODUCTO NO ENCONTRADO</font>';
							 $up = '<font color="red">NO</font>'; $noenc++;
						   } 
					?>
                    <td align="center"><?=$desc?></td>
                    <td align="center"><div align="center">
                  <?=$row['iva']?>
                </div></td>
                    <td align="center"><?=$up?></td>
                </tr>
				 <? 
		 $j++;
		}
		   $tota = $enc + $noenc;
		 ?>
         <tr>
    <td align="center"><strong>ENCONTRADOS: <?=$enc?></strong></td>
    <td align="center"><strong>NO ENCONTRADOS: <?=$noenc?></strong></td>
    <td align="center"><strong>TOTAL: <?=$tota?></strong></td>
   </tr>
         </table>
         