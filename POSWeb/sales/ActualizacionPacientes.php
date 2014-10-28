<?php 
set_time_limit(5000);
include ("../settings.php");
include ("../Connections/conexion.php");
include ("../classes/db_functions.php");
$imagenes='cargando.gif';
	global $cfg_locationid;
	echo 'BODEGA ='.$cfg_locationid.'<br>';
	print '<img src="'.$imagenes.'">';
	$dbf = new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);

//	$conn_erp = mysql_connect("191.168.0.56","webservice","webservice") or die("Could not connecta : ".mysql_error());
//	mysql_select_db("jvmcompa_emssanar",$conn_erp) or die("Could not select database <b>jvmcompa_emssanar</b>");

	$tiempo = microtime();//->GUARDO LA HORA DONDE INICIA EL PROCESO
	$tiempo = explode(" ", $tiempo);//->DIFIDO LA HORA
	$tiempo = $tiempo[1] + $tiempo[0];//->SUMO LAS POCISIONES
	$tiempoInicial = $tiempo;//->TENGO EL  TIEMPO INICIAL

for($i=1;$i<=1300000;$i=$i+5000){
	$CA=403+$i;
	$SQL = "SELECT id,account_number,almacenid FROM dbo_pos_pacientes_final WHERE id>".$CA." LIMIT 5000 ";
	//echo $SQL.'<br>' ;
	$respta = mysql_query($SQL,$dbf->conn);
	while ($rowdel = mysql_fetch_assoc($respta)) {
		
		$id_pacientes=$rowdel['id']-305;
		echo '<br> id_pos_pacientes = ('.$id_pacientes.') ,id_dbo = ('.$rowdel['id'].')<br>';
		if($id_pacientes>0){	
			//if($rowdel_itemlocation_copy['onhandqty']<'0'){$cantidad=0;}else{$cantidad=$rowdel_itemlocation_copy['onhandqty'];}
				$SQL1 = 'update pos_pacientes set account_number = "'.$rowdel['account_number'].'", almacenid = "'.$rowdel['almacenid'].'" 
				where id = '.$id_pacientes;
				mysql_query($SQL1,$dbf->conn);
													
					//			echo 'CEDULA ='.$rowdel_pa_fin['account_number'].'<br>';
					//			echo 'FARMACIA ='.$rowdel_pa_fin['almacenid'].'<br>';
					//			echo '***************************************************<br>';
					
		}
		
	}
}
	$tiempo = microtime();$tiempo = explode(" ", $tiempo);$tiempo = $tiempo[1] + $tiempo[0];$tiempoFinal = $tiempo;
	$tiempoTotal = $tiempoFinal - $tiempoInicial;
	echo "La Actualizacion tardó ( " . $tiempoTotal . " ) segundos.";

	echo'<blink>Todos Los PACIENTES Fueron Actualizados!</blink>';

?>