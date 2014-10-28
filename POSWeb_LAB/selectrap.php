<?php session_start(); 
include ("settings.php");
include ("language/$cfg_language");
include ("Connections/conexion.php");
?>
<?
 	         $rc_items=mysql_query('select *  from pos_items where id = 32266 or id = 48292',$conn_2);
    $i = 0;
	$aa = 0;
    while($row=mysql_fetch_assoc($rc_items))
		{
				  echo  $row["description"].'  pack:'.$row["pack"].'<br> ';
				 $aa = 2;
		}
		if($aa == 0) echo 'Todo actualizado correctamente';
		else echo 'fallo la operacion';
?>