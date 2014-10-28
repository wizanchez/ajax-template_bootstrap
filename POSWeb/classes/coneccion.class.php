<?php
							
		  $url_class = FOLDER_RAIZ.'classes/adodb/adodb.inc.php';
		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
			  ADOLoadCode(DB_TYPE);
			  $conn = &ADONewConnection();
			  $conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

?>