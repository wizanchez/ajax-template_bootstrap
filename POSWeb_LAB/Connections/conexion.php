<?php
$conn_2 = mysql_pconnect($cfg_server, $cfg_username, $cfg_password) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($cfg_database,$conn_2) or die("Could not select database <b>$database</b>");
?>