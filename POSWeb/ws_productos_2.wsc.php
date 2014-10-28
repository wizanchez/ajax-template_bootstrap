<?PHP
set_time_limit(5000);
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
//((((((((((((((((((((((((((((((((((( DEFINE'S QUE PERMITEN CONTROL SOBRE ALGUNAS VALIDACIONES DEL CODIGO ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
										define(FOLDER_RAIZ,'');

				#----------------------------------------------------------------------------------------
				#	ARCHIVO DE LA DIRECCION IP DE LOS WSDL
							include('ws_ip_ws.inc.php');
				#----------------------------------------------------------------------------------------	
			
		
		
		############################################################################################################
		##	WEBSERVICE EN TABLAS DE PRUEBAS
		//define(URL_WEB_SERVICE_SERVIDOR,'http://suiteerp.com/emssanar/v3.01/oserp/ws_asistencial.wsdl.php');
		
		
		############################################################################################################
		##	WEBSERVICE EN TABLAS ORIGUNALES
		define(URL_WEB_SERVICE_SERVIDOR,DF_URL_WSDL_RAIZ.'ws_asistencial_v20.wsdl.php');
		#define(URL_WEB_SERVICE_SERVIDOR,'http://191.168.0.57/emssanar/v3.01/oserp/ws_asistencial_v20.wsdl.php');



define(FECHA_INICIO_SINCRONIZACION,date('2013-01-01'));
//define(FECHA_FIN_SINCRONIZACION,date('2011-02-05'));
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
									

						
/*
 *	$Id: client1.php,v 1.3 2007/11/06 14:48:24 snichol Exp $
 *
 *	Client sample that should get a fault response.
 *
 *	Service: SOAP endpoint
 *	Payload: rpc/encoded
 *	Transport: http
 *	Authentication: none
 */

require_once(FOLDER_RAIZ.'classes/nusoap/lib/nusoap.php');

$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';

$client = new nusoap_client(URL_WEB_SERVICE_SERVIDOR, false,
						$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	exit();
}
$client->setUseCurl($useCURL); echo 'ssss';
// This is an archaic parameter list
$params = array(
    'manufacturer' => "O'Reilly",
    'page'         => '1',
    'mode'         => 'books',
    'tag'          => 'trachtenberg-20',
    'type'         => 'lite',
    'devtag'       => 'Your tag here',
    'sort'         => '+title'
);
		$arreglo 		= array('tipo' => $tipo,'value' => $value);
	//	echo'bug <pre>'; print_r($arreglo);
		$result 	= $client->call('informacionProductos',array('parametro'=>$arreglo));
echo 'nnnn';


//$result = $client->call('ManufacturerSearchRequest', $params, 'http://soap.amazon.com', 'http://soap.amazon.com');
if ($client->fault) {
	echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; print_r($result); echo '</pre>';
} else {
	$err = $client->getError();
	if ($err) {
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';

?>