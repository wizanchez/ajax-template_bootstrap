<?PHP
set_time_limit(5000);
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
//((((((((((((((((((((((((((((((((((( DEFINE'S QUE PERMITEN CONTROL SOBRE ALGUNAS VALIDACIONES DEL CODIGO ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
define(TABLA_PACIENTES,'pos_pacientes');
define(TABLA_CONVENIOS,'pos_convenios');
define(TABLA_PRODUCTOS,'pos_items');
define(TABLA_PRODUCTOS_DETA,'pos_itempos');
define(TABLA_PRODUCTOS_TAX,'pos_itemtax');
define(TABLA_ITEMCONVENIO,'pos_itemconvenio');

			
			#############################################################################################################
			##	WEB SERVICE EN TABLAS DE PRUEBAS
			//define(URL_WEB_SERVICE_SERVIDOR,'http://suiteerp.com/emssanar/v3.01/oserp/ws_asistencial.wsdl.php');
			#############################################################################################################

			#############################################################################################################
			##	WEB SERVICE EN TABLAS ORIGINALES
			define(URL_WEB_SERVICE_SERVIDOR,'http://191.168.0.56/emssanar/v3.01/oserp/ws_asistencial_v20.wsdl.php');
			#define(URL_WEB_SERVICE_SERVIDOR,'http://191.168.0.57/emssanar/v3.01/oserp/ws_asistencial_v20.wsdl.php');
			#############################################################################################################
define(FECHA_INICIO_SINCRONIZACION,date('2013-01-01'));
//define(FECHA_FIN_SINCRONIZACION,date('2011-02-05'));
//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
									
