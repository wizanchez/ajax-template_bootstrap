<?PHP
set_time_limit(5000);
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
//((((((((((((((((((((((((((((((((((( DEFINE'S QUE PERMITEN CONTROL SOBRE ALGUNAS VALIDACIONES DEL CODIGO ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
										define(FOLDER_RAIZ,'');
										define(TABLA_POS_ITEMS,'pos_items');
										define(TABLA_POS_ITEMCONVENIO,'pos_itemconvenio');
										define(TABLA_POS_CONVENIOS,'pos_convenios');
										define(TABLA_ITEMTAX,'pos_itemtax');
										define(TABLA_TAX_RATES,'pos_tax_rates');
										define(TABLA_POS_PACIENTES,'pos_pacientes');
//define(URL_WEB_SERVICE_SERVIDOR,'http://suiteerp.com/emssanar/v3.01/oserp/ws_asistencial.wsdl.php');

define(URL_WEB_ws,'http://192.168.1.135/erp_panaderia/');
#define(URL_WEB_ws,'http://191.168.0.57/emssanar/');




			#############################################################################################################
			##	WEB SERVICE EN TABLAS PRUEBAS
				//define(URL_WEB_SERVICE_SERVIDOR,URL_WEB_ws.'v3.01/oserp/ws_asistencial_2.wsdl.php');
			#############################################################################################################
			
			#############################################################################################################
			##	WEB SERVICE EN TABLAS ORIGINALES
				define(URL_WEB_SERVICE_SERVIDOR,URL_WEB_ws.'v1.02/oserp/ws_asistencial_v20.wsdl.php');
			#############################################################################################################


define(FECHA_INICIO_SINCRONIZACION,date('2014-10-01'));
//define(FECHA_FIN_SINCRONIZACION,date('2011-02-05'));
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
									
class ws_productos{
	
	private function clave()
	{
		return	array('loggin' =>  'luis', 'pass' => 123);
	}//-> FIN clave
	public function incluir_archivo_ws($url)
	{
		/* Description: metodo para saber si existe el archivo
		* @param: La URL del archivo a incluir
		* @return n/a
		* @Creado 22 Sep 2010
		* @autor luis Sanchez
		*/
		$url_class = $url;
		if (!file_exists($url_class)) {
			echo 'Error include { ' . $url_class . ' }<br>';
		} else {
			require_once ($url_class);
		}
		/*incluyo el nombre de la clase controlador*/
	}//-> FIN incluir_archivo_ws
	//->Omar:(incluirClases)
	private function incluirClases()
	{
		//require_once(FOLDER_RAIZ.'classes/nusoap/lib/nusoap.php');
		$url	=FOLDER_RAIZ.'classes/nusoap/lib/nusoap.php';
		//$url	=FOLDER_RAIZ.'classes/nusoap/nusoap.php';
      	ws_productos::incluir_archivo_ws($url);
	}//-> FIN incluirClases

