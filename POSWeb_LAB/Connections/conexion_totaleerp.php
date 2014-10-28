<?php
$conn_erp = mysql_pconnect('201.217.214.51', 'vespinosa', 'victorhugo8363') or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db('totaleerp',$conn_erp) or die("Could not select database <b>$database</b>");
?>