class ws_asistencial{
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((( FUNCIONES PRINCIPALES ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))

	//->Omar:(clave) Permite tener un mayor contro sobre el acceso al web service
	private function clave(){
		return	array('loggin' =>  'luis', 'pass' => 123);
	}//-> FIN clave
	
	//->Omar:(incluirClases)
	private function incluirClases(){
		$url	=FOLDER_RAIZ.'classes/nusoap/nusoap.php';
      	ws_asistencial::incluir_archivo_ws($url);
	}//-> FIN incluirClases

	//->Omar:(verificarError) Verifico si llego bien la informacion de lo contrario imprimo un error wsdl
	private function verificarError($mess=''){
		global $cliente;
		$err = $cliente->getError();
			if($err){
				?><div align="center"><h2>Error  al wsdl,{mess: <?php echo $mess;?> }</h2>
				<pre><?php echo htmlspecialchars($cliente->response, ENT_QUOTES);?></pre></div><?php
				 //exit;
			}
	}//-> FIN verificarError

	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	//((((((((((((((((((((((((((((((((((((((((((((((((((((((((((( TRAIGO LAS TABLAS DE PACIENTES ))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))

	//->Omar:(consultarPaciente)
	private function consultarPaciente($paciente_cod_jvm){
		$a_vec['datos']	='id,lastchangedate as ultima_actualizacion';
		$a_vec['tabla']	=TABLA_PACIENTES;
		$a_vec['donde']	=' parent_id="'.$paciente_cod_jvm.'"';
		return AdminConsulta::ejec_consulta($a_vec,$ver_consulta='');//ver_consulta
	}//-> FIN consultarPaciente

	//->Omar:(conectarWebService)
	private function conectarWebService($url='', $tipo='',$mess=''){
		global $cliente;
		$tipo		=($tipo=='wsdl')?true:false;
	   	$ws_url  	=$url;
       	$cliente 	= new nusoap_client($ws_url,$tipo);
	   	$err 		= $cliente->getError();
	  	ws_asistencial::verificarError($mess);
	}//-> FIN conectarWebService

	//->Omar:(consultarPacientes)
	public function consultarPacientes($ws_url,$value='',$tipo=''){
		global  $cliente;
		$a_paciente	=array();
		ws_asistencial::incluirClases();
		$mess	='Sincronizacion Pacientess';
		ws_asistencial::conectarWebService($ws_url,$mess);
		$arreglo 		= array('tipo' => $tipo,'value' => $value,'acceso'=>ws_asistencial::clave());
	//	echo'bug <pre>'; print_r($arreglo);
		$a_paciente 	= $cliente->call('informacionPaciente',array('parametro'=>$arreglo));
	//	echo'<pre>'; print_r($a_paciente);//die;
		ws_asistencial::verificarError($mess);
		return $a_paciente;
	}//-> FIN consultarPacientes

	//->Omar:(sincronizarPacientes)
	public function sincronizarPacientes(){
		
		//$status	=ws_asistencial::consultarSincro();
		
		$a_paciente		=array();
		$a_pac_consul	=array();
		$max_id	=ws_asistencial::consultarMaxId('pos_pacientes','parent_id');
		$value			=$max_id[0][0];
		$tipo			='max_id';
//		$tipo			='max_id_up';
		
//		$value		= FECHA_INICIO_SINCRONIZACION.' 00:00:00|'.date('Y-m-d H:i:s');
//		$value		= FECHA_INICIO_SINCRONIZACION.' 00:00:00|'.FECHA_FIN_SINCRONIZACION.' 00:00:00';
		
		$ws_url		=URL_WEB_SERVICE_SERVIDOR;
		$a_paciente	=ws_asistencial::consultarPacientes($ws_url,$value,$tipo);
	//	echo'<pre>'; print_r($a_paciente);
		for($i=0;$i<count($a_paciente);++$i){
			$post['first_name']				=$a_paciente[$i]['primer_nombre'];
			$post['first_name2']			=$a_paciente[$i]['segundo_nombre'];
			$post['last_name']				=$a_paciente[$i]['primer_apellido'];
			$post['last_name2']				=$a_paciente[$i]['segundo_apellido'];
			$post['account_number']			=$a_paciente[$i]['identificacion'];
			$post['street_address']			=$a_paciente[$i]['direccion'];
			$post['phone_number']			=$a_paciente[$i]['telefono'];
			$post['lastchangedate']			=$a_paciente[$i]['ultima_actualizacion'];
			$post['convenioid']				=$a_paciente[$i]['convenioid'];
			//$post['image_url']			=$a_paciente[$i]['image_url'];
			//$post['genero']				=$a_paciente[$i]['genero'];
			//$post['pelocolor']			=$a_paciente[$i]['pelocolor'];
			//$post['ojoscolor']			=$a_paciente[$i]['ojoscolor'];
			//$post['alto']					=$a_paciente[$i]['alto'];
			//$post['peso']					=$a_paciente[$i]['peso'];
			//$post['gafas']				=$a_paciente[$i]['gafas'];
			//$post['audifono']				=$a_paciente[$i]['audifono'];
			//$post['descargado']			=$a_paciente[$i]['descargado'];
			//$post['habitacion']			=$a_paciente[$i]['habitacion'];
			//$post['pesotype']				=$a_paciente[$i]['peso_tipo'];
			//$post['cama']					=$a_paciente[$i]['cama'];
			//$post['nacimiento']			=$a_paciente[$i]['nacimiento'];
			//$post['ciudad']				=$a_paciente[$i]['ciudad_id'];
			//$post['localizacion_telefono']=$a_paciente[$i]['localizacion_telefono'];
			//$post['gruposan']				=$a_paciente[$i]['gruposan'];
			//$post['estadocivil']			=$a_paciente[$i]['estadocivil'];
			//$post['entidadid']			=$a_paciente[$i]['entidadid'];
			//$post['convenioid']			=$a_paciente[$i]['convenioid'];
			//$post['planid']				=$a_paciente[$i]['planid'];
			//$post['subplanid']			=$a_paciente[$i]['subplanid'];
			//return false;
			
			//->Omar: Verifico si el paciente ya se encuentra en la base de datos del pos, esto se verifica con el codigo JVM
			$a_pac_consul	=ws_asistencial::consultarPaciente($a_paciente[$i]['paciente_cod_jvm']);

			//->Omar: Si no existe se realiza la insercion
			if(count($a_pac_consul)==0){
				$post['parent_id']		=$a_paciente[$i]['paciente_cod_jvm'];
				$post['parent_tipo']	='insertado wsdl //'.$ws_url;
				AdminConsulta::insertar2($post, $tabla=TABLA_PACIENTES,$ver_query='');//ver_query
			}
			else{
				//->Omar: ahora comparo si las ultimas fecha de actualizacion son diferentes, actualizo
				if($a_paciente[$i]['ultima_actualizacion']!=$a_pac_consul[0]['ultima_actualizacion']){
					$donde=' parent_id="'.$a_paciente[$i]['paciente_cod_jvm'].'"';
					AdminConsulta::actualizar2($post, $tabla=TABLA_PACIENTES, $donde,$ver_query='');//ver_consulta
				}
			}			
		}//->FIN for
		//echo '**************'.$a_paciente[0]['total_registros'];
		return $a_paciente[0]['total_registros'];
		
	}//-> FIN sincronizarPacientes
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	

	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((( TRAIGO LAS TABLAS DE CONVENIOS )))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	
	//->Omar:(consultarConvenio)
	private function consultarConvenio($convenio_cod_jvm=''){
		$a_vec['datos']	='id,lastchangedate as ultima_actualizacion';
		$a_vec['tabla']	=TABLA_CONVENIOS;
		$a_vec['donde']	=' convenum="'.$convenio_cod_jvm.'"';
		return AdminConsulta::ejec_consulta($a_vec,$ver_consulta='');
	}//-> FIN consultarConvenio

	//->Omar:(consultarConvenio)
	public function consultarConvenios($ws_url,$value='',$tipo=''){
		global  $cliente, $cfg_locationid;;
		$a_paciente	=array();
		ws_asistencial::incluirClases();
		$mess='Sincronizacion Convenios';
		ws_asistencial::conectarWebService($ws_url,$mess);
		$arreglo 	= array('tipo' => $tipo,'value' => $value.' :: '.$cfg_locationid,'acceso'=>ws_asistencial::clave());		
		//echo'bug <pre>'; print_r($arreglo);
		$a_paciente = $cliente->call('informacionConvenios',array('parametro'=>$arreglo));
/*		echo $a_paciente['__numeric_1']['id'].'**';
		echo $a_paciente['__numeric_2']['id'].'**';
		echo $a_paciente[1]['id'].'**';
		echo $a_paciente[2]['id'].'**';
		echo'+++++<pre>'; print_r($a_paciente);die;*/
		ws_asistencial::verificarError($mess);
		return $a_paciente;
	}//-> FIN consultarConvenios
	
    //->Omar:(sincronizarConvenios)
/*	public function sincronizarConvenios(){
		$a_convenios		=array();
		$max_id	=ws_asistencial::consultarMaxId('pos_itemconvenio','parent_id');
		$value			=$max_id[0][0];
		$tipo			='max_id';
		
		//$value			= FECHA_INICIO_SINCRONIZACION.' 00:00:00|'.date('Y-m-d H:i:s');
		$ws_url			=URL_WEB_SERVICE_SERVIDOR;
		$a_convenios	=ws_asistencial::consultarConvenios($ws_url,$value,$tipo);
		//echo'<pre>';print_r($a_convenios);
		for($i=0;$i<count($a_convenios);++$i){
			$post['convenom']				=$a_convenios[$i]['nombre_convenio'];
			$post['lastchangedate']			=$a_convenios[$i]['ultima_actualizacion'];
			//$post['plan']					=$a_convenios[$i]['plan'];
			//$post['subplan']				=$a_convenios[$i]['subplan'];
			//$post['Programa']				=$a_convenios[$i]['Programa'];
			//$post['idListaProd']			=$a_convenios[$i]['idListaProd'];
			//$post['locationid']			=$a_convenios[$i]['locationid'];
			//$post['facturaInd']			=$a_convenios[$i]['facturaInd'];
			//$post['formuMedi']			=$a_convenios[$i]['formuMedi'];
			//$post['histoClin']			=$a_convenios[$i]['histoClin'];
			//$post['resMedi']				=$a_convenios[$i]['resMedi'];
			//$post['consolidado']			=$a_convenios[$i]['consolidado'];
			//$post['periodoFac']			=$a_convenios[$i]['periodoFac'];
			//$post['formaFac']				=$a_convenios[$i]['formaFac'];
			//$post['status']				=$a_convenios[$i]['status'];
			//$post['fecha_in']				=$a_convenios[$i]['fecha_in'];
			//$post['aplica_valor']			=$a_convenios[$i]['aplica_valor'];
			//$post['num_benef']			=$a_convenios[$i]['num_benef'];
			//$post['valor']				=$a_convenios[$i]['valor'];
			//$post['entrydate']			=$a_convenios[$i]['entrydate'];
			//$post['entryuserid']			=$a_convenios[$i]['entryuserid'];
			//$post['lastchangeuserid']		=$a_convenios[$i]['lastchangeuserid'];
		
			//->Omar: Verifico si el paciente ya se encuentra en la base de datos del pos, esto se verifica con el codigo JVM
			$a_pac_consul	=ws_asistencial::consultarConvenio($a_convenios[$i]['convenio_cod_jvm']);
							
			//->Omar: Si no existe se realiza la insercion
			if(count($a_pac_consul)==0){
				$post['convenum']				=$a_convenios[$i]['convenio_cod_jvm'];
				$post['parent_id']				=$a_convenios[$i]['convenio_cod_jvm'];
				$post['parent_tipo']			='insertado wsdl //'.$ws_url;
				AdminConsulta::insertar2($post, $tabla=TABLA_CONVENIOS,$ver_query='');
			}
			else{
				//->Omar: ahora comparo si las ultimas fecha de actualizacion son diferentes, actualizo
				if($a_convenios[$i]['ultima_actualizacion']!=$a_pac_consul[0]['ultima_actualizacion']){
					$donde=' convenum="'.$a_convenios[$i]['convenio_cod_jvm'].'"';
					AdminConsulta::actualizar2($post, $tabla=TABLA_CONVENIOS, $donde,$ver_query='');
				}
			}	
			
			for($k=0;$k<count($a_convenios[$i]['itemconvenios']);++$k){
				
					$a_vec1['datos']	='id,buy_price';
					$a_vec1['tabla']	=TABLA_PRODUCTOS;
					$a_vec1['donde']	=' parent_id="'.$a_convenios[$i]['itemconvenios'][$k]['itemid'].'"';
					$id_item		 =AdminConsulta::ejec_consulta($a_vec1,$ver_consulta='');
					//echo'<br>';print_r($id_item);
					if($id_item){
						$post3['items_id']		=$id_item[0][0];
						$post3['convenio_id']	=$a_convenios[$i]['itemconvenios'][$k]['conveniosid'];
						$post3['price_evento']		=$a_convenios[$i]['itemconvenios'][$k]['itemprice'];
						$post3['estado']		='1';
						$post3['price_vta']	=$id_item[0][1];
						AdminConsulta::insertar2($post3, $tabla=TABLA_ITEMCONVENIO,$ver_query='');
					}
				}
			
		}
		return $a_convenios[0]['total_registros'];
		
		
	}//-> FIN sincronizarConvenios
*/	public function sincronizarConvenios(){
		
		$a_convenios		=array();
		$max_id	=ws_asistencial::consultarMaxId('pos_itemconvenio','parent_id');
		$value			=$max_id[0][0];
		$tipo			='max_id';
		if(!$value){$value='0';}
		
		$ws_url			=URL_WEB_SERVICE_SERVIDOR;
		$a_convenios	=ws_asistencial::consultarConvenios($ws_url,$value,$tipo);
		//echo'<pre>';print_r($a_convenios);
		for($i=0;$i<count($a_convenios);++$i){
			$post['id']						=$a_convenios['__numeric_'.$i]['id'];
			$post['convenio_cod_jvm']		=$a_convenios['__numeric_'.$i]['id'];
			$post['itemid']					=$a_convenios['__numeric_'.$i]['itemid'];
			$post['itemlocationid']			=$a_convenios['__numeric_'.$i]['itemlocationid'];
			$post['precio_capi']			=$a_convenios['__numeric_'.$i]['price'];
			$post['precio_evento']			=$a_convenios['__numeric_'.$i]['precio_venta'];
			$post['convenio_id']			=$a_convenios['__numeric_'.$i]['pricesublevelid'];
		
			//->Omar: Verifico si el paciente ya se encuentra en la base de datos del pos, esto se verifica con el codigo JVM
				
			$a_vec1['datos']	='id';
			$a_vec1['tabla']	=TABLA_PRODUCTOS;
			$a_vec1['donde']	=' parent_id="'.$post['itemid'].'"';
			$id_item		 	=AdminConsulta::ejec_consulta($a_vec1,$ver_consulta='');
			//echo'<br>';print_r($id_item);
			if($id_item){
				$post3['items_id']		=$id_item[0][0];
				$post3['convenio_id']	=$post['convenio_id'];
				$post3['price_evento']	=$post['precio_evento'];
				$post3['estado']		='1';
				$post3['price_vta']		=$post['precio_capi'];
				$post3['parent_id']		=$post['convenio_cod_jvm'];
				AdminConsulta::insertar2($post3, $tabla=TABLA_ITEMCONVENIO,$ver_query='');
			}
			
		}
		return $a_convenios['total']['total_registros'];
		
		
	}//-> FIN sincronizarConvenios
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((( TRAIGO LAS TABLAS DE PRODUCTOS )))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))

	//->Omar:(consultarProdutos) permite consultar la tabla pos_items trayendo el campo de fecha de ultima actualizacion de ese paren_id.	
	private function consultarProdutos($producto_cod_jvm=''){
		$a_vec['datos']		='id,lastchangedate as ultima_actualizacion';
		$a_vec['tabla']		=TABLA_PRODUCTOS;
		$a_vec['donde']		='parent_id="'.$producto_cod_jvm.'"';
		return AdminConsulta::ejec_consulta($a_vec,$ver_consulta='');
	}//-> FIN consultarConvenios

	//->Omar:(consultarProdutos_deta) permite consultar la tabla pos_itempos trayendo el campo de fecha de ultima actualizacion de ese paren_id.
  	private function consultarProdutos_deta($producto_cod_jvm=''){
		$a_vec['datos']		='id,lastchangedate as ultima_actualizacion';
		$a_vec['tabla']		=TABLA_PRODUCTOS_DETA;
		$a_vec['donde']		='parent_id="'.$producto_cod_jvm.'"';
		return AdminConsulta::ejec_consulta($a_vec,$ver_consulta='');
	}//-> FIN consultarProdutos_deta
	
	//->Omar:(consultarMaxId) permite consultar cual es el ultimo id que se inserto
  	private function consultarMaxId($tabla,$campo1){
		$a_vec['datos']		='MAX('.$campo1.')';
		$a_vec['tabla']		=$tabla;
		$a_vec['donde']		='id>0';
		return AdminConsulta::ejec_consulta($a_vec,$ver_consulta='');
	}//-> FIN consultarMaxId	

	//->Omar:(consultarProductos) 
	public function consultarProductos($ws_url,$value='',$tipo=''){
		global  $cliente,$cfg_locationid;
		$a_producto	=array();
		ws_asistencial::incluirClases();
		$mess	='Sincronizacion Productos';
		ws_asistencial::conectarWebService($ws_url);
		$arreglo= array('tipo' => $tipo,'value' => $value,'bodega'=>$cfg_locationid,'proveedor'=>'todos','acceso'=>ws_asistencial::clave());
		//echo'<pre>'; print_r($arreglo);
		$a_producto 	= $cliente->call('informacionProductos',array('parametro'=>$arreglo));
		ws_asistencial::verificarError($mess);
		//echo'<pre>***'; print_r($a_producto);return false;
		return $a_producto;
	}//-> FIN consultarProductos
	
	//->Omar:(sincronizarProductos) 
	public function sincronizarProductos(){
		global $cliente;
		$a_productos		=array();
		$max_id	=ws_asistencial::consultarMaxId('pos_items','parent_id');
		//echo'max <pre>';print_r($max_id);
		$value			=$max_id[0][0];
		$tipo			='max_id';
//		$ws_url			='http://suiteerp.com/emssanar/v3.01/oserp/ws_asistencial.wsdl.php';
		$ws_url			='http://191.168.0.56/emssanar/v3.01/oserp/ws_asistencial.wsdl.php';
		$a_productos	=ws_asistencial::consultarProductos($ws_url,$value,$tipo);
	//	echo'<pre>'; print_r($a_producto);return false;
		
		for($i=0;$i<count($a_productos);++$i){
			$post['item_name']				=$a_productos[$i]['descripcion'];
			$post['item_number']			=$a_productos[$i]['plu'];
			$post['brand_id']				=$a_productos[$i]['marca_id'];
			$post['category_id']			=$a_productos[$i]['category_id'];
			$post['shortdescription']		=$a_productos[$i]['descripcion'];
			$post['pack']					=$a_productos[$i]['pack'];
			$post['unit_price']				=$a_productos[$i]['bodega'][0]['precio'][0]['precio'];
			$post['total_cost']				=$a_productos[$i]['bodega'][0]['precio'][0]['precio'];//->este precio calculado por el pos pero en sincro se trae el de Vent
			$post['lastchangedate']			=$a_productos[$i]['ultima_actualizacion'];
			$post['buy_price']				=$a_productos[$i]['bodega'][0]['vendor'][0]['costo_1'];
			$post['quantity']				=$a_productos[$i]['bodega'][0]['inventario'];
			$post['active']					='1';// producto activo = 1, inactivo = 0
			//echo '<br> ****'.$post['buy_price'];
			
			$post2['purchasegroupid']		=$a_productos[$i]['purchasegroupid'];
			$post2['presentationid']		=$a_productos[$i]['presentationid'];
			$post2['itemid']				=$a_productos[$i]['item_id'];
			$post2['shortdescription']		=$a_productos[$i]['shortdescription'];
			$post2['pack']					=$a_productos[$i]['pack'];
			$post2['distriunit']			=$a_productos[$i]['distriunit'];
			$post2['size_x']				=$a_productos[$i]['size_x'];
			$post2['size_y']				=$a_productos[$i]['size_y'];
			$post2['size_z']				=$a_productos[$i]['size_z'];
			$post2['packagecolor']			=$a_productos[$i]['packagecolor'];
			$post2['packagematerial']		=$a_productos[$i]['packagematerial'];
			$post2['typefacing']			=$a_productos[$i]['typefacing'];
			$post2['scale']					=$a_productos[$i]['scale'];
			$post2['itemcode_link']			=$a_productos[$i]['itemcode_link'];
			$post2['mixmatchcode']			=$a_productos[$i]['mixmatchcode'];
			$post2['longdescription']		=$a_productos[$i]['longdescription'];
			$post2['tareweigth']			=$a_productos[$i]['tareweigth'];
			$post2['salescheduleid']		=$a_productos[$i]['salescheduleid'];
			$post2['qtyinsale']				=$a_productos[$i]['qtyinsale'];
			$post2['explosionpriceunit']	=$a_productos[$i]['explosionpriceunit'];
			$post2['initialcodeid']			=$a_productos[$i]['initialcodeid'];
			$post2['contentid']				=$a_productos[$i]['contentid'];
			$post2['contentunitid']			=$a_productos[$i]['contentunitid'];
			$post2['contentunitid']			=$a_productos[$i]['contentunitid'];
			$post2['item_impoconsumo']		=$a_productos[$i]['item_impoconsumo'];
			$post2['itemfedepanela']		=$a_productos[$i]['itemfedepanela'];
			$post2['target']				=$a_productos[$i]['target'];
			$post2['conservationconditions']=$a_productos[$i]['conservationconditions'];
			$post2['restrictedsale']		=$a_productos[$i]['restrictedsale'];
			$post2['postsaleguarantee']		=$a_productos[$i]['postsaleguarantee'];
			$post2['fdaduedate']			=$a_productos[$i]['fdaduedate'];
			$post2['fragileproduct']		=$a_productos[$i]['fragileproduct'];
			$post2['btocost']				=$a_productos[$i]['btocost'];
			$post2['netcost']				=$a_productos[$i]['netcost'];
			$post2['suggestedsaleprice']	=$a_productos[$i]['suggestedsaleprice'];
			$post2['publinversion']			=$a_productos[$i]['publinversion'];
			$post2['tmkinversion']			=$a_productos[$i]['tmkinversion'];
			$post2['product_tax']			=$a_productos[$i]['product_tax'];
			$post2['minshippqty']			=$a_productos[$i]['minshippqty'];
			$post2['requirevalid']			=$a_productos[$i]['requirevalid'];
			$post2['barcodevta']			=$a_productos[$i]['barcodevta'];
			$post2['tmkinversion']			=$a_productos[$i]['tmkinversion'];
			$post2['itembarcode']			=$a_productos[$i]['itembarcode'];
			$post2['gondola']				=$a_productos[$i]['gondola'];
			$post2['porcentsaleprice']		=$a_productos[$i]['porcentsaleprice'];
			$post2['item_tax']				=$a_productos[$i]['item_tax'];
			$post2['lastchangedate']		=$a_productos[$i]['ultima_actualizacion_itempos'];
			$post2['lastchangeuserid']		=$a_productos[$i]['lastchangeuserid_itempo'];
			
			$post3['itemid']				=$a_productos[$i]['item_id'];
			$post3['taxid']					=$a_productos[$i]['item_iva'];
			
			//->Omar: Verifico si el paciente ya se encuentra en la base de datos del pos, esto se verifica con el codigo JVM
			$a_pac_consul		=ws_asistencial::consultarProdutos($a_productos[$i]['item_cod_jvm']);
			$a_pac_consul_deta	=ws_asistencial::consultarProdutos_deta($a_productos[$i]['item_cod_jvm']);
			
			//echo'<pre>';print_r($a_pac_consul_deta);echo count($a_pac_consul_deta).'<<<<< a_pac_consul_deta-';
							
			//->Omar: Si no existe se realiza la insercion
			if(count($a_pac_consul)==0){
				//echo'<br>insertado';
				//$post['precio_venta']		=$a_productos[$i]['bodega'][0]['precio'][0]['precio'];
				$post['parent_id']			=$a_productos[$i]['item_cod_jvm'];
				$post['parent_tipo']		='insertado wsdl //'.$ws_url;
				$tiemid=AdminConsulta::insertar2($post, $tabla=TABLA_PRODUCTOS,$ver_query='');
							
				$post2['parent_id']			=$a_productos[$i]['item_cod_jvm'];
				$post2['parent_tipo']		='insertado wsdl //'.$ws_url;
				AdminConsulta::insertar2($post2, $tabla=TABLA_PRODUCTOS_DETA,$ver_query='');
				
				AdminConsulta::insertar2($post3, $tabla=TABLA_PRODUCTOS_TAX,$ver_query='');
			}else{
				//->Omar: ahora comparo si las ultimas fecha de actualizacion son diferentes, actualizo
				if($a_productos[$i]['ultima_actualizacion']!=$a_pac_consul[0]['ultima_actualizacion']){
					//echo'<br>actualizado';
					$donde=' parent_id="'.$a_productos[$i]['item_cod_jvm'].'"';
					AdminConsulta::actualizar2($post, $tabla=TABLA_PRODUCTOS, $donde,$ver_query='');
				}//->if fin
				if(count($a_pac_consul_deta)!=0){
					if($a_productos[$i]['ultima_actualizacion_itempos']!=$a_pac_consul_deta[0]['ultima_actualizacion']){
						$donde=' parent_id="'.$a_productos[$i]['item_cod_jvm'].'"';
						AdminConsulta::actualizar2($post2, $tabla=TABLA_PRODUCTOS_DETA, $donde,$ver_query='');
						$donde=' itemid="'.$a_productos[$i]['item_cod_jvm'].'"';
						AdminConsulta::actualizar2($post3, $tabla=TABLA_PRODUCTOS_TAX, $donde,$ver_query='');
					}else{echo'';}
				}
			}//-> else fin	
		}//->for($i=0;$i<count($a_productos);++$i) fin
		
		return $a_productos[0]['total_registros'];
			
			
			
	}//-> FIN sincronizarProductos
	
	//->Omar:(incluir_archivo_ws) 
	public function incluir_archivo_ws($url) {
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
	//(((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((()))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))
	

}
?>
