<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<?
 	         $rc_items=mysql_query('select pack, id, item_number from pos_items where id > 25000 ',$conn_2);
    $i = 0;
	$aa = 0;
    while($row=mysql_fetch_assoc($rc_items))
		{
				 $rc_temp=mysql_query('select pastilleo, codigo from temp where codigo = '.$row["item_number"].' ',$conn_2);
				 // echo 'select pastilleo, codigo from temp where codigo = '.$row["item_number"].'	';
				  $row2=mysql_fetch_assoc($rc_temp);
				  //echo  $row["id"].' ---------- '.$row["item_number"].' ---------- '.$row["pack"].' ---------- '.$row2["codigo"].' ---------- '.$row2["pastilleo"].'<br>';
				 
				  $rc_temp=mysql_query('select pastilleo, codigo from temp where codigo = '.$row["item_number"].' ',$conn_2);
				  if($row["pack"] != $row2["pastilleo"] ) 
				       $aa = 1;
					
				  //$rc=mysql_query('update pos_items set pack = '.$row2["pastilleo"].'  where item_number = '.$row["item_number"].' ',$conn_2);
				 //$i=$i+1;
		}
		if($aa == 0) echo 'Todo actualizado correctamente';
		else echo 'La cagaste';
?>