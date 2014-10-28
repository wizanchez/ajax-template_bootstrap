<?php
$conn_3 = mysql_pconnect("localhost", "root","80071432") or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db("jvmcompa_posweb",$conn_3) or die("Could not select database <b>$database</b>");
?>