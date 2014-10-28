<?

$style = true;

include ("settings.php");

include ("language/$cfg_language");

include ("Connections/conexion.php");

	#########################################################################################################################################################
	###ENTRA A LA CONECCION
		define(FOLDER_RAIZ,'');
		$style		='FALSE';
		$url_class 	= FOLDER_RAIZ.'settings.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
		$url_class 	= FOLDER_RAIZ.'classes/adodb/adodb.inc.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}
		ADOLoadCode(DB_TYPE);
		$conn 		= &ADONewConnection();
		$conn->PConnect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
		$url_class 	= FOLDER_RAIZ.'classes/consulta.class.php';
	  		if (!file_exists($url_class)) {	echo 'Error include { ' . $url_class . ' }<br>';} else {include ($url_class);}

	#########################################################################################################################################################

header('Cache-Control: no-cache, must-revalidate');

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

header('Content-type: application/json');

$a = $_REQUEST['a'];

$tipoVta = $_REQUEST['tipoVta'];

$tipSearch = $_REQUEST['tipSearch'];



if($tipSearch == '1')

if($tipoVta == '1'){

    $strSearch = "(account_number = '$a')";

}else{

    $strSearch = "(account_number = '$a' OR carnet_number = '$a')";

    }

if($tipSearch == '2')

    $strSearch = "(first_name LIKE '%$a%' OR last_name LIKE '%$a%' OR account_number LIKE '%$a%' )";



if($tipoVta == '1'){

    $sql = "SELECT account_number,id,last_name,first_name FROM pos_customers WHERE $strSearch LIMIT 20";

    

}else{

    $sql = "SELECT account_number,id,last_name,first_name,almacenid,tipo_subsidio FROM pos_pacientes WHERE $strSearch LIMIT 20";

}

$result = mysql_query($sql,$conn_2);

if(mysql_num_rows($result) == 0){

   $return_arr = array();

   $return_arr[0]['id'] = 0;

   $return_arr[0]['label'] = 0;

   $return_arr[0]['value'] = 0;

   $return_arr[0]['cc_num'] = 0; 

}else{

    $return_arr = array();

    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        $row_array['id'] 			= $row['id'];
        $valor_v					=($row['almacenid']=='999' || $row['almacenid']==LOCATION_ID)?'(L)':'';

        $row_array['label'] 		= $row['account_number'].' - '. mb_convert_encoding ( $row['first_name'], "UTF-8", "ISO-8859-1") .' '. mb_convert_encoding ( $row['last_name'].' - '.$valor_v, "UTF-8","ISO-8859-1") ;

        $row_array['value'] 		= mb_convert_encoding ( $row['first_name'], "UTF-8", "ISO-8859-1") .' '. mb_convert_encoding ( $row['last_name'], "UTF-8", "ISO-8859-1") ;

        $row_array['cc_num'] 		= $row['account_number'];
        $row_array['tipo_sub'] 		= $row['tipo_subsidio'];
        
		#########################################################################################################################################################
		###AVERIGUAMOS LA ULTIMA FECHA DE DISPENSACION
		
				$a_info_dispencacion	=ultima_fecha_dispecacion($row['id']);
		
		$row_array['ult_fech_disp']	 = $a_info_dispencacion[0]['ultima_fecha_dispensacion'];
		$row_array['diferencia_dias'] = $a_info_dispencacion[0]['diferencia_dias'];


        array_push($return_arr,$row_array);

    }    

}

    echo json_encode($return_arr);



	function ultima_fecha_dispecacion($paciente_id)
	{
		
							$a_sql['datos']			='	MAX(pos.date) as ultima_fecha_dispensacion,
														DATEDIFF(NOW(), MAX(pos.date) ) as  diferencia_dias';
							$a_sql['tabla']			='	
														pos_sales			as 	pos';
							$a_sql['donde']			=' pos.customer_id="'.$paciente_id.'"  ';
							return 					AdminConsulta::ejec_consulta($a_sql,'');
	
		
	
	}
?>