	//->Omar:(verificarError) Verifico si llego bien la informacion de lo contrario imprimo un error wsdl
	private function verificarError($mess='')
	{
		global $cliente;
		$err = $cliente->getError();
			if($err){
				?><div align="center">	<h2>SI USTED ESTA VIENDO ESTO FAVOR COMUNICARSE CON EL EUQIPO JVM , GRACIAS {# ERROR: ws_productos_wsc}</h2>
                						<h2>Error  al wsdl,{mess: <?php echo $mess;?> }</h2>
                					 	 <h2>Error  al wsdl,{mess: <?php echo $err;?> }</h2>
				<pre><?php echo htmlspecialchars($cliente->response, ENT_QUOTES);?></pre></div><?php
				 //exit;
			}
	}//-> FIN verificarError
	
	private function conectarWebService($url='', $tipo='',$mess='')
	{
		global $cliente;
		$tipo			=($tipo=='wsdl')?true:false;
	   	$ws_url  		=$url;
		$proxyhost 		= isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
		$proxyport 		= isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
		$proxyusername 	= isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
		$proxypassword 	= isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
		$useCURL 		= isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';

		$cliente 		= new nusoap_client($ws_url,$tipo,$proxyhost, $proxyport, $proxyusername, $proxypassword);
		//$err 		= $cliente->getError();
	  	ws_productos::verificarError($mess);
		
	}//-> FIN conectarWebService
	
	
	public function consultarProductos($ws_url,$value='',$tipo='',$bodega_id='',$proveedor_id='',$incluir_lib='',$lista_id='')
	{
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		
		#####################################################################################################
		## SE HACE ESTA CONDICIONAL PORQUE CUANDO SE LLAMA CON OTRO WEB SERVICE ANTES INCLUIDO LA  LIBRERIA
		## GENERA ERROR
			if($incluir_lib!='FALSE'){ws_productos::incluirClases();}
		#####################################################################################################
		$mess	='Sincronizacion Productos';
		ws_productos::conectarWebService($ws_url);
		//$bodega_id=4;
		$arreglo= array(
							'tipo' 		=> $tipo
							,'value' 	=> $value
							,'bodega'	=> $bodega_id
							,'proveedor'=> $proveedor_id
							,'lista_id'	=> $lista_id
							,'acceso'=>ws_productos::clave()
						);
		//echo'<pre>'; print_r($arreglo);
		
		$a_producto 	= $cliente->call('informacionProductos',array('parametro'=>$arreglo));
		ws_productos::verificarError($mess);
		//echo'<pre>***'; 
		//echo $bodega_id;
//		print_r($a_producto);return false;
		return $a_producto;
	}//-> FIN consultarProductos
	
	
	
	public function maestro_producto($ws_url,$value='',$tipo='',$locationid)
	{
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		
		ws_productos::incluirClases();
		$mess	='Sincronizacion Productos Maestro';
		ws_productos::conectarWebService($ws_url);
		$arreglo= array('tipo' => $tipo,'value' => $value,'locationid' => $locationid,'acceso'=>ws_productos::clave());
	//echo'<pre>'; print_r($arreglo);
		
		$a_producto 	= $cliente->call('maestroProductos',array('parametro'=>$arreglo));
		ws_productos::verificarError($mess);
		//echo'<pre>***'; print_r($a_producto);return false;
		return $a_producto;
	}//-> FIN consultarProductos
	
	
	//->Omar:(sincronizarProductos) 
	public function sincronizarPreciosProductos($value='',$tipo='',$bodega_id='',$proveedor_id='',$incluir_lib='',$lista_id='')
	{
		global $cliente;
		$a_productos		=array();	
		//$max_id	=ws_asistencial::consultarMaxId('pos_items','parent_id');
		//echo'max <pre>';print_r($max_id);
		//$value			=$max_id[0][0];
		//$tipo			='max_id';
//		$ws_url			='http://suiteerp.com/emssanar/v3.01/oserp/ws_asistencial.wsdl.php';
	 	$ws_url			=URL_WEB_SERVICE_SERVIDOR;
	
		$a_productos	=ws_productos::consultarProductos(
															$ws_url
															,$value
															,$tipo
															,$bodega_id
															,$proveedor_id
															,$incluir_lib
															,$lista_id
															);
		//echo '===============================';#Omar:>
		#echo '<pre>';
		#print_r($a_productos);
			
			//echo $a_productos[0]['descripcion_concatenada'].' omar ';
			
			$cadena = eregi_replace("[\n|\r|\n\r]",'',$a_productos[0]['descripcion_concatenada']);
			//echo $cadena.' omar ';
			
			//$a_vec['shortdescription']	=rtrim(ltrim($a_productos[0]['descripcion_concatenada']));
			$a_vec['shortdescription']	=$cadena;
			$a_vec['description']		=$cadena;
			$a_vec['item_name']			=$cadena;
			$a_vec['quantity']			=$a_productos[0]['bodega'][0]['inventario'];
			$a_vec['buy_price']			=$a_productos[0]['bodega'][0]['det_price_general'][0]['precio_unitario'];
			$a_vec['unit_price']		=$a_productos[0]['bodega'][0]['det_price_general'][0]['precio_unitario'];
			$a_vec['total_cost']		=$a_productos[0]['bodega'][0]['det_price_general'][0]['precio_unitario'];
			$a_vec['tax_percent']		=$a_productos[0]['iva']['porcentaje'];
			#$a_vec['tax_percentss']		='.......';
			
			$campo						=($tipo=='plu')?'item_number':'';
			$donde						=' '.$campo.'="'.$value.'"';
			
		
			AdminConsulta::actualizar2($a_vec, $tabla=TABLA_POS_ITEMS, $donde,$ver_query='');//ver_consulta
			###################################################################################################################3
			## averiguo el item id de loa tabla pos items
				
				$info_pos_items		=ws_productos::pos_items_info($value,'plu');
				#echo'<pre>'; print_r($a_productos);return false;
			###################################################################################################################3

			###################################################################################################################3
			## vamos a mirar ahora si el impuesto esta inscrito
			//$a_vec_iva['iva_porcentaje']	=$a_productos[0]['iva']['porcentaje'];
			//$a_vec_iva['iva_descripcion']	=strtoupper(rtrim(ltrim($a_productos[0]['iva']['descripcion'])));
			//$a_vec_iva['tax_class_id']		=$a_productos[0]['iva']['tax_class_id'];
			
						//ws_productos::actualizar_impuesto($a_vec_iva,$info_pos_items[0]['pos_item_id']);
			###################################################################################################################3
				
				

			
			###################################################################################################################3
			## actualizamos los comvenios	
				for($p=0;$p<count($a_productos[0]['bodega'][0]['convenios']);++$p){
							
							$parent_convenio_id		=$a_productos[0]['bodega'][0]['convenios'][$p]['sub_level_id'];
							$parent_sub_price_id	=$a_productos[0]['bodega'][0]['convenios'][$p]['sub_price_id'];
							$parent_convenio_nombre	=$a_productos[0]['bodega'][0]['convenios'][$p]['nombre'];
							$parent_porcentaje		=$a_productos[0]['bodega'][0]['convenios'][$p]['porcentaje'];
							$price_evento           =$a_productos[0]['bodega'][0]['convenios'][$p]['price_evento'];
							##########################################################################################################
							## averiguamos el id del convenio en lastablas pos partient del id parent del erp
							$convenio_id			=ws_productos::convenio_id($parent_convenio_id,$parent_convenio_nombre);
							
							
							$a_sql['datos']			='	id as pos_itemconvenio_id,
														parent_tipo	';
							$a_sql['tabla']			=TABLA_POS_ITEMCONVENIO;
							$a_sql['donde']			=' items_id="'.$info_pos_items[0]['pos_item_id'].'" AND convenio_id="'.$convenio_id.'"';
							//echo $info_pos_items[0]['pos_item_id'];
							$a_info_item_convenio	=AdminConsulta::ejec_consulta($a_sql,'');#ver_consulta
							unset($a_vec2);
							
							$tipo	=(count($a_info_item_convenio)==0)?'insert':'update';
							
										$a_vec2['price_vta']		=$a_vec['buy_price'];
										$a_vec2['estado']			='1';
										//$a_vec2['price_evento']		=(($a_vec2['price_vta']*$parent_porcentaje)/100)+$a_vec2['price_vta'];
										$a_vec2['price_evento']		=$price_evento;//->Viene calculado desde el ERP
										
										$a_vec2['parent_tipo']		=$a_info_item_convenio[0]['parent_tipo'].date('Y-m-d H:i:s').','.$tipo.' ,via ws .'.URL_WEB_SERVICE_SERVIDOR.',ws_productos.wcs *price_evento:'.$a_vec2['price_evento'].',price_vta:'.$a_vec2['price_vta'].'*|';
																	
						if(count($a_info_item_convenio)==0){
							
										$a_vec2['parent_id']		=$parent_sub_price_id;
										$a_vec2['items_id']			=$info_pos_items[0]['pos_item_id'];
										$a_vec2['convenio_id']		=$convenio_id;
										
										AdminConsulta::insertar2($a_vec2, $tabla=TABLA_POS_ITEMCONVENIO, $ver_query='');//ver_query
							
							
							
							
							}else{
										
										//$a_vec2['parent_tipo']		=$a_vec2['parent_tipo'].$a_info_item_convenio[0]['parent_tipo'];

										$donde						=' id="'.$a_info_item_convenio[0]['pos_itemconvenio_id'].'"';
										AdminConsulta::actualizar2($a_vec2, $tabla=TABLA_POS_ITEMCONVENIO, $donde,$ver_query='');//ver_consulta
			
								}
					
						
					
					
					}







			
			
		//echo'<pre>'; print_r($a_vec);return false;	
		
		return $a_vec;
			
			
			
	}//-> FIN sincronizarProductos
	private function pos_items_info($value,$tipo)
	{
		
				switch($tipo){
					
					case 'plu':{
									$fields='item_number';
								}break;
					case 'id':{
									$fields='id';
								}break;
								
					
					}
		
							$a_sql['datos']		='	item_number	as plu,
													id			as pos_item_id';
							$a_sql['tabla']		=TABLA_POS_ITEMS;
							$a_sql['donde']		=$fields.'="'.$value.'"';
							
					return AdminConsulta::ejec_consulta($a_sql,'');
		
	}
		
	private function convenio_id($parent_convenio_id,$parent_convenio_nombre)
	{		
							$a_sql['datos']		='	id as pos_convenios_id';
							$a_sql['tabla']		=TABLA_POS_CONVENIOS;
							$a_sql['donde']		='parent_id="'.$parent_convenio_id.'"';
							
							$a_info				=AdminConsulta::ejec_consulta($a_sql,'');
		
								if(count($a_info)==0){
													
												$post_c['convenom']		=$parent_convenio_nombre;	
												$post_c['parent_tipo']	=date('Y-m-d H:i:s').', insert via ws .'.URL_WEB_SERVICE_SERVIDOR.',ws_productos.wcs|';	
												$post_c['parent_id']	=$parent_convenio_id;	
												
									return AdminConsulta::insertar2($post_c, $tabla=TABLA_POS_CONVENIOS,$VIEW);
									
									}else{
										
										return $a_info[0]['pos_convenios_id'];
										
										}
	}
	
	public function actualizar_impuesto($a_vec_iva,$pos_item_id)
	{
		
							$a_sql['datos']			='	tax_rates_id as tax_id';
							$a_sql['tabla']			=TABLA_TAX_RATES;
							$a_sql['donde']			=' tax_class_id="'.$a_vec_iva['tax_class_id'].'" AND tax_description="'.$a_vec_iva['iva_descripcion'].'" AND cancel=0';
							//echo $info_pos_items[0]['pos_item_id'];
							$taxx_rates				=AdminConsulta::ejec_consulta($a_sql,'');
		
					if(count($taxx_rates)==0){
						
										$a_vec2['tax_class_id']		=$a_vec_iva['tax_class_id'];
										$a_vec2['tax_description']	=$a_vec_iva['iva_descripcion'];
										$a_vec2['date_added']		=date('Y-m-d H:i:s');
										$a_vec2['cancel']			='0';
										$a_vec2['parent_tipo']		='via ws .'.URL_WEB_SERVICE_SERVIDOR;
										
										$tax_id						=AdminConsulta::insertar2($a_vec2, $tabla=TABLA_TAX_RATES, $ver_query='');//ver_consulta
						
						}else{
							
										$tax_id						=$taxx_rates;
							}
				
				
					############################################################################################
					## ahora miro si existe el impuesto asociado al producto
							$a_sql2['datos']			='	id as item_tax_id';
							$a_sql2['tabla']			=TABLA_ITEMTAX;
							$a_sql2['donde']			=' taxid="'.$tax_id.'" AND itemid="'.$pos_item_id.'" AND cancel=0';
							//echo $info_pos_items[0]['pos_item_id'];
							$taxx_rates_item		=AdminConsulta::ejec_consulta($a_sql2,'');
		
					if(count($taxx_rates_item)==0){
						
										$a_vec23['itemid']			=$pos_item_id;
										$a_vec23['taxid']			=$tax_id	;
										$a_vec23['entryuserid']		=date('Y-m-d H:i:s');
										$a_vec23['cancel']			='0';
										$a_vec23['parent_tipo']		='via ws .'.URL_WEB_SERVICE_SERVIDOR;
										
										$item_ix_id						=AdminConsulta::insertar2($a_vec23, $tabla=TABLA_ITEMTAX, $ver_query='');//ver_consulta
						
						}
				
				
					############################################################################################
				
		
		}	
		
		
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	####################################################P A C I E N T E S ###################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
		
		
	public function maestro_pacientes($ws_url,$value='',$tipo='',$locationid)
	{
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		
		ws_productos::incluirClases();
		$mess	='Sincronizacion Pacientes Maestro';
		ws_productos::conectarWebService($ws_url);
		$arreglo= array('tipo' => $tipo,'value' => $value,'locationid' => $locationid,'acceso'=>ws_productos::clave());
		#echo'<pre>'; print_r($arreglo);
		
		$a_producto 	= $cliente->call('maestroPacientes',array('parametro'=>$arreglo));
		ws_productos::verificarError($mess);
		//echo'<pre>***'; print_r($a_producto);return false;
		return $a_producto;
	}//-> FIN consultarProductos
	
	public function maestro_total_pacientes($ws_url,$value='',$tipo='',$locationid)
	{
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		
		ws_productos::incluirClases();
		$mess	='Sincronizacion Pacientes Total Maestro';
		ws_productos::conectarWebService($ws_url);
		$arreglo= array('tipo' => $tipo,'value' => $value,'locationid' => $locationid,'acceso'=>ws_productos::clave());
		//echo'<pre>'; print_r($arreglo);
		
		$a_producto 	= $cliente->call('totalPacientesPos',array('parametro'=>$arreglo));
		ws_productos::verificarError($mess);
		//echo'<pre>***'; print_r($a_producto);return false;
		return $a_producto;
	}//-> FIN consultarProductos
	

	public function total_pacientes()
	{
		
			
							$a_sql['datos']			='	count(*) as total_pacientes';
							$a_sql['tabla']			=TABLA_POS_PACIENTES;
							$a_sql['donde']			=' id>0';
							return					AdminConsulta::ejec_consulta($a_sql,'');
		
		
		}
		
		
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	####################################################V E N T A S  ########################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
	#########################################################################################################################################################
		
		
	public function sincronizar_enviar_venta($ws_url,$sale_id,$cedula,$formula_numero,$vec_cab,$vec_detalle,$bodega_id,$incluir_lib='')
	{
		
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		#####################################################################################################
		## SE HACE ESTA CONDICIONAL PORQUE CUANDO SE LLAMA CON OTRO WEB SERVICE ANTES INCLUIDO LA  LIBRERIA
		## GENERA ERROR
			if($incluir_lib!='FALSE'){ws_productos::incluirClases();}
		#####################################################################################################
		$mess	='Sincronizacion enviar venta';
		ws_productos::conectarWebService($ws_url);
		$arreglo= array(	
							'sale_id' 				=> $sale_id,
							'cedula' 				=> $cedula,
							'formula_numero' 		=> $formula_numero,
							'vta_cab'				=>$vec_cab,
							'vta_detalle'			=>$vec_detalle,
							'bodega_id'				=>$bodega_id,
							'acceso'				=>ws_productos::clave()
						);
		//echo'<pre>'; print_r($arreglo);
		
		$a_producto 	= $cliente->call('enviarVentaPos',array('parametro'=>$arreglo));
		ws_productos::verificarError($mess);

		//echo'<pre>***'; print_r($a_producto);return false;
		return $a_producto;
		
		}//-> FIN sincronizar ventas
	
}
	#########################################################################################################################################################
	###ENTRA A LA CONECCION
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

	switch($_REQUEST['ws_productos']){
		
		case 'actualizar_precios':{
										
									$a_resp	=ws_productos::sincronizarPreciosProductos(
																						$value			=$_REQUEST['value'],
																						$tipo			=$_REQUEST['tipo'],
																						$bodega_id		=$_REQUEST['location_id'],
																						$proveedor_id	=$_REQUEST['proveedor_id'],
																						'',
																						$lista_id		=base64_decode($_REQUEST['lista_id'])
																				);
										header('Content-type: application/json');
										$a_resp['val']		='TRUE';
										echo json_encode($a_resp);	
									}break;
		
		}


?>