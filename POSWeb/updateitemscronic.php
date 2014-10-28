<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<link rel="stylesheet" type="text/css" href="css/pos.css">
<?
 	         $rc_items=mysql_query('select id,codigo,descripcion,item_update from cronicos',$conn_2);
    $i = 0;
	$aa = 0;
    ?>
    <table align="center" class="KT_tngtable">
  <tr>
    <td align="center"><div align="center"><strong>#</strong></div></td>
    <td align="center"><div align="center"><strong>CODIGO</strong></div></td>
    <td align="center"><div align="center"><strong>DESCRIPCION</strong></div></td>
    <td align="center"><div align="center"><strong>ACTUALIZADO</strong></div></td>
    </tr>
	<?
	$j = 1;
	while($row=mysql_fetch_assoc($rc_items))
		{
			
				 $rc_items2=mysql_query('select pos_items.id  from pos_items, cronicos where pos_items.item_number = '.$row["codigo"].'',$conn_2);
				  $row2=mysql_fetch_assoc($rc_items2);
				  if($row2["id"] != '') {
				   $rc_updcron=mysql_query('update pos_items set cronico = 1 where id =  '.$row2["id"].'',$conn_2);
				     $a = 'Si'; $color = '#000099'; 
				   } else { $a = 'No'; $color = '#FF0000';  }
				  //while($row2=mysql_fetch_assoc($rc_items2))
			     ?>
                  <tr>
                <td align="center"><?=$j?></td>
                <td align="center"><?=$row["codigo"]?></td>
				<td align="center"><?=$row["descripcion"]?></td>
				<td align="center"><font color="<?=$color?>"><?=$a?></font></td>
              </tr>
				 <? 
		 $j++;
		}
		 ?></table>