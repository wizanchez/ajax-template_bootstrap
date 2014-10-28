<?php session_start();
include ("../settings.php");
include ("../Connections/conexion.php");
include ("../classes/db_functions.php");
$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);

$SQL = "SELECT id,item_name FROM pos_items";
$respta = mysql_query($SQL,$dbf->conn);
while ($rowdel = mysql_fetch_assoc($respta)) {
  $queryupd = 'update pos_items set shortdescription = "'.$rowdel['item_name'].'" where id = '.$rowdel['id'].'';
  //echo $queryupd;
  $result_queryupd = mysql_query($queryupd);								
}

echo'<blink>Todos Los Productos Fueron Actualizados!</blink>';
